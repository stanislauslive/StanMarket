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


    global $page_name;
    
// start the timer for the page parse time log
  define('PAGE_PARSE_START_TIME', microtime());

// set the level of error reporting
  error_reporting(E_ALL & ~E_NOTICE);
  if (function_exists('ini_get') && (ini_get('register_globals') == false) && (PHP_VERSION < 4.3) ) {
	exit('Server Requirement Error: register_globals is disabled in your PHP configuration. This can be enabled in your php.ini configuration file or in the .htaccess file in your catalog directory. Please use PHP 4.3+ if register_globals cannot be enabled on the server.');
  }

// include server parameters
  require('includes/configure.php');
/*Included the affiliate_configure.php,by Cimi*/
  require(DIR_WS_INCLUDES.'affiliate_configure.php');

// include the database functions
  require(DIR_WS_FUNCTIONS . 'database.php');

// make a connection to the database... now
  smn_db_connect() or die('Unable to connect to database server!');

//load these DB tables first as they are used before any function/class calls
        require(DIR_WS_INCLUDES . 'database_tables.php');
  
// need to get the store prefix before the definitions are set....

    require(DIR_WS_CLASSES . 'mall_setup.php');
    if (isset($_GET['ID'])){
      $store_id = (int)$_GET['ID'];
    }
    elseif (isset($_POST['ID'])){
      $store_id = (int)$_POST['ID'];
    }else{
      $store_id = 1;  
    }
	
    $store = new mall_setup($store_id);
    $store->set_store_parameters();

//set the store type to be used
  $store_type = $store->get_store_type();

//set store images and filename variables
  $store->set_store_variables($store_type);
  
// some code to solve compatibility issues
	require(DIR_WS_FUNCTIONS . 'compatibility.php');
	
// set the type of request (secure or not)
  $request_type = (getenv('HTTPS') == 'on') ? 'NONSSL' : 'NONSSL';

// set php_self in the local scope
  if (!isset($PHP_SELF)) $PHP_SELF = $_SERVER['PHP_SELF'];

  if ($request_type == 'NONSSL') {
    define('DIR_WS_CATALOG', DIR_WS_HTTP_CATALOG);
  } else {
    define('DIR_WS_CATALOG', DIR_WS_HTTPS_CATALOG);
  }

// if gzip_compression is enabled, start to buffer the output
  if ( (GZIP_COMPRESSION == 'true') && ($ext_zlib_loaded = extension_loaded('zlib')) && (PHP_VERSION >= '4') ) {
    if (($ini_zlib_output_compression = (int)ini_get('zlib.output_compression')) < 1) {
      if (PHP_VERSION >= '4.0.4') {
        ob_start('ob_gzhandler');
      } else {
        include(DIR_WS_FUNCTIONS . 'gzip_compression.php');
        ob_start();
        ob_implicit_flush();
      }
    } else {
      ini_set('zlib.output_compression_level', GZIP_LEVEL);
    }
  }

// set the HTTP GET parameters manually if search_engine_friendly_urls is enabled
  if (SEARCH_ENGINE_FRIENDLY_URLS == 'true') {
    if (strlen(getenv('PATH_INFO')) > 1) {
      $GET_array = array();
      $PHP_SELF = str_replace(getenv('PATH_INFO'), '', $PHP_SELF);
      $vars = explode('/', substr(getenv('PATH_INFO'), 1));
      for ($i=0, $n=sizeof($vars); $i<$n; $i++) {
        if (strpos($vars[$i], '[]')) {
          $GET_array[substr($vars[$i], 0, -2)][] = $vars[$i+1];
        } else {
          $_GET[$vars[$i]] = $vars[$i+1];
        }
        $i++;
      }

      if (sizeof($GET_array) > 0) {
        while (list($key, $value) = each($GET_array)) {
          $_GET[$key] = $value;
        }
      }
    }
  }

// define general functions used application-wide

  require(DIR_WS_FUNCTIONS . 'general.php');
  require(DIR_WS_FUNCTIONS . 'html_output.php');
  require(DIR_WS_FUNCTIONS . 'mall_setup.php');
// include shopping cart class

    require(DIR_WS_CLASSES . 'shopping_cart.php');

// set the cookie domain
  $cookie_domain = (($request_type == 'NONSSL') ? HTTP_COOKIE_DOMAIN : HTTPS_COOKIE_DOMAIN);
  $cookie_path = (($request_type == 'NONSSL') ? HTTP_COOKIE_PATH : HTTPS_COOKIE_PATH);

// include cache functions if enabled
  if (USE_CACHE == 'true') include(DIR_WS_FUNCTIONS . 'cache.php');

// include navigation history class
  require(DIR_WS_CLASSES . 'navigation_history.php');

// check if sessions are supported, otherwise use the php3 compatible session class
  if (!function_exists('session_start')) {
    define('PHP_SESSION_NAME', 'osCMall');
    define('PHP_SESSION_PATH', $cookie_path);
    define('PHP_SESSION_DOMAIN', $cookie_domain);
    define('PHP_SESSION_SAVE_PATH', SESSION_WRITE_DIRECTORY);

    include(DIR_WS_CLASSES . 'sessions.php');
  }

// define how the session functions will be used
  require(DIR_WS_FUNCTIONS . 'sessions.php');

// set the session name and save path
  smn_session_name('osCMall');
  smn_session_save_path(SESSION_WRITE_DIRECTORY);

// set the session cookie parameters
   if (function_exists('session_set_cookie_params')) {
    session_set_cookie_params(0, $cookie_path, $cookie_domain);
  } elseif (function_exists('ini_set')) {
    ini_set('session.cookie_lifetime', '0');
    ini_set('session.cookie_path', $cookie_path);
    ini_set('session.cookie_domain', $cookie_domain);
  }

// set the session ID if it exists
   if (isset($_POST[smn_session_name()])) {
     smn_session_id($_POST[smn_session_name()]);
   } elseif ( isset($_GET[smn_session_name()]) ) {
     smn_session_id($_GET[smn_session_name()]);
   }

// start the session
  $session_started = false;
  if (SESSION_FORCE_COOKIE_USE == 'True') {
    smn_setcookie('cookie_test', 'please_accept_for_session', time()+60*60*24*30, $cookie_path, $cookie_domain);

    if (isset($HTTP_COOKIE_VARS['cookie_test'])) {
      smn_session_start();
      $session_started = true;
    }
  } elseif (SESSION_BLOCK_SPIDERS == 'True') {
    $user_agent = strtolower(getenv('HTTP_USER_AGENT'));
    $spider_flag = false;

    if (smn_not_null($user_agent)) {
      $spiders = file(DIR_WS_INCLUDES . 'spiders.txt');

      for ($i=0, $n=sizeof($spiders); $i<$n; $i++) {
        if (smn_not_null($spiders[$i])) {
          if (is_integer(strpos($user_agent, trim($spiders[$i])))) {
            $spider_flag = true;
            break;
          }
        }
      }
    }

    if ($spider_flag == false) {
      smn_session_start();
      $session_started = true;
    }
  } else {
    smn_session_start();
    $session_started = true;
  }
  if ( ($session_started == true) && (PHP_VERSION >= 4.3) && function_exists('ini_get') && (ini_get('register_globals') == false) ) {
    extract($_SESSION, EXTR_OVERWRITE+EXTR_REFS);
  }

    if (!smn_session_is_registered ('store_registered'))
        smn_session_register('store_registered');
        $store_registered = $store->smn_set_store_status($store->get_store_status());
        
    if (!smn_session_is_registered ('store_name'))
        smn_session_register('store_name'); 
        $store_name = $store->get_store_name();
        
    if (!smn_session_is_registered ('store_id'))
        smn_session_register('store_id'); 
        $store_id = $store->get_store_id();
        
    if (!smn_session_is_registered ('store_type'))
        smn_session_register('store_type'); 
        $store_type = $store->get_store_type_name();
        
// set SID once, even if empty
  $SID = (defined('SID') ? SID : '');

// verify the ssl_session_id if the feature is enabled
  if ( ($request_type == 'NONSSL') && (SESSION_CHECK_SSL_SESSION_ID == 'True') && (ENABLE_SSL == true) && ($session_started == true) ) {
    $ssl_session_id = getenv('SSL_SESSION_ID');
    if (!smn_session_is_registered('SSL_SESSION_ID')) {
      $SESSION_SSL_ID = $ssl_session_id;
      smn_session_register('SESSION_SSL_ID');
    }

    if ($SESSION_SSL_ID != $ssl_session_id) {
      smn_session_destroy();
      smn_redirect(smn_href_link(FILENAME_SSL_CHECK));
    }
  }

// verify the browser user agent if the feature is enabled
  if (SESSION_CHECK_USER_AGENT == 'True') {
    $http_user_agent = getenv('HTTP_USER_AGENT');
    if (!smn_session_is_registered('SESSION_USER_AGENT')) {
      $SESSION_USER_AGENT = $http_user_agent;
      smn_session_register('SESSION_USER_AGENT');
    }

    if ($SESSION_USER_AGENT != $http_user_agent) {
      smn_session_destroy();
      smn_redirect(smn_href_link(FILENAME_LOGIN));
    }
  }

// verify the IP address if the feature is enabled
  if (SESSION_CHECK_IP_ADDRESS == 'True') {
    $ip_address = smn_get_ip_address();
    if (!smn_session_is_registered('SESSION_IP_ADDRESS')) {
      $SESSION_IP_ADDRESS = $ip_address;
      smn_session_register('SESSION_IP_ADDRESS');
    }

    if ($SESSION_IP_ADDRESS != $ip_address) {
      smn_session_destroy();
      smn_redirect(smn_href_link(FILENAME_LOGIN));
    }
  }

// create the shopping cart & fix the cart if necesary
  if (smn_session_is_registered('cart') && is_object($cart)) {

  } else {
    smn_session_register('cart');
    $cart = new shoppingCart;
  }

// include currencies class and create an instance
  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();


// set the language
  define('PROJECT_VERSION', 'oscMall ver 4.1');
  define('TITLE', MALL_NAME . ' : ' . $store_name);
  
  if (!smn_session_is_registered('language') || isset($_GET['language'])) {
    if (!smn_session_is_registered('language')) {
      smn_session_register('language');
      smn_session_register('languages_id');
    }

    include(DIR_WS_CLASSES . 'language.php');
    $lng = new language();

    if (isset($_GET['language']) && smn_not_null($_GET['language'])) {
      $lng->set_language($_GET['language']);
    } else {
      $lng->get_browser_language();
    }

    $language = $lng->language['directory'];
    $languages_id = $lng->language['id'];
  }

// include the language translations
  require(DIR_WS_LANGUAGES . $language . '.php');

// currency
  if (!smn_session_is_registered('currency') || isset($_GET['currency']) || ( (USE_DEFAULT_LANGUAGE_CURRENCY == 'true') && (LANGUAGE_CURRENCY != $currency) ) ) {
    if (!smn_session_is_registered('currency')) smn_session_register('currency');

  if (isset($_GET['currency']) && $currencies->is_set($_GET['currency'])) {
  	  $currency = $_GET['currency'];
    } else {
      $currency = (USE_DEFAULT_LANGUAGE_CURRENCY == 'true') ? LANGUAGE_CURRENCY : DEFAULT_CURRENCY;
    }
  }

// navigation history
  if (!smn_session_is_registered('navigation')) {
    smn_session_register('navigation');
    $navigation = new navigationHistory;
  }
  $navigation->add_current_page();

// Shopping cart actions
  if (isset($_GET['action'])) {
// redirect the customer to a friendly cookie-must-be-enabled page if cookies are disabled
    if ($session_started == false) {
      smn_redirect(smn_href_link(FILENAME_COOKIE_USAGE));
    }

    if (DISPLAY_CART == 'true') {
      $goto =  FILENAME_CHECKOUT_SELECT;
	  if(ALLOW_STORE_PAYMENT == 'true'){
      	$parameters = array('action', 'cPath', 'products_id', 'pid');
	  }else{
	    $parameters = array('action', 'cPath', 'products_id', 'pid','ID');
	  }
    } else {
      $goto = basename($PHP_SELF);
      if ($_GET['action'] == 'buy_now') {
        $parameters = array('action', 'pid', 'products_id');
      } else {
        $parameters = array('action', 'pid');
      }
    }
    switch ($_GET['action']) {
      // customer wants to update the product quantity in their shopping cart
      case 'update_product' : for ($i=0, $n=sizeof($_POST['products_id']); $i<$n; $i++) {
                                if (($store_registered) && (in_array($_POST['products_id'][$i], (is_array($_POST['cart_delete']) ? $_POST['cart_delete'] : array())))) {
                                  $cart->remove($_POST['products_id'][$i]);
                                } else {
                                  $attributes = ($_POST['id'][$_POST['products_id'][$i]]) ? $_POST['id'][$_POST['products_id'][$i]] : '';
                                  $cart->add_cart($_POST['products_id'][$i], $_POST['cart_quantity'][$i], $attributes, false);
                                }
                              }
                              smn_redirect(smn_href_link($goto, smn_get_all_get_params($parameters)));
                              break;
      // customer adds a product from the products page
      case 'add_product' :    if (($store_registered) && (isset($_POST['products_id']))) {
                                $cart->add_cart($_POST['products_id'], $cart->get_quantity(smn_get_prid(smn_get_uprid($_POST['products_id'], $_POST['id'])))+1, $_POST['id']);
                              }
                              smn_redirect(smn_href_link($goto, smn_get_all_get_params($parameters)));
                              break;
      // performed by the 'buy now' button in product listings and review page
      case 'buy_now' :        if (($store_registered) && (isset($_GET['products_id']))) {
                                if (smn_has_product_attributes($_GET['products_id'])) {
                                  smn_redirect(smn_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $_GET['products_id']));
                                } else {
                                  $cart->add_cart($_GET['products_id'], $cart->get_quantity($_GET['products_id'])+1);
                                }
                              }
                              smn_redirect(smn_href_link($goto, smn_get_all_get_params($parameters)));
                              break;
      case 'notify' :         if (($store_registered) && (smn_session_is_registered('customer_id'))) {
                                if (isset($_GET['products_id'])) {
                                  $notify = $set_product_id;
                                } elseif (isset($_GET['notify'])) {
                                  $notify = $_GET['notify'];
                                } elseif (isset($_POST['notify'])) {
                                  $notify = $_POST['notify'];
                                } else {
                                  smn_redirect(smn_href_link(basename($PHP_SELF), smn_get_all_get_params(array('action', 'notify'))));
                                }
                                if (!is_array($notify)) $notify = array($notify);
                                for ($i=0, $n=sizeof($notify); $i<$n; $i++) {
                                  $check_query = smn_db_query("select count(*) as count from " . TABLE_PRODUCTS_NOTIFICATIONS . " where products_id = '" . $notify[$i] . "' and customers_id = '" . $customer_id . "'");
                                  $check = smn_db_fetch_array($check_query);
                                  if ($check['count'] < 1) {
                                    smn_db_query("insert into " . TABLE_PRODUCTS_NOTIFICATIONS . " (store_id, products_id, customers_id, date_added) values ('" . $store_id . "', '" . $notify[$i] . "', '" . $customer_id . "', now())");
                                  }
                                }
                                smn_redirect(smn_href_link(basename($PHP_SELF), smn_get_all_get_params(array('action', 'notify'))));
                              } else {
                                $navigation->set_snapshot();
                                smn_redirect(smn_href_link(FILENAME_LOGIN, '', 'NONSSL'));
                              }
                              break;
      case 'notify_remove' :  if (($store_registered) && (smn_session_is_registered('customer_id')) && isset($_GET['products_id'])) {
                                $check_query = smn_db_query("select count(*) as count from " . TABLE_PRODUCTS_NOTIFICATIONS . " where products_id = '" . $set_product_id . "' and customers_id = '" . $customer_id . "'");
                                $check = smn_db_fetch_array($check_query);
                                if ($check['count'] > 0) {
                                  smn_db_query("delete from " . TABLE_PRODUCTS_NOTIFICATIONS . " where products_id = '" . $set_product_id . "' and customers_id = '" . $customer_id . "'");
                                }
                                smn_redirect(smn_href_link(basename($PHP_SELF), smn_get_all_get_params(array('action'))));
                              } else {
                                $navigation->set_snapshot();
                                smn_redirect(smn_href_link(FILENAME_LOGIN, '', 'NONSSL'));
                              }
                              break;
      case 'cust_order' :     if (($store_registered) && (smn_session_is_registered('customer_id') && isset($_GET['pid']))) {
                                if (smn_has_product_attributes($_GET['pid'])) {
                                  smn_redirect(smn_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $_GET['pid']));
                                } else {
                                  $cart->add_cart($_GET['pid'], $cart->get_quantity($_GET['pid'])+1);
                                }
                              }
                              smn_redirect(smn_href_link($goto, smn_get_all_get_params($parameters)));
                              break;
    }
  }

// infobox
  require(DIR_WS_CLASSES . 'boxes.php');

// include the who's online functions
  require(DIR_WS_FUNCTIONS . 'whos_online.php');
  smn_update_whos_online();

// split-page-results
  require(DIR_WS_CLASSES . 'split_page_results.php');

//set the layout for the the template system.....
  require(DIR_WS_CLASSES . 'template_setup.php');
  $store_layout = new template_setup;
  $store_layout->smn_set_template();

// auto activate and expire banners
  require(DIR_WS_FUNCTIONS . 'banner.php');
  smn_activate_banners();
  smn_expire_banners();

// auto expire special products
  require(DIR_WS_FUNCTIONS . 'specials.php');
  smn_expire_specials();

// calculate category path
  if (isset($_GET['cPath'])) {
    $cPath = $_GET['cPath'];
  } elseif (isset($_GET['products_id']) && !isset($_GET['manufacturers_id'])) {
    $cPath = smn_get_product_path($set_product_id);
  } else {
    $cPath = '';
  }

  if (smn_not_null($cPath)) {
    $cPath_array = smn_parse_category_path($cPath);
    $cPath = implode('_', $cPath_array);
    $current_category_id = $cPath_array[(sizeof($cPath_array)-1)];
  } else {
    $current_category_id = 0;
  }
  
  require(DIR_WS_CLASSES . 'spath_setup.php');
  $spath_setup = new spath_setup;
  
  // calculate store_category path
    $sPath = $spath_setup->smn_set_sPath($sPath);
    if (smn_not_null($sPath))
    $sPath_array = $spath_setup->smn_parse_store_category_path($sPath);
    $current_store_category_id = $spath_setup->smn_set_store_category_id($sPath);

// include the breadcrumb class and start the breadcrumb trail
  require(DIR_WS_CLASSES . 'breadcrumb.php');
  $breadcrumb = new breadcrumb;
  $breadcrumb->add(MALL_NAME, smn_href_link(FILENAME_DEFAULT, 'ID=1'));
  $breadcrumb->add($store->get_store_name(), smn_href_link(FILENAME_DEFAULT, 'ID=' . $store_id));

// add category names or the manufacturer name to the breadcrumb trail
  if (isset($cPath_array)) {
    for ($i=0, $n=sizeof($cPath_array); $i<$n; $i++) {
      $categories_query = smn_db_query("select categories_name from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id = '" . (int)$cPath_array[$i] . "' and language_id = '" . (int)$languages_id . "'");
      if (smn_db_num_rows($categories_query) > 0) {
        $categories = smn_db_fetch_array($categories_query);
        $breadcrumb->add($categories['categories_name'], smn_href_link(FILENAME_DEFAULT, 'cPath=' . implode('_', array_slice($cPath_array, 0, ($i+1)))));
      } else {
        break;
      }
    }
  } elseif (isset($_GET['manufacturers_id'])) {
    $manufacturers_query = smn_db_query("select manufacturers_name from " . TABLE_MANUFACTURERS . " where manufacturers_id = '" . (int)$_GET['manufacturers_id'] . "'");
    if (smn_db_num_rows($manufacturers_query)) {
      $manufacturers = smn_db_fetch_array($manufacturers_query);
      $breadcrumb->add($manufacturers['manufacturers_name'], smn_href_link(FILENAME_DEFAULT, 'manufacturers_id=' . $_GET['manufacturers_id']));
    }
  }
  
  $affiliate_clientdate = (date ("Y-m-d H:i:s"));
  $affiliate_clientbrowser = $_SERVER["HTTP_USER_AGENT"];
  $affiliate_clientip = $_SERVER["REMOTE_ADDR"];
  $affiliate_clientreferer = $_SERVER["HTTP_REFERER"];

  if (!$HTTP_SESSION_VARS['affiliate_ref']) {
    smn_session_register('affiliate_ref');
    smn_session_register('affiliate_clickthroughs_id');
    if (($_GET['ref'] || $_POST['ref'])) {
      if ($_GET['ref']) $affiliate_ref = $_GET['ref'];
      if ($_POST['ref']) $affiliate_ref = $_POST['ref'];
      if ($_GET['products_id']) $affiliate_products_id = $set_product_id;
      if ($_POST['products_id']) $affiliate_products_id = $_POST['products_id'];
      if ($_GET['affiliate_banner_id']) $affiliate_banner_id = $_GET['affiliate_banner_id'];
      if ($_POST['affiliate_banner_id']) $affiliate_banner_id = $_POST['affiliate_banner_id'];
      if (!$link_to) $link_to = "0";
      $sql_data_array = array('affiliate_id' => $affiliate_ref,
                              'affiliate_clientdate' => $affiliate_clientdate,
                              'affiliate_clientbrowser' => $affiliate_clientbrowser,
                              'affiliate_clientip' => $affiliate_clientip,
                              'affiliate_clientreferer' => $affiliate_clientreferer,
                              'affiliate_products_id' => $affiliate_products_id,
                              'affiliate_banner_id' => $affiliate_banner_id);
      smn_db_perform(TABLE_AFFILIATE_CLICKTHROUGHS, $sql_data_array);
      $affiliate_clickthroughs_id = smn_db_insert_id();
   // Banner has been clicked, update stats:
      if ($affiliate_banner_id && $affiliate_ref) {
        $today = date('Y-m-d');
        $sql = "select * from " . TABLE_AFFILIATE_BANNERS_HISTORY . " where affiliate_banners_id = '" . $affiliate_banner_id  . "' and  affiliate_banners_affiliate_id = '" . $affiliate_ref . "' and affiliate_banners_history_date = '" . $today . "'";
        $banner_stats_query = smn_db_query($sql);
     // Banner has been shown today
        if (smn_db_fetch_array($banner_stats_query)) {
        smn_db_query("update " . TABLE_AFFILIATE_BANNERS_HISTORY . " set affiliate_banners_clicks = affiliate_banners_clicks + 1 where affiliate_banners_id = '" . $affiliate_banner_id . "' and affiliate_banners_affiliate_id = '" . $affiliate_ref. "' and affiliate_banners_history_date = '" . $today . "'");
   // Initial entry if banner has not been shown
      } else {
        $sql_data_array = array('affiliate_banners_id' => $affiliate_banner_id,
                                'affiliate_banners_products_id' => $affiliate_products_id,
                                'affiliate_banners_affiliate_id' => $affiliate_ref,
                                'affiliate_banners_clicks' => '1',
                                'affiliate_banners_history_date' => $today);
        smn_db_perform(TABLE_AFFILIATE_BANNERS_HISTORY, $sql_data_array);
      }
    }
 // Set Cookie if the customer comes back and orders it counts
    setcookie('affiliate_ref', $affiliate_ref, time() + AFFILIATE_COOKIE_LIFETIME);
    }
    if ($HTTP_COOKIE_VARS['affiliate_ref']) { // Customer comes back and is registered in cookie
      $affiliate_ref = $HTTP_COOKIE_VARS['affiliate_ref'];
    }
  }
// add the products model to the breadcrumb trail
  if (isset($_GET['products_id'])) {
    $model_query = smn_db_query("select products_model from " . TABLE_PRODUCTS . " where products_id = '" . (int)$set_product_id . "'");
    if (smn_db_num_rows($model_query)) {
      $model = smn_db_fetch_array($model_query);
      $breadcrumb->add($model['products_model'], smn_href_link(FILENAME_PRODUCT_INFO, 'cPath=' . $cPath . '&products_id=' . smn_set_prid($set_product_id, $store_id)));
    }
  }

// initialize the message stack for output messages
  require(DIR_WS_CLASSES . 'message_stack.php');
  $messageStack = new messageStack;

  define('TEMPLATENAME_BOX', 'box.php');
  define('TEMPLATENAME_POPUP', 'popup.php');
  
// header tags system  
  require(DIR_WS_FUNCTIONS . 'header_tags.php');
  
// Clean out HTML comments from ALT tags etc.
  require(DIR_WS_FUNCTIONS . 'clean_html_comments.php');
  
// Set the length of the redeem code, the longer the more secure
  define('SECURITY_CODE_LENGTH', '10');
  define('USE_JAVASCRIPT_LIBRARY', 'true');
  
  require(DIR_WS_CLASSES . 'jQuery.php');
  $jQuery = new jQuery();
  $jQuery->loadAllExtensions();
  $jQuery->loadAllPlugins();
?>