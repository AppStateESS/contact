<?php

namespace contact\Controller;

/**
 * @license http://opensource.org/licenses/lgpl-3.0.html
 * @author Matthew McNaney <mcnaney at gmail dot com>
 */
class Social extends \phpws2\Http\Controller
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
        $content = \contact\Factory\ContactInfo::form($request, 'social');
        $view = new \phpws2\View\HtmlView(\PHPWS_ControlPanel::display($content));
        return $view;
    }

    public function post(\Canopy\Request $request)
    {
        $social_links = \contact\Factory\ContactInfo\Social::pullSavedLinks();
        $label = $request->pullPostString('label');
        $url = $request->pullPostString('url');
        if (empty($url)) {
            unset($social_links[$label]);
        } else {
            $social_links[$label] = preg_replace('/https?:\/\//', '', $url);
        }
        \contact\Factory\ContactInfo\Social::saveLinks($social_links);
        echo 'post successful';
        exit;
    }

}
