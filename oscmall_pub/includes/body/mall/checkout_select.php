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
<? if (ALLOW_STORE_PAYMENT=='true'){?>
     <table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo THANK_YOU_HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo smn_image(DIR_WS_IMAGES . 'table_background_checkout.gif', HEADING_TITLE); ?></td>
	  </tr>
	  <tr>
	    <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
	  </tr>
	</table></td>
      </tr><?php echo smn_draw_form('cart_quantity', smn_href_link(FILENAME_CHECKOUT_SELECT, 'action=update_product')); ?>
<?php
  $store_list = $cart->get_store_list();
  // systemsmanager begin - wifi mods 
  // prods are not being displayed in the select page because the store_id is wrong in the customers_basket table for each prod
  //print_r($store_list);
  
  for( $k=0; $k< sizeof($store_list); $k++) {
    $checkout_store_name_query = smn_db_query("select store_name from " . TABLE_STORE_DESCRIPTION . " where store_id = '" . (int)$store_list[$k] . "'");   
    $checkout_store_name = smn_db_fetch_array($checkout_store_name_query);
?>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td align="left" class="main"><?php echo TEXT_THANK_YOU_FOR_SHOPPING_HERE . $checkout_store_name['store_name']; ?></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td>
	  <table border="0" width="100%" cellspacing="0" cellpadding="2"><tr><td>
<?php
    $info_box_contents = array();
    $info_box_contents[0][] = array('align' => 'center',
                                    'params' => 'class="productListing-heading"',
                                    'text' => TABLE_HEADING_REMOVE);

    $info_box_contents[0][] = array('params' => 'class="productListing-heading"',
                                    'text' => TABLE_HEADING_PRODUCTS);

    $info_box_contents[0][] = array('align' => 'center',
                                    'params' => 'class="productListing-heading"',
                                    'text' => TABLE_HEADING_QUANTITY);

    $info_box_contents[0][] = array('align' => 'right',
                                    'params' => 'class="productListing-heading"',
                                    'text' => TABLE_HEADING_TOTAL);

    $any_out_of_stock = 0;
    $products = $cart->get_products($store_list[$k]);
    for ($i=0, $n=sizeof($products); $i<$n; $i++) {
      $store_images = 'images/'. $products[$i]['store_id'] . '_images/';
// Push all attributes information in an array
      if (isset($products[$i]['attributes']) && is_array($products[$i]['attributes'])) {
        while (list($option, $value) = each($products[$i]['attributes'])) {
          echo smn_draw_hidden_field('id[' . $products[$i]['id'] . '][' . $option . ']', $value);
          $attributes = smn_db_query("select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix
                                      from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa
                                      where pa.products_id = '" . $products[$i]['id'] . "'
                                       and pa.options_id = '" . $option . "'
                                       and pa.options_id = popt.products_options_id
                                       and pa.options_values_id = '" . $value . "'
                                       and pa.options_values_id = poval.products_options_values_id
                                       and popt.language_id = '" . $languages_id . "'
                                       and poval.language_id = '" . $languages_id . "'");
          $attributes_values = smn_db_fetch_array($attributes);
          $products[$i][$option]['products_options_name'] = $attributes_values['products_options_name'];
          $products[$i][$option]['options_values_id'] = $value;
          $products[$i][$option]['products_options_values_name'] = $attributes_values['products_options_values_name'];
          $products[$i][$option]['options_values_price'] = $attributes_values['options_values_price'];
          $products[$i][$option]['price_prefix'] = $attributes_values['price_prefix'];
        }
      }
    }
    $cart_total = 0;
    for ($i=0, $n=sizeof($products); $i<$n; $i++) {
      if (($i/2) == floor($i/2)) {
        $info_box_contents[] = array('params' => 'class="productListing-even"');
      } else {
        $info_box_contents[] = array('params' => 'class="productListing-odd"');
      }

      $cur_row = sizeof($info_box_contents) - 1;

      $info_box_contents[$cur_row][] = array('align' => 'center',
                                             'params' => 'class="productListing-data" valign="top"',
                                             'text' => smn_draw_checkbox_field('cart_delete[]', $products[$i]['id']));

      $products_name = '<table border="0" cellspacing="2" cellpadding="2">' .
                       '  <tr>' .
                       '    <td class="productListing-data" align="center"><a href="' . smn_href_link(FILENAME_PRODUCT_INFO, 'ID=' . $store_list[$k] . '&products_id=' . $products[$i]['id']) . '">' . smn_image($store_images . $products[$i]['image'], $products[$i]['name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a></td>' .
                       '    <td class="productListing-data" valign="top"><a href="' . smn_href_link(FILENAME_PRODUCT_INFO, 'ID=' . $store_list[$k] . '&products_id=' . $products[$i]['id']) . '"><b>' . $products[$i]['name'] . '</b></a>';

      if (STOCK_CHECK == 'true') {
        $stock_check = smn_check_stock($products[$i]['id'], $products[$i]['quantity']);
        if (smn_not_null($stock_check)) {
          $any_out_of_stock = 1;

          $products_name .= $stock_check;
        }
      }

      if (isset($products[$i]['attributes']) && is_array($products[$i]['attributes'])) {
        reset($products[$i]['attributes']);
        while (list($option, $value) = each($products[$i]['attributes'])) {
          $products_name .= '<br><small><i> - ' . $products[$i][$option]['products_options_name'] . ' ' . $products[$i][$option]['products_options_values_name'] . '</i></small>';
        }
      }

      $products_name .= '    </td>' .
                        '  </tr>' .
                        '</table>';

      $info_box_contents[$cur_row][] = array('params' => 'class="productListing-data"',
                                             'text' => $products_name);

      $info_box_contents[$cur_row][] = array('align' => 'center',
                                             'params' => 'class="productListing-data" valign="top"',
                                             'text' => smn_draw_input_field('cart_quantity[]', $products[$i]['quantity'], 'size="4"') . smn_draw_hidden_field('products_id[]', $products[$i]['id']));

      $info_box_contents[$cur_row][] = array('align' => 'right',
                                             'params' => 'class="productListing-data" valign="top"',
                                             'text' => '<b>' . $currencies->display_price($products[$i]['final_price'], smn_get_tax_rate($products[$i]['tax_class_id']), $products[$i]['quantity']) . '</b>');
					     
    $cart_total += ($products[$i]['final_price'] * $products[$i]['quantity']) ;
    }

    new productListingBox($info_box_contents);
?>

</td></tr></table></td></tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td align="right" class="main"><b><?php echo SUB_TITLE_SUB_TOTAL; ?> <?php echo $currencies->format($cart_total); ?></b></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
  	 	<td align="left" class="main"><?php echo TEXT_BUY_PRODUCTS_IN_STORE . $checkout_store_name['store_name']; ?></td>
		<td align="right" class="main"><a href="<?php echo smn_href_link(FILENAME_CHECKOUT_SHIPPING, 'ID=' . $store_list[$k], 'NONSSL'); ?>"><?php echo smn_image_button('button_checkout.gif', IMAGE_BUTTON_CHECKOUT); ?></a></td>
		<td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
  }
?>
      <tr>
        <td><?php  echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>	
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
	  	<td align="left" class="main"><?php echo TEXT_UPDATE_SHOPPING_CART; ?></td>
		<td align="right" class="main"><?php echo smn_image_submit('button_update_cart.gif', IMAGE_BUTTON_UPDATE_CART); ?></td>
                <td width="10" align="right"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr></form>
      <tr>
        <td><?php  echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>	
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
	  	<td align="left" class="main"><?php echo TEXT_RETURN_TO_SHOPPING_HERE; ?></td>
		<td align="right" class="main"><?php echo '<a href="' . smn_href_link(FILENAME_DEFAULT, '', 'NONSSL'). '">' . smn_image_button('button_continue_shopping.gif', IMAGE_BUTTON_CONTINUE_SHOPPING) . '</a>'; ?></td>
                <td width="10" align="right"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table>
<? } else{ ?>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo THANK_YOU_HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo smn_image(DIR_WS_IMAGES . 'table_background_checkout.gif', HEADING_TITLE); ?></td>
	  </tr>
	  <tr>
	    <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
	  </tr>
	</table></td>
      </tr><?php echo smn_draw_form('cart_quantity', smn_href_link(FILENAME_CHECKOUT_SELECT, 'action=update_product')); ?>
	  
	  
	  
	  
	  
	   <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td align="left" class="main"><?php echo TEXT_THANK_YOU_FOR_SHOPPING_HERE . $checkout_store_name['store_name']; ?></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
	  
	  
	  
	  
	  
<?php
  $store_list = $cart->get_store_list();
  // systemsmanager begin - wifi mods 
  // prods are not being displayed in the select page because the store_id is wrong in the customers_basket table for each prod
  //print_r($store_list);
  $tot = 0;
  for( $k=0; $k< sizeof($store_list); $k++) {
    $checkout_store_name_query = smn_db_query("select store_name from " . TABLE_STORE_DESCRIPTION . " where store_id = '" . (int)$store_list[$k] . "'");   
    $checkout_store_name = smn_db_fetch_array($checkout_store_name_query);
?>
     
      <tr>
        <td>
	  <table border="0" width="100%" cellspacing="0" cellpadding="2"><tr><td>
<?php
    $info_box_contents = array();
    $info_box_contents[0][] = array('align' => 'center',
                                    'params' => 'class="productListing-heading"',
                                    'text' => TABLE_HEADING_REMOVE);

    $info_box_contents[0][] = array('params' => 'class="productListing-heading"',
                                    'text' => TABLE_HEADING_PRODUCTS);

    $info_box_contents[0][] = array('align' => 'center',
                                    'params' => 'class="productListing-heading"',
                                    'text' => TABLE_HEADING_QUANTITY);

    $info_box_contents[0][] = array('align' => 'right',
                                    'params' => 'class="productListing-heading"',
                                    'text' => TABLE_HEADING_TOTAL);

    $any_out_of_stock = 0;
    $products = array_merge($products,$cart->get_products($store_list[$k]));

?>

</td></tr></table></td></tr>

	  <?php
  }
?>
      <tr>
        <td>
	  <table border="0" width="100%" cellspacing="0" cellpadding="2"><tr><td>
	  <?
    for ($i=0, $n=sizeof($products); $i<$n; $i++) {
// Push all attributes information in an array
      if (isset($products[$i]['attributes']) && is_array($products[$i]['attributes'])) {
        while (list($option, $value) = each($products[$i]['attributes'])) {
          echo smn_draw_hidden_field('id[' . $products[$i]['id'] . '][' . $option . ']', $value);
          $attributes = smn_db_query("select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix
                                      from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa
                                      where pa.products_id = '" . $products[$i]['id'] . "'
                                       and pa.options_id = '" . $option . "'
                                       and pa.options_id = popt.products_options_id
                                       and pa.options_values_id = '" . $value . "'
                                       and pa.options_values_id = poval.products_options_values_id
                                       and popt.language_id = '" . $languages_id . "'
                                       and poval.language_id = '" . $languages_id . "'");
          $attributes_values = smn_db_fetch_array($attributes);
          $products[$i][$option]['products_options_name'] = $attributes_values['products_options_name'];
          $products[$i][$option]['options_values_id'] = $value;
          $products[$i][$option]['products_options_values_name'] = $attributes_values['products_options_values_name'];
          $products[$i][$option]['options_values_price'] = $attributes_values['options_values_price'];
          $products[$i][$option]['price_prefix'] = $attributes_values['price_prefix'];
        }
      }
    }
    $cart_total = 0;
    for ($i=0, $n=sizeof($products); $i<$n; $i++) {
    $store_images = 'images/'. $products[$i]['store_id'] . '_images/';
      if (($i/2) == floor($i/2)) {
        $info_box_contents[] = array('params' => 'class="productListing-even"');
      } else {
        $info_box_contents[] = array('params' => 'class="productListing-odd"');
      }

      $cur_row = sizeof($info_box_contents) - 1;
      $info_box_contents[$cur_row][] = array('align' => 'center',
                                             'params' => 'class="productListing-data" valign="top"',
                                             'text' => smn_draw_checkbox_field('cart_delete[]', $products[$i]['id']));
      $products_name = '<table border="0" cellspacing="2" cellpadding="2">' .
                       '  <tr>' .
                       '    <td class="productListing-data" align="center"><a href="' . smn_href_link(FILENAME_PRODUCT_INFO, 'ID=' . $products[$i]['store_id'] . '&products_id=' . $products[$i]['id']) . '">' . smn_image($store_images . $products[$i]['image'], $products[$i]['name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a></td>' .
                       '    <td class="productListing-data" valign="top"><a href="' . smn_href_link(FILENAME_PRODUCT_INFO, 'ID=' . $products[$i]['store_id'] . '&products_id=' . $products[$i]['id']) . '"><b>' . $products[$i]['name'] . '</b></a>';

      if (STOCK_CHECK == 'true') {
        $stock_check = smn_check_stock($products[$i]['id'], $products[$i]['quantity']);
        if (smn_not_null($stock_check)) {
          $any_out_of_stock = 1;

          $products_name .= $stock_check;
        }
      }

      if (isset($products[$i]['attributes']) && is_array($products[$i]['attributes'])) {
        reset($products[$i]['attributes']);
        while (list($option, $value) = each($products[$i]['attributes'])) {
          $products_name .= '<br><small><i> - ' . $products[$i][$option]['products_options_name'] . ' ' . $products[$i][$option]['products_options_values_name'] . '</i></small>';
        }
      }

      $products_name .= '    </td>' .
                        '  </tr>' .
                        '</table>';

      $info_box_contents[$cur_row][] = array('params' => 'class="productListing-data"',
                                             'text' => $products_name);

      $info_box_contents[$cur_row][] = array('align' => 'center',
                                             'params' => 'class="productListing-data" valign="top"',
                                             'text' => smn_draw_input_field('cart_quantity[]', $products[$i]['quantity'], 'size="4"') . smn_draw_hidden_field('products_id[]', $products[$i]['id']));

      $info_box_contents[$cur_row][] = array('align' => 'right',
                                             'params' => 'class="productListing-data" valign="top"',
                                             'text' => '<b>' . $currencies->display_price($products[$i]['final_price'], smn_get_tax_rate($products[$i]['tax_class_id']), $products[$i]['quantity']) . '</b>');
					     
    $cart_total += ($products[$i]['final_price'] * $products[$i]['quantity']) ;
    }
	$tot += $cart_total;
    new productListingBox($info_box_contents);
	?></td></tr></table></td></tr>
<tr>
     <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
 </tr>
<tr>
     <td align="right" class="main"><b><?php echo SUB_TITLE_TOTAL; ?> <?php echo $currencies->format($tot); ?></b></td>
</tr>

      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
  	 	<td align="left" class="main"><?php echo TEXT_BUY_PRODUCTS_IN_STORE . $checkout_store_name['store_name']; ?></td>
		<td align="right" class="main"><a href="<?php echo smn_href_link(FILENAME_CHECKOUT_SHIPPING, 'ID=' . $store_list[$k], 'NONSSL'); ?>"><?php echo smn_image_button('button_checkout.gif', IMAGE_BUTTON_CHECKOUT); ?></a></td>
		<td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
	  
	  
	  
	  
	  
	  
	  
      <tr>
        <td><?php  echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>	
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
	  	<td align="left" class="main"><?php echo TEXT_UPDATE_SHOPPING_CART; ?></td>
		<td align="right" class="main"><?php echo smn_image_submit('button_update_cart.gif', IMAGE_BUTTON_UPDATE_CART); ?></td>
                <td width="10" align="right"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr></form>
      <tr>
        <td><?php  echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>	
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
	  	<td align="left" class="main"><?php echo TEXT_RETURN_TO_SHOPPING_HERE; ?></td>
		<td align="right" class="main"><?php echo '<a href="' . smn_href_link(FILENAME_DEFAULT, '', 'NONSSL'). '">' . smn_image_button('button_continue_shopping.gif', IMAGE_BUTTON_CONTINUE_SHOPPING) . '</a>'; ?></td>
                <td width="10" align="right"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table>
<? } ?>
