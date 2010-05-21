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
   
//added to reset whether a gift voucher is used or not on this order
if (smn_session_is_registered('cot_gv')) smn_session_unregister('cot_gv');  

// if the customer is not logged on, redirect them to the login page
  if (!smn_session_is_registered('customer_id')) {
    $navigation->set_snapshot();
    smn_redirect(smn_href_link(FILENAME_LOGIN, '', 'NONSSL'));
  }

// if there is nothing in the customers cart, redirect them to the shopping cart page
  if ($cart->count_contents() < 1) {
    smn_redirect(smn_href_link(FILENAME_SHOPPING_CART));
  }

// if no shipping method has been selected, redirect the customer to the shipping method selection page
  if (!smn_session_is_registered('shipping')) {
    smn_redirect(smn_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'NONSSL'));
  }

// avoid hack attempts during the checkout procedure by checking the internal cartID
  if (isset($cart->cartID) && smn_session_is_registered('cartID')) {
    if ($cart->cartID != $cartID) {
      smn_redirect(smn_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'NONSSL'));
    }
  }
  
// if we have been here before and are coming back get rid of the credit covers variable CCGV Contribution
	if(smn_session_is_registered('credit_covers')) smn_session_unregister('credit_covers');
        
// Stock Check
  if ( (STOCK_CHECK == 'true') && (STOCK_ALLOW_CHECKOUT != 'true') ) {
    $products = $cart->get_products($store_id);
    for ($i=0, $n=sizeof($products); $i<$n; $i++) {
      if (smn_check_stock($products[$i]['id'], $products[$i]['quantity'])) {
        smn_redirect(smn_href_link(FILENAME_SHOPPING_CART));
        break;
      }
    }
  }

 require(DIR_WS_CLASSES . 'shipping.php');
 $shipping_modules = new shipping($shipping);

// if no billing destination address was selected, use the customers own address as default
  if (!smn_session_is_registered('billto')) {
    smn_session_register('billto');
    $billto = $customer_default_address_id;
  } else {
// verify the selected billing address
    if ( (is_array($billto) && empty($billto)) || is_numeric($billto) ) {
        $check_address_query = smn_db_query("select count(*) as total from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int)$customer_id . "' and address_book_id = '" . (int)$billto . "'");
        $check_address = smn_db_fetch_array($check_address_query);

        if ($check_address['total'] != '1') {
          $billto = $customer_default_address_id;
          if (smn_session_is_registered('payment')) smn_session_unregister('payment');
        }
    }
  }

  require(DIR_WS_CLASSES . 'order.php');
  $order = new order;

  require(DIR_WS_CLASSES . 'order_total.php');
  $order_total_modules = new order_total;
  $order_total_modules->clear_posts();


  if (!smn_session_is_registered('comments')) smn_session_register('comments');
  if (isset($HTTP_POST_VARS['comments']) && smn_not_null($HTTP_POST_VARS['comments'])) {
	  $comments = smn_db_prepare_input($HTTP_POST_VARS['comments']);
  }
  $total_weight = $cart->show_weight();
  $total_count = $cart->count_contents();
  $total_count = $cart->count_contents_virtual();
  
// load all enabled payment modules
  require(DIR_WS_CLASSES . 'payment.php');
  $payment_modules = new payment;

  $breadcrumb->add(NAVBAR_TITLE_1, smn_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'NONSSL'));
  $breadcrumb->add(NAVBAR_TITLE_2, smn_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'NONSSL'));

?>