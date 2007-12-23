CREATE TABLE `smartbilling_account` (
  `accountid` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `contact_lastname` varchar(255) NOT NULL default '',
  `contact_firstname` varchar(255) NOT NULL default '',
  `contact_email` varchar(255) NOT NULL default '',
  `contact_phone` varchar(255) NOT NULL default '',
  `website` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`accountid`)
) TYPE=MyISAM COMMENT='SmartBilling by The SmartFactory <www.smartfactory.ca>' AUTO_INCREMENT=1 ;

CREATE TABLE `smartbilling_invoice` (
  `invoiceid` int(11) NOT NULL auto_increment,
  `accountid` int(11) NOT NULL default 0,
  `invoice_number` VARCHAR(255) NOT NULL default '',
  `amount` float NOT NULL default 0,
  `expected_payment_method` VARCHAR(50) NOT NULL default '',
  `currency` int(2) NOT NULL default 0,
  `date` int(11) NOT NULL default 0,
  `paid` int(1) NOT NULL default 0,
  `note` TEXT NOT NULL default '',
  `invoice_file` VARCHAR(255) NOT NULL default 0,
  PRIMARY KEY  (`invoiceid`)
) TYPE=MyISAM COMMENT='SmartBilling by The SmartFactory <www.smartfactory.ca>' AUTO_INCREMENT=1 ;

CREATE TABLE `smartbilling_payment` (
  `paymentid` int(11) NOT NULL auto_increment,
  `invoiceid` int(11) NOT NULL default 0,
  `amount` float NOT NULL default 0,
  `payment_method` VARCHAR(50) NOT NULL default '',
  `payment_date` int(11) NOT NULL default 0,
  `note` TEXT NOT NULL default '',
  PRIMARY KEY  (`paymentid`)
) TYPE=MyISAM COMMENT='SmartBilling by The SmartFactory <www.smartfactory.ca>' AUTO_INCREMENT=1 ;

CREATE TABLE `smartbilling_domain` (
  `domainid` int(11) NOT NULL auto_increment,
  `accountid` int(11) NOT NULL default 0,
  `name` VARCHAR(255) NOT NULL default '',
  `registrar` VARCHAR(255) NOT NULL default 0,
  `note` TEXT NOT NULL default '',
  PRIMARY KEY  (`domainid`)
) TYPE=MyISAM COMMENT='SmartBilling by The SmartFactory <www.smartfactory.ca>' AUTO_INCREMENT=1 ;

CREATE TABLE `smartbilling_webaccount` (
  `webaccountid` int(11) NOT NULL auto_increment,
  `accountid` int(11) NOT NULL default 0,
  `serverid` int(11) NOT NULL default 0,
  `domain` VARCHAR(255) NOT NULL default '',
  `date` int(11) NOT NULL default 0,
  `disk_limit` int(11) NOT NULL default 0,
  `bandwidth_limit` int(11) NOT NULL default 0,
  `monthly_cost` float NOT NULL default 0,
  `currency` int(2) NOT NULL default 0,
  `status` int(2) NOT NULL default 1,
  `next_billing_date` int(11) NOT NULL default 0,
  `note` TEXT NOT NULL default '',
  PRIMARY KEY  (`webaccountid`)
) TYPE=MyISAM COMMENT='SmartBilling by The SmartFactory <www.smartfactory.ca>' AUTO_INCREMENT=1 ;

CREATE TABLE `smartbilling_server` (
  `serverid` int(11) NOT NULL auto_increment,
  `supplierid` int(11) NOT NULL default 0,
  `name` VARCHAR(255) NOT NULL default '',
  `note` TEXT NOT NULL default '',
  PRIMARY KEY  (`serverid`)
) TYPE=MyISAM COMMENT='SmartBilling by The SmartFactory <www.smartfactory.ca>' AUTO_INCREMENT=1 ;

CREATE TABLE `smartbilling_supplier` (
  `supplierid` int(11) NOT NULL auto_increment,
  `name` VARCHAR(255) NOT NULL default '',
  `note` TEXT NOT NULL default '',
  PRIMARY KEY  (`supplierid`)
) TYPE=MyISAM COMMENT='SmartBilling by The SmartFactory <www.smartfactory.ca>' AUTO_INCREMENT=1 ;

CREATE TABLE `smartbilling_project` (
  `projectid` int(11) NOT NULL auto_increment,
  `project_name` VARCHAR(255) NOT NULL default '',
  `project_description` TEXT NOT NULL default '',
  PRIMARY KEY  (`projectid`)
) TYPE=MyISAM COMMENT='SmartBilling by The SmartFactory <www.smartfactory.ca>' AUTO_INCREMENT=1 ;

CREATE TABLE `smartbilling_activity` (
  `activityid` int(11) NOT NULL auto_increment,
  `activity_name` VARCHAR(255) NOT NULL default '',
  `activity_description` TEXT NOT NULL default '',
  PRIMARY KEY  (`activityid`)
) TYPE=MyISAM COMMENT='SmartBilling by The SmartFactory <www.smartfactory.ca>' AUTO_INCREMENT=1 ;

CREATE TABLE `smartbilling_activity_project` (
  `activity_projectid` int(11) NOT NULL auto_increment,
  `activityid` INT(11) NOT NULL default 0,
  `projectid` INT(11) NOT NULL default 0,
  PRIMARY KEY  (`activity_projectid`)
) TYPE=MyISAM COMMENT='SmartBilling by The SmartFactory <www.smartfactory.ca>' AUTO_INCREMENT=1 ;

CREATE TABLE `smartbilling_log` (
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
) TYPE=MyISAM COMMENT='SmartBilling by The SmartFactory <www.smartfactory.ca>' AUTO_INCREMENT=1 ;

CREATE TABLE `smartbilling_meta` (
  `metakey` varchar(50) NOT NULL default '',
  `metavalue` varchar(255) NOT NULL default '',
  PRIMARY KEY (`metakey`)
) TYPE=MyISAM COMMENT='SmartBilling by The SmartFactory <www.smartfactory.ca>' ;

INSERT INTO `smartbilling_meta` VALUES ('version',9);
