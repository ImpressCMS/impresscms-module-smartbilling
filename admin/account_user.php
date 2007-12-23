<?php

/**
* $Id$
* Module: SmartBilling
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

function editaccount_user($showmenu = false, $account_userid = 0, $parentid =0)
{
	global $smartbilling_account_user_handler, $submenus, $accountid;

	if (!$accountid) {
		redirect_header('account.php', 3, _NOPERM);
		exit;
	}

	$account_userObj = $smartbilling_account_user_handler->get($account_userid);
	$account_userObj->setVar('accountid', $accountid);

	if (isset($_POST['op'])) {
		$controller = new SmartObjectController($smartbilling_account_user_handler);
		$controller->postDataToObject($account_userObj);

		if ($_POST['op'] == 'changedField') {

			switch($_POST['changedField']) {
				case 'uid':
					if ($account_userObj->getVar('uid') == 'new') {
						$account_userObj->showFieldOnForm(array('user_realname', 'user_email', 'user_url', 'user_uname', 'user_password', 'user_notification'));
						$account_userObj->setFieldAsRequired(array('user_realname', 'user_email'));
					} else {
						$account_userObj->hideFieldFromForm(array('user_realname', 'user_email', 'user_url', 'user_uname', 'user_password', 'user_notification'));
						$account_userObj->setVar('user_realname', false);
						$account_userObj->setVar('user_email', false);
						$account_userObj->setVar('user_url', false);
						$account_userObj->setVar('user_uname', false);
						$account_userObj->setVar('user_password', false);
					}
				break;
			}
		}
	}

	if ($showmenu) {
		smart_adminMenu(2, _AM_SBILLING_ACCOUNT_USERS . " > " . _CO_SOBJECT_CREATINGNEW, $submenus, 1);
	}

	smart_collapsableBar('account_usercreate', _AM_SBILLING_ACCOUNT_USER_CREATE, _AM_SBILLING_ACCOUNT_USER_CREATE_INFO);
	$sform = $account_userObj->getForm(_AM_SBILLING_ACCOUNT_USER_CREATE, 'addaccount_user');
	$sform->display();
	smart_close_collapsable('account_usercreate');
}

include_once("admin_header.php");
include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";

$smartbilling_account_user_handler = xoops_getmodulehandler('account_user');

$op = '';

if (isset($_GET['op'])) $op = $_GET['op'];
if (isset($_POST['op'])) $op = $_POST['op'];

$accountid = isset($_GET['accountid']) ? $_GET['accountid'] : 0;

$account_userid = isset($_GET['account_userid']) ? intval($_GET['account_userid']) : 0 ;

switch ($op) {
	case "mod":
	case "changedField":

		smart_xoops_cp_header();

		editaccount_user(true, $account_userid, $parentid);
		break;

	case "addaccount_user":
        include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smartbilling_account_user_handler);
		$controller->storeFromDefaultForm(_AM_SBILLING_ACCOUNT_USER_CREATED, _AM_SBILLING_ACCOUNT_USER_MODIFIED);

		break;

	case "del":
	    include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smartbilling_account_user_handler);
		$controller->handleObjectDeletion();

		break;

	default:

		redirect_header('account.php', 3, _NOPERM);
		exit;
		break;
}

smart_modFooter();
xoops_cp_footer();

?>