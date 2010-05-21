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


  if ($_GET['action'])
  {
    switch ($_GET['action'])
    {
    case 'update':
            $template_id = smn_db_prepare_input($_GET['tID']);
	    smn_db_query("update " . TABLE_CONFIGURATION . " set configuration_value = '" . $template_id . "', last_modified = now() where configuration_key = 'TEMPLATE_ID' and store_id = '" . $store_id . "'");
	    smn_redirect(smn_href_link( FILENAME_TEMPLATE,  'tID='   . $_GET['tID'])); 
    break;
        
    case 'insert':
      if($store_id != 1){
	smn_redirect(smn_href_link( FILENAME_TEMPLATE,  'tID='   . $_GET['tID'])); 
      }
        if (isset($_POST['template_name'])){
        $directory = $_POST['template_name'];
        $install_data_file = DIR_FS_CATALOG . 'includes/template/'. $directory . '/install.sql';
            if ( $data = fopen($install_data_file, 'r')) {
	      fseek($data, 0);
	      $template_data = fread($data, filesize($install_data_file));
	      $insert_data_array = explode('/n', $template_data);
	      foreach($insert_data_array as $insert) {
                smn_db_query($insert);
	      }
	      fclose($data);
            }else{
	      echo ('Can not find file <b>' . $install_data_file . '</b> please make sure you entered the correct directory name.');
            }
        }else{
        smn_redirect(smn_href_link( FILENAME_TEMPLATE,  'tID='   . $_GET['tID']));    
        }
    break;
    }
  }    
  $template_query = smn_db_query("select * from " . TABLE_TEMPLATE);
  
  $content_page = basename($_SERVER['PHP_SELF']);
  
  require('templates/default/layout.php');

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>