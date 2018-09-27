<?php
/**
* @author    Roland Soos
* @copyright (C) 2015 Nextendweb.com
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Restricted access');
?><?php

N2Loader::import('libraries.form.element.list');

class N2ElementCobaltTypes extends N2ElementList
{

    function fetchElement() {
        $model = new N2Model("js_res_types");
        $query = "SELECT
            id,
            name
            FROM #__js_res_types
            ORDER BY name ASC
            ";

        $types = $model->db->queryAll($query, false, "object");

        if (count($types)) {
            foreach ($types AS $option) {
                $this->_xml->addChild('option', htmlspecialchars($option->name))
                           ->addAttribute('value', $option->id);
            }
            if ($this->getValue() == '') {
                $this->setValue($types[0]->id);
            }
        }

        return parent::fetchElement();
    }
}
