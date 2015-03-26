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

namespace DealerGoogleMap\Action;

use DealerGoogleMap\DealerGoogleMap;
use Dealer\Event\DealerEvents;
use Dealer\Event\DealerTabEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Thelia\Action\BaseAction;
use Thelia\Log\Tlog;
use Thelia\Model\ConfigQuery;

/**
 * Class GoogleMapAction
 * @package DealerGoogleMap\Action
 */
class GoogleMapAction extends BaseAction implements EventSubscriberInterface
{
    /**
     * Generate Address for Google API request
     * @param DealerTabEvent $event
     * @return string
     */
    protected function generateAddress(DealerTabEvent $event)
    {

        $address = $event->getAddress1();

        if ($event->getAddress2()) {
            $address .= " " . $event->getAddress2();
        }

        $address .= " " . $event->getZipcode() . " " . $event->getCity();

        $address = str_replace(" ", "+", $address);

        return $address;
    }

    /**
     * Generate URL for Google API request
     * @param DealerTabEvent $event
     * @return string
     */
    protected function generateGoogleRequest(DealerTabEvent $event)
    {
        $url = "https://maps.googleapis.com/maps/api/geocode/json?";
        $url .= "address=" . $this->generateAddress($event);

        return $url;

    }

    /**
     * Get create|update event from Dealer to insert lat/lon param
     * @param DealerTabEvent $event
     */
    public function generateCoordinate(DealerTabEvent $event)
    {
        if ($url = $this->generateGoogleRequest($event)) {

            try {
                $response = file_get_contents($url);

                if ($response) {
                    $jsonEncoder = new JsonEncoder();
                    $data = $jsonEncoder->decode($response, JsonEncoder::FORMAT);

                    if(isset($data["status"]) && strcmp($data["status"],"OK") == 0){
                        $loc = $data["results"][0]["geometry"]["location"];
                        $event->setLatitude($loc["lat"]);
                        $event->setLongitude($loc["lng"]);
                    }

                }

            } catch (\ErrorException $ex) {
                Tlog::getInstance()->error("DEALER GOOGLE MAP : " . $ex->getMessage());
            }

        }


    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     *
     * @api
     */
    public static function getSubscribedEvents()
    {
        return array(
            DealerEvents::DEALER_TAB_CREATE => ["generateCoordinate", 200],
            DealerEvents::DEALER_TAB_UPDATE => ["generateCoordinate", 200],
        );
    }
}