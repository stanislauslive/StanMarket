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
  
  if ($HTTP_GET_VARS['action']) {
    switch ($HTTP_GET_VARS['action']) {
      case 'member_new':
        $check_email_query = smn_db_query("select admin_email_address from " . TABLE_ADMIN . "");
        while ($check_email = smn_db_fetch_array($check_email_query)) {
          $stored_email[] = $check_email['admin_email_address'];
        }
        
        if (in_array($HTTP_POST_VARS['admin_email_address'], $stored_email)) {
          smn_redirect(smn_href_link(FILENAME_ADMIN_MEMBERS, 'page=' . $HTTP_GET_VARS['page'] . 'mID=' . $HTTP_GET_VARS['mID'] . '&error=email&action=new_member'));
        } else {
          function randomize() {
            $salt = "abchefghjkmnpqrstuvwxyz0123456789";
            srand((double)microtime()*1000000); 
            $i = 0;
    	    while ($i <= 7) {
    		$num = rand() % 33;
    		$tmp = substr($salt, $num, 1);
    		$pass = $pass . $tmp;
    		$i++;
  	    }
  	    return $pass;
          }
          $makePassword = randomize();
        
          $sql_data_array = array('admin_groups_id' => smn_db_prepare_input($HTTP_POST_VARS['admin_groups_id']),
                                  'admin_firstname' => smn_db_prepare_input($HTTP_POST_VARS['admin_firstname']),
                                  'admin_lastname' => smn_db_prepare_input($HTTP_POST_VARS['admin_lastname']),
                                  'admin_email_address' => smn_db_prepare_input($HTTP_POST_VARS['admin_email_address']),
                                  'admin_password' => smn_encrypt_password($makePassword),
                                  'admin_created' => 'now()');
        
          smn_db_perform(TABLE_ADMIN, $sql_data_array);
          $admin_id = smn_db_insert_id();
        
          smn_mail($HTTP_POST_VARS['admin_firstname'] . ' ' . $HTTP_POST_VARS['admin_lastname'], $HTTP_POST_VARS['admin_email_address'], ADMIN_EMAIL_SUBJECT, sprintf(ADMIN_EMAIL_TEXT, $HTTP_POST_VARS['admin_firstname'], HTTP_SERVER . DIR_WS_ADMIN, $HTTP_POST_VARS['admin_email_address'], $makePassword, $store->get_store_owner()), $store->get_store_owner(), $store->get_store_owner_email_address());
        
          smn_redirect(smn_href_link(FILENAME_ADMIN_MEMBERS, 'page=' . $HTTP_GET_VARS['page'] . '&mID=' . $admin_id));
        }
        b