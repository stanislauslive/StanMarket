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
    <table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo THANK_YOU_HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo smn_image(DIR_WS_IMAGES . 'table_background_thank_you.gif', HEADING_TITLE); ?></td>
		  </tr>
		<tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>

        </table></td>
      </tr>

<?php
  if ($cart->count_contents() > 0) {
?>      
		<tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
		  <tr>
        <td align="left" class="main"><?php echo TEXT_THANK_YOU_FOR_SHOPPING_HERE; ?></td>
      </tr>
	  <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr> 
	   <tr>
        <td><form name="buy_products_in_cart" method=  $stock_check = smn_check_stock($products[$i]['id'], $products[$i]['quantity']);
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
    }

    new productListingBox($info_box_contents);
?>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td align="right" class="main"><b><?php echo SUB_TITLE_SUB_TOTAL; ?> <?php echo $currencies->format($cart->show_total()); ?></b></td>
      </tr>
      <tr>
        <td><br><table border="0" width="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
  	 		<td align="left" class="main"><?php echo TEXT_BUY_PRODUCTS_IN_CART; ?></td>
			
            <td align="right" class="main"><a href="<?php echo smn_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'NONSSL'); ?>"><?php echo smn_image_button('button_checkout.gif', IMAGE_BUTTON_CHECKOUT); ?></a></td>
         </form>                 <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
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
	   		<td align="left" class="main"><?php echo TEXT_DROP_PRODUCTS_IN_CART; ?></td>
            <td align="right" class="main"><?php echo '<a href="'.smn_href_link(FILENAME_GOTO_STORE, 'newID=' . $switch_store_id, 'NONSSL').'">' . smn_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a>'; ?></td>
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>	
      <tr>
        <td><?php  echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
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
	  	 <td align="left" class="main"><?php echo TEXT_RETURN_TO_SHOPPING_HERE; ?></td>
	    <td align="right" class="main"><?php echo '<a href="' . smn_href_link(FILENAME_DEFAULT, '', 'NONSSL'). '">' . smn_image_button('button_continue_shopping.gif', IMAGE_BUTTON_CONTINUE_SHOPPING) . '</a>'; ?></td>
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
	 </table>
</td>
      </tr>
<?php
  } else {
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
        <td align="left" class="main"><?php echo TEXT_THANK_YOU_FOR_SHOPPING_HERE; ?></td>
        <td align="right" class="main"><br><a href="<?php echo  smn_href_link(FILENAME_GOTO_STORE, 'newID=' . $switch_store_id, 'NONSSL'); ?>"><?php echo smn_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE); ?></a></td>
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
	        <tr>
        <td><?php  echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
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
	  	 <td align="left" class="main"><?php echo TEXT_RETURN_TO_SHOPPING_HERE; ?></td>
	    <td align="right" class="main"><?php echo '<a href="' . smn_href_link(FILENAME_DEFAULT, '', 'NONSSL') . '">' . smn_image_button('button_continue_shopping.gif', IMAGE_BUTTON_CONTINUE_SHOPPING) . '</a>'; ?></td>
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
<?php
  }
?>
    </tr></table>
