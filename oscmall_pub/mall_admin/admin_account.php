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
  
  if ($_GET['action']) {
    switch ($_GET['action']) {
      case 'check_password':
        $check_pass_query = smn_db_query("select admin_password as confirm_password from " . TABLE_ADMIN . " where admin_id = '" . $_POST['id_info'] . "'");
        $check_pass = smn_db_fetch_array($check_pass_query);
        
        // Check that password is good
        if (!smn_validate_password($_POST['password_confirmation'], $check_pass['confirm_password'])) {
          smn_redirect(smn_href_link(FILENAME_ADMIN_ACCOUNT, 'action=check_account&error=password'));
        } else {
          //$confirm = 'confirm_account';
          smn_session_register('confirm_account');
		  $confirm_account = '1';
          smn_redirect(smn_href_link(FILENAME_ADMIN_ACCOUNT, 'action=edit_process'));
        }

        break;    
      case 'save_account':
        $admin_id = smn_db_prepare_input($_POST['id_info']);
        $admin_email_address = smn_db_prepare_input($_POST['admin_email_address']);
        $stored_email[] = 'NONE';
        
        $check_email_query = smn_db_query("select admin_email_address from " . TABLE_ADMIN . " where admin_id <> " . $admin_id . "");
        while ($check_email = smn_db_fetch_array($check_email_query)) {
          $stored_email[] = $check_email['admin_email_address'];
        }
        
        if (in_array($_POST['admin_email_address'], $stored_email)) {
          smn_redirect(smn_href_link(FILENAME_ADMIN_ACCOUNT, 'action=edit_process&error=email'));
        } else {
          $sql_data_array = array('admin_firstname' => smn_db_prepare_input($_POST['admin_firstname']),
                                  'admin_lastname' => smn_db_prepare_input($_POST['admin_lastname']),
                                  'admin_email_address' => smn_db_prepare_input($_POST['admin_email_address']),
                                  'admin_password' => smn_encrypt_password(smn_db_prepare_input($_POST['admin_password'])),
                                  'admin_modified' => 'now()');
        
          smn_db_perform(TABLE_ADMIN, $sql_data_array, 'update', 'admin_id = \'' . $admin_id . '\'');
        
        
         smn_mail($_POST['admin_firstname'] . ' ' . $_POST['admin_lastname'], $_POST['check_email_address'], ADMIN_EMAIL_SUBJECT, sprintf(ADMIN_EMAIL_TEXT, $hiddenPassword), $_POST['check_firstname'] . ' ' . $_POST['admin_lastname'], $_POST['check_email_address']);
        
          smn_redirect(smn_href_link(FILENAME_ADMIN_ACCOUNT, 'page=' . $_GET['page'] . '&mID=' . $admin_id));
        }
        break;
    }
  }
  
  $content_page = basename($_SERVER['PHP_SELF']);
  
  require('templates/default/layout.php');

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>