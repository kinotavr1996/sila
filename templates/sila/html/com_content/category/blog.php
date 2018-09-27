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

	$docroute = JRoute::_(ContentHelperRoute::getCategoryRoute($this->parent->id));

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
		<?php	echo $renderer->render($position, $options, null);	?>
	</div>

	<div class="l-content-inner">
		<div class="l-wrap l-blog">

			<?php $leadingcount = 0; ?>
			<?php if (!empty($this->lead_items)) : ?>
				<div class="l-blog-item">
					<?php foreach ($this->lead_items as &$item) : ?>
						<?php
						$this->item = & $item;
						echo $this->loadTemplate('item');
						?>
						<?php $leadingcount++; ?>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<?php
			$introcount = (count($this->intro_items));
			$counter = 0;
			?>

			<?php if (!empty($this->intro_items)) : ?>
				<?php foreach ($this->intro_items as $key => &$item) : ?>
					<?php $rowcount = ((int) $key % (int) $this->columns) + 1; ?>
					<div class="l-blog-item <?php echo ($key % 2 == 0)? '_right': '' ?>">
						<?php
						$this->item = & $item;
						echo $this->loadTemplate('item');
						?>
						<?php $counter++; ?>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>


		</div>
		<?php /*
		<div class="l-wrap">
			<div class="l-blog-nav">
				<a href="" class="c-blog__nav _left"><?php echo JText::_('COM_CONTENT_PREV'); ?></a><a href="" class="c-blog__nav _right"><?php echo JText::_('COM_CONTENT_NEXT'); ?></a>
				<div class="clear"></div>
			</div>
		</div>
		*/ ?>
		<?php if (($this->params->def('show_pagination', 1) == 1 || ($this->params->get('show_pagination') == 2)) && ($this->pagination->get('pages.total') > 1)) : ?>
			<div class="pagination">
				<?php if ($this->params->def('show_pagination_results', 1)) : ?>
					<p class="counter pull-right"> <?php echo $this->pagination->getPagesCounter(); ?> </p>
				<?php endif; ?>
				<?php echo $this->pagination->getPagesLinks(); ?> </div>
		<?php endif; ?>
	</div>
	</div>
