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
// include the mail classes
  require(DIR_WS_CLASSES . 'mime.php');
  require(DIR_WS_CLASSES . 'email.php');
// include validation functions (right now only email address)
  require(DIR_WS_FUNCTIONS . 'validations.php');
  
  $error = false;
  if (isset($_GET['action']) && ($_GET['action'] == 'send')) {
    $customer_name = smn_db_prepare_input($_POST['customer_name']);
    $email_address = smn_db_prepare_input($_POST['email']);
    $enquiry = smn_db_prepare_input($_POST['enquiry']);
    $subject = smn_db_prepare_input($_POST['subject']);
    
    if (smn_validate_email($email_address)) {
      smn_mail($store->get_store_owner(), $store->get_store_owner_email_address(), $subject, $enquiry, $customer_name, $email_address);
      smn_redirect(smn_href_link(FILENAME_CONTACT_US, 'action=success'));
    } else {
      $error = true;

      $messageStack->add('contact', ENTRY_EMAIL_ADDRESS_CHECK_ERROR);
    }
  }

  $breadcrumb->add(NAVBAR_TITLE, smn_href_link(FILENAME_CONTACT_US));

?>