<?php
/**
* @author    Roland Soos
* @copyright (C) 2015 Nextendweb.com
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Restricted access');
?><?php

N2Loader::import('libraries.form.element.list');

class N2ElementEShopTags extends N2ElementList
{

    function fetchElement() {

        $model = new N2Model("eshop_manufacturers");

        $query = 'SELECT tag_name, id
                  FROM #__eshop_tags
                  ORDER BY id';

        $tags = $model->db->queryAll($query, false, "object");

        $this->_xml->addChild('option', htmlspecialchars(n2_('All')))
                   ->addAttribute('value', 0);
        if (count($tags)) {
            foreach ($tags AS $tag) {
                $this->_xml->addChild('option', htmlspecialchars($tag->tag_name))
                           ->addAttribute('value', $tag->id);
            }
        }
        return parent::fetchElement();
    }

}
