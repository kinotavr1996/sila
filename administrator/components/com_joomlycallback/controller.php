<?php

defined('_JEXEC') or die;

class JoomlycallbackController extends JControllerLegacy
{

	public function display($cachable = false, $urlparams = false)
	{

		$document	= JFactory::getDocument();
		$jinput = JFactory::getApplication()->input;
		$vName = $jinput->get('view', 'list');
		$vFormat = $document->getType();
		$view = $this->getView($vName, $vFormat);
		$model = $this->getModel($vName);
		$view->setModel($model, true);
		$view->display();
		
	}
	
	public function	deleteFeed()
	{
		
		$jinput = JFactory::getApplication()->input;
		$id= $jinput->get('delete_id', 1);
		$db = JFactory::getDbo();
		$query= "DELETE FROM #__joomly_callback WHERE `id` = {$id}";
		$db->setQuery($query);
		$result = $db->execute();
	}
}
