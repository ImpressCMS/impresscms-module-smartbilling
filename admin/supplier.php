<?php

/**
* $Id$
* Module: SmartBilling
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

function editsupplier($showmenu = false, $supplierid = 0, $parentid =0)
{
	global $smartbilling_supplier_handler, $submenus;

	$supplierObj = $smartbilling_supplier_handler->get($supplierid);

	$invoiceid = isset($_GET['invoiceid']) ? intval($_GET['invoiceid']) : 0 ;
	if ($invoiceid) {
		$supplierObj->setVar('invoiceid', $invoiceid);
	}
	if (!$supplierObj->isNew()){

		if ($showmenu) {
			smart_adminMenu(1, _AM_SBILLING_SUPPLIERS . " > " . _CO_SOBJECT_EDITING, $submenus, 3);
		}
		smart_collapsableBar('supplieredit', _AM_SBILLING_SUPPLIER_EDIT, _AM_SBILLING_SUPPLIER_EDIT_INFO);

		$sform = $supplierObj->getForm(_AM_SBILLING_SUPPLIER_EDIT, 'addsupplier');
		$sform->display();
		smart_close_collapsable('supplieredit');
	} else {
		if ($showmenu) {
			smart_adminMenu(1, _AM_SBILLING_SUPPLIERS . " > " . _CO_SOBJECT_CREATINGNEW, $submenus, 3);
		}

		smart_collapsableBar('suppliercreate', _AM_SBILLING_SUPPLIER_CREATE, _AM_SBILLING_SUPPLIER_CREATE_INFO);
		$sform = $supplierObj->getForm(_AM_SBILLING_SUPPLIER_CREATE, 'addsupplier');
		$sform->display();
		smart_close_collapsable('suppliercreate');
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

		$supplierid = isset($_GET['supplierid']) ? intval($_GET['supplierid']) : 0 ;

		smart_xoops_cp_header();

		editsupplier(true, $supplierid, $parentid);
		break;


	case "addsupplier":
        include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smartbilling_supplier_handler);
		$controller->storeFromDefaultForm(_AM_SBILLING_SUPPLIER_CREATED, _AM_SBILLING_SUPPLIER_MODIFIED);

		break;

	case "del":
	    include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smartbilling_supplier_handler);
		$controller->handleObjectDeletion();

		break;

	default:

		smart_xoops_cp_header();

		smart_adminMenu(1, _AM_SBILLING_SUPPLIERS, $submenus, 3);

		smart_collapsableBar('createdsuppliers', _AM_SBILLING_SUPPLIERS, _AM_SBILLING_SUPPLIERS_DSC);

		include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";
		$objectTable = new SmartObjectTable($smartbilling_supplier_handler);
		$objectTable->addColumn(new SmartObjectColumn('name', 'left'));

		$objectTable->addIntroButton('addsupplier', 'supplier.php?op=mod', _AM_SBILLING_SUPPLIER_CREATE);

		$objectTable->addQuickSearch(array('name'));

		$objectTable->render();

		echo "<br />";
		smart_close_collapsable('createdsuppliers');
		echo "<br>";

		break;
}

smart_modFooter();
xoops_cp_footer();

?>