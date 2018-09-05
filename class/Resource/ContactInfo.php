<?php

namespace contact\Resource;

use contact\Resource\ContactInfo;

class ContactInfo extends \phpws2\Resource
{

    /**
     * @var ContactInfo\PhysicalAddress
     */
    private $physical_address;

    /**
     * @var \phpws2\Variable\StringVar
     */
    private $phone_number;

    /**
     * @var \phpws2\Variable\StringVar
     */
    private $fax_number;

    /**
     * @var ContactInfo\Social
     */
    private $social;

    /**
     * @var ContactInfo\Map
     */
    private $map;

    /**
     * @var \phpws2\Variable\Email
     */
    private $email;

    /**
     * @var \phpws2\Variable\StringVar
     */
    private $site_contact_name;

    /**
     * @var \phpws2\Variable\StringVar
     */
    private $site_contact_email;

    /**
     * @var \phpws2\Variable\StringVar
     */
    private $other_information;
    
    private $front_only;
    
    private $linkSupport;

    public function __construct()
    {
        $this->physical_address = new ContactInfo\PhysicalAddress;
        $this->phone_number = new \phpws2\Variable\StringVar(null, 'phone_number');
        $this->fax_number = new \phpws2\Variable\StringVar(null, 'phone_number');
        $this->fax_number->allowEmpty(true);
        $this->social = new ContactInfo\Social;
        $this->map = new ContactInfo\Map;
        $this->email = new \phpws2\Variable\Email(null, 'email');
        $this->email->allowNull(true);
        $this->site_contact_name = new \phpws2\Variable\TextOnly(null, 'site_contact_name');
        $this->site_contact_name->allowNull(true);
        $this->site_contact_email = new \phpws2\Variable\TextOnly(null, 'site_contact_email');
        $this->site_contact_email->allowNull(true);
        $this->other_information = new \phpws2\Variable\StringVar(null, 'other_information');
        $this->other_information->allowNull(true);
        $this->front_only = new \phpws2\Variable\BooleanVar(0, 'front_only');
        $this->linkSupport = new \phpws2\Variable\BooleanVar(1, 'linkSupport');
    }

    /**
     *
     * @return contact\Resource\ContactInfo\PhysicalAddress
     */
    public function getPhysicalAddress()
    {
        return $this->physical_address;
    }

    /**
     *
     * @return contact\Resource\ContactInfo\Social
     */
    public function getSocial()
    {
        return $this->social;
    }

    /**
     *
     * @return contact\Resource\ContactInfo\Map
     */
    public function getMap()
    {
        return $this->map;
    }

    public function getPhoneNumber($format = false)
    {
        $phone_number = $this->phone_number->get();
        if (!$format) {
            return $phone_number;
        }
        return '(' . substr($phone_number, 0, 3) . ') ' . substr($phone_number, 3, 3) . '-' . substr($phone_number, 6, 4);
    }

    public function setPhoneNumber($phone)
    {
        $phone = preg_replace('/[^\d]/', '', $phone);
        $this->phone_number->set($phone);
    }

    public function getFaxNumber($format = false)
    {
        $fax_number = $this->fax_number->get();
        if (!$format) {
            return $fax_number;
        }
        return '(' . substr($fax_number, 0, 3) . ') ' . substr($fax_number, 3, 3) . '-' . substr($fax_number, 6, 4);
    }
    
    public function setLinkSupport($ls)
    {
        $this->linkSupport->set($ls);
    }
    
    public function getLinkSupport()
    {
        return $this->linkSupport->get();
    }

    public function setFaxNumber($fax)
    {
        $fax = preg_replace('/[^\d]/', '', $fax);
        $this->fax_number->set($fax);
    }

    public function setEmail($email)
    {
        $this->email->set($email);
    }

    public function getEmail()
    {
        $email = $this->email->get();
        return $email;
    }

    public function setPhysicalAddress(ContactInfo\PhysicalAddress $physical_address)
    {
        $this->physical_address = $physical_address;
    }

    public function setMap(ContactInfo\Map $map)
    {
        $this->map = $map;
    }

    public function setSocial(ContactInfo\Social $social)
    {
        $this->social = $social;
    }

    public function setSiteContactName($contact_name)
    {
        $this->site_contact_name->set($contact_name);
    }

    public function getSiteContactName()
    {
        return $this->site_contact_name->get();
    }

    public function setSiteContactEmail($contact_email)
    {
        $this->site_contact_email->set($contact_email);
    }

    public function getSiteContactEmail()
    {
        return $this->site_contact_email->get();
    }

    public function setOtherInformation($info)
    {
        $this->other_information->set($info);
    }

    public function getOtherInformation()
    {
        return $this->other_information->get();
    }
    
    public function setFrontOnly($fo)
    {
        $this->front_only->set($fo);
    }
    
    public function getFrontOnly()
    {
        return $this->front_only->get();
    }

}
