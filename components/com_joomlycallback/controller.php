<?php

defined('_JEXEC') or die;

class JoomlycallbackController extends JControllerLegacy
{

	public function display($cachable = false, $urlparams = false)
	{

		$document	= JFactory::getDocument();
		$vName   = $this->input->getCmd('view', 'add');
		$vFormat = $document->getType();
		$view = $this->getView($vName, $vFormat);
		$model = $this->getModel($vName);
		$view->setModel($model, true);	
		$view->display();
		
	}
}
