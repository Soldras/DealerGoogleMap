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

namespace DealerGoogleMap;

use Thelia\Core\Template\TemplateDefinition;
use Thelia\Module\BaseModule;

class DealerGoogleMap extends BaseModule
{
    const MESSAGE_DOMAIN = "dealergooglemap";
    const ROUTER = "router.dealergooglemap";
    const CONF_API_KEY = "dealergooglemap_api_key";

    public function getHooks()
    {
        return array(

            array(
                "type" => TemplateDefinition::FRONT_OFFICE,
                "code" => "dealermap.stylesheet",
                "title" => "Hook Map CSS",
                "description" => "Hook to integrate CSS in map page",
                "active" => true
            ),
            array(
                "type" => TemplateDefinition::FRONT_OFFICE,
                "code" => "dealermap.after-javascript-include",
                "title" => "Hook Map JS includes",
                "description" => "Hook to integrate JS in map page",
                "active" => true
            ),
            array(
                "type" => TemplateDefinition::FRONT_OFFICE,
                "code" => "dealermap.javascript-initialization",
                "title" => "Hook Map JS init",
                "description" => "Hook to integrate JS initialization in map page",
                "active" => true
            )
        );
    }
}
