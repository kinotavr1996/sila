<?php
/**
* @author    Roland Soos
* @copyright (C) 2015 Nextendweb.com
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Restricted access');
?><?php
if(N2SSPRO) {
    class N2SSPluginResponsiveAdaptive extends N2PluginBase
    {

        private static $name = 'adaptive';

        function onResponsiveList(&$list, &$labels) {
            $list[self::$name]   = $this->getPath();
            $labels[self::$name] = n2_x('Adaptive', 'Slider responsive mode');
        }

        static function getPath() {
            return dirname(__FILE__) . DIRECTORY_SEPARATOR . self::$name . DIRECTORY_SEPARATOR;
        }
    }

    N2Plugin::addPlugin('ssresponsive', 'N2SSPluginResponsiveAdaptive');

    class N2SSResponsiveAdaptive
    {

        private $params, $responsive;

        public function __construct($params, $responsive) {
            $this->params     = $params;
            $this->responsive = $responsive;
        }
    }
} //N2SSPRO