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

  Copyright (c) 2001,2002 Ian C Wilson
*/

  require('includes/application_top.php');

  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

  if ($_GET['action']=='confirmrelease' && isset($_GET['gid'])) {
    $gv_query=smn_db_query("select release_flag from " . TABLE_COUPON_GV_QUEUE . " where store_id = '" . $store_id . "' and unique_id='" . $_GET['gid'] . "'");
    $gv_result=smn_db_fetch_array($gv_query);
    if ($gv_result['release_flag']=='N') { 
      $gv_query=smn_db_query("select customer_id, amount from " . TABLE_COUPON_GV_QUEUE ." where store_id = '" . $store_id . "' and unique_id='" . $_GET['gid'] . "'");
      if ($gv_resulta=smn_db_fetch_array($gv_query)) {
      $gv_amount = $gv_resulta['amount'];
      //Let's build a message object using the email class
      $mail_query = smn_db_query("select customers_firstname, customers_lastname, customers_email_address from " . TABLE_CUSTOMERS . " where customers_id = '" . $gv_resulta['customer_id'] . "'");
      $mail = smn_db_fetch_array($mail_query);
      $message = TEXT_REDEEM_COUPON_MESSAGE_HEADER;
      $message .= sprintf(TEXT_REDEEM_COUPON_MESSAGE_AMOUNT, $currencies->format($gv_amount));
      $message .= TEXT_REDEEM_COUPON_MESSAGE_BODY;
      $message .= TEXT_REDEEM_COUPON_MESSAGE_FOOTER;
      $mimemessage = new email(array('X-Mailer: oscMall bulk mailer'));
      // add the message to the object
      $mimemessage->add_text($message);
      $mimemessage->build_message();
    
      $mimemessage->send($mail['customers_firstname'] . ' ' . $mail['customers_lastname'], $mail['customers_email_address'], '', EMAIL_FROM, TEXT_REDEEM_COUPON_SUBJECT );
      $gv_amount=$gv_resulta['amount'];
      $gv_query=smn_db_query("select amount from " . TABLE_COUPON_GV_CUSTOMER . " where store_id = '" . $store_id . "' and customer_id='" . $gv_resulta['customer_id'] . "'");
      $customer_gv=false;
      $total_gv_amount=0;
      if ($gv_result=smn_db_fetch_array($gv_query)) {
        $total_gv_amount=$gv_result['amount'];
        $customer_gv=true;
      }    
      $total_gv_amount=$total_gv_amount+$gv_amount;
      if ($customer_gv) {
        $gv_update=smn_db_query("update " . TABLE_COUPON_GV_CUSTOMER . " set amount='".$total_gv_amount."' where store_id = '" . $store_id . "' and customer_id='".$gv_resulta['customer_id']."'");
      } else {
        $gv_insert=smn_db_query("insert into " .TABLE_COUPON_GV_CUSTOMER . " (store_id, customer_id, amount) values ('" . $store_id . "', '".$gv_resulta['customer_id']."','".$total_gv_amount."')");
      }
        $gv_update=smn_db_query("update " . TABLE_COUPON_GV_QUEUE . " set release_flag='Y' where store_id = '" . $store_id . "' and unique_id='".$_GET['gid']."'");
      }
    }
  }
  
  $content_page = basename($_SERVER['PHP_SELF']);
  
  require('templates/default/layout.php');

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>