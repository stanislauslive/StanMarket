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

  class nochex {
    var $code, $title, $description, $enabled;

// class constructor
    function nochex() {
      global $order;

      $this->code = 'nochex';
      $this->title = MODULE_PAYMENT_NOCHEX_TEXT_TITLE;
      $this->description = MODULE_PAYMENT_NOCHEX_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_PAYMENT_NOCHEX_SORT_ORDER;
      $this->enabled = ((MODULE_PAYMENT_NOCHEX_STATUS == 'True') ? true : false);
	  $this->single = ((MODULE_PAYMENT_NOCHEX_SINGLE_CHECKOUT == 'True') ? true : false);

      if ((int)MODULE_PAYMENT_NOCHEX_ORDER_STATUS_ID > 0) {
        $this->order_status = MODULE_PAYMENT_NOCHEX_ORDER_STATUS_ID;
      }

      if (is_object($order)) $this->update_status();

      $this->form_action_url = 'https://www.nochex.com/nochex.dll/checkout';
    }

// class methods
    function update_status() {
      global $order, $store_id;

      if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_NOCHEX_ZONE > 0) ) {
        $check_flag = false;
        $check_query = smn_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_NOCHEX_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' and store_id = '" . $store_id . "' order by zone_id");
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
      return false;
    }

    function selection() {
      return array('id' => $this->code,
                   'module' => $this->title);
    }

    function pre_confirmation_check() {
      return false;
    }

    function confirmation() {
      return false;
    }

    function process_button() {
      global $order, $currencies, $customer_id;

      $process_button_string = smn_draw_hidden_field('cmd', '_xclick') .
                               smn_draw_hidden_field('email', MODULE_PAYMENT_NOCHEX_ID) .
                               smn_draw_hidden_field('amount', number_format($order->info['total'] * $currencies->currencies['GBP']['value'], $currencies->currencies['GBP']['decimal_places'])) .
                               smn_draw_hidden_field('ordernumber', $customer_id . '-' . date('Ymdhis')) .
                               smn_draw_hidden_field('returnurl', smn_href_link(FILENAME_CHECKOUT_PROCESS, '', 'NONSSL')) .
                               smn_draw_hidden_field('cancel_return', smn_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'NONSSL'));

      return $process_button_string;
    }

    function before_process() {
      return false;
    }
	
    function after_process() {
      return false;
    }

    function output_error() {
      return false;
    }

    function check() {
      global $store_id;
      
      if (!isset($this->_check)) {
        $check_query = smn_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_NOCHEX_STATUS' and store_id = '" . $store_id . "'");
        $this->_check = smn_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      global $store_id;
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . $store_id . "', 'Enable NOCHEX Module', 'MODULE_PAYMENT_NOCHEX_STATUS', 'True', 'Do you want to accept NOCHEX payments?', '6', '3', 'smn_cfg_select_option(array(\'True\', \'False\'), ', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . $store_id . "', 'E-Mail Address', 'MODULE_PAYMENT_NOCHEX_ID', 'you@yourbuisness.com', 'The e-mail address to use for the NOCHEX service', '6', '4', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . $store_id . "', 'Sort order of display.', 'MODULE_PAYMENT_NOCHEX_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('" . $store_id . "', 'Payment Zone', 'MODULE_PAYMENT_NOCHEX_ZONE', '0', 'If a zone is selected, only enable this payment method for that zone.', '6', '2', 'smn_get_zone_class_title', 'smn_cfg_pull_down_zone_classes(', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('" . $store_id . "', 'Set Order Status', 'MODULE_PAYMENT_NOCHEX_ORDER_STATUS_ID', '0', 'Set the status of orders made with this payment module to this value', '6', '0', 'smn_cfg_pull_down_order_statuses(', 'smn_get_order_status_name', now())");
	  if($store_id==1){
        smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . $store_id . "', 'For Single Checkout?', 'MODULE_PAYMENT_NOCHEX_SINGLE_CHECKOUT', 'False', 'Use this payment for single checkout?', '6', '2', 'smn_cfg_select_option(array(\'True\', \'False\'), ', now())");
	  }
    }

    function remove() {
      global $store_id;
      smn_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "') and store_id = '" . $store_id . "'");
    }

    function keys() {
	  global $store_id;
	   $key_array = array('MODULE_PAYMENT_NOCHEX_STATUS', 'MODULE_PAYMENT_NOCHEX_ID', 'MODULE_PAYMENT_NOCHEX_ZONE', 'MODULE_PAYMENT_NOCHEX_ORDER_STATUS_ID', 'MODULE_PAYMENT_NOCHEX_SORT_ORDER');
	   if($store_id==1){
	   	$key_array = array_merge($key_array,array('MODULE_PAYMENT_NOCHEX_SINGLE_CHECKOUT'));
	   }
      return $key_array;
    }
  }
?>
