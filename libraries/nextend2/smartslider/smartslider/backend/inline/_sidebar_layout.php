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
N2Base::getApplication('smartslider')
      ->getApplicationType('backend')
      ->run(array(
          'useRequest' => false,
          'controller' => 'layout',
          'action'     => 'index'
      ));
