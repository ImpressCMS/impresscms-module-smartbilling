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


// Main admin - account.php
define("_AM_SBILLING_ACCOUNTS", "Account Listing");
define("_AM_SBILLING_ACCOUNTS_DSC", "All accounts in the module");
define("_AM_SBILLING_ACCOUNT_CREATE", "Add an account");

define("_AM_SBILLING_ACCOUNT", "Account");
define("_AM_SBILLING_ACCOUNT_CREATE_INFO", "Fill-out the following form to create a new account.");
define("_AM_SBILLING_ACCOUNT_EDIT", "Edit this account");
define("_AM_SBILLING_ACCOUNT_EDIT_INFO", "Fill-out the following form in order to edit this account.");
define("_AM_SBILLING_ACCOUNT_MODIFIED", "The account was successfully modified.");
define("_AM_SBILLING_ACCOUNT_CREATED", "The account has been successfully created.");
define("_AM_SBILLING_ACCOUNT_VIEW", "Account info");
define("_AM_SBILLING_ACCOUNT_VIEW_DSC", "Here is all the about this account as well as the users linked to it.");

define("_AM_SBILLING_ACCOUNT_NEW_INVOICE", "Create a new invoice for this account");

define("_AM_SBILLING_ACCOUNT_NEW_USER", "Create a new user");


//account_user

define("_AM_SBILLING_ACCOUNT_USERS", "Account users");
define("_AM_SBILLING_ACCOUNT_USERS_DSC", "Users who are linked to this account");
define("_AM_SBILLING_ACCOUNT_USER_CREATE", "Add a user");
define("_AM_SBILLING_ACCOUNT_USER", "User");
define("_AM_SBILLING_ACCOUNT_USER_CREATE_INFO", "Select the user you would like to link to this account.");
define("_AM_SBILLING_ACCOUNT_USER_CREATED", "The user has been successfully added to this account.");
define("_AM_SBILLING_ACCOUNT_USER_CREATED_ERROR", "An error occured when linking a user to this account.");
define("_AM_SBILLING_ACCOUNT_USER_CREATED_NEW_ERROR", "An error occured when creating the new user.");
define("_AM_SBILLING_ACCOUNT_USER_NOT_SELECT", "A user must be selected or a new one created.");

//invoices

define("_AM_SBILLING_INVOICES", "Invoice Listing");
define("_AM_SBILLING_INVOICES_DSC", "All invoices in the module");
define("_AM_SBILLING_INVOICE_CREATE", "Add an invoice");
define("_AM_SBILLING_INVOICE", "Invoice");
define("_AM_SBILLING_INVOICE_CREATE_INFO", "Fill-out the following form to create a new invoice.");
define("_AM_SBILLING_INVOICE_EDIT", "Edit this invoice");
define("_AM_SBILLING_INVOICE_EDIT_INFO", "Fill-out the following form in order to edit this invoice.");
define("_AM_SBILLING_INVOICE_MODIFIED", "The invoice was successfully modified.");
define("_AM_SBILLING_INVOICE_CREATED", "The invoice has been successfully created.");
define("_AM_SBILLING_INVOICE_VIEW", "Invoice info");
define("_AM_SBILLING_INVOICE_VIEW_DSC", "Here is the info about this invoice as well as the payments made so far.");
define("_AM_SBILLING_INVOICE_NEW_PAYMENT", "Add a payment for this invoice");
define("_AM_SBILLING_SUBMENU_INVOICES", "Invoices");

//payment

define("_AM_SBILLING_PAYMENTS", "Payment Listing");
define("_AM_SBILLING_PAYMENTS_DSC", "All payments in the module");
define("_AM_SBILLING_PAYMENT_CREATE", "Add a payment");
define("_AM_SBILLING_PAYMENT", "Payment");
define("_AM_SBILLING_PAYMENT_CREATE_INFO", "Fill-out the following form to create a new payment.");
define("_AM_SBILLING_PAYMENT_EDIT", "Edit this payment");
define("_AM_SBILLING_PAYMENT_EDIT_INFO", "Fill-out the following form in order to edit this payment.");
define("_AM_SBILLING_PAYMENT_MODIFIED", "The payment was successfully modified.");
define("_AM_SBILLING_PAYMENT_CREATED", "The payment has been successfully created.");
define("_AM_SBILLING_TOTAL_BALANCE", "Outstanding");
//define("_AM_SBILLING_TOTAL_BALANCE", "Receivable");
define("_AM_SBILLING_SUBMENU_PAYMENTS", "Payments");

//suppliers

define("_AM_SBILLING_SUPPLIERS", "Supplier Listing");
define("_AM_SBILLING_SUPPLIERS_DSC", "All suppliers in the module");
define("_AM_SBILLING_SUPPLIER_CREATE", "Add a supplier");
define("_AM_SBILLING_SUPPLIER", "Supplier");
define("_AM_SBILLING_SUPPLIER_CREATE_INFO", "Fill-out the following form to create a new supplier.");
define("_AM_SBILLING_SUPPLIER_EDIT", "Edit this supplier");
define("_AM_SBILLING_SUPPLIER_EDIT_INFO", "Fill-out the following form in order to edit this supplier.");
define("_AM_SBILLING_SUPPLIER_MODIFIED", "The supplier was successfully modified");
define("_AM_SBILLING_SUPPLIER_CREATED", "The supplier has been successfully created.");
define("_AM_SBILLING_SUPPLIER_VIEW", "Supplier info");
define("_AM_SBILLING_SUPPLIER_VIEW_DSC", "Here is the info about this supplier as well as the payments made so far.");
define("_AM_SBILLING_SUPPLIER_NEW_PAYMENT", "Add a payment for this supplier");

//webaccount

define("_AM_SBILLING_WEBACCOUNTS", "Web account Listing");
define("_AM_SBILLING_WEBACCOUNTS_DSC", "All web accounts in the module");
define("_AM_SBILLING_WEBACCOUNT_CREATE", "Add a web account");
define("_AM_SBILLING_WEBACCOUNT", "Web account");
define("_AM_SBILLING_WEBACCOUNT_CREATE_INFO", "Fill-out the following form to create a new web account.");
define("_AM_SBILLING_WEBACCOUNT_EDIT", "Edit this web account");
define("_AM_SBILLING_WEBACCOUNT_EDIT_INFO", "Fill-out the following form in order to edit this web account.");
define("_AM_SBILLING_WEBACCOUNT_MODIFIED", "The web account was successfully modified.");
define("_AM_SBILLING_WEBACCOUNT_CREATED", "The web account has been successfully created.");
define("_AM_SBILLING_WEBACCOUNT_VIEW", "Web account info");
define("_AM_SBILLING_WEBACCOUNT_VIEW_DSC", "Here is the info about this web account.");
define("_AM_SBILLING_WEBACCOUNT_NEW_PAYMENT", "Add a payment for this web account");

//domain

define("_AM_SBILLING_DOMAINS", "Domain Listing");
define("_AM_SBILLING_DOMAINS_DSC", "All domains in the module");
define("_AM_SBILLING_DOMAIN_CREATE", "Add a domain");
define("_AM_SBILLING_DOMAIN", "Domain");
define("_AM_SBILLING_DOMAIN_CREATE_INFO", "Fill-out the following form to create a new domain.");
define("_AM_SBILLING_DOMAIN_EDIT", "Edit this domain");
define("_AM_SBILLING_DOMAIN_EDIT_INFO", "Fill-out the following form in order to edit this domain.");
define("_AM_SBILLING_DOMAIN_MODIFIED", "The domain was successfully modified.");
define("_AM_SBILLING_DOMAIN_CREATED", "The domain has been successfully created.");
define("_AM_SBILLING_DOMAIN_VIEW", "Domain info");
define("_AM_SBILLING_DOMAIN_VIEW_DSC", "Here is the info about this domain as well as the payments made so far.");
define("_AM_SBILLING_DOMAIN_NEW_PAYMENT", "Add a payment for this domain");

//server

define("_AM_SBILLING_SERVERS", "Server Listing");
define("_AM_SBILLING_SERVERS_DSC", "All servers in the module");
define("_AM_SBILLING_SERVER_CREATE", "Add a server");
define("_AM_SBILLING_SERVER", "Server");
define("_AM_SBILLING_SERVER_CREATE_INFO", "Fill-out the following form to create a new server.");
define("_AM_SBILLING_SERVER_EDIT", "Edit this server");
define("_AM_SBILLING_SERVER_EDIT_INFO", "Fill-out the following form in order to edit this server.");
define("_AM_SBILLING_SERVER_MODIFIED", "The server was successfully modified.");
define("_AM_SBILLING_SERVER_CREATED", "The server has been successfully created.");
define("_AM_SBILLING_SERVER_VIEW", "Server info");
define("_AM_SBILLING_SERVER_VIEW_DSC", "Here is the info about this server as well as the payments made so far.");
define("_AM_SBILLING_SERVER_NEW_PAYMENT", "Add a payment for this server");
define("_AM_SBILLING_SERVER_WEBACCOUNTS", "Web accounts");
define("_AM_SBILLING_SERVER_WEBACCOUNTS_DSC", "Accounts hosted on this server");


// Time tracking
define("_AM_SBILLING_TIME_TRACKING", "Time tracking");

//project

define("_AM_SBILLING_PROJECTS", "Project Listing");
define("_AM_SBILLING_PROJECTS_DSC", "All projects in the module");
define("_AM_SBILLING_PROJECT_CREATE", "Add a project");
define("_AM_SBILLING_PROJECT", "Project");
define("_AM_SBILLING_PROJECT_CREATE_INFO", "Fill-out the following form to create a new project.");
define("_AM_SBILLING_PROJECT_EDIT", "Edit this project");
define("_AM_SBILLING_PROJECT_EDIT_INFO", "Fill-out the following form in order to edit this project.");
define("_AM_SBILLING_PROJECT_MODIFIED", "The project was successfully modified.");
define("_AM_SBILLING_PROJECT_CREATED", "The project has been successfully created.");
define("_AM_SBILLING_SUBMENU_PROJECTS", "Projects");
define("_AM_SBILLING_PROJECT_VIEW", "Project info");
define("_AM_SBILLING_PROJECT_VIEW_DSC", "Here is the info about this project.");


//activity

define("_AM_SBILLING_ACTIVITYS", "Log Listing");
define("_AM_SBILLING_ACTIVITYS_DSC", "All activities in the module");
define("_AM_SBILLING_ACTIVITY_CREATE", "Add an activity");
define("_AM_SBILLING_ACTIVITY", "Log");
define("_AM_SBILLING_ACTIVITY_CREATE_INFO", "Fill-out the following form to create a new activity.");
define("_AM_SBILLING_ACTIVITY_EDIT", "Edit this activity");
define("_AM_SBILLING_ACTIVITY_EDIT_INFO", "Fill-out the following form in order to edit this activity.");
define("_AM_SBILLING_ACTIVITY_MODIFIED", "The activity successfully modified");
define("_AM_SBILLING_ACTIVITY_CREATED", "The activity has been successfully created");
define("_AM_SBILLING_ACTIVITY_VIEW", "Log info");
define("_AM_SBILLING_ACTIVITY_VIEW_DSC", "Here is the info about this activity.");

//activity_project

define("_AM_SBILLING_LOG_PROJECTS", "Log Listing");
define("_AM_SBILLING_LOG_PROJECTS_DSC", "All activities in the module");
define("_AM_SBILLING_LOG_PROJECT_CREATE", "Add an activity");
define("_AM_SBILLING_LOG_PROJECT", "Log");
define("_AM_SBILLING_LOG_PROJECT_CREATE_INFO", "Fill-out the following form to create a new activity.");
define("_AM_SBILLING_LOG_PROJECT_EDIT", "Edit this activity");
define("_AM_SBILLING_LOG_PROJECT_EDIT_INFO", "Fill-out the following form in order to edit this activity.");
define("_AM_SBILLING_LOG_PROJECT_MODIFIED", "The activity was successfully modified.");
define("_AM_SBILLING_LOG_PROJECT_CREATED", "The activity has been successfully created.");
define("_AM_SBILLING_SUBMENU_LOG_PROJECTS", "Activities");
define("_AM_SBILLING_LOG_PROJECT_VIEW", "Log info");
define("_AM_SBILLING_LOG_PROJECT_VIEW_DSC", "Here is the info about this activity.");



define("_AM_SBILLING_SUBMENU_SERVERS", "Servers");
define("_AM_SBILLING_SUBMENU_DOMAINS", "Domains");
define("_AM_SBILLING_SUBMENU_SUPPLIERS", "Suppliers");
define("_AM_SBILLING_MENU_WEBACCOUNTS", "Web Accounts");

define("_AM_SBILLING_SUBMENU_LOG", "Logs");
define("_AM_SBILLING_SUBMENU_ACTIVITIES", "Activities");
define("_AM_SBILLING_SUBMENU_REPORTS", "Reports");

//log

define("_AM_SBILLING_LOGS", "Log Listing");
define("_AM_SBILLING_LOGS_DSC", "All logs in the module");
define("_AM_SBILLING_LOG_CREATE", "Add a log");
define("_AM_SBILLING_LOG", "Log");
define("_AM_SBILLING_LOG_CREATE_INFO", "Fill-out the following form to create a new log.");
define("_AM_SBILLING_LOG_EDIT", "Edit this log");
define("_AM_SBILLING_LOG_EDIT_INFO", "Fill-out the following form in order to edit this log.");
define("_AM_SBILLING_LOG_MODIFIED", "The log was successfully modified.");
define("_AM_SBILLING_LOG_CREATED", "The log has been successfully created.");
define("_AM_SBILLING_LOG_VIEW", "Log info");
define("_AM_SBILLING_LOG_VIEW_DSC", "Here is the info about this log.");
?>