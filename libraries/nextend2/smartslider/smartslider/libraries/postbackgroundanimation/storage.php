<?php
/**
* @author    Roland Soos
* @copyright (C) 2015 Nextendweb.com
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Restricted access');
?><?php

class N2SmartSliderPostBackgroundAnimationStorage
{

    private static $sets = array();

    private static $animation = array();

    private static $animationBySet = array();

    private static $animationById = array();

    public static function init() {
        N2Pluggable::addAction('smartsliderpostbackgroundanimationset', 'N2SmartSliderPostBackgroundAnimationStorage::animationSet');
        N2Pluggable::addAction('smartsliderpostbackgroundanimation', 'N2SmartSliderPostBackgroundAnimationStorage::animations');
        N2Pluggable::addAction('postbackgroundanimation', 'N2SmartSliderPostBackgroundAnimationStorage::animation');
    }

    private static function load() {
        static $loaded;
        if (!$loaded) {
            N2Pluggable::doAction('postBackgroundAnimationStorage', array(
                &self::$sets,
                &self::$animation
            ));

            for ($i = 0; $i < count(self::$animation); $i++) {
                if (!isset(self::$animationBySet[self::$animation[$i]['referencekey']])) {
                    self::$animationBySet[self::$animation[$i]['referencekey']] = array();
                }
                self::$animationBySet[self::$animation[$i]['referencekey']][] = &self::$animation[$i];
                self::$animationById[self::$animation[$i]['id']]              = &self::$animation[$i];
            }
            $loaded = true;
        }
    }

    public static function animationSet($referenceKey, &$sets) {
        self::load();

        for ($i = count(self::$sets) - 1; $i >= 0; $i--) {
            self::$sets[$i]['system']   = 1;
            self::$sets[$i]['editable'] = 0;
            array_unshift($sets, self::$sets[$i]);
        }

    }

    public static function animations($referenceKey, &$animation) {
        self::load();
        if (isset(self::$animationBySet[$referenceKey])) {
            $_animation = &self::$animationBySet[$referenceKey];
            for ($i = count($_animation) - 1; $i >= 0; $i--) {
                $_animation[$i]['system']   = 1;
                $_animation[$i]['editable'] = 0;
                array_unshift($animation, $_animation[$i]);
            }

        }
    }

    public static function animation($id, &$animation) {
        self::load();
        if (isset(self::$animationById[$id])) {
            self::$animationById[$id]['system']   = 1;
            self::$animationById[$id]['editable'] = 0;
            $animation                            = self::$animationById[$id];
        }
    }
}

N2SmartSliderPostBackgroundAnimationStorage::init();