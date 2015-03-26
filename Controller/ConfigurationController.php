<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/
/*************************************************************************************/
namespace DealerGoogleMap\Controller;

use DealerGoogleMap\DealerGoogleMap;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Model\ConfigQuery;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class Configuration
 */
class ConfigurationController extends BaseAdminController {

    /**
     * Methode used to save API Key for google map in Config
     * @return mixed|null|\Symfony\Component\HttpFoundation\Response|static
     */
    public function saveAction(){
        if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), array('delaergooglemap'), AccessManager::UPDATE)) {
            return $response;
        }

        $form = new \DealerGoogleMap\Form\ConfigurationForm($this->getRequest());
        $resp = array(
            "message" => ""
        );
        $code = 200;

        try {
            $vform = $this->validateForm($form);
            $data = $vform->getData();

            ConfigQuery::write(DealerGoogleMap::CONF_API_KEY, $data["apikey"], false, true);
            $resp["message"] = $this->getTranslator()->trans("API Key saved",[],DealerGoogleMap::MESSAGE_DOMAIN);

        } catch (\Exception $e) {
            $resp["message"] = $e->getMessage();
            $code = 500;
        }

        return JsonResponse::create($resp,$code);
    }

}