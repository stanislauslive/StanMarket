<?php
/*
  $Id: conditions.php,v 1.1 2002/06/16 15:24:15 harley_vb Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  
  SystemsManager.Net Technologies Template Solution Version 3
  http://www.systemsmanager.net

  Copyright (c) 2002 osCommerce
  Copyright (c) 2002 SystemsManager.Net
*/
?>
    <table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo smn_image(DIR_WS_IMAGES . 'table_background_address_book.gif', NAVBAR_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
  if ($messageStack->size('addressbook') > 0) {
?>
      <tr>
        <td><?php echo $messageStack->output('addressbook'); ?></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
  }
?>
      <tr>
        <td class="main"><b><?php echo PRIMARY_ADDRESS_TITLE; ?></b></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td class="main" width="50%" valign="top"><?php echo PRIMARY_ADDRESS_DESCRIPTION; ?></td>
                <td align="right" width="50%" valign="top"><table border="0" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="main" align="center" valign="top"><b><?php echo PRIMARY_ADDRESS_TITLE; ?></b><br><?php echo smn_image(DIR_WS_IMAGES . 'arrow_south_east.gif'); ?></td>
                    <td><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                    <td class="main" valign="top"><?php echo smn_address_label($customer_id, $customer_default_address_id, true, ' ', '<br>'); ?></td>
                    <td><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><b><?php echo ADDRESS_BOOK_TITLE; ?></b></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php
  $addresses_query = smn_db_query("select address_book_id, entry_firstname as firstname, entry_lastname as lastname, entry_company as company, entry_street_address as street_address, entry_city as city, entry_postcode as postcode, entry_state as state, entry_zone_id as zone_id, entry_country_id as country_id from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int)$customer_id . "' order by firstname, lastname");
  while ($addresses = smn_db_fetch_array($addresses_query)) {
    $format_id = smn_get_address_format_id($addresses['country_id']);
?>
              <tr>
                <td><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onClick="document.location.href='<?php echo smn_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'edit=' . $addresses['address_book_id'].'&ID='.$store_id, 'NONSSL'); ?>'">
                    <td class="main"><b><?php echo smn_output_string_protected($addresses['firstname'] . ' ' . $addresses['lastname']); ?></b><?php if ($addresses['address_book_id'] == $customer_default_address_id) echo '&nbsp;<small><i>' . PRIMARY_ADDRESS . '</i></small>'; ?></td>
                    <td class="main" align="right"><?php echo '<a href="' . smn_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'edit=' . $addresses['address_book_id'].'&ID='.$store_id, 'NONSSL') . '">' . smn_image_button('small_edit.gif', SMALL_IMAGE_BUTTON_EDIT) . '</a> <a href="' . smn_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'delete=' . $addresses['address_book_id'].'&ID='.$store_id, 'NONSSL') . '">' . smn_image_button('small_delete.gif', SMALL_IMAGE_BUTTON_DELETE) . '</a>'; ?></td>
                  </tr>
                  <tr>
                    <td colspan="2"><table border="0" cellspacing="0" cellpadding="2">
                      <tr>
                        <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                        <td class="main"><?php echo smn_address_format($format_id, $addresses, true, ' ', '<br>'); ?></td>
                        <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                      </tr>
                    </table></td>
                  </tr>
                </table></td>
                <td><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
<?php
  }
?>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td class="smallText"><?php echo '<a href="' . smn_href_link(FILENAME_ACCOUNT, 'ID='.$store_id, 'NONSSL') . '">' . smn_image_button('button_back.gif', IMAGE_BUTTON_BACK) . '</a>'; ?></td>
<?php
  if (smn_count_customer_address_book_entries() < MAX_ADDRESS_BOOK_ENTRIES) {
?>
                <td class="smallText" align="right"><?php echo '<a href="' . smn_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'ID='.$store_id, 'NONSSL') . '">' . smn_image_button('button_add_address.gif', IMAGE_BUTTON_ADD_ADDRESS) . '</a>'; ?></td>
<?php
  }
?>
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
        <td class="smallText"><?php echo sprintf(TEXT_MAXIMUM_ENTRIES, MAX_ADDRESS_BOOK_ENTRIES); ?></td>
      </tr>
    </table>