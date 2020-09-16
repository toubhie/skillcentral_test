<?php
/**
* Copyright (c) Microsoft Corporation.  All Rights Reserved.  Licensed under the MIT License.  See License in the project root for license information.
* 
* WebBrowserCookieSettings File
* PHP version 7
*
* @category  Library
* @package   Microsoft.Graph
* @copyright © Microsoft Corporation. All rights reserved.
* @license   https://opensource.org/licenses/MIT MIT License
* @version   GIT: 1.4.0
* @link      https://graph.microsoft.io/
*/
namespace Microsoft\Graph\Model;

use Microsoft\Graph\Core\Enum;

/**
* WebBrowserCookieSettings class
*
* @category  Model
* @package   Microsoft.Graph
* @copyright © Microsoft Corporation. All rights reserved.
* @license   https://opensource.org/licenses/MIT MIT License
* @version   Release: 1.4.0
* @link      https://graph.microsoft.io/
*/
class WebBrowserCookieSettings extends Enum
{
    /**
    * The Enum WebBrowserCookieSettings
    */
    const BROWSER_DEFAULT = "browserDefault";
    const BLOCK_ALWAYS = "blockAlways";
    const ALLOW_CURRENT_WEB_SITE = "allowCurrentWebSite";
    const ALLOW_FROM_WEBSITES_VISITED = "allowFromWebsitesVisited";
    const ALLOW_ALWAYS = "allowAlways";
}