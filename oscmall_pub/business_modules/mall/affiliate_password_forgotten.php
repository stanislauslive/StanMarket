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
// include the mail classes
  require(DIR_WS_CLASSES . 'mime.php');
  require(DIR_WS_CLASSES . 'email.php');

  if (isset($_GET['action']) && ($_GET['action'] == 'process')) {
    $check_affiliate_query = smn_db_query("select affiliate_firstname, affiliate_lastname, affiliate_password, affiliate_id from " . TABLE_AFFILIATE . " where affiliate_email_address = '" . $_POST['email_address'] . "'");
    if (smn_db_num_rows($check_affiliate_query)) {
      $check_affiliate = smn_db_fetch_array($check_affiliate_query);
      // Crypted password mods - create a new password, update the database and mail it to them
      $newpass = smn_create_random_value(ENTRY_PASSWORD_MIN_LENGTH);
      $crypted_password = smn_encrypt_password($newpass);
      smn_db_query("update " . TABLE_AFFILIATE . " set affiliate_password = '" . $crypted_password . "' where affiliate_id = '" . $check_affiliate['affiliate_id'] . "'");
      
      smn_mail($check_affiliate['affiliate_firstname'] . " " . $check_affiliate['affiliate_lastname'], $_POST['email_address'], EMAIL_PASSWORD_REMINDER_SUBJECT, nl2br(sprintf(EMAIL_PASSWORD_REMINDER_BODY, $newpass)), $store->get_store_owner(), AFFILIATE_EMAIL_ADDRESS);
      smn_redirect(smn_href_link(FILENAME_AFFILIATE, 'info_message=' . urlencode(TEXT_PASSWORD_SENT), 'NONSSL', true, false));
    } else {
      smn_redirect(smn_href_link(FILENAME_AFFILIATE_PASSWORD_FORGOTTEN, 'email=nonexistent', 'NONSSL'));
    }
  } else {

  $breadcrumb->add(NAVBAR_TITLE_1, smn_href_link(FILENAME_AFFILIATE, '', 'NONSSL'));
  $breadcrumb->add(NAVBAR_TITLE_2, smn_href_link(FILENAME_AFFILIATE_PASSWORD_FORGOTTEN, '', 'NONSSL'));
?> ?>