<?php
/*
  $Id: paypal_ipn.php,v 2.1.0.0 13/01/2007 16:30:28 Edith Karnitsch Exp $

  Copyright (c) 2004 osCommerce
  Released under the GNU General Public License
  
  Original Authors: Harald Ponce de Leon, Mark Evans 
  Updates by PandA.nl, Navyhost, Zoeticlight, David, gravyface, AlexStudio, windfjf and Terra
    
*/

  class paypal_ipn {
    var $code, $title, $description, $enabled, $identifier;

// class constructor
    function paypal_ipn() {
      global $order;

      $this->code = 'paypal_ipn';
      $this->title = MODULE_PAYMENT_PAYPAL_IPN_TEXT_TITLE;
      $this->description = MODULE_PAYMENT_PAYPAL_IPN_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_PAYMENT_PAYPAL_IPN_SORT_ORDER;
      $this->enabled = ((MODULE_PAYMENT_PAYPAL_IPN_STATUS == 'True') ? true : false);
      $this->email_footer = MODULE_PAYMENT_PAYPAL_IPN_TEXT_EMAIL_FOOTER;
      $this->identifier = 'osCommerce PayPal IPN v2.1';
	  $this->single = ((MODULE_PAYMENT_PAYPAL_IPN_SINGLE_CHECKOUT == 'True') ? true : false);

      if ((int)MODULE_PAYMENT_PAYPAL_IPN_PREPARE_ORDER_STATUS_ID > 0) {
        $this->order_status = MODULE_PAYMENT_PAYPAL_IPN_PREPARE_ORDER_STATUS_ID;
      }

      if (is_object($order)) $this->update_status();

      if (MODULE_PAYMENT_PAYPAL_IPN_GATEWAY_SERVER == 'Live') {
        $this->form_action_url = 'https://www.paypal.com/cgi-bin/webscr';
      } else {
        $this->form_action_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
      }
    }

// class methods
    function update_status() {
      global $order;

      if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_PAYPAL_IPN_ZONE > 0) ) {
        $check_flag = false;
        $check_query = smn_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_PAYPAL_IPN_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");
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
      global $cartID, $cart_PayPal_IPN_ID, $customer_id, $languages_id, $order, $order_total_modules,$store_id,$cart;

      $insert_order = true;

        if ($insert_order == true) {
          $order_totals = array();
          if (is_array($order_total_modules->modules)) {
            reset($order_total_modules->modules);
            while (list(, $value) = each($order_total_modules->modules)) {
              $class = substr($value, 0, strrpos($value, '.'));
              if ($GLOBALS[$class]->enabled) {
                for ($i=0, $n=sizeof($GLOBALS[$class]->output); $i<$n; $i++) {
                  if (smn_not_null($GLOBALS[$class]->output[$i]['title']) && smn_not_null($GLOBALS[$class]->output[$i]['text'])) {
                    $order_totals[] = array('code' => $GLOBALS[$class]->code,
                                            'title' => $GLOBALS[$class]->output[$i]['title'],
                                            'text' => $GLOBALS[$class]->output[$i]['text'],
                                            'value' => $GLOBALS[$class]->output[$i]['value'],
                                            'sort_order' => $GLOBALS[$class]->sort_order);
                  }
                }
              }
            }
          }
         if(ALLOW_STORE_PAYMENT=='true'){
				  $sql_data_array = array('store_id' => $store_id,
										  'customers_id' => $customer_id,
										  'customers_name' => $order->customer['firstname'] . ' ' . $order->customer['lastname'],
										  'customers_company' => $order->customer['company'],
										  'customers_street_address' => $order->customer['street_address'],
										  'customers_city' => $order->customer['city'],
										  'customers_postcode' => $order->customer['postcode'],
										  'customers_state' => $order->customer['state'],
										  'customers_country' => $order->customer['country']['title'],
										  'customers_telephone' => $order->customer['telephone'],
										  'customers_email_address' => $order->customer['email_address'],
										  'customers_address_format_id' => $order->customer['format_id'],
										  'delivery_name' => $order->delivery['firstname'] . ' ' . $order->delivery['lastname'],
										  'delivery_company' => $order->delivery['company'],
										  'delivery_street_address' => $order->delivery['street_address'],
										  'delivery_city' => $order->delivery['city'],
										  'delivery_postcode' => $order->delivery['postcode'],
										  'delivery_state' => $order->delivery['state'],
										  'delivery_country' => $order->delivery['country']['title'],
										  'delivery_address_format_id' => $order->delivery['format_id'],
										  'billing_name' => $order->billing['firstname'] . ' ' . $order->billing['lastname'],
										  'billing_company' => $order->billing['company'],
										  'billing_street_address' => $order->billing['street_address'],
										  'billing_city' => $order->billing['city'],
										  'billing_postcode' => $order->billing['postcode'],
										  'billing_state' => $order->billing['state'],
										  'billing_country' => $order->billing['country']['title'],
										  'billing_address_format_id' => $order->billing['format_id'],
										  'payment_method' => $order->info['payment_method'],
										  'cc_type' => $order->info['cc_type'],
										  'cc_owner' => $order->info['cc_owner'],
										  'cc_number' => $order->info['cc_number'],
										  'cc_expires' => $order->info['cc_expires'],
										  'date_purchased' => 'now()',
										  'orders_status' => $order->info['order_status'],
										  'currency' => $order->info['currency'],
										  'currency_value' => $order->info['currency_value']);
		
				  //+1.4
				  if ( $update_order ){ 
					smn_db_perform(TABLE_ORDERS, $sql_data_array, 'update', 'orders_id = "' . (int)$order_id . '"');
					$insert_id = (int)$order_id;
				  } else { 
				  //-1.4
				  smn_db_perform(TABLE_ORDERS, $sql_data_array);
		
				  $insert_id = smn_db_insert_id();
				  }//1.4
				  $orders_invoice_id =  $insert_id;
				  for ($i=0, $n=sizeof($order_totals); $i<$n; $i++) {
					$sql_data_array = array('orders_id' => $insert_id,
											'title' => $order_totals[$i]['title'],
											'text' => $order_totals[$i]['text'],
											'value' => $order_totals[$i]['value'],
											'class' => $order_totals[$i]['code'],
											'sort_order' => $order_totals[$i]['sort_order']);
		
					smn_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);
				  }
				  //+1.4
				  $sql_data_array = array('orders_id' => $insert_id, 
											'orders_status_id' => $order->info['order_status'], 
											'date_added' => 'now()', 
								 'customer_notified' => '0', 
											'comments' => $order->info['comments']);
				  smn_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);
				  //-1.4
		
				  for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
				  if($order->products[$i]['products_store_id']==$store_id){
					$sql_data_array = array('orders_id' => $insert_id,
											'products_id' => smn_get_prid($order->products[$i]['id']),
											'products_model' => $order->products[$i]['model'],
											'products_name' => $order->products[$i]['name'],
											'products_price' => $order->products[$i]['price'],
											'final_price' => $order->products[$i]['final_price'],
											'products_tax' => $order->products[$i]['tax'],
											'products_quantity' => $order->products[$i]['qty']);
		
					smn_db_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array);
		
					$order_products_id = smn_db_insert_id();
		
					$attributes_exist = '0';
					if (isset($order->products[$i]['attributes'])) {
					  $attributes_exist = '1';
					  for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {
						if (DOWNLOAD_ENABLED == 'true') {
						  $attributes_query = "select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix, pad.products_attributes_maxdays, pad.products_attributes_maxcount , pad.products_attributes_filename
											   from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa
											   left join " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad
											   on pa.products_attributes_id=pad.products_attributes_id
											   where pa.products_id = '" . $order->products[$i]['id'] . "'
											   and pa.options_id = '" . $order->products[$i]['attributes'][$j]['option_id'] . "'
											   and pa.options_id = popt.products_options_id
											   and pa.options_values_id = '" . $order->products[$i]['attributes'][$j]['value_id'] . "'
											   and pa.options_values_id = poval.products_options_values_id
											   and popt.language_id = '" . $languages_id . "'
											   and poval.language_id = '" . $languages_id . "'";
						  $attributes = smn_db_query($attributes_query);
						} else {
						  $attributes = smn_db_query("select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa where pa.products_id = '" . $order->products[$i]['id'] . "' and pa.options_id = '" . $order->products[$i]['attributes'][$j]['option_id'] . "' and pa.options_id = popt.products_options_id and pa.options_values_id = '" . $order->products[$i]['attributes'][$j]['value_id'] . "' and pa.options_values_id = poval.products_options_values_id and popt.language_id = '" . $languages_id . "' and poval.language_id = '" . $languages_id . "'");
						}
						$attributes_values = smn_db_fetch_array($attributes);
		
						$sql_data_array = array('orders_id' => $insert_id,
												'orders_products_id' => $order_products_id,
												'products_options' => $attributes_values['products_options_name'],
												'products_options_values' => $attributes_values['products_options_values_name'],
												'options_values_price' => $attributes_values['options_values_price'],
												'price_prefix' => $attributes_values['price_prefix']);
		
						smn_db_perform(TABLE_ORDERS_PRODUCTS_ATTRIBUTES, $sql_data_array);
		
						if ((DOWNLOAD_ENABLED == 'true') && isset($attributes_values['products_attributes_filename']) && smn_not_null($attributes_values['products_attributes_filename'])) {
						  $sql_data_array = array('orders_id' => $insert_id,
												  'orders_products_id' => $order_products_id,
												  'orders_products_filename' => $attributes_values['products_attributes_filename'],
												  'download_maxdays' => $attributes_values['products_attributes_maxdays'],
												  'download_count' => $attributes_values['products_attributes_maxcount']);
		
						  smn_db_perform(TABLE_ORDERS_PRODUCTS_DOWNLOAD, $sql_data_array);
						}
					  }
					}
				  }
				  }
						  
						  }else{
			$store_list = $cart->get_store_list();
			$orders_invoice_id = '';
			for( $k=0; $k< sizeof($store_list); $k++) {	
				  $sql_data_array = array('store_id' => $store_list[$k],
										  'customers_id' => $customer_id,
										  'customers_name' => $order->customer['firstname'] . ' ' . $order->customer['lastname'],
										  'customers_company' => $order->customer['company'],
										  'customers_street_address' => $order->customer['street_address'],
										  'customers_city' => $order->customer['city'],
										  'customers_postcode' => $order->customer['postcode'],
										  'customers_state' => $order->customer['state'],
										  'customers_country' => $order->customer['country']['title'],
										  'customers_telephone' => $order->customer['telephone'],
										  'customers_email_address' => $order->customer['email_address'],
										  'customers_address_format_id' => $order->customer['format_id'],
										  'delivery_name' => $order->delivery['firstname'] . ' ' . $order->delivery['lastname'],
										  'delivery_company' => $order->delivery['company'],
										  'delivery_street_address' => $order->delivery['street_address'],
										  'delivery_city' => $order->delivery['city'],
										  'delivery_postcode' => $order->delivery['postcode'],
										  'delivery_state' => $order->delivery['state'],
										  'delivery_country' => $order->delivery['country']['title'],
										  'delivery_address_format_id' => $order->delivery['format_id'],
										  'billing_name' => $order->billing['firstname'] . ' ' . $order->billing['lastname'],
										  'billing_company' => $order->billing['company'],
										  'billing_street_address' => $order->billing['street_address'],
										  'billing_city' => $order->billing['city'],
										  'billing_postcode' => $order->billing['postcode'],
										  'billing_state' => $order->billing['state'],
										  'billing_country' => $order->billing['country']['title'],
										  'billing_address_format_id' => $order->billing['format_id'],
										  'payment_method' => $order->info['payment_method'],
										  'cc_type' => $order->info['cc_type'],
										  'cc_owner' => $order->info['cc_owner'],
										  'cc_number' => $order->info['cc_number'],
										  'cc_expires' => $order->info['cc_expires'],
										  'date_purchased' => 'now()',
										  'orders_status' => $order->info['order_status'],
										  'currency' => $order->info['currency'],
										  'currency_value' => $order->info['currency_value']);
		
				  //+1.4
				  if ( $update_order ){ 
					smn_db_perform(TABLE_ORDERS, $sql_data_array, 'update', 'orders_id = "' . (int)$order_id . '"');
					$insert_id = (int)$order_id;
				  } else { 
				  //-1.4
				  smn_db_perform(TABLE_ORDERS, $sql_data_array);
		
				  $insert_id = smn_db_insert_id();
				  }//1.4
		
				  for ($i=0, $n=sizeof($order_totals); $i<$n; $i++) {
					$sql_data_array = array('orders_id' => $insert_id,
											'title' => $order_totals[$i]['title'],
											'text' => $order_totals[$i]['text'],
											'value' => $order_totals[$i]['value'],
											'class' => $order_totals[$i]['code'],
											'sort_order' => $order_totals[$i]['sort_order']);
		
					smn_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);
				  }
				  //+1.4
				  $sql_data_array = array('orders_id' => $insert_id, 
											'orders_status_id' => $order->info['order_status'], 
											'date_added' => 'now()', 
								 'customer_notified' => '0', 
											'comments' => $order->info['comments']);
				  smn_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);
				  //-1.4
		
				  for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
				  if($order->products[$i]['products_store_id']==$store_list[$k]){
					$sql_data_array = array('orders_id' => $insert_id,
											'products_id' => smn_get_prid($order->products[$i]['id']),
											'products_model' => $order->products[$i]['model'],
											'products_name' => $order->products[$i]['name'],
											'products_price' => $order->products[$i]['price'],
											'final_price' => $order->products[$i]['final_price'],
											'products_tax' => $order->products[$i]['tax'],
											'products_quantity' => $order->products[$i]['qty']);
		
					smn_db_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array);
		
					$order_products_id = smn_db_insert_id();
		
					$attributes_exist = '0';
					if (isset($order->products[$i]['attributes'])) {
					  $attributes_exist = '1';
					  for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {
						if (DOWNLOAD_ENABLED == 'true') {
						  $attributes_query = "select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix, pad.products_attributes_maxdays, pad.products_attributes_maxcount , pad.products_attributes_filename
											   from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa
											   left join " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad
											   on pa.products_attributes_id=pad.products_attributes_id
											   where pa.products_id = '" . $order->products[$i]['id'] . "'
											   and pa.options_id = '" . $order->products[$i]['attributes'][$j]['option_id'] . "'
											   and pa.options_id = popt.products_options_id
											   and pa.options_values_id = '" . $order->products[$i]['attributes'][$j]['value_id'] . "'
											   and pa.options_values_id = poval.products_options_values_id
											   and popt.language_id = '" . $languages_id . "'
											   and poval.language_id = '" . $languages_id . "'";
						  $attributes = smn_db_query($attributes_query);
						} else {
						  $attributes = smn_db_query("select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa where pa.products_id = '" . $order->products[$i]['id'] . "' and pa.options_id = '" . $order->products[$i]['attributes'][$j]['option_id'] . "' and pa.options_id = popt.products_options_id and pa.options_values_id = '" . $order->products[$i]['attributes'][$j]['value_id'] . "' and pa.options_values_id = poval.products_options_values_id and popt.language_id = '" . $languages_id . "' and poval.language_id = '" . $languages_id . "'");
						}
						$attributes_values = smn_db_fetch_array($attributes);
		
						$sql_data_array = array('orders_id' => $insert_id,
												'orders_products_id' => $order_products_id,
												'products_options' => $attributes_values['products_options_name'],
												'products_options_values' => $attributes_values['products_options_values_name'],
												'options_values_price' => $attributes_values['options_values_price'],
												'price_prefix' => $attributes_values['price_prefix']);
		
						smn_db_perform(TABLE_ORDERS_PRODUCTS_ATTRIBUTES, $sql_data_array);
		
						if ((DOWNLOAD_ENABLED == 'true') && isset($attributes_values['products_attributes_filename']) && smn_not_null($attributes_values['products_attributes_filename'])) {
						  $sql_data_array = array('orders_id' => $insert_id,
												  'orders_products_id' => $order_products_id,
												  'orders_products_filename' => $attributes_values['products_attributes_filename'],
												  'download_maxdays' => $attributes_values['products_attributes_maxdays'],
												  'download_count' => $attributes_values['products_attributes_maxcount']);
		
						  smn_db_perform(TABLE_ORDERS_PRODUCTS_DOWNLOAD, $sql_data_array);
						}
					  }
					}
				  }
				  }
				 $sql_data_array = array('orders_invoice_id' => $orders_invoice_id,
				  						  'orders_id' => $insert_id);
				 smn_db_perform(TABLE_ORDERS_INVOICE, $sql_data_array);
				 $orders_invoice_id = smn_db_insert_id();
				}
				}
				 smn_session_register('cart_PayPal_IPN_ID');
				  // Terra register globals fix
				  $_SESSION['cart_PayPal_IPN_ID'] = $cartID . '-' . $orders_invoice_id;

        }

      return false;
    }

    function process_button() {
      global $customer_id, $order, $languages_id, $currencies, $currency, $cart_PayPal_IPN_ID, $shipping,$store;

      if (MODULE_PAYMENT_PAYPAL_IPN_CURRENCY == 'Selected Currency') {
        $my_currency = $currency;
      } else {
        $my_currency = substr(MODULE_PAYMENT_PAYPAL_IPN_CURRENCY, 5);
      }
      
      if (!in_array($my_currency, array('AUD', 'CAD', 'CHF', 'CZK', 'DKK', 'EUR', 'GBP', 'HKD', 'HUF', 'JPY', 'NOK', 'NZD', 'PLN', 'SEK', 'SGD', 'USD'))) {
        $my_currency = 'USD';
      }
      
      $parameters = array();

      if ( (MODULE_PAYMENT_PAYPAL_IPN_TRANSACTION_TYPE == 'Per Item') && (MODULE_PAYMENT_PAYPAL_IPN_EWP_STATUS == 'False') ) {
        $parameters['cmd'] = '_cart';
        $parameters['upload'] = '1';

        for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
          $item = $i+1;

          $tax_value = ($order->products[$i]['tax'] / 100) * $order->products[$i]['final_price'];

          $parameters['item_name_' . $item] = $order->products[$i]['name'];
          $parameters['amount_' . $item] = number_format($order->products[$i]['final_price'] * $currencies->get_value($my_currency), $currencies->get_decimal_places($my_currency));
          $parameters['tax_' . $item] = number_format($tax_value * $currencies->get_value($my_currency), $currencies->get_decimal_places($my_currency));
          $parameters['quantity_' . $item] = $order->products[$i]['qty'];

          if ($i == 0) {
            if (DISPLAY_PRICE_WITH_TAX == 'true') {
              $shipping_cost = $order->info['shipping_cost'];
            } else {
              $module = substr($shipping['id'], 0, strpos($shipping['id'], '_'));
              $shipping_tax = smn_get_tax_rate($GLOBALS[$module]->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
              $shipping_cost = $order->info['shipping_cost'] + smn_calculate_tax($order->info['shipping_cost'], $shipping_tax);
            }

            $parameters['shipping_' . $item] = number_format($shipping_cost * $currencies->get_value($my_currency), $currencies->get_decimal_places($my_currency));
          }

          if (isset($order->products[$i]['attributes'])) {
            for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {
              if (DOWNLOAD_ENABLED == 'true') {
                $attributes_query = "select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix, pad.products_attributes_maxdays, pad.products_attributes_maxcount , pad.products_attributes_filename
                                     from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa
                                     left join " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad
                                     on pa.products_attributes_id=pad.products_attributes_id
                                     where pa.products_id = '" . $order->products[$i]['id'] . "'
                                     and pa.options_id = '" . $order->products[$i]['attributes'][$j]['option_id'] . "'
                                     and pa.options_id = popt.products_options_id
                                     and pa.options_values_id = '" . $order->products[$i]['attributes'][$j]['value_id'] . "'
                                     and pa.options_values_id = poval.products_options_values_id
                                     and popt.language_id = '" . $languages_id . "'
                                     and poval.language_id = '" . $languages_id . "'";
                $attributes = smn_db_query($attributes_query);
              } else {
                $attributes = smn_db_query("select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa where pa.products_id = '" . $order->products[$i]['id'] . "' and pa.options_id = '" . $order->products[$i]['attributes'][$j]['option_id'] . "' and pa.options_id = popt.products_options_id and pa.options_values_id = '" . $order->products[$i]['attributes'][$j]['value_id'] . "' and pa.options_values_id = poval.products_options_values_id and popt.language_id = '" . $languages_id . "' and poval.language_id = '" . $languages_id . "'");
              }
              $attributes_values = smn_db_fetch_array($attributes);

// Unfortunately PayPal only accepts two attributes per product, so the
// third attribute onwards will not be shown at PayPal
              $parameters['on' . $j . '_' . $item] = $attributes_values['products_options_name'];
              $parameters['os' . $j . '_' . $item] = $attributes_values['products_options_values_name'];
            }
          }
        }

        $parameters['num_cart_items'] = $item;
        
              if(MOVE_TAX_TO_TOTAL_AMOUNT == 'True') {
           // PandA.nl move tax to total amount
           $parameters['amount'] = number_format(($order->info['total'] - $order->info['shipping_cost']) * $currencies->get_value($my_currency), $currencies->get_decimal_places($my_currency));
           } else {
           // default
          $parameters['amount'] = number_format(($order->info['total'] - $order->info['shipping_cost'] - $order->info['tax']) * $currencies->get_value($my_currency), $currencies->get_decimal_places($my_currency));
      }
        
      } else {
        $parameters['cmd'] = '_ext-enter';
        $parameters['redirect_cmd'] = '_xclick';
        $parameters['item_name'] = STORE_NAME;
        $parameters['shipping'] = '0';
      if(MOVE_TAX_TO_TOTAL_AMOUNT == 'True') {
           // PandA.nl move tax to total amount
           $parameters['amount'] = number_format($order->info['total'] * $currencies->get_value($my_currency), $currencies->get_decimal_places($my_currency));
           } else {
           // default
          $parameters['amount'] = number_format(($order->info['total'] - $order->info['tax']) * $currencies->get_value($my_currency), $currencies->get_decimal_places($my_currency));
      }
       }
       
       // billing information fix by gravyface
       // for pre-populating the fiels if customer has no PayPal account
       // only works if force shipping address is set to FALSE
      $state_abbr = smn_get_zone_code($order->delivery['country']['id'], $order->delivery['zone_id'], $order->delivery['state']);
      $name = $order->delivery['firstname'] . ' ' . $order->delivery['lastname'];

      $parameters['business'] = MODULE_PAYMENT_PAYPAL_IPN_ID;
      
      // let's check what has been defined in the shop admin for the shipping address
      if (MODULE_PAYMENT_PAYPAL_IPN_SHIPPING == 'True') {
      // all that matters is that we send the variables
      // what they contain is irrelevant as PayPal overwrites it with the customer's confirmed PayPal address
      // so what we send is probably not what we'll get back
      $parameters['no_shipping'] = '2';   
      $parameters['address_name'] 		= $name;
      $parameters['address_street'] 	= $order->delivery['street_address'];
      $parameters['address_city'] 		= $order->delivery['city'];
      $parameters['address_zip'] 		= $order->delivery['postcode'];
      $parameters['address_state'] 		= $state_abbr;
      $parameters['address_country_code']	= $order->delivery['country']['iso_code_2'];
      $parameters['address_country']	= $order->delivery['country']['title'];
      $parameters['payer_email'] 		= $order->customer['email_address'];          
     } else {      
      $parameters['no_shipping'] = '1'; 
      $parameters['H_PhoneNumber'] 	      = $order->customer['telephone'];      
      $parameters['first_name'] 		= $order->delivery['firstname'];
      $parameters['last_name'] 		= $order->delivery['lastname'];        
      $parameters['address1'] 		= $order->delivery['street_address'];
      $parameters['address2'] 		= $order->delivery['suburb'];
      $parameters['city'] 			= $order->delivery['city'];
      $parameters['zip'] 			= $order->delivery['postcode'];
      $parameters['state'] 			= $state_abbr;
      $parameters['country'] 			= $order->delivery['country']['iso_code_2'];
      $parameters['email'] 			= $order->customer['email_address'];   
          }      
      
      $parameters['currency_code'] = $my_currency;
      $parameters['invoice'] = substr($cart_PayPal_IPN_ID, strpos($cart_PayPal_IPN_ID, '-')+1);
      $parameters['custom'] = $customer_id;
      $parameters['no_note'] = '1';
      $parameters['notify_url'] = smn_href_link('ext/modules/payment/paypal_ipn/ipn.php', '', 'NONSSL', false, false);
      $parameters['cbt'] = CONFIRMATION_BUTTON_TEXT;  
      $parameters['return'] = smn_href_link(FILENAME_CHECKOUT_PROCESS, 'ID='.$store->get_store_id(), 'NONSSL');
      $parameters['cancel_return'] = smn_href_link(FILENAME_CHECKOUT_PAYMENT, '' , 'NONSSL');
      $parameters['bn'] = $this->identifier;
      $parameters['lc'] = $order->customer['country']['iso_code_2'];
      

      if (smn_not_null(MODULE_PAYMENT_PAYPAL_IPN_PAGE_STYLE)) {
        $parameters['page_style'] = MODULE_PAYMENT_PAYPAL_IPN_PAGE_STYLE;
      }

      if (MODULE_PAYMENT_PAYPAL_IPN_EWP_STATUS == 'True') {
        $parameters['cert_id'] = MODULE_PAYMENT_PAYPAL_IPN_EWP_CERT_ID;

        $random_string = rand(100000, 999999) . '-' . $customer_id . '-';

        $data = '';
        while (list($key, $value) = each($parameters)) {
          $data .= $key . '=' . $value . "\n";
        }

        $fp = fopen(MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY . '/' . $random_string . 'data.txt', 'w');
        fwrite($fp, $data);
        fclose($fp);

        unset($data);

        if (function_exists('openssl_pkcs7_sign') && function_exists('openssl_pkcs7_encrypt')) {
          openssl_pkcs7_sign(MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY . '/' . $random_string . 'data.txt', MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY . '/' . $random_string . 'signed.txt', file_get_contents(MODULE_PAYMENT_PAYPAL_IPN_EWP_PUBLIC_KEY), file_get_contents(MODULE_PAYMENT_PAYPAL_IPN_EWP_PRIVATE_KEY), array('From' => MODULE_PAYMENT_PAYPAL_IPN_ID), PKCS7_BINARY);

          unlink(MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY . '/' . $random_string . 'data.txt');

// remove headers from the signature
          $signed = file_get_contents(MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY . '/' . $random_string . 'signed.txt');
          $signed = explode("\n\n", $signed);
          $signed = base64_decode($signed[1]);

          $fp = fopen(MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY . '/' . $random_string . 'signed.txt', 'w');
          fwrite($fp, $signed);
          fclose($fp);

          unset($signed);

          openssl_pkcs7_encrypt(MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY . '/' . $random_string . 'signed.txt', MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY . '/' . $random_string . 'encrypted.txt', file_get_contents(MODULE_PAYMENT_PAYPAL_IPN_EWP_PAYPAL_KEY), array('From' => MODULE_PAYMENT_PAYPAL_IPN_ID), PKCS7_BINARY);

          unlink(MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY . '/' . $random_string . 'signed.txt');

// remove headers from the encrypted result
          $data = file_get_contents(MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY . '/' . $random_string . 'encrypted.txt');
          $data = explode("\n\n", $data);
          $data = '-----BEGIN PKCS7-----' . "\n" . $data[1] . "\n" . '-----END PKCS7-----';

          unlink(MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY . '/' . $random_string . 'encrypted.txt');
        } else {
          exec(MODULE_PAYMENT_PAYPAL_IPN_EWP_OPENSSL . ' smime -sign -in ' . MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY . '/' . $random_string . 'data.txt -signer ' . MODULE_PAYMENT_PAYPAL_IPN_EWP_PUBLIC_KEY . ' -inkey ' . MODULE_PAYMENT_PAYPAL_IPN_EWP_PRIVATE_KEY . ' -outform der -nodetach -binary > ' . MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY . '/' . $random_string . 'signed.txt');
          unlink(MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY . '/' . $random_string . 'data.txt');

          exec(MODULE_PAYMENT_PAYPAL_IPN_EWP_OPENSSL . ' smime -encrypt -des3 -binary -outform pem ' . MODULE_PAYMENT_PAYPAL_IPN_EWP_PAYPAL_KEY . ' < ' . MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY . '/' . $random_string . 'signed.txt > ' . MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY . '/' . $random_string . 'encrypted.txt');
          unlink(MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY . '/' . $random_string . 'signed.txt');

          $fh = fopen(MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY . '/' . $random_string . 'encrypted.txt', 'rb');
          $data = fread($fh, filesize(MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY . '/' . $random_string . 'encrypted.txt'));
          fclose($fh);

          unlink(MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY . '/' . $random_string . 'encrypted.txt');
        }

        $process_button_string = smn_draw_hidden_field('cmd', '_s-xclick') .
                                 smn_draw_hidden_field('encrypted', $data);

        unset($data);
      } else {
        while (list($key, $value) = each($parameters)) {
          echo smn_draw_hidden_field($key, $value);
        }
      }

      return $process_button_string;
    }

    function before_process() {
      global $cart,$customer_id,$invoice,$order;
	  if(ALLOW_STORE_PAYMENT=='true'){
		  $invoice_query = smn_db_query("select o.store_id from " . TABLE_ORDERS . " o where o.orders_id='".$invoice."'");
		  while ($invoice = smn_db_fetch_array($invoice_query)){
			$store_id = $invoice[store_id];
			for ($i=0, $n=sizeof($order->products); $i<$n; $i++) { // PRODUCT LOOP STARTS HERE
      		unset($cart->contents[smn_get_prid($order->products[$i]['id'])]);
			  smn_db_query("delete from " . TABLE_CUSTOMERS_BASKET . " where customers_id = '" . (int)$customer_id . "' and products_id = '" . smn_get_prid($order->products[$i]['id']) . "' and store_id='".$store_id."'");
			  smn_db_query("delete from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . " where customers_id = '" . (int)$customer_id . "' and products_id = '" . smn_get_prid($order->products[$i]['id']) . "' and store_id='".$store_id."'");
		   }
		 }
	  }else{
        $cart->reset(true);
	}
// unregister session variables used during checkout
      smn_session_unregister('sendto');
      smn_session_unregister('billto');
      smn_session_unregister('shipping');
      smn_session_unregister('payment');
      smn_session_unregister('comments');

      smn_session_unregister('cart_PayPal_IPN_ID');

      smn_redirect(smn_href_link(FILENAME_CHECKOUT_SUCCESS, '', 'NONSSL'));
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
        $check_query = smn_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_PAYPAL_IPN_STATUS' and store_id = '" . $store_id . "'");
        $this->_check = smn_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
	  global $store_id;
      $check_query = smn_db_query("select orders_status_id from " . TABLE_ORDERS_STATUS . " where orders_status_name = 'Preparing [PayPal IPN]' limit 1");

      if (smn_db_num_rows($check_query) < 1) {
        $status_query = smn_db_query("select max(orders_status_id) as status_id from " . TABLE_ORDERS_STATUS);
        $status = smn_db_fetch_array($status_query);

        $status_id = $status['status_id']+1;

        $languages = smn_get_languages();

        foreach ($languages as $lang) {
          smn_db_query("insert into " . TABLE_ORDERS_STATUS . " (orders_status_id, language_id, orders_status_name) values ('" . $status_id . "', '" . $lang['id'] . "', 'Preparing [PayPal IPN]')");
        }
      } else {
        $check = smn_db_fetch_array($check_query);

        $status_id = $check['orders_status_id'];
      }

		
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id,configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . $store_id . "','Enable PayPal IPN Module', 'MODULE_PAYMENT_PAYPAL_IPN_STATUS', 'False', 'Do you want to accept PayPal IPN payments?', '6', '1', 'smn_cfg_select_option(array(\'True\', \'False\'), ', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id,configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . $store_id . "','Gateway Server', 'MODULE_PAYMENT_PAYPAL_IPN_GATEWAY_SERVER', 'Testing', 'Use the testing (sandbox) or live gateway server for transactions?', '6', '2', 'smn_cfg_select_option(array(\'Testing\',\'Live\'), ', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id,configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . $store_id . "','Sort order of display.', 'MODULE_PAYMENT_PAYPAL_IPN_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '3', now())");            
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id,configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . $store_id . "','Force shipping address?', 'MODULE_PAYMENT_PAYPAL_IPN_SHIPPING', 'False', 'If TRUE the address details for the PayPal Seller Protection Policy are sent but customers without a PayPal account must re-enter their details. If set to FALSE order is not eligible for Seller Protection but customers without acount will have their address fiels pre-populated.', '6', '4', 'smn_cfg_select_option(array(\'True\', \'False\'), ', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id,configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . $store_id . "','E-Mail Address', 'MODULE_PAYMENT_PAYPAL_IPN_ID', '', 'The e-mail address to use for the PayPal IPN service', '6', '5', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id,configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . $store_id . "','Transaction Currency', 'MODULE_PAYMENT_PAYPAL_IPN_CURRENCY', 'Selected Currency', 'The currency to use for transactions', '6', '10', 'smn_cfg_select_option(array(\'Selected Currency\',\'Only AUD\',\'Only CAD\',\'Only CHF\',\'Only CZK\',\'Only DKK\',\'Only EUR\',\'Only GBP\',\'Only HKD\',\'Only HUF\',\'Only JPY\',\'Only NOK\',\'Only NZD\',\'Only PLN\',\'Only SEK\',\'Only SGD\',\'Only USD\'), ', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id,configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('" . $store_id . "','Payment Zone', 'MODULE_PAYMENT_PAYPAL_IPN_ZONE', '0', 'If a zone is selected, only enable this payment method for that zone.', '6', '11', 'smn_get_zone_class_title', 'smn_cfg_pull_down_zone_classes(', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id,configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('" . $store_id . "','Set Preparing Order Status', 'MODULE_PAYMENT_PAYPAL_IPN_PREPARE_ORDER_STATUS_ID', '" . $status_id . "', 'Set the status of prepared orders made with this payment module to this value', '6', '12', 'smn_cfg_pull_down_order_statuses(', 'smn_get_order_status_name', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id,configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('" . $store_id . "','Set PayPal Acknowledged Order Status', 'MODULE_PAYMENT_PAYPAL_IPN_ORDER_STATUS_ID', '0', 'Set the status of orders made with this payment module to this value', '6', '13', 'smn_cfg_pull_down_order_statuses(', 'smn_get_order_status_name', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id,configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('" . $store_id . "','Set PayPal Completed Order Status', 'MODULE_PAYMENT_PAYPAL_IPN_COMP_ORDER_STATUS_ID', '0', 'Set the status of orders which are confirmed as paid (completed) to this value', '6', '13', 'smn_cfg_pull_down_order_statuses(', 'smn_get_order_status_name', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id,configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . $store_id . "','Transaction Type', 'MODULE_PAYMENT_PAYPAL_IPN_TRANSACTION_TYPE', 'Aggregate', 'Send individual items to PayPal or aggregate all as one total item?', '6', '14', 'smn_cfg_select_option(array(\'Per Item\',\'Aggregate\'), ', now())");
      // bof PandA.nl move tax to total amount
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id,configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . $store_id . "','Move tax to total amount', 'MOVE_TAX_TO_TOTAL_AMOUNT', 'True', 'Do you want to move the tax to the total amount? If true PayPal will allways show the total amount including tax. (needs Aggregate instead of Per Item to function)', '6', '15', 'smn_cfg_select_option(array(\'True\', \'False\'), ', now())");
      // eof PandA.nl move tax to total amount      
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id,configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . $store_id . "','Page Style', 'MODULE_PAYMENT_PAYPAL_IPN_PAGE_STYLE', '', 'The page style to use for the transaction procedure (defined at your PayPal Profile page)', '6', '20', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id,configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . $store_id . "','Debug E-Mail Address', 'MODULE_PAYMENT_PAYPAL_IPN_DEBUG_EMAIL', '', 'All parameters of an Invalid IPN notification will be sent to this email address if one is entered.', '6', '21', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id,configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . $store_id . "','Enable Encrypted Web Payments', 'MODULE_PAYMENT_PAYPAL_IPN_EWP_STATUS', 'False', 'Do you want to enable Encrypted Web Payments?', '6', '30', 'smn_cfg_select_option(array(\'True\', \'False\'), ', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id,configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . $store_id . "','Your Private Key', 'MODULE_PAYMENT_PAYPAL_IPN_EWP_PRIVATE_KEY', '', 'The location of your Private Key to use for signing the data. (*.pem)', '6', '31', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id,configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . $store_id . "','Your Public Certificate', 'MODULE_PAYMENT_PAYPAL_IPN_EWP_PUBLIC_KEY', '', 'The location of your Public Certificate to use for signing the data. (*.pem)', '6', '32', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id,configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . $store_id . "','PayPals Public Certificate', 'MODULE_PAYMENT_PAYPAL_IPN_EWP_PAYPAL_KEY', '', 'The location of the PayPal Public Certificate for encrypting the data.', '6', '33', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id,configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . $store_id . "','Your PayPal Public Certificate ID', 'MODULE_PAYMENT_PAYPAL_IPN_EWP_CERT_ID', '', 'The Certificate ID to use from your PayPal Encrypted Payment Settings Profile.', '6', '34', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id,configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . $store_id . "','Working Directory', 'MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY', '', 'The working directory to use for temporary files. (trailing slash needed)', '6', '35', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id,configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . $store_id . "','OpenSSL Location', 'MODULE_PAYMENT_PAYPAL_IPN_EWP_OPENSSL', '/usr/bin/openssl', 'The location of the openssl binary file.', '6', '36', now())");
	  if($store_id==1){
        smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id,configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . $store_id . "','For Single Checkout?', 'MODULE_PAYMENT_PAYPAL_IPN_SINGLE_CHECKOUT', 'False', 'Use this payment for single checkout?', '6', '2', 'smn_cfg_select_option(array(\'True\', \'False\'), ', now())");
	  }
    }

    function remove() {
	  global $store_id;
      smn_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')and store_id = '" . $store_id . "'");
    }

   function keys() {
    // PandA.nl move tax to total amount added: ", 'MOVE_TAX_TO_TOTAL_AMOUNT'"
	  global $store_id;
	   $key_array = array('MODULE_PAYMENT_PAYPAL_IPN_STATUS', 'MODULE_PAYMENT_PAYPAL_IPN_GATEWAY_SERVER', 'MODULE_PAYMENT_PAYPAL_IPN_ID', 'MODULE_PAYMENT_PAYPAL_IPN_SORT_ORDER', 'MODULE_PAYMENT_PAYPAL_IPN_CURRENCY', 'MODULE_PAYMENT_PAYPAL_IPN_ZONE', 'MODULE_PAYMENT_PAYPAL_IPN_SHIPPING', 'MODULE_PAYMENT_PAYPAL_IPN_PREPARE_ORDER_STATUS_ID', 'MODULE_PAYMENT_PAYPAL_IPN_ORDER_STATUS_ID', 'MODULE_PAYMENT_PAYPAL_IPN_COMP_ORDER_STATUS_ID', 'MODULE_PAYMENT_PAYPAL_IPN_TRANSACTION_TYPE', 'MOVE_TAX_TO_TOTAL_AMOUNT', 'MODULE_PAYMENT_PAYPAL_IPN_PAGE_STYLE', 'MODULE_PAYMENT_PAYPAL_IPN_DEBUG_EMAIL',  'MODULE_PAYMENT_PAYPAL_IPN_EWP_STATUS', 'MODULE_PAYMENT_PAYPAL_IPN_EWP_PRIVATE_KEY', 'MODULE_PAYMENT_PAYPAL_IPN_EWP_PUBLIC_KEY', 'MODULE_PAYMENT_PAYPAL_IPN_EWP_PAYPAL_KEY', 'MODULE_PAYMENT_PAYPAL_IPN_EWP_CERT_ID', 'MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY', 'MODULE_PAYMENT_PAYPAL_IPN_EWP_OPENSSL');
	   if($store_id==1){
	   	$key_array = array_merge($key_array,array('MODULE_PAYMENT_PAYPAL_IPN_SINGLE_CHECKOUT'));
	   }
      return $key_array;
   }
  }
?>
