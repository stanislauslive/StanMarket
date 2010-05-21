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

  class ups {
    var $code, $title, $descrption, $icon, $enabled, $types;

// class constructor
    function ups() {
      
      global $store_id, $order;

      $this->code = 'ups';
      $this->title = MODULE_SHIPPING_UPS_TEXT_TITLE;
      $this->description = MODULE_SHIPPING_UPS_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_UPS_SORT_ORDER;
      $this->icon = DIR_WS_ICONS . 'shipping_ups.gif';
      $this->tax_class = MODULE_SHIPPING_UPS_TAX_CLASS;
      $this->enabled = ((MODULE_SHIPPING_UPS_STATUS == 'True') ? true : false);

      if ( ($this->enabled == true) && ((int)MODULE_SHIPPING_UPS_ZONE > 0) ) {
        $check_flag = false;
        $check_query = smn_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_SHIPPING_UPS_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' and store_id = '" . $store_id . "' order by zone_id");
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

      $this->types = array('1DM' => 'Next Day Air Early AM',
                           '1DML' => 'Next Day Air Early AM Letter',
                           '1DA' => 'Next Day Air',
                           '1DAL' => 'Next Day Air Letter',
                           '1DAPI' => 'Next Day Air Intra (Puerto Rico)',
                           '1DP' => 'Next Day Air Saver',
                           '1DPL' => 'Next Day Air Saver Letter',
                           '2DM' => '2nd Day Air AM',
                           '2DML' => '2nd Day Air AM Letter',
                           '2DA' => '2nd Day Air',
                           '2DAL' => '2nd Day Air Letter',
                           '3DS' => '3 Day Select',
                           'GND' => 'Ground',
                           'GNDCOM' => 'Ground Commercial',
                           'GNDRES' => 'Ground Residential',
                           'STD' => 'Canada Standard',
                           'XPR' => 'Worldwide Express',
                           'XPRL' => 'worldwide Express Letter',
                           'XDM' => 'Worldwide Express Plus',
                           'XDML' => 'Worldwide Express Plus Letter',
                           'XPD' => 'Worldwide Expedited');
    }

// class methods
    function quote($method = '') {
/*Declared $cart as global, by Cimi*/
      global $_POST, $order, $shipping_weight, $shipping_num_boxes,$cart;
	  global $store;

      if ( (smn_not_null($method)) && (isset($this->types[$method])) ) {
        $prod = $method;
      } else {
        $prod = 'GNDRES';
      }
	
      if ($method) $this->_upsAction('3'); // return a single quote

      $this->_upsProduct($prod);

/*Changed the code to manage single checkout, By Cimi*/
     /* $country_name = smn_get_countries($store->get_shipping_origin_country(), true);
      $this->_upsOrigin($store->get_shipping_origin_zip(), $country_name['countries_iso_code_2']);
      $this->_upsDest($order->delivery['postcode'], $order->delivery['country']['iso_code_2']);
      $this->_upsRate(MODULE_SHIPPING_UPS_PICKUP);
      $this->_upsContainer(MODULE_SHIPPING_UPS_PACKAGE);
      $this->_upsWeight($shipping_weight);
      $this->_upsRescom(MODULE_SHIPPING_UPS_RES);
      $upsQuote = $this->_upsGetQuote();*/
	  if(ALLOW_STORE_PAYMENT=='true'){
      $country_name = smn_get_countries($store->get_shipping_origin_country(), true);
      $this->_upsOrigin($store->get_shipping_origin_zip(), $country_name['countries_iso_code_2']);
      $this->_upsDest($order->delivery['postcode'], $order->delivery['country']['iso_code_2']);
      $this->_upsRate(MODULE_SHIPPING_UPS_PICKUP);
      $this->_upsContainer(MODULE_SHIPPING_UPS_PACKAGE);
      $this->_upsWeight($shipping_weight);
      $this->_upsRescom(MODULE_SHIPPING_UPS_RES);
      $upsQuote = $this->_upsGetQuote();
	  }else{
	  $store_list = $cart->get_store_list();
	  	for($k=0;$k<sizeof($store_list);$k++){
      	  $country_name = smn_get_countries($cart->get_cart_store_country($store_list[$k]), true);
		  $this->_upsOrigin($cart->get_cart_store_zip($store_list[$k]), $country_name['countries_iso_code_2']);
		  $this->_upsDest($order->delivery['postcode'], $order->delivery['country']['iso_code_2']);
		  $this->_upsRate(MODULE_SHIPPING_UPS_PICKUP);
		  $this->_upsContainer(MODULE_SHIPPING_UPS_PACKAGE);
		  $this->_upsWeight($shipping_weight);
		  $this->_upsRescom(MODULE_SHIPPING_UPS_RES);
		  $upsQuote = $this->_upsGetQuote();
		  if(count($prev_array) && is_array($prev_array))
		  {
		  foreach($prev_array as $key=>$value)
		  {
		  	foreach($value as $key1=>$val)
			{
				$prev_array[$key][$key1] = $prev_array[$key][$key1]+$upsQuote[$key][$key1];
			}
		  }
		  }
		  else
		  {
		  $prev_array = $upsQuote;
		  }
	  	}
		$upsQuote = $prev_array;
	  }
      if ( (is_array($upsQuote)) && (sizeof($upsQuote) > 0) ) {
        $this->quotes = array('id' => $this->code,
                              'module' => $this->title . ' (' . $shipping_num_boxes . ' x ' . $shipping_weight . 'lbs)');

        $methods = array();
        $qsize = sizeof($upsQuote);
        for ($i=0; $i<$qsize; $i++) {
          list($type, $cost) = each($upsQuote[$i]);
          $methods[] = array('id' => $type,
                             'title' => $this->types[$type],
                             'cost' => ($cost + MODULE_SHIPPING_UPS_HANDLING) * $shipping_num_boxes);
        }

        $this->quotes['methods'] = $methods;

        if ($this->tax_class > 0) {
          $this->quotes['tax'] = smn_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
        }
      } else {
        $this->quotes = array('module' => $this->title,
                              'error' => 'An error occured with the UPS shipping calculations.<br>' . $upsQuote . '<br>If you prefer to use UPS as your shipping method, please contact the store owner.');
      }

      if (smn_not_null($this->icon)) $this->quotes['icon'] = smn_image($this->icon, $this->title);

      return $this->quotes;
    }
	
	/*Added the function to get the shipping charge of each store separately,By Cimi*/
	function quote_store($method = '') {
      global $_POST, $order, $shipping_weight, $shipping_num_boxes,$cart;
	  global $store;

      if ( (smn_not_null($method)) && (isset($this->types[$method])) ) {
        $prod = $method;
      } else {
        $prod = 'GNDRES';
      }
	
      if ($method) $this->_upsAction('3'); // return a single quote

      $this->_upsProduct($prod);

	  $store_list = $cart->get_store_list();
	  	for($k=0;$k<sizeof($store_list);$k++){
      	  $country_name = smn_get_countries($cart->get_cart_store_country($store_list[$k]), true);
		  $this->_upsOrigin($cart->get_cart_store_zip($store_list[$k]), $country_name['countries_iso_code_2']);
		  $this->_upsDest($order->delivery['postcode'], $order->delivery['country']['iso_code_2']);
		  $this->_upsRate(MODULE_SHIPPING_UPS_PICKUP);
		  $this->_upsContainer(MODULE_SHIPPING_UPS_PACKAGE);
		  $this->_upsWeight($shipping_weight);
		  $this->_upsRescom(MODULE_SHIPPING_UPS_RES);
		  $upsQuote[$store_list[$k]] = $this->_upsGetQuote();
		}
		foreach($upsQuote as $key=>$value){ 
		  if ( (is_array($value)) && (sizeof($value) > 0) ) {
			$this->quotes_store[$key] = array('id' => $this->code,
								  'module' => $this->title . ' (' . $shipping_num_boxes . ' x ' . $shipping_weight . 'lbs)');
			$methods = array();
			$qsize = sizeof($value);
			for ($i=0; $i<$qsize; $i++) {
			  list($type, $cost) = each($value[$i]);
			  $methods[] = array('id' => $type,
								 'title' => $this->types[$type],
								 'cost' => ($cost + MODULE_SHIPPING_UPS_HANDLING) * $shipping_num_boxes);
			}
        $this->quotes_store[$key]['methods'] = $methods;
        if ($this->tax_class > 0) {
          $this->quotes_store[$key]['tax'] = smn_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
        }
       		}
else {
        $this->quotes_store[$key] = array('module' => $this->title,
                              'error' => 'An error occured with the UPS shipping calculations.<br>' . $upsQuote . '<br>If you prefer to use UPS as your shipping method, please contact the store owner.');
      }

      if (smn_not_null($this->icon)) $this->quotes_store[$key]['icon'] = smn_image($this->icon, $this->title);
	  }
      return $this->quotes_store;
    }

    function check() {
      global $store_id;
      if (!isset($this->_check)) {
        $check_query = smn_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_UPS_STATUS' and store_id = '" . $store_id . "'");
        $this->_check = smn_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      global $store_id;
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . $store_id . "', 'Enable UPS Shipping', 'MODULE_SHIPPING_UPS_STATUS', 'True', 'Do you want to offer UPS shipping?', '6', '0', 'smn_cfg_select_option(array(\'True\', \'False\'), ', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . $store_id . "', 'UPS Pickup Method', 'MODULE_SHIPPING_UPS_PICKUP', 'CC', 'How do you give packages to UPS? CC - Customer Counter, RDP - Daily Pickup, OTP - One Time Pickup, LC - Letter Center, OCA - On Call Air', '6', '0', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . $store_id . "', 'UPS Packaging?', 'MODULE_SHIPPING_UPS_PACKAGE', 'CP', 'CP - Your Packaging, ULE - UPS Letter, UT - UPS Tube, UBE - UPS Express Box', '6', '0', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . $store_id . "', 'Residential Delivery?', 'MODULE_SHIPPING_UPS_RES', 'RES', 'Quote for Residential (RES) or Commercial Delivery (COM)', '6', '0', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . $store_id . "', 'Handling Fee', 'MODULE_SHIPPING_UPS_HANDLING', '0', 'Handling fee for this shipping method.', '6', '0', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('" . $store_id . "', 'Tax Class', 'MODULE_SHIPPING_UPS_TAX_CLASS', '0', 'Use the following tax class on the shipping fee.', '6', '0', 'smn_get_tax_class_title', 'smn_cfg_pull_down_tax_classes(', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('" . $store_id . "', 'Shipping Zone', 'MODULE_SHIPPING_UPS_ZONE', '0', 'If a zone is selected, only enable this shipping method for that zone.', '6', '0', 'smn_get_zone_class_title', 'smn_cfg_pull_down_zone_classes(', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . $store_id . "', 'Sort order of display.', 'MODULE_SHIPPING_UPS_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
    }

    function remove() {
      global $store_id;
      smn_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "') and store_id = '" . $store_id . "'");
    }

    function keys() {
      return array('MODULE_SHIPPING_UPS_STATUS', 'MODULE_SHIPPING_UPS_PICKUP', 'MODULE_SHIPPING_UPS_PACKAGE', 'MODULE_SHIPPING_UPS_RES', 'MODULE_SHIPPING_UPS_HANDLING', 'MODULE_SHIPPING_UPS_TAX_CLASS', 'MODULE_SHIPPING_UPS_ZONE', 'MODULE_SHIPPING_UPS_SORT_ORDER');
    }

    function _upsProduct($prod){
      $this->_upsProductCode = $prod;
    }

    function _upsOrigin($postal, $country){
      $this->_upsOriginPostalCode = $postal;
      $this->_upsOriginCountryCode = $country;
    }

    function _upsDest($postal, $country){
      $postal = str_replace(' ', '', $postal);

      if ($country == 'US') {
        $this->_upsDestPostalCode = substr($postal, 0, 5);
      } else {
        $this->_upsDestPostalCode = $postal;
      }

      $this->_upsDestCountryCode = $country;
    }

    function _upsRate($foo) {
      switch ($foo) {
        case 'RDP':
          $this->_upsRateCode = 'Regular+Daily+Pickup';
          break;
        case 'OCA':
          $this->_upsRateCode = 'On+Call+Air';
          break;
        case 'OTP':
          $this->_upsRateCode = 'One+Time+Pickup';
          break;
        case 'LC':
          $this->_upsRateCode = 'Letter+Center';
          break;
        case 'CC':
          $this->_upsRateCode = 'Customer+Counter';
          break;
      }
    }

    function _upsContainer($foo) {
      switch ($foo) {
        case 'CP': // Customer Packaging
          $this->_upsContainerCode = '00';
          break;
        case 'ULE': // UPS Letter Envelope
          $this->_upsContainerCode = '01';
          break;
        case 'UT': // UPS Tube
          $this->_upsContainerCode = '03';
          break;
        case 'UEB': // UPS Express Box
          $this->_upsContainerCode = '21';
          break;
        case 'UW25': // UPS Worldwide 25 kilo
          $this->_upsContainerCode = '24';
          break;
        case 'UW10': // UPS Worldwide 10 kilo
          $this->_upsContainerCode = '25';
          break;
      }
    }

    function _upsWeight($foo) {
      $this->_upsPackageWeight = $foo;
    }

    function _upsRescom($foo) {
      switch ($foo) {
        case 'RES': // Residential Address
          $this->_upsResComCode = '1';
          break;
        case 'COM': // Commercial Address
          $this->_upsResComCode = '2';
          break;
      }
    }

    function _upsAction($action) {
      /* 3 - Single Quote
         4 - All Available Quotes */

      $this->_upsActionCode = $action;
    }

    function _upsGetQuote() {
      if (!isset($this->_upsActionCode)) $this->_upsActionCode = '4';

      $request = join('&', array('accept_UPS_license_agreement=yes',
                                 '10_action=' . $this->_upsActionCode,
                                 '13_product=' . $this->_upsProductCode,
                                 '14_origCountry=' . $this->_upsOriginCountryCode,
                                 '15_origPostal=' . $this->_upsOriginPostalCode,
                                 '19_destPostal=' . $this->_upsDestPostalCode,
                                 '22_destCountry=' . $this->_upsDestCountryCode,
                                 '23_weight=' . $this->_upsPackageWeight,
                                 '47_rate_chart=' . $this->_upsRateCode,
                                 '48_container=' . $this->_upsContainerCode,
                                 '49_residential=' . $this->_upsResComCode));
								 
      $http = new httpClient();
      if ($http->Connect('www.ups.com', 80)) {
        $http->addHeader('Host', 'www.ups.com');
        $http->addHeader('User-Agent', 'oscMall');
        $http->addHeader('Connection', 'Close');

        if ($http->Get('/using/services/rave/qcostcgi.cgi?' . $request)) $body = $http->getBody();

        $http->Disconnect();
      } else {
        return 'error';
      }

      $body_array = explode("\n", $body);

      $returnval = array();
      $errorret = 'error'; // only return error if NO rates returned

      $n = sizeof($body_array);
      for ($i=0; $i<$n; $i++) {
        $result = explode('%', $body_array[$i]);
        $errcode = substr($result[0], -1);
        switch ($errcode) {
          case 3:
            if (is_array($returnval)) $returnval[] = array($result[1] => $result[8]);
            break;
          case 4:
            if (is_array($returnval)) $returnval[] = array($result[1] => $result[8]);
            break;
          case 5:
            $errorret = $result[1];
            break;
          case 6:
            if (is_array($returnval)) $returnval[] = array($result[3] => $result[10]);
            break;
        }
      }
      if (empty($returnval)) $returnval = $errorret;

      return $returnval;
    }
  }
?>