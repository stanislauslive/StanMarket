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
// include validation functions (right now only email address)
  require(DIR_WS_FUNCTIONS . 'validations.php');
// include the password crypto functions
  require(DIR_WS_FUNCTIONS . 'password_funcs.php');
// include the mail classes
  require(DIR_WS_CLASSES . 'mime.php');
  require(DIR_WS_CLASSES . 'email.php');
  
  /* Included the customer class by Cimi on June 13,2007  */
  
  require(DIR_WS_CLASSES . 'customer.php');
  
  if (isset($_POST['action'])) {
    $a_gender = smn_db_prepare_input($_POST['a_gender']);
    $a_firstname = smn_db_prepare_input($_POST['a_firstname']);
    $a_lastname = smn_db_prepare_input($_POST['a_lastname']);
/*Changed the dob format to fit to the customer table,By Cimi*/
    /*$a_dob = smn_db_prepare_input($_POST['a_dob']);*/
    $a_dob = $_POST['dob_day'] . '-' . $_POST['dob_month'] . '-' . $_POST['dob_year'];
    $a_email_address = smn_db_prepare_input($_POST['a_email_address']);
    $a_company = smn_db_prepare_input($_POST['a_company']);
    $a_company_taxid = smn_db_prepare_input($_POST['a_company_taxid']);
    $a_payment_check = smn_db_prepare_input($_POST['a_payment_check']);
    $a_payment_paypal = smn_db_prepare_input($_POST['a_payment_paypal']);
    $a_payment_bank_name = smn_db_prepare_input($_POST['a_payment_bank_name']);
    $a_payment_bank_branch_number = smn_db_prepare_input($_POST['a_payment_bank_branch_number']);
    $a_payment_bank_swift_code = smn_db_prepare_input($_POST['a_payment_bank_swift_code']);
    $a_payment_bank_account_name = smn_db_prepare_input($_POST['a_payment_bank_account_name']);
    $a_payment_bank_account_number = smn_db_prepare_input($_POST['a_payment_bank_account_number']);
    $a_street_address = smn_db_prepare_input($_POST['a_street_address']);
    $a_suburb = smn_db_prepare_input($_POST['a_suburb']);
    $a_postcode = smn_db_prepare_input($_POST['a_postcode']);
    $a_city = smn_db_prepare_input($_POST['a_city']);
    $a_country=smn_db_prepare_input($_POST['a_country']);
    $a_zone_id = smn_db_prepare_input($_POST['a_zone_id']);
    $a_state = smn_db_prepare_input($_POST['a_state']);
    $a_telephone = smn_db_prepare_input($_POST['a_telephone']);
    $a_fax = smn_db_prepare_input($_POST['a_fax']);
    $a_homepage = smn_db_prepare_input($_POST['a_homepage']);
    $a_password = smn_db_prepare_input($_POST['a_password']);
    $a_newsletter = smn_db_prepare_input($_POST['a_newsletter']);

    $error = false; // reset error flag

    if (ACCOUNT_GENDER == 'true') {
      if (($a_gender == 'm') || ($a_gender == 'f')) {
        $entry_gender_error = false;
      } else {
        $error = true;
        $entry_gender_error = true;
      }
    }

    if (strlen($a_firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
      $error = true;
      $entry_firstname_error = true;
    } else {
      $entry_firstname_error = false;
    }

    if (strlen($a_lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
      $error = true;
      $entry_lastname_error = true;
    } else {
      $entry_lastname_error = false;
    }

    if (ACCOUNT_DOB == 'true') {
      if (checkdate(substr(smn_date_raw($a_dob), 4, 2), substr(smn_date_raw($a_dob), 6, 2), substr(smn_date_raw($a_dob), 0, 4))) {
        $entry_date_of_birth_error = false;
      } else {
        $error = true;
        $entry_date_of_birth_error = true;
      }
    }
  
    if (strlen($a_email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
      $error = true;
      $entry_email_address_error = true;
    } else {
      $entry_email_address_error = false;
    }

    if (!smn_validate_email($a_email_address)) {
      $error = true;
      $entry_email_address_check_error = true;
    } else {
      $entry_email_address_check_error = false;
    }

    if (strlen($a_street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
      $error = true;
      $entry_street_address_error = true;
    } else {
      $entry_street_address_error = false;
    }
  
    if (strlen($a_postcode) < ENTRY_POSTCODE_MIN_LENGTH) {
      $error = true;
      $entry_post_code_error = true;
    } else {
      $entry_post_code_error = false;
    } 

    if (strlen($a_city) < ENTRY_CITY_MIN_LENGTH) {
      $error = true;
      $entry_city_error = true;
    } else {
      $entry_city_error = false;
    }

    if (!$a_country) {
      $error = true;
      $entry_country_error = true;
    } else {
      $entry_country_error = false;
    }

    if (ACCOUNT_STATE == 'true') {
      if ($entry_country_error) {
        $entry_state_error = true;
      } else {
        $a_zone_id = 0;
        $entry_state_error = false;
        $check_query = smn_db_query("select count(*) as total from " . TABLE_ZONES . " where zone_country_id = '" . smn_db_input($a_country) . "'");
        $check_value = smn_db_fetch_array($check_query);
        $entry_state_has_zones = ($check_value['total'] > 0);
        if ($entry_state_has_zones) {
          $zone_query = smn_db_query("select zone_id from " . TABLE_ZONES . " where zone_country_id = '" . smn_db_input($a_country) . "' and zone_name = '" . smn_db_input($a_state) . "'");
          if (smn_db_num_rows($zone_query) == 1) {
            $zone_values = smn_db_fetch_array($zone_query);
            $a_zone_id = $zone_values['zone_id'];
          } else {
            $zone_query = smn_db_query("select zone_id from " . TABLE_ZONES . " where zone_country_id = '" . smn_db_input($a_country) . "' and zone_code = '" . smn_db_input($a_state) . "'");
            if (smn_db_num_rows($zone_query) == 1) {
              $zone_values = smn_db_fetch_array($zone_query);
              $a_zone_id = $zone_values['zone_id'];
            } else {
              $error = true;
              $entry_state_error = true;
            }
          }
        } else {
          if (!$a_state) {
            $error = true;
            $entry_state_error = true;
          }
        }
      }
    }

    if (strlen($a_telephone) < ENTRY_TELEPHONE_MIN_LENGTH) {
      $error = true;
      $entry_telephone_error = true;
    } else {
      $entry_telephone_error = false;
    }

    $passlen = strlen($a_password);
    if ($passlen < ENTRY_PASSWORD_MIN_LENGTH) {
      $error = true;
      $entry_password_error = true;
    } else {
      $entry_password_error = false;
    }

    if ($a_password != $a_confirmation) {
      $error = true;
      $entry_password_error = true;
    }
	/* Changed the query to check the uniqueness of customer email By Cimi on June 13,2007*/
    /*$check_email = smn_db_query("select affiliate_email_address from " . TABLE_AFFILIATE . " where affiliate_email_address = '" . smn_db_input($a_email_address) . "'");*/
    $check_email = smn_db_query("select customers_email_address from " . TABLE_CUSTOMERS . " where customers_email_address = '" . smn_db_input($a_email_address) . "'");
    if (smn_db_num_rows($check_email)) {
      $error = true;
      $entry_email_address_exists = true;
    } else {
      $entry_email_address_exists = false;
    }

    // Check Suburb
    $entry_suburb_error = false;

    // Check Fax
    $entry_fax_error = false;

    if (!affiliate_check_url($a_homepage)) {
      $error = true;
      $entry_homepage_error = true;
    } else {
      $entry_homepage_error = false;
    }

    if (!$a_agb) {
	  $error=true;
	  $entry_agb_error=true;
    }

    // Check Company 
    $entry_company_error = false;
    $entry_company_taxid_error = false;

    // Check Newsletter 
    $entry_newsletter_error = false;

    // Check Payment
    $entry_payment_check_error = false;
    $entry_payment_paypal_error = false;
    $entry_payment_bank_name_error = false;
    $entry_payment_bank_branch_number_error = false;
    $entry_payment_bank_swift_code_error = false;
    $entry_payment_bank_account_name_error = false;
    $entry_payment_bank_account_number_error = false;

    if (!$error) {
	/* Added sales agent data in customer table by cimi on June 13,2007 */
	  if (!smn_session_is_registered('customer_id')) {
		  //ADD THE STORE OWNER DATA ....
		  $new_customer = new customer();
		  $new_customer->set_firstname($a_firstname);
		  $new_customer->set_lastname($a_lastname);
		  $new_customer->set_email_address($a_email_address);
		  $new_customer->set_telephone($a_telephone);
		  $new_customer->set_fax($a_fax);
		  $new_customer->set_newsletter($a_newsletter);
		  $new_customer->set_password($a_password);
		  $new_customer->set_gender($a_gender);
		  $new_customer->set_dob($a_dob);
		  $new_customer->set_street_address($a_street_address);
		  $new_customer->set_postcode($a_postcode);
		  $new_customer->set_city($a_city);
		  $new_customer->set_country_id($a_country);
                  $new_customer->set_company($a_company);
		  $new_customer->set_zone_id($a_zone_id);
		  $new_customer->set_state($a_state);
		  $customer_id = $new_customer->create();
                  $customer_default_address_id = $new_customer->get_default_address();
                  
		  smn_session_register('customer_id');
		  smn_session_register('customer_first_name');
		  smn_session_register('customer_default_address_id');
		  smn_session_register('customer_country_id');
		  smn_session_register('customer_zone_id');
	  }
	  
/*End of adding sales agent data*/

/*Changed data in the affiliate table by Cimi on June 13,2007*/
     /* $sql_data_array = array('affiliate_firstname' => $a_firstname,
                              'affiliate_lastname' => $a_lastname,
                              'affiliate_email_address' => $a_email_address,
                              'affiliate_payment_check' => $a_payment_check,
                              'affiliate_payment_paypal' => $a_payment_paypal,
                              'affiliate_payment_bank_name' => $a_payment_bank_name,
                              'affiliate_payment_bank_branch_number' => $a_payment_bank_branch_number,
                              'affiliate_payment_bank_swift_code' => $a_payment_bank_swift_code,
                              'affiliate_payment_bank_account_name' => $a_payment_bank_account_name,
                              'affiliate_payment_bank_account_number' => $a_payment_bank_account_number,
                              'affiliate_street_address' => $a_street_address,
                              'affiliate_postcode' => $a_postcode,
                              'affiliate_city' => $a_city,
                              'affiliate_country_id' => $a_country,
                              'affiliate_telephone' => $a_telephone,
                              'affiliate_fax' => $a_fax,
                              'affiliate_homepage' => $a_homepage,
                              'affiliate_password' => smn_encrypt_password($a_password),
                              'affiliate_agb' => '1',
                              'affiliate_newsletter' => $a_newsletter);

      if (ACCOUNT_GENDER == 'true') $sql_data_array['affiliate_gender'] = $a_gender;
      if (ACCOUNT_DOB == 'true') $sql_data_array['affiliate_dob'] = smn_date_raw($a_dob);
      if (ACCOUNT_COMPANY == 'true') {
        $sql_data_array['affiliate_company'] = $a_company;
        $sql_data_array['affiliate_company_taxid'] = $a_company_taxid;
      }
      if (ACCOUNT_SUBURB == 'true') $sql_data_array['affiliate_suburb'] = $a_suburb;
      if (ACCOUNT_STATE == 'true') {
        if ($a_zone_id > 0) {
          $sql_data_array['affiliate_zone_id'] = $a_zone_id;
          $sql_data_array['affiliate_state'] = '';
        } else {
          $sql_data_array['affiliate_zone_id'] = '0';
          $sql_data_array['affiliate_state'] = $a_state;
        }
      }*/

      $sql_data_array = array('affiliate_customer_id' => $customer_id,
                              'affiliate_payment_check' => $a_payment_check,
                              'affiliate_payment_paypal' => $a_payment_paypal,
                              'affiliate_payment_bank_name' => $a_payment_bank_name,
                              'affiliate_payment_bank_branch_number' => $a_payment_bank_branch_number,
                              'affiliate_payment_bank_swift_code' => $a_payment_bank_swift_code,
                              'affiliate_payment_bank_account_name' => $a_payment_bank_account_name,
                              'affiliate_payment_bank_account_number' => $a_payment_bank_account_number,
                              'affiliate_homepage' => $a_homepage,
                              'affiliate_agb' => '1'
							  );

      if (ACCOUNT_COMPANY == 'true') {
        $sql_data_array['affiliate_company_taxid'] = $a_company_taxid;
      }
      if (ACCOUNT_SUBURB == 'true') $sql_data_array['affiliate_suburb'] = $a_suburb;
	  
      $affiliate_id = affiliate_insert ($sql_data_array, $HTTP_SESSION_VARS['affiliate_ref'] );

      $aemailbody = MAIL_AFFILIATE_HEADER . "\n"
                  . MAIL_AFFILIATE_ID . $affiliate_id . "\n"
                  . MAIL_AFFILIATE_USERNAME . $a_email_address . "\n"
                  . MAIL_AFFILIATE_PASSWORD . $a_password . "\n\n"
                  . MAIL_AFFILIATE_LINK
                  . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_AFFILIATE . "\n\n"
                  . MAIL_AFFILIATE_FOOTER;
      smn_mail($a_firstname . ' ' . $a_lastname, $a_email_address, MAIL_AFFILIATE_SUBJECT, nl2br($aemailbody), $store->get_store_owner(), AFFILIATE_EMAIL_ADDRESS);
    
      smn_session_register('affiliate_id');
      $affiliate_email = $a_email_address;
      $affiliate_name = $a_firstname . ' ' . $a_lastname;
      smn_session_register('affiliate_email');
      smn_session_register('affiliate_name');
      smn_redirect(smn_href_link(FILENAME_AFFILIATE_SIGNUP_OK, '', 'NONSSL'));
    }
  }

  $breadcrumb->add(NAVBAR_TITLE, smn_href_link(FILENAME_AFFILIATE_SIGNUP, '', 'NONSSL'));
?> 
