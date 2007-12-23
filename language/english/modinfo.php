<?php

/**
* $Id$
* Module: SmartBilling
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

/**  not edited by RJB on 3/10/07 */

if (!defined("XOOPS_ROOT_PATH")) {
 	die("XOOPS root path not defined");
}

// Module Info
// The name of this module

global $xoopsModule;
define("_MI_SBILLING_MD_NAME", "SmartBilling");
define("_MI_SBILLING_MD_DESC", "Simple billing system");

define("_MI_SBILLING_INDEX", "Invoices");
define("_MI_SBILLING_ACCOUNTS", "Accounts");
define("_MI_SBILLING_PAYMENTS", "Payments");
define("_MI_SBILLING_HOSTING_MANAGEMENT", "Hosting Management");
define("_MI_SBILLING_TIME_TRACKING", "Time Tracking");
define("_MI_SBILLING_NEWUGROUP", "Add new users to these groups");
define("_MI_SBILLING_NEWUGROUPDSC", "When new user are created via the Account tab of the module, they will be automatically added to these groups.");




?>