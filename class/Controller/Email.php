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

namespace contact\Controller;

class Email extends \phpws2\Http\Controller
{

    public function post(\Canopy\Request $request)
    {
        \phpws2\Settings::set('contact', 'linkSupport', $request->pullPostBoolean('value'));
        $view = new \phpws2\View\JsonView(array('success' => true));
        $response = new \Canopy\Response($view);
        return $response;
    }

}
