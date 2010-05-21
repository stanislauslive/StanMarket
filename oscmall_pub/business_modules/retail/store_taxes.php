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

  if (!smn_session_is_registered('customer_id')) {
    //$navigation->set_snapshot();
    smn_redirect(smn_href_link(FILENAME_LOGIN, 'ID=' . $store_id, 'NONSSL'));
  }

  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  
  if (smn_not_null($action)){
     switch($action){
         case 'getZones':
             $country = $_GET['country'];
             $Qzones = smn_db_query("select zone_id, zone_name from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country . "' order by zone_name");
             if (smn_db_num_rows($Qzones)){
                 $zones_array = array();
                 while ($zones = smn_db_fetch_array($Qzones)) {
                     $zones_array[] = '"' . $zones['zone_id'] . '": "' . $zones['zone_name'] . '"';
                 }
                 echo '{
                     success: true,
                     hasZones: true,
                     zones: {' . 
                             implode(',', $zones_array) . 
                     '}
                 }';
             }else{
                 echo '{ 
                     success: true,
                     hasZones: false
                 }';
             }
             exit;
         break;
         case 'subZonesListing':
             $geo_zone_id = smn_db_prepare_input($_GET['geo_zone_id']);
             $content = array();
             
             $zones_query = smn_db_query("select a.association_id, a.zone_country_id, c.countries_name, a.zone_id, a.geo_zone_id, a.last_modified, a.date_added, z.zone_name from " . TABLE_ZONES_TO_GEO_ZONES . " a left join " . TABLE_COUNTRIES . " c on a.zone_country_id = c.countries_id left join " . TABLE_ZONES . " z on a.zone_id = z.zone_id where a.geo_zone_id = " . $geo_zone_id . "  and a.store_id = '" . $store_id . "'order by association_id");
             while ($zones = smn_db_fetch_array($zones_query)) {
                 $content[] = '{
                      association_id: "' . $zones['association_id'] . '", 
                      zone_country_id: "' . $zones['zone_country_id'] . '", 
                      countries_name: "' . addslashes($zones['countries_name']) . '", 
                      zone_id: "' . $zones['zone_id'] . '",
                      geo_zone_id: "' . $zones['geo_zone_id'] . '",
                      last_modified: "' . $zones['last_modified'] . '",
                      date_added: "' . $zones['date_added'] . '",
                      zone_name: "' . addslashes($zones['zone_name']) . '"
                 }';
             }
             echo '{
                 success: true,
                 totalCount: ' . smn_db_num_rows($zones_query) . ',
                 arr: [' . implode(',', $content) . ']
             }';
             exit;
         break;
         case 'saveClass':
             $tax_class_title = smn_db_prepare_input($_POST['tax_class_title']);
             $tax_class_description = smn_db_prepare_input($_POST['tax_class_description']);
             
             if ($_POST['hidden_action'] == 'edit' && $_POST['tax_class_id'] > 0){
                 smn_db_query("update " . TABLE_TAX_CLASS . " set tax_class_title = '" . smn_db_input($tax_class_title) . "', tax_class_description = '" . smn_db_input($tax_class_description) . "', last_modified = now() where store_id = '" . smn_db_input($store_id) . "' and tax_class_id = '" . $_POST['tax_class_id'] . "'");
                 $tax_class_id = $_POST['tax_class_id'];
             }else{
                 smn_db_query("insert into " . TABLE_TAX_CLASS . " (store_id, tax_class_title, tax_class_description, date_added) values ('" . smn_db_input($store_id) . "', '" . smn_db_input($tax_class_title) . "', '" . smn_db_input($tax_class_description) . "', now())");
                 $tax_class_id = smn_db_insert_id();
             }
             
             $Qclass = smn_db_query('select * from ' . TABLE_TAX_CLASS . ' where tax_class_id = "' . $tax_class_id . '"');
             $class = smn_db_fetch_array($Qclass);
             echo '{
                 success: true,
                 db: {
                   tax_class_id  : "' . $class['tax_class_id'] . '",
                   tax_class_title  : "' . addslashes($class['tax_class_title']) . '",
                   tax_class_description  : "' . addslashes($class['tax_class_description']) . '",
                   last_modified  : "' . $class['last_modified'] . '",
                   date_added  : "' . $class['date_added'] . '"
                 }
             }';
             exit;
         break;
         case 'deleteClass':
             $tax_class_id = smn_db_prepare_input($_GET['class_id']);

             smn_db_query("delete from " . TABLE_TAX_CLASS . " where tax_class_id = '" . (int)$tax_class_id . "' and store_id = '" . $store_id ."'");
             if (mysql_affected_rows() > 0){
                 echo '{success: true}';
             }else{
                 echo '{success: false}';
             }
             exit;
         break;
         case 'saveZone':
             $geo_zone_name = smn_db_prepare_input($_POST['geo_zone_name']);
             $geo_zone_description = smn_db_prepare_input($_POST['geo_zone_description']);
             
             if ($_POST['hidden_action'] == 'edit' && $_POST['geo_zone_id'] > 0){
                 smn_db_query("update " . TABLE_GEO_ZONES . " set geo_zone_name = '" . smn_db_input($geo_zone_name) . "', geo_zone_description = '" . smn_db_input($geo_zone_description) . "', last_modified = now() where store_id = '" . smn_db_input($store_id) . "' and geo_zone_id = '" . $_POST['geo_zone_id'] . "'");
                 $zone_id = $_POST['geo_zone_id'];
             }else{
                 smn_db_query("insert into " . TABLE_GEO_ZONES . " (store_id, geo_zone_name, geo_zone_description, date_added) values ('" . smn_db_input($store_id) . "', '" . smn_db_input($geo_zone_name) . "', '" . smn_db_input($geo_zone_description) . "', now())");
                 $zone_id = smn_db_insert_id();
             }
             
             $Qzone = smn_db_query('select * from ' . TABLE_GEO_ZONES . ' where geo_zone_id = "' . $zone_id . '"');
             $zone = smn_db_fetch_array($Qzone);
             echo '{
                 success: true,
                 db: {
                   geo_zone_id  : "' . $zone['geo_zone_id'] . '",
                   geo_zone_name  : "' . $zone['geo_zone_name'] . '",
                   geo_zone_description  : "' . $zone['geo_zone_description'] . '",
                   last_modified  : "' . $zone['last_modified'] . '",
                   date_added  : "' . $zone['date_added'] . '"
                 }
             }';
             exit;
         break;
         case 'deleteZone':
             $geo_zone_id = smn_db_prepare_input($_GET['zone_id']);

             smn_db_query("delete from " . TABLE_GEO_ZONES . " where geo_zone_id = '" . (int)$geo_zone_id . "' and store_id = '" . $store_id . "'");
             smn_db_query("delete from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . (int)$geo_zone_id . "' and store_id = '" . $store_id . "'");
             
             echo '{ success:true }';
             exit;
         break;
         case 'saveRate':
             $tax_zone_id = smn_db_prepare_input($_POST['tax_zone_id']);
             $tax_class_id = smn_db_prepare_input($_POST['tax_class_id']);
             $tax_rate = smn_db_prepare_input($_POST['tax_rate']);
             $tax_description = smn_db_prepare_input($_POST['tax_description']);
             $tax_priority = smn_db_prepare_input($_POST['tax_priority']);

             if ($_POST['hidden_action'] == 'edit' && $_POST['tax_rates_id'] > 0){
                 smn_db_query("update " . TABLE_TAX_RATES . " set tax_zone_id = '" . (int)$tax_zone_id . "', tax_class_id = '" . (int)$tax_class_id . "', tax_rate = '" . smn_db_input($tax_rate) . "', tax_description = '" . smn_db_input($tax_description) . "', tax_priority = '" . smn_db_input($tax_priority) . "', last_modified = now() where tax_rates_id = '" . (int)$_POST['tax_rates_id'] . "' and store_id = '" . $store_id ."'");
                 $tax_rate_id = $_POST['tax_rates_id'];
             }else{
                 smn_db_query("insert into " . TABLE_TAX_RATES . " (store_id, tax_zone_id, tax_class_id, tax_rate, tax_description, tax_priority, date_added) values ('" . (int)$store_id . "', '" . (int)$tax_zone_id . "', '" . (int)$tax_class_id . "', '" . smn_db_input($tax_rate) . "', '" . smn_db_input($tax_description) . "', '" . smn_db_input($tax_priority) . "', now())");
                 $tax_rate_id = smn_db_insert_id();
             }
             
             $Qrate = smn_db_query("select r.tax_rates_id, z.geo_zone_id, z.geo_zone_name, tc.tax_class_title, tc.tax_class_id, r.tax_priority, r.tax_rate, r.tax_description, r.date_added, r.last_modified from " . TABLE_TAX_CLASS . " tc, " . TABLE_TAX_RATES . " r left join " . TABLE_GEO_ZONES . " z on r.tax_zone_id = z.geo_zone_id where tax_rates_id = '" . $tax_rate_id . "' and r.tax_class_id = tc.tax_class_id and z.store_id = '" . $store_id ."' and r.store_id = '" . $store_id ."' and tc.store_id = '" . $store_id ."'");
             $rate = smn_db_fetch_array($Qrate);
             echo '{
                 success: true,
                 db: {
                   tax_rates_id  : "' . $rate['tax_rates_id'] . '",
                   geo_zone_id  : "' . $rate['geo_zone_id'] . '",
                   geo_zone_name  : "' . addslashes($rate['geo_zone_name']) . '",
                   tax_class_title  : "' . addslashes($rate['tax_class_title']) . '",
                   tax_class_id  : "' . $rate['tax_class_id'] . '",
                   tax_priority  : "' . $rate['tax_priority'] . '",
                   tax_rate  : "' . $rate['tax_rate'] . '",
                   tax_description  : "' . addslashes($rate['tax_description']) . '",
                   last_modified  : "' . $rate['last_modified'] . '",
                   date_added  : "' . $rate['date_added'] . '"
                 }
             }';
             exit;
         break;
         case 'deleteRate':
             $tax_rates_id = smn_db_prepare_input($_GET['rate_id']);

             smn_db_query("delete from " . TABLE_TAX_RATES . " where tax_rates_id = '" . (int)$tax_rates_id . "' and store_id = '" . $store_id ."'");
             
             echo '{ success:true }';
             exit;
         break;
         case 'saveSubZone':
             $geo_zone_id = smn_db_prepare_input($_POST['geo_zone_id']);
             $zone_country_id = smn_db_prepare_input($_POST['zone_country_id']);
             $zone_id = smn_db_prepare_input($_POST['zone_id']);
             
             if ($_POST['hidden_action'] == 'edit' && $_POST['association_id'] > 0){
                 smn_db_query("update " . TABLE_ZONES_TO_GEO_ZONES . " set geo_zone_id = '" . (int)$geo_zone_id . "', zone_country_id = '" . (int)$zone_country_id . "', zone_id = " . (smn_not_null($zone_id) ? "'" . (int)$zone_id . "'" : 'null') . ", last_modified = now() where association_id = '" . (int)$_POST['association_id'] . "' and store_id = '" . $store_id . "'");
                 $association_id = $_POST['association_id'];
             }else{
                 smn_db_query("insert into " . TABLE_ZONES_TO_GEO_ZONES . " (store_id, zone_country_id, zone_id, geo_zone_id, date_added) values ('" . (int)$store_id . "', '" . (int)$zone_country_id . "', '" . (int)$zone_id . "', '" . (int)$geo_zone_id . "', now())");
                 $association_id = smn_db_insert_id();
             }
             
             $Qzone = smn_db_query('select * from ' . TABLE_ZONES_TO_GEO_ZONES . ' where association_id = "' . $association_id . '"');
             $zone = smn_db_fetch_array($Qzone);
             echo '{
                 success: true,
                 db: {
                   association_id  : "' . $zone['association_id'] . '",
                   zone_country_id  : "' . $zone['zone_country_id'] . '",
                   zone_id  : "' . $zone['zone_id'] . '",
                   geo_zone_id  : "' . $zone['geo_zone_id'] . '",
                   last_modified  : "' . $zone['last_modified'] . '",
                   date_added  : "' . $zone['date_added'] . '"
                 }
             }';
             exit;
         break;
         case 'deleteSubZone':
             $association_id = smn_db_prepare_input($_GET['association_id']);

             smn_db_query("delete from " . TABLE_ZONES_TO_GEO_ZONES . " where association_id = '" . (int)$association_id . "' and store_id = '" . $store_id . "'");
             
             echo '{ success:true }';
             exit;
         break;
     }
  }

/* Common Elements For Tabs - BEGIN */
  $commonCancelButton = $jQuery->getPluginClass('button', array(
      'id'   => 'cancel_button',
      'text' => 'Cancel'
  ));
  
  $commonDeleteButton = $jQuery->getPluginClass('button', array(
      'id'   => 'delete_button',
      'text' => 'Delete'
  ));
  
  $commonSaveButton = $jQuery->getPluginClass('button', array(
      'id'   => 'save_button',
      'type' => 'submit',
      'text' => 'Save'
  ));
/* Common Elements For Tabs - END */
  
/* Setup Tabs - BEGIN */
  $jQuery->setGlobalVars(array(
      'languages',
      'languages_id',
      'store_id',
      'commonSaveButton',
      'commonDeleteButton',
      'commonCancelButton'
  ));

  $tabsArray = array();
  $tabsArray[] = array(
      'tabID'    => 'tab-classes',
      'filename' => 'tab_classes.php',
      'text'     => 'Tax Classes'
  );
 
  $tabsArray[] = array(
      'tabID'    => 'tab-rates',
      'filename' => 'tab_rates.php',
      'text'     => 'Tax Rates'
  );
 
  $tabsArray[] = array(
      'tabID'    => 'tab-zones',
      'filename' => 'tab_zones.php',
      'text'     => 'Tax Zones'
  );
 
  $backButton = $jQuery->getPluginClass('button', array(
      'id'   => 'backButton',
      'text' => 'Back To Account',
      'href' => $jQuery->link(FILENAME_ACCOUNT, 'ID=' . $store_id)
  ));
 
  $helpButton = $jQuery->getPluginClass('button', array(
      'id'   => 'helpButton',
      'text' => 'Help',
  ));
    
  $tabPanel = $jQuery->getPluginClass('tabs', array(
      'id'            => 'initialPane',
      'tabDir'        => DIR_FS_CATALOG . DIR_WS_MODULES . 'pages_tabs/taxes/',
      'tabs'          => $tabsArray,
      'footerButtons' => array($backButton, $helpButton),
      'showFooter'    => true
  ));
 
  $tabPanel->setHelpButton('helpButton', true);
/* Setup Tabs - END */

  $breadcrumb->add(NAVBAR_TITLE, smn_href_link(FILENAME_TAXES));
?>