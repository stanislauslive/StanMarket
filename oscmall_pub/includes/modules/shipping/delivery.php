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

  class delivery {
    var $code, $title, $description, $icon, $enabled;

// class constructor
    function delivery() {
      global $store_id, $order;

      $this->code = 'delivery';
      $this->title = MODULE_SHIPPING_DELIVERY_TEXT_TITLE;
      $this->description = MODULE_SHIPPING_DELIVERY_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_DELIVERY_SORT_ORDER;
      $this->icon = '';
      $this->tax_class = MODULE_SHIPPING_DELIVERY_TAX_CLASS;
      $this->enabled = ((MODULE_SHIPPING_DELIVERY_STATUS == 'True') ? true : false);

      if ( ($this->enabled == true) && ((int)MODULE_SHIPPING_DELIVERY_ZONE > 0) ) {
        $check_flag = false;
        $check_query = smn_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_SHIPPING_DELIVERY_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' and store_id = '" . $store_id . "' order by zone_id");
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
    }

// class methods
    function quote($method = '') {
      global $order;

      $this->quotes = array('id' => $this->code,
                            'module' => MODULE_SHIPPING_DELIVERY_TEXT_TITLE,
                            'methods' => array(array('id' => $this->code,
                                                     'title' => MODULE_SHIPPING_DELIVERY_TEXT_WAY,
                                                     'cost' => MODULE_SHIPPING_DELIVERY_COST)));

      if ($this->tax_class > 0) {
        $this->quotes['tax'] = smn_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
      }

      if (smn_not_null($this->icon)) $this->quotes['icon'] = smn_image($this->icon, $this->title);

      return $this->quotes;
    }
	
	 function quote_store($method = '') {
      global $order;

      $this->quotes = array('id' => $this->code,
                            'module' => MODULE_SHIPPING_DELIVERY_TEXT_TITLE,
                            'methods' => array(array('id' => $this->code,
                                                     'title' => MODULE_SHIPPING_DELIVERY_TEXT_WAY,
                                                     'cost' => MODULE_SHIPPING_DELIVERY_COST)));

      if ($this->tax_class > 0) {
        $this->quotes['tax'] = smn_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
      }

      if (smn_not_null($this->icon)) $this->quotes['icon'] = smn_image($this->icon, $this->title);

      return $this->quotes;
    }

    function check() {
      global $store_id;
      if (!isset($this->_check)) {
        $check_query = smn_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_DELIVERY_STATUS' and store_id = '" . $store_id . "'");
        $this->_check = smn_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      global $store_id;
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . $store_id . "', 'Enable delivery Shipping', 'MODULE_SHIPPING_DELIVERY_STATUS', 'True', 'Do you want to offer delivery rate shipping?', '6', '0', 'smn_cfg_select_option(array(\'True\', \'False\'), ', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . $store_id . "', 'Shipping Cost', 'MODULE_SHIPPING_DELIVERY_COST', '5.00', 'The shipping cost for all orders using this shipping method.', '6', '0', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('" . $store_id . "', 'Tax Class', 'MODULE_SHIPPING_DELIVERY_TAX_CLASS', '0', 'Use the following tax class on the shipping fee.', '6', '0', 'smn_get_tax_class_title', 'smn_cfg_pull_down_tax_classes(', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('" . $store_id . "', 'Shipping Zone', 'MODULE_SHIPPING_DELIVERY_ZONE', '0', 'If a zone is selected, only enable this shipping method for that zone.', '6', '0', 'smn_get_zone_class_title', 'smn_cfg_pull_down_zone_classes(', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . $store_id . "', 'Sort Order', 'MODULE_SHIPPING_DELIVERY_SORT_ORDER', '0', 'Sort order of display.', '6', '0', now())");
    }

    function remove() {
      global $store_id;
      smn_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "') and store_id = '" . $store_id . "'");
    }

    function keys() {
      return array('MODULE_SHIPPING_DELIVERY_STATUS', 'MODULE_SHIPPING_DELIVERY_COST', 'MODULE_SHIPPING_DELIVERY_TAX_CLASS', 'MODULE_SHIPPING_DELIVERY_ZONE', 'MODULE_SHIPPING_DELIVERY_SORT_ORDER');
    }
  }
?>
