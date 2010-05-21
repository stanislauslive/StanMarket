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
        function setflag(){
          if ( ($_GET['flag'] == '0') || ($_GET['flag'] == '1') ) {
            if (isset($_GET['sID'])) {
              smn_set_store_status($_GET['sID'], $_GET['flag']);
            }
            if (USE_CACHE == 'true') {
              smn_reset_cache_block('store_categories');
              smn_reset_cache_block('also_purchased');
          }
        }
          smn_redirect(smn_href_link(FILENAME_MANAGEMENT, 'sPath=' . $_GET['sPath'] . '&sID=' . $_GET['sID']));
      }

      function store_category($action){
        if (isset($_POST['store_categories_id'])) $store_categories_id = smn_db_prepare_input($_POST['store_categories_id']);
        $sort_order = smn_db_prepare_input($_POST['sort_order']);
        $sql_data_array = array('sort_order' => $sort_order);
        if ($action == 'insert_store_category') {
          $insert_sql_data = array('store_parent_id' => $current_store_category_id,
                                   'date_added' => 'now()');
          $sql_data_array = array_merge($sql_data_array, $insert_sql_data);
          smn_db_perform(TABLE_STORE_CATEGORIES, $sql_data_array);
          $store_categories_id = smn_db_insert_id();
        } elseif ($action == 'update_store_category') {
          $update_sql_data = array('last_modified' => 'now()');
          $sql_data_array = array_merge($sql_data_array, $update_sql_data);
          smn_db_perform(TABLE_STORE_CATEGORIES, $sql_data_array, 'update', "store_categories_id = '" . (int)$store_categories_id . "'");
        }
        $languages = smn_get_languages();
        for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
          $store_categories_name_array = $_POST['store_categories_name'];
          $language_id = $languages[$i]['id'];
          $sql_data_array = array('store_categories_name' => smn_db_prepare_input($store_categories_name_array[$language_id]));
          if ($action == 'insert_store_category') {
            $insert_sql_data = array('store_categories_id' => $store_categories_id,
                                     'language_id' => $languages[$i]['id']);
            $sql_data_array = array_merge($sql_data_array, $insert_sql_data);
            smn_db_perform(TABLE_STORE_CATEGORIES_DESCRIPTION, $sql_data_array);
          } elseif ($action == 'update_store_category') {
            smn_db_perform(TABLE_STORE_CATEGORIES_DESCRIPTION, $sql_data_array, 'update', "store_categories_id = '" . (int)$store_categories_id . "' and language_id = '" . (int)$languages[$i]['id'] . "'");
          }
        }
        if ($store_categories_image = new upload('store_categories_image', DIR_FS_CATALOG_IMAGES)) {
          smn_db_query("update " . TABLE_STORE_CATEGORIES . " set store_categories_image = '" . smn_db_input($store_categories_image->filename) . "' where store_categories_id = '" . (int)$store_categories_id . "'");
        }
        if (USE_CACHE == 'true') {
          smn_reset_cache_block('store_categories');
          smn_reset_cache_block('also_purchased');
        }
        smn_redirect(smn_href_link(FILENAME_MANAGEMENT, 'sPath=' . $sPath . '&cID=' . $store_categories_id));
      }
      
      function delete_store_category_confirm(){
        if (isset($_POST['store_categories_id'])) {
          $store_categories_id = smn_db_prepare_input($_POST['store_categories_id']);
          $store_categories = $store->smn_get_store_category_tree($store_categories_id, '', '0', '', true);
          $store_arr = array();
          $store_delete = array();
          for ($i=0, $n=sizeof($store_categories); $i<$n; $i++) {
            $store_ids_query = smn_db_query("select store_id from " . TABLE_STORE_TO_CATEGORIES . " where store_categories_id = '" . (int)$store_categories[$i]['id'] . "'");
            while ($store_ids = smn_db_fetch_array($store_ids_query)) {
              $store_arr[$store_ids['store_id']]['store_categories'][] = $store_categories[$i]['id'];
            }
          }
          reset($store);
          while (list($key, $value) = each($store)) {
            $store_category_ids = '';
            for ($i=0, $n=sizeof($value['store_categories']); $i<$n; $i++) {
              $store_category_ids .= "'" . (int)$value['store_categories'][$i] . "', ";
            }
            $store_category_ids = substr($store_category_ids, 0, -2);
            $check_query = smn_db_query("select count(*) as total from " . TABLE_STORE_TO_CATEGORIES . " where store_id = '" . (int)$key . "' and store_categories_id not in (" . $store_category_ids . ")");
            $check = smn_db_fetch_array($check_query);
            if ($check['total'] < '1') {
              $store_delete[$key] = $key;
            }
          }
// removing store_categories can be a lengthy process
          smn_set_time_limit(0);
          for ($i=0, $n=sizeof($store_categories); $i<$n; $i++) {
            smn_remove_store_category($store_categories[$i]['id']);
          }
          reset($store_delete);
          while (list($key) = each($store_delete)) {
            smn_remove_store($key);
          }
        }
        if (USE_CACHE == 'true') {
          smn_reset_cache_block('store_categories');
          smn_reset_cache_block('also_purchased');
        }
        smn_redirect(smn_href_link(FILENAME_MANAGEMENT, 'sPath=' . $sPath));
      }
      
      function delete_store_confirm(){
        if (isset($_POST['list_store_id']) && isset($_POST['store_categories']) && is_array($_POST['store_categories'])) {
          $list_store_id = smn_db_prepare_input($_POST['list_store_id']);
          $store_categories = $_POST['store_categories'];
          for ($i=0, $n=sizeof($store_categories); $i<$n; $i++) {
            smn_db_query("delete from " . TABLE_STORE_TO_CATEGORIES . " where store_id = '" . (int)$list_store_id . "' and store_categories_id = '" . (int)$store_categories[$i] . "'");
          }
          
          $store_categories_query = smn_db_query("select count(*) as total from " . TABLE_STORE_TO_CATEGORIES . " where store_id = '" . (int)$list_store_id . "'");
          $store_categories = smn_db_fetch_array($store_categories_query);
          if ($store_categories['total'] == '0') {
              require(DIR_WS_FUNCTIONS . 'delete_store_sql.php');
              $stores_deleted = smn_delete_store($list_store_id);
          }
        }
        if (USE_CACHE == 'true') {
          smn_reset_cache_block('store_categories');
          smn_reset_cache_block('also_purchased');
        }
       smn_redirect(smn_href_link(FILENAME_MANAGEMENT, 'sPath=' . $sPath));
      }
      
      
      function move_store_category_confirm(){
        if (isset($_POST['store_categories_id']) && ($_POST['store_categories_id'] != $_POST['move_to_store_category_id'])) {
          $store_categories_id = smn_db_prepare_input($_POST['store_categories_id']);
          $new_store_parent_id = smn_db_prepare_input($_POST['move_to_store_category_id']);
          $path = explode('_', smn_get_generated_store_category_path_ids($new_store_parent_id));
          if (in_array($store_categories_id, $path)) {
            $messageStack->add_session(ERROR_CANNOT_MOVE_CATEGORY_TO_PARENT, 'error');
            smn_redirect(smn_href_link(FILENAME_MANAGEMENT, 'sPath=' . $sPath . '&cID=' . $store_categories_id));
          } else {
            smn_db_query("update " . TABLE_STORE_CATEGORIES . " set store_parent_id = '" . (int)$new_store_parent_id . "', last_modified = now() where store_categories_id = '" . (int)$store_categories_id . "'");
            if (USE_CACHE == 'true') {
              smn_reset_cache_block('store_categories');
              smn_reset_cache_block('also_purchased');
            }
            smn_redirect(smn_href_link(FILENAME_MANAGEMENT, 'sPath=' . $new_store_parent_id . '&cID=' . $store_categories_id));
          }
        }
      }
      
      
      function move_store_confirm(){
        $list_store_id = smn_db_prepare_input($_POST['list_store_id']);
        $new_store_parent_id = smn_db_prepare_input($_POST['move_to_store_category_id']);
        $duplicate_check_query = smn_db_query("select count(*) as total from " . TABLE_STORE_TO_CATEGORIES . " where store_id = '" . (int)$list_store_id . "' and store_categories_id = '" . (int)$new_store_parent_id . "'");
        $duplicate_check = smn_db_fetch_array($duplicate_check_query);
        if ($duplicate_check['total'] < 1) smn_db_query("update " . TABLE_STORE_TO_CATEGORIES . " set store_categories_id = '" . (int)$new_store_parent_id . "' where store_id = '" . (int)$list_store_id . "' and store_categories_id = '" . (int)$current_store_category_id . "'");
        if (USE_CACHE == 'true') {
          smn_reset_cache_block('store_categories');
          smn_reset_cache_block('also_purchased');
        }
        smn_redirect(smn_href_link(FILENAME_MANAGEMENT, 'sPath=' . $new_store_parent_id . '&sID=' . $list_store_id));
      }
      
      function manage_store_image(){

      // copy image only if modified
        $store_image = new upload('store_image');
        $store_image->set_destination(DIR_FS_CATALOG_IMAGES);
        if ($store_image->parse() && $store_image->save()) {
          $store_image_name = $store_image->filename;
        } else {
          $store_image_name = (isset($_POST['store_previous_image']) ? $_POST['store_previous_image'] : '');
        }
        
          if (USE_CACHE == 'true') {
            smn_reset_cache_block('store_categories');
            smn_reset_cache_block('also_purchased');
          smn_redirect(smn_href_link(FILENAME_MANAGEMENT, 'sPath=' . $sPath . '&sID=' . $list_store_id));
          }
      }
      
      function copy_to_confirm(){
        if (isset($_POST['list_store_id']) && isset($_POST['store_categories_id'])) {
          $list_store_id = smn_db_prepare_input($_POST['list_store_id']);
          $store_categories_id = smn_db_prepare_input($_POST['store_categories_id']);
          if ($_POST['copy_as'] == 'link') {
            if ($store_categories_id != $current_store_category_id) {
              $check_query = smn_db_query("select count(*) as total from " . TABLE_STORE_TO_CATEGORIES . " where store_id = '" . (int)$list_store_id . "' and store_categories_id = '" . (int)$store_categories_id . "'");
              $check = smn_db_fetch_array($check_query);
              if ($check['total'] < '1') {
                smn_db_query("insert into " . TABLE_STORE_TO_CATEGORIES . " (store_id, store_categories_id) values ('" . (int)$list_store_id . "', '" . (int)$store_categories_id . "')");
              }
            } else {
              $messageStack->add_session(ERROR_CANNOT_LINK_TO_SAME_CATEGORY, 'error');
            }
          } elseif ($_POST['copy_as'] == 'duplicate') {
            $store_query = smn_db_query("select store_image, store_status  from " . TABLE_STORE_MAIN . " where store_id = '" . (int)$list_store_id . "'");
            $store_arr = smn_db_fetch_array($store_query);
           smn_db_query("insert into " . TABLE_STORE_MAIN . " (store_image, date_added, store_status) values ('" . smn_db_input($store_arr['store_image']) . "', now(), '0')");
            $dup_store_id = smn_db_insert_id();
            $description_query = smn_db_query("select language_id, store_name, store_description from " . TABLE_STORE_DESCRIPTION . " where store_id = '" . (int)$list_store_id . "'");
            while ($description = smn_db_fetch_array($description_query)) {
              smn_db_query("insert into " . TABLE_STORE_DESCRIPTION . " (store_id, language_id, store_name, store_description, store_viewed) values ('" . (int)$dup_store_id . "', '" . (int)$description['language_id'] . "', '" . smn_db_input($description['store_name']) . "', '" . smn_db_input($description['store_description']) . "', '0')");
            }
            smn_db_query("insert into " . TABLE_STORE_TO_CATEGORIES . " (store_id, store_categories_id) values ('" . (int)$dup_store_id . "', '" . (int)$store_categories_id . "')");
            $list_store_id = $dup_store_id;
          }
          if (USE_CACHE == 'true') {
            smn_reset_cache_block('store_categories');
            smn_reset_cache_block('also_purchased');
          }
        }
        smn_redirect(smn_href_link(FILENAME_MANAGEMENT, 'sPath=' . $store_categories_id . '&sID=' . $list_store_id));
      }
      
      function edit_store(){
        $store_query = smn_db_query("select sd.store_name, s.store_id, s.store_image, sd.store_description as store_description, so.store_owner_firstname as customers_firstname, so.store_owner_lastname as customers_lastname, so.telephone_number, so.fax_number, so.newsletter as customers_newsletter, so.street_address, so.postal_code, so.city, so.company as entry_company, so.state, so.country from " . TABLE_STORE_MAIN . " s, " . TABLE_STORE_DESCRIPTION . " sd, " . TABLE_STORE_OWNER_DATA . " so where s.store_id = '" . (int)$sID . "' AND s.store_id = sd.store_id AND s.store_id = so.store_id");
        $store_arr = smn_db_fetch_array($store_query);
        $sInfo = new objectInfo($store_arr);
      }