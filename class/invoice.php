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

define('SMARTBILLING_INVOICE_STATUS_STANDING', 1);
define('SMARTBILLING_INVOICE_STATUS_PAID', 2);
define('SMARTBILLING_INVOICE_STATUS_LOST', 3);

class SmartbillingInvoice extends SmartObject {

    function SmartbillingInvoice() {
        $this->quickInitVar('invoiceid', XOBJ_DTYPE_INT, true);
        $this->quickInitVar('accountid', XOBJ_DTYPE_INT, true, _CO_SBILLING_INVOICE_ACCOUNTID, _CO_SBILLING_INVOICE_ACCOUNTID_DSC);
        $this->quickInitVar('invoice_number', XOBJ_DTYPE_TXTBOX, true, _CO_SBILLING_INVOICE_NUMBER, _CO_SBILLING_INVOICE_NUMBER_DSC);
        $this->quickInitVar('amount', XOBJ_DTYPE_CURRENCY, true, _CO_SBILLING_INVOICE_AMOUNT, _CO_SBILLING_INVOICE_AMOUNT_DSC);
        $this->quickInitVar('currency', XOBJ_DTYPE_INT, true, _CO_SBILLING_INVOICE_CURRENCY, _CO_SBILLING_INVOICE_CURRENCY_DSC);
        $this->quickInitVar('expected_payment_method', XOBJ_DTYPE_TXTBOX, true, _CO_SBILLING_INVOICE_EXPECTED_PAYMENT_METHOD, _CO_SBILLING_INVOICE_EXPECTED_PAYMENT_METHOD_DSC);
		$this->quickInitVar('invoice_file', XOBJ_DTYPE_TXTBOX, false, _CO_SBILLING_INVOICE_FILE, _CO_SBILLING_INVOICE_FILE_DSC);
		$this->quickInitVar('date', XOBJ_DTYPE_LTIME, true, _CO_SBILLING_INVOICE_DATE, _CO_SBILLING_INVOICE_DATE_DSC);
        $this->quickInitVar('status', XOBJ_DTYPE_INT, true, _CO_SBILLING_INVOICE_STATUS, _CO_SBILLING_INVOICE_STATUS_DSC, SMARTBILLING_INVOICE_STATUS_STANDING);
        $this->quickInitVar('note', XOBJ_DTYPE_TXTAREA, false, _CO_SBILLING_INVOICE_NOTE, _CO_SBILLING_INVOICE_NOTE_DSC);

		$this->setControl('status', array('itemHandler' => 'invoice',
                                          'method' => 'getStatus',
                                          'module' => 'smartbilling'));

        $this->setControl('invoice_file', 'file');
		$this->setControl('accountid', array('itemHandler' => 'account',
                                          'method' => 'getList',
                                          'module' => 'smartbilling'));
		$this->setControl('currency', array('itemHandler' => 'invoice',
                                          'method' => 'getCurrencies',
                                          'module' => 'smartbilling'));
		$this->setControl('expected_payment_method', array('itemHandler' => 'invoice',
                                          'method' => 'getPaymentMethod',
                                          'module' => 'smartbilling'));

    }

    function getVar($key, $format = 's') {
        if ($format == 's' && in_array($key, array('accountid', 'date', 'status', 'invoice_file','currency', 'expected_payment_method'))) {
            return call_user_func(array($this,$key));
        }
        return parent::getVar($key, $format);
    }

    function accessGranted($uid) {
		$smartbilling_account_user_handler = xoops_getModuleHandler('account_user', 'smartbilling');
		$accountids = $smartbilling_account_user_handler->getGrantedAccountids($uid);
		$ret = in_array($this->getVar('accountid', 'e'), $accountids);
		return $ret;
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

    function date() {
		$ret = $this->getVar('date', 'e');
		$ret = formatTimestamp($ret, _SHORTDATESTRING);
		return $ret;
    }

	function expected_payment_method() {
		global $smartbilling_invoice_handler;
		$methodArray = $smartbilling_invoice_handler->getPaymentMethod();
		$method = $this->getVar('expected_payment_method', 'e');
		$ret = $method ? $methodArray[$method] : '';
		return $ret;
	}

    function status() {
    	global $smartbilling_invoice_status;

    	$ret = $this->getVar('status', 'e');
    	if (isset($smartbilling_invoice_status[$ret])) {
    		$ret = $smartbilling_invoice_status[$ret];
    	}
    	return $ret;
    }

    function invoice_file() {
    	$ret = '';

    	$filename = $this->getVar('invoice_file', 'e');
    	if (!$filename) {
    		return $ret;
    	}
    	$filename_url = $this->handler->getImageUrl() . $filename;
    	return '<a href="' . $filename_url . '">' . _CO_SBILLING_INVOICE_FILE_DOWNLOAD . '</a>';
    }

    function displayInfo() {
   		$xoopsTpl = new XoopsTpl();
   		$xoopsTpl->assign('smartbilling_invoice', $this->toArray());
   		return $xoopsTpl->display( 'db:smartbilling_invoice_summary.html' );
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
				} else {
					$singleview->addRow(new SmartObjectRow($key, false, $is_header));
				}
			}
		}

		if ($fetchOnly) {
			$ret = $singleview->render($fetchOnly);;
			return $ret;
		}else {
			$singleview->render($fetchOnly);
		}
    }

    function getAccountLink() {
    	$ret = '<a href="' . SMARTBILLING_ADMIN_URL . 'account.php?accountid=' . $this->getVar('accountid', 'e') . '&op=view">' . $this->getVar('accountid') . '</a>';
    	return $ret;
    }

    function getInvoiceLInk() {
    	$ret = '<a href="' . SMARTBILLING_ADMIN_URL . 'invoice.php?invoiceid=' . $this->getVar('invoiceid', 'e') . '&op=view">' . $this->getVar('invoice_number') . '</a>';
    	return $ret;
    }

    function getAddPaymentLink() {
    	$ret = '<a href="' . SMARTBILLING_ADMIN_URL . 'payment.php?invoiceid=' . $this->getVar('invoiceid', 'e') . '&op=mod"><img src="' . SMARTOBJECT_IMAGES_ACTIONS_URL . 'filenew.png" alt="' . _AM_SBILLING_INVOICE_NEW_PAYMENT . '" title="' . _AM_SBILLING_INVOICE_NEW_PAYMENT . '" style="vertical-align: middle;" /></a>';
    	return $ret;
    }

    function getTotalAmountPaidYet() {
		global $smartbilling_payment_handler;

		$invoiceid = $this->getVar('invoiceid');

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('invoiceid', $invoiceid));
		$criteria->setGroupby('invoiceid');

		$sql = 'SELECT sum(amount) AS totalPaid FROM ' . $smartbilling_payment_handler->table;

		$ret = $smartbilling_payment_handler->query($sql, $criteria);
		$ret = smart_currency($ret[0]['totalPaid']);
    	return $ret;
    }

    function getBalance() {
		$totalAmountPaidYet = $this->getTotalAmountPaidYet();

		$balance = $this->getVar('amount', 'e') - $totalAmountPaidYet;
		$balance = smart_currency($balance);
		return $balance;
    }

    function toArray() {
    	$ret = parent::toArray();
    	$ret['isPaid'] = $this->getVar('status', 'e' == SMARTBILLING_STATUS_INVOICE_PAID);
    	$ret['totalPaid'] = $this->getTotalAmountPaidYet();
    	$ret['balance'] = $this->getBalance();
    	return $ret;
    }

	function getAmountReceivable() {
		global $smartbilling_invoice_handler;

		$receivablesArray = $smartbilling_invoice_handler->getAllReceivableArray();

		if (isset($receivablesArray[$this->getVar('invoiceid')])) {
			return ($receivablesArray[$this->getVar('invoiceid')]['balance']);
		} else {
			return smart_currency(0);
		}
	}

}
class SmartbillingInvoiceHandler extends SmartPersistableObjectHandler {

	var $receivablesArray=false;
	var $receivableBalance=false;
	var $currenciesList=false;
	var $allReceivables=false;

    function SmartbillingInvoiceHandler($db) {
    	global $smartobject_currenciesArray;
        $this->SmartPersistableObjectHandler($db, 'invoice', 'invoiceid', 'invoice_number', 'amount', 'smartbilling');
		$this->generalSQL = 'SELECT * FROM '.$this->table . " AS " . $this->_itemname . ' JOIN ' . $this->db->prefix('smartbilling_account') . ' AS account ON invoice.accountid=account.accountid';

		$mimetypes= array(
						'application/pdf',
						'application/acrobat',
						'application/x-pdf',
						'applications/vnd.pdf',
						'text/pdf',
						'application/msword',
						'application/doc',
						'appl/text',
						'application/vnd.msword',
						'application/vnd.ms-word',
						'application/winword',
						'application/word',
						'application/x-msw6'.
						'application/x-msword',
						'application/msexcel',
						'application/x-msexcel',
						'application/x-ms-excel',
						'application/vnd.ms-excel',
						'application/x-excel',
						'application/x-dos_ms_excel',
						'application/xls',
						'application/x-xls',
						'zz-application/zz-winassoc-xls'
						);
		$this->setUploaderConfig(false, $mimetypes, 300000, false, false);

		$this->currenciesList = $smartobject_currenciesArray;
    }

    function beforeSave(&$obj) {
		$error = false;
		if (isset($_POST['smart_upload_file'])) {
		    include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartuploader.php";
			$uploaderObj = new SmartUploader($this->getImagePath(true), $this->_allowedMimeTypes, $this->_maxFileSize, $this->_maxWidth, $this->_maxHeight);
			foreach ($_FILES as $name=>$file_array) {
				if (isset ($file_array['name']) && $file_array['name'] != "" ) {
					if ($uploaderObj->fetchMedia($name)) {
						$uploaderObj->setTargetFileName(time()."_+_". $uploaderObj->getMediaName());
						if ($uploaderObj->upload()) {
							// Find the related field in the SmartObject
							$related_field = 'invoice_file';
							$obj->setVar($related_field, $uploaderObj->getSavedFileName());
						} else {
							$error = true;
							$obj->setErrors($uploaderObj->getErrors(false));
						}
					} else {
						$error = true;
						$obj->setErrors($uploaderObj->getErrors(false));
					}
				}
			}
		}
		if ($error) {
			return false;
		} else {
			return true;
		}
    }

    function getCurrencies()  {
    	return $this->currenciesList;
    }

    function getPaymentMethod() {
    	$ret = array();
    	$ret['paypal'] = _CO_SBILLING_PAYMENT_METHOD_PAYPAL;
    	$ret['check'] = _CO_SBILLING_PAYMENT_METHOD_CHECK;
    	return $ret;
    }

    function getAllReceivableArray() {

		if (!$this->allReceivables) {

			global $smartbilling_payment_handler;

			$criteria = new CriteriaCompo();
			$criteria->add(new Criteria('status', SMARTBILLING_INVOICE_STATUS_STANDING));
			$criteria->setGroupby('invoiceid');

			$sql = 'SELECT invoice.invoiceid, invoice.currency, invoice.amount, total.totalPaid, IFNULL(invoice.amount - total.totalPaid, invoice.amount) AS balance FROM ' . $this->table . ' AS invoice LEFT JOIN (
						SELECT invoiceid, sum(amount) AS totalPaid FROM ' . $smartbilling_payment_handler->table . ' GROUP BY invoiceid
					) AS total ON
					invoice.invoiceid=total.invoiceid';

			$results = $this->query($sql, $criteria);
			$ret = array();

			foreach ($results as $result) {
				$ret[$result['invoiceid']]['amount'] = smart_currency($result['amount']);
				$ret[$result['invoiceid']]['totalPaid'] = smart_currency($result['totalPaid']);
				$ret[$result['invoiceid']]['balance'] = smart_currency($result['balance']);
				$ret[$result['invoiceid']]['currency'] = $result['currency'];
			}
			$this->allReceivables = $ret;
		}
    	return $this->allReceivables;
    }

    function getReceivableBalance() {
    	global $smartobject_currenciesObj, $smartobject_default_currency;

    	if (!$this->receivableBalance) {
    		$receivablesArray = $this->getAllReceivableArray();
    		$ret = 0;
    		foreach($receivablesArray as $invoiceid=>$receivable) {
	   			$real_balance = $receivable['balance'] / $smartobject_currenciesObj[$receivable['currency']]->rate();
				$ret = $ret + $real_balance;

    		}
    		$ret = smart_currency($ret, $smartobject_default_currency);
    		$this->receivableBalance = $ret;
    	}
    	return $this->receivableBalance;

    }

    function getStatus() {
    	global $smartbilling_invoice_status;
    	return $smartbilling_invoice_status;
    }
}
?>