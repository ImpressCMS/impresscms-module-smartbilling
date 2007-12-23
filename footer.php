<?php

/**
* $Id$
* Module: SmartBilling
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/
if (!defined("XOOPS_ROOT_PATH")) {
 	die("XOOPS root path not defined");
}

global $xoopsModule, $xoopsModuleConfig;

include_once XOOPS_ROOT_PATH . "/modules/smartbilling/include/functions.php";

$uid = ($xoopsUser) ? ($xoopsUser->getVar("uid")) : 0;

$xoopsTpl->assign("smartbilling_adminpage", smart_getModuleAdminLink());
$xoopsTpl->assign("isAdmin", $smartbilling_isAdmin);
$xoopsTpl->assign('smartbilling_url', SMARTBILLING_URL);
$xoopsTpl->assign('smartbilling_images_url', SMARTBILLING_IMAGES_URL);

$xoTheme->addStylesheet(SMARTBILLING_URL . 'module.css');

$xoopsTpl->assign("ref_smartfactory", "SmartBilling is developed by The SmartFactory (http://smartfactory.ca), a division of InBox Solutions (http://inboxsolutions.net)");

?>