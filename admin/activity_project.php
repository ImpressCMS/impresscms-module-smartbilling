<?php

/**
* $Id$
* Module: SmartBilling
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

function editactivity_project($showmenu = false, $activity_projectid = 0, $parentid =0)
{
	global $smartbilling_activity_project_handler, $submenus;

	$activity_projectObj = $smartbilling_activity_project_handler->get($activity_projectid);

	$invoiceid = isset($_GET['invoiceid']) ? intval($_GET['invoiceid']) : 0 ;
	if ($invoiceid) {
		$activity_projectObj->setVar('invoiceid', $invoiceid);
	}
	if (!$activity_projectObj->isNew()){

		if ($showmenu) {
			smart_adminMenu(1, _AM_SBILLING_ACTIVITY_PROJECTS . " > " . _CO_SOBJECT_EDITING, $submenus, 2);
		}
		smart_collapsableBar('activity_projectedit', _AM_SBILLING_ACTIVITY_PROJECT_EDIT, _AM_SBILLING_ACTIVITY_PROJECT_EDIT_INFO);

		$sform = $activity_projectObj->getForm(_AM_SBILLING_ACTIVITY_PROJECT_EDIT, 'addactivity_project');
		$sform->display();
		smart_close_collapsable('activity_projectedit');
	} else {
		if ($showmenu) {
			smart_adminMenu(1, _AM_SBILLING_ACTIVITY_PROJECTS . " > " . _CO_SOBJECT_CREATINGNEW, $submenus, 2);
		}

		smart_collapsableBar('activity_projectcreate', _AM_SBILLING_ACTIVITY_PROJECT_CREATE, _AM_SBILLING_ACTIVITY_PROJECT_CREATE_INFO);
		$sform = $activity_projectObj->getForm(_AM_SBILLING_ACTIVITY_PROJECT_CREATE, 'addactivity_project');
		$sform->display();
		smart_close_collapsable('activity_projectcreate');
	}
}

include_once("admin_header.php");
include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";

$smartbilling_activity_project_handler = xoops_getModuleHandler('activity_project');

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

switch ($op) {
	case "mod":

		$activity_projectid = isset($_GET['activity_projectid']) ? intval($_GET['activity_projectid']) : 0 ;

		smart_xoops_cp_header();

		editactivity_project(true, $activity_projectid, $parentid);
		break;


	case "addactivity_project":
        include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smartbilling_activity_project_handler);
		$controller->storeFromDefaultForm(_AM_SBILLING_ACTIVITY_PROJECT_CREATED, _AM_SBILLING_ACTIVITY_PROJECT_MODIFIED);

		break;

	case "del":
	    include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smartbilling_activity_project_handler);
		$controller->handleObjectDeletion();

		break;

	default:

		smart_xoops_cp_header();

		smart_adminMenu(1, _AM_SBILLING_ACTIVITY_PROJECTS, $submenus, 2);

		smart_collapsableBar('createdactivity_projects', _AM_SBILLING_ACTIVITY_PROJECTS, _AM_SBILLING_ACTIVITY_PROJECTS_DSC);

		include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";
		$objectTable = new SmartObjectTable($smartbilling_activity_project_handler);
		$objectTable->addColumn(new SmartObjectColumn('activityid', 'left'));
		$objectTable->addColumn(new SmartObjectColumn('projectid', 'left'));

		$objectTable->addIntroButton('addactivity_project', 'activity_project.php?op=mod', _AM_SBILLING_ACTIVITY_PROJECT_CREATE);

		$objectTable->addQuickSearch(array('name', 'registrar'));

		$objectTable->render();

		echo "<br />";
		smart_close_collapsable('createdactivity_projects');
		echo "<br>";

		break;
}

smart_modFooter();
xoops_cp_footer();

?>