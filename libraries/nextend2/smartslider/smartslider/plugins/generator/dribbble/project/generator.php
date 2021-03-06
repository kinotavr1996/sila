<?php
/**
* @author    Roland Soos
* @copyright (C) 2015 Nextendweb.com
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Restricted access');
?><?php

N2Loader::import('libraries.slider.generator.NextendSmartSliderGeneratorAbstract', 'smartslider');

class N2GeneratorDribbbleProject extends N2GeneratorAbstract
{

    protected function _getData($count, $startIndex) {
        $data   = array();
        $client = $this->info->getConfiguration()
                             ->getApi();

        $result  = null;
        $success = $client->CallAPI('https://api.dribbble.com/v1/projects/' . $this->data->get('dribbble-project-id') . '/shots', 'GET', array('per_page' => $count + $startIndex), array('FailOnAccessError' => true), $result);

        if (is_array($result)) {
            $shots = array_slice($result, $startIndex, $count);

            foreach ($shots AS $shot) {
                $user = $shot->user;
                $p = array(
                    'image'          => isset($shot->images->hidpi) ? $shot->images->hidpi : $shot->images->normal,
                    'thumbnail'      => $shot->images->teaser,
                    'title'          => $shot->title,
                    'description'    => $shot->description,
                    'url'            => $shot->html_url,
                    'url_label'      => n2_('View'),
                    'image_normal'   => $shot->images->normal,
                    'views_count'    => $shot->views_count,
                    'likes_count'    => $shot->likes_count,
                    'comments_count' => $shot->comments_count,
                    'rebounds_count' => $shot->rebounds_count,
                    'buckets_count'  => $shot->buckets_count,
                    'name'           => $user->name,
                    'user_name'      => $user->username,
                    'user_url'       => $user->html_url,
                    'user_avatar'    => $user->avatar_url,
                );
                foreach ($shot->tags AS $j => $tag) {
                    $p['tag_' . ($j + 1)] = $tag;
                }
                $data[] = $p;
            }
        }
        return $data;
    }
}