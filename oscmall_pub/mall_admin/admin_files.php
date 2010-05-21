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

  $current_boxes = DIR_FS_ADMIN . DIR_WS_BOXES;
  $current_files = DIR_FS_ADMIN;
  
  if ($_GET['action']) {
    switch ($_GET['action']) {
      case 'box_store':       
        $sql_data_array = array('admin_files_name' => smn_db_prepare_input($_GET['box']),
                                'admin_files_is_boxes' => '1');
        smn_db_perform(TABLE_ADMIN_FILES, $sql_data_array);
        $admin_boxes_id = smn_db_insert_id();
        
        smn_redirect(smn_href_link(FILENAME_ADMIN_FILES, 'cID=' . $admin_boxes_id));
        break;
      case 'box_remove':
        // NOTE: ALSO DELETE FILES STORED IN REMOVED BOX //
        $admin_boxes_id = smn_db_prepare_input($_GET['cID']);
        smn_db_query("delete from " . TABLE_ADMIN_FILES . " where admin_files_id = '" . $admin_boxes_id . "' or admin_files_to_boxes = '" . $admin_boxes_id . "'");
        
        smn_redirect(smn_href_link(FILENAME_ADMIN_FILES));
        break;
      case 'file_store':
        $sql_data_array = array('admin_files_name' => smn_db_prepare_input($_POST['admin_files_name']),
                                'admin_files_to_boxes' => smn_db_prepare_input($_POST['admin_files_to_boxes']));
        smn_db_perform(TABLE_ADMIN_FILES, $sql_data_array);
        $admin_files_id = smn_db_insert_id();

        smn_redirect(smn_href_link(FILENAME_ADMIN_FILES, 'cPath=' . $_GET['cPath'] . '&fID=' . $admin_files_id));
        break;
      case 'file_remove':
        $admin_files_id = smn_db_prepare_input($_POST['admin_files_id']);      
        smn_db_query("delete from " . TABLE_ADMIN_FILES . " where admin_files_id = '" . $admin_files_id . "'");
        
        smn_redirect(smn_href_link(FILENAME_ADMIN_FILES, 'cPath=' . $_GET['cPath']));
        break;
    }
  }
  
  $content_page = basename($_SERVER['PHP_SELF']);
  
  require('templates/default/layout.php');

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>