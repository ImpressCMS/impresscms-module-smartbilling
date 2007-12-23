<?php
/**
* $Id$
* Module: SmartContent
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

function editlog($logid = 0)
{
	global $smartbilling_log_handler, $xoopsUser, $xoopsTpl;

	$logObj = $smartbilling_log_handler->get($logid);

	//testing ajax
	$logObj->quickInitVar('test', XOBJ_DTYPE_TXTBOX, false, 'Test', '');
	$logObj->setControl('test', array(
								'name' => 'autocompleter',
								'itemHandler' => 'project',
								'method' => 'getProjectsList',
								'module' => 'smartbilling',
								'onSelect' => 'submit')
						);


	$logObj->hideFieldFromForm(array('log_date', 'uid'));
	$logObj->setVar('uid', $xoopsUser->uid());

	if (isset($_POST['op'])) {
		$controller = new SmartObjectController($smartbilling_log_handler);
		$controller->postDataToObject($logObj);

		if ($_POST['op'] == 'changedField') {

			switch($_POST['changedField']) {
				case 'projectid':

				break;
			}
		}
	}

	if (!$logObj->isNew()){
		$sform = $logObj->getForm(_MD_SBILLING_LOG_EDIT, 'addlog');
		$sform->assign($xoopsTpl);
		$xoopsTpl->assign('categoryPath', '<a href="log.php">' . _MD_SBILLING_LOG_MYLOG . '</a> > ' . _MD_SBILLING_LOG_EDIT);
	} else {
		$sform = $logObj->getForm(_MD_SBILLING_LOG_CREATE, 'addlog');
		$xoopsTpl->assign('categoryPath', '<a href="log.php">' . _MD_SBILLING_LOG_MYLOG . '</a> > ' . _MD_SBILLING_LOG_CREATE);
		$sform->assign($xoopsTpl);
	}
}

include_once('header.php');

$xoopsOption['template_main'] = 'smartbilling_log.html';
include_once(XOOPS_ROOT_PATH . "/header.php");

include_once(XOOPS_ROOT_PATH . "/modules/smartobject/class/smartjax.php");
$smartjax = new Smartjax();
$smartjax->initiateFromUserside();

include_once("footer.php");

$op = '';

if (isset($_GET['op'])) $op = $_GET['op'];
if (isset($_POST['op'])) $op = $_POST['op'];

$smartbilling_log_handler = xoops_getModuleHandler('log');
$logid = isset($_GET['logid']) ? intval($_GET['logid']) : 0 ;

switch ($op) {
	case 'test':
		smart_redirect(XOOPS_URL, 3, 'yooooooo');
	break;

	case "mod":
	case "changedField":

		editlog($logid);
		break;

	case "addlog":
        include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smartbilling_log_handler);
		$controller->storeFromDefaultForm(_MD_SBILLING_LOG_CREATED, _MD_SBILLING_LOG_MODIFIED);

		break;

	case "del":

	    include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smartbilling_log_handler);
		$controller->handleObjectDeletionFromUserSide();

		break;

	default:

		$smart_registry = SmartObjectsRegistry::getInstance();
		$smart_registry->addObjectsFromItemName('account');
		$smart_registry->addObjectsFromItemName('project');
		$smart_registry->addObjectsFromItemName('activity');

		include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('uid', $xoopsUser->uid()));

		$objectTable = new SmartObjectTable($smartbilling_log_handler, $criteria);
		$objectTable->isForUserSide();

		$objectTable->addColumn(new SmartObjectColumn('log_date', 'left', 150, 'getLogDate'));
		//$objectTable->addColumn(new SmartObjectColumn('uid', 'left', 150));
		$objectTable->addColumn(new SmartObjectColumn('projectid', 'left', 150));
		$objectTable->addColumn(new SmartObjectColumn('activityid', 'left', 150));
		$objectTable->addColumn(new SmartObjectColumn('accountid', 'left', false));
		$objectTable->addColumn(new SmartObjectColumn('duration', 'right', 100));

		$objectTable->addIntroButton('addlog', 'log.php?op=mod', _MD_SBILLING_LOG_CREATE);

		//$objectTable->addQuickSearch(array('name'));

		$objectTable->addFilter('accountid', 'getAccounts');

		$xoopsTpl->assign('smartbilling_mylog', $objectTable->fetch());
		$xoopsTpl->assign('categoryPath', _MD_SBILLING_LOG_MYLOG);

		break;
}
$xoopsTpl->assign('module_home', smart_getModuleName(false, true));

include_once(XOOPS_ROOT_PATH . '/footer.php');
?>