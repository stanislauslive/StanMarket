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


// include the password crypto functions
  require(DIR_WS_FUNCTIONS . 'password_funcs.php');

  
  // redirect the customer to a friendly cookie-must-be-enabled page if cookies are disabled (or the session has not started)
  if ($session_started == false) {
    smn_redirect(smn_href_link(FILENAME_COOKIE_USAGE));
  }



  $error = false;
  if (isset($_GET['action']) && ($_GET['action'] == 'process')) {
    $email_address = smn_db_prepare_input($_POST['email_address']);
    $password = smn_db_prepare_input($_POST['password']);

// Check if email exists
    $check_customer_query = smn_db_query("select customers_id, customers_firstname, customers_password, customers_email_address, customers_default_address_id from " . TABLE_CUSTOMERS . " where customers_email_address = '" . smn_db_input($email_address) . "'");
    if (!smn_db_num_rows($check_customer_query)) {
      $error = true;
    } else {
      $check_customer = smn_db_fetch_array($check_customer_query);
// Check that password is good
      if (!smn_validate_password($password, $check_customer['customers_password'])) {
        $error = true;
      } else {
        if (SESSION_RECREATE == 'True') {
          smn_session_recreate();
        }

        $check_country_query = smn_db_query("select entry_country_id, entry_zone_id from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int)$check_customer['customers_id'] . "' and address_book_id = '" . (int)$check_customer['customers_default_address_id'] . "'");
        $check_country = smn_db_fetch_array($check_country_query);
        
        $check_customer_store_query = smn_db_query("select store_id from " . TABLE_ADMIN . " where customer_id = '" . smn_db_input($check_customer['customers_id']) . "'");
        if (smn_db_num_rows($check_customer_store_query)) {
          $check_customer_store = smn_db_fetch_array($check_customer_store_query);
          $customer_store_id = $check_customer_store['store_id'];
          smn_session_register('customer_store_id');
        }
        
        $customer_id = $check_customer['customers_id'];
        $customer_default_address_id = $check_customer['customers_default_address_id'];
        $customer_first_name = $check_customer['customers_firstname'];
        $customer_country_id = $check_country['entry_country_id'];
        $customer_zone_id = $check_country['entry_zone_id'];
        smn_session_register('customer_id');
        smn_session_register('customer_default_address_id');
        smn_session_register('customer_first_name');
        smn_session_register('customer_country_id');
        smn_session_register('customer_zone_id');
        
        smn_db_query("update " . TABLE_CUSTOMERS_INFO . " set customers_info_date_of_last_logon = now(), customers_info_number_of_logons = customers_info_number_of_logons+1 where customers_info_id = '" . (int)$customer_id . "'");

// restore cart contents
        $cart->restore_contents();

        if (smn_session_is_registered('customer_store_id')){
           smn_redirect(smn_href_link(FILENAME_ACCOUNT, 'ID=' . $customer_store_id));
        }
        
        if (sizeof($navigation->snapshot) > 0) {
          $origin_href = smn_href_link($navigation->snapshot['page'], smn_array_to_string($navigation->snapshot['get'], array(smn_session_name())), $navigation->snapshot['mode']);
          $navigation->clear_snapshot();
          smn_redirect($origin_href);
        } else {
          smn_redirect(smn_href_link(FILENAME_DEFAULT, 'ID=' . $store_id));
        }
      }
    }
  }

  if ($error == true) {
    $messageStack->add('login', TEXT_LOGIN_ERROR);
  }

  $breadcrumb->add(NAVBAR_TITLE, smn_href_link(FILENAME_LOGIN, '', 'NONSSL'));
?>