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
  require(DIR_WS_CLASSES . 'mime.php');
  require(DIR_WS_CLASSES . 'email.php');

  // include the password crypto functions
    require(DIR_WS_FUNCTIONS . 'password_funcs.php');
    
  if (isset($_GET['action']) && ($_GET['action'] == 'process')) {
    $email_address = smn_db_prepare_input($_POST['email_address']);

    $check_customer_query = smn_db_query("select customers_firstname, customers_lastname, customers_password, customers_id from " . TABLE_CUSTOMERS . " where customers_email_address = '" . smn_db_input($email_address) . "'");
    if (smn_db_num_rows($check_customer_query)) {
      $check_customer = smn_db_fetch_array($check_customer_query);

      $new_password = smn_create_random_value(ENTRY_PASSWORD_MIN_LENGTH);
      $crypted_password = smn_encrypt_password($new_password);

      smn_db_query("update " . TABLE_CUSTOMERS . " set customers_password = '" . smn_db_input($crypted_password) . "' where customers_id = '" . (int)$check_customer['customers_id'] . "'");

      smn_mail($check_customer['customers_firstname'] . ' ' . $check_customer['customers_lastname'], $email_address, EMAIL_PASSWORD_REMINDER_SUBJECT, sprintf(EMAIL_PASSWORD_REMINDER_BODY, $new_password), $store->get_store_owner(), $store->get_store_owner_email_address());

      $messageStack->add_session('login', SUCCESS_PASSWORD_SENT, 'success');

      smn_redirect(smn_href_link(FILENAME_LOGIN, '', 'NONSSL'));
    } else {
      $messageStack->add('password_forgotten', TEXT_NO_EMAIL_ADDRESS_FOUND);
    }
  }

  $breadcrumb->add(NAVBAR_TITLE_1, smn_href_link(FILENAME_LOGIN, '', 'NONSSL'));
  $breadcrumb->add(NAVBAR_TITLE_2, smn_href_link(FILENAME_PASSWORD_FORGOTTEN, '', 'NONSSL'));
 
?>