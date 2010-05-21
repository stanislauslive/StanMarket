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
?>
<table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php
  if (sizeof($products_new_array) < 1) {
?>
  <tr>
    <td class="main"><?php echo TEXT_NO_NEW_PRODUCTS; ?></td>
  </tr>
<?php
  } else {
    for($i=0, $n=sizeof($products_new_array); $i<$n; $i++) {
      $store_images = 'images/'. $products_new_array[$i]['store_id'] . '_images/';
      if (isset($products_new_array[$i]['specials_price'])) {
        $products_price = '<s>' .  $currencies->display_price($products_new_array[$i]['price'], smn_get_tax_rate($products_new_array[$i]['tax_class_id'], '', '', $products_new_array[$i]['store_id'])) . '</s>&nbsp;&nbsp;<span class="productSpecialPrice">' . $currencies->display_price($products_new_array[$i]['specials_price'], smn_get_tax_rate($products_new_array[$i]['tax_class_id'], '', '', $products_new_array[$i]['store_id'])) . '</span>';
      } else {
        $products_price = $currencies->display_price($products_new_array[$i]['price'], smn_get_tax_rate($products_new_array[$i]['tax_class_id'], '', '', $products_new_array[$i]['store_id']));
      }
?>
  <tr>
    <td width="<?php echo SMALL_IMAGE_WIDTH + 10; ?>" valign="top" class="main"><?php echo '<a href="' . smn_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products_new_array[$i]['id'] . '&ID=' . $products_new_array[$i]['store_id']) . '">' . smn_image($store_images . $products_new_array[$i]['image'], $products_new_array[$i]['name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a>'; ?></td>
    <td valign="top" class="main"><?php echo '<a href="' . smn_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products_new_array[$i]['id'] . '&ID=' . $products_new_array[$i]['store_id']) . '"><b><u>' . $products_new_array[$i]['name'] . '</u></b></a><br>' . TEXT_DATE_ADDED . ' ' . $products_new_array[$i]['date_added'] . '<br>' . TEXT_MANUFACTURER . ' ' . $products_new_array[$i]['manufacturer'] . '<br><br>' . TEXT_PRICE . ' ' . $products_price; ?></td>
    <td align="right" valign="middle" class="main"><?php echo '<a href="' . smn_href_link(FILENAME_PRODUCTS_NEW, smn_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $products_new_array[$i]['id'] . '&ID=' . $products_new_array[$i]['store_id']) . '">' . smn_image_button('button_in_cart.gif', IMAGE_BUTTON_IN_CART) . '</a>'; ?></td>
  </tr>
<?php
      if (($i+1) != $n) {
?>
  <tr>
    <td colspan="3" class="main">&nbsp;</td>
  </tr>
<?php
      }
    }
  }
?>
</table>
