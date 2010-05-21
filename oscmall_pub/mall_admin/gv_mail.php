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

  if ( ($_GET['action'] == 'send_email_to_user') && ($_POST['customers_email_address'] || $_POST['email_to']) && (!$_POST['back_x']) ) {
    switch ($_POST['customers_email_address']) {
      case '***':
        $mail_query = smn_db_query("select customers_firstname, customers_lastname, customers_email_address from " . TABLE_CUSTOMERS);
        $mail_sent_to = TEXT_ALL_CUSTOMERS;
        break;
      case '**D':
        $mail_query = smn_db_query("select customers_firstname, customers_lastname, customers_email_address from " . TABLE_CUSTOMERS . " where customers_newsletter = '1'");
        $mail_sent_to = TEXT_NEWSLETTER_CUSTOMERS;
        break;
      default:
        $customers_email_address = smn_db_prepare_input($_POST['customers_email_address']);

        $mail_query = smn_db_query("select customers_firstname, customers_lastname, customers_email_address from " . TABLE_CUSTOMERS . " where customers_email_address = '" . smn_db_input($customers_email_address) . "'");
        $mail_sent_to = $_POST['customers_email_address'];
        if ($_POST['email_to']) {
          $mail_sent_to = $_POST['email_to'];
        }
        break;
    }

    $from = smn_db_prepare_input($_POST['from']);
    $subject = smn_db_prepare_input($_POST['subject']);
    while ($mail = smn_db_fetch_array($mail_query)) {
      $id1 = create_coupon_code($mail['customers_email_address']);
      $message = $_POST['message'];
      $message .= "\n\n" . TEXT_GV_WORTH  . $currencies->format($_POST['amount']) . "\n\n";
      $message .= TEXT_TO_REDEEM;
      $message .= TEXT_WHICH_IS . $id1 . TEXT_IN_CASE . "\n\n";
      if (SEARCH_ENGINE_FRIENDLY_URLS == 'true') {
        $message .= HTTP_SERVER  . DIR_WS_CATALOG . 'gv_redeem.php' . '/gv_no/'.$id1 . "\n\n";
      } else {
        $message .= HTTP_SERVER  . DIR_WS_CATALOG . 'gv_redeem.php' . '?gv_no='.$id1 . "\n\n";
      }
      $message .= TEXT_OR_VISIT . HTTP_SERVER  . DIR_WS_CATALOG . TEXT_ENTER_CODE;

      //Let's build a message object using the email class
      $mimemessage = new email(array('X-Mailer: oscMall bulk mailer'));
      // add the message to the object
      $mimemessage->add_text($message);
      $mimemessage->build_message();
    
      $mimemessage->send($mail['customers_firstname'] . ' ' . $mail['customers_lastname'], $mail['customers_email_address'], '', $from, $subject);
      // Now create the coupon main and email entry
      $insert_query = smn_db_query("insert into " . TABLE_COUPONS . " (store_id, coupon_code, coupon_type, coupon_amount, date_created) values ('" . $store_id . "', '" . $id1 . "', 'G', '" . $_POST['amount'] . "', now())");
      $insert_id = smn_db_insert_id($insert_query);
      $insert_query = smn_db_query("insert into " . TABLE_COUPON_EMAIL_TRACK . " (store_id, coupon_id, customer_id_sent, sent_firstname, emailed_to, date_sent) values ('" . $store_id . "', '" . $insert_id ."', '0', 'Admin', '" . $mail['customers_email_address'] . "', now() )"); 
    }
    if ($_POST['email_to']) {
      $id1 = create_coupon_code($_POST['email_to']);
      $message = smn_db_prepare_input($_POST['message']);
      $message .= "\n\n" . TEXT_GV_WORTH  . $currencies->format($_POST['amount']) . "\n\n";
      $message .= TEXT_TO_REDEEM;
      $message .= TEXT_WHICH_IS . $id1 . TEXT_IN_CASE . "\n\n";
      $message .= HTTP_SERVER  . DIR_WS_CATALOG . 'gv_redeem.php' . '?gv_no='.$id1 . "\n\n";
      $message .= TEXT_OR_VISIT . HTTP_SERVER  . DIR_WS_CATALOG  . TEXT_ENTER_CODE;
     
      //Let's build a message object using the email class
      $mimemessage = new email(array('X-Mailer: oscMall bulk mailer'));
      // add the message to the object
      $mimemessage->add_text($message);
      $mimemessage->build_message();
      $mimemessage->send('Friend', $_POST['email_to'], '', $from, $subject);
      // Now create the coupon email entry
      $insert_query = smn_db_query("insert into " . TABLE_COUPONS . " (store_id, coupon_code, coupon_type, coupon_amount, date_created) values ('" . $store_id . "', '" . $id1 . "', 'G', '" . $_POST['amount'] . "', now())");
      $insert_id = smn_db_insert_id($insert_query);
      $insert_query = smn_db_query("insert into " . TABLE_COUPON_EMAIL_TRACK . " (store_id, coupon_id, customer_id_sent, sent_firstname, emailed_to, date_sent) values ('" . $store_id . "', '" . $insert_id ."', '0', 'Admin', '" . $_POST['email_to'] . "', now() )"); 
    }
    smn_redirect(smn_href_link(FILENAME_GV_MAIL, 'mail_sent_to=' . urlencode($mail_sent_to)));
  }

  if ( ($_GET['action'] == 'preview') && (!$_POST['customers_email_address']) && (!$_POST['email_to']) ) {
    $messageStack->add(ERROR_NO_CUSTOMER_SELECTED, 'error');
  }

  if ( ($_GET['action'] == 'preview') && (!$_POST['amount']) ) {
    $messageStack->add(ERROR_NO_AMOUNT_SELECTED, 'error');
  }

  if ($_GET['mail_sent_to']) {
    $messageStack->add(sprintf(NOTICE_EMAIL_SENT_TO, $_GET['mail_sent_to']), 'notice');
  }
  
  $content_page = basename($_SERVER['PHP_SELF']);
  
  require('templates/default/layout.php');

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>