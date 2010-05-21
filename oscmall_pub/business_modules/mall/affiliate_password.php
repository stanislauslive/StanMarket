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

   global $page_name, $error;  
// include the password crypto functions
  require(DIR_WS_FUNCTIONS . 'password_funcs.php');
  
  if (!smn_session_is_registered('affiliate_id')) {
    $navigation->set_snapshot();
    smn_redirect(smn_href_link(FILENAME_AFFILIATE, '', 'NONSSL'));
  }

  if (isset($_POST['action']) && ($_POST['action'] == 'process')) {
    $password_current = smn_db_prepare_input($_POST['password_current']);
    $password_new = smn_db_prepare_input($_POST['password_new']);
    $password_confirmation = smn_db_prepare_input($_POST['password_confirmation']);

    $error = false;

    if (strlen($password_current) < ENTRY_PASSWORD_MIN_LENGTH) {
      $error = true;

      $messageStack->add('a_password', ENTRY_PASSWORD_CURRENT_ERROR);
    } elseif (strlen($password_new) < ENTRY_PASSWORD_MIN_LENGTH) {
      $error = true;

      $messageStack->add('a_password', ENTRY_PASSWORD_NEW_ERROR);
    } elseif ($password_new != $password_confirmation) {
      $error = true;

      $messageStack->add('a_password', ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING);
    }

    if ($error == false) {
	/*Changed the query to take the password from customer table ,By Cimi*/
      /*$check_affiliate_query = smn_db_query("select affiliate_password from " . TABLE_AFFILIATE . " where affiliate_id = '" . (int)$affiliate_id . "'");*/
      $check_affiliate_query = smn_db_query("select customers_password from " . TABLE_CUSTOMERS . " where customers_id = '" . (int)$customer_id . "'");
      $check_affiliate = smn_db_fetch_array($check_affiliate_query);
	  
/*Changed the index of the array from affiliate_password to cumstomers_password, by Cimi*/

      if (smn_validate_password($password_current, $check_affiliate['customers_password'])) {
	  	/*Changed the query to take the password from customer table ,By Cimi*/
        /*smn_db_query("update " . TABLE_AFFILIATE . " set affiliate_password = '" . smn_encrypt_password($password_new) . "' where affiliate_id = '" . (int)$affiliate_id . "'");*/
        smn_db_query("update " . TABLE_CUSTOMERS . " set customers_password = '" . smn_encrypt_password($password_new) . "' where customers_id = '" . (int)$customer_id . "'");

        $messageStack->add_session('account', SUCCESS_PASSWORD_UPDATED, 'success');

        smn_redirect(smn_href_link(FILENAME_AFFILIATE_SUMMARY, '', 'NONSSL'));
      } else {
        $error = true;

        $messageStack->add('a_password', ERROR_CURRENT_PASSWORD_NOT_MATCHING);
      }
    }
  }

  $breadcrumb->add(NAVBAR_TITLE_1, smn_href_link(FILENAME_AFFILIATE, '', 'NONSSL'));
  $breadcrumb->add(NAVBAR_TITLE_2, smn_href_link(FILENAME_AFFILIATE_PASSWORD, '', 'NONSSL'));
?> 