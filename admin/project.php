<?php

/**
* $Id$
* Module: SmartBilling
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

function editproject($showmenu = false, $projectid = 0, $parentid =0)
{
	global $smartbilling_project_handler, $submenus;

	$projectObj = $smartbilling_project_handler->get($projectid);

	$invoiceid = isset($_GET['invoiceid']) ? intval($_GET['invoiceid']) : 0 ;
	if ($invoiceid) {
		$projectObj->setVar('invoiceid', $invoiceid);
	}
	if (!$projectObj->isNew()){

		if ($showmenu) {
			smart_adminMenu(3, _AM_SBILLING_PROJECTS . " > " . _CO_SOBJECT_EDITING, $submenus);
		}
		smart_collapsableBar('projectedit', _AM_SBILLING_PROJECT_EDIT, _AM_SBILLING_PROJECT_EDIT_INFO);

		$sform = $projectObj->getForm(_AM_SBILLING_PROJECT_EDIT, 'addproject');
		$sform->display();
		smart_close_collapsable('projectedit');
	} else {
		if ($showmenu) {
			smart_adminMenu(3, _AM_SBILLING_PROJECTS . " > " . _CO_SOBJECT_CREATINGNEW, $submenus);
		}

		smart_collapsableBar('projectcreate', _AM_SBILLING_PROJECT_CREATE, _AM_SBILLING_PROJECT_CREATE_INFO);
		$sform = $projectObj->getForm(_AM_SBILLING_PROJECT_CREATE, 'addproject');
		$sform->display();
		smart_close_collapsable('projectcreate');
	}
}

include_once("admin_header.php");
include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";

$smartbilling_project_handler = xoops_getModuleHandler('project');

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

$projectid = isset($_GET['projectid']) ? intval($_GET['projectid']) : 0 ;

switch ($op) {
	case "mod":

		smart_xoops_cp_header();

		editproject(true, $projectid, $parentid);
		break;


	case "addproject":
        include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smartbilling_project_handler);
		$controller->storeFromDefaultForm(_AM_SBILLING_PROJECT_CREATED, _AM_SBILLING_PROJECT_MODIFIED);

		break;

	case "del":
	    include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smartbilling_project_handler);
		$controller->handleObjectDeletion();

		break;

	case "view" :
		$projectObj = $smartbilling_project_handler->get($projectid);

		smart_xoops_cp_header();

		smart_adminMenu(3, _AM_SBILLING_PROJECT_VIEW . ' > ' . $projectObj->getVar('name'), $submenus, 2);

		smart_collapsableBar('projectview', $projectObj->getVar('name') . $projectObj->getEditItemLink(), _AM_SBILLING_PROJECT_VIEW_DSC);

		$projectObj->displaySingleObject();

		echo "<br />";
		smart_close_collapsable('projectview');
		echo "<br>";

/*		smart_collapsableBar('createdpayments', _AM_SBILLING_PAYMENTS, _AM_SBILLING_PAYMENTS_DSC);

		include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('payment.projectid', $projectid));

		$objectTable = new SmartObjectTable($smartbilling_payment_handler, $criteria);
		$objectTable->addColumn(new SmartObjectColumn('payment_date', 'left', false, 'getPaymentLink'));
		$objectTable->addColumn(new SmartObjectColumn('projectid', 'left', false, 'getProjectLink'));
		$objectTable->addColumn(new SmartObjectColumn('amount', 'right', 100));

		$objectTable->addIntroButton('addpayment', 'payment.php?op=mod&projectid=' . $projectid, _AM_SBILLING_PAYMENT_CREATE);

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

		smart_adminMenu(3, _AM_SBILLING_PROJECTS, $submenus, 2);

		smart_collapsableBar('createdprojects', _AM_SBILLING_PROJECTS, _AM_SBILLING_PROJECTS_DSC);

		include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";
		$objectTable = new SmartObjectTable($smartbilling_project_handler);
		$objectTable->addColumn(new SmartObjectColumn('name', 'left', 150, 'getAdminViewItemLink'));
		$objectTable->addColumn(new SmartObjectColumn('description', 'left', false));

		$objectTable->addIntroButton('addproject', 'project.php?op=mod', _AM_SBILLING_PROJECT_CREATE);

		$objectTable->addQuickSearch(array('name'));

		$objectTable->render();

		echo "<br />";
		smart_close_collapsable('createdprojects');
		echo "<br>";

		break;
}

smart_modFooter();
xoops_cp_footer();

?>