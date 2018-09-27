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
// Подключаем библеотеку контроллера Joomla
jimport('joomla.application.component.controller');

/**
 * Основной контроллер
 */
class SmFAQController extends JControllerLegacy
{
	/**
	 * Отображаем задачу
	 * Параметр $cachable устанавливает использовать или нет кэш
	 */
	public function display($cachable = false, $urlparams = array())
	{
		// устанавка вида по умолчанию
		$app = JFactory::getApplication();
		$app->input->set('view', $app->input->get('view', 'SmfaqList'));
		
		//подключение стилей
		$document = JFactory::getDocument();
		$document->addStyleSheet(JURI::root(true).'/administrator/components/com_smfaq/css/smfaq.css');

		parent::display($cachable, $urlparams);
	}
}

