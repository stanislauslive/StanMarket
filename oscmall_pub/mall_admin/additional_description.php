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

  require('includes/application_top.php');

  //1 - We allow category and manufacturer information only

  $additional_info_array = array ("CATEGORY","CATLEVEL","MANUFACTURER");
  // so the shop owner will chose which one the additional info is for.

  $languages = smn_get_languages();
  
  $content_page = basename($_SERVER['PHP_SELF']);
  
  require('templates/default/layout.php');
  
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>