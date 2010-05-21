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


function smn_deldir($dir){
   $current_dir = opendir($dir);
   while($entryname = readdir($current_dir)){
      if(is_dir("$dir/$entryname") and ($entryname != "." and $entryname!="..")){
         smn_deldir("${dir}/${entryname}");
      }elseif($entryname != "." and $entryname!=".."){
         unlink("${dir}/${entryname}");
      }
   }
   closedir($current_dir);
   rmdir(${dir});
}

function smn_delete_store ($prefix){
   global $languages;
   if ($prefix != '') {
   
   $DB_tables = array(TABLE_ADMIN,
                     TABLE_CATEGORIES, 
                     TABLE_CATEGORIES_DESCRIPTION, 
                     TABLE_CONFIGURATION,
                     TABLE_LANGUAGES, 
                     TABLE_NEWSLETTERS, 
                     TABLE_ORDERS_TRACKING,
                     TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD, 
                     TABLE_PRODUCTS_NOTIFICATIONS, 
                     TABLE_PRODUCTS_OPTIONS, 
                     TABLE_PRODUCTS_OPTIONS_VALUES, 
                     TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS, 
                     TABLE_REVIEWS, 
                     TABLE_REVIEWS_DESCRIPTION,
                     TABLE_TAX_CLASS, 
                     TABLE_TAX_RATES, 
                     TABLE_GEO_ZONES, 
                     TABLE_ZONES_TO_GEO_ZONES, 
                     TABLE_ARTICLES, 
                     TABLE_WEB_SITE_CONTENT, 
                     TABLE_DYNAMIC_PAGE_INDEX,
                     TABLE_SPECIALS,
                     TABLE_STORE_MAIN, 
                     TABLE_STORE_COSTS, 
                     //TABLE_STORE_OWNER_DATA, 
                     TABLE_STORE_TO_CATEGORIES, 
                     TABLE_STORE_DESCRIPTION,  
                     TABLE_STORE_REVIEWS, 
                     TABLE_MEMBER_ORDERS);
   
   
//delete all DB table rows associated with the store....   
   foreach( $DB_tables as $table_name){
      smn_db_query("delete from " . $table_name . " WHERE store_id = '". $prefix ."'");
   }
      
   //remove products from system
   $product_categories_query = smn_db_query("select products_id from " . TABLE_PRODUCTS . " where store_id = '" . (int)$prefix . "'");
   while($product_categories = smn_db_fetch_array($product_categories_query)){
      $product_id = (int)$product_categories['products_id'];
      smn_db_query("delete from " . TABLE_SPECIALS . " where products_id = '" . $product_id . "' and store_id = '" . (int)$prefix . "'");
      smn_db_query("delete from " . TABLE_PRODUCTS . " where products_id = '" . $product_id . "' and store_id = '" . (int)$prefix . "'");
      smn_db_query("delete from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . $product_id . "' and store_id = '" . (int)$prefix . "'");
      smn_db_query("delete from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . $product_id . "'");
      smn_db_query("delete from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . $product_id . "' and store_id = '" . (int)$prefix . "'");
      smn_db_query("delete from " . TABLE_CUSTOMERS_BASKET . " where products_id = '" . $product_id . "' and store_id = '" . (int)$prefix . "'");
      smn_db_query("delete from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . " where products_id = '" . $product_id . "' and store_id = '" . (int)$prefix . "'");
      $product_reviews_query = smn_db_query("select reviews_id from " . TABLE_REVIEWS . " where products_id = '" . $product_id . "'");
      while ($product_reviews = smn_db_fetch_array($product_reviews_query)) {
         smn_db_query("delete from " . TABLE_REVIEWS_DESCRIPTION . " where reviews_id = '" . $product_reviews['reviews_id'] . "' and store_id = '" . (int)$prefix . "'");
      }
      smn_db_query("delete from " . TABLE_REVIEWS . " where products_id = '" . $product_id . "' and store_id = '" . (int)$prefix . "'");

      if (USE_CACHE == 'true') {
         smn_reset_cache_block('categories');
         smn_reset_cache_block('also_purchased');
      }  
   }

   //remove orders from system
   $store_orders_query = smn_db_query("select orders_id from " . TABLE_ORDERS . " where store_id = '" . (int)$prefix . "'");
   while($store_orders = smn_db_fetch_array($store_orders_query)){
      smn_db_query("delete from " . TABLE_ORDERS_TRACKING . " WHERE orders_id = '". (int)$store_orders['orders_id'] ."'");
      smn_db_query("delete from " . TABLE_ORDERS_PRODUCTS . " WHERE orders_id = '". (int)$store_orders['orders_id'] ."'");
      smn_db_query("delete from " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES. " WHERE orders_id = '". (int)$store_orders['orders_id'] ."'");
      smn_db_query("delete from " . TABLE_ORDERS_PRODUCTS_DOWNLOAD . " WHERE orders_id = '". (int)$store_orders['orders_id'] ."'");
      smn_db_query("delete from " . TABLE_ORDERS_STATUS_HISTORY . " WHERE orders_id = '". (int)$store_orders['orders_id'] ."'");
      smn_db_query("delete from " . TABLE_ORDERS_TOTAL . " WHERE orders_id = '". (int)$store_orders['orders_id'] ."'");
   }
   
//delete the stores image directory and files from the system
   $dir = DIR_FS_CATALOG . 'images/'. $prefix . '_images';
   smn_deldir($dir);

   /*
    //delete any saved orders in the DB tables associated with this store		
   $saved_store_order_query = smn_db_query("select saved_order_id from " . TABLE_SAVED_ORDERS . " WHERE saved_store_id = '". $prefix_id ."'");
   if (smn_db_num_rows($store_query)){	
      while ($saved_store_order = smn_db_fetch_array($saved_store_order_query)){
         smn_db_query("delete from " . TABLE_SAVED_ORDERS_PRODUCTS . " where saved_order_id = '" . $saved_store_order['saved_order_id'] . "'");
         smn_db_query("delete from " . TABLE_SAVED_ORDERS_PRODUCTS_ATTRIBUTES . " where saved_order_id = '" . $saved_store_order['saved_order_id'] . "'");
      }
          
      smn_db_query("delete from " . TABLE_SAVED_ORDERS . " where saved_store_id = '". $prefix_id ."'");
   }*/

   }  
return ($store_deleted = 'true');
}//end of delete_tables