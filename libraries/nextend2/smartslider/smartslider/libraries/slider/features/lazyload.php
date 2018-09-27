<?php
/**
* @author    Roland Soos
* @copyright (C) 2015 Nextendweb.com
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Restricted access');
?><?php

class N2SmartSliderFeatureLazyLoad
{

    private $slider;

    public $isEnabled = 0;

    public $neighborCount = 0;

    public function __construct($slider) {

        $this->slider = $slider;

        $this->isEnabled     = intval($slider->params->get('imageload', 0));
        $this->neighborCount = intval($slider->params->get('imageloadNeighborSlides', 0));
    }

    public function makeJavaScriptProperties(&$properties) {

        $properties['lazyLoad']         = $this->isEnabled;
        $properties['lazyLoadNeighbor'] = $this->neighborCount;
    }

    public function isSlideLazyLoaded($slideIndex) {
        if ($this->isEnabled == 0) {
            return false;
        }
        if ($this->slider->_activeSlide == $slideIndex) {
            return false;
        }

        if ($this->lazyLoad->neighborCount) {
            $dist         = abs($this->slider->_activeSlide - $slideIndex);
            $distanceBack = abs($slideIndex - count($this->_slides) - 1);
            if ($distanceBack < $dist) {
                $dist = $distanceBack;
            }
            if ($dist <= $this->lazyLoad->neighborCount) {
                return false;
            }
        }
        return true;
    }
}