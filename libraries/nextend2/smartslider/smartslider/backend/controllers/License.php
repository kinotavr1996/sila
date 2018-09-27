<?php
/**
* @author    Roland Soos
* @copyright (C) 2015 Nextendweb.com
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Restricted access');
?><?php
class N2SmartsliderBackendLicenseController extends N2SmartSliderController
{

    public function actionDeAuthorize() {
        $status = N2SmartsliderLicenseModel::getInstance()
                                           ->deAuthorize();

        $hasError = N2SS3::hasApiError($status);
        if (is_array($hasError)) {
            $this->response->redirect($hasError);
        }

        $this->redirectToSliders();
    }
}
