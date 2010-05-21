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


// if the customer is not logged on, redirect them to the shopping cart page
  if (!smn_session_is_registered('customer_id')) {
    smn_redirect(smn_href_link(FILENAME_SHOPPING_CART));
  }

  if (isset($_GET['action']) && ($_GET['action'] == 'update')) {
    $notify_string = ''; 
  
     if (isset($HTTP_POST_VARS['notify']) && !empty($HTTP_POST_VARS['notify'])) { 
       $notify = $HTTP_POST_VARS['notify']; 
  
       if (!is_array($notify)) { 
         $notify = array($notify); 
       } 
  
       for ($i=0, $n=sizeof($notify); $i<$n; $i++) { 
         if (is_numeric($notify[$i])) { 
           $notify_string .= 'notify[]=' . $notify[$i] . '&'; 
         } 
       } 
  
       if (!empty($notify_string)) { 
         $notify_string = 'action=notify&' . substr($notify_string, 0, -1); 
       } 

    smn_redirect(smn_href_link(FILENAME_DEFAULT, $notify_string));
  }


    $NAVBAR_TITLE_2 = NAVBAR_TITLE_2; 
    $HEADING_TITLE = HEADING_TITLE; 
    $TEXT_SUCCESS = TEXT_SUCCESS; 

  $breadcrumb->add($NAVBAR_TITLE_1);
  $breadcrumb->add($NAVBAR_TITLE_2);

  $global_query = smn_db_query("select global_product_notifications from " . TABLE_CUSTOMERS_INFO . " where customers_info_id = '" . (int)$customer_id . "'");
  $global = smn_db_fetch_array($global_query);

  if ($global['global_product_notifications'] != '1') {
    $orders_query = smn_db_query("select orders_id from " . TABLE_ORDERS . " where customers_id = '" . (int)$customer_id . "' order by date_purchased desc limit 1");
    $orders = smn_db_fetch_array($orders_query);

    $products_array = array();
    $products_query = smn_db_query("select products_id, products_name from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . (int)$orders['orders_id'] . "' order by products_name");
    while ($products = smn_db_fetch_array($products_query)) {
      $products_array[] = array('id' => $products['products_id'],
                                'text' => $products['products_name']);
    }
  }
?>