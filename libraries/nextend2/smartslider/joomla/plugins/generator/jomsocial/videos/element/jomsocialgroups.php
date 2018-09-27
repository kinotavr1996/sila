<?php
/**
* @author    Roland Soos
* @copyright (C) 2015 Nextendweb.com
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Restricted access');
?><?php

N2Loader::import('libraries.form.element.list');

class N2ElementJomSocialGroups extends N2ElementList
{

    function fetchElement() {

        $model = new N2Model('community_groups');

        $query  = "SELECT id, name FROM #__community_groups ORDER BY id";
        $groups = $model->db->queryAll($query, false, "object");

        $this->_xml->addChild('option', htmlspecialchars(n2_('All')))
                   ->addAttribute('value', 0);
        if (count($groups)) {
            foreach ($groups AS $group) {
                $this->_xml->addChild('option', htmlspecialchars($group->name))
                           ->addAttribute('value', $group->id);
            }
        }
        return parent::fetchElement();
    }
}