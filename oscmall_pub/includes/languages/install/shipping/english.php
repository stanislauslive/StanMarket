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

        case 'ups':
            smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ups', 'MODULE_SHIPPING_UPS_TEXT_TITLE', " . (int)$new_language_id . ", 'United Parcel Service', now());");
            smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ups', 'MODULE_SHIPPING_UPS_TEXT_DESCRIPTION', " . (int)$new_language_id . ", 'United Parcel Service', now());");
            smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ups', 'MODULE_SHIPPING_UPS_TEXT_OPT_GND', " . (int)$new_language_id . ", 'UPS Ground', now());");
            smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ups', 'MODULE_SHIPPING_UPS_TEXT_OPT_1DM', " . (int)$new_language_id . ", 'Next Day Air Early AM', now());");
            smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ups', 'MODULE_SHIPPING_UPS_TEXT_OPT_1DA', " . (int)$new_language_id . ", 'Next Day Air', now());");
            smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ups', 'MODULE_SHIPPING_UPS_TEXT_OPT_1DP', " . (int)$new_language_id . ", 'Next Day Air Saver', now());");
            smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ups', 'MODULE_SHIPPING_UPS_TEXT_OPT_2DM', " . (int)$new_language_id . ", '2nd Day Air Early AM', now());");
            smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ups', 'MODULE_SHIPPING_UPS_TEXT_OPT_3DS', " . (int)$new_language_id . ", '3 Day Select', now());");
            smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ups', 'MODULE_SHIPPING_UPS_TEXT_OPT_STD', " . (int)$new_language_id . ", 'Canada Standard', now());");
            smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ups', 'MODULE_SHIPPING_UPS_TEXT_OPT_XPR', " . (int)$new_language_id . ", 'Worldwide Express', now());");
            smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ups', 'MODULE_SHIPPING_UPS_TEXT_OPT_XDM', " . (int)$new_language_id . ", 'Worldwide Express Plus', now());");
            smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ups', 'MODULE_SHIPPING_UPS_TEXT_OPT_XPD', " . (int)$new_language_id . ", 'Worldwide Expedited', now());");
        break;

// table installs
        case 'table':
        smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'table', 'MODULE_SHIPPING_TABLE_TEXT_TITLE', " . (int)$new_language_id . ", 'Table Rate', now());");
        smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'table', 'MODULE_SHIPPING_TABLE_TEXT_DESCRIPTION', " . (int)$new_language_id . ", 'Table Rate', now());");
        smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'table', 'MODULE_SHIPPING_TABLE_TEXT_WAY', " . (int)$new_language_id . ", 'Best Way', now());");
        smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'table', 'MODULE_SHIPPING_TABLE_TEXT_WEIGHT', " . (int)$new_language_id . ", 'Weight', now());");
        smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'table', 'MODULE_SHIPPING_TABLE_TEXT_AMOUNT', " . (int)$new_language_id . ", 'Amount', now());");
        break;

// pick up installs
        case 'pickup':
        smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'pickup', 'MODULE_SHIPPING_PICK_UP_TEXT_TITLE', " . (int)$new_language_id . ", 'Pick Up Rate', now());");
        smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'pickup', 'MODULE_SHIPPING_PICK_UP_TEXT_DESCRIPTION', " . (int)$new_language_id . ", 'Pick Up Rate', now());");
        smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'pickup', 'MODULE_SHIPPING_PICK_UP_TEXT_WAY', " . (int)$new_language_id . ", 'Best Way', now());");
        break;

// items installs
        case 'item':
        smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'item', 'MODULE_SHIPPING_ITEM_TEXT_TITLE', " . (int)$new_language_id . ", 'Per Item', now());");
        smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'item', 'MODULE_SHIPPING_ITEM_TEXT_DESCRIPTION', " . (int)$new_language_id . ", 'Per Item', now());");
        smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'item', 'MODULE_SHIPPING_ITEM_TEXT_WA', " . (int)$new_language_id . ", 'Best Way', now());");
        break;

// freeamount installs
        case 'freeamount':
        smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'freeamount', 'MODULE_SHIPPING_FREEAMOUNT_TEXT_TITLE', " . (int)$new_language_id . ", 'No Shipping Charges', now());");
        smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'freeamount', 'MODULE_SHIPPING_FREEAMOUNT_TEXT_DESCRIPTION', " . (int)$new_language_id . ", 'No Shipping Charges', now());");
        smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'freeamount', 'MODULE_SHIPPING_FREEAMOUNT_TEXT_WAY', " . (int)$new_language_id . ", 'No Shipping Charges', now());");
        smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'freeamount', 'MODULE_SHIPPING_FREEAMOUNT_TEXT_ERROR', " . (int)$new_language_id . ", 'Only for a order minimum', now());");
        smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'freeamount', 'MODULE_SHIPPING_FREEAMOUNT_TEXT_TO_HEIGHT', " . (int)$new_language_id . ", 'To height', now());");
        smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'freeamount', 'MODULE_SHIPPING_FREEAMOUNT_TEXT_UNIT', " . (int)$new_language_id . ", 'lbs', now());");
        smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'freeamount', 'MODULE_SHIPPING_FREEAMOUNT_COST', " . (int)$new_language_id . ", '0.00', now());");
        break;

// freeshipper installs
        case 'freeshipper':
        smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'freeshipper', 'MODULE_SHIPPING_FREESHIPPER_TEXT_TITLE', " . (int)$new_language_id . ", 'No Shipping Charges', now());");
        smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'freeshipper', 'MODULE_SHIPPING_FREESHIPPER_TEXT_DESCRIPTION', " . (int)$new_language_id . ", 'No Shipping Charges', now());");
        smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'freeshipper', 'MODULE_SHIPPING_FREESHIPPER_TEXT_WAY', " . (int)$new_language_id . ", 'No Shipping Charges', now());");
        break;

// flat installs
        case 'flat':
        smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'flat', 'MODULE_SHIPPING_FLAT_TEXT_TITLE', " . (int)$new_language_id . ", 'Flat Rate', now());");
        smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'flat', 'MODULE_SHIPPING_FLAT_TEXT_DESCRIPTION', " . (int)$new_language_id . ", 'Flat Rate', now());");
        smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'flat', 'MODULE_SHIPPING_FLAT_TEXT_WAY', " . (int)$new_language_id . ", 'Best Way', now());");
        break;

// delivery installs
        case 'delivery':
        smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'delivery', 'MODULE_SHIPPING_DELIVERY_TEXT_TITLE', " . (int)$new_language_id . ", 'Delivery Rate', now());");
        smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'delivery', 'MODULE_SHIPPING_DELIVERY_TEXT_DESCRIPTION', " . (int)$new_language_id . ", 'Delivery Rate', now());");
        smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'delivery', 'MODULE_SHIPPING_DELIVERY_TEXT_WAY', " . (int)$new_language_id . ", 'Best Way', now());");
        break;

// zones installs
        case 'zones':
        smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'zones', 'MODULE_SHIPPING_ZONES_TEXT_TITLE', " . (int)$new_language_id . ", 'Zone Rates', now());");
        smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'zones', 'MODULE_SHIPPING_ZONES_TEXT_DESCRIPTION', " . (int)$new_language_id . ", 'Zone Based Rates', now());");
        smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'zones', 'MODULE_SHIPPING_ZONES_TEXT_WAY', " . (int)$new_language_id . ", 'Shipping to', now());");
        smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'zones', 'MODULE_SHIPPING_ZONES_TEXT_UNITS', " . (int)$new_language_id . ", 'lb(s)', now());");
        smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'zones', 'MODULE_SHIPPING_ZONES_INVALID_ZONE', " . (int)$new_language_id . ", 'No shipping available to the selected country', now());");
        smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'zones', 'MODULE_SHIPPING_ZONES_UNDEFINED_RATE', " . (int)$new_language_id . ", 'The shipping rate cannot be determined at this time', now());");
        break;

// usps installs
        case 'usps':
        smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'usps', 'MODULE_SHIPPING_USPS_TEXT_TITLE', " . (int)$new_language_id . ", 'United States Postal Service', now());");
        smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'usps', 'MODULE_SHIPPING_USPS_TEXT_DAYS', " . (int)$new_language_id . ", 'Days', now());");
        smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'usps', 'MODULE_SHIPPING_USPS_TEXT_DAY', " . (int)$new_language_id . ", 'Day', now());");
        smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'usps', 'MODULE_SHIPPING_USPS_TEXT_DESCRIPTION', " . (int)$new_language_id . ", 'United States Postal Service<br><br>You will need to have registered an account with USPS at http://www.uspsprioritymail.com/et_regcert.html to use this module<br><br>USPS expects you to use pounds as weight measure for your products.', now());");
        smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'usps', 'MODULE_SHIPPING_USPS_TEXT_OPT_PP', " . (int)$new_language_id . ", 'Parcel Post', now());");
        smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'usps', 'MODULE_SHIPPING_USPS_TEXT_OPT_PM', " . (int)$new_language_id . ", 'Priority Mail', now());");
        smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'usps', 'MODULE_SHIPPING_USPS_TEXT_OPT_EX', " . (int)$new_language_id . ", 'Express Mail', now());");
        smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'usps', 'MODULE_SHIPPING_USPS_TEXT_ERROR', " . (int)$new_language_id . ", 'An error occured with the USPS shipping calculations.<br>If you prefer to use USPS as your shipping method, please contact the store owner.', now());");
        break;
    }
}