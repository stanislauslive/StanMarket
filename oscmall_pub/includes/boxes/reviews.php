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

  $boxHeading = BOX_HEADING_REVIEWS;
  $boxLink = '<a href="' . smn_href_link(FILENAME_REVIEWS) . '"><img src="images/infobox/arrow_right.gif" border="0" alt="more" title=" more " width="12" height="10"></a>';
  $box_base_name = 'reviews';
  $box_id = $box_base_name . 'Box'; 
  $random_select = "select r.store_id, r.reviews_id, r.reviews_rating, p.products_id, p.store_id, p.products_image, pd.products_name from " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd, " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.store_id = '" . $store_id . "' and p.products_status = '1' and p.products_id = r.products_id and r.reviews_id = rd.reviews_id and rd.languages_id = '" . (int)$languages_id . "' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "'";
  if (isset($_GET['products_id'])) {
    $random_select .= " and p.products_id = '" . (int)$_GET['products_id'] . "'";
  }
  $random_select .= " order by r.reviews_id desc limit " . MAX_RANDOM_SELECT_REVIEWS;
  $random_product = smn_random_select($random_select);
  $store_images = 'images/'. $random_product['store_id'] . '_images/';
  if ($random_product) {
// display random review box
    $review_query = smn_db_query("select substring(reviews_text, 1, 60) as reviews_text from " . TABLE_REVIEWS_DESCRIPTION . " where reviews_id = '" . (int)$random_product['reviews_id'] . "' and languages_id = '" . (int)$languages_id . "'");
    $reviews_text = smn_db_fetch_array($review_query);
    $reviews_text = smn_break_string(smn_output_string_protected($reviews_text['reviews_text']), 15, '-<br>');
    $boxContent = '<div align="center"><a href="' . smn_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'ID=' . $random_product['store_id'] . '&products_id=' . $random_product['products_id'] . '&reviews_id=' . $random_product['reviews_id']) . '">' . smn_image($store_images . $random_product['products_image'], $random_product['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a></div><a href="' . smn_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'ID=' . $random_product['store_id'] . '&products_id=' . $random_product['products_id'] . '&reviews_id=' . $random_product['reviews_id']) . '">' . $reviews_text . ' ..</a><br><div align="center">' . smn_image(DIR_WS_IMAGES . 'store_images/' . 'stars_' . $random_product['reviews_rating'] . '.gif' , sprintf(BOX_REVIEWS_TEXT_OF_5_STARS, $random_product['reviews_rating'])) . '</div>';
  } elseif (isset($_GET['products_id'])) {
// display 'write a review' box
    $boxContent = '<table border="0" cellspacing="0" cellpadding="2"><tr><td class="infoBoxContents"><a href="' . smn_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, 'products_id=' . $_GET['products_id']) . '">' . smn_image(DIR_WS_IMAGES . 'box_write_review.gif', IMAGE_BUTTON_WRITE_REVIEW) . '</a></td><td class="infoBoxContents"><a href="' . smn_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, 'products_id=' . $_GET['products_id']) . '">' . BOX_REVIEWS_WRITE_REVIEW .'</a></td></tr></table>';
  } else {
// display 'no reviews' box
    $boxContent = BOX_REVIEWS_NO_REVIEWS;
  }

  if(file_exists(DIR_WS_BOX_TEMPLATES . $box_base_name . '.php')){
      require(DIR_WS_BOX_TEMPLATES . $box_base_name . '.php');
  }else {
      require(DEFAULT_TEMPLATENAME_BOX);
  }
  $boxContent_attributes = '';
  $boxLink = '';
?>
