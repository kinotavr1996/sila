<?php
/**
* @author    Roland Soos
* @copyright (C) 2015 Nextendweb.com
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Restricted access');
?><?php

class N2SSPluginResponsiveFullWidth extends N2PluginBase
{

    private static $name = 'fullwidth';

    function onResponsiveList(&$list, &$labels) {
        $list[self::$name]   = $this->getPath();
        $labels[self::$name] = n2_x('Fullwidth', 'Slider responsive mode');
    }

    static function getPath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR . self::$name . DIRECTORY_SEPARATOR;
    }
}

N2Plugin::addPlugin('ssresponsive', 'N2SSPluginResponsiveFullWidth');

class N2SSResponsiveFullWidth
{

    private $params, $responsive;

    public function __construct($params, $responsive) {
        $this->params     = $params;
        $this->responsive = $responsive;

        $this->responsive->scaleDown = 1;
        $this->responsive->scaleUp   = 1;

        $this->responsive->minimumHeight = intval($this->params->get('responsiveSliderHeightMin', 0));
        $this->responsive->maximumHeight = intval($this->params->get('responsiveSliderHeightMax', 3000));

        $this->responsive->maximumSlideWidth = intval($this->params->get('responsiveSlideWidthMax', 3000));

        $this->responsive->forceFull = intval($this->params->get('responsiveForceFull', 1));
    }
}