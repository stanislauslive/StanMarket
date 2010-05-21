<?php
/*
  WebMakers.com Added: Free Payments and Shipping
  Written by Linda McGrath osCOMMERCE@WebMakers.com
  http://www.thewebmakerscorner.com

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

  class freecharger {
    var $code, $title, $description, $enabled, $payment;

// class constructor
    function freecharger() {
      global $order;
      $this->code = 'freecharger';
      $this->title = MODULE_PAYMENT_FREECHARGER_TEXT_TITLE;
      $this->description = MODULE_PAYMENT_FREECHARGER_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_PAYMENT_FREECHARGER_SORT_ORDER;
      $this->enabled = ((MODULE_PAYMENT_FREECHARGER_STATUS == 'True') ? true : false);
	  $this->single = ((MODULE_PAYMENT_FREECHARGER_SINGLE_CHECKOUT == 'True') ? true : false);

      if ((int)MODULE_PAYMENT_FREECHARGER_ORDER_STATUS_ID > 0) {
        $this->order_status = MODULE_PAYMENT_FREECHARGER_ORDER_STATUS_ID;
        $payment='freecharger';
      } else {
        if ($payment=='freecharger') {
          $payment='';
        }
      }

      if (is_object($order)) $this->update_status();

      $this->email_footer = MODULE_PAYMENT_FREECHARGER_TEXT_EMAIL_FOOTER;
    }

// class methods
    function update_status() {
      global $order;

      if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_FREECHARGER_ZONE > 0) ) {
        $check_flag = false;
        $check_query = smn_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_FREECHARGER_ZONE . "'  and store_id = '" . $store_id . "' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");
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
      return array('title' => MODULE_PAYMENT_FREECHARGER_TEXT_DESCRIPTION);
    }

    function process_button() {
      return false;
    }

    function before_process() {
      return false;
    }
	

    function after_process() {
      return false;
    }

    function get_error() {
      return false;
    }

    function check() {
      global $store_id;
      if (!isset($this->_check)) {
        $check_query = smn_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_FREECHARGER_STATUS' and store_id = '" . $store_id . "'");
        $this->_check = smn_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      global $store_id;
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . $store_id ."', 'Enable Free Charge Module', 'MODULE_PAYMENT_FREECHARGER_STATUS', 'True', 'Do you want to accept Free Charge payments?', '6', '1', 'smn_cfg_select_option(array(\'True\', \'False\'), ', now());");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . $store_id ."', 'Sort order of display.', 'MODULE_PAYMENT_FREECHARGER_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('" . $store_id ."', 'Payment Zone', 'MODULE_PAYMENT_FREECHARGER_ZONE', '0', 'If a zone is selected, only enable this payment method for that zone.', '6', '2', 'smn_get_zone_class_title', 'smn_cfg_pull_down_zone_classes(', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('" . $store_id ."', 'Set Order Status', 'MODULE_PAYMENT_FREECHARGER_ORDER_STATUS_ID', '0', 'Set the status of orders made with this payment module to this value', '6', '0', 'smn_cfg_pull_down_order_statuses(', 'smn_get_order_status_name', now())");
	  if($store_id==1){
        smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . $store_id ."', 'For Single Checkout?', 'MODULE_PAYMENT_FREECHARGER_SINGLE_CHECKOUT', 'False', 'Use this payment for single checkout?', '6', '2', 'smn_cfg_select_option(array(\'True\', \'False\'), ', now());");
	  }
    }

    function remove() {
      global $store_id;
      smn_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "') and store_id = '" . $store_id . "'");
    }

    function keys() {
	  global $store_id;
	   $key_array = array('MODULE_PAYMENT_FREECHARGER_STATUS', 'MODULE_PAYMENT_FREECHARGER_ZONE', 'MODULE_PAYMENT_FREECHARGER_ORDER_STATUS_ID', 'MODULE_PAYMENT_FREECHARGER_SORT_ORDER');
	   if($store_id==1){
	   	$key_array = array_merge($key_array,array('MODULE_PAYMENT_FREECHARGER_SINGLE_CHECKOUT'));
	   }
      return $key_array;
    }
  }
?>