<?php
/**
* @author    Roland Soos
* @copyright (C) 2015 Nextendweb.com
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Restricted access');
?><?php
class N2SSPluginWidgetIndicator extends N2PluginBase
{

    private static $group = 'indicator';

    function onWidgetList(&$list) {
        $list[self::$group] = array(
            n2_('Indicator'),
            $this->getPath(),
            4
        );
    }

    function getPath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR . self::$group . DIRECTORY_SEPARATOR;
    }
}

N2Plugin::addPlugin('sswidget', 'N2SSPluginWidgetIndicator');
