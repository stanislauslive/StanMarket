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

// define the database table names used in the project
  define('TABLE_ADDRESS_BOOK', 'address_book');
  define('TABLE_ADDRESS_FORMAT', 'address_format');
  define('TABLE_BANNERS', 'banners');
  define('TABLE_BANNERS_HISTORY', 'banners_history');
  define('TABLE_CATEGORIES', 'categories');
  define('TABLE_CATEGORIES_DESCRIPTION', 'categories_description');
  define('TABLE_CONFIGURATION', 'configuration');
  define('TABLE_CONFIGURATION_GROUP', 'configuration_group');
  define('TABLE_COUNTER', 'counter');
  define('TABLE_COUNTER_HISTORY', 'counter_history');
  define('TABLE_COUNTRIES', 'countries');
  define('TABLE_CURRENCIES', 'currencies');
  define('TABLE_CUSTOMERS', 'customers');
  define('TABLE_CUSTOMERS_BASKET', 'customers_basket');
  define('TABLE_CUSTOMERS_BASKET_ATTRIBUTES', 'customers_basket_attributes');
  define('TABLE_CUSTOMERS_INFO', 'customers_info');
  define('TABLE_LANGUAGES', 'languages');
  define('TABLE_MANUFACTURERS', 'manufacturers');
  define('TABLE_MANUFACTURERS_INFO', 'manufacturers_info');
  define('TABLE_ORDERS', 'orders');
  define('TABLE_ORDERS_INVOICE', 'orders_invoice');
  define('TABLE_ORDERS_PRODUCTS', 'orders_products');
  define('TABLE_ORDERS_PRODUCTS_ATTRIBUTES', 'orders_products_attributes');
  define('TABLE_ORDERS_PRODUCTS_DOWNLOAD', 'orders_products_download');
  define('TABLE_ORDERS_STATUS', 'orders_status');
  define('TABLE_ORDERS_STATUS_HISTORY', 'orders_status_history');
  define('TABLE_ORDERS_TOTAL', 'orders_total');
/*Defined the DB table orders_vendor_amount, By Cimi */
  define('TABLE_ORDERS_VENDOR_AMOUNT', 'orders_vendor_amount');
  define('TABLE_PRODUCTS', 'products');
  define('TABLE_PRODUCTS_ATTRIBUTES', 'products_attributes');
  define('TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD', 'products_attributes_download');
  define('TABLE_PRODUCTS_DESCRIPTION', 'products_description');
  define('TABLE_PRODUCTS_NOTIFICATIONS', 'products_notifications');
  define('TABLE_PRODUCTS_OPTIONS', 'products_options');
  define('TABLE_PRODUCTS_OPTIONS_VALUES', 'products_options_values');
  define('TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS', 'products_options_values_to_products_options');
  define('TABLE_PRODUCTS_TO_CATEGORIES', 'products_to_categories');
  define('TABLE_REVIEWS', 'reviews');
  define('TABLE_REVIEWS_DESCRIPTION', 'reviews_description');
  define('TABLE_SESSIONS', 'sessions');
  define('TABLE_SPECIALS', 'specials');
  define('TABLE_TAX_CLASS', 'tax_class');
  define('TABLE_TAX_RATES', 'tax_rates');
  define('TABLE_GEO_ZONES', 'geo_zones');
  define('TABLE_ZONES_TO_GEO_ZONES', 'zones_to_geo_zones');
  define('TABLE_WHOS_ONLINE', 'whos_online');
  define('TABLE_ZONES', 'zones');
  
  
  define('TABLE_ADMIN', 'admin');  
  define('TABLE_ADMIN_GROUPS', 'admin_groups');
  define('TABLE_FINANCIAL_DATA', 'financial_data');  
  
  define('TABLE_TEMPLATE', 'template');
  define('TABLE_ARTICLES', 'articles');
  define('TABLE_WEB_SITE_CONTENT', 'web_site_content');
  define('TABLE_DYNAMIC_PAGE_INDEX', 'dynamic_page_index');
  
  
  define('TABLE_STORE_MAIN','store_main');  
  define('TABLE_STORE_TYPES', 'store_types'); 
  define('TABLE_STORE_COSTS', 'store_costs');
 // define('TABLE_STORE_OWNER_DATA' , 'store_owner_data');
  define('TABLE_STORE_TO_CATEGORIES', 'store_to_categories');
  define('TABLE_STORE_CATEGORIES', 'store_categories');
  define('TABLE_STORE_CATEGORIES_DESCRIPTION', 'store_categories_description');
  define('TABLE_STORE_TYPES', 'store_types');
  define('TABLE_STORE_DESCRIPTION', 'store_description');  
  
  define('TABLE_MEMBER_ORDERS', 'member_orders');
  define('TABLE_ORDERS_TRACKING', 'orders_tracking');
  

  define('TABLE_COUPON_GV_CUSTOMER', 'coupon_gv_customer');
  define('TABLE_COUPON_GV_QUEUE', 'coupon_gv_queue');
  define('TABLE_COUPON_REDEEM_TRACK', 'coupon_redeem_track');
  define('TABLE_COUPON_EMAIL_TRACK', 'coupon_email_track');
  define('TABLE_COUPONS', 'coupons');
  define('TABLE_COUPONS_DESCRIPTION', 'coupons_description');
  
  define('TABLE_AFFILIATE', 'affiliate_affiliate');
/*Defined the affilaite_news_contents table,By Cimi*/
  define('TABLE_AFFILIATE_NEWS', 'affiliate_news');
  define('TABLE_AFFILIATE_NEWS_CONTENTS', 'affiliate_news_contents');
  define('TABLE_AFFILIATE_NEWSLETTERS', 'affiliate_newsletters');
  define('TABLE_AFFILIATE_BANNERS', 'affiliate_banners');
  define('TABLE_AFFILIATE_BANNERS_HISTORY', 'affiliate_banners_history');
  define('TABLE_AFFILIATE_CLICKTHROUGHS', 'affiliate_clickthroughs');
  define('TABLE_AFFILIATE_PAYMENT', 'affiliate_payment');
  define('TABLE_AFFILIATE_PAYMENT_STATUS', 'affiliate_payment_status');
  define('TABLE_AFFILIATE_PAYMENT_STATUS_HISTORY', 'affiliate_payment_status_history');
  define('TABLE_AFFILIATE_SALES', 'affiliate_sales');


  define('TABLE_STREAMING_PRODUCTS_INFO', 'video_streams_info');
  define('TABLE_STREAMING_PRODUCTS', 'purchased_streams');
  
  define('TABLE_HELP', 'help');
  define('TABLE_HELP_CONTENT', 'help_content');
?>