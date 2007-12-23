<?php

/**
* $Id$
* Module: SmartBilling
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

function editserver($showmenu = false, $serverid = 0, $parentid =0)
{
	global $smartbilling_server_handler, $submenus;

	$serverObj = $smartbilling_server_handler->get($serverid);

	$invoiceid = isset($_GET['invoiceid']) ? intval($_GET['invoiceid']) : 0 ;
	if ($invoiceid) {
		$serverObj->setVar('invoiceid', $invoiceid);
	}
	if (!$serverObj->isNew()){

		if ($showmenu) {
			smart_adminMenu(1, _AM_SBILLING_SERVERS . " > " . _CO_SOBJECT_EDITING, $submenus, 1);
		}
		smart_collapsableBar('serveredit', _AM_SBILLING_SERVER_EDIT, _AM_SBILLING_SERVER_EDIT_INFO);

		$sform = $serverObj->getForm(_AM_SBILLING_SERVER_EDIT, 'addserver');
		$sform->display();
		smart_close_collapsable('serveredit');
	} else {
		if ($showmenu) {
			smart_adminMenu(1, _AM_SBILLING_SERVERS . " > " . _CO_SOBJECT_CREATINGNEW, $submenus, 1);
		}

		smart_collapsableBar('servercreate', _AM_SBILLING_SERVER_CREATE, _AM_SBILLING_SERVER_CREATE_INFO);
		$sform = $serverObj->getForm(_AM_SBILLING_SERVER_CREATE, 'addserver');
		$sform->display();
		smart_close_collapsable('servercreate');
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
$submenus[$i]['title'] = _AM_SBILLING_MENU_WEBACCOUNTS;
$submenus[$i]['link'] = 'webaccount.php';

$i++;
$submenus[$i]['title'] = _AM_SBILLING_SUBMENU_SERVERS;
$submenus[$i]['link'] = 'server.php';

$i++;
$submenus[$i]['title'] = _AM_SBILLING_SUBMENU_DOMAINS;
$submenus[$i]['link'] = 'domain.php';

$i++;
$submenus[$i]['title'] = _AM_SBILLING_SUBMENU_SUPPLIERS;
$submenus[$i]['link'] = 'supplier.php';

$serverid = isset($_GET['serverid']) ? intval($_GET['serverid']) : 0 ;

switch ($op) {
	case "export":
		if (!isset($_POST['createdwebaccounts_objects']) || count($_POST['createdwebaccounts_objects']) == 0) {
			redirect_header($smart_previous_page, 3);
			exit;
		}

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('webaccountid', '(' . implode(', ', $_POST['createdwebaccounts_objects']) . ')', 'IN'));

		include_once(SMARTOBJECT_ROOT_PATH . 'class/smartexport.php');
		$smartObjectExport = new SmartObjectExport($smartbilling_webaccount_handler, $criteria);
		$smartObjectExport->render();
		exit;

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

	case "mod":

		smart_xoops_cp_header();

		editserver(true, $serverid, $parentid);
		break;

  case "view" :

  	$smart_registry = SmartObjectsRegistry::getInstance();
  	$smart_registry->addObjectsFromItemName('server');

    $serverObj = $smart_registry->getSingleObject('server', $serverid);

    smart_xoops_cp_header();

    smart_adminMenu(1, _AM_SBILLING_SERVER_VIEW . ' > ' . $serverObj->getVar('name'), $submenus);

    smart_collapsableBar('serverview', $serverObj->getVar('name') . ' ' . $serverObj->getEditItemLink(), _AM_SBILLING_SERVER_VIEW_DSC);

    $serverObj->displaySingleObject();

    echo "<br />";
    smart_close_collapsable('serverview');
    echo "<br>";

	smart_collapsableBar('accountwebaccounts', _AM_SBILLING_SERVER_WEBACCOUNTS, _AM_SBILLING_SERVER_WEBACCOUNTS_DSC);

	$criteria = new CriteriaCompo();
	$criteria->add(new Criteria('serverid', $serverid));

	include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";
	$objectTable = new SmartObjectTable($smartbilling_webaccount_handler, $criteria);
	$objectTable->setTableId('createdwebaccounts');
	$objectTable->addColumn(new SmartObjectColumn('domain', 'left', false, 'getDomainLink'));
	$objectTable->addColumn(new SmartObjectColumn('accountid', 'left', 300, 'getAccountLink'));
	$objectTable->addColumn(new SmartObjectColumn('serverid', 'left', 200, 'getServerLink'));
	$objectTable->addColumn(new SmartObjectColumn('status', 'center', 100, 'getStatusControl'));
	$objectTable->addColumn(new SmartObjectColumn('next_billing_date', 'center', 120, 'getNextBillingDate'));
	$objectTable->addColumn(new SmartObjectColumn('monthly_cost', 'center', 100));

	$objectTable->addIntroButton('addwebaccount', 'webaccount.php?op=mod&serverid=' . $serverid, _AM_SBILLING_WEBACCOUNT_CREATE);

	$objectTable->addQuickSearch(array('domain', 'account.name'));

	$criteria_due30 = new CriteriaCompo();
	$criteria_due30->add(new Criteria('next_billing_date', time() + (60 * 60 * 24 * 30), '<'));
	$criteria_due30->add(new Criteria('next_billing_date', time(), '>'));
	$criteria_due30->add(new Criteria('status', SMARTBILLING_WEBACCOUNT_STATUS_NORMAL));

	$objectTable->addFilter(_CO_SBILLING_WEB_ACCOUNT_30DAYS, array(
								'key' => 'next_billing_date',
								'criteria' => $criteria_due30
	));

	$criteria_due = new CriteriaCompo();
	$criteria_due->add(new Criteria('next_billing_date', time(), '<'));
	$criteria_due->add(new Criteria('status', SMARTBILLING_WEBACCOUNT_STATUS_NORMAL));
	$objectTable->addFilter(_CO_SBILLING_WEB_ACCOUNT_DUE, array(
								'key' => 'next_billing_date',
								'criteria' => $criteria_due
	));
	$objectTable->addFilter('status', 'getStatus');

	$objectTable->addActionButton('updateWebaccountObjects', _SUBMIT, _CO_SOBJECT_UPDATE_ALL);
	$objectTable->addActionButton('export', _SUBMIT, _CO_SOBJECT_EXPORT);
	$objectTable->render();
	echo "<br />";
	smart_close_collapsable('accountwebaccounts');
	echo "<br>";

    break;

	case "addserver":
        include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smartbilling_server_handler);
		$controller->storeFromDefaultForm(_AM_SBILLING_SERVER_CREATED, _AM_SBILLING_SERVER_MODIFIED);

		break;

	case "del":
	    include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smartbilling_server_handler);
		$controller->handleObjectDeletion();

		break;

	default:

		$smart_registry = SmartObjectsRegistry::getInstance();
  		$smart_registry->addObjectsFromItemName('supplier');

		smart_xoops_cp_header();

		smart_adminMenu(1, _AM_SBILLING_SERVERS, $submenus, 1);

		smart_collapsableBar('createdservers', _AM_SBILLING_SERVERS, _AM_SBILLING_SERVERS_DSC);

		include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";
		$objectTable = new SmartObjectTable($smartbilling_server_handler);
		$objectTable->addColumn(new SmartObjectColumn('name', 'left', false, 'getAdminViewItemLink'));
		$objectTable->addColumn(new SmartObjectColumn('supplierid', 'left', 300));

		$objectTable->addIntroButton('addserver', 'server.php?op=mod', _AM_SBILLING_SERVER_CREATE);

		$objectTable->addQuickSearch(array('name'));

		$objectTable->render();

		echo "<br />";
		smart_close_collapsable('createdservers');
		echo "<br>";

		break;
}

smart_modFooter();
xoops_cp_footer();

?>