<?php
/*
  Copyright (c) 2004 SystemsManager.Net
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
        $zone_country_id = smn_db_prepare_input($_POST['zone_country_id']);
        $zone_code = smn_db_prepare_input($_POST['zone_code']);
        $zone_name = smn_db_prepare_input($_POST['zone_name']);

        smn_db_query("insert into " . TABLE_ZONES . " (zone_country_id, zone_code, zone_name) values ('" . (int)$zone_country_id . "', '" . smn_db_input($zone_code) . "', '" . smn_db_input($zone_name) . "')");

        smn_redirect(smn_href_link(FILENAME_ZONES));
        break;
      case 'save':
        $zone_id = smn_db_prepare_input($_GET['cID']);
        $zone_country_id = smn_db_prepare_input($_POST['zone_country_id']);
        $zone_code = smn_db_prepare_input($_POST['zone_code']);
        $zone_name = smn_db_prepare_input($_POST['zone_name']);

        smn_db_query("update " . TABLE_ZONES . " set zone_country_id = '" . (int)$zone_country_id . "', zone_code = '" . smn_db_input($zone_code) . "', zone_name = '" . smn_db_input($zone_name) . "' where zone_id = '" . (int)$zone_id . "'");

        smn_redirect(smn_href_link(FILENAME_ZONES, 'page=' . $_GET['page'] . '&cID=' . $zone_id));
        break;
      case 'deleteconfirm':
        $zone_id = smn_db_prepare_input($_GET['cID']);

        smn_db_query("delete from " . TABLE_ZONES . " where zone_id = '" . (int)$zone_id . "'");

        smn_redirect(smn_href_link(FILENAME_ZONES, 'page=' . $_GET['page']));
        break;
    }
  }
  
  $content_page = basename($_SERVER['PHP_SELF']);
  
  require('templates/default/layout.php');

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>