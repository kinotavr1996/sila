<?php

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
// ------------ Start Canonical-Mod
$mainmenu =& JSite::getMenu();
if($mainmenu->getActive()!== $mainmenu->getDefault()) :
	$document = JFactory::getDocument();
	$livesite = substr_replace(JURI::root(), '', -1, 1);

	$docpagenr = '';
	$docstart = JRequest::getInt('start',0);
	if($docstart>0) :
		// Если хотим чтобы в канонической ссылке прописывалась постраничная разбивка типа start=10..., то раскомментируем сроку ниже. В противном случае будет индексироваться только главная страница категории
		//$docpagenr = '?start='.$docstart;
	endif;

	$docroute = JRoute::_(ContentHelperRoute::getCategoryRoute($this->category->id));

	$document->addHeadLink($livesite . $docroute . $docpagenr, 'canonical', 'rel', '');
endif;
// ------------ End Canonical-Mod

JHtml::_('behavior.caption');
$document = JFactory::getDocument();
$renderer = $document->loadRenderer('modules');
$options = array('style' => 'xhtml');
$position = 'position_bread';
?>
<div class="l-content">

	<div class="l-wrap">
		<h1 class="c-title-big"><?php echo $this->category->title; ?></h1>
		<?php	 echo $renderer->render($position, $options, null);	?>
	</div>

	<div class="l-content-inner">
		<div class="l-wrap">
		
		
			<div class="c-main-product _page">
				<div class="l-wrap">
					<?php $leadingcount = 0; ?>
					<?php if (!empty($this->lead_items)) : ?>
					<div class="l-main-product-item _0">

						<?php foreach ($this->lead_items as &$item) : ?>
							<?php

							$this->item = & $item;
							echo $this->loadTemplate('item');
							?>
							<?php $leadingcount++; ?>							
							<div class="c-main-product-item__num"><?php echo "0".($leadingcount)?><i>.</i></div>
						<?php endforeach; ?>
					</div>
					<?php endif; ?>

					<?php
					$introcount = (count($this->intro_items));
					$counter = 1;
					?>
					<?php if (!empty($this->intro_items)) : ?>
						<?php foreach ($this->intro_items as $key => &$item) : ?>
							<?php $rowcount = ((int) $key % (int) $this->columns) + 1; ?>
							<div class="l-main-product-item <?php echo '_'.$counter; ?> <?php echo ($key % 2 == 0)? '_right': ''; ?>">
								<?php
								$this->item = & $item;
								echo $this->loadTemplate('item');
								?>
								<?php $counter++; ?>
								<div class="c-main-product-item__num"><?php echo "0".($key+2)?><i>.</i></div>
							</div>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</div>
			<div class="c-main-desc">

				<div class="c-main-desc__title"><?php echo $this->category->title; ?></div>
				<div class="c-main-desc__txt">
					<?php echo JHtml::_('content.prepare', $this->category->description, '', 'com_content.category'); ?>
				</div>
			</div>
		</div>
	</div>
</div>
