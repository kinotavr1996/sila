<?php
/**
 * SMFAQ
 *
 * @package		Component for Joomla 2.5.6+
 * @version		1.7.3
 * @copyright	(C)2009 - 2013 by SmokerMan (http://joomla-code.ru)
 * @license		GNU/GPL v.3 see http://www.gnu.org/licenses/gpl.html
 */

// защита от прямого доступа
defined('_JEXEC') or die('@-_-@');
// Подключаем Тулбар
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('dropdown.init');
JHtml::_('formbehavior.chosen', 'select');


$user	= JFactory::getUser();

$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
$saveOrder	= $listOrder == 'a.ordering';
$n = count($this->items);

if ($saveOrder)
{
    $saveOrderingUrl = 'index.php?option=com_smfaq&task=smfaqlist.saveOrderAjax&tmpl=component';
    JHtml::_('sortablelist.sortable', 'articleList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}
?>

<script type="text/javascript">
	Joomla.orderTable = function()
	{
		table = document.getElementById("sortTable");
		direction = document.getElementById("directionTable");
		order = table.options[table.selectedIndex].value;
		if (order != '<?php echo $listOrder; ?>')
		{
			dirn = 'asc';
		}
		else
		{
			dirn = direction.options[direction.selectedIndex].value;
		}
		Joomla.tableOrdering(order, dirn, '');
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_smfaq'); ?>" method="post" name="adminForm" id="adminForm">
    <div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
	<div id="filter-bar" class="btn-toolbar">
	
		<div class="filter-search btn-group pull-left">
			<label for="filter_search" class="element-invisible"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
			<input type="text" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('JSEARCH_FILTER'); ?>" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_SMFAQ_SEARCH_IN_TITLE'); ?>" />
    	</div>
		<div class="btn-group pull-left hidden-phone">
			<button type="submit" class="btn hasTooltip" title="<?php echo JHtml::tooltipText('JSEARCH_FILTER_SUBMIT'); ?>"><i class="icon-search"></i></button>
			<button type="button" class="btn hasTooltip" title="<?php echo JHtml::tooltipText('JSEARCH_FILTER_CLEAR'); ?>" onclick="document.id('filter_search').value='';this.form.submit();"><i class="icon-remove"></i></button>
		</div>
	</div>
	
	<table class="table table-striped" id="articleList">
		<thead>
		<tr>
		<th width="1%" class="nowrap center hidden-phone">
			<?php echo JHtml::_('grid.sort', '<i class="icon-menu-2"></i>', 'a.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING'); ?>
		</th>		
        <th width="20">
        	<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
        </th>                     
        <th width="40%">
        	<?php echo JHtml::_('grid.sort',  'COM_SMFAQ_FIELD_QUESTION_LABEL', 'a.question', $listDirn, $listOrder); ?>
        </th>
        <th width="10%">
        	<?php echo JHtml::_('grid.sort',  'COM_SMFAQ_FIELD_CREATED_LABEL', 'a.created', $listDirn, $listOrder); ?>
        </th>
        <th>
        	<?php echo JHtml::_('grid.sort',  'COM_SMFAQ_FIELD_AUTHOR_LABEL', 'a.created_by', $listDirn, $listOrder); ?>
        </th>
        
        <th width="5%">
			<?php echo JHtml::_('grid.sort',  'JPUBLISHED', 'a.published', $listDirn, $listOrder); ?>
		</th>
		
		<th width="10%">
			<?php echo JHtml::_('grid.sort', 'JCATEGORY', 'category', $listDirn, $listOrder); ?>
		</th>
		<th width="10%">
			<?php echo JHtml::_('grid.sort', 'COM_SMFAQ_FIELD_ANSWER_STATE_LABEL', 'a.answer_state', $listDirn, $listOrder); ?>
		</th>
		
		<th width="10%">
			<?php echo JText::_('COM_SMFAQ_VOTE_LABEL'); ?>
		</th>
		
		
        <th width="5">
        	<?php echo JHtml::_('grid.sort',  'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
        </th>

		</tr>
		</thead>
		<tbody>
		<?php if ($this->items): ?>
			<?php foreach($this->items as $i => $item): 
				$ordering	= ($listOrder == 'a.ordering');
				$canCheckin	= $user->authorise('core.manage', 'com_checkin') || $item->checked_out==$user->get('id') || $item->checked_out==0;
				$canEdit	= $user->authorise('core.edit',	'com_smfaq.category.'.$item->catid);
				?>
		        <tr class="row<?php echo $i % 2; ?>">
					<td class="order nowrap center hidden-phone">
						<?php
						if (!$saveOrder)
						{
						    $iconClass = ' inactive tip-top hasTooltip" title="' . JHtml::tooltipText('JORDERINGDISABLED');
							
						} else {
                            $iconClass = ' inactive';    
                        }

						?>
						<span class="sortable-handler<?php echo $iconClass ?>">
							<i class="icon-menu"></i>
						</span>
						<?php if ($saveOrder) : ?>
							<input type="text" style="display:none" name="order[]" size="5" value="<?php echo $item->ordering; ?>" class="width-20 text-area-order " />
						<?php endif; ?>
					</td>		        
	                <td class="center">
	                	<?php echo JHtml::_('grid.id', $i, $item->id); ?>
	                </td>
	                <td>
	                	<?php if ($item->checked_out) : ?>
						<?php echo JHtml::_('jgrid.checkedout', $i, '', $item->checked_out_time, 'SMFAQlist.', $canCheckin); ?>
						<?php endif; ?>
						<?php if ($canEdit) : ?>
		                	<a href="<?php echo JRoute::_('index.php?option=com_smfaq&task=smfaq.edit&id=' . $item->id); ?>">
		                    	<?php echo $this->escape($item->question); ?>
		                    </a>
						<?php else : ?>
								<?php echo $this->escape($item->question); ?>
						<?php endif; ?>
	                    
	                </td>
					<td class="center">
						<?php echo JHTML::_('date',$item->created, JText::_('COM_SMFAQ_DATE_FORMAT')); ?>
					</td>
					<td class="center">
					<?php if ($item->user_id) :?>
						<strong><?php echo $this->escape($item->created_by); ?></strong>
					<?php else :?>
						<?php echo $this->escape($item->created_by); ?>
					<?php endif; ?>
						<br />
						<a title="<?php echo JText::_('COM_SMFAQ_LOOK_IP'); ?>" href="http://www.ripe.net/perl/whois?searchtext=<?php echo $this->escape($item->ip); ?>" target="_blank"><?php echo $this->escape($item->ip); ?></a>
					</td>
					<td class="center">
						<?php echo JHtml::_('jgrid.published', $item->published, $i, 'smfaqlist.', true, 'cb', null, null); ?>
					</td>
					<td align="center">
						<?php echo $item->category; ?>
					</td>
					<td class="center">
						<?php switch ($item->answer_state) {
							default:
							case 0: 
								echo '<span style="color:#FF5F5F;">' . JText::_('COM_SMFAQ_ANSWER_STATE_WAITING') . '</span>';
								break;
							case 1:
								echo '<span style="color:#3FFF7D;">' . JText::_('COM_SMFAQ_ANSWER_STATE_YES') . '</span>';
								break;
							case 2:
								echo '<span style="color:#4F7EFF;">' . JText::_('COM_SMFAQ_ANSWER_STATE_NO') . '</span>';
								break;
						}?>
					</td>

	                <td class="center">
	                	<?php if ($item->vote_yes || $item->vote_no): ?>
	                	<span class="vote-yes-smfaq"><?php echo $item->vote_yes; ?></span>
	                	<span class="vote-no-smfaq"><?php echo $item->vote_no; ?></span>
	                	<?php else: ?>
	                	-
	                	<?php endif; ?>
	                	<?php if ($item->comments) : ?>
	                	<div><?php echo JText::sprintf('COM_SMFAQ_COMMENTS', $item->comments);?></div>
	                	<?php endif; ?>
 	                </td>
					
	                <td>
	                	<?php echo $item->id; ?>
	                </td>
						                
		        </tr>
			<?php endforeach; ?>
		<?php else : ?>
			<tr>
			<td colspan="11" align="center"><strong><?php echo JText::_('COM_SMFAQ_NON_ITEMS'); ?></strong></td>
			</tr>
		<?php endif; ?>
	</tbody>
	</table>
	    <?php echo $this->pagination->getListFooter(); ?>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />		
		<?php echo JHTML::_('form.token'); ?>
    </div>
</form>
