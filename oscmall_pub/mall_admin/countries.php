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

  $action = (isset($_GET['action']) ? $_GET['action'] : '');

  if (smn_not_null($action)) {
    switch ($action) {
      case 'insert':
        $countries_name = smn_db_prepare_input($_POST['countries_name']);
        $countries_iso_code_2 = smn_db_prepare_input($_POST['countries_iso_code_2']);
        $countries_iso_code_3 = smn_db_prepare_input($_POST['countries_iso_code_3']);
        $address_format_id = smn_db_prepare_input($_POST['address_format_id']);

        smn_db_query("insert into " . TABLE_COUNTRIES . " (countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('" . smn_db_input($countries_name) . "', '" . smn_db_input($countries_iso_code_2) . "', '" . smn_db_input($countries_iso_code_3) . "', '" . (int)$address_format_id . "')");

        smn_redirect(smn_href_link(FILENAME_COUNTRIES));
        break;
      case 'save':
        $countries_id = smn_db_prepare_input($_GET['cID']);
        $countries_name = smn_db_prepare_input($_POST['countries_name']);
        $countries_iso_code_2 = smn_db_prepare_input($_POST['countries_iso_code_2']);
        $countries_iso_code_3 = smn_db_prepare_input($_POST['countries_iso_code_3']);
        $address_format_id = smn_db_prepare_input($_POST['address_format_id']);

        smn_db_query("update " . TABLE_COUNTRIES . " set countries_name = '" . smn_db_input($countries_name) . "', countries_iso_code_2 = '" . smn_db_input($countries_iso_code_2) . "', countries_iso_code_3 = '" . smn_db_input($countries_iso_code_3) . "', address_format_id = '" . (int)$address_format_id . "' where countries_id = '" . (int)$countries_id . "'");

        smn_redirect(smn_href_link(FILENAME_COUNTRIES, 'page=' . $_GET['page'] . '&cID=' . $countries_id));
        break;
      case 'deleteconfirm':
        $countries_id = smn_db_prepare_input($_GET['cID']);

        smn_db_query("delete from " . TABLE_COUNTRIES . " where countries_id = '" . (int)$countries_id . "'");

        smn_redirect(smn_href_link(FILENAME_COUNTRIES, 'page=' . $_GET['page']));
        break;
    }
  }
  
  $content_page = basename($_SERVER['PHP_SELF']);
  
  require('templates/default/layout.php');

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>