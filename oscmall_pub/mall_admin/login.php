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

    if (isset($_GET['ID']))
  {
      $GLOBALS['store_id'] = '';
      smn_redirect(smn_href_link(FILENAME_LOGIN, '', 'NONSSL'));
  }    

 
  if (isset($_GET['action']) && ($_GET['action'] == 'process')) {
    $email_address = smn_db_prepare_input($_POST['email_address']);
    $password = smn_db_prepare_input($_POST['password']);

// Check if email exists
    $check_admin_query = smn_db_query("select store_id, admin_id as login_id, admin_groups_id as login_groups_id, admin_firstname as login_firstname, admin_email_address as login_email_address, admin_password as login_password, admin_modified as login_modified, admin_logdate as login_logdate, admin_lognum as login_lognum from " . TABLE_ADMIN . " where admin_email_address = '" . smn_db_input($email_address) . "'");
    if (!smn_db_num_rows($check_admin_query)) {
      $login = 'fail';
    } else {
      $check_admin = smn_db_fetch_array($check_admin_query);
      // Check that password is good
      if (!smn_validate_password($password, $check_admin['login_password'])) {
        $login = 'fail';
      } else {
        if (smn_session_is_registered('password_forgotten')) {
          smn_session_unregister('password_forgotten');
        }

        $login_id = $check_admin['login_id'];
        $store_id = $check_admin['store_id'];
        $login_groups_id = $check_admin['login_groups_id'];
        $login_firstname = $check_admin['login_firstname'];
        $login_email_address = $check_admin['login_email_address'];
        $login_logdate = $check_admin['login_logdate'];
        $login_lognum = $check_admin['login_lognum'];
        $login_modified = $check_admin['login_modified'];

        smn_session_register('login_id');
        smn_session_register('store_id');
        smn_session_register('login_groups_id');
        smn_session_register('login_first_name');

        //$date_now = date('Ymd');
        smn_db_query("update " . TABLE_ADMIN . " set admin_logdate = now(), admin_lognum = admin_lognum+1 where admin_id = '" . $login_id . "'");
        
        echo '{ success: true, redirectUrl: "' . smn_href_link(FILENAME_DEFAULT) . '" }';
        exit;
      }
    }
    echo '{ success: false, errorMsg: "' . $jQuery->jsonHtmlPrepare(TEXT_LOGIN_ERROR) . '" }';
    exit;
  }

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_LOGIN);
  
  $submitButton = $jQuery->getPluginClass('button');
  $submitButton->setID('submitButton');
  $submitButton->setType('submit');
  $submitButton->setText('Login');
  
  $content_page = basename($_SERVER['PHP_SELF']);
  
  $ignoreHeader = true;
  $ignoreColumn = true;
  
  require('templates/default/layout.php');

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>