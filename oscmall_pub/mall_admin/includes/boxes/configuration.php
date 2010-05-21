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

  if ($store_id == 1){
      $group_filter = " and (group_owner  = 'store' or group_owner  = 'mall')";
  }else{
      $group_filter = " and group_owner  = 'store'";
  }

  $children = array();
  $configuration_groups_query = smn_db_query("select configuration_group_id as cgID, configuration_group_title as cgTitle from " . TABLE_CONFIGURATION_GROUP . " where visible = '1'" . $group_filter . " order by sort_order");
  while ($configuration_groups = smn_db_fetch_array($configuration_groups_query)) {
      $children[] = array(
          'text' => $configuration_groups['cgTitle'],
          'link' => $jQuery->link(FILENAME_CONFIGURATION, 'gID=' . $configuration_groups['cgID']),
          'ajax' => true
      );
  }

  $menu->addMenuBlock(array(
      'heading' => BOX_HEADING_CONFIGURATION,
      'children' => $children
  ));
?>