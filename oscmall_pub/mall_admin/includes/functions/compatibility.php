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

////
// Recursively handle magic_quotes_gpc turned off.
// This is due to the possibility of have an array in
// $HTTP_xxx_VARS
// Ie, products attributes
  function do_magic_quotes_gpc(&$ar) {
    if (!is_array($ar)) return false;
	reset($ar);
    while (list($key, $value) = each($ar)) {
      if (is_array($value)) {
        do_magic_quotes_gpc($value);
      } else {
        $ar[$key] = addslashes($value);
      }
    }
	reset($ar);
  }

// $HTTP_xxx_VARS are always set on php4
  if (PHP_VERSION >= 4.1) {
	  $HTTP_GET_VARS =& $_GET;
	  $HTTP_POST_VARS =& $_POST;
	  $HTTP_COOKIE_VARS =& $_COOKIE;
	  $HTTP_SESSION_VARS =& $_SESSION;
	  $HTTP_POST_FILES =& $_FILES;
	  $HTTP_SERVER_VARS =& $_SERVER;
  } else {
	  if (!is_array($_GET)) $_GET = array();
	  if (!is_array($_POST)) $_POST = array();
	  if (!is_array($HTTP_COOKIE_VARS)) $HTTP_COOKIE_VARS = array();
  }

// handle magic_quotes_gpc turned off.
  if (!get_magic_quotes_gpc()) {
    do_magic_quotes_gpc($_GET);
    do_magic_quotes_gpc($_POST);
    do_magic_quotes_gpc($HTTP_COOKIE_VARS);
  }

  if (!function_exists('is_numeric')) {
    function is_numeric($param) {
      return ereg("^[0-9]{1,50}.?[0-9]{0,50}$", $param);
    }
  }

  if (!function_exists('is_uploaded_file')) {
    function is_uploaded_file($filename) {
      if (!$tmp_file = get_cfg_var('upload_tmp_dir')) {
        $tmp_file = dirname(tempnam('', ''));
      }

      if (strchr($tmp_file, '/')) {
        if (substr($tmp_file, -1) != '/') $tmp_file .= '/';
      } elseif (strchr($tmp_file, '\\')) {
        if (substr($tmp_file, -1) != '\\') $tmp_file .= '\\';
      }

      return file_exists($tmp_file . basename($filename));
    }
  }

  if (!function_exists('move_uploaded_file')) {
    function move_uploaded_file($file, $target) {
      return copy($file, $target);
    }
  }

  if (!function_exists('checkdnsrr')) {
    function checkdnsrr($host, $type) {
      if(smn_not_null($host) && smn_not_null($type)) {
        @exec("nslookup -type=$type $host", $output);
        while(list($k, $line) = each($output)) {
          if(eregi("^$host", $line)) {
            return true;
          }
        }
      }
      return false;
    }
  }

  if (!function_exists('in_array')) {
    function in_array($lookup_value, $lookup_array) {
      reset($lookup_array);
      while (list($key, $value) = each($lookup_array)) {
        if ($value == $lookup_value) return true;
      }

      return false;
    }
  }

  if (!function_exists('array_merge')) {
    function array_merge($array1, $array2, $array3 = '') {
      if ($array3 == '') $array3 = array();

      while (list($key, $val) = each($array1)) $array_merged[$key] = $val;
      while (list($key, $val) = each($array2)) $array_merged[$key] = $val;

      if (sizeof($array3) > 0) while (list($key, $val) = each($array3)) $array_merged[$key] = $val;

      return (array)$array_merged;
    }
  }

  if (!function_exists('array_shift')) {
    function array_shift(&$array) {
      $i = 0;
      $shifted_array = array();
      reset($array);
      while (list($key, $value) = each($array)) {
        if ($i > 0) {
          $shifted_array[$key] = $value;
        } else {
          $return = $array[$key];
        }
        $i++;
      }
      $array = $shifted_array;

      return $return;
    }
  }

  if (!function_exists('array_reverse')) {
    function array_reverse($array) {
      $reversed_array = array();

      for ($i=sizeof($array)-1; $i>=0; $i--) {
        $reversed_array[] = $array[$i];
      }

      return $reversed_array;
    }
  }

  if (!function_exists('array_slice')) {
    function array_slice($array, $offset, $length = '0') {
      $length = abs($length);

      if ($length == 0) {
        $high = sizeof($array);
      } else {
        $high = $offset+$length;
      }

      for ($i=$offset; $i<$high; $i++) {
        $new_array[$i-$offset] = $array[$i];
      }

      return $new_array;
    }
  }
 
/* 
 * stripos() natively supported from PHP 5.0 
 * From Pear::PHP_Compat 
 */ 
  
   if (!function_exists('stripos')) { 
     function stripos($haystack, $needle, $offset = null) { 
       $fix = 0; 
  
       if (!is_null($offset)) { 
         if ($offset > 0) { 
           $haystack = substr($haystack, $offset, strlen($haystack) - $offset); 
           $fix = $offset; 
         } 
       } 
  
       $segments = explode(strtolower($needle), strtolower($haystack), 2); 
  
 // Check there was a match 
       if (count($segments) == 1) { 
         return false; 
       } 
  
       $position = strlen($segments[0]) + $fix; 
  
       return $position; 
     } 
   } 
?>
