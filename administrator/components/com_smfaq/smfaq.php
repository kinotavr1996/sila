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

if (!JFactory::getUser()->authorise('core.manage', 'com_smfaq')) {
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
	return;
}
// Подключаем библеотеку контроллера Joomla
jimport('joomla.application.component.controller');
// Получаем экземпляр класса контроллера с префиксом SmFAQ
$controller = JControllerLegacy::getInstance('SmFAQ');

// Обрабатываем запрос (task)
$controller->execute(JFactory::getApplication()->input->get('task'));
// Переадресуем, если установлено контроллером
$controller->redirect();
