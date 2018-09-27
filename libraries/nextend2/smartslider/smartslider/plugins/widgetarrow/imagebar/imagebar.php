<?php
/**
* @author    Roland Soos
* @copyright (C) 2015 Nextendweb.com
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Restricted access');
?><?php
N2Loader::import('libraries.plugins.N2SliderWidgetAbstract', 'smartslider');

class N2SSPluginWidgetArrowImageBar extends N2SSPluginWidgetAbstract
{

    private static $key = 'widget-arrow-';

    var $_name = 'imagebar';

    static function getDefaults() {
        return array(
            'widget-arrow-previous-position-mode'   => 'simple',
            'widget-arrow-previous-position-area'   => 2,
            'widget-arrow-previous-position-offset' => 0,
            'widget-arrow-next-position-mode'       => 'simple',
            'widget-arrow-next-position-area'       => 4,
            'widget-arrow-next-position-offset'     => 0,
            'widget-arrow-width'                    => 100,
            'widget-arrow-previous'                 => '$ss$/plugins/widgetarrow/imagebar/imagebar/previous/simple-horizontal.svg',
            'widget-arrow-mirror'                   => 1,
            'widget-arrow-next'                     => '$ss$/plugins/widgetarrow/imagebar/imagebar/next/simple-horizontal.svg'
        );
    }


    function onArrowList(&$list) {
        $list[$this->_name] = $this->getPath();
    }

    function getPath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR . 'imagebar' . DIRECTORY_SEPARATOR;
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
        N2CSS::addFile(N2Filesystem::translate(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'imagebar' . DIRECTORY_SEPARATOR . 'style.css'), $id);

        N2JS::addFile(N2Filesystem::translate(dirname(__FILE__) . '/imagebar/arrow.js'), $id);

        $previous = $params->get(self::$key . 'previous');
        if ($params->get(self::$key . 'mirror')) {
            $next = str_replace('imagebar/previous/', 'imagebar/next/', $previous);
        } else {
            $next = $params->get(self::$key . 'next');
        }

        $html = '';
        $html .= self::getHTML($slider, $id, $params, 'previous', N2ImageHelper::fixed($previous));
        $html .= self::getHTML($slider, $id, $params, 'next', N2ImageHelper::fixed($next));

        $images = array();
        foreach ($slider->slides AS $slide) {
            $images[] = $slide->getThumbnail();
        }

        N2JS::addInline('new NextendSmartSliderWidgetArrowImageBar("' . $id . '", ' . json_encode($images) . ');');

        return $html;
    }

    /**
     * @param N2SmartSlider $slider
     * @param               $id
     * @param               $params
     * @param               $side
     *
     * @return string
     */
    private static function getHTML($slider, $id, &$params, $side, $icon) {

        list($displayClass, $displayAttributes) = self::getDisplayAttributes($params, self::$key);

        list($style, $attributes) = self::getPosition($params, self::$key . $side . '-');

        switch ($side) {
            case 'previous':
                $image = $slider->getPreviousSlide()
                                ->getThumbnail();
                break;
            case 'next':
                $image = $slider->getNextSlide()
                                ->getThumbnail();
                break;
        }

        $style .= 'width: ' . intval($params->get(self::$key . 'width')) . 'px';

        return NHtml::tag('div', $displayAttributes + $attributes + array(
                'id'    => $id . '-arrow-' . $side,
                'class' => $displayClass . 'nextend-arrow nextend-arrow-imagebar nextend-arrow-' . $side,
                'style' => $style
            ), NHtml::tag('div', array(
                'class' => 'nextend-arrow-image',
                'style' => 'background-image: url(' . $image . ');'
            ), '') . NHtml::tag('div', array(
                'class' => 'nextend-arrow-arrow',
                'style' => 'background-image: url(' . $icon . ');'
            ), ''));
    }
}

N2Plugin::addPlugin('sswidgetarrow', 'N2SSPluginWidgetArrowImageBar');
