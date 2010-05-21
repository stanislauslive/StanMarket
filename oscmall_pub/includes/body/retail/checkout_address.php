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
    <?php echo smn_draw_form('checkout_address', smn_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'NONSSL')); ?><table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo smn_image(DIR_WS_IMAGES . 'table_background_delivery.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php
  if (smn_not_null(MODULE_SHIPPING_INSTALLED)) {
?>
          <tr>
            <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td class="tableHeading"><?php echo TABLE_HEADING_SHIPPING_INFO; ?></td>
                <td class="tableHeading" align="right"><?php echo TABLE_HEADING_SHIPPING_QUOTE; ?></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><?php echo smn_draw_separator(); ?></td>
          </tr>
          <tr>
            <td><?php echo $shipping_modules->selection(); ?></td>
          </tr>
          <tr>
            <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
<?php
  }
?>
          <tr>
            <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td class="tableHeading"><?php echo TABLE_HEADING_MY_ADDRESS; ?></td>
                <td class="tableHeading" align="right"><?php echo TABLE_HEADING_DELIVER_TO; ?></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><?php echo smn_draw_separator(); ?></td>
          </tr>
          <tr>
            <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td class="main"><?php echo smn_address_label($customer_id, 1, 1, ' ', '<br>'); ?></td>
                <td class="main" align="right" valign="middle"><input type="radio" name="sendto" value="1"<?php if ($sendto == '1') echo ' checked'; ?>></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><br><table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td class="tableHeading"><?php echo TABLE_HEADING_ADDRESS_BOOK; ?></td>
                <td align="right" class="tableHeading"><?php echo TABLE_HEADING_DELIVER_TO; ?></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><?php echo smn_draw_separator(); ?></td>
          </tr>
<?php
  $address_book = smn_db_query("select address_book_id from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . $customer_id . "' and address_book_id > 1 order by address_book_id");
  $row = 1;
  if (!smn_db_num_rows($address_book)) {
?>
          <tr>
            <td class="smallText"><?php echo TEXT_ADDRESS_BOOK_NO_ENTRIES; ?></td>
          </tr>
<?php
  } else {
?>
          <tr>
            <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
<?php
    while ($address_book_values = smn_db_fetch_array($address_book)) {
      $row++;
      echo '              <tr class="shippingOptions-' . ($row / 2 == floor($row / 2) ? 'odd' : 'even') . '">' . "\n";
      echo '                <td align="right" valign="top" class="smallText">' . number_format($row - 1) . '.</td>' . "\n";
      echo '                <td class="smallText">' . smn_address_label($customer_id, $address_book_values['address_book_id'], true) . '</td>' . "\n";
      echo '                <td align="right" class="smallText"><input type="radio" name="sendto" value="' . $address_book_values['address_book_id'] . '"' . ($address_book_values['address_book_id'] == $sendto ? ' checked' : '') . '></td>' . "\n";
      echo '              </tr>' . "\n";
    }
?>
            </table></td>
          </tr>
<?php
  }
?>
          <tr>
            <td class="main"><br><table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
<?php
  if ($row <= MAX_ADDRESS_BOOK_ENTRIES) {
    echo '                <td class="main"><a href="' . smn_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'entry_id=' . ($row + 1), 'NONSSL') . '">' . smn_image_button('button_add_address.gif', IMAGE_BUTTON_ADD_ADDRESS) . '</a></td>' . "\n";
  } else {
    echo '                <td valign="top" class="smallText">' . TEXT_MAXIMUM_ENTRIES_REACHED . '</td>' . "\n";
  }
?>
                <td align="right" class="main"><?php echo smn_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE); ?></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="right" class="checkoutBar"><br>[ <span class="checkoutBarHighlighted"><?php echo CHECKOUT_BAR_DELIVERY_ADDRESS; ?></span> | <?php echo CHECKOUT_BAR_PAYMENT_METHOD; ?> | <?php echo CHECKOUT_BAR_CONFIRMATION; ?> | <?php echo CHECKOUT_BAR_FINISHED; ?> ]</td>
          </tr>
        </table></td>
      </tr>
    </table></form>