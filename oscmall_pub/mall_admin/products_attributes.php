<?php
/*
  Copyright (c) 2002 - 2005 SystemsManager.Net

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

  require('includes/application_top.php');
  $languages = smn_get_languages();

  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  $option_page = (isset($HTTP_GET_VARS['option_page']) && is_numeric($HTTP_GET_VARS['option_page'])) ? $HTTP_GET_VARS['option_page'] : 1; 
  $value_page = (isset($HTTP_GET_VARS['value_page']) && is_numeric($HTTP_GET_VARS['value_page'])) ? $HTTP_GET_VARS['value_page'] : 1; 
  $attribute_page = (isset($HTTP_GET_VARS['attribute_page']) && is_numeric($HTTP_GET_VARS['attribute_page'])) ? $HTTP_GET_VARS['attribute_page'] : 1; 
    
  $page_info = 'option_page=' . $option_page . '&value_page=' . $value_page . '&attribute_page=' . $attribute_page; 

  if (smn_not_null($action)) {
    switch ($action) {
      case 'add_product_options':
        $products_options_id = smn_db_prepare_input($_POST['products_options_id']);
        $option_name_array = $_POST['option_name'];

        for ($i=0, $n=sizeof($languages); $i<$n; $i ++) {
          $option_name = smn_db_prepare_input($option_name_array[$languages[$i]['id']]);

          smn_db_query("insert into " . TABLE_PRODUCTS_OPTIONS . " (store_id, products_options_id, products_options_name, language_id) values ('" . (int)$store_id . "', '" . (int)$products_options_id . "', '" . smn_db_input($option_name) . "', '" . (int)$languages[$i]['id'] . "')");
        }
        smn_redirect(smn_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info));
        break;
      case 'add_product_option_values':
        $value_name_array = $_POST['value_name'];
        $value_id = smn_db_prepare_input($_POST['value_id']);
        $option_id = smn_db_prepare_input($_POST['option_id']);

        for ($i=0, $n=sizeof($languages); $i<$n; $i ++) {
          $value_name = smn_db_prepare_input($value_name_array[$languages[$i]['id']]);

          smn_db_query("insert into " . TABLE_PRODUCTS_OPTIONS_VALUES . " (store_id, products_options_values_id, language_id, products_options_values_name) values ('" . (int)$store_id . "', '" . (int)$value_id . "', '" . (int)$languages[$i]['id'] . "', '" . smn_db_input($value_name) . "')");
        }

        smn_db_query("insert into " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " (store_id, products_options_id, products_options_values_id) values ('" . (int)$store_id . "', '" . (int)$option_id . "', '" . (int)$value_id . "')");

        smn_redirect(smn_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info));
        break;
      case 'add_product_attributes':
        $products_id = smn_db_prepare_input($_POST['products_id']);
        $options_id = smn_db_prepare_input($_POST['options_id']);
        $values_id = smn_db_prepare_input($_POST['values_id']);
        $value_price = smn_db_prepare_input($_POST['value_price']);
        $price_prefix = smn_db_prepare_input($_POST['price_prefix']);
        $sort_order = smn_db_prepare_input($_POST['sort_order']);

        smn_db_query("insert into " . TABLE_PRODUCTS_ATTRIBUTES . " values ('" . (int)$store_id . "', null, '" . (int)$products_id . "', '" . (int)$options_id . "', '" . (int)$values_id . "', '" . (float)smn_db_input($value_price) . "', '" . smn_db_input($price_prefix) . "', '" . (int)$sort_order . "')");

        if (DOWNLOAD_ENABLED == 'true') {
          $products_attributes_id = smn_db_insert_id();

          $products_attributes_filename = smn_db_prepare_input($_POST['products_attributes_filename']);
          $products_attributes_maxdays = smn_db_prepare_input($_POST['products_attributes_maxdays']);
          $products_attributes_maxcount = smn_db_prepare_input($_POST['products_attributes_maxcount']);

          if (smn_not_null($products_attributes_filename)) {
            smn_db_query("insert into " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " values ('" . (int)$store_id . "', " . (int)$products_attributes_id . ", '" . smn_db_input($products_attributes_filename) . "', '" . smn_db_input($products_attributes_maxdays) . "', '" . smn_db_input($products_attributes_maxcount) . "')");
          }
        }

        smn_redirect(smn_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info));
        break;
      case 'update_option_name':
        $option_name_array = $_POST['option_name'];
        $option_id = smn_db_prepare_input($_POST['option_id']);

        for ($i=0, $n=sizeof($languages); $i<$n; $i ++) {
          $option_name = smn_db_prepare_input($option_name_array[$languages[$i]['id']]);

          smn_db_query("update " . TABLE_PRODUCTS_OPTIONS . " set products_options_name = '" . smn_db_input($option_name) . "' where products_options_id = '" . (int)$option_id . "' and language_id = '" . (int)$languages[$i]['id'] . "' and store_id = '" . $store_id . "'");
        }

        smn_redirect(smn_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info));
        break;
      case 'update_value':
        $value_name_array = $_POST['value_name'];
        $value_id = smn_db_prepare_input($_POST['value_id']);
        $option_id = smn_db_prepare_input($_POST['option_id']);
        $sort_order = smn_db_prepare_input($_POST['sort_order']);

        for ($i=0, $n=sizeof($languages); $i<$n; $i ++) {
          $value_name = smn_db_prepare_input($value_name_array[$languages[$i]['id']]);

          smn_db_query("update " . TABLE_PRODUCTS_OPTIONS_VALUES . " set products_options_values_name = '" . smn_db_input($value_name) . "' where products_options_values_id = '" . smn_db_input($value_id) . "' and language_id = '" . (int)$languages[$i]['id'] . "' and store_id = '" . $store_id . "'");
        }

        smn_db_query("update " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " set products_options_id = '" . (int)$option_id . "'  where products_options_values_id = '" . (int)$value_id . "' and store_id = '" . $store_id . "'");

        smn_redirect(smn_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info));
        break;
      case 'update_product_attribute':
        $products_id = smn_db_prepare_input($_POST['products_id']);
        $options_id = smn_db_prepare_input($_POST['options_id']);
        $values_id = smn_db_prepare_input($_POST['values_id']);
        $value_price = smn_db_prepare_input($_POST['value_price']);
        $price_prefix = smn_db_prepare_input($_POST['price_prefix']);
        $attribute_id = smn_db_prepare_input($_POST['attribute_id']);
        $sort_order = smn_db_prepare_input($_POST['sort_order']);

        smn_db_query("update " . TABLE_PRODUCTS_ATTRIBUTES . " set products_id = '" . (int)$products_id . "', options_id = '" . (int)$options_id . "', options_values_id = '" . (int)$values_id . "', options_values_price = '" . (float)smn_db_input($value_price) . "', price_prefix = '" . smn_db_input($price_prefix) . "', sort_order = '" . (int)$sort_order . "' where products_attributes_id = '" . (int)$attribute_id . "' and store_id = '" . $store_id . "'");

        if (DOWNLOAD_ENABLED == 'true') {
          $products_attributes_filename = smn_db_prepare_input($_POST['products_attributes_filename']);
          $products_attributes_maxdays = smn_db_prepare_input($_POST['products_attributes_maxdays']);
          $products_attributes_maxcount = smn_db_prepare_input($_POST['products_attributes_maxcount']);

          if (smn_not_null($products_attributes_filename)) {
            smn_db_query("replace into " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " set products_attributes_id = '" . (int)$attribute_id . "', products_attributes_filename = '" . smn_db_input($products_attributes_filename) . "', products_attributes_maxdays = '" . smn_db_input($products_attributes_maxdays) . "', products_attributes_maxcount = '" . smn_db_input($products_attributes_maxcount) . "', store_id = '" . $store_id . "'");
          }
        }

        smn_redirect(smn_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info));
        break;
      case 'delete_option':
        $option_id = smn_db_prepare_input($_GET['option_id']);

        smn_db_query("delete from " . TABLE_PRODUCTS_OPTIONS . " where products_options_id = '" . (int)$option_id . "' and store_id = '" . $store_id . "'");

        smn_redirect(smn_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info));
        break;
      case 'delete_value':
        $value_id = smn_db_prepare_input($_GET['value_id']);

        smn_db_query("delete from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where products_options_values_id = '" . (int)$value_id . "' and store_id = '" . $store_id . "'");
        smn_db_query("delete from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where products_options_values_id = '" . (int)$value_id . "' and store_id = '" . $store_id . "'");
        smn_db_query("delete from " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " where products_options_values_id = '" . (int)$value_id . "' and store_id = '" . $store_id . "'");

        smn_redirect(smn_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info));
        break;
      case 'delete_attribute':
        $attribute_id = smn_db_prepare_input($_GET['attribute_id']);

        smn_db_query("delete from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_attributes_id = '" . (int)$attribute_id . "' and store_id = '" . $store_id . "'");

// added for DOWNLOAD_ENABLED. Always try to remove attributes, even if downloads are no longer enabled
        smn_db_query("delete from " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " where products_attributes_id = '" . (int)$attribute_id . "' and store_id = '" . $store_id . "'");

        smn_redirect(smn_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info));
        break;
    }
  }
  
  $content_page = basename($_SERVER['PHP_SELF']);
  
  require('templates/default/layout.php');

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>