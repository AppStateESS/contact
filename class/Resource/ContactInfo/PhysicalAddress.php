<?php

namespace contact\Resource\ContactInfo;

/**
 * @license http://opensource.org/licenses/lgpl-3.0.html
 * @author Matthew McNaney <mcnaney at gmail dot com>
 */
class PhysicalAddress extends \Canopy\Data{

    /**
     * Room nummber in building
     * @var \phpws2\Variable\Integer
     */
    private $room_number;

    /**
     * Name of building
     * @var \phpws2\Variable\TextOnly
     */
    private $building;

    /**
     *
     * @var \phpws2\Variable\TextOnly
     */
    private $street;

    /**
     * Post Office box
     * @var \phpws2\Variable\Integer
     */
    private $post_box;

    /**
     * @var \phpws2\Variable\TextOnly
     */
    private $city;

    /**
     * @var \phpws2\Variable\TextOnly
     */
    private $state;

    /**
     * @var \phpws2\Variable\Integer
     */
    private $zip;

    public function __construct()
    {
        $this->room_number = new \phpws2\Variable\IntegerVar(null, 'room_number');
        $this->room_number->allowNull(true);
        $this->building = new \phpws2\Variable\TextOnly(null, 'building');
        $this->building->allowNull(true);
        $this->street = new \phpws2\Variable\TextOnly(null, 'street');
        $this->street->allowNull(true);
        $this->post_box = new \phpws2\Variable\IntegerVar(null, 'post_box');
        $this->post_box->allowNull(true);
        $this->city = new \phpws2\Variable\TextOnly(null, 'city');
        $this->city->allowNull(true);
        $this->state = new \phpws2\Variable\TextOnly(null, 'state');
        $this->state->allowNull(true);
        $this->zip = new \phpws2\Variable\StringVar(null, 'zip');
        $this->zip->allowNull(true);
    }

    public function getRoomNumber()
    {
        return $this->room_number->get();
    }

    public function getBuilding()
    {
        return $this->building->get();
    }

    public function getStreet()
    {
        return $this->street->get();
    }

    public function getPostBox()
    {
        return $this->post_box->get();
    }

    public function getCity()
    {
        return $this->city->get();
    }

    public function getState()
    {
        return $this->state->get();
    }

    public function getZip()
    {
        return $this->zip->get();
    }

    public function setBuilding($building)
    {
        $this->building->set($building);
    }

    public function setRoomNumber($room_number)
    {
        if (empty($room_number)) {
            $this->room_number->set(null);
        } else {
            $this->room_number->set($room_number);
        }
    }

    public function setPostBox($post_box)
    {
        if (empty($post_box)) {
            $post_box = null;
        }
        $this->post_box->set($post_box);
    }

    public function setStreet($street)
    {
        $this->street->set($street);
    }

    public function setCity($city)
    {
        $this->city->set($city);
    }

    public function setState($state)
    {
        $this->state->set($state);
    }

    public function setZip($zip)
    {
        $this->zip->set($zip);
    }

}
