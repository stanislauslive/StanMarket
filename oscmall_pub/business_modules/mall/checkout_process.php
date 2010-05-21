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
  global $page_name;
// include the mail classes
  require(DIR_WS_CLASSES . 'mime.php');
  require(DIR_WS_CLASSES . 'email.php');
  
  // if the customer is not logged on, redirect them to the login page
  if (!smn_session_is_registered('customer_id')) {
    $navigation->set_snapshot(array('mode' => 'NONSSL', 'page' => FILENAME_CHECKOUT_PAYMENT));
    smn_redirect(smn_href_link(FILENAME_LOGIN, '', 'NONSSL'));
  }
  
// if there is nothing in the customers cart, redirect them to the shopping cart page 
   if ($cart->count_contents() < 1) { 
     smn_redirect(smn_href_link(FILENAME_SHOPPING_CART)); 
   } 
    
 // if no shipping method has been selected, redirect the customer to the shipping method selection page 
   if (!smn_session_is_registered('shipping') || !smn_session_is_registered('sendto')) { 
     smn_redirect(tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL')); 
   } 

  if ( (smn_not_null(MODULE_PAYMENT_INSTALLED)) && (!smn_session_is_registered('payment')) ) {
    smn_redirect(smn_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'NONSSL'));
 }

// avoid hack attempts during the checkout procedure by checking the internal cartID
  if (isset($cart->cartID) && smn_session_is_registered('cartID')) {
    if ($cart->cartID != $cartID) {
      smn_redirect(smn_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'NONSSL'));
    }
  }
// load selected payment module
  require(DIR_WS_CLASSES . 'payment.php');
  $payment_modules = new payment($payment);
  if ($credit_covers) $payment='';
  
// load the selected shipping module
  require(DIR_WS_CLASSES . 'shipping.php');
  $shipping_modules = new shipping($shipping);


// get the order class and create a new object

  require(DIR_WS_CLASSES . 'order.php');
  if($payment=='paypal_ipn'){
  if(ALLOW_STORE_PAYMENT=='true'){
	$order = new order($invoice);
  }else{
		$invoice_query = smn_db_query("select orders_id from " . TABLE_ORDERS_INVOICE . " where orders_invoice_id = '" . $invoice . "'");
		 while ($invoice_data = smn_db_fetch_array($invoice_query)){
		  $orders_id = $invoice_data[orders_id];
			$order = new order($orders_id);
	  }
  }
  }else{
  $order = new order;
  }

// Stock Check 
   $any_out_of_stock = false; 
   if (STOCK_CHECK == 'true') { 
     for ($i=0, $n=sizeof($order->products); $i<$n; $i++) { 
       if (smn_check_stock($order->products[$i]['id'], $order->products[$i]['qty'])) { 
         $any_out_of_stock = true; 
       } 
     } 
     // Out of Stock 
     if ( (STOCK_ALLOW_CHECKOUT != 'true') && ($any_out_of_stock == true) ) { 
       smn_redirect(smn_href_link(FILENAME_SHOPPING_CART)); 
     } 
   } 
  
   $payment_modules->update_status(); 
  
   if ( ( is_array($payment_modules->modules) && (sizeof($payment_modules->modules) > 1) && !is_object($$payment) ) || (is_object($$payment) && ($$payment->enabled == false)) ) { 
     smn_redirect(smn_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message=' . urlencode(ERROR_NO_PAYMENT_MODULE_SELECTED), 'SSL')); 
   } 
  

  require(DIR_WS_CLASSES . 'order_total.php');
  $order_total_modules = new order_total;

  $order_totals = $order_total_modules->process();
// load the before_process function from the payment modules
  	$payment_modules->before_process();
  /*Added the code for single checkout also,by Cimi*/
  if(ALLOW_STORE_PAYMENT=='true'){
  $orders_invoice_id = '';
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
                          'delivery_name' => trim($order->delivery['firstname'] . ' ' . $order->delivery['lastname']),
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
                          'last_modified' => 'now()',
                          'orders_status' => $order->info['order_status'], 
                          'currency' => $order->info['currency'], 
                          'currency_value' => $order->info['currency_value']);
  smn_db_perform(TABLE_ORDERS, $sql_data_array);
  $insert_id = smn_db_insert_id();
	for ($i=0, $n=sizeof($order_totals); $i<$n; $i++) {
	$sql_data_array = array('orders_id' => $insert_id,
							'title' => $order_totals[$i]['title'],
							'text' => $order_totals[$i]['text'],
							'value' => $order_totals[$i]['value'], 
							'class' => $order_totals[$i]['code'], 
							'sort_order' => $order_totals[$i]['sort_order']);
	smn_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);
  }
				 
  $customer_notification = (SEND_EMAILS == 'true') ? '1' : '0';
  $sql_data_array = array('orders_id' => $insert_id, 
                          'orders_status_id' => $order->info['order_status'], 
                          'date_added' => 'now()', 
                          'customer_notified' => $customer_notification,
                          'comments' => $order->info['comments']);
  smn_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);
// initialized for the email confirmation
  $products_ordered = '';
  $subtotal = 0;
  $total_tax = 0;

  for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
// Stock Update - Joao Correia
    if (STOCK_LIMITED == 'true') {
      if (DOWNLOAD_ENABLED == 'true') {
        $stock_query_raw = "SELECT products_quantity, pad.products_attributes_filename 
                            FROM " . TABLE_PRODUCTS . " p
                            LEFT JOIN " . TABLE_PRODUCTS_ATTRIBUTES . " pa
                             ON p.products_id=pa.products_id
                            LEFT JOIN " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad
                             ON pa.products_attributes_id=pad.products_attributes_id
                            WHERE p.products_id = '" . smn_get_prid($order->products[$i]['id']) . "'";
// Will work with only one option for downloadable products
// otherwise, we have to build the query dynamically with a loop
        $products_attributes = $order->products[$i]['attributes'];
        if (is_array($products_attributes)) {
          $stock_query_raw .= " AND pa.options_id = '" . $products_attributes[0]['option_id'] . "' AND pa.options_values_id = '" . $products_attributes[0]['value_id'] . "'";
        }
        $stock_query = smn_db_query($stock_query_raw);
      } else {
        $stock_query = smn_db_query("select products_quantity from " . TABLE_PRODUCTS . " where products_id = '" . smn_get_prid($order->products[$i]['id']) . "'");
      }
      if (smn_db_num_rows($stock_query) > 0) {
        $stock_values = smn_db_fetch_array($stock_query);
// do not decrement quantities if products_attributes_filename exists
        if ((DOWNLOAD_ENABLED != 'true') || (!$stock_values['products_attributes_filename'])) {
          $stock_left = $stock_values['products_quantity'] - $order->products[$i]['qty'];
        } else {
          $stock_left = $stock_values['products_quantity'];
        }
        smn_db_query("update " . TABLE_PRODUCTS . " set products_quantity = '" . $stock_left . "' where products_id = '" . smn_get_prid($order->products[$i]['id']) . "'");
        if ( ($stock_left < 1) && (STOCK_ALLOW_CHECKOUT == 'false') ) {
          smn_db_query("update " . TABLE_PRODUCTS . " set products_status = '0' where products_id = '" . smn_get_prid($order->products[$i]['id']) . "'");
        }
      }
    }

// Update products_ordered (for bestsellers list)
    smn_db_query("update " . TABLE_PRODUCTS . " set products_ordered = products_ordered + " . sprintf('%d', $order->products[$i]['qty']) . " where products_id = '" . smn_get_prid($order->products[$i]['id']) . "'");
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
    $order_total_modules->update_credit_account($i);

    $member_product = explode('_', $order->products[$i]['model']);
    if(($member_product[0] == 'mem') && ($store_id == 1)){
        $start_day = getdate();
        $day = $start_day['mday'];
        $month = $start_day['mon'];
        $year = $start_day['year'];
        $product_end_date = strftime('%Y',mktime(0,0,0, $month + (int)$member_product[1], $day, $year)) . '-' . strftime('%m',mktime(0,0,0, $month + (int)$member_product[1], $day, $year)) . '-' . strftime('%d',mktime(0,0,0, $month + (int)$member_product[1], $day, $year));
        $sql_data_array = array('orders_id' => $insert_id,
                                'store_id' => $insert_id,
                                'products_id' => smn_get_prid($order->products[$i]['id']), 
                                'customer_id' => $customer_id, 
                                'products_end_date' => $product_end_date);
    $update_query = smn_db_query("select store_id from " . TABLE_MEMBER_ORDERS . " where customer_id = '" . (int)$customer_id . "'");

    if (smn_db_num_rows($update_query)) {
      smn_db_perform(TABLE_MEMBER_ORDERS, $sql_data_array, 'update', "customer_id = '" . (int)$customer_id . "'");
    }else{
      smn_db_perform(TABLE_MEMBER_ORDERS, $sql_data_array);
      }
      
    smn_db_query("update " . TABLE_STORE_MAIN . " set store_status = 1 where customer_id = '" . (int)$customer_id . "'");
    $set_member_product = 'true';
    }

//------insert customer choosen option to order--------
    $attributes_exist = '0';
    $products_ordered_attributes = '';
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

    if (strstr($attributes_values['products_options_name'], 'Stream')) $content_type = 'stream_product';
    if($content_type == 'stream_product'){
      $start_day = getdate();
      $day = $start_day['mday'];
      $month = $start_day['mon'];
      $year = $start_day['year'];
      $time_entry = strftime('%d',mktime(0,0,0, $month, $day, $year)) . '-' . strftime('%m',mktime(0,0,0, $month, $day, $year)) . '-' . strftime('%Y',mktime(0,0,0, $month, $day, $year));
      $streaming_query = smn_db_query("select * from " . TABLE_STREAMING_PRODUCTS_INFO . " where products_id = '" . $use_products_id. "'");
      if(smn_db_num_rows($streaming_query)) $streaming_values = smn_db_fetch_array($streaming_query);
      if(!smn_session_is_registered('authorization_code')) smn_session_register('authorization_code');
      $random = rand();
      $string = md5($random);
      $authorization_code = substr($string, 20);
      $sql_data_array = array('customer_id' => $customer_id,
                              'products_id' => $order->products[$i]['id'],
                              'purchase_id' => $authorization_code,
                              'time_entry' => $time_entry,
                              'time_expire' => (int)$order->products[$i]['time_expire'],
                              'total_click' => 0,
                              'total_click_allowed' => (int)$order->products[$i]['total_click_allowed']);
      smn_db_perform(TABLE_STREAMING_PRODUCTS, $sql_data_array); 
    } 


        $sql_data_array = array('orders_id' => $insert_id, 
                                'orders_products_id' => $order_products_id, 
                                'products_options' => $attributes_values['products_options_name'],
                                'products_options_values' => $attributes_values['products_options_values_name'], 
                                'options_values_price' => $attributes_values['options_values_price'], 
                                'price_prefix' => $attributes_values['price_prefix']);
        smn_db_perform(TABLE_ORDERS_PRODUCTS_ATTRIBUTES, $sql_data_array);


        if ((DOWNLOAD_ENABLED == 'true') && 
		isset($attributes_values['products_attributes_filename']) && 
		smn_not_null($attributes_values['products_attributes_filename'])) {
          $sql_data_array = array('orders_id' => $insert_id, 
                                  'orders_products_id' => $order_products_id, 
                                  'orders_products_filename' => $attributes_values['products_attributes_filename'], 
                                  'download_maxdays' => $attributes_values['products_attributes_maxdays'], 
                                  'download_count' => $attributes_values['products_attributes_maxcount']);
          smn_db_perform(TABLE_ORDERS_PRODUCTS_DOWNLOAD, $sql_data_array);
        }
        $products_ordered_attributes .= "\n\t" . $attributes_values['products_options_name'] . ' ' . $attributes_values['products_options_values_name'];
      }
    }
    
//------insert customer choosen option eof ----
    $total_weight += ($order->products[$i]['qty'] * $order->products[$i]['weight']);
    $total_tax += smn_calculate_tax($total_products_price, $products_tax) * $order->products[$i]['qty'];
    $total_cost += $total_products_price;

    $products_ordered .= $order->products[$i]['qty'] . ' x ' . $order->products[$i]['name'] . ' (' . $order->products[$i]['model'] . ') = ' . $currencies->display_price($order->products[$i]['final_price'], $order->products[$i]['tax'], $order->products[$i]['qty']) . $products_ordered_attributes . "\n";
    $cart->remove($order->products[$i]['id']);
  }
  
    $start_day = getdate();
    $set_date = $start_day['mday'] . '-' . $start_day['mon'] . '-' . $start_day['year'];
    $sql_data_array = array('orders_id' => $insert_id,
                            'store_id' => $store_id,
                            'value' => $total_products_price, 
                            'date' => $set_date);
    smn_db_perform(TABLE_ORDERS_TRACKING, $sql_data_array);
                            
  $order_total_modules->apply_credit();

  }else{
    $orders_invoice_id = '';
  	$store_list = $cart->get_store_list();
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
                          'last_modified' => 'now()',
                          'orders_status' => $order->info['order_status'], 
                          'currency' => $order->info['currency'], 
                          'currency_value' => $order->info['currency_value']);
		smn_db_perform(TABLE_ORDERS, $sql_data_array);
    	$insert_id = smn_db_insert_id();
		$sql_data_array = array('orders_invoice_id' => $orders_invoice_id,
								 'orders_id' => $insert_id);
		smn_db_perform(TABLE_ORDERS_INVOICE, $sql_data_array);
		$orders_invoice_id = smn_db_insert_id();
		
		$subtotal_store = '';
 		for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
			if($order->products[$i]['products_store_id']==$store_list[$k]){
        		$shown_price = smn_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax']) * $order->products[$i]['qty'];
        		$subtotal_store += $shown_price;

				$products_tax_store = $order->products[$i]['tax'];
		
				$products_tax_description_store = $order->products[$i]['tax_description'];
		
				if (DISPLAY_PRICE_WITH_TAX == 'true') {
				  $tax_store += $shown_price - ($shown_price / (($products_tax_store < 10) ? "1.0" . str_replace('.', '', $products_tax_store) : "1." . str_replace('.', '', $products_tax_store)));
				} else {
				  $tax_store += ($products_tax_store / 100) * $shown_price;
				}
			}
		 }
		 $shipping_charge_store = $order->info_store[$store_list[$k]]['shipping_cost'];
		if (DISPLAY_PRICE_WITH_TAX == 'true') {
        	$total_store = $subtotal_store + $shipping_charge_store;
      	}else{
			$total_store = $subtotal_store + $tax_store + $shipping_charge_store;
		}
		
   		$sql_data_array_store = array('orders_id' => $insert_id,
  						  'subtotal' => $subtotal_store,
						  'shipping_method' => $order->info['shipping_method'],
						  'shipping_charge' => $shipping_charge_store,
						  'total' => $total_store);
						  
		smn_db_perform(TABLE_ORDERS_VENDOR_AMOUNT, $sql_data_array_store);
		
		for ($i=0, $n=sizeof($order_totals); $i<$n; $i++) {
		$sql_data_array = array('orders_id' => $insert_id,
								'title' => $order_totals[$i]['title'],
								'text' => $order_totals[$i]['text'],
								'value' => $order_totals[$i]['value'], 
								'class' => $order_totals[$i]['code'], 
								'sort_order' => $order_totals[$i]['sort_order']);
		smn_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);
  		}
	  $customer_notification = (SEND_EMAILS == 'true') ? '1' : '0';
	  $sql_data_array = array('orders_id' => $insert_id, 
							  'orders_status_id' => $order->info['order_status'], 
							  'date_added' => 'now()', 
							  'customer_notified' => $customer_notification,
							  'comments' => $order->info['comments']);
	  smn_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);
	// initialized for the email confirmation
	  $products_ordered = '';
	  $products_ordered_store = '';
	  $subtotal = 0;
	  $total_tax = 0;

	  for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
	// Stock Update - Joao Correia
		if (STOCK_LIMITED == 'true') {
		  if (DOWNLOAD_ENABLED == 'true') {
			$stock_query_raw = "SELECT products_quantity, pad.products_attributes_filename 
								FROM " . TABLE_PRODUCTS . " p
								LEFT JOIN " . TABLE_PRODUCTS_ATTRIBUTES . " pa
								 ON p.products_id=pa.products_id
								LEFT JOIN " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad
								 ON pa.products_attributes_id=pad.products_attributes_id
								WHERE p.products_id = '" . smn_get_prid($order->products[$i]['id']) . "'";
	// Will work with only one option for downloadable products
	// otherwise, we have to build the query dynamically with a loop
			$products_attributes = $order->products[$i]['attributes'];
			if (is_array($products_attributes)) {
			  $stock_query_raw .= " AND pa.options_id = '" . $products_attributes[0]['option_id'] . "' AND pa.options_values_id = '" . $products_attributes[0]['value_id'] . "'";
			}
			$stock_query = smn_db_query($stock_query_raw);
		  } else {
			$stock_query = smn_db_query("select products_quantity from " . TABLE_PRODUCTS . " where products_id = '" . smn_get_prid($order->products[$i]['id']) . "'");
		  }
		  if (smn_db_num_rows($stock_query) > 0) {
			$stock_values = smn_db_fetch_array($stock_query);
	// do not decrement quantities if products_attributes_filename exists
			if ((DOWNLOAD_ENABLED != 'true') || (!$stock_values['products_attributes_filename'])) {
			  $stock_left = $stock_values['products_quantity'] - $order->products[$i]['qty'];
			} else {
			  $stock_left = $stock_values['products_quantity'];
			}
			smn_db_query("update " . TABLE_PRODUCTS . " set products_quantity = '" . $stock_left . "' where products_id = '" . smn_get_prid($order->products[$i]['id']) . "'");
			if ( ($stock_left < 1) && (STOCK_ALLOW_CHECKOUT == 'false') ) {
			  smn_db_query("update " . TABLE_PRODUCTS . " set products_status = '0' where products_id = '" . smn_get_prid($order->products[$i]['id']) . "'");
			}
		  }
		}
	
	// Update products_ordered (for bestsellers list)
		smn_db_query("update " . TABLE_PRODUCTS . " set products_ordered = products_ordered + " . sprintf('%d', $order->products[$i]['qty']) . " where products_id = '" . smn_get_prid($order->products[$i]['id']) . "'");
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
		}
		$order_products_id = smn_db_insert_id();
		$order_total_modules->update_credit_account($i);
	
		$member_product = explode('_', $order->products[$i]['model']);
		if(($member_product[0] == 'mem') && ($store_id == 1)){
			$start_day = getdate();
			$day = $start_day['mday'];
			$month = $start_day['mon'];
			$year = $start_day['year'];
			$product_end_date = strftime('%Y',mktime(0,0,0, $month + (int)$member_product[1], $day, $year)) . '-' . strftime('%m',mktime(0,0,0, $month + (int)$member_product[1], $day, $year)) . '-' . strftime('%d',mktime(0,0,0, $month + (int)$member_product[1], $day, $year));
			$sql_data_array = array('orders_id' => $insert_id,
									'store_id' => $insert_id,
									'products_id' => smn_get_prid($order->products[$i]['id']), 
									'customer_id' => $customer_id, 
									'products_end_date' => $product_end_date);
		$update_query = smn_db_query("select store_id from " . TABLE_MEMBER_ORDERS . " where customer_id = '" . (int)$customer_id . "'");
	
		if (smn_db_num_rows($update_query)) {
		  smn_db_perform(TABLE_MEMBER_ORDERS, $sql_data_array, 'update', "customer_id = '" . (int)$customer_id . "'");
		}else{
		  smn_db_perform(TABLE_MEMBER_ORDERS, $sql_data_array);
		  }
		  
		smn_db_query("update " . TABLE_STORE_MAIN . " set store_status = 1 where customer_id = '" . (int)$customer_id . "'");
		$set_member_product = 'true';
		}
	
	//------insert customer choosen option to order--------
		$attributes_exist = '0';
		$products_ordered_attributes = '';
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
	
		if (strstr($attributes_values['products_options_name'], 'Stream')) $content_type = 'stream_product';
		if($content_type == 'stream_product'){
		  $start_day = getdate();
		  $day = $start_day['mday'];
		  $month = $start_day['mon'];
		  $year = $start_day['year'];
		  $time_entry = strftime('%d',mktime(0,0,0, $month, $day, $year)) . '-' . strftime('%m',mktime(0,0,0, $month, $day, $year)) . '-' . strftime('%Y',mktime(0,0,0, $month, $day, $year));
		  $streaming_query = smn_db_query("select * from " . TABLE_STREAMING_PRODUCTS_INFO . " where products_id = '" . $use_products_id. "'");
		  if(smn_db_num_rows($streaming_query)) $streaming_values = smn_db_fetch_array($streaming_query);
		  if(!smn_session_is_registered('authorization_code')) smn_session_register('authorization_code');
		  $random = rand();
		  $string = md5($random);
		  $authorization_code = substr($string, 20);
		  $sql_data_array = array('customer_id' => $customer_id,
								  'products_id' => $order->products[$i]['id'],
								  'purchase_id' => $authorization_code,
								  'time_entry' => $time_entry,
								  'time_expire' => (int)$order->products[$i]['time_expire'],
								  'total_click' => 0,
								  'total_click_allowed' => (int)$order->products[$i]['total_click_allowed']);
		  smn_db_perform(TABLE_STREAMING_PRODUCTS, $sql_data_array); 
		} 
	
	
			$sql_data_array = array('orders_id' => $insert_id, 
									'orders_products_id' => $order_products_id, 
									'products_options' => $attributes_values['products_options_name'],
									'products_options_values' => $attributes_values['products_options_values_name'], 
									'options_values_price' => $attributes_values['options_values_price'], 
									'price_prefix' => $attributes_values['price_prefix']);
			smn_db_perform(TABLE_ORDERS_PRODUCTS_ATTRIBUTES, $sql_data_array);
	
	
			if ((DOWNLOAD_ENABLED == 'true') && 
			isset($attributes_values['products_attributes_filename']) && 
			smn_not_null($attributes_values['products_attributes_filename'])) {
			  $sql_data_array = array('orders_id' => $insert_id, 
									  'orders_products_id' => $order_products_id, 
									  'orders_products_filename' => $attributes_values['products_attributes_filename'], 
									  'download_maxdays' => $attributes_values['products_attributes_maxdays'], 
									  'download_count' => $attributes_values['products_attributes_maxcount']);
			  smn_db_perform(TABLE_ORDERS_PRODUCTS_DOWNLOAD, $sql_data_array);
			}
			$products_ordered_attributes .= "\n\t" . $attributes_values['products_options_name'] . ' ' . $attributes_values['products_options_values_name'];
		  }
		}
		
		
	//------insert customer choosen option eof ----
		$total_weight += ($order->products[$i]['qty'] * $order->products[$i]['weight']);
		$total_tax += smn_calculate_tax($total_products_price, $products_tax) * $order->products[$i]['qty'];
		$total_cost += $total_products_price;
	
		$products_ordered .= $order->products[$i]['qty'] . ' x ' . $order->products[$i]['name'] . ' (' . $order->products[$i]['model'] . ') = ' . $currencies->display_price($order->products[$i]['final_price'], $order->products[$i]['tax'], $order->products[$i]['qty']) . $products_ordered_attributes . "\n";
		if($order->products[$i]['products_store_id']==$store_list[$k]){
			$products_ordered_store .= $order->products[$i]['qty'] . ' x ' . $order->products[$i]['name'] . ' (' . $order->products[$i]['model'] . ') = ' . $currencies->display_price($order->products[$i]['final_price'], $order->products[$i]['tax'], $order->products[$i]['qty']) . $products_ordered_attributes . "\n";
		}
	  }
	  
	  
	  
	  
	  
	  $vendor_query = smn_db_query("select c.*,sd.* from ".TABLE_CUSTOMERS." c,".TABLE_STORE_MAIN." s,".TABLE_STORE_DESCRIPTION." sd where s.store_id=".$store_list[$k]." and s.customer_id=c.customers_id and s.store_id=sd.store_id ");
	  $vendor_details = smn_db_fetch_array($vendor_query);
	  $email_order_store = '';
		  
	  if($set_member_product == 'true'){
			 $email_order_store .= EMAIL_TEXT_MEMBER_PRODUCT . ' ' . $product_end_date . "\n\n";
			}
	// lets start with the email confirmation
	  $email_order_store .= $vendor_details['store_name'] . "\n" . 
					 EMAIL_SEPARATOR . "\n" .
					 EMAIL_TEXT_ORDER_NUMBER . ' ' . $insert_id . "\n" .
					 EMAIL_TEXT_DATE_ORDERED . ' ' . strftime(DATE_FORMAT_LONG) . "\n\n";
	  if ($order->info['comments']) {
		$email_order_store .= smn_db_output($order->info['comments']) . "\n\n";
	  }
	  
	  $email_order_store .= EMAIL_TEXT_PRODUCTS . "\n" . 
					  EMAIL_SEPARATOR . "\n" . 
					  $products_ordered_store . 
					  EMAIL_SEPARATOR . "\n";
	
		$email_order_store .= 'Sub Total' . ' ' . $currencies->format($subtotal_store) . "\n";
		$email_order_store .= $order->info['shipping_method'] . ' ' . $currencies->format($shipping_charge_store) . "\n";
		$email_order_store .= 'Total' . ' ' . $currencies->format($total_store) . "\n";
	
	  if ($order->content_type != 'virtual') {
		$email_order_store .= "\n" . EMAIL_TEXT_DELIVERY_ADDRESS . "\n" . 
						EMAIL_SEPARATOR . "\n" .
						smn_address_label($customer_id, $sendto, 0, '', "\n") . "\n";
	  }
	
	  $email_order_store .= "\n" . EMAIL_TEXT_BILLING_ADDRESS . "\n" .
					  EMAIL_SEPARATOR . "\n" .
					  smn_address_label($customer_id, $billto, 0, '', "\n") . "\n\n";
	  if (is_object($$payment)) {
		$email_order_store .= EMAIL_TEXT_PAYMENT_METHOD . "\n" . 
						EMAIL_SEPARATOR . "\n";
		$payment_class = $$payment;
		$email_order_store .= $payment_class->title . "\n\n";
		if ($payment_class->email_footer) { 
		  $email_order_store .= $payment_class->email_footer . "\n\n";
		}
	  }
	  smn_mail($vendor_details['customers_firstname'].' '.$vendor_details['customers_lastname'], $vendor_details['customers_email_address'], EMAIL_TEXT_SUBJECT, $email_order_store, $store->get_store_owner(), $store->get_store_owner_email_address());
	  
	  
	  
	  
	  
	  
	  
	  for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
	  		$cart->remove($order->products[$i]['id']);
		}
		
		
		

		$start_day = getdate();
		$set_date = $start_day['mday'] . '-' . $start_day['mon'] . '-' . $start_day['year'];
		$sql_data_array = array('orders_id' => $insert_id,
								'store_id' => $store_id,
								'value' => $total_products_price, 
								'date' => $set_date);
		smn_db_perform(TABLE_ORDERS_TRACKING, $sql_data_array);
								
	  $order_total_modules->apply_credit();
	  }
  }
/*End of code*/
  $email_order .= '';
	  
  if($set_member_product == 'true'){
		 $email_order .= EMAIL_TEXT_MEMBER_PRODUCT . ' ' . $product_end_date . "\n\n";
		}
// lets start with the email confirmation
  $email_order .= $store->get_store_name() . "\n" . 
                 EMAIL_SEPARATOR . "\n" .
                 EMAIL_TEXT_ORDER_NUMBER . ' ' . $insert_id . "\n" .
                 EMAIL_TEXT_INVOICE_URL . ' ' . smn_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $insert_id, 'NONSSL', false) . "\n" .
                 EMAIL_TEXT_DATE_ORDERED . ' ' . strftime(DATE_FORMAT_LONG) . "\n\n";
  if ($order->info['comments']) {
    $email_order .= smn_db_output($order->info['comments']) . "\n\n";
  }
  
  $email_order .= EMAIL_TEXT_PRODUCTS . "\n" . 
                  EMAIL_SEPARATOR . "\n" . 
                  $products_ordered . 
                  EMAIL_SEPARATOR . "\n";

  for ($i=0, $n=sizeof($order_totals); $i<$n; $i++) {
    $email_order .= strip_tags($order_totals[$i]['title']) . ' ' . strip_tags($order_totals[$i]['text']) . "\n";
  }

  if ($order->content_type != 'virtual') {
    $email_order .= "\n" . EMAIL_TEXT_DELIVERY_ADDRESS . "\n" . 
                    EMAIL_SEPARATOR . "\n" .
                    smn_address_label($customer_id, $sendto, 0, '', "\n") . "\n";
  }

  $email_order .= "\n" . EMAIL_TEXT_BILLING_ADDRESS . "\n" .
                  EMAIL_SEPARATOR . "\n" .
                  smn_address_label($customer_id, $billto, 0, '', "\n") . "\n\n";
  if (is_object($$payment)) {
    $email_order .= EMAIL_TEXT_PAYMENT_METHOD . "\n" . 
                    EMAIL_SEPARATOR . "\n";
    $payment_class = $$payment;
    $email_order .= $order->info['payment_method'] . "\n\n";
    if ($payment_class->email_footer) { 
      $email_order .= $payment_class->email_footer . "\n\n";
    }
  }
  smn_mail($order->customer['firstname'] . ' ' . $order->customer['lastname'], $order->customer['email_address'], EMAIL_TEXT_SUBJECT, $email_order, $store->get_store_owner(), $store->get_store_owner_email_address());

// load the after_process function from the payment modules
  $payment_modules->after_process();

// unregister session variables used during checkout
  smn_session_unregister('sendto');
  smn_session_unregister('billto');
  smn_session_unregister('shipping');
  smn_session_unregister('shipping_store');
  smn_session_unregister('payment');
  smn_session_unregister('comments');
  if(smn_session_is_registered('credit_covers')) smn_session_unregister('credit_covers');
  $order_total_modules->clear_posts();
  smn_redirect(smn_href_link(FILENAME_CHECKOUT_SUCCESS, 'orders_id=' . $insert_id, 'NONSSL'));

?>