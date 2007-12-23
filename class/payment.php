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
class SmartbillingPayment extends SmartObject {

    function SmartbillingPayment() {
        $this->quickInitVar('paymentid', XOBJ_DTYPE_INT, true);
        $this->quickInitVar('invoiceid', XOBJ_DTYPE_INT, true, _CO_SBILLING_PAYMENT_INVOICEID, _CO_SBILLING_PAYMENT_INVOICEID_DSC);
        $this->quickInitVar('amount', XOBJ_DTYPE_CURRENCY, true, _CO_SBILLING_PAYMENT_AMOUNT, _CO_SBILLING_PAYMENT_AMOUNT_DSC);
        $this->quickInitVar('payment_method', XOBJ_DTYPE_TXTBOX, true, _CO_SBILLING_PAYMENT_METHOD, _CO_SBILLING_PAYMENT_METHOD_DSC);
        $this->quickInitVar('payment_date', XOBJ_DTYPE_LTIME, true, _CO_SBILLING_PAYMENT_DATE, _CO_SBILLING_PAYMENT_DATE_DSC);
        $this->quickInitVar('note', XOBJ_DTYPE_TXTAREA, false, _CO_SBILLING_PAYMENT_NOTE, _CO_SBILLING_PAYMENT_NOTE_DSC);

		$this->setControl('invoiceid', array('itemHandler' => 'invoice',
                                          'method' => 'getList',
                                          'module' => 'smartbilling'));

		$this->setControl('payment_method', array('itemHandler' => 'invoice',
                                          'method' => 'getPaymentMethod',
                                          'module' => 'smartbilling'));
    }

    function getPaymentLink(){
    	$ret = $this->getVar('payment_date');
    	return $ret;
    }

    function getInvoiceLink() {
    	$ret = '<a href="' . SMARTBILLING_ADMIN_URL . 'invoice.php?invoiceid=' . $this->getVar('invoiceid', 'e') . '&op=view">' . $this->getVar('invoiceid') . '</a>';
    	return $ret;
    }

    function getVar($key, $format = 's') {
        if ($format == 's' && in_array($key, array('invoiceid', 'payment_method'))) {
            return call_user_func(array($this,$key));
        }
        return parent::getVar($key, $format);
    }

    function invoiceid() {
    	$smart_registry = SmartObjectsRegistry::getInstance();
    	$ret = $this->getVar('invoiceid', 'e');
		$obj = $smart_registry->getSingleObject('invoice', $ret, 'smartbilling');

        $ret = $obj->getVar('invoice_number');

        return $ret;
    }

	function payment_method() {
		global $smartbilling_invoice_handler;
		$methodArray = $smartbilling_invoice_handler->getPaymentMethod();
		$ret = $methodArray[$this->getVar('payment_method', 'e')];
		return $ret;
	}
}
class SmartbillingPaymentHandler extends SmartPersistableObjectHandler {
    function SmartbillingPaymentHandler($db) {
        $this->SmartPersistableObjectHandler($db, 'payment', 'paymentid', 'payment_date', 'amount', 'smartbilling');
        $this->generalSQL = 'SELECT * FROM '.$this->table . " AS " . $this->_itemname . ' JOIN ' . $this->db->prefix('smartbilling_invoice') . ' AS invoice ON payment.invoiceid=invoice.invoiceid';
    }

    function afterSave(&$obj) {
    	global $smartbilling_invoice_handler;
    	$invoiceObj = $smartbilling_invoice_handler->get($obj->getVar('invoiceid', 'e'));
    	$balance = $invoiceObj->getBalance();
    	if ($balance <= 0) {
    		$invoiceObj->setVar('status', SMARTBILLING_INVOICE_STATUS_PAID);
    		$smartbilling_invoice_handler->insert($invoiceObj);
    	}
    	return true;
    }
}
?>