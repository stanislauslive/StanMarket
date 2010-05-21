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

  $boxHeading = BOX_HEADING_SHOPPING_CART;
  $boxLink = '<a href="' . smn_href_link(FILENAME_SHOPPING_CART, 'ID=' . $store_id) . '"><img src="images/infobox/arrow_right.gif" border="0" alt="more" title=" more " width="12" height="10"></a>';
  $box_base_name = 'shopping_cart';
  $box_id = $box_base_name . 'Box';
  $boxContent = '';
  if ($cart->count_contents() > 0) {
    
    
    
    $boxContent = '<table border="0" width="100%" cellspacing="0" cellpadding="0">';
    $products = $cart->get_products();
    for ($i=0, $n=sizeof($products); $i<$n; $i++) {
      $boxContent .= '<tr><td align="right" valign="top" class="infoBoxContents">';

      if ((smn_session_is_registered('new_products_id_in_cart')) && ($new_products_id_in_cart == $products[$i]['id'])) {
        $boxContent .= '<span class="newItemInCart">';
      } else {
        $boxContent .= '<span class="infoBoxContents">';
      }

      $boxContent .= $products[$i]['quantity'] . '&nbsp;x&nbsp;</span></td><td valign="top" class="infoBoxContents"><a href="' . smn_href_link(FILENAME_PRODUCT_INFO, 'ID=' . $products[$i]['store_id'] . '&products_id=' .$products[$i]['id']) . '">';

      if ((smn_session_is_registered('new_products_id_in_cart')) && ($new_products_id_in_cart == $products[$i]['id'])) {
        $boxContent .= '<span class="newItemInCart">';
      } else {
        $boxContent .= '<span class="infoBoxContents">';
      }

      $boxContent .= $products[$i]['name'] . '</span></a></td></tr>';

      if ((smn_session_is_registered('new_products_id_in_cart')) && ($new_products_id_in_cart == $products[$i]['id'])) {
        smn_session_unregister('new_products_id_in_cart');
      }
    }
    $boxContent .= '</table>';
  } else {
    $boxContent .= BOX_SHOPPING_CART_EMPTY;
  }

  if ($cart->count_contents() > 0) {
    $boxContent .= smn_draw_separator();
    $boxContent .= '<div align="right">' . $currencies->format($cart->show_total()) . '</div>';
    $boxContent .= '<div align="left"><a href="' . smn_href_link(FILENAME_CHECKOUT_SELECT, 'ID=' . $store_id) . '">' . smn_image(TEMPLATE_IMAGES . 'table_background_cart.gif', HEADER_TITLE_CHECKOUT) . '</a></div>';
  }

  if (smn_session_is_registered('customer_id')) {
    $gv_query = smn_db_query("select amount from " . TABLE_COUPON_GV_CUSTOMER . " where customer_id = '" . $customer_id . "'");
    $gv_result = smn_db_fetch_array($gv_query);
    if ($gv_result['amount'] > 0 ) {
      $boxContent .= smn_draw_separator();
      $boxContent .= '<table cellpadding="0" width="100%" cellspacing="0" border="0"><tr><td class="smalltext">' . VOUCHER_BALANCE . '</td><td class="smalltext" align="right" valign="bottom">' . $currencies->format($gv_result['amount']) . '</td></tr></table>';
      $boxContent .= '<table cellpadding="0" width="100%" cellspacing="0" border="0"><tr><td class="smalltext"><a href="'. smn_href_link(FILENAME_GV_SEND, 'ID=' . $store_id) . '">' . BOX_SEND_TO_FRIEND . '</a></td></tr></table>';
    }
  }
  if (smn_session_is_registered('gv_id')) {
    $gv_query = smn_db_query("select coupon_amount from " . TABLE_COUPONS . " where coupon_id = '" . $gv_id . "'");
    $coupon = smn_db_fetch_array($gv_query);
    $boxContent .= smn_draw_separator();
    $boxContent .= '<table cellpadding="0" width="100%" cellspacing="0" border="0"><tr><td class="smalltext">' . VOUCHER_REDEEMED . '</td><td class="smalltext" align="right" valign="bottom">' . $currencies->format($coupon['coupon_amount']) . '</td></tr></table>';

  }

if (smn_session_is_registered('cc_id') && $cc_id) {
 $coupon_query = smn_db_query("select c.*, cd.* from " . TABLE_COUPONS . "c,  " . TABLE_COUPONS_DESCRIPTION . " cd where cd.coupon_id = '" . $cc_id . "' and c.coupon_id = '" . $cc_id . "' and cd.language_id = '" . $languages_id . "'");
 $coupon = smn_db_fetch_array($coupon_query);
 
 $coupon_desc_query = smn_db_query("select * from " . TABLE_COUPONS_DESCRIPTION . " where coupon_id = '" . $cc_id . "' and language_id = '" . $languages_id . "'");
 $coupon_desc = smn_db_fetch_array($coupon_desc_query);
 $text_coupon_help = sprintf("%s",$coupon_desc['coupon_name']);
   $boxContent .= smn_draw_separator();
   $boxContent .= '<table cellpadding="0" width="100%" cellspacing="0" border="0"><tr><td class="infoBoxContents">' . CART_COUPON . $text_coupon_help . '<br>' . '</td></tr></table>';
   } 

  if(file_exists(DIR_WS_BOX_TEMPLATES . $box_base_name . '.php')){
      require(DIR_WS_BOX_TEMPLATES . $box_base_name . '.php');
  }else {
      require(DEFAULT_TEMPLATENAME_BOX);
  }
  $boxContent_attributes = '';
  $boxLink = '';
?>