<?php

/**
 * MIT License
 * Copyright (c) 2019 Electronic Student Services @ Appalachian State University
 * 
 * See LICENSE file in root directory for copyright and distribution permissions.
 * 
 * @author Matthew McNaney <mcnaneym@appstate.edu>
 * @license https://opensource.org/licenses/MIT
 */

define('CONTACT_SCRIPT_PRODUCTION', true);

// 1 : smtp
// 2 : sendmail
if (!defined('SWIFT_MAIL_TRANSPORT_TYPE')) {
    define('SWIFT_MAIL_TRANSPORT_TYPE', 2);
}

// depends on the choice above
// 1 : server location
// 2 : location of sendmail
// http://swiftmailer.org/docs/sending.html
if (!defined('SWIFT_MAIL_TRANSPORT_PARAMETER')) {
    define('SWIFT_MAIL_TRANSPORT_PARAMETER', '/usr/sbin/sendmail -t -i');
}