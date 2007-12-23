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

class SmartbillingActivity_projectElement extends XoopsFormSelect {

	function SmartbillingActivity_projectElement($object, $key){
	    $var = $object->vars[$key];

		$smartbilling_activity_project_handler = xoops_getModuleHandler('activity_project', 'smartbilling');
		$relatedProjects = $smartbilling_activity_project_handler->getProjectsFromActivity($object->id());

	    $this->XoopsFormSelect($var['form_caption'], $key, $relatedProjects, 4, true);

	    $smart_registry = SmartObjectsRegistry::getInstance();
	    $options = $smart_registry->getList('project', 'smartbilling');
		$this->addOptionArray($options);
	}
}
?>