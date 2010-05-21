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


    if ((isset($sPath)) && ($sPath != '')){
        
        if (strpos('_', $sPath)){
           echo $sPath . 'test'; 
// check to see if there are deeper store_categories within the current category
      $store_category_links = array_reverse($sPath_array);
      for($i=0, $n=sizeof($store_category_links); $i<$n; $i++) {
        $store_categories_query = smn_db_query("select count(*) as total from " . TABLE_STORE_CATEGORIES . " c, " . TABLE_STORE_CATEGORIES_DESCRIPTION . " cd where c.store_parent_id = '" . (int)$store_category_links[$i] . "' and c.store_categories_id = cd.store_categories_id and cd.language_id = '" . (int)$languages_id . "'");
        $store_categories = smn_db_fetch_array($store_categories_query);
        if ($store_categories['total'] < 1) {
          // do nothing, go through the loop
        } else {
          $store_categories_query = smn_db_query("select c.store_categories_id, cd.store_categories_name, c.store_categories_image, c.store_parent_id from " . TABLE_STORE_CATEGORIES . " c, " . TABLE_STORE_CATEGORIES_DESCRIPTION . " cd where c.store_parent_id = '" . (int)$store_category_links[$i] . "' and c.store_categories_id = cd.store_categories_id and cd.language_id = '" . (int)$languages_id . "' order by sort_order, cd.store_categories_name");
          break; // we've found the deepest category the customer is in
        }
      }
    }else {
      $store_categories_query = smn_db_query("select c.store_categories_id, cd.store_categories_description, cd.store_categories_name, c.store_categories_image, c.store_parent_id from " . TABLE_STORE_CATEGORIES . " c, " . TABLE_STORE_CATEGORIES_DESCRIPTION . " cd where c.store_categories_id = cd.store_categories_id and cd.language_id = '" . (int)$languages_id . "' order by sort_order, cd.store_categories_name");
    }
    }else {
      $store_categories_query = smn_db_query("select c.store_categories_id, cd.store_categories_description, cd.store_categories_name, c.store_categories_image, c.store_parent_id from " . TABLE_STORE_CATEGORIES . " c, " . TABLE_STORE_CATEGORIES_DESCRIPTION . " cd where c.store_parent_id = '" . (int)$current_store_category_id . "' and c.store_categories_id = cd.store_categories_id and cd.language_id = '" . (int)$languages_id . "' order by sort_order, cd.store_categories_name");
    }
    $number_of_store_categories = smn_db_num_rows($store_categories_query);
    $rows = 0;



    while ($store_categories = smn_db_fetch_array($store_categories_query)) {
      $rows++;
      $sPath_new = smn_get_spath($store_categories['store_categories_id']);
      $width = (int)(100 / MAX_DISPLAY_CATEGORIES_PER_ROW) . '%';
      echo '                <td align="center" class="smallText" width="' . $width . '" valign="top"><a href="' . smn_href_link(FILENAME_DEFAULT, $sPath_new) . '">' . smn_image(DIR_WS_IMAGES . $store_categories['store_categories_image'], '' /*$store_categories['store_categories_name']*/, SUBCATEGORY_IMAGE_WIDTH, SUBCATEGORY_IMAGE_HEIGHT, 'onmouseover=\'toolTip("' . ($store_categories['store_categories_description']=='' ? $store_categories['store_categories_name'] : $store_categories['store_categories_description']) . '",this)\'') . '<br>' . $store_categories['store_categories_name'] . '</a></td>' . "\n";
      if ((($rows / MAX_DISPLAY_CATEGORIES_PER_ROW) == floor($rows / MAX_DISPLAY_CATEGORIES_PER_ROW)) && ($rows != $number_of_store_categories)) {
        echo '              </tr>' . "\n";
        echo '              <tr>' . "\n";
      }
    }
?>

