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

  $menu->addMenuBlock(array(
      'heading' => BOX_HEADING_LOCALIZATION,
      'children' => array(
          $store->smn_admin_files_boxes(FILENAME_CURRENCIES, BOX_LOCALIZATION_CURRENCIES),
          $store->smn_admin_files_boxes(FILENAME_LANGUAGES, BOX_LOCALIZATION_LANGUAGES),
          $store->smn_admin_files_boxes(FILENAME_ORDERS_STATUS, BOX_LOCALIZATION_ORDERS_STATUS)
      )
  ));
?>