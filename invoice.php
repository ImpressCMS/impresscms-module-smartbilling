<?php
/**
* $Id$
* Module: SmartContent
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

include_once('header.php');

if (!is_object($xoopsUser)) {
	redirect_header(XOOPS_URL, 3, _NOPERM);
	exit;
}

$xoopsOption['template_main'] = 'smartbilling_invoice.html';
include_once(XOOPS_ROOT_PATH . "/header.php");
include_once("footer.php");

$op = '';

if (isset($_GET['op'])) $op = $_GET['op'];
if (isset($_POST['op'])) $op = $_POST['op'];

$smartbilling_invoice_handler = xoops_getModuleHandler('invoice');
$invoiceid = isset($_GET['invoiceid']) ? intval($_GET['invoiceid']) : 0 ;

if ($invoiceid) {
	$op = 'view';
}

switch ($op) {
	case "view" :
		$invoiceObj = $smartbilling_invoice_handler->get($invoiceid);

		if (!$invoiceObj->accessGranted($xoopsUser->uid())) {
			redirect_header(SMARTBILLING_URL, 3, _NOPERM);
			exit;
		}

		$xoopsTpl->assign('smartbilling_invoice_single_view', $invoiceObj->displaySingleObject(true));

		include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('payment.invoiceid', $invoiceid));

		$objectTable = new SmartObjectTable($smartbilling_payment_handler, $criteria, array());
		$objectTable->addColumn(new SmartObjectColumn('payment_date', 'center', 150, 'getPaymentLink'));
		$objectTable->addColumn(new SmartObjectColumn('invoiceid', 'left', false));
		$objectTable->addColumn(new SmartObjectColumn('amount', 'center', 100));

		$xoopsTpl->assign('smartbilling_payments', $objectTable->fetch());
		$xoopsTpl->assign('categoryPath', '<a href="invoice.php">' . _MD_SBILLING_INVOICE_MYINVOICES . '</a> > ' . $invoiceObj->getVar('invoice_number'));

		break;

	default:

		include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";

		$smart_registry = SmartObjectsRegistry::getInstance();
  		$smart_registry->addObjectsFromItemName('account');

		$smartbilling_account_user_handler = xoops_getModuleHandler('account_user');
		$accountids = $smartbilling_account_user_handler->getGrantedAccountids($xoopsUser->uid());

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('invoice.accountid', '(' . implode(', ', $accountids) . ')', 'IN'));

		$objectTable = new SmartObjectTable($smartbilling_invoice_handler, $criteria, array());
		$objectTable->isForUserSide();

		$objectTable->addColumn(new SmartObjectColumn('date', 'center', 100));
		$objectTable->addColumn(new SmartObjectColumn('invoice_number', 'center', 200));
		$objectTable->addColumn(new SmartObjectColumn('amount', 'center', 100));
		$objectTable->addColumn(new SmartObjectColumn('currency', 'center', 75));
		$objectTable->addColumn(new SmartObjectColumn(_MD_SBILLING_TOTAL_BALANCE, 'center', 100, 'getAmountReceivable'));
		$objectTable->addColumn(new SmartObjectColumn('note', 'left'));
		$objectTable->addColumn(new SmartObjectColumn('status', 'center', 50));

		$objectTable->addQuickSearch(array('name', 'invoice_number'));

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

		$xoopsTpl->assign('smartbilling_invoices', $objectTable->fetch());
		$xoopsTpl->assign('categoryPath', _MD_SBILLING_INVOICE_MYINVOICES);

		break;
}
$xoopsTpl->assign('module_home', smart_getModuleName(false, true));

include_once(XOOPS_ROOT_PATH . '/footer.php');
?>