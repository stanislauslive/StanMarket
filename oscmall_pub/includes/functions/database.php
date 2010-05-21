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

  function smn_db_connect($server = DB_SERVER, $username = DB_SERVER_USERNAME, $password = DB_SERVER_PASSWORD, $database = DB_DATABASE, $link = 'db_link') {
    global $$link;

    if (USE_PCONNECT == 'true') {
      $$link = mysql_pconnect($server, $username, $password);
    } else {
      $$link = mysql_connect($server, $username, $password);
    }

    if ($$link) mysql_select_db($database);

    return $$link;
  }

  function smn_db_close($link = 'db_link') {
    global $$link;

    return mysql_close($$link);
  }

  function smn_db_error($query, $errno, $error) { 
    die('<font color="#000000"><b>' . $errno . ' - ' . $error . '<br><br>' . $query . '<br><br><small><font color="#ff0000">[smn STOP]</font></small><br><br></b></font>');
  }

  function smn_db_query($query, $link = 'db_link') {
    global $$link;

    if (defined('STORE_DB_TRANSACTIONS') && (STORE_DB_TRANSACTIONS == 'true')) {
      error_log('QUERY ' . $query . "\n", 3, STORE_PAGE_PARSE_TIME_LOG);
    }

    $result = mysql_query($query, $$link) or smn_db_error($query, mysql_errno(), mysql_error());

    if (defined('STORE_DB_TRANSACTIONS') && (STORE_DB_TRANSACTIONS == 'true')) {
       $result_error = mysql_error();
       error_log('RESULT ' . $result . ' ' . $result_error . "\n", 3, STORE_PAGE_PARSE_TIME_LOG);
    }

    return $result;
  }

  function smn_db_perform($table, $data, $action = 'insert', $parameters = '', $link = 'db_link') {
    reset($data);
    if ($action == 'insert') {
      $query = 'insert into ' . $table . ' (';
      while (list($columns, ) = each($data)) {
        $query .= $columns . ', ';
      }
      $query = substr($query, 0, -2) . ') values (';
      reset($data);
      while (list(, $value) = each($data)) {
        switch ((string)$value) {
          case 'now()':
            $query .= 'now(), ';
            break;
          case 'null':
            $query .= 'null, ';
            break;
          default:
            $query .= '\'' . smn_db_input($value) . '\', ';
            break;
        }
      }
      $query = substr($query, 0, -2) . ')';
    } elseif ($action == 'update') {
      $query = 'update ' . $table . ' set ';
      while (list($columns, $value) = each($data)) {
        switch ((string)$value) {
          case 'now()':
            $query .= $columns . ' = now(), ';
            break;
          case 'null':
            $query .= $columns .= ' = null, ';
            break;
          default:
            $query .= $columns . ' = \'' . smn_db_input($value) . '\', ';
            break;
        }
      }
      $query = substr($query, 0, -2) . ' where ' . $parameters;
    }
    return smn_db_query($query, $link);
  }

  function smn_db_fetch_array($db_query) {
    return mysql_fetch_array($db_query, MYSQL_ASSOC);
  }

  function smn_db_num_rows($db_query) {
    return mysql_num_rows($db_query);
  }

  function smn_db_data_seek($db_query, $row_number) {
    return mysql_data_seek($db_query, $row_number);
  }

 function smn_db_insert_id($link = 'db_link') {
  	global $$link;
    return mysql_insert_id($$link);
  }

  function smn_db_free_result($db_query) {
    return mysql_free_result($db_query);
  }

  function smn_db_fetch_fields($db_query) {
    return mysql_fetch_field($db_query);
  }

  function smn_db_output($string) {
    return htmlspecialchars($string);
  }

// systemsmanager begin - Dec 1, 2005 security patch		
/*
  function smn_db_input($string) {
    return addslashes($string);
  }
*/
function smn_db_input($string, $link = 'db_link') {
  global $$link;
 
  if (function_exists('mysql_real_escape_string')) {
    return mysql_real_escape_string($string, $$link);
  } elseif (function_exists('mysql_escape_string')) {
    return mysql_escape_string($string);
  }
 
  return addslashes($string);
}
// systemsmanager end 

  function smn_db_prepare_input($string) {
    if (is_string($string)) {
      return trim(smn_sanitize_string(stripslashes($string)));
    } elseif (is_array($string)) {
      reset($string);
      while (list($key, $value) = each($string)) {
        $string[$key] = smn_db_prepare_input($value);
      }
      return $string;
    } else {
      return $string;
    }
  }
?>
