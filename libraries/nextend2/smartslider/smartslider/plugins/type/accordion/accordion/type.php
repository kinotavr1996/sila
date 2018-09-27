<?php
/**
* @author    Roland Soos
* @copyright (C) 2015 Nextendweb.com
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Restricted access');
?><?php

class N2SmartSliderTypeAccordion extends N2SmartSliderType
{

    public static function getItemDefaults() {
        return array(
            'align'  => 'left',
            'valign' => 'top'
        );
    }

    public function getDefaults() {
        return array(
            'orientation'         => 'horizontal',
            'carousel'            => 1,
            'outer-border'        => 6,
            'outer-border-color'  => '3E3E3Eff',
            'inner-border'        => 6,
            'inner-border-color'  => '222222ff',
            'border-radius'       => 6,
            'tab-normal-color'    => '3E3E3E',
            'tab-active-color'    => '87B801',
            'slide-margin'        => 2,
            'title-size'          => 30,
            'title-margin'        => 10,
            'title-border-radius' => 2,
            'title-font'          => 'eyJuYW1lIjoiU3RhdGljIiwiZGF0YSI6W3siZXh0cmEiOiJ0ZXh0LXRyYW5zZm9ybTogdXBwZXJjYXNlOyIsImNvbG9yIjoiZmZmZmZmZmYiLCJzaXplIjoiMTR8fHB4IiwidHNoYWRvdyI6IjB8KnwwfCp8MHwqfDAwMDAwMGZmIiwiYWZvbnQiOiJNb250c2VycmF0IiwibGluZWhlaWdodCI6IjEuMyIsImJvbGQiOjAsIml0YWxpYyI6MCwidW5kZXJsaW5lIjowLCJhbGlnbiI6ImxlZnQiLCJsZXR0ZXJzcGFjaW5nIjoibm9ybWFsIiwid29yZHNwYWNpbmciOiJub3JtYWwiLCJ0ZXh0dHJhbnNmb3JtIjoibm9uZSJ9LHsiZXh0cmEiOiIifV19',
            'animation-duration'  => 1000,
            'slider-outer-css'    => '',
            'slider-inner-css'    => 'box-shadow: 0 1px 3px 1px RGBA(0, 0, 0, .3) inset;',
            'slider-title-css'    => 'box-shadow: 0 0 0 1px RGBA(255, 255, 255, .05) inset, 0 0 2px 1px RGBA(0, 0, 0, .3);',
            'animation-easing'    => 'easeOutQuad'
        );
    }

    protected function renderType() {

        $params = $this->slider->params;

        N2JS::addFiles(N2Filesystem::translate(dirname(__FILE__) . "/gsap"), array(
            "TypeAccordion.js",
            "ResponsiveAccordion.js",
            "MainAnimationAccordion.js"
        ), "smartslider-accordion-type-frontend");

        echo $this->openSliderElement();

        echo NHtml::openTag('div', array(
            'class' => 'n2-ss-slider-1',
            'style' => $params->get('slider-outer-css')
        ));

        echo NHtml::openTag('div', array(
            'class' => 'n2-ss-slider-2',
            'style' => $params->get('slider-inner-css')
        ));

        echo $this->slider->staticHtml;

        foreach ($this->slider->slides AS $i => $slide) {
            ?>
            <div class="n2-ss-slide <?php echo $slide->classes; ?>">
                <?php
                $font = N2FontRenderer::render($params->get('title-font'), 'accordionslidetitle', $this->slider->elementId, 'div#' . $this->slider->elementId . ' ');

                echo NHtml::openTag('div', array(
                    'class' => 'n2-accordion-title ' . $font,
                    'style' => $params->get('slider-title-css')
                ));
                ?>
                <div class="n2-accordion-title-inner">
                    <div class="n2-accordion-title-rotate-90">
                        <?php echo $slide->getTitle(); ?>
                    </div>
                </div>
                <?php echo NHtml::closeTag('div'); ?>
                <div class="n2-accordion-slide" style="<?php echo $slide->style; ?>">
                    <?php
                    echo NHtml::tag('div', $slide->attributes + array(
                            'class' => 'n2-ss-canvas',
                        ), $slide->background . $slide->getHTML());
                    ?>
                </div>
            </div>
        <?php
        }

        echo NHtml::closeTag('div');
        echo NHtml::closeTag('div');

        $this->widgets->echoRemainder();
        echo NHtml::closeTag('div');

        $this->javaScriptProperties['carousel']      = $params->get('carousel');
        $this->javaScriptProperties['orientation']   = $params->get('orientation');
        $this->javaScriptProperties['mainanimation'] = array(
            'duration' => intval($params->get('animation-duration')),
            'ease'     => $params->get('animation-easing')
        );

        N2Plugin::callPlugin('nextendslider', 'onNextendSliderProperties', array(&$this->javaScriptProperties));

        N2JS::addFirstCode("new NextendSmartSliderAccordion(n2('#{$this->slider->elementId}'), " . json_encode($this->javaScriptProperties) . ");");

        echo NHtml::clear();
    }

    protected function getSliderClasses() {
        return parent::getSliderClasses() . 'n2-accordion-' . $this->slider->params->get('orientation', 'horizontal');
    }
}