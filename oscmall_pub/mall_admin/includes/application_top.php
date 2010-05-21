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

// Start the clock for the page parse time log
  define('PAGE_PARSE_START_TIME', microtime());

// Set the level of error reporting
  error_reporting(E_ALL & ~E_NOTICE);

// check support for register_globals
// Since this is a temporary measure this message is hardcoded. The requirement will be removed before 2.2 is finalized.
  if (function_exists('ini_get') && (ini_get('register_globals') == false) && (PHP_VERSION < 4.3) ) {
    exit('Server Requirement Error: register_globals is disabled in your PHP configuration. This can be enabled in your php.ini configuration file or in the .htaccess file in your catalog directory. Please use PHP 4.3+ if register_globals cannot be enabled on the server.');
  }

// Set the local configuration parameters - mainly for developers
  if (file_exists('includes/local/configure.php')) include('includes/local/configure.php');

// Include application configuration parameters
  require('includes/configure.php');
  
  // include the database functions
  require(DIR_WS_FUNCTIONS . 'database.php');

// make a connection to the database... now
  smn_db_connect() or die('Unable to connect to database server!');
  
  //define tables used with the project
  /* gus begin **
  require(DIR_WS_INCLUDES . 'database_tables.php');
  smn_set_database_tables();
  ** gus end */
  
// Define the project version
  define('PROJECT_VERSION', 'SystemsManager Technologies oscMall Version 4.0');
  
  // some code to solve compatibility issues
  require(DIR_WS_FUNCTIONS . 'compatibility.php');
  
// need to get the store prefix before the definitions are set....

    require(DIR_WS_CLASSES . 'mall_setup.php');
    if (isset($_GET['ID'])){
      $store_id = $_GET['ID'];
    }
    elseif (isset($_POST['ID'])){
      $store_id = $_POST['ID'];
    }else{
      $store_id = 1;  
    }
    
    $store = new mall_setup($store_id);
    $store->set_store_parameters();
    
//set the stor type to be used
  $store_type = $store->get_store_type_name();
  
//set store images and filename variables
/* gus begin **
  $store->set_store_variables();
** gus end */
  
// set php_self in the local scope
  $PHP_SELF = (isset($HTTP_SERVER_VARS['PHP_SELF']) ? $HTTP_SERVER_VARS['PHP_SELF'] : $HTTP_SERVER_VARS['SCRIPT_NAME']);
  $request_type = (getenv('HTTPS') == 'on') ? 'NONSSL' : 'NONSSL';
// Used in the "Backup Manager" to compress backups
  define('LOCAL_EXE_GZIP', '/usr/bin/gzip');
  define('LOCAL_EXE_GUNZIP', '/usr/bin/gunzip');
  define('LOCAL_EXE_ZIP', '/usr/local/bin/zip');
  define('LOCAL_EXE_UNZIP', '/usr/local/bin/unzip');

// customization for the design layout
  define('BOX_WIDTH', 125); // how wide the boxes should be in pixels (default: 125)

// Define how do we update currency exchange rates
// Possible values are 'oanda' 'xe' or ''
  define('CURRENCY_SERVER_PRIMARY', 'oanda');
  define('CURRENCY_SERVER_BACKUP', 'xe');

// set the mall application parameters
  /*Changed the query to display the orders placed from substores in the account history by Cimi*/
  /*$configuration_query = smn_db_query("select configuration_key as cfgKey, configuration_value as cfgValue from " . TABLE_CONFIGURATION . " where store_id ='" . $store_id ."' or store_id = '0'");*/
  $configuration_query = smn_db_query("select configuration_key as cfgKey, configuration_value as cfgValue from " . TABLE_CONFIGURATION . " where store_id ='" . $store_id ."' or store_id = '0' order by store_id desc");
  while ($configuration = smn_db_fetch_array($configuration_query)) {
    define($configuration['cfgKey'], $configuration['cfgValue']);
  }

// define our general functions used application-wide
  require(DIR_WS_FUNCTIONS . 'general.php');
  require(DIR_WS_FUNCTIONS . 'html_output.php');
  require(DIR_WS_FUNCTIONS . 'mall_setup.php');
  
// include the password crypto functions
  require(DIR_WS_FUNCTIONS . 'password_funcs.php');

// initialize the logger class
  require(DIR_WS_CLASSES . 'logger.php');

// include shopping cart class
    require(DIR_WS_CLASSES . 'shopping_cart.php');



// check to see if php implemented session management functions - if not, include php3/php4 compatible session class
  if (!function_exists('session_start')) {
    define('PHP_SESSION_NAME', 'osCMallAdmin');
    define('PHP_SESSION_PATH', '/');
    define('PHP_SESSION_SAVE_PATH', SESSION_WRITE_DIRECTORY);

    include(DIR_WS_CLASSES . 'sessions.php');
  }

// define how the session functions will be used
  require(DIR_WS_FUNCTIONS . 'sessions.php');

// set the session name and save path
  smn_session_name('osCMallAdmin');
  smn_session_save_path(SESSION_WRITE_DIRECTORY);

// set the session cookie parameters
   if (function_exists('session_set_cookie_params')) {
    session_set_cookie_params(0, DIR_WS_ADMIN);
  } elseif (function_exists('ini_set')) {
    ini_set('session.cookie_lifetime', '0');
    ini_set('session.cookie_path', DIR_WS_ADMIN);
  }

// lets start our session
  smn_session_start();
  if ( (PHP_VERSION >= 4.3) && function_exists('ini_get') && (ini_get('register_globals') == false) ) {
    extract($_SESSION, EXTR_OVERWRITE+EXTR_REFS);
  }
 
    if (($_GET['ID'])  && (!$store_id) ){
     if (!smn_session_is_registered ('store_id'))
        smn_session_register('store_id'); 
        $store_id = intval($_GET['ID']);
    } 
    if (!smn_session_is_registered ('store_name'))
        smn_session_register('store_name'); 
	$store_name = $store->get_store_name();
	
    if (!smn_session_is_registered ('store_group_type'))
        smn_session_register('store_group_type'); 
        $store_group_type = smn_set_store_group_type($store->get_store_type());
	
    if (!smn_session_is_registered ('store_type'))
        smn_session_register('store_type'); 
	$store_type = $store->get_store_type();
        

// set the language
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
  $current_page = basename($PHP_SELF);
  if (file_exists(DIR_WS_LANGUAGES . $language . '/' . $current_page)) {
    include(DIR_WS_LANGUAGES . $language . '/' . $current_page);
  }

// define our localization functions
  require(DIR_WS_FUNCTIONS . 'localization.php');

// Include validation functions (right now only email address)
  require(DIR_WS_FUNCTIONS . 'validations.php');

// setup our boxes
  require(DIR_WS_CLASSES . 'table_block.php');
  require(DIR_WS_CLASSES . 'box.php');

// initialize the message stack for output messages
  require(DIR_WS_CLASSES . 'message_stack.php');
  $messageStack = new messageStack;

// split-page-results
  require(DIR_WS_CLASSES . 'split_page_results.php');

// entry/item info classes
  require(DIR_WS_CLASSES . 'object_info.php');

// email classes
  require(DIR_WS_CLASSES . 'mime.php');
  require(DIR_WS_CLASSES . 'email.php');

// file uploading class
  require(DIR_WS_CLASSES . 'upload.php');

// calculate category path
  if (isset($_GET['cPath'])) {
    $cPath = $_GET['cPath'];
  } elseif (isset($_POST['cPath'])) {
      $cPath = $_POST['cPath'];
  }else{
    $cPath = '';
  }

  if (smn_not_null($cPath)) {
    $cPath_array = smn_parse_category_path($cPath);
    $cPath = implode('_', $cPath_array);
    $current_category_id = $cPath_array[(sizeof($cPath_array)-1)];
  } else {
    $current_category_id = 0;
  }

// calculate category path
  if (isset($_GET['sPath'])) {
    $sPath = $_GET['sPath'];
  } elseif (isset($_POST['sPath'])) {
      $sPath = $_POST['sPath'];
  }else{
    $sPath = '';
  }

  if (smn_not_null($sPath)) {
    $sPath_array = smn_parse_store_category_path($sPath);
    $sPath = implode('_', $sPath_array);
    $current_store_category_id = $sPath_array[(sizeof($sPath_array)-1)];
  } else {
    $current_store_category_id = 0;
  }


// default open navigation box
  if (!smn_session_is_registered('selected_box')) {
    smn_session_register('selected_box');
    $selected_box = 'configuration';
  }

  if (isset($_GET['selected_box'])) {
    $selected_box = $_GET['selected_box'];
  }

// the following cache blocks are used in the Tools->Cache section
// ('language' in the filename is automatically replaced by available languages)
  $cache_blocks = array(array('title' => TEXT_CACHE_CATEGORIES, 'code' => 'categories', 'file' => 'categories_box-language.cache', 'multiple' => true),
                        array('title' => TEXT_CACHE_MANUFACTURERS, 'code' => 'manufacturers', 'file' => 'manufacturers_box-language.cache', 'multiple' => true),
                        array('title' => TEXT_CACHE_ALSO_PURCHASED, 'code' => 'also_purchased', 'file' => 'also_purchased-language.cache', 'multiple' => true)
                       );

// check if a default currency is set
  if (!defined('DEFAULT_CURRENCY')) {
    $messageStack->add(ERROR_NO_DEFAULT_CURRENCY_DEFINED, 'error');
  }

// check if a default language is set
  if (!defined('DEFAULT_LANGUAGE')) {
    $messageStack->add(ERROR_NO_DEFAULT_LANGUAGE_DEFINED, 'error');
  }

  if (function_exists('ini_get') && ((bool)ini_get('file_uploads') == false) ) {
    $messageStack->add(WARNING_FILE_UPLOADS_DISABLED, 'warning');
  }

// set the store_id
if (smn_session_is_registered('login_id')) {
        
    $store_id_check = smn_db_query("select admin_id, admin_groups_id, store_id  from " . TABLE_ADMIN . " where admin_id = '". $login_id."'");
    $check = smn_db_fetch_array($store_id_check);
        
    $switch_store_id = $check['store_id'];
    if (!smn_session_is_registered ('switch_store_id'))smn_session_register('switch_store_id');
            
    if (($check['admin_id'] == 1 )&& ($check['store_id'] == 1 )&& ($check['admin_groups_id'] == 1 )) {   
      $super_user = 'true';
      if (!smn_session_is_registered ('super_user')) smn_session_register('super_user');
      if (isset ($_POST['store'])){
        smn_session_unregister('store_id');       
        $store_id = $_POST['store'];
        smn_session_register('store_id');
        smn_redirect(smn_href_link(basename($PHP_SELF)));
      }
    }else{
        $super_user = 'false';
        if (!smn_session_is_registered ('super_user')) smn_session_register('super_user');
        if (intval($_GET['ID']) != intval($switch_store_id)) smn_redirect(smn_href_link(FILENAME_LOGOFF));
        $store_id = $check['store_id'];
        smn_session_register('store_id'); 
    }

      $filename = basename( $PHP_SELF );
    
    if ($filename != FILENAME_DEFAULT && $filename != FILENAME_FORBIDEN && $filename != FILENAME_LOGOFF && $filename != FILENAME_ADMIN_ACCOUNT && $filename != FILENAME_POPUP_IMAGE && $filename != 'packingslip.php' && $filename != 'invoice.php') {
      $db_file_query = smn_db_query("select admin_files_name, admin_groups_id from " . TABLE_ADMIN_FILES . " where FIND_IN_SET( '" . $login_groups_id . "', admin_groups_id) and admin_files_name = '" . $filename . "'");
        if (!smn_db_num_rows($db_file_query)) {
        //smn_redirect(smn_href_link(FILENAME_FORBIDEN));
      }else{
            $db_file = smn_db_fetch_array($db_file_query);
      }
     }   
    }

  // Check login and file access
  if (basename($PHP_SELF) != FILENAME_LOGOFF && basename($PHP_SELF) != FILENAME_LOGIN && basename($PHP_SELF) != FILENAME_PASSWORD_FORGOTTEN)
  { 
   if (!smn_session_is_registered('login_id')) {
        smn_session_unregister('store_id');
        smn_session_unregister('login_id');
        if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
            echo '{
                success: false,
                errorType: "login",
                errorMsg: "Your Login Session Has Expired, Use The Fields Below To Login."
            }';
            exit;
        }
        smn_redirect(smn_href_link(FILENAME_LOGIN, '', 'NONSSL'));
        } 
  }
  
  define ('AFFILIATE_NOTIFY_AFTER_BILLING','true'); // Nofify affiliate if he got a new invoice
  define ('AFFILIATE_DELETE_ORDERS','false');       // Delete affiliate_sales if an order is deleted (Warning: Only not yet billed sales are deleted)
  define ('AFFILIATE_TAX_ID','1');  // Tax Rates used for billing the affiliates 
// you get this from the URl (tID) when you select you Tax Rate at the admin: tax_rates.php?tID=1
// If set, the following actions take place each time you call the admin/affiliate_summary 									
  define ('AFFILIATE_DELETE_CLICKTHROUGHS','false');  // (days / false) To keep the clickthrough report small you can set the days after which they are deleted (when calling affiliate_summary in the admin) 
  define ('AFFILIATE_DELETE_AFFILIATE_BANNER_HISTORY','false');  // (days / false) To keep thethe table AFFILIATE_BANNER_HISTORY small you can set the days after which they are deleted (when calling affiliate_summary in the admin) 
     
// If an order is deleted delete the sale too (optional)
  if ($_GET['action'] == 'deleteconfirm' && basename($HTTP_SERVER_VARS['SCRIPT_FILENAME']) == FILENAME_ORDERS && AFFILIATE_DELETE_ORDERS == 'true') {
    $affiliate_oID = smn_db_prepare_input($_GET['oID']);
    smn_db_query("delete from " . TABLE_AFFILIATE_SALES . " where affiliate_orders_id = '" . smn_db_input($affiliate_oID) . "' and affiliate_billing_status != 1");
  }
  define('SECURITY_CODE_LENGTH', '6'); 
  
  
  require('../includes/classes/jQuery.php');
  $jQuery = new jQuery();
  $jQuery->loadAllExtensions();
  $jQuery->loadAllPlugins(); 

// 
//   This define('JQUERY_MENU', 'jd_menu'); ( which will be moved into the database ) has 2 values currently: jd_menu or ??//    accordion
define('JQUERY_MENU', 'jd_menu');
  
?>