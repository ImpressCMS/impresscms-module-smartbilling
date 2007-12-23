<?php

if (!defined("XOOPS_ROOT_PATH")) {
 	die("XOOPS root path not defined");
}

global $modversion;
if( ! empty( $_POST['fct'] ) && ! empty( $_POST['op'] ) && $_POST['fct'] == 'modulesadmin' && $_POST['op'] == 'update_ok' && $_POST['dirname'] == $modversion['dirname'] ) {
	// referer check
	$ref = xoops_getenv('HTTP_REFERER');
	if( $ref == '' || strpos( $ref , XOOPS_URL.'/modules/system/admin.php' ) === 0 ) {
		/* module specific part */



		/* General part */

		// Keep the values of block's options when module is updated (by nobunobu)
		include dirname( __FILE__ ) . "/updateblock.inc.php" ;

	}
}

function xoops_module_update_smartbilling($module) {

	include_once(XOOPS_ROOT_PATH . "/modules/" . $module->getVar('dirname') . "/include/functions.php");
	include_once(XOOPS_ROOT_PATH . "/modules/smartobject/class/smartdbupdater.php");

	$dbupdater = new SmartobjectDbupdater();

    ob_start();

    $dbVersion  = smart_GetMeta('version', 'smartbilling');
    if (!$dbVersion) {
    	$dbVersion = 0;
    }

	$dbupdater = new SmartobjectDbupdater();

	echo "<code>" . _SDU_UPDATE_UPDATING_DATABASE . "<br />";


    // db migrate version = 1
    $newDbVersion = 1;

    if ($dbVersion < $newDbVersion) {
    	echo "Database migrate to version " . $newDbVersion . "<br />";

	    $table = new SmartDbTable('smartbilling_invoice');
	    if (!$table->fieldExists('expected_payment_method')) {

	    	$table->addNewField('expected_payment_method', "VARCHAR(50) NOT NULL default ''");
		    if (!$dbupdater->updateTable($table)) {
		        /**
		         * @todo trap the errors
		         */
		    }

	    }
	    $table = new SmartDbTable('smartbilling_payment');
	    if (!$table->fieldExists('payment_method')) {
	    	$table->addNewField('payment_method', "VARCHAR(50) NOT NULL default ''");
		    if (!$dbupdater->updateTable($table)) {
		        /**
		         * @todo trap the errors
		         */
		    }
	    }
	}

    // db migrate version = 2
    $newDbVersion = 2;

    if ($dbVersion < $newDbVersion) {
    	echo "Database migrate to version " . $newDbVersion . "<br />";

		// Create table smartbilling_domain
	    $table = new SmartDbTable('smartbilling_domain');
	    if (!$table->exists()) {
		    $table->setStructure("
			  `domainid` int(11) NOT NULL auto_increment,
			  `accountid` int(11) NOT NULL default 0,
			  `name` VARCHAR(255) NOT NULL default 0,
			  `registrar` VARCHAR(255) NOT NULL default 0,
			  `note` TEXT NOT NULL default '',
			  PRIMARY KEY  (`domainid`)
			");
	    }

	    if (!$dbupdater->updateTable($table)) {
	        /**
	         * @todo trap the errors
	         */
	  	}

		// Create table smartbilling_webaccount
	    $table = new SmartDbTable('smartbilling_webaccount');
	    if (!$table->exists()) {
		    $table->setStructure("
			  `webaccountid` int(11) NOT NULL auto_increment,
			  `accountid` int(11) NOT NULL default 0,
			  `serverid` int(11) NOT NULL default 0,
			  `domain` VARCHAR(255) NOT NULL default 0,
			  `note` TEXT NOT NULL default '',
			  PRIMARY KEY  (`webaccountid`)
			");
	    }

	    if (!$dbupdater->updateTable($table)) {
	        /**
	         * @todo trap the errors
	         */
	  	}

		// Create table smartbilling_server
	    $table = new SmartDbTable('smartbilling_server');
	    if (!$table->exists()) {
		    $table->setStructure("
			  `serverid` int(11) NOT NULL auto_increment,
			  `supplierid` int(11) NOT NULL default 0,
			  `name` VARCHAR(255) NOT NULL default 0,
			  `note` TEXT NOT NULL default '',
			  PRIMARY KEY  (`serverid`)
			");
	    }

	    if (!$dbupdater->updateTable($table)) {
	        /**
	         * @todo trap the errors
	         */
	  	}

		// Create table smartbilling_supplier
	    $table = new SmartDbTable('smartbilling_supplier');
	    if (!$table->exists()) {
		    $table->setStructure("
			  `supplierid` int(11) NOT NULL auto_increment,
			  `name` VARCHAR(255) NOT NULL default 0,
			  `note` TEXT NOT NULL default '',
			  PRIMARY KEY  (`supplierid`)
			");
	    }

	    if (!$dbupdater->updateTable($table)) {
	        /**
	         * @todo trap the errors
	         */
	  	}
	}

    // db migrate version = 3
    $newDbVersion = 3;

    if ($dbVersion < $newDbVersion) {
    	echo "Database migrate to version " . $newDbVersion . "<br />";

	    $table = new SmartDbTable('smartbilling_webaccount');
	    if (!$table->fieldExists('disk_limit')) {

	    	$table->addNewField('disk_limit', "int(11) NOT NULL default 0");
		    if (!$dbupdater->updateTable($table)) {
		        /**
		         * @todo trap the errors
		         */
		    }
	    }
	    $table = new SmartDbTable('smartbilling_webaccount');
	    if (!$table->fieldExists('bandwidth_limit')) {

	    	$table->addNewField('bandwidth_limit', "int(11) NOT NULL default 0");
		    if (!$dbupdater->updateTable($table)) {
		        /**
		         * @todo trap the errors
		         */
		    }
	    }
	    $table = new SmartDbTable('smartbilling_webaccount');
	    if (!$table->fieldExists('monthly_cost')) {

	    	$table->addNewField('monthly_cost', "float NOT NULL default 0");
		    if (!$dbupdater->updateTable($table)) {
		        /**
		         * @todo trap the errors
		         */
		    }
	    }
	}

    // db migrate version = 4
    $newDbVersion = 4;

    if ($dbVersion < $newDbVersion) {
    	echo "Database migrate to version " . $newDbVersion . "<br />";

	    $table = new SmartDbTable('smartbilling_webaccount');
	    if (!$table->fieldExists('currency')) {

	    	$table->addNewField('currency', "int(2) NOT NULL default 0");
		    if (!$dbupdater->updateTable($table)) {
		        /**
		         * @todo trap the errors
		         */
		    }
	    }
	}

    // db migrate version = 5
    $newDbVersion = 5;

    if ($dbVersion < $newDbVersion) {
    	echo "Database migrate to version " . $newDbVersion . "<br />";

	    $table = new SmartDbTable('smartbilling_webaccount');
	    if (!$table->fieldExists('date')) {

	    	$table->addNewField('date', "int(11) NOT NULL default 0");
		    if (!$dbupdater->updateTable($table)) {
		        /**
		         * @todo trap the errors
		         */
		    }
	    }
	}

    // db migrate version = 6
    $newDbVersion = 6;

    if ($dbVersion < $newDbVersion) {
    	echo "Database migrate to version " . $newDbVersion . "<br />";

	    $table = new SmartDbTable('smartbilling_webaccount');
	    if (!$table->fieldExists('next_billing_date')) {

	    	$table->addNewField('next_billing_date', "int(11) NOT NULL default 0");
		    if (!$dbupdater->updateTable($table)) {
		        /**
		         * @todo trap the errors
		         */
		    }
	    }
	    $table = new SmartDbTable('smartbilling_webaccount');
	    if (!$table->fieldExists('status')) {

	    	$table->addNewField('status', "int(2) NOT NULL default 1");
		    if (!$dbupdater->updateTable($table)) {
		        /**
		         * @todo trap the errors
		         */
		    }
	    }
    }
    // db migrate version = 7
    $newDbVersion = 7;

    if ($dbVersion < $newDbVersion) {
    	echo "Database migrate to version " . $newDbVersion . "<br />";

	    $table = new SmartDbTable('smartbilling_invoice');
	    if (!$table->fieldExists('status')) {

	    	$table->addNewField('status', "int(2) NOT NULL default 1");
		    if (!$dbupdater->updateTable($table)) {
		        /**
		         * @todo trap the errors
		         */
		    }
	    }

	    // looping through existing invoices to change paid=>staus
	    $smartbilling_invoice_handler = xoops_getModuleHandler('invoice', 'smartbilling');
	    $sql = 'SELECT invoiceid from ' . $smartbilling_invoice_handler->table . ' WHERE paid=1';
	    $records = $smartbilling_invoice_handler->query($sql);
	    $paid_invoice_array = array();
	    foreach ($records as $record) {
			$paid_invoice_array[] = $record['invoiceid'];
	    }

	    $table = new SmartDbTable('smartbilling_invoice');
	    if ($table->fieldExists('paid')) {

	    	$table->addDropedField('paid');
		    if (!$dbupdater->updateTable($table)) {
		        /**
		         * @todo trap the errors
		         */
		    }
	    }

	    $criteria = new CriteriaCompo();
	    $criteria->add(new Criteria('invoiceid', '(' . implode(', ', $paid_invoice_array) . ')', 'IN'));
		$smartbilling_invoice_handler->updateAll('status', SMARTBILLING_INVOICE_STATUS_PAID, $criteria);
	}

    // db migrate version = 8
    $newDbVersion = 8;

    if ($dbVersion < $newDbVersion) {
    	echo "Database migrate to version " . $newDbVersion . "<br />";

	    $table = new SmartDbTable('smartbilling_payment');
    	$table->addAlteredField('date', 'INT(11)', 'payment_date');
	    if (!$dbupdater->updateTable($table)) {
	        /**
	         * @todo trap the errors
	         */
	    }
	}

    // db migrate version = 9
    $newDbVersion = 9;

    if ($dbVersion < $newDbVersion) {
    	echo "Database migrate to version " . $newDbVersion . "<br />";

		// Create table smartbilling_project
	    $table = new SmartDbTable('smartbilling_project');

	    $table->setStructure("
		  `projectid` int(11) NOT NULL auto_increment,
		  `project_name` VARCHAR(255) NOT NULL default '',
		  `project_description` TEXT NOT NULL default '',
		  PRIMARY KEY  (`projectid`)
		");

	    if (!$dbupdater->updateTable($table)) {
	        /**
	         * @todo trap the errors
	         */
	    }

		// Create table smartbilling_activity
	    $table = new SmartDbTable('smartbilling_activity');

	    $table->setStructure("
		  `activityid` int(11) NOT NULL auto_increment,
		  `activity_name` VARCHAR(255) NOT NULL default '',
		  `activity_description` TEXT NOT NULL default '',
		  PRIMARY KEY  (`activityid`)
		");

	    if (!$dbupdater->updateTable($table)) {
	        /**
	         * @todo trap the errors
	         */
	    }

		// Create table smartbilling_activity_project
	    $table = new SmartDbTable('smartbilling_activity_project');

	    $table->setStructure("
			  `activity_projectid` int(11) NOT NULL auto_increment,
			  `activityid` INT(11) NOT NULL default 0,
			  `projectid` INT(11) NOT NULL default 0,
			  PRIMARY KEY  (`activity_projectid`)
		");

	    if (!$dbupdater->updateTable($table)) {
	        /**
	         * @todo trap the errors
	         */
	    }

		// Create table smartbilling_activity_log
	    $table = new SmartDbTable('smartbilling_log');

	    $table->setStructure("
			  `logid` int(11) NOT NULL auto_increment,
			  `uid` INT(11) NOT NULL default 0,
			  `accountid` INT(11) NOT NULL default 0,
			  `activity_projectid` INT(11) NOT NULL default 0,
			  `start` INT(11) NOT NULL default 0,
			  `finish` INT(11) NOT NULL default 0,
			  `duration` INT(11) NOT NULL default 0,
			  `note` TEXT NOT NULL default '',
			  `billable` INT(1) NOT NULL default 0,
			  PRIMARY KEY  (`logid`)
		");

	    if (!$dbupdater->updateTable($table)) {
	        /**
	         * @todo trap the errors
	         */
	    }
	}

    // db migrate version = 10
    $newDbVersion = 10;

    if ($dbVersion < $newDbVersion) {
    	echo "Database migrate to version " . $newDbVersion . "<br />";

	    $table = new SmartDbTable('smartbilling_log');
    	$table->addNewField('log_date', "int(11) NOT NULL default 0");
	    if (!$dbupdater->updateTable($table)) {
	        /**
	         * @todo trap the errors
	         */
	    }
	}

    // db migrate version = 11
    $newDbVersion = 11;

    if ($dbVersion < $newDbVersion) {
    	echo "Database migrate to version " . $newDbVersion . "<br />";

		// Create table smartbilling_project
	    $table = new SmartDbTable('smartbilling_account_user');

	    $table->setStructure("
		  `account_userid` int(11) NOT NULL auto_increment,
		  `uid` int(11) NOT NULL default 0,
		  `accountid` int(11) NOT NULL default 0,
		  PRIMARY KEY  (`account_userid`)
		");

	    if (!$dbupdater->updateTable($table)) {
	        /**
	         * @todo trap the errors
	         */
	    }
    }

	echo "</code>";

    $feedback = ob_get_clean();
    if (method_exists($module, "setMessage")) {
        $module->setMessage($feedback);
    } else {
        echo $feedback;
    }
    smart_SetMeta("version", $newDbVersion, "smartbilling"); //Set meta version to current
    return true;
}

function xoops_module_install_smartbilling($module) {

    ob_start();

	include_once(XOOPS_ROOT_PATH . "/modules/" . $module->getVar('dirname') . "/include/functions.php");

	//smartbilling_create_upload_folders();

    $feedback = ob_get_clean();
    if (method_exists($module, "setMessage")) {
        $module->setMessage($feedback);
    }
    else {
        echo $feedback;
    }

	return true;
}


?>