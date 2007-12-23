<?php

/**
* $Id$
* Module: SmartBilling
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

function editinvoice($showmenu = false, $invoiceid = 0, $parentid =0)
{
	global $smartbilling_invoice_handler, $submenus;

	$invoiceObj = $smartbilling_invoice_handler->get($invoiceid);

	$accountid = isset($_GET['accountid']) ? intval($_GET['accountid']) : 0 ;
	if ($accountid) {
		$invoiceObj->setVar('accountid', $accountid);
	}

	if (!$invoiceObj->isNew()){

		if ($showmenu) {
			smart_adminMenu(0, _AM_SBILLING_INVOICES . " > " . _CO_SOBJECT_EDITING, $submenus, 0);
		}
		smart_collapsableBar('invoiceedit', _AM_SBILLING_INVOICE_EDIT, _AM_SBILLING_INVOICE_EDIT_INFO);

		$sform = $invoiceObj->getForm(_AM_SBILLING_INVOICE_EDIT, 'addinvoice');
		$sform->display();
		smart_close_collapsable('invoiceedit');
	} else {
		if ($showmenu) {
			smart_adminMenu(0, _AM_SBILLING_INVOICES . " > " . _CO_SOBJECT_CREATINGNEW, $submenus, 0);
		}

		smart_collapsableBar('invoicecreate', _AM_SBILLING_INVOICE_CREATE, _AM_SBILLING_INVOICE_CREATE_INFO);
		$sform = $invoiceObj->getForm(_AM_SBILLING_INVOICE_CREATE, 'addinvoice');
		$sform->display();
		smart_close_collapsable('invoicecreate');
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

$invoiceid = isset($_GET['invoiceid']) ? intval($_GET['invoiceid']) : 0 ;

switch ($op) {
	case "mod":
		smart_xoops_cp_header();

		editinvoice(true, $invoiceid, $parentid);
		break;


	case "addinvoice":
        include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smartbilling_invoice_handler);
		$controller->storeFromDefaultForm(_AM_SBILLING_INVOICE_CREATED, _AM_SBILLING_INVOICE_MODIFIED);

		break;

	case "del":
	    include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smartbilling_invoice_handler);
		$controller->handleObjectDeletion();

		break;

	case "view" :
		$invoiceObj = $smartbilling_invoice_handler->get($invoiceid);

		smart_xoops_cp_header();

		smart_adminMenu(0, _AM_SBILLING_INVOICE_VIEW . ' > ' . $invoiceObj->getVar('invoice_number'), $submenus, 0);

		smart_collapsableBar('invoiceview', $invoiceObj->getVar('invoice_number') . ' - [' . $invoiceObj->getAccountLink() . '] ' . $invoiceObj->getEditItemLink(), _AM_SBILLING_INVOICE_VIEW_DSC);

		$invoiceObj->displaySingleObject();

		echo "<br />";
		smart_close_collapsable('invoiceview');
		echo "<br>";

		smart_collapsableBar('createdpayments', _AM_SBILLING_PAYMENTS, _AM_SBILLING_PAYMENTS_DSC);

		include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('payment.invoiceid', $invoiceid));

		$objectTable = new SmartObjectTable($smartbilling_payment_handler, $criteria);
		$objectTable->addColumn(new SmartObjectColumn('payment_date', 'left', false, 'getPaymentLink'));
		$objectTable->addColumn(new SmartObjectColumn('invoiceid', 'left', false, 'getInvoiceLink'));
		$objectTable->addColumn(new SmartObjectColumn('amount', 'right', 100));

		$objectTable->addIntroButton('addpayment', 'payment.php?op=mod&invoiceid=' . $invoiceid, _AM_SBILLING_PAYMENT_CREATE);

		//$objectTable->addQuickSearch(array('name'));

		$objectTable->render();

		echo "<br />";
		smart_close_collapsable('createdpayments');
		echo "<br>";


		break;

	default:

		$xoopsTpl = new XoopsTpl();

	  	$smart_registry = SmartObjectsRegistry::getInstance();
	  	$smart_registry->addObjectsFromItemName('account');

		smart_xoops_cp_header();

		smart_adminMenu(0, _AM_SBILLING_INVOICES, $submenus, 0);

		smart_collapsableBar('createdinvoices', _AM_SBILLING_INVOICES, _AM_SBILLING_INVOICES_DSC);

		include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";
		$objectTable = new SmartObjectTable($smartbilling_invoice_handler);
		$objectTable->addColumn(new SmartObjectColumn('date', 'left', 100));
		$objectTable->addColumn(new SmartObjectColumn('invoice_number', 'left', false, 'getInvoiceLink'));
		$objectTable->addColumn(new SmartObjectColumn('amount', 'right', 100));
		$objectTable->addColumn(new SmartObjectColumn(_AM_SBILLING_TOTAL_BALANCE, 'right', 100, 'getAmountReceivable'));
		$objectTable->addColumn(new SmartObjectColumn('expected_payment_method', 'center', 100));
		$objectTable->addColumn(new SmartObjectColumn('currency', 'center', 75));
		$objectTable->addColumn(new SmartObjectColumn('accountid', 'center', false, 'getAccountLink'));
		$objectTable->addColumn(new SmartObjectColumn('status', 'center', 50));

		$objectTable->addIntroButton('addinvoice', 'invoice.php?op=mod', _AM_SBILLING_INVOICE_CREATE);
		$objectTable->addIntroButton('addinvoice', 'payment.php?op=mod', _AM_SBILLING_PAYMENT_CREATE);
		$objectTable->addIntroButton('addinvoice', 'account.php?op=mod', _AM_SBILLING_ACCOUNT_CREATE);

		$objectTable->addQuickSearch(array('invoice_number', 'account.name'));

		$criteria_notpaid = new CriteriaCompo();
		$criteria_notpaid->add(new Criteria('status', SMARTBILLING_INVOICE_STATUS_STANDING));
		$objectTable->addFilter(_CO_SBILLING_INVOICES_NOT_PAID, array(
									'key' => 'status',
									'criteria' => $criteria_notpaid
		));

		$criteria_paid = new CriteriaCompo();
		$criteria_paid->add(new Criteria('status', SMARTBILLING_INVOICE_STATUS_PAID));
		$objectTable->addFilter(_CO_SBILLING_INVOICES_PAID, array(
									'key' => 'status',
									'criteria' => $criteria_paid
		));

		$criteria_lost = new CriteriaCompo();
		$criteria_lost->add(new Criteria('status', SMARTBILLING_INVOICE_STATUS_LOST));
		$objectTable->addFilter(_CO_SBILLING_INVOICES_LOST, array(
									'key' => 'status',
									'criteria' => $criteria_lost
		));

		$objectTable->setDefaultFilter('status');

		$objectTable->addCustomAction('getAddPaymentLink');

		$xoopsTpl->assign('smartbilling_total_balance', $smartbilling_invoice_handler->getReceivableBalance());

		$objectTable->addHeader($xoopsTpl->fetch('db:smartbilling_balance.html'));

		$objectTable->render();

		echo "<br />";
		smart_close_collapsable('createdinvoices');
		echo "<br>";

		break;
}

smart_modFooter();
xoops_cp_footer();

?>