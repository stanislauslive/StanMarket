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

  Copyright (c) 2001,2002 Ian C Wilson
*/

define('SEPAR', chr(9));

  require('includes/application_top.php');

  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

if (isset($_GET['generate_file']) && $_GET['generate_file']=='y') {

  	$sql = "select sd.* from " . TABLE_STORE_MAIN . " sd, " . TABLE_ORDERS_TOTAL . " ot, " . TABLE_ORDERS . " o 
  				     where ot.orders_id = o.orders_id and 
				         sd.store_id = o.store_id and
						 ot.class = 'ot_gv' and
						 o.vendors_processed = 0
				     group by sd.store_id";
	$qry_store = smn_db_query($sql);
	if (smn_db_num_rows($qry_store) > 0) {
	
/*
		if (file_exists(DIR_FS_ADMIN . 'mass_pay.csv')) {
			unlink(DIR_FS_ADMIN . 'mass_pay.csv');
		}
		touch (DIR_FS_ADMIN .'mass_pay.csv');
*/
		$fp = fopen(DIR_FS_ADMIN ."mass_pay.tab", "w") or die ("can not open file!");
		
		while ($st = smn_db_fetch_array($qry_store)) {
			$cust = smn_db_fetch_array(smn_db_query("SELECT customers_email_address FROM " . TABLE_CUSTOMERS . " WHERE customers_id=" . $st['customer_id']));
			$email_address = $cust['customers_email_address'];

			$order = smn_db_fetch_array(smn_db_query("SELECT sum(ot.value) AS s FROM " . TABLE_ORDERS . " o, " . TABLE_ORDERS_TOTAL . " ot 
					  WHERE o.orders_id = ot.orders_id AND
							o.store_id = " . $st['store_id'] . " AND
							ot.class = 'ot_gv' AND
							o.vendors_processed = 0"));
			$amount = $order['s'];

			$insert = $email_address . SEPAR . $amount . SEPAR . "USD" . SEPAR . "StoreID_" . $st['store_id'] . SEPAR . "oscMall GV Payment\n";
			fwrite($fp, $insert);
			
			$sql = "SELECT o.orders_id FROM " . TABLE_ORDERS . " o, " . TABLE_ORDERS_TOTAL . " ot 
					  WHERE o.orders_id = ot.orders_id AND
							o.store_id = " . $st['store_id'] . " AND
							ot.class = 'ot_gv' AND
							o.vendors_processed = 0";
			$ordqry = smn_db_query($sql);
			while ($ord = smn_db_fetch_array($ordqry)) {
				$sql = "UPDATE " . TABLE_ORDERS . " SET vendors_processed=1 WHERE orders_id=" . $ord['orders_id'];
				smn_db_query($sql);
			}
		}		
		fclose($fp);
		
/*
		header('Content-type: application/x-octet-stream');
		header('Content-disposition: attachment; filename=mass_pay.tab');
		readfile(DIR_FS_ADMIN .'mass_pay.tab');
*/
		
		echo "
			<script>
		  	window.open('" . HTTP_SERVER . DIR_WS_ADMIN . "mass_pay.tab','popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=600,height=300,screenX=150,screenY=150,top=150,left=150');
			self.location.href = '" . smn_href_link(FILENAME_GV_REPORT) . "';</script>";
	}
	
}
  
  $content_page = basename($_SERVER['PHP_SELF']);
  
  require('templates/default/layout.php');

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>