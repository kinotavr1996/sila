<?php
/**
* @author    Roland Soos
* @copyright (C) 2015 Nextendweb.com
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Restricted access');
?><?php

N2Loader::import('libraries.form.element.list');

class N2ElementMijoShopManufacturers extends N2ElementList
{

    function fetchElement() {

        $model = new N2Model("mijoshop_manufacturer");

        $query = 'SELECT manufacturer_id AS id, name FROM #__mijoshop_manufacturer ORDER BY sort_order, id';

        $manufacturers = $model->db->queryAll($query, false, "object");

        $this->_xml->addChild('option', htmlspecialchars(n2_('All')))
                   ->addAttribute('value', 0);
        if (count($manufacturers)) {
            foreach ($manufacturers AS $manufacturer) {
                $this->_xml->addChild('option', htmlspecialchars($manufacturer->name))
                           ->addAttribute('value', $manufacturer->id);
            }
        }
        return parent::fetchElement();
    }

}
