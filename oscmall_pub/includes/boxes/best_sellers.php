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

  if (isset($current_category_id) && ($current_category_id > 0)) {
    $best_sellers_query = smn_db_query("select p.products_id, p.store_id, pd.products_name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c where p.products_status = '1' and p.products_ordered > 0 and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' and p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and '" . (int)$current_category_id . "' in (c.categories_id, c.parent_id) order by p.products_ordered desc, pd.products_name limit " . MAX_DISPLAY_BESTSELLERS);
  } else {
    $best_sellers_query = smn_db_query("select p.products_id, p.store_id, pd.products_name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_ordered > 0 and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' order by p.products_ordered desc, pd.products_name limit " . MAX_DISPLAY_BESTSELLERS);
  }

  if (smn_db_num_rows($best_sellers_query) >= MIN_DISPLAY_BESTSELLERS) {
  $boxHeading = BOX_HEADING_BESTSELLERS;
  $box_base_name = 'best_sellers';
  $box_id = $box_base_name . 'Box';

  $rows = 0;
  $boxContent = '<table border="0" width="100%" cellspacing="0" cellpadding="1">';
  while ($best_sellers = smn_db_fetch_array($best_sellers_query)) {
    $rows++;
    $boxContent .= '<tr><td class="infoBoxContents" valign="top">' . smn_row_number_format($rows) . '.</td><td class="infoBoxContents"><a href="' . smn_href_link(FILENAME_PRODUCT_INFO, 'ID=' . $best_sellers['store_id'] . '&products_id=' . $best_sellers['products_id']) . '">' . $best_sellers['products_name'] . '</a></td></tr>';
  }
  $boxContent .= '</table>';

  if(file_exists(DIR_WS_BOX_TEMPLATES . $box_base_name . '.php')){
      require(DIR_WS_BOX_TEMPLATES . $box_base_name . '.php');
  }else {
      require(DEFAULT_TEMPLATENAME_BOX);
  }
  $boxContent_attributes = '';
  }
?>
