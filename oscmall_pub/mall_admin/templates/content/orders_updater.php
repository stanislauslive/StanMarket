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
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
          </tr>
          <tr>
            <td align="right"><table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr><?php echo smn_draw_form('orders', FILENAME_ORDERS_UPDATER, '', 'get'); ?>
                <td class="smallText" align="right"><?php echo HEADING_TITLE_SEARCH . ' ' . smn_draw_input_field('oID', '', 'size="12"') . smn_draw_hidden_field('action', 'edit'); ?></td>
              </form></tr>
              <tr><?php echo smn_draw_form('status', FILENAME_ORDERS_UPDATER, '', 'get'); ?>
                <td class="smallText" align="right"><?php echo HEADING_TITLE_STATUS . ' ' . smn_draw_pull_down_menu('status', array_merge(array(array('id' => '', 'text' => TEXT_ALL_ORDERS)), $orders_statuses), '', 'onChange="this.form.submit();"'); ?></td>
              </form></tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_CUSTOMERS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ORDER_TOTAL; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_DATE_PURCHASED; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php

    echo smn_draw_form('status_updater', FILENAME_ORDERS_UPDATER . '?action=update_orders'); 
    if ($HTTP_GET_VARS['cID']) {
      $cID = smn_db_prepare_input($HTTP_GET_VARS['cID']);
      $orders_query_raw = "select o.orders_id, o.customers_name, o.customers_id, o.payment_method, o.date_purchased, o.last_modified, o.currency, o.currency_value, s.orders_status_name, ot.text as order_total from " . TABLE_ORDERS . " o left join " . TABLE_ORDERS_TOTAL . " ot on (o.orders_id = ot.orders_id), " . TABLE_ORDERS_STATUS . " s where o.customers_id = '" . smn_db_input($cID) . "' and o.orders_status = s.orders_status_id and s.language_id = '" . $languages_id . "' and ot.class = 'ot_total' order by orders_id DESC";
    } elseif ($HTTP_GET_VARS['status']) {
      $status = smn_db_prepare_input($HTTP_GET_VARS['status']);
      $orders_query_raw = "select o.orders_id, o.customers_name, o.payment_method, o.date_purchased, o.last_modified, o.currency, o.currency_value, s.orders_status_name, ot.text as order_total from " . TABLE_ORDERS . " o left join " . TABLE_ORDERS_TOTAL . " ot on (o.orders_id = ot.orders_id), " . TABLE_ORDERS_STATUS . " s where o.orders_status = s.orders_status_id and s.language_id = '" . $languages_id . "' and s.orders_status_id = '" . smn_db_input($status) . "' and ot.class = 'ot_total' order by o.orders_id DESC";
    } else {
      $orders_query_raw = "select o.orders_id, o.customers_name, o.payment_method, o.date_purchased, o.last_modified, o.currency, o.currency_value, s.orders_status_name, ot.text as order_total from " . TABLE_ORDERS . " o left join " . TABLE_ORDERS_TOTAL . " ot on (o.orders_id = ot.orders_id), " . TABLE_ORDERS_STATUS . " s where o.orders_status = s.orders_status_id and s.language_id = '" . $languages_id . "' and ot.class = 'ot_total' order by o.orders_id DESC";
    }
    $orders_query = smn_db_query($orders_query_raw);
    $row = 0;
    while ($orders = smn_db_fetch_array($orders_query)) {
      if ($row % 2 == 0){
      echo '<tr class="dataTableRow">';
    }else{
    '<tr class="dataTableRowSelected">';
    }
?>
              
                <td class="dataTableContent"><?php echo '<a href="' . smn_href_link(FILENAME_ORDERS, smn_get_all_get_params(array('oID', 'action')) . 'oID=' . $orders['orders_id'] . '&action=edit') . '">' . smn_image(DIR_WS_ICONS . 'preview.gif', ICON_PREVIEW) . '</a>&nbsp;' . $orders['customers_name']; ?></td>
                <td class="dataTableContent" align="right"><?php echo strip_tags($orders['order_total']); ?></td>
                <td class="dataTableContent" align="center"><?php echo smn_datetime_short($orders['date_purchased']); ?></td>
                <td class="dataTableContent" align="right"><?php echo $orders['orders_status_name']; ?></td>
<?php
    if (isset($HTTP_GET_VARS['checkall']) && $HTTP_GET_VARS['checkall'] == 0)
   {
?>
                <td class="dataTableContent" align="right"><?php echo smn_draw_checkbox_field('select_order[' . $row .']', '', false); ?>&nbsp;</td>
<?php
    }else{
?>
                <td class="dataTableContent" align="right"><?php echo smn_draw_checkbox_field('select_order[' . $row .']', '', true); ?>&nbsp;</td>
<?php
    }
?>
              </tr>
<?php
 echo smn_draw_hidden_field('orders_selected[' . $row .']', $orders['orders_id']);
    $row ++;
    }
?>
            </table></td>
          </tr>
        </table></td>
      </tr>
               <tr>
                <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '5'); ?></td>
              </tr>             
        <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
            <tr>
                <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
            </tr>
            <tr>
                <td class="smallText" align="left"><?php echo SET_TO_STATUS . ' ' . smn_draw_pull_down_menu('new_status', array_merge(array(array('id' => '', 'text' => TEXT_SELECT_ORDERS_STATUS)), $orders_statuses)); ?></td>
                <td><a href="<?php echo FILENAME_ORDERS_UPDATER . '?checkall=1&ID=5';?>"><?php echo CHECK_ALL_ORDERS; ?></a>
                    &nbsp;/&nbsp;
                <a href="<?php echo FILENAME_ORDERS_UPDATER . '?checkall=0&ID=5';?>"><?php echo UNCHECK_ALL_ORDERS; ?></a></td>
                <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
            </tr>
             <tr>
                <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '5'); ?></td>
            </tr>
            <tr>
                <td class="main"><br><b><?php echo TABLE_HEADING_COMMENTS; ?></b></td>
            </tr>
            <tr>
                <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '5'); ?></td>
            </tr>
            <tr>
                <td class="main"><?php echo smn_draw_textarea_field('comments', 'soft', '60', '5'); ?></td>
            </tr>
            <tr>
                <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
            </tr>
              <tr>
                <td>
                  <table border="0" width="100%" cellspacing="0" cellpadding="2">                
                  <tr>
                    <td class="main"><b><?php echo ENTRY_NOTIFY_CUSTOMER; ?></b> <?php echo smn_draw_checkbox_field('notify', '', true); ?>&nbsp;&nbsp;
                    <b><?php echo ENTRY_NOTIFY_COMMENTS; ?></b> <?php echo smn_draw_checkbox_field('notify_comments', '', true); ?></td>
                  </tr>
                  <tr>
                  <td valign="top" align="right"><?php echo smn_image_submit('button_update.gif', IMAGE_UPDATE); ?></td>
                  </tr>
                </table></td>
          </tr>
        </table></td>
      </tr>
    </table>