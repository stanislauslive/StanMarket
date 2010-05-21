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

  class shoppingCart {
    var $contents, $total, $weight, $cartID, $content_type;

    function shoppingCart() {
      $this->reset();
    }

    function restore_contents() {
      global $customer_id, $gv_id, $REMOTE_ADDR;

      if (!smn_session_is_registered('customer_id')) return false;

// insert current cart contents in database
      if (is_array($this->contents)) {
        reset($this->contents);
        while (list($products_id, ) = each($this->contents)) {
          $qty = $this->contents[$products_id]['qty'];
          

           // store id is getting lost when a shopper add items, THEN logs in
          $ID = $this->get_store_id($products_id);
          //$ID = $this->contents[$products_id]['store_id'];^M

          
          $product_query = smn_db_query("select * from " . TABLE_CUSTOMERS_BASKET . " where customers_id = '" . (int)$customer_id . "' and products_id = '" . smn_db_input($products_id) . "'");
          if (!smn_db_num_rows($product_query)) {
            smn_db_query("insert into " . TABLE_CUSTOMERS_BASKET . " (customers_id, products_id, customers_basket_quantity, customers_basket_date_added, store_id) values ('" . (int)$customer_id . "', '" . smn_db_input($products_id) . "', '" . smn_db_input($qty) . "', '" . date('Ymd') . "', '" . smn_db_input($ID) . "')");
            if (isset($this->contents[$products_id]['attributes'])) {
              reset($this->contents[$products_id]['attributes']);
              while (list($option, $value) = each($this->contents[$products_id]['attributes'])) {
                smn_db_query("insert into " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . " (customers_id, products_id, products_options_id, products_options_value_id, store_id) values ('" . (int)$customer_id . "', '" . smn_db_input($products_id) . "', '" . (int)$option . "', '" . (int)$value . "', '" . smn_db_input($ID) . "')");
              }
            }
          } else {
            smn_db_query("update " . TABLE_CUSTOMERS_BASKET . " set customers_basket_quantity = '" . smn_db_input($qty) . "' where customers_id = '" . (int)$customer_id . "' and products_id = '" . smn_db_input($products_id) . "'");
          }
        }
        if (smn_session_is_registered('gv_id')) {
          $gv_query = smn_db_query("insert into  " . TABLE_COUPON_REDEEM_TRACK . " (coupon_id, customer_id, redeem_date, redeem_ip) values ('" . $gv_id . "', '" . (int)$customer_id . "', now(),'" . $REMOTE_ADDR . "')");
          $gv_update = smn_db_query("update " . TABLE_COUPONS . " set coupon_active = 'N' where coupon_id = '" . $gv_id . "'");
          smn_gv_account_update($customer_id, $gv_id);
          smn_session_unregister('gv_id');
        }
      }

// reset per-session cart contents, but not the database contents
      $this->reset(false);

      $products_query = smn_db_query("select products_id, store_id, customers_basket_quantity from " . TABLE_CUSTOMERS_BASKET . " where customers_id = '" . (int)$customer_id . "'");
      while ($products = smn_db_fetch_array($products_query)) {
        $this->contents[$products['products_id']] = array('qty' => $products['customers_basket_quantity'], 'store_id' => $products['store_id']);
// attributes
        $attributes_query = smn_db_query("select products_options_id, products_options_value_id from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . " where customers_id = '" . (int)$customer_id . "' and products_id = '" . smn_db_input($products['products_id']) . "'");
        while ($attributes = smn_db_fetch_array($attributes_query)) {
          $this->contents[$products['products_id']]['attributes'][$attributes['products_options_id']] = $attributes['products_options_value_id'];
        }
      }
      $this->cleanup();
    }
    function reset($reset_database = false) {
      global $customer_id;
      $this->contents = array();
      $this->total = 0;
      $this->weight = 0;
      $this->content_type = false;
      if (smn_session_is_registered('customer_id') && ($reset_database == true)) {
        smn_db_query("delete from " . TABLE_CUSTOMERS_BASKET . " where customers_id = '" . (int)$customer_id . "'");
        smn_db_query("delete from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . " where customers_id = '" . (int)$customer_id . "'");
      }
      unset($this->cartID);
      if (smn_session_is_registered('cartID')) smn_session_unregister('cartID');
    }
    
    function get_store_id($products_id) {
      $store_id = 1;
      $store_id_query = smn_db_query("select store_id from " . TABLE_PRODUCTS . " where products_id = '" . smn_db_input($products_id) . "' LIMIT 1");
      if (smn_db_num_rows($store_id_query) > 0) {
        while ($row = smn_db_fetch_array($store_id_query)) {
          $store_id = $row['store_id'];
        }
      }
      return $store_id;
    }
    
function add_cart($products_id, $qty = '1', $attributes = '', $notify = true) {
  global $new_products_id_in_cart, $customer_id;
  $products_id_string = smn_get_uprid($products_id, $attributes);
  $products_id = smn_get_prid($products_id_string);
  if (defined('MAX_QTY_IN_CART') && (MAX_QTY_IN_CART > 0) && ((int)$qty > MAX_QTY_IN_CART)) {
  	$qty = MAX_QTY_IN_CART;
  }
 
  $store_id = $this->get_store_id($products_id);
  if (is_numeric($products_id) && is_numeric($qty)) {
  
    $check_product_query = smn_db_query("select store_id, products_status from " . TABLE_PRODUCTS . " where products_id = '" . (int)$products_id . "'");
    $check_product = smn_db_fetch_array($check_product_query);
 
    if (($check_product !== false) && ($check_product['products_status'] == '1')) {
      if ($notify == true) {
        $new_products_id_in_cart = $products_id;
        smn_session_register('new_products_id_in_cart');
      }
      if ($this->in_cart($products_id_string)) {
        $this->update_quantity($products_id_string, $qty, $attributes, $check_product['store_id']);
      } else {
        $this->contents[$products_id_string] = array('qty' => (int)$qty, 'store_id' => $check_product['store_id']);
// insert into database
        if (smn_session_is_registered('customer_id')) smn_db_query("insert into " . TABLE_CUSTOMERS_BASKET . " (store_id, customers_id, products_id, customers_basket_quantity, customers_basket_date_added) values ('" . (int)$check_product['store_id'] . "', '" . (int)$customer_id . "', '" . smn_db_input($products_id_string) . "', '" . (int)$qty . "', '" . date('Ymd') . "')");
 
        if (is_array($attributes)) {
          reset($attributes);
          while (list($option, $value) = each($attributes)) {
            $this->contents[$products_id_string]['attributes'][$option] = $value;
// insert into database
            if (smn_session_is_registered('customer_id')) smn_db_query("insert into " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . " (customers_id, products_id, products_options_id, products_options_value_id) values ('" . (int)$customer_id . "', '" . smn_db_input($products_id_string) . "', '" . (int)$option . "', '" . (int)$value . "')");
          }
        }
      }
      $this->cleanup();
// assign a temporary unique ID to the order contents to prevent hack attempts during the checkout procedure
      $this->cartID = $this->generate_cart_id();
    }
  }
}

function update_quantity($products_id, $quantity = '', $attributes = '', $use_store_id = 1) {
  global $customer_id;
 
  $products_id_string = smn_get_uprid($products_id, $attributes);
  $products_id = smn_get_prid($products_id_string);
  if (defined('MAX_QTY_IN_CART') && (MAX_QTY_IN_CART > 0) && ((int)$quantity > MAX_QTY_IN_CART)) {
  	$quantity = MAX_QTY_IN_CART;
  }
 
  if (is_numeric($products_id) && isset($this->contents[$products_id_string]) && is_numeric($quantity)) {
    $this->contents[$products_id_string] = array('qty' => (int)$quantity, 'store_id' => (int)$use_store_id);
// update database
    if (smn_session_is_registered('customer_id')) smn_db_query("update " . TABLE_CUSTOMERS_BASKET . " set customers_basket_quantity = '" . (int)$quantity . "' where customers_id = '" . (int)$customer_id . "' and products_id = '" . smn_db_input($products_id_string) . "'");
 
    if (is_array($attributes)) {
      reset($attributes);
      while (list($option, $value) = each($attributes)) {
        $this->contents[$products_id_string]['attributes'][$option] = $value;
// update database
        if (smn_session_is_registered('customer_id')) smn_db_query("update " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . " set products_options_value_id = '" . (int)$value . "' where customers_id = '" . (int)$customer_id . "' and products_id = '" . smn_db_input($products_id_string) . "' and products_options_id = '" . (int)$option . "'");
      }
    }
  }
}

    function cleanup() {
      global $customer_id;

      reset($this->contents);
      while (list($key,) = each($this->contents)) {
        if ($this->contents[$key]['qty'] < 1) {
          unset($this->contents[$key]);
// remove from database
          if (smn_session_is_registered('customer_id')) {
            smn_db_query("delete from " . TABLE_CUSTOMERS_BASKET . " where customers_id = '" . (int)$customer_id . "' and products_id = '" . smn_db_input($key) . "'");
            smn_db_query("delete from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . " where customers_id = '" . (int)$customer_id . "' and products_id = '" . smn_db_input($key) . "'");
          }
        }
      }
    }

    function count_contents() {  // get total number of items in cart 
      $total_items = 0;
      
      if (is_array($this->contents)) {
        reset($this->contents);
        while (list($products_id, ) = each($this->contents)) {
          $total_items += $this->get_quantity($products_id);
        }
      }
      return $total_items;
    }

    function get_quantity($products_id) {
      
      if (is_array($products_id )) $products_id = $products_id[0];
      if (isset($this->contents[$products_id])) {
        return $this->contents[$products_id]['qty'];
      } else {
        return 0;
      }
    }

    function get_store_list() {
      global $customer_id;
      $this->store_list = array();
      if (smn_session_is_registered('customer_id')){
        $products_query = smn_db_query("select DISTINCT (store_id) from " . TABLE_CUSTOMERS_BASKET . " where customers_id = '" . (int)$customer_id . "'");
        while ($store_products = smn_db_fetch_array($products_query)) {
          $this->store_list[] = (int)$store_products['store_id'];
        }
      }elseif (is_array($this->contents)) {
        reset($this->contents);
        while (list($products_id, ) = each($this->contents)) {
          $products_query = smn_db_query("select store_id from " . TABLE_PRODUCTS . " where products_id = '" . (int)$products_id . "' LIMIT 1");
          $products = smn_db_fetch_array($products_query);
          if(!in_array((int)$products['store_id'], $this->store_list)){
          $this->store_list[] = (int)$products['store_id'];
          }
        } 
      }
      return $this->store_list;
    }

    function in_cart($products_id) {
      if (isset($this->contents[$products_id])) {
        return true;
      } else {
        return false;
      }
    }

    function remove($products_id) {
      global $customer_id;
      unset($this->contents[$products_id]);
// remove from database
      if (smn_session_is_registered('customer_id')) {
        smn_db_query("delete from " . TABLE_CUSTOMERS_BASKET . " where customers_id = '" . (int)$customer_id . "' and products_id = '" . smn_db_input($products_id) . "'");
        smn_db_query("delete from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . " where customers_id = '" . (int)$customer_id . "' and products_id = '" . smn_db_input($products_id) . "'");
      }

// assign a temporary unique ID to the order contents to prevent hack attempts during the checkout procedure
      $this->cartID = $this->generate_cart_id();
    }

    function remove_all() {
      $this->reset();
    }

    function get_product_id_list() {
      $product_id_list = '';
      if (is_array($this->contents)) {
        reset($this->contents);
        while (list($products_id, ) = each($this->contents)) {
          $product_id_list .= ', ' . $products_id;
        }
      }

      return substr($product_id_list, 2);
    }

    function calculate($store = '') {
      $this->total_virtual = 0;
      $this->total = 0;
      $this->weight = 0;
      if (!is_array($this->contents)) return 0;
      reset($this->contents);
      while (list($products_id, ) = each($this->contents)) {
        $qty = $this->contents[$products_id]['qty'];
// products price
        $product_query = smn_db_query("select products_model, products_tax_class_id, products_price, store_id, products_price, products_weight from " . TABLE_PRODUCTS . " where products_id = '" . (int)$products_id . "' LIMIT 1");
        if ($product = smn_db_fetch_array($product_query)) {
          $products_price = $product['products_price']; //SW Fix 9-17-2007 : Consider Special Price
          $products_tax = smn_get_tax_rate($product['products_tax_class_id']);
          $no_count = 1;
          $products_weight = $product['products_weight']; //SW Fix 10-1-2007 : Shipping Weight Fix
          $products_store_id = $product['store_id']; //SW Fix 10-1-2007 : Shipping Weight Fix
          if (ereg('^GIFT', $gv_result['products_model'])) {
            $no_count = 0;
          }
          $specials_query = smn_db_query("select specials_new_products_price from " . TABLE_SPECIALS . " where products_id = '" . (int)$products_id . "' and status = '1' and store_id = '" . (int) $product['store_id'] . "' LIMIT 1");
          if (smn_db_num_rows ($specials_query)) {
            $specials = smn_db_fetch_array($specials_query);
            $products_price = $specials['specials_new_products_price'];
          }
          if((isset($store)) && ($store != '')){
            if($products_store_id == $store){
              $this->total_virtual += smn_add_tax($products_price, $products_tax) * $qty * $no_count; //SW Fix 9-17-2007 : Consider Special Price
              $this->weight_virtual += ($qty * $products_weight) * $no_count;
              $this->total += smn_add_tax($products_price, $products_tax) * $qty; //SW Fix 9-17-2007 : Consider Special Price
              $this->weight += ($qty * $products_weight); //SW Fix 10-1-2007 : Shipping Weight Fix
            }
          }else{
          $this->total_virtual += smn_add_tax($products_price, $products_tax) * $qty * $no_count; //SW Fix 9-17-2007 : Consider Special Price
          $this->weight_virtual += ($qty * $products_weight) * $no_count; //SW Fix 10-1-2007 : Shipping Weight Fix
          $this->total += smn_add_tax($products_price, $products_tax) * $qty; //SW Fix 9-17-2007 : Consider Special Price
          $this->weight += ($qty * $products_weight); //SW Fix 10-1-2007 : Shipping Weight Fix
          }
        }

// attributes price
        if (isset($this->contents[$products_id]['attributes'])) {
          reset($this->contents[$products_id]['attributes']);
          while (list($option, $value) = each($this->contents[$products_id]['attributes'])) {
            $attribute_price_query = smn_db_query("select options_values_price, price_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . (int)$products_id . "' and options_id = '" . (int)$option . "' and store_id = '".$products_store_id."' and options_values_id = '" . (int)$value . "' LIMIT 1");
            $attribute_price = smn_db_fetch_array($attribute_price_query);
            if ($attribute_price['price_prefix'] == '+') {
              $this->total += $qty * smn_add_tax($attribute_price['options_values_price'], $products_tax);
            } else {
              $this->total -= $qty * smn_add_tax($attribute_price['options_values_price'], $products_tax);
            }
          }
        }
      }
    }

    function attributes_price($products_id) {

      $attributes_price = 0;

      if (isset($this->contents[$products_id]['attributes'])) {
        reset($this->contents[$products_id]['attributes']);
        while (list($option, $value) = each($this->contents[$products_id]['attributes'])) {
          $products_query = smn_db_query("select store_id from " . TABLE_PRODUCTS . " where products_id = '" . (int)$products_id . "' LIMIT 1");
          $products = smn_db_fetch_array($products_query);
          $products_store_id = $products['store_id'];
          $attribute_price_query = smn_db_query("select options_values_price, price_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . (int)$products_id . "' and options_id = '" . (int)$option . "' and options_values_id = '" . (int)$value . "' and store_id = '" . $products_store_id . "' LIMIT 1");
          $attribute_price = smn_db_fetch_array($attribute_price_query);
          if ($attribute_price['price_prefix'] == '+') {
            $attributes_price += $attribute_price['options_values_price'];
          } else {
            $attributes_price -= $attribute_price['options_values_price'];
          }
        }
      }

      return $attributes_price;
    }

    function get_products($use_store_id = '') {
      global $languages_id;
      if (!is_array($this->contents)){ return false;}

      $products_array = array();
      reset($this->contents);
      while (list($products_id, ) = each($this->contents)) {
        $products_id = smn_get_uprid($products_id, $attributes);
		 /* Changed the query to get products of specified store by Cimi on June 08,2007*/
		 
        /*$products_query = smn_db_query("select pd.products_name, p.products_model, p.products_image, p.products_price, p.products_weight, p.products_tax_class_id, p.store_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = '" . (int)$products_id . "' and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "' LIMIT 1");*/
        $products_query = smn_db_query("select pd.products_name, p.products_model, p.products_image, p.products_price, p.products_weight, p.products_tax_class_id, p.store_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = '" . (int)$products_id . "' and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "' and p.store_id='".(int)$use_store_id."' LIMIT 1");
        if ($products = smn_db_fetch_array($products_query)) {
          $products_price = $products['products_price']; 
          $specials_query = smn_db_query("select specials_new_products_price from " . TABLE_SPECIALS . " where products_id = '" . (int)$products_id . "' and status = '1' and store_id = '" . (int)$products['store_id'] . "' LIMIT 1");
          if (smn_db_num_rows($specials_query)) {
            $specials = smn_db_fetch_array($specials_query);
            $products_price = $specials['specials_new_products_price'];
          }           
          if(($use_store_id != '') &&  ($products['store_id'] == $use_store_id))  {
            $products_array[] = array('id' => $products_id,
                                      'store_id' => $products['store_id'],
                                      'name' => $products['products_name'],
                                      'model' => $products['products_model'],
                                      'image' => $products['products_image'],
                                      'price' => $products_price,
                                      'quantity' => $this->contents[$products_id]['qty'],
                                      'weight' => $products['products_weight'],
                                      'final_price' => ($products_price + $this->attributes_price($products_id)),
                                      'tax_class_id' => $products['products_tax_class_id'],
                                      'attributes' => (isset($this->contents[$products_id]['attributes']) ? $this->contents[$products_id]['attributes'] : ''));
          }elseif($store == ''){
            $products_array[] = array('id' => $products_id,
                                      'store_id' => $products['store_id'],
                                      'name' => $products['products_name'],
                                      'model' => $products['products_model'],
                                      'image' => $products['products_image'],
                                      'price' => $products_price,
                                      'quantity' => $this->contents[$products_id]['qty'],
                                      'weight' => $products['products_weight'],
                                      'final_price' => ($products_price + $this->attributes_price($products_id)),
                                      'tax_class_id' => $products['products_tax_class_id'],
                                      'attributes' => (isset($this->contents[$products_id]['attributes']) ? $this->contents[$products_id]['attributes'] : ''));
          }
        }
      }

      return $products_array;
    }

    function show_total($store = '') {
      $this->calculate($store);
      return $this->total;
    }

    function show_weight($store = '') {
      $this->calculate($store);
      return $this->weight;
    }

    function show_total_virtual() {
      $this->calculate();

      return $this->total_virtual;
    }

    function show_weight_virtual() {
      $this->calculate();

      return $this->weight_virtual;
    }
      
    function generate_cart_id($length = 5) {
      return smn_create_random_value($length, 'digits');
    }

    function get_content_type() {
      $this->content_type = false;

      if ( (DOWNLOAD_ENABLED == 'true') && ($this->count_contents() > 0) ) {
        reset($this->contents);
        while (list($products_id, ) = each($this->contents)) {
          if (isset($this->contents[$products_id]['attributes'])) {
            reset($this->contents[$products_id]['attributes']);
            while (list(, $value) = each($this->contents[$products_id]['attributes'])) {
              $products_query = smn_db_query("select store_id from " . TABLE_PRODUCTS . " where products_id = '" . (int)$products_id . "' LIMIT 1");
              $products = smn_db_fetch_array($products_query);
              $products_store_id = $products['store_id'];
              $virtual_check_query = smn_db_query("select count(*) as total from " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad where pad.store_id = '" . $products_store_id . "'  and pa.store_id = '" . $products_store_id . "' and pa.products_id = '" . (int)$products_id . "' and pa.options_values_id = '" . (int)$value . "' and pa.products_attributes_id = pad.products_attributes_id LIMIT 1");
              $virtual_check = smn_db_fetch_array($virtual_check_query);

              if ($virtual_check['total'] > 0) {
                switch ($this->content_type) {
                  case 'physical':
                    $this->content_type = 'mixed';

                    return $this->content_type;
                    break;
                  default:
                    $this->content_type = 'virtual';
                    break;
                }
              } else {
                switch ($this->content_type) {
                  case 'virtual':
                    $this->content_type = 'mixed';

                    return $this->content_type;
                    break;
                  default:
                    $this->content_type = 'physical';
                    break;
                }
              }
            }
          } elseif ($this->show_weight() == 0) {
            reset($this->contents);
            while (list($products_id, ) = each($this->contents)) {
              $virtual_check_query = smn_db_query("select products_weight from " . TABLE_PRODUCTS . " where products_id = '" . (int)$products_id . "' LIMIT 1");
              $virtual_check = smn_db_fetch_array($virtual_check_query);
              if ($virtual_check['products_weight'] == 0) {
                switch ($this->content_type) {
                  case 'physical':
                    $this->content_type = 'mixed';

                    return $this->content_type;
                    break;
                  default:
                    $this->content_type = 'virtual';
                    break;
                }
              } else {
                switch ($this->content_type) {
                  case 'virtual':
                    $this->content_type = 'mixed';

                    return $this->content_type;
                    break;
                  default:
                    $this->content_type = 'physical';
                    break;
                }
              }
            }
          } else {
            switch ($this->content_type) {
              case 'virtual':
                $this->content_type = 'mixed';

                return $this->content_type;
                break;
              default:
                $this->content_type = 'physical';
                break;
            }
          }
        }
      } else {
        $this->content_type = 'physical';
      }
      return $this->content_type;
    }


    function count_contents_virtual() {  // get total number of items in cart disregard gift vouchers
      $total_items = 0;
      if (is_array($this->contents)) {
        reset($this->contents);
        while (list($products_id, ) = each($this->contents)) {
          $no_count = false;
          $gv_query = smn_db_query("select products_model, products_weight from " . TABLE_PRODUCTS . " where products_id = '" . (int)$products_id . "' LIMIT 1");
          $gv_result = smn_db_fetch_array($gv_query);
          if (ereg('^GIFT', $gv_result['products_model'])) {
            $no_count=true;
          }
          if (NO_COUNT_ZERO_WEIGHT == 1) {
            if ($gv_result['products_weight']<=MINIMUM_WEIGHT) {
              $no_count=true;
            }
          }
          if (!$no_count) $total_items += $this->get_quantity($products_id);
        }
      }
      return $total_items;
    }

    function unserialize($broken) {
      for(reset($broken);$kv=each($broken);) {
        $key=$kv['key'];
        if (gettype($this->$key)!="user function")
        $this->$key=$kv['value'];
      }
    }
	/*Added the functions get_cart_store_country and get_cart_store_zip,By Cimi*/
  function get_cart_store_country($store_id){
  	$store_info_query = smn_db_query("select entry_country_id from " . TABLE_CUSTOMERS . " c, " . TABLE_ADDRESS_BOOK . " ab," . TABLE_STORE_MAIN . " s WHERE c.customers_id = s.customer_id and c.customers_id = ab.customers_id and c.customers_default_address_id = ab.address_book_id LIMIT 1");
	$store_info_array = smn_db_fetch_array($store_info_query);
	return $store_info_array['entry_country_id'];
  }
   function get_cart_store_zip($store_id){
  	$store_info_query = smn_db_query("select entry_postcode from " . TABLE_CUSTOMERS . " c, " . TABLE_ADDRESS_BOOK . " ab," . TABLE_STORE_MAIN . " s WHERE c.customers_id = s.customer_id and c.customers_id = ab.customers_id and c.customers_default_address_id = ab.address_book_id LIMIT 1");
	$store_info_array = smn_db_fetch_array($store_info_query);
	return $store_info_array['entry_postcode'];
  }
  }
?>
