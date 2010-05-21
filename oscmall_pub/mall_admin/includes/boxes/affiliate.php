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
      'heading' => BOX_HEADING_AFFILIATE,
      'children' => array(
          $store->smn_admin_files_boxes(FILENAME_AFFILIATE_SUMMARY, BOX_AFFILIATE_SUMMARY),
          $store->smn_admin_files_boxes(FILENAME_AFFILIATE, BOX_AFFILIATE),
          $store->smn_admin_files_boxes(FILENAME_AFFILIATE_PAYMENT, BOX_AFFILIATE_PAYMENT),
          $store->smn_admin_files_boxes(FILENAME_AFFILIATE_SALES, BOX_AFFILIATE_SALES),
          $store->smn_admin_files_boxes(FILENAME_AFFILIATE_CLICKS, BOX_AFFILIATE_CLICKS),
          $store->smn_admin_files_boxes(FILENAME_AFFILIATE_BANNER_MANAGER, BOX_AFFILIATE_BANNERS),
          $store->smn_admin_files_boxes(FILENAME_AFFILIATE_NEWS, BOX_AFFILIATE_NEWS),
          $store->smn_admin_files_boxes(FILENAME_AFFILIATE_NEWSLETTERS, BOX_AFFILIATE_NEWSLETTER_MANAGER),
          $store->smn_admin_files_boxes(FILENAME_AFFILIATE_CONTACT, BOX_AFFILIATE_CONTACT)
      )
  ));
?>