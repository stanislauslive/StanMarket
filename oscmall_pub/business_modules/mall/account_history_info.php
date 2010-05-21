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
   global $page_name; 

  if (!smn_session_is_registered('customer_id')) {
    $navigation->set_snapshot();
    smn_redirect(smn_href_link(FILENAME_LOGIN, '', 'NONSSL'));
  }

  if (!isset($_GET['order_id']) || (isset($_GET['order_id']) && !is_numeric($_GET['order_id']))) {
    smn_redirect(smn_href_link(FILENAME_ACCOUNT_HISTORY, '', 'NONSSL'));
  }
  
  $customer_info_query = smn_db_query("select o.customers_id from " . TABLE_ORDERS . " o, " . TABLE_ORDERS_STATUS . " s where o.orders_id = '". (int)$_GET['order_id'] . "' and o.orders_status = s.orders_status_id and s.language_id = '" . (int)$languages_id . "' and s.public_flag = '1'");
  $customer_info = smn_db_fetch_array($customer_info_query);
  if ($customer_info['customers_id'] != $customer_id) {
    smn_redirect(smn_href_link(FILENAME_ACCOUNT_HISTORY, '', 'NONSSL'));
  }



  $breadcrumb->add(NAVBAR_TITLE_1, smn_href_link(FILENAME_ACCOUNT, '', 'NONSSL'));
  $breadcrumb->add(NAVBAR_TITLE_2, smn_href_link(FILENAME_ACCOUNT_HISTORY, '', 'NONSSL'));
  $breadcrumb->add(sprintf(NAVBAR_TITLE_3, $_GET['order_id']), smn_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $_GET['order_id'], 'NONSSL'));

// get the order class and create a new object
  if ( file_exists(DIR_WS_CLASSES . $store_type . '_order.php') ) {
    require(DIR_WS_CLASSES . $store_type . '_order.php');
  }else{
    require(DIR_WS_CLASSES . 'order.php');
  }
  $order = new order($_GET['order_id']);

?>