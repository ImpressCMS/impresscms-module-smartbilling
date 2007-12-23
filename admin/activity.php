<?php

/**
* $Id$
* Module: SmartBilling
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

function editactivity($showmenu = false, $activityid = 0, $parentid =0)
{
	global $smartbilling_activity_handler, $submenus;

	$activityObj = $smartbilling_activity_handler->get($activityid);

	$invoiceid = isset($_GET['invoiceid']) ? intval($_GET['invoiceid']) : 0 ;
	if ($invoiceid) {
		$activityObj->setVar('invoiceid', $invoiceid);
	}
	if (!$activityObj->isNew()){

		if ($showmenu) {
			smart_adminMenu(3, _AM_SBILLING_ACTIVITYS . " > " . _CO_SOBJECT_EDITING, $submenus);
		}
		smart_collapsableBar('activityedit', _AM_SBILLING_ACTIVITY_EDIT, _AM_SBILLING_ACTIVITY_EDIT_INFO);

		$sform = $activityObj->getForm(_AM_SBILLING_ACTIVITY_EDIT, 'addactivity');
		$sform->display();
		smart_close_collapsable('activityedit');
	} else {
		if ($showmenu) {
			smart_adminMenu(3, _AM_SBILLING_ACTIVITYS . " > " . _CO_SOBJECT_CREATINGNEW, $submenus);
		}

		smart_collapsableBar('activitycreate', _AM_SBILLING_ACTIVITY_CREATE, _AM_SBILLING_ACTIVITY_CREATE_INFO);
		$sform = $activityObj->getForm(_AM_SBILLING_ACTIVITY_CREATE, 'addactivity');
		$sform->display();
		smart_close_collapsable('activitycreate');
	}
}

include_once("admin_header.php");
include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";

$smartbilling_activity_handler = xoops_getModuleHandler('activity');

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

$activityid = isset($_GET['activityid']) ? intval($_GET['activityid']) : 0 ;

switch ($op) {
	case "mod":

		smart_xoops_cp_header();

		editactivity(true, $activityid, $parentid);
		break;


	case "addactivity":
        include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smartbilling_activity_handler);
		$controller->storeFromDefaultForm(_AM_SBILLING_ACTIVITY_CREATED, _AM_SBILLING_ACTIVITY_MODIFIED);

		break;

	case "del":
	    include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smartbilling_activity_handler);
		$controller->handleObjectDeletion();

		break;

	case "view" :
		$activityObj = $smartbilling_activity_handler->get($activityid);

		smart_xoops_cp_header();

		smart_adminMenu(3, _AM_SBILLING_ACTIVITY_VIEW . ' > ' . $activityObj->getVar('name'), $submenus, 3);

		smart_collapsableBar('activityview', $activityObj->getVar('name') . $activityObj->getEditItemLink(), _AM_SBILLING_ACTIVITY_VIEW_DSC);

		$activityObj->displaySingleObject();

		echo "<br />";
		smart_close_collapsable('activityview');
		echo "<br>";

/*		smart_collapsableBar('createdpayments', _AM_SBILLING_PAYMENTS, _AM_SBILLING_PAYMENTS_DSC);

		include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('payment.activityid', $activityid));

		$objectTable = new SmartObjectTable($smartbilling_payment_handler, $criteria);
		$objectTable->addColumn(new SmartObjectColumn('payment_date', 'left', false, 'getPaymentLink'));
		$objectTable->addColumn(new SmartObjectColumn('activityid', 'left', false, 'getProjectLink'));
		$objectTable->addColumn(new SmartObjectColumn('amount', 'right', 100));

		$objectTable->addIntroButton('addpayment', 'payment.php?op=mod&activityid=' . $activityid, _AM_SBILLING_PAYMENT_CREATE);

		//$objectTable->addQuickSearch(array('name'));

		$objectTable->render();

		echo "<br />";
		smart_close_collapsable('createdpayments');
		echo "<br>";
*/

		break;


	default:

//	  	$smart_registry = SmartObjectsRegistry::getInstance();
//	  	$smart_registry->addObjectsFromItemName('invoice');

		smart_xoops_cp_header();

		smart_adminMenu(3, _AM_SBILLING_ACTIVITYS, $submenus, 3);

		smart_collapsableBar('createdactivitys', _AM_SBILLING_ACTIVITYS, _AM_SBILLING_ACTIVITYS_DSC);

		include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";
		$objectTable = new SmartObjectTable($smartbilling_activity_handler);
		$objectTable->addColumn(new SmartObjectColumn('name', 'left', 150, 'getAdminViewItemLink'));
		$objectTable->addColumn(new SmartObjectColumn('description', 'left', false));

		$objectTable->addIntroButton('addactivity', 'activity.php?op=mod', _AM_SBILLING_ACTIVITY_CREATE);

		$objectTable->addQuickSearch(array('name'));

		$objectTable->render();

		echo "<br />";
		smart_close_collapsable('createdactivitys');
		echo "<br>";

		break;
}

smart_modFooter();
xoops_cp_footer();

?>