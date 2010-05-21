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
  $boxHeading = BOX_HEADING_STORE_CATEGORIES;
  $box_base_name = 'store_categories'; 
  $box_id = $box_base_name . 'Box';
  
  function smn_show_store_category($store_counter) {
    global $stree, $boxContent, $sPath_array;

    for ($i=0; $i<$stree[$store_counter]['level']; $i++) {
      $boxContent  .=  "&nbsp;&nbsp;";
    }

    $boxContent  .=  '<a href="';

    if ($stree[$store_counter]['parent'] == 0) {
      $sPath_new = 'sPath=' . $store_counter;
    } else {
      $sPath_new = 'sPath=' . $stree[$store_counter]['path'];
    }

    $boxContent  .=  smn_href_link(FILENAME_STORE_LISTING, $sPath_new) . '">';

    if (isset($sPath_array) && in_array($store_counter, $sPath_array)) {
      $boxContent  .=  '<b>';
    }

// display category name
    $boxContent  .=  $stree[$store_counter]['name'];

    if (isset($sPath_array) && in_array($store_counter, $sPath_array)) {
      $boxContent  .=  '</b>';
    }

    if (smn_has_store_category_subcategories($store_counter)) {
      $boxContent  .=  '-&gt;';
    }

    $boxContent  .=  '</a>';

    if (SHOW_COUNTS == 'true') {
      $store_in_category = smn_count_store_in_category($store_counter);
      if ($store_in_category > 0) {
        $boxContent  .=  '&nbsp;(' . $store_in_category . ')';
      }
    }

    $boxContent  .=  '<br>';

    if ($stree[$store_counter]['next_id'] != false) {
      smn_show_store_category($stree[$store_counter]['next_id']);
    }
  }
?>
<!-- store_categories //-->

<?php
  $boxContent = '';
  $stree = array();

  $store_categories_query = smn_db_query("select c.store_categories_id, cd.store_categories_name, c.store_parent_id from " . TABLE_STORE_CATEGORIES . " c, " . TABLE_STORE_CATEGORIES_DESCRIPTION . " cd where c.store_parent_id = '0' and c.store_categories_id = cd.store_categories_id and cd.language_id='" . (int)$languages_id ."' order by sort_order, cd.store_categories_name");
  while ($store_categories = smn_db_fetch_array($store_categories_query))  {
    $stree[$store_categories['store_categories_id']] = array('name' => $store_categories['store_categories_name'],
                                                'parent' => $store_categories['store_parent_id'],
                                                'level' => 0,
                                                'path' => $store_categories['store_categories_id'],
                                                'next_id' => false);

    if (isset($store_parent_id)) {
      $stree[$store_parent_id]['next_id'] = $store_categories['store_categories_id'];
    }

    $store_parent_id = $store_categories['store_categories_id'];

    if (!isset($store_first_element)) {
      $store_first_element = $store_categories['store_categories_id'];
    }
  }

  //------------------------
  if (smn_not_null($sPath)) {
    $new_path = '';
    reset($sPath_array);
    while (list($key, $value) = each($sPath_array)) {
      unset($store_parent_id);
      unset($first_id);
      $store_categories_query = smn_db_query("select c.store_categories_id, cd.store_categories_name, c.store_parent_id from " . TABLE_STORE_CATEGORIES . " c, " . TABLE_STORE_CATEGORIES_DESCRIPTION . " cd where c.store_parent_id = '" . (int)$value . "' and c.store_categories_id = cd.store_categories_id and cd.language_id='" . (int)$languages_id ."' order by sort_order, cd.store_categories_name");
      if (smn_db_num_rows($store_categories_query)) {
        $new_path .= $value;
        while ($row = smn_db_fetch_array($store_categories_query)) {
          $stree[$row['store_categories_id']] = array('name' => $row['store_categories_name'],
                                               'parent' => $row['store_parent_id'],
                                               'level' => $key+1,
                                               'path' => $new_path . '_' . $row['store_categories_id'],
                                               'next_id' => false);

          if (isset($store_parent_id)) {
            $stree[$store_parent_id]['next_id'] = $row['store_categories_id'];
          }

          $store_parent_id = $row['store_categories_id'];

          if (!isset($first_id)) {
            $first_id = $row['store_categories_id'];
          }

          $last_id = $row['store_categories_id'];
        }
        $stree[$last_id]['next_id'] = $stree[$value]['next_id'];
        $stree[$value]['next_id'] = $first_id;
        $new_path .= '_';
      } else {
        break;
      }
    }
  }
  smn_show_store_category($store_first_element); 
  
  if(file_exists(DIR_WS_BOX_TEMPLATES . $box_base_name . '.php')) {
      require(DIR_WS_BOX_TEMPLATES . $box_base_name . '.php');
  }else {
      require(TEMPLATENAME_BOX);
  }
?>
<!-- store_categories_eof //-->
