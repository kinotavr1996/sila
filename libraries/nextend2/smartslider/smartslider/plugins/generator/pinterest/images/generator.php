<?php
/**
* @author    Roland Soos
* @copyright (C) 2015 Nextendweb.com
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Restricted access');
?><?php

N2Loader::import('libraries.slider.generator.N2SmartSliderGeneratorAbstract', 'smartslider');

class N2GeneratorPinterestImages extends N2GeneratorAbstract
{

    function escape($string) {
        $string = str_replace(' ', '-', $string);
        $string = preg_replace('/(?=\P{Nd})(?!\+)(?!\-)\P{L}/u', '', $string);
        return $string;
    }

    protected function _getData($count, $startIndex) {
        $username = $this->data->get('pinterestusername', '');
        $board    = $this->data->get('pinterestboard', 'All');

        $data = array();

        if ($board == "All" || $board == "all" || $board == "") {
            $boardSpecified = false;
            $jsonUrl        = "https://api.pinterest.com/v3/pidgets/users/" . $username . "/pins/";
        } else {
            $boardSpecified = true;
            $board          = $this->escape($board);
            $jsonUrl        = "https://api.pinterest.com/v3/pidgets/boards/" . $username . "/" . $board . "/pins/";

        }
        $json     = @file_get_contents($jsonUrl);
        $pins     = json_decode($json);
        $imageKey = '237x';
        if (is_object($pins) && isset($pins->data->pins)) {
            for ($i = 0; $i < count($pins->data->pins) && $i < $count; $i++) {
                $pin = $pins->data->pins[$i];

                $data[$i]['image']       = str_replace("/237x/", "/1200x/", $pin->images->$imageKey->url);
                $data[$i]['thumbnail']   = $pin->images->$imageKey->url;
                $data[$i]['description'] = $pin->description;
                $data[$i]['title']       = $data[$i]['description'];
                $data[$i]['url']         = "https://www.pinterest.com/pin/" . $pin->id;
                $data[$i]['url_label']   = n2_("View");

                $data[$i]['id']                     = $pin->id;
                $data[$i]['link']                   = $pin->link;
                $data[$i]['image_736']              = str_replace("/237x/", "/736x/", $pin->images->$imageKey->url);
                $data[$i]['pinner_about']           = $pin->pinner->about;
                $data[$i]['pinner_location']        = $pin->pinner->location;
                $data[$i]['pinner_full_name']       = $pin->pinner->full_name;
                $data[$i]['pinner_follower_count']  = $pin->pinner->follower_count;
                $data[$i]['pinner_image_small_url'] = $pin->pinner->image_small_url;
                $data[$i]['pinner_image_140_url']   = str_replace("_30.", "_140.", $data[$i]['pinner_image_small_url']);
                $data[$i]['pinner_image_280_url']   = str_replace("_30.", "_280.", $data[$i]['pinner_image_small_url']);
                $data[$i]['pinner_image_big_url']   = str_replace("_30.", ".", $data[$i]['pinner_image_small_url']);
                $data[$i]['pinner_pin_count']       = $pin->pinner->pin_count;
                $data[$i]['pinner_profile_url']     = $pin->pinner->profile_url;
                $data[$i]['repin_count']            = $pin->repin_count;
                $data[$i]['dominant_color']         = $pin->dominant_color;
                $data[$i]['like_count']             = $pin->like_count;
                if (!$boardSpecified) {
                    $data[$i]['board_description']         = $pin->board->description;
                    $data[$i]['board_url']                 = "http://www.pinterest.com" . $pin->board->url;
                    $data[$i]['board_image_thumbnail_url'] = $pin->board->image_thumbnail_url;
                    $data[$i]['board_pin_count']           = $pin->board->pin_count;
                    $data[$i]['board_name']                = $pin->board->name;
                } else {
                    $data[$i]['board_description']         = $pins->data->board->description;
                    $data[$i]['board_url']                 = "http://www.pinterest.com" . $pins->data->board->url;
                    $data[$i]['board_image_thumbnail_url'] = $pins->data->board->image_thumbnail_url;
                    $data[$i]['board_pin_count']           = $pins->data->board->pin_count;
                    $data[$i]['board_name']                = $pins->data->board->name;
                }
                $data[$i]['user_about']           = $pins->data->user->about;
                $data[$i]['user_location']        = $pins->data->user->location;
                $data[$i]['user_full_name']       = $pins->data->user->full_name;
                $data[$i]['user_follower_count']  = $pins->data->user->follower_count;
                $data[$i]['user_image_small_url'] = $pins->data->user->image_small_url;
                $data[$i]['user_image_140_url']   = str_replace("_30.", "_140.", $data[$i]['user_image_small_url']);
                $data[$i]['user_image_280_url']   = str_replace("_30.", "_280.", $data[$i]['user_image_small_url']);
                $data[$i]['user_image_big_url']   = str_replace("_30.", ".", $data[$i]['user_image_small_url']);
                $data[$i]['user_pin_count']       = $pins->data->user->pin_count;
                $data[$i]['user_profile_url']     = $pins->data->user->profile_url;
                $data[$i]['pin_it']               = "http://pinterest.com/pin/create/button/?url=" . urlencode($data[$i]['url']) . "&media=" . urlencode($data[$i]['image']) . "&description=" . urlencode($data[$i]['description']);
            }
        }
        return $data;
    }

}
