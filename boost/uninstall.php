<?php

/**
 * @license http://opensource.org/licenses/lgpl-3.0.html
 * @author Matthew McNaney <mcnaney at gmail dot com>
 */

function contact_uninstall(&$content) {
    $content[] = 'Settings cleared.';
    \phpws2\Settings::reset('contact');
    return true;
}