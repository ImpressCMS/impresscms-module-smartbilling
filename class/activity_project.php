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
class SmartbillingActivity_project extends SmartObject {

    function SmartbillingActivity_project() {
        $this->quickInitVar('activity_projectid', XOBJ_DTYPE_INT, true);
        $this->quickInitVar('activityid', XOBJ_DTYPE_INT, true, _CO_SBILLING_ACTIVITY_PROJECT_ACTIVITYID, _CO_SBILLING_ACTIVITY_PROJECT_ACTIVITYID_DSC);
		$this->quickInitVar('projectid', XOBJ_DTYPE_INT, true, _CO_SBILLING_ACTIVITY_PROJECT_PROJECTID, _CO_SBILLING_ACTIVITY_PROJECT_PROJECTID_DSC);

		$this->initNonPersistableVar('activity_name', XOBJ_DTYPE_TXTBOX, 'activity');
		$this->initNonPersistableVar('project_name', XOBJ_DTYPE_TXTBOX, 'project');

		$this->setControl('activityid', array('itemHandler' => 'activity',
                                          'method' => 'getList',
                                          'module' => 'smartbilling'));

		$this->setControl('projectid', array('itemHandler' => 'project',
                                          'method' => 'getList',
                                          'module' => 'smartbilling'));
    }

    function getVar($key, $format = 's') {
        if ($format == 's' && in_array($key, array('activityid', 'projectid'))) {
            return call_user_func(array($this,$key));
        }
        return parent::getVar($key, $format);
    }

    function activityid() {
    	$ret = $this->getVar('activity_name');
    	return $ret;
    }

    function projectid() {
    	$ret = $this->getVar('project_name');
    	return $ret;
    }
}
class SmartbillingActivity_projectHandler extends SmartPersistableObjectHandler {
    function SmartbillingActivity_projectHandler($db) {
        $this->SmartPersistableObjectHandler($db, 'activity_project', 'activity_projectid', 'activityid', '', 'smartbilling');
		$this->generalSQL = 'SELECT * FROM '.$this->table . " AS " . $this->_itemname . ' JOIN ' . $this->db->prefix('smartbilling_activity') . ' AS activity ON activity_project.activityid=activity.activityid JOIN ' . $this->db->prefix('smartbilling_project') . ' AS project ON activity_project.projectid=project.projectid';
    }

    function deleteAllProjectsFromActivity($activityid) {
    	$criteria = new CriteriaCompo();
    	$criteria->add(new Criteria('activityid', $activityid));
    	return $this->deleteAll($criteria);
    }

    function getProjectsFromActivity($activityid) {
    	$criteria = new CriteriaCompo();
    	$criteria->add(new Criteria('activity_project.activityid', $activityid));
    	$objects = $this->getObjects($criteria);
    	$ret = array();
    	foreach($objects as $object) {
			$ret[] = $object->getVar('projectid', 'e');
    	}
    	return $ret;
    }

    function getActivitiesFromProject($projectid) {
    	$criteria = new CriteriaCompo();
    	$criteria->add(new Criteria('activity_project.projectid', $projectid));
    	$objects = $this->getObjects($criteria);
    	$ret = array();
    	foreach($objects as $object) {
			$ret[$object->getVar('activity_projectid', 'e')] = $object->getVar('activityid');
    	}
    	return $ret;
    }

    function getActivitiesCountFrom($projectid) {
    	$criteria = new CriteriaCompo();
    	$criteria->add(new Criteria('activity_project.projectid', $projectid));
    	$count = $this->getCount($criteria);
    	return !$count;
    }
}
?>