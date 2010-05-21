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

  if (!isset($lng) || (isset($lng) && !is_object($lng))) {
    include(DIR_WS_CLASSES . 'language.php');
    $lng = new language;
  }
  if (sizeof($lng->catalog_languages) > 1) 
   include(DIR_WS_BOXES . 'languages.php');
   
  include(DIR_WS_BOXES . 'store_categories.php');
  require(DIR_WS_BOXES . 'shopping_cart.php');
  require(DIR_WS_BOXES . 'loginbox.php');
  include(DIR_WS_BOXES . 'whats_new.php');
  
  if ( (USE_CACHE == 'true') && !SID) {
    echo smn_cache_categories_box();
  } else {
    include(DIR_WS_BOXES . 'categories.php');
    if (smn_session_is_registered('customer_id')) include(DIR_WS_BOXES . 'order_history.php');
      if (isset($HTTP_GET_VARS['products_id'])) {
        if (smn_session_is_registered('customer_id')) {
          $check_query = smn_db_query("select count(*) as count from " . TABLE_CUSTOMERS_INFO . " where customers_info_id = '" . (int)$customer_id . "' and global_product_notifications = '1'");
          $check = smn_db_fetch_array($check_query);
            if ($check['count'] > 0) {
              include(DIR_WS_BOXES . 'best_sellers.php');
            } else {
              include(DIR_WS_BOXES . 'product_notifications.php');
            }
          } else {
            include(DIR_WS_BOXES . 'product_notifications.php');
          }
        } else {
          include(DIR_WS_BOXES . 'best_sellers.php');
      }
    require(DIR_WS_BOXES . 'reviews.php');
    if (substr(basename($PHP_SELF), 0, 8) != 'checkout') {
      include(DIR_WS_BOXES . 'currencies.php'); 
    }
  }

  require(DIR_WS_BOXES . 'specials.php');
  
  if ($store_id == 1) require(DIR_WS_BOXES . 'articles.php');
  include(DIR_WS_BOXES . 'manufacturers.php');
  
//  include(DIR_WS_BOXES . 'footer.php');
?>
