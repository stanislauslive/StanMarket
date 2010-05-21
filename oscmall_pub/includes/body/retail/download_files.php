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
<?php
  if ($_GET['action'] == 'archive') {
    $delete_query = smn_db_query("select orders_products_download_id, orders_id from orders_products_download where orders_products_download_id = '" . $_GET['aID'] . "'");
    $delete = smn_db_fetch_array($delete_query);
	smn_db_query("update orders_products_download set archived = 'yes' where orders_id = '" . $delete['orders_id'] . "' AND orders_products_download_id = '" . $_GET['aID'] . "' LIMIT 1");
?>
     <table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading">Download Your Items Here</td>
            <td class="pageHeading" align="right"><?php echo smn_image(DIR_WS_IMAGES . 'table_background_default.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td>
<?php

$orders_query_raw = "SELECT orders_id FROM " . TABLE_ORDERS . " WHERE customers_id = '" . $customer_id . "' ORDER BY orders_id DESC LIMIT 999";
    $orders_query = smn_db_query($orders_query_raw);
    $orders_values = smn_db_fetch_array($orders_query);
    $last_order = $orders_values['orders_id'];

// Now get all downloadable products in that order
  $downloads_query_raw = "SELECT DATE_FORMAT(date_purchased, '%Y-%m-%d') as date_purchased_day, o.orders_id, opd.download_maxdays, op.products_name, op.products_id, opd.orders_products_download_id, opd.orders_products_filename, opd.download_count, opd.download_maxdays
                          FROM " . TABLE_ORDERS . " o, " . TABLE_ORDERS_PRODUCTS . " op, " . TABLE_ORDERS_PRODUCTS_DOWNLOAD . " opd
                          WHERE customers_id = '" . $customer_id . "'
                          AND o.orders_id = op.orders_id
                          AND op.orders_id = o.orders_id
                          AND o.orders_status >= '2'
                          AND o.orders_status != 99999
						  AND opd.archived != 'yes'
                          AND opd.orders_products_id=op.orders_products_id
                          AND opd.orders_products_filename<>''
						  ORDER BY opd.orders_products_download_id DESC LIMIT 999";
  $downloads_query = smn_db_query($downloads_query_raw);

// Don't display if there is no downloadable product
  if (smn_db_num_rows($downloads_query) > 0) {
?>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><b><?php echo HEADING_DOWNLOAD; ?></b></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td>
          <table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">

<!-- list of products -->
<?php
    while ($downloads_values = smn_db_fetch_array($downloads_query)) {
    	list($dt_year, $dt_month, $dt_day) = explode('-', $downloads_values['date_purchased_day']);
    	$download_timestamp = mktime(23, 59, 59, $dt_month, $dt_day + $downloads_values['download_maxdays'], $dt_year);
  	    $download_expiry = date('Y-m-d H:i:s', $download_timestamp);

      if (($downloads_values['download_count'] > 0) && (file_exists(DIR_FS_DOWNLOAD . $downloads_values['orders_products_filename'])) &&
          (($downloads_values['download_maxdays'] == 0) || ($download_timestamp > time()))) {
		  $n = $n+1;
		echo '			  <tr class="infoBoxContents">' . "\n";
		echo '            <td align="left">#' . $n . '</td>' . "\n";
        echo '            <td align="left">' . smn_image_button("button_archive.gif", 'Archive', 'onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . smn_href_link('download_files.php', smn_get_all_get_params(array('dID', 'action')) . 'action=archive' . '&aID=' . $downloads_values['orders_products_download_id'] . '\'"')) . '</td>' . "\n";
        echo '            <td><a href="' . smn_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $downloads_values['products_id'], 'NONSSL') . '">' . $downloads_values['products_name'] . '</a></td>' . "\n";
		echo '            <td><a href="' . smn_href_link(FILENAME_DOWNLOAD, 'order=' . $downloads_values['orders_id'] . '&id=' . $downloads_values['orders_products_download_id']) . '">' . $downloads_values['orders_products_filename'] . '</a></td>' . "\n";
	    echo '            <td>' . TABLE_HEADING_DOWNLOAD_DATE . smn_date_long($download_expiry) . '</td>' . "\n";
        echo '            <td align="right">' . $downloads_values['download_count'] . TABLE_HEADING_DOWNLOAD_COUNT . '</td>' . "\n";
        echo '          </tr>' . "\n";
} 
}
?>
            </tr>
          </table>
        </td>
      </tr>
<?php
    if (!strstr($PHP_SELF, FILENAME_ACCOUNT_HISTORY_INFO)) {
?>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr><?php
	  echo '          <td class="smalltext" colspan="4"></form>' . "\n";
?>     
	  </tr>
<?php
    }
  }
?>
			</td>
          </tr>
        </table></td>
      </tr>
     </table>
<?php
} else {
?>
    <table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading">Download Your Items Here</td>
            <td class="pageHeading" align="right"><?php echo smn_image(DIR_WS_IMAGES . 'table_background_default.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td>
<?php

$orders_query_raw = "SELECT orders_id FROM " . TABLE_ORDERS . " WHERE customers_id = '" . $customer_id . "' ORDER BY orders_id DESC LIMIT 999";
    $orders_query = smn_db_query($orders_query_raw);
    $orders_values = smn_db_fetch_array($orders_query);
    $last_order = $orders_values['orders_id'];

// Now get all downloadable products in that order
  $downloads_query_raw = "SELECT DATE_FORMAT(date_purchased, '%Y-%m-%d') as date_purchased_day, o.orders_id, opd.download_maxdays, op.products_name, opd.orders_products_download_id, opd.orders_products_filename, opd.download_count, opd.download_maxdays
                          FROM " . TABLE_ORDERS . " o, " . TABLE_ORDERS_PRODUCTS . " op, " . TABLE_ORDERS_PRODUCTS_DOWNLOAD . " opd
                          WHERE customers_id = '" . $customer_id . "'
                          AND o.orders_id = op.orders_id
                          AND op.orders_id = o.orders_id
                          AND o.orders_status >= '2'
                          AND o.orders_status != 99999
						  AND opd.archived != 'yes'
                          AND opd.orders_products_id=op.orders_products_id
                          AND opd.orders_products_filename<>''
						  ORDER BY opd.orders_products_download_id DESC LIMIT 999";
  $downloads_query = smn_db_query($downloads_query_raw);

// Don't display if there is no downloadable product
  if (smn_db_num_rows($downloads_query) > 0) {
?>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><b><?php echo HEADING_DOWNLOAD; ?></b></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td>
          <table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">

<!-- list of products -->
<?php
    while ($downloads_values = smn_db_fetch_array($downloads_query)) {
    	list($dt_year, $dt_month, $dt_day) = explode('-', $downloads_values['date_purchased_day']);
    	$download_timestamp = mktime(23, 59, 59, $dt_month, $dt_day + $downloads_values['download_maxdays'], $dt_year);
  	    $download_expiry = date('Y-m-d H:i:s', $download_timestamp);

      if (($downloads_values['download_count'] > 0) && (file_exists(DIR_FS_DOWNLOAD . $downloads_values['orders_products_filename'])) &&
          (($downloads_values['download_maxdays'] == 0) || ($download_timestamp > time()))) {
		  $n = $n+1;
		echo '			  <tr class="infoBoxContents">' . "\n";
		echo '            <td align="left">#' . $n . '</td>' . "\n";
        echo '            <td align="left">' . smn_image_button("button_archive.gif", 'Archive', 'onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . smn_href_link('download_files.php', smn_get_all_get_params(array('dID', 'action')) . 'action=archive' . '&aID=' . $downloads_values['orders_products_download_id'] . '\'"')) . '</td>' . "\n";
        echo '            <td><a href="' . smn_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $downloads_values['products_id'], 'NONSSL') . '">' . $downloads_values['products_name'] . '</a></td>' . "\n";
		echo '            <td><a href="' . smn_href_link(FILENAME_DOWNLOAD, 'order=' . $downloads_values['orders_id'] . '&id=' . $downloads_values['orders_products_download_id']) . '">' . $downloads_values['orders_products_filename'] . '</a></td>' . "\n";
	    echo '            <td>' . TABLE_HEADING_DOWNLOAD_DATE . smn_date_long($download_expiry) . '</td>' . "\n";
        echo '            <td align="right">' . $downloads_values['download_count'] . TABLE_HEADING_DOWNLOAD_COUNT . '</td>' . "\n";
        echo '          </tr>' . "\n";
} 
}
?>
            </tr>
          </table>
        </td>
      </tr>
<?php
    if (!strstr($PHP_SELF, FILENAME_ACCOUNT_HISTORY_INFO)) {
?>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr><?php
	  echo '          <td class="smalltext" colspan="4"></form>' . "\n";
?>     
	  </tr>
<?php
    }
  }
?>
			</td>
          </tr>
        </table></td>
      </tr>
     </table>
<?php
}
?>