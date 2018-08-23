<?php

namespace contact\Controller;

use contact\Factory\ContactInfo as Factory;
use contact\Resource;

/**
 * @license http://opensource.org/licenses/lgpl-3.0.html
 * @author Matthew McNaney <mcnaney at gmail dot com>
 */
class ContactInfo extends \phpws2\Http\Controller
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
        $content = Factory::form($request, 'contact_info');
        $view = new \phpws2\View\HtmlView(\PHPWS_ControlPanel::display($content));
        return $view;
    }

    public function post(\Canopy\Request $request)
    {
        return $this->postContactInfo($request);
    }

    private function postContactInfo(\Canopy\Request $request)
    {
        $values = $request->pullPostVars();
        Factory::post(Factory::load(), $values);
        $view = new \phpws2\View\JsonView(array('success'=>true));
        $response = new \Canopy\Response($view);
        return $response;
    }
    
}
