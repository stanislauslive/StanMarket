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


  require('includes/classes/http_client.php');

if (smn_get_configuration_key_value('MODULE_SHIPPING_FREESHIPPER_STATUS') and $cart->show_weight()!=0) {
  smn_session_unregister('shipping');
/*Unregister the shipping_store session,by Cimi*/
  smn_session_unregister('shipping_store');
}

// if the customer is not logged on, redirect them to the login page
  if (!smn_session_is_registered('customer_id')) {
    $navigation->set_snapshot();
    smn_redirect(smn_href_link(FILENAME_LOGIN, '', 'NONSSL'));
  }

// if there is nothing in the customers cart, redirect them to the shopping cart page
  if ($cart->count_contents() < 1) {
    smn_redirect(smn_href_link(FILENAME_SHOPPING_CART));
  }

// if no shipping destination address was selected, use the customers own address as default
  if (!smn_session_is_registered('sendto')) {
    smn_session_register('sendto');
    $sendto = $customer_default_address_id;
  } else {
// verify the selected shipping address
    if ( (is_array($sendto) && empty($sendto)) || is_numeric($sendto) ) {
        $check_address_query = smn_db_query("select count(*) as total from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int)$customer_id . "' and address_book_id = '" . (int)$sendto . "'");
        $check_address = smn_db_fetch_array($check_address_query);

        if ($check_address['total'] != '1') {
          $sendto = $customer_default_address_id;
          if (smn_session_is_registered('shipping')) smn_session_unregister('shipping');
/*Unregister the session shipping_store,By Cimi*/
	      if (smn_session_is_registered('shipping_store')) smn_session_unregister('shipping_store');
        }
    }
  }
  // get the order class and create a new object
  require(DIR_WS_CLASSES . 'order.php');
  $order = new order;

// register a random ID in the session to check throughout the checkout procedure
// against alterations in the shopping cart contents
  if (!smn_session_is_registered('cartID')) smn_session_register('cartID');
  $cartID = $cart->cartID;

// if the order contains only virtual products, forward the customer to the billing page as
// a shipping address is not needed
  if (($order->content_type == 'virtual') || ($order->content_type == 'virtual_weight') ) {
    if (!smn_session_is_registered('shipping')) smn_session_register('shipping');
/*Unregister the session shipping_store,By Cimi*/
	if (!smn_session_is_registered('shipping_store')) smn_session_register('shipping_store');
    $shipping = false;
    $sendto = false;
    smn_redirect(smn_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'NONSSL'));
  }

  $total_weight = $cart->show_weight($store_id);
  $total_count = $cart->count_contents($store_id);

// load all enabled shipping modules
  require(DIR_WS_CLASSES . 'shipping.php');
  $shipping_modules = new shipping;

  if ( defined('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING') && (MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING == 'true') ) {
    $pass = false;

    switch (MODULE_ORDER_TOTAL_SHIPPING_DESTINATION) {
      case 'national':
        if ($order->delivery['country_id'] == $store->get_store_country()) {
          $pass = true;
        }
        break;
      case 'international':
        if ($order->delivery['country_id'] != $store->get_store_country()) {
          $pass = true;
        }
        break;
      case 'both':
        $pass = true;
        break;
    }

    $free_shipping = false;
    if ( ($pass == true) && ($order->info['total'] >= MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER) ) {
      $free_shipping = true;

        $content_query = smn_db_query("select text_key, text_content from " . TABLE_WEB_SITE_CONTENT . " where store_id = '" . $store_id . "' " . " and page_name = 'ot_shipping'");
        while ($text_contents = smn_db_fetch_array($content_query)){
          define($text_contents['text_key'], $text_contents['text_content']);
        }
    }
  } else {
    $free_shipping = false;
  }

// process the selected shipping method
  if ( isset($_POST['action']) && ($_POST['action'] == 'process') ) {
/*Added the code to get the shpping charges of each module for each store,by Cimi*/
	if(ALLOW_STORE_PAYMENT=='false'){
		$quotes_store = $shipping_modules->quote_store();
		}
    if (!smn_session_is_registered('comments')) smn_session_register('comments');
    if (smn_not_null($_POST['comments'])) {
      $comments = smn_db_prepare_input($_POST['comments']);
    }

    if (!smn_session_is_registered('shipping')) smn_session_register('shipping');
/*Register the session shipping_store,By Cimi*/
	if (!smn_session_is_registered('shipping_store')) smn_session_register('shipping_store');

    if ( (smn_count_shipping_modules() > 0) || ($free_shipping == true) ) {
      if ( (isset($_POST['shipping'])) && (strpos($_POST['shipping'], '_')) ) {
        $shipping = $_POST['shipping'];

        list($module, $method) = explode('_', $shipping);
        if ( is_object($$module) || ($shipping == 'free_free') ) {
          if ($shipping == 'free_free') {
            $quote[0]['methods'][0]['title'] = FREE_SHIPPING_TITLE;
            $quote[0]['methods'][0]['cost'] = '0';
          } else {
            $quote = $shipping_modules->quote($method, $module);
          }
          if (isset($quote['error'])) {
            smn_session_unregister('shipping');
/*Unregister the session shipping_store,By Cimi*/
			smn_session_unregister('shipping_store');
          } else {
            if ( (isset($quote[0]['methods'][0]['title'])) && (isset($quote[0]['methods'][0]['cost'])) ) {
              $shipping = array('id' => $shipping,
                                'title' => (($free_shipping == true) ?  $quote[0]['methods'][0]['title'] : $quote[0]['module'] . ' (' . $quote[0]['methods'][0]['title'] . ')'),
                                'cost' => $quote[0]['methods'][0]['cost']);
/*Added code to register shipping charge of selected module of each store,By Cimi*/
			if(ALLOW_STORE_PAYMENT=='false'){
  			  $store_list = $cart->get_store_list();
			  for($k=0;$k<sizeof($store_list);$k++){
				  foreach($quotes_store as $key=>$value){
			  	  	if(array_search($quote[0]['id'],$quotes_store[$key][$store_list[$k]])) $k1 = $key;
				  }
				  foreach($quotes_store[$k1][$store_list[$k]]['methods'] as $key1=>$value1){
			  	  	if(array_search($quote[0]['methods'][0]['id'],$value1)) $k2 = $key1;
				  }
			  	  $shipping_cost_store = $quotes_store[$k1][$store_list[$k]]['methods'][$k2]['cost'];
				  $shipping_store[$store_list[$k]] = array('id' => $_POST['shipping'],
									'title' => (($free_shipping == true) ?  $quote[0]['methods'][0]['title'] : $quote[0]['module'] . ' (' . $quote[0]['methods'][0]['title'] . ')'),
									'cost' => $shipping_cost_store);
			  }
			  }
              smn_redirect(smn_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'NONSSL'));
            }
          }
        } else {
          smn_session_unregister('shipping');
/*Unregister the session shipping_store,By Cimi*/
		  smn_session_unregister('shipping_store');
        }
      }
    } else {
      $shipping = false;
                
      smn_redirect(smn_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'NONSSL'));
    }    
  }

// get all available shipping quotes

  $quotes = $shipping_modules->quote();

// if no shipping method has been selected, automatically select the cheapest method.
// if the modules status was changed when none were available, to save on implementing
// a javascript force-selection method, also automatically select the cheapest shipping
// method if more than one module is now enabled
  if ( !smn_session_is_registered('shipping') || ( smn_session_is_registered('shipping') && ($shipping == false) && (smn_count_shipping_modules() > 1) ) ) $shipping = $shipping_modules->cheapest();


  $breadcrumb->add(NAVBAR_TITLE_1, smn_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'NONSSL'));
  $breadcrumb->add(NAVBAR_TITLE_2, smn_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'NONSSL'));

?>