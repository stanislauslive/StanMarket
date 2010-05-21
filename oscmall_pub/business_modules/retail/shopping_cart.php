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
   
  if ($cart->count_contents() > 0) { 
     include(DIR_WS_CLASSES . 'payment.php'); 
     $payment_modules = new payment; 
   } 

  $breadcrumb->add(NAVBAR_TITLE, smn_href_link(FILENAME_SHOPPING_CART));
?>