<?php

/*
 * See docs/AUTHORS and docs/COPYRIGHT for relevant info.
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * @author Matthew McNaney <mcnaney at gmail dot com>
 *
 * @license http://opensource.org/licenses/lgpl-3.0.html
 */

class Swift_MailTransport
{

    public static function newInstance()
    {
        return new Swift_MailTransport;
    }

}

class Swift_Message
{

    public $subject;
    public $from;
    public $to;
    public $body;
    public $cc;
    public $bcc;

    public static function newInstance()
    {
        return new Swift_Message;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function getTo()
    {
        return $this->to;
    }

    public function getCc()
    {
        return $this->cc;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getBcc()
    {
        return $this->bcc;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function setFrom($from)
    {
        $this->from = $from;
    }

    public function setTo($to)
    {
        $this->to = $to;
    }

    public function setCc($cc)
    {
        $this->cc = $cc;
    }

    public function setBcc($bcc)
    {
        $this->bcc = $bcc;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function get()
    {
        return get_object_vars($this);
    }

}

class Swift_Mailer
{

    public static function newInstance($transport)
    {
        return new Swift_Mailer;
    }

    public function send($message)
    {
        $file = str_replace(' ', '-', $message->subject) . '-' . microtime() . '.html';

        $save_path = 'files/' . $file;

        $message_array = $message->get();

        if (is_array($message_array['from'])) {
            foreach ($message_array['from'] as $fromEmail => $fromName);
            $message_array['from'] = "$fromName &lt;$fromEmail&gt;";
        }
        
        $template = new \phpws2\Template($message_array);
        $template->setModuleTemplate('properties', 'FakeSwift.html');
        $content = $template->get();
        file_put_contents($save_path, $content);
        return true;
    }

}
