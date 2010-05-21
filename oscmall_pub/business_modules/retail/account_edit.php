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

  global $page_name, $store;

  $action = (isset($_GET['action']) ? $_GET['action'] : '');
 
  if (!smn_session_is_registered('customer_id')) {
    if (isset($_POST) && !empty($_POST) && smn_not_null($action)){
       echo '{
           success: false,
           errorType: "login"
       }';
       exit;
    }
    $navigation->set_snapshot();
    
    smn_redirect(smn_href_link(FILENAME_LOGIN, 'ID='.$store_id, 'NONSSL'));
  }
  
  if ($action == 'getZones' && isset($_GET['country'])){
      $country = $_GET['country'];
      $Qzones = smn_db_query("select zone_name from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country . "' order by zone_name");
      if (smn_db_num_rows($Qzones)){
          $zones_array = array();
          while ($zones = smn_db_fetch_array($Qzones)) {
              $zones_array[] = '"' . $zones['zone_name'] . '": "' . $zones['zone_name'] . '"';
          }
          echo '{
              success: true,
              hasZones: true,
              zones: {' . implode(',', $zones_array) . '}
          }';
      }else{
          echo '{
              success: true,
              hasZones: false
          }';
      }
      exit;
  }
  
 if (!class_exists('customer')){
     require(DIR_WS_CLASSES . 'customer.php');
 }
 $customerInfo = new customer($customer_id);

 if (smn_session_is_registered('customer_store_id')){
     if (!class_exists('store')){
         require('includes/classes/store.php');
     }
     $customersStore = new store($customer_store_id);
 }
 
 if (isset($_POST) && !empty($_POST) && $action == 'save'){
    $error = false;
    // include validation functions (right now only email address)
    require(DIR_WS_FUNCTIONS . 'validations.php');
    
    $customer_first_name = $_POST['firstname'];
    $lastname = $_POST['lastname'];
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
     
    if (strlen($customer_first_name) < ENTRY_FIRST_NAME_MIN_LENGTH) {
       $error = true;
       $messageStack->add('account_edit', ENTRY_FIRST_NAME_ERROR, '');
    }

    if (strlen($lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
       $error = true;
       $messageStack->add('account_edit', ENTRY_LAST_NAME_ERROR, '');
    }

    if (strlen($email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
       $error = true;
       $messageStack->add('account_edit', ENTRY_EMAIL_ADDRESS_ERROR, '');
    } elseif (smn_validate_email($email_address) == false) {
       $error = true;
       $messageStack->add('account_edit', ENTRY_EMAIL_ADDRESS_CHECK_ERROR, '');
    } else {
       $check_email_query = smn_db_query("select count(*) as total from " . TABLE_ADMIN . " where admin_email_address = '" . smn_db_input($email_address) . "' and customer_id != '" . $customer_id . "'");
       $check_email = smn_db_fetch_array($check_email_query);
       if ($check_email['total'] > 0) {
          $error = true;
          $messageStack->add('account_edit', ENTRY_EMAIL_ADDRESS_ERROR_EXISTS, '');
       }
    }

    if (strlen($street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
       $error = true;
       $messageStack->add('account_edit', ENTRY_STREET_ADDRESS_ERROR, '');
    }
     
    if (strlen($postcode) < ENTRY_POSTCODE_MIN_LENGTH) {
       $error = true;
       $messageStack->add('account_edit', ENTRY_POST_CODE_ERROR, '');
    }

    if (strlen($city) < ENTRY_CITY_MIN_LENGTH) {
       $error = true;
       $messageStack->add('account_edit', ENTRY_CITY_ERROR, '');
    }

    if (is_numeric($customer_country_id) == false) {
       $error = true;
       $messageStack->add('account_edit', ENTRY_COUNTRY_ERROR, '');
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
          $messageStack->add('account_edit', ENTRY_STATE_ERROR_SELECT, '');
       }
    } else {
       if (strlen($state) < ENTRY_STATE_MIN_LENGTH) {
          $error = true;
          $messageStack->add('account_edit', ENTRY_STATE_ERROR, '');
       }
    }

    $telephone = $_POST['telephone_0'] . '-' . $_POST['telephone_1'] . '-' . $_POST['telephone_2'];
    $tollfree = $_POST['tollfree_0'] . '-' . $_POST['tollfree_1'] . '-' . $_POST['tollfree_2'];
    $fax = $_POST['fax_0'] . '-' . $_POST['fax_1'] . '-' . $_POST['fax_2'];
    if (isset($_POST['newsletter']) && $_POST['newsletter'] == '1') {
       $newsletter = '1';
    } else {
       $newsletter = false;
    }
    /*
    if (isset($_POST['affiliate_id']) && !empty($_POST['affiliate_id'])){
        $Qcheck = smn_db_query('select * from ' . TABLE_AFFILIATE . ' where affiliate_id = "' . $_POST['affiliate_id'] . '"');
        if (!smn_db_num_rows($Qcheck)){
          $error = true;
          $messageStack->add('account_edit', 'There is no affiliate with the entered id.', '');
        }
    }
    */
    if (smn_session_is_registered('customer_store_id')){
        $new_store_name = smn_db_prepare_input($_POST['storename']);
        $store_query = smn_db_query("select store_name from " . TABLE_STORE_DESCRIPTION . " WHERE store_name like '". $new_store_name ."' and store_id != '" . $customer_store_id . "'");
        if (smn_db_num_rows($store_query)) {
            $error = true;
            $messageStack->add('account_edit', ENTRY_STORE_NAME_ERROR, '');
        }
        
        if (isset($_POST['sp_store_path'])){
            $sp = new store_path($customer_store_id);
            $data = array(
                'sp_store_path'      => $_POST['sp_store_path'],
                'sp_store_id'        => $customer_store_id,
                'sp_store_path_text' => $_POST['sp_store_path_text']
            );
            $rv = $sp->choose_path($data);
            if ($rv) {
            } else {
                $error = true;
                $messageStack->add('account_edit', $sp->error_message());
            }
        }
        
        // file uploading class
        $doUpload = false;
        if (!empty($_FILES['store_image']['name']) || !empty($GLOBALS['HTTP_POST_FILES']['store_image']) || !empty($GLOBALS['store_image_name'])){
            require(DIR_WS_CLASSES . 'upload.php');
            if (function_exists('ini_get') && ((bool)ini_get('file_uploads') == false) ) {
                $error = true;
                $messageStack->add('account_edit', WARNING_FILE_UPLOADS_DISABLED, '');
            }
            $customersStore->set_store_logo('store_image');
            $doUpload = true;
        }
        if ($doUpload === true){
            $error_text = $customersStore->put_logo_image();
            if ($error_text != '') {
                $error = true;
                $messageStack->add('account_edit', $error_text, '');
            }
        }
    }
 
    if ($error === false){
	   $customerInfo->set_firstname($customer_first_name);
	   $customerInfo->set_lastname($lastname);
	   $customerInfo->set_email_address($email_address);
	   $customerInfo->set_dob($dob);
	   $customerInfo->set_street_address($street_address);
	   $customerInfo->set_postcode($postcode);
	   $customerInfo->set_city($city);
	   $customerInfo->set_country_id($customer_country_id);
       $customerInfo->set_company($company);
	   $customerInfo->set_zone_id($customer_zone_id);
	   $customerInfo->set_state($state);
	   $customerInfo->set_telephone($telephone);
	   $customerInfo->set_tollfree($tollfree);
	   $customerInfo->set_fax($fax);
	   $customerInfo->set_newsletter($newsletter);
	   /*
	   if (isset($_POST['affiliate_id']) && !empty($_POST['affiliate_id'])){
	       $customerInfo->set_affiliate_id($_POST['affiliate_id']);
	   }
	   */
	   
	   $customerInfo->create($customer_id);
	   
	   if (smn_session_is_registered('customer_store_id')){
	      $customerInfo->update_store_admin();
          $customersStore->set_store_name($new_store_name);
          $customersStore->set_store_category($_POST['store_catagory']);
          $customersStore->set_store_description($_POST['store_description']);
          $customersStore->update_store_info();
          $customersStore->put_store_category();
	   }
       echo '{success:true}';
    }else{
       echo '{
              success: false,
              errors: {
                   message: "' . addslashes(str_replace("\n", '', nl2br($messageStack->outputPlain('account_edit')))) . '"
              }
             }';
    }
    exit;
 }
 
  $account_query = smn_db_query("select c.*, ab.* from " . TABLE_CUSTOMERS . " c,  " . TABLE_ADDRESS_BOOK . " ab  where ab.customers_id = '" . (int)$customer_id . "' and c.customers_id = '" . (int)$customer_id . "' and ab.address_book_id = c.customers_default_address_id");
  $account = smn_db_fetch_array($account_query);
  $breadcrumb->add(NAVBAR_TITLE_1, smn_href_link(FILENAME_ACCOUNT, 'ID='.$store_id, 'NONSSL'));
  $breadcrumb->add(NAVBAR_TITLE_2, smn_href_link(FILENAME_ACCOUNT_EDIT, 'ID='.$store_id, 'NONSSL')); 

  $store_categories = $spath_setup->smn_get_store_category_tree('0','', '0');
  $countries = smn_get_countries();
 
  $Qzone = smn_db_query('select zone_name from ' . TABLE_ZONES . ' where (zone_code = "' . strtoupper($customerInfo->address_data['entry_state']) . '" || zone_name = "' . $customerInfo->address_data['entry_state'] . '")');
  if (smn_db_num_rows($Qzone)){
      $zone = smn_db_fetch_array($Qzone);
      $customerInfo->address_data['entry_state'] = $zone['zone_name'];
  }
 
/* Common Elements For Tabs - BEGIN */
  $commonCancelButton = $jQuery->getPluginClass('button', array(
      'id'   => 'cancel_button',
      'text' => 'Cancel'
  ));
  
  $commonDeleteButton = $jQuery->getPluginClass('button', array(
      'id'   => 'delete_button',
      'text' => 'Delete'
  ));
  
  $commonSaveButton = $jQuery->getPluginClass('button', array(
      'id'   => 'save_button',
      'type' => 'submit',
      'text' => 'Save'
  ));
/* Common Elements For Tabs - END */

/* Setup Tabs - BEGIN */
  $jQuery->setGlobalVars(array(
      'languages',
      'languages_id',
      'store_id',
      'commonSaveButton',
      'commonDeleteButton',
      'commonCancelButton',
      'account',
      'customerInfo',
      'customer_store_id',
      'affiliate_id',
      'customersStore',
      'store_categories',
      'countries'
  ));

  $tabsArray = array();
  $tabsArray[] = array(
      'tabID'    => 'tab-contact',
      'filename' => 'tab_contact.php',
      'text'     => 'Contact'
  );
 
  $tabsArray[] = array(
      'tabID'    => 'tab-personal',
      'filename' => 'tab_personal.php',
      'text'     => 'Personal'
  );
 
  if (smn_session_is_registered('customer_store_id')){
      $tabsArray[] = array(
          'tabID'    => 'tab-settings',
          'filename' => 'tab_settings.php',
          'text'     => 'Settings'
      );
  }
   
  $submitButton = $jQuery->getPluginClass('button', array(
      'id'   => 'submitButton',
      'text' => IMAGE_BUTTON_SAVE_CHANGES,
      'type' => 'submit'
  ));
 
  $backButton = $jQuery->getPluginClass('button', array(
      'id'   => 'backButton',
      'text' => IMAGE_BUTTON_BACK,
      'href' => $jQuery->link(FILENAME_ACCOUNT, 'ID=' . $store_id)
  ));
 
  $helpButton = $jQuery->getPluginClass('button', array(
      'id'   => 'helpButton',
      'text' => IMAGE_BUTTON_HELP,
  ));
  
  $tabPanel = $jQuery->getPluginClass('tabs', array(
      'id'            => 'initialPane',
      'tabDir'        => DIR_FS_CATALOG . DIR_WS_MODULES . 'pages_tabs/account_edit/',
      'tabs'          => $tabsArray,
      'footerButtons' => array($submitButton, $backButton, $helpButton),
      'showFooter'    => true
  ));
 
  $tabPanel->setHelpButton('helpButton', true);
/* Setup Tabs - END */
?>