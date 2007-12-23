<?php

/**
* $Id$
* Module: SmartBilling
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

if (!defined("XOOPS_ROOT_PATH")) {
 	die("XOOPS root path not defined");
}

$modversion['name'] = _MI_SBILLING_MD_NAME;
$modversion['version'] = 1.0;
$modversion['description'] = _MI_SBILLING_MD_DESC;
$modversion['author'] = "INBOX International";
$modversion['credits'] = "The SmartFactory";
$modversion['help'] = "";
$modversion['license'] = "GNU General Public License (GPL)";
$modversion['official'] = 0;
$modversion['image'] = "images/module_logo.gif";
$modversion['dirname'] = "smartbilling";

// Added by marcan for the About page in admin section
$modversion['developer_website_url'] = "http://smartfactory.ca";
$modversion['developer_website_name'] = "The SmartFactory";
$modversion['developer_email'] = "info@smartfactory.ca";
$modversion['status_version'] = "Beta 1";
$modversion['status'] = "Beta";
$modversion['date'] = "unreleased";

$modversion['people']['developers'][] = "[url=http://smartfactory.ca/userinfo.php?uid=1]marcan[/url] (Marc-André Lanciault)";
$modversion['people']['developers'][] = "[url=http://smartfactory.ca/userinfo.php?uid=112]felix[/url] (Félix Tousignant)";

//$modversion['people']['testers'][] = "Rob Butterworth";

//$modversion['people']['translators'][] = "translator 1";

//$modversion['people']['documenters'][] = "documenter 1";

//$modversion['people']['other'][] = "other 1";

$modversion['warning'] = _CO_SOBJECT_WARNING_BETA;

$modversion['author_word'] = "";

$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

$modversion['onInstall'] = "include/onupdate.inc.php";
$modversion['onUpdate'] = "include/onupdate.inc.php";

$modversion['tables'][0] = "smartbilling_meta";
$modversion['tables'][1] = "smartbilling_account";
$modversion['tables'][2] = "smartbilling_invoice";
$modversion['tables'][3] = "smartbilling_payment";

// Search
$modversion['hasSearch'] = 0;
$modversion['search']['file'] = "include/search.inc.php";
$modversion['search']['func'] = "smartbilling_search";
// Menu
$modversion['hasMain'] = 1;
/*
global $xoopsUser;
if (is_object($xoopsUser)) {
	$modversion['sub'][1]['name'] = _MI_SBILLING_MYCLASS;
	$modversion['sub'][1]['url'] = "myclass.php";
}
*/
/*
$modversion['blocks'][1]['file'] = "new_adds.php";
$modversion['blocks'][1]['name'] = _MI_SBILLING_NEW_ADDS;
$modversion['blocks'][1]['show_func'] = "new_adds_show";
$modversion['blocks'][1]['edit_func'] = "new_adds_edit";
$modversion['blocks'][1]['template'] = "smartbilling_new_adds.html";

*/
global $xoopsModule;
// Templates
$i = 0;

$i++;
$modversion['templates'][$i]['file'] = 'smartbilling_header.html';
$modversion['templates'][$i]['description'] = 'Header template of all pages';

$i++;
$modversion['templates'][$i]['file'] = 'smartbilling_footer.html';
$modversion['templates'][$i]['description'] = 'Footer template of all pages';

$i++;
$modversion['templates'][$i]['file'] = 'smartbilling_index.html';
$modversion['templates'][$i]['description'] = 'Display Index page';

$i++;
$modversion['templates'][$i]['file'] = 'smartbilling_invoice_summary.html';
$modversion['templates'][$i]['description'] = 'Display invoice summary';

$i++;
$modversion['templates'][$i]['file'] = 'smartbilling_account_summary.html';
$modversion['templates'][$i]['description'] = 'Display account summary';

$i++;
$modversion['templates'][$i]['file'] = 'smartbilling_balance.html';
$modversion['templates'][$i]['description'] = 'Display balance';

$i++;
$modversion['templates'][$i]['file'] = 'smartbilling_log.html';
$modversion['templates'][$i]['description'] = 'User side logs';

$i++;
$modversion['templates'][$i]['file'] = 'smartbilling_invoice.html';
$modversion['templates'][$i]['description'] = 'Invoices page';

// Config Settings (only for modules that need config settings generated automatically)
$i = 0;

// Retreive the group user list, because the autpmatic group_multi config formtype does not include Anonymous group :-(
$member_handler =& xoops_gethandler('member');
$groups_array = $member_handler->getGroupList();
foreach($groups_array as $k=>$v) {
	$select_groups_options[$v] = $k;
}
//common prefs for all module uses
$i++;
$modversion['config'][$i]['name'] = 'new_user_groups';
$modversion['config'][$i]['title'] = '_MI_SBILLING_NEWUGROUP';
$modversion['config'][$i]['description'] = '_MI_SBILLING_NEWUGROUPDSC';
$modversion['config'][$i]['formtype'] = 'select_multi';
$modversion['config'][$i]['valuetype'] = 'array';
$modversion['config'][$i]['options'] = $select_groups_options;
$modversion['config'][$i]['default'] =  '2';

/*
$i++;
$modversion['config'][$i]['name'] = 'show_subcats';
$modversion['config'][$i]['title'] = '_MI_SBILLING_SHOW_SUBCATS';
$modversion['config'][$i]['description'] = '_MI_SBILLING_SHOW_SUBCATS_DSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'all';
$modversion['config'][$i]['options'] = array(_MI_SBILLING_SHOW_SUBCATS_NO  => 'no',
                                   		_MI_SBILLING_SHOW_SUBCATS_NOTEMPTY   => 'nonempty',
                                  		 _MI_SBILLING_SHOW_SUBCATS_ALL => 'all');
*/
/*
$i++;
$modversion['config'][$i]['name'] = 'qualifying_period';
$modversion['config'][$i]['title'] = '_MI_SBILLING_QUALPERIOD';
$modversion['config'][$i]['description'] = '_MI_SBILLING_QUALPERIODDSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 36;

$i++;
$modversion['config'][$i]['name'] = 'qualifying_hours';
$modversion['config'][$i]['title'] = '_MI_SBILLING_QUALHOURS';
$modversion['config'][$i]['description'] = '_MI_SBILLING_QUALHOURSDSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 90;

$i++;
$modversion['config'][$i]['name'] = 'associated_designation';
$modversion['config'][$i]['title'] = '_MI_SBILLING_ASSDESIGN';
$modversion['config'][$i]['description'] = '_MI_SBILLING_ASSDESIGNDSC';
$modversion['config'][$i]['formtype'] = 'textarea';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name'] = 'categories';
$modversion['config'][$i]['title'] = '_MI_SBILLING_CAT';
$modversion['config'][$i]['description'] = '_MI_SBILLING_CATDSC';
$modversion['config'][$i]['formtype'] = 'textarea';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name'] = 'paypal_email';
$modversion['config'][$i]['title'] = '_MI_SBILLING_PAYPAL';
$modversion['config'][$i]['description'] = '_MI_SBILLING_PAYPALDSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name'] = 'default_payee';
$modversion['config'][$i]['title'] = '_MI_SBILLING_PAYEE';
$modversion['config'][$i]['description'] = '_MI_SBILLING_PAYEEDSC';
$modversion['config'][$i]['formtype'] = 'textarea';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name'] = 'default_timezone';
$modversion['config'][$i]['title'] = '_MI_SBILLING_TZ';
$modversion['config'][$i]['description'] = '_MI_SBILLING_TZDSC';
$modversion['config'][$i]['formtype'] = 'timezone';
$modversion['config'][$i]['valuetype'] = 'float';
$modversion['config'][$i]['default'] = '-7';
*/
/*
// Notification
$modversion['hasNotification'] = 1;
$modversion['notification']['lookup_file'] = 'include/notification.inc.php';
$modversion['notification']['lookup_func'] = 'smartbilling_notify_iteminfo';

/*$modversion['notification']['category'][1]['name'] = 'global';
$modversion['notification']['category'][1]['title'] = _MI_SBILLING_GLOBAL_ITEM_NOTIFY;
$modversion['notification']['category'][1]['description'] = _MI_SBILLING_GLOBAL_ITEM_NOTIFY_DSC;
$modversion['notification']['category'][1]['subscribe_from'] = array('index.php', 'category.php', 'item.php');

$modversion['notification']['category'][2]['name'] = 'item';
$modversion['notification']['category'][2]['title'] = _MI_SBILLING_ITEM_NOTIFY;
$modversion['notification']['category'][2]['description'] = _MI_SBILLING_ITEM_NOTIFY_DSC;
$modversion['notification']['category'][2]['subscribe_from'] = array('submit.php');
$modversion['notification']['category'][2]['item_name'] = 'itemid';

$modversion['notification']['event'][1]['name'] = 'approved';
$modversion['notification']['event'][1]['category'] = 'item';
$modversion['notification']['event'][1]['invisible'] = 1;
$modversion['notification']['event'][1]['title'] = _MI_SBILLING_ITEM_APPROVED_NOTIFY;
$modversion['notification']['event'][1]['caption'] = _MI_SBILLING_ITEM_APPROVED_NOTIFY_CAP;
$modversion['notification']['event'][1]['description'] = _MI_SBILLING_ITEM_APPROVED_NOTIFY_DSC;
$modversion['notification']['event'][1]['mail_template'] = 'item_approved';
$modversion['notification']['event'][1]['mail_subject'] = _MI_SBILLING_ITEM_APPROVED_NOTIFY_SBJ;


$modversion['notification']['event'][2]['name'] = 'submitted';
$modversion['notification']['event'][2]['category'] = 'global';
$modversion['notification']['event'][2]['admin_only'] = 1;
$modversion['notification']['event'][2]['title'] = _MI_SBILLING_ITEM_SUBMITTED_NOTIFY;
$modversion['notification']['event'][2]['caption'] = _MI_SBILLING_ITEM_SUBMITTED_NOTIFY_CAP;
$modversion['notification']['event'][2]['description'] = _MI_SBILLING_ITEM_SUBMITTED_NOTIFY_DSC;
$modversion['notification']['event'][2]['mail_template'] = 'item_submitted';
$modversion['notification']['event'][2]['mail_subject'] = _MI_SBILLING_ITEM_SUBMITTED_NOTIFY_SBJ;

$modversion['notification']['event'][3]['name'] = 'published';
$modversion['notification']['event'][3]['category'] = 'global';
$modversion['notification']['event'][3]['title'] = _MI_SBILLING_GLOBAL_ITEM_PUBLISHED_NOTIFY;
$modversion['notification']['event'][3]['caption'] = _MI_SBILLING_GLOBAL_ITEM_PUBLISHED_NOTIFY_CAP;
$modversion['notification']['event'][3]['description'] = _MI_SBILLING_GLOBAL_ITEM_PUBLISHED_NOTIFY_DSC;
$modversion['notification']['event'][3]['mail_template'] = 'global_published';
$modversion['notification']['event'][3]['mail_subject'] = _MI_SBILLING_GLOBAL_ITEM_PUBLISHED_NOTIFY_SBJ;
*/
?>