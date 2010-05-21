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

  class ipayment {
    var $code, $title, $description, $enabled;

// class constructor
    function ipayment() {
      global $order;

      $this->code = 'ipayment';
      $this->title = MODULE_PAYMENT_IPAYMENT_TEXT_TITLE;
      $this->description = MODULE_PAYMENT_IPAYMENT_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_PAYMENT_IPAYMENT_SORT_ORDER;
      $this->enabled = ((MODULE_PAYMENT_IPAYMENT_STATUS == 'True') ? true : false);
	  $this->single = ((MODULE_PAYMENT_IPAYMENT_SINGLE_CHECKOUT == 'True') ? true : false);

      if ((int)MODULE_PAYMENT_IPAYMENT_ORDER_STATUS_ID > 0) {
        $this->order_status = MODULE_PAYMENT_IPAYMENT_ORDER_STATUS_ID;
      }

      if (is_object($order)) $this->update_status();

      $this->form_action_url = 'https://ipayment.de/merchant/' . MODULE_PAYMENT_IPAYMENT_ID . '/processor.php';
    }

// class methods
    function update_status() {
      global $order, $store_id;

      if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_IPAYMENT_ZONE > 0) ) {
        $check_flag = false;
        $check_query = smn_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_IPAYMENT_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' and store_id = '" . $store_id . "' order by zone_id");
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
            '    var cc_owner = document.checkout_payment.ipayment_cc_owner.value;' . "\n" .
            '    var cc_number = document.checkout_payment.ipayment_cc_number.value;' . "\n" .
            '    if (cc_owner == "" || cc_owner.length < ' . CC_OWNER_MIN_LENGTH . ') {' . "\n" .
            '      error_message = error_message + "' . MODULE_PAYMENT_IPAYMENT_TEXT_JS_CC_OWNER . '";' . "\n" .
            '      error = 1;' . "\n" .
            '    }' . "\n" .
            '    if (cc_number == "" || cc_number.length < ' . CC_NUMBER_MIN_LENGTH . ') {' . "\n" .
            '      error_message = error_message + "' . MODULE_PAYMENT_IPAYMENT_TEXT_JS_CC_NUMBER . '";' . "\n" .
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
                         'fields' => array(array('title' => MODULE_PAYMENT_IPAYMENT_TEXT_CREDIT_CARD_OWNER,
                                                 'field' => smn_draw_input_field('ipayment_cc_owner', $order->billing['firstname'] . ' ' . $order->billing['lastname'])),
                                           array('title' => MODULE_PAYMENT_IPAYMENT_TEXT_CREDIT_CARD_NUMBER,
                                                 'field' => smn_draw_input_field('ipayment_cc_number')),
                                           array('title' => MODULE_PAYMENT_IPAYMENT_TEXT_CREDIT_CARD_EXPIRES,
                                                 'field' => smn_draw_pull_down_menu('ipayment_cc_expires_month', $expires_month) . '&nbsp;' . smn_draw_pull_down_menu('ipayment_cc_expires_year', $expires_year)),
                                           array('title' => MODULE_PAYMENT_IPAYMENT_TEXT_CREDIT_CARD_CHECKNUMBER,
                                                 'field' => smn_draw_input_field('ipayment_cc_checkcode', '', 'size="4" maxlength="3"') . '&nbsp;<small>' . MODULE_PAYMENT_IPAYMENT_TEXT_CREDIT_CARD_CHECKNUMBER_LOCATION . '</small>')));

      return $selection;
    }

    function pre_confirmation_check() {
      global $_POST;

      include(DIR_WS_CLASSES . 'cc_validation.php');

      $cc_validation = new cc_validation();
      $result = $cc_validation->validate($_POST['ipayment_cc_number'], $_POST['ipayment_cc_expires_month'], $_POST['ipayment_cc_expires_year']);

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
        $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode($error) . '&ipayment_cc_owner=' . urlencode($_POST['ipayment_cc_owner']) . '&ipayment_cc_expires_month=' . $_POST['ipayment_cc_expires_month'] . '&ipayment_cc_expires_year=' . $_POST['ipayment_cc_expires_year'] . '&ipayment_cc_checkcode=' . $_POST['ipayment_cc_checkcode'];

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
                            'fields' => array(array('title' => MODULE_PAYMENT_IPAYMENT_TEXT_CREDIT_CARD_OWNER,
                                                    'field' => $_POST['ipayment_cc_owner']),
                                              array('title' => MODULE_PAYMENT_IPAYMENT_TEXT_CREDIT_CARD_NUMBER,
                                                    'field' => substr($this->cc_card_number, 0, 4) . str_repeat('X', (strlen($this->cc_card_number) - 8)) . substr($this->cc_card_number, -4)),
                                              array('title' => MODULE_PAYMENT_IPAYMENT_TEXT_CREDIT_CARD_EXPIRES,
                                                    'field' => strftime('%B, %Y', mktime(0,0,0,$_POST['ipayment_cc_expires_month'], 1, '20' . $_POST['ipayment_cc_expires_year'])))));

      if (smn_not_null($_POST['ipayment_cc_checkcode'])) {
        $confirmation['fields'][] = array('title' => MODULE_PAYMENT_IPAYMENT_TEXT_CREDIT_CARD_CHECKNUMBER,
                                          'field' => $_POST['ipayment_cc_checkcode']);
      }

      return $confirmation;
    }

    function process_button() {
      global $_POST, $order, $currencies, $currency;
	  global $store;

      switch (MODULE_PAYMENT_IPAYMENT_CURRENCY) {
        case 'Always EUR':
          $trx_currency = 'EUR';
          break;
        case 'Always USD':
          $trx_currency = 'USD';
          break;
        case 'Either EUR or USD, else EUR':
          if ( ($currency == 'EUR') || ($currency == 'USD') ) {
            $trx_currency = $currency;
          } else {
            $trx_currency = 'EUR';
          }
          break;
        case 'Either EUR or USD, else USD':
          if ( ($currency == 'EUR') || ($currency == 'USD') ) {
            $trx_currency = $currency;
          } else {
            $trx_currency = 'USD';
          }
          break;
      }

      $process_button_string = smn_draw_hidden_field('silent', '1') .
                               smn_draw_hidden_field('trx_paymenttyp', 'cc') .
                               smn_draw_hidden_field('trxuser_id', MODULE_PAYMENT_IPAYMENT_USER_ID) .
                               smn_draw_hidden_field('trxpassword', MODULE_PAYMENT_IPAYMENT_PASSWORD) .
                               smn_draw_hidden_field('item_name', $store->get_store_name()) .
                               smn_draw_hidden_field('trx_currency', $trx_currency) .
                               smn_draw_hidden_field('trx_amount', number_format($order->info['total'] * 100 * $currencies->get_value($trx_currency), 0, '','')) .
                               smn_draw_hidden_field('cc_expdate_month', $_POST['ipayment_cc_expires_month']) .
                               smn_draw_hidden_field('cc_expdate_year', $_POST['ipayment_cc_expires_year']) .
                               smn_draw_hidden_field('cc_number', $_POST['ipayment_cc_number']) .
                               smn_draw_hidden_field('cc_checkcode', $_POST['ipayment_cc_checkcode']) .
                               smn_draw_hidden_field('addr_name', $_POST['ipayment_cc_owner']) .
                               smn_draw_hidden_field('addr_email', $order->customer['email_address']) .
                               smn_draw_hidden_field('redirect_url', smn_href_link(FILENAME_CHECKOUT_PROCESS, '', 'NONSSL', true)) .
                               smn_draw_hidden_field('silent_error_url', smn_href_link(FILENAME_CHECKOUT_PAYMENT, 'payment_error=' . $this->code . '&ipayment_cc_owner=' . urlencode($_POST['ipayment_cc_owner']), 'NONSSL', true));

      return $process_button_string;
    }

    function before_process() {
      return false;
    }

    function after_process() {
      return false;
    }

    function get_error() {
      global $_GET;

      $error = array('title' => IPAYMENT_ERROR_HEADING,
                     'error' => ((isset($_GET['error'])) ? stripslashes(urldecode($_GET['error'])) : IPAYMENT_ERROR_MESSAGE));

      return $error;
    }

    function check() {
      global $store_id;
      
      if (!isset($this->_check)) {
        $check_query = smn_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_IPAYMENT_STATUS' and store_id = '" . $store_id . "'");
        $this->_check = smn_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      global $store_id;
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . $store_id . "', 'Enable iPayment Module', 'MODULE_PAYMENT_IPAYMENT_STATUS', 'True', 'Do you want to accept iPayment payments?', '6', '1', 'smn_cfg_select_option(array(\'True\', \'False\'), ', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . $store_id . "', 'Account Number', 'MODULE_PAYMENT_IPAYMENT_ID', '99999', 'The account number used for the iPayment service', '6', '2', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . $store_id . "', 'User ID', 'MODULE_PAYMENT_IPAYMENT_USER_ID', '99999', 'The user ID for the iPayment service', '6', '3', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . $store_id . "', 'User Password', 'MODULE_PAYMENT_IPAYMENT_PASSWORD', '0', 'The user password for the iPayment service', '6', '4', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . $store_id . "', 'Transaction Currency', 'MODULE_PAYMENT_IPAYMENT_CURRENCY', 'Either EUR or USD, else EUR', 'The currency to use for credit card transactions', '6', '5', 'smn_cfg_select_option(array(\'Always EUR\', \'Always USD\', \'Either EUR or USD, else EUR\', \'Either EUR or USD, else USD\'), ', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . $store_id . "', 'Sort order of display.', 'MODULE_PAYMENT_IPAYMENT_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('" . $store_id . "', 'Payment Zone', 'MODULE_PAYMENT_IPAYMENT_ZONE', '0', 'If a zone is selected, only enable this payment method for that zone.', '6', '2', 'smn_get_zone_class_title', 'smn_cfg_pull_down_zone_classes(', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('" . $store_id . "', 'Set Order Status', 'MODULE_PAYMENT_IPAYMENT_ORDER_STATUS_ID', '0', 'Set the status of orders made with this payment module to this value', '6', '0', 'smn_cfg_pull_down_order_statuses(', 'smn_get_order_status_name', now())");
	  if($store_id==1){
        smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . $store_id . "', 'For Single Checkout?', 'MODULE_PAYMENT_IPAYMENT_SINGLE_CHECKOUT', 'False', 'Use this payment for single checkout?', '6', '2', 'smn_cfg_select_option(array(\'True\', \'False\'), ', now())");
	  }
    }

    function remove() {
      global $store_id;
      smn_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "') and store_id = '" . $store_id . "'");
    }

    function keys() {
	  global $store_id;
	   $key_array = array('MODULE_PAYMENT_IPAYMENT_STATUS', 'MODULE_PAYMENT_IPAYMENT_ID', 'MODULE_PAYMENT_IPAYMENT_USER_ID', 'MODULE_PAYMENT_IPAYMENT_PASSWORD', 'MODULE_PAYMENT_IPAYMENT_CURRENCY', 'MODULE_PAYMENT_IPAYMENT_ZONE', 'MODULE_PAYMENT_IPAYMENT_ORDER_STATUS_ID', 'MODULE_PAYMENT_IPAYMENT_SORT_ORDER');
	   if($store_id==1){
	   	$key_array = array_merge($key_array,array('MODULE_PAYMENT_IPAYMENT_SINGLE_CHECKOUT'));
	   }
      return $key_array;
    }
  }
?>
