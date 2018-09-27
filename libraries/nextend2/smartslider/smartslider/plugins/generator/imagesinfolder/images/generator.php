<?php
/**
* @author    Roland Soos
* @copyright (C) 2015 Nextendweb.com
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Restricted access');
?><?php

N2Loader::import('libraries.slider.generator.NextendSmartSliderGeneratorAbstract', 'smartslider');

class N2GeneratorInFolderimages extends N2GeneratorAbstract
{

    protected function _getData($count, $startIndex) {
        $root   = N2Filesystem::getImagesFolder();
        $folder = N2Filesystem::realpath($root . '/' . ltrim(rtrim($this->data->get('sourcefolder', ''), '/'), '/'));
        $files  = N2Filesystem::files($folder);

        for ($i = count($files) - 1; $i >= 0; $i--) {
            $ext = strtolower(pathinfo($files[$i], PATHINFO_EXTENSION));
            if ($ext != 'jpg' && $ext != 'jpeg' && $ext != 'png' && $ext != 'gif') {
                array_splice($files, $i, 1);
            }
        }

        $IPTC = $this->data->get('iptc', 0) && function_exists('exif_read_data');

        $files = array_slice($files, $startIndex);

        $data = array();
        for ($i = 0; $i < $count && isset($files[$i]); $i++) {
            $image    = N2ImageHelper::dynamic(N2Uri::pathToUri($folder . '/' . $files[$i]));
            $data[$i] = array(
                'image'     => $image,
                'thumbnail' => $image,
                'title'     => $files[$i]
            );
            if ($IPTC) {
                $properties = @exif_read_data($folder . '/' . $files[$i]);
                if ($properties) {
                    foreach ($properties AS $key => $property) {
                        if (!is_array($property) && $property != '' && preg_match('/^[a-zA-Z]+$/', $key)) {
                            $data[$i][$key] = $property;
                        }
                    }
                }
            }
        }
        return $data;
    }
}