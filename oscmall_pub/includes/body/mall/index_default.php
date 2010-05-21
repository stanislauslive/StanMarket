     <table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td>
	 <table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="main2"><?php echo $store->get_store_description();?></td>
          </tr>         
        </table></td>
      </tr>
    </table>
    <table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
<?php

    if ((isset($cPath)) && ($cPath != '')){
        if (strpos('_', $cPath)){
// check to see if there are deeper categories within the current category
      $category_links = array_reverse($cPath_array);
      for($i=0, $n=sizeof($category_links); $i<$n; $i++) {
        $categories_query = smn_db_query("select count(*) as total from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.store_id= '" . $store->get_store_id() . "' and c.parent_id = '" . (int)$category_links[$i] . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "'");
        $categories = smn_db_fetch_array($categories_query);
        if ($categories['total'] < 1) {
          // do nothing, go through the loop
        } else {
          $categories_query = smn_db_query("select c.categories_id, cd.categories_description, cd.categories_name, c.categories_image, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.store_id= '" . $store->get_store_id() . "' and c.parent_id = '" . (int)$category_links[$i] . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' order by sort_order, cd.categories_name");
          break; // we've found the deepest category the customer is in
        }
      }
    } 
    }else {
      $categories_query = smn_db_query("select c.categories_id, cd.categories_description, cd.categories_name, c.categories_image, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.store_id= '" . $store->get_store_id() . "' and c.parent_id = '" . (int)$current_category_id . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' order by sort_order, cd.categories_name");
    }
    
    $number_of_categories = smn_db_num_rows($categories_query);

    $rows = 0;
    while ($categories = smn_db_fetch_array($categories_query)) {
      $rows++;
      $cPath_new = smn_get_path($categories['categories_id']);
      $width = (int)(100 / MAX_DISPLAY_CATEGORIES_PER_ROW) . '%';
      echo '                <td align="center" class="smallText" width="' . $width . '" valign="top"><a href="' . smn_href_link(FILENAME_DEFAULT, $cPath_new) . '">' . smn_image(DIR_WS_IMAGES . $categories['categories_image'], '' /* $categories['categories_name'] */, SUBCATEGORY_IMAGE_WIDTH, SUBCATEGORY_IMAGE_HEIGHT, 'onmouseover=\'toolTip("' . ($categories['categories_description']=='' ? $categories['categories_name'] : $categories['categories_description']) . '",this)\'')  . '<br>' . $categories['categories_name'] . '</a></td>' . "\n";
      if ((($rows / MAX_DISPLAY_CATEGORIES_PER_ROW) == floor($rows / MAX_DISPLAY_CATEGORIES_PER_ROW)) && ($rows != $number_of_categories)) {
        echo '              </tr>' . "\n";
        echo '              <tr>' . "\n";
      }
    }
?>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
        </table></td>
      </tr>
    </table>


<span id="toolTipBox" width="200"></span>
    <table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
<?php

    if ((isset($sPath)) && ($sPath != '')){
        
        if (strpos('_', $sPath)){
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
      echo '                <td align="center" class="smallText" width="' . $width . '" valign="top"><a href="' . smn_href_link(FILENAME_STORE_LISTING, $sPath_new) . '">' . smn_image(DIR_WS_IMAGES . $store_categories['store_categories_image'], '' /*$store_categories['store_categories_name']*/, SUBCATEGORY_IMAGE_WIDTH, SUBCATEGORY_IMAGE_HEIGHT, 'onmouseover=\'toolTip("' . ($store_categories['store_categories_description']=='' ? $store_categories['store_categories_name'] : $store_categories['store_categories_description']) . '",this)\'') . '<br>' . $store_categories['store_categories_name'] . '</a></td>' . "\n";
      if ((($rows / MAX_DISPLAY_CATEGORIES_PER_ROW) == floor($rows / MAX_DISPLAY_CATEGORIES_PER_ROW)) && ($rows != $number_of_store_categories)) {
        echo '              </tr>' . "\n";
        echo '              <tr>' . "\n";
      }
    }
?>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
        </table></td>
      </tr>
    </table>