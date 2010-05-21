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

  if ( (PHP_VERSION >= 4.3) && ((bool)ini_get('register_globals') == false) ) { 
     @ini_set('session.bug_compat_42', 1); 
     @ini_set('session.bug_compat_warn', 0); 
   } 

   if (STORE_SESSIONS == 'mysql') {
    if (!$SESS_LIFE = get_cfg_var('session.gc_maxlifetime')) {
      $SESS_LIFE = 1440;
    }

    function _sess_open($save_path, $session_name) {
      return true;
    }

    function _sess_close() {
      return true;
    }

    function _sess_read($key) {
      $value_query = smn_db_query("select value from " . TABLE_SESSIONS . " where sesskey = '" . smn_db_input($key) . "' and expiry > '" . time() . "'");
	  $value = smn_db_fetch_array($value_query);

	if (isset($value['value'])) {
        return $value['value'];
      }

      return '';
    }

    function _sess_write($key, $val) {
      global $SESS_LIFE;

      $expiry = time() + $SESS_LIFE;
      $value = $val;

      $check_query = smn_db_query("select count(*) as total from " . TABLE_SESSIONS . " where sesskey = '" . smn_db_input($key) . "'");
      $check = smn_db_fetch_array($check_query);

      if ($check['total'] > 0) {
        return smn_db_query("update " . TABLE_SESSIONS . " set expiry = '" . smn_db_input($expiry) . "', value = '" . smn_db_input($value) . "' where sesskey = '" . smn_db_input($key) . "'");
      } else {
        return smn_db_query("insert into " . TABLE_SESSIONS . " values ('" . smn_db_input($key) . "', '" . smn_db_input($expiry) . "', '" . smn_db_input($value) . "')");
      }
    }

    function _sess_destroy($key) {
      return smn_db_query("delete from " . TABLE_SESSIONS . " where sesskey = '" . smn_db_input($key) . "'");
    }

    function _sess_gc($maxlifetime) {
      smn_db_query("delete from " . TABLE_SESSIONS . " where expiry < '" . time() . "'");

      return true;
    }

    session_set_save_handler('_sess_open', '_sess_close', '_sess_read', '_sess_write', '_sess_destroy', '_sess_gc');
  }

  function smn_session_start() {
  	global $HTTP_GET_VARS, $HTTP_POST_VARS, $HTTP_COOKIE_VARS;
	$sane_session_id = true;
	if (isset($HTTP_GET_VARS[smn_session_name()])) {
  	  if (preg_match('/^[a-zA-Z0-9]+$/', $HTTP_GET_VARS[smn_session_name()]) == false) {
	  	unset($HTTP_GET_VARS[smn_session_name()]);
		$sane_session_id = false;
	  }
	}elseif (isset($HTTP_POST_VARS[smn_session_name()])) {
	  if (preg_match('/^[a-zA-Z0-9]+$/', $HTTP_POST_VARS[smn_session_name()]) == false) {
		unset($HTTP_POST_VARS[smn_session_name()]);
		$sane_session_id = false;
	  }
	} elseif (isset($HTTP_COOKIE_VARS[smn_session_name()])) {
	  if (preg_match('/^[a-zA-Z0-9]+$/', $HTTP_COOKIE_VARS[smn_session_name()]) == false) {
	    $session_data = session_get_cookie_params();
		setcookie(smn_session_name(), '', time()-42000, $session_data['path'], $session_data['domain']);
		$sane_session_id = false;
	  }
	}
	if ($sane_session_id == false) {
	  smn_redirect(smn_href_link(FILENAME_DEFAULT, '', 'NONSSL', false)); 
	} 	
			
    return session_start();
  }

  function smn_session_register($variable) {
    if (PHP_VERSION < 4.3) {
      return session_register($variable);
	} else {
	  if (isset($GLOBALS[$variable])) {
	    $_SESSION[$variable] =& $GLOBALS[$variable];
	  } else {
	    $_SESSION[$variable] = null;
	  }
	}
	return false;   
  }

  function smn_session_is_registered($variable) {
    if (PHP_VERSION < 4.3) {
      return session_is_registered($variable);
	} else {
	  return isset($_SESSION) && array_key_exists($variable, $_SESSION);
	}
  }

  function smn_session_unregister($variable) {
    if (PHP_VERSION < 4.3) {
      return session_unregister($variable);
	} else {
	  unset($_SESSION[$variable]);
	}  
  }

  function smn_session_id($sessid = '') {
    if ($sessid != '') {
      return session_id($sessid);
    } else {
      return session_id();
    }
  }

  function smn_session_name($name = '') {
    if ($name != '') {
      return session_name($name);
    } else {
      return session_name();
    }
  }

  function smn_session_close() {
    if (PHP_VERSION >= '4.0.4') {
	  return session_write_close();
	} elseif (function_exists('session_close')) {
      return session_close();
    }
  }

  function smn_session_destroy() {
    return session_destroy();
  }

  function smn_session_save_path($path = '') {
    if ($path != '') {
      return session_save_path($path);
    } else {
      return session_save_path();
    }
  }
?>
