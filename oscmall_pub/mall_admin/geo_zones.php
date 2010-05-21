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

  $saction = (isset($_GET['saction']) ? $_GET['saction'] : '');

  if (smn_not_null($saction)) {
    switch ($saction) {
      case 'insert_sub':
        $zID = smn_db_prepare_input($_GET['zID']);
        $zone_country_id = smn_db_prepare_input($_POST['zone_country_id']);
        $zone_id = smn_db_prepare_input($_POST['zone_id']);

        smn_db_query("insert into " . TABLE_ZONES_TO_GEO_ZONES . " (store_id, zone_country_id, zone_id, geo_zone_id, date_added) values ('" . (int)$store_id . "', '" . (int)$zone_country_id . "', '" . (int)$zone_id . "', '" . (int)$zID . "', now())");
        $new_subzone_id = smn_db_insert_id();

        smn_redirect(smn_href_link(FILENAME_GEO_ZONES, 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID'] . '&action=list&spage=' . $_GET['spage'] . '&sID=' . $new_subzone_id));
        break;
      case 'save_sub':
        $sID = smn_db_prepare_input($_GET['sID']);
        $zID = smn_db_prepare_input($_GET['zID']);
        $zone_country_id = smn_db_prepare_input($_POST['zone_country_id']);
        $zone_id = smn_db_prepare_input($_POST['zone_id']);

        smn_db_query("update " . TABLE_ZONES_TO_GEO_ZONES . " set geo_zone_id = '" . (int)$zID . "', zone_country_id = '" . (int)$zone_country_id . "', zone_id = " . (smn_not_null($zone_id) ? "'" . (int)$zone_id . "'" : 'null') . ", last_modified = now() where association_id = '" . (int)$sID . "' and store_id = '" . $store_id . "'");

        smn_redirect(smn_href_link(FILENAME_GEO_ZONES, 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID'] . '&action=list&spage=' . $_GET['spage'] . '&sID=' . $_GET['sID']));
        break;
      case 'deleteconfirm_sub':
        $sID = smn_db_prepare_input($_GET['sID']);

        smn_db_query("delete from " . TABLE_ZONES_TO_GEO_ZONES . " where association_id = '" . (int)$sID . "' and store_id = '" . $store_id . "'");

        smn_redirect(smn_href_link(FILENAME_GEO_ZONES, 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID'] . '&action=list&spage=' . $_GET['spage']));
        break;
    }
  }

  $action = (isset($_GET['action']) ? $_GET['action'] : '');

  if (smn_not_null($action)) {
    switch ($action) {
      case 'insert_zone':
        $geo_zone_name = smn_db_prepare_input($_POST['geo_zone_name']);
        $geo_zone_description = smn_db_prepare_input($_POST['geo_zone_description']);

        smn_db_query("insert into " . TABLE_GEO_ZONES . " (store_id, geo_zone_name, geo_zone_description, date_added) values ('" . smn_db_input($store_id) . "', '" . smn_db_input($geo_zone_name) . "', '" . smn_db_input($geo_zone_description) . "', now())");
        $new_zone_id = smn_db_insert_id();

        smn_redirect(smn_href_link(FILENAME_GEO_ZONES, 'zpage=' . $_GET['zpage'] . '&zID=' . $new_zone_id));
        break;
      case 'save_zone':
        $zID = smn_db_prepare_input($_GET['zID']);
        $geo_zone_name = smn_db_prepare_input($_POST['geo_zone_name']);
        $geo_zone_description = smn_db_prepare_input($_POST['geo_zone_description']);

        smn_db_query("update " . TABLE_GEO_ZONES . " set geo_zone_name = '" . smn_db_input($geo_zone_name) . "', geo_zone_description = '" . smn_db_input($geo_zone_description) . "', last_modified = now() where geo_zone_id = '" . (int)$zID . "' and store_id = '" . $store_id . "'");

        smn_redirect(smn_href_link(FILENAME_GEO_ZONES, 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID']));
        break;
      case 'deleteconfirm_zone':
        $zID = smn_db_prepare_input($_GET['zID']);

        smn_db_query("delete from " . TABLE_GEO_ZONES . " where geo_zone_id = '" . (int)$zID . "' and store_id = '" . $store_id . "'");
        smn_db_query("delete from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . (int)$zID . "' and store_id = '" . $store_id . "'");

        smn_redirect(smn_href_link(FILENAME_GEO_ZONES, 'zpage=' . $_GET['zpage']));
        break;
    }
  }
  
  $content_page = basename($_SERVER['PHP_SELF']);
  
  require('templates/default/layout.php');

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>