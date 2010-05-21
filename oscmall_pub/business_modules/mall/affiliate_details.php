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
  
  if (!smn_session_is_registered('affiliate_id')) {
    $navigation->set_snapshot();
    smn_redirect(smn_href_link(FILENAME_AFFILIATE, '', 'NONSSL'));
  }
  
/*Included customer class and created an object of the same , by Cimi*/

  require(DIR_WS_CLASSES . 'customer.php');
  $profile_edit = new customer($store_id);
  if (isset($_POST['action'])) {
  
    require(DIR_WS_FUNCTIONS . 'validations.php');

    $a_gender = smn_db_prepare_input($_POST['a_gender']);
    $a_firstname = smn_db_prepare_input($_POST['a_firstname']);
    $a_lastname = smn_db_prepare_input($_POST['a_lastname']);
     $a_dob = smn_db_prepare_input($_POST['a_dob']);
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
	
/*Commented DOB validation as the dob field is noneditable ,by Cimi*/
    /* if (ACCOUNT_DOB == 'true') {
      if (checkdate(substr(smn_date_raw($a_dob), 4, 2), substr(smn_date_raw($a_dob), 6, 2), substr(smn_date_raw($a_dob), 0, 4))) {
        $entry_date_of_birth_error = false;
      } else {
        $error = true;
        $entry_date_of_birth_error = true;
      }
    }*/
	
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

/*Commented the password validation as password section is removed from account edit,By Cimi*/
    /*$passlen = strlen($a_password);
    if ($passlen < ENTRY_PASSWORD_MIN_LENGTH) {
      $error = true;
      $entry_password_error = true;
    } else {
      $entry_password_error = false;
    }

    if ($a_password != $a_confirmation) {
      $error = true;
      $entry_password_error = true;
    }*/
	/*Changed the query to take the password from customer table ,By Cimi*/
	/*$check_email_query = smn_db_query("select count(*) as total from " . TABLE_AFFILIATE . " where affiliate_email_address = '" .  smn_db_input($a_email_address) . "' and affiliate_id != '" . smn_db_input($affiliate_id) . "'");*/
    $check_email_query = smn_db_query("select count(*) as total from " . TABLE_CUSTOMERS . " where customers_email_address = '" .  smn_db_input($a_email_address) . "' and customers_id != '" . smn_db_input($customer_id) . "'");
    $check_email = smn_db_fetch_array($check_email_query);
    if ($check_email['total'] > 0) {
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
/*Commented the unwanted validation,By Cimi*/
   /* if (!$a_agb) {
	  $error=true;
	  $entry_agb_error=true;
    }*/

    // Check Company 
    $entry_company_error = false;
    $entry_company_taxid_error = false;

    // Check Payment
    $entry_payment_check_error = false;
    $entry_payment_paypal_error = false;
    $entry_payment_bank_name_error = false;
    $entry_payment_bank_branch_number_error = false;
    $entry_payment_bank_swift_code_error = false;
    $entry_payment_bank_account_name_error = false;
    $entry_payment_bank_account_number_error = false;

    if (!$error) {
	/*Added the code to edit the details in the customer table,by Cimi*/
	  $profile_edit->set_firstname($a_firstname);
      $profile_edit->set_lastname($a_lastname);
      $profile_edit->set_email_address($a_email_address);
      $profile_edit->set_telephone($a_telephone);
      $profile_edit->set_fax($a_fax);
      $profile_edit->set_newsletter($newsletter);
      $profile_edit->set_gender($a_gender);
      $profile_edit->set_dob($a_dob);
      $profile_edit->set_street_address($a_street_address);
      $profile_edit->set_postcode($a_postcode);
      $profile_edit->set_city($a_city);
      $profile_edit->set_country_id($a_country);
      $profile_edit->set_company($a_company);

      if ($a_zone_id > 0) {
      	$L_state = smn_get_zone_name($a_country, $a_zone_id, '');
        $profile_edit->set_zone_id($a_zone_id);
        $profile_edit->set_state($L_state);
        
      } else {
        $profile_edit->set_zone_id('0');
        $profile_edit->set_state($a_state);      
        
      }
      
    $customer_id = $profile_edit->create($customer_id); 
	
/*End of the code*/
/*Removed the unwanted items from the query data array,By Cimi */
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
			      				'affiliate_header_image' => $a_header_image,
                              'affiliate_password' => smn_encrypt_password($a_password),
                              'affiliate_agb' => '1');

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
      }

      $sql_data_array['affiliate_date_account_last_modified'] = 'now()';*/
	
      $sql_data_array = array('affiliate_payment_check' => $a_payment_check,
                              'affiliate_payment_paypal' => $a_payment_paypal,
                              'affiliate_payment_bank_name' => $a_payment_bank_name,
                              'affiliate_payment_bank_branch_number' => $a_payment_bank_branch_number,
                              'affiliate_payment_bank_swift_code' => $a_payment_bank_swift_code,
                              'affiliate_payment_bank_account_name' => $a_payment_bank_account_name,
                              'affiliate_payment_bank_account_number' => $a_payment_bank_account_number,
                              'affiliate_homepage' => $a_homepage,
                              'affiliate_agb' => '1');

      if (ACCOUNT_COMPANY == 'true') {
        $sql_data_array['affiliate_company_taxid'] = $a_company_taxid;
      }
      if (ACCOUNT_SUBURB == 'true') $sql_data_array['affiliate_suburb'] = $a_suburb;

      smn_db_perform(TABLE_AFFILIATE, $sql_data_array, 'update', "affiliate_id = '" . smn_db_input($affiliate_id) . "'");

      smn_redirect(smn_href_link(FILENAME_AFFILIATE_DETAILS_OK, '', 'NONSSL'));
    }
  }

  $breadcrumb->add(NAVBAR_TITLE_1, smn_href_link(FILENAME_AFFILIATE_DETAILS, '', 'NONSSL'));
  $breadcrumb->add(NAVBAR_TITLE_2, smn_href_link(FILENAME_AFFILIATE_DETAILS, '', 'NONSSL'));
 
?> 