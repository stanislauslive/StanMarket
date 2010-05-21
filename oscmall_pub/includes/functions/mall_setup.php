<?php
/*
  Copyright (c) 2002 - 2006 SystemsManager.Net

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



function smn_set_store_type ($store_type = 1){
  $store_type_query = smn_db_query("select st.store_types_name from " . TABLE_ADMIN_GROUPS . " ag,  " . TABLE_STORE_TYPES . " st where ag.admin_groups_store_type = st.store_types_id and ag.admin_groups_id = '" . $store_type ."'");
  $store_type = smn_db_fetch_array($store_type_query);
  
  return $store_type['store_types_name'];
}

function smn_new_store_type ($new_store_type = 1){
  $store_type_query = smn_db_query("select store_types_name from " . TABLE_STORE_TYPES . " where store_types_id = '" . $new_store_type ."'");
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

function smn_set_store_status($store_status){   
  if ($store_status != 1)
  {
    return ($store_registered = FALSE);
  }else{
    return ($store_registered = TRUE);
  }
}


function smn_get_store_names ($store_id = 0){        
          $store_names_array = array(array('id' => '0', 'text' => TEXT_NONE));
          $where = '';
          if ($store_id > 0){
            $where = " where store_id = '" . $store_id . "'";
          } 
          $store_names_query = smn_db_query("select store_id, store_name from " . TABLE_STORE_DESCRIPTION . $where);
          while ($store_names= smn_db_fetch_array($store_names_query))
            {
             $store_names_array[] = array('id' => $store_names['store_id'],
                                        'text' => $store_names['store_name']);
            }
  return $store_names_array;          
}




// Return true if the category has subcategories
// TABLES: store_categories
  function smn_has_store_category_subcategories($store_category_id) {
    $child_store_category_query = smn_db_query("select count(*) as count from " . TABLE_STORE_CATEGORIES . " where store_parent_id = '" . (int)$store_category_id . "'");
    $child_store_category = smn_db_fetch_array($child_store_category_query);

    if ($child_store_category['count'] > 0) {
      return true;
    } else {
      return false;
    }
  }
  
// Parse and secure the cPath parameter values
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
  
// Generate a path to store_categories
  function smn_get_spath($current_store_category_id = '') {
    global $sPath_array;

    if (smn_not_null($current_store_category_id)) {
      $cp_size = sizeof($sPath_array);
      if ($cp_size == 0) {
        $sPath_new = $current_store_category_id;
      } else {
        $sPath_new = '';
        $last_store_category_query = smn_db_query("select store_parent_id from " . TABLE_STORE_CATEGORIES . " where store_categories_id = '" . (int)$sPath_array[($cp_size-1)] . "'");
        $last_store_category = smn_db_fetch_array($last_store_category_query);

        $current_store_category_query = smn_db_query("select store_parent_id from " . TABLE_STORE_CATEGORIES . " where store_categories_id = '" . (int)$current_store_category_id . "'");
        $current_store_category = smn_db_fetch_array($current_store_category_query);

        if ($last_store_category['store_parent_id'] == $current_store_category['store_parent_id']) {
          for ($i=0; $i<($cp_size-1); $i++) {
            $sPath_new .= '_' . $sPath_array[$i];
          }
        } else {
          for ($i=0; $i<$cp_size; $i++) {
            $sPath_new .= '_' . $sPath_array[$i];
          }
        }
        $sPath_new .= '_' . $current_store_category_id;

        if (substr($sPath_new, 0, 1) == '_') {
          $sPath_new = substr($sPath_new, 1);
        }
      }
    } else {
      $sPath_new = implode('_', $sPath_array);
    }
    return 'sPath=' . $sPath_new;
  }
  
// Return the number of products in a store_category
  function smn_count_store_in_category($store_category_id, $include_inactive = false) {
    $store_count = 0;
    if ($include_inactive == true) {
      $store_query = smn_db_query("select count(*) as total from " . TABLE_STORE_MAIN . " p, " . TABLE_STORE_TO_CATEGORIES . " p2c where p.store_id = p2c.store_id and p2c.store_categories_id = '" . (int)$store_category_id . "'");
    } else {
      $store_query = smn_db_query("select count(*) as total from " . TABLE_STORE_MAIN . " p, " . TABLE_STORE_TO_CATEGORIES . " p2c where p.store_id = p2c.store_id and p.store_status = '1' and p2c.store_categories_id = '" . (int)$store_category_id . "'");
    }
    $store = smn_db_fetch_array($store_query);
    $store_count += $store['total'];

    $child_store_categories_query = smn_db_query("select store_categories_id from " . TABLE_STORE_CATEGORIES . " where store_parent_id = '" . (int)$store_category_id . "'");
    if (smn_db_num_rows($child_store_categories_query)) {
      while ($child_store_categories = smn_db_fetch_array($child_store_categories_query)) {
        $store_count += smn_count_store_in_category($child_store_categories['store_categories_id'], $include_inactive);
      }
    }
    return $store_count;
  }
  
function smn_get_store_category_tree($store_parent_id = '0', $spacing = '', $exclude = '0', $store_category_tree_array = '', $include_itself = false) {
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
  
  ////
// Recursively go through the store_categories and retreive all parent store_categories IDs
// TABLES: store_categories
function smn_get_parent_store_categories(&$store_categories, $store_categories_id) {
    $parent_store_categories_query = smn_db_query("select store_parent_id from " . TABLE_STORE_CATEGORIES . " where store_categories_id = '" . (int)$store_categories_id . "'");
    while ($parent_store_categories = smn_db_fetch_array($parent_store_categories_query)) {
      if ($parent_store_categories['store_parent_id'] == 0) return true;
      $store_categories[sizeof($store_categories)] = $parent_store_categories['store_parent_id'];
      if ($parent_store_categories['store_parent_id'] != $store_categories_id) {
        smn_get_parent_store_categories($store_categories, $parent_store_categories['store_parent_id']);
      }
    }
  }

// Construct a store_category path to the product
// TABLES: store_to_categories
function smn_get_store_path($store_id) {
    $sPath = '';

    $category_query = smn_db_query("select s2c.store_categories_id from " . TABLE_STORE_MAIN . " s, " . TABLE_STORE_TO_CATEGORIES . " s2c where s.store_id = '" . (int)$store_id . "' and s.store_status = '1' and s.store_id = s2c.store_id limit 1");
    if (smn_db_num_rows($store_category_query)) {
      $store_category = smn_db_fetch_array($store_category_query);

      $store_categories = array();
      smn_get_parent_store_categories($store_categories, $store_category['store_categories_id']);

      $store_categories = array_reverse($store_categories);

      $sPath = implode('_', $store_categories);

      if (smn_not_null($sPath)) $sPath .= '_';
      $sPath .= $store_category['store_categories_id'];
    }
    return $sPath;
  }
  
function  smn_set_sPath($sPath)
{
    // calculate store_category path
  if (isset($sPath)) {
    return $sPath;
  } elseif (isset($_GET['store_id'])) {
    return ($sPath = smn_get_spath($_GET['store_id']));
  } else {
    return ($sPath = '');
  }
}

function  smn_set_store_category_id ($sPath)
{
    global $sPath_array;
  if (smn_not_null($sPath)) {
    $sPath = implode('_', $sPath_array);
    return ($current_store_category_id = $sPath_array[(sizeof($sPath_array)-1)]);
  } else {
    return ($current_store_category_id = 0);
  }
}
?>