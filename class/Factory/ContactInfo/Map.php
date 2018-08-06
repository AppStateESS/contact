<?php

namespace contact\Factory\ContactInfo;

/**
 * @license http://opensource.org/licenses/lgpl-3.0.html
 * @author Matthew McNaney <mcnaney at gmail dot com>
 */
class Map
{

    public static function getMapSearchString(\contact\Resource\ContactInfo\PhysicalAddress $physical_address)
    {
        $building = $physical_address->getBuilding();
        $street = $physical_address->getStreet();
        $city = $physical_address->getCity();
        $state = $physical_address->getState();

        if (empty($building) || empty($street) || empty($city) || empty($state)) {
            throw new \Exception('Building, street, city and state are required information.');
        } else {
            $address = "$building,+$street,+$city,+$state";
            return $address;
        }
    }

    public static function getImageUrl($latitude, $longitude)
    {
        $map = self::load();
        $size = \phpws2\Settings::get('contact', 'dimension_x') . 'x' . \phpws2\Settings::get('contact', 'dimension_y');
        $zoom = \phpws2\Settings::get('contact', 'zoom');
        $accessToken = \phpws2\Settings::get('contact', 'accessToken');
        $pitch = \phpws2\Settings::get('contact', 'pitch');
        
        return "https://api.mapbox.com/styles/v1/mapbox/streets-v10/static/$longitude,$latitude,$zoom,0,$pitch/$size?access_token=$accessToken";
    }

    public static function getGoogleMapUrl($latitude, $longitude)
    {
        $map = self::load();
        $zoom = $map->getZoom();
        return "https://www.google.com/maps/place/$latitude,$longitude/z=$zoom";
    }
    
    public static function getOpenStreetMapUrl($latitude, $longitude)
    {
        $map = self::load();
        $zoom = $map->getZoom();
        return "https://www.openstreetmap.org/#map=$zoom/$latitude/$longitude/&layers=N";
    }

    public static function getValues(\contact\Resource\ContactInfo\Map $map)
    {
        $values['thumbnail_map'] = $map->getThumbnailMap();
        $values['latitude'] = $map->getLatitude();
        $values['longitude'] = $map->getLongitude();
        $values['full_map_link'] = $map->getFullMapLink();
        $values['zoom'] = $map->getZoom();
        $values['dimension_x'] = $map->getDimensionX();
        $values['dimension_y'] = $map->getDimensionY();
        $values['pitch'] = $map->getPitch();
        return $values;
    }

    public static function load()
    {
        $map = new \contact\Resource\ContactInfo\Map;

        $map->setThumbnailMap(\phpws2\Settings::get('contact', 'thumbnail_map'));
        $map->setLatitude(\phpws2\Settings::get('contact', 'latitude'));
        $map->setLongitude(\phpws2\Settings::get('contact', 'longitude'));
        $map->setFullMapLink(\phpws2\Settings::get('contact', 'full_map_link'));
        $map->setZoom(\phpws2\Settings::get('contact', 'zoom'));
        $map->setDimensionX(\phpws2\Settings::get('contact', 'dimension_x'));
        $map->setDimensionY(\phpws2\Settings::get('contact', 'dimension_y'));
        $map->setPitch(\phpws2\Settings::get('contact', 'pitch'));
        return $map;
    }

    public static function save(\contact\Resource\ContactInfo\Map $map)
    {
        $values = self::getValues($map);
        foreach ($values as $key => $val) {
            \phpws2\Settings::set('contact', $key, $val);
        }
    }

    public static function createMapThumbnail($latitude, $longitude)
    {
        $image_url = self::getImageUrl($latitude, $longitude);
        $curl = \curl_init($image_url);

        $filename = 'images/contact/map_' . time() . '.jpg';
        $fp = fopen(PHPWS_HOME_DIR . $filename, "w");
        \curl_setopt($curl, CURLOPT_FILE, $fp);
        \curl_setopt($curl, CURLOPT_HEADER, 0);

        \curl_exec($curl);
        \curl_close($curl);
        fclose($fp);

        $map = self::load();
        $map->setThumbnailMap($filename);
        $map->setLatitude($latitude);
        $map->setLongitude($longitude);
        $map->setFullMapLink(self::getOpenStreetMapUrl($latitude, $longitude));
        self::save($map);
        return $filename;
    }

    public static function clearThumbnail()
    {
        $map_directory = \phpws2\Settings::get('contact', 'thumbnail_map');
        if (is_file($map_directory)) {
            unlink($map_directory);
        }
        \phpws2\Settings::set('contact', 'thumbnail_map', null);
    }

}
