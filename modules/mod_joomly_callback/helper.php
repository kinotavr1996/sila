<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_joomly_callback
 *
 * @copyright   Copyright (C) 2015 Artem Yegorov. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Helper for mod_joomly_callback
 *
 * @package     Joomla.Site
 * @subpackage  mod_joomly_callback
 * @since       1.1.0
 */
class ModJoomlyCallbackHelper
{
	public static function getFields()
	{
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('params')
		->from('#__modules')
		->where('module="mod_joomly_callback"');
		$db->setQuery($query);
		$array =  $db->loadAssoc();
		$fields =  json_decode($array['params']); 
				
		return $fields;
	}
	
	public static function getWeekdays(){
		$weekdays = array();
		$weekdays[0] = JText::_('MOD_JOOMLY_CALLBACK_SUNDAY');	
		$weekdays[1] = JText::_('MOD_JOOMLY_CALLBACK_MONDAY');	
		$weekdays[2] = JText::_('MOD_JOOMLY_CALLBACK_TUESDAY');	
		$weekdays[3] = JText::_('MOD_JOOMLY_CALLBACK_WEDNESDAY');	
		$weekdays[4] = JText::_('MOD_JOOMLY_CALLBACK_THURSDAY');	
		$weekdays[5] = JText::_('MOD_JOOMLY_CALLBACK_FRIDAY');	
		$weekdays[6] = JText::_('MOD_JOOMLY_CALLBACK_SATURDAY');	
		
		return $weekdays; 		
	}	
}