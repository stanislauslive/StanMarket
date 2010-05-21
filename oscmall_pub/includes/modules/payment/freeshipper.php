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

  class freeshipper {
    var $code, $title, $description, $icon, $enabled;

// BOF: WebMakers.com Added: Free Payments and Shipping
// class constructor
    function freeshipper() {
      global $order, $cart;
      $this->code = 'freeshipper';
      $this->title = MODULE_SHIPPING_FREESHIPPER_TEXT_TITLE;
      $this->description = MODULE_SHIPPING_FREESHIPPER_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_FREESHIPPER_SORT_ORDER;
      $this->icon = DIR_WS_ICONS . 'shipping_free_shipper.jpg';
      $this->tax_class = MODULE_SHIPPING_FREESHIPPER_TAX_CLASS;
      $this->enabled = ((MODULE_SHIPPING_FREESHIPPER_STATUS == 'True') ? true : false);
	  $this->single = ((MODULE_SHIPPING_FREESHIPPER_SINGLE_CHECKOUT == 'True') ? true : false);

// Only show if weight is 0
//      if ( (!strstr($PHP_SELF,'modules.php')) || $cart->show_weight()==0) {
        $this->enabled = MODULE_SHIPPING_FREESHIPPER_STATUS;
        if ( ($this->enabled == true) && ((int)MODULE_SHIPPING_FREESHIPPER_ZONE > 0) ) {
          $check_flag = false;
          $check_query = smn_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_SHIPPING_FREESHIPPER_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' and store_id = '" . $store_id . "' order by zone_id");
          while ($check = smn_db_fetch_array($check_query)) {
            if ($check['zone_id'] < 1) {
              $check_flag = true;
              break;
            } elseif ($check['zone_id'] == $order->delivery['zone_id']) {
              $check_flag = true;
              break;
            }
          }

          if ($check_flag == false) {
            $this->enabled = false;
          }
        }
//      }
// EOF: WebMakers.com Added: Free Payments and Shipping
    }

// class methods
    function quote($method = '') {
      global $order;

      $this->quotes = array('id' => $this->code,
                            'module' => MODULE_SHIPPING_FREESHIPPER_TEXT_TITLE,
                            'methods' => array(array('id' => $this->code,
                                                     'title' => '<FONT COLOR=FF0000><B>' . MODULE_SHIPPING_FREESHIPPER_TEXT_WAY . '</B></FONT>',
                                                     'cost' => SHIPPING_HANDLING + MODULE_SHIPPING_FREESHIPPER_COST)));

      if ($this->tax_class > 0) {
        $this->quotes['tax'] = smn_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
      }
      if (smn_not_null($this->icon)) $this->quotes['icon'] = smn_image($this->icon, $this->title);

      return $this->quotes;
    }

    function check() {
      global $store_id;
      
      if (!isset($this->_check)) {
        $check_query = smn_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_FREESHIPPER_STATUS' and store_id = '" . $store_id . "'");
        $this->_check = smn_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      global $store_id;
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . $store_id . "', 'Enable Free Shipping', 'MODULE_SHIPPING_FREESHIPPER_STATUS', '1', 'Do you want to offer Free shipping?', '6', '5', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . $store_id . "', 'Free Shipping Cost', 'MODULE_SHIPPING_FREESHIPPER_COST', '0.00', 'What is the Shipping cost? The Handling fee will also be added.', '6', '6', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('" . $store_id . "', 'Tax Class', 'MODULE_SHIPPING_FREESHIPPER_TAX_CLASS', '0', 'Use the following tax class on the shipping fee.', '6', '0', 'smn_get_tax_class_title', 'smn_cfg_pull_down_tax_classes(', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('" . $store_id . "', 'Shipping Zone', 'MODULE_SHIPPING_FREESHIPPER_ZONE', '0', 'If a zone is selected, only enable this shipping method for that zone.', '6', '0', 'smn_get_zone_class_title', 'smn_cfg_pull_down_zone_classes(', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . $store_id . "', 'Sort Order', 'MODULE_SHIPPING_FREESHIPPER_SORT_ORDER', '0', 'Sort order of display.', '6', '0', now())");
	  if($store_id==1){
        smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . $store_id . "', 'For Single Checkout?', 'MODULE_SHIPPING_FREESHIPPER_SINGLE_CHECKOUT',  'False', 'Use this payment for single checkout?', '6', '2', 'smn_cfg_select_option(array(\'True\', \'False\'), ', now());");
	  }
    }

    function remove() {
      global $store_id;
      $keys = '';
      $keys_array = $this->keys();
      for ($i=0; $i<sizeof($keys_array); $i++) {
        $keys .= "'" . $keys_array[$i] . "',";
      }
      $keys = substr($keys, 0, -1);

      smn_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in (" . $keys . ") and store_id = '" . $store_id . "'");
    }
	

    function keys() {
	  global $store_id;
	   $key_array = array('MODULE_SHIPPING_FREESHIPPER_STATUS', 'MODULE_SHIPPING_FREESHIPPER_COST', 'MODULE_SHIPPING_FREESHIPPER_TAX_CLASS', 'MODULE_SHIPPING_FREESHIPPER_ZONE', 'MODULE_SHIPPING_FREESHIPPER_SORT_ORDER');
	   if($store_id==1){
	   	$key_array = array_merge($key_array,array('MODULE_SHIPPING_FREESHIPPER_SINGLE_CHECKOUT'));
	   }
      return $key_array;
    }
  }
?>