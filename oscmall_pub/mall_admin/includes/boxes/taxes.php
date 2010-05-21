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
      'heading' => BOX_HEADING_LOCATION_AND_TAXES,
      'children' => array(
          $store->smn_admin_files_boxes(FILENAME_COUNTRIES, BOX_TAXES_COUNTRIES),
          $store->smn_admin_files_boxes(FILENAME_ZONES, BOX_TAXES_ZONES),
          $store->smn_admin_files_boxes(FILENAME_GEO_ZONES, BOX_TAXES_GEO_ZONES),
          $store->smn_admin_files_boxes(FILENAME_TAX_CLASSES, BOX_TAXES_TAX_CLASSES),
          $store->smn_admin_files_boxes(FILENAME_TAX_RATES, BOX_TAXES_TAX_RATES)
      )
  ));
?>