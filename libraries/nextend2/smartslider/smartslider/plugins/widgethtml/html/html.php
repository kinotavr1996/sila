<?php
/**
* @author    Roland Soos
* @copyright (C) 2015 Nextendweb.com
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Restricted access');
?><?php

N2Loader::import('libraries.plugins.N2SliderWidgetAbstract', 'smartslider');

class N2SSPluginWidgetHTMLHTML extends N2SSPluginWidgetAbstract
{

    var $_name = 'html';

    private static $key = 'widget-html-';

    static function getDefaults() {
        return array(
            'widget-html-position-mode' => 'simple',
            'widget-html-position-area' => 2,
            'widget-html-code'          => '',
        );
    }

    function onHtmlList(&$list) {
        $list[$this->_name] = $this->getPath();
    }

    function getPath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR . 'html' . DIRECTORY_SEPARATOR;
    }

    static function getPositions(&$params) {
        $positions                  = array();
        $positions['html-position'] = array(
            self::$key . 'position-',
            'html'
        );
        return $positions;
    }

    static function render($slider, $id, $params) {

        list($displayClass, $displayAttributes) = self::getDisplayAttributes($params, self::$key);

        list($style, $attributes) = self::getPosition($params, self::$key);

        return NHtml::tag('div', $displayAttributes + $attributes + array(
                "class" => "n2-widget-html {$displayClass}",
                "style" => "{$style}z-index: 10",
            ), $params->get(self::$key . 'code'));

    }
}

N2Plugin::addPlugin('sswidgethtml', 'N2SSPluginWidgetHTMLHTML');