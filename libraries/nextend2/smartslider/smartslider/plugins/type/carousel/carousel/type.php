<?php
/**
* @author    Roland Soos
* @copyright (C) 2015 Nextendweb.com
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Restricted access');
?><?php

class N2SmartSliderTypeCarousel extends N2SmartSliderType
{

    public function getDefaults() {
        return array(
            'slide-width'            => 600,
            'slide-height'           => 400,
            'background-color'       => 'dee3e6ff',
            'background'             => '',
            'background-size'        => 'cover',
            'background-fixed'       => 0,
            'animation'              => 'horizontal',
            'animation-duration'     => 800,
            'animation-delay'        => 0,
            'animation-easing'       => 'easeOutQuad',
            'carousel'               => 1,
            'border-width'           => 0,
            'border-color'           => '3E3E3Eff',
            'border-radius'          => 0,
            'slide-background-color' => 'ffffff',
            'slide-border-radius'    => 0
        );
    }

    protected function renderType() {

        $params = $this->slider->params;

        N2JS::addFiles(N2Filesystem::translate(dirname(__FILE__) . "/gsap"), array(
            "Type.js",
            "Responsive.js",
            "MainAnimation.js"
        ), "smartslider-carousel-type-frontend");

        $background = $params->get('background');
        $css        = $params->get('slider-css');
        if (!empty($background)) {
            $css = 'background-image: url(' . N2ImageHelper::fixed($background) . ');';
        }

        echo $this->openSliderElement();
        ?>
        <div class="n2-ss-slider-1" style="<?php echo $css; ?>">
            <div class="n2-ss-slider-2">
                <div class="n2-ss-slider-pane">
                    <?php
                    echo $this->slider->staticHtml;
                    ?>
                    <?php
                    foreach ($this->slider->slides AS $i => $slide) {
                        echo NHtml::tag('div', array('class' => 'n2-ss-slide-group ' . $slide->classes), NHtml::tag('div', $slide->attributes + array(
                                'class' => 'n2-ss-slide ' . $slide->classes . ' n2-ss-canvas',
                                'style' => $slide->style . $params->get('slide-css')
                            ), $slide->background . $slide->getHTML()));
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
        $this->widgets->echoRemainder();
        echo NHtml::closeTag('div');


        $this->javaScriptProperties['mainanimation'] = array(
            'type'     => $params->get('animation'),
            'duration' => intval($params->get('animation-duration')),
            'delay'    => intval($params->get('animation-delay')),
            'ease'     => $params->get('animation-easing')
        );

        $this->javaScriptProperties['carousel']     = intval($params->get('carousel'));
        $this->javaScriptProperties['maxPaneWidth'] = intval($params->get('maximum-pane-width'));

        $this->javaScriptProperties['parallax']['enabled'] = 0;

        N2Plugin::callPlugin('nextendslider', 'onNextendSliderProperties', array(&$this->javaScriptProperties));

        N2JS::addFirstCode("new NextendSmartSliderCarousel(n2('#{$this->slider->elementId}'), " . json_encode($this->javaScriptProperties) . ");");

        echo NHtml::clear();
    }
}