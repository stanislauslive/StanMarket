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
?>
<span id="toolTipBox" width="500"></span>
    <table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo smn_image(DIR_WS_IMAGES . 'table_background_listing.gif', HEADING_TITLE); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="main"><?php echo TEXT_STORE_LISTING_INFORMATION; ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>  

<?php 
 
  if ($store_category_depth == 'nested') {
    $store_category_query = smn_db_query("select cd.store_categories_name, c.store_categories_image from " . TABLE_STORE_CATEGORIES . " c, " . TABLE_STORE_CATEGORIES_DESCRIPTION . " cd where c.store_categories_id = '" . (int)$current_store_category_id . "' and cd.store_categories_id = '" . (int)$current_store_category_id . "' and cd.language_id = '" . (int)$languages_id . "'");
    $store_category = smn_db_fetch_array($store_category_query);
  }
  ?>
        <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="0"> 
<?php
 if ((isset($sPath)) && ($sPath != '')) { 
      if (strpos('_', $sPath))  { 
// check to see if there are deeper store_categories within the current store_category
      $store_category_links = array_reverse($sPath_array);
      for($i=0, $n=sizeof($store_category_links); $i<$n; $i++) {
        $store_categories_query = smn_db_query("select count(*) as total from " . TABLE_STORE_CATEGORIES . " c, " . TABLE_STORE_CATEGORIES_DESCRIPTION . " cd where c.store_parent_id = '" . (int)$store_category_links[$i] . "' and c.store_categories_id = cd.store_categories_id and cd.language_id = '" . (int)$languages_id . "'");
        $store_categories = smn_db_fetch_array($store_categories_query);
        if ($store_categories['total'] < 1) {
          // do nothing, go through the loop
        } else {
          $store_categories_query = smn_db_query("select c.store_categories_id, cd.store_categories_name, c.store_categories_image, c.store_parent_id from " . TABLE_STORE_CATEGORIES . " c, " . TABLE_STORE_CATEGORIES_DESCRIPTION . " cd where c.store_parent_id = '" . (int)$store_category_links[$i] . "' and c.store_categories_id = cd.store_categories_id and cd.language_id = '" . (int)$languages_id . "' order by sort_order, cd.store_categories_name");
          break; // we've found the deepest store_category the customer is in
        }
      }
    }
 }else {
      $store_categories_query = smn_db_query("select c.store_categories_id, cd.store_categories_name, c.store_categories_image, c.store_parent_id from " . TABLE_STORE_CATEGORIES . " c, " . TABLE_STORE_CATEGORIES_DESCRIPTION . " cd where c.store_parent_id = '" . (int)$current_store_category_id . "' and c.store_categories_id = cd.store_categories_id and cd.language_id = '" . (int)$languages_id . "' order by sort_order, cd.store_categories_name");
    }
    $number_of_store_categories = smn_db_num_rows($store_categories_query);

    $rows = 0;
    while ($store_categories = smn_db_fetch_array($store_categories_query)) {
      $rows++;
      $sPath_new = smn_get_spath($store_categories['store_categories_id']);
      $width = (int)(100 / MAX_DISPLAY_CATEGORIES_PER_ROW) . '%';
 
      echo '      <td align="center" class="smallText" width="' . $width . '" valign="top"><a href="' . smn_href_link(FILENAME_STORE_LISTING, $sPath_new) . '">' . smn_image('images/' . $store_categories['store_categories_image'], $store_categories['store_categories_name'], SUBCATEGORY_IMAGE_WIDTH, SUBCATEGORY_IMAGE_HEIGHT) . '<br>' . $store_categories['store_categories_name'] . '</a></td>' . "\n";
    
      
      if ((($rows / MAX_DISPLAY_CATEGORIES_PER_ROW) == floor($rows / MAX_DISPLAY_CATEGORIES_PER_ROW)) && ($rows != $number_of_store_categories)) {
        echo '              </tr></table></tr>' . "\n";
        echo '     <tr>';
        echo '        <td>' . smn_draw_separator('pixel_trans.gif', '100%', '20'). '</td>';
        echo '     </tr>'; 
        echo '              <tr><table valign="top" border="0" width="100%" cellspacing="0" cellpadding="0"><tr>' . "\n";
      }
    }
    ?>
      </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
         <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
<?php

$store_info_query  = smn_db_query("select sd.store_description, sd.store_name, sd.store_id from " . TABLE_STORE_MAIN . " s, " . TABLE_STORE_DESCRIPTION . " sd, "  . TABLE_STORE_TO_CATEGORIES . " s2c where s.store_id = sd.store_id and s.store_status = '1' and s.store_id = s2c.store_id and s2c.store_categories_id = '" . (int)$current_store_category_id . "'");   
$number_of_stores = smn_db_num_rows($store_info_query);
 if ($number_of_stores > 0)
{
      $image = smn_db_query("select store_categories_image from " . TABLE_STORE_CATEGORIES . " where store_categories_id = '" . (int)$current_store_category_id . "'");
      $image = smn_db_fetch_array($image);
      $image = $image['store_categories_image'];
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td class="pageHeading"><?php echo CATAGORY_HEADING_TITLE; ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="0"><tr>  
<?php
$store_info_query  = smn_db_query("select s.store_id, s.store_image, sd.store_description, sd.store_name from
                                  " . TABLE_STORE_MAIN . " s,
                                  " . TABLE_STORE_DESCRIPTION . " sd,
                                  "  . TABLE_STORE_TO_CATEGORIES . " s2c where
                                  s.store_id = sd.store_id
                                  and s.store_id = s2c.store_id
                                  and s.store_status = '1'
                                  and s2c.store_categories_id = '" . (int)$current_store_category_id . "'");
  $rows = 0;                                  
  while ($store_query = smn_db_fetch_array($store_info_query)){
    include(DIR_WS_MODULES . FILENAME_STORE_LISTING); 
   }
?>
      </table></td>
          </tr>
        </table></td>
      </tr>  
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
<?php        
}else{
?>
          <tr>
            <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td class="main"><?php echo TEXT_NO_STORE_LISTING_INFORMATION; ?></td>
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '1', '1'); ?></td>
             </tr>
            </table>
            </td>
          </tr>
        </table></td>
      </tr>
      <?php
 }
?>
    </table>		
