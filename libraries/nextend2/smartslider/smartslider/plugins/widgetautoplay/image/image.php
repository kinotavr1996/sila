<?php
/**
* @author    Roland Soos
* @copyright (C) 2015 Nextendweb.com
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Restricted access');
?><?php

N2Loader::import('libraries.plugins.N2SliderWidgetAbstract', 'smartslider');

class N2SSPluginWidgetAutoplayImage extends N2SSPluginWidgetAbstract
{

    private static $key = 'widget-autoplay-';

    var $_name = 'image';

    static function getDefaults() {
        return array(
            'widget-autoplay-responsive-desktop' => 1,
            'widget-autoplay-responsive-tablet'  => 0.7,
            'widget-autoplay-responsive-mobile'  => 0.5,
            'widget-autoplay-play-image'         => '',
            'widget-autoplay-play'               => '$ss$/plugins/widgetautoplay/image/image/play/small-light.svg',
            'widget-autoplay-style'              => 'eyJuYW1lIjoiU3RhdGljIiwiZGF0YSI6W3siYmFja2dyb3VuZGNvbG9yIjoiMDAwMDAwYWIiLCJwYWRkaW5nIjoiMTB8KnwxMHwqfDEwfCp8MTB8KnxweCIsImJveHNoYWRvdyI6IjB8KnwwfCp8MHwqfDB8KnwwMDAwMDBmZiIsImJvcmRlciI6IjB8Knxzb2xpZHwqfDAwMDAwMGZmIiwiYm9yZGVycmFkaXVzIjoiMyIsImV4dHJhIjoiIn0seyJiYWNrZ3JvdW5kY29sb3IiOiIwMDAwMDBhYiJ9XX0=',
            'widget-autoplay-position-mode'      => 'simple',
            'widget-autoplay-position-area'      => 4,
            'widget-autoplay-position-offset'    => 15,
            'widget-autoplay-mirror'             => 1,
            'widget-autoplay-pause-image'        => '',
            'widget-autoplay-pause'              => '$ss$/plugins/widgetautoplay/image/image/pause/small-light.svg'
        );
    }

    function onAutoplayList(&$list) {
        $list[$this->_name] = $this->getPath();
    }

    function getPath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR . 'image' . DIRECTORY_SEPARATOR;
    }

    static function getPositions(&$params) {
        $positions = array();

        $positions['autoplay-position'] = array(
            self::$key . 'position-',
            'autoplay'
        );
        return $positions;
    }

    static function render($slider, $id, $params) {
        $html = '';

        $play = $params->get(self::$key . 'play-image');
        if (empty($play)) {
            $play = $params->get(self::$key . 'play');
            if ($play == -1) {
                $play = null;
            } elseif ($play[0] != '$') {
                $play = N2Uri::pathToUri(dirname(__FILE__) . '/image/play/' . $play);
            }
        }

        if ($params->get(self::$key . 'mirror')) {
            $pause = str_replace('image/play/', 'image/pause/', $play);
        } else {
            $pause = $params->get(self::$key . 'pause-image');
            if (empty($pause)) {
                $pause = $params->get(self::$key . 'pause');
                if ($pause == -1) {
                    $pause = null;
                } elseif ($pause[0] != '$') {
                    $pause = N2Uri::pathToUri(dirname(__FILE__) . '/image/pause/' . $pause);
                }
            }
        }

        if ($play && $pause) {

            N2CSS::addFile(N2Filesystem::translate(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'image' . DIRECTORY_SEPARATOR . 'style.css'), $id);

            N2JS::addFile(N2Filesystem::translate(dirname(__FILE__) . '/image/autoplay.js'), $id);

            list($displayClass, $displayAttributes) = self::getDisplayAttributes($params, self::$key);

            $styleClass = N2StyleRenderer::render($params->get(self::$key . 'style'), 'heading', $slider->elementId, 'div#' . $slider->elementId . ' ');


            list($style, $attributes) = self::getPosition($params, self::$key);


            N2JS::addInline('new NextendSmartSliderWidgetAutoplayImage("' . $id . '", ' . floatval($params->get(self::$key . 'responsive-desktop')) . ', ' . floatval($params->get(self::$key . 'responsive-tablet')) . ', ' . floatval($params->get(self::$key . 'responsive-mobile')) . ');');

            $html = NHtml::tag('div', $displayAttributes + $attributes + array(
                    'class' => $displayClass . $styleClass . 'nextend-autoplay nextend-autoplay-image',
                    'style' => $style
                ), NHtml::image(N2ImageHelper::fixed($play), '', array('class' => 'nextend-autoplay-play')) . NHtml::image(N2ImageHelper::fixed($pause), '', array('class' => 'nextend-autoplay-pause')));
        }

        return $html;
    }

    public static function prepareExport($export, $params) {
        $export->addImage($params->get(self::$key . 'play-image', ''));
        $export->addImage($params->get(self::$key . 'pause-image', ''));

        $export->addVisual($params->get(self::$key . 'style'));
    }

    public static function prepareImport($import, $params) {

        $params->set(self::$key . 'play-image', $import->fixImage($params->get(self::$key . 'play-image', '')));
        $params->set(self::$key . 'pause-image', $import->fixImage($params->get(self::$key . 'pause-image', '')));

        $params->set(self::$key . 'style', $import->fixSection($params->get(self::$key . 'style', '')));
    }

}

N2Plugin::addPlugin('sswidgetautoplay', 'N2SSPluginWidgetAutoplayImage');
class N2SSPluginWidgetAutoplayImageBlue extends N2SSPluginWidgetAutoplayImage
{

    var $_name = 'imageBlue';

    static function getDefaults() {
        return array_merge(N2SSPluginWidgetAutoplayImage::getDefaults(), array(
            'widget-autoplay-position-area' => 11,
            'widget-autoplay-style'         => 'eyJuYW1lIjoiU3RhdGljIiwiZGF0YSI6W3siYmFja2dyb3VuZGNvbG9yIjoiMDAwMDAwYWIiLCJwYWRkaW5nIjoiMTB8KnwxMHwqfDEwfCp8MTB8KnxweCIsImJveHNoYWRvdyI6IjB8KnwwfCp8MHwqfDB8KnwwMDAwMDBmZiIsImJvcmRlciI6IjB8Knxzb2xpZHwqfDAwMDAwMGZmIiwiYm9yZGVycmFkaXVzIjoiMyIsImV4dHJhIjoiIn0seyJiYWNrZ3JvdW5kY29sb3IiOiIwMGMxYzRmZiJ9XX0='
        ));
    }
}

N2Plugin::addPlugin('sswidgetautoplay', 'N2SSPluginWidgetAutoplayImageBlue');
