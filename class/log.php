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
// Log: The XOOPS Log                                               //
// -------------------------------------------------------------------------//

if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}
include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobject.php";
class SmartbillingLog extends SmartObject {

    function SmartbillingLog() {
        $this->quickInitVar('logid', XOBJ_DTYPE_INT, true);
        $this->quickInitVar('log_date', XOBJ_DTYPE_LTIME, false, _CO_SBILLING_LOG_DATE, _CO_SBILLING_LOG_DATE_DSC);
        $this->quickInitVar('uid', XOBJ_DTYPE_INT, false, _CO_SBILLING_LOG_UID, _CO_SBILLING_LOG_UID_DSC);
        $this->initNonPersistableVar('projectid', XOBJ_DTYPE_INT, 'activity_project',_CO_SBILLING_LOG_PROJECTID);
        $this->initNonPersistableVar('activityid', XOBJ_DTYPE_INT, 'activity_project',_CO_SBILLING_LOG_ACTIVITYID);
        $this->quickInitVar('accountid', XOBJ_DTYPE_INT, true, _CO_SBILLING_LOG_ACCOUNTID, _CO_SBILLING_LOG_ACCOUNTID_DSC);
		$this->quickInitVar('activity_projectid', XOBJ_DTYPE_INT, true, _CO_SBILLING_LOG_ACTIVITY_PROJECTID, _CO_SBILLING_LOG_ACTIVITY_PROJECTID_DSC);
		//$this->quickInitVar('start', XOBJ_DTYPE_TIME_ONLY, true, _CO_SBILLING_LOG_START, _CO_SBILLING_LOG_START_DSC);
		//$this->quickInitVar('finish', XOBJ_DTYPE_TIME_ONLY, true, _CO_SBILLING_LOG_FINISH, _CO_SBILLING_LOG_FINISH_DSC);
		$this->quickInitVar('duration', XOBJ_DTYPE_FLOAT, true, _CO_SBILLING_LOG_DURATION, _CO_SBILLING_LOG_DURATION_DSC);
		$this->quickInitVar('note', XOBJ_DTYPE_TXTAREA, false, _CO_SBILLING_LOG_NOTE, _CO_SBILLING_LOG_NOTE_DSC);
		$this->quickInitVar('billable', XOBJ_DTYPE_INT, false, _CO_SBILLING_LOG_BILLABLE, _CO_SBILLING_LOG_BILLABLE_DSC, true);

		$this->hideFieldFromForm('activity_projectid');
		$this->ShowFieldOnForm(array('projectid', 'activityid'));

		$this->setControl('uid', 'user');
		$this->setControl('billable', 'yesno');
		$this->setControl('projectid', array('itemHandler' => 'project',
                                  'method' => 'getProjectsList',
                                  'module' => 'smartbilling',
                                  'onSelect' => 'submit'));
		$this->setControl('activityid', 'activity');
		$this->setControl('accountid', array('itemHandler' => 'account',
                                  'method' => 'getList',
                                  'module' => 'smartbilling'));
    }

    function getVar($key, $format = 's') {
        if ($format == 's' && in_array($key, array('accountid', 'activityid', 'projectid', 'uid', 'duration'))) {
            return call_user_func(array($this,$key));
        }
        return parent::getVar($key, $format);
    }

	function accountid() {
		$smart_registry = SmartObjectsRegistry::getInstance();
    	$ret = $this->getVar('accountid', 'e');
		$obj = $smart_registry->getSingleObject('account', $ret, 'smartbilling');

    	if (!$obj->isNew()) {
    		$ret = $obj->getVar('name');
    	}
    	return $ret;
	}

	function activityid() {
		$smart_registry = SmartObjectsRegistry::getInstance();
    	$ret = $this->getVar('activityid', 'e');
		$obj = $smart_registry->getSingleObject('activity', $ret, 'smartbilling');

    	if (!$obj->isNew()) {
    		$ret = $obj->getVar('activity_name');
    	}
    	return $ret;
	}

	function duration() {
		return smart_float($this->getVar('duration', 'e'));
	}

    function getAccountLink() {
    	$ret = '<a href="' . SMARTBILLING_ADMIN_URL . 'account.php?accountid=' . $this->getVar('accountid', 'e') . '&op=view">' . $this->getVar('accountid') . '</a>';
    	return $ret;
    }

    function getLogDate() {
    	return $this->getVar('log_date');
    }

	function projectid() {
		$smart_registry = SmartObjectsRegistry::getInstance();
    	$ret = $this->getVar('projectid', 'e');
		$obj = $smart_registry->getSingleObject('project', $ret, 'smartbilling');

    	if (!$obj->isNew()) {
    		$ret = $obj->getVar('project_name');
    	}
    	return $ret;
	}

    function uid() {
        return smart_getLinkedUnameFromId($this->getVar('uid', 'e'), false);
    }
}
class SmartbillingLogHandler extends SmartPersistableObjectHandler {
    function SmartbillingLogHandler($db) {
        $this->SmartPersistableObjectHandler($db, 'log', 'logid', 'uid', 'duration', 'smartbilling');
        $this->generalSQL = 'SELECT * FROM '.$this->table . " AS " . $this->_itemname . ' JOIN ' . $this->db->prefix('smartbilling_activity_project') . ' AS activity_project ON log.activity_projectid=activity_project.activity_projectid ';
    }

    function beforeSave(&$obj) {

		$obj->setVar('activity_projectid', $_POST['activityid']);
		return true;
    }

    function beforeInsert(&$obj) {

		if ($obj->getVar('log_date', 'e') == 0) {
			$obj->setVar('log_date', time());
		}
		return true;
    }

    function getAccounts() {
    	// get all uid used in the log table
    	$sql = 'SELECT DISTINCT accountid FROM '.$this->table;
    	$aAccounts = $this->query($sql);
    	$aAccountsId = array();
    	foreach($aAccounts as $aAccountid) {
    		$aAccountsId[] = $aAccountid['accountid'];
    	}
    	$smartbilling_account_handler = xoops_getModuleHandler('account', 'smartbilling');

    	$criteria = new CriteriaCompo();
    	$criteria->add(new Criteria('accountid', '(' . implode(', ', $aAccountsId) . ')', 'IN'));
		$accountList = $smartbilling_account_handler->getList($criteria);
		$ret = array('default'=>_CO_SOBJECT_ALL);
		foreach($accountList as $accountid=>$name) {
			$ret[$accountid] = $name;
		}
    	return $ret;
    }

    function getUsers() {
    	// get all uid used in the log table
    	$sql = 'SELECT DISTINCT uid FROM '.$this->table;
    	$aUids = $this->query($sql);
    	$aUsersId = array();
    	foreach($aUids as $aUid) {
    		$aUsersId[] = $aUid['uid'];
    	}
    	$member_handler = xoops_getHandler('member');
    	$criteria = new CriteriaCompo();
    	$criteria->add(new Criteria('uid', '(' . implode(', ', $aUsersId) . ')', 'IN'));
		$usersList = $member_handler->getUserList($criteria);
		$ret = array('default'=>_CO_SOBJECT_ALL);
		foreach($usersList as $uid=>$uname) {
			$ret[$uid] = $uname;
		}
    	return $ret;
    }

}
?>