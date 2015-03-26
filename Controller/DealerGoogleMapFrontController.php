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

use Dealer\Model\DealerTabQuery;
use Dealer\Model\DealerTab;
use DealerGoogleMap\DealerGoogleMap;
use Thelia\Controller\Front\BaseFrontController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Thelia\Log\Tlog;

/**
 * Class DealerGoogleMapFrontController
 * @package DealerGoogleMap\Controller
 */
class DealerGoogleMapFrontController extends BaseFrontController
{
    protected $useFallbackTemplate = true;

    public function mapAction()
    {
        $url = $this->getRouteFromRouter(DealerGoogleMap::ROUTER,"dealergooglemap.front.marker");
        $this->render("map",["URL" => $url]);

    }

    public function getMarkerAction()
    {
        $dealers = DealerTabQuery::create()->find();


        $retour = [];
        /** @var DealerTab $dealer */
        foreach ($dealers as $dealer) {
            $retour[] = [
                "title" => $dealer->getCompany(),
                "loc" => [
                    $dealer->getLatitude(),
                    $dealer->getLongitude()
                ],
                "description" => $dealer->getDescription(),
            "info" =>$dealer->getAddress1(). " " . $dealer->getAddress2(). "<br>" .$dealer->getZipcode(). " " . $dealer->getCity() . "<br>". $dealer->getPhoneNumber()
            ];
        }

        return JsonResponse::create($retour);
    }
}