<?php
/*
  Copyright (c) 2002 - 2005 SystemsManager.Net

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

function customers_csv($search_string_start, $search_string_end, $export_file_name, $status_filter = '') {

   if (file_exists(DIR_FS_ADMIN . "order/" . $export_file_name . ".csv")) {
        unlink(DIR_FS_ADMIN . "order/" . $export_file_name . ".csv");
    }
    touch (DIR_FS_ADMIN . "order/" . $export_file_name . ".csv");
    $filter_string = "";
    if($status_filter != ''){
        $filter_string = " and o.orders_status = '" . $status_filter . "' ";
    }
	$SeparatorString = '|';
	$customers_query = smn_db_query("SELECT o.customers_id FROM " . TABLE_ORDERS . " o WHERE o.customers_id >= '" . (int)$search_string_start . "'
                                    and o.customers_id <= '" . (int)$search_string_end . "'
                                    " . $filter_string . "
                                    GROUP BY o.customers_id ORDER BY o.customers_id");
    if (smn_db_num_rows($customers_query)){
	while ($cust = smn_db_fetch_array($customers_query)) {
	    $sql = "SELECT * FROM " . TABLE_ORDERS . " o WHERE customers_id=" . $cust['customers_id'] . " " . $filter_string . " ORDER BY orders_id DESC LIMIT 1";
	    $orders_query = smn_db_query($sql);
	    while ($customers = smn_db_fetch_array($orders_query)){
		switch($customers['delivery_country']){
		    case 'Austria':
			$service = 130;
			break;
		    case 'Belgium':
			$service = 131;
			break;
		    case 'Denmark':
			$service = 133;
			break;
		    case 'Finland':
			$service = 135;
			break;
		    case 'France':
			$service = 136;
			break;
		    case 'Germany':
			$service = 145;
			break;
		    case 'Ireland':
			$service = 212;
			break;
		    case 'Italy':
			$service = 137;
			break;
		    case 'Luxembourg':
			$service = 139;
			break;
		    case 'Netherlands':
			$service = 140;
			break;
		    case 'Northern Ireland':
			$service = 212;
			break;
		    case 'Portugal':
			$service = 142;
			break;
		    case 'Spain':
			$service = 134;
			break;
		    case 'Sweden':
			$service = 143;
			break;
		    default:
			$service = 212;
			break;
		}
	    ($fp = fopen(DIR_FS_ADMIN . "order/" . $export_file_name . ".csv", "a")) or die ("can not open file!");
             $export_data = array(sprintf("%05d" , $customers['customers_id']),
                                  ((sizeof($customers['customers_name']) > 35 ) ? sprintf("%35s" , $customers['customers_name']) : $customers['customers_name']),
                                  ((sizeof($customers['delivery_street_address']) > 35 ) ? sprintf("%35s" , $customers['delivery_street_address']) : $customers['delivery_street_address']),
                                  ((sizeof($customers['delivery_city']) > 35 ) ? sprintf("%35s" , $customers['delivery_city']) : $customers['delivery_city']),
                                  ((sizeof($customers['delivery_state']) > 35 ) ? sprintf("%35s" , $customers['delivery_state']) : $customers['delivery_state']),
                                  ((sizeof($customers['delivery_postcode']) > 20 ) ? sprintf("%20s" , $customers['delivery_postcode']) : $customers['delivery_postcode']),
                                  $service,
                                  ((sizeof($customers['customers_telephone']) > 15 ) ? sprintf("%15s" , $customers['customers_telephone']) : $customers['customers_telephone']),
                                  ((sizeof($customers['customers_email_address']) > 50 ) ? sprintf("%50s" , $customers['customers_email_address']) : $customers['customers_email_address']));
                $count = 1;
                foreach ($export_data as $val){
                    if ($count == 11) $count = 1;
                    if ($count == 10){
                        $insert = '';
                        $insert = ($val . "\n");
                    }else{
                        $insert = '';
                        $insert = ($val . $SeparatorString); 
                    }
                    $count += 1;
                    fwrite($fp, $insert);
                }
        fclose($fp);   
	    }
	}
    }
    if (file_exists(DIR_FS_ADMIN . "order/" . $export_file_name . ".csv")){   
        return ('true');
    }else{
        return ('false');
    }
  }
?>