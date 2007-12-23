<?php

/**
* $Id$
* Module: SmartBilling
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

function editwebaccount($showmenu = false, $webaccountid = 0, $parentid =0)
{
	global $smartbilling_webaccount_handler, $submenus;

	$webaccountObj = $smartbilling_webaccount_handler->get($webaccountid);

	$accountid = isset($_GET['accountid']) ? intval($_GET['accountid']) : 0 ;
	$serverid = isset($_GET['serverid']) ? intval($_GET['serverid']) : 0 ;

	if ($accountid) {
		$webaccountObj->setVar('accountid', $accountid);
	}
	if ($serverid) {
		$webaccountObj->setVar('serverid', $serverid);
	}
	if (!$webaccountObj->isNew()){

		if ($showmenu) {
			smart_adminMenu(1, _AM_SBILLING_WEBACCOUNTS . " > " . _CO_SOBJECT_EDITING, $submenus, 0);
		}
		smart_collapsableBar('webaccountedit', _AM_SBILLING_WEBACCOUNT_EDIT, _AM_SBILLING_WEBACCOUNT_EDIT_INFO);

		$sform = $webaccountObj->getForm(_AM_SBILLING_WEBACCOUNT_EDIT, 'addwebaccount');
		$sform->display();
		smart_close_collapsable('webaccountedit');
	} else {
		if ($showmenu) {
			smart_adminMenu(1, _AM_SBILLING_WEBACCOUNTS . " > " . _CO_SOBJECT_CREATINGNEW, $submenus, 0);
		}

		smart_collapsableBar('webaccountcreate', _AM_SBILLING_WEBACCOUNT_CREATE, _AM_SBILLING_WEBACCOUNT_CREATE_INFO);
		$sform = $webaccountObj->getForm(_AM_SBILLING_WEBACCOUNT_CREATE, 'addwebaccount');
		$sform->display();
		smart_close_collapsable('webaccountcreate');
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

$webaccountid = isset($_GET['webaccountid']) ? intval($_GET['webaccountid']) : 0 ;

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

	case "mod":

		smart_xoops_cp_header();

		editwebaccount(true, $webaccountid, $parentid);
		break;

  case "view" :

    $webaccountObj = $smartbilling_webaccount_handler->get($webaccountid);

    smart_xoops_cp_header();

    smart_adminMenu(1, _AM_SBILLING_WEBACCOUNT_VIEW . ' > ' . $webaccountObj->getVar('domain'), $submenus);

    smart_collapsableBar('webaccountview', $webaccountObj->getVar('domain') . ' ' . $webaccountObj->getEditItemLink(), _AM_SBILLING_WEBACCOUNT_VIEW_DSC);

    $webaccountObj->displaySingleObject();

    echo "<br />";
    smart_close_collapsable('webaccountview');
    echo "<br>";

    break;

	case "addwebaccount":
        include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smartbilling_webaccount_handler);
		$controller->storeFromDefaultForm(_AM_SBILLING_WEBACCOUNT_CREATED, _AM_SBILLING_WEBACCOUNT_MODIFIED);

		break;

	case "del":
	    include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smartbilling_webaccount_handler);
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


	default:

  		$smart_registry = SmartObjectsRegistry::getInstance();
  		$smart_registry->addObjectsFromItemName('account');
		$smart_registry->addObjectsFromItemName('server');

		smart_xoops_cp_header();

		smart_adminMenu(1, _AM_SBILLING_WEBACCOUNTS, $submenus, 0);

		smart_collapsableBar('createdwebaccounts', _AM_SBILLING_WEBACCOUNTS, _AM_SBILLING_WEBACCOUNTS_DSC);

		include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";
		$objectTable = new SmartObjectTable($smartbilling_webaccount_handler);
		$objectTable->setTableId('createdwebaccounts');
		$objectTable->addColumn(new SmartObjectColumn('domain', 'left', false, 'getDomainLink'));
		$objectTable->addColumn(new SmartObjectColumn('accountid', 'left', 300, 'getAccountLink'));
		$objectTable->addColumn(new SmartObjectColumn('serverid', 'left', 200, 'getServerLink'));
		$objectTable->addColumn(new SmartObjectColumn('status', 'center', 100, 'getStatusControl'));
		$objectTable->addColumn(new SmartObjectColumn('next_billing_date', 'center', 120, 'getNextBillingDate'));
		$objectTable->addColumn(new SmartObjectColumn('monthly_cost', 'center', 100));

		$objectTable->addIntroButton('addwebaccount', 'webaccount.php?op=mod', _AM_SBILLING_WEBACCOUNT_CREATE);

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
		smart_close_collapsable('createdwebaccounts');
		echo "<br>";

		break;
}

smart_modFooter();
xoops_cp_footer();

?>