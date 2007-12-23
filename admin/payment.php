<?php

/**
* $Id$
* Module: SmartBilling
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

function editpayment($showmenu = false, $paymentid = 0, $parentid =0)
{
	global $smartbilling_payment_handler, $submenus;

	$paymentObj = $smartbilling_payment_handler->get($paymentid);

	$invoiceid = isset($_GET['invoiceid']) ? intval($_GET['invoiceid']) : 0 ;
	if ($invoiceid) {
		$paymentObj->setVar('invoiceid', $invoiceid);
	}
	if (!$paymentObj->isNew()){

		if ($showmenu) {
			smart_adminMenu(0, _AM_SBILLING_PAYMENTS . " > " . _CO_SOBJECT_EDITING, $submenus, 1);
		}
		smart_collapsableBar('paymentedit', _AM_SBILLING_PAYMENT_EDIT, _AM_SBILLING_PAYMENT_EDIT_INFO);

		$sform = $paymentObj->getForm(_AM_SBILLING_PAYMENT_EDIT, 'addpayment');
		$sform->display();
		smart_close_collapsable('paymentedit');
	} else {
		if ($showmenu) {
			smart_adminMenu(0, _AM_SBILLING_PAYMENTS . " > " . _CO_SOBJECT_CREATINGNEW, $submenus, 1);
		}

		smart_collapsableBar('paymentcreate', _AM_SBILLING_PAYMENT_CREATE, _AM_SBILLING_PAYMENT_CREATE_INFO);
		$sform = $paymentObj->getForm(_AM_SBILLING_PAYMENT_CREATE, 'addpayment');
		$sform->display();
		smart_close_collapsable('paymentcreate');
	}
}

include_once("admin_header.php");
include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";

$op = '';

if (isset($_GET['op'])) $op = $_GET['op'];
if (isset($_POST['op'])) $op = $_POST['op'];

// Adding AdminMenu sublinks
$i = -1;

$i++;
$submenus[$i]['title'] = _AM_SBILLING_SUBMENU_INVOICES;
$submenus[$i]['link'] = 'invoice.php';

$i++;
$submenus[$i]['title'] = _AM_SBILLING_SUBMENU_PAYMENTS;
$submenus[$i]['link'] = 'payment.php';

$paymentid = isset($_GET['paymentid']) ? intval($_GET['paymentid']) : 0 ;

switch ($op) {
	case "mod":

		smart_xoops_cp_header();

		editpayment(true, $paymentid, $parentid);
		break;


	case "addpayment":
        include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smartbilling_payment_handler);
		$controller->storeFromDefaultForm(_AM_SBILLING_PAYMENT_CREATED, _AM_SBILLING_PAYMENT_MODIFIED);

		break;

	case "del":
	    include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smartbilling_payment_handler);
		$controller->handleObjectDeletion();

		break;

	default:

	  	$smart_registry = SmartObjectsRegistry::getInstance();
	  	$smart_registry->addObjectsFromItemName('invoice');

		smart_xoops_cp_header();

		smart_adminMenu(0, _AM_SBILLING_PAYMENTS, $submenus, 1);

		smart_collapsableBar('createdpayments', _AM_SBILLING_PAYMENTS, _AM_SBILLING_PAYMENTS_DSC);

		include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";
		$objectTable = new SmartObjectTable($smartbilling_payment_handler);
		$objectTable->addColumn(new SmartObjectColumn('payment_date', 'left', 150, 'getPaymentLink'));
		$objectTable->addColumn(new SmartObjectColumn('invoiceid', 'left', false, 'getInvoiceLink'));
		$objectTable->addColumn(new SmartObjectColumn('payment_method', 'center', 100));
		$objectTable->addColumn(new SmartObjectColumn('amount', 'right', 100));

		$objectTable->addIntroButton('addpayment', 'payment.php?op=mod', _AM_SBILLING_PAYMENT_CREATE);

		$objectTable->addQuickSearch(array('invoice_number'));

		$objectTable->render();

		echo "<br />";
		smart_close_collapsable('createdpayments');
		echo "<br>";

		break;
}

smart_modFooter();
xoops_cp_footer();

?>