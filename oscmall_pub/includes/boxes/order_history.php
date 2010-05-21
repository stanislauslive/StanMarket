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

  if (smn_session_is_registered('customer_id')) {
// retreive the last x products purchased
    $orders_query = smn_db_query("select distinct op.products_id from " . TABLE_ORDERS . " o, " . TABLE_ORDERS_PRODUCTS . " op, " . TABLE_PRODUCTS . " p where o.customers_id = '" . (int)$customer_id . "' and o.orders_id = op.orders_id and op.products_id = p.products_id and p.products_status = '1' group by products_id order by o.date_purchased desc limit " . MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX);
    if (smn_db_num_rows($orders_query)) {

      $boxHeading = BOX_HEADING_CUSTOMER_ORDERS;
      $box_base_name = 'order_history';
      $box_id = $box_base_name . 'Box';
      $product_ids = '';
      while ($orders = smn_db_fetch_array($orders_query)) {
        $product_ids .= (int)$orders['products_id'] . ',';
      }
      $product_ids = substr($product_ids, 0, -1);

      $boxContent = '<table border="0" width="100%" cellspacing="0" cellpadding="1">';
      $products_query = smn_db_query("select p.products_id, p.store_id, pd.products_name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = pd.products_id and pd.products_id in (" . $product_ids . ") and pd.language_id = '" . (int)$languages_id . "' order by products_name");
      while ($products = smn_db_fetch_array($products_query)) {
        $boxContent .= '  <tr>' .
                                   '    <td class="infoBoxContents"><a href="' . smn_href_link(FILENAME_PRODUCT_INFO, 'ID=' . $products['store_id'] . '&products_id=' . $products['products_id']) . '">' . $products['products_name'] . '</a></td>' .
                                   '    <td class="infoBoxContents" align="right" valign="top"><a href="' . smn_href_link(basename($PHP_SELF), smn_get_all_get_params(array('action')) . 'action=cust_order&pid=' . $products['products_id']) . '">' . smn_image(DIR_WS_ICONS . 'cart.gif', ICON_CART) . '</a></td>' .
                                   '  </tr>';
      }
      $boxContent .= '</table>';

    if(file_exists(DIR_WS_BOX_TEMPLATES . $box_base_name . '.php')) {
      require(DIR_WS_BOX_TEMPLATES . $box_base_name . '.php');
    }else{
      require(DEFAULT_TEMPLATENAME_BOX);
    }
    $boxContent_attributes = '';

    }
  }
?>
