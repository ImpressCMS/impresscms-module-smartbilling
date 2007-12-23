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
// Activity: The XOOPS Activity                                               //
// -------------------------------------------------------------------------//

if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}
include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobject.php";
class SmartbillingActivity extends SmartObject {

    function SmartbillingActivity() {
        $this->quickInitVar('activityid', XOBJ_DTYPE_INT, true);
        $this->quickInitVar('activity_name', XOBJ_DTYPE_TXTBOX, true, _CO_SBILLING_ACTIVITY_NAME, _CO_SBILLING_ACTIVITY_NAME_DSC);
        $this->quickInitVar('activity_description', XOBJ_DTYPE_TXTAREA, false, _CO_SBILLING_ACTIVITY_DESCRIPTION, _CO_SBILLING_ACTIVITY_DESCRIPTION_DSC);

        $this->initNonPersistableVar('projects', XOBJ_DTYPE_ARRAY, false, _CO_SBILLING_ACTIVITY_PROJECTS, false, '', true);

        $this->setControl('projects', 'activity_project');
    }

    function getVar($key, $format = 's') {
        if ($format == 's' && in_array($key, array())) {
            return call_user_func(array($this,$key));
        }
        return parent::getVar($key, $format);
    }
}
class SmartbillingActivityHandler extends SmartPersistableObjectHandler {
    function SmartbillingActivityHandler($db) {
        $this->SmartPersistableObjectHandler($db, 'activity', 'activityid', 'activity_name', 'activity_description', 'smartbilling');
    }

    function afterSave(&$obj) {
		$smartbilling_activity_project_handler = xoops_getModuleHandler('activity_project', 'smartbilling');
		$aProjects = isset($_POST['projects']) ? $_POST['projects'] : false;
		$activityid = $obj->getVar('activityid', 'e');

		if (!$obj->isNew()) {
			//first, delete all projects related to this activity
			$smartbilling_activity_project_handler->deleteAllProjectsFromActivity($activityid);
		}
		if (!$aProjects) {
			return true;
		} else {
			foreach($aProjects as $projectid) {
				$activity_projectObj = $smartbilling_activity_project_handler->create();
				$activity_projectObj->setVar('projectid', $projectid);
				$activity_projectObj->setVar('activityid', $activityid);
				$smartbilling_activity_project_handler->insert($activity_projectObj);
			}
			return true;
		}
    }

    function afterDelete(&$obj) {
		$smartbilling_activity_project_handler = xoops_getModuleHandler('activity_project', 'smartbilling');
		$activityid = $obj->getVar('activityid', 'e');
		return $smartbilling_activity_project_handler->deleteAllProjectsFromActivity($activityid);
    }
}
?>