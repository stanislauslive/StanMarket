<?php
/*
  Copyright (c) 2002 - 2006 SystemsManager.Net

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

  function smn_update_whos_online() {
    global $customer_id;

    if (smn_session_is_registered('customer_id')) {
      $wo_customer_id = $customer_id;

      $customer_query = smn_db_query("select customers_firstname, customers_lastname from " . TABLE_CUSTOMERS . " where customers_id = '" . (int)$customer_id . "'");
      $customer = smn_db_fetch_array($customer_query);

      $wo_full_name = $customer['customers_firstname'] . ' ' . $customer['customers_lastname'];
    } else {
      $wwo_full_name = 'Guest';
    }

    $wo_session_id = smn_session_id();
    $wo_ip_address = getenv('REMOTE_ADDR');
    $wo_last_page_url = getenv('REQUEST_URI');

    $current_time = time();
    $xx_mins_ago = ($current_time - 900);

// remove entries that have expired
    smn_db_query("delete from " . TABLE_WHOS_ONLINE . " where time_last_click < '" . $xx_mins_ago . "'");

    $stored_customer_query = smn_db_query("select count(*) as count from " . TABLE_WHOS_ONLINE . " where session_id = '" . smn_db_input($wo_session_id) . "'");
    $stored_customer = smn_db_fetch_array($stored_customer_query);

    if ($stored_customer['count'] > 0) {
      smn_db_query("update " . TABLE_WHOS_ONLINE . " set customer_id = '" . (int)$wo_customer_id . "', full_name = '" . smn_db_input($wo_full_name) . "', ip_address = '" . smn_db_input($wo_ip_address) . "', time_last_click = '" . smn_db_input($current_time) . "', last_page_url = '" . smn_db_input($wo_last_page_url) . "' where session_id = '" . smn_db_input($wo_session_id) . "'");
    } else {
      smn_db_query("insert into " . TABLE_WHOS_ONLINE . " (customer_id, full_name, session_id, ip_address, time_entry, time_last_click, last_page_url) values ('" . (int)$wo_customer_id . "', '" . smn_db_input($wo_full_name) . "', '" . smn_db_input($wo_session_id) . "', '" . smn_db_input($wo_ip_address) . "', '" . smn_db_input($current_time) . "', '" . smn_db_input($current_time) . "', '" . smn_db_input($wo_last_page_url) . "')");
    }
  }
?>
