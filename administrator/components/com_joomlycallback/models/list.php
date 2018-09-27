<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class JoomlycallbackModelList extends JModelLegacy
{	
	function getList($offset){
		$query= "SELECT * FROM #__joomly_callback  WHERE 1 ORDER BY id DESC LIMIT {$offset},10";
		$this->_db->setQuery($query);
		$this->list = $this->_db->loadObjectList();
		
		return $this->list;
	}
	
	function getMaxPage(){
		$query= "SELECT count(*) FROM #__joomly_callback  WHERE 1";
		$this->_db->setQuery($query);
		$count = $this->_db->loadResult();
		$MaxPage = ceil($count/10);
		$MaxPage = ceil($count/10) == 0 ? 1 : ceil($count/10);
			
		return $MaxPage;	
	}
	
	
	
}
