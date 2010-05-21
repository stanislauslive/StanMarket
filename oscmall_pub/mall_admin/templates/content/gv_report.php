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
        </table></td>
      </tr>
	  
<?php
if (isset($_GET['details']) && $_GET['details']=='y') {
?>
	<tr>
		<td>
<?php
	$vendor = smn_db_fetch_array(smn_db_query("SELECT * FROM " . TABLE_STORE_DESCRIPTION . " WHERE store_id=" . $_GET['gid']));
?>		
			<h3><?php echo $vendor['store_name'];?></h3>
			<table border="0" width="100%" cellspacing="0" cellpadding="0">
<?php
	$sql = "SELECT o.* FROM " . TABLE_ORDERS . " o, " . TABLE_ORDERS_TOTAL . " ot
	        WHERE o.orders_id = ot.orders_id AND
			      ot.class = 'ot_gv' AND
				  o.vendors_processed = 0 AND
				  o.store_id = " . $_GET['gid'];
	$orders_qry = smn_db_query($sql);
	while ($order = smn_db_fetch_array($orders_qry)) {
		echo "<tr><td colspan=3 class=details><b>Order #" . $order['order_id'] . " - Date: " . $order['date_purchased'] . "</b></td></tr>";
		
		$sql = "SELECT * FROM " . TABLE_ORDERS_PRODUCTS . " WHERE orders_id=" . $order['orders_id'];
		$prods_qry = smn_db_query($sql);
		while ($prod = smn_db_fetch_array($prods_qry)) {
			echo "<tr>
			         <td width=10%>&nbsp;</td>
			         <td width=60% align=left class=details>" . $prod['products_quantity'] . " x " . $prod['products_name'] . "</td>
					 <td align=right class=details>$ " . number_format($prod['final_price'], 2) . "</td>
				  </tr>";
		}

		$sql = "SELECT * FROM " . TABLE_ORDERS_TOTAL . " WHERE orders_id=" . $order['orders_id'] . " ORDER BY sort_order ASC";
		$totals_qry = smn_db_query($sql);
		while ($total = smn_db_fetch_array($totals_qry)) {
			echo "<tr>
			         <td width=10%>&nbsp;</td>
			         <td width=60% align=left class=details>&nbsp;</td>
					 <td align=right class=details>" . $total['title'] . "&nbsp;&nbsp;&nbsp;$ " . number_format($total['value'], 2) . "</td>
				  </tr>";
		}
	}
?>		
				<tr><td colspan="3" align="center"><input onClick="self.location.href='<?php echo smn_href_link(FILENAME_GV_REPORT, 'page=' . $_GET['page'] . '&gid=' . $_GET['gid']); ?>';" type="button" name="Back" value="<?php echo TEXT_BUTTON_BACK;?>"></td></tr>
			</table>
		</td>
	</tr>
<?php
}
else {
?>  
      <tr>
        <td>
		<table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_VENDORS_NAME; ?></td>
<!--
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_VOUCHER_VALUE; ?></td>
-->
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_QTY_ORDERS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_CREDIT_AMOUNT; ?></td>		
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
  //$gv_query_raw = "select c.coupon_amount, c.coupon_code, c.coupon_id, et.sent_firstname, et.sent_lastname, et.customer_id_sent, et.emailed_to, et.date_sent, c.coupon_id from " . TABLE_COUPONS . " c, " . TABLE_COUPON_EMAIL_TRACK . " et where c.store_id = et.store_id and c.coupon_id = et.coupon_id";
  $gv_query_raw = "select sd.* from " . TABLE_STORE_DESCRIPTION . " sd, " . TABLE_ORDERS_TOTAL . " ot, " . TABLE_ORDERS . " o 
  				   where ot.orders_id = o.orders_id and 
				         sd.store_id = o.store_id and
						 ot.class = 'ot_gv' and
						 o.vendors_processed = 0
				   group by sd.store_id";
  $gv_query = smn_db_query($gv_query_raw);
  $gv_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $gv_query_raw, $gv_query_numrows);

  while ($gv_list = smn_db_fetch_array($gv_query)) {
    if (((!$_GET['gid']) || (@$_GET['gid'] == $gv_list['store_id'])) && (!$gInfo)) {
    	$gInfo = new objectInfo($gv_list);
    }
    if ( (is_object($gInfo)) && ($gv_list['store_id'] == $gInfo->store_id) ) {
      echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . smn_href_link(FILENAME_GV_REPORT, smn_get_all_get_params(array('gid', 'action')) . 'gid=' . $gInfo->store_id . '&action=edit') . '\'">' . "\n";
    } else {
      echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . smn_href_link(FILENAME_GV_REPORT, smn_get_all_get_params(array('gid', 'action')) . 'gid=' . $gv_list['store_id']) . '\'">' . "\n";
    }

  $sql = "SELECT count(o.orders_id) AS c FROM " . TABLE_ORDERS . " o, " . TABLE_ORDERS_TOTAL . " ot 
          WHERE o.orders_id = ot.orders_id AND
		        o.store_id = " . $gv_list['store_id'] . " AND
				ot.class = 'ot_gv' AND
				o.vendors_processed = 0";
  $orders = smn_db_fetch_array(smn_db_query($sql));
  $qty = $orders['c'];

  $sql = "SELECT sum(ot.value) AS s FROM " . TABLE_ORDERS . " o, " . TABLE_ORDERS_TOTAL . " ot 
          WHERE o.orders_id = ot.orders_id AND
		        o.store_id = " . $gv_list['store_id'] . " AND
				ot.class = 'ot_gv' AND
				o.vendors_processed = 0";
  $orders = smn_db_fetch_array(smn_db_query($sql));
  $total_credit = ' $' . number_format($orders['s'], 2);
  
?>
                <td class="dataTableContent"><?php echo $gv_list['store_name']; ?></td>
<!--
                <td class="dataTableContent" align="center"><?php //echo $currencies->format($gv_list['coupon_amount']); ?></td>
-->
                <td class="dataTableContent" align="center"><?php echo $qty; ?></td>				
                <td class="dataTableContent" align="right"><?php echo $total_credit; ?></td>
                <td class="dataTableContent" align="right"><?php if ( (is_object($gInfo)) && ($gv_list['store_id'] == $gInfo->store_id) ) { echo smn_image(DIR_WS_IMAGES . 'icon_arrow_right.gif'); } else { echo '<a href="' . smn_href_link(FILENAME_GV_REPORT, 'page=' . $_GET['page'] . '&gid=' . $gv_list['store_id']) . '">' . smn_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
  }
?>
              <tr>
                <td colspan="5">
				<table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $gv_split->display_count($gv_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_GIFT_VOUCHERS); ?></td>
                    <td class="smallText" align="right"><?php echo $gv_split->display_links($gv_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>

				  <tr>
				  	<td class="smallText" align="left"><input onClick="self.location.href='<?php echo smn_href_link(FILENAME_GV_REPORT, 'generate_file=y');?>'" type="button" name="generate_mass_pay_file" value="<?php echo TEXT_BUTTON_GENERATE_FILE;?>">
					</td>
<?php
$sql = "SELECT sum(ot.value) AS s FROM " . TABLE_ORDERS . " o, " . TABLE_ORDERS_TOTAL . " ot 
	    WHERE o.orders_id = ot.orders_id AND
			ot.class = 'ot_gv' AND
			o.vendors_processed = 0";
$tot = smn_db_fetch_array(smn_db_query($sql));
?>					
				  	<td class="smallText" align="right"><b><?php echo TEXT_INFO_GRAND_TOTAL . ' $ ' . number_format($tot['s'], 2);?></b>
					</td>
				  </tr>	
                </table>
				</td>
              </tr>
			  
            </table></td>
<?php
  $heading = array();
  $contents = array();

if (isset($gInfo)) {
  $heading[] = array('text' => '[' . $gInfo->store_id . '] ' . ' ' . $gInfo->store_name);
  
  $sql = "SELECT o.*, ot.* FROM " . TABLE_ORDERS . " o, " . TABLE_ORDERS_TOTAL . " ot 
          WHERE o.orders_id = ot.orders_id AND
		        o.store_id = " . $gInfo->store_id . " AND
				ot.class = 'ot_gv' AND
				o.vendors_processed = 0";
  $qry = smn_db_query($sql);
  if (smn_db_num_rows($qry) > 0) 
	  while ($order = smn_db_fetch_array($qry)) {
		$contents[] = array('text' => TEXT_INFO_ORDER_ID . $order['orders_id']);
		$contents[] = array('text' => TEXT_INFO_ORDER_DATE . $order['date_purchased']);
		$contents[] = array('text' => TEXT_INFO_CUSTOMER . $order['customers_name']);
		$contents[] = array('text' => TEXT_INFO_AMOUNT . '$ ' . number_format($order['value'],2));
		$contents[] = array('text' => '<hr>');
	  }
  
  
  $contents[] = array('align' => 'center', 'text' => '<input type=button name=Details value="' . TEXT_BUTTON_DETAILS . '" onClick="self.location.href=\'' . smn_href_link(FILENAME_GV_REPORT, 'details=y&page=' . $_GET['page'] . '&gid=' . $gInfo->store_id) . '\';">');

  if ( (smn_not_null($heading)) && (smn_not_null($contents)) ) {
    echo '            <td width="25%" valign="top">' . "\n";

    $box = new box;
    echo $box->infoBox($heading, $contents);

    echo '            </td>' . "\n";
  }
}  
?>
	          </tr>
<?php
} // else del if ($_GET[details]==y)
?>
        </table></td>
      </tr>
    </table>