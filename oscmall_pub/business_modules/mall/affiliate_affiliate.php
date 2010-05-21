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
  
  if (isset($_GET['action']) && ($_GET['action'] == 'process')) {
    $affiliate_username = smn_db_prepare_input($_POST['affiliate_username']);
    $affiliate_password = smn_db_prepare_input($_POST['affiliate_password']);

// Check if username exists
/*Changed the query to take the sales agent details from customer table by Cimi*/
    //$check_affiliate_query = smn_db_query("select affiliate_id, affiliate_firstname, affiliate_password, affiliate_email_address from " . TABLE_AFFILIATE . " where affiliate_email_address = '" . smn_db_input($affiliate_username) . "'");
	 $check_customer_query = smn_db_query("select a.affiliate_id,c.customers_id, c.customers_firstname, c.customers_password, c.customers_email_address, c.customers_default_address_id from " . TABLE_CUSTOMERS . " c,". TABLE_AFFILIATE ." a where c.customers_email_address = '" . smn_db_input($affiliate_username) . "' and c.customers_id=a.affiliate_customer_id");
    if (!smn_db_num_rows($check_customer_query)) {
      $_GET['login'] = 'fail';
    } else {
      $check_customer = smn_db_fetch_array($check_customer_query);
// Check that password is good
      if (!smn_validate_password($affiliate_password, $check_customer['customers_password'])) {
        $_GET['login'] = 'fail';
      } else {
	  /*Changed the code to set the session of user and sales agent if the login is success by Cimi*/
        /*$affiliate_id = $check_affiliate['affiliate_id'];
        smn_session_register('affiliate_id');

        $date_now = date('Ymd');

        smn_db_query("update " . TABLE_AFFILIATE . " set affiliate_date_of_last_logon = now(), affiliate_number_of_logons = affiliate_number_of_logons + 1 where affiliate_id = '" . $affiliate_id . "'");*/

	   if (SESSION_RECREATE == 'True') {
          smn_session_recreate();
        }
        $check_country_query = smn_db_query("select entry_country_id, entry_zone_id from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int)$check_customer['customers_id'] . "' and address_book_id = '" . (int)$check_customer['customers_default_address_id'] . "'");
        $check_country = smn_db_fetch_array($check_country_query);

        $affiliate_id = $check_affiliate['affiliate_id'];
        smn_session_register('affiliate_id');
		$customer_id = $check_customer['customers_id'];
        $customer_default_address_id = $check_customer['customers_default_address_id'];
        $customer_first_name = $check_customer['customers_firstname'];
        $customer_country_id = $check_country['entry_country_id'];
        $customer_zone_id = $check_country['entry_zone_id'];
        smn_session_register('customer_id');
        smn_session_register('customer_default_address_id');
        smn_session_register('customer_first_name');
        smn_session_register('customer_country_id');
        smn_session_register('customer_zone_id');


        smn_db_query("update " . TABLE_CUSTOMERS_INFO . " set customers_info_date_of_last_logon = now(), customers_info_number_of_logons = customers_info_number_of_logons+1 where customers_info_id = '" . (int)$customer_id . "'");
        $cart->restore_contents();
		
        smn_redirect(smn_href_link(FILENAME_AFFILIATE_SUMMARY,'','NONSSL'));
      }
    }
  }
  $breadcrumb->add(NAVBAR_TITLE, smn_href_link(FILENAME_AFFILIATE, '', 'NONSSL'));
?> 
