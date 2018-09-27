<?php
defined('_JEXEC') or die;

class JoomlycallbackViewList extends JViewLegacy
{
	public function display($tpl = null)
	{
		$document	= JFactory::getDocument();
		$document->addStyleSheet('components/com_joomlycallback/css/list.css');
		$document->addStyleSheet('https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css');
		$model=$this->getModel();
		$jinput = JFactory::getApplication()->input;
		$CurrentPage = $jinput->get('page', 1);
		$PreviousPage = $CurrentPage-1;
		$NextPage = $CurrentPage+1;
		$MaxPage=$model->getMaxPage();
		if ($CurrentPage>$MaxPage){
			$CurrentPage = $MaxPage;
		}
		$offset = ($CurrentPage-1)*10;

		$list=$model->getList($offset);

		$this->assignRef('list', $list);
		$this->assignRef('MaxPage', $MaxPage);

		$this->assignRef('PreviousPage', $PreviousPage);
		$this->assignRef('NextPage', $NextPage);
		$this->assignRef('CurrentPage', $CurrentPage);

		parent::display($tpl);
		$this->addToolbar();
	}
	
	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{

		JToolBarHelper::title(JText::_('COM_JOOMLYCALLBACK_FEEDBACKS_LIST'));

	}
		
}
