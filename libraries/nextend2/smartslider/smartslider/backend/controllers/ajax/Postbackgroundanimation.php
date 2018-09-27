<?php
/**
* @author    Roland Soos
* @copyright (C) 2015 Nextendweb.com
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Restricted access');
?><?php
N2Base::getApplication('system')
      ->getApplicationType('backend');
N2Loader::import('helpers.controllers.VisualManagerAjax', 'system.backend');

class N2SmartSliderBackendPostBackgroundAnimationControllerAjax extends N2SystemBackendVisualManagerControllerAjax
{

    protected $type = 'postbackgroundanimation';

    public function initialize() {
        parent::initialize();

        N2Loader::import(array(
            'models.' . $this->type
        ), 'smartslider');
    }

    public function getModel() {
        return new N2SmartSliderPostBackgroundAnimationModel();
    }
}
