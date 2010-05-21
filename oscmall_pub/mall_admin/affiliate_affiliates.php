<?php
/*
  Copyright (c) 2002 - 2005 SystemsManager.Net

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

  require('includes/application_top.php');

  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

  if ($_GET['action']) {
    switch ($_GET['action']) {
      case 'update':
        $affiliate_id = smn_db_prepare_input($_GET['acID']);
/*Added to get the customer id by Cimi on June 15,2007*/
		$affiliate_customer_id = smn_db_prepare_input($_GET['cID']);
        $affiliate_gender = smn_db_prepare_input($_POST['affiliate_gender']);
        $affiliate_firstname = smn_db_prepare_input($_POST['affiliate_firstname']);
        $affiliate_lastname = smn_db_prepare_input($_POST['affiliate_lastname']);
        $affiliate_dob = smn_db_prepare_input($_POST['affiliate_dob']);
        $affiliate_email_address = smn_db_prepare_input($_POST['affiliate_email_address']);
        $affiliate_company = smn_db_prepare_input($_POST['affiliate_company']);
        $affiliate_company_taxid = smn_db_prepare_input($_POST['affiliate_company_taxid']);
        $affiliate_payment_check = smn_db_prepare_input($_POST['affiliate_payment_check']);
        $affiliate_payment_paypal = smn_db_prepare_input($_POST['affiliate_payment_paypal']);
        $affiliate_payment_bank_name = smn_db_prepare_input($_POST['affiliate_payment_bank_name']);
        $affiliate_payment_bank_branch_number = smn_db_prepare_input($_POST['affiliate_payment_bank_branch_number']);
        $affiliate_payment_bank_swift_code = smn_db_prepare_input($_POST['affiliate_payment_bank_swift_code']);
        $affiliate_payment_bank_account_name = smn_db_prepare_input($_POST['affiliate_payment_bank_account_name']);
        $affiliate_payment_bank_account_number = smn_db_prepare_input($_POST['affiliate_payment_bank_account_number']);
        $affiliate_street_address = smn_db_prepare_input($_POST['affiliate_street_address']);
        $affiliate_suburb = smn_db_prepare_input($_POST['affiliate_suburb']);
        $affiliate_postcode=smn_db_prepare_input($_POST['affiliate_postcode']);
        $affiliate_city = smn_db_prepare_input($_POST['affiliate_city']);
        $affiliate_country_id=smn_db_prepare_input($_POST['affiliate_country_id']);
        $affiliate_telephone=smn_db_prepare_input($_POST['affiliate_telephone']);
        $affiliate_fax=smn_db_prepare_input($_POST['affiliate_fax']);
        $affiliate_homepage=smn_db_prepare_input($_POST['affiliate_homepage']);
        $affiliate_state = smn_db_prepare_input($_POST['affiliate_state']);
        $affiliatey_zone_id = smn_db_prepare_input($_POST['affiliate_zone_id']);
        $affiliate_commission_percent = smn_db_prepare_input($_POST['affiliate_commission_percent']);
        if ($affiliate_zone_id > 0) $affiliate_state = '';
        // If someone uses , instead of .
        $affiliate_commission_percent = str_replace (',' , '.' , $affiliate_commission_percent);

/*Added to update the details in customer table by Cimi on June 15,2007*/
		$sql_data_array = array('customers_firstname' => $affiliate_firstname,
                                'customers_lastname' => $affiliate_lastname,
                                'customers_email_address' => $affiliate_email_address,
                                'customers_telephone' => $affiliate_telephone,
                                'customers_fax' => $affiliate_fax);

        if (ACCOUNT_GENDER == 'true') $sql_data_array['customers_gender'] = $affiliate_gender;
        if (ACCOUNT_DOB == 'true') $sql_data_array['customers_dob'] = smn_date_raw($affiliate_dob);

        smn_db_perform(TABLE_CUSTOMERS, $sql_data_array, 'update', "customers_id = '" . (int)$affiliate_customer_id . "'");

        smn_db_query("update " . TABLE_CUSTOMERS_INFO . " set customers_info_date_account_last_modified = now() where customers_info_id = '" . (int)$affiliate_customer_id . "'");

        if ($entry_zone_id > 0) $entry_state = '';

        $sql_data_array = array('entry_firstname' => $affiliate_firstname,
                                'entry_lastname' => $affiliate_lastname,
                                'entry_street_address' => $affiliate_street_address,
                                'entry_postcode' => $affiliate_postcode,
                                'entry_city' => $affiliate_city,
                                'entry_country_id' => $affiliate_country_id);

        if (ACCOUNT_COMPANY == 'true') $sql_data_array['entry_company'] = $affiliate_company;

        if (ACCOUNT_STATE == 'true') {
          if ($entry_zone_id > 0) {
            $sql_data_array['entry_zone_id'] = $affiliate_zone_id;
            $sql_data_array['entry_state'] = '';
          } else {
            $sql_data_array['entry_zone_id'] = '0';
            $sql_data_array['entry_state'] = $affiliate_state;
          }
        }

        smn_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array, 'update', "customers_id = '" . (int)$affiliate_customer_id . "' and address_book_id = '" . (int)$default_address_id . "'");
		/*End of code*/
		/*Changed the data to be edited in the affiliate table by Cimi*/
       /* $sql_data_array = array('affiliate_firstname' => $affiliate_firstname,
                                'affiliate_lastname' => $affiliate_lastname,
                                'affiliate_email_address' => $affiliate_email_address,
                                'affiliate_payment_check' => $affiliate_payment_check,
                                'affiliate_payment_paypal' => $affiliate_payment_paypal,
                                'affiliate_payment_bank_name' => $affiliate_payment_bank_name,
                                'affiliate_payment_bank_branch_number' => $affiliate_payment_bank_branch_number,
                                'affiliate_payment_bank_swift_code' => $affiliate_payment_bank_swift_code,
                                'affiliate_payment_bank_account_name' => $affiliate_payment_bank_account_name,
                                'affiliate_payment_bank_account_number' => $affiliate_payment_bank_account_number,
                                'affiliate_street_address' => $affiliate_street_address,
                                'affiliate_postcode' => $affiliate_postcode,
                                'affiliate_city' => $affiliate_city,
                                'affiliate_country_id' => $affiliate_country_id,
                                'affiliate_telephone' => $affiliate_telephone,
                                'affiliate_fax' => $affiliate_fax,
                                'affiliate_homepage' => $affiliate_homepage,
                                'affiliate_commission_percent' => $affiliate_commission_percent,
                                'affiliate_agb' => '1');

        if (ACCOUNT_DOB == 'true') $sql_data_array['affiliate_dob'] = smn_date_raw($affiliate_dob);
        if (ACCOUNT_GENDER == 'true') $sql_data_array['affiliate_gender'] = $affiliate_gender;
        if (ACCOUNT_COMPANY == 'true') {
          $sql_data_array['affiliate_company'] = $affiliate_company;
          $sql_data_array['affiliate_company_taxid'] =  $affiliate_company_taxid;
        }
        if (ACCOUNT_SUBURB == 'true') $sql_data_array['affiliate_suburb'] = $affiliate_suburb;
        if (ACCOUNT_STATE == 'true') {
          $sql_data_array['affiliate_state'] = $affiliate_state;
          $sql_data_array['affiliate_zone_id'] = $affiliate_zone_id;
        }

        $sql_data_array['affiliate_date_account_last_modified'] = 'now()';*/

        $sql_data_array = array('affiliate_payment_check' => $affiliate_payment_check,
                                'affiliate_payment_paypal' => $affiliate_payment_paypal,
                                'affiliate_payment_bank_name' => $affiliate_payment_bank_name,
                                'affiliate_payment_bank_branch_number' => $affiliate_payment_bank_branch_number,
                                'affiliate_payment_bank_swift_code' => $affiliate_payment_bank_swift_code,
                                'affiliate_payment_bank_account_name' => $affiliate_payment_bank_account_name,
                                'affiliate_payment_bank_account_number' => $affiliate_payment_bank_account_number,
                                'affiliate_homepage' => $affiliate_homepage,
                                'affiliate_commission_percent' => $affiliate_commission_percent,
                                'affiliate_agb' => '1');

        if (ACCOUNT_COMPANY == 'true') {
          $sql_data_array['affiliate_company_taxid'] =  $affiliate_company_taxid;
        }

        smn_db_perform(TABLE_AFFILIATE, $sql_data_array, 'update', "affiliate_id = '" . smn_db_input($affiliate_id) . "'");

        smn_redirect(smn_href_link(FILENAME_AFFILIATE, smn_get_all_get_params(array('acID', 'action')) . 'acID=' . $affiliate_id));
        break;
      case 'deleteconfirm':
        $affiliate_id = smn_db_prepare_input($_GET['acID']);

        affiliate_delete(smn_db_input($affiliate_id)); 

        smn_redirect(smn_href_link(FILENAME_AFFILIATE, smn_get_all_get_params(array('acID', 'action')))); 
        break;
    }
  }
  
  $content_page = basename($_SERVER['PHP_SELF']);
  
  require('templates/default/layout.php');

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>