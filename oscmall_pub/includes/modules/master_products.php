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

$master_query = smn_db_query("select products_master from " . TABLE_PRODUCTS . " where products_master = '" . (int)$_GET['products_id'] . "'");
$thisquery = smn_db_fetch_array($master_query);
if ($thisquery['products_master'] != '0') {
	
          $slave_list = array('MASTER_LIST_NAME' => MASTER_LIST_NAME,
                         'MASTER_LIST_MANUFACTURER' => MASTER_LIST_MANUFACTURER, 
                         'MASTER_LIST_QUANTITY' => MASTER_LIST_QUANTITY, 
                         'MASTER_LIST_IMAGE' => MASTER_LIST_IMAGE,
                         'MASTER_LIST_DESCRIPTION' => MASTER_LIST_DESCRIPTION); 
                                                   
    asort($slave_list);

    $column_list = array();
    reset($slave_list);
    while (list($key, $value) = each($slave_list)) {
      if ($value > 0) $column_list[] = $key;
    }

    $select_column_list = '';

    for ($i=0, $n=sizeof($column_list); $i<$n; $i++) {
      switch ($column_list[$i]) {

        case 'MASTER_LIST_NAME':
          $select_column_list .= 'pd.products_name, ';
          break;
        case 'MASTER_LIST_DESCRIPTION':
	  $select_column_list .= 'pd.products_description, ';
          break;          
        case 'MASTER_LIST_MANUFACTURER':
          $select_column_list .= 'm.manufacturers_name, ';
          break;
        case 'MASTER_LIST_QUANTITY':
          $select_column_list .= 'p.products_quantity, ';
          break;
        case 'MASTER_LIST_IMAGE':
          $select_column_list .= 'p.products_image, ';
          break;
      }
    }

      $master_sql = "select  " . $select_column_list . " p.products_id,  p.manufacturers_id, p.products_tax_class_id, s.specials_new_products_price, s.status, p.products_price from ". TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS . " p left join " . TABLE_MANUFACTURERS . " m on p.manufacturers_id = m.manufacturers_id left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id where p.products_id = pd.products_id and p.products_master = '" . $thisquery['products_master'] . "' and p.products_status = '1' and pd.language_id = '" . (int)$languages_id . "'";


    }

    if ( (!isset($_GET['sort'])) || (!ereg('[1-8][ad]', $_GET['sort'])) || (substr($_GET['sort'], 0, 1) > sizeof($column_list)) ) {
      for ($i=0, $n=sizeof($column_list); $i<$n; $i++) {
        if ($column_list[$i] == 'MASTER_LIST_NAME') {
          $_GET['sort'] = $i+1 . 'a';
          $master_sql .= " order by pd.products_name";
          break;
        }
      }
    } else {
      $sort_col = substr($_GET['sort'], 0 , 1);
      $sort_order = substr($_GET['sort'], 1);
      $master_sql .= ' order by ';
      switch ($column_list[$sort_col-1]) {
        case 'MASTER_LIST_NAME':
          $master_sql .= "pd.products_name " . ($sort_order == 'd' ? 'desc' : '');
          break;
        case 'MASTER_LIST_MANUFACTURER':
          $master_sql .= "m.manufacturers_name " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
          break;
        case 'MASTER_LIST_QUANTITY':
          $master_sql .= "p.products_quantity " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
          break;
        case 'MASTER_LIST_IMAGE':
          $master_sql .= "pd.products_name";
          break;
      }
    }
     
     include(DIR_WS_MODULES . FILENAME_MASTER_LISTING); 

?>