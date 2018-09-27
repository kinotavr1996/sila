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


jimport('joomla.application.component.controllerform');

class SmfaqControllerEdit extends JControllerForm
{

	public function __construct($config = array())
	{

		$this->view_list = 'category';
		
		

		return parent::__construct($config);
	}

	
	public function add()
	{
		// Initialise variables.
		$app = JFactory::getApplication();
		$context = "$this->option.edit.$this->context";

		// Access check.
		if (!$this->allowAdd())
		{
			// Set the internal error and also the redirect error.
			$this->setError(JText::_('JLIB_APPLICATION_ERROR_CREATE_RECORD_NOT_PERMITTED'));
			$this->setMessage($this->getError(), 'error');

			$this->setRedirect(
				JRoute::_(
					'index.php?option=' . $this->option . '&view=' . $this->view_list
					. $this->getRedirectToListAppend(), false
				)
			);

			return false;
		}

		// Clear the record edit information from the session.
		$app->setUserState($context . '.data', null);
		
		$catid = $app->input->get('catid', null, 'int'); 

		// Redirect to the edit screen.
		$this->setRedirect(
			JRoute::_(
				'index.php?option=' . $this->option . '&view=' . $this->view_item
				.'&catid='.$catid.'&id=0'.$this->getRedirectToItemAppend(), false
			)
		);

		return true;
	}
		
	/* 
	 *	Проверка прав на добавление вопроса редактором
	 */
	protected function allowAdd($data = array())
	{
	    $app = JFactory::getApplication();
		$user 	= JFactory::getUser();
		$catId	=  $app->input->get('catid', null, 'int'); 
		$allow	= false;
		if (!$user->guest && $catId) {
			$allow = $user->authorise('core.edit', 'com_smfaq.category.'.$catId);
		}
	
		return $allow;
	}

	/*
	 *	Проверка прав на редактирование вопроса редактором
	 */	
	protected function allowEdit($data = array(), $urlVar = null)
	{
	    $app = JFactory::getApplication();
		$user 	= JFactory::getUser();
		$catid =  $app->input->get('catid', null, 'int'); 
		if ($user->guest || ($user->authorise('core.edit', 'com_smfaq.category.'.$catid) !== true)) {
			return false;
		}

		$record		= $this->getModel()->getItem($app->input->get($urlVar, null, 'int'));
		if ($user->authorise('core.edit', 'com_smfaq.category.'.$record->catid)) {
			return true;
		}

		return false;

	}

	/*
	*	Проверка прав на сохранение вопроса редактором
	*/	
	protected function allowSave($data, $key = 'id')
	{
		$user 	= JFactory::getUser();
		$catId	= JArrayHelper::getValue($data, 'catid', null, 'int');
		$allow		= false;
		if ($catId) {
			$allow = $user->authorise('core.edit', 'com_smfaq.category.'.$catId);
		}

		return $allow;
	}

	
	public function edit($key = 'id', $urlVar = 'id')
	{
	    $app = JFactory::getApplication();
		if (!$this->allowEdit(null, 'id')) {
			$this->setError(JText::_('JLIB_APPLICATION_ERROR_EDIT_NOT_PERMITTED'));
			$this->setMessage($this->getError(), 'error');
			
			$id = $app->input->get('id', null, 'int');
			$catid = $app->input->get('catid', null, 'int'); 
			$return = 'index.php?option=com_smfaq&task=edit.edit&id='.$id.'&catid='.$catid;
			$this->setRedirect(JRoute::_('index.php?option=com_users&task=login&return='.base64_encode($return)));
			return false;
		}
		parent::edit($key, $urlVar);
	}	
	
	protected function postSaveHook(JModelLegacy $model, $validData = array())
	{
		$task = $this->getTask();
		if ($task == 'save') {
			$this->setRedirect(JRoute::_(SmfaqHelperRoute::getCategoryRoute($validData['catid']), false));
		}
	}
	
	public function cancel($key = null) 
	{
		if (parent::cancel($key)) {
			$catid =  JFactory::getApplication()->input->get('catid', null, 'int');
			$this->setRedirect(JRoute::_(SmfaqHelperRoute::getCategoryRoute($catid), false));;
		}
	}
	
	protected function getRedirectToItemAppend($recordId = null, $urlVar = 'id')
	{
	    $app = JFactory::getApplication();
	    $tmpl = $app->input->get('tmpl');
		$layout =  $app->input->get('layout', 'edit'); 
		$catid =  $app->input->get('id', null, 'int'); 
		
		$append = '';
	
		// Setup redirect info.
		if ($tmpl)
		{
			$append .= '&tmpl=' . $tmpl;
		}
	
		if ($layout)
		{
			$append .= '&layout=' . $layout;
		}
	
		if ($recordId)
		{
			$append .= '&' . $urlVar . '=' . $recordId;
		}
		
		if ($catid)
		{
			$append .= '&catid=' . $catid;
		}		
	
		return $append;
	}	
}


