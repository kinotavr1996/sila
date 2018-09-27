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

class N2GeneratorRSEventsProEvents extends N2GeneratorAbstract
{

    private function formatDate($datetime, $dateOrTime = 0) {
        switch ($dateOrTime) {
            case 0:
                $dot = 'Y-m-d';
                break;
            case 1:
                $dot = 'H:i:s';
                break;
        }
        if ($dateOrTime == 1 || $datetime != '0000-00-00 00:00:00') {
            return date($dot, strtotime($datetime));
        } else {
            return '0000-00-00';
        }
    }

    protected function _getData($count, $startIndex) {
        require_once(JPATH_SITE . '/components/com_rseventspro/helpers/rseventspro.php');
        require_once(JPATH_SITE . '/components/com_rseventspro/helpers/route.php');

        $categories = array_map('intval', explode('||', $this->data->get('sourcecategories', '')));
        $groups     = array_map('intval', explode('||', $this->data->get('sourcegroups', '')));
        $tags       = array_map('intval', explode('||', $this->data->get('sourcetags', '')));
        $locations  = array_map('intval', explode('||', $this->data->get('sourcelocations', '')));

        $model = new N2Model('rseventspro_events');

        $where = array('published = 1');

        if (!in_array('0', $categories)) {
            $where[] = "id IN (SELECT ide FROM #__rseventspro_taxonomy WHERE id IN (" . implode(', ', $categories) . ") AND type = 'category')";
        }

        if (!in_array('0', $groups)) {
            $where[] = "id IN (SELECT ide FROM #__rseventspro_taxonomy WHERE id IN (" . implode(', ', $groups) . ") AND type = 'groups')";
        }

        if (!in_array('0', $tags)) {
            $where[] = "id IN (SELECT ide FROM #__rseventspro_taxonomy WHERE id IN (" . implode(', ', $tags) . ") AND type = 'tag')";
        }

        if (!in_array('0', $locations)) {
            $where[] = "location IN (" . implode(', ', $locations) . ")";
        }

        $today = date('Y-m-d h:i:s', time());

        switch ($this->data->get('started', '0')) {
            case 1:
                $where[] = "start < '" . $today . "'";
                break;
            case -1:
                $where[] = "start >= '" . $today . "'";
                break;
        }

        switch ($this->data->get('ended', '-1')) {
            case 1:
                $where[] = "end < '" . $today . "'";
                break;
            case -1:
                $where[] = "end >= '" . $today . "'";
                break;
        }

        switch ($this->data->get('allday', '0')) {
            case 1:
                $where[] = "allday = 1";
                break;
            case -1:
                $where[] = "allday = 0";
                break;
        }

        switch ($this->data->get('recurring', '0')) {
            case 1:
                $where[] = "recurring = 1";
                break;
            case -1:
                $where[] = "recurring = 0";
                break;
        }

        $query = 'SELECT * FROM #__rseventspro_events WHERE ' . implode(' AND ', $where) . ' ';

        $order = N2Parse::parse($this->data->get('rseventsproorder', 'start|*|asc'));
        if ($order[0]) {
            $query .= 'ORDER BY ' . $order[0] . ' ' . $order[1] . ' ';
        }

        $query .= 'LIMIT ' . $startIndex . ', ' . $count;

        $result = $model->db->queryAll($query);

        $data = array();
        $root = N2Uri::getBaseUri();
        foreach ($result AS $res) {
            $r = array(
                'title'       => $res['name'],
                'description' => $res['description']
            );

            $res['icon'] = 'components/com_rseventspro/assets/images/events/' . $res['icon'];

            $r['image'] = $r['thumbnail'] = NextendImageFallBack::fallback($root . "/", array(
                @$res['icon']
            ), array(
                @$res['description']
            ));

            $r += array(
                'start_date'      => $this->formatDate($res['start']),
                'start_time'      => $this->formatDate($res['start'], 1),
                'end_date'        => $this->formatDate($res['end']),
                'end_time'        => $this->formatDate($res['end'], 1),
                'url'             => rseventsproHelper::route('index.php?option=com_rseventspro&layout=show&id=' . rseventsproHelper::sef($res['id'], $res['name']), true, RseventsproHelperRoute::getEventsItemid()),
                'created'         => $res['created'],
                'website'         => $res['URL'],
                'email'           => $res['email'],
                'phone'           => $res['phone'],
                'metaname'        => $res['metaname'],
                'metakeywords'    => $res['metakeywords'],
                'metadescription' => $res['metadescription'],
                'hits'            => $res['hits'],
                'id'              => $res['id']
            );
            $data[] = $r;
        }
        return $data;
    }
}
