<?php
/**
* @author    Roland Soos
* @copyright (C) 2015 Nextendweb.com
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Restricted access');
?><?php
N2Loader::import('libraries.plugins.N2SliderWidgetAbstract', 'smartslider');

class N2SSPluginWidgetArrowReveal extends N2SSPluginWidgetAbstract
{

    private static $key = 'widget-arrow-';

    var $_name = 'reveal';

    static function getDefaults() {
        return array(
            'widget-arrow-previous-position-mode'   => 'simple',
            'widget-arrow-previous-position-area'   => 6,
            'widget-arrow-previous-position-offset' => 0,
            'widget-arrow-next-position-mode'       => 'simple',
            'widget-arrow-next-position-area'       => 7,
            'widget-arrow-next-position-offset'     => 0,
            'widget-arrow-font'                     => '',
            'widget-arrow-background'               => '00000080',
            'widget-arrow-title-show'               => 0,
            'widget-arrow-title-font'               => 'eyJuYW1lIjoiU3RhdGljIiwiZGF0YSI6W3siY29sb3IiOiJmZmZmZmZmZiIsInNpemUiOiIxMnx8cHgiLCJ0c2hhZG93IjoiMHwqfDB8KnwwfCp8MDAwMDAwZmYiLCJhZm9udCI6Ik1vbnRzZXJyYXQiLCJsaW5laGVpZ2h0IjoiMS4zIiwiYm9sZCI6MCwiaXRhbGljIjowLCJ1bmRlcmxpbmUiOjAsImFsaWduIjoibGVmdCIsImV4dHJhIjoiIn0se31dfQ==',
            'widget-arrow-title-background'         => '000000cc',
            'widget-arrow-animation'                => 'slide',
            'widget-arrow-previous'                 => '$ss$/plugins/widgetarrow/reveal/reveal/previous/simple-horizontal.svg',
            'widget-arrow-mirror'                   => 1,
            'widget-arrow-next'                     => '$ss$/plugins/widgetarrow/reveal/reveal/next/simple-horizontal.svg'
        );
    }


    function onArrowList(&$list) {
        $list[$this->_name] = $this->getPath();
    }

    function getPath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR . 'reveal' . DIRECTORY_SEPARATOR;
    }

    static function getPositions(&$params) {
        $positions = array();

        $positions['previous-position'] = array(
            self::$key . 'previous-position-',
            'previous'
        );

        $positions['next-position'] = array(
            self::$key . 'next-position-',
            'next'
        );
        return $positions;
    }

    static function render($slider, $id, $params) {

        list($hex, $RGBA) = N2Color::colorToCss($params->get(self::$key . 'background'));
        list($titleHex, $titleRGBA) = N2Color::colorToCss($params->get(self::$key . 'title-background'));

        N2LESS::addFile(N2Filesystem::translate(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'reveal' . DIRECTORY_SEPARATOR . 'style.less'), $slider->cacheId, array(
            "sliderid"            => $slider->elementId,
            "arrowBackgroundHex"  => $hex ? '#' . $hex : 'transparent',
            "arrowBackgroundRGBA" => $RGBA,
            "titleBackgroundHex"  => $titleHex ? '#' . $titleHex : 'transparent',
            "titleBackgroundRGBA" => $titleRGBA
        ), NEXTEND_SMARTSLIDER_ASSETS . '/less' . NDS);

        N2JS::addFile(N2Filesystem::translate(dirname(__FILE__) . '/reveal/arrow.js'), $id);

        $previous = $params->get(self::$key . 'previous');
        if ($params->get(self::$key . 'mirror')) {
            $next = str_replace('reveal/previous/', 'reveal/next/', $previous);
        } else {
            $next = $params->get(self::$key . 'next');
        }

        $fontClass = N2FontRenderer::render($params->get(self::$key . 'title-font'), 'simple', $slider->elementId, 'div#' . $slider->elementId . ' ', $slider->fontSize);

        $animation      = $params->get(self::$key . 'animation');
        $animationClass = ' n2-ss-arrow-animation-' . $animation;

        $html = '';
        $html .= self::getHTML($slider, $id, $params, 'previous', N2ImageHelper::fixed($previous), $fontClass, $animationClass);
        $html .= self::getHTML($slider, $id, $params, 'next', N2ImageHelper::fixed($next), $fontClass, $animationClass);

        $images = array();
        $titles = array();
        foreach ($slider->slides AS $slide) {
            $images[] = $slide->getThumbnail();
            $titles[] = $slide->getTitle();
        }

        N2JS::addInline('new NextendSmartSliderWidgetArrowReveal("' . $id . '","' . $animation . '", ' . json_encode($images) . ', ' . json_encode($titles) . ');');

        return $html;
    }

    /**
     * @param N2SmartSlider $slider
     * @param               $id
     * @param               $params
     * @param               $side
     * @param               $icon
     * @param               $fontClass
     * @param               $animationClass
     *
     * @return string
     */
    private static function getHTML($slider, $id, &$params, $side, $icon, $fontClass, $animationClass) {

        list($displayClass, $displayAttributes) = self::getDisplayAttributes($params, self::$key);

        list($style, $attributes) = self::getPosition($params, self::$key . $side . '-');

        switch ($side) {
            case 'previous':
                $image = $slider->getPreviousSlide()
                                ->getThumbnail();
                $title = $slider->getPreviousSlide()
                                ->getTitle();
                break;
            case 'next':
                $image = $slider->getNextSlide()
                                ->getThumbnail();
                $title = $slider->getNextSlide()
                                ->getTitle();
                break;
        }

        return NHtml::tag('div', $displayAttributes + $attributes + array(
                'id'    => $id . '-arrow-' . $side,
                'class' => $displayClass . 'nextend-arrow n2-ib nextend-arrow-reveal nextend-arrow-' . $side . $animationClass,
                'style' => $style
            ), NHtml::tag('div', array(
                'class' => ' nextend-arrow-image',
                'style' => 'background-image: url(' . $image . ');'
            ), $params->get(self::$key . 'title-show') ? NHtml::tag('div', array(
                'class' => $fontClass . ' nextend-arrow-title'
            ), $title) : '') . NHtml::tag('div', array(
                'class' => 'nextend-arrow-arrow',
                'style' => 'background-image: url(' . $icon . ');'
            ), ''));
    }

    public static function prepareExport($export, $params) {
        $export->addVisual($params->get(self::$key . 'title-font'));
    }

    public static function prepareImport($import, $params) {

        $params->set(self::$key . 'title-font', $import->fixSection($params->get(self::$key . 'title-font', '')));
    }
}

N2Plugin::addPlugin('sswidgetarrow', 'N2SSPluginWidgetArrowReveal');
