<?php

/**
* $Id$
* Module: SmartBilling
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

include_once "../../mainfile.php";

if( !defined("SMARTBILLING_DIRNAME") ){
	define("SMARTBILLING_DIRNAME", 'smartbilling');
}

include_once XOOPS_ROOT_PATH.'/modules/' . SMARTBILLING_DIRNAME . '/include/common.php';
smart_loadCommonLanguageFile();
?>