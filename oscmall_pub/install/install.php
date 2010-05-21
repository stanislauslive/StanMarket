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



  require('includes/application.php');

  $page_file = 'install.php';
  $page_title = 'Installation';

  switch ($_GET['step']) {
    case '2':
      if (osc_in_array('database', $_POST['install'])) {
        $page_contents = 'install_2.php';
      } elseif (osc_in_array('configure', $_POST['install'])) {
        $page_contents = 'install_4.php';
      } else {
        $page_contents = 'install.php';
      }
      break;
    case '3':
      if (osc_in_array('database', $_POST['install'])) {
        $page_contents = 'install_3.php';
      } else {
        $page_contents = 'install.php';
      }
      break;
    case '4':
      if (osc_in_array('configure', $_POST['install'])) {
        $page_contents = 'install_4.php';
      } else {
        $page_contents = 'install.php';
      }
      break;
    case '5':
      if (osc_in_array('configure', $_POST['install'])) {
        if (isset($_POST['ENABLE_SSL']) && ($_POST['ENABLE_SSL'] == 'true')) {
          $page_contents = 'install_5.php';
        } else {
          $page_contents = 'install_6.php';
        }
      } else {
        $page_contents = 'install.php';
      }
      break;
    case '6':
      if (osc_in_array('configure', $_POST['install'])) {
        $page_contents = 'install_6.php';
      } else {
        $page_contents = 'install.php';
      }
      break;
    case '7':
      if (osc_in_array('configure', $_POST['install'])) {
        $page_contents = 'install_7.php';
      } else {
        $page_contents = 'install.php';
      }
      break;
    default:
      $page_contents = 'install.php';
  }

  require('templates/main_page.php');
?>
