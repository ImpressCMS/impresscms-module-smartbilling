<?php

/**
* $Id$
* Module: SmartBilling
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

/**  Text edited by RJB on 3/10/07 */

if (!defined("XOOPS_ROOT_PATH")) {
 	die("XOOPS root path not defined");
}

// account.php
define("_CO_SBILLING_ACCOUNT_NAME", "Account name");
define("_CO_SBILLING_ACCOUNT_NAME_DSC", "");
define("_CO_SBILLING_ACCOUNT_UNAME", "User link to this account");
define("_CO_SBILLING_ACCOUNT_UNAME_DSC", "");
define("_CO_SBILLING_ACCOUNT_CONTACT_LASTNAME", "Contact last name");
define("_CO_SBILLING_ACCOUNT_CONTACT_LASTNAME_DSC", "");
define("_CO_SBILLING_ACCOUNT_CONTACT_FIRSTNAME", "Contact first name");
define("_CO_SBILLING_ACCOUNT_CONTACT_FIRSTNAME_DSC", "");
define("_CO_SBILLING_ACCOUNT_CONTACT_EMAIL", "Email");
define("_CO_SBILLING_ACCOUNT_CONTACT_EMAIL_DSC", "");
define("_CO_SBILLING_ACCOUNT_CONTACT_PHONE", "Phone");
define("_CO_SBILLING_ACCOUNT_CONTACT_PHONE_DSC", "");
define("_CO_SBILLING_ACCOUNT_WEBSITE", "Company's web site");
define("_CO_SBILLING_ACCOUNT_WEBSITE_DSC", "");

// account_user

define("_CO_SBILLING_ACCOUNT_USER_UID", "User");
define("_CO_SBILLING_ACCOUNT_USER_UID_DSC", "");
define("_CO_SBILLING_ACCOUNT_USER_ACCOUNTID", "Account");
define("_CO_SBILLING_ACCOUNT_USER_ACCOUNTID_DSC", "");
define("_CO_SBILLING_ACCOUNT_USER_EMAIL", "Email");
define("_CO_SBILLING_ACCOUNT_USER_REALNAME", "User real name");
define("_CO_SBILLING_ACCOUNT_USER_URL", "User web site");
define("_CO_SBILLING_ACCOUNT_USER_UNAME", "Username");
define("_CO_SBILLING_ACCOUNT_USER_PASSWORD", "Password");
define("_CO_SBILLING_ACCOUNT_USER_NOTIFICATION", "Notify the newly created user by email");


//invoice.php
define("_CO_SBILLING_INVOICE_ACCOUNTID", "Account");
define("_CO_SBILLING_INVOICE_ACCOUNTID_DSC", "");
define("_CO_SBILLING_INVOICE_NUMBER", "Invoice number");
define("_CO_SBILLING_INVOICE_NUMBER_DSC", "");
define("_CO_SBILLING_INVOICE_AMOUNT", "Amount");
define("_CO_SBILLING_INVOICE_AMOUNT_DSC", "");
define("_CO_SBILLING_INVOICE_CURRENCY", "Currency");
define("_CO_SBILLING_INVOICE_CURRENCY_DSC", "");
define("_CO_SBILLING_INVOICE_DATE", "Date");
define("_CO_SBILLING_INVOICE_DATE_DSC", "");
define("_CO_SBILLING_INVOICE_STATUS", "Status");
define("_CO_SBILLING_INVOICE_STATUS_DSC", "");
define("_CO_SBILLING_INVOICE_NOTE", "Notes");
define("_CO_SBILLING_INVOICE_NOTE_DSC", "");
define("_CO_SBILLING_INVOICE_TOTAL_PAID", "Total amount paid");
define("_CO_SBILLING_INVOICES_NOT_PAID", "Standing invoices");
define("_CO_SBILLING_INVOICES_PAID", "Paid invoices");
define("_CO_SBILLING_INVOICES_LOST", "Lost invoices");
define("_CO_SBILLING_INVOICE_FILE", "Invoice file");
define("_CO_SBILLING_INVOICE_FILE_DSC", "");
define("_CO_SBILLING_INVOICE_FILE_DOWNLOAD", "View invoice file");
define("_CO_SBILLING_INVOICE_BALANCE", "Balance");
define("_CO_SBILLING_INVOICE_EXPECTED_PAYMENT_METHOD", "Method");
define("_CO_SBILLING_INVOICE_EXPECTED_PAYMENT_METHOD_DSC", "");
define("_CO_SBILLING_PAYMENT_METHOD", "Payment method");
define("_CO_SBILLING_PAYMENT_METHOD_DSC", "");
define("_CO_SBILLING_PAYMENT_METHOD_CHECK", "Check");
define("_CO_SBILLING_PAYMENT_METHOD_PAYPAL", "PayPal");
define("_CO_SBILLING_INVOICE_STATUS_STANDING", "Standing");
define("_CO_SBILLING_INVOICE_STATUS_PAID", "Paid");
define("_CO_SBILLING_INVOICE_STATUS_LOST", "Lost");


//payment

define("_CO_SBILLING_PAYMENT_INVOICEID", "Invoice");
define("_CO_SBILLING_PAYMENT_INVOICEID_DSC", "");
define("_CO_SBILLING_PAYMENT_AMOUNT", "Amount");
define("_CO_SBILLING_PAYMENT_AMOUNT_DSC", "");
define("_CO_SBILLING_PAYMENT_DATE", "Date");
define("_CO_SBILLING_PAYMENT_DATE_DSC", "");
define("_CO_SBILLING_PAYMENT_NOTE", "Notes");
define("_CO_SBILLING_PAYMENT_NOTE_DSC", "");

//domain

define("_CO_SBILLING_DOMAIN_ACCOUNTID", "Account");
define("_CO_SBILLING_DOMAIN_ACCOUNTID_DSC", "");
define("_CO_SBILLING_DOMAIN_NAME", "Name");
define("_CO_SBILLING_DOMAIN_NAME_DSC", "");
define("_CO_SBILLING_DOMAIN_REGISTRAR", "Registrar");
define("_CO_SBILLING_DOMAIN_REGISTRAR_DSC", "");
define("_CO_SBILLING_DOMAIN_NOTE", "Notes");
define("_CO_SBILLING_DOMAIN_NOTE_DSC", "");

//web account

define("_CO_SBILLING_WEBACCOUNT_ACCOUNTID", "Account");
define("_CO_SBILLING_WEBACCOUNT_ACCOUNTID_DSC", "");
define("_CO_SBILLING_WEBACCOUNT_SERVERID", "Server");
define("_CO_SBILLING_WEBACCOUNT_SERVERID_DSC", "");
define("_CO_SBILLING_WEBACCOUNT_WEBACCOUNTID", "Server");
define("_CO_SBILLING_WEBACCOUNT_WEBACCOUNTID_DSC", "");
define("_CO_SBILLING_WEBACCOUNT_DOMAIN", "Domain");
define("_CO_SBILLING_WEBACCOUNT_DOMAIN_DSC", "");
define("_CO_SBILLING_WEBACCOUNT_NOTE", "Notes");
define("_CO_SBILLING_WEBACCOUNT_NOTE_DSC", "");
define("_CO_SBILLING_WEBACCOUNT_DISK_LIMIT", "Disk limit");
define("_CO_SBILLING_WEBACCOUNT_DISK_LIMIT_DSC", "");
define("_CO_SBILLING_WEBACCOUNT_BANDWIDTH_LIMIT", "Bandwidth limit");
define("_CO_SBILLING_WEBACCOUNT_BANDWIDTH_LIMIT_DSC", "");
define("_CO_SBILLING_WEBACCOUNT_MONTHLY_COST", "Monthly cost");
define("_CO_SBILLING_WEBACCOUNT_MONTHLY_COST_DSC", "");
define("_CO_SBILLING_WEBACCOUNT_DATE", "Creation date");
define("_CO_SBILLING_WEBACCOUNT_DATE_DSC", "");
define("_CO_SBILLING_WEBACCOUNT_NEXT_BILLING_DATE", "Next billing date");
define("_CO_SBILLING_WEBACCOUNT_NEXT_BILLING_DATE_DSC", "");
define("_CO_SBILLING_WEBACCOUNT_STATUS", "Status");
define("_CO_SBILLING_WEBACCOUNT_STATUS_DSC", "");
define("_CO_SBILLING_WEBACCOUNT_STATUS_NORMAL", "Normal");
define("_CO_SBILLING_WEBACCOUNT_STATUS_FREE", "Free");
define("_CO_SBILLING_WEBACCOUNT_STATUS_INACTIVE", "Inactive");
define("_CO_SBILLING_WEBACCOUNT_STATUS_NOTSET", "Not set");
define("_CO_SBILLING_WEBACCOUNT_STATUS_INPACKAGE", "In package");
define("_CO_SBILLING_WEBACCOUNT_STATUS_DELETED", "Deleted");
define("_CO_SBILLING_WEBACCOUNT_STATUS_INTERNAL", "Internal use");
define("_CO_SBILLING_WEB_ACCOUNT_DUE", "Next billing date overdue");
define("_CO_SBILLING_WEB_ACCOUNT_30DAYS", "Next billing date less then 30 days");



//server

define("_CO_SBILLING_SERVER_SUPPLIERID", "Supplier");
define("_CO_SBILLING_SERVER_SUPPLIERID_DSC", "");
define("_CO_SBILLING_SERVER_NAME", "Name");
define("_CO_SBILLING_SERVER_NAME_DSC", "");
define("_CO_SBILLING_SERVER_NOTE", "Notes");
define("_CO_SBILLING_SERVER_NOTE_DSC", "");


//supplier

define("_CO_SBILLING_SUPPLIER_NAME", "Name");
define("_CO_SBILLING_SUPPLIER_NAME_DSC", "");
define("_CO_SBILLING_SUPPLIER_NOTE", "Notes");
define("_CO_SBILLING_SUPPLIER_NOTE_DSC", "");

//project

define("_CO_SBILLING_PROJECT_NAME", "Name");
define("_CO_SBILLING_PROJECT_NAME_DSC", "");
define("_CO_SBILLING_PROJECT_DESCRIPTION", "Description");
define("_CO_SBILLING_PROJECT_DESCRIPTION_DSC", "");

//activity

define("_CO_SBILLING_ACTIVITY_NAME", "Name");
define("_CO_SBILLING_ACTIVITY_NAME_DSC", "");
define("_CO_SBILLING_ACTIVITY_DESCRIPTION", "Description");
define("_CO_SBILLING_ACTIVITY_DESCRIPTION_DSC", "");
define("_CO_SBILLING_ACTIVITY_PROJECTS", "This activity will be available in these projects");

//activity_project
define("_CO_SBILLING_ACTIVITY_PROJECT_ACTIVITYID", "Activity");
define("_CO_SBILLING_ACTIVITY_PROJECT_ACTIVITYID_DSC", "");
define("_CO_SBILLING_ACTIVITY_PROJECT_PROJECTID", "Project");
define("_CO_SBILLING_ACTIVITY_PROJECT_PROJECTID_DSC", "");
define("_CO_SBILLING_ACTIVITY_PROJECT_NAME", "Name");
define("_CO_SBILLING_ACTIVITY_PROJECT_NAME_DSC", "");
define("_CO_SBILLING_ACTIVITY_PROJECT_DESCRIPTION", "Description");
define("_CO_SBILLING_ACTIVITY_PROJECT_DESCRIPTION_DSC", "");

//log

define("_CO_SBILLING_LOG_UID", "User");
define("_CO_SBILLING_LOG_UID_DSC", "");
define("_CO_SBILLING_LOG_DATE", "Date");
define("_CO_SBILLING_LOG_DATE_DSC", "");
define("_CO_SBILLING_LOG_ACCOUNTID", "Account");
define("_CO_SBILLING_LOG_ACCOUNTID_DSC", "");
define("_CO_SBILLING_LOG_PROJECTID", "Project");
define("_CO_SBILLING_LOG_PROJECTID_DSC", "");
define("_CO_SBILLING_LOG_ACTIVITYID", "Activity");
define("_CO_SBILLING_LOG_ACTIVITYID_DSC", "");
define("_CO_SBILLING_LOG_START", "Start");
define("_CO_SBILLING_LOG_START_DSC", "");
define("_CO_SBILLING_LOG_FINISH", "Finish");
define("_CO_SBILLING_LOG_FINISH_DSC", "");
define("_CO_SBILLING_LOG_DURATION", "Duration");
define("_CO_SBILLING_LOG_DURATION_DSC", "");
define("_CO_SBILLING_LOG_NOTE", "Notes");
define("_CO_SBILLING_LOG_NOTE_DSC", "");
define("_CO_SBILLING_LOG_BILLABLE", "Billable");
define("_CO_SBILLING_LOG_BILLABLE_DSC", "");
define("_CO_SBILLING_LOG_ACTIVITY_PROJECTID", "Project");
define("_CO_SBILLING_LOG_ACTIVITY_PROJECTID_DSC", "");
?>