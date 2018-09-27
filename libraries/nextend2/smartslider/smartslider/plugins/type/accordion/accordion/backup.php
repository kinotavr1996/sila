<?php
/**
* @author    Roland Soos
* @copyright (C) 2015 Nextendweb.com
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Restricted access');
?><?php

class N2SmartSliderBackupAccordion
{

    /**
     * @param N2SmartSliderExport $export
     * @param                          $slider
     */
    public static function export($export, $slider) {
        $export->addVisual($slider['params']->get('title-font', ''));
    }

    /**
     * @param N2SmartSliderImport $import
     * @param                          $slider
     */
    public static function import($import, $slider) {
        $slider['params']->set('title-font', $import->fixSection($slider['params']->get('title-font', '')));
    }
}