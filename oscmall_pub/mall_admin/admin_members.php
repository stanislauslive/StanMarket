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
      case 'member_new':
        $check_email_query = smn_db_query("select admin_email_address from " . TABLE_ADMIN . "");
        while ($check_email = smn_db_fetch_array($check_email_query)) {
          $stored_email[] = $check_email['admin_email_address'];
        }
        
        if (in_array($_POST['admin_email_address'], $stored_email)) {
          smn_redirect(smn_href_link(FILENAME_ADMIN_MEMBERS, 'page=' . $_GET['page'] . 'mID=' . $_GET['mID'] . '&error=email&action=new_member'));
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
        
          $sql_data_array = array('admin_groups_id' => smn_db_prepare_input($_POST['admin_groups_id']),
                                  'admin_firstname' => smn_db_prepare_input($_POST['admin_firstname']),
                                  'admin_lastname' => smn_db_prepare_input($_POST['admin_lastname']),
                                  'admin_email_address' => smn_db_prepare_input($_POST['admin_email_address']),
                                  'admin_password' => smn_encrypt_password($makePassword),
                                  'admin_created' => 'now()');
        
          smn_db_perform(TABLE_ADMIN, $sql_data_array);
          $admin_id = smn_db_insert_id();
        
          smn_mail($_POST['admin_firstname'] . ' ' . $_POST['admin_lastname'], $_POST['admin_email_address'], ADMIN_EMAIL_SUBJECT, sprintf(ADMIN_EMAIL_TEXT, $_POST['admin_firstname'], HTTP_SERVER . DIR_WS_ADMIN, $_POST['admin_email_address'], $makePassword, STORE_OWNER), STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
        
          smn_redirect(smn_href_link(FILENAME_ADMIN_MEMBERS, 'page=' . $_GET['page'] . '&mID=' . $admin_id));
        }
        break;
      case 'member_edit':
        $admin_id = smn_db_prepare_input($_POST['admin_id']);
        $hiddenPassword = '-hidden-';
        $stored_email[] = 'NONE';
        
        $check_email_query = smn_db_query("select admin_email_address from " . TABLE_ADMIN . " where admin_id <> " . $admin_id . "");
        while ($check_email = smn_db_fetch_array($check_email_query)) {
          $stored_email[] = $check_email['admin_email_address'];
        }
        
        if (in_array($_POST['admin_email_address'], $stored_email)) {
          smn_redirect(smn_href_link(FILENAME_ADMIN_MEMBERS, 'page=' . $_GET['page'] . 'mID=' . $_GET['mID'] . '&error=email&action=edit_member'));
        } else {
          $sql_data_array = array('admin_groups_id' => smn_db_prepare_input($_POST['admin_groups_id']),
                                  'admin_firstname' => smn_db_prepare_input($_POST['admin_firstname']),
                                  'admin_lastname' => smn_db_prepare_input($_POST['admin_lastname']),
                                  'admin_email_address' => smn_db_prepare_input($_POST['admin_email_address']),
                                  'admin_modified' => 'now()');
        
          smn_db_perform(TABLE_ADMIN, $sql_data_array, 'update', 'admin_id = \'' . $admin_id . '\'');
        
          smn_mail($_POST['admin_firstname'] . ' ' . $_POST['admin_lastname'], $_POST['admin_email_address'], ADMIN_EMAIL_SUBJECT, sprintf(ADMIN_EMAIL_TEXT, $_POST['admin_firstname'], HTTP_SERVER . DIR_WS_ADMIN, $_POST['admin_email_address'], $hiddenPassword, MALL_NAME), STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
          
          smn_redirect(smn_href_link(FILENAME_ADMIN_MEMBERS, 'page=' . $_GET['page'] . '&mID=' . $admin_id));
        }
        break;
      case 'member_delete':
        $admin_id = smn_db_prepare_input($_POST['admin_id']);
        smn_db_query("delete from " . TABLE_ADMIN . " where admin_id = '" . $admin_id . "'");
        
        smn_redirect(smn_href_link(FILENAME_ADMIN_MEMBERS, 'page=' . $_GET['page']));
        break;
      case 'group_define':
        $selected_checkbox = $_POST['groups_to_boxes'];
        
        $define_files_query = smn_db_query("select admin_files_id from " . TABLE_ADMIN_FILES . " order by admin_files_id");
        while ($define_files = smn_db_fetch_array($define_files_query)) {
          $admin_files_id = $define_files['admin_files_id'];
          
          if (in_array ($admin_files_id, $selected_checkbox)) {
            $sql_data_array = array('admin_groups_id' => smn_db_prepare_input($_POST['checked_' . $admin_files_id]));
            //$set_group_id = $_POST['checked_' . $admin_files_id];
          } else {
            $sql_data_array = array('admin_groups_id' => smn_db_prepare_input($_POST['unchecked_' . $admin_files_id]));
            //$set_group_id = $_POST['unchecked_' . $admin_files_id];
          }
          smn_db_perform(TABLE_ADMIN_FILES, $sql_data_array, 'update', 'admin_files_id = \'' . $admin_files_id . '\'');
        }
               
        smn_redirect(smn_href_link(FILENAME_ADMIN_MEMBERS, 'gID=' . $_POST['admin_groups_id']));
        break;
      case 'group_delete':
        $set_groups_id = smn_db_prepare_input($_POST['set_groups_id']);
        
        smn_db_query("delete from " . TABLE_ADMIN_GROUPS . " where admin_groups_id = '" . $_GET['gID'] . "'");
        smn_db_query("alter table " . TABLE_ADMIN_FILES . " change admin_groups_id admin_groups_id set( " . $set_groups_id . " ) NOT NULL DEFAULT '1' ");
        smn_db_query("delete from " . TABLE_ADMIN . " where admin_groups_id = '" . $_GET['gID'] . "'");
               
        smn_redirect(smn_href_link(FILENAME_ADMIN_MEMBERS, 'gID=groups'));
        break;        
      case 'group_edit':
        $admin_groups_name = ucwords(strtolower(smn_db_prepare_input($_POST['admin_groups_name'])));
	$name_replace = ereg_replace (" ", "%", $admin_groups_name);
	$sql_data_array = array('admin_groups_name' => $admin_groups_name,
				'admin_groups_store_type' => smn_db_prepare_input($_POST['admin_groups_store_types']),
				'admin_sales_cost' => smn_db_prepare_input($_POST['admin_sales_cost']),
				'admin_groups_max_products' => smn_db_prepare_input($_POST['admin_groups_max_products']));

        if (($admin_groups_name == '' || NULL) || (strlen($admin_groups_name) <= 5) ) {
          smn_redirect(smn_href_link(FILENAME_ADMIN_MEMBERS, 'gID=' . $_GET[gID] . '&gName=false&action=action=edit_group'));
        } else {
          $check_groups_name_query = smn_db_query("select admin_groups_name as group_name_edit from " . TABLE_ADMIN_GROUPS . " where admin_groups_id <> " . $_GET['gID'] . " and admin_groups_name = '" . $name_replace . "'");
          $check_duplicate = smn_db_num_rows($check_groups_name_query);
          if ($check_duplicate > 0){
            smn_redirect(smn_href_link(FILENAME_ADMIN_MEMBERS, 'gID=' . $_GET['gID'] . '&gName=used&action=edit_group'));
          } else {
            $admin_groups_id = $_GET['gID'];
	    smn_db_perform(TABLE_ADMIN_GROUPS, $sql_data_array, 'update', "admin_groups_id = '" . $admin_groups_id . "'");
            smn_redirect(smn_href_link(FILENAME_ADMIN_MEMBERS, 'gID=' . $admin_groups_id));
          }
        }
        break;              
      case 'group_new':
        $admin_groups_name = ucwords(strtolower(smn_db_prepare_input($_POST['admin_groups_name'])));
        $name_replace = ereg_replace (" ", "%", $admin_groups_name);
        
        if (($admin_groups_name == '' || NULL) || (strlen($admin_groups_name) <= 5) ) {
          smn_redirect(smn_href_link(FILENAME_ADMIN_MEMBERS, 'gID=' . $_GET[gID] . '&gName=false&action=new_group'));
        } elseif ($_GET['gID'] != 'edit_group') {
          $check_groups_name_query = smn_db_query("select admin_groups_name as group_name_new from " . TABLE_ADMIN_GROUPS . " where admin_groups_name like '%" . $name_replace . "%'");
          $check_duplicate = smn_db_num_rows($check_groups_name_query);
          if ($check_duplicate > 0){
            smn_redirect(smn_href_link(FILENAME_ADMIN_MEMBERS, 'gID=' . $_GET['gID'] . '&gName=used&action=new_group'));
          } else {
	  $sql_product_data_array = array('products_quantity' => '1000',
		                          'products_model' => 'mem_6_',
					  'products_price' => smn_db_prepare_input($_POST['admin_groups_cost']),
					  'products_date_available' => date('Y-m-d'),
                                          'store_id' => 1,
					  'products_weight' => '0',
					  'products_status' => '1',
					  'products_tax_class_id' => '',
					  'products_date_added' => 'now()',
					  'products_image' => '',
					  'manufacturers_id' => '');
	  smn_db_perform(TABLE_PRODUCTS, $sql_product_data_array);
	  $products_id = smn_db_insert_id();
	  smn_db_query("insert into " . TABLE_PRODUCTS_TO_CATEGORIES . " (products_id, categories_id) values ('" . (int)$products_id . "', '1')");
          $languages = smn_get_languages();
          for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
            $language_id = $languages[$i]['id']; 
            $sql_data_array = array('products_id' => $products_id,
                                    'products_name' => smn_db_prepare_input($admin_groups_name),
                                    'language_id' => $language_id,
                                    'products_url' => HTTP_CATALOG_SERVER);
            smn_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data_array);  
          }

	$sql_data_array = array('admin_groups_name' => $admin_groups_name,
				'admin_groups_store_type' => smn_db_prepare_input($_POST['admin_groups_store_types']),
				'admin_groups_products_id' => $products_id,
				'admin_sales_cost' => smn_db_prepare_input($_POST['admin_sales_cost']),
				'admin_groups_max_products' => smn_db_prepare_input($_POST['admin_groups_max_products']));	
            smn_db_perform(TABLE_ADMIN_GROUPS, $sql_data_array);
            $admin_groups_id = smn_db_insert_id();
            $set_groups_id = smn_db_prepare_input($_POST['set_groups_id']);
            $add_group_id = $set_groups_id . ',\'' . $admin_groups_id . '\'';
            smn_db_query("alter table " . TABLE_ADMIN_FILES . " change admin_groups_id admin_groups_id set( " . $add_group_id . ") NOT NULL DEFAULT '1' ");

	    
	    
	    
	    
            smn_redirect(smn_href_link(FILENAME_ADMIN_MEMBERS, 'gID=' . $admin_groups_id));
          }
        }
        break;        
    }
  }
  
  $content_page = basename($_SERVER['PHP_SELF']);
  
  require('templates/default/layout.php');

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>