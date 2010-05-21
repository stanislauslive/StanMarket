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

  require('includes/application_top.php');
  define('FILENAME_ACCOUNT_HISTORY_INFO', 'account_history_info.php');
  
    $start_day = getdate();
    $day = $start_day['mday'];
    $month = $start_day['mon'];
    $year = $start_day['year'];
    $product_email_date = strftime('%Y',mktime(0,0,0, $month, $day + (int)14, $year)) . '-' . strftime('%m',mktime(0,0,0, $month, $day + (int)14, $year)) . '-' . strftime('%d',mktime(0,0,0, $month, $day + (int)14, $year));
    $product_end_date = strftime('%Y',mktime(0,0,0, $month, $day, $year)) . '-' . strftime('%m',mktime(0,0,0, $month, $day, $year)) . '-' . strftime('%d',mktime(0,0,0, $month, $day, $year));

    $email_member_order_query = smn_db_query("select o.orders_id, o.customers_name, mo.products_id, o.customers_email_address from " . TABLE_ORDERS . " o, " . TABLE_MEMBER_ORDERS . " mo where o.orders_id = mo.orders_id and mo.products_end_date = '" . $product_email_date ."'");
    while ($email_member_order = smn_db_fetch_array($email_member_order_query)) {
        
         smn_db_query("insert into " . TABLE_CUSTOMERS_BASKET . " (customers_id, products_id, customers_basket_quantity, customers_basket_date_added) values ('" . $email_member_order['customer_id'] . "', '" . $email_member_order['$products_id'] . "', '" . 1 . "', '" . $product_email_date . "')");
        
        $email_order =  STORE_NAME . "\n" . 
                        EMAIL_SEPARATOR . "\n" . "\n" . 
                        EMAIL_TEXT_MEMBER_RENEWAL . "\n" .
                        EMAIL_SEPARATOR . "\n" . "\n" .
                        EMAIL_TEXT_INVOICE_URL . ' ' . smn_href_link(FILENAME_LOGIN, 'ID=1', 'NONSSL') . "\n" .
                        EMAIL_TEXT_DATE_END . ' ' . $product_email_date . "\n\n";
        smn_mail($email_member_order['customers_name'], $email_member_order['customers_email_address'], EMAIL_TEXT_SUBJECT, $email_order, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
        }
    
    $update_member_order_query = smn_db_query("select customer_id from " . TABLE_MEMBER_ORDERS . " where products_end_date = '" . $product_end_date . "'");
    
    while ($update_member_order = smn_db_fetch_array($update_member_order_query)) {
        smn_db_query("update " . TABLE_STORE_NAMES . " set store_status = 0 where customer_id = '" . $customer_id . "'");
        }
    
?>
