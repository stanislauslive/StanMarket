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
// include the password crypto functions
  require(DIR_WS_FUNCTIONS . 'password_funcs.php');
// include the mail classes
  require(DIR_WS_CLASSES . 'mime.php');
  require(DIR_WS_CLASSES . 'email.php');
  
  $process = false;
  if (isset($_POST['action']) && ($_POST['action'] == 'process')) {
    $process = true;

    if (ACCOUNT_GENDER == 'true') {
      if (isset($_POST['gender'])) {
        $gender = smn_db_prepare_input($_POST['gender']);
      } else {
        $gender = false;
      }
    }
    $firstname = smn_db_prepare_input($_POST['firstname']);
    $lastname = smn_db_prepare_input($_POST['lastname']);
    if (ACCOUNT_DOB == 'true') $dob = smn_db_prepare_input($_POST['dob']);
    $email_address = smn_db_prepare_input($_POST['email_address']);
    if (ACCOUNT_COMPANY == 'true') $company = smn_db_prepare_input($_POST['company']);
    $street_address = smn_db_prepare_input($_POST['street_address']);
    $postcode = smn_db_prepare_input($_POST['postcode']);
    $city = smn_db_prepare_input($_POST['city']);
    if (ACCOUNT_STATE == 'true') {
      $state = smn_db_prepare_input($_POST['state']);
      if (isset($_POST['zone_id'])) {
        $zone_id = smn_db_prepare_input($_POST['zone_id']);
      } else {
        $zone_id = false;
      }
    }
    $country = smn_db_prepare_input($_POST['country']);
    $telephone = smn_db_prepare_input($_POST['telephone']);
    $fax = smn_db_prepare_input($_POST['fax']);
    if (isset($_POST['newsletter'])) {
      $newsletter = smn_db_prepare_input($_POST['newsletter']);
    } else {
      $newsletter = false;
    }
    $password = smn_db_prepare_input($_POST['password']);
    $confirmation = smn_db_prepare_input($_POST['confirmation']);

    $error = false;

    if (ACCOUNT_GENDER == 'true') {
      if ( ($gender != 'm') && ($gender != 'f') ) {
        $error = true;

        $messageStack->add('create_account', ENTRY_GENDER_ERROR);
      }
    }

    if (strlen($firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
      $error = true;

      $messageStack->add('create_account', ENTRY_FIRST_NAME_ERROR);
    }

    if (strlen($lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
      $error = true;

      $messageStack->add('create_account', ENTRY_LAST_NAME_ERROR);
    }

    if (ACCOUNT_DOB == 'true') {
      //if (checkdate(substr(smn_date_raw($dob), 4, 2), substr(smn_date_raw($dob), 6, 2), substr(smn_date_raw($dob), 0, 4)) == false) {
      if (checkdate($dob_month, $dob_day, $dob_year) == false) {
        $error = true;

        $messageStack->add('create_account', ENTRY_DATE_OF_BIRTH_ERROR);
      }
    }

    if (strlen($email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
      $error = true;

      $messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_ERROR);
    } elseif (smn_validate_email($email_address) == false) {
      $error = true;

      $messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_CHECK_ERROR);
    } else {
      $check_email_query = smn_db_query("select count(*) as total from " . TABLE_CUSTOMERS . " where customers_email_address = '" . smn_db_input($email_address) . "'");
      $check_email = smn_db_fetch_array($check_email_query);
      if ($check_email['total'] > 0) {
        $error = true;

        $messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_ERROR_EXISTS);
      }
    }

    if (strlen($street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
      $error = true;

      $messageStack->add('create_account', ENTRY_STREET_ADDRESS_ERROR);
    }

    if (strlen($postcode) < ENTRY_POSTCODE_MIN_LENGTH) {
      $error = true;

      $messageStack->add('create_account', ENTRY_POST_CODE_ERROR);
    }

    if (strlen($city) < ENTRY_CITY_MIN_LENGTH) {
      $error = true;

      $messageStack->add('create_account', ENTRY_CITY_ERROR);
    }

    if (is_numeric($country) == false) {
      $error = true;

      $messageStack->add('create_account', ENTRY_COUNTRY_ERROR);
    }

    if (ACCOUNT_STATE == 'true') {
      $zone_id = 0;
      $check_query = smn_db_query("select count(*) as total from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country . "'");
      $check = smn_db_fetch_array($check_query);
      $entry_state_has_zones = ($check['total'] > 0);
      if ($entry_state_has_zones == true) {
        $zone_query = smn_db_query("select distinct zone_id from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country . "' and (upper(zone_name) = upper('" . smn_db_input($state) . "') or upper(zone_code) = upper('" . smn_db_input($state) . "'))");
        if (smn_db_num_rows($zone_query) == 1) {
          $zone = smn_db_fetch_array($zone_query);
          $zone_id = $zone['zone_id'];
        } else {
          $error = true;
          $entry_state_error = true;
          $messageStack->add('create_account', ENTRY_STATE_ERROR_SELECT);
        }
      } else {
        if (strlen($state) < ENTRY_STATE_MIN_LENGTH) {
          $error = true;

          $messageStack->add('create_account', ENTRY_STATE_ERROR);
        }
      }
    }

    if (strlen($telephone) < ENTRY_TELEPHONE_MIN_LENGTH) {
      $error = true;

      $messageStack->add('create_account', ENTRY_TELEPHONE_NUMBER_ERROR);
    }


    if (strlen($password) < ENTRY_PASSWORD_MIN_LENGTH) {
      $error = true;

      $messageStack->add('create_account', ENTRY_PASSWORD_ERROR);
    } elseif ($password != $confirmation) {
      $error = true;

      $messageStack->add('create_account', ENTRY_PASSWORD_ERROR_NOT_MATCHING);
    }

    if ($error == false) {
      $sql_data_array = array('customers_firstname' => $firstname,
                              'customers_lastname' => $lastname,
                              'customers_email_address' => $email_address,
                              'customers_telephone' => $telephone,
                              'customers_fax' => $fax,
                              'customers_newsletter' => $newsletter,
                              'customers_password' => smn_encrypt_password($password));

      if (ACCOUNT_GENDER == 'true') $sql_data_array['customers_gender'] = $gender;
      if (ACCOUNT_DOB == 'true') {
      	$dob = $dob_day.'/'.$dob_month.'/'.$dob_year;
      	$sql_data_array['customers_dob'] = smn_date_raw($dob);
      }

      smn_db_perform(TABLE_CUSTOMERS, $sql_data_array);

      $customer_id = smn_db_insert_id();

      $sql_data_array = array('customers_id' => $customer_id,
                              'entry_firstname' => $firstname,
                              'entry_lastname' => $lastname,
                              'entry_street_address' => $street_address,
                              'entry_postcode' => $postcode,
                              'entry_city' => $city,
                              'entry_country_id' => $country);

      if (ACCOUNT_GENDER == 'true') $sql_data_array['entry_gender'] = $gender;
      if (ACCOUNT_COMPANY == 'true') $sql_data_array['entry_company'] = $company;
      if (ACCOUNT_STATE == 'true') {
        if ($zone_id > 0) {
          $sql_data_array['entry_zone_id'] = $zone_id;
          $sql_data_array['entry_state'] = '';
        } else {
          $sql_data_array['entry_zone_id'] = '0';
          $sql_data_array['entry_state'] = $state;
        }
      }

      smn_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array);

      $address_id = smn_db_insert_id();

      smn_db_query("update " . TABLE_CUSTOMERS . " set customers_default_address_id = '" . (int)$address_id . "' where customers_id = '" . (int)$customer_id . "'");

      smn_db_query("insert into " . TABLE_CUSTOMERS_INFO . " (customers_info_id, customers_info_number_of_logons, customers_info_date_account_created) values ('" . (int)$customer_id . "', '0', now())");

      if (SESSION_RECREATE == 'True') {
        smn_session_recreate();
      }

      $customer_first_name = $firstname;
      $customer_default_address_id = $address_id;
      $customer_country_id = $country;
      $customer_zone_id = $zone_id;
      smn_session_register('customer_id');
      smn_session_register('customer_first_name');
      smn_session_register('customer_default_address_id');
      smn_session_register('customer_country_id');
      smn_session_register('customer_zone_id');

// restore cart contents
      $cart->restore_contents();

// build the message content
      $name = $firstname . ' ' . $lastname;
      
        define('EMAIL_SUBJECT', 'Welcome to ' . $display_store_name);
        define('EMAIL_GREET_MR', 'Dear Mr. ' . $lastname . ',' . "\n\n");
        define('EMAIL_GREET_MS', 'Dear Ms. ' . $lastname . ',' . "\n\n");
        define('EMAIL_GREET_NONE', 'Dear ' . $firstname . ',' . "\n\n");
        define('EMAIL_WELCOME', 'We welcome you to <b>' . $display_store_name . '</b>.' . "\n\n");
        define('EMAIL_CONTACT', 'For help with any of our online services, please email the store-owner: ' . $store->get_store_owner_email_address() . '.' . "\n\n");
        define('EMAIL_WARNING', '<b>Note:</b> This email address was given to us by one of our customers. If you did not signup to be a member, please send a email to ' . $store->get_store_owner_email_address() . '.' . "\n");

      if (ACCOUNT_GENDER == 'true') {
         if ($gender == 'm') {
           $email_text = sprintf(EMAIL_GREET_MR, $lastname);
         } else {
           $email_text = sprintf(EMAIL_GREET_MS, $lastname);
         }
      } else {
        $email_text = sprintf(EMAIL_GREET_NONE, $firstname);
      }

      $email_text .= EMAIL_WELCOME . EMAIL_CONTACT . EMAIL_WARNING;
      
  if (NEW_SIGNUP_GIFT_VOUCHER_AMOUNT > 0) {
    $coupon_code = create_coupon_code();
    $insert_query = smn_db_query("insert into " . TABLE_COUPONS . " (coupon_code, coupon_type, coupon_amount, date_created) values ('" . $coupon_code . "', 'G', '" . NEW_SIGNUP_GIFT_VOUCHER_AMOUNT . "', now())");
    $insert_id = smn_db_insert_id($insert_query);
    $insert_query = smn_db_query("insert into " . TABLE_COUPON_EMAIL_TRACK . " (coupon_id, customer_id_sent, sent_firstname, emailed_to, date_sent) values ('" . $insert_id ."', '0', 'Admin', '" . $email_address . "', now() )");
    $email_text .= sprintf(EMAIL_GV_INCENTIVE_HEADER, $currencies->format(NEW_SIGNUP_GIFT_VOUCHER_AMOUNT)) . "\n\n" .
                   sprintf(EMAIL_GV_REDEEM, $coupon_code) . "\n\n" .
                   EMAIL_GV_LINK . smn_href_link(FILENAME_GV_REDEEM, 'gv_no=' . $coupon_code,'NONSSL', false) .
                   "\n\n";
  }
  if (NEW_SIGNUP_DISCOUNT_COUPON != '') {
    $coupon_code = NEW_SIGNUP_DISCOUNT_COUPON;
    $coupon_query = smn_db_query("select * from " . TABLE_COUPONS . " where coupon_code = '" . $coupon_code . "'");
    $coupon = smn_db_fetch_array($coupon_query);
    $coupon_id = $coupon['coupon_id'];		
    $coupon_desc_query = smn_db_query("select * from " . TABLE_COUPONS_DESCRIPTION . " where coupon_id = '" . $coupon_id . "' and language_id = '" . (int)$languages_id . "'");
    $coupon_desc = smn_db_fetch_array($coupon_desc_query);
    $insert_query = smn_db_query("insert into " . TABLE_COUPON_EMAIL_TRACK . " (coupon_id, customer_id_sent, sent_firstname, emailed_to, date_sent) values ('" . $coupon_id ."', '0', 'Admin', '" . $email_address . "', now() )");
    $email_text .= EMAIL_COUPON_INCENTIVE_HEADER .  "\n" .
                   sprintf("%s", $coupon_desc['coupon_description']) ."\n\n" .
                   sprintf(EMAIL_COUPON_REDEEM, $coupon['coupon_code']) . "\n\n" .
                   "\n\n";

  }
  
      smn_mail($name, $email_address, EMAIL_SUBJECT, $email_text, $store->get_store_owner(), $store->get_store_owner_email_address());

      smn_redirect(smn_href_link(FILENAME_CREATE_ACCOUNT_SUCCESS, '', 'NONSSL'));
    }
  }

  $breadcrumb->add(NAVBAR_TITLE, smn_href_link(FILENAME_CREATE_ACCOUNT, '', 'NONSSL'));

?>