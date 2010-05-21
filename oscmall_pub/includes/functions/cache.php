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
//! Write out serialized data.
//  write_cache uses serialize() to store $var in $filename.
//  $var      -  The variable to be written out.
//  $filename -  The name of the file to write to.
  function write_cache(&$var, $filename) {
    $filename = DIR_FS_CACHE . $filename;
    $success = false;

// try to open the file
    if ($fp = @fopen($filename, 'w')) {
// obtain a file lock to stop corruptions occuring
      flock($fp, 2); // LOCK_EX
// write serialized data
      fputs($fp, serialize($var));
// release the file lock
      flock($fp, 3); // LOCK_UN
      fclose($fp);
      $success = true;
    }

    return $success;
  }

////
//! Read in seralized data.
//  read_cache reads the serialized data in $filename and
//  fills $var using unserialize().
//  $var      -  The variable to be filled.
//  $filename -  The name of the file to read.
  function read_cache(&$var, $filename, $auto_expire = false){
    $filename = DIR_FS_CACHE . $filename;
    $success = false;

    if (($auto_expire == true) && file_exists($filename)) {
      $now = time();
      $filetime = filemtime($filename);
      $difference = $now - $filetime;

      if ($difference >= $auto_expire) {
        return false;
      }
    }

// try to open file
    if ($fp = @fopen($filename, 'r')) {
// read in serialized data
      $szdata = fread($fp, filesize($filename));
      fclose($fp);
// unserialze the data
      $var = unserialize($szdata);

      $success = true;
    }

    return $success;
  }

////
//! Get data from the cache or the database.
//  get_db_cache checks the cache for cached SQL data in $filename
//  or retreives it from the database is the cache is not present.
//  $SQL      -  The SQL query to exectue if needed.
//  $filename -  The name of the cache file.
//  $var      -  The variable to be filled.
//  $refresh  -  Optional.  If true, do not read from the cache.
  function get_db_cache($sql, &$var, $filename, $refresh = false){
    $var = array();

// check for the refresh flag and try to the data
    if (($refresh == true)|| !read_cache($var, $filename)) {
// Didn' get cache so go to the database.
//      $conn = mysql_connect("localhost", "apachecon", "apachecon");
      $res = smn_db_query($sql);
//      if ($err = mysql_error()) trigger_error($err, E_USER_ERROR);
// loop through the results and add them to an array
      while ($rec = smn_db_fetch_array($res)) {
        $var[] = $rec;
      }
// write the data to the file
      write_cache($var, $filename);
    }
  }

////
//! Cache the categories box
// Cache the categories box
  function smn_cache_categories_box($auto_expire = false, $refresh = false) {
    global $cPath, $language, $languages_id, $tree, $cPath_array, $categories_string;

    if (($refresh == true) || !read_cache($cache_output, 'categories_box-' . $language . '.cache' . $cPath, $auto_expire)) {
      ob_start();
      include(DIR_WS_BOXES . 'categories.php');
      $cache_output = ob_get_contents();
      ob_end_clean();
      write_cache($cache_output, 'categories_box-' . $language . '.cache' . $cPath);
    }

    return $cache_output;
  }

////
//! Cache the categories box
// Cache the categories box
  function smn_cache_store_categories_box($auto_expire = false, $refresh = false) {
    global $sPath, $language, $languages_id, $tree, $sPath_array, $store_categories_string;

    if (($refresh == true) || !read_cache($store_cache_output, 'store_categories_box-' . $language . '.cache' . $sPath, $auto_expire)) {
      ob_start();
      include(DIR_WS_BOXES . 'store_categories.php');
      $store_cache_output = ob_get_contents();
      ob_end_clean();
      write_cache($store_cache_output, 'store_categories_box-' . $language . '.cache' . $sPath);
    }

    return $store_cache_output;
  }
  
  

////
//! Cache the manufacturers box
// Cache the manufacturers box
  function smn_cache_manufacturers_box($auto_expire = false, $refresh = false) {
    global $_GET, $language;

    $manufacturers_id = '';
    if (isset($_GET['manufacturers_id']) && smn_not_null($_GET['manufacturers_id'])) {
      $manufacturers_id = $_GET['manufacturers_id'];
    }

    if (($refresh == true) || !read_cache($cache_output, 'manufacturers_box-' . $language . '.cache' . $manufacturers_id, $auto_expire)) {
      ob_start();
      include(DIR_WS_BOXES . 'manufacturers.php');
      $cache_output = ob_get_contents();
      ob_end_clean();
      write_cache($cache_output, 'manufacturers_box-' . $language . '.cache' . $manufacturers_id);
    }

    return $cache_output;
  }

////
//! Cache the also purchased module
// Cache the also purchased module
  function smn_cache_also_purchased($auto_expire = false, $refresh = false) {
    global $_GET, $language, $languages_id;

    if (($refresh == true) || !read_cache($cache_output, 'also_purchased-' . $language . '.cache' . $_GET['products_id'], $auto_expire)) {
      ob_start();
      include(DIR_WS_MODULES . FILENAME_ALSO_PURCHASED_PRODUCTS);
      $cache_output = ob_get_contents();
      ob_end_clean();
      write_cache($cache_output, 'also_purchased-' . $language . '.cache' . $_GET['products_id']);
    }

    return $cache_output;
  }
?>
