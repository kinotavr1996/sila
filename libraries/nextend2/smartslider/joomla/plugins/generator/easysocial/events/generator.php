<?php
/**
* @author    Roland Soos
* @copyright (C) 2015 Nextendweb.com
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Restricted access');
?><?php
N2Loader::import('libraries.slider.generator.N2SmartSliderGeneratorAbstract', 'smartslider');
require_once(dirname(__FILE__) . '/../../imagefallback.php');

class N2GeneratorEasySocialEvents extends N2GeneratorAbstract
{

    private function checkImage($url, $image) {
        if (isset($image)) {
            return N2ImageHelper::dynamic($url . $image);
        } else {
            return '';
        }
    }

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

        $model = new N2Model('EasySocial_Events');

        $where = array(
            "a.parent_id = 0",
            "a.cluster_type = 'event'",
            "a.state = '1'"
        );

        $category = array_map('intval', explode('||', $this->data->get('easysocialcategories', '')));

        if (!in_array('0', $category)) {
            $where[] = 'a.category_id IN (' . implode(',', $category) . ')';
        }

        $today = date('Y-m-d h:i:s', time());

        switch ($this->data->get('started', '0')) {
            case 1:
                $where[] = "b.start < '" . $today . "'";
                break;
            case -1:
                $where[] = "b.start >= '" . $today . "'";
                break;
        }

        switch ($this->data->get('ended', '-1')) {
            case 1:
                $where[] = "(b.end < '" . $today . "' AND b.end <> '0000-00-00 00:00:00')";
                break;
            case -1:
                $where[] = "(b.end >= '" . $today . "' OR b.end = '0000-00-00 00:00:00')";
                break;
        }

        switch ($this->data->get('allday', 0)) {
            case 1:
                $where[] = 'b.all_day = 1';
                break;
            case -1:
                $where[] = 'b.all_day = 0';
                break;
        }

        switch ($this->data->get('featured', 0)) {
            case 1:
                $where[] = 'a.featured = 1';
                break;
            case -1:
                $where[] = 'a.featured = 0';
                break;
        }

        $type = $this->data->get('eventtype', 0);
        if ($type != 0) {
            $where[] = 'a.type = ' . $type;
        }

        $location = $this->data->get('location', '*');
        if ($location != '*' && !empty($location)) {
            $where[] = "a.address = '" . $location . "'";
        }

        $query = "SELECT
                  a.title, a.description, a.address, a.longitude, a.latitude, a.created, a.alias, a.category_id, a.id, a.alias,
                  b.start, b.end,
                  c.small, c.medium, c.square, c.large, c.uid AS avatar_folder,
                  (SELECT value FROM #__social_photos_meta WHERE photo_id = d.id AND property = 'original') AS original_cover,
                  (SELECT value FROM #__social_photos_meta WHERE photo_id = d.id AND property = 'thumbnail') AS thumbnail_cover,
                  (SELECT value FROM #__social_photos_meta WHERE photo_id = d.id AND property = 'square') AS square_cover,
                  (SELECT value FROM #__social_photos_meta WHERE photo_id = d.id AND property = 'featured') AS featured_cover,
                  (SELECT value FROM #__social_photos_meta WHERE photo_id = d.id AND property = 'large') AS large_cover,
                  (SELECT value FROM #__social_photos_meta WHERE photo_id = d.id AND property = 'stock') AS stock_cover
                  FROM #__social_clusters AS a
                  LEFT JOIN #__social_events_meta AS b ON b.cluster_id = a.id
                  LEFT JOIN #__social_avatars AS c ON c.uid = a.id
                  LEFT JOIN #__social_photos AS d ON d.uid = a.id AND (d.album_id IN (SELECT id FROM #__social_albums WHERE title = 'COM_EASYSOCIAL_ALBUMS_PROFILE_COVER') OR d.album_id IS NULL)
                  WHERE " . implode(' AND ', $where) . "  ";

        $order = N2Parse::parse($this->data->get('easysocialorder', 'b.start|*|asc'));
        if ($order[0]) {
            $query .= 'ORDER BY ' . $order[0] . ' ' . $order[1] . ' ';
        }

        $query .= 'LIMIT ' . $startIndex . ', ' . $count;

        $result     = $model->db->queryAll($query);
        $root       = N2Uri::getBaseUri();
        $avatarRoot = $root . "/media/com_easysocial/avatars/event/";

        if (!class_exists('FRoute')) {
            if (file_exists(JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_easysocial' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'easysocial.php')) {
                require_once(JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_easysocial' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'easysocial.php');
            }
            require_once(JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_easysocial' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'router.php');
        }

        $urlOptions = array(
            'layout'   => 'item',
            'external' => false,
            'sef'      => true
        );

        $data = array();
        for ($i = 0; $i < count($result); $i++) {
            $urlOptions['id'] = $result[$i]['id'];

            $r = array(
                'title'       => $result[$i]['title'],
                'description' => $result[$i]['description']
            );

            $r['thumbnail'] = $this->checkImage($root, $result[$i]['thumbnail_cover']);

            $r['image'] = NextendImageFallBack::fallback($root, array(
                @$result[$i]['original_cover'],
                isset($result[$i]['large']) ? "/media/com_easysocial/avatars/event/" . $result[$i]['avatar_folder'] . "/" . $result[$i]['large'] : ''
            ), array());

            if ($r['thumbnail'] == '' && $r['image'] != '') {
                $r['thumbnail'] = $r['image'];
            }

            $r += array(
                'square_image'        => $this->checkImage($root, $result[$i]['square_cover']),
                'featured_image'      => $this->checkImage($root, $result[$i]['featured_cover']),
                'large_image'         => $this->checkImage($root, $result[$i]['large_cover']),
                'stock_image'         => $this->checkImage($root, $result[$i]['stock_cover']),
                'avatar_small_image'  => $this->checkImage($avatarRoot . $result[$i]['avatar_folder'] . "/", $result[$i]['small']),
                'avatar_medium_image' => $this->checkImage($avatarRoot . $result[$i]['avatar_folder'] . "/", $result[$i]['medium']),
                'avatar_square_image' => $this->checkImage($avatarRoot . $result[$i]['avatar_folder'] . "/", $result[$i]['square']),
                'avatar_large_image'  => $this->checkImage($avatarRoot . $result[$i]['avatar_folder'] . "/", $result[$i]['large']),
                'url'                 => FRoute::events($urlOptions, true),
                'start_date'          => $this->formatDate($result[$i]['start']),
                'start_time'          => $this->formatDate($result[$i]['start'], 1),
                'end_date'            => $this->formatDate($result[$i]['end']),
                'end_time'            => $this->formatDate($result[$i]['end'], 1),
                'address'             => $result[$i]['address'],
                'longitude'           => $result[$i]['longitude'],
                'latitude'            => $result[$i]['latitude'],
                'creation_time'       => $result[$i]['created'],
                'alias'               => $result[$i]['alias'],
                'category_id'         => $result[$i]['category_id'],
                'id'                  => $result[$i]['id']
            );

            $data[] = $r;
        }

        return $data;
    }
}
