<?php
/**
* @author    Roland Soos
* @copyright (C) 2015 Nextendweb.com
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Restricted access');
?><?php
N2Loader::import('libraries.plugins.N2SliderGeneratorPluginAbstract', 'smartslider');

class N2SSPluginGeneratorJEvents extends N2PluginBase
{

    public static $group = 'jevents';
    public static $groupLabel = 'JEvents';

    function onGeneratorList(&$group, &$list) {
        $installed = N2Filesystem::existsFile(JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_jevents' . DIRECTORY_SEPARATOR . 'jevents.php');
        $url       = 'http://extensions.joomla.org/extension/jevents';

        $group[self::$group] = self::$groupLabel;

        if (!isset($list[self::$group])) {
            $list[self::$group] = array();
        }

        $list[self::$group]['events'] = N2GeneratorInfo::getInstance(self::$groupLabel, n2_('Events'), $this->getPath() . 'events')
                                                       ->setInstalled($installed)
                                                       ->setUrl($url)
                                                       ->setType('event');
    }

    function getPath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR;
    }
}

N2Plugin::addPlugin('ssgenerator', 'N2SSPluginGeneratorJEvents');
