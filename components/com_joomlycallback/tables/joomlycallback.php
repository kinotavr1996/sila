<?php

defined('_JEXEC') or die('Restricted access');

class TableJoomlycallback extends JTable
{

	var $id = null;
	var $created_at = null;
  function __construct(&$db)
  {
    parent::__construct('#__joomly_callback', 'id', $db);
  }
}
?>