<?php

namespace contact\Factory;

use contact\Resource\ContactInfo\PhysicalAddress;
use contact\Factory;
use phpws2\Template;

if (is_file(PHPWS_SOURCE_DIR . 'mod/contact/config/defines.php')) {
    require_once PHPWS_SOURCE_DIR . 'mod/contact/config/defines.php';
} else {
    require_once PHPWS_SOURCE_DIR . 'mod/contact/config/defines.dist.php';
}
require_once PHPWS_SOURCE_DIR . 'javascript/captcha/recaptcha/recaptcha_settings.php';

// Never run in production
// require_once PHPWS_SOURCE_DIR . 'mod/contact/class/FakeSwiftMailer.php';

/**
 * @license http://opensource.org/licenses/lgpl-3.0.html
 * @author Matthew McNaney <mcnaneym@appstate.edu>
 */
class ContactInfo
{

    public static function form(\Canopy\Request $request, $active_tab)
    {
        javascript('ckeditor');
        $contact_info = self::load();
        $values = json_encode(self::getValues($contact_info));
        $settings = <<<EOF
<script>const settings= $values;</script>
EOF;
        \Layout::addJSHeader($settings);
        if (CONTACT_SCRIPT_PRODUCTION) {
            $script = PHPWS_SOURCE_HTTP . 'mod/contact/javascript/build/form.js';
        } else {
            $script = PHPWS_SOURCE_HTTP . 'mod/contact/javascript/dev/form.js';
        }
        \Layout::addJSHeader("<script type='text/javascript' src='$script'></script>");
        return <<<EOF
<div id="contact-form"></div>
EOF;
    }

    public static function emailChoice()
    {
        if (CONTACT_SCRIPT_PRODUCTION) {
            $script = PHPWS_SOURCE_HTTP . 'mod/contact/javascript/build/email.js';
        } else {
            $script = PHPWS_SOURCE_HTTP . 'mod/contact/javascript/dev/email.js';
        }
        self::addEmailModal();
        \Layout::addJSHeader("<script type='text/javascript' src='$script'></script>");
    }

    private static function addEmailModal()
    {
        $vars['site_key'] = RECAPTCHA_PUBLIC_KEY;
        $vars['captcha'] = javascript('captcha/recaptcha');
        $template = new \phpws2\Template($vars);
        $template->setModuleTemplate('contact', 'email.html');
        $content = $template->get();
        \Layout::add($content);
    }

    public static function load()
    {
        $contact_info = new \contact\Resource\ContactInfo;
        $contact_info->setPhoneNumber(\phpws2\Settings::get('contact',
                        'phone_number'));
        $contact_info->setFaxNumber(\phpws2\Settings::get('contact',
                        'fax_number'));
        $contact_info->setEmail(\phpws2\Settings::get('contact', 'email'));
        $contact_info->setSiteContactName(\phpws2\Settings::get('contact',
                        'site_contact_name'));
        $contact_info->setSiteContactEmail(\phpws2\Settings::get('contact',
                        'site_contact_email'));
        $contact_info->setOtherInformation(\phpws2\Settings::get('contact',
                        'other_information'));
        $contact_info->setFrontOnly(\phpws2\Settings::get('contact',
                        'front_only'));

        $contact_info->setPhysicalAddress(ContactInfo\PhysicalAddress::load());
        //$contact_info->setMap(Factory\ContactInfo\Map::load());
        $contact_info->setSocial(Factory\ContactInfo\Social::load());
        return $contact_info;
    }

    private static function getValues(\contact\Resource\ContactInfo $contact_info,
            $sort_social = false)
    {
        $values['phone_number'] = $contact_info->getPhoneNumber();
        $values['fax_number'] = $contact_info->getFaxNumber();
        $values['email'] = $contact_info->getEmail();
        $values['formatted_phone_number'] = $contact_info->getPhoneNumber(true);
        if ($values['fax_number']) {
            $values['formatted_fax_number'] = $contact_info->getFaxNumber(true);
        }

        $values['front_only'] = $contact_info->getFrontOnly();
        $values['site_contact_name'] = $contact_info->getSiteContactName();
        $values['site_contact_email'] = $contact_info->getSiteContactEmail();
        $values['other_information'] = $contact_info->getOtherInformation();
        $values['accessToken'] = \phpws2\Settings::get('contact', 'accessToken');
        $values['thumbnail_map'] = \phpws2\Settings::get('contact',
                        'thumbnail_map');
        $values['zoom'] = \phpws2\Settings::get('contact', 'zoom');
        $x = \phpws2\Settings::get('contact', 'dimension_x');
        $y = \phpws2\Settings::get('contact', 'dimension_y');
        $values['pitch'] = \phpws2\Settings::get('contact', 'pitch');
        $values['dimensions'] = "{$x}x{$y}";
        $lat = \phpws2\Settings::get('contact', 'latitude');
        $long = \phpws2\Settings::get('contact', 'longitude');

        $values['latitude'] = $lat;
        $values['longitude'] = $long;
        $values['openmap_link'] = ContactInfo\Map::getOpenStreetMapUrl($lat,
                        $long);
        $values['google_link'] = ContactInfo\Map::getGoogleMapUrl($lat, $long);
        $values['linkSupport'] = \phpws2\Settings::get('contact', 'linkSupport');
        $values['emailForm'] = \phpws2\Settings::get('contact', 'emailForm');

        $physical_address = $contact_info->getPhysicalAddress();
        $map = $contact_info->getMap();

        $values = array_merge($values,
                ContactInfo\PhysicalAddress::getValues($physical_address));
        //$values = array_merge($values, ContactInfo\Map::getValues($map));

        if ($sort_social) {
            $social = ContactInfo\Social::getLinks();
            foreach ($social as $label => $link) {
                if (isset($link['url'])) {
                    $social_icons[$label] = $link;
                }
            }
            if (!empty($social_icons)) {
                $values = array_merge($values, array('social' => $social_icons));
            }
        } else {
            $values = array_merge($values,
                    array('social' => ContactInfo\Social::getLinks()));
        }
        return $values;
    }

    public static function post(\contact\Resource\ContactInfo $contact_info,
            $values)
    {
        $contact_info->setPhoneNumber($values['phone_number']);
        $contact_info->setFaxNumber($values['fax_number']);
        $contact_info->setEmail($values['email']);
        $contact_info->setSiteContactName($values['site_contact_name']);
        $contact_info->setSiteContactEmail($values['site_contact_email']);
        $contact_info->setOtherInformation($values['other_information']);
        $contact_info->setFrontOnly($values['front_only']);
        $contact_info->setLinkSupport($value['linkSupport']);
        self::save($contact_info);

        $physical_address = $contact_info->getPhysicalAddress();
        Factory\ContactInfo\PhysicalAddress::set($physical_address, $values);
        Factory\ContactInfo\PhysicalAddress::save($physical_address);
    }

    private static function save(\contact\Resource\ContactInfo $contact_info)
    {
        \phpws2\Settings::set('contact', 'phone_number',
                $contact_info->getPhoneNumber());
        \phpws2\Settings::set('contact', 'fax_number',
                $contact_info->getFaxNumber());
        \phpws2\Settings::set('contact', 'email', $contact_info->getEmail());
        \phpws2\Settings::set('contact', 'site_contact_name',
                $contact_info->getSiteContactName());
        \phpws2\Settings::set('contact', 'site_contact_email',
                $contact_info->getSiteContactEmail());
        \phpws2\Settings::set('contact', 'other_information',
                $contact_info->getOtherInformation());
        \phpws2\Settings::set('contact', 'front_only',
                $contact_info->getFrontOnly());
    }

    public static function showSiteContact()
    {
        require_once PHPWS_SOURCE_DIR . 'mod/contact/config/default_message.php';
        $name = SITE_CONTACT_NAME;
        $email = SITE_CONTACT_EMAIL;
        $sc_name = \phpws2\Settings::get('contact', 'site_contact_name');
        $sc_email = \phpws2\Settings::get('contact', 'site_contact_email');
        if (!empty($sc_name) && !empty($sc_email)) {
            $name = $sc_name;
            $email = $sc_email;
        }
        if (empty($name) || empty($email)) {
            return;
        }
        \Layout::plug($sc_name, 'CONTACT_NAME');
        \Layout::plug($sc_email, 'CONTACT_EMAIL');
        $content = "Please report problems with this site or content errors to <a href='mailto:$email'>$name <i class='far fa-envelope'></i></a>.";
        \Layout::add($content, 'contact', 'SITE_CONTACT');
    }

    public static function display()
    {
        $building = \phpws2\Settings::get('contact', 'building');

        if (empty($building)) {
            return;
        }

        $contact_info = self::load();
        $values = self::getValues($contact_info, true);

        $template = new \phpws2\Template($values);
        $template->setModuleTemplate('contact', 'view.html');
        $content = $template->get();
        return $content;
    }

    private static function testCaptcha(\Canopy\Request $request)
    {
        $curl = curl_init();
        curl_setopt_array($curl,
                array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify',
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => array(
                'secret' => RECAPTCHA_PRIVATE_KEY,
                'response' => $request->pullPostString('captchaKey')
            )
        ));

        $resp = curl_exec($curl);
        curl_close($curl);

        $result = json_decode($resp);
        return $result->success;
    }

    public static function postEmail(\Canopy\Request $request)
    {
        $success = true;
        $resultMessage = '';

        $name = $request->pullPostString('name');
        $email = $request->pullPostString('email');
        $subject = substr($request->pullPostString('subject'), 0, 255);
        $message = substr($request->pullPostString('message'), 0, 1000);
        $toAddress = $request->pullPostString('toAddress');

        try {
            $emailObj = new \phpws2\Variable\Email($email);

            if (empty($name) || empty($email) || empty($subject) || empty($message)) {
                $success = false;
                $resultMessage = 'Some fields were incomplete.';
            } elseif (!self::testCaptcha($request)) {
                $success = false;
                $resultMessage = 'ReCaptcha failed.';
            }
        } catch (\Exception $e) {
            $success = false;
            $resultMessage = 'Check your email address.';
        }

        if ($success) {
            self::sendEmail($toAddress, $name, $email, $subject, $message);
        }

        return ['success' => $success, 'message' => $resultMessage];
    }

    private static function sendEmail($toAddress, $name, $email, $subject,
            $content)
    {
        $siteTitle = \Layout::getPageTitle(true);
        $subject = "Via website $siteTitle - $subject";
        $transport = new \Swift_SendmailTransport(SWIFT_MAIL_TRANSPORT_PARAMETER);
        $message = \Swift_Message::newInstance();
        $message->setSubject($subject);
        $message->setFrom([$email => $name]);
        $message->setTo($toAddress);
        $message->setBody($content, 'text/html');
        $mailer = new \Swift_Mailer($transport);
        $mailer->send($message);
    }

}
