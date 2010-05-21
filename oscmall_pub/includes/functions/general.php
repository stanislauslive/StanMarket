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

////
// Stop from parsing any further PHP code
  function smn_exit() {
   smn_session_close();
   exit();
  }



function smn_redirect($url) {

  if ( (strstr($url, "\n") != false) || (strstr($url, "\r") != false) ) {
    smn_redirect(smn_href_link(FILENAME_DEFAULT, '', 'NONSSL', false));
  }
  if ( (ENABLE_SSL == true) && (getenv('HTTPS') == 'on') ) { // We are loading an SSL page
    if (substr($url, 0, strlen(HTTP_SERVER)) == HTTP_SERVER) { // NONSSL url
      $url = HTTPS_SERVER . substr($url, strlen(HTTP_SERVER)); // Change it to SSL
    }
  }
  header('Location: ' . str_replace('&amp;', '&', $url));
  smn_exit();
}


// Parse the data used in the html tags to ensure the tags will not break
  function smn_parse_input_field_data($data, $parse) {
    return strtr(trim($data), $parse);
  }

  function smn_output_string($string, $translate = false, $protected = false) {
    if ($protected == true) {
      return ($string);
    } else {
      if ($translate == false) {
        return ($string);
      } else {
        return ($string);
      }
    }
  }

  function smn_output_string_protected($string) {
    return smn_output_string($string, false, true);
  }

  function smn_sanitize_string($string) {
    $string = ereg_replace(' +', ' ', trim($string));

    return preg_replace("/[<>]/", '_', $string);
  }

////
// Return a random row from a database query
  function smn_random_select($query) {
    $random_product = '';
    $random_query = smn_db_query($query);
    $num_rows = smn_db_num_rows($random_query);
    if ($num_rows > 0) {
      $random_row = smn_rand(0, ($num_rows - 1));
      smn_db_data_seek($random_query, $random_row);
      $random_product = smn_db_fetch_array($random_query);
    }

    return $random_product;
  }

////
// Return a product's name
// TABLES: products
  function smn_get_products_name($product_id, $language = '') {
    global $languages_id;

    if (empty($language)) $language = $languages_id;

    $product_query = smn_db_query("select products_name from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . (int)$product_id . "' and language_id = '" . (int)$language . "'");
    $product = smn_db_fetch_array($product_query);

    return $product['products_name'];
  }

////
// Return a product's special price (returns nothing if there is no offer)
// TABLES: products
  function smn_get_products_special_price($product_id) {
    $product_query = smn_db_query("select specials_new_products_price from " . TABLE_SPECIALS . " where products_id = '" . (int)$product_id . "' and status");
    $product = smn_db_fetch_array($product_query);

    return $product['specials_new_products_price'];
  }

////
// Return a product's stock
// TABLES: products
  function smn_get_products_stock($products_id) {
    $products_id = smn_get_prid($products_id);
    $stock_query = smn_db_query("select products_quantity from " . TABLE_PRODUCTS . " where products_id = '" . (int)$products_id . "'");
    $stock_values = smn_db_fetch_array($stock_query);

    return $stock_values['products_quantity'];
  }

////
// Check if the required stock is available
// If insufficent stock is available return an out of stock message
  function smn_check_stock($products_id, $products_quantity) {
    $stock_left = smn_get_products_stock($products_id) - $products_quantity;
    $out_of_stock = '';

    if ($stock_left < 0) {
      $out_of_stock = '<span class="markProductOutOfStock">' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . '</span>';
    }

    return $out_of_stock;
  }

////
// Break a word in a string if it is longer than a specified length ($len)
  function smn_break_string($string, $len, $break_char = '-') {
    $l = 0;
    $output = '';
    for ($i=0, $n=strlen($string); $i<$n; $i++) {
      $char = substr($string, $i, 1);
      if ($char != ' ') {
        $l++;
      } else {
        $l = 0;
      }
      if ($l > $len) {
        $l = 1;
        $output .= $break_char;
      }
      $output .= $char;
    }

    return $output;
  }

////
// Return all HTTP GET variables, except those passed as a parameter
  function smn_get_all_get_params($exclude_array = '') {
    global $_GET;

    if (!is_array($exclude_array)) $exclude_array = array();

    $get_url = '';
    if (is_array($_GET) && (sizeof($_GET) > 0)) {
      reset($_GET);
      while (list($key, $value) = each($_GET)) {
	  /* Removed ($key != 'ID')&& from the condition to add store id in the url by Cimi on June 08,2007*/
        if ( (strlen($value) > 0) && ($key != smn_session_name()) && ($key != 'error')  && ($key != 'SmT')  &&  (!in_array($key, $exclude_array)) && ($key != 'x') && ($key != 'y') ) {
          $get_url .= $key . '=' . rawurlencode(stripslashes($value)) . '&';
        }
      }
    }

    return $get_url;
  }

////
// Returns an array with countries
// TABLES: countries
  function smn_get_countries($countries_id = '', $with_iso_codes = false) {
    $countries_array = array();
    if (smn_not_null($countries_id)) {
      if ($with_iso_codes == true) {
        $countries = smn_db_query("select countries_name, countries_iso_code_2, countries_iso_code_3 from " . TABLE_COUNTRIES . " where countries_id = '" . (int)$countries_id . "' order by countries_name");
        $countries_values = smn_db_fetch_array($countries);
        $countries_array = array('countries_name' => $countries_values['countries_name'],
                                 'countries_iso_code_2' => $countries_values['countries_iso_code_2'],
                                 'countries_iso_code_3' => $countries_values['countries_iso_code_3']);
      } else {
        $countries = smn_db_query("select countries_name from " . TABLE_COUNTRIES . " where countries_id = '" . (int)$countries_id . "'");
        $countries_values = smn_db_fetch_array($countries);
        $countries_array = array('countries_name' => $countries_values['countries_name']);
      }
    } else {
      $countries = smn_db_query("select countries_id, countries_name from " . TABLE_COUNTRIES . " order by countries_name");
      while ($countries_values = smn_db_fetch_array($countries)) {
        $countries_array[] = array('countries_id' => $countries_values['countries_id'],
                                   'countries_name' => $countries_values['countries_name']);
      }
    }

    return $countries_array;
  }


  function smn_get_sales($store_id = '', $status = 1) {
  
    if($store_id == ''){
      return '0';
    }else{
      $order_query = smn_db_query("select count(*) as total from " . TABLE_ORDERS . " where store_id = '". (int)$store_id ."' and orders_status = '" . (int)$status . "'");
      $order = smn_db_fetch_array($order_query);
      return $order['total'];
    }
  }




////
// Alias function to smn_get_countries, which also returns the countries iso codes
  function smn_get_countries_with_iso_codes($countries_id) {
    return smn_get_countries($countries_id, true);
  }

////
// Generate a path to categories
  function smn_get_path($current_category_id = '') {
    global $cPath_array, $store_id;

    if (smn_not_null($current_category_id)) {
      $cp_size = sizeof($cPath_array);
      if ($cp_size == 0) {
        $cPath_new = $current_category_id;
      } else {
        $cPath_new = '';
        $last_category_query = smn_db_query("select parent_id from " . TABLE_CATEGORIES . " where categories_id = '" . (int)$cPath_array[($cp_size-1)] . "' and store_id = '" . (int)$store_id  . "'");
        $last_category = smn_db_fetch_array($last_category_query);

        $current_category_query = smn_db_query("select parent_id from " . TABLE_CATEGORIES . " where categories_id = '" . (int)$current_category_id . "' and store_id = '" . (int)$store_id  . "'");
        $current_category = smn_db_fetch_array($current_category_query);

        if ($last_category['parent_id'] == $current_category['parent_id']) {
          for ($i=0; $i<($cp_size-1); $i++) {
            $cPath_new .= '_' . $cPath_array[$i];
          }
        } else {
          for ($i=0; $i<$cp_size; $i++) {
            $cPath_new .= '_' . $cPath_array[$i];
          }
        }
        $cPath_new .= '_' . $current_category_id;

        if (substr($cPath_new, 0, 1) == '_') {
          $cPath_new = substr($cPath_new, 1);
        }
      }
    } else {
      $cPath_new = implode('_', $cPath_array);
    }

    return 'cPath=' . $cPath_new;
  }

////
// Returns the clients browser
  function smn_browser_detect($component) {
    global $HTTP_USER_AGENT;

    return stristr($HTTP_USER_AGENT, $component);
  }

////
// Alias function to smn_get_countries()
  function smn_get_country_name($country_id) {
    $country_array = smn_get_countries($country_id);

    return $country_array['countries_name'];
  }

////
// Returns the zone (State/Province) name
// TABLES: zones
  function smn_get_zone_name($country_id, $zone_id, $default_zone) {
    $zone_query = smn_db_query("select zone_name from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country_id . "' and zone_id = '" . (int)$zone_id . "'");
    if (smn_db_num_rows($zone_query)) {
      $zone = smn_db_fetch_array($zone_query);
      return $zone['zone_name'];
    } else {
      return $default_zone;
    }
  }

////
// Returns the zone (State/Province) code
// TABLES: zones
  function smn_get_zone_code($country_id, $zone_id, $default_zone) {
    $zone_query = smn_db_query("select zone_code from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country_id . "' and zone_id = '" . (int)$zone_id . "'");
    if (smn_db_num_rows($zone_query)) {
      $zone = smn_db_fetch_array($zone_query);
      return $zone['zone_code'];
    } else {
      return $default_zone;
    }
  }

////
// Wrapper function for round()
  function smn_round($number, $precision) {
    if (strpos($number, '.') && (strlen(substr($number, strpos($number, '.')+1)) > $precision)) {
      $number = substr($number, 0, strpos($number, '.') + 1 + $precision + 1);

      if (substr($number, -1) >= 5) {
        if ($precision > 1) {
          $number = substr($number, 0, -1) + ('0.' . str_repeat(0, $precision-1) . '1');
        } elseif ($precision == 1) {
          $number = substr($number, 0, -1) + 0.1;
        } else {
          $number = substr($number, 0, -1) + 1;
        }
      } else {
        $number = substr($number, 0, -1);
      }
    }

    return $number;
  }

////
// Returns the tax rate for a zone / class
// TABLES: tax_rates, zones_to_geo_zones
  function smn_get_tax_rate($class_id, $country_id = -1, $zone_id = -1, $use_store_id = '') {
    global $customer_zone_id, $customer_country_id, $store_id, $store;
    if ($use_store_id == ''){$use_store_id = (int)$store_id ;}
    
    if ( ($country_id == -1) && ($zone_id == -1) ) {
      if (!smn_session_is_registered('customer_id')) {
        $country_id = $store->get_store_country();
        $zone_id = $store->get_store_zone();
      } else {
        $country_id = $customer_country_id;
        $zone_id = $customer_zone_id;
      }
    }
    $tax_query = smn_db_query("select sum(tax_rate) as tax_rate from " . TABLE_TAX_RATES . " tr left join " . TABLE_ZONES_TO_GEO_ZONES . " za on (tr.tax_zone_id = za.geo_zone_id ) left join " . TABLE_GEO_ZONES . " tz on (tz.geo_zone_id = tr.tax_zone_id) where (za.zone_country_id is null or za.zone_country_id = '0' or za.zone_country_id = '" . (int)$country_id . "') and (za.zone_id is null or za.zone_id = '0' or za.zone_id = '" . (int)$zone_id . "') and tr.tax_class_id = '" . (int)$class_id . "' and tr.store_id = ' " . $use_store_id . "' and za.store_id = ' " . $use_store_id . "' group by tr.tax_priority");
    if (smn_db_num_rows($tax_query)) {

      $tax_multiplier = 1.0;
      while ($tax = smn_db_fetch_array($tax_query)) {
        $tax_multiplier *= 1.0 + ($tax['tax_rate'] / 100);
      }
      return ($tax_multiplier - 1.0) * 100;
    } else {
      return 0;
    }
  }

////
// Return the tax description for a zone / class
// TABLES: tax_rates;
  function smn_get_tax_description($class_id, $country_id, $zone_id, $use_store_id = '') {
    global $store_id;
    
    if ($use_store_id == ''){$use_store_id = (int)$store_id ;}
    
    $tax_query = smn_db_query("select tax_description from " . TABLE_TAX_RATES . " tr left join " . TABLE_ZONES_TO_GEO_ZONES . " za on (tr.tax_zone_id = za.geo_zone_id) left join " . TABLE_GEO_ZONES . " tz on (tz.geo_zone_id = tr.tax_zone_id ) where (za.zone_country_id is null or za.zone_country_id = '0' or za.zone_country_id = '" . (int)$country_id . "') and (za.zone_id is null or za.zone_id = '0' or za.zone_id = '" . (int)$zone_id . "') and tr.tax_class_id = '" . (int)$class_id . "' and tr.store_id = ' " . $use_store_id . "' and za.store_id = ' " . $use_store_id . "' order by tr.tax_priority");
    if (smn_db_num_rows($tax_query)) {
      $tax_description = '';
      while ($tax = smn_db_fetch_array($tax_query)) {
        $tax_description .= $tax['tax_description'] . ' + ';
      }
      $tax_description = substr($tax_description, 0, -3);

      return $tax_description;
    } else {
      return TEXT_UNKNOWN_TAX_RATE;
    }
  }

////
// Add tax to a products price
  function smn_add_tax($price, $tax) {

    if ( (DISPLAY_PRICE_WITH_TAX == 'true') && ($tax > 0) ) {
      return $price + smn_calculate_tax($price, $tax);
    } else {
      return $price;
    }
  }

// Calculates Tax rounding the result
  function smn_calculate_tax($price, $tax) {
    global $currencies;

    return $price * $tax / 100;
  }

////
// Return the number of products in a category
// TABLES: products, products_to_categories, categories
  function smn_count_products_in_category($category_id, $include_inactive = false) {
    global $store_id;
    $products_count = 0;
    if ($include_inactive == true) {
      $products_query = smn_db_query("select count(*) as total from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p2c.store_id = '" . (int)$store_id  . "' and p.products_id = p2c.products_id and p2c.categories_id = '" . (int)$category_id . "'");
    } else {
      $products_query = smn_db_query("select count(*) as total from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where  p2c.store_id = '" . (int)$store_id  . "' and p.products_id = p2c.products_id and p.products_status = '1' and p2c.categories_id = '" . (int)$category_id . "'");
    }
    $products = smn_db_fetch_array($products_query);
    $products_count += $products['total'];

    $child_categories_query = smn_db_query("select categories_id from " . TABLE_CATEGORIES . " where parent_id = '" . (int)$category_id . "' and store_id = '" . (int)$store_id  . "'");
    if (smn_db_num_rows($child_categories_query)) {
      while ($child_categories = smn_db_fetch_array($child_categories_query)) {
        $products_count += smn_count_products_in_category($child_categories['categories_id'], $include_inactive);
      }
    }

    return $products_count;
  }

////
// Return true if the category has subcategories
// TABLES: categories
  function smn_has_category_subcategories($category_id) {
    global $store_id;
    $child_category_query = smn_db_query("select count(*) as count from " . TABLE_CATEGORIES . " where parent_id = '" . (int)$category_id . "' and store_id = '" .  (int)$store_id . "'");
    $child_category = smn_db_fetch_array($child_category_query);

    if ($child_category['count'] > 0) {
      return true;
    } else {
      return false;
    }
  }

////
// Returns the address_format_id for the given country
// TABLES: countries;
  function smn_get_address_format_id($country_id) {
    $address_format_query = smn_db_query("select address_format_id as format_id from " . TABLE_COUNTRIES . " where countries_id = '" . (int)$country_id . "'");
    if (smn_db_num_rows($address_format_query)) {
      $address_format = smn_db_fetch_array($address_format_query);
      return $address_format['format_id'];
    } else {
      return '1';
    }
  }

////
// Return a formatted address
// TABLES: address_format
  function smn_address_format($address_format_id, $address, $html, $boln, $eoln) {
    $address_format_query = smn_db_query("select address_format as format from " . TABLE_ADDRESS_FORMAT . " where address_format_id = '" . (int)$address_format_id . "'");
    $address_format = smn_db_fetch_array($address_format_query);

    $company = smn_output_string_protected($address['company']);
    if (isset($address['firstname']) && smn_not_null($address['firstname'])) {
      $firstname = smn_output_string_protected($address['firstname']);
      $lastname = smn_output_string_protected($address['lastname']);
    } elseif (isset($address['name']) && smn_not_null($address['name'])) {
      $firstname = smn_output_string_protected($address['name']);
      $lastname = '';
    } else {
      $firstname = '';
      $lastname = '';
    }
    $street = smn_output_string_protected($address['street_address']);
    $suburb = smn_output_string_protected($address['suburb']);
    $city = smn_output_string_protected($address['city']);
    $state = smn_output_string_protected($address['state']);
    if (isset($address['country_id']) && smn_not_null($address['country_id'])) {
      $country = smn_get_country_name($address['country_id']);

      if (isset($address['zone_id']) && smn_not_null($address['zone_id'])) {
        $state = smn_get_zone_code($address['country_id'], $address['zone_id'], $state);
      }
    } elseif (isset($address['country']) && smn_not_null($address['country'])) {
      $country = smn_output_string_protected($address['country']['title']);
    } else {
      $country = '';
    }
    $postcode = smn_output_string_protected($address['postcode']);
    $zip = $postcode;

    if ($html) {
// HTML Mode
      $HR = '<hr>';
      $hr = '<hr>';
      if ( ($boln == '') && ($eoln == "\n") ) { // Values not specified, use rational defaults
        $CR = '<br>';
        $cr = '<br>';
        $eoln = $cr;
      } else { // Use values supplied
        $CR = $eoln . $boln;
        $cr = $CR;
      }
    } else {
// Text Mode
      $CR = $eoln;
      $cr = $CR;
      $HR = '----------------------------------------';
      $hr = '----------------------------------------';
    }

    $statecomma = '';
    $streets = $street;
    if ($suburb != '') $streets = $street . $cr . $suburb;
    if ($country == '') $country = smn_output_string_protected($address['country']);
    if ($state != '') $statecomma = $state . ', ';
    $fmt = $address_format['format'];
    eval("\$address = \"$fmt\";");

    if ( (ACCOUNT_COMPANY == 'true') && (smn_not_null($company)) ) {
      $address = $company . $cr . $address;
    }

    return $address;
  }

////
// Return a formatted address
// TABLES: customers, address_book
  function smn_address_label($customers_id, $address_id = 1, $html = false, $boln = '', $eoln = "\n") {
    if (is_array($address_id) && !empty($address_id)) { 
      return smn_address_format($address_id['address_format_id'], $address_id, $html, $boln, $eoln); 
     } 

     $address_query = smn_db_query("select entry_firstname as firstname, entry_lastname as lastname, entry_company as company, entry_street_address as street_address, entry_city as city, entry_postcode as postcode, entry_state as state, entry_zone_id as zone_id, entry_country_id as country_id from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int)$customers_id . "' and address_book_id = '" . (int)$address_id . "'");
    $address = smn_db_fetch_array($address_query);

    $format_id = smn_get_address_format_id($address['country_id']);

    return smn_address_format($format_id, $address, $html, $boln, $eoln);
  }

  function smn_row_number_format($number) {
    if ( ($number < 10) && (substr($number, 0, 1) != '0') ) $number = '0' . $number;

    return $number;
  }


  function smn_get_categories($categories_array = '', $parent_id = '0', $indent = '') {
    global $languages_id, $store_id;

    if (!is_array($categories_array)) $categories_array = array();

    $categories_query = smn_db_query("select c.categories_id, cd.categories_name from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where parent_id = '" . (int)$parent_id . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' and cd.store_id = '" . (int)$store_id  . "' and c.store_id = '" . (int)$store_id  . "' order by sort_order, cd.categories_name");
    while ($categories = smn_db_fetch_array($categories_query)) {
      $categories_array[] = array('id' => $categories['categories_id'],
                                  'text' => $indent . $categories['categories_name']);

      if ($categories['categories_id'] != $parent_id) {
        $categories_array = smn_get_categories($categories_array, $categories['categories_id'], $indent . '&nbsp;&nbsp;');
      }
    }

    return $categories_array;
  }

  function smn_get_manufacturers($manufacturers_array = '') {
    if (!is_array($manufacturers_array)) $manufacturers_array = array();

    $manufacturers_query = smn_db_query("select manufacturers_id, manufacturers_name from " . TABLE_MANUFACTURERS . " order by manufacturers_name");
    while ($manufacturers = smn_db_fetch_array($manufacturers_query)) {
      $manufacturers_array[] = array('id' => $manufacturers['manufacturers_id'], 'text' => $manufacturers['manufacturers_name']);
    }

    return $manufacturers_array;
  }

////
// Return all subcategory IDs
// TABLES: categories
  function smn_get_subcategories(&$subcategories_array, $parent_id = 0) {
    global $store_id;
    $subcategories_query = smn_db_query("select categories_id from " . TABLE_CATEGORIES . " where parent_id = '" . (int)$parent_id . "' and store_id = '" . (int)$store_id  . "'");
    while ($subcategories = smn_db_fetch_array($subcategories_query)) {
      $subcategories_array[sizeof($subcategories_array)] = $subcategories['categories_id'];
      if ($subcategories['categories_id'] != $parent_id) {
        smn_get_subcategories($subcategories_array, $subcategories['categories_id']);
      }
    }
  }

// Output a raw date string in the selected locale date format
// $raw_date needs to be in this format: YYYY-MM-DD HH:MM:SS
  function smn_date_long($raw_date) {
    if ( ($raw_date == '0000-00-00 00:00:00') || ($raw_date == '') ) return false;

    $year = (int)substr($raw_date, 0, 4);
    $month = (int)substr($raw_date, 5, 2);
    $day = (int)substr($raw_date, 8, 2);
    $hour = (int)substr($raw_date, 11, 2);
    $minute = (int)substr($raw_date, 14, 2);
    $second = (int)substr($raw_date, 17, 2);

    return strftime(DATE_FORMAT_LONG, mktime($hour,$minute,$second,$month,$day,$year));
  }

////
// Output a raw date string in the selected locale date format
// $raw_date needs to be in this format: YYYY-MM-DD HH:MM:SS
// NOTE: Includes a workaround for dates before 01/01/1970 that fail on windows servers
  function smn_date_short($raw_date) {
    if ( ($raw_date == '0000-00-00 00:00:00') || empty($raw_date) ) return false;

    $year = substr($raw_date, 0, 4);
    $month = (int)substr($raw_date, 5, 2);
    $day = (int)substr($raw_date, 8, 2);
    $hour = (int)substr($raw_date, 11, 2);
    $minute = (int)substr($raw_date, 14, 2);
    $second = (int)substr($raw_date, 17, 2);

    if (@date('Y', mktime($hour, $minute, $second, $month, $day, $year)) == $year) {
      return date(DATE_FORMAT, mktime($hour, $minute, $second, $month, $day, $year));
    } else {
      return ereg_replace('2037' . '$', $year, date(DATE_FORMAT, mktime($hour, $minute, $second, $month, $day, 2037)));
    }
  }

////
// Parse search string into indivual objects
  function smn_parse_search_string($search_str = '', &$objects) {
    $search_str = trim(strtolower($search_str));

// Break up $search_str on whitespace; quoted string will be reconstructed later
    $pieces = split('[[:space:]]+', $search_str);
    $objects = array();
    $tmpstring = '';
    $flag = '';

    for ($k=0; $k<count($pieces); $k++) {
      while (substr($pieces[$k], 0, 1) == '(') {
        $objects[] = '(';
        if (strlen($pieces[$k]) > 1) {
          $pieces[$k] = substr($pieces[$k], 1);
        } else {
          $pieces[$k] = '';
        }
      }

      $post_objects = array();

      while (substr($pieces[$k], -1) == ')')  {
        $post_objects[] = ')';
        if (strlen($pieces[$k]) > 1) {
          $pieces[$k] = substr($pieces[$k], 0, -1);
        } else {
          $pieces[$k] = '';
        }
      }

// Check individual words

      if ( (substr($pieces[$k], -1) != '"') && (substr($pieces[$k], 0, 1) != '"') ) {
        $objects[] = trim($pieces[$k]);

        for ($j=0; $j<count($post_objects); $j++) {
          $objects[] = $post_objects[$j];
        }
      } else {
/* This means that the $piece is either the beginning or the end of a string.
   So, we'll slurp up the $pieces and stick them together until we get to the
   end of the string or run out of pieces.
*/

// Add this word to the $tmpstring, starting the $tmpstring
        $tmpstring = trim(ereg_replace('"', ' ', $pieces[$k]));

// Check for one possible exception to the rule. That there is a single quoted word.
        if (substr($pieces[$k], -1 ) == '"') {
// Turn the flag off for future iterations
          $flag = 'off';

          $objects[] = trim($pieces[$k]);

          for ($j=0; $j<count($post_objects); $j++) {
            $objects[] = $post_objects[$j];
          }

          unset($tmpstring);

// Stop looking for the end of the string and move onto the next word.
          continue;
        }

// Otherwise, turn on the flag to indicate no quotes have been found attached to this word in the string.
        $flag = 'on';

// Move on to the next word
        $k++;

// Keep reading until the end of the string as long as the $flag is on

        while ( ($flag == 'on') && ($k < count($pieces)) ) {
          while (substr($pieces[$k], -1) == ')') {
            $post_objects[] = ')';
            if (strlen($pieces[$k]) > 1) {
              $pieces[$k] = substr($pieces[$k], 0, -1);
            } else {
              $pieces[$k] = '';
            }
          }

// If the word doesn't end in double quotes, append it to the $tmpstring.
          if (substr($pieces[$k], -1) != '"') {
// Tack this word onto the current string entity
            $tmpstring .= ' ' . $pieces[$k];

// Move on to the next word
            $k++;
            continue;
          } else {
/* If the $piece ends in double quotes, strip the double quotes, tack the
   $piece onto the tail of the string, push the $tmpstring onto the $haves,
   kill the $tmpstring, turn the $flag "off", and return.
*/
            $tmpstring .= ' ' . trim(ereg_replace('"', ' ', $pieces[$k]));

// Push the $tmpstring onto the array of stuff to search for
            $objects[] = trim($tmpstring);

            for ($j=0; $j<count($post_objects); $j++) {
              $objects[] = $post_objects[$j];
            }

            unset($tmpstring);

// Turn off the flag to exit the loop
            $flag = 'off';
          }
        }
      }
    }

// add default logical operators if needed
    $temp = array();
    for($i=0; $i<(count($objects)-1); $i++) {
      $temp[] = $objects[$i];
      if ( ($objects[$i] != 'and') &&
           ($objects[$i] != 'or') &&
           ($objects[$i] != '(') &&
           ($objects[$i+1] != 'and') &&
           ($objects[$i+1] != 'or') &&
           ($objects[$i+1] != ')') ) {
        $temp[] = ADVANCED_SEARCH_DEFAULT_OPERATOR;
      }
    }
    $temp[] = $objects[$i];
    $objects = $temp;

    $keyword_count = 0;
    $operator_count = 0;
    $balance = 0;
    for($i=0; $i<count($objects); $i++) {
      if ($objects[$i] == '(') $balance --;
      if ($objects[$i] == ')') $balance ++;
      if ( ($objects[$i] == 'and') || ($objects[$i] == 'or') ) {
        $operator_count ++;
      } elseif ( ($objects[$i]) && ($objects[$i] != '(') && ($objects[$i] != ')') ) {
        $keyword_count ++;
      }
    }

    if ( ($operator_count < $keyword_count) && ($balance == 0) ) {
      return true;
    } else {
      return false;
    }
  }

////
// Check date
  function smn_checkdate($date_to_check, $format_string, &$date_array) {
    $separator_idx = -1;

    $separators = array('-', ' ', '/', '.');
    $month_abbr = array('jan','feb','mar','apr','may','jun','jul','aug','sep','oct','nov','dec');
    $no_of_days = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

    $format_string = strtolower($format_string);

    if (strlen($date_to_check) != strlen($format_string)) {
      return false;
    }

    $size = sizeof($separators);
    for ($i=0; $i<$size; $i++) {
      $pos_separator = strpos($date_to_check, $separators[$i]);
      if ($pos_separator != false) {
        $date_separator_idx = $i;
        break;
      }
    }

    for ($i=0; $i<$size; $i++) {
      $pos_separator = strpos($format_string, $separators[$i]);
      if ($pos_separator != false) {
        $format_separator_idx = $i;
        break;
      }
    }

    if ($date_separator_idx != $format_separator_idx) {
      return false;
    }

    if ($date_separator_idx != -1) {
      $format_string_array = explode( $separators[$date_separator_idx], $format_string );
      if (sizeof($format_string_array) != 3) {
        return false;
      }

      $date_to_check_array = explode( $separators[$date_separator_idx], $date_to_check );
      if (sizeof($date_to_check_array) != 3) {
        return false;
      }

      $size = sizeof($format_string_array);
      for ($i=0; $i<$size; $i++) {
        if ($format_string_array[$i] == 'mm' || $format_string_array[$i] == 'mmm') $month = $date_to_check_array[$i];
        if ($format_string_array[$i] == 'dd') $day = $date_to_check_array[$i];
        if ( ($format_string_array[$i] == 'yyyy') || ($format_string_array[$i] == 'aaaa') ) $year = $date_to_check_array[$i];
      }
    } else {
      if (strlen($format_string) == 8 || strlen($format_string) == 9) {
        $pos_month = strpos($format_string, 'mmm');
        if ($pos_month != false) {
          $month = substr( $date_to_check, $pos_month, 3 );
          $size = sizeof($month_abbr);
          for ($i=0; $i<$size; $i++) {
            if ($month == $month_abbr[$i]) {
              $month = $i;
              break;
            }
          }
        } else {
          $month = substr($date_to_check, strpos($format_string, 'mm'), 2);
        }
      } else {
        return false;
      }

      $day = substr($date_to_check, strpos($format_string, 'dd'), 2);
      $year = substr($date_to_check, strpos($format_string, 'yyyy'), 4);
    }

    if (strlen($year) != 4) {
      return false;
    }

    if (!settype($year, 'integer') || !settype($month, 'integer') || !settype($day, 'integer')) {
      return false;
    }

    if ($month > 12 || $month < 1) {
      return false;
    }

    if ($day < 1) {
      return false;
    }

    if (smn_is_leap_year($year)) {
      $no_of_days[1] = 29;
    }

    if ($day > $no_of_days[$month - 1]) {
      return false;
    }

    $date_array = array($year, $month, $day);

    return true;
  }

////
// Check if year is a leap year
  function smn_is_leap_year($year) {
    if ($year % 100 == 0) {
      if ($year % 400 == 0) return true;
    } else {
      if (($year % 4) == 0) return true;
    }

    return false;
  }

////
// Return table heading with sorting capabilities
  function smn_create_sort_heading($sortby, $colnum, $heading) {
    global $PHP_SELF;

    $sort_prefix = '';
    $sort_suffix = '';

    if ($sortby) {
      $sort_prefix = '<a href="' . smn_href_link(basename($PHP_SELF), smn_get_all_get_params(array('page', 'info', 'sort')) . 'page=1&sort=' . $colnum . ($sortby == $colnum . 'a' ? 'd' : 'a')) . '" title="' . smn_output_string(TEXT_SORT_PRODUCTS . ($sortby == $colnum . 'd' || substr($sortby, 0, 1) != $colnum ? TEXT_ASCENDINGLY : TEXT_DESCENDINGLY) . TEXT_BY . $heading) . '" class="productListing-heading">' ;
      $sort_suffix = (substr($sortby, 0, 1) == $colnum ? (substr($sortby, 1, 1) == 'a' ? '+' : '-') : '') . '</a>';
    }

    return $sort_prefix . $heading . $sort_suffix;
  }

////
// Recursively go through the categories and retreive all parent categories IDs
// TABLES: categories
  function smn_get_parent_categories(&$categories, $categories_id) {
    global $store_id;
    $parent_categories_query = smn_db_query("select parent_id from " . TABLE_CATEGORIES . " where categories_id = '" . (int)$categories_id . "' and store_id = '" . (int)$store_id  . "'");
    while ($parent_categories = smn_db_fetch_array($parent_categories_query)) {
      if ($parent_categories['parent_id'] == 0) return true;
      $categories[sizeof($categories)] = $parent_categories['parent_id'];
      if ($parent_categories['parent_id'] != $categories_id) {
        smn_get_parent_categories($categories, $parent_categories['parent_id']);
      }
    }
  }

////
// Construct a category path to the product
// TABLES: products_to_categories
  function smn_get_product_path($products_id) {
    global $store_id;
    
    $cPath = '';

    $category_query = smn_db_query("select p2c.categories_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p.products_id = '" . (int)$products_id . "' and p.products_status = '1'  and p2c.store_id = '" . (int)$store_id  . "' and p.products_id = p2c.products_id limit 1");
    if (smn_db_num_rows($category_query)) {
      $category = smn_db_fetch_array($category_query);

      $categories = array();
      smn_get_parent_categories($categories, $category['categories_id']);

      $categories = array_reverse($categories);

      $cPath = implode('_', $categories);

      if (smn_not_null($cPath)) $cPath .= '_';
      $cPath .= $category['categories_id'];
    }

    return $cPath;
  }

// systemsmanager begin - Dec 1, 2005 security patch		
/*
////
// Return a product ID with attributes
  function smn_get_uprid($prid, $params) {
    $uprid = $prid;
    if ( (is_array($params)) && (!strstr($prid, '{')) ) {
      while (list($option, $value) = each($params)) {
        $uprid = $uprid . '{' . $option . '}' . $value;
      }
    }

    return $uprid;
  }

////
// Return a product ID from a product ID with attributes
  function smn_get_prid($uprid) {
    $pieces = explode('{', $uprid);

    return $pieces[0];
  }
*/
function smn_get_uprid($prid, $params) {
  if (is_numeric($prid)) {
    $uprid = $prid;
 
    if (is_array($params) && (sizeof($params) > 0)) {
      $attributes_check = true;
      $attributes_ids = '';
 
      reset($params);
      while (list($option, $value) = each($params)) {
        if (is_numeric($option) && is_numeric($value)) {
          $attributes_ids .= '{' . (int)$option . '}' . (int)$value;
        } else {
          $attributes_check = false;
          break;
        }
      }
 
      if ($attributes_check == true) {
        $uprid .= $attributes_ids;
      }
    }
  } else {
    $uprid = smn_get_prid($prid);
 
    if (is_numeric($uprid)) {
      if (strpos($prid, '{') !== false) {
        $attributes_check = true;
        $attributes_ids = '';
 
// strpos()+1 to remove up to and including the first { which would create an empty array element in explode()
        $attributes = explode('{', substr($prid, strpos($prid, '{')+1));
 
        for ($i=0, $n=sizeof($attributes); $i<$n; $i++) {
          $pair = explode('}', $attributes[$i]);
 
          if (is_numeric($pair[0]) && is_numeric($pair[1])) {
            $attributes_ids .= '{' . (int)$pair[0] . '}' . (int)$pair[1];
          } else {
            $attributes_check = false;
            break;
          }
        }
 
        if ($attributes_check == true) {
          $uprid .= $attributes_ids;
        }
      }
    } else {
      return false;
    }
  }
 
  return $uprid;
}

function smn_get_prid($uprid) {
  $pieces = explode('{', $uprid);
 
  if (is_numeric($pieces[0])) {
    return $pieces[0];
  } else {
    return false;
  }
}

// systemsmanager end


////
// Return a customer greeting
  function smn_customer_greeting() {
    global $customer_id, $customer_first_name;

    if (smn_session_is_registered('customer_first_name') && smn_session_is_registered('customer_id')) {
      $greeting_string = sprintf(TEXT_GREETING_PERSONAL, smn_output_string_protected($customer_first_name), smn_href_link(FILENAME_PRODUCTS_NEW));
    } else {
      $greeting_string = sprintf(TEXT_GREETING_GUEST, smn_href_link(FILENAME_LOGIN, '', 'NONSSL'), smn_href_link(FILENAME_CREATE_ACCOUNT, '', 'NONSSL'));
    }

    return $greeting_string;
  }

////
//! Send email (text/html) using MIME
// This is the central mail function. The SMTP Server should be configured
// correct in php.ini
// Parameters:
// $to_name           The name of the recipient, e.g. "Jan Wildeboer"
// $to_email_address  The eMail address of the recipient,
//                    e.g. jan.wildeboer@gmx.de
// $email_subject     The subject of the eMail
// $email_text        The text of the eMail, may contain HTML entities
// $from_email_name   The name of the sender, e.g. Shop Administration
// $from_email_adress The eMail address of the sender,
//                    e.g. info@mysmnshop.com

  function smn_mail($to_name, $to_email_address, $email_subject, $email_text, $from_email_name, $from_email_address) {
    if (SEND_EMAILS != 'true') return false;
  
    //Remove any newline and anything after it on the header fields of the mail.
    //$to_email_address and $from_email_address are checked with smn_validate_email().
    $to_name = preg_replace('/[\n|\r].*/', '', $to_name);
    $email_subject = preg_replace('/[\n|\r].*/', '', $email_subject);
    $from_name = preg_replace('/[\n|\r].*/', '', $from_name);

    // Instantiate a new mail object
    $message = new email(array('X-Mailer: oscMall Mailer'));

    // Build the text version
    $text = strip_tags($email_text);
    if (EMAIL_USE_HTML == 'true') {
      $message->add_html($email_text, $text);
    } else {
      $message->add_text($text);
    }

    // Send message
    $message->build_message();
    $message->send($to_name, $to_email_address, $from_email_name, $from_email_address, $email_subject);
  }

////
// Check if product has attributes
  function smn_has_product_attributes($products_id) {
    global $store_id;
    $attributes_query = smn_db_query("select count(*) as count from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . (int)$products_id . "' and store_id = '" . (int)$store_id  . "'");
    $attributes = smn_db_fetch_array($attributes_query);

    if ($attributes['count'] > 0) {
      return true;
    } else {
      return false;
    }
  }

////
// Get the number of times a word/character is present in a string
  function smn_word_count($string, $needle) {
    $temp_array = split($needle, $string);

    return sizeof($temp_array);
  }

  function smn_count_modules($modules = '') {
    $count = 0;

    if (empty($modules)) return $count;

    $modules_array = split(';', $modules);

    for ($i=0, $n=sizeof($modules_array); $i<$n; $i++) {
      $class = substr($modules_array[$i], 0, strrpos($modules_array[$i], '.'));

      if (is_object($GLOBALS[$class])) {
        if ($GLOBALS[$class]->enabled) {
          $count++;
        }
      }
    }

    return $count;
  }

  function smn_count_payment_modules() {
    return smn_count_modules(MODULE_PAYMENT_INSTALLED);
  }

  function smn_count_shipping_modules() {
    return smn_count_modules(MODULE_SHIPPING_INSTALLED);
  }

  function smn_create_random_value($length, $type = 'mixed') {
    if ( ($type != 'mixed') && ($type != 'chars') && ($type != 'digits')) return false;

    $rand_value = '';
    while (strlen($rand_value) < $length) {
      if ($type == 'digits') {
        $char = smn_rand(0,9);
      } else {
        $char = chr(smn_rand(0,255));
      }
      if ($type == 'mixed') {
        if (eregi('^[a-z0-9]$', $char)) $rand_value .= $char;
      } elseif ($type == 'chars') {
        if (eregi('^[a-z]$', $char)) $rand_value .= $char;
      } elseif ($type == 'digits') {
        if (ereg('^[0-9]$', $char)) $rand_value .= $char;
      }
    }

    return $rand_value;
  }

  function smn_array_to_string($array, $exclude = '', $equals = '=', $separator = '&') {
    if (!is_array($exclude)) $exclude = array();

    $get_string = '';
    if (sizeof($array) > 0) {
      while (list($key, $value) = each($array)) {
        if ( (!in_array($key, $exclude)) && ($key != 'x') && ($key != 'y') ) {
          $get_string .= $key . $equals . $value . $separator;
        }
      }
      $remove_chars = strlen($separator);
      $get_string = substr($get_string, 0, -$remove_chars);
    }

    return $get_string;
  }

  function smn_not_null($value) {
    if (is_array($value)) {
      if (sizeof($value) > 0) {
        return true;
      } else {
        return false;
      }
    } else {
      if (($value != '') && (strtolower($value) != 'null') && (strlen(trim($value)) > 0)) {
        return true;
      } else {
        return false;
      }
    }
  }

////
// Output the tax percentage with optional padded decimals
  function smn_display_tax_value($value, $padding = TAX_DECIMAL_PLACES) {
    if (strpos($value, '.')) {
      $loop = true;
      while ($loop) {
        if (substr($value, -1) == '0') {
          $value = substr($value, 0, -1);
        } else {
          $loop = false;
          if (substr($value, -1) == '.') {
            $value = substr($value, 0, -1);
          }
        }
      }
    }

    if ($padding > 0) {
      if ($decimal_pos = strpos($value, '.')) {
        $decimals = strlen(substr($value, ($decimal_pos+1)));
        for ($i=$decimals; $i<$padding; $i++) {
          $value .= '0';
        }
      } else {
        $value .= '.';
        for ($i=0; $i<$padding; $i++) {
          $value .= '0';
        }
      }
    }

    return $value;
  }

////
// Checks to see if the currency code exists as a currency
// TABLES: currencies
function smn_currency_exists($code) {
   $code = smn_db_prepare_input($code);
   $currency_query = smn_db_query("select code from " . TABLE_CURRENCIES . " where code = '" . smn_db_input($code) . "' limit 1");
   if (smn_db_num_rows($currency_query)) {
     $currency = smn_db_fetch_array($currency_query);   
     return $currency['code'];
   } else {
     return false;
   }
 }

  function smn_string_to_int($string) {
    return (int)$string;
  }

////
// Parse and secure the cPath parameter values
  function smn_parse_category_path($cPath) {
// make sure the category IDs are integers
    $cPath_array = array_map('smn_string_to_int', explode('_', $cPath));

// make sure no duplicate category IDs exist which could lock the server in a loop
    $tmp_array = array();
    $n = sizeof($cPath_array);
    for ($i=0; $i<$n; $i++) {
      if (!in_array($cPath_array[$i], $tmp_array)) {
        $tmp_array[] = $cPath_array[$i];
      }
    }

    return $tmp_array;
  }

////
// Return a random value
  function smn_rand($min = null, $max = null) {
    static $seeded;

    if (!isset($seeded)) {
      mt_srand((double)microtime()*1000000);
      $seeded = true;
    }

    if (isset($min) && isset($max)) {
      if ($min >= $max) {
        return $min;
      } else {
        return mt_rand($min, $max);
      }
    } else {
      return mt_rand();
    }
  }

  function smn_setcookie($name, $value = '', $expire = 0, $path = '/', $domain = '', $secure = 0) {
    setcookie($name, $value, $expire, $path, (smn_not_null($domain) ? $domain : ''), $secure);
  }

  function smn_get_ip_address() {
    global $HTTP_SERVER_VARS;
    if (isset($HTTP_SERVER_VARS)) {
      if (isset($HTTP_SERVER_VARS['HTTP_X_FORWARDED_FOR'])) {
        $ip = $HTTP_SERVER_VARS['HTTP_X_FORWARDED_FOR'];
      } elseif (isset($HTTP_SERVER_VARS['HTTP_CLIENT_IP'])) {
        $ip = $HTTP_SERVER_VARS['HTTP_CLIENT_IP'];
      } else {
        $ip = $HTTP_SERVER_VARS['REMOTE_ADDR'];
      }
    } else {
      if (getenv('HTTP_X_FORWARDED_FOR')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
      } elseif (getenv('HTTP_CLIENT_IP')) {
        $ip = getenv('HTTP_CLIENT_IP');
      } else {
        $ip = getenv('REMOTE_ADDR');
      }
    }

    return $ip;
  }

  function smn_count_customer_orders($id = '', $check_session = true) {
    global $customer_id, $languages_id;

    if (is_numeric($id) == false) {
      if (smn_session_is_registered('customer_id')) {
        $id = $customer_id;
      } else {
        return 0;
      }
    }

    if ($check_session == true) {
      if ( (smn_session_is_registered('customer_id') == false) || ($id != $customer_id) ) {
        return 0;
      }
    }
    $orders_check_query = smn_db_query("select count(*) as total from " . TABLE_ORDERS . " o, " . TABLE_ORDERS_STATUS . " s where o.customers_id = '" . (int)$id . "' and o.orders_status = s.orders_status_id and s.language_id = '" . (int)$languages_id . "' and s.public_flag = '1'");
    $orders_check = smn_db_fetch_array($orders_check_query);

    return $orders_check['total'];
  }

  function smn_count_customer_address_book_entries($id = '', $check_session = true) {
    global $customer_id;

    if (is_numeric($id) == false) {
      if (smn_session_is_registered('customer_id')) {
        $id = $customer_id;
      } else {
        return 0;
      }
    }

    if ($check_session == true) {
      if ( (smn_session_is_registered('customer_id') == false) || ($id != $customer_id) ) {
        return 0;
      }
    }

    $addresses_query = smn_db_query("select count(*) as total from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int)$id . "'");
    $addresses = smn_db_fetch_array($addresses_query);

    return $addresses['total'];
  }

// nl2br() prior PHP 4.2.0 did not convert linefeeds on all OSs (it only converted \n)
  function smn_convert_linefeeds($from, $to, $string) {
    if ((PHP_VERSION < "4.0.5") && is_array($from)) {
      return ereg_replace('(' . implode('|', $from) . ')', $to, $string);
    } else {
      return str_replace($from, $to, $string);
    }
  }


  function affiliate_check_url($url) {
    return eregi("^https?://[a-z0-9]([-_.]?[a-z0-9])+[.][a-z0-9][a-z0-9/=?.&\~_-]+$",$url);
  }

  function affiliate_insert ($sql_data_array, $affiliate_parent = 0) {
    // LOCK TABLES
    smn_db_query("LOCK TABLES " . TABLE_AFFILIATE . " WRITE");
    if ($affiliate_parent > 0) {
      $affiliate_root_query = smn_db_query("select affiliate_root, affiliate_rgt, affiliate_lft from  " . TABLE_AFFILIATE . " where affiliate_id = '" . $affiliate_parent . "' ");
      // Check if we have a parent affiliate
      if ($affiliate_root_array = smn_db_fetch_array($affiliate_root_query)) {
        smn_db_query("update " . TABLE_AFFILIATE . " SET affiliate_lft = affiliate_lft + 2 WHERE affiliate_root  =  '" . $affiliate_root_array['affiliate_root'] . "' and  affiliate_lft > "  . $affiliate_root_array['affiliate_rgt'] . "  AND affiliate_rgt >= " . $affiliate_root_array['affiliate_rgt'] . " ");
        smn_db_query("update " . TABLE_AFFILIATE . " SET affiliate_rgt = affiliate_rgt + 2 WHERE affiliate_root  =  '" . $affiliate_root_array['affiliate_root'] . "' and  affiliate_rgt >= "  . $affiliate_root_array['affiliate_rgt'] . "  ");
      

        $sql_data_array['affiliate_root'] = $affiliate_root_array['affiliate_root'];
        $sql_data_array['affiliate_lft'] = $affiliate_root_array['affiliate_rgt'];
        $sql_data_array['affiliate_rgt'] = ($affiliate_root_array['affiliate_rgt'] + 1);
        smn_db_perform(TABLE_AFFILIATE, $sql_data_array);
        $affiliate_id = smn_db_insert_id();
      }
    // no parent -> new root
    } else {
      $sql_data_array['affiliate_lft'] = '1';
      $sql_data_array['affiliate_rgt'] = '2';
      smn_db_perform(TABLE_AFFILIATE, $sql_data_array);
      $affiliate_id = smn_db_insert_id();
      smn_db_query ("update " . TABLE_AFFILIATE . " set affiliate_root = '" . $affiliate_id . "' where affiliate_id = '" . $affiliate_id . "' ");
    }
    // UNLOCK TABLES
    smn_db_query("UNLOCK TABLES");
    return $affiliate_id;

  }

////
// Compatibility to older Snapshots
  if (!function_exists('smn_round')) {
    function smn_round($value, $precision) {
      if (PHP_VERSION < 4) {
        $exp = pow(10, $precision);
        return round($value * $exp) / $exp;
      } else {
        return round($value, $precision);
      }
    }
  }

////
// Return a random value
  if (!function_exists('smn_rand')) {
    function smn_rand($min = null, $max = null) {
      static $seeded;

      if (!isset($seeded)) {
        mt_srand((double)microtime()*1000000);
        $seeded = true;
      }

      if (isset($min) && isset($max)) {
        if ($min >= $max) {
          return $min;
        } else {
          return mt_rand($min, $max);
        }
      } else {
        return mt_rand();
      }
    }
  }
  
  
  function smn_get_main_categories($categories_array = '', $parent_id = '0', $indent = '') {
    global $languages_id;
    if (!is_array($categories_array)){
      $categories_array = array();
    }
    $categories_query = smn_db_query("select c.categories_id, cd.categories_name from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where parent_id = '" . (int)$parent_id . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' and cd.store_id = '1' and c.store_id = '1' order by sort_order, cd.categories_name");
    while ($categories = smn_db_fetch_array($categories_query)) {
      if (($categories['categories_id'] != $parent_id) && ($categories['categories_id'] != '1')) {
        $categories_array[] = array('id' => $categories['categories_id'],
                                    'text' => $indent . $categories['categories_name']);
                                    
        $categories_array = smn_get_main_categories($categories_array, $categories['categories_id'], $indent . '&nbsp;&nbsp;->');
      }
    }
    return $categories_array;
  }
  
  
 /*  function to allow for the stores logo to display where needed */
  function smn_info_image($image, $alt, $width = '', $height = '') {
  	global $store;
	
    if (smn_not_null($image) && (file_exists(DIR_FS_CATALOG_IMAGES . $image)) ) {
      $image = smn_image(DIR_WS_IMAGES . $image, $alt, $width, $height);
    } else {
      $image = '<h3>' . $store->get_store_name() . '</h3>';
    }
      return $image;
  }  


// systemsmanager begin   
  function smn_get_categories_extended($categories_array = '', $parent_id = '0', $indent = '') {
    global $store_id;
    global $languages_id;
	
    if (!is_array($categories_array)){
      $categories_array = array();
    }
	$sql = "select c.categories_id, cd.categories_name from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$parent_id . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' and cd.store_id = '1' and c.store_id = '1' order by sort_order, cd.categories_name";
	if ($store_id != 1) {
		$sql = "select c.categories_id, cd.categories_name from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$parent_id . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' and (cd.store_id = '1' or cd.store_id = '" . $store_id . "') and (c.store_id = '1' or c.store_id = '" . $store_id . "') order by sort_order, cd.categories_name";
	}
    $categories_query = smn_db_query($sql);
    while ($categories = smn_db_fetch_array($categories_query)) {
      if (($categories['categories_id'] != $parent_id) /* && ($categories['categories_id'] != '1') */) {
        $categories_array[] = array('id' => $categories['categories_id'],
                                    'text' => $indent . $categories['categories_name']);
                                    
        $categories_array = smn_get_categories_extended($categories_array, $categories['categories_id'], $indent . '&nbsp;&nbsp;->');
      }
    }
    return $categories_array;
  }
// systemsmanager end

  function create_coupon_code($salt="secret", $length = SECURITY_CODE_LENGTH) {
    $ccid = md5(uniqid("","salt"));
    $ccid .= md5(uniqid("","salt"));
    $ccid .= md5(uniqid("","salt"));
    $ccid .= md5(uniqid("","salt"));
    srand((double)microtime()*1000000); // seed the random number generator
    $random_start = @rand(0, (128-$length));
    $good_result = 0;
    while ($good_result == 0) {
      $id1=substr($ccid, $random_start,$length);        
      $query = smn_db_query("select coupon_code from " . TABLE_COUPONS . " where coupon_code = '" . $id1 . "'");    
      if (smn_db_num_rows($query) == 0) $good_result = 1;
    }
    return $id1;
  }
////
// Update the Customers GV account
  function smn_gv_account_update($customer_id, $gv_id) {
    $customer_gv_query = smn_db_query("select amount from " . TABLE_COUPON_GV_CUSTOMER . " where customer_id = '" . $customer_id . "'");
    $coupon_gv_query = smn_db_query("select coupon_amount from " . TABLE_COUPONS . " where coupon_id = '" . $gv_id . "'");
    $coupon_gv = smn_db_fetch_array($coupon_gv_query);
    if (smn_db_num_rows($customer_gv_query) > 0) {
      $customer_gv = smn_db_fetch_array($customer_gv_query);
      $new_gv_amount = $customer_gv['amount'] + $coupon_gv['coupon_amount'];
   // new code bugfix
   $gv_query = smn_db_query("update " . TABLE_COUPON_GV_CUSTOMER . " set amount = '" . $new_gv_amount . "' where customer_id = '" . $customer_id . "'");  
	 // original code $gv_query = smn_db_query("update " . TABLE_COUPON_GV_CUSTOMER . " set amount = '" . $new_gv_amount . "'");
    } else {
      $gv_query = smn_db_query("insert into " . TABLE_COUPON_GV_CUSTOMER . " (customer_id, amount) values ('" . $customer_id . "', '" . $coupon_gv['coupon_amount'] . "')");
    }
  }
////
// Get tax rate from tax description
  function smn_get_tax_rate_from_desc($tax_desc) {
    $tax_query = smn_db_query("select tax_rate from " . TABLE_TAX_RATES . " where tax_description = '" . $tax_desc . "'");
    $tax = smn_db_fetch_array($tax_query);
    return $tax['tax_rate'];
  }
  function smn_get_configuration_key_value($lookup) {
    global $store_id;    
    $configuration_query_raw = smn_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key='" . $lookup . "' and store_id = '" . $store_id . "'");
    $configuration_query = smn_db_fetch_array($configuration_query_raw);
    $lookup_value = $configuration_query['configuration_value'];
    return $lookup_value;
  }
/*Codes Added By Cimi*/
// To remove an order by a vendor
  function smn_remove_order($order_id, $restock = false) {
    if ($restock == 'on') {
      $order_query = smn_db_query("select products_id, products_quantity from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . (int)$order_id . "'");
      while ($order = smn_db_fetch_array($order_query)) {
        smn_db_query("update " . TABLE_PRODUCTS . " set products_quantity = products_quantity + " . $order['products_quantity'] . ", products_ordered = products_ordered - " . $order['products_quantity'] . " where products_id = '" . (int)$order['products_id'] . "'");
      }
    }

    smn_db_query("delete from " . TABLE_ORDERS . " where orders_id = '" . (int)$order_id . "'");
    smn_db_query("delete from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . (int)$order_id . "'");
    smn_db_query("delete from " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " where orders_id = '" . (int)$order_id . "'");
    smn_db_query("delete from " . TABLE_ORDERS_STATUS_HISTORY . " where orders_id = '" . (int)$order_id . "'");
    smn_db_query("delete from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . (int)$order_id . "'");
  }
// To get the category Tree  
  function smn_get_category_tree($parent_id = '0', $spacing = '', $exclude = '', $category_tree_array = '', $include_itself = false, $use_store_id = '') {
    global $languages_id, $store_id;
    
    if($use_store_id == ''){
      $use_store_id = $store_id;
    }
    
    if (!is_array($category_tree_array)) $category_tree_array = array();
    if ( (sizeof($category_tree_array) < 1) && ($exclude != '0') ) $category_tree_array[] = array('id' => '0', 'text' => TEXT_TOP);
    if ($include_itself) {
      $category_query = smn_db_query("select cd.categories_name from " . TABLE_CATEGORIES_DESCRIPTION . " cd where cd.store_id = '". $use_store_id . "' and cd.language_id = '" . (int)$languages_id . "' and cd.categories_id = '" . (int)$parent_id . "'");
      $category = smn_db_fetch_array($category_query);
      $category_tree_array[] = array('id' => $parent_id, 'text' => $category['categories_name']);
    }
    $categories_query = smn_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where  cd.store_id = '". $use_store_id . "' and  c.store_id = '". $use_store_id . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' and c.parent_id = '" . (int)$parent_id . "' order by c.sort_order, cd.categories_name");
    while ($categories = smn_db_fetch_array($categories_query)) {
      if ($exclude != $categories['categories_id']) $category_tree_array[] = array('id' => $categories['categories_id'], 'text' => $spacing . $categories['categories_name']);
      $category_tree_array = smn_get_category_tree($categories['categories_id'], $spacing . '&nbsp;&nbsp;&nbsp;', $exclude, $category_tree_array);
    }
    return $category_tree_array;
  }
 // To get the count of childs in a category
  function smn_childs_in_category_count($categories_id) {
    global $store_id;
    
    $categories_count = 0;

    $categories_query = smn_db_query("select categories_id from " . TABLE_CATEGORIES . " where parent_id = '" . (int)$categories_id . "' and store_id = '" . $store_id . "'");
    while ($categories = smn_db_fetch_array($categories_query)) {
      $categories_count++;
      $categories_count += smn_childs_in_category_count($categories['categories_id']);
    }

    return $categories_count;
  }
 // To get the count of products in a category
  function smn_products_in_category_count($categories_id, $include_deactivated = false) {
    global $store_id;
    $products_count = 0;

    if ($include_deactivated) {
      $products_query = smn_db_query("select count(*) as total from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where  p.store_id = '" . $store_id . "'  and p2c.store_id = '" . $store_id . "' and p.products_id = p2c.products_id and p2c.categories_id = '" . (int)$categories_id . "'");
    } else {
      $products_query = smn_db_query("select count(*) as total from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where  p.store_id = '" . $store_id . "'  and p2c.store_id = '" . $store_id . "' and p.products_id = p2c.products_id and p.products_status = '1' and p2c.categories_id = '" . (int)$categories_id . "'");
    }

    $products = smn_db_fetch_array($products_query);

    $products_count += $products['total'];

    $childs_query = smn_db_query("select categories_id from " . TABLE_CATEGORIES . " where parent_id = '" . (int)$categories_id . "' and store_id = '" . $store_id . "'");
    if (smn_db_num_rows($childs_query)) {
      while ($childs = smn_db_fetch_array($childs_query)) {
        $products_count += smn_products_in_category_count($childs['categories_id'], $include_deactivated);
      }
    }

    return $products_count;
  }
   // To get the category name
    function smn_get_category_name($category_id, $language_id) {
    global $store_id;
    
    $category_query = smn_db_query("select categories_name from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id = '" . (int)$category_id . "' and language_id = '" . (int)$language_id . "' and store_id = '" . $store_id . "'");
    $category = smn_db_fetch_array($category_query);

    return $category['categories_name'];
  }
   // To get the category descripiton
  function smn_get_category_description($category_id, $language_id) {
    global $store_id;
    
    $category_query = smn_db_query("select categories_description from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id = '" . (int)$category_id . "' and language_id = '" . (int)$language_id . "' and store_id = '" . $store_id . "'");
    $category = smn_db_fetch_array($category_query);

    return $category['categories_description'];
  }
  
  // To get all lanuages
  function smn_get_languages() {
    global $store_id;
    
      if (ALLOW_STORE_SITE_TEXT == 'true'){
        $use_store_id = $store_id;
      }else{
        $use_store_id = 1;
      }
    
    
    $languages_query = smn_db_query("select languages_id, name, code, image, directory from " . TABLE_LANGUAGES . " where store_id = '" . $use_store_id . "' order by sort_order");
    while ($languages = smn_db_fetch_array($languages_query)) {
      $languages_array[] = array('id' => $languages['languages_id'],
                                 'name' => $languages['name'],
                                 'code' => $languages['code'],
                                 'image' => $languages['image'],
                                 'directory' => $languages['directory']);
    }

    return $languages_array;
  }
// Sets timeout for the current script.
// Cant be used in safe mode.
  function smn_set_time_limit($limit) {
    if (!get_cfg_var('safe_mode')) {
      set_time_limit($limit);
    }
  }
  function smn_remove_category($category_id) {
    global $store_id;
    
    $category_image_query = smn_db_query("select categories_image from " . TABLE_CATEGORIES . " where categories_id = '" . (int)$category_id . "' and store_id = '" . $store_id . "'");
    $category_image = smn_db_fetch_array($category_image_query);

    $duplicate_image_query = smn_db_query("select count(*) as total from " . TABLE_CATEGORIES . " where categories_image = '" . smn_db_input($category_image['categories_image']) . "' and store_id = '" . $store_id . "'");
    $duplicate_image = smn_db_fetch_array($duplicate_image_query);

    if ($duplicate_image['total'] < 2) {
      if (file_exists(DIR_FS_CATALOG_IMAGES . $category_image['categories_image'])) {
        @unlink(DIR_FS_CATALOG_IMAGES . $category_image['categories_image']);
      }
    }

    smn_db_query("delete from " . TABLE_CATEGORIES . " where categories_id = '" . (int)$category_id . "' and store_id = '" . $store_id . "'");
    smn_db_query("delete from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id = '" . (int)$category_id . "' and store_id = '" . $store_id . "'");
    smn_db_query("delete from " . TABLE_PRODUCTS_TO_CATEGORIES . " where categories_id = '" . (int)$category_id . "' and store_id = '" . $store_id . "'");

    if (USE_CACHE == 'true') {
      smn_reset_cache_block('categories');
      smn_reset_cache_block('also_purchased');
    }
  }
  function smn_remove_product($product_id) {
    global $store_id;
    $product_image_query = smn_db_query("select products_image from " . TABLE_PRODUCTS . " where products_id = '" . (int)$product_id . "' and store_id = '" . $store_id . "'");
    $product_image = smn_db_fetch_array($product_image_query);

    $duplicate_image_query = smn_db_query("select count(*) as total from " . TABLE_PRODUCTS . " where products_image = '" . smn_db_input($product_image['products_image']) . "' and store_id = '" . $store_id . "'");
    $duplicate_image = smn_db_fetch_array($duplicate_image_query);

    if ($duplicate_image['total'] < 2) {
      if (file_exists(DIR_FS_CATALOG_IMAGES . $product_image['products_image'])) {
        @unlink(DIR_FS_CATALOG_IMAGES . $product_image['products_image']);
      }
    }

    smn_db_query("delete from " . TABLE_SPECIALS . " where products_id = '" . (int)$product_id . "' and store_id = '" . $store_id . "'");
    smn_db_query("delete from " . TABLE_PRODUCTS . " where products_id = '" . (int)$product_id . "' and store_id = '" . $store_id . "'");
    smn_db_query("delete from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . (int)$product_id . "' and store_id = '" . $store_id . "'");
    smn_db_query("delete from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . (int)$product_id . "'");
    smn_db_query("delete from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . (int)$product_id . "' and store_id = '" . $store_id . "'");
    smn_db_query("delete from " . TABLE_CUSTOMERS_BASKET . " where products_id = '" . (int)$product_id . "' and store_id = '" . $store_id . "'");
    smn_db_query("delete from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . " where products_id = '" . (int)$product_id . "' and store_id = '" . $store_id . "'");

    $product_reviews_query = smn_db_query("select reviews_id from " . TABLE_REVIEWS . " where products_id = '" . (int)$product_id . "'");
    while ($product_reviews = smn_db_fetch_array($product_reviews_query)) {
      smn_db_query("delete from " . TABLE_REVIEWS_DESCRIPTION . " where reviews_id = '" . (int)$product_reviews['reviews_id'] . "' and store_id = '" . $store_id . "'");
    }
    smn_db_query("delete from " . TABLE_REVIEWS . " where products_id = '" . (int)$product_id . "' and store_id = '" . $store_id . "'");

    if (USE_CACHE == 'true') {
      smn_reset_cache_block('categories');
      smn_reset_cache_block('also_purchased');
    }
  }
  function smn_get_generated_category_path_ids($id, $from = 'category') {
    $calculated_category_path_string = '';
    $calculated_category_path = smn_generate_category_path($id, $from);
    for ($i=0, $n=sizeof($calculated_category_path); $i<$n; $i++) {
      for ($j=0, $k=sizeof($calculated_category_path[$i]); $j<$k; $j++) {
        $calculated_category_path_string .= $calculated_category_path[$i][$j]['id'] . '_';
      }
      $calculated_category_path_string = substr($calculated_category_path_string, 0, -1) . '<br>';
    }
    $calculated_category_path_string = substr($calculated_category_path_string, 0, -4);

    if (strlen($calculated_category_path_string) < 1) $calculated_category_path_string = TEXT_TOP;

    return $calculated_category_path_string;
  }
  function smn_generate_category_path($id, $from = 'category', $categories_array = '', $index = 0) {
    global $languages_id, $store_id;

    if (!is_array($categories_array)) $categories_array = array();

    if ($from == 'product') {
      $categories_query = smn_db_query("select categories_id from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . (int)$id . "' and store_id = '" . $store_id . "'");
      while ($categories = smn_db_fetch_array($categories_query)) {
        if ($categories['categories_id'] == '0') {
          $categories_array[$index][] = array('id' => '0', 'text' => TEXT_TOP);
        } else {
          $category_query = smn_db_query("select cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = '" . (int)$categories['categories_id'] . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' and cd.store_id = '" . $store_id . "' and c.store_id = '" . $store_id . "'");
          $category = smn_db_fetch_array($category_query);
          $categories_array[$index][] = array('id' => $categories['categories_id'], 'text' => $category['categories_name']);
          if ( (smn_not_null($category['parent_id'])) && ($category['parent_id'] != '0') ) $categories_array = smn_generate_category_path($category['parent_id'], 'category', $categories_array, $index);
          $categories_array[$index] = array_reverse($categories_array[$index]);
        }
        $index++;
      }
    } elseif ($from == 'category') {
      $category_query = smn_db_query("select cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = '" . (int)$id . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' and c.store_id = '" . $store_id . "' and cd.store_id = '" . $store_id . "'");
      $category = smn_db_fetch_array($category_query);
      $categories_array[$index][] = array('id' => $id, 'text' => $category['categories_name']);
      if ( (smn_not_null($category['parent_id'])) && ($category['parent_id'] != '0') ) $categories_array = smn_generate_category_path($category['parent_id'], 'category', $categories_array, $index);
    }

    return $categories_array;
  }
// Returns the tax rate for a tax class
// TABLES: tax_rates
  function smn_get_tax_rate_value($class_id) {
    global $store_id;
    $tax_query = smn_db_query("select SUM(tax_rate) as tax_rate from " . TABLE_TAX_RATES . " where tax_class_id = '" . (int)$class_id . "' and store_id = '" . $store_id . "' group by tax_priority");
    if (smn_db_num_rows($tax_query)) {
      $tax_multiplier = 0;
      while ($tax = smn_db_fetch_array($tax_query)) {
        $tax_multiplier += $tax['tax_rate'];
      }
      return $tax_multiplier;
    } else {
      return 0;
    }
  }

  function smn_output_generated_category_path($id, $from = 'category') {
    $calculated_category_path_string = '';
    $calculated_category_path = smn_generate_category_path($id, $from);
    for ($i=0, $n=sizeof($calculated_category_path); $i<$n; $i++) {
      for ($j=0, $k=sizeof($calculated_category_path[$i]); $j<$k; $j++) {
        $calculated_category_path_string .= $calculated_category_path[$i][$j]['text'] . '&nbsp;&gt;&nbsp;';
      }
      $calculated_category_path_string = substr($calculated_category_path_string, 0, -16) . '<br>';
    }
    $calculated_category_path_string = substr($calculated_category_path_string, 0, -4);

    if (strlen($calculated_category_path_string) < 1) $calculated_category_path_string = TEXT_TOP;

    return $calculated_category_path_string;
  }
  function smn_get_products_description($product_id, $language_id) {
    $product_query = smn_db_query("select products_description from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . (int)$product_id . "' and language_id = '" . (int)$language_id . "'");
    $product = smn_db_fetch_array($product_query);

    return $product['products_description'];
  }
  function smn_get_products_head_title_tag($product_id, $language_id) {
    $product_query = smn_db_query("select products_head_title_tag from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . (int)$product_id . "' and language_id = '" . (int)$language_id . "'");
    $product = smn_db_fetch_array($product_query);

    return $product['products_head_title_tag'];
  }

  function smn_get_products_head_desc_tag($product_id, $language_id) {
    $product_query = smn_db_query("select products_head_desc_tag from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . (int)$product_id . "' and language_id = '" . (int)$language_id . "'");
    $product = smn_db_fetch_array($product_query);

    return $product['products_head_desc_tag'];
  }

  function smn_get_products_head_keywords_tag($product_id, $language_id) {
    $product_query = smn_db_query("select products_head_keywords_tag from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . (int)$product_id . "' and language_id = '" . (int)$language_id . "'");
    $product = smn_db_fetch_array($product_query);

    return $product['products_head_keywords_tag'];
  }
  function smn_get_products_url($product_id, $language_id) {
    $product_query = smn_db_query("select products_url from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . (int)$product_id . "' and language_id = '" . (int)$language_id . "'");
    $product = smn_db_fetch_array($product_query);

    return $product['products_url'];
  }
  
// Sets the status of a product
  function smn_set_product_status($products_id, $status) {
    if ($status == '1') {
      return smn_db_query("update " . TABLE_PRODUCTS . " set products_status = '1', products_last_modified = now() where products_id = '" . (int)$products_id . "'");
    } elseif ($status == '0') {
      return smn_db_query("update " . TABLE_PRODUCTS . " set products_status = '0', products_last_modified = now() where products_id = '" . (int)$products_id . "'");
    } else {
      return -1;
    }
  }
// Get list of address_format_id's
  function smn_get_address_formats() {
    $address_format_query = smn_db_query("select address_format_id from " . TABLE_ADDRESS_FORMAT . " order by address_format_id");
    $address_format_array = array();
    while ($address_format_values = smn_db_fetch_array($address_format_query)) {
      $address_format_array[] = array('id' => $address_format_values['address_format_id'],
                                      'text' => $address_format_values['address_format_id']);
    }
    return $address_format_array;
  }
  function smn_get_countries_drop_down($default = '') {
    $countries_array = array();
    if ($default) {
      $countries_array[] = array('id' => '',
                                 'text' => $default);
    }
    $countries_query = smn_db_query("select countries_id, countries_name from " . TABLE_COUNTRIES . " order by countries_name");
    while ($countries = smn_db_fetch_array($countries_query)) {
      $countries_array[] = array('id' => $countries['countries_id'],
                                 'text' => $countries['countries_name']);
    }

    return $countries_array;
  }
  function smn_prepare_country_zones_pull_down($country_id = '') {
// preset the width of the drop-down for Netscape
    $pre = '';
    if ( (!smn_browser_detect('MSIE')) && (smn_browser_detect('Mozilla/4')) ) {
      for ($i=0; $i<45; $i++) $pre .= '&nbsp;';
    }

    $zones = smn_get_country_zones($country_id);

    if (sizeof($zones) > 0) {
      $zones_select = array(array('id' => '', 'text' => PLEASE_SELECT));
      $zones = array_merge($zones_select, $zones);
    } else {
      $zones = array(array('id' => '', 'text' => TYPE_BELOW));
// create dummy options for Netscape to preset the height of the drop-down
      if ( (!smn_browser_detect('MSIE')) && (smn_browser_detect('Mozilla/4')) ) {
        for ($i=0; $i<9; $i++) {
          $zones[] = array('id' => '', 'text' => $pre);
        }
      }
    }

    return $zones;
  }

// return an array with country zones
  function smn_get_country_zones($country_id) {
    $zones_array = array();
    $zones_query = smn_db_query("select zone_id, zone_name from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country_id . "' order by zone_name");
    while ($zones = smn_db_fetch_array($zones_query)) {
      $zones_array[] = array('id' => $zones['zone_id'],
                             'text' => $zones['zone_name']);
    }

    return $zones_array;
  }
  function smn_tax_classes_pull_down($parameters, $selected = '') {
    global $store_id;
    
    $select_string = '<select ' . $parameters . '>';
    $classes_query = smn_db_query("select tax_class_id, tax_class_title from " . TABLE_TAX_CLASS . "  where store_id = '" . $store_id . "' order by tax_class_title");
    while ($classes = smn_db_fetch_array($classes_query)) {
      $select_string .= '<option value="' . $classes['tax_class_id'] . '"';
      if ($selected == $classes['tax_class_id']) $select_string .= ' SELECTED';
      $select_string .= '>' . $classes['tax_class_title'] . '</option>';
    }
    $select_string .= '</select>';

    return $select_string;
  }
    function smn_geo_zones_pull_down($parameters, $selected = '') {
    global $store_id;
    $select_string = '<select ' . $parameters . '>';
    $zones_query = smn_db_query("select geo_zone_id, geo_zone_name from " . TABLE_GEO_ZONES . "  where store_id = '" . $store_id . "' order by geo_zone_name");
    while ($zones = smn_db_fetch_array($zones_query)) {
      $select_string .= '<option value="' . $zones['geo_zone_id'] . '"';
      if ($selected == $zones['geo_zone_id']) $select_string .= ' SELECTED';
      $select_string .= '>' . $zones['geo_zone_name'] . '</option>';
    }
    $select_string .= '</select>';

    return $select_string;
  }

    /*End of codes added by Cimi*/
    
    function smn_get_stores_name($storeID){
      $Qstore = smn_db_query('select store_name from ' . TABLE_STORE_DESCRIPTION . ' where store_id = "' . $storeID . '"');
      $store = smn_db_fetch_array($Qstore);
     return $store['store_name'];
    }
  function smn_call_function($function, $parameter, $object = '') {
    if ($object == '') {
      return call_user_func($function, $parameter);
    } elseif (PHP_VERSION < 4) {
      return call_user_method($function, $object, $parameter);
    } else {
      return call_user_func(array($object, $function), $parameter);
    }
  }
  function smn_get_zone_class_title($zone_class_id) {
    if ($zone_class_id == '0') {
      return TEXT_NONE;
    } else {
      $classes_query = smn_db_query("select geo_zone_name from " . TABLE_GEO_ZONES . " where geo_zone_id = '" . (int)$zone_class_id . "'");
      $classes = smn_db_fetch_array($classes_query);

      return $classes['geo_zone_name'];
    }
  }
  function smn_get_order_status_name($order_status_id, $language_id = '') {
    global $languages_id;

    if ($order_status_id < 1) return TEXT_DEFAULT;

    if (!is_numeric($language_id)) $language_id = $languages_id;

    $status_query = smn_db_query("select orders_status_name from " . TABLE_ORDERS_STATUS . " where orders_status_id = '" . (int)$order_status_id . "' and language_id = '" . (int)$language_id . "'");
    $status = smn_db_fetch_array($status_query);

    return $status['orders_status_name'];
  }
  function smn_cfg_pull_down_order_statuses($order_status_id, $key = '') {
    global $languages_id;

    $name = (($key) ? 'configuration[' . $key . ']' : 'configuration_value');

    $statuses_array = array(array('id' => '0', 'text' => TEXT_DEFAULT));
    $statuses_query = smn_db_query("select orders_status_id, orders_status_name from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "' order by orders_status_name");
    while ($statuses = smn_db_fetch_array($statuses_query)) {
      $statuses_array[] = array('id' => $statuses['orders_status_id'],
                                'text' => $statuses['orders_status_name']);
    }

    return smn_draw_pull_down_menu($name, $statuses_array, $order_status_id);
  }
  function smn_cfg_pull_down_zone_classes($zone_class_id, $key = '') {
    $name = (($key) ? 'configuration[' . $key . ']' : 'configuration_value');

    $zone_class_array = array(array('id' => '0', 'text' => TEXT_NONE));
    $zone_class_query = smn_db_query("select geo_zone_id, geo_zone_name from " . TABLE_GEO_ZONES . " order by geo_zone_name");
    while ($zone_class = smn_db_fetch_array($zone_class_query)) {
      $zone_class_array[] = array('id' => $zone_class['geo_zone_id'],
                                  'text' => $zone_class['geo_zone_name']);
    }

    return smn_draw_pull_down_menu($name, $zone_class_array, $zone_class_id);
  }
  function smn_cfg_pull_down_country_list($country_id) {
    return smn_draw_pull_down_menu('configuration_value', smn_get_countries(), $country_id);
  }

  function smn_cfg_pull_down_zone_list($zone_id) {
    return smn_draw_pull_down_menu('configuration_value', smn_get_country_zones(STORE_COUNTRY), $zone_id);
  }
  function smn_cfg_pull_down_store_list() {
    return smn_draw_pull_down_menu('store_types', smn_get_store_types());
  }

  function smn_pull_down_store_list($store_type = 1) {
    return smn_draw_pull_down_menu('admin_groups_store_types', smn_get_store_types(), $store_type);
  }
  function smn_cfg_pull_down_tax_classes($tax_class_id, $key = '') {
    global $store_id;
    
    $name = (($key) ? 'configuration[' . $key . ']' : 'configuration_value');

    $tax_class_array = array(array('id' => '0', 'text' => TEXT_NONE));
    $tax_class_query = smn_db_query("select tax_class_id, tax_class_title from " . TABLE_TAX_CLASS . "  where store_id = '" . $store_id . "'order by tax_class_title");
    while ($tax_class = smn_db_fetch_array($tax_class_query)) {
      $tax_class_array[] = array('id' => $tax_class['tax_class_id'],
                                 'text' => $tax_class['tax_class_title']);
    }

    return smn_draw_pull_down_menu($name, $tax_class_array, $tax_class_id);
  }

////
// Function to read in text area in admin
 function smn_cfg_textarea($text) {
    return smn_draw_textarea_field('configuration_value', false, 35, 5, $text);
  }

  function smn_cfg_get_zone_name($zone_id) {
    $zone_query = smn_db_query("select zone_name from " . TABLE_ZONES . " where zone_id = '" . (int)$zone_id . "'");

    if (!smn_db_num_rows($zone_query)) {
      return $zone_id;
    } else {
      $zone = smn_db_fetch_array($zone_query);
      return $zone['zone_name'];
    }
  }
////
// Alias function for Store configuration values in the Administration Tool
  function smn_cfg_select_option($select_array, $key_value, $key = '') {
    $string = '';

    for ($i=0, $n=sizeof($select_array); $i<$n; $i++) {
      $name = ((smn_not_null($key)) ? 'configuration[' . $key . ']' : 'configuration_value');

      $string .= '<br><input type="radio" name="' . $name . '" value="' . $select_array[$i] . '"';

      if ($key_value == $select_array[$i]) $string .= ' CHECKED';

      $string .= '> ' . $select_array[$i];
    }

    return $string;
  }

////
// Alias function for module configuration keys
  function smn_mod_select_option($select_array, $key_name, $key_value) {
    reset($select_array);
    while (list($key, $value) = each($select_array)) {
      if (is_int($key)) $key = $value;
      $string .= '<br><input type="radio" name="configuration[' . $key_name . ']" value="' . $key . '"';
      if ($key_value == $key) $string .= ' CHECKED';
      $string .= '> ' . $value;
    }

    return $string;
  }
  
   function smn_cfg_select_multioption($select_array, $key_value, $key = '') {
    for ($i=0; $i<sizeof($select_array); $i++) {
      $name = (($key) ? 'configuration[' . $key . '][]' : 'configuration_value');
      $string .= '<br><input type="checkbox" name="' . $name . '" value="' . $select_array[$i] . '"';
      $key_values = explode( ", ", $key_value);
      if ( in_array($select_array[$i], $key_values) ) $string .= ' CHECKED';
      $string .= '> ' . $select_array[$i];
    }
    $string .= '<input type="hidden" name="' . $name . '" value="--none--">';
    return $string;
  }
  
  function smn_get_mall_categories($categories_array = ''){
    global $languages_id;
      if (!is_array($categories_array)){
          $categories_array = array();
      }
      $store_categories_query = smn_db_query("select c.store_categories_id, cd.store_categories_name, c.store_parent_id from " . TABLE_STORE_CATEGORIES . " c, " . TABLE_STORE_CATEGORIES_DESCRIPTION . " cd where c.store_parent_id = '0' and c.store_categories_id = cd.store_categories_id and cd.language_id='" . (int)$languages_id ."' order by sort_order, cd.store_categories_name");
      while ($store_categories = smn_db_fetch_array($store_categories_query))  {
          $categories_array[] = array(
              'id'   => $store_categories['store_categories_id'],
              'text' => $store_categories['store_categories_name']
          );
      }
    return $categories_array;
  }
?>