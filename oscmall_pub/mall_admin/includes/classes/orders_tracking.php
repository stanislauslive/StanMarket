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

  class sales_report {
    var $mode, $globalStartDate, $startDate, $endDate, $actDate, $showDate, $showDateEnd, $sortString, $status, $outlet, $srDownload, $srCustomer, $srDelivery, $srSeparator, $srBilling;

    function sales_report($mode, $startDate = 0, $endDate = 0, $sort = 0, $statusFilter = 0, $filter = 0) {
      // startDate and endDate have to be a unix timestamp. Use mktime !
      // if set then both have to be valid startDate and endDate
      $this->mode = $mode;
      $this->tax_include = DISPLAY_PRICE_WITH_TAX;

      $this->statusFilter = $statusFilter;
            
      // get date of first sale
      $firstQuery = smn_db_query("select UNIX_TIMESTAMP(min(date_purchased)) as first FROM " . TABLE_ORDERS);
      $first = smn_db_fetch_array($firstQuery);
      $this->globalStartDate = mktime(0, 0, 0, date("m", $first['first']), date("d", $first['first']), date("Y", $first['first']));
            
      $statusQuery = smn_db_query("select * from orders_status where language_id = '1'");
      $i = 0;
      while ($outResp = smn_db_fetch_array($statusQuery)) {
        $status[$i] = $outResp;
        $i++;
      }
      $this->status = $status;

      
      if ($startDate == 0  or $startDate < $this->globalStartDate) {
        // set startDate to globalStartDate
        $this->startDate = $this->globalStartDate;
      } else {
        $this->startDate = $startDate;
      }
      if ($this->startDate > mktime(0, 0, 0, date("m"), date("d"), date("Y"))) {
        $this->startDate = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
      }
      
      if ($endDate > mktime(0, 0, 0, date("m"), date("d") + 1, date("Y"))) {
        // set endDate to tomorrow
        $this->endDate = mktime(0, 0, 0, date("m"), date("d") + 1, date("Y"));
      } else {
        $this->endDate = $endDate;
      }
      if ($this->endDate < $this->startDate + 24 * 60 * 60) {
        $this->endDate = $this->startDate + 24 * 60 * 60;
      }
      
      $this->actDate = $this->startDate;

      // query for order count
      $this->queryOrderCnt = "SELECT count(o.orders_id) as order_cnt FROM " . TABLE_ORDERS . " o";
      // queries for item details count
      $this->queryItemCnt = "SELECT o.orders_id, op.products_id as pid, op.orders_products_id, op.products_name as pname, sum(op.products_quantity) as pquant, sum(op.final_price * op.products_quantity) as psum, op.products_tax as ptax FROM " . TABLE_ORDERS . " o, " . TABLE_ORDERS_PRODUCTS . " op WHERE o.orders_id = op.orders_id";
      // query for shipping
      $this->queryShipping = "SELECT sum(ot.value) as shipping FROM " . TABLE_ORDERS . " o, " . TABLE_ORDERS_TOTAL . " ot WHERE ot.orders_id = o.orders_id AND  ot.class = 'ot_shipping'";

      switch ($sort) {
        case '0':
          $this->sortString = "";
          break;
        case '1':
          $this->sortString = " order by pname asc ";
          break;
        case '2':
          $this->sortString = " order by pname desc";
          break;
        case '3':
          $this->sortString = " order by pquant asc, pname asc";
          break;
        case '4':
          $this->sortString = " order by pquant desc, pname asc";
          break;
        case '5':
          $this->sortString = " order by psum asc, pname asc";
          break;
        case '6':
          $this->sortString = " order by psum desc, pname asc";
          break;
      }
    
    }

    function getNext() {
      switch ($this->mode) {
        // yearly
        case '1':
          $sd = $this->actDate;
          $ed = mktime(0, 0, 0, date("m", $sd), date("d", $sd), date("Y", $sd) + 1);
          break;
        // monthly
        case '2':
          $sd = $this->actDate;
          $ed = mktime(0, 0, 0, date("m", $sd) + 1, 1, date("Y", $sd));
          break;
        // weekly
        case '3':
          $sd = $this->actDate;
          $ed = mktime(0, 0, 0, date("m", $sd), date("d", $sd) + 7, date("Y", $sd));
          break;
        // daily
        case '4':
          $sd = $this->actDate;
          $ed = mktime(0, 0, 0, date("m", $sd), date("d", $sd) + 1, date("Y", $sd));
          break;
      }
      if ($ed > $this->endDate) {
        $ed = $this->endDate;
      }

      $filterString = "";
      if ($this->statusFilter > 0) {
        $filterString .= " AND o.orders_status = " . $this->statusFilter . " ";
      }
      $rqOrders = smn_db_query($this->queryOrderCnt . " WHERE o.date_purchased >= '" . smn_db_input(date("Y-m-d\TH:i:s", $sd)) . "' AND o.date_purchased < '" . smn_db_input(date("Y-m-d\TH:i:s", $ed)) . "'" . $filterString);
      $order = smn_db_fetch_array($rqOrders);

      $rqShipping = smn_db_query($this->queryShipping . " AND o.date_purchased >= '" . smn_db_input(date("Y-m-d\TH:i:s", $sd)) . "' AND o.date_purchased < '" . smn_db_input(date("Y-m-d\TH:i:s", $ed)) . "'" . $filterString);
      $shipping = smn_db_fetch_array($rqShipping);

      $rqItems = smn_db_query($this->queryItemCnt . " AND o.date_purchased >= '" . smn_db_input(date("Y-m-d\TH:i:s", $sd)) . "' AND o.date_purchased < '" . smn_db_input(date("Y-m-d\TH:i:s", $ed)) . "'" . $filterString . " group by pid " . $this->sortString);

      // return the values
      $this->actDate = $ed;
      $this->showDate = $sd;
      $this->showDateEnd = $ed - 60 * 60 * 24;

      // execute the query
      $cnt = 0;
      $itemTot = 0;
      $sumTot = 0;
      while ($resp[$cnt] = smn_db_fetch_array($rqItems)) {
        // to avoid rounding differences round for every quantum
        // multiply with the number of items afterwords.
        $price = $resp[$cnt]['psum'] / $resp[$cnt]['pquant'];

        // products_attributes
        // are there any attributes for this order_id ?
        $queryAttr = "select * from " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " where orders_id = " . $resp[$cnt]['orders_id'] . " AND orders_products_id = " . $resp[$cnt]['orders_products_id'];
        $attrItems = smn_db_query($queryAttr);
        $i = 0;
        while ($attr[$i] = smn_db_fetch_array($attrItems)) {
          $i++;
        }

        // values per date
        if ($i > 0) {
          $price2 = 0;
          $price3 = 0;
          $optionText = "";
          for ($j = 0; $j < $i; $j++) {
            if ($attr[$j]['price_prefix'] == "-") {
              $price2 += (-1) *  $attr[$j]['options_values_price'];
              $price3 = (-1) * $attr[$j]['options_values_price'];
              $prefix = "-";
            } else {
              $price2 += $attr[$j]['options_values_price'];
              $price3 = $attr[$j]['options_values_price'];
              $prefix = "+";
            }
            if ($j == 0) {
              $optionText .= $attr[$j]['products_options'] . ": " . $attr[$j]['products_options_values'];
            } else {
              $optionText .= ", " . $attr[$j]['products_options'] . ": " . $attr[$j]['products_options_values'];
            }
            if ($price3 != 0) {
              $optionText .= " [" . $prefix . smn_add_tax($price3, $resp[$cnt]['ptax']) . "]";
            }
          }
          $resp[$cnt]['psum'] = $resp[$cnt]['pquant'] * smn_add_tax($price +  $price2, $resp[$cnt]['ptax']);
          // overwrite pname
          $resp[$cnt]['pname'] = $resp[$cnt]['pname'] . " (" . $optionText . ")";
        } else {
          $resp[$cnt]['psum'] = $resp[$cnt]['pquant'] * smn_add_tax($price, $resp[$cnt]['ptax']);
        }
        $resp[$cnt]['order'] = $order['order_cnt'];
        $resp[$cnt]['shipping'] = $shipping['shipping'];

        // values per date and item
        $sumTot += $resp[$cnt]['psum'];
        $itemTot += $resp[$cnt]['pquant'];
        // add totsum and totitem until current row
        $resp[$cnt]['totsum'] = $sumTot;
        $resp[$cnt]['totitem'] = $itemTot;
        $cnt++;
      }

      return $resp;
    }
    
    
function DownloadFile($srStatus, $startDate, $endDate, $srDownload, $srCustomer, $srDelivery, $srSeparator, $srBilling){
  
$this->download = $srDownload ;

 if ($this->download == 'true')
  {
    $this->billingFilter = $srBilling;
    $this->customerFilter = $srCustomer;
    $this->deliveryFilter = $srDelivery;
    $this->separator = $srSeparator;
    $this->status = $srStatus;


   if (file_exists(DIR_FS_ADMIN . 'orders.csv'))
    {
        unlink(DIR_FS_ADMIN . 'orders.csv');
    }
    touch (DIR_FS_ADMIN .'orders.cvs');
    
      $StatusFilterString = "";
      if ($this->status  > 0) {
        $StatusFilterString = " orders_status = '" . $this->status . "' AND ";
      }
      $dataString = "";
      if (($this->customerFilter > 0) && ($this->deliveryFilter == 0) && ($this->billingFilter == 0)) {
        $dataString .= " customers_name, customers_street_address, customers_city, customers_postcode, customers_state, customers_country, ";
      }
      
      if (($this->billingFilter > 0)  && ($this->customerFilter == 0) && ($this->billingFilter == 0)){
        $dataString .= " billing_name, billing_company, billing_street_address, billing_city, billing_postcode, billing_state, billing_country, ";
      }
      
      if (($this->deliveryFilter > 0) && ($this->customerFilter == 0) && ($this->billingFilter == 0)) {
        $dataString .= " delivery_name, delivery_company, delivery_street_address, delivery_city, delivery_postcode, delivery_state, delivery_country, ";
      } 
      if (($this->customerFilter > 0) && ($this->billingFilter > 0) && ($this->deliveryFilter == 0)) {
        $dataString .= " customers_name, customers_street_address, customers_city, customers_postcode, customers_state, customers_country,";
        $dataString .= " billing_name, billing_company, billing_street_address, billing_city, billing_postcode, billing_state, billing_country, ";
      }
      
      if (($this->billingFilter > 0) && ($this->deliveryFilter > 0)&& ($this->customerFilter == 0)) {
        $dataString .= " billing_name, billing_company, billing_street_address, billing_city, billing_postcode, billing_state, billing_country,";
        $dataString .= " delivery_name, delivery_company, delivery_street_address, delivery_city, delivery_postcode, delivery_state, delivery_country, ";
      }
      
      if (($this->customerFilter > 0) && ($this->deliveryFilter > 0) && ($this->billingFilter == 0)) {
        $dataString .= " customers_name, customers_street_address, customers_city, customers_postcode, customers_state, customers_country,";  
        $dataString .= " delivery_name, delivery_company, delivery_street_address, delivery_city, delivery_postcode, delivery_state, delivery_country, ";
      }
      if (($this->customerFilter > 0) && ($this->deliveryFilter > 0) && ($this->billingFilter > 0)) {
        $dataString .= " customers_name, customers_street_address, customers_city, customers_postcode, customers_state, customers_country,";
        $dataString .= " billing_name, billing_company, billing_street_address, billing_city, billing_postcode, billing_state, billing_country,";
        $dataString .= " delivery_name, delivery_company, delivery_street_address, delivery_city, delivery_postcode, delivery_state, delivery_country, ";
      }
      
      if ($this->separator == '1') {
        $SeparatorString = SR_SEPARATOR1;
        $StartString = '';
      }
      elseif ($this->separator == '2') {
        $SeparatorString = SR_SEPARATOR2;
        $StartString = SR_START;
      }

     $check_status_query = smn_db_query("select orders_id,customers_company, customers_telephone, customers_email_address, " .$dataString ."  cc_type, cc_owner, cc_number, cc_expires, payment_method from " . TABLE_ORDERS . " where " .$StatusFilterString . "date_purchased >= '" . smn_db_input(date("Y-m-d\TH:i:s", $startDate)) . "' AND date_purchased <= '" . smn_db_input(date("Y-m-d\TH:i:s", $endDate)) . "' order by orders_id asc ");
  
           if (smn_db_num_rows($check_status_query))
        {
            while ($check_status = smn_db_fetch_array($check_status_query))
            {
                $orders_info=array();
                $export_data=array();               
                ($fp = fopen(DIR_FS_ADMIN ."orders.csv", "a")) or die ("can not open file!");
                $export_data = array($check_status['orders_id'], $check_status['customers_company'],  $check_status['customers_email_address'], $check_status['customers_telephone'], $check_status['cc_type'], $check_status['cc_number'], $check_status['cc_expires'],$check_status['cc_owner'],  $check_status['payment_method']);
               
            if ($this->customerFilter > 0)
                {
                $customers_orders_info = array($check_status['customers_name'], $check_status['customers_street_address'], $check_status['customers_city'], $check_status['customers_postcode'], $check_status['customers_state'], $check_status['customers_country']);
                
                $export_data = array_merge($export_data, $customers_orders_info);
                }
                
            if ($this->billingFilter > 0)
                {
                 $billing_orders_info = array($check_status['billing_company'], $check_status['billing_name'], $check_status['billing_street_address'], $check_status['billing_city'], $check_status['billing_postcode'], $check_status['billing_state'], $check_status['billing_country']);
                 
                 $export_data = array_merge($export_data, $billing_orders_info);
                }
                
                
            if ($this->deliveryFilter > 0)
                {                     
                 $delivery_orders_info = array($check_status['delivery_company'], $check_status['delivery_name'], $check_status['delivery_street_address'], $check_status['delivery_city'], $check_status['delivery_postcode'], $check_status['delivery_state'], $check_status['delivery_country']);
                 
                 $export_data = array_merge($export_data, $delivery_orders_info);
                }
                foreach ($export_data as $val)
                {
                    
                    if (empty($val))
                    {
                    $insert='';
                    $insert= ($StartString . $SeparatorString);
                    }else{
                    $insert='';
                    $insert= ($StartString . $val . $SeparatorString);
                    }
                    fwrite($fp, $insert);
                }
                $prducts_query_raw = smn_db_query("select orders_products_id, products_model, products_name, products_quantity from " . TABLE_ORDERS_PRODUCTS . " where orders_id= '" . $check_status['orders_id']. "'");
                if (smn_db_num_rows($prducts_query_raw))
               
                    {
                    while ($prducts_query = smn_db_fetch_array($prducts_query_raw))
                        {
                        $products_attribute_query_raw = smn_db_query("select products_options,  products_options_values from " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " where orders_id= '" . $check_status['orders_id']. "' and orders_products_id = '" .$prducts_query['orders_products_id'] . "'" );
                        if (smn_db_num_rows($products_attribute_query_raw))
                        {
                            $product_attributes='';
                            while ($prducts_attributes_query = smn_db_fetch_array($products_attribute_query_raw))
                            {
                            $product_attributes .= $prducts_query['products_name'] . ' ' . $prducts_attributes_query['products_options'] . ' ' . $prducts_attributes_query['products_options_values'];
                            }
                        }
                        else
                            $product_attributes = $prducts_query['products_name'];
                                
                        $orders_product = array($prducts_query['products_model'], $product_attributes, $prducts_query['products_price'], $prducts_query['products_quantity']);
                        fwrite($fp, '"BEGIN_ITEM",');            
                        foreach ($orders_product as $val)
                            {
                            if (empty($val))
                                {
                                $insert='';
                                $insert= ($StartString . $SeparatorString);
                            }else{
                                $insert='';
                                $insert= ($StartString . $val . $SeparatorString);
                                }
                            fwrite($fp, $insert);
                            }
                        fwrite($fp, '"END_ITEM",');
                        }
                    fwrite($fp, SR_NEWLINE);
                    }
            }
        fclose($fp);   
  
    
        }
        
       if (file_exists(DIR_FS_ADMIN . "orders.csv"))
       {   
        return ('true');
       }
       else
       {
        return ('false');
       }
    }
 }

  function DownloadOrdersFile($srStatus, $startDate, $endDate, $srDownload, $StatusFilterString = '', $OrderFilterString = ''){
    global $store_id;
    
    if (file_exists(DIR_FS_ADMIN . 'orders.html')){
      unlink(DIR_FS_ADMIN . 'orders.html');
    }
    touch (DIR_FS_ADMIN .'orders.html');

    if ($store_id != 1){
      $StatusFilterString .= " and store_id = '" . $store_id . "'";
    }

    $OrderFilterString = ' order by store_id';
    $orders_tracking_query = smn_db_query("select orders_id,
                                                  store_id,
                                                  value, 
                                                  date
                                                  from " . TABLE_ORDERS_TRACKING . "
                                                  where " .$StatusFilterString . " date >= '" . smn_db_input(date("Y-m-d\TH:i:s", $startDate)) . "'
                                                  AND date <= '" . smn_db_input(date("Y-m-d\TH:i:s", $endDate)) . "' "
                                                  . $StatusFilterString . $OrderFilterString);
              
    $fp = fopen(DIR_FS_ADMIN ."orders.html", "a") or die ("can not open file!");
    $insert = ORDERS_TRACKING_START . BR_NEWLINE . HEADING_TITLE . BR_NEWLINE . "\n\n";
    fwrite($fp, $insert);
    
    $end_check = false;
    while ($orders_tracking = smn_db_fetch_array($orders_tracking_query)) {

      if($orders_tracking['store_id'] != $check_id){
        $check_id = $orders_tracking['store_id'];
        $loop_check = false;
        $end_check = true;
        $store_cost_query = smn_db_query("select sc.monthly_costs, ad.admin_sales_cost from " . TABLE_ADMIN_GROUPS . " ag, " . TABLE_ADMIN . " a, " . TABLE_STORE_COSTS . " sc where ag.admin_groups_id = a.admin_groups_id and a.admin_store_id = '" . $orders_tracking['store_id'] . "' and sc.store_id = '" . $orders_tracking['store_id'] . "'");
        $store_cost = smn_db_fetch_array($store_cost_query);
        $monthly_store_cost = $store_cost['monthly_costs'];
        $store_sales_cost = $store_cost['admin_sales_cost'];
        $total_sales = $orders_tracking['value'];
         
      }elseif($orders_tracking['store_id'] == $check_id){
        $end_check = false;
        $loop_check = true;
        $total_sales += $orders_tracking['value'];
      }

      if($end_check == true){
        //add address info here for file
        $store_info_query = smn_db_query("select sd.store_name, sod.store_owner_firstname, sod.store_owner_lastname, sod.street_address, sod.city, sod.state, sod.postal_code, sod.country, sod.telephone_number from " . TABLE_STORE_OWNER_DATA ." sod, " . TABLE_STORE_DESCRIPTION ." sd where sod.store_id = sd.store_id and sod.store_id = '" . $orders_tracking['store_id'] ."'");
        $store_info = smn_db_fetch_array($store_info_query);
        
        $insert =  REPORT_START_DATE . $startDate . REPORT_END_DATE . $endDate . BR_NEWLINE . BR_NEWLINE . "\n\n";
        $insert .=   FONT_SIZE_START . STORE_NAME_LISTED . $store_info['store_name'] . BR_NEWLINE . "\n\n";
        $insert .=  STORE_OWNER . $store_info['store_owner_firstname'] . ' ' . $store_info['store_owner_lastname']. BR_NEWLINE . "\n";
        $insert .=  STORE_ADDRESS . BR_NEWLINE . $store_info['street_address'] . BR_NEWLINE . "\n\n";
        $insert .=  $store_info['city'] . BR_NEWLINE . "\n\n";
        $insert .=  $store_info['state'] . BR_NEWLINE . "\n\n";
        $insert .=  $store_info['country'] . BR_NEWLINE . "\n\n";
        $insert .=  $store_info['postal_code'] . BR_NEWLINE . "\n\n";
        $insert .=  $store_info['telephone_number'] . FONT_SIZE_END. BR_NEWLINE . "\n\n";
        $insert .= "\n\n" . BR_NEWLINE . TRACKING_SEPARATOR . BR_NEWLINE . "\n\n";
      }
        
      if(($end_check == true) && ($loop_check == false)){
         //add costs info here for file
        $percentage_total_sales = ($total_sales * ($store_sales_cost/100));
        $insert .=  TEXT_MONTHLY_RENTAL . $monthly_store_cost . BR_NEWLINE . "\n\n";
        $insert .= "\n\n" . BR_NEWLINE . MID_TRACKING_SEPARATOR . BR_NEWLINE . "\n\n";        
        $insert .=  TEXT_TOTAL_REVENUE . $total_sales . BR_NEWLINE . "\n\n";
        $insert .=  TEXT_PERCENTAGE_REVENUE . $percentage_total_sales . BR_NEWLINE . "\n";
        $insert .= "\n\n" . BR_NEWLINE . MID_TRACKING_SEPARATOR . BR_NEWLINE . "\n\n";
      }        
      fwrite($fp, $insert);
      
    }
    $insert = "\n\n" . ORDERS_TRACKING_END;
    fwrite($fp, $insert);
    fclose($fp);
    
    if (file_exists(DIR_FS_ADMIN . "orders.html")){   
      return ('true');
    } else{
      return ('false');
    }
  }
}

?>
