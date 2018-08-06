<?php

namespace contact\Controller;

use contact\Factory\ContactInfo\Map as Factory;

/**
 * @license http://opensource.org/licenses/lgpl-3.0.html
 * @author Matthew McNaney <mcnaney at gmail dot com>
 */
class Map extends \phpws2\Http\Controller
{

    public function get(\Canopy\Request $request)
    {
        $data = array();
        $view = $this->getView($data, $request);
        $response = new \Canopy\Response($view);
        return $response;
    }

    protected function getHtmlView($data, \Canopy\Request $request)
    {
        $content = \contact\Factory\ContactInfo::form($request, 'map');
        $view = new \phpws2\View\HtmlView(\PHPWS_ControlPanel::display($content));
        return $view;
    }

    protected function getJsonView($data, \Canopy\Request $request)
    {
        $command = $request->shiftCommand();
        switch ($command) {
            case 'locationString':
                return $this->locationString();
                break;

            case 'getGoogleLink':
                return $this->getGoogleLink($request);
                break;
            
            case 'saveThumbnail':
                return $this->saveThumbnail($request);
                break;

            case 'clearThumbnail':
                Factory::clearThumbnail();
                $json['success'] = 1;
                $view = new \phpws2\View\JsonView($json);
                return $view;
                break;
        }
    }

    public function post(\Canopy\Request $request)
    {
        $command = $request->shiftCommand();
        switch ($command) {
            case 'saveAccessToken':
                \phpws2\Settings::set('contact', 'accessToken',
                        $request->pullPostString('accessToken'));
                break;
        }
        $json['result'] = 'true';
        $view = new \phpws2\View\JsonView($json);
        $response = new \Canopy\Response($view);
        return $response;
    }

    private function locationString()
    {
        $json = array();
        $contact_info = \contact\Factory\ContactInfo::load();
        $physical_address = $contact_info->getPhysicalAddress();

        try {
            $json['address'] = Factory::getMapSearchString($physical_address);
        } catch (\Exception $e) {
            $json['error'] = $e->getMessage();
        }

        $view = new \phpws2\View\JsonView($json);
        return $view;
    }

    private function saveThumbnail(\Canopy\Request $request)
    {
        $latitude = $request->pullGetString('latitude');
        $longitude = $request->pullGetString('longitude');
        $dimensions = $request->pullGetString('dimensions');
        $pitch = $request->pullGetString('pitch');
        $zoom = $request->pullGetInteger('zoom');
        
        list($x, $y) = explode('x', $dimensions);
        \phpws2\Settings::set('contact', 'dimension_x', $x);
        \phpws2\Settings::set('contact', 'dimension_y', $y);
        \phpws2\Settings::set('contact', 'pitch', $pitch);
        \phpws2\Settings::set('contact', 'zoom', $zoom);

        $json['image'] = Factory::createMapThumbnail($latitude, $longitude);
        $view = new \phpws2\View\JsonView($json);
        return $view;
    }

}
