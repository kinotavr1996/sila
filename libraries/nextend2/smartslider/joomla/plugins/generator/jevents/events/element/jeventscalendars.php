<?php
/**
* @author    Roland Soos
* @copyright (C) 2015 Nextendweb.com
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Restricted access');
?><?php

N2Loader::import('libraries.form.element.list');

class N2ElementJEventsCalendars extends N2ElementList
{

    function fetchElement() {
        $model     = new N2Model('jevents_icsfile');
        $query     = "SELECT ics_id, label FROM #__jevents_icsfile WHERE state = '1'";
        $calendars = $model->db->queryAll($query, false, "object");

        $this->_xml->addChild('option', htmlspecialchars(n2_('All')))
                   ->addAttribute('value', 0);
        if (count($calendars)) {
            foreach ($calendars AS $calendar) {
                $this->_xml->addChild('option', htmlspecialchars($calendar->label))
                           ->addAttribute('value', $calendar->ics_id);
            }
        }
        return parent::fetchElement();
    }

}
