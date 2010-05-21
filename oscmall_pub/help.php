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

  require('includes/application_top.php');
  
  if (isset($_GET['tab'])){
      $Qcheck = smn_db_query('select help_id from ' . TABLE_HELP . ' where help_file = "' . $_GET['page'] . '" and help_file_tab = "' . $_GET['tab'] . '" and help_custom = "false"');
      $errMsg = 'Sorry There Is No Help Available For This Tab';
  }elseif (isset($_GET['custom'])){
      $Qcheck = smn_db_query('select help_id from ' . TABLE_HELP . ' where help_file = "false" and help_file_tab = "false" and help_custom = "' . $_GET['custom'] . '"');
      $errMsg = 'Sorry There Is No Help Available For This Custom Tag';
  }else{
      $Qcheck = smn_db_query('select help_id from ' . TABLE_HELP . ' where help_file = "' . $_GET['page'] . '" and help_file_tab = "false" and help_custom = "false"');
      $errMsg = 'Sorry There Is No Help Available For This Page';
  }
  
  if (smn_db_num_rows($Qcheck)){
      $help = smn_db_fetch_array($Qcheck);
      $Qcontent = smn_db_query('select help_content from ' . TABLE_HELP_CONTENT . ' where language_id = "1" and help_id = "' . $help['help_id'] . '"');
      $content = smn_db_fetch_array($Qcontent);
      echo stripslashes($content['help_content']);
  }else{
      echo $errMsg;
  }
  exit;
?>