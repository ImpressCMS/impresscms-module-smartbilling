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

if( !defined("SMARTBILLING_DIRNAME") ){
	define("SMARTBILLING_DIRNAME", 'smartbilling');
}

if( !defined("SMARTBILLING_URL") ){
	define("SMARTBILLING_URL", XOOPS_URL.'/modules/'.SMARTBILLING_DIRNAME.'/');
}
if( !defined("SMARTBILLING_ROOT_PATH") ){
	define("SMARTBILLING_ROOT_PATH", XOOPS_ROOT_PATH.'/modules/'.SMARTBILLING_DIRNAME.'/');
}

if( !defined("SMARTBILLING_IMAGES_URL") ){
	define("SMARTBILLING_IMAGES_URL", SMARTBILLING_URL.'images/');
}

if( !defined("SMARTBILLING_ADMIN_URL") ){
	define("SMARTBILLING_ADMIN_URL", SMARTBILLING_URL.'admin/');
}

/** Include SmartObject framework **/
include_once XOOPS_ROOT_PATH.'/modules/smartobject/class/smartloader.php';

/*
 * Including the common language file of the module
 */
$fileName = SMARTBILLING_ROOT_PATH . 'language/' . $GLOBALS['xoopsConfig']['language'] . '/common.php';
if (!file_exists($fileName)) {
	$fileName = SMARTBILLING_ROOT_PATH . 'language/english/common.php';
}

include_once($fileName);

include_once(SMARTBILLING_ROOT_PATH . "include/functions.php");

// Creating the SmartModule object
$smartbillingModule =& smart_getModuleInfo(SMARTBILLING_DIRNAME);

// Find if the user is admin of the module
$smartbilling_isAdmin = smart_userIsAdmin(SMARTBILLING_DIRNAME);

$myts = MyTextSanitizer::getInstance();
if(is_object($smartbillingModule)){
	$smartbilling_moduleName = $smartbillingModule->getVar('name');
}

// Creating the SmartModule config Object
$smartbillingConfig =& smart_getModuleConfig(SMARTBILLING_DIRNAME);

include_once(SMARTBILLING_ROOT_PATH . "class/account.php");
include_once(SMARTBILLING_ROOT_PATH . "class/invoice.php");
include_once(SMARTBILLING_ROOT_PATH . "class/payment.php");
include_once(SMARTBILLING_ROOT_PATH . "class/domain.php");
include_once(SMARTBILLING_ROOT_PATH . "class/webaccount.php");
include_once(SMARTBILLING_ROOT_PATH . "class/server.php");
include_once(SMARTBILLING_ROOT_PATH . "class/supplier.php");

// include SmartObject Currency Management feature
include_once(SMARTOBJECT_ROOT_PATH . "include/currency.php");

$smartbilling_account_handler = xoops_getmodulehandler('account', SMARTBILLING_DIRNAME);
$smartbilling_invoice_handler = xoops_getmodulehandler('invoice', SMARTBILLING_DIRNAME);
$smartbilling_payment_handler = xoops_getmodulehandler('payment', SMARTBILLING_DIRNAME);
$smartbilling_domain_handler = xoops_getmodulehandler('domain', SMARTBILLING_DIRNAME);
$smartbilling_webaccount_handler = xoops_getmodulehandler('webaccount', SMARTBILLING_DIRNAME);
$smartbilling_server_handler = xoops_getmodulehandler('server', SMARTBILLING_DIRNAME);
$smartbilling_supplier_handler = xoops_getmodulehandler('supplier', SMARTBILLING_DIRNAME);

$smartbilling_domain_registrar = array(
		'godaddy' => 'GoDaddy.com',
		'inboxhosting' => 'INBOX Hosting',
		'domainsatcost' => 'Domains At Cost',
		'inboxnetwork' => 'inBox Network'
);

$smartbilling_webaccount_status = array(
	SMARTBILLING_WEBACCOUNT_STATUS_NORMAL => _CO_SBILLING_WEBACCOUNT_STATUS_NORMAL,
	SMARTBILLING_WEBACCOUNT_STATUS_INPACKAGE => _CO_SBILLING_WEBACCOUNT_STATUS_INPACKAGE,
	SMARTBILLING_WEBACCOUNT_STATUS_INTERNAL => _CO_SBILLING_WEBACCOUNT_STATUS_INTERNAL,
	SMARTBILLING_WEBACCOUNT_STATUS_FREE => _CO_SBILLING_WEBACCOUNT_STATUS_FREE,
	SMARTBILLING_WEBACCOUNT_STATUS_INACTIVE => _CO_SBILLING_WEBACCOUNT_STATUS_INACTIVE,
	SMARTBILLING_WEBACCOUNT_STATUS_DELETED => _CO_SBILLING_WEBACCOUNT_STATUS_DELETED,
	SMARTBILLING_WEBACCOUNT_STATUS_NOTSET => _CO_SBILLING_WEBACCOUNT_STATUS_NOTSET
	);

$smartbilling_invoice_status = array(
	SMARTBILLING_INVOICE_STATUS_STANDING => _CO_SBILLING_INVOICE_STATUS_STANDING,
	SMARTBILLING_INVOICE_STATUS_PAID => _CO_SBILLING_INVOICE_STATUS_PAID,
	SMARTBILLING_INVOICE_STATUS_LOST => _CO_SBILLING_INVOICE_STATUS_LOST
	);

?>