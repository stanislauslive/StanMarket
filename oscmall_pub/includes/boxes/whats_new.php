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
  if ($random_product = smn_random_select("select store_id, products_id, products_image, products_tax_class_id, products_price from " . TABLE_PRODUCTS . " where store_id = '". $store_id ."' and products_status = '1' order by products_date_added desc limit " . MAX_RANDOM_SELECT_NEW)) {

    $boxHeading = BOX_HEADING_WHATS_NEW;
    $corner_left = 'square';
    $corner_right = 'square';
    $boxContent_attributes = ' align="center"';
    $boxLink = '<a href="' . smn_href_link(FILENAME_PRODUCTS_NEW) . '"><img src="images/infobox/arrow_right.gif" border="0" alt="more" title=" more " width="12" height="10"></a>';
    $box_base_name = 'whats_new';
    $box_id = $box_base_name . 'Box';
    $random_product['products_name'] = smn_get_products_name($random_product['products_id']);
    $random_product['specials_new_products_price'] = smn_get_products_special_price($random_product['products_id']);
    $store_images = 'images/'. $random_product['store_id'] . '_images/';

    if (smn_not_null($random_product['specials_new_products_price'])) {
      $whats_new_price = '<s>' . $currencies->display_price($random_product['products_price'], smn_get_tax_rate($random_product['products_tax_class_id'])) . '</s><br>';
      $whats_new_price .= '<span class="productSpecialPrice">' . $currencies->display_price($random_product['specials_new_products_price'], smn_get_tax_rate($random_product['products_tax_class_id'])) . '</span>';
    } else {
      $whats_new_price = $currencies->display_price($random_product['products_price'], smn_get_tax_rate($random_product['products_tax_class_id']));
    }

    $boxContent = '<a href="' . smn_href_link(FILENAME_PRODUCT_INFO, 'ID=' . $random_product['store_id'] . '&products_id=' . $random_product['products_id']) . '">' . smn_image($store_images . $random_product['products_image'], $random_product['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a><br><a href="' . smn_href_link(FILENAME_PRODUCT_INFO, 'ID=' . $random_product['store_id'] . '&products_id=' . $random_product['products_id']) . '">' . $random_product['products_name'] . '</a><br>' . $whats_new_price;

  if(file_exists(DIR_WS_BOX_TEMPLATES . $box_base_name . '.php')){
      require(DIR_WS_BOX_TEMPLATES . $box_base_name . '.php');
  }else {
      require(DEFAULT_TEMPLATENAME_BOX);
  }
  $boxContent_attributes = '';

    $boxLink = '';
    $boxContent_attributes = '';

  }
?>
