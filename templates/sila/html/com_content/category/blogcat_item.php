<?php
defined('_JEXEC') or die;

// Create a shortcut for params.
$params = $this->item->params;
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
$canEdit = $this->item->params->get('access-edit');
$info    = $params->get('info_block_position', 0);
$images = json_decode($this->item->images);
$lang = JFactory::getLanguage();
$lang = explode('-',$lang->getTag()); //example output format: en-GB
$firstLetter = mb_substr($this->item->title,0,1, 'UTF-8');
		if($firstLetter == 'Д'){
			$firstLetterClass = d;
		}elseif($firstLetter == 'К'){
			$secondLetterClass = d;
			$firstLetterClass = k;
		}elseif($firstLetter == 'Р'){
			$firstLetterClass = p;
			$secondLetterClass = k;
		}else{
			$firstLetterClass = h;
			$secondLetterClass = k;

		}

$url = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language));
//var_dump($firstLetter);
?>

		<div class="l-paralax-row _leter _letter_<?php 	echo $secondLetterClass; ?>">
			<div class="l-main-product__letter l-main-product__letter_<?php echo $firstLetterClass; ?> <?php 	echo $lang[0]; ?>">
			</div>
		</div>

		<div class="l-main-product-wrap">
				<div class="l-main-product-col _img">
					<div class="c-main-product-media">
						<div class="<?php echo "c-main-product-media__img l-paralax-row media_1"?>">
							<img onclick="location.href='<?php echo  $url?>'" src="<?php $articl = json_decode($this->item->images);
											echo $tmpl_need.$articl->image_intro;
										?>" alt="">
						</div>
					</div>
				</div>
				<!--col-->
				<div class="l-main-product-col">
					<div class="c-main-product-txt">
						<div onclick="location.href='<?php echo  $url?>'" class="c-main-product-txt-title"><?php echo $this->item->title; ?> <i class="bounceInLeft wow animated"></i></div>
						<div class="c-main-product-txt-desc">
							<i class="bounceInLeft wow animated"></i>
							<?php echo $this->item->introtext; ?>
						</div>
						<a href="<?php echo $url ?>" class="c-main-product-txt-desc__link"><?php echo JText::_('TPL_SILV_PROD_READMORE');?></a>
					</div>
				</div>
				<!--col-->
				<div class="clear"></div>
			</div>