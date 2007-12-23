<?php

/**
* $Id$
* Module: SmartBilling
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

function editdomain($showmenu = false, $domainid = 0, $parentid =0)
{
	global $smartbilling_domain_handler, $submenus;

	$domainObj = $smartbilling_domain_handler->get($domainid);

	$invoiceid = isset($_GET['invoiceid']) ? intval($_GET['invoiceid']) : 0 ;
	if ($invoiceid) {
		$domainObj->setVar('invoiceid', $invoiceid);
	}
	if (!$domainObj->isNew()){

		if ($showmenu) {
			smart_adminMenu(1, _AM_SBILLING_DOMAINS . " > " . _CO_SOBJECT_EDITING, $submenus, 2);
		}
		smart_collapsableBar('domainedit', _AM_SBILLING_DOMAIN_EDIT, _AM_SBILLING_DOMAIN_EDIT_INFO);

		$sform = $domainObj->getForm(_AM_SBILLING_DOMAIN_EDIT, 'adddomain');
		$sform->display();
		smart_close_collapsable('domainedit');
	} else {
		if ($showmenu) {
			smart_adminMenu(1, _AM_SBILLING_DOMAINS . " > " . _CO_SOBJECT_CREATINGNEW, $submenus, 2);
		}

		smart_collapsableBar('domaincreate', _AM_SBILLING_DOMAIN_CREATE, _AM_SBILLING_DOMAIN_CREATE_INFO);
		$sform = $domainObj->getForm(_AM_SBILLING_DOMAIN_CREATE, 'adddomain');
		$sform->display();
		smart_close_collapsable('domaincreate');
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

switch ($op) {
	case "mod":

		$domainid = isset($_GET['domainid']) ? intval($_GET['domainid']) : 0 ;

		smart_xoops_cp_header();

		editdomain(true, $domainid, $parentid);
		break;


	case "adddomain":
        include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smartbilling_domain_handler);
		$controller->storeFromDefaultForm(_AM_SBILLING_DOMAIN_CREATED, _AM_SBILLING_DOMAIN_MODIFIED);

		break;

	case "del":
	    include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smartbilling_domain_handler);
		$controller->handleObjectDeletion();

		break;

	default:

		smart_xoops_cp_header();

		smart_adminMenu(1, _AM_SBILLING_DOMAINS, $submenus, 2);

		smart_collapsableBar('createddomains', _AM_SBILLING_DOMAINS, _AM_SBILLING_DOMAINS_DSC);

		include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";
		$objectTable = new SmartObjectTable($smartbilling_domain_handler);
		$objectTable->addColumn(new SmartObjectColumn('name', 'left'));
		$objectTable->addColumn(new SmartObjectColumn('accountid', 'left', 300));
		$objectTable->addColumn(new SmartObjectColumn('registrar', 'left', 100));

		$objectTable->addIntroButton('adddomain', 'domain.php?op=mod', _AM_SBILLING_DOMAIN_CREATE);

		$objectTable->addQuickSearch(array('name', 'registrar'));

		$objectTable->render();

		echo "<br />";
		smart_close_collapsable('createddomains');
		echo "<br>";

		break;
}

smart_modFooter();
xoops_cp_footer();

?>