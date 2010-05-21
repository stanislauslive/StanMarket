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
class freeamount {
    var $code, $title, $description, $icon, $enabled;// class constructor
    
        function freeamount() {
          global $store_id, $order;
            $this->code = 'freeamount';
            $this->title = MODULE_SHIPPING_FREEAMOUNT_TEXT_TITLE;
            $this->description = MODULE_SHIPPING_FREEAMOUNT_TEXT_DESCRIPTION;
            $this->sort_order = MODULE_SHIPPING_FREEAMOUNT_SORT_ORDER;
            $this->icon ='';
            $this->enabled = ((MODULE_SHIPPING_FREEAMOUNT_STATUS == 'True') ? true : false);
            if ( ($this->enabled == true) && ((int)MODULE_SHIPPING_FREEAMOUNT_ZONE > 0) ) {
                $check_flag = false;
                $check_query = smn_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_SHIPPING_FREEAMOUNT_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' and store_id = '" . $store_id . "' order by zone_id");
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
        }// class methods
        
        function quote($method = '') {
            global $order, $cart, $shipping_weight;
            $dest_country = $order->delivery['country']['id'];
            $currency = $order->info['currency'];
            if ($shipping_weight > MODULE_SHIPPING_FREEAMOUNT_WEIGHT_MAX)
                $this->quotes['error'] = MODULE_SHIPPING_FREEAMOUNT_TEXT_TO_HEIGHT . ' (' . $shipping_weight . ') ' . MODULE_SHIPPING_FREEAMOUNT_TEXT_UNIT;
            if ($cart->show_total() < MODULE_SHIPPING_FREEAMOUNT_AMOUNT) {
                if (MODULE_SHIPPING_FREEAMOUNT_DISPLAY == 'False')
                return;
            else $this->quotes['error'] = MODULE_SHIPPING_FREEAMOUNT_TEXT_ERROR;
            } else
                $this->quotes = array('id' => $this->code,
                                      'module' => MODULE_SHIPPING_FREEAMOUNT_TEXT_TITLE,
                                      'methods' => array(array('id' => $this->code,
                                      'title' => MODULE_SHIPPING_FREEAMOUNT_TEXT_WAY,
                                      'cost' => MODULE_SHIPPING_FREEAMOUNT_COST)));
                                      
            if (smn_not_null($this->icon))
            $this->quotes['icon'] = smn_image($this->icon, $this->title);
            return $this->quotes;
        }
        
        function check() {
      global $store_id;
            if (!isset($this->_check)) {
                $check_query = smn_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_FREEAMOUNT_STATUS' and store_id = '" . $store_id . "'");
                $this->_check = smn_db_num_rows($check_query);
                }
                return $this->_check;
        }
        
        function install() {
            global $store_id;
            smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . $store_id . "', 'Enable Free Shipping with Minimum Purchase', 'MODULE_SHIPPING_FREEAMOUNT_STATUS', 'True', 'Do you want to offer minimum order free shipping?', '6', '7', 'smn_cfg_select_option(array(\'True\', \'False\'), ', now())");
            smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id,  sort_order, date_added) values ('" . $store_id . "', 'Maximum Weight', 'MODULE_SHIPPING_FREEAMOUNT_WEIGHT_MAX', '10', 'What is the maximum weight you will ship?', '6', '8', now())");
            smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . $store_id . "', 'Enable Display', 'MODULE_SHIPPING_FREEAMOUNT_DISPLAY', 'True', 'Do you want to display text way if the minimum amount is not reached?', '6', '7', 'smn_cfg_select_option(array(\'True\', \'False\'), ', now())");
            smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id,  sort_order, date_added) values ('" . $store_id . "', 'Minimum Cost', 'MODULE_SHIPPING_FREEAMOUNT_AMOUNT', '50.00', 'Minimum order amount purchased before shipping is free?', '6', '8', now())");
            smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . $store_id . "', 'Sort Order', 'MODULE_SHIPPING_FREEAMOUNT_SORT_ORDER', '0', 'Sort order of display.', '6', '0', now())");
            smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('" . $store_id . "', 'Shipping Zone', 'MODULE_SHIPPING_FREEAMOUNT_ZONE', '0', 'If a zone is selected, only enable this shipping method for that zone.', '6', '0', 'smn_get_zone_class_title', 'smn_cfg_pull_down_zone_classes(', now())");
        }
        function remove() {
            global $store_id;  
            smn_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "') and store_id = '" . $store_id . "'");
        }
        
        function keys() {
            return array('MODULE_SHIPPING_FREEAMOUNT_STATUS', 'MODULE_SHIPPING_FREEAMOUNT_WEIGHT_MAX', 'MODULE_SHIPPING_FREEAMOUNT_SORT_ORDER', 'MODULE_SHIPPING_FREEAMOUNT_DISPLAY', 'MODULE_SHIPPING_FREEAMOUNT_AMOUNT', 'MODULE_SHIPPING_FREEAMOUNT_ZONE');
        }
    }
?>