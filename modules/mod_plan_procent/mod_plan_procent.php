<?php
/**
 * @copyright	Copyright © 2018 - All rights reserved.
 * @license		GNU General Public License v2.0
 * @generator	http://xdsoft/joomla-module-generator/
 */
defined('_JEXEC') or die;

$doc = JFactory::getDocument();
/* Available fields:"procent_per_year","invest_sum","income","your_decision", */
// Include assets
$doc->addStyleSheet(JURI::root()."modules/mod_plan_procent/assets/css/style.css");
$doc->addScript(JURI::root()."modules/mod_plan_procent/assets/js/script.js");
// $width 			= $params->get("width");

/**
	$db = JFactory::getDBO();
	$db->setQuery("SELECT * FROM #__mod_plan_procent where del=0 and module_id=".$module->id);
	$objects = $db->loadAssocList();
*/
require JModuleHelper::getLayoutPath('mod_plan_procent', $params->get('layout', 'default'));