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
        $tax_zone_id = smn_db_prepare_input($_POST['tax_zone_id']);
        $tax_class_id = smn_db_prepare_input($_POST['tax_class_id']);
        $tax_rate = smn_db_prepare_input($_POST['tax_rate']);
        $tax_description = smn_db_prepare_input($_POST['tax_description']);
        $tax_priority = smn_db_prepare_input($_POST['tax_priority']);

        smn_db_query("insert into " . TABLE_TAX_RATES . " (store_id, tax_zone_id, tax_class_id, tax_rate, tax_description, tax_priority, date_added) values ('" . (int)$store_id . "', '" . (int)$tax_zone_id . "', '" . (int)$tax_class_id . "', '" . smn_db_input($tax_rate) . "', '" . smn_db_input($tax_description) . "', '" . smn_db_input($tax_priority) . "', now())");

        smn_redirect(smn_href_link(FILENAME_TAX_RATES));
        break;
      case 'save':
        $tax_rates_id = smn_db_prepare_input($_GET['tID']);
        $tax_zone_id = smn_db_prepare_input($_POST['tax_zone_id']);
        $tax_class_id = smn_db_prepare_input($_POST['tax_class_id']);
        $tax_rate = smn_db_prepare_input($_POST['tax_rate']);
        $tax_description = smn_db_prepare_input($_POST['tax_description']);
        $tax_priority = smn_db_prepare_input($_POST['tax_priority']);

        smn_db_query("update " . TABLE_TAX_RATES . " set tax_rates_id = '" . (int)$tax_rates_id . "', tax_zone_id = '" . (int)$tax_zone_id . "', tax_class_id = '" . (int)$tax_class_id . "', tax_rate = '" . smn_db_input($tax_rate) . "', tax_description = '" . smn_db_input($tax_description) . "', tax_priority = '" . smn_db_input($tax_priority) . "', last_modified = now() where tax_rates_id = '" . (int)$tax_rates_id . "' and store_id = '" . $store_id ."'");

        smn_redirect(smn_href_link(FILENAME_TAX_RATES, 'page=' . $_GET['page'] . '&tID=' . $tax_rates_id));
        break;
      case 'deleteconfirm':
        $tax_rates_id = smn_db_prepare_input($_GET['tID']);

        smn_db_query("delete from " . TABLE_TAX_RATES . " where tax_rates_id = '" . (int)$tax_rates_id . "' and store_id = '" . $store_id ."'");

        smn_redirect(smn_href_link(FILENAME_TAX_RATES, 'page=' . $_GET['page']));
        break;
    }
  }
  
  $content_page = basename($_SERVER['PHP_SELF']);
  
  require('templates/default/layout.php');

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>