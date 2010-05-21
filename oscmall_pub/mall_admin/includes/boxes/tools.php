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
      'heading' => BOX_HEADING_TOOLS,
      'children' => array(
          $store->smn_admin_files_boxes(FILENAME_BACKUP, BOX_TOOLS_BACKUP),
          $store->smn_admin_files_boxes(FILENAME_BANNER_MANAGER, BOX_TOOLS_BANNER_MANAGER),
          $store->smn_admin_files_boxes(FILENAME_CACHE, BOX_TOOLS_CACHE),
          $store->smn_admin_files_boxes(FILENAME_MAIL, BOX_TOOLS_MAIL),
          $store->smn_admin_files_boxes(FILENAME_NEWSLETTERS, BOX_TOOLS_NEWSLETTER_MANAGER),
          $store->smn_admin_files_boxes(FILENAME_WHOS_ONLINE, BOX_TOOLS_WHOS_ONLINE)
      )
  ));
?>