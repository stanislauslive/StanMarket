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
 

// if the customer is not logged on, redirect them to the login page
  if (!smn_session_is_registered('customer_id')) {
    $navigation->set_snapshot(array('mode' => 'NONSSL', 'page' => FILENAME_CHECKOUT_PAYMENT));
    smn_redirect(smn_href_link(FILENAME_LOGIN, '', 'NONSSL'));
  }

// if there is nothing in the customers cart, redirect them to the shopping cart page
  if ($cart->count_contents() < 1) {
    smn_redirect(smn_href_link(FILENAME_SHOPPING_CART));
  }

// avoid hack attempts during the checkout procedure by checking the internal cartID
  if (isset($cart->cartID) && smn_session_is_registered('cartID')) {
    if ($cart->cartID != $cartID) {
      smn_redirect(smn_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'NONSSL'));
    }
  }

// if no shipping method has been selected, redirect the customer to the shipping method selection page
  if (!smn_session_is_registered('shipping')) {
    smn_redirect(smn_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'NONSSL'));
  }

  if (!smn_session_is_registered('payment')) smn_session_register('payment');
  if (isset($_POST['payment'])) $payment = $_POST['payment'];

  if (!smn_session_is_registered('comments')) smn_session_register('comments');
  if (smn_not_null($_POST['comments'])) {
    $comments = smn_db_prepare_input($_POST['comments']);
  }

// load the selected payment module
  require(DIR_WS_CLASSES . 'payment.php');
  $payment_modules = new payment($payment);
 // if ($credit_covers) $payment=''; 

  require(DIR_WS_CLASSES . 'order_total.php');
  require(DIR_WS_CLASSES . 'order.php');
  $order = new order;
  $payment_modules->update_status();
  $order_total_modules = new order_total;
  $order_total_modules->process();
  $order_total_modules->collect_posts();
  $order_total_modules->pre_confirmation_check();
  $payment_modules->update_status();

  if ( (is_array($payment_modules->modules)) && (sizeof($payment_modules->modules) > 1) && (!is_object($$payment)) && (!$credit_covers) ) {
    smn_redirect(smn_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message=' . urlencode(ERROR_NO_PAYMENT_MODULE_SELECTED), 'NONSSL'));
  }
  if (is_array($payment_modules->modules)) {
    $payment_modules->pre_confirmation_check();
  }
// load the selected shipping module
  require(DIR_WS_CLASSES . 'shipping.php');
  $shipping_modules = new shipping($shipping);


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
  /*Added the store id in the link FILENAME_CHECKOUT_SHIPPING by Cimi on June 12,2007*/
  $breadcrumb->add(NAVBAR_TITLE_1, smn_href_link(FILENAME_CHECKOUT_SHIPPING, 'ID='.$_REQUEST['ID'], 'NONSSL'));
  $breadcrumb->add(NAVBAR_TITLE_2);

?>