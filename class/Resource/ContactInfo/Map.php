<?php

namespace contact\Resource\ContactInfo;

/**
 * @license http://opensource.org/licenses/lgpl-3.0.html
 * @author Matthew McNaney <mcnaney at gmail dot com>
 */
class Map extends \Canopy\Data{
    private $thumbnail_map;
    private $latitude;
    private $longitude;
    private $full_map_link;
    private $zoom;
    private $accessToken;
    private $dimension_x;
    private $dimension_y;

    public function __construct()
    {
        $this->thumbnail_map = new \phpws2\Variable\FileVar(null, 'thumbnail_map');
        $this->thumbnail_map->allowNull(true);
        $this->thumbnail_map->allowEmpty(true);
        $this->latitude = new \phpws2\Variable\FloatVar(null, 'latitude');
        $this->longitude = new \phpws2\Variable\FloatVar(null, 'longitude');
        $this->full_map_link = new \phpws2\Variable\Url(null, 'full_map_link');
        $this->full_map_link->allowNull(true);
        $this->zoom = new \phpws2\Variable\IntegerVar(null, 'zoom');
        $this->dimension_x = new \phpws2\Variable\IntegerVar(null, 'dimension_x');
        $this->dimension_y = new \phpws2\Variable\IntegerVar(null, 'dimension_y');
        $this->accessToken = new \phpws2\Variable\Alphanumeric(null, 'accessToken');
        $this->pitch = new \phpws2\Variable\IntegerVar(0, 'pitch');
    }

    public function setThumbnailMap($thumbnail_map)
    {
        $this->thumbnail_map->set($thumbnail_map);
    }

    public function setLatitude($latitude)
    {
        $latitude = (float)$latitude;
        $this->latitude->set($latitude);
    }

    public function setLongitude($longitude)
    {
        $longitude = (float)$longitude;
        $this->longitude->set($longitude);
    }

    public function setFullMapLink($full_map_link)
    {
        $this->full_map_link->set($full_map_link);
    }

    public function setZoom($zoom)
    {
        $this->zoom->set($zoom);
    }

    public function setDimensionX($dim_x)
    {
        $this->dimension_x->set($dim_x);
    }

    public function setDimensionY($dim_y)
    {
        $this->dimension_y->set($dim_y);
    }
    
    public function setAccessToken($token)
    {
        $this->accessToken->set($token);
    }
    
    public function setPitch($pitch)
    {
        $this->pitch->set($pitch);
    }
    
    public function getPitch()
    {
        return $this->pitch->get();
    }
    
    public function getAccessToken()
    {
        return $this->accessToken->get();
    }

     public function getThumbnailMap()
    {
        return $this->thumbnail_map->get();
    }

    public function getLatitude()
    {
        return $this->latitude->get();
    }

    public function getLongitude()
    {
        return $this->longitude->get();
    }

    public function getFullMapLink()
    {
        return $this->full_map_link->get();
    }

    public function getZoom()
    {
        return $this->zoom->get();
    }

    public function getDimensionX()
    {
        return $this->dimension_x->get();
    }

    public function getDimensionY()
    {
        return $this->dimension_y->get();
    }

}
