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

  require('includes/application_top.php');
  
  if (isset($_GET['action']) && ($_GET['action'] == 'process')) {
    $email_address = smn_db_prepare_input($_POST['email_address']);
    $firstname = smn_db_prepare_input($_POST['firstname']);
    $log_times = $_POST['log_times']+1;
    if ($log_times >= 4) {
      smn_session_register('password_forgotten');
    }
      
// Check if email exists
    $check_admin_query = smn_db_query("select admin_id as check_id, admin_firstname as check_firstname, admin_lastname as check_lastname, admin_email_address as check_email_address from " . TABLE_ADMIN . " where admin_email_address = '" . smn_db_input($email_address) . "'");
    if (!smn_db_num_rows($check_admin_query)) {
      $_GET['login'] = 'fail';
    } else {
      $check_admin = smn_db_fetch_array($check_admin_query);
      if ($check_admin['check_firstname'] != $firstname) {
        $_GET['login'] = 'fail';
      } else {
        $_GET['login'] = 'success';
        
        function randomize() {
          $salt = "ABCDEFGHIJKLMNOPQRSTUVWXWZabchefghjkmnpqrstuvwxyz0123456789";
          srand((double)microtime()*1000000); 
          $i = 0;
    
          while ($i <= 7) {
            $num = rand() % 33;
    	    $tmp = substr($salt, $num, 1);
    	    $pass = $pass . $tmp;
    	    $i++;
  	  }
  	  return $pass;
        }
        $makePassword = randomize();
	
	
	
	
      smn_mail($check_admin['customers_firstname'] . ' ' . $check_admin['customers_lastname'], $check_admin['check_email_address'], EMAIL_PASSWORD_REMINDER_SUBJECT, sprintf(EMAIL_PASSWORD_REMINDER_BODY, $makePassword), $check_admin['check_firstname'] . ' ' . $check_admin['admin_lastname'], $check_admin['check_email_address']);
      smn_db_query("update " . TABLE_ADMIN . " set admin_password = '" . smn_encrypt_password($makePassword) . "' where admin_id = '" . $check_admin['check_id'] . "'");
      }
    }
  }

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_LOGIN);
  
  $content_page = basename($_SERVER['PHP_SELF']);
  
  require('templates/default/layout.php');

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>