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
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo smn_image(DIR_WS_IMAGES . 'table_background_account.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="main"><?php echo TEXT_PRODUCT_NOTIFICATIONS_INTRODUCTION; ?></td>
          </tr>
          <tr>
            <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
<?php
  if ($global_status['global_product_notifications'] == '1') {
?>
          <tr>
            <td class="main"><b><?php echo HEADING_GLOBAL_PRODUCT_NOTIFICATIONS; ?></b></td>
          </tr>
          <tr>
            <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_GLOBAL_PRODUCT_NOTIFICATIONS_ENABLED; ?></td>
          </tr>
          <tr>
            <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_GLOBAL_PRODUCT_NOTIFICATIONS_DESCRIPTION_ENABLED; ?></td>
          </tr>
          <tr>
            <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
          <?php echo smn_draw_form('global', smn_href_link(FILENAME_PRODUCT_NOTIFICATIONS, 'action=global_notify', 'NONSSL')); ?>
          <tr>
            <td class="main"><?php echo smn_draw_checkbox_field('global', 'enable', true) . '&nbsp;' . TEXT_ENABLE_GLOBAL_NOTIFICATIONS; ?></td>
          </tr>
          <tr>
            <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '20'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo smn_image_submit('button_update.gif', IMAGE_BUTTON_UPDATE); ?></td>
          </tr>
          </form>
<?php
  } else {
?>
          <tr>
            <td class="main"><b><?php echo HEADING_GLOBAL_PRODUCT_NOTIFICATIONS; ?></b></td>
          </tr>
          <tr>
            <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_GLOBAL_PRODUCT_NOTIFICATIONS_DISABLED; ?></td>
          </tr>
          <tr>
            <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_GLOBAL_PRODUCT_NOTIFICATIONS_DESCRIPTION_DISABLED; ?></td>
          </tr>
          <tr>
            <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
          <?php echo smn_draw_form('global', smn_href_link(FILENAME_PRODUCT_NOTIFICATIONS, 'action=global_notify', 'NONSSL')); ?>
          <tr>
            <td class="main"><?php echo smn_draw_checkbox_field('global', 'enable') . '&nbsp;' . TEXT_ENABLE_GLOBAL_NOTIFICATIONS; ?></td>
          </tr>
          <tr>
            <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '20'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo smn_image_submit('button_update.gif', IMAGE_BUTTON_UPDATE); ?></td>
          </tr>
          </form>
          <tr>
            <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '20'); ?></td>
          </tr>
          <tr>
            <td class="main"><b><?php echo HEADING_PRODUCT_NOTIFICATIONS; ?></b></td>
          </tr>
          <tr>
            <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_PRODUCT_NOTIFICATIONS_LIST; ?></td>
          </tr>
          <tr>
            <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
          <?php echo smn_draw_form('notifications', smn_href_link(FILENAME_PRODUCT_NOTIFICATIONS, 'action=update_notifications', 'NONSSL')); ?>
<?php
    $products_query = smn_db_query("select pd.products_id, pd.products_name from " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_NOTIFICATIONS . " pn where pn.customers_id = '" . $customer_id . "' and pn.products_id = pd.products_id and pd.language_id = '" . $languages_id . "' order by pd.products_name");
    while ($products = smn_db_fetch_array($products_query)) {
      echo '          <tr>' . "\n" .
           '            <td class="main">' . smn_draw_checkbox_field('products[]', $products['products_id']) . '&nbsp;' . $products['products_name'] . '</td>' . "\n" .
           '          </tr>' . "\n";
    }
?>
          <tr>
            <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo smn_image_submit('button_remove_notifications.gif', IMAGE_BUTTON_REMOVE_NOTIFICATIONS); ?></td>
          </tr>
          </form>
<?php
  }
?>
          <tr>
            <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
          <tr>
            <td align="right" class="smallText"><?php echo '<a href="' . smn_href_link(FILENAME_ACCOUNT, '', 'NONSSL') . '">' . smn_image_button('button_back.gif', IMAGE_BUTTON_BACK) . '</a>'; ?></td>
          </tr>
        </table></td>
      </tr>
    </table>