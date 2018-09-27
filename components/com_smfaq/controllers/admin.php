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


jimport('joomla.application.component.controller');

class SmfaqControllerAdmin extends JControllerLegacy
{

	/**
	 * Метод для показа неопубликованых вопросов
	 * @return 
	 */
	public function show_unpublished()
	{
		// Проверка доступа
		$app = JFactory::getApplication();
		$catid = $app->input->get('catid', null, 'int');
		$user = JFactory::getUser();
		if (!$catid || $user->guest || !$user->authorise('core.edit', 'com_smfaq.category.'.$catid)) {
			$this->setError(JText::_('COM_SMFAQ_NOT_PERMITTED'));
			echo $this->getError();
			exit;
			return false;
				
		}
		$app->input->set('Itemid', $app->input->get('Itemid', null, 'int'));

		
		$model = $this->getModel('unpublished');
		$view = $this->getView('unpublished','html');
		$view->setModel($model, true);
		$view->display();

		exit;

	}
	
	/**
	 * TODO: Разобраться с authorise
	 */
	public function delcomment()
	{
		$user = JFactory::getUser();
		$id = JFactory::getApplication()->input->get('id', null, 'int');
		
		$db	= JFactory::getDBO();
		$query = ' SELECT catid FROM #__smfaq ' .
				 ' WHERE id = ' . (int) $id;
		
		$db->setQuery($query);
		if (!$db->query()) {
			$this->setError($db->stderr());
			echo $this->getError();
			exit;
		}
		
		$catid = (int) $db->loadResult();		
		
		if (!$user->authorise('core.edit', 'com_smfaq.category.'.$catid)) {
			$this->setError(JText::_('COM_SMFAQ_NOT_PERMITTED'));
			echo $this->getError();
			exit;
				
		}
		
		$query = ' DELETE FROM #__smfaq_comments ' .
				 ' WHERE id = ' . (int) $id;
		
		$db->setQuery($query);
		if (!$db->query()) {
			$this->setError($db->stderr());
			echo $this->getError();
			exit;
		}
		echo JText::_('COM_SMFAQ_COMMENT_DEL_OK');
		exit;
	}
	
}





