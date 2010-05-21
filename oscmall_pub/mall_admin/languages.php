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

  function smn_language_list() {  
    $left = false;
    $smn_language_list_array[] = array('id' => '',
                                       'text' => TEXT_NONE);
    
    $language_query = smn_db_query("select name from " . TABLE_LANGUAGES . " order by sort_order");
      while ($languages = smn_db_fetch_array($language_query)) {
        $language_array[] = $languages['name'];
      }
      
    if ($dir = dir(DIR_FS_CATALOG_LANGUAGES . 'install')) {
      while ($file = $dir->read()) {
          if ( ($file != '.' ) && ($file != '..' ) && (!is_dir($file)) ){
            $list_file = explode('_', $file);
            if(!in_array($list_file[0], $language_array)){
              $smn_language_list_array[] = array('id' => $list_file[0],
                                                 'text' => $list_file[0]);
            }
          }
        }
      }
      $dir->close();
      return $smn_language_list_array;
    }  

  $action = (isset($_GET['action']) ? $_GET['action'] : '');

  if (smn_not_null($action)) {
    switch ($action) {
      case 'insert':
        
        $new_language = smn_db_prepare_input($_POST['new_language_id']);
        require(DIR_FS_CATALOG_LANGUAGES . 'install/' . $new_language . '_install.php');
        $language_array = explode(',', smn_language_info ());
        $name = smn_db_prepare_input($language_array[0]);
        $code = smn_db_prepare_input($language_array[1]);
        $image = smn_db_prepare_input($language_array[2]);
        $directory = smn_db_prepare_input($language_array[3]);
        $sort_order_query = smn_db_query("select MAX(sort_order) from " . TABLE_LANGUAGES);
        $sort_order  = smn_db_fetch_array($sort_order_query);
        $sort_order = ((int)$sort_order['sort_order'] + 1);
        smn_db_query("insert into " . TABLE_LANGUAGES . " (store_id, name, code, image, directory, sort_order) values ('" . smn_db_input($store_id) . "', '" . smn_db_input($name) . "', '" . smn_db_input($code) . "', '" . smn_db_input($image) . "', '" . smn_db_input($directory) . "', '" . smn_db_input($sort_order) . "')");
        $insert_id = smn_db_insert_id();

        if (ALLOW_STORE_SITE_TEXT == 'true'){
          $prefix = $store_id;
        }else{
          $prefix = 1;
        }
        smn_install_language ($insert_id, $prefix);

// create additional categories_description records
        $categories_query = smn_db_query("select c.categories_id, cd.categories_name from " . TABLE_CATEGORIES . " c left join " . TABLE_CATEGORIES_DESCRIPTION . " cd on c.categories_id = cd.categories_id where cd.language_id = '" . (int)$languages_id . "' and c.store_id = '". $store_id ."' and cd.store_id = '". $store_id ."'");
        while ($categories = smn_db_fetch_array($categories_query)) {
          smn_db_query("insert into " . TABLE_CATEGORIES_DESCRIPTION . " (store_id, categories_id, language_id, categories_name) values ('" . $store_id . "', '" . (int)$categories['categories_id'] . "', '" . (int)$insert_id . "', '" . smn_db_input($categories['categories_name']) . "')");
        }

// create additional products_description records
        $products_query = smn_db_query("select p.products_id, pd.products_name, pd.products_description, pd.products_url from " . TABLE_PRODUCTS . " p left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id where pd.language_id = '" . (int)$languages_id . "' and p.store_id = '". $store_id ."'");
        while ($products = smn_db_fetch_array($products_query)) {
          smn_db_query("insert into " . TABLE_PRODUCTS_DESCRIPTION . " (products_id, language_id, products_name, products_description, products_url) values ('" . (int)$products['products_id'] . "', '" . (int)$insert_id . "', '" . smn_db_input($products['products_name']) . "', '" . smn_db_input($products['products_description']) . "', '" . smn_db_input($products['products_url']) . "')");
        }

// create additional products_options records
        $products_options_query = smn_db_query("select products_options_id, products_options_name from " . TABLE_PRODUCTS_OPTIONS . " where language_id = '" . (int)$languages_id . "'");
        while ($products_options = smn_db_fetch_array($products_options_query)) {
          smn_db_query("insert into " . TABLE_PRODUCTS_OPTIONS . " (store_id, products_options_id, language_id, products_options_name) values ('". (int)$store_id ."', '" . (int)$products_options['products_options_id'] . "', '" . (int)$insert_id . "', '" . smn_db_input($products_options['products_options_name']) . "')");
        }

// create additional products_options_values records
        $products_options_values_query = smn_db_query("select products_options_values_id, products_options_values_name from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where language_id = '" . (int)$languages_id . "' and store_id = '". $store_id ."'");
        while ($products_options_values = smn_db_fetch_array($products_options_values_query)) {
          smn_db_query("insert into " . TABLE_PRODUCTS_OPTIONS_VALUES . " (store_id, products_options_values_id, language_id, products_options_values_name) values ('". (int)$store_id ."', '" . (int)$products_options_values['products_options_values_id'] . "', '" . (int)$insert_id . "', '" . smn_db_input($products_options_values['products_options_values_name']) . "')");
        }

// create additional manufacturers_info records
        $manufacturers_query = smn_db_query("select m.manufacturers_id, mi.manufacturers_url from " . TABLE_MANUFACTURERS . " m left join " . TABLE_MANUFACTURERS_INFO . " mi on m.manufacturers_id = mi.manufacturers_id where mi.languages_id = '" . (int)$languages_id . "'");
        while ($manufacturers = smn_db_fetch_array($manufacturers_query)) {
          smn_db_query("insert into " . TABLE_MANUFACTURERS_INFO . " (manufacturers_id, languages_id, manufacturers_url) values ('" . $manufacturers['manufacturers_id'] . "', '" . (int)$insert_id . "', '" . smn_db_input($manufacturers['manufacturers_url']) . "')");
        }

// create additional orders_status records
        $orders_status_query = smn_db_query("select orders_status_id, orders_status_name from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "'");
        while ($orders_status = smn_db_fetch_array($orders_status_query)) {
          smn_db_query("insert into " . TABLE_ORDERS_STATUS . " (orders_status_id, language_id, orders_status_name) values ('" . (int)$orders_status['orders_status_id'] . "', '" . (int)$insert_id . "', '" . smn_db_input($orders_status['orders_status_name']) . "')");
        }
        if (isset($_POST['default']) && ($_POST['default'] == 'on')) {
          smn_db_query("update " . TABLE_CONFIGURATION . " set configuration_value = '" . smn_db_input($code) . "' where configuration_key = 'DEFAULT_LANGUAGE' and store_id = '" . $store_id . "'");
        }
        smn_redirect(smn_href_link(FILENAME_LANGUAGES, (isset($_GET['page']) ? 'page=' . $_GET['page'] . '&' : '') . 'lID=' . $insert_id));
        break;
      case 'save':
        $lID = smn_db_prepare_input($_GET['lID']);
        $name = smn_db_prepare_input($_POST['name']);
        $code = smn_db_prepare_input($_POST['code']);
        $image = smn_db_prepare_input($_POST['image']);
        $directory = smn_db_prepare_input($_POST['directory']);
        $sort_order = smn_db_prepare_input($_POST['sort_order']);
        smn_db_query("update " . TABLE_LANGUAGES . " set store_id = '" . (int)$store_id . "', name = '" . smn_db_input($name) . "', code = '" . smn_db_input($code) . "', image = '" . smn_db_input($image) . "', directory = '" . smn_db_input($directory) . "', sort_order = '" . smn_db_input($sort_order) . "' where languages_id = '" . (int)$lID . "'");
        if ($_POST['default'] == 'on') {
          smn_db_query("update " . TABLE_CONFIGURATION . " set configuration_value = '" . smn_db_input($code) . "' where configuration_key = 'DEFAULT_LANGUAGE' and store_id = '" . $store_id . "'");
        }
        smn_redirect(smn_href_link(FILENAME_LANGUAGES, 'page=' . $_GET['page'] . '&lID=' . $_GET['lID']));
        break;
      case 'deleteconfirm':
        $lID = smn_db_prepare_input($_GET['lID']);

        $lng_query = smn_db_query("select languages_id from " . TABLE_LANGUAGES . " where code = '" . DEFAULT_CURRENCY . "' and store_id = '" . $store_id . "'");
        $lng = smn_db_fetch_array($lng_query);
        if ($lng['languages_id'] == $lID) {
          smn_db_query("update " . TABLE_CONFIGURATION . " set configuration_value = '' where configuration_key = 'DEFAULT_CURRENCY' and store_id = '" . $store_id . "'");
        }

        smn_db_query("delete from " . TABLE_CATEGORIES_DESCRIPTION . " where language_id = '" . (int)$lID . "' and store_id = '". $store_id . "'");
        smn_db_query("delete from " . TABLE_PRODUCTS_DESCRIPTION . " where language_id = '" . (int)$lID . "'");
        smn_db_query("delete from " . TABLE_PRODUCTS_OPTIONS . " where language_id = '" . (int)$lID . "' and store_id = '". $store_id . "'");
        smn_db_query("delete from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where language_id = '" . (int)$lID . "' and store_id = '". $store_id . "'");
        smn_db_query("delete from " . TABLE_MANUFACTURERS_INFO . " where languages_id = '" . (int)$lID . "'");
       // smn_db_query("delete from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$lID . "'");
        smn_db_query("delete from " . TABLE_LANGUAGES . " where languages_id = '" . (int)$lID . "' and store_id = '". $store_id . "'");
        smn_db_query("delete from " . TABLE_WEB_SITE_CONTENT . " where store_id = '" . $store_id . "' and language_id = '" . (int)$lID . "'");

        smn_redirect(smn_href_link(FILENAME_LANGUAGES, 'page=' . $_GET['page']));
        break;
      case 'delete':
        $lID = smn_db_prepare_input($_GET['lID']);

        $lng_query = smn_db_query("select code from " . TABLE_LANGUAGES . " where languages_id = '" . (int)$lID . "' and store_id = '". $store_id . "'");
        $lng = smn_db_fetch_array($lng_query);

        $remove_language = true;
        if ($lng['code'] == DEFAULT_LANGUAGE) {
          $remove_language = false;
          $messageStack->add(ERROR_REMOVE_DEFAULT_LANGUAGE, 'error');
        }
        break;
    }
  }
  
  $content_page = basename($_SERVER['PHP_SELF']);
  
  require('templates/default/layout.php');

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
