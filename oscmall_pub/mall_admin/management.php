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
require('includes/application_top.php');
require(DIR_WS_CLASSES . 'store.php');
require(DIR_WS_CLASSES . 'customer.php');

  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  $error = false;
  if (smn_not_null($action)) {
    switch ($action) {
        case 'setflag':
        require(DIR_WS_FUNCTIONS . 'management.php');
          setflag();
       break;
      
      case 'insert_store_category':
      case 'update_store_category':
        require(DIR_WS_FUNCTIONS . 'management.php');
        store_category($action);
        break;
      
      case 'delete_store_category_confirm':
        require(DIR_WS_FUNCTIONS . 'management.php');
        delete_store_category_confirm();
        break;
      
      case 'delete_store_confirm':
        require(DIR_WS_FUNCTIONS . 'management.php');
        delete_store_confirm();
        break;
      
      case 'move_store_category_confirm':
        require(DIR_WS_FUNCTIONS . 'management.php');
        move_store_category_confirm();
        break;
      
      case 'move_store_confirm':
        require(DIR_WS_FUNCTIONS . 'management.php');
        move_store_confirm();
        break;
      
      case 'insert_store':
      case 'update_store':
        require(DIR_WS_FUNCTIONS . 'management.php');
      // copy image only if modified
        manage_store_image();
        break;
      
      case 'copy_to_confirm':
        require(DIR_WS_FUNCTIONS . 'management.php');
        copy_to_confirm();
        break;
      
      case 'edit_store':
        require(DIR_WS_FUNCTIONS . 'management.php');
        $store_arr = edit_store();
        $sInfo = new objectInfo($store_arr);
        break;
    }
  }        
  if (($_GET['action'] == 'process') || ($_GET['action'] == 'update')) {
    
    $process = true;
    if (isset($_POST['customers_gender'])) {
      $gender = smn_db_prepare_input($_POST['customers_gender']);
    } else {
      $gender = false;
    }
    $customers_id = smn_db_prepare_input($_POST['customers_id']);
    $new_store_name = smn_db_prepare_input($_POST['new_store_name']);
    $new_store_name = str_replace("'", "\'", $new_store_name);
    $new_store_type = smn_db_prepare_input((int)$_POST['store_type']);
    $store_status = smn_db_prepare_input((int)$_POST['store_status']);
    $firstname = smn_db_prepare_input($_POST['customers_firstname']);
    $lastname = smn_db_prepare_input($_POST['customers_lastname']);
    $store_catagory = smn_db_prepare_input($sPath);
    $store_description = smn_db_prepare_input($_POST['store_description']);
    $list_store_id = smn_db_prepare_input($_POST['list_store_id']);
    $dob = smn_db_prepare_input($_POST['dob_day']) . '-' . smn_db_prepare_input($_POST['dob_month']) . '-' . smn_db_prepare_input($_POST['dob_year']);
    $email_address = smn_db_prepare_input($_POST['customers_email_address']);
    $customers_email_address = smn_db_prepare_input($_POST['customers_email_address']);
    $company = smn_db_prepare_input($_POST['entry_company']);
    $street_address = smn_db_prepare_input($_POST['entry_street_address']);
    $postal_code = smn_db_prepare_input($_POST['entry_postcode']);
    $city = smn_db_prepare_input($_POST['entry_city']);
    $state = smn_db_prepare_input($_POST['entry_state']);
    if (isset($_POST['zone_id'])) {
      $zone_id = smn_db_prepare_input($_POST['zone_id']);
    } else {
      $zone_id = false;
    }
    $country = smn_db_prepare_input($_POST['entry_country_id']);
    $telephone = smn_db_prepare_input($_POST['customers_telephone']);
    $fax = smn_db_prepare_input($_POST['fax']);
    if (isset($_POST['customers_newsletter'])) {
      $newsletter = smn_db_prepare_input($_POST['customers_newsletter']);
    } else {
      $newsletter = false;
    }
    $password = smn_db_prepare_input($_POST['password']);
    $confirmation = smn_db_prepare_input($_POST['confirmation']);
    $error = false;   

       if (strlen($customers_firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
          $error = true;
          $entry_firstname_error = true;
        } else {
          $entry_firstname_error = false;
        }

        if (strlen($customers_lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
          $error = true;
          $entry_lastname_error = true;
        } else {
          $entry_lastname_error = false;
        }

        if (strlen($customers_email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
          $error = true;
          $entry_email_address_error = true;
        } else {
          $entry_email_address_error = false;
       }
  
        if (strlen($entry_street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
          $error = true;
          $entry_street_address_error = true;
        } else {
          $entry_street_address_error = false;
        }
        
        if (strlen($entry_postcode) < ENTRY_POSTCODE_MIN_LENGTH) {
          $error = true;
          $entry_post_code_error = true;
        } else {
          $entry_post_code_error = false;
        }
        
        if (strlen($entry_city) < ENTRY_CITY_MIN_LENGTH) {
          $error = true;
          $entry_city_error = true;
        } else {
          $entry_city_error = false;
        }
        
        if ($entry_country_id == false) {
          $error = true;
          $entry_country_error = true;
        } else {
          $entry_country_error = false;
        }
          if ($entry_country_error == true) {
            $entry_state_error = true;
          } else {
            $zone_id = 0;
            $entry_state_error = false;
            $check_query = smn_db_query("select count(*) as total from " . TABLE_ZONES . " where zone_country_id = '" . (int)$entry_country_id . "'");
            $check_value = smn_db_fetch_array($check_query);
            $entry_state_has_zones = ($check_value['total'] > 0);
            if ($entry_state_has_zones == true) {
              $zone_query = smn_db_query("select zone_id from " . TABLE_ZONES . " where zone_country_id = '" . (int)$entry_country_id . "'  and (zone_name like '" . smn_db_input($state) . "%' or zone_code like '%" . smn_db_input($state) . "%')");
              if (smn_db_num_rows($zone_query) == 1) {
                $zone_values = smn_db_fetch_array($zone_query);
                $entry_zone_id = $zone_values['zone_id'];
              } else {
                $error = true;
                $entry_state_error = true;
              }
            } else {
              if ($entry_state == false) {
                $error = true;
                $entry_state_error = true;
              }
            }
         }
      
      if (strlen($customers_telephone) < ENTRY_TELEPHONE_MIN_LENGTH) {
        $error = true;
        $entry_telephone_error = true;
      } else {
        $entry_telephone_error = false;
      }
      if ($action == 'update'){
        if (strlen($customers_email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
          
          $error = true;
          $entry_email_address_error = true;
        } else {
          $entry_email_address_error = false;
        }
      }else{
        if (strlen($customers_email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
          $error = true;
          $entry_email_address_error = true;
		  echo "1";
        } elseif (smn_validate_email($email_address) == false) {
          $error = true;
          $entry_email_address_error = true;
		  echo "2";
        } else {
          $check_email_query = smn_db_query("select count(*) as total from " . TABLE_ADMIN . " where admin_email_address = '" . smn_db_input($email_address) . "'");
          $check_email = smn_db_fetch_array($check_email_query);
          if ($check_email['total'] > 0) {
            $error = true;
            $entry_email_address_error = true;
			echo "3";
          }
        }
      }
  if($_GET['action'] == 'process'){
    if (strlen($password) < ENTRY_PASSWORD_MIN_LENGTH) {
      $entry_password_error = true;
      $error = true;
    } elseif ($password != $confirmation) {
      $error = true;
      $entry_password_error = true;
    }else {
        $entry_password_error = false;
      }
  }        
    if ($error == false) {

  //===============================================================================================

    $store_monthly_costs = smn_set_store_cost($new_store_type); 
    $check_new_store_type = smn_set_store_type($new_store_type);
    $store_products_id = smn_set_products_id ($new_store_type);
    
//CREATE STORE IN THE DATABASE.....
	
    if ($_GET['action'] == 'update') {
      smn_session_register('customers_id');
      $customer_info = new customer($customers_id);
      $store_info = new store((int)$_GET['sID']);
    }else{
      if (!smn_session_is_registered('cart') && !is_object($cart)) {
        smn_session_register('cart');
        $cart = new shoppingCart;
      }
      $customer_info = new customer();
      $store_info = new store();
    }
    $customer_info->set_firstname($firstname );
    $customer_info->set_lastname($lastname);
    $customer_info->set_email_address($email_address);
    $customer_info->set_telephone($telephone);
    $customer_info->set_fax($fax);
    $customer_info->set_newsletter($newsletter);
    $customer_info->set_gender($gender);
//    $customer_info->set_dob($dob);
    $customer_info->set_street_address($street_address);
    $customer_info->set_postcode($postal_code);
    $customer_info->set_city($city);
    $customer_info->set_country_id($country);
    $customer_info->set_company($company);
    if($_GET['action'] == 'process')$customer_info->set_password($password);
    if ($zone_id > 0) {
      $customer_info->set_zone_id($zone_id);
      $customer_info->set_state('');
    } else {
      $customer_info->set_zone_id('0');
      $customer_info->set_state($state);      
    }
  //ADD THE STORE OWNER DATA ....      
    if ($_GET['action'] == 'update') {

      $customers_id = $customer_info->create($customers_id);
    }else{
      $customers_id = $customer_info->create();
    }
      $store_info->set_store_type($new_store_type);
      $store_info->set_customers_id($customers_id);
      $store_info->set_customers_data($customers_id);
      $store_info->set_store_name($new_store_name);      
      $store_info->set_store_description($store_description);
      $store_info->set_store_category($store_catagory);
      $store_info->set_store_logo('store_image');
      
      if($_GET['action'] == 'process'){
        $customer_store_id = $store_info->create_store();
		$store_info->put_store_description();  
        $store_info->put_store_category();
        $store_info->put_store_admin();
        $store_info->put_store_data();
        $store_info->put_store_cost();
        $store_info->put_store_products();                  
        if (ALLOW_STORE_SITE_TEXT == 'true') $store_info->put_store_language('english');
        $store_info->send_store_email($gender);
        $error_text = $store_info->put_logo_image('update');
      }else{
        $customer_store_id = (int)$_GET['sID'];
        //update existing store here....
        $store_info->update_store_info();
        $error_text = $store_info->put_logo_image('update');
        $sql_store_array = array('store_status' => $store_status);
        smn_db_perform(TABLE_STORE_MAIN, $sql_store_array,'update', "store_id = '" . (int)$_GET['sID'] . "'" );
        $sql_member_array = array('products_id' => (int)$store_products_id);
        smn_db_perform(TABLE_MEMBER_ORDERS, $sql_member_array, 'update', "store_id = '" . (int)$_GET['sID'] . "'");
        if((int)$_GET['sID'] != 1)  $sql_data_array = array('admin_groups_id' => (int)$new_store_type);                         
        smn_db_perform(TABLE_ADMIN, $sql_data_array, 'update', "store_id = '" . (int)$_GET['sID'] . "'" );
      }

    smn_redirect(smn_href_link(FILENAME_MANAGEMENT, 'sPath=' . $sPath . '&sID=' . (int)$customer_store_id));
  }
  }

// check if the catalog image directory exists
  if (is_dir(DIR_FS_CATALOG_IMAGES)) {
    if (!is_writeable(DIR_FS_CATALOG_IMAGES)) $messageStack->add(ERROR_CATALOG_IMAGE_DIRECTORY_NOT_WRITEABLE, 'error');
  } else {
    $messageStack->add(ERROR_CATALOG_IMAGE_DIRECTORY_DOES_NOT_EXIST, 'error');
  }
  
  $content_page = basename($_SERVER['PHP_SELF']);
  
  require('templates/default/layout.php');

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>