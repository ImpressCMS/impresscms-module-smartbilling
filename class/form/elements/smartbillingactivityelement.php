<?php
/**
 * Contains the controls to set answers
 *
 * @license GNU
 * @author marcan <marcan@smartfactory.ca>
 * @version $Id$
 * @link http://smartfactory.ca The SmartFactory
 */
if (!defined('XOOPS_ROOT_PATH')) {
	die("XOOPS root path not defined");
}

class SmartbillingActivityElement extends XoopsFormSelect {

	function SmartbillingActivityElement($object, $key){
	    $var = $object->vars[$key];

		$smartbilling_activity_project_handler = xoops_getModuleHandler('activity_project', 'smartbilling');
		$relatedActivities = $smartbilling_activity_project_handler->getActivitiesFromProject($object->getvar('projectid', 'e'));
	    $this->XoopsFormSelect($var['form_caption'], $key, '');

	    $smart_registry = SmartObjectsRegistry::getInstance();
	    //$options = $smart_registry->getList('project', 'smartbilling');
		$this->addOptionArray($relatedActivities);
	}
}
?>