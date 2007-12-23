<?php
/**
* $Id$
* Module: SmartBilling
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

$i = -1;

$i++;
$adminmenu[$i]['title'] = _MI_SBILLING_INDEX;
$adminmenu[$i]['link'] = "admin/invoice.php";

$i++;
$adminmenu[$i]['title'] = _MI_SBILLING_HOSTING_MANAGEMENT;
$adminmenu[$i]['link'] = "admin/webaccount.php";

$i++;
$adminmenu[$i]['title'] = _MI_SBILLING_ACCOUNTS;
$adminmenu[$i]['link'] = "admin/account.php";

$i++;
$adminmenu[$i]['title'] = _MI_SBILLING_TIME_TRACKING;
$adminmenu[$i]['link'] = "admin/log.php";

if (isset($xoopsModule)) {

	$i = -1;

	$i++;
	$headermenu[$i]['title'] = _PREFERENCES;
	$headermenu[$i]['link'] = '../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=' . $xoopsModule->getVar('mid');

	$i++;
	$headermenu[$i]['title'] = _CO_SOBJECT_GOTOMODULE;
	$headermenu[$i]['link'] = SMARTBILLING_URL;

	$i++;
	$headermenu[$i]['title'] = _CO_SOBJECT_UPDATE_MODULE;
	$headermenu[$i]['link'] = XOOPS_URL . "/modules/system/admin.php?fct=modulesadmin&op=update&module=" . $xoopsModule->getVar('dirname');

	$i++;
	$headermenu[$i]['title'] = _AM_SOBJECT_ABOUT;
	$headermenu[$i]['link'] = SMARTBILLING_URL . "admin/about.php";
}
?>
