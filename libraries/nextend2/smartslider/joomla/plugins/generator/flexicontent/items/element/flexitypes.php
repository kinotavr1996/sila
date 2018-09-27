<?php
/**
* @author    Roland Soos
* @copyright (C) 2015 Nextendweb.com
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Restricted access');
?><?php

N2Loader::import('libraries.form.element.list');

class N2ElementFlexiTypes extends N2ElementList
{

    function fetchElement() {

        $db = JFactory::getDBO();

        $query = 'SELECT id, name FROM #__flexicontent_types WHERE published = 1 ORDER BY id';

        $db->setQuery($query);
        $menuItems = $db->loadObjectList();

        if (count($menuItems)) {
            foreach ($menuItems AS $option) {
                $this->_xml->addChild('option', htmlspecialchars($option->name))
                           ->addAttribute('value', $option->id);
            }
            if ($this->getValue() == '') {
                $this->setValue($menuItems[0]->id);
            }
        }
        return parent::fetchElement();
    }

}
