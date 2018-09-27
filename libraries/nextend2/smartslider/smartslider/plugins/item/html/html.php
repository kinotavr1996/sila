<?php
/**
* @author    Roland Soos
* @copyright (C) 2015 Nextendweb.com
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Restricted access');
?><?php
N2Loader::import('libraries.plugins.N2SliderItemAbstract', 'smartslider');

class N2SSPluginItemHTML extends N2SSPluginItemAbstract
{

    var $_identifier = 'html';

    protected $priority = 40;

    protected $layerProperties = array("width" => 200);

    public function __construct() {
        $this->_title = n2_x('HTML', 'Slide item');
    }

    function getTemplate($slider) {
        return '
    <div>
        {html}
        <style type="text/css">
          {css}
        </style>
    </div>
    ';
    }

    function _render($data, $id, $slider, $items) {
        return $this->getHtml($data, $id, $slider, $items);
    }

    function _renderAdmin($data, $id, $slider, $items) {
        return $this->getHtml($data, $id, $slider, $items);
    }

    private function getHtml($data, $id, $slider, $slide) {
        $css = '';
        if ($cssCode = $data->get('css', '')) {
            $css = NHtml::style($cssCode);
        }

        return NHtml::tag("div", array(), $this->closeTags($slide->fill($data->get("html")) . $css));
    }

    function closeTags($html) {
        // Put all opened tags into an array
        preg_match_all('#<([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
        $openedtags = $result[1];   #put all closed tags into an array
        preg_match_all('#</([a-z]+)>#iU', $html, $result);
        $closedtags = $result[1];
        $len_opened = count($openedtags);
        # Check if all tags are closed
        if (count($closedtags) == $len_opened) {
            return $html;
        }
        $openedtags = array_reverse($openedtags);
        # close tags
        for ($i = 0; $i < $len_opened; $i++) {
            if (!in_array($openedtags[$i], $closedtags)) {
                if ($openedtags[$i] != 'br') {
                    // Ignores <br> tags to avoid unnessary spacing
                    // at the end of the string
                    $html .= '</' . $openedtags[$i] . '>';
                }
            } else {
                unset($closedtags[array_search($openedtags[$i], $closedtags)]);
            }
        }
        return $html;
    }

    function getValues() {
        return array(
            'html' => '<table  class="my-table">
<tbody><tr>
<th>First Name</th>
<th>Last Name</th>
<th>Points</th>
</tr>
<tr>
<td>Eve</td>
<td>Jackson</td>
<td>94</td>
</tr>
<tr>
<td>John</td>
<td>Doe</td>
<td>80</td>
</tr>
<tr>
<td>Adam</td>
<td>Johnson</td>
<td>67</td>
</tr>
<tr>
<td>Jill</td>
<td>Smith</td>
<td>50</td>
</tr>
</tbody></table>',
            'css'  => 'table.my-table{
width: 100%;
background: #1890d7;
color: white;
}

table.my-table th,
table.my-table td{
padding: 5px;
text-align: left;
}'
        );
    }

    function getPath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR . $this->_identifier . DIRECTORY_SEPARATOR;
    }

    public function getFilled($slide, $data) {
        $data->set('html', $slide->fill($data->get('html', '')));
        return $data;
    }
}

N2Plugin::addPlugin('ssitem', 'N2SSPluginItemHTML');
