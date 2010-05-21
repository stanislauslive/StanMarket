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

define('HEADING_TITLE', 'Store Categories / Stores');
define('HEADING_TITLE_SEARCH', 'Search:');
define('HEADING_TITLE_GOTO', 'Go To:');
define('TABLE_HEADING_ID', 'ID');
define('TABLE_HEADING_CATEGORIES_STORES', 'Store Categories / Stores');
define('TABLE_HEADING_ACTION', 'Action');
define('TABLE_HEADING_STATUS', 'Status');
define('TEXT_NEW_PRODUCT', 'New Store in &quot;%s&quot;');
define('TEXT_CATEGORIES', 'Store Categories:');
define('TEXT_STORES', 'Stores:');
define('TEXT_SUBCATEGORIES', 'Subcategories:');
define('TEXT_STORE', 'Stores:');
define('TEXT_DATE_ADDED', 'Date Added:');
define('TEXT_DATE_AVAILABLE', 'Date Available:');
define('TEXT_LAST_MODIFIED', 'Last Modified:');
define('TEXT_IMAGE_NONEXISTENT', 'IMAGE DOES NOT EXIST');
define('TEXT_NO_CHILD_CATEGORIES_OR_STORES', 'Please insert a new store category or store in this level.');
define('TEXT_PRODUCT_MORE_INFORMATION', 'For more information, please visit this stores <a href="http://%s" target="blank"><u>webpage</u></a>.');
define('TEXT_PRODUCT_DATE_ADDED', 'This product was added to our catalog on %s.');
define('TEXT_PRODUCT_DATE_AVAILABLE', 'This store will be open on %s.');
define('TEXT_EDIT_INTRO', 'Please make any necessary changes');
define('TEXT_EDIT_CATEGORIES_ID', 'Store Category ID:');
define('TEXT_EDIT_CATEGORIES_NAME', 'Store Category Name:');
define('TEXT_EDIT_CATEGORIES_DESCRIPTION', 'Store Category Description:');
define('TEXT_EDIT_CATEGORIES_IMAGE', 'Store Category Image:');
define('TEXT_EDIT_SORT_ORDER', 'Sort Order:');
define('TEXT_INFO_COPY_TO_INTRO', 'Please choose a new store category you wish to copy this product to');
define('TEXT_INFO_CURRENT_CATEGORIES', 'Current Store Categories:');
define('TEXT_INFO_HEADING_NEW_CATEGORY', 'New Store Category');
define('TEXT_INFO_HEADING_EDIT_CATEGORY', 'Edit Store Category');
define('TEXT_INFO_HEADING_DELETE_CATEGORY', 'Delete Store Category');
define('TEXT_INFO_HEADING_MOVE_CATEGORY', 'Move Store Category');
define('TEXT_INFO_HEADING_DELETE_STORE', 'Delete Store');
define('TEXT_INFO_HEADING_MOVE_STORE', 'Move Store');
define('TEXT_INFO_HEADING_COPY_TO', 'Copy To');
define('TEXT_DELETE_CATEGORY_INTRO', 'Are you sure you want to delete this category?');
define('TEXT_DELETE_PRODUCT_INTRO', 'Are you sure you want to permanently delete this store?');
define('TEXT_DELETE_WARNING_CHILDS', '<b>WARNING:</b> There are %s (child-)categories still linked to this category!');
define('TEXT_DELETE_WARNING_STORE', '<b>WARNING:</b> There are %s stores still linked to this category!');
define('TEXT_MOVE_STORES_INTRO', 'Please select which category you wish <b>%s</b> to reside in');
define('TEXT_MOVE_CATEGORIES_INTRO', 'Please select which category you wish <b>%s</b> to reside in');
define('TEXT_MOVE', 'Move <b>%s</b> to:');
define('TEXT_NEW_CATEGORY_INTRO', 'Please fill out the following information for the new category');
define('TEXT_CATEGORIES_NAME', 'Store Category Name:');
define('TEXT_CATEGORIES_DESCRIPTION', 'Store Category Description:');
define('TEXT_CATEGORIES_IMAGE', 'Store Category Image:');
define('TEXT_SORT_ORDER', 'Sort Order:');
define('TEXT_STORE_STATUS', 'Stores Status:');
define('TEXT_STORE_MANUFACTURER', 'Stores Manufacturer:');
define('TEXT_STORE_NAME', 'Stores Name:');
define('TEXT_STORE_DESCRIPTION', 'Stores Description:');
define('TEXT_STORE_IMAGE', 'Stores Image:');
define('EMPTY_CATEGORY', 'Empty Category');
define('TEXT_HOW_TO_COPY', 'Copy Method:');
define('TEXT_COPY_AS_LINK', 'Link product');
define('TEXT_COPY_AS_DUPLICATE', 'Duplicate product');
define('ERROR_CANNOT_LINK_TO_SAME_CATEGORY', 'Error: Can not link Stores in the same category.');
define('ERROR_CATALOG_IMAGE_DIRECTORY_NOT_WRITEABLE', 'Error: Catalog images directory is not writeable: ' . DIR_FS_CATALOG_IMAGES);
define('ERROR_CATALOG_IMAGE_DIRECTORY_DOES_NOT_EXIST', 'Error: Catalog images directory does not exist: ' . DIR_FS_CATALOG_IMAGES);
define('ERROR_CANNOT_MOVE_CATEGORY_TO_PARENT', 'Error: Category cannot be moved into child category.');
define('TEXT_DELETE_STORE_INTRO', 'Are you sure you want to delete this Store?');
define('ERROR_STORE_NAME', 'Error: <b>Store Name</b> required');
define('ERROR_STORE_PASSWORD', 'Error: <b>Store password</b> required');
define('ERROR_DELETE_STORE', 'Error: STORE NOT DELETED');
define('ERROR_REMOVE_LOCKED_STORE', 'Error: Please unlock the <b>Store</b> before deleting it.');
define('ERROR_EDIT_LOCKED_STORE', 'Error: Please unlock the <b>Store</b> before editing it.');
define('ERROR_SEND_LOCKED_STORE', 'Error: Please unlock the <b>Store</b> before sending it.');
define('REGULAR_STORE_MAX_PRODUCTS', 'enter up to ');
define('REGULAR_STORE_COST', 'products at a monthly cost of: ');
define('BASIC_STORE_PACKAGE_TEXT', 'Enter Store Type');
define('BOX_TITLE_CREATE_NEW_STORE', 'Create New Store');
define('BOX_TITLE_CREATE_DELETE_STORE', 'Delete Store');
define('BOX_ENTRY_STORE_NAME', 'Store Name:');
define('BOX_ENTRY_OWNER_NAME', 'Store Owner Name:');
define('BOX_ENTRY_OWNER_EMAIL', 'Email Address:');
define('BOX_ENTRY_STORE_EMAIL', 'Store Email Address:');
define('BOX_ENTRY_STORE_PASSWORD', 'Store Password:');
define('ERROR_STORE_INPUT', 'Error... All fields are required to be filled in');
define('ERROR_STORE_NAME', 'Error... Duplicate store name');
define('TEXT_INFO_DELETE_STORE', 'Error... Required Information to DELETE a store');
define('TEXT_INFO_DELETE_CANCEL', 'Cancel deletion of store....');
define('TEXT_STORE_OWNER_FIRST_NAME', 'Store Owner First Name:');  
define('TEXT_STORE_OWNER_LAST_NAME', 'Store Owner Last Name:');    
define('TEXT_STORE_CONTACT_FIRST_NAME', 'Store Owner First Name:');   
define('TEXT_STORE_CONTACT_LAST_NAME', 'Store Owner Last Name:');   
define('TEXT_STORE_TELEPHONE', 'Store Telephone:');     
define('TEXT_STORE_FAX', 'Store Fax:');     
define('TEXT_STORE_NEWSLETTER', 'Store Newsletter:');     
define('TEXT_STORE_STREET_ADDRESS', 'Street Address:');   
define('TEXT_STORE_SUBURB', 'Suburb:');     
define('TEXT_STORE_POSTAL_CODE', 'Store Postal Code:');   
define('TEXT_STORE_CITY', 'City:');  
define('TEXT_STORE_AREA', 'Region:');     
define('TEXT_STORE_STATE', 'State/Province:');    
define('TEXT_STORE_COUNTRY', 'Country:'); 
define('TEXT_NEW_STORE', 'Store Manager'); 
define('TEXT_STORES_STATUS', 'Status of Store:'); 
define('TEXT_STORE_AVAILABLE', 'Available:'); 
define('TEXT_STORE_NOT_AVAILABLE', 'Not Available:');
define('TEXT_STORES_TIME_AVAILABLE', 'Store Operation Hours:');
define('TEXT_STORES_NAME', 'Store Name:'); 
define('TEXT_STORE_DESCRIPTION', 'Description of Store:'); 
define('ENTRY_PASSWORD_TEXT', 'Store Password'); 
define('ENTRY_PASSWORD_CONFIRMATION_TEXT', 'Re-Type Password'); 
define('TEXT_STORES_IMAGE', 'Store Logo:');
define('EMAIL_SUBJECT', 'Welcome to ' . MALL_NAME);
define('EMAIL_GREET_MR', 'Dear Mr. ');
define('EMAIL_GREET_MS', 'Dear Ms. ');
define('EMAIL_GREET_NONE', 'Dear ');
define('EMAIL_WELCOME', 'We welcome you to <b>' . MALL_NAME . '</b>.' . "\n\n");
define('EMAIL_TEXT', 'You can now take part in the <b>various services</b> we have to offer you. Some of these services include:' . "\n\n" .
                     '<li><b>Permanent Cart</b> - Any customer items added to the online cart remain there until they remove them, or check them out.' . "\n" .
                     '<li><b>Free Product Listing</b> - We offer your business free listings without limit within our mall! This is perfect to market your services on a broad scale.' . "\n" .
                     '<li><b>Order History</b> - View history of purchases that you have been made with us from your free listing.' . "\n" .
                     '<li><b>Stores Reviews</b> - So customers can share opinions on your services with other customers.' . "\n\n");
define('EMAIL_STORE_CONTACT', 'For help with any of our online services, please email the mall-owner: ' . MALL_EMAIL_ADDRESS . '.' . "\n\n");
define('EMAIL_STORE_WARNING', '<b>Note:</b> This email address was given to us by one of our customers. If you did not signup to be a vendor at our mall, please send an email to ' . MALL_EMAIL_ADDRESS . '.' . "\n");
?>