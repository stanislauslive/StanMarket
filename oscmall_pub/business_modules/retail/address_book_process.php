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

  if (!smn_session_is_registered('customer_id')) {
    $navigation->set_snapshot();
    smn_redirect(smn_href_link(FILENAME_LOGIN, '', 'NONSSL'));
  }

  if (isset($_GET['action']) && ($_GET['action'] == 'deleteconfirm') && isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    smn_db_query("delete from " . TABLE_ADDRESS_BOOK . " where address_book_id = '" . (int)$_GET['delete'] . "' and customers_id = '" . (int)$customer_id . "'");

    $messageStack->add_session('addressbook', SUCCESS_ADDRESS_BOOK_ENTRY_DELETED, 'success');

    smn_redirect(smn_href_link(FILENAME_ADDRESS_BOOK, 'ID='.$store_id, 'NONSSL'));
  }

// error checking when updating or adding an entry
  $process = false;
  if (isset($_POST['action']) && (($_POST['action'] == 'process') || ($_POST['action'] == 'update'))) {
    $process = true;
    $error = false;

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

        $messageStack->add('addressbook', ENTRY_GENDER_ERROR);
      }
    }

    if (strlen($firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
      $error = true;

      $messageStack->add('addressbook', ENTRY_FIRST_NAME_ERROR);
    }

    if (strlen($lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
      $error = true;

      $messageStack->add('addressbook', ENTRY_LAST_NAME_ERROR);
    }

    if (strlen($street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
      $error = true;

      $messageStack->add('addressbook', ENTRY_STREET_ADDRESS_ERROR);
    }

    if (strlen($postcode) < ENTRY_POSTCODE_MIN_LENGTH) {
      $error = true;

      $messageStack->add('addressbook', ENTRY_POST_CODE_ERROR);
    }

    if (strlen($city) < ENTRY_CITY_MIN_LENGTH) {
      $error = true;

      $messageStack->add('addressbook', ENTRY_CITY_ERROR);
    }

    if (!is_numeric($country)) {
      $error = true;

      $messageStack->add('addressbook', ENTRY_COUNTRY_ERROR);
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

          $messageStack->add('addressbook', ENTRY_STATE_ERROR_SELECT);
        }
      } else {
        if (strlen($state) < ENTRY_STATE_MIN_LENGTH) {
          $error = true;

          $messageStack->add('addressbook', ENTRY_STATE_ERROR);
        }
      }
    }

    if ($error == false) {
      $sql_data_array = array('entry_firstname' => $firstname,
                              'entry_lastname' => $lastname,
                              'entry_street_address' => $street_address,
                              'entry_postcode' => $postcode,
                              'entry_city' => $city,
                              'entry_country_id' => (int)$country);

      if (ACCOUNT_GENDER == 'true') $sql_data_array['entry_gender'] = $gender;
      if (ACCOUNT_COMPANY == 'true') $sql_data_array['entry_company'] = $company;
      if (ACCOUNT_STATE == 'true') {
        if ($zone_id > 0) {
          $sql_data_array['entry_zone_id'] = (int)$zone_id;
          $sql_data_array['entry_state'] = '';
        } else {
          $sql_data_array['entry_zone_id'] = '0';
          $sql_data_array['entry_state'] = $state;
        }
      }

      if ($_POST['action'] == 'update') {
        $check_query = smn_db_query("select address_book_id from " . TABLE_ADDRESS_BOOK . " where address_book_id = '" . (int)$_GET['edit'] . "' and customers_id = '" . (int)$customer_id . "' limit 1"); 
         if (smn_db_num_rows($check_query) == 1) { 
 
            smn_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array, 'update', "address_book_id = '" . (int)$_GET['edit'] . "' and customers_id ='" . (int)$customer_id . "'");

// reregister session variables
            if ( (isset($_POST['primary']) && ($_POST['primary'] == 'on')) || ($_GET['edit'] == $customer_default_address_id) ) {
              $customer_first_name = $firstname;
// systemsmanager begin - Dec 1, 2005 security patch
//          $customer_country_id = $country_id;
		      $customer_country_id = $country;
// systemsmanager end		  
              $customer_zone_id = (($zone_id > 0) ? (int)$zone_id : '0');
              $customer_default_address_id = (int)$_GET['edit'];

              $sql_data_array = array('customers_firstname' => $firstname,
                                      'customers_lastname' => $lastname,
                                      'customers_default_address_id' => (int)$_GET['edit']);

              if (ACCOUNT_GENDER == 'true') $sql_data_array['customers_gender'] = $gender;

              smn_db_perform(TABLE_CUSTOMERS, $sql_data_array, 'update', "customers_id = '" . (int)$customer_id . "'");
            }
          $messageStack->add_session('addressbook', SUCCESS_ADDRESS_BOOK_ENTRY_UPDATED, 'success');
         }
      } else {
        if (tep_count_customer_address_book_entries() < MAX_ADDRESS_BOOK_ENTRIES) {  
            $sql_data_array['customers_id'] = (int)$customer_id;
            smn_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array);

            $new_address_book_id = smn_db_insert_id();

// reregister session variables
            if (isset($_POST['primary']) && ($_POST['primary'] == 'on')) {
              $customer_first_name = $firstname;
// systemsmanager begin - Dec 1, 2005 security patch
//          $customer_country_id = $country_id;
              $customer_country_id = $country;
// systemsmanager end
		      $customer_zone_id = (($zone_id > 0) ? (int)$zone_id : '0');
              if (isset($_POST['primary']) && ($_POST['primary'] == 'on')) $customer_default_address_id = $new_address_book_id;

              $sql_data_array = array('customers_firstname' => $firstname,
                                      'customers_lastname' => $lastname);

              if (ACCOUNT_GENDER == 'true') $sql_data_array['customers_gender'] = $gender;
              if (isset($_POST['primary']) && ($_POST['primary'] == 'on')) $sql_data_array['customers_default_address_id'] = $new_address_book_id;

              smn_db_perform(TABLE_CUSTOMERS, $sql_data_array, 'update', "customers_id = '" . (int)$customer_id . "'");
            }
            $messageStack->add_session('addressbook', SUCCESS_ADDRESS_BOOK_ENTRY_UPDATED, 'success');            
        }
      }

      smn_redirect(smn_href_link(FILENAME_ADDRESS_BOOK, 'ID='.$store_id, 'NONSSL'));
    }
  }

  if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $entry_query = smn_db_query("select entry_gender, entry_company, entry_firstname, entry_lastname, entry_street_address, entry_postcode, entry_city, entry_state, entry_zone_id, entry_country_id from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int)$customer_id . "' and address_book_id = '" . (int)$_GET['edit'] . "'");

    if (!smn_db_num_rows($entry_query)) {
      $messageStack->add_session('addressbook', ERROR_NONEXISTING_ADDRESS_BOOK_ENTRY);

      smn_redirect(smn_href_link(FILENAME_ADDRESS_BOOK, 'ID='.$store_id, 'NONSSL'));
    }

    $entry = smn_db_fetch_array($entry_query);
  } elseif (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    if ($_GET['delete'] == $customer_default_address_id) {
      $messageStack->add_session('addressbook', WARNING_PRIMARY_ADDRESS_DELETION, 'warning');

      smn_redirect(smn_href_link(FILENAME_ADDRESS_BOOK, 'ID='.$store_id, 'NONSSL'));
    } else {
      $check_query = smn_db_query("select count(*) as total from " . TABLE_ADDRESS_BOOK . " where address_book_id = '" . (int)$_GET['delete'] . "' and customers_id = '" . (int)$customer_id . "'");
      $check = smn_db_fetch_array($check_query);

      if ($check['total'] < 1) {
        $messageStack->add_session('addressbook', ERROR_NONEXISTING_ADDRESS_BOOK_ENTRY);

        smn_redirect(smn_href_link(FILENAME_ADDRESS_BOOK, 'ID='.$store_id, 'NONSSL'));
      }
    }
  } else {
    $entry = array();
  }

  if (!isset($_GET['delete']) && !isset($_GET['edit'])) {
    if (smn_count_customer_address_book_entries() >= MAX_ADDRESS_BOOK_ENTRIES) {
      $messageStack->add_session('addressbook', ERROR_ADDRESS_BOOK_FULL);

      smn_redirect(smn_href_link(FILENAME_ADDRESS_BOOK, 'ID='.$store_id, 'NONSSL'));
    }
  }

  $breadcrumb->add(NAVBAR_TITLE_1, smn_href_link(FILENAME_ACCOUNT, 'ID='.$store_id, 'NONSSL'));
  $breadcrumb->add(NAVBAR_TITLE_2, smn_href_link(FILENAME_ADDRESS_BOOK, 'ID='.$store_id, 'NONSSL'));

  if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $breadcrumb->add(NAVBAR_TITLE_MODIFY_ENTRY, smn_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'edit=' . $_GET['edit'].'&ID='.$store_id, 'NONSSL'));
  } elseif (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $breadcrumb->add(NAVBAR_TITLE_DELETE_ENTRY, smn_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'delete=' . $_GET['delete'].'&ID='.$store_id, 'NONSSL'));
  } else {
    $breadcrumb->add(NAVBAR_TITLE_ADD_ENTRY, smn_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'ID='.$store_id, 'NONSSL'));
  }

?>