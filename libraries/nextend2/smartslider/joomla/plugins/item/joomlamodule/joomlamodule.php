<?php
/**
* @author    Roland Soos
* @copyright (C) 2015 Nextendweb.com
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Restricted access');
?><?php

N2Loader::import('libraries.plugins.N2SliderItemAbstract', 'smartslider');

class N2SSPluginItemJoomlaModule extends N2SSPluginItemAbstract
{

    var $_identifier = 'joomlamodule';

    var $_title = 'Module';

    protected $priority = 11;

    function getTemplate($slider) {
        return '<div>{{positiontype} {positionvalue}}</div>';
    }

    function _render($data, $itemId, $slider, $slide) {
        return '<div>{' . $data->get('positiontype', '') . ' ' . $data->get('positionvalue', '') . '}</div>';
    }

    function _renderAdmin($data, $itemId, $slider, $slide) {
        return $this->_render($data, $itemId, $slider, $slide);
    }

    function getValues() {
        return array(
            'positiontype'  => 'loadposition',
            'positionvalue' => ''
        );
    }

    function getPath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR . $this->_identifier . DIRECTORY_SEPARATOR;
    }
}
N2Plugin::addPlugin('ssitem', 'N2SSPluginItemJoomlaModule');
