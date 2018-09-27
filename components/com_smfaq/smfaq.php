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
require_once JPATH_COMPONENT.'/helpers/route.php';

$dispatcher = JDispatcher::getInstance();
$dispatcher->register('onSmfaqAfterDisplay', 'clink');
function clink() {
	return base64_decode('PGRpdiBjbGFzcz0ic21mYXEtY29weSI+cG93ZXJlZCBieSA8YSBocmVmPSJodHRwOi8vam9vbWxhLWNvZGUucnUiPnNtZmFxPC9hPjwvZGl2Pg==');
}
$dispatcher->register('onSmfaqAfterSend', 'test');
function test() {
	$res['msg'] = func_get_args();
	die(json_encode($res));
}

$controller	= JControllerLegacy::getInstance('SmFaq');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();

