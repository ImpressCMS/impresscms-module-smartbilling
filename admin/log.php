<?php

/**
* $Id$
* Module: SmartBilling
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

function editlog($showmenu = false, $logid = 0, $parentid =0)
{
	global $smartbilling_log_handler, $submenus;

	$logObj = $smartbilling_log_handler->get($logid);
	$logObj->hideFieldFromForm('log_date');

	if (isset($_POST['op'])) {
		$controller = new SmartObjectController($smartbilling_log_handler);
		$controller->postDataToObject($logObj);

		if ($_POST['op'] == 'changedField') {

			switch($_POST['changedField']) {
				case 'projectid':

				break;
			}
		}
	}

	if (!$logObj->isNew()){

		if ($showmenu) {
			smart_adminMenu(3, _AM_SBILLING_LOGS . " > " . _CO_SOBJECT_EDITING, $submenus);
		}
		smart_collapsableBar('logedit', _AM_SBILLING_LOG_EDIT, _AM_SBILLING_LOG_EDIT_INFO);

		$sform = $logObj->getForm(_AM_SBILLING_LOG_EDIT, 'addlog');
		$sform->display();
		smart_close_collapsable('logedit');
	} else {
		if ($showmenu) {
			smart_adminMenu(3, _AM_SBILLING_LOGS . " > " . _CO_SOBJECT_CREATINGNEW, $submenus);
		}

		smart_collapsableBar('logcreate', _AM_SBILLING_LOG_CREATE, _AM_SBILLING_LOG_CREATE_INFO);
		$sform = $logObj->getForm(_AM_SBILLING_LOG_CREATE, 'addlog');
		$sform->display();
		smart_close_collapsable('logcreate');
	}
}

include_once("admin_header.php");
include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";

$smartbilling_log_handler = xoops_getModuleHandler('log');

$op = '';

if (isset($_GET['op'])) $op = $_GET['op'];
if (isset($_POST['op'])) $op = $_POST['op'];

// Adding AdminMenu sublinks
$i = -1;

$i++;
$submenus[$i]['title'] = _AM_SBILLING_SUBMENU_LOG;
$submenus[$i]['link'] = 'log.php';

$i++;
$submenus[$i]['title'] = _AM_SBILLING_SUBMENU_REPORTS;
$submenus[$i]['link'] = 'reports.php';

$i++;
$submenus[$i]['title'] = _AM_SBILLING_SUBMENU_PROJECTS;
$submenus[$i]['link'] = 'project.php';

$i++;
$submenus[$i]['title'] = _AM_SBILLING_SUBMENU_ACTIVITIES;
$submenus[$i]['link'] = 'activity.php';

$logid = isset($_GET['logid']) ? intval($_GET['logid']) : 0 ;

switch ($op) {
	case "mod":
	case "changedField":

		smart_xoops_cp_header();

		editlog(true, $logid);
		break;


	case "addlog":
        include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smartbilling_log_handler);
		$controller->storeFromDefaultForm(_AM_SBILLING_LOG_CREATED, _AM_SBILLING_LOG_MODIFIED);

		break;

	case "del":
	    include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smartbilling_log_handler);
		$controller->handleObjectDeletion();

		break;

	case "view" :
		$logObj = $smartbilling_log_handler->get($logid);

		smart_xoops_cp_header();

		smart_adminMenu(3, _AM_SBILLING_LOG_VIEW . ' > ' . $logObj->getVar('name'), $submenus, 2);

		smart_collapsableBar('logview', $logObj->getVar('name') . $logObj->getEditItemLink(), _AM_SBILLING_LOG_VIEW_DSC);

		$logObj->displaySingleObject();

		echo "<br />";
		smart_close_collapsable('logview');
		echo "<br>";

/*		smart_collapsableBar('createdpayments', _AM_SBILLING_PAYMENTS, _AM_SBILLING_PAYMENTS_DSC);

		include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('payment.logid', $logid));

		$objectTable = new SmartObjectTable($smartbilling_payment_handler, $criteria);
		$objectTable->addColumn(new SmartObjectColumn('payment_date', 'left', false, 'getPaymentLink'));
		$objectTable->addColumn(new SmartObjectColumn('logid', 'left', false, 'getLogLink'));
		$objectTable->addColumn(new SmartObjectColumn('amount', 'right', 100));

		$objectTable->addIntroButton('addpayment', 'payment.php?op=mod&logid=' . $logid, _AM_SBILLING_PAYMENT_CREATE);

		//$objectTable->addQuickSearch(array('name'));

		$objectTable->render();

		echo "<br />";
		smart_close_collapsable('createdpayments');
		echo "<br>";
*/

		break;

	default:

	  	$smart_registry = SmartObjectsRegistry::getInstance();
	  	$smart_registry->addObjectsFromItemName('account');
	  	$smart_registry->addObjectsFromItemName('project');
	  	$smart_registry->addObjectsFromItemName('activity');

		smart_xoops_cp_header();

		smart_adminMenu(3, _AM_SBILLING_LOGS, $submenus, 0);

		smart_collapsableBar('createdlogs', _AM_SBILLING_LOGS, _AM_SBILLING_LOGS_DSC);

		include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";
		$objectTable = new SmartObjectTable($smartbilling_log_handler);
		$objectTable->addColumn(new SmartObjectColumn('log_date', 'left', 150, 'getLogDate'));
		$objectTable->addColumn(new SmartObjectColumn('uid', 'left', 150));
		$objectTable->addColumn(new SmartObjectColumn('projectid', 'left', 150));
		$objectTable->addColumn(new SmartObjectColumn('activityid', 'left', 150));
		$objectTable->addColumn(new SmartObjectColumn('accountid', 'left', false, 'getAccountLink'));
		$objectTable->addColumn(new SmartObjectColumn('duration', 'right', 100));

		$objectTable->addIntroButton('addlog', 'log.php?op=mod', _AM_SBILLING_LOG_CREATE);

		//$objectTable->addQuickSearch(array('name'));

		$objectTable->addFilter('uid', 'getUsers');
		$objectTable->addFilter('accountid', 'getAccounts');

		$objectTable->render();

		echo "<br />";
		smart_close_collapsable('createdlogs');
		echo "<br>";

		break;
}

smart_modFooter();
xoops_cp_footer();

?>