<?php
/**
* @author    Roland Soos
* @copyright (C) 2015 Nextendweb.com
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Restricted access');
?><?php

class N2SmartSliderFeatureAlign
{

    private $slider;

    public $align = 'normal';

    public function __construct($slider) {

        $this->slider = $slider;

        $this->align = $slider->params->get('align', 'normal');
    }

    public function renderSlider($sliderHTML, $maxWidth) {
        $aligned = false;

        $htmlOptions = array(
            "class"  => "n2-ss-align",
            "encode" => false
        );

        if (!$this->slider->features->responsive->scaleUp && $this->align != 'normal') {
            switch ($this->align) {
                case 'left':
                case 'right':
                    $htmlOptions["style"] = "float: {$this->align};";
                    break;
                case 'center':
                    $htmlOptions["style"] = "margin: 0 auto; max-width: {$maxWidth}px;";
                    break;
            }
            $aligned = true;
        }

        $sliderHTML = NHtml::tag("div", $htmlOptions, NHtml::tag("div", array('class' => 'n2-padding'), $sliderHTML));

        if ($aligned == true) {
            $sliderHTML .= NHtml::tag("div", array("style" => "clear: both"), "");
        }

        return $sliderHTML;
    }
}