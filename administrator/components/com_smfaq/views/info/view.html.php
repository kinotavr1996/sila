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
// Подключаем библиотеку представления Joomla
jimport('joomla.application.component.view');

/**
 * Вид для отображения списка записей
 *
 */
class SmFAQViewInfo extends JViewLegacy {

	/**
	 * Метод для отображения вида
	 */
	public function display($tpl = null)
	{
		$data = JApplicationHelper::parseXMLInstallFile(JPATH_COMPONENT.'/smfaq.xml');
		
		$this->assignRef('data', $data);
		
		require_once JPATH_COMPONENT.'/helpers/smfaq.php';
		SmFaqHelper::addSubmenu($this->_name);

		parent::display($tpl);
		
	}

}

