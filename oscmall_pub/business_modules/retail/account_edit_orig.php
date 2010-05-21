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


ob_start();

  global $page_name, $store;

  if (!smn_session_is_registered('customer_id')) {
    $navigation->set_snapshot();
    smn_redirect(smn_href_link(FILENAME_LOGIN, '', 'NONSSL'));
  }
  
  include('editor.php');
  require(DIR_WS_CLASSES . 'customer.php');
  $profile_edit = new customer($store_id);
  if ($store->is_store_owner($customer_id)){
    require(DIR_WS_CLASSES . 'store.php');
    $store_edit = new store($store_id);
  }
  if (isset($_POST['action']) && ($_POST['action'] == 'process')) {
    $error = false;
    // include validation functions (right now only email address)
    require(DIR_WS_FUNCTIONS . 'validations.php');

    if (isset($_POST['state'])) {
      $zone_id = smn_db_prepare_input($_POST['state']);

    } else {
      $zone_id = false;
      
    }
    
    if (strlen($_POST['firstname']) < ENTRY_FIRST_NAME_MIN_LENGTH) {

      $error = true;

      $messageStack->add('account_edit', ENTRY_FIRST_NAME_ERROR);
    }

    if (strlen($_POST['lastname']) < ENTRY_LAST_NAME_MIN_LENGTH) {
      $error = true;
      $messageStack->add('account_edit', ENTRY_LAST_NAME_ERROR);
    }
    if (strlen($_POST['email_address']) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
      $error = true;
      $messageStack->add('account_edit', ENTRY_EMAIL_ADDRESS_ERROR);
    }
    if (strlen($_POST['city']) < ENTRY_CITY_MIN_LENGTH) {
      $error = true;
      $messageStack->add('account_edit', ENTRY_CITY_ERROR);
    }

    if (!smn_validate_email($_POST['email_address'])) {
      $error = true;
      $messageStack->add('account_edit', ENTRY_EMAIL_ADDRESS_CHECK_ERROR);
    }


    $check_email_query = smn_db_query("select count(*) as total from " . TABLE_CUSTOMERS . " where customers_email_address = '" . smn_db_input($_POST['email_address']) . "' and customers_id != '" . (int)$customer_id . "'");
    $check_email = smn_db_fetch_array($check_email_query);
    if ($check_email['total'] > 0) {
      $error = true;
      $messageStack->add('account_edit', ENTRY_EMAIL_ADDRESS_ERROR_EXISTS);
    }

    if (strlen($_POST['telephone']) < ENTRY_TELEPHONE_MIN_LENGTH) {
      $error = true;
      $messageStack->add('account_edit', ENTRY_TELEPHONE_NUMBER_ERROR);
    }
    if ($error == false) {
      $profile_edit->set_firstname($_POST['firstname']);
      $profile_edit->set_lastname($_POST['lastname']);
      $profile_edit->set_email_address($_POST['email_address']);
      $profile_edit->set_telephone($_POST['telephone']);
      $profile_edit->set_fax($_POST['fax']);
      $profile_edit->set_newsletter($newsletter);
      $profile_edit->set_gender($_POST['customers_gender']);
      $profile_edit->set_dob($_POST['customers_dob']);
      $profile_edit->set_street_address($_POST['street_address']);
      $profile_edit->set_postcode($_POST['postcode']);
      $profile_edit->set_city($_POST['city']);
      $profile_edit->set_country_id($_POST['country']);
      $profile_edit->set_company($_POST['company']);

      if ($zone_id > 0) {
      	$L_state = smn_get_zone_name($_POST['country'], $zone_id, '');
        $profile_edit->set_zone_id($zone_id);
        $profile_edit->set_state($L_state);
        
      } else {
        $profile_edit->set_zone_id('0');
        $profile_edit->set_state($_POST['state']);      
        
      }
      
    $customer_id = $profile_edit->create($customer_id); 
    if ($store->is_store_owner($customer_id)){
        // file uploading class
        require(DIR_WS_CLASSES . 'upload.php');
        if (function_exists('ini_get') && ((bool)ini_get('file_uploads') == false) ) {
          $messageStack->add(WARNING_FILE_UPLOADS_DISABLED, 'warning');
        }        
        $store_query = smn_db_query("select store_name from " . TABLE_STORE_DESCRIPTION . " WHERE store_name like '". $_POST['store_edit_name'] ."'");
        if (smn_db_num_rows($store_query)) {
            $error = true;
            $messageStack->add('account_edit', ENTRY_STORE_NAME_ERROR);
        }else{
            $store_edit->set_store_name($_POST['store_edit_name']);
        }
		$store_edit->set_store_description($_POST['store_description']);
        $store_edit->update_store_info();
        $store_edit->set_store_logo('store_image');
        $error_text = $store_edit->put_logo_image('update');
        if ($error_text != '') {
          smn_session_register('error_text');
        }
    }
      $customer_first_name = $firstname;
      $messageStack->add_session('account_edit', SUCCESS_ACCOUNT_UPDATED, 'success');
      smn_redirect(smn_href_link(FILENAME_ACCOUNT_EDIT, 'ID='.$store_id, 'NONSSL'));
    }
  }

  $account_query = smn_db_query("select c.*, ab.* from " . TABLE_CUSTOMERS . " c,  " . TABLE_ADDRESS_BOOK . " ab  where ab.customers_id = '" . (int)$customer_id . "' and c.customers_id = '" . (int)$customer_id . "' and ab.address_book_id = c.customers_default_address_id");
  $account = smn_db_fetch_array($account_query);
  $breadcrumb->add(NAVBAR_TITLE_1, smn_href_link(FILENAME_ACCOUNT, 'ID='.$store_id, 'NONSSL'));
  $breadcrumb->add(NAVBAR_TITLE_2, smn_href_link(FILENAME_ACCOUNT_EDIT, 'ID='.$store_id, 'NONSSL')); 
?>