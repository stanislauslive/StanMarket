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

function smn_store_info ($store_id = 1){
  define('TABLE_STORE_MAIN','store_main');
  define('TABLE_ADMIN_GROUPS', 'admin_groups');
  define('TABLE_STORE_TYPES', 'store_types');
  define('TABLE_STORE_DESCRIPTION', 'store_description');
  
  $store_query = smn_db_query("select * from " . TABLE_STORE_MAIN . " WHERE store_id = '". $store_id ."'");
  $store_array = smn_db_fetch_array($store_query);
  
  $store_name_query = smn_db_query("select * from " . TABLE_STORE_DESCRIPTION . " where store_id='" . $store_id . "'");
  $current_store_name = smn_db_fetch_array($store_name_query); 
  
  $store_info[] = array('store_type' => (int)$store_array['store_type'],
                        'store_name' => stripslashes($current_store_name['store_name']),
                        'store_description' => stripslashes($current_store_name['store_description']),
                        'store_status' => (int)$store_array['store_status'],
                        'store_image' => $store_array['store_image'],
                        'store_open_time' => $store_array['store_open_time'],
                        'store_closed_time' => $store_array['store_closed_time'],
                        'store_id' => (int)$store_array['store_id']);
  return ($store_info);
}

function smn_set_store_group_type ($store_group_type = 1){  
  $store_type_query = smn_db_query("select admin_groups_store_type from " . TABLE_ADMIN_GROUPS . " where admin_groups_id = '" . $store_group_type ."'");
  $store_type = smn_db_fetch_array($store_type_query);
  return $store_type['admin_groups_store_type'];
}


function smn_set_store_type ($store_type = 1)
{
  $store_type_query = smn_db_query("select st.store_types_name from " . TABLE_ADMIN_GROUPS . " ag,  " . TABLE_STORE_TYPES . " st where ag.admin_groups_store_type = st.store_types_id and ag.admin_groups_id = '" . $store_type ."'");
  $store_type = smn_db_fetch_array($store_type_query);
  
  return $store_type['store_types_name'];
}

function smn_set_products_id ($store_type = 1){
  $store_products_id_query = smn_db_query("select admin_groups_products_id from " . TABLE_ADMIN_GROUPS . " where admin_groups_id = '" . $store_type ."'");
  $store_products_id = smn_db_fetch_array($store_products_id_query);
  
  return $store_products_id['admin_groups_products_id'];
}

function smn_set_store_cost ($store_type = 1){
  $store_cost_query = smn_db_query("select p.products_price from " . TABLE_ADMIN_GROUPS . " ag,  " . TABLE_PRODUCTS . " p where ag.admin_groups_products_id = p.products_id and ag.admin_groups_store_type = '" . $store_type ."'");
  $store_cost = smn_db_fetch_array($store_cost_query);
  
  return $store_cost['products_price'];
}

function smn_get_store_names ($store_id = 0){        
          $store_names_array = array(array('id' => '0', 'text' => TEXT_NONE));
          $where = '';
          if ($store_id > 0){
            $where = " where store_id = '" . $store_id . "'";
          } 
          $store_names_query = smn_db_query("select store_id, store_name from " . TABLE_STORE_DESCRIPTION . $where);
          while ($store_name_= smn_db_fetch_array($store_names_query))
            {
             $store_names_array[] = array('id' => $store_names['store_id'],
                                        'text' => $store_names['store_name']);
            }
  return $store_names_array;          
}

  function smn_set_db_tables ($store_id = 1, $store_type = 'mall'){
    define('DIR_WS_BODY', DIR_WS_INCLUDES . 'body/' . $store_type . '/');
    define('DIR_WS_JAVA', DIR_WS_INCLUDES . 'java/');
    require(DIR_WS_INCLUDES . $store_type . '_filenames.php');
    define('DIR_WS_ADMIN',  DIR_WS_HTTP_CATALOG . 'mall_admin/');
    require(DIR_WS_INCLUDES . 'database_tables.php');
    smn_set_database_tables();
    define('DIR_WS_IMAGES', 'images/'. $store_id . '_images/');
    define('DIR_WS_STORE_CATALOG', $store_type . '/');
    define('DIR_WS_CATALOG_IMAGES', DIR_WS_CATALOG .'images/'. $store_id . '_images/');
    define('DIR_WS_ICONS', DIR_WS_IMAGES . 'icons/');
    define('DIR_FS_CATALOG_IMAGES', DIR_FS_CATALOG .'images/'. $store_id . '_images/');       
}

function smn_set_store_hours ($store_open_time, $store_closed_time){        
  $open_time = explode (":", $store_open_time);
  $closed_time = explode (":", $store_closed_time);      
  $store_open_time  = (intval($open_time[0] . $open_time[1] . $open_time[2]));
  $store_closed_time  = (intval($closed_time[0] . $closed_time[2] . $closed_time[2]));
  if ((strftime ("%H%M%S")) > $store_open_time && (strftime ("%H%M%S")) < $store_closed_time){
    return ($store_open = TRUE);
  }else{
    return ($store_open = FALSE);
  }
}

////
//Return 'true' or 'false' value to display boxes and files in index.php and column_left.php
function smn_admin_check_boxes($filename, $boxes='') {
  global $login_groups_id;
  
  $is_boxes = 1;
  if ($boxes == 'sub_boxes') {
    $is_boxes = 0;
  }
  $dbquery = smn_db_query("select admin_files_id from " . TABLE_ADMIN_FILES . " where FIND_IN_SET( '" . $login_groups_id . "', admin_groups_id) and admin_files_is_boxes = '" . $is_boxes . "' and admin_files_name = '" . $filename . "'");
  
  $return_value = false;
  if (smn_db_num_rows($dbquery)) {
    $return_value = true;
  }
  return $return_value;
}

////
//Return files stored in box that can be accessed by user
function smn_admin_files_boxes($filename, $sub_box_name) {
  global $login_groups_id;
  $sub_boxes = '';
  
  $dbquery = smn_db_query("select admin_files_name from " . TABLE_ADMIN_FILES . " where FIND_IN_SET( '" . $login_groups_id . "', admin_groups_id) and admin_files_is_boxes = '0' and admin_files_name = '" . $filename . "'");
  if (smn_db_num_rows($dbquery)) {
    $sub_boxes = '<a href="' . smn_href_link($filename) . '" class="menuBoxContentLink">' . $sub_box_name . '</a><br>';
  }
  return $sub_boxes;
}

////
//Get selected file for index.php
function smn_selected_file($filename) {
  global $login_groups_id;
  $randomize = FILENAME_ADMIN_ACCOUNT;
  
  $dbquery = smn_db_query("select admin_files_id as boxes_id from " . TABLE_ADMIN_FILES . " where FIND_IN_SET( '" . $login_groups_id . "', admin_groups_id) and admin_files_is_boxes = '1' and admin_files_name = '" . $filename . "'");
  if (smn_db_num_rows($dbquery)) {
    $boxes_id = smn_db_fetch_array($dbquery);
    $randomize_query = smn_db_query("select admin_files_name from " . TABLE_ADMIN_FILES . " where FIND_IN_SET( '" . $login_groups_id . "', admin_groups_id) and admin_files_is_boxes = '0' and admin_files_to_boxes = '" . $boxes_id['boxes_id'] . "'");
    if (smn_db_num_rows($randomize_query)) {
      $file_selected = smn_db_fetch_array($randomize_query);
      $randomize = $file_selected['admin_files_name'];
    }
  }
  return $randomize;
}

  function smn_get_store_category_tree($store_parent_id = '0', $spacing = '', $exclude = '', $store_category_tree_array = '', $include_itself = false) {
    global $languages_id;

    if (!is_array($store_category_tree_array)) $store_category_tree_array = array();
    if ( (sizeof($store_category_tree_array) < 1) && ($exclude != '0') ) $store_category_tree_array[] = array('id' => '0', 'text' => 'Top');

    if ($include_itself) {
      $store_category_query = smn_db_query("select cd.store_categories_name from " . TABLE_STORE_CATEGORIES_DESCRIPTION . " cd where cd.language_id = '" . (int)$languages_id . "' and cd.store_categories_id = '" . (int)$store_parent_id . "'");
      $store_category = smn_db_fetch_array($store_category_query);
      $store_category_tree_array[] = array('id' => $store_parent_id, 'text' => $store_category['store_categories_name']);
    }

    $store_categories_query = smn_db_query("select c.store_categories_id, cd.store_categories_name, c.store_parent_id from " . TABLE_STORE_CATEGORIES . " c, " . TABLE_STORE_CATEGORIES_DESCRIPTION . " cd where c.store_categories_id = cd.store_categories_id and cd.language_id = '" . (int)$languages_id . "' and c.store_parent_id = '" . (int)$store_parent_id . "' order by c.sort_order, cd.store_categories_name");
    while ($store_categories = smn_db_fetch_array($store_categories_query)) {
      if ($exclude != $store_categories['store_categories_id']) $store_category_tree_array[] = array('id' => $store_categories['store_categories_id'], 'text' => $spacing . $store_categories['store_categories_name']);
      $store_category_tree_array = smn_get_store_category_tree($store_categories['store_categories_id'], $spacing . '&nbsp;&nbsp;&nbsp;', $exclude, $store_category_tree_array);
    }

    return $store_category_tree_array;
  }


  function smn_store_in_category_count($store_categories_id, $include_deactivated = false) {
    $stores_count = 0;

    if ($include_deactivated) {
      $store_query = smn_db_query("select count(*) as total from " . TABLE_STORE_MAIN . " s, " . TABLE_STORE_TO_CATEGORIES . " s2c where s.store_id = s2c.store_id and s2c.store_categories_id = '" . (int)$store_categories_id . "'");
    } else {
      $store_query = smn_db_query("select count(*) as total from " . TABLE_STORE_MAIN . " s, " . TABLE_STORE_TO_CATEGORIES . " s2c where s.store_id = s2c.store_id and s.store_status = '1' and s2c.store_categories_id = '" . (int)$store_categories_id . "'");
    }

    $store = smn_db_fetch_array($store_query);

    $store_count += $store['total'];

    $childs_query = smn_db_query("select store_categories_id from " . TABLE_STORE_CATEGORIES . " where store_parent_id = '" . (int)$store_categories_id . "'");
    if (smn_db_num_rows($childs_query)) {
      while ($childs = smn_db_fetch_array($childs_query)) {
        $store_count += smn_store_in_category_count($childs['store_categories_id'], $include_deactivated);
      }
    }
    return $store_count;
  }


  function smn_get_store_name($product_id, $language_id = 0) {
    global $languages_id;

    if ($language_id == 0) $language_id = $languages_id;
    $store_query = smn_db_query("select store_name from " . TABLE_STORE_DESCRIPTION . " where store_id = '" . (int)$store_id . "' and language_id = '" . (int)$language_id . "'");
    $store = smn_db_fetch_array($store_query);
    return $store['store_name'];
  }
  
    function smn_get_store_description($store_id, $language_id) {
    $store_query = smn_db_query("select store_description from " . TABLE_STORE_DESCRIPTION . " where store_id = '" . (int)$store_id . "' and language_id = '" . (int)$language_id . "'");
    $store = smn_db_fetch_array($store_query);

    return $store['store_description'];
  }

  function smn_get_store_category_name($store_category_id, $language_id) {
    $store_category_query = smn_db_query("select store_categories_name from " . TABLE_STORE_CATEGORIES_DESCRIPTION . " where store_categories_id = '" . (int)$store_category_id . "' and language_id = '" . (int)$language_id . "'");
    $store_category = smn_db_fetch_array($store_category_query);

    return $store_category['store_categories_name'];
  }
  
  ////
// Count how many subcategories exist in a category
// TABLES: categories
  function smn_childs_in_store_category_count($store_categories_id) {
    $store_categories_count = 0;

    $store_categories_query = smn_db_query("select store_categories_id from " . TABLE_STORE_CATEGORIES . " where store_parent_id = '" . (int)$store_categories_id . "'");
    while ($store_categories = smn_db_fetch_array($store_categories_query)) {
      $store_categories_count++;
      $store_categories_count += smn_childs_in_store_category_count($store_categories['store_categories_id']);
    }

    return $store_categories_count;
  }
 
function smn_generate_store_category_path($id, $from = 'store_category', $store_categories_array = '', $index = 0) {
    global $languages_id;

    if (!is_array($store_categories_array)) $store_categories_array = array();

    if ($from == 'store') {
      $store_categories_query = smn_db_query("select store_categories_id from " . TABLE_STORE_TO_CATEGORIES . " where store_id = '" . (int)$id . "'");
      while ($store_categories = smn_db_fetch_array($store_categories_query)) {
        if ($store_categories['store_categories_id'] == '0') {
          $store_categories_array[$index][] = array('id' => '0', 'text' => TEXT_TOP);
        } else {
          $store_category_query = smn_db_query("select cd.store_categories_name, c.store_parent_id from " . TABLE_STORE_CATEGORIES . " c, " . TABLE_STORE_CATEGORIES_DESCRIPTION . " cd where c.store_categories_id = '" . (int)$store_categories['store_categories_id'] . "' and c.store_categories_id = cd.store_categories_id and cd.language_id = '" . (int)$languages_id . "'");
          $store_category = smn_db_fetch_array($store_category_query);
          $store_categories_array[$index][] = array('id' => $store_categories['store_categories_id'], 'text' => $store_category['store_categories_name']);
          if ( (smn_not_null($store_category['store_parent_id'])) && ($store_category['store_parent_id'] != '0') ) $store_categories_array = smn_generate_store_category_path($store_category['store_parent_id'], 'store_category', $store_categories_array, $index);
          $store_categories_array[$index] = array_reverse($store_categories_array[$index]);
        }
        $index++;
      }
    } elseif ($from == 'store_category') {
      $store_category_query = smn_db_query("select cd.store_categories_name, c.store_parent_id from " . TABLE_STORE_CATEGORIES . " c, " . TABLE_STORE_CATEGORIES_DESCRIPTION . " cd where c.store_categories_id = '" . (int)$id . "' and c.store_categories_id = cd.store_categories_id and cd.language_id = '" . (int)$languages_id . "'");
      $store_category = smn_db_fetch_array($store_category_query);
      $store_categories_array[$index][] = array('id' => $id, 'text' => $store_category['store_categories_name']);
      if ( (smn_not_null($store_category['store_parent_id'])) && ($store_category['store_parent_id'] != '0') ) $store_categories_array = smn_generate_store_category_path($store_category['store_parent_id'], 'store_category', $store_categories_array, $index);
    }

    return $store_categories_array;
  }

  function smn_output_generated_store_category_path($id, $from = 'store_category') {
    $calculated_store_category_path_string = '';
    $calculated_store_category_path = smn_generate_store_category_path($id, $from);
    for ($i=0, $n=sizeof($calculated_store_category_path); $i<$n; $i++) {
      for ($j=0, $k=sizeof($calculated_store_category_path[$i]); $j<$k; $j++) {
        $calculated_store_category_path_string .= $calculated_store_category_path[$i][$j]['text'] . '&nbsp;&gt;&nbsp;';
      }
      $calculated_store_category_path_string = substr($calculated_store_category_path_string, 0, -16) . '<br>';
    }
    $calculated_store_category_path_string = substr($calculated_store_category_path_string, 0, -4);

    if (strlen($calculated_store_category_path_string) < 1) $calculated_store_category_path_string = TEXT_TOP;

    return $calculated_store_category_path_string;
  }

  function smn_get_generated_store_category_path_ids($id, $from = 'store_category') {
    $calculated_store_category_path_string = '';
    $calculated_store_category_path = smn_generate_store_category_path($id, $from);
    for ($i=0, $n=sizeof($calculated_store_category_path); $i<$n; $i++) {
      for ($j=0, $k=sizeof($calculated_store_category_path[$i]); $j<$k; $j++) {
        $calculated_store_category_path_string .= $calculated_store_category_path[$i][$j]['id'] . '_';
      }
      $calculated_store_category_path_string = substr($calculated_store_category_path_string, 0, -1) . '<br>';
    }
    $calculated_store_category_path_string = substr($calculated_store_category_path_string, 0, -4);

    if (strlen($calculated_store_category_path_string) < 1) $calculated_store_category_path_string = TEXT_TOP;

    return $calculated_store_category_path_string;
  }

  function smn_remove_store_category($store_category_id) {
    $store_category_image_query = smn_db_query("select store_categories_image from " . TABLE_STORE_CATEGORIES . " where store_categories_id = '" . (int)$store_category_id . "'");
    $store_category_image = smn_db_fetch_array($store_category_image_query);

    $duplicate_image_query = smn_db_query("select count(*) as total from " . TABLE_STORE_CATEGORIES . " where store_categories_image = '" . smn_db_input($store_category_image['store_categories_image']) . "'");
    $duplicate_image = smn_db_fetch_array($duplicate_image_query);

    if ($duplicate_image['total'] < 2) {
      if (file_exists(DIR_FS_CATALOG_IMAGES . $store_category_image['store_categories_image'])) {
        @unlink(DIR_FS_CATALOG_IMAGES . $store_category_image['store_categories_image']);
      }
    }

    smn_db_query("delete from " . TABLE_STORE_CATEGORIES . " where store_categories_id = '" . (int)$store_category_id . "'");
    smn_db_query("delete from " . TABLE_STORE_CATEGORIES_DESCRIPTION . " where store_categories_id = '" . (int)$store_category_id . "'");
    smn_db_query("delete from " . TABLE_STORE_TO_CATEGORIES . " where store_categories_id = '" . (int)$store_category_id . "'");

    if (USE_CACHE == 'true') {
      smn_reset_cache_block('store_categories');
      smn_reset_cache_block('also_purchased');
    }
  }
  
  function smn_remove_store($category_id) {
    $category_image_query = smn_db_query("select store_categories_image from " . TABLE_STORE_CATEGORIES . " where store_categories_id = '" . (int)$category_id . "'");
    $category_image = smn_db_fetch_array($category_image_query);

    $duplicate_image_query = smn_db_query("select count(*) as total from " . TABLE_STORE_CATEGORIES . " where store_categories_image = '" . smn_db_input($category_image['store_categories_image']) . "'");
    $duplicate_image = smn_db_fetch_array($duplicate_image_query);

    if ($duplicate_image['total'] < 2) {
      if (file_exists(DIR_FS_CATALOG_IMAGES . $category_image['store_categories_image'])) {
        @unlink(DIR_FS_CATALOG_IMAGES . $category_image['store_categories_image']);
      }
    }

    smn_db_query("delete from " . TABLE_STORE_CATEGORIES . " where store_categories_id = '" . (int)$store_categories_id . "'");
    smn_db_query("delete from " . TABLE_STORE_CATEGORIES_DESCRIPTION . " where store_categories_id = '" . (int)$store_categories_id . "'");
    smn_db_query("delete from " . TABLE_STORE_TO_CATEGORIES . " where store_categories_id = '" . (int)$store_categories_id . "'");

    if (USE_CACHE == 'true') {
      smn_reset_cache_block('store_categories');
    }
  }  
  
  ////
// Parse and secure the sPath parameter values
  function smn_parse_store_category_path($sPath) {
// make sure the category IDs are integers
    $sPath_array = array_map('smn_string_to_int', explode('_', $sPath));

// make sure no duplicate category IDs exist which could lock the server in a loop
    $tmp_array = array();
    $n = sizeof($sPath_array);
    for ($i=0; $i<$n; $i++) {
      if (!in_array($sPath_array[$i], $tmp_array)) {
        $tmp_array[] = $sPath_array[$i];
      }
    }

    return $tmp_array;
  }

  function smn_get_spath($current_store_category_id = '') {
    global $sPath_array;

    if ($current_store_category_id == '') {
      $sPath_new = implode('_', $sPath_array);
    } else {
      if (sizeof($sPath_array) == 0) {
        $sPath_new = $current_store_category_id;
      } else {
        $sPath_new = '';
        $last_store_category_query = smn_db_query("select store_parent_id from " . TABLE_STORE_CATEGORIES . " where store_categories_id = '" . (int)$sPath_array[(sizeof($sPath_array)-1)] . "'");
        $last_store_category = smn_db_fetch_array($last_store_category_query);

        $current_store_category_query = smn_db_query("select store_parent_id from " . TABLE_STORE_CATEGORIES . " where store_categories_id = '" . (int)$current_store_category_id . "'");
        $current_store_category = smn_db_fetch_array($current_store_category_query);

        if ($last_store_category['store_parent_id'] == $current_store_category['store_parent_id']) {
          for ($i = 0, $n = sizeof($sPath_array) - 1; $i < $n; $i++) {
            $sPath_new .= '_' . $sPath_array[$i];
          }
        } else {
          for ($i = 0, $n = sizeof($sPath_array); $i < $n; $i++) {
            $sPath_new .= '_' . $sPath_array[$i];
          }
        }

        $sPath_new .= '_' . $current_store_category_id;

        if (substr($sPath_new, 0, 1) == '_') {
          $sPath_new = substr($sPath_new, 1);
        }
      }
    }
  }
  
////
// Sets the status of a store
  function smn_set_store_status($store_id, $status) {
    if ($status == '1') {
      return smn_db_query("update " . TABLE_STORE_MAIN . " set store_status = '1' where store_id = '" . (int)$store_id . "'");
    } elseif ($status == '0') {
      return smn_db_query("update " . TABLE_STORE_MAIN . " set store_status = '0' where store_id = '" . (int)$store_id . "'");
    } else {
      return -1;
    }
  }

function smn_get_store_status($store_status){   
  if ($store_status != 1){
    return ($store_registered = FALSE);
  }else{
    return ($store_registered = TRUE);
  }
}
  
function smn_store_add_products($store_group_type) {
    $store_max_query = smn_db_query("select admin_groups_max_products from " . TABLE_ADMIN_GROUPS . " where admin_groups_id = '" . $store_group_type ."'");
    $store_max = smn_db_fetch_array($store_max_query);
    if ((int)$store_max['admin_groups_max_products'] == 0)
      return TRUE;
    $check_query = smn_db_query("select count(*) as total from " . TABLE_PRODUCTS);
    $check = smn_db_fetch_array($check_query);

    if ((int)$check['total'] < (int)$store_max['admin_groups_max_products'])
    {
      return TRUE;
    }else{
      return FALSE;
    }
  }
  function smn_get_products_master_status($product_id) {

    $product_query = smn_db_query("select products_master_status from " . TABLE_PRODUCTS . " where products_id = '" . (int)$product_id . "'");
    $product = smn_db_fetch_array($product_query);

    return $product['products_master_status'];
  }

function smn_set_template ($custom, $theme = '', $layout = ''){
    global $language;
    $default_theme = 'smn_original';
  // set the template and theme parameters (can be modified through the administration interface)
  
  if ($custom){
    //Site template configuration system
    if ((smn_not_null($theme)) && (smn_not_null($layout))){
      $template['themeKey'] = $theme;
      $template['templateValue'] = $layout;
    }else{
    // set the template and theme parameters (can be modified through the administration interface)
      $template_query = smn_db_query("select thema as themeKey, template_name as templateValue from " . TABLE_TEMPLATE . " where use_template = 'true'");
      $template = smn_db_fetch_array($template_query);
    }
    if(($template['templateValue']=="") || ($template['themeKey']=="")) {
      define('TEMPLATE_STYLE', DIR_WS_TEMPLATE . $default_theme . '/catalog.php');
      define('DIR_WS_SITE_FILES', DIR_WS_TEMPLATE . $default_theme . '/');
      define('THEMA_STYLE', DIR_WS_SITE_FILES . 'blue/stylesheet.css');  
      define('DIR_WS_BOXES', DIR_WS_SITE_FILES . 'theme_boxes/');
      define('DIR_WS_BUTTONS', DIR_WS_SITE_FILES . $default_theme . '/' . $language . '_buttons/');
      define('DIR_WS_INFOBOX', DIR_WS_SITE_FILES . THEME_STYLE . $default_theme . '/infobox/');
      define('TEMPLATE_IMAGES', DIR_WS_TEMPLATE . 'template_images/');  
      require(DIR_WS_SITE_FILES . 'thema_boxes.php');
      $newtheme = THEME_STYLE;
    }else{
      $newtheme = THEME_STYLE;
      define('THEME_STYLE',$template['themeKey']);
      define('TEMPLATE',$template['templateValue']);
      define('TEMPLATE_STYLE', DIR_WS_TEMPLATE . TEMPLATE . '/catalog.php');
      define('DIR_WS_SITE_FILES', DIR_WS_TEMPLATE . TEMPLATE . '/');
      define('THEMA_STYLE', DIR_WS_SITE_FILES . THEME_STYLE . '/stylesheet.css');  
      define('DIR_WS_BOXES', DIR_WS_SITE_FILES . 'theme_boxes/');
      define('DIR_WS_BUTTONS', DIR_WS_SITE_FILES . THEME_STYLE . '/'. $language . '_buttons/');
      define('DIR_WS_INFOBOX', DIR_WS_SITE_FILES . THEME_STYLE . '/infobox/');
      define('TEMPLATE_IMAGES', DIR_WS_SITE_FILES . 'template_images/');
      require(DIR_WS_SITE_FILES . 'thema_boxes.php');
    }
  }
}
?>