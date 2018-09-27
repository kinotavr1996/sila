<?php 
	// No direct access
	defined('_JEXEC') or die;	
	$heading = $params->get('heading') ? JText::_($params->get('heading')) : JText::_('_SEO_HEADING');
	$intro = $params->get('intro') ? $params->get('intro') : '';
	$readmore = $params->get('readmore') ? $params->get('readmore') : '';

	$doc = JFactory::getDocument();
	$doc->addScriptDeclaration("
		jQuery(document).ready(function(){
			jQuery('.seo_readmore_btn').click(function(){
				event.preventDefault();
				if(jQuery('.c-main-desc__txt.readmore').css('display') == 'none'){
					jQuery('.c-main-desc__txt.readmore').slideDown();
					jQuery('.seo_readmore_btn').addClass('open');
					jQuery('.seo_readmore_btn').text('".JText::_('MOD_SOME_TEXT_CLOSE')."');
				}else{
					jQuery('.c-main-desc__txt.readmore').slideUp();
					jQuery('.seo_readmore_btn').text('".JText::_('MOD_SOME_TEXT_READMORE')."');
					jQuery('.seo_readmore_btn').removeClass('open');
				}
			});
		});
	");
?>

<div class="c-main-desc">
	<div class="l-wrap">
		<?php if($params->get('h1') == 1): ?>
			<h1 class="c-main-desc__title"><?php echo $heading; ?></h1>
		<?php else: ?>
			<h2 class="c-main-desc__title" style="font-size: 16px"><?php echo $heading; ?></h2>
		<?php endif; ?>
		<div class="c-main-desc__txt"><?php echo $intro; ?></div>
		<div class="c-main-desc__txt readmore"><?php echo $readmore; ?></div>
		<?php if(!empty($readmore)): ?>
		<a href="#" class="seo_readmore_btn"><span><?php echo JText::_('MOD_SOME_TEXT_READMORE'); ?></span></a>
		<?php endif; ?>
	</div>
</div>
