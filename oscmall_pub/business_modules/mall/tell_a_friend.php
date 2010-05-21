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
   
// include validation functions (right now only email address)
  require(DIR_WS_FUNCTIONS . 'validations.php');
// include the mail classes
  require(DIR_WS_CLASSES . 'mime.php');
  require(DIR_WS_CLASSES . 'email.php');

  if (!smn_session_is_registered('customer_id') && (ALLOW_GUEST_TO_TELL_A_FRIEND == 'false')) {
    $navigation->set_snapshot();
    smn_redirect(smn_href_link(FILENAME_LOGIN, '', 'NONSSL'));
  }

  $valid_product = false;
  if (isset($_GET['products_id'])) {
    $product_info_query = smn_db_query("select p.store_id, pd.products_name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = '" . (int)$_GET['products_id'] . "' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "'");
    if (smn_db_num_rows($product_info_query)) {
      $valid_product = true;
      $product_info = smn_db_fetch_array($product_info_query);
    }
  }

  if ($valid_product == false) {
    smn_redirect(smn_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $_GET['products_id']));
  }


  if (isset($_GET['action']) && ($_GET['action'] == 'process')) {
    $error = false;

    $to_email_address = smn_db_prepare_input($_POST['to_email_address']);
    $to_name = smn_db_prepare_input($_POST['to_name']);
    $from_email_address = smn_db_prepare_input($_POST['from_email_address']);
    $from_name = smn_db_prepare_input($_POST['from_name']);
    $message = smn_db_prepare_input($_POST['message']);

    if (empty($from_name)) {
      $error = true;

      $messageStack->add('friend', ERROR_FROM_NAME);
    }

    if (!smn_validate_email($from_email_address)) {
      $error = true;

      $messageStack->add('friend', ERROR_FROM_ADDRESS);
    }

    if (empty($to_name)) {
      $error = true;

      $messageStack->add('friend', ERROR_TO_NAME);
    }

    if (!smn_validate_email($to_email_address)) {
      $error = true;

      $messageStack->add('friend', ERROR_TO_ADDRESS);
    }

    if ($error == false) {
      $email_subject = sprintf(TEXT_EMAIL_SUBJECT, $from_name, $store->get_store_name());
      $email_body = sprintf(TEXT_EMAIL_INTRO, $to_name, $from_name, $product_info['products_name'], $store->get_store_name()) . "\n\n";

      if (smn_not_null($message)) {
        $email_body .= $message . "\n\n";
      }

      $email_body .= sprintf(TEXT_EMAIL_LINK, smn_href_link(FILENAME_PRODUCT_INFO, 'ID=' . $product_info['store_id'] . '&products_id=' . $_GET['products_id'])) . "\n\n" .
                     sprintf(TEXT_EMAIL_SIGNATURE, $store->get_store_name() . "\n" . HTTP_SERVER . DIR_WS_CATALOG . "\n");

      smn_mail($to_name, $to_email_address, $email_subject, $email_body, $from_name, $from_email_address);

      $messageStack->add_session('header', sprintf(TEXT_EMAIL_SUCCESSFUL_SENT, $product_info['products_name'], smn_output_string_protected($to_name)), 'success');

      smn_redirect(smn_href_link(FILENAME_PRODUCT_INFO, 'ID=' . $product_info['store_id'] . '&products_id=' . $_GET['products_id']));
    }
  } elseif (smn_session_is_registered('customer_id')) {
    $account_query = smn_db_query("select customers_firstname, customers_lastname, customers_email_address from " . TABLE_CUSTOMERS . " where customers_id = '" . (int)$customer_id . "'");
    $account = smn_db_fetch_array($account_query);

    $from_name = $account['customers_firstname'] . ' ' . $account['customers_lastname'];
    $from_email_address = $account['customers_email_address'];
  }

  $breadcrumb->add(NAVBAR_TITLE, smn_href_link(FILENAME_TELL_A_FRIEND, 'ID=' . $product_info['store_id'] . '&products_id=' . $_GET['products_id']));
?>