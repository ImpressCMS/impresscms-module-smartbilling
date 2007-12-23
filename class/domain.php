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
class SmartbillingDomain extends SmartObject {

    function SmartbillingDomain() {
        $this->quickInitVar('domainid', XOBJ_DTYPE_INT, true);
        $this->quickInitVar('accountid', XOBJ_DTYPE_INT, true, _CO_SBILLING_DOMAIN_ACCOUNTID, _CO_SBILLING_DOMAIN_ACCOUNTID_DSC);
        $this->quickInitVar('name', XOBJ_DTYPE_TXTBOX, true, _CO_SBILLING_DOMAIN_NAME, _CO_SBILLING_DOMAIN_NAME_DSC);
        $this->quickInitVar('registrar', XOBJ_DTYPE_TXTBOX, false, _CO_SBILLING_DOMAIN_REGISTRAR, _CO_SBILLING_DOMAIN_REGISTRAR_DSC);
        $this->quickInitVar('note', XOBJ_DTYPE_TXTAREA, false, _CO_SBILLING_DOMAIN_NOTE, _CO_SBILLING_DOMAIN_NOTE_DSC);

		$this->setControl('accountid', array('itemHandler' => 'account',
                                          'method' => 'getList',
                                          'module' => 'smartbilling'));

		$this->setControl('registrar', array('itemHandler' => 'domain',
                                          'method' => 'getRegistrars',
                                          'module' => 'smartbilling'));
    }

    function getVar($key, $format = 's') {
        if ($format == 's' && in_array($key, array('accountid', 'registrar'))) {
            return call_user_func(array($this,$key));
        }
        return parent::getVar($key, $format);
    }

    function accountid() {
    	$smartbilling_account_handler = xoops_getModuleHandler('account', 'smartbilling');
    	$ret = $this->getVar('accountid', 'e');
    	$accountObj = $smartbilling_account_handler->get($ret);
    	if (!$accountObj->isNew()) {
    		$ret = $accountObj->getVar('name');
    	}
    	return $ret;
    }

    function registrar() {
    	global $registrarsArray;
    	$ret = $this->getVar('registrar', 'e');
    	if (isset($registrarsArray[$ret])) {
    		$ret = $registrarsArray[$ret];
    	}
    	return $ret;
    }
}
class SmartbillingDomainHandler extends SmartPersistableObjectHandler {
    function SmartbillingDomainHandler($db) {
        $this->SmartPersistableObjectHandler($db, 'domain', 'domainid', 'name', '', 'smartbilling');
    }

    function getRegistrars() {
    	global $smartbilling_domain_registrar;
    	return $smartbilling_domain_registrar;
    }
}
?>