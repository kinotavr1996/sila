<?php

defined('_JEXEC') or die;

JHtml::_('stylesheet', 'mod_languages/template.css', array(), true);

if ($params->get('dropdown', 1) && !$params->get('dropdownimage', 0))
{
	JHtml::_('formbehavior.chosen');
}
?>

	<ul class="c-header__lang">
	<?php foreach ($list as $language) : ?>
		<?php if ($params->get('show_active', 0) || !$language->active) : ?>
			<li class="<?php echo $language->active ? 'lang-active' : 'lang'; ?>" dir="<?php echo $language->rtl ? 'rtl' : 'ltr'; ?>">
			<a href="<?php echo $language->link; ?>">
				<?php echo $params->get('full_name', 1) ? $language->title_native : strtoupper($language->sef); ?>
			</a>
			</li>
		<?php endif; ?>
	<?php endforeach; ?>
	</ul>
