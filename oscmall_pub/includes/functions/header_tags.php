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

  WebMakers.com Added: Header Tags Generator v2.3
*/
function smn_get_header_tag_products_title($product_id) {
  global $languages_id, $_GET; 

  $product_header_tags = smn_db_query("select products_head_title_tag from " . TABLE_PRODUCTS_DESCRIPTION . " where language_id = '" . (int)$languages_id . "' and products_id = '" . (int)$_GET['products_id'] . "'");
  $product_header_tags_values = smn_db_fetch_array($product_header_tags);

  return clean_html_comments($product_header_tags_values['products_head_title_tag']);
  }


////
// Get products_head_keywords_tag
// TABLES: products_description
function smn_get_header_tag_products_keywords($product_id) {
  global $languages_id, $_GET; 

  $product_header_tags = smn_db_query("select products_head_keywords_tag from " . TABLE_PRODUCTS_DESCRIPTION . " where language_id = '" . (int)$languages_id . "' and products_id = '" . (int)$_GET['products_id'] . "'");
  $product_header_tags_values = smn_db_fetch_array($product_header_tags);

  return $product_header_tags_values['products_head_keywords_tag'];
  }


////
// Get products_head_desc_tag
// TABLES: products_description
function smn_get_header_tag_products_desc($product_id) {
  global $languages_id, $_GET; 

  $product_header_tags = smn_db_query("select products_head_desc_tag from " . TABLE_PRODUCTS_DESCRIPTION . " where language_id = '" . (int)$languages_id . "' and products_id = '" . (int)$_GET['products_id'] . "'");
  $product_header_tags_values = smn_db_fetch_array($product_header_tags);

  return $product_header_tags_values['products_head_desc_tag'];
  }

?>
