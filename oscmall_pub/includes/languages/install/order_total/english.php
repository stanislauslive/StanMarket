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

function smn_module_laguage_install($module_name, $new_language_id, $prefix){
    switch($module_name){
// ot_total installs
        case 'ot_total':
          smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ot_total', 'MODULE_ORDER_TOTAL_TOTAL_TITLE', " . (int)$new_language_id . ", 'Total', now());");
          smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ot_total', 'MODULE_ORDER_TOTAL_TOTAL_DESCRIPTION', " . (int)$new_language_id . ", 'Order Total', now());");
        break;

// ot_loworderfee installs
        case 'ot_loworderfee':
          smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ot_loworderfee', 'MODULE_ORDER_TOTAL_LOWORDERFEE_TITLE', " . (int)$new_language_id . ", 'Low Order Fee', now());");
          smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ot_loworderfee', 'MODULE_ORDER_TOTAL_LOWORDERFEE_DESCRIPTION', " . (int)$new_language_id . ", 'Low Order Fee', now());");
        break;

// ot_shipping installs
        case 'ot_shipping':
          smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ot_shipping', 'MODULE_ORDER_TOTAL_SHIPPING_TITLE', " . (int)$new_language_id . ", 'Shipping', now());");
          smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ot_shipping', 'MODULE_ORDER_TOTAL_SHIPPING_DESCRIPTION', " . (int)$new_language_id . ", 'Order Shipping Cost', now());");
          smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ot_shipping', 'FREE_SHIPPING_TITLE', " . (int)$new_language_id . ", 'Free Shipping', now());");
          smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ot_shipping', 'FREE_SHIPPING_DESCRIPTION', " . (int)$new_language_id . ", 'Free shipping for orders over', now());");
        break;

// ot_subtotal installs
        case 'ot_subtotal':
          smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ot_subtotal', 'MODULE_ORDER_TOTAL_SUBTOTAL_TITLE', " . (int)$new_language_id . ", 'Sub-Total', now());");
          smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ot_subtotal', 'MODULE_ORDER_TOTAL_SUBTOTAL_DESCRIPTION', " . (int)$new_language_id . ", 'Order Sub-Total', now());");
        break;

// ot_tax installs
        case 'ot_tax':
          smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ot_tax', 'MODULE_ORDER_TOTAL_TAX_TITLE', " . (int)$new_language_id . ", 'Tax', now());");
          smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ot_tax', 'MODULE_ORDER_TOTAL_TAX_DESCRIPTION', " . (int)$new_language_id . ", 'Order Tax', now());");
        break;
    
    
// ot_gv installs
        case 'ot_gv':
          smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ot_gv', 'MODULE_ORDER_TOTAL_GV_TITLE', " . (int)$new_language_id . ", 'Gift Vouchers (-) ', now());");
          smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ot_gv', 'MODULE_ORDER_TOTAL_GV_HEADER', " . (int)$new_language_id . ", 'Enter code below if you have any gift certificates or coupons you have not redeemed yet.', now());");
          smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ot_gv', 'MODULE_ORDER_TOTAL_GV_DESCRIPTION', " . (int)$new_language_id . ", 'Gift Vouchers', now());");
          smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ot_gv', 'SHIPPING_NOT_INCLUDED', " . (int)$new_language_id . ", ' [Shipping not included]', now());");
          smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ot_gv', 'TAX_NOT_INCLUDED', " . (int)$new_language_id . ", ' [Tax not included]', now());");
          smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ot_gv', 'MODULE_ORDER_TOTAL_GV_USER_PROMPT', " . (int)$new_language_id . ", ' <b>to be used from Gift Vouchers</td><td align=right>', now());");
          smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ot_gv', 'TEXT_ENTER_GV_CODE', " . (int)$new_language_id . ", 'Enter Redeem Code  ', now());");
          smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ot_gv', 'MODULE_ORDER_TOTAL_GV_TEXT_ERROR', " . (int)$new_language_id . ", 'Gift Voucher/Discount coupon Error', now());");
        break;
    
// ot_coupon installs
        case 'ot_coupon':
          smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ot_coupon', 'MODULE_ORDER_TOTAL_COUPON_TITLE', " . (int)$new_language_id . ", 'Discount Coupons', now());");
          smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ot_coupon', 'MODULE_ORDER_TOTAL_COUPON_HEADER', " . (int)$new_language_id . ", 'Gift Vouchers/Discount Coupons', now());");
          smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ot_coupon', 'MODULE_ORDER_TOTAL_COUPON_DESCRIPTION', " . (int)$new_language_id . ", 'Discount Coupon', now());");
          smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ot_coupon', 'SHIPPING_NOT_INCLUDED', " . (int)$new_language_id . ", ' [Shipping not included]', now());");
          smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ot_coupon', 'TAX_NOT_INCLUDED', " . (int)$new_language_id . ", ' [Tax not included]', now());");
          smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ot_coupon', 'MODULE_ORDER_TOTAL_COUPON_USER_PROMPT', " . (int)$new_language_id . ", '', now());");
          smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ot_coupon', 'ERROR_NO_INVALID_REDEEM_COUPON', " . (int)$new_language_id . ", 'Invalid Coupon Code', now());");
          smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ot_coupon', 'ERROR_REDEEMED_AMOUNT_ZERO', " . (int)$new_language_id . ", 'a valid coupon number. HOWEVER: No reduction will be applied, please see the coupon restrictions that was sent within your offer email**', now());");
          smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ot_coupon', 'ERROR_INVALID_STARTDATE_COUPON', " . (int)$new_language_id . ", 'This coupon is not available yet', now());");
          smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ot_coupon', 'ERROR_INVALID_FINISDATE_COUPON', " . (int)$new_language_id . ", 'This coupon has expired', now());");
          smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ot_coupon', 'ERROR_INVALID_USES_COUPON', " . (int)$new_language_id . ", 'This coupon could only be used ', now());");
          smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ot_coupon', 'TIMES', " . (int)$new_language_id . ", ' times.', now());");
          smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ot_coupon', 'ERROR_INVALID_USES_USER_COUPON', " . (int)$new_language_id . ", 'You have used the coupon the maximum number of times allowed per customer.', now());");
          smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ot_coupon', 'REDEEMED_COUPON', " . (int)$new_language_id . ", 'a coupon worth ', now());");
          smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ot_coupon', 'REDEEMED_MIN_ORDER', " . (int)$new_language_id . ", 'on orders over ', now());");
          smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ot_coupon', 'REDEEMED_RESTRICTIONS', " . (int)$new_language_id . ", ' [Product-Category restrictions apply]', now());");
          smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ot_coupon', 'TEXT_ENTER_COUPON_CODE', " . (int)$new_language_id . ", 'Enter Redeem Code&nbsp;&nbsp;', now());");
          smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ot_coupon', 'MODULE_ORDER_TOTAL_COUPON_TEXT_ERROR', " . (int)$new_language_id . ", 'Discount Coupon Error', now());");
        break;     
    }
}