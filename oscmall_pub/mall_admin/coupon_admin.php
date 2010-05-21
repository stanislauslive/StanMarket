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

  require('includes/application_top.php');
  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

  if ($_GET['selected_box']) {
    $_GET['action']='';
    $_GET['old_action']='';
  }
  
  if (($_GET['action'] == 'send_email_to_user') && ($_POST['customers_email_address']) && (!$_POST['back_x'])) {
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
      break;
    }
    $coupon_query = smn_db_query("select coupon_code from " . TABLE_COUPONS . " where store_id = '" . $store_id . "' and coupon_id = '" . $_GET['cid'] . "'");
    $coupon_result = smn_db_fetch_array($coupon_query);
    $coupon_name_query = smn_db_query("select coupon_name from " . TABLE_COUPONS_DESCRIPTION . " where store_id = '" . $store_id . "' and coupon_id = '" . $_GET['cid'] . "' and language_id = '" . $languages_id . "'");
    $coupon_name = smn_db_fetch_array($coupon_name_query);

    $from = smn_db_prepare_input($_POST['from']);
    $subject = smn_db_prepare_input($_POST['subject']);
    while ($mail = smn_db_fetch_array($mail_query)) {
      $message = smn_db_prepare_input($_POST['message']);
      $message .= "\n\n" . TEXT_TO_REDEEM . "\n\n";
      $message .= TEXT_VOUCHER_IS . $coupon_result['coupon_code'] . "\n\n";
      $message .= TEXT_REMEMBER . "\n\n";
      $message .= TEXT_VISIT . "\n\n";
     
      //Let's build a message object using the email class
      $mimemessage = new email(array('X-Mailer: oscMall bulk mailer'));
      // add the message to the object
      $mimemessage->add_text($message);
      $mimemessage->build_message();    
      $mimemessage->send($mail['customers_firstname'] . ' ' . $mail['customers_lastname'], $mail['customers_email_address'], '', $from, $subject);
    }

    smn_redirect(smn_href_link(FILENAME_COUPON_ADMIN, 'mail_sent_to=' . urlencode($mail_sent_to)));
  }
 
  if ( ($_GET['action'] == 'preview_email') && (!$_POST['customers_email_address']) ) {
    $_GET['action'] = 'email';    
    $messageStack->add(ERROR_NO_CUSTOMER_SELECTED, 'error');
  }

  if ($_GET['mail_sent_to']) {
    $messageStack->add(sprintf(NOTICE_EMAIL_SENT_TO, $_GET['mail_sent_to']), 'notice');
  }

  $coupon_id = ((isset($_GET['cid'])) ? smn_db_prepare_input($_GET['cid']) : '');

  switch ($_GET['action']) {
    case 'setflag':
      if ( ($_GET['flag'] == 'N') || ($_GET['flag'] == 'Y') ) {
        if (isset($_GET['cid'])) {
          smn_set_coupon_status($coupon_id, $_GET['flag']);
        }
      }
      smn_redirect(smn_href_link(FILENAME_COUPON_ADMIN, '&cid=' . $_GET['cid']));
      break;
    case 'confirmdelete':
      $delete_query=smn_db_query("delete from " . TABLE_COUPONS . " where coupon_id='" . (int)$coupon_id . "'");
      break;
    case 'update':
      // get all HTTP_POST_VARS and validate
      $_POST['coupon_code'] = trim($_POST['coupon_code']);
        $languages = smn_get_languages();
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
          $language_id = $languages[$i]['id'];
          if ($_POST['coupon_name'][$language_id]) $_POST['coupon_name'][$language_id] = trim($_POST['coupon_name'][$language_id]);
          if ($_POST['coupon_desc'][$language_id]) $_POST['coupon_desc'][$language_id] = trim($_POST['coupon_desc'][$language_id]);
        }
      $_POST['coupon_amount'] = trim($_POST['coupon_amount']);
      $update_errors = 0;
      if ((!smn_not_null($_POST['coupon_amount'])) && (!smn_not_null($_POST['coupon_free_ship']))) {
        $update_errors = 1;
        $messageStack->add(ERROR_NO_COUPON_AMOUNT, 'error');
      }
      $coupon_code = ((smn_not_null($_POST['coupon_code'])) ? $_POST['coupon_code'] : create_coupon_code());

      $query1 = smn_db_query("select coupon_code from " . TABLE_COUPONS . " where store_id = '" . $store_id . "' and coupon_code = '" . smn_db_prepare_input($coupon_code) . "'");    
      if (smn_db_num_rows($query1) && $_POST['coupon_code'] && $_GET['oldaction'] != 'voucheredit')  {
        $update_errors = 1;
        $messageStack->add(ERROR_COUPON_EXISTS, 'error');
      }
      if ($update_errors != 0) {
        $_GET['action'] = 'new';  
      } else {  
        $_GET['action'] = 'update_preview';
      }
      break;
    case 'update_confirm':
      if ( ($_POST['back_x']) || ($_POST['back_y']) ) {
        if ($_GET['oldaction'] == 'voucheredit') {
          $_GET['action'] = 'voucheredit';
        } else {
          $_GET['action'] = 'new';
        }
      } else {
        $coupon_type = "F";
        $coupon_amount = $_POST['coupon_amount'];
        if (substr($_POST['coupon_amount'], -1) == '%') $coupon_type='P';
        if ($_POST['coupon_free_ship']) {
          $coupon_type = 'S';
          $coupon_amount = 0;
        }
        $sql_data_array = array('coupon_active' => smn_db_prepare_input($_POST['coupon_status']),
                                'coupon_code' => smn_db_prepare_input($_POST['coupon_code']),
                                'store_id' => $store_id,
                                'coupon_amount' => smn_db_prepare_input($coupon_amount),
                                'coupon_type' => smn_db_prepare_input($coupon_type),
                                'uses_per_coupon' => smn_db_prepare_input($_POST['coupon_uses_coupon']),
                                'uses_per_user' => smn_db_prepare_input($_POST['coupon_uses_user']),
                                'coupon_minimum_order' => smn_db_prepare_input($_POST['coupon_min_order']),
                                'restrict_to_products' => smn_db_prepare_input($_POST['coupon_products']),
                                'restrict_to_categories' => smn_db_prepare_input($_POST['coupon_categories']),
                                'coupon_start_date' => $_POST['coupon_startdate'],
                                'coupon_expire_date' => $_POST['coupon_finishdate'],
                                'date_created' => (($_POST['date_created'] != '0') ? $_POST['date_created'] : 'now()'),
                                'date_modified' => 'now()');
        $languages = smn_get_languages();
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
          $language_id = $languages[$i]['id'];
          $sql_data_marray[$i] = array('coupon_name' => smn_db_prepare_input($_POST['coupon_name'][$language_id]),
                                 'coupon_description' => smn_db_prepare_input($_POST['coupon_desc'][$language_id])
                                 );
        }

        if ($_GET['oldaction']=='voucheredit') {
          smn_db_perform(TABLE_COUPONS, $sql_data_array, 'update', "store_id = '" . $store_id . "' and coupon_id='" . (int)$coupon_id . "'"); 
          for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
          $language_id = $languages[$i]['id'];
            $update = smn_db_query("update " . TABLE_COUPONS_DESCRIPTION . " set coupon_name = '" . smn_db_prepare_input($_POST['coupon_name'][$language_id]) . "', coupon_description = '" . smn_db_prepare_input($_POST['coupon_desc'][$language_id]) . "' where coupon_id = '" . (int)$coupon_id . "' and store_id = '" . $store_id . "' and language_id = '" . $language_id . "'");
           
          }
        } else {   
          $query = smn_db_perform(TABLE_COUPONS, $sql_data_array);
          $insert_id = smn_db_insert_id($query);
          
          for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
            $language_id = $languages[$i]['id'];
            $sql_data_marray[$i]['coupon_id'] = $insert_id;
            $sql_data_marray[$i]['language_id'] = $language_id;
            $sql_data_marray[$i]['store_id'] = $store_id;
            smn_db_perform(TABLE_COUPONS_DESCRIPTION, $sql_data_marray[$i]);            
          }
      }
    }
  }
  
  $content_page = basename($_SERVER['PHP_SELF']);
  
  require('templates/default/layout.php');

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>