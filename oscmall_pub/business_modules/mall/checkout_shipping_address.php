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


// if the customer is not logged on, redirect them to the login page
  if (!smn_session_is_registered('customer_id')) {
    $navigation->set_snapshot();
    smn_redirect(smn_href_link(FILENAME_LOGIN, '', 'NONSSL'));
  }

// if there is nothing in the customers cart, redirect them to the shopping cart page
  if ($cart->count_contents() < 1) {
    smn_redirect(smn_href_link(FILENAME_SHOPPING_CART));
  }

  // needs to be included earlier to set the success message in the messageStack
 

  require(DIR_WS_CLASSES . 'order.php');
  $order = new order;

// if the order contains only virtual products, forward the customer to the billing page as
// a shipping address is not needed
  if ($order->content_type == 'virtual') {
    if (!smn_session_is_registered('shipping')) smn_session_register('shipping');
/*Register the session shipping_store,By Cimi*/
	if (!smn_session_is_registered('shipping_store')) smn_session_register('shipping_store');
    $shipping = false;
    if (!smn_session_is_registered('sendto')) smn_session_register('sendto');
    $sendto = false;
    smn_redirect(smn_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'NONSSL'));
  }

  $error = false;
  $process = false;
  if (isset($_POST['action']) && ($_POST['action'] == 'submit')) {
// process a new shipping address
    if (smn_not_null($_POST['firstname']) && smn_not_null($_POST['lastname']) && smn_not_null($_POST['street_address'])) {
      $process = true;

      if (ACCOUNT_GENDER == 'true') $gender = smn_db_prepare_input($_POST['gender']);
      if (ACCOUNT_COMPANY == 'true') $company = smn_db_prepare_input($_POST['company']);
      $firstname = smn_db_prepare_input($_POST['firstname']);
      $lastname = smn_db_prepare_input($_POST['lastname']);
      $street_address = smn_db_prepare_input($_POST['street_address']);
      $postcode = smn_db_prepare_input($_POST['postcode']);
      $city = smn_db_prepare_input($_POST['city']);
      $country = smn_db_prepare_input($_POST['country']);
      if (ACCOUNT_STATE == 'true') {
        if (isset($_POST['zone_id'])) {
          $zone_id = smn_db_prepare_input($_POST['zone_id']);
        } else {
          $zone_id = false;
        }
        $state = smn_db_prepare_input($_POST['state']);
      }

      if (ACCOUNT_GENDER == 'true') {
        if ( ($gender != 'm') && ($gender != 'f') ) {
          $error = true;

          $messageStack->add('checkout_address', ENTRY_GENDER_ERROR);
        }
      }

      if (strlen($firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
        $error = true;

        $messageStack->add('checkout_address', ENTRY_FIRST_NAME_ERROR);
      }

      if (strlen($lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
        $error = true;

        $messageStack->add('checkout_address', ENTRY_LAST_NAME_ERROR);
      }

      if (strlen($street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
        $error = true;

        $messageStack->add('checkout_address', ENTRY_STREET_ADDRESS_ERROR);
      }

      if (strlen($postcode) < ENTRY_POSTCODE_MIN_LENGTH) {
        $error = true;

        $messageStack->add('checkout_address', ENTRY_POST_CODE_ERROR);
      }

      if (strlen($city) < ENTRY_CITY_MIN_LENGTH) {
        $error = true;

        $messageStack->add('checkout_address', ENTRY_CITY_ERROR);
      }

      if (ACCOUNT_STATE == 'true') {
        $zone_id = 0;
        $check_query = smn_db_query("select count(*) as total from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country . "'");
        $check = smn_db_fetch_array($check_query);
        $entry_state_has_zones = ($check['total'] > 0);
        if ($entry_state_has_zones == true) {
          $zone_query = smn_db_query("select distinct zone_id from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country . "' and (zone_name = '" . smn_db_input($state) . "' or zone_code = '" . smn_db_input($state) . "')");
          if (smn_db_num_rows($zone_query) == 1) {
            $zone = smn_db_fetch_array($zone_query);
            $zone_id = $zone['zone_id'];
          } else {
            $error = true;

            $messageStack->add('checkout_address', ENTRY_STATE_ERROR_SELECT);
          }
        } else {
          if (strlen($state) < ENTRY_STATE_MIN_LENGTH) {
            $error = true;

            $messageStack->add('checkout_address', ENTRY_STATE_ERROR);
          }
        }
      }

      if ( (is_numeric($country) == false) || ($country < 1) ) {
        $error = true;

        $messageStack->add('checkout_address', ENTRY_COUNTRY_ERROR);
      }

      if ($error == false) {
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

        if (!smn_session_is_registered('sendto')) smn_session_register('sendto');

        smn_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array);

        $sendto = smn_db_insert_id();

        if (smn_session_is_registered('shipping')) smn_session_unregister('shipping');
/*Unregister the session shipping_store,By Cimi*/
		if (smn_session_is_registered('shipping_store')) smn_session_unregister('shipping_store');

        smn_redirect(smn_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'NONSSL'));
      }
// process the selected shipping destination
    } elseif (isset($_POST['address'])) {
      $reset_shipping = false;
      if (smn_session_is_registered('sendto')) {
        if ($sendto != $_POST['address']) {
          if (smn_session_is_registered('shipping')) {
            $reset_shipping = true;
          }
        }
      } else {
        smn_session_register('sendto');
      }

      $sendto = $_POST['address'];

      $check_address_query = smn_db_query("select count(*) as total from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int)$customer_id . "' and address_book_id = '" . (int)$sendto . "'");
      $check_address = smn_db_fetch_array($check_address_query);

      if ($check_address['total'] == '1') {
        if ($reset_shipping == true) smn_session_unregister('shipping');
        smn_redirect(smn_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'NONSSL'));
      } else {
        smn_session_unregister('sendto');
      }
    } else {
      if (!smn_session_is_registered('sendto')) smn_session_register('sendto');
      $sendto = $customer_default_address_id;

      smn_redirect(smn_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'NONSSL'));
    }
  }

// if no shipping destination address was selected, use their own address as default
  if (!smn_session_is_registered('sendto')) {
    $sendto = $customer_default_address_id;
  }

  $breadcrumb->add(NAVBAR_TITLE_1, smn_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'NONSSL'));
  $breadcrumb->add(NAVBAR_TITLE_2, smn_href_link(FILENAME_CHECKOUT_SHIPPING_ADDRESS, '', 'NONSSL'));

  $addresses_count = smn_count_customer_address_book_entries();

?>