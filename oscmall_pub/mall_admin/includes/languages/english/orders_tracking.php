<?php
/*
  Copyright (c) 2002 - 2005 SystemsManager.Net

  SystemsManager Technologies
  oscMall System Version 4
  http://www.systemsmanager.net
  
  Portions Copyright (c) 2002 osCommerce
  
  This source file is subject to version 2.0 of the GPL license,   
  that is bundled with this package in the file LICENSE. If you
  did not receive a copy of the oscMall System license and are unable 
  to obtain it through the world-wide-web, please send a note to    
  license@systemsmanager.net so we can mail you a copy immediately.
*/

define('REPORT_DATE_FORMAT', 'm. d. Y');

define('HEADING_TITLE', 'Sales Report');

define('REPORT_TYPE_YEARLY', 'Yearly');
define('REPORT_TYPE_MONTHLY', 'Monthly');
define('REPORT_TYPE_WEEKLY', 'Weekly');
define('REPORT_TYPE_DAILY', 'Daily');
define('REPORT_START_DATE', 'from date ');
define('REPORT_END_DATE', ' to date (inclusive) ');
define('REPORT_DETAIL', 'detail');
define('REPORT_MAX', 'show top');
define('REPORT_ALL', 'all');
define('REPORT_SORT', 'sort');
define('REPORT_EXP', 'Export');
define('REPORT_SEND', 'Submit Query');
define('EXP_NORMAL', 'normal');
define('EXP_HTML', 'HTML only');
define('EXP_CSV', 'CSV Export');
define('EXP_ORDERS_HTML', 'Stores Report');
define('TABLE_HEADING_START_DATE', 'Report From Date');
define('TABLE_HEADING_END_DATE', 'Ending Date');
define('TABLE_HEADING_ORDERS', '#Orders ');
define('TABLE_HEADING_ITEMS', '#Items');
define('TABLE_HEADING_REVENUE', 'Revenue ');
define('TABLE_HEADING_SHIPPING', 'Shipping');
define('TABLE_HEADING_STATUS', 'Status');

define('DET_HEAD_ONLY', 'no details');
define('DET_DETAIL', 'show details');
define('DET_DETAIL_ONLY', 'details with amount');

define('SORT_VAL0', 'standard');
define('SORT_VAL1', 'description');
define('SORT_VAL2', 'description desc');
define('SORT_VAL3', '#Items');
define('SORT_VAL4', '#Items desc');
define('SORT_VAL5', 'Revenue');
define('SORT_VAL6', 'Revenue desc');

define('REPORT_STATUS_FILTER', 'Status');

define('SR_SEPARATOR1', ';');
define('SR_SEPARATOR2', '", ');
define('SR_START', '"');
define('SR_NEWLINE', '\n\r');


define('TEXT_TOTAL_REVENUE', 'Total Sales: ');
define('TEXT_PERCENTAGE_REVENUE', '% of Total Sales: ');
define('TEXT_MONTHLY_RENTAL', 'Shop Monthly Rental Fee: ');

define('STORE_NAME_LISTED', 'Store Name: ');
define('STORE_OWNER', 'Store Owner: ');
define('STORE_EMAIL', 'Store Email: ');
define('STORE_ADDRESS', 'Store Address:');

define('ORDERS_TRACKING_START', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
                        <html xml:lang="en" lang="en" xmlns="http://www.w3.org/1999/xhtml">
                        <head> 
                        <title>Vendors Orders Report</title>
                        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" /> 
                        </head> 
                        <body><b>List Start</b>');
define('ORDERS_TRACKING_END', ' </body>  </html>');
define('FONT_SIZE_START', '<big>');
define('FONT_SIZE_END', '</big>');
define('BR_NEWLINE', '<br>');

define('TRACKING_SEPARATOR', '---------------------------------------------------------------');
define('MID_TRACKING_SEPARATOR', '================================');

define('TEXT_SR_SEPARATOR1', ' use<b> ; </b>as a csv download separator');
define('TEXT_SR_SEPARATOR2', ' use<b> " </b>as a csv download separator');
define('TEXT_INCLUDE_BILLING_ADDRESS', ' include billing address in csv file');
define('TEXT_INCLUDE_DELIVERY_ADDRESS', ' include delivery address in csv file');
define('TEXT_INCLUDE_CUSTOMER_ADDRESS', ' include customer address in csv file');
define('TEXT_NOT_INCLUDE_BILLING_ADDRESS', ' <b>do not</b> include billing address in csv file');
define('TEXT_NOT_INCLUDE_DELIVERY_ADDRESS', ' <b>do not</b> include delivery address in csv file');
define('TEXT_NOT_INCLUDE_CUSTOMER_ADDRESS', ' <b>do not</b> include customer address in csv file');
?>
