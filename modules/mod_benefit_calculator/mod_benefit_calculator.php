<?php
/**
 * @copyright	Copyright © 2018 - All rights reserved.
 * @license		GNU General Public License v2.0
 * @generator	http://xdsoft/joomla-module-generator/
 */
defined('_JEXEC') or die;

$doc = JFactory::getDocument();
/* Available fields:"first_month","second_month","third_month","fourth_month","fifth_month","six_month","project_cost","procent_for_investor_from_the_project","estimated_profitability_of_the_project","project_start","project_end","project_info", */
// Include assets
$doc->addStyleSheet(JURI::root()."modules/mod_benefit_calculator/assets/css/style.css");
$doc->addScript(JURI::root()."modules/mod_benefit_calculator/assets/js/script.js");
// $width 			= $params->get("width");

/**
	$db = JFactory::getDBO();
	$db->setQuery("SELECT * FROM #__mod_benefit_calculator where del=0 and module_id=".$module->id);
	$objects = $db->loadAssocList();
*/
require JModuleHelper::getLayoutPath('mod_benefit_calculator', $params->get('layout', 'default'));