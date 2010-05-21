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
ob_start();
   global $page_name; 

  require(DIR_WS_CLASSES . 'upload.php');
  ?>
  <script language="javascript" type="text/javascript" src="mall_admin/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>

<!-- configure tinyMCE -->
<script language="javascript" type="text/javascript">
// Notice: The simple theme does not use all options some of them are limited to the advanced theme
tinyMCE.init({
mode : "exact",
theme : "simple",
elements : "products_description,categories_description"
});
</script>

 <?  
  if (!smn_session_is_registered('customer_id')) {
    //$navigation->set_snapshot();
    smn_redirect(smn_href_link(FILENAME_LOGIN, '', 'NONSSL'));
  }
  // regular store owners cannot add vouchers, which are signified
  // by the product model starting with 'GIFT'
  function checkVoucherPermissions($store_id, $model) {
    $canAddProduct = true;
    if (isset($model) && strpos($model, 'GIFT') === 0) {
      if ($store_id == 1) {
        $canAddProduct = true;
      } else {
        $canAddProduct = false;
      }
    }
    return $canAddProduct;
  }
       
  $currencies = new currencies();
  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  $check_groups_max_products_query = smn_db_query("select ag.admin_groups_max_products as max_products from " . TABLE_ADMIN_GROUPS . " ag, " . TABLE_ADMIN ." a where ag.admin_groups_id = a.admin_groups_id and a.store_id= '". $store_id ."'");
  $check_groups_max_products = smn_db_fetch_array($check_groups_max_products_query);
  $total_products_query = smn_db_query("select count(*) as total_products from " . TABLE_PRODUCTS . " where store_id ='" . $store_id . "'");
  $total_products = smn_db_fetch_array($total_products_query);
  $allow_insert = 'false';
  if($check_groups_max_products['max_products'] == 0){
    $allow_insert = 'true';
  }elseif($check_groups_max_products['max_products'] > $total_products['total_products']){
    $allow_insert = 'true';
  }
  if (smn_not_null($action)) {
    switch ($action) {
      case 'setflag':
        if ( ($_GET['flag'] == '0') || ($_GET['flag'] == '1') ) {
          if (isset($_GET['pID'])) {
            smn_set_product_status($_GET['pID'], $_GET['flag']);
          }

          if (USE_CACHE == 'true') {
            smn_reset_cache_block('categories');
            smn_reset_cache_block('also_purchased');
          }
        }
        smn_redirect(html_entity_decode(smn_href_link(FILENAME_STORE_PRODUCT_CATEGORIES, 'cPath=' . $_GET['cPath'] . '&ID='.$store_id.'&pID=' . $_GET['pID'])));
        break;
      case 'insert_category':
      case 'update_category':
        if (isset($_POST['categories_id'])) $categories_id = smn_db_prepare_input($_POST['categories_id']);
        $sort_order = smn_db_prepare_input($_POST['sort_order']);
        $sql_data_array = array('sort_order' => $sort_order);
        $htc_title = smn_db_prepare_input($_POST['htc_title']);
        $htc_title_data = array('category_head_title_tag' => $htc_title);
        $htc_desc = smn_db_prepare_input($_POST['htc_desc']);
        $htc_desc_data = array('category_head_desc_tag' => $htc_desc);
        $htc_keywords = smn_db_prepare_input($_POST['htc_keywords']);
        $htc_keywords_data = array('category_head_keywords_tag' => $htc_keywords);
        
        if ($action == 'insert_category') {
          $insert_sql_data = array('parent_id' => $current_category_id,
                                   'store_id' => $store_id,
                                   'date_added' => 'now()');
          $sql_data_array = array_merge($sql_data_array, $insert_sql_data);
          $sql_data_array = array_merge($sql_data_array, $htc_title_data);
          $sql_data_array = array_merge($sql_data_array, $htc_desc_data);
          $sql_data_array = array_merge($sql_data_array, $htc_keywords_data);
          smn_db_perform(TABLE_CATEGORIES, $sql_data_array);
          $categories_id = smn_db_insert_id();
        } elseif ($action == 'update_category') {
          $update_sql_data = array('last_modified' => 'now()');
          $sql_data_array = array_merge($sql_data_array, $update_sql_data);
          $sql_data_array = array_merge($sql_data_array, $htc_title_data);
          $sql_data_array = array_merge($sql_data_array, $htc_desc_data);
          $sql_data_array = array_merge($sql_data_array, $htc_keywords_data);
          smn_db_perform(TABLE_CATEGORIES, $sql_data_array, 'update', "categories_id = '" . (int)$categories_id . "' and store_id = '" .$store_id . "'");
        }
        $languages = smn_get_languages();
		
          $categories_name_array = $_POST['categories_name'];
          $categories_description_array = $_POST['categories_description'];
		  
//print_r($categories_description_array);
        for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
          $language_id = $languages[$i]['id'];
          $sql_data_array = array(	'categories_description' => $categories_description_array[$language_id],
		  							'categories_name' => smn_db_prepare_input($categories_name_array[$language_id]));
          if ($action == 'insert_category') {
            $insert_sql_data = array('categories_id' => $categories_id,
                                     'store_id' => $store_id,
                                     'language_id' => $languages[$i]['id']);
            $sql_data_array = array_merge($sql_data_array, $insert_sql_data);
            smn_db_perform(TABLE_CATEGORIES_DESCRIPTION, $sql_data_array);
          } elseif ($action == 'update_category') {
            smn_db_perform(TABLE_CATEGORIES_DESCRIPTION, $sql_data_array, 'update', "categories_id = '" . (int)$categories_id . "' and language_id = '" . (int)$languages[$i]['id'] . "' and store_id = '" .$store_id . "'");
          }
		  
//print_r($sql_data_array);		  
        }
//print_r($_FILES);        
		if (isset($_FILES['categories_image']) && is_array($_FILES['categories_image']) && $_FILES['categories_image']['size']>0){
        $categories_image = new upload('categories_image');
		$categories_image->set_destination(DIR_FS_CATALOG_IMAGES);
		if ($categories_image->parse() && $categories_image->save()) {
          $allowed_files_types = array('gif', 'jpg', 'jpeg', 'png');
  //       if ($categories_image->set_extensions($allowed_files_types)) {
            smn_db_query("update " . TABLE_CATEGORIES . " set categories_image = '" . smn_db_input($categories_image->filename) . "' where categories_id = '" . (int)$categories_id . "' and store_id = '" .$store_id . "'");
  //       }
        }
		}
        if (USE_CACHE == 'true') {
          smn_reset_cache_block('categories');
          smn_reset_cache_block('also_purchased');
        }
        smn_redirect(html_entity_decode(smn_href_link(FILENAME_STORE_PRODUCT_CATEGORIES, 'cPath=' . $cPath . '&ID='.$store_id)));
        break;
      case 'delete_category_confirm':
        if (isset($_POST['categories_id'])) {
          $categories_id = smn_db_prepare_input($_POST['categories_id']);
          $categories = smn_get_category_tree($categories_id, '', '0', '', true);
          $products = array();
          $products_delete = array();
          for ($i=0, $n=sizeof($categories); $i<$n; $i++) {
            $product_ids_query = smn_db_query("select products_id from " . TABLE_PRODUCTS_TO_CATEGORIES . " where categories_id = '" . (int)$categories[$i]['id'] . "' and store_id = '" .$store_id . "'");
            while ($product_ids = smn_db_fetch_array($product_ids_query)) {
              $products[$product_ids['products_id']]['categories'][] = $categories[$i]['id'];
            }
          }
          reset($products);
          while (list($key, $value) = each($products)) {
            $category_ids = '';
            for ($i=0, $n=sizeof($value['categories']); $i<$n; $i++) {
              $category_ids .= "'" . (int)$value['categories'][$i] . "', ";
            }
            $category_ids = substr($category_ids, 0, -2);
            $check_query = smn_db_query("select count(*) as total from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . (int)$key . "' and store_id = '" .$store_id . "' and categories_id not in (" . $category_ids . ")");
            $check = smn_db_fetch_array($check_query);
            if ($check['total'] < '1') {
              $products_delete[$key] = $key;
            }
          }
// removing categories can be a lengthy process
          smn_set_time_limit(0);
          for ($i=0, $n=sizeof($categories); $i<$n; $i++) {
            smn_remove_category($categories[$i]['id']);
          }
          reset($products_delete);
          while (list($key) = each($products_delete)) {
            smn_remove_product($key);
          }
        }
        if (USE_CACHE == 'true') {
          smn_reset_cache_block('categories');
          smn_reset_cache_block('also_purchased');
        }
        smn_redirect(html_entity_decode(smn_href_link(FILENAME_STORE_PRODUCT_CATEGORIES, 'cPath=' . $cPath.'&ID='.$store_id)));
        break;
      case 'delete_product_confirm':
        if (isset($_POST['products_id']) && isset($_POST['product_categories']) && is_array($_POST['product_categories'])) {
          $product_id = smn_db_prepare_input($_POST['products_id']);
          $product_categories = $_POST['product_categories'];
          for ($i=0, $n=sizeof($product_categories); $i<$n; $i++) {
            smn_db_query("delete from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . (int)$product_id . "' and categories_id = '" . (int)$product_categories[$i] . "' and store_id = '" .$store_id . "'");
          }
          $product_categories_query = smn_db_query("select count(*) as total from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . (int)$product_id . "' and store_id = '" .$store_id . "'");
          $product_categories = smn_db_fetch_array($product_categories_query);
          if ($product_categories['total'] == '0') {
            smn_remove_product($product_id);
          }
        }
        if (USE_CACHE == 'true') {
          smn_reset_cache_block('categories');
          smn_reset_cache_block('also_purchased');
        }
        smn_redirect(html_entity_decode(smn_href_link(FILENAME_STORE_PRODUCT_CATEGORIES, 'cPath=' . $cPath.'&ID='.$store_id)));
        break;
      case 'move_category_confirm':
        if (isset($_POST['categories_id']) && ($_POST['categories_id'] != $_POST['move_to_category_id'])) {
          $categories_id = smn_db_prepare_input($_POST['categories_id']);
          $new_parent_id = smn_db_prepare_input($_POST['move_to_category_id']);
          $path = explode('_', smn_get_generated_category_path_ids($new_parent_id));
          if (in_array($categories_id, $path)) {
            $messageStack->add_session(ERROR_CANNOT_MOVE_CATEGORY_TO_PARENT, 'error');
            smn_redirect(html_entity_decode(smn_href_link(FILENAME_STORE_PRODUCT_CATEGORIES, 'cPath=' . $cPath . '&ID='.$store_id.'&cID=' . $categories_id)));
          } else {
            smn_db_query("update " . TABLE_CATEGORIES . " set parent_id = '" . (int)$new_parent_id . "', last_modified = now() where categories_id = '" . (int)$categories_id . "' and store_id = '" .$store_id . "'");
            if (USE_CACHE == 'true') {
              smn_reset_cache_block('categories');
              smn_reset_cache_block('also_purchased');
            }
            smn_redirect(html_entity_decode(smn_href_link(FILENAME_STORE_PRODUCT_CATEGORIES, 'cPath=' . $new_parent_id . '&ID='.$store_id.'&cID=' . $categories_id)));
          }
        }
        break;
      case 'move_product_confirm':
        $products_id = smn_db_prepare_input($_POST['products_id']);
        $new_parent_id = smn_db_prepare_input($_POST['move_to_category_id']);
        $duplicate_check_query = smn_db_query("select count(*) as total from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . (int)$products_id . "' and categories_id = '" . (int)$new_parent_id . "' and store_id = '" .$store_id . "'");
        $duplicate_check = smn_db_fetch_array($duplicate_check_query);
        if ($duplicate_check['total'] < 1) smn_db_query("update " . TABLE_PRODUCTS_TO_CATEGORIES . " set categories_id = '" . (int)$new_parent_id . "' where products_id = '" . (int)$products_id . "' and categories_id = '" . (int)$current_category_id . "' and store_id = '" . $store_id . "'");
        if (USE_CACHE == 'true') {
          smn_reset_cache_block('categories');
          smn_reset_cache_block('also_purchased');
        }
        smn_redirect(html_entity_decode(smn_href_link(FILENAME_STORE_PRODUCT_CATEGORIES, 'cPath=' . $new_parent_id . '&ID='.$store_id.'&pID=' . $products_id)));
        break;
      case 'insert_product':
      case 'update_store_product':
        if (isset($_POST['edit_x']) || isset($_POST['edit_y']) && ($allow_insert == 'true')) {
          $action = 'new_product';
        } else {
          if (! checkVoucherPermissions($store_id, $_POST['products_model'])) {
            $messageStack->add(ERROR_VENDORS_CANT_ADD_VOUCHERS, 'error');
            $allow_insert = 'false';
          } else {
            if (isset($_GET['pID'])) $products_id = smn_db_prepare_input($_GET['pID']);
            $products_date_available = smn_db_prepare_input($_POST['products_date_available']);
            $products_date_available = (date('Y-m-d') < $products_date_available) ? $products_date_available : 'null';
            $sql_data_array = array('store_id' => $store_id,
                                    'products_quantity' => smn_db_prepare_input($_POST['products_quantity']),
                                    'products_model' => smn_db_prepare_input($_POST['products_model']),
                                    'products_price' => smn_db_prepare_input($_POST['products_price']),
                                    'products_date_available' => $products_date_available,
                                    'products_weight' => smn_db_prepare_input($_POST['products_weight']),
                                    'products_status' => smn_db_prepare_input($_POST['products_status']),
                                    'products_tax_class_id' => smn_db_prepare_input($_POST['products_tax_class_id']),
                                    'manufacturers_id' => smn_db_prepare_input($_POST['manufacturers_id']));
            if (isset($_POST['products_image']) && smn_not_null($_POST['products_image']) && ($_POST['products_image'] != 'none')) {
              $sql_data_array['products_image'] = smn_db_prepare_input($_POST['products_image']);
            } 
            if (($action == 'insert_product') && ($allow_insert == 'true'))  {
        
              $insert_sql_data = array('products_date_added' => 'now()');
              $sql_data_array = array_merge($sql_data_array, $insert_sql_data);
              smn_db_perform(TABLE_PRODUCTS, $sql_data_array);
              $products_id = smn_db_insert_id();
            if($store_id != 1){
              # create loop here to insert rows for multiple main mall categories
        $selected_catids =  smn_db_prepare_input($_POST['main_category_id']);
        if(($selected_catids != '') && ($selected_catids > 0)) smn_db_query("insert into " . TABLE_PRODUCTS_TO_CATEGORIES . " (store_id, products_id, categories_id) values ('1', '" . (int)$products_id . "', '" . (int)$selected_catids . "')");
            }
              smn_db_query("insert into " . TABLE_PRODUCTS_TO_CATEGORIES . " (store_id, products_id, categories_id) values ('" . (int)$store_id . "', '" . (int)$products_id . "', '" . (int)$current_category_id . "')");
            } elseif ($action == 'update_store_product') {
              $update_sql_data = array('products_last_modified' => 'now()');
              $sql_data_array = array_merge($sql_data_array, $update_sql_data);
              smn_db_perform(TABLE_PRODUCTS, $sql_data_array, 'update', "products_id = '" . (int)$products_id . "'");
              if($store_id != 1){
                # create loop here to insert rows for multiple main mall categories
                $selected_catids =  smn_db_prepare_input($_POST['main_category_id']);
                if(($selected_catids != '') && ($selected_catids > 0)) smn_db_query("update " . TABLE_PRODUCTS_TO_CATEGORIES . " set categories_id = '" . (int)$selected_catids. "' where products_id = '" . (int)$products_id . "' and store_id = '1'");
              }
            }
            $languages = smn_get_languages();
            for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
              $language_id = $languages[$i]['id'];
              $sql_data_array = array('products_name' => smn_db_prepare_input($_POST['products_name'][$language_id]),
                                      'products_description' => $_POST['products_description'][$language_id],
                                      'products_url' => smn_db_prepare_input($_POST['products_url'][$language_id]),
                                      'products_head_title_tag' => $_POST['products_head_title_tag'][$language_id],
                                      'products_head_desc_tag' => $_POST['products_head_desc_tag'][$language_id],
                                      'products_head_keywords_tag' => $_POST['products_head_keywords_tag'][$language_id]);
              if (($action == 'insert_product')  && ($allow_insert == 'true'))  {
                $insert_sql_data = array('products_id' => $products_id,
                                         'language_id' => $language_id);
                $sql_data_array = array_merge($sql_data_array, $insert_sql_data);
                smn_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data_array);
              } elseif ($action == 'update_store_product') {
                smn_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data_array, 'update', "products_id = '" . (int)$products_id . "' and language_id = '" . (int)$language_id . "'");
              }
            }
            if (USE_CACHE == 'true') {
              smn_reset_cache_block('categories');
              smn_reset_cache_block('also_purchased');
            }
            smn_redirect(html_entity_decode(smn_href_link(FILENAME_STORE_PRODUCT_CATEGORIES, 'cPath=' . $cPath . '&ID='.$store_id.'&pID=' . $products_id)));
          }
        }
        break;
      case 'copy_to_confirm':
        if (isset($_POST['products_id']) && isset($_POST['categories_id'])) {
          $products_id = smn_db_prepare_input($_POST['products_id']);
          $categories_id = smn_db_prepare_input($_POST['categories_id']);
          if ($_POST['copy_as'] == 'link') {
            if ($categories_id != $current_category_id) {
              $check_query = smn_db_query("select count(*) as total from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . (int)$products_id . "' and categories_id = '" . (int)$categories_id . "' and store_id = '" . $store_id . "'");
              $check = smn_db_fetch_array($check_query);
              if ($check['total'] < '1') {
                smn_db_query("insert into " . TABLE_PRODUCTS_TO_CATEGORIES . " (store_id, products_id, categories_id) values ('" . (int)$store_id . "', '" . (int)$products_id . "', '" . (int)$categories_id . "')");
              }
            } else {
              $messageStack->add_session(ERROR_CANNOT_LINK_TO_SAME_CATEGORY, 'error');
            }
          } elseif ($_POST['copy_as'] == 'duplicate') {
            $product_query = smn_db_query("select store_id, products_quantity, products_model, products_image, products_price, products_date_available, products_weight, products_tax_class_id, manufacturers_id from " . TABLE_PRODUCTS . " where products_id = '" . (int)$products_id . "'");
            $product = smn_db_fetch_array($product_query);
            smn_db_query("insert into " . TABLE_PRODUCTS . " (store_id, products_quantity, products_model,products_image, products_price, products_date_added, products_date_available, products_weight, products_status, products_tax_class_id, manufacturers_id) values ('" . (int)$store_id . "', '" . smn_db_input($product['products_quantity']) . "', '" . smn_db_input($product['products_model']) . "', '" . smn_db_input($product['products_image']) . "', '" . smn_db_input($product['products_price']) . "',  now(), '" . smn_db_input($product['products_date_available']) . "', '" . smn_db_input($product['products_weight']) . "', '0', '" . (int)$product['products_tax_class_id'] . "', '" . (int)$product['manufacturers_id'] . "')");
            $dup_products_id = smn_db_insert_id();
            $description_query = smn_db_query("select language_id, products_name, products_description, products_head_title_tag, products_head_desc_tag, products_head_keywords_tag, products_url from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . (int)$products_id . "'");
            while ($description = smn_db_fetch_array($description_query)) {
              smn_db_query("insert into " . TABLE_PRODUCTS_DESCRIPTION . " (products_id, language_id, products_name, products_description, products_head_title_tag, products_head_desc_tag, products_head_keywords_tag, products_url, products_viewed) values ('" . (int)$dup_products_id . "', '" . (int)$description['language_id'] . "', '" . smn_db_input($description['products_name']) . "', '" . smn_db_input($description['products_description']) . "', '" . smn_db_input($description['products_head_title_tag']) . "', '" . smn_db_input($description['products_head_desc_tag']) . "', '" . smn_db_input($description['products_head_keywords_tag']) . "', '" . smn_db_input($description['products_url']) . "', '0')");
            }    
            smn_db_query("insert into " . TABLE_PRODUCTS_TO_CATEGORIES . " (store_id, products_id, categories_id) values ('" . (int)$store_id . "', '" . (int)$dup_products_id . "', '" . (int)$categories_id . "')");
            $products_id = $dup_products_id;
          }
          if (USE_CACHE == 'true') {
            smn_reset_cache_block('categories');
            smn_reset_cache_block('also_purchased');
          }
        }
        smn_redirect(html_entity_decode(smn_href_link(FILENAME_STORE_PRODUCT_CATEGORIES, 'cPath=' . $categories_id . '&ID='.$store_id.'&pID=' . $products_id)));
        break;
      case 'new_product_preview':
          if (! checkVoucherPermissions($store_id, $_POST['products_model'])) {
            $messageStack->add(ERROR_VENDORS_CANT_ADD_VOUCHERS, 'error');
            $allow_insert = 'false';
          } else {
            // copy image only if modified
            $allowed_files_types = array('gif', 'jpg', 'jpeg', 'png');
            $products_image = new upload('products_image');
            $products_image->set_destination(DIR_FS_CATALOG_IMAGES);
            $products_image->set_extensions($allowed_files_types);  
            if ($products_image->parse() && $products_image->save()) {
              $products_image_name = $products_image->filename;
            } else {
              $products_image_name = (isset($_POST['products_previous_image']) ? $_POST['products_previous_image'] : '');
            }
          }
        break;
    }
  }
// check if the catalog image directory exists
  if (is_dir(DIR_FS_CATALOG_IMAGES)) {
    if (!is_writeable(DIR_FS_CATALOG_IMAGES)) $messageStack->add(ERROR_CATALOG_IMAGE_DIRECTORY_NOT_WRITEABLE, 'error');
  } else {
    $messageStack->add(ERROR_CATALOG_IMAGE_DIRECTORY_DOES_NOT_EXIST, 'error');
  }
  
  $breadcrumb->add(NAVBAR_TITLE, smn_href_link(FILENAME_STORE_PRODUCT_CATEGORIES, 'ID='.$store_id, 'NONSSL'));
?>