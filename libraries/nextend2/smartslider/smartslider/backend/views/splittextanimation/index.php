<?php
/**
* @author    Roland Soos
* @copyright (C) 2015 Nextendweb.com
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Restricted access');
?><?php
/**
 * @var $model N2SystemAnimationModel
 */

$sets = $model->getSets();

$animations = array();
foreach ($sets AS $set) {
    $animations[$set['id']] = $model->getVisuals($set['id']);
}

N2JS::addFirstCode("
    new NextendSplitTextAnimationManager({
        setsIdentifier: '" . $model->type . "set',
        sets: " . json_encode($sets) . ",
        visuals: " . json_encode($animations) . ",
        ajaxUrl: '" . $this->appType->router->createAjaxUrl(array('splittextanimation/index')) . "'
    });
");
?>
    <div class="n2-form-tab ">
        <div class="n2-heading-controls n2-content-box-title-bg">
            <div class="n2-table">
                <div class="n2-tr">
                    <div class="n2-td n2-h2" style="white-space: nowrap">
                        <?php n2_e('Split text settings'); ?>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <?php
            $model->renderForm();
            ?>
        </div>
    </div>

    <div class="n2-form-tab n2-editor-preview-box">
        <div class="n2-heading-controls n2-content-box-title-bg">
            <div class="n2-table n2-table-fixed">
                <div class="n2-tr">
                    <div class="n2-td n2-h2">
                        <?php n2_e('Preview'); ?>
                    </div>

                    <div class="n2-td n2-last n2-visual-editor-preview-tab">
                        <div class="n2-editor-background-color">
                            <div style="" class="n2-form-element-text n2-form-element-color n2-border-radius">
                                <div class="sp-replacer">
                                    <div class="sp-preview">
                                        <div class="sp-preview-inner"></div>
                                    </div>
                                    <div class="sp-dd">▲</div>
                                </div>
                                <input type="text" autocomplete="off" class="n2-h5" value="ced3d5"
                                       name="n2-splittextanimation-editor-background-color"
                                       id="n2-splittextanimation-editor-background-color">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="n2-splittextanimation-editor-preview">
        </div>
    </div>

<?php
$model->renderFormExtra();
?>