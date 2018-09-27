<?php
/**
* @author    Roland Soos
* @copyright (C) 2015 Nextendweb.com
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Restricted access');
?><?php
N2Loader::import('libraries.plugins.N2SliderGeneratorPluginAbstract', 'smartslider');

class N2SSPluginGeneratorJReviews extends N2PluginBase
{

public static $group = 'jreviews';
public static $groupLabel = 'JReviews';

function onGeneratorList(&$group, &$list) {
    $installed = N2Filesystem::existsFolder(JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_jreviews');
    $url       = 'https://www.jreviews.com/';

    $group[self::$group] = self::$groupLabel;

    if (!isset($list[self::$group])) {
        $list[self::$group] = array();
    }

    $list[self::$group]['comments'] = N2GeneratorInfo::getInstance(self::$groupLabel, n2_('Comments'), $this->getPath() . 'comments')
                                                     ->setInstalled($installed)
                                                     ->setUrl($url)
                                                     ->setType('article');
}

function getPath() {
    return dirname(__FILE__) . DIRECTORY_SEPARATOR;
}

}

N2Plugin::addPlugin('ssgenerator', 'N2SSPluginGeneratorJReviews');
