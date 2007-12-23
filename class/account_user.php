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
class SmartbillingAccount_user extends SmartObject {

    function SmartbillingAccount_user() {
        $this->quickInitVar('account_userid', XOBJ_DTYPE_INT, true);
        $this->quickInitVar('accountid', XOBJ_DTYPE_INT, true, _CO_SBILLING_ACCOUNT_USER_ACCOUNTID, _CO_SBILLING_ACCOUNT_USER_ACCOUNTID_DSC);
        $this->quickInitVar('uid', XOBJ_DTYPE_INT, true, _CO_SBILLING_ACCOUNT_USER_UID, _CO_SBILLING_ACCOUNT_USER_UID_DSC);
		$this->initNonPersistableVar('account.name', XOBJ_DTYPE_TXTBOX, 'account', _CO_SBILLING_ACCOUNT_NAME, false, '');

		$this->initNonPersistableVar('uname', XOBJ_DTYPE_TXTBOX, 'user', _CO_SBILLING_ACCOUNT_USER_UID, false, '');
		$this->initNonPersistableVar('email', XOBJ_DTYPE_TXTBOX, 'user', _CO_SBILLING_ACCOUNT_USER_EMAIL, false, '');

        $this->initNonPersistableVar('user_realname', XOBJ_DTYPE_TXTBOX, '', _CO_SBILLING_ACCOUNT_USER_REALNAME, false, '');
        $this->initNonPersistableVar('user_email', XOBJ_DTYPE_TXTBOX, '', _CO_SBILLING_ACCOUNT_USER_EMAIL, false, '');
        $this->initNonPersistableVar('user_url', XOBJ_DTYPE_TXTBOX, '', _CO_SBILLING_ACCOUNT_USER_URL, false, '');
        $this->initNonPersistableVar('user_uname', XOBJ_DTYPE_TXTBOX, '', _CO_SBILLING_ACCOUNT_USER_UNAME, false, '');
        $this->initNonPersistableVar('user_password', XOBJ_DTYPE_TXTBOX, '', _CO_SBILLING_ACCOUNT_USER_PASSWORD, false, '');

        $this->initNonPersistableVar('user_notification', XOBJ_DTYPE_INT, '', _CO_SBILLING_ACCOUNT_USER_NOTIFICATION, false, true);

		$this->setControl('uid', array('itemHandler' => 'account',
                                          'method' => 'getUserList',
                                          'module' => 'smartbilling',
                                  		  'onSelect' => 'submit'));


		$this->setControl('accountid', array('itemHandler' => 'account',
                                          'method' => 'getList',
                                          'module' => 'smartbilling'));

		$this->setControl('user_notification', 'yesno');

		$this->makeFieldReadOnly(array('accountid'));
    }

    function getVar($key, $format = 's') {
        if ($format == 's' && in_array($key, array('accountid', 'uid', 'uname', 'email'))) {
            return call_user_func(array($this,$key));
        }
        return parent::getVar($key, $format);
    }

    function accountid() {
		$ret = $this->getVar('account.name');
    	return $ret;
    }

    function email() {
    	$ret = '<a href="mailto:' . $this->getVar('email', 'e') . '">' . $this->getVar('email', 'e') . '</a>';
        return $ret;
    }

    function getUnameLink() {
    	return $this->uname();
    }

    function uid() {
        return smart_getLinkedUnameFromId($this->getVar('uid', 'e'), true, false, true);
    }

    function uname() {
        return smart_getLinkedUnameFromId($this->getVar('uid', 'e'), true, false);
    }
}
class SmartbillingAccount_userHandler extends SmartPersistableObjectHandler {
    function SmartbillingAccount_userHandler($db) {
        $this->SmartPersistableObjectHandler($db, 'account_user', 'account_userid', 'uname', '', 'smartbilling');
        $this->generalSQL = 'SELECT * FROM '.$this->table . " AS " . $this->_itemname . ' JOIN ' . $this->db->prefix('smartbilling_account') . ' AS account ON account_user.accountid=account.accountid JOIN ' . $this->db->prefix('users') . ' AS user ON account_user.uid=user.uid';
    }

	function beforeSave(&$obj) {
		$uid = $obj->getVar('uid', 'e');
		if (!$uid) {
			$obj->setErrors(_AM_SBILLING_ACCOUNT_USER_NOT_SELECT);
			return false;
		}
		if ($uid == 'new') {
			$smartobject_member_handler = xoops_getModuleHandler('member', 'smartobject');
			$userObj = $smartobject_member_handler->createUser();
			$userObj->setVar('email', $obj->getVar('user_email', 'e'));
			$userObj->setVar('uname', $obj->getVar('user_uname', 'e'));
			$userObj->setVar('name', $obj->getVar('user_realname', 'e'));
			$userObj->setVar('url', $obj->getVar('user_url', 'e'));
			$userObj->setVar('pass', $obj->getVar('user_password', 'e'));

			// retreive the groups to add the user to
			global $xoopsModuleConfig;
			$groups = $xoopsModuleConfig['new_user_groups'];

			$ret = $smartobject_member_handler->addAndActivateUser($userObj, $groups, $obj->getVar('user_notification', 'e'));
			if (!$ret) {
				$obj->setErrors(_AM_SBILLING_ACCOUNT_USER_CREATED_NEW_ERROR);
				return false;
			}
			$obj->setVar('uid', $userObj->uid());
			return true;
		}
		return true;
	}

	function getGrantedAccountids($uid) {
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('account_user.uid', $uid));
		$sql = 'SELECT accountid FROM '.$this->table . " AS " . $this->_itemname;
		$aResult = $this->query($sql, $criteria);
		$ret = array();
		foreach ($aResult as $v) {
			$ret[] = $v['accountid'];
		}
		return $ret;
	}
}
?>