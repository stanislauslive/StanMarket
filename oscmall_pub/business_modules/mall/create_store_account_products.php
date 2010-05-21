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

   global $page_name;

  // file uploading class
  require(DIR_WS_CLASSES . 'upload.php');
  if (function_exists('ini_get') && ((bool)ini_get('file_uploads') == false) ) {
    $messageStack->add(WARNING_FILE_UPLOADS_DISABLED, 'warning');
  }
  require(DIR_WS_CLASSES . 'store.php');
  require(DIR_WS_CLASSES . 'store_products.php');
   
// if the customer is not logged on, redirect them to the login page
  if (!smn_session_is_registered('customer_id')) {
    $navigation->set_snapshot();
    smn_redirect(smn_href_link(FILENAME_LOGIN, '', 'NONSSL'));
  }
   

   
   
// systemsmanager begin - Dec 8, 2005
if (isset($_POST['action']) && ($_POST['action'] == 'process') && smn_session_is_registered('customer_store_id')) {
	$new_products = new store_products($customer_store_id);
	for ($j=0; $j<4; $j++) {
	  if (isset($_POST["products_name_$j"]) && $_POST['products_name_' . $j]!= '') {
            $products_array = array('products_name' => $_POST['products_name_' . $j],
                                    'products_id' => '',
				    'products_model' => $_POST['products_model_' . $j],
                                    'products_price' => $_POST['products_price_' . $j],
                                    'products_description' => $_POST['products_description_' . $j],
                                    'products_image' => 'products_image_' . $j,
                                    'products_type' => $_POST['products_type_' . $j],
                                    'category_id' => $_POST['products_category_' . $j]);
	    $new_products->set_store_products($products_array);
            $error_text = $new_products->load_products();
            if ($error_text != '') {
	      smn_session_register('error_text');
            }
	  }
	}
    smn_redirect(smn_href_link(FILENAME_CREATE_STORE_ACCOUNT_SUCCESS, '', 'NONSSL'));	
}


// systemsmanager end

  $breadcrumb->add(NAVBAR_TITLE_1);
  $breadcrumb->add(NAVBAR_TITLE_2);

  if (sizeof($navigation->snapshot) > 0) {
    $origin_href = smn_href_link($navigation->snapshot['page'], smn_array_to_string($navigation->snapshot['get'], array(smn_session_name())), $navigation->snapshot['mode']);
    $navigation->clear_snapshot();
  } else {
    $origin_href = smn_href_link(FILENAME_DEFAULT);
  }
?>