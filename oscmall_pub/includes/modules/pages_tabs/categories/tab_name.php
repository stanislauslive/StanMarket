 <table border="0" cellspacing="0" cellpadding="5" width="96%">
<?php
    for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
?>
  <tr>
   <td class="main"><?php if ($i == 0) echo TEXT_PRODUCTS_NAME; ?></td>
   <td><?php echo smn_image(DIR_WS_CATALOG_LANGUAGES . 'images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . smn_draw_input_field('products_name[' . $languages[$i]['id'] . ']', (isset($products_name[$languages[$i]['id']]) ? stripslashes($products_name[$languages[$i]['id']]) : smn_get_products_name($pInfo->products_id, $languages[$i]['id'])), 'size="35"'); ?></td>
  </tr>
<?php
    }
?>
  <tr>
   <td colspan="2"><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
  </tr>
  <tr>
   <td class="main"><?php echo TEXT_PRODUCTS_MODEL; ?></td>
   <td><?php echo smn_draw_input_field('products_model', $pInfo->products_model); ?></td>
  </tr>
  <tr>
   <td colspan="2"><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
  </tr>
  <tr>
   <td class="main"><?php echo TEXT_PRODUCTS_STATUS; ?></td>
   <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '' . smn_draw_radio_field('products_status', '1', $in_status) . '' . TEXT_PRODUCT_AVAILABLE .  '<br>' . smn_draw_separator('pixel_trans.gif', '24', '15') .smn_draw_radio_field('products_status', '0', $out_status) . '' . TEXT_PRODUCT_NOT_AVAILABLE; ?></td>
  </tr>
  <tr>
   <td colspan="2"><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
  </tr>
  <tr>
   <td class="main"><?php echo TEXT_PRODUCTS_DATE_AVAILABLE; ?><br><small>(YYYY-MM-DD)</small></td>
   <td><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . ''; ?><?php echo smn_draw_input_field('products_date_available', $pInfo->products_date_available, 'id="products_date_available"');?></td>
  </tr>
  <tr>
   <td colspan="2"><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
  </tr>	  
  <tr>
   <td class="main"><?php echo TEXT_PRODUCTS_QUANTITY; ?></td>
   <td><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_input_field('products_quantity', $pInfo->products_quantity); ?></td>
  </tr>
  <tr>
   <td colspan="2"><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
  </tr>          
<?php
 for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
?>
  <tr>
   <td class="main"><?php if ($i == 0) echo TEXT_PRODUCTS_URL . '<br>' . TEXT_PRODUCTS_URL_WITHOUT_HTTP . ''; ?></td>
   <td><?php echo smn_image(DIR_WS_CATALOG_LANGUAGES .  'images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . smn_draw_input_field('products_url[' . $languages[$i]['id'] . ']', (isset($products_url[$languages[$i]['id']]) ? stripslashes($products_url[$languages[$i]['id']]) : smn_get_products_url($pInfo->products_id, $languages[$i]['id']))); ?></td>
  </tr>
<?php
    }
?>
  <tr>
   <td colspan="2"><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
  </tr>
  <tr>
   <td class="main"><?php echo TEXT_PRODUCTS_MANUFACTURER; ?></td>
   <td><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_pull_down_menu('manufacturers_id', $manufacturers_array, $pInfo->manufacturers_id); ?></td>
  </tr>
  <tr>
   <td class="main"><?php echo TEXT_PRODUCTS_WEIGHT; ?></td>
   <td><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_input_field('products_weight', $pInfo->products_weight); ?></td>
  </tr>
  <tr>
   <td colspan="2"><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
  </tr>
 </table>