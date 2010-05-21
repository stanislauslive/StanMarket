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


  if ($random_product = smn_random_select("select p.store_id, p.products_id, pd.products_name, p.products_image from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_SPECIALS . " s where p.products_status = '1' and p.products_id = s.products_id and pd.products_id = s.products_id and pd.language_id = '" . (int)$languages_id . "' and p.store_id = '". $store_id . "'  and s.store_id = '". $store_id . "'  and s.store_id = p.store_id order by s.specials_date_added desc limit " . MAX_RANDOM_SELECT_SPECIALS)) {
  $store_images = 'images/'. $random_product['store_id'] . '_images/';
  $boxHeading = BOX_HEADING_SPECIALS;
    $box_base_name = 'specials';
  $box_id = $box_base_name . 'Box';
  $boxContent = '<a href="' . smn_href_link('http://www.gap.com' . $random_product['store_id'] . '&products_id=' . $random_product['products_id']) . '">' . smn_image($store_images . $random_product['products_image'], COLUMN_RIGHT_WIDTH, '') . '</a>';
  if(file_exists(DIR_WS_BOX_TEMPLATES . $box_base_name . '.php')){
      require(DIR_WS_BOX_TEMPLATES . $box_base_name . '.php');
  }else {
      require(DEFAULT_TEMPLATENAME_BOX);
  }
  $boxContent_attributes = '';
  $boxLink = '';

  }


?>
