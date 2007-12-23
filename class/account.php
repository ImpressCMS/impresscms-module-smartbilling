<?php
// $Id$
// ------------------------------------------------------------------------ //
// 				 XOOPS - PHP Content Management System                      //
//					 Copyright (c) 2000 XOOPS.org                           //
// 						<http://www.xoops.org/>                             //
// ------------------------------------------------------------------------ //
// This program is free software; you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License, or        //
// (at your option) any later version.                                      //

// You may not change or alter any portion of this comment or credits       //
// of supporting developers from this source code or any supporting         //
// source code which is considered copyrighted (c) material of the          //
// original comment or credit authors.                                      //
// This program is distributed in the hope that it will be useful,          //
// but WITHOUT ANY WARRANTY; without even the implied warranty of           //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
// GNU General Public License for more details.                             //

// You should have received a copy of the GNU General Public License        //
// along with this program; if not, write to the Free Software              //
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
// ------------------------------------------------------------------------ //
// URL: http://www.xoops.org/												//
// Project: The XOOPS Project                                               //
// -------------------------------------------------------------------------//

if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}
include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobject.php";
class SmartbillingAccount extends SmartObject {

    function SmartbillingAccount() {
        $this->quickInitVar('accountid', XOBJ_DTYPE_INT, true);
        $this->quickInitVar('name', XOBJ_DTYPE_TXTBOX, true, _CO_SBILLING_ACCOUNT_NAME, _CO_SBILLING_ACCOUNT_NAME_DSC);
        $this->quickInitVar('contact_email', XOBJ_DTYPE_TXTBOX, false, _CO_SBILLING_ACCOUNT_CONTACT_EMAIL, _CO_SBILLING_ACCOUNT_CONTACT_EMAIL_DSC);
        $this->quickInitVar('contact_phone', XOBJ_DTYPE_TXTBOX, false, _CO_SBILLING_ACCOUNT_CONTACT_PHONE, _CO_SBILLING_ACCOUNT_CONTACT_EMAIL_DSC);
        $this->quickInitVar('website', XOBJ_DTYPE_TXTBOX, false, _CO_SBILLING_ACCOUNT_WEBSITE, _CO_SBILLING_ACCOUNT_WEBSITE_DSC);

        $this->initNonPersistableVar('user_uid', XOBJ_DTYPE_TXTBOX, '', _CO_SBILLING_ACCOUNT_UNAME, false, '');
        $this->initNonPersistableVar('user_realname', XOBJ_DTYPE_TXTBOX, '', _CO_SBILLING_ACCOUNT_USER_REALNAME, false, '');
        $this->initNonPersistableVar('user_email', XOBJ_DTYPE_TXTBOX, '', _CO_SBILLING_ACCOUNT_USER_EMAIL, false, '');
        $this->initNonPersistableVar('user_url', XOBJ_DTYPE_TXTBOX, '', _CO_SBILLING_ACCOUNT_USER_URL, false, '');
        $this->initNonPersistableVar('user_uname', XOBJ_DTYPE_TXTBOX, '', _CO_SBILLING_ACCOUNT_USER_UNAME, false, '');
        $this->initNonPersistableVar('user_password', XOBJ_DTYPE_TXTBOX, '', _CO_SBILLING_ACCOUNT_USER_PASSWORD, false, '');
		$this->initNonPersistableVar('user_notification', XOBJ_DTYPE_INT, '', _CO_SBILLING_ACCOUNT_USER_NOTIFICATION, false, true);

		$this->setControl('user_uid', array('itemHandler' => 'account',
                                          'method' => 'getUserList',
                                          'module' => 'smartbilling',
                                  		  'onSelect' => 'submit'));

		$this->setControl('user_notification', 'yesno');

		$this->hideFieldFromSingleView(array('user_uid', 'user_realname', 'user_email', 'user_url', 'user_uname', 'user_password', 'user_notification'));
    }

    function getVar($key, $format = 's') {
        if ($format == 's' && in_array($key, array(''))) {
            return call_user_func(array($this,$key));
        }
        return parent::getVar($key, $format);
    }

    function getAccountLink() {
    	$ret = '<a href="' . SMARTBILLING_ADMIN_URL . 'account.php?accountid=' . $this->getVar('accountid', 'e') . '&op=view">' . $this->getVar('name') . '</a>';
    	return $ret;
    }

    function getAddInvoiceLink() {
    	$ret = '<a href="' . SMARTBILLING_ADMIN_URL . 'invoice.php?accountid=' . $this->getVar('accountid', 'e') . '&op=mod"><img src="' . SMARTOBJECT_IMAGES_ACTIONS_URL . 'filenew.png" alt="' . _AM_SBILLING_ACCOUNT_NEW_INVOICE . '" title="' . _AM_SBILLING_ACCOUNT_NEW_INVOICE . '" style="vertical-align: middle;" /></a>';
    	return $ret;
    }
}
class SmartbillingAccountHandler extends SmartPersistableObjectHandler {
    function SmartbillingAccountHandler($db) {
        $this->SmartPersistableObjectHandler($db, 'account', 'accountid', 'name', '', 'smartbilling');
    }

    function getUserList() {
    	$criteria = new CriteriaCompo();
    	$criteria->setSort('uname');
    	$member_handler = xoops_gethandler('member');
    	$aUsers = $member_handler->getUserList($criteria);
    	$ret[0] = '----';
    	$ret['new'] = _AM_SBILLING_ACCOUNT_NEW_USER;
    	foreach($aUsers as $k=>$v) {
    		$ret[$k] = $v;
    	}
    	return $ret;
    }

	function afterSave(&$obj) {
		$smartbilling_account_user_handler = xoops_getmodulehandler('account_user', 'smartbilling');
		$uid = $obj->getVar('user_uid');
		if (intval($uid) && intval($uid) > 0) {
			// a user was selected, so let's link this uid with the account
			$account_userObj = $smartbilling_account_user_handler->create();
			$account_userObj->setVar('uid', $uid);
			$account_userObj->setVar('accountid', $obj->id());
			if (!$smartbilling_account_user_handler->insert($account_userObj)) {
				$obj->serError(_AM_SBILLING_ACCOUNT_USER_CREATED_ERROR);
				return false;
			} else {
				return true;
			}
		} elseif($uid == 'new') {
			$smartobject_member_handler = xoops_getModuleHandler('member', 'smartobject');
			$userObj = $smartobject_member_handler->createUser();
			$userObj->setVar('email', $obj->getVar('user_email', 'e'));
			$userObj->setVar('uname', $obj->getVar('user_uname', 'e'));
			$userObj->setVar('name', $obj->getVar('user_realname', 'e'));
			$userObj->setVar('url', $obj->getVar('user_url', 'e'));

			// retreive the groups to add the user to
			global $xoopsModuleConfig;
			$groups = $xoopsModuleConfig['new_user_groups'];
			$ret = $smartobject_member_handler->addAndActivateUser($userObj, $groups, $obj->getVar('user_notification', 'e'));
			if (!$ret) {
				$obj->setErrors(_AM_SBILLING_ACCOUNT_USER_CREATED_NEW_ERROR);
				return false;
			}
			// a user was selected, so let's link this uid with the account
			$account_userObj = $smartbilling_account_user_handler->create();
			$account_userObj->setVar('uid', $userObj->uid());
			$account_userObj->setVar('accountid', $obj->id());
			if (!$smartbilling_account_user_handler->insert($account_userObj)) {
				$obj->serError(_AM_SBILLING_ACCOUNT_USER_CREATED_ERROR);
				return false;
			} else {
				return true;
			}
		}
		return true;
	}
}
?>