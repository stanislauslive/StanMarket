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
  $page_name = 'sitemap';
  require('includes/application_top.php');
  define('PAGE_NAME' , $page_name . '.php');
  include (DIR_WS_BUSINESS_MODULES . $store->get_store_type() . '/' .$page_name . '.php');
  require(TEMPLATE_STYLE);
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>