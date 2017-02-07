<?php

namespace contact\Resource\ContactInfo\Social;

/**
 * @license http://opensource.org/licenses/lgpl-3.0.html
 * @author Matthew McNaney <mcnaney at gmail dot com>
 */
class Link extends \Data
{
    /**
     * Name of font awesome icon
     * @var string
     */
    private $icon = null;

    /**
     * @var \phpws2\Variable\TextOnly
     */
    private $title;

    /**
     * @var \phpws2\Variable\Url
     */
    private $url;

    public function __construct()
    {
        $this->title = new \phpws2\Variable\TextOnly(null, 'title');
        $this->icon = new \phpws2\Variable\TextOnly(null, 'icon');
        $this->url = new \phpws2\Variable\Url(null, 'url');
    }

    public function setIcon($icon)
    {
        $this->icon->set($icon);
    }
    
    public function getIcon()
    {
        return $this->icon->get();
    }
    
    public function getFAIcon()
    {
        return '<i class="fa fa-' . $this->getIcon() . ' fa-stack-2x"></i>';
    }
    
    public function setTitle($title)
    {
        $this->title->set($title);
    }
    
    public function getTitle()
    {
        return $this->title->get();
    }
    
    public function setUrl($url)
    {
        $this->url->set($url);
    }
    
    public function getUrl()
    {
        return $this->url->get();
    }

}
