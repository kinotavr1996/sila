<?php

defined('_JEXEC') or die;
$tmpl_need = JUri::base() . "templates/brilliant_new/";
$tmpl_need = "";
$Root = $_SERVER["DOCUMENT_ROOT"];
require_once($Root . DIRECTORY_SEPARATOR . "components" . DIRECTORY_SEPARATOR . "com_content" . DIRECTORY_SEPARATOR . "models" . DIRECTORY_SEPARATOR . "category.php");
require_once($Root . DIRECTORY_SEPARATOR . "components" . DIRECTORY_SEPARATOR . "com_content" . DIRECTORY_SEPARATOR . "models" . DIRECTORY_SEPARATOR . "articles.php");

?>
<div class="c-main-product">
    <div class="l-wrap">
        <?php
        $lang = JFactory::getLanguage();
        $category_id = ($lang->getTag() == ('en-GB')) ? 8 : 11;
        $model = JModelLegacy::getInstance('Articles', 'ContentModel');
        $model->setState('filter.category_id', $category_id); // Set category ID here
        $articles = $model->getItems();
        $i = 0;


        foreach ($articles as $article):
            $letter = mb_substr($article->title, 0, 1, "UTF-8");
            $lang_tag = mb_substr($lang->getTag(), 0, 2);

        if($lang_tag == 'en') {
            switch ($letter) {
                case('Д'):
                    $letter = 'd';
                    $num = '01';
                    $lang_tag .= '/products/26-doska12';
                    break;
                case('Ч'):
                    $letter = 'h';
                    $num = '02';
                    $lang_tag .= '/products/24-chmz';
                    break;
                case('К'):
                    $letter = 'k';
                    $num = '03';
                    $lang_tag .= '/products/23-kruglyak';
                    break;
                case('Р'):
                    $letter = 'p';
                    $num = '04';
                    $lang_tag .= '/products/25-rejka';
                    break;
            }
        }
        else {
            switch ($letter) {
                case('Д'):
                    $letter = 'd';
                    $num = '01';
                    $lang_tag .= '/products/18-doska1';
                    break;
                case('Ч'):
                    $letter = 'h';
                    $num = '02';
                    $lang_tag .= '/products/20-chmz';
                    break;
                case('К'):
                    $letter = 'k';
                    $num = '03';
                    $lang_tag .= '/products/21-kruglyak';
                    break;
                case('Р'):
                    $letter = 'p';
                    $num = '04';
                    $lang_tag .= '/products/19-rejka';
                    break;

            }
        }

            ?>

            <div class="l-main-product-item<?php echo ($i % 2 == 0) ? '' : ' _right' ?> <?php echo '_'.$i; ?>">

                <div class="l-paralax-row _leter _letter_<?php echo $letter ?> <?php echo $lang_tag.' '.'_'.$i ?>">
                    <div class="l-main-product__letter l-main-product__letter_<?php echo $letter ?> <?php echo $lang_tag.' '.'_'.$i ?>"></div>
                </div>

                <div class="l-main-product-wrap">
                    <div class="l-main-product-col _img">
                        <div class="c-main-product-media">
                            <a href= "<?php echo JRoute::_('index.php?view=article&catid='.catid.'&id='.$article->id); ?>" class="<?php echo "c-main-product-media__img l-paralax-row media_" . ($i + 1) ?>">
                                <img src="<?php $articl = json_decode($article->images);
                                echo $tmpl_need . $articl->image_intro;
                                ?>" alt="">
                            </a>
                        </div>
                    </div>
                    <!--col-->
                    <div class="l-main-product-col">
                        <div class="c-main-product-txt">
                            <a href= "<?php echo JRoute::_('index.php?view=article&catid='.catid.'&id='.$article->id); ?>" class="c-main-product-txt-title"><?php echo $article->title; ?> <i
                                    class="bounceInLeft wow animated"></i></a>
                            <div class="c-main-product-txt-desc">
                                <i class="bounceInLeft wow animated"></i>
                                <?php echo $article->introtext; ?>
                            </div>
                            <a href="<?php echo JRoute::_('index.php?view=article&catid='.catid.'&id='.$article->id); ?>"
                               class="c-main-product-txt-desc__link"><?php echo JText::_('TPL_SILV_PROD_READMORE'); ?></a>
                        </div>
                    </div>
                    <!--col-->
                    <div class="clear"></div>
                </div>
                <!--l-main-product-wrap-->
                <div class="c-main-product-item__num"><?php echo "0" . ($i + 1) ?><i>.</i></div>
            </div>
            <!--l-main-product-item-->


            <?php $i++; endforeach; ?>
        <!--l-main-product-item-->
    </div>
    <!--l-main-product-item-->
</div>



<!--wrap-->

