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
class SmartbillingServer extends SmartObject {

    function SmartbillingServer() {
        $this->quickInitVar('serverid', XOBJ_DTYPE_INT, true);
        $this->quickInitVar('supplierid', XOBJ_DTYPE_INT, true, _CO_SBILLING_SERVER_SUPPLIERID, _CO_SBILLING_SERVER_SUPPLIERID_DSC);
        $this->quickInitVar('name', XOBJ_DTYPE_TXTBOX, true, _CO_SBILLING_SERVER_NAME, _CO_SBILLING_SERVER_NAME_DSC);
        $this->quickInitVar('note', XOBJ_DTYPE_TXTAREA, false, _CO_SBILLING_SERVER_NOTE, _CO_SBILLING_SERVER_NOTE_DSC);

		$this->setControl('supplierid', array('itemHandler' => 'supplier',
                                          'method' => 'getList',
                                          'module' => 'smartbilling'));

    }

    function getVar($key, $format = 's') {
        if ($format == 's' && in_array($key, array('supplierid'))) {
            return call_user_func(array($this,$key));
        }
        return parent::getVar($key, $format);
    }

    function supplierid() {
	  	$smart_registry = SmartObjectsRegistry::getInstance();
    	$ret = $this->getVar('supplierid', 'e');
		$obj = $smart_registry->getSingleObject('supplier', $ret, 'smartbilling');

    	if (!$obj->isNew()) {
    		$ret = $obj->getVar('name');
    	}
    	return $ret;
    }
}
class SmartbillingServerHandler extends SmartPersistableObjectHandler {
    function SmartbillingServerHandler($db) {
        $this->SmartPersistableObjectHandler($db, 'server', 'serverid', 'name', '', 'smartbilling');
    }
}
?>