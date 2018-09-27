<?php
defined('_JEXEC') or die;

// Create a shortcut for params.
$params = $this->item->params;
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
$canEdit = $this->item->params->get('access-edit');
$info    = $params->get('info_block_position', 0);
$images = json_decode($this->item->images);
$document = & JFactory::getDocument();
$document->setMetadata('robots', 'noindex, nofollow');
?>
<?php if (isset($images->image_intro) and !empty($images->image_intro)) : ?>
<div class="l-blog-col">
	<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language)); ?>" class="c-blog__img">
		<img title="<?php echo htmlspecialchars($images->image_intro_caption); ?>" src="<?php echo htmlspecialchars($images->image_intro); ?>" alt="<?php echo htmlspecialchars($images->image_intro_alt); ?>" />
	</a>
</div>
<?php endif; ?>
<div class="l-blog-col l-blog-info">
		<div class="c-blog__date">
			<?php echo JText::sprintf(JHtml::_('date', $this->item->publish_up, JText::_('DATA_FORMAT_DAY'))); ?>
		</div>
		
		<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language)); ?>" class="c-blog__name">
				<span><?php echo $this->item->title; ?></span>
		</a>
		
		<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language)); ?>" class="c-blog__more">
			<?php echo JText::_('COM_CONTENT_LINK_NEWS');?>
		</a>
</div>
<div class="clear"></div>
