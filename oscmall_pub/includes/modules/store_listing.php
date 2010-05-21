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

  $rows = 0;                                  
  while ($store_query = smn_db_fetch_array($store_info_query)){
     $rows++;
     $width = (int)(100 / MAX_DISPLAY_CATEGORIES_PER_ROW) . '%';
      
                if (( file_exists(DIR_FS_CATALOG . '/images/' .$store_query['store_id'] . '_images/' .$store_query['store_image'])) && ($store_query['store_image'] != '')){
               echo  '<td align="center" class="smallText" width="' . $width . '" valign="top"><a href="' .
                     smn_href_link(FILENAME_INDEX, 'ID=' . $store_query['store_id']) . '">' .
                     smn_image('images/' . $store_query['store_id'] .'_images/' . $store_query['store_image'], '', SUBCATEGORY_IMAGE_WIDTH, SUBCATEGORY_IMAGE_HEIGHT, 'onmouseover=\'toolTip("' . ($store_description == '' ? str_replace("'", "", stripslashes($store_query['store_description'])) : str_replace("'", "", stripslashes($store_query['store_name']))) . '",this)\'') . '<br>' .
                     stripslashes($store_query['store_name']) . '</a></td>' . "\n";
          }else{
               echo  '<td align="center" class="smallText" width="' . $width . '" valign="top"><a href="' .
                     smn_href_link(FILENAME_INDEX, 'ID=' . $store_query['store_id']) . '">' .
                     smn_image(DIR_WS_IMAGES . 'default/default_store_logo.gif', '', SUBCATEGORY_IMAGE_WIDTH, SUBCATEGORY_IMAGE_HEIGHT, 'onmouseover=\'toolTip("' . ($store_description == '' ? str_replace("'", "", stripslashes($store_query['store_description'])) : str_replace("'", "", stripslashes($store_query['store_name']))) . '",this)\'') . '<br>' .
                     stripslashes($store_query['store_name']) . '</a></td>' . "\n";
          }
      if ((($rows / MAX_DISPLAY_CATEGORIES_PER_ROW) == floor($rows / MAX_DISPLAY_CATEGORIES_PER_ROW)) && ($rows != $number_of_stores)) {
        echo '              </tr>' . "\n";
        echo '              <tr>' . "\n"; 
    } 
   }
?>