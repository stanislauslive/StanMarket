<?php
/*
  $Id: paypal_ipn.php,v 2.1.0.0 13/01/2007 16:30:21 Edith Karnitsch Exp $

  Copyright (c) 2004 osCommerce
  Released under the GNU General Public License
  
  Original Authors: Harald Ponce de Leon, Mark Evans 
  Updates by PandA.nl, Navyhost, Zoeticlight, David, gravyface, AlexStudio, windfjf, Monika in Germany and Terra
    
*/

  chdir('../../../../');
  require('includes/application_top.php');
 // include(DIR_WS_LANGUAGES . $language . '/' . FILENAME_CHECKOUT_PROCESS);

  $parameters = 'cmd=_notify-validate';

  foreach ($_POST as $key => $value) {
    $parameters .= '&' . $key . '=' . urlencode(stripslashes($value));
  }

  if (MODULE_PAYMENT_PAYPAL_IPN_GATEWAY_SERVER == 'Live') {
    $server = 'www.paypal.com';
  } else {
    $server = 'www.sandbox.paypal.com';
  }

  $fsocket = false;
  $curl = false;
  $result = false;

  if ( (PHP_VERSION >= 4.3) && ($fp = @fsockopen('ssl://' . $server, 443, $errno, $errstr, 30)) ) {
    $fsocket = true;
  } elseif (function_exists('curl_exec')) {
    $curl = true;
  } elseif ($fp = @fsockopen($server, 80, $errno, $errstr, 30)) {
    $fsocket = true;
  }

  if ($fsocket == true) {
    $header = 'POST /cgi-bin/webscr HTTP/1.0' . "\r\n" .
              'Host: ' . $server . "\r\n" .
              'Content-Type: application/x-www-form-urlencoded' . "\r\n" .
              'Content-Length: ' . strlen($parameters) . "\r\n" .
              'Connection: close' . "\r\n\r\n";

    @fputs($fp, $header . $parameters);

    $string = '';
    while (!@feof($fp)) {
      $res = @fgets($fp, 1024);
      $string .= $res;

      if ( ($res == 'VERIFIED') || ($res == 'INVALID') ) {
        $result = $res;

        break;
      }
    }

    @fclose($fp);
  } elseif ($curl == true) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://' . $server . '/cgi-bin/webscr');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $result = curl_exec($ch);

    curl_close($ch);
  }
  require(DIR_WS_CLASSES . 'order.php');
  require(DIR_WS_CLASSES . 'payment.php');
  require(DIR_WS_CLASSES . 'email.php');
  require(DIR_WS_CLASSES . 'mime.php');
  $payment_modules = new payment(paypal_ipn);
  if ($result == 'VERIFIED') {
    if (isset($_POST['invoice']) && is_numeric($_POST['invoice']) && ($_POST['invoice'] > 0)) {
	if(ALLOW_STORE_PAYMENT=='true'){
	  $invoice_id = $_POST['invoice'];
	  $store_query = smn_db_query("select store_id from " . TABLE_ORDERS . " where orders_id = '" . $invoice_id . "'");
	  $store = smn_db_fetch_array($store_query);
	  $store_id = $store[store_id];
	  
      $order_query = smn_db_query("select currency, currency_value from " . TABLE_ORDERS . " where orders_id = '" . $invoice_id . "' and customers_id = '" . (int)$_POST['custom'] . "'");
      if (smn_db_num_rows($order_query) > 0) {
        $order_db = smn_db_fetch_array($order_query);
        
      // let's re-create the required arrays
         $order = new order($invoice_id);
         
        // let's update the order status
        $total_query = smn_db_query("select value from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $invoice_id . "' and class = 'ot_total' limit 1");
        $total = smn_db_fetch_array($total_query);

        $comment_status = $_POST['payment_status'] . ' (' . ucfirst($_POST['payer_status']) . '; ' . $currencies->format($_POST['mc_gross'], false, $_POST['mc_currency']) . ')';

        if ($_POST['payment_status'] == 'Pending') {
          $comment_status .= '; ' . $_POST['pending_reason'];
        } elseif ( ($_POST['payment_status'] == 'Reversed') || ($_POST['payment_status'] == 'Refunded') ) {
          $comment_status .= '; ' . $_POST['reason_code'];
        } elseif ( ($_POST['payment_status'] == 'Completed') && (MODULE_PAYMENT_PAYPAL_IPN_SHIPPING == 'True') ) {
          $comment_status .= ", \n" . PAYPAL_ADDRESS . ": " . $_POST['address_name'] . ", " . $_POST['address_street'] . ", " . $_POST['address_city'] . ", " . $_POST['address_zip'] . ", " . $_POST['address_state'] . ", " . $_POST['address_country'] . ", " . $_POST['address_country_code'] . ", " . $_POST['address_status'];
        } 

$order_status_id = DEFAULT_ORDERS_STATUS_ID;
 
// modified AlexStudio's Rounding error bug fix 
// variances of up to 0.05 on either side (plus / minus) are ignored
        if (
         (((number_format($total['value'] * $order_db['currency_value'], $currencies->get_decimal_places($order_db['currency']))) -  $_POST['mc_gross']) <= 0.05)  
         &&
          (((number_format($total['value'] * $order_db['currency_value'], $currencies->get_decimal_places($order_db['currency']))) -  $_POST['mc_gross']) >= -0.05)          
        ) {

// previous validation

// Terra -> modified update. If payment status is "completed" than a completed order status is chosen based on the admin settings 
          if ( (MODULE_PAYMENT_PAYPAL_IPN_COMP_ORDER_STATUS_ID > 0) && ($_POST['payment_status'] == 'Completed') ) {
            $order_status_id = MODULE_PAYMENT_PAYPAL_IPN_COMP_ORDER_STATUS_ID;
          } elseif (MODULE_PAYMENT_PAYPAL_IPN_ORDER_STATUS_ID > 0) {
            $order_status_id = MODULE_PAYMENT_PAYPAL_IPN_ORDER_STATUS_ID;
          } 
          
       }

        // Let's see what the PayPal payment status is and set the notification accordingly
        // more info: https://www.paypal.com/IntegrationCenter/ic_ipn-pdt-variable-reference.html
        if ( ($_POST['payment_status'] == 'Pending') || ($_POST['payment_status'] == 'Completed')) {
          $customer_notified = '1'; 
          } else {
          $customer_notified = '0'; 
        }


        smn_db_query("update " . TABLE_ORDERS . " set orders_status = '" . $order_status_id . "', last_modified = now() where orders_id = '" . $invoice_id . "'");

        $sql_data_array = array('orders_id' => $invoice_id,
                                'orders_status_id' => $order_status_id,
                                'date_added' => 'now()',
                                'customer_notified' => $customer_notified,
                                'comments' => 'PayPal IPN Verified [' . $comment_status . ']');

        smn_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);

// If the order is pending, then we want to send a notification email to the customer

// If the order is completed, then we want to send the order email and update the stock
 if ($_POST['payment_status'] == 'Completed') { // START STATUS == COMPLETED LOOP

// initialized for the email confirmation
  $products_ordered_store = '';
  $total_tax = 0;
  $subtotal_store = '';


// let's update the stock  
#######################################################

  for ($i=0, $n=sizeof($order->products); $i<$n; $i++) { // PRODUCT LOOP STARTS HERE
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



// Let's get all the info together for the email
    $total_weight += ($order->products[$i]['qty'] * $order->products[$i]['weight']);
    $total_tax += smn_calculate_tax($total_products_price, $products_tax) * $order->products[$i]['qty'];
    $total_cost += $total_products_price;

// Let's get the attributes
  $products_ordered_attributes = '';
   if ( (isset($order->products[$i]['attributes'])) && (sizeof($order->products[$i]['attributes']) > 0) ) {
            for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {
               $products_ordered_attributes .= "\n\t" . $order->products[$i]['attributes'][$j]['option'] . ' ' . $order->products[$i]['attributes'][$j]['value'];
             }
      } 
      
// Let's format the products model       
$products_model = '';      
      if ( !empty($order->products[$i]['model']) ) {
          $products_model = ' (' . $order->products[$i]['model'] . ')';
          } 

// Let's put all the product info together into a string
      $products_ordered .= $order->products[$i]['qty'] . ' x ' . $order->products[$i]['name'] . $products_model . ' = ' . $currencies->display_price($order->products[$i]['final_price'], $order->products[$i]['tax'], $order->products[$i]['qty']) . $products_ordered_attributes . "\n";
		if($order->products[$i]['products_store_id']==$store_id){
			$products_ordered_store .= $order->products[$i]['qty'] . ' x ' . $order->products[$i]['name'] . ' (' . $order->products[$i]['model'] . ') = ' . $currencies->display_price($order->products[$i]['final_price'], $order->products[$i]['tax'], $order->products[$i]['qty']) . $products_ordered_attributes . "\n";
		}
        		$shown_price = smn_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax']) * $order->products[$i]['qty'];
        		$subtotal_store += $shown_price;

				$products_tax_store = $order->products[$i]['tax'];
		
				$products_tax_description_store = $order->products[$i]['tax_description'];
		
				if (DISPLAY_PRICE_WITH_TAX == 'true') {
				  $tax_store += $shown_price - ($shown_price / (($products_tax_store < 10) ? "1.0" . str_replace('.', '', $products_tax_store) : "1." . str_replace('.', '', $products_tax_store)));
				} else {
				  $tax_store += ($products_tax_store / 100) * $shown_price;
				}

}        // PRODUCT LOOP ENDS HERE

		 $shipping_charge_store = $order->info_store[$store_id]['shipping_cost'];
		if (DISPLAY_PRICE_WITH_TAX == 'true') {
        	$total_store = $subtotal_store + $shipping_charge_store;
      	}else{
			$total_store = $subtotal_store + $tax_store + $shipping_charge_store;
		}
		
   		$sql_data_array_store = array('orders_id' => $invoice_id,
  						  'subtotal' => $subtotal_store,
						  'shipping_method' => $order->info_store[$store_id]['shipping_method'],
						  'shipping_charge' => $shipping_charge_store,
						  'total' => $total_store);
						  
		smn_db_perform(TABLE_ORDERS_VENDOR_AMOUNT, $sql_data_array_store);

#######################################################

// lets start with the email confirmation
// $order variables have been changed from checkout_process to work with the variables from the function query () instead of cart () in the order class
  $vendor_query = smn_db_query("select c.*,sd.* from ".TABLE_CUSTOMERS." c,".TABLE_STORE_MAIN." s,".TABLE_STORE_DESCRIPTION." sd where s.store_id=".$store_id." and s.customer_id=c.customers_id and s.store_id=sd.store_id ");
  $vendor_details = smn_db_fetch_array($vendor_query);
  
  define(STORE_NAME,$vendor_details['store_name']);
  define(STORE_OWNER,$vendor_details['customers_firstname'].' '.$vendor_details['customers_lastname']);
  define(STORE_OWNER_EMAIL_ADDRESS,$vendor_details['customers_email_address']);
  
  $email_order = STORE_NAME . "\n" . 
                 EMAIL_SEPARATOR . "\n" . 
                 EMAIL_TEXT_ORDER_NUMBER . ' ' . $invoice_id . "\n" .
                 EMAIL_TEXT_INVOICE_URL . ' ' . smn_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $invoice_id, 'NONSSL', false) . "\n" .
                 EMAIL_TEXT_DATE_ORDERED . ' ' . strftime(DATE_FORMAT_LONG) . "\n\n";
  if ($order->info['comments']) {
    $email_order .= smn_db_output($order->info['comments']) . "\n\n";
  }
  $email_order .= EMAIL_TEXT_PRODUCTS . "\n" . 
                  EMAIL_SEPARATOR . "\n" . 
                  $products_ordered_store . 
                  EMAIL_SEPARATOR . "\n";

 /* for ($i=0, $n=sizeof($order->totals); $i<$n; $i++) {
  $email_order .= strip_tags($order->totals[$i]['title']) . ' ' . strip_tags($order->totals[$i]['text']) . "\n";
  }*/
		$email_order .= 'Sub Total' . ' ' . $currencies->format($subtotal_store) . "\n";
		$email_order .= $order->info_store[$store_id]['shipping_method'] . ' ' . $currencies->format($shipping_charge_store) . "\n";
		$email_order .= 'Total' . ' ' . $currencies->format($total_store) . "\n";

  if ($order->content_type != 'virtual') {
    $email_order .= "\n" . EMAIL_TEXT_DELIVERY_ADDRESS . "\n" . 
                    EMAIL_SEPARATOR . "\n" .
                    smn_address_format($order->delivery['format_id'], $order->delivery,  0, '', "\n") . "\n";
  }

  $email_order .= "\n" . EMAIL_TEXT_BILLING_ADDRESS . "\n" .
                  EMAIL_SEPARATOR . "\n" .
                  smn_address_format($order->billing['format_id'], $order->billing, 0, '', "\n") . "\n\n";
  if (is_object($$payment)) {
    $email_order .= EMAIL_TEXT_PAYMENT_METHOD . "\n" . 
                    EMAIL_SEPARATOR . "\n";
    $payment_class = $$payment;
    $email_order .= $payment_class->title . "\n\n";
    if ($payment_class->email_footer) { 
      $email_order .= $payment_class->email_footer . "\n\n";
    }
  }
  smn_mail($vendor_details['customers_firstname'].' '.$vendor_details['customers_lastname'], $vendor_details['customers_email_address'], EMAIL_TEXT_SUBJECT, $email_order, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);


// send emails to other people
  if (SEND_EXTRA_ORDER_EMAILS_TO != '') {
    smn_mail('', SEND_EXTRA_ORDER_EMAILS_TO, EMAIL_TEXT_SUBJECT, $email_order, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
  }

  
  
} // END STATUS == COMPLETED LOOP

 if ($_POST['payment_status'] == 'Pending') { // START STATUS == PENDING LOOP
 
  $vendor_query = smn_db_query("select c.*,sd.* from ".TABLE_CUSTOMERS." c,".TABLE_STORE_MAIN." s,".TABLE_STORE_DESCRIPTION." sd where s.store_id=".$store_id." and s.customer_id=c.customers_id and s.store_id=sd.store_id ");
  $vendor_details = smn_db_fetch_array($vendor_query);
  
  define(STORE_NAME,$vendor_details['store_name']);
  define(STORE_OWNER,$vendor_details['customers_firstname'].' '.$vendor_details['customers_lastname']);
  define(STORE_OWNER_EMAIL_ADDRESS,$vendor_details['customers_email_address']);
  
  $email_order = STORE_NAME . "\n" . 
                 EMAIL_SEPARATOR . "\n" . 
                 EMAIL_TEXT_ORDER_NUMBER . ' ' . $invoice_id . "\n" .
                 EMAIL_TEXT_INVOICE_URL . ' ' . smn_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $invoice_id, 'NONSSL', false) . "\n" .
                 EMAIL_TEXT_DATE_ORDERED . ' ' . strftime(DATE_FORMAT_LONG) . "\n\n" . 
                 EMAIL_SEPARATOR . "\n" .
                 EMAIL_PAYPAL_PENDING_NOTICE . "\n\n"; 
  smn_mail($vendor_details['customers_firstname'].' '.$vendor_details['customers_lastname'], $vendor_details['customers_email_address'], EMAIL_TEXT_SUBJECT, $email_order, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);


// send emails to other people
  if (SEND_EXTRA_ORDER_EMAILS_TO != '') {
   smn_mail('', SEND_EXTRA_ORDER_EMAILS_TO, EMAIL_TEXT_SUBJECT, $email_order, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
  } 
} // END STATUS == PENDING LOOP

      }
	}else{
	$products_ordered = '';
	$invoice_query = smn_db_query("select orders_id from " . TABLE_ORDERS_INVOICE . " where orders_invoice_id = '" . $_POST['invoice'] . "'");
	 while ($invoice = smn_db_fetch_array($invoice_query)){
	  $invoice_id = $invoice[orders_id];
	  $store_query = smn_db_query("select store_id from " . TABLE_ORDERS . " where orders_id = '" . $invoice_id . "'");
	  $store = smn_db_fetch_array($store_query);
	  $store_id = $store[store_id];
	  
      $order_query = smn_db_query("select currency, currency_value from " . TABLE_ORDERS . " where orders_id = '" . $invoice_id . "' and customers_id = '" . (int)$_POST['custom'] . "'");
      if (smn_db_num_rows($order_query) > 0) {
        $order_db = smn_db_fetch_array($order_query);
        
      // let's re-create the required arrays
         $order = new order($invoice_id);
         
        // let's update the order status
        $total_query = smn_db_query("select value from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $invoice_id . "' and class = 'ot_total' limit 1");
        $total = smn_db_fetch_array($total_query);

        $comment_status = $_POST['payment_status'] . ' (' . ucfirst($_POST['payer_status']) . '; ' . $currencies->format($_POST['mc_gross'], false, $_POST['mc_currency']) . ')';

        if ($_POST['payment_status'] == 'Pending') {
          $comment_status .= '; ' . $_POST['pending_reason'];
        } elseif ( ($_POST['payment_status'] == 'Reversed') || ($_POST['payment_status'] == 'Refunded') ) {
          $comment_status .= '; ' . $_POST['reason_code'];
        } elseif ( ($_POST['payment_status'] == 'Completed') && (MODULE_PAYMENT_PAYPAL_IPN_SHIPPING == 'True') ) {
          $comment_status .= ", \n" . PAYPAL_ADDRESS . ": " . $_POST['address_name'] . ", " . $_POST['address_street'] . ", " . $_POST['address_city'] . ", " . $_POST['address_zip'] . ", " . $_POST['address_state'] . ", " . $_POST['address_country'] . ", " . $_POST['address_country_code'] . ", " . $_POST['address_status'];
        } 

$order_status_id = DEFAULT_ORDERS_STATUS_ID;
 
// modified AlexStudio's Rounding error bug fix 
// variances of up to 0.05 on either side (plus / minus) are ignored
        if (
         (((number_format($total['value'] * $order_db['currency_value'], $currencies->get_decimal_places($order_db['currency']))) -  $_POST['mc_gross']) <= 0.05)  
         &&
          (((number_format($total['value'] * $order_db['currency_value'], $currencies->get_decimal_places($order_db['currency']))) -  $_POST['mc_gross']) >= -0.05)          
        ) {

// previous validation

// Terra -> modified update. If payment status is "completed" than a completed order status is chosen based on the admin settings 
          if ( (MODULE_PAYMENT_PAYPAL_IPN_COMP_ORDER_STATUS_ID > 0) && ($_POST['payment_status'] == 'Completed') ) {
            $order_status_id = MODULE_PAYMENT_PAYPAL_IPN_COMP_ORDER_STATUS_ID;
          } elseif (MODULE_PAYMENT_PAYPAL_IPN_ORDER_STATUS_ID > 0) {
            $order_status_id = MODULE_PAYMENT_PAYPAL_IPN_ORDER_STATUS_ID;
          } 
          
       }

        // Let's see what the PayPal payment status is and set the notification accordingly
        // more info: https://www.paypal.com/IntegrationCenter/ic_ipn-pdt-variable-reference.html
        if ( ($_POST['payment_status'] == 'Pending') || ($_POST['payment_status'] == 'Completed')) {
          $customer_notified = '1'; 
          } else {
          $customer_notified = '0'; 
        }


        smn_db_query("update " . TABLE_ORDERS . " set orders_status = '" . $order_status_id . "', last_modified = now() where orders_id = '" . $invoice_id . "'");

        $sql_data_array = array('orders_id' => $invoice_id,
                                'orders_status_id' => $order_status_id,
                                'date_added' => 'now()',
                                'customer_notified' => $customer_notified,
                                'comments' => 'PayPal IPN Verified [' . $comment_status . ']');

        smn_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);

// If the order is pending, then we want to send a notification email to the customer

// If the order is completed, then we want to send the order email and update the stock
 if ($_POST['payment_status'] == 'Completed') { // START STATUS == COMPLETED LOOP

// initialized for the email confirmation
  $products_ordered_store = '';
  $total_tax = 0;
  $subtotal_store = '';


// let's update the stock  
#######################################################

  for ($i=0, $n=sizeof($order->products); $i<$n; $i++) { // PRODUCT LOOP STARTS HERE
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



// Let's get all the info together for the email
    $total_weight += ($order->products[$i]['qty'] * $order->products[$i]['weight']);
    $total_tax += smn_calculate_tax($total_products_price, $products_tax) * $order->products[$i]['qty'];
    $total_cost += $total_products_price;

// Let's get the attributes
  $products_ordered_attributes = '';
   if ( (isset($order->products[$i]['attributes'])) && (sizeof($order->products[$i]['attributes']) > 0) ) {
            for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {
               $products_ordered_attributes .= "\n\t" . $order->products[$i]['attributes'][$j]['option'] . ' ' . $order->products[$i]['attributes'][$j]['value'];
             }
      } 
      
// Let's format the products model       
$products_model = '';      
      if ( !empty($order->products[$i]['model']) ) {
          $products_model = ' (' . $order->products[$i]['model'] . ')';
          } 

// Let's put all the product info together into a string
      $products_ordered .= $order->products[$i]['qty'] . ' x ' . $order->products[$i]['name'] . $products_model . ' = ' . $currencies->display_price($order->products[$i]['final_price'], $order->products[$i]['tax'], $order->products[$i]['qty']) . $products_ordered_attributes . "\n";
		if($order->products[$i]['products_store_id']==$store_id){
			$products_ordered_store .= $order->products[$i]['qty'] . ' x ' . $order->products[$i]['name'] . ' (' . $order->products[$i]['model'] . ') = ' . $currencies->display_price($order->products[$i]['final_price'], $order->products[$i]['tax'], $order->products[$i]['qty']) . $products_ordered_attributes . "\n";
		}
        		$shown_price = smn_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax']) * $order->products[$i]['qty'];
        		$subtotal_store += $shown_price;

				$products_tax_store = $order->products[$i]['tax'];
		
				$products_tax_description_store = $order->products[$i]['tax_description'];
		
				if (DISPLAY_PRICE_WITH_TAX == 'true') {
				  $tax_store += $shown_price - ($shown_price / (($products_tax_store < 10) ? "1.0" . str_replace('.', '', $products_tax_store) : "1." . str_replace('.', '', $products_tax_store)));
				} else {
				  $tax_store += ($products_tax_store / 100) * $shown_price;
				}

}        // PRODUCT LOOP ENDS HERE

		 $shipping_charge_store = $order->info_store[$store_id]['shipping_cost'];
		if (DISPLAY_PRICE_WITH_TAX == 'true') {
        	$total_store = $subtotal_store + $shipping_charge_store;
      	}else{
			$total_store = $subtotal_store + $tax_store + $shipping_charge_store;
		}
		
   		$sql_data_array_store = array('orders_id' => $invoice_id,
  						  'subtotal' => $subtotal_store,
						  'shipping_method' => $order->info_store[$store_id]['shipping_method'],
						  'shipping_charge' => $shipping_charge_store,
						  'total' => $total_store);
						  
		smn_db_perform(TABLE_ORDERS_VENDOR_AMOUNT, $sql_data_array_store);

#######################################################

// lets start with the email confirmation
// $order variables have been changed from checkout_process to work with the variables from the function query () instead of cart () in the order class
  $vendor_query = smn_db_query("select c.*,sd.* from ".TABLE_CUSTOMERS." c,".TABLE_STORE_MAIN." s,".TABLE_STORE_DESCRIPTION." sd where s.store_id=".$store_id." and s.customer_id=c.customers_id and s.store_id=sd.store_id ");
  $vendor_details = smn_db_fetch_array($vendor_query);
  
  define(STORE_NAME,$vendor_details['store_name']);
  define(STORE_OWNER,$vendor_details['customers_firstname'].' '.$vendor_details['customers_lastname']);
  define(STORE_OWNER_EMAIL_ADDRESS,$vendor_details['customers_email_address']);
  
  $email_order = STORE_NAME . "\n" . 
                 EMAIL_SEPARATOR . "\n" . 
                 EMAIL_TEXT_ORDER_NUMBER . ' ' . $invoice_id . "\n" .
                 EMAIL_TEXT_INVOICE_URL . ' ' . smn_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $invoice_id, 'NONSSL', false) . "\n" .
                 EMAIL_TEXT_DATE_ORDERED . ' ' . strftime(DATE_FORMAT_LONG) . "\n\n";
  if ($order->info['comments']) {
    $email_order .= smn_db_output($order->info['comments']) . "\n\n";
  }
  $email_order .= EMAIL_TEXT_PRODUCTS . "\n" . 
                  EMAIL_SEPARATOR . "\n" . 
                  $products_ordered_store . 
                  EMAIL_SEPARATOR . "\n";

 /* for ($i=0, $n=sizeof($order->totals); $i<$n; $i++) {
  $email_order .= strip_tags($order->totals[$i]['title']) . ' ' . strip_tags($order->totals[$i]['text']) . "\n";
  }*/
		$email_order .= 'Sub Total' . ' ' . $currencies->format($subtotal_store) . "\n";
		$email_order .= $order->info_store[$store_id]['shipping_method'] . ' ' . $currencies->format($shipping_charge_store) . "\n";
		$email_order .= 'Total' . ' ' . $currencies->format($total_store) . "\n";

  if ($order->content_type != 'virtual') {
    $email_order .= "\n" . EMAIL_TEXT_DELIVERY_ADDRESS . "\n" . 
                    EMAIL_SEPARATOR . "\n" .
                    smn_address_format($order->delivery['format_id'], $order->delivery,  0, '', "\n") . "\n";
  }

  $email_order .= "\n" . EMAIL_TEXT_BILLING_ADDRESS . "\n" .
                  EMAIL_SEPARATOR . "\n" .
                  smn_address_format($order->billing['format_id'], $order->billing, 0, '', "\n") . "\n\n";
  if (is_object($$payment)) {
    $email_order .= EMAIL_TEXT_PAYMENT_METHOD . "\n" . 
                    EMAIL_SEPARATOR . "\n";
    $payment_class = $$payment;
    $email_order .= $payment_class->title . "\n\n";
    if ($payment_class->email_footer) { 
      $email_order .= $payment_class->email_footer . "\n\n";
    }
  }
  smn_mail($vendor_details['customers_firstname'].' '.$vendor_details['customers_lastname'], $vendor_details['customers_email_address'], EMAIL_TEXT_SUBJECT, $email_order, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);


// send emails to other people
  if (SEND_EXTRA_ORDER_EMAILS_TO != '') {
    smn_mail('', SEND_EXTRA_ORDER_EMAILS_TO, EMAIL_TEXT_SUBJECT, $email_order, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
  }

  
  
} // END STATUS == COMPLETED LOOP

 if ($_POST['payment_status'] == 'Pending') { // START STATUS == PENDING LOOP
 
  $vendor_query = smn_db_query("select c.*,sd.* from ".TABLE_CUSTOMERS." c,".TABLE_STORE_MAIN." s,".TABLE_STORE_DESCRIPTION." sd where s.store_id=".$store_id." and s.customer_id=c.customers_id and s.store_id=sd.store_id ");
  $vendor_details = smn_db_fetch_array($vendor_query);
  
  define(STORE_NAME,$vendor_details['store_name']);
  define(STORE_OWNER,$vendor_details['customers_firstname'].' '.$vendor_details['customers_lastname']);
  define(STORE_OWNER_EMAIL_ADDRESS,$vendor_details['customers_email_address']);
  
  $email_order = STORE_NAME . "\n" . 
                 EMAIL_SEPARATOR . "\n" . 
                 EMAIL_TEXT_ORDER_NUMBER . ' ' . $invoice_id . "\n" .
                 EMAIL_TEXT_INVOICE_URL . ' ' . smn_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $invoice_id, 'NONSSL', false) . "\n" .
                 EMAIL_TEXT_DATE_ORDERED . ' ' . strftime(DATE_FORMAT_LONG) . "\n\n" . 
                 EMAIL_SEPARATOR . "\n" .
                 EMAIL_PAYPAL_PENDING_NOTICE . "\n\n"; 
  smn_mail($vendor_details['customers_firstname'].' '.$vendor_details['customers_lastname'], $vendor_details['customers_email_address'], EMAIL_TEXT_SUBJECT, $email_order, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);


// send emails to other people
  if (SEND_EXTRA_ORDER_EMAILS_TO != '') {
   smn_mail('', SEND_EXTRA_ORDER_EMAILS_TO, EMAIL_TEXT_SUBJECT, $email_order, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
  } 
} // END STATUS == PENDING LOOP

      }
    }
}
  if ($_POST['payment_status'] == 'Completed') { // START STATUS == Completed LOOP
  
  $email_order = STORE_NAME . "\n" . 
                 EMAIL_SEPARATOR . "\n" . 
                 EMAIL_TEXT_ORDER_NUMBER . ' ' . $invoice_id . "\n" .
                 EMAIL_TEXT_INVOICE_URL . ' ' . smn_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $invoice_id, 'NONSSL', false) . "\n" .
                 EMAIL_TEXT_DATE_ORDERED . ' ' . strftime(DATE_FORMAT_LONG) . "\n\n";
  if ($order->info['comments']) {
    $email_order .= smn_db_output($order->info['comments']) . "\n\n";
  }
  $email_order .= EMAIL_TEXT_PRODUCTS . "\n" . 
                  EMAIL_SEPARATOR . "\n" . 
                  $products_ordered . 
                  EMAIL_SEPARATOR . "\n";

 for ($i=0, $n=sizeof($order->totals); $i<$n; $i++) {
  $email_order .= strip_tags($order->totals[$i]['title']) . ' ' . strip_tags($order->totals[$i]['text']) . "\n";
  }

  if ($order->content_type != 'virtual') {
    $email_order .= "\n" . EMAIL_TEXT_DELIVERY_ADDRESS . "\n" . 
                    EMAIL_SEPARATOR . "\n" .
                    smn_address_format($order->delivery['format_id'], $order->delivery,  0, '', "\n") . "\n";
  }

  $email_order .= "\n" . EMAIL_TEXT_BILLING_ADDRESS . "\n" .
                  EMAIL_SEPARATOR . "\n" .
                  smn_address_format($order->billing['format_id'], $order->billing, 0, '', "\n") . "\n\n";
  if (is_object($$payment)) {
    $email_order .= EMAIL_TEXT_PAYMENT_METHOD . "\n" . 
                    EMAIL_SEPARATOR . "\n";
    $payment_class = $$payment;
    $email_order .= $payment_class->title . "\n\n";
    if ($payment_class->email_footer) { 
      $email_order .= $payment_class->email_footer . "\n\n";
    }
  }
    smn_mail($order->customer['name'], $order->customer['email_address'], EMAIL_TEXT_SUBJECT, $email_order, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
  }
  if ($_POST['payment_status'] == 'Pending') { // START STATUS == Pending LOOP
    $email_order = STORE_NAME . "\n" . 
                 EMAIL_SEPARATOR . "\n" . 
                 EMAIL_TEXT_ORDER_NUMBER . ' ' . $invoice_id . "\n" .
                 EMAIL_TEXT_INVOICE_URL . ' ' . smn_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $invoice_id, 'NONSSL', false) . "\n" .
                 EMAIL_TEXT_DATE_ORDERED . ' ' . strftime(DATE_FORMAT_LONG) . "\n\n" . 
                 EMAIL_SEPARATOR . "\n" .
                 EMAIL_PAYPAL_PENDING_NOTICE . "\n\n"; 
  smn_mail($order->customer['name'], $order->customer['email_address'], EMAIL_TEXT_SUBJECT, $email_order, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
}
  
  }
  
  } else {
    if (smn_not_null(MODULE_PAYMENT_PAYPAL_IPN_DEBUG_EMAIL)) {
      $email_body = '$_POST:' . "\n\n";
      foreach ($_POST as $key => $value) {
        $email_body .= $key . '=' . $value . "\n";
      }
      $email_body .= "\n" . '$_GET:' . "\n\n";
      foreach ($_GET as $key => $value) {
        $email_body .= $key . '=' . $value . "\n";
      }

     smn_mail('', MODULE_PAYMENT_PAYPAL_IPN_DEBUG_EMAIL, 'PayPal IPN Invalid Process', $email_body, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
    }

    if (isset($_POST['invoice']) && is_numeric($_POST['invoice']) && ($_POST['invoice'] > 0)) {
	$invoice_query = smn_db_query("select orders_id from " . TABLE_ORDERS_INVOICE . " where orders_invoice_id = '" . $_POST['invoice'] . "'");
	 while ($invoice_id = smn_db_fetch_array($invoice_query)){
	
      $check_query = smn_db_query("select orders_id from " . TABLE_ORDERS . " where orders_id = '" . $invoice_id . "' and customers_id = '" . (int)$_POST['custom'] . "'");
      if (smn_db_num_rows($check_query) > 0) {
        $comment_status = $_POST['payment_status'];

        if ($_POST['payment_status'] == 'Pending') {
          $comment_status .= '; ' . $_POST['pending_reason'];
        } elseif ( ($_POST['payment_status'] == 'Reversed') || ($_POST['payment_status'] == 'Refunded') ) {
          $comment_status .= '; ' . $_POST['reason_code'];
        }

        smn_db_query("update " . TABLE_ORDERS . " set orders_status = '" . ((MODULE_PAYMENT_PAYPAL_IPN_ORDER_STATUS_ID > 0) ? MODULE_PAYMENT_PAYPAL_IPN_ORDER_STATUS_ID : DEFAULT_ORDERS_STATUS_ID) . "', last_modified = now() where orders_id = '" . $invoice_id . "'");

        $sql_data_array = array('orders_id' => $invoice_id,
                                'orders_status_id' => (MODULE_PAYMENT_PAYPAL_IPN_ORDER_STATUS_ID > 0) ? MODULE_PAYMENT_PAYPAL_IPN_ORDER_STATUS_ID : DEFAULT_ORDERS_STATUS_ID,
                                'date_added' => 'now()',
                                'customer_notified' => '0',
                                'comments' => 'PayPal IPN Invalid [' . $comment_status . ']');

        smn_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);
      }
    }
	
	
  }
  }

  require('includes/application_bottom.php');
?>
