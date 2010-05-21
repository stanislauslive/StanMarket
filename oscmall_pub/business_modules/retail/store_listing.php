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

   global $page_name; 


// the following sPath references come from application_top.php
  $store_category_depth = 'top';
  if (isset($sPath) && smn_not_null($sPath)) {
    $store_categories_query = smn_db_query("select count(*) as total from " . TABLE_STORE_TO_CATEGORIES . " where store_categories_id = '" . (int)$current_store_category_id . "'");
    $store_cateqories = smn_db_fetch_array($store_categories_query);
    if ($store_cateqories['total'] > 0) {
      $store_category_depth = 'store'; // display products
    } else {
      $store_category_parent_query = smn_db_query("select count(*) as total from " . TABLE_STORE_CATEGORIES . " where store_parent_id = '" . (int)$current_store_category_id . "'");
      $store_category_parent = smn_db_fetch_array($store_category_parent_query);
      if ($store_category_parent['total'] > 0) {
        $store_category_depth = 'nested'; // navigate through the categories
      } else {
        $store_category_depth = 'store'; // category has no products, but display the 'no products' message
      }
    }
  }
  
?>