<?php
/**
* @author    Roland Soos
* @copyright (C) 2015 Nextendweb.com
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Restricted access');
?><?php
N2Loader::import('libraries.form.element.list');

class N2ElementJReviewsCategories extends N2ElementList
{

    function fetchElement() {

        $db = JFactory::getDBO();

        $query = 'SELECT asset_id FROM #__categories WHERE id IN
                    (SELECT id FROM j_jreviews_categories WHERE `option` = \'com_content\' AND criteriaid IN
                      (SELECT id FROM #__jreviews_criteria WHERE state <> 0))';

        $db->setQuery($query);
        $ratableItems = $db->loadColumn();

        $query = 'SELECT title, asset_id, id, parent_id FROM #__categories';
        $db->setQuery($query);
        $allItems = $db->loadObjectList();
        $children = array();
        if ($allItems) {
            foreach ($allItems as $v) {
                $pt   = $v->parent_id;
                $list = isset($children[$pt]) ? $children[$pt] : array();
                array_push($list, $v);
                $children[$pt] = $list;
            }
        }

        $this->_xml->addChild('option', htmlspecialchars(n2_('All')))
                   ->addAttribute('value', '0');

        jimport('joomla.html.html.menu');
        $options = JHTML::_('menu.treerecurse', 0, '', array(), $children, 9999, 0, 0);
        if (count($options)) {
            foreach ($options AS $option) {
                if (in_array($option->asset_id, $ratableItems)) {
                    $this->_xml->addChild('option', htmlspecialchars($option->treename))
                               ->addAttribute('value', $option->asset_id);
                }
            }
        }
        return parent::fetchElement();
    }

}
