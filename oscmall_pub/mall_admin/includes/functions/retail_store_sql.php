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

function insert_data ($data){
$prefix = $data['store_id'];


smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES (".$prefix.", 'Expected Sort Order', 'EXPECTED_PRODUCTS_SORT', 'desc', 'This is the sort order used in the expected products box.', '1', '8', 'smn_cfg_select_option(array(\'asc\', \'desc\'), ', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES (".$prefix.", 'Expected Sort Field', 'EXPECTED_PRODUCTS_FIELD', 'date_expected', 'The column to sort by in the expected products box.', '1', '9', 'smn_cfg_select_option(array(\'products_name\', \'date_expected\'), ', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES (".$prefix.", 'Switch To Default Language Currency', 'USE_DEFAULT_LANGUAGE_CURRENCY', 'false', 'Automatically switch to the language\'s currency when it is changed', '1', '10', 'smn_cfg_select_option(array(\'true\', \'false\'), ', now());");

smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES (".$prefix.", 'Use Search-Engine Safe URLs (still in development)', 'SEARCH_ENGINE_FRIENDLY_URLS', 'false', 'Use search-engine safe urls for all site links', '1', '12', 'smn_cfg_select_option(array(\'true\', \'false\'), ', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES (".$prefix.", 'Display Cart After Adding Product', 'DISPLAY_CART', 'true', 'Display the shopping cart after adding a product (or return back to their origin)', '1', '14', 'smn_cfg_select_option(array(\'true\', \'false\'), ', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES (".$prefix.", 'Allow Guest To Tell A Friend', 'ALLOW_GUEST_TO_TELL_A_FRIEND', 'false', 'Allow guests to tell a friend about a product', '1', '15', 'smn_cfg_select_option(array(\'true\', \'false\'), ', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES (".$prefix.", 'Default Search Operator', 'ADVANCED_SEARCH_DEFAULT_OPERATOR', 'and', 'Default search operators', '1', '17', 'smn_cfg_select_option(array(\'and\', \'or\'), ', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES (".$prefix.", 'Store Address and Phone', 'STORE_NAME_ADDRESS', '".$data['store_name']."\n". $data['street_address'] . "\n". $data['city'] ."\n" . $data['postal_code'] ."\n', 'This is the Store Name, Address and Phone used on printable documents and displayed online', '1', '18', 'smn_cfg_textarea(', now());");

smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES (".$prefix.", 'Send Extra Order Emails To', 'SEND_EXTRA_ORDER_EMAILS_TO', '', 'Send extra order emails to the following email addresses, in this format: Name 1 &lt;email@address1&gt;, Name 2 &lt;email@address2&gt;', '1', '19', '', now());");

smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Credit Card Owner Name', 'CC_OWNER_MIN_LENGTH', '3', 'Minimum length of credit card owner name', '2', '12', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Credit Card Number', 'CC_NUMBER_MIN_LENGTH', '10', 'Minimum length of credit card number', '2', '13', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Review Text', 'REVIEW_TEXT_MIN_LENGTH', '50', 'Minimum length of review text', '2', '14', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Best Sellers', 'MIN_DISPLAY_BESTSELLERS', '1', 'Minimum number of best sellers to display', '2', '15', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Also Purchased', 'MIN_DISPLAY_ALSO_PURCHASED', '1', 'Minimum number of products to display in the \'This Customer Also Purchased\' box', '2', '16', now());");


smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Search Results', 'MAX_DISPLAY_SEARCH_RESULTS', '20', 'Amount of products to list', '3', '2', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Page Links', 'MAX_DISPLAY_PAGE_LINKS', '5', 'Number of \'number\' links use for page-sets', '3', '3', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Special Products', 'MAX_DISPLAY_SPECIAL_PRODUCTS', '9', 'Maximum number of products on special to display', '3', '4', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'New Products Module', 'MAX_DISPLAY_NEW_PRODUCTS', '9', 'Maximum number of new products to display in a category', '3', '5', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Products Expected', 'MAX_DISPLAY_UPCOMING_PRODUCTS', '10', 'Maximum number of products expected to display', '3', '6', now());");

smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Manufacturers List', 'MAX_DISPLAY_MANUFACTURERS_IN_A_LIST', '0', 'Used in manufacturers box; when the number of manufacturers exceeds this number, a drop-down list will be displayed instead of the default list', '3', '7', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Manufacturers Select Size', 'MAX_MANUFACTURERS_LIST', '1', 'Used in manufacturers box; when this value is \'1\' the classic drop-down list will be used for the manufacturers box. Otherwise, a list-box with the specified number of rows will be displayed.', '3', '7', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Length of Manufacturers Name', 'MAX_DISPLAY_MANUFACTURER_NAME_LEN', '15', 'Used in manufacturers box; maximum length of manufacturers name to display', '3', '8', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Store List', 'MAX_DISPLAY_STORES_IN_A_LIST', '0', 'Used in store box; when the number of stores exceeds this number, a drop-down list will be displayed instead of the default list', '3', '7', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Store Select Size', 'MAX_STORE_LIST', '1', 'Used in store box; when this value is \'1\' the classic drop-down list will be used for the storess box. Otherwise, a list-box with the specified number of rows will be displayed.', '3', '7', now());");

smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'New Reviews', 'MAX_DISPLAY_NEW_REVIEWS', '6', 'Maximum number of new reviews to display', '3', '9', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Selection of Random Reviews', 'MAX_RANDOM_SELECT_REVIEWS', '10', 'How many records to select from to choose one random product review', '3', '10', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Selection of Random New Products', 'MAX_RANDOM_SELECT_NEW', '10', 'How many records to select from to choose one random new product to display', '3', '11', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Selection of Products on Special', 'MAX_RANDOM_SELECT_SPECIALS', '10', 'How many records to select from to choose one random product special to display', '3', '12', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Categories To List Per Row', 'MAX_DISPLAY_CATEGORIES_PER_ROW', '3', 'How many categories to list per row', '3', '13', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'New Products Listing', 'MAX_DISPLAY_PRODUCTS_NEW', '10', 'Maximum number of new products to display in new products page', '3', '14', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Best Sellers', 'MAX_DISPLAY_BESTSELLERS', '10', 'Maximum number of best sellers to display', '3', '15', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Also Purchased', 'MAX_DISPLAY_ALSO_PURCHASED', '6', 'Maximum number of products to display in the \'This Customer Also Purchased\' box', '3', '16', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Customer Order History Box', 'MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX', '6', 'Maximum number of products to display in the customer order history box', '3', '17', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Order History', 'MAX_DISPLAY_ORDER_HISTORY', '10', 'Maximum number of orders to display in the order history page', '3', '18', now());");

smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Small Image Width', 'SMALL_IMAGE_WIDTH', '100', 'The pixel width of small images', '4', '1', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Small Image Height', 'SMALL_IMAGE_HEIGHT', '80', 'The pixel height of small images', '4', '2', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Heading Image Width', 'HEADING_IMAGE_WIDTH', '57', 'The pixel width of heading images', '4', '3', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Heading Image Height', 'HEADING_IMAGE_HEIGHT', '40', 'The pixel height of heading images', '4', '4', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Subcategory Image Width', 'SUBCATEGORY_IMAGE_WIDTH', '100', 'The pixel width of subcategory images', '4', '5', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Subcategory Image Height', 'SUBCATEGORY_IMAGE_HEIGHT', '57', 'The pixel height of subcategory images', '4', '6', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES (".$prefix.", 'Calculate Image Size', 'CONFIG_CALCULATE_IMAGE_SIZE', 'true', 'Calculate the size of images?', '4', '7', 'smn_cfg_select_option(array(\'true\', \'false\'), ', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES (".$prefix.", 'Image Required', 'IMAGE_REQUIRED', 'true', 'Enable to display broken images. Good for development.', '4', '8', 'smn_cfg_select_option(array(\'true\', \'false\'), ', now());");

smn_db_query ("INSERT INTO configuration  VALUES (".$prefix.", '', 'Installed Modules', 'MODULE_PAYMENT_INSTALLED', '', 'List of payment module filenames separated by a semi-colon. This is automatically updated. No need to edit. (Example: cc.php;cod.php;paypal.php)', 6, 0, now(), now(), NULL, NULL);");
smn_db_query ("INSERT INTO configuration  VALUES (".$prefix.", '', 'Installed Modules', 'MODULE_ORDER_TOTAL_INSTALLED', '', 'List of order_total module filenames separated by a semi-colon. This is automatically updated. No need to edit. (Example: ot_subtotal.php;ot_tax.php;ot_shipping.php;ot_total.php)', 6, 0, now(), now(), NULL, NULL);");
smn_db_query ("INSERT INTO configuration  VALUES (".$prefix.", '', 'Installed Modules', 'MODULE_SHIPPING_INSTALLED', '', 'List of shipping module filenames separated by a semi-colon. This is automatically updated. No need to edit. (Example: ups.php;flat.php;item.php)', 6, 0, now(), now(), NULL, NULL);");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Default Template', 'TEMPLATE_ID', '1', 'Default Template Layout used for store vendor', '6', '0', now());");


smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Default Currency', 'DEFAULT_CURRENCY', 'USD', 'Default Currency', '6', '0', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Default Language', 'DEFAULT_LANGUAGE', 'en', 'Default Language', '6', '0', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Default Order Status For New Orders', 'DEFAULT_ORDERS_STATUS_ID', '1', 'When a new order is created, this order status will be assigned to it.', '6', '0', now());");

smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Enter the Maximum Package Weight you will ship', 'SHIPPING_MAX_WEIGHT', '50', 'Carriers have a max weight limit for a single package. This is a common one for all.', '7', '3', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Package Tare weight.', 'SHIPPING_BOX_WEIGHT', '3', 'What is the weight of typical packaging of small to medium packages?', '7', '4', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Larger packages - percentage increase.', 'SHIPPING_BOX_PADDING', '10', 'For 10% enter 10', '7', '5', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Handling Fee', 'SHIPPING_HANDLING', '5.00', 'Enter the handling fee you may charge.', '7', '6', now());");

smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Display Product Image', 'PRODUCT_LIST_IMAGE', '0', 'Do you want to display the Product Image?', '8', '1', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Display Product Manufaturer Name','PRODUCT_LIST_MANUFACTURER', '0', 'Do you want to display the Product Manufacturer Name?', '8', '2', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Display Product Model', 'PRODUCT_LIST_MODEL', '0', 'Do you want to display the Product Model?', '8', '3', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Display Product Name', 'PRODUCT_LIST_NAME', '1', 'Do you want to display the Product Name?', '8', '4', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Display Product Price', 'PRODUCT_LIST_PRICE', '2', 'Do you want to display the Product Price', '8', '5', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Display Product Quantity', 'PRODUCT_LIST_QUANTITY', '0', 'Do you want to display the Product Quantity?', '8', '6', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Display Product Weight', 'PRODUCT_LIST_WEIGHT', '0', 'Do you want to display the Product Weight?', '8', '7', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Display Buy Now column', 'PRODUCT_LIST_BUY_NOW', '0', 'Do you want to display the Buy Now column?', '8', '8', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Display Category/Manufacturer Filter (0=disable; 1=enable)', 'PRODUCT_LIST_FILTER', '1', 'Do you want to display the Category/Manufacturer Filter?', '8', '9', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Location of Prev/Next Navigation Bar (1-top, 2-bottom, 3-both)', 'PREV_NEXT_BAR_LOCATION', '2', 'Sets the location of the Prev/Next Navigation Bar (1-top, 2-bottom, 3-both)', '8', '10', now());");

smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES (".$prefix.", 'Check stock level', 'STOCK_CHECK', 'true', 'Check to see if sufficent stock is available', '9', '1', 'smn_cfg_select_option(array(\'true\', \'false\'), ', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES (".$prefix.", 'Subtract stock', 'STOCK_LIMITED', 'true', 'Subtract product in stock by product orders', '9', '2', 'smn_cfg_select_option(array(\'true\', \'false\'), ', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES (".$prefix.", 'Allow Checkout', 'STOCK_ALLOW_CHECKOUT', 'true', 'Allow customer to checkout even if there is insufficient stock', '9', '3', 'smn_cfg_select_option(array(\'true\', \'false\'), ', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Mark product out of stock', 'STOCK_MARK_PRODUCT_OUT_OF_STOCK', '***', 'Display something on screen so customer can see which product has insufficient stock', '9', '4', now());");
smn_db_query ("INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (".$prefix.", 'Stock Re-order level', 'STOCK_REORDER_LEVEL', '5', 'Define when stock needs to be re-ordered', '9', '5', now());");

smn_db_query ("INSERT INTO tax_class (store_id, tax_class_id, tax_class_title, tax_class_description, last_modified, date_added) VALUES (".$prefix.", '', 'Taxable Goods', 'The following types of products are included non-food, services, etc', now(), now());");
$tax_class_id = smn_db_insert_id();

smn_db_query ("INSERT INTO geo_zones (store_id, geo_zone_id, geo_zone_name, geo_zone_description, date_added) VALUES (".$prefix.", '','Florida','Florida local sales tax zone',now());");
$geo_zone_id = smn_db_insert_id();

smn_db_query ("INSERT INTO tax_rates (store_id, tax_rates_id, tax_zone_id, tax_class_id, tax_priority, tax_rate, tax_description, last_modified, date_added ) VALUES (".$prefix.", '',  " . $geo_zone_id  . ", " . $tax_class_id . ", 1, 7.0, 'FL TAX 7.0%', now(), now());");
$tax_rate_id = smn_db_insert_id();

smn_db_query ("INSERT INTO zones_to_geo_zones (store_id, association_id, zone_country_id, zone_id, geo_zone_id, date_added) VALUES (".$prefix.", '', 223, 18, " . $geo_zone_id  . ", now());");


    if ($db_error)
	return ($db_error);
	else
	return ($store_data_inserted = 'true');

} // end of insert data


 function my_dir_copy($oldname, $newname){
  if(!is_dir($newname)){
     mkdir($newname);
   }
   $dir = opendir($oldname);
   while($file = readdir($dir)){
     if($file == "." || $file == ".."){
       continue;
    }
     my_copy("$oldname/$file", "$newname/$file");
   }
   closedir($dir);
   return ($store_images_created = 'true'); 
 }

 function my_copy($oldname, $newname){
  if(is_file($oldname)){
     $perms = fileperms($oldname);
    return copy($oldname, $newname) && chmod($newname, $perms);
  }else if(is_dir($oldname)){
     my_dir_copy($oldname, $newname);
   }else{
     die("Cannot copy file: $oldname (it's neither a file nor a directory)");
   } 
}
?>