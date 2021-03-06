<?php
/*
  Copyright (c) 2003 SystemsManager.Net
  SystemsManager Technologies
  oscMall System Version 3
  http://www.systemsmanager.net
  
  Portions Copyright (c) 2003 osCommerce
  
  This source file is subject to version 2.0 of the GPL license,   
  that is bundled with this package in the file LICENSE. If you
  did not receive a copy of the oscMall System license and are unable 
  to obtain it through the world-wide-web, please send a note to    
  license@systemsmanager.net so we can mail you a copy immediately. 
*/

  $menu->addMenuBlock(array(
      'heading' => BOX_HEADING_CUSTOMERS,
      'children' => array(
          $store->smn_admin_files_boxes(FILENAME_CUSTOMERS, BOX_CUSTOMERS_CUSTOMERS),
          $store->smn_admin_files_boxes(FILENAME_ORDERS_UPDATER, BOX_CUSTOMERS_ORDERS_UPDATER),
          $store->smn_admin_files_boxes(FILENAME_ORDERS_TRACKING, BOX_CUSTOMERS_ORDERS_TRACKING),
          $store->smn_admin_files_boxes(FILENAME_ORDERS, BOX_CUSTOMERS_ORDERS)
      )
  ));
?>