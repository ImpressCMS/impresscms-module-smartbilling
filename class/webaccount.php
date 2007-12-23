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

define('SMARTBILLING_WEBACCOUNT_STATUS_NORMAL', 1);
define('SMARTBILLING_WEBACCOUNT_STATUS_FREE', 2);
define('SMARTBILLING_WEBACCOUNT_STATUS_INACTIVE', 3);
define('SMARTBILLING_WEBACCOUNT_STATUS_NOTSET', 4);
define('SMARTBILLING_WEBACCOUNT_STATUS_DELETED', 5);
define('SMARTBILLING_WEBACCOUNT_STATUS_INPACKAGE', 6);
define('SMARTBILLING_WEBACCOUNT_STATUS_INTERNAL', 7);

include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobject.php";
class SmartbillingWebaccount extends SmartObject {

    function SmartbillingWebaccount() {
        $this->quickInitVar('webaccountid', XOBJ_DTYPE_INT, true);
        $this->quickInitVar('accountid', XOBJ_DTYPE_INT, true, _CO_SBILLING_WEBACCOUNT_ACCOUNTID, _CO_SBILLING_WEBACCOUNT_ACCOUNTID_DSC);
		$this->quickInitVar('serverid', XOBJ_DTYPE_INT, true, _CO_SBILLING_WEBACCOUNT_SERVERID, _CO_SBILLING_WEBACCOUNT_SERVERID_DSC);
        $this->quickInitVar('domain', XOBJ_DTYPE_TXTBOX, true, _CO_SBILLING_WEBACCOUNT_DOMAIN, _CO_SBILLING_WEBACCOUNT_DOMAIN_DSC);
        $this->quickInitVar('date', XOBJ_DTYPE_LTIME, true, _CO_SBILLING_WEBACCOUNT_DATE, _CO_SBILLING_WEBACCOUNT_DATE_DSC);
        $this->quickInitVar('disk_limit', XOBJ_DTYPE_INT, true, _CO_SBILLING_WEBACCOUNT_DISK_LIMIT, _CO_SBILLING_WEBACCOUNT_DISK_LIMIT_DSC, 0);
        $this->quickInitVar('bandwidth_limit', XOBJ_DTYPE_INT, true, _CO_SBILLING_WEBACCOUNT_BANDWIDTH_LIMIT, _CO_SBILLING_WEBACCOUNT_BANDWIDTH_LIMIT_DSC, 0);
        $this->quickInitVar('monthly_cost', XOBJ_DTYPE_CURRENCY, true, _CO_SBILLING_WEBACCOUNT_MONTHLY_COST, _CO_SBILLING_WEBACCOUNT_MONTHLY_COST_DSC, 0);
		$this->quickInitVar('currency', XOBJ_DTYPE_INT, true, _CO_SBILLING_INVOICE_CURRENCY, _CO_SBILLING_INVOICE_CURRENCY_DSC);
		$this->quickInitVar('status', XOBJ_DTYPE_INT, true, _CO_SBILLING_WEBACCOUNT_STATUS, _CO_SBILLING_WEBACCOUNT_STATUS_DSC, SMARTBILLING_WEBACCOUNT_STATUS_NORMAL);
        $this->quickInitVar('next_billing_date', XOBJ_DTYPE_STIME, true, _CO_SBILLING_WEBACCOUNT_NEXT_BILLING_DATE, _CO_SBILLING_WEBACCOUNT_NEXT_BILLING_DATE_DSC);
        $this->quickInitVar('note', XOBJ_DTYPE_TXTAREA, false, _CO_SBILLING_WEBACCOUNT_NOTE, _CO_SBILLING_WEBACCOUNT_NOTE_DSC);

		//$this->initNonPersistableVar('name', XOBJ_DTYPE_TXTBOX, 'user', _CO_SQUIZ_TAKE_USER_NAME);

		$this->setControl('accountid', array('itemHandler' => 'account',
                                          'method' => 'getList',
                                          'module' => 'smartbilling'));

		$this->setControl('serverid', array('itemHandler' => 'server',
                                          'method' => 'getList',
                                          'module' => 'smartbilling'));

		$this->setControl('currency', array('itemHandler' => 'invoice',
                                          'method' => 'getCurrencies',
                                          'module' => 'smartbilling'));

		$this->setControl('status', array('itemHandler' => 'webaccount',
                                          'method' => 'getStatus',
                                          'module' => 'smartbilling'));
    }

    function getVar($key, $format = 's') {
        if ($format == 's' && in_array($key, array('accountid', 'serverid', 'currency', 'status'))) {
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

    function currency() {
    	global $smartobject_currenciesObj;
    	$currencyid = $this->getVar('currency', 'n');
    	$ret = $smartobject_currenciesObj[$currencyid]->getCode();
    	return $ret;
    }

    function displaySingleObject($fetchOnly=false, $userSide=false) {
		include_once SMARTOBJECT_ROOT_PATH."class/smartobjectsingleview.php";
		$singleview = new SmartObjectSingleView($this, $userSide);
		// add all fields mark as displayOnSingleView except the keyid
		foreach($this->vars as $key=>$var) {
			if ($key != $this->handler->keyName && $var['displayOnSingleView']) {
				$is_header = ($key == $this->handler->identifierName);
				if ($key == 'accountid') {
					$singleview->addRow(new SmartObjectRow($key, 'getAccountLink', $is_header));
				} elseif($key == 'serverid') {
					$singleview->addRow(new SmartObjectRow($key, 'getServerLink', $is_header));
				} else {
					$singleview->addRow(new SmartObjectRow($key, false, $is_header));
				}
			}
		}

		if ($fetchOnly) {
			$ret = $singleview->render($fetchOnly);
			return $ret;
		}else {
			$singleview->render($fetchOnly);
		}
    }

    function serverid() {
	  	$smart_registry = SmartObjectsRegistry::getInstance();
    	$ret = $this->getVar('serverid', 'e');
		$obj = $smart_registry->getSingleObject('server', $ret, 'smartbilling');

    	if (!$obj->isNew()) {
    		$ret = $obj->getVar('name');
    	}
    	return $ret;
    }

    function status() {
    	global $smartbilling_webaccount_status;
    	$ret = $this->getVar('status', 'e');
    	if (isset($smartbilling_webaccount_status[$ret])) {
    		$ret = $smartbilling_webaccount_status[$ret];
    	}
    	return $ret;
    }

    function getAccountLink() {
    	$ret = '<a href="' . SMARTBILLING_ADMIN_URL . 'account.php?accountid=' . $this->getVar('accountid', 'e') . '&op=view">' . $this->getVar('accountid') . '</a>';
    	return $ret;
    }

    function getNextBillingDate() {
    	$ret = $this->getVar('next_billing_date', 'e');
		if ($ret < 1) {
			return '';
		}
    	$ret = formatTimestamp($ret, _SHORTDATESTRING);
    	return $ret;
    }

    function getServerLink() {
    	$ret = '<a href="' . SMARTBILLING_ADMIN_URL . 'server.php?serverid=' . $this->getVar('serverid', 'e') . '&op=view">' . $this->getVar('serverid') . '</a>';
    	return $ret;
    }

    function getDomainLink() {
    	$ret = $this->getVar('domain');
    	$ret = '<a href="http://' . $ret . '" target="_blank">' . $ret . '</a>';
    	return $ret;
    }

    function getStatusControl() {
		global $smartbilling_webaccount_status;
		$control = new XoopsFormSelect('', 'status_' . $this->id(), $this->getVar('status', 'e'));
		$control->addOptionArray($smartbilling_webaccount_status);
		return $control->render();
    }
}
class SmartbillingWebaccountHandler extends SmartPersistableObjectHandler {
    function SmartbillingWebaccountHandler($db) {
        $this->SmartPersistableObjectHandler($db, 'webaccount', 'webaccountid', 'domain', '', 'smartbilling');
		$this->generalSQL = 'SELECT * FROM '.$this->table . " AS " . $this->_itemname . ' JOIN ' . $this->db->prefix('smartbilling_account') . ' AS account ON webaccount.accountid=account.accountid';
    }

    function getStatus() {
    	global $smartbilling_webaccount_status;
    	return $smartbilling_webaccount_status;
    }
}
?>