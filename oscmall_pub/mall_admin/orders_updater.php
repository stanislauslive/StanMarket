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

  $orders_statuses = array();
  $orders_status_array = array();
  $orders_status_query = smn_db_query("select orders_status_id, orders_status_name from " . TABLE_ORDERS_STATUS . " where language_id = '" . $languages_id . "'");
  while ($orders_status = smn_db_fetch_array($orders_status_query)) {
    $orders_statuses[] = array('id' => $orders_status['orders_status_id'],
                               'text' => $orders_status['orders_status_name']);
    $orders_status_array[$orders_status['orders_status_id']] = $orders_status['orders_status_name'];
  }

  switch ($HTTP_GET_VARS['action']) {
    case 'update_orders':
    $status = smn_db_prepare_input($HTTP_POST_VARS['new_status']);
    $comments = smn_db_prepare_input($HTTP_POST_VARS['comments']);
 echo $HTTP_POST_VARS['select_order'];
 echo 'test';
  for ($i=0, $n=sizeof($HTTP_POST_VARS['select_order']); $i<$n; $i++) {echo 'test';
    if ($HTTP_POST_VARS['select_order'][$i] == 1)
        {            
      $oID = smn_db_prepare_input($HTTP_POST_VARS['orders_selected[' . $i .']']);
      $order_updated = false;
      $check_status_query = smn_db_query("select customers_name, customers_email_address, orders_status, date_purchased from " . TABLE_ORDERS . " where orders_id = '" . smn_db_input($oID) . "'");
      $check_status = smn_db_fetch_array($check_status_query);

        $customer_notified = '0';
        if ($HTTP_POST_VARS['notify'] == 'on') {
          $notify_comments = '';
          if ($HTTP_POST_VARS['notify_comments'] == 'on' and $comments) {
            $notify_comments = sprintf(EMAIL_TEXT_COMMENTS_UPDATE, $comments) . "\n\n";
          }
          $email = STORE_NAME . "\n" . EMAIL_SEPARATOR . "\n" . EMAIL_TEXT_ORDER_NUMBER . ' ' . $oID . "\n" . EMAIL_TEXT_INVOICE_URL . ' ' . smn_catalog_href_link(FILENAME_CATALOG_ACCOUNT_HISTORY_INFO, 'order_id=' . $oID, 'NONSSL') . "\n" . EMAIL_TEXT_DATE_ORDERED . ' ' . smn_date_long($check_status['date_purchased']) . "\n\n" . $notify_comments . sprintf(EMAIL_TEXT_STATUS_UPDATE, $orders_status_array[$status]);
          smn_mail($check_status['customers_name'], $check_status['customers_email_address'], EMAIL_TEXT_SUBJECT, nl2br($email), STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
          $customer_notified = '1';
        }

        smn_db_query("insert into " . TABLE_ORDERS_STATUS_HISTORY . " (orders_id, orders_status_id, date_added, customer_notified, comments) values ('" . smn_db_input($oID) . "', '" . smn_db_input($status) . "', now(), '" . $customer_notified . "', '" . smn_db_input($comments)  . "')");

        $order_updated = true;
     
      if ($order_updated) {
       $messageStack->add_session(SUCCESS_ORDER_UPDATED, 'success');
      } else {
        $messageStack->add_session(WARNING_ORDER_NOT_UPDATED, 'warning');
      }
    }
  }
      //smn_redirect(smn_href_link(FILENAME_ORDERS_UPDATER));
      break;
  }
  
  $content_page = basename($_SERVER['PHP_SELF']);
  
  require('templates/default/layout.php');

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>