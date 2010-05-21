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

  if ( (USE_CACHE == 'true') && !SID) {
    echo smn_cache_store_categories_box();
  } else {
    include(DIR_WS_BOXES . 'store_categories.php');
  }
 if ($store_id == 1) require(DIR_WS_BOXES . 'articles.php');
     require(DIR_WS_BOXES . 'affiliate.php');
     require(DIR_WS_BOXES . 'reviews.php');
     require(DIR_WS_BOXES . 'shopping_cart.php');
  
    if (isset($HTTP_GET_VARS['products_id'])) {
    if (basename($PHP_SELF) != FILENAME_TELL_A_FRIEND) include(DIR_WS_BOXES . 'tell_a_friend.php');
  }

 require(DIR_WS_BOXES . 'loginbox.php');
 if ($store_id == 1) require(DIR_WS_BOXES . 'information.php'); 
?>