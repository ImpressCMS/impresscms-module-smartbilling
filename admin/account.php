<?php

/**
* $Id$
* Module: SmartBilling
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

function editaccount($showmenu = false, $accountid = 0, $parentid =0)
{
	global $smartbilling_account_handler;

	$accountObj = $smartbilling_account_handler->get($accountid);

	if (isset($_POST['op'])) {
		$controller = new SmartObjectController($smartbilling_account_handler);
		$controller->postDataToObject($accountObj);

		if ($_POST['op'] == 'changedField') {

			switch($_POST['changedField']) {
				case 'user_uid':
					if ($accountObj->getVar('user_uid') == 'new') {
						$accountObj->showFieldOnForm(array('user_realname', 'user_email', 'user_url', 'user_uname', 'user_password', 'user_notification'));
						$accountObj->setFieldAsRequired(array('user_realname', 'user_email'));
					} else {
						$accountObj->hideFieldFromForm(array('user_realname', 'user_email', 'user_url', 'user_uname', 'user_password', 'user_notification'));
						$accountObj->setVar('user_realname', false);
						$accountObj->setVar('user_email', false);
						$accountObj->setVar('user_url', false);
						$accountObj->setVar('user_uname', false);
						$accountObj->setVar('user_password', false);
					}
				break;
			}
		}
	}

	if (!$accountObj->isNew()){

		if ($showmenu) {
			smart_adminMenu(2, _AM_SBILLING_ACCOUNTS . " > " . _CO_SOBJECT_EDITING);
		}
		smart_collapsableBar('accountedit', _AM_SBILLING_ACCOUNT_EDIT, _AM_SBILLING_ACCOUNT_EDIT_INFO);

		$sform = $accountObj->getForm(_AM_SBILLING_ACCOUNT_EDIT, 'addaccount');
		$sform->display();
		smart_close_collapsable('accountedit');
	} else {
		if ($showmenu) {
			smart_adminMenu(2, _AM_SBILLING_ACCOUNTS . " > " . _CO_SOBJECT_CREATINGNEW);
		}
		$accountObj->showFieldOnForm('user_uid');
		smart_collapsableBar('accountcreate', _AM_SBILLING_ACCOUNT_CREATE, _AM_SBILLING_ACCOUNT_CREATE_INFO);
		$sform = $accountObj->getForm(_AM_SBILLING_ACCOUNT_CREATE, 'addaccount');
		$sform->display();
		smart_close_collapsable('accountcreate');
	}
}

include_once("admin_header.php");
include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";

$op = '';

if (isset($_GET['op'])) $op = $_GET['op'];
if (isset($_POST['op'])) $op = $_POST['op'];

$accountid = isset($_GET['accountid']) ? intval($_GET['accountid']) : 0 ;

$smartbilling_account_user_handler = xoops_getmodulehandler('account_user');

switch ($op) {
	case "mod":
	case "changedField":
		smart_xoops_cp_header();

		editaccount(true, $accountid, $parentid);
		break;


	case "addaccount":
        include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smartbilling_account_handler);
		$controller->storeFromDefaultForm(_AM_SBILLING_ACCOUNT_CREATED, _AM_SBILLING_ACCOUNT_MODIFIED);

		break;

	case "del":
	    include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smartbilling_account_handler);
		$controller->handleObjectDeletion();

		break;

	case "updateWebaccountObjects":
		if (!isset($_POST['createdwebaccounts_objects']) || count($_POST['createdwebaccounts_objects']) == 0) {
			redirect_header($smart_previous_webaccount, 3, _CO_SOBJECT_NO_RECORDS_TO_UPDATE);
			exit;
		}

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('webaccountid', '(' . implode(', ', $_POST['createdwebaccounts_objects']) . ')', 'IN'));
		$webaccountsObj = $smartbilling_webaccount_handler->getObjects($criteria, true);
		foreach($webaccountsObj as $webaccountid=>$webaccountobj) {
			$webaccountobj->setVar('status', isset($_POST['status_' . $webaccountid]) ? intval($_POST['status_' . $webaccountid]) : 0);
			$smartbilling_webaccount_handler->insert($webaccountobj);
		}

		redirect_header($smart_previous_webaccount, 3, _CO_SOBJECT_NO_RECORDS_UPDATED);
		exit;

		break;

	case "view" :

		$smart_registry = SmartObjectsRegistry::getInstance();
  		$smart_registry->addObjectsFromItemName('server');
  		$smart_registry->addObjectsFromItemName('account');

		$accountObj = $smartbilling_account_handler->get($accountid);

		smart_xoops_cp_header();

		smart_adminMenu(2, _AM_SBILLING_ACCOUNT_VIEW . ' > ' . $accountObj->getVar('name'));

		$account_title = $accountObj->getVar('name') . ' ' . $accountObj->getEditItemLink();

		// Listing the users linked to this account

		smart_collapsableBar('account_users', $account_title, _AM_SBILLING_ACCOUNT_VIEW_DSC);

		$accountObj->displaySingleObject();

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('account_user.accountid', $accountid));

		include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";
		$objectTable = new SmartObjectTable($smartbilling_account_user_handler, $criteria, array('delete'));
		$objectTable->addColumn(new SmartObjectColumn('uname', 'left', 300, 'getUnameLink'));
		$objectTable->addColumn(new SmartObjectColumn('email', 'left'));

		$objectTable->addIntroButton('addaccount_user', 'account_user.php?op=mod&accountid=' . $accountid, _AM_SBILLING_ACCOUNT_USER_CREATE);

		$objectTable->render();

		echo "<br />";
		smart_close_collapsable('account_users');
		echo "<br>";

		// Listing the invoices for this account

		smart_collapsableBar('accountinvoices', _AM_SBILLING_INVOICES, _AM_SBILLING_INVOICES_DSC);

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('invoice.accountid', $accountid));

		include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";
		$objectTable = new SmartObjectTable($smartbilling_invoice_handler, $criteria);
		$objectTable->addColumn(new SmartObjectColumn('invoice_number', 'left', 150, 'getInvoiceLink'));
		$objectTable->addColumn(new SmartObjectColumn('date', 'left'));
		$objectTable->addColumn(new SmartObjectColumn('amount', 'left'));
		$objectTable->addColumn(new SmartObjectColumn('accountid', 'left', false, 'getAccountLink'));
		$objectTable->addColumn(new SmartObjectColumn('status', 'center', 50));

		$objectTable->addIntroButton('addinvoice', 'invoice.php?op=mod&accountid=' . $accountid, _AM_SBILLING_INVOICE_CREATE);

		$objectTable->addCustomAction('getAddPaymentLink');
		$objectTable->addQuickSearch(array('invoice_number'));

		$objectTable->render();

		echo "<br />";
		smart_close_collapsable('accountinvoices');
		echo "<br>";

		// Listing the payments for this account

		smart_collapsableBar('createdpayments', _AM_SBILLING_PAYMENTS, _AM_SBILLING_PAYMENTS_DSC);

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('invoice.accountid', $accountid));

		include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";
		$objectTable = new SmartObjectTable($smartbilling_payment_handler, $criteria);
		$objectTable->addColumn(new SmartObjectColumn('payment_date', 'left', 150, 'getPaymentLink'));
		$objectTable->addColumn(new SmartObjectColumn('invoiceid', 'left', false, 'getInvoiceLink'));
		$objectTable->addColumn(new SmartObjectColumn('payment_method', 'center', 100));
		$objectTable->addColumn(new SmartObjectColumn('amount', 'right', 100));

		$objectTable->addIntroButton('addpayment', 'payment.php?op=mod', _AM_SBILLING_PAYMENT_CREATE);

		$objectTable->render();

		echo "<br />";
		smart_close_collapsable('createdpayments');
		echo "<br>";

		// Listing the web accounts for this account

		smart_collapsableBar('accountwebaccounts', _AM_SBILLING_WEBACCOUNTS, _AM_SBILLING_WEBACCOUNTS_DSC);

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('webaccount.accountid', $accountid));

		include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";
		$objectTable = new SmartObjectTable($smartbilling_webaccount_handler, $criteria);
		$objectTable->setTableId('createdwebaccounts');
		$objectTable->addColumn(new SmartObjectColumn('domain', 'left', false, 'getDomainLink'));
		$objectTable->addColumn(new SmartObjectColumn('accountid', 'left', 300, 'getAccountLink'));
		$objectTable->addColumn(new SmartObjectColumn('serverid', 'left', 200, 'getServerLink'));
		$objectTable->addColumn(new SmartObjectColumn('status', 'center', 100, 'getStatusControl'));
		$objectTable->addColumn(new SmartObjectColumn('next_billing_date', 'center', 120, 'getNextBillingDate'));
		$objectTable->addColumn(new SmartObjectColumn('monthly_cost', 'center', 100));

		$objectTable->addIntroButton('addwebaccount', 'webaccount.php?op=mod&accountid=' . $accountid, _AM_SBILLING_WEBACCOUNT_CREATE);
		$objectTable->addActionButton('updateWebaccountObjects', _SUBMIT, _CO_SOBJECT_UPDATE_ALL);
		$objectTable->render();

		echo "<br />";
		smart_close_collapsable('accountwebaccounts');
		echo "<br>";

		break;

	default:

		smart_xoops_cp_header();

		smart_adminMenu(2, _AM_SBILLING_ACCOUNTS);

		smart_collapsableBar('createdaccounts', _AM_SBILLING_ACCOUNTS, _AM_SBILLING_ACCOUNTS_DSC);

		include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";
		$objectTable = new SmartObjectTable($smartbilling_account_handler);
		$objectTable->addColumn(new SmartObjectColumn('name', 'left', false, 'getAccountLink'));
		$objectTable->addColumn(new SmartObjectColumn('contact_email', 'left'));
		$objectTable->addColumn(new SmartObjectColumn('contact_phone', 'left'));
		$objectTable->addColumn(new SmartObjectColumn('website', 'left'));

		$objectTable->addIntroButton('addaccount', 'account.php?op=mod', _AM_SBILLING_ACCOUNT_CREATE);

		$objectTable->addCustomAction('getAddInvoiceLink');

		$objectTable->addQuickSearch(array('name'));

		$objectTable->render();

		echo "<br />";
		smart_close_collapsable('createdaccounts');
		echo "<br>";

		break;
}

smart_modFooter();
xoops_cp_footer();

?>