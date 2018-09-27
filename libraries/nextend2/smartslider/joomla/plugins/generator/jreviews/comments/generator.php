<?php
/**
* @author    Roland Soos
* @copyright (C) 2015 Nextendweb.com
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Restricted access');
?><?php
N2Loader::import('libraries.slider.generator.N2SmartSliderGeneratorAbstract', 'smartslider');
require_once(JPATH_SITE . '/components/com_content/helpers/route.php');

class N2GeneratorJReviewsComments extends N2GeneratorAbstract
{

    function imageUrl($image) {
        $root = JURI::root();
        if (!empty($image)) {
            return N2ImageHelper::dynamic($root . $image);
        } else {
            return '';
        }
    }

    protected function _getData($count, $startIndex) {
        $model = new N2Model('jreviews_categories');

        $categories = array_map('intval', explode('||', $this->data->get('sourcecategories', '')));
        $articles   = array_map('intval', explode('||', $this->data->get('sourcearticles', '')));

        $where = array(
            'jc.published = 1',
            'jc.mode = \'com_content\''
        );

        $articleWhere = '';
        if (!in_array(0, $articles) && count($articles) > 0) {
            $articleWhere = ' AND asset_id IN (' . implode(',', $articles) . ') ';
        }

        if (!in_array(0, $categories) && count($categories) > 0) {
            $where[] = 'jc.pid IN (SELECT id FROM #__content WHERE asset_id IN (SELECT id FROM #__assets WHERE parent_id IN (' . implode(',', $categories) . '))' . $articleWhere . ')';
        } else if (!in_array(0, $articles) && count($articles) > 0) {
            $where[] = 'jc.pid IN (SELECT id FROM #__content WHERE asset_id IN (' . implode(',', $articles) . '))';
        }

        $stars = $this->data->get('sourcestars', '');
        if (!empty($stars)) {
            $where[] = 'jc.rating >= ' . $stars;
        }

        $helpful = intval($this->data->get('sourcehelpful', ''));
        if (!empty($helpful) && $helpful > 0) {
            $where[] = 'jc.vote_helpful >= ' . $helpful;
        }

        $query = 'SELECT *,jc.title AS comment_title FROM #__jreviews_comments AS jc
                  LEFT JOIN #__content AS c ON jc.pid = c.id
                  WHERE ' . implode(' AND ', $where);

        $order = N2Parse::parse($this->data->get('jreviewsorder', 'jc.created|*|desc'));
        if ($order[0]) {
            $query .= ' ORDER BY ' . $order[0] . ' ' . $order[1] . ' ';
        }

        $query .= ' LIMIT ' . $startIndex . ', ' . $count;

        $result = $model->db->queryAll($query);

        $data = array();

        foreach ($result AS $res) {
            $r = array(
                'title'       => $res['comment_title'],
                'description' => $res['comments']
            );

            $query = 'SELECT media_type, filename, file_extension, rel_path, title, description, embed FROM #__jreviews_media
                      WHERE listing_id = ' . $res['pid'] . ' AND published = 1 AND approved = 1';
            $model = new N2Model('jreviews_media');
            $media = $model->db->queryAll($query);

            $i = 1;
            foreach ($media AS $m) {
                if ($m['media_type'] == 'photo') {
                    $r['photo' . $i] = $this->imageUrl('media/reviews/photos/' . $m['rel_path'] . $m['filename'] . '.' . $m['file_extension']);
                    $i++;
                }
            }

            $article_images = json_decode($res['images']);

            if (isset($r['photo1'])) {
                $r['image'] = $r['photo1'];
            } else if (!empty($article_images->image_intro)) {
                $r['image'] = $this->imageUrl($article_images->image_intro);
            } else if (isset($article_images->image_fulltext)) {
                $r['image'] = $this->imageUrl($article_images->image_fulltext);
            } else {
                $r['image'] = '';
            }

            $r['thumbnail'] = $r['image'];

            $r += array(
                'title'             => $res['comment_title'],
                'description'       => $res['comments'],
                'url'               => ContentHelperRoute::getArticleRoute($res['id'], $res['catid']),
                'url_label'         => sprintf(n2_('View %s'), n2_('article')),
                'rating'            => round($res['rating'], 1),
                'name'              => $res['name'],
                'username'          => $res['username'],
                'email'             => $res['email'],
                'location'          => $res['location'],
                'creation_time'     => $res['created'],
                'vote_helpful'      => $res['vote_helpful'],
                'vote_total'        => $res['vote_total'],
                'review_note'       => $res['review_note'],
                'article_title'     => $res['title'],
                'article_introtext' => $res['introtext'],
                'article_fulltext'  => $res['fulltext'],
                'article_hits'      => $res['hits']
            );

            if (isset($article_images->image_intro)) $r['article_introtext_image'] = $this->imageUrl($article_images->image_intro);
            if (isset($article_images->image_fulltext)) $r['article_fulltext_image'] = $this->imageUrl($article_images->image_fulltext);

            $data[] = $r;
        }

        return $data;
    }

}
