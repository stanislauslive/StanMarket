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
  class pm2checkout {
    var $code, $title, $description, $enabled;

// class constructor
    function pm2checkout() {
      global $order;

      $this->code = 'pm2checkout';
      $this->title = MODULE_PAYMENT_2CHECKOUT_TEXT_TITLE;
      $this->description = MODULE_PAYMENT_2CHECKOUT_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_PAYMENT_2CHECKOUT_SORT_ORDER;
      $this->enabled = ((MODULE_PAYMENT_2CHECKOUT_STATUS == 'True') ? true : false);
	  $this->single = ((MODULE_PAYMENT_2CHECKOUT_SINGLE_CHECKOUT == 'True') ? true : false);

      if ((int)MODULE_PAYMENT_2CHECKOUT_ORDER_STATUS_ID > 0) {
        $this->order_status = MODULE_PAYMENT_2CHECKOUT_ORDER_STATUS_ID;
      }

      if (is_object($order)) $this->update_status();

      $this->form_action_url = 'https://www.2checkout.com/cgi-bin/Abuyers/purchase.2c';
    }

// class methods
    function update_status() {
      global $order, $store_id;

      if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_2CHECKOUT_ZONE > 0) ) {
        $check_flag = false;
        $check_query = smn_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_2CHECKOUT_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' and store_id = '" . $store_id . "' order by zone_id");
        while ($check = smn_db_fetch_array($check_query)) {
          if ($check['zone_id'] < 1) {
            $check_flag = true;
            break;
          } elseif ($check['zone_id'] == $order->billing['zone_id']) {
            $check_flag = true;
            break;
          }
        }

        if ($check_flag == false) {
          $this->enabled = false;
        }
      }
    }

    function javascript_validation() {
      $js = '  if (payment_value == "' . $this->code . '") {' . "\n" .
            '    var cc_number = document.checkout_payment.pm_2checkout_cc_number.value;' . "\n" .
            '    if (cc_number == "" || cc_number.length < ' . CC_NUMBER_MIN_LENGTH . ') {' . "\n" .
            '      error_message = error_message + "' . MODULE_PAYMENT_2CHECKOUT_TEXT_JS_CC_NUMBER . '";' . "\n" .
            '      error = 1;' . "\n" .
            '    }' . "\n" .
            '  }' . "\n";

      return $js;
    }

    function selection() {
      global $order;

      for ($i=1; $i < 13; $i++) {
        $expires_month[] = array('id' => sprintf('%02d', $i), 'text' => strftime('%B',mktime(0,0,0,$i,1,2000)));
      }

      $today = getdate(); 
      for ($i=$today['year']; $i < $today['year']+10; $i++) {
        $expires_year[] = array('id' => strftime('%y',mktime(0,0,0,1,1,$i)), 'text' => strftime('%Y',mktime(0,0,0,1,1,$i)));
      }

      $selection = array('id' => $this->code,
                         'module' => $this->title,
                         'fields' => array(array('title' => MODULE_PAYMENT_2CHECKOUT_TEXT_CREDIT_CARD_OWNER_FIRST_NAME,
                                                 'field' => smn_draw_input_field('pm_2checkout_cc_owner_firstname', $order->billing['firstname'])),
                                           array('title' => MODULE_PAYMENT_2CHECKOUT_TEXT_CREDIT_CARD_OWNER_LAST_NAME,
                                                 'field' => smn_draw_input_field('pm_2checkout_cc_owner_lastname', $order->billing['lastname'])),
                                           array('title' => MODULE_PAYMENT_2CHECKOUT_TEXT_CREDIT_CARD_NUMBER,
                                                 'field' => smn_draw_input_field('pm_2checkout_cc_number')),
                                           array('title' => MODULE_PAYMENT_2CHECKOUT_TEXT_CREDIT_CARD_EXPIRES,
                                                 'field' => smn_draw_pull_down_menu('pm_2checkout_cc_expires_month', $expires_month) . '&nbsp;' . smn_draw_pull_down_menu('pm_2checkout_cc_expires_year', $expires_year)),
                                           array('title' => MODULE_PAYMENT_2CHECKOUT_TEXT_CREDIT_CARD_CHECKNUMBER,
                                                 'field' => smn_draw_input_field('pm_2checkout_cc_cvv', '', 'size="4" maxlength="3"') . '&nbsp;<small>' . MODULE_PAYMENT_2CHECKOUT_TEXT_CREDIT_CARD_CHECKNUMBER_LOCATION . '</small>')));

      return $selection;
    }

    function pre_confirmation_check() {
      global $_POST;

      include(DIR_WS_CLASSES . 'cc_validation.php');

      $cc_validation = new cc_validation();
      $result = $cc_validation->validate($_POST['pm_2checkout_cc_number'], $_POST['pm_2checkout_cc_expires_month'], $_POST['pm_2checkout_cc_expires_year']);

      $error = '';
      switch ($result) {
        case -1:
          $error = sprintf(TEXT_CCVAL_ERROR_UNKNOWN_CARD, substr($cc_validation->cc_number, 0, 4));
          break;
        case -2:
        case -3:
        case -4:
          $error = TEXT_CCVAL_ERROR_INVALID_DATE;
          break;
        case false:
          $error = TEXT_CCVAL_ERROR_INVALID_NUMBER;
          break;
      }

      if ( ($result == false) || ($result < 1) ) {
        $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode($error) . '&pm_2checkout_cc_owner_firstname=' . urlencode($_POST['pm_2checkout_cc_owner_firstname']) . '&pm_2checkout_cc_owner_lastname=' . urlencode($_POST['pm_2checkout_cc_owner_lastname']) . '&pm_2checkout_cc_expires_month=' . $_POST['pm_2checkout_cc_expires_month'] . '&pm_2checkout_cc_expires_year=' . $_POST['pm_2checkout_cc_expires_year'];

        smn_redirect(smn_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'NONSSL', true, false));
      }

      $this->cc_card_type = $cc_validation->cc_type;
      $this->cc_card_number = $cc_validation->cc_number;
      $this->cc_expiry_month = $cc_validation->cc_expiry_month;
      $this->cc_expiry_year = $cc_validation->cc_expiry_year;
    }

    function confirmation() {
      global $_POST;

      $confirmation = array('title' => $this->title . ': ' . $this->cc_card_type,
                            'fields' => array(array('title' => MODULE_PAYMENT_2CHECKOUT_TEXT_CREDIT_CARD_OWNER,
                                                    'field' => $_POST['pm_2checkout_cc_owner_firstname'] . ' ' . $_POST['pm_2checkout_cc_owner_lastname']),
                                              array('title' => MODULE_PAYMENT_2CHECKOUT_TEXT_CREDIT_CARD_NUMBER,
                                                    'field' => substr($this->cc_card_number, 0, 4) . str_repeat('X', (strlen($this->cc_card_number) - 8)) . substr($this->cc_card_number, -4)),
                                              array('title' => MODULE_PAYMENT_2CHECKOUT_TEXT_CREDIT_CARD_EXPIRES,
                                                    'field' => strftime('%B, %Y', mktime(0,0,0,$_POST['pm_2checkout_cc_expires_month'], 1, '20' . $_POST['pm_2checkout_cc_expires_year'])))));

      return $confirmation;
    }

    function process_button() {
      global $_POST, $order;

      $process_button_string = smn_draw_hidden_field('x_login', MODULE_PAYMENT_2CHECKOUT_LOGIN) .
                               smn_draw_hidden_field('x_amount', number_format($order->info['total'], 2)) .
                               smn_draw_hidden_field('x_invoice_num', date('YmdHis')) .
                               smn_draw_hidden_field('x_test_request', ((MODULE_PAYMENT_2CHECKOUT_TESTMODE == 'Test') ? 'Y' : 'N')) .
                               smn_draw_hidden_field('x_card_num', $this->cc_card_number) .
                               smn_draw_hidden_field('cvv', $_POST['pm_2checkout_cc_cvv']) .
                               smn_draw_hidden_field('x_exp_date', $this->cc_expiry_month . substr($this->cc_expiry_year, -2)) .
                               smn_draw_hidden_field('x_first_name', $_POST['pm_2checkout_cc_owner_firstname']) .
                               smn_draw_hidden_field('x_last_name', $_POST['pm_2checkout_cc_owner_lastname']) .
                               smn_draw_hidden_field('x_address', $order->customer['street_address']) .
                               smn_draw_hidden_field('x_city', $order->customer['city']) .
                               smn_draw_hidden_field('x_state', $order->customer['state']) .
                               smn_draw_hidden_field('x_zip', $order->customer['postcode']) .
                               smn_draw_hidden_field('x_country', $order->customer['country']['title']) .
                               smn_draw_hidden_field('x_email', $order->customer['email_address']) .
                               smn_draw_hidden_field('x_phone', $order->customer['telephone']) .
                               smn_draw_hidden_field('x_ship_to_first_name', $order->delivery['firstname']) .
                               smn_draw_hidden_field('x_ship_to_last_name', $order->delivery['lastname']) .
                               smn_draw_hidden_field('x_ship_to_address', $order->delivery['street_address']) .
                               smn_draw_hidden_field('x_ship_to_city', $order->delivery['city']) .
                               smn_draw_hidden_field('x_ship_to_state', $order->delivery['state']) .
                               smn_draw_hidden_field('x_ship_to_zip', $order->delivery['postcode']) .
                               smn_draw_hidden_field('x_ship_to_country', $order->delivery['country']['title']) .
                               smn_draw_hidden_field('x_receipt_link_url', smn_href_link(FILENAME_CHECKOUT_PROCESS, '', 'NONSSL')) .
                               smn_draw_hidden_field('x_email_merchant', ((MODULE_PAYMENT_2CHECKOUT_EMAIL_MERCHANT == 'True') ? 'TRUE' : 'FALSE'));

      return $process_button_string;
    }

    function before_process() {
      global $_POST;

      if ($_POST['x_response_code'] != '1') {
        smn_redirect(smn_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message=' . urlencode(MODULE_PAYMENT_2CHECKOUT_TEXT_ERROR_MESSAGE), 'NONSSL', true, false));
      }
    }


    function after_process() {
      return false;
    }

    function get_error() {
      global $_GET;

      $error = array('title' => MODULE_PAYMENT_2CHECKOUT_TEXT_ERROR,
                     'error' => stripslashes(urldecode($_GET['error'])));

      return $error;
    }

    function check() {
      global $store_id;
      
      if (!isset($this->_check)) {
        $check_query = smn_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_2CHECKOUT_STATUS' and store_id = '" . $store_id . "'");
        $this->_check = smn_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      global $store_id;
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . $store_id . "', 'Enable 2CheckOut Module', 'MODULE_PAYMENT_2CHECKOUT_STATUS', 'True', 'Do you want to accept 2CheckOut payments?', '6', '0', 'smn_cfg_select_option(array(\'True\', \'False\'), ', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . $store_id . "', 'Login/Store Number', 'MODULE_PAYMENT_2CHECKOUT_LOGIN', '18157', 'Login/Store Number used for the 2CheckOut service', '6', '0', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . $store_id . "', 'Transaction Mode', 'MODULE_PAYMENT_2CHECKOUT_TESTMODE', 'Test', 'Transaction mode used for the 2Checkout service', '6', '0', 'smn_cfg_select_option(array(\'Test\', \'Production\'), ', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . $store_id . "', 'Merchant Notifications', 'MODULE_PAYMENT_2CHECKOUT_EMAIL_MERCHANT', 'True', 'Should 2CheckOut e-mail a receipt to the store owner?', '6', '0', 'smn_cfg_select_option(array(\'True\', \'False\'), ', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . $store_id . "', 'Sort order of display.', 'MODULE_PAYMENT_2CHECKOUT_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('" . $store_id . "', 'Payment Zone', 'MODULE_PAYMENT_2CHECKOUT_ZONE', '0', 'If a zone is selected, only enable this payment method for that zone.', '6', '2', 'smn_get_zone_class_title', 'smn_cfg_pull_down_zone_classes(', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('" . $store_id . "', 'Set Order Status', 'MODULE_PAYMENT_2CHECKOUT_ORDER_STATUS_ID', '0', 'Set the status of orders made with this payment module to this value', '6', '0', 'smn_cfg_pull_down_order_statuses(', 'smn_get_order_status_name', now())");
	  if($store_id==1){
        smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . $store_id . "', 'For Single Checkout?', 'MODULE_PAYMENT_2CHECKOUT_SINGLE_CHECKOUT', 'False', 'Use this payment for single checkout?', '6', '2', 'smn_cfg_select_option(array(\'True\', \'False\'), ', now())");
	  }
    }

    function remove() {
      global $store_id;
      smn_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "') and store_id = '" . $store_id . "'");
    }

    function keys() {
	  global $store_id;
	   $key_array = array('MODULE_PAYMENT_2CHECKOUT_STATUS', 'MODULE_PAYMENT_2CHECKOUT_LOGIN', 'MODULE_PAYMENT_2CHECKOUT_TESTMODE', 'MODULE_PAYMENT_2CHECKOUT_EMAIL_MERCHANT', 'MODULE_PAYMENT_2CHECKOUT_ZONE', 'MODULE_PAYMENT_2CHECKOUT_ORDER_STATUS_ID', 'MODULE_PAYMENT_2CHECKOUT_SORT_ORDER');
	   if($store_id==1){
	   	$key_array = array_merge($key_array,array('MODULE_PAYMENT_2CHECKOUT_SINGLE_CHECKOUT'));
	   }
      return $key_array;
    }
  }
?>
