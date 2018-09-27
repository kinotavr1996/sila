<?php
/**
* @author    Roland Soos
* @copyright (C) 2015 Nextendweb.com
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Restricted access');
?><?php
if(N2SSPRO) {
    class N2SSPluginResponsiveFullPage extends N2PluginBase
    {

        private static $name = 'fullpage';

        function onResponsiveList(&$list, &$labels) {
            $list[self::$name]   = $this->getPath();
            $labels[self::$name] = n2_x('Fullpage', 'Slider responsive mode');
        }

        static function getPath() {
            return dirname(__FILE__) . DIRECTORY_SEPARATOR . self::$name . DIRECTORY_SEPARATOR;
        }
    }

    N2Plugin::addPlugin('ssresponsive', 'N2SSPluginResponsiveFullPage');

    class N2SSResponsiveFullPage
    {

        private $params, $responsive;

        public function __construct($params, $responsive) {
            $this->params     = $params;
            $this->responsive = $responsive;

            $this->responsive->scaleDown = 1;
            $this->responsive->scaleUp   = 1;

            $this->responsive->maximumSlideWidth = intval($this->params->get('responsiveSlideWidthMax', 3000));

            $this->responsive->focusUser     = intval($this->params->get('responsiveFocusUser', 0));
            $this->responsive->focusAutoplay = intval($this->params->get('responsiveFocusAutoplay', 0));

            $this->responsive->forceFull               = intval($this->params->get('responsiveForceFull', 1));
            $this->responsive->verticalOffsetSelectors = $this->params->get('responsiveHeightOffset', '#wpadminbar');

        }
    }
} //N2SSPRO