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
   
  if (isset($_GET['action']) && $_GET['action'] == 'getZones'){
      $Qzones = smn_db_query('select zone_name from ' . TABLE_ZONES . ' where zone_country_id = "' . smn_db_input($_GET['country_id']) . '"');
      if (smn_db_num_rows($Qzones)){
          $zones_array = array();
          while ($zones = smn_db_fetch_array($Qzones)) {
            $zones_array[] = array('id' => $zones['zone_name'], 'text' => $zones['zone_name']);
          }
          echo smn_draw_pull_down_menu('state', $zones_array);
      }else{
          echo smn_draw_input_field('state');
      }
      echo (smn_not_null(ENTRY_STATE_TEXT) ? '&nbsp;<span class="inputRequirement">' . ENTRY_STATE_TEXT . '</span>': '');
      exit;
  }
 
  if ($_POST['conditions'] != 1 ){
    smn_redirect(smn_href_link(FILENAME_CREATE_STORE, '', 'NONSSL'));
  }

  if (!isset($_POST['store_type'])){
    smn_redirect(smn_href_link(FILENAME_CREATE_STORE, '', 'NONSSL'));
  }else{
    $new_store_type = (int)$_POST['store_type'];
  }

  if (isset($_POST['action']) && ($_POST['action'] == 'process')) {
    $error = false;
    
  // include validation functions (right now only email address)
    require(DIR_WS_FUNCTIONS . 'validations.php');
  // include the password crypto functions
    require(DIR_WS_FUNCTIONS . 'password_funcs.php');
  // file uploading class
    require(DIR_WS_CLASSES . 'upload.php');
    if (function_exists('ini_get') && ((bool)ini_get('file_uploads') == false) ) {
      $messageStack->add(WARNING_FILE_UPLOADS_DISABLED, 'warning');
    }
    require(DIR_WS_CLASSES . 'store.php');
    require(DIR_WS_CLASSES . 'customer.php');

    if (isset($_POST['gender'])) {
      $gender = $_POST['gender'];
    } else {
      $gender = false;
    }
    $new_store_name = addslashes($_POST['storename']);
    $customer_first_name = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $store_catagory = $_POST['store_catagory'];
    $store_description = addslashes($_POST['store_description']);
    $dob = $_POST['dob_day'] . '-' . $_POST['dob_month'] . '-' . $_POST['dob_year'];

    $email_address = $_POST['email_address'];
    $company = $_POST['company'];
    $street_address = $_POST['street_address'];
    $postal_code = $_POST['postcode'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    if (isset($_POST['zone_id'])) {
      $customer_zone_id = $_POST['zone_id'];
    } else {
      $customer_zone_id = 0;
    }
    $customer_country_id = $_POST['country'];
    $telephone = $_POST['telephone_area'] . '-' . $_POST['telephone_prefix'] . '-' . $_POST['telephone_post'];
    $fax = $_POST['fax_area'] . '-' . $_POST['fax_prefix'] . '-' . $_POST['fax_post'];
    if (isset($_POST['newsletter'])) {
      $newsletter = $_POST['newsletter'];
    } else {
      $newsletter = false;
    }
    $password = $_POST['password'];
    $confirmation = $_POST['confirmation'];
    $store_query = smn_db_query("select store_name from " . TABLE_STORE_DESCRIPTION . " WHERE store_name like '". $new_store_name ."'");
    if (smn_db_num_rows($store_query)) {
      $error = true;
      $messageStack->add('create_store_account', ENTRY_STORE_NAME_ERROR);
    }

    if (strlen($customer_first_name) < ENTRY_FIRST_NAME_MIN_LENGTH) {
      $error = true;
      $messageStack->add('create_store_account', ENTRY_FIRST_NAME_ERROR);
    }

    if (strlen($lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
      $error = true;
      $messageStack->add('create_store_account', ENTRY_LAST_NAME_ERROR);
    }

    if (strlen($email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
      $error = true;
      $messageStack->add('create_store_account', ENTRY_EMAIL_ADDRESS_ERROR);
    } elseif (smn_validate_email($email_address) == false) {
      $error = true;
      $messageStack->add('create_store_account', ENTRY_EMAIL_ADDRESS_CHECK_ERROR);
    } else {
      $check_email_query = smn_db_query("select count(*) as total from " . TABLE_ADMIN . " where admin_email_address = '" . smn_db_input($email_address) . "'");
      $check_email = smn_db_fetch_array($check_email_query);
      if ($check_email['total'] > 0) {
        $error = true;
        $messageStack->add('create_store_account', ENTRY_EMAIL_ADDRESS_ERROR_EXISTS);
      }
    }

    if (strlen($street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
      $error = true;
      $messageStack->add('create_store_account', ENTRY_STREET_ADDRESS_ERROR);
    }

    if (strlen($postcode) < ENTRY_POSTCODE_MIN_LENGTH) {
      $error = true;
      $messageStack->add('create_store_account', ENTRY_POST_CODE_ERROR);
    }

    if (strlen($city) < ENTRY_CITY_MIN_LENGTH) {
      $error = true;
      $messageStack->add('create_store_account', ENTRY_CITY_ERROR);
    }

    if (is_numeric($customer_country_id) == false) {
      $error = true;
      $messageStack->add('create_store_account', ENTRY_COUNTRY_ERROR);
    }
    $customer_zone_id = 0;
    $check_query = smn_db_query("select count(*) as total from " . TABLE_ZONES . " where zone_country_id = '" . (int)$customer_country_id . "'");
    $check = smn_db_fetch_array($check_query);
    $entry_state_has_zones = ($check['total'] > 0);
    if ($entry_state_has_zones == true) {
      $zone_query = smn_db_query("select distinct zone_id from " . TABLE_ZONES . " where zone_country_id = '" . (int)$customer_country_id . "' and (zone_name = '" . smn_db_input($state) . "' or zone_code = '" . smn_db_input($state) . "')");
      if (smn_db_num_rows($zone_query) == 1) {
        $zone = smn_db_fetch_array($zone_query);
        $customer_zone_id = $zone['zone_id'];
      } else {
        $error = true;
        $entry_state_error = true;
        $messageStack->add('create_store_account', ENTRY_STATE_ERROR_SELECT);
      }
    } else {
      if (strlen($state) < ENTRY_STATE_MIN_LENGTH) {
        $error = true;
        $messageStack->add('create_store_account', ENTRY_STATE_ERROR);
      }
    }

    if (strlen($password) < ENTRY_PASSWORD_MIN_LENGTH) {
      $error = true;
      $messageStack->add('create_store_account', ENTRY_PASSWORD_ERROR);
    } elseif ($password != $confirmation) {
      $error = true;
      $messageStack->add('create_store_account', ENTRY_PASSWORD_ERROR_NOT_MATCHING);
    }
    
    if ($error == false) {
	  if (!smn_session_is_registered('customer_id')) {
		  //ADD THE STORE OWNER DATA ....
		  $new_customer = new customer();
		  $new_customer->set_firstname($customer_first_name);
		  $new_customer->set_lastname($lastname);
		  $new_customer->set_email_address($email_address);
		  $new_customer->set_telephone($telephone);
		  $new_customer->set_fax($fax);
		  $new_customer->set_newsletter($newsletter);
		  $new_customer->set_password($password);
		  $new_customer->set_gender($gender);
		  $new_customer->set_dob($dob);
		  $new_customer->set_street_address($street_address);
		  $new_customer->set_postcode($postcode);
		  $new_customer->set_city($city);
		  $new_customer->set_country_id($customer_country_id);
                  $new_customer->set_company($company);
		  $new_customer->set_zone_id($customer_zone_id);
		  $new_customer->set_state($state);
		  $customer_id = $new_customer->create();
                  $customer_default_address_id = $new_customer->get_default_address();
                  
		  smn_session_register('customer_id');
		  smn_session_register('customer_first_name');
		  smn_session_register('customer_default_address_id');
		  smn_session_register('customer_country_id');
		  smn_session_register('customer_zone_id');
	  }

//CREATE STORE IN THE DATABASE.....

// systemsmanager begin - Dec 5, 2005
		$new_store = new store();
		$new_store->set_store_type($new_store_type);
		$new_store->set_customers_id($customer_id);
		$new_store->set_store_name($new_store_name);
		$new_store->set_store_description($store_description);
		$new_store->set_store_category($store_catagory);
		$new_store->set_store_logo('store_image');
		$customer_store_id = $new_store->create_store();
                smn_session_register('customer_store_id');
		$error_text = $new_store->put_logo_image();
		if ($error_text != '') {
                  smn_session_register('error_text');
		}
		$new_store->put_store_description();
		$new_store->put_store_category();
		$new_store->put_store_admin();
                $new_store->put_store_data();
                $new_store->put_store_cost();
                $new_store->put_store_products();                  
		if (ALLOW_STORE_SITE_TEXT == 'true')$new_store->put_store_language('english');
		$new_store->send_store_email($gender);
        smn_redirect(smn_href_link(FILENAME_CREATE_STORE_ACCOUNT_SUCCESS, '', 'NONSSL'));

    }
  }
  $breadcrumb->add(NAVBAR_TITLE, smn_href_link(FILENAME_CREATE_STORE_ACCOUNT, '', 'NONSSL'));
  
      $today = getdate();
      for ($i=1; $i<= 31; $i++){
      $day_drop_down_array[] = array('id' =>  sprintf('%02d', $i), 'text' => $i);
    }
      for ($i=1; $i<= 12; $i++){
      $month_drop_down_array[] = array('id' => sprintf('%02d', $i), 'text' => strftime('%B',mktime(0,0,0,$i,1,$today['year'])));
    }
      for ($i=1935; $i<= (int)$today['year']; $i++){
      $year_drop_down_array[] = array('id' => $i, 'text' => $i);
    }
  
?>