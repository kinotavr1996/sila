<?php
/**
* @author    Roland Soos
* @copyright (C) 2015 Nextendweb.com
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Restricted access');
?><?php

N2Loader::import('libraries.slider.generator.NextendSmartSliderGeneratorAbstract', 'smartslider');
require_once(dirname(__FILE__) . '/../../imagefallback.php');

class N2GeneratorHikaShopProducts extends N2GeneratorAbstract
{

    function getPrice($pid, $tax_id = 0) {
        $arr                    = array();
        $arr[0]                 = new stdClass();
        $arr[0]->product_id     = $pid;
        $arr[0]->product_tax_id = $tax_id;
        $currencyClass          = hikashop_get('class.currency');
        $zone                   = hikashop_getZone();
        $cur                    = hikashop_getCurrency();
        $currencyClass->getListingPrices($arr, $zone, $cur);
        $i         = 0;
        $currPrice = 0;
        if (isset($arr[0]->prices)) {
            foreach ($arr[0]->prices as $k => $price) {
                if (!$i) {
                    $currPrice = $price->price_value_with_tax;
                }
                if ($price->price_value_with_tax < $currPrice) $currPrice = $price->price_value_with_tax;
                $i++;
            }
            return $currencyClass->format($currPrice, $cur);
        } else {
            return '';
        }
    }

    function url($id, $alias, $itemID) {
        $url = 'index.php?option=com_hikashop&ctrl=product&task=show&cid=' . $id;
        if (!empty($alias)) {
            $url .= '&name=' . $alias;
        }
        if (!empty($itemID) && $itemID != 0) {
            $url .= '&Itemid=' . $itemID;
        }
        return $url;
    }

    protected function _getData($count, $startIndex) {
        require_once(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_hikashop' . DS . 'helpers' . DS . 'helper.php');

        $categories = array_map('intval', explode('||', $this->data->get('hikashopcategories', '')));
        $brands     = array_map('intval', explode('||', $this->data->get('hikashopbrands', '0')));
        $tags       = array_map('intval', explode('||', $this->data->get('hikashoptags', '0')));
        $warehouses = array_map('intval', explode('||', $this->data->get('hikashopwarehouses', '0')));

        $model = new N2Model('hikashop_products');

        $where = array(
            "p.product_published = 1 "
        );

        if (!in_array(0, $categories) && count($categories) > 0) {
            $where[] = "p.product_id IN (SELECT product_id FROM #__hikashop_product_category WHERE category_id IN (" . implode(',', $categories) . "))";
        }

        if (!in_array(0, $brands) && count($brands) > 0) {
            $where[] = "p.product_manufacturer_id IN (" . implode(',', $brands) . ")";
        }

        if (!in_array(0, $tags)) {
            $where[] = 'p.product_id IN (SELECT content_item_id FROM #__contentitem_tag_map WHERE type_alias = \'com_hikashop.product\' AND tag_id IN (' . implode(',', $tags) . ')) ';
        }

        if (!in_array(0, $warehouses) && count($warehouses) > 0) {
            $where[] = "p.product_warehouse_id IN (" . implode(',', $warehouses) . ")";
        }

        $query = "SELECT * FROM #__hikashop_product AS p LEFT JOIN #__hikashop_file AS f ON p.product_id = f.file_ref_id WHERE " . implode(' AND ', $where);

        $query .= " GROUP BY p.product_id ";

        $order = N2Parse::parse($this->data->get('hikashopproductsorder', 'p.product_created|*|desc'));
        if ($order[0]) {
            $query .= 'ORDER BY ' . $order[0] . ' ' . $order[1];
        }

        $query .= ' LIMIT ' . $startIndex . ', ' . $count;

        $result = $model->db->queryAll($query);

        $data = array();
        $url  = JURI::root(false);
        for ($i = 0; $i < count($result); $i++) {
            $r = array(
                'title'       => $result[$i]['product_name'],
                'url'         => $this->url($result[$i]['product_id'], $result[$i]['product_alias'], $this->data->get('hikashopitemid', '0')),
                'description' => $result[$i]['product_description']
            );

            $r['image'] = NextendImageFallBack::fallback($url, array(
                !empty($result[$i]['file_path']) ? 'media/com_hikashop/upload/' . $result[$i]['file_path'] : '',
            ), array(
                @$r['description']
            ));

            if (!empty($result[$i]['file_path'])) {
                $r['thumbnail'] = str_replace('media/com_hikashop/upload/', 'media/com_hikashop/upload/thumbnails/100x100/', $r['image']);
            } else {
                $r['thumbnail'] = $r['image'];
            }

            $r += array(
                'price'                    => $this->getPrice($result[$i]['product_id'], $result[$i]['product_tax_id']),
                'price_without_tax'        => $this->getPrice($result[$i]['product_id']),
                'product_code'             => $result[$i]['product_code'],
                'hits'                     => $result[$i]['product_hit'],
                'brand_url'                => $result[$i]['product_url'],
                'product_weight'           => $result[$i]['product_weight'],
                'product_weight_unit'      => $result[$i]['product_weight_unit'],
                'product_keywords'         => $result[$i]['product_keywords'],
                'product_meta_description' => $result[$i]['product_meta_description'],
                'product_width'            => $result[$i]['product_width'],
                'product_length'           => $result[$i]['product_length'],
                'product_height'           => $result[$i]['product_height'],
                'product_dimension_unit'   => $result[$i]['product_dimension_unit'],
                'product_sales'            => $result[$i]['product_sales'],
                'product_average_score'    => $result[$i]['product_average_score'],
                'product_total_vote'       => $result[$i]['product_total_vote'],
                'product_page_title'       => $result[$i]['product_page_title'],
                'product_alias'            => $result[$i]['product_alias'],
                'product_price_percentage' => $result[$i]['product_price_percentage'],
                'product_msrp'             => $result[$i]['product_msrp'],
                'product_canonical'        => $result[$i]['product_canonical'],
                'product_id'               => $result[$i]['product_id']
            );
            $data[] = $r;
        }
        return $data;
    }
}
