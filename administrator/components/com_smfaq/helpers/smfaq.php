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

/**
 * Smfaq helper
 *
 */
class SmFaqHelper
{
	/**
	 * Конфигурация доп меню
	 *
	 * @param	string	$vName	Имя вида.
	 */
	public static function addSubmenu($vName)
	{
	    if (version_compare(JVERSION, '3.0') >= 0) {
	        $class = 'JHtmlSidebar';
	    } else {
	        $class = 'JSubMenuHelper';
	    }
	    
		$class::addEntry(
			JText::_('COM_SMFAQ_QUESTIONS_MENU'),
			'index.php?option=com_smfaq&view=smfaqlist',
			$vName == 'smfaqlist'
		);
		$class::addEntry(
			JText::_('COM_SMFAQ_CATEGORY_MENU'),
			'index.php?option=com_categories&extension=com_smfaq',
			$vName == 'categories'
		);
		
		if ($vName == 'categories') {
			$doc = JFactory::getDocument();
			$doc->addStyleDeclaration('.icon-48-smfaq-categories {background: url("../media/com_smfaq/images/icon-48-smfaq-categories.png") no-repeat 10px 0 !important}');
			
		}
		
		$class::addEntry(
			JText::_('COM_SMFAQ_INFO'),
			'index.php?option=com_smfaq&view=info',
			$vName == 'info'
		);
		
	}

	/**
	 * Установка ACL
	 * @param unknown_type $categoryId
	 * @return JObject
	 */
	public static function getActions($categoryId = 0)
	{
		$user	= JFactory::getUser();
		$result	= new JObject;
		if (empty($categoryId)) {
			$assetName = 'com_smfaq';
		} else {
			$assetName = 'com_smfaq.category.'.(int) $categoryId;
		}
		
		$actions = array('core.create', 'core.edit', 'core.admin', 'core.manage');

		foreach ($actions as $action) {
			$result->set($action,	$user->authorise($action, $assetName));
		}

		return $result;
	}

}