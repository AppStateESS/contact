<?php

namespace contact\Factory\ContactInfo;

use contact\Resource\ContactInfo\PhysicalAddress as PhysicalAddressResource;

/**
 * @license http://opensource.org/licenses/lgpl-3.0.html
 * @author Matthew McNaney <mcnaney at gmail dot com>
 */
class PhysicalAddress
{

    public static function load()
    {
        $physical_address = new \contact\Resource\ContactInfo\PhysicalAddress;
        $physical_address->setRoomNumber(\phpws2\Settings::get('contact', 'room_number'));
        $physical_address->setBuilding(\phpws2\Settings::get('contact', 'building'));
        $physical_address->setStreet(\phpws2\Settings::get('contact', 'street'));
        $physical_address->setPostBox(\phpws2\Settings::get('contact', 'post_box'));
        $physical_address->setCity(\phpws2\Settings::get('contact', 'city'));
        $physical_address->setState(\phpws2\Settings::get('contact', 'state'));
        $physical_address->setZip(\phpws2\Settings::get('contact', 'zip'));
        return $physical_address;
    }

    public static function set(PhysicalAddressResource $physical_address, $values)
    {
        $physical_address->setBuilding($values['building']);
        $physical_address->setRoomNumber(empty($values['room_number']) ? null : $values['room_number']);
        $physical_address->setPostBox((int)$values['post_box']);
        $physical_address->setStreet($values['street']);
        $physical_address->setCity($values['city']);
        $physical_address->setState($values['state']);
        $physical_address->setZip($values['zip']);
    }

    public static function save(PhysicalAddressResource $physical_address)
    {
        \phpws2\Settings::set('contact', 'building', $physical_address->getBuilding());
        \phpws2\Settings::set('contact', 'room_number', $physical_address->getRoomNumber());
        \phpws2\Settings::set('contact', 'post_box', $physical_address->getPostBox());
        \phpws2\Settings::set('contact', 'street', $physical_address->getStreet());
        \phpws2\Settings::set('contact', 'city', $physical_address->getCity());
        \phpws2\Settings::set('contact', 'state', $physical_address->getState());
        \phpws2\Settings::set('contact', 'zip', $physical_address->getZip());
    }

    public static function getValues(PhysicalAddressResource $physical_address)
    {
        $values['room_number'] = $physical_address->getRoomNumber();
        $values['building'] = $physical_address->getBuilding();
        $values['street'] = $physical_address->getStreet();
        $values['post_box'] = $physical_address->getPostBox();
        $values['city'] = $physical_address->getCity();
        $values['state'] = $physical_address->getState();
        $values['zip'] = $physical_address->getZip();
        return $values;
    }

}
