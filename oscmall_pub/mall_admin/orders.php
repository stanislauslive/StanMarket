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

  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

  $orders_statuses = array();
  $orders_status_array = array();
  $orders_status_query = smn_db_query("select orders_status_id, orders_status_name from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "'");
  while ($orders_status = smn_db_fetch_array($orders_status_query)) {
    $orders_statuses[] = array('id' => $orders_status['orders_status_id'],
                               'text' => $orders_status['orders_status_name']);
    $orders_status_array[$orders_status['orders_status_id']] = $orders_status['orders_status_name'];
  }

  $action = (isset($_GET['action']) ? $_GET['action'] : '');

  if (smn_not_null($action)) {
    switch ($action) {
      case 'update_order':
        $oID = smn_db_prepare_input($_GET['oID']);
        $status = smn_db_prepare_input($_POST['status']);
        $comments = smn_db_prepare_input($_POST['comments']);

        $order_updated = false;
        $check_status_query = smn_db_query("select * from " . TABLE_ORDERS . " where store_id = '". $store_id ."' and orders_id = '" . (int)$oID . "'");
        $check_status = smn_db_fetch_array($check_status_query);

        if ( ($check_status['orders_status'] != $status) || smn_not_null($comments) || ($status ==DOWNLOADS_ORDERS_STATUS_UPDATED_VALUE) ) {
          smn_db_query("update " . TABLE_ORDERS . " set orders_status = '" . smn_db_input($status) . "', last_modified = now() where orders_id = '" . (int)$oID . "'");
        if ( $check_status['orders_status'] == DOWNLOADS_ORDERS_STATUS_UPDATED_VALUE ) {
          smn_db_query("update " . TABLE_ORDERS_PRODUCTS_DOWNLOAD . " set download_maxdays = '" . smn_get_configuration_key_value('DOWNLOAD_MAX_DAYS') . "', download_count = '" . smn_get_configuration_key_value('DOWNLOAD_MAX_COUNT') . "' where store_id = '". $store_id ."' and orders_id = '" . (int)$oID . "' ");
        }
          $customer_notified = '0';
          if (isset($_POST['notify']) && ($_POST['notify'] == 'on')) {
            $notify_comments = '';
            if (isset($_POST['notify_comments']) && ($_POST['notify_comments'] == 'on')) {
              $notify_comments = sprintf(EMAIL_TEXT_COMMENTS_UPDATE, $comments) . "\n\n";
            }

            $email = STORE_NAME . "\n" . EMAIL_SEPARATOR . "\n" . EMAIL_TEXT_ORDER_NUMBER . ' ' . $oID . "\n" . EMAIL_TEXT_INVOICE_URL . ' ' . smn_catalog_href_link(FILENAME_CATALOG_ACCOUNT_HISTORY_INFO, 'order_id=' . $oID, 'NONSSL') . "\n" . EMAIL_TEXT_DATE_ORDERED . ' ' . smn_date_long($check_status['date_purchased']) . "\n\n" . $notify_comments . sprintf(EMAIL_TEXT_STATUS_UPDATE, $orders_status_array[$status]);

            smn_mail($check_status['customers_name'], $check_status['customers_email_address'], EMAIL_TEXT_SUBJECT, $email, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);

            $customer_notified = '1';
          }

          smn_db_query("insert into " . TABLE_ORDERS_STATUS_HISTORY . " (orders_id, orders_status_id, date_added, customer_notified, comments) values ('" . (int)$oID . "', '" . smn_db_input($status) . "', now(), '" . smn_db_input($customer_notified) . "', '" . smn_db_input($comments)  . "')");

          $order_updated = true;
        }

        if ($order_updated == true) {
         $messageStack->add_session(SUCCESS_ORDER_UPDATED, 'success');
        } else {
          $messageStack->add_session(WARNING_ORDER_NOT_UPDATED, 'warning');
        }

        smn_redirect(smn_href_link(FILENAME_ORDERS, smn_get_all_get_params(array('action')) . 'action=edit'));
        break;
      case 'deleteconfirm':
        $oID = smn_db_prepare_input($_GET['oID']);

        smn_remove_order($oID, $_POST['restock']);
       
        smn_redirect(smn_href_link(FILENAME_ORDERS, smn_get_all_get_params(array('oID', 'action'))));
        break;
    }
  }

  if (($action == 'edit') && isset($_GET['oID'])) {
    $oID = smn_db_prepare_input($_GET['oID']);

    $orders_query = smn_db_query("select orders_id from " . TABLE_ORDERS . " where orders_id = '" . (int)$oID . "'");
    $order_exists = true;
    if (!smn_db_num_rows($orders_query)) {
      $order_exists = false;
      $messageStack->add(sprintf(ERROR_ORDER_DOES_NOT_EXIST, $oID), 'error');
    }
  }

  include(DIR_WS_CLASSES . 'order.php');
  
  $content_page = basename($_SERVER['PHP_SELF']);
  
  require('templates/default/layout.php');

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>