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
  
  Gift Voucher System v1.0
  Copyright (c) 2001, 2002 Ian C Wilson
  http://www.phesis.org

*/

   global $page_name;

// if the customer is not logged on, redirect them to the login page
if (!smn_session_is_registered('customer_id')) {
$navigation->set_snapshot();
smn_redirect(smn_href_link(FILENAME_LOGIN, '', 'NONSSL'));
}



// check for a voucher number in the url
  if (isset($_GET['gv_no'])) {
    $error = true;
 $voucher_number=smn_db_prepare_input($_GET['gv_no']);
    $gv_query = smn_db_query("select c.coupon_id, c.coupon_amount from " . TABLE_COUPONS . " c, " . TABLE_COUPON_EMAIL_TRACK . " et where coupon_code = '" . addslashes($voucher_number) . "' and c.coupon_id = et.coupon_id");
    if (smn_db_num_rows($gv_query) >0) {
      $coupon = smn_db_fetch_array($gv_query);
      $redeem_query = smn_db_query("select coupon_id from ". TABLE_COUPON_REDEEM_TRACK . " where coupon_id = '" . $coupon['coupon_id'] . "'");
      if (smn_db_num_rows($redeem_query) == 0 ) {
// check for required session variables
        if (!smn_session_is_registered('gv_id')) {
          smn_session_register('gv_id');
        }
        $gv_id = $coupon['coupon_id'];
        $error = false;
      } else {
        $error = true;
      }
    }
  } else {
    smn_redirect(FILENAME_DEFAULT);
  }
  if ((!$error) && (smn_session_is_registered('customer_id'))) {
// Update redeem status
    $gv_query = smn_db_query("insert into  " . TABLE_COUPON_REDEEM_TRACK . " (coupon_id, customer_id, redeem_date, redeem_ip) values ('" . $coupon['coupon_id'] . "', '" . $customer_id . "', now(),'" . $REMOTE_ADDR . "')");
    $gv_update = smn_db_query("update " . TABLE_COUPONS . " set coupon_active = 'N' where coupon_id = '" . $coupon['coupon_id'] . "'");
    smn_gv_account_update($customer_id, $gv_id);
    smn_session_unregister('gv_id');   
  } 

      if ((smn_session_is_registered('customer_id')) && $voucher_not_redeemed) {
        $gv_id = $coupon['coupon_id'];
        $gv_query = smn_db_query("insert into  " . TABLE_COUPON_REDEEM_TRACK . " (coupon_id, customer_id, redeem_date, redeem_ip) values ('" . $coupon['coupon_id'] . "', '" . $customer_id . "', now(),'" . $REMOTE_ADDR . "')");
        $gv_update = smn_db_query("update " . TABLE_COUPONS . " set coupon_active = 'N' where coupon_id = '" . $coupon['coupon_id'] . "'");
        smn_gv_account_update($customer_id, $gv_id);
        $error = false;
      } elseif($voucher_not_redeemed) {
        if (!smn_session_is_registered('floating_gv_code')) {
            smn_session_register('floating_gv_code');
          //}
          $floating_gv_code = $_GET['gv_no'];
          $gv_error_message = TEXT_NEEDS_TO_LOGIN;
      } else {
        $gv_error_message = TEXT_INVALID_GV;
     }
    } else {
      $gv_error_message = TEXT_INVALID_GV;
    }
  $message = $gv_error_message;
        if (smn_session_is_registered('floating_gv_code')) {
          $gv_query = smn_db_query("SELECT c.coupon_id, c.coupon_amount, IF(rt.coupon_id>0, 'true', 'false') AS redeemed FROM ". TABLE_COUPONS ." c LEFT JOIN ". TABLE_COUPON_REDEEM_TRACK." rt USING(coupon_id), ". TABLE_COUPON_EMAIL_TRACK ." et WHERE c.coupon_code = '". $floating_gv_code ."' AND c.coupon_id = et.coupon_id");
          // check if coupon exist
          if (smn_db_num_rows($gv_query) >0) {
            $coupon = smn_db_fetch_array($gv_query);
            // check if coupon_id exist and coupon not redeemed
            if($coupon['coupon_id']>0 && $coupon['redeemed'] == 'false') {
              smn_session_unregister('floating_gv_code');
              $gv_query = smn_db_query("insert into  " . TABLE_COUPON_REDEEM_TRACK . " (coupon_id, customer_id, redeem_date, redeem_ip) values ('" . $coupon['coupon_id'] . "', '" . $customer_id . "', now(),'" . $REMOTE_ADDR . "')");
              $gv_update = smn_db_query("update " . TABLE_COUPONS . " set coupon_active = 'N' where coupon_id = '" . $coupon['coupon_id'] . "'");
              smn_gv_account_update($customer_id, $coupon['coupon_id']);
            }
          }
        }
//**********

/*******************************************************
****  create_account.php  ***********************************
*******************************************************/

      if (smn_session_is_registered('floating_gv_code')) {
        $gv_query = smn_db_query("SELECT c.coupon_id, c.coupon_amount, IF(rt.coupon_id>0, 'true', 'false') AS redeemed FROM ". TABLE_COUPONS ." c LEFT JOIN ". TABLE_COUPON_REDEEM_TRACK." rt USING(coupon_id), ". TABLE_COUPON_EMAIL_TRACK ." et WHERE c.coupon_code = '". $floating_gv_code ."' AND c.coupon_id = et.coupon_id");
        // check if coupon exist
        if (smn_db_num_rows($gv_query) >0) {
          $coupon = smn_db_fetch_array($gv_query);
          // check if coupon_id exist and coupon not redeemed
          if($coupon['coupon_id']>0 && $coupon['redeemed'] == 'false') {
              smn_session_unregister('floating_gv_code');
              $gv_query = smn_db_query("insert into  " . TABLE_COUPON_REDEEM_TRACK . " (coupon_id, customer_id, redeem_date, redeem_ip) values ('" . $coupon['coupon_id'] . "', '" . $customer_id . "', now(),'" . $REMOTE_ADDR . "')");
              $gv_update = smn_db_query("update " . TABLE_COUPONS . " set coupon_active = 'N' where coupon_id = '" . $coupon['coupon_id'] . "'");
              smn_gv_account_update($customer_id, $coupon['coupon_id']);
          }
        }
      }


  $breadcrumb->add(NAVBAR_TITLE); 
?>