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
        $tax_class_title = smn_db_prepare_input($_POST['tax_class_title']);
        $tax_class_description = smn_db_prepare_input($_POST['tax_class_description']);

        smn_db_query("insert into " . TABLE_TAX_CLASS . " (store_id, tax_class_title, tax_class_description, date_added) values ('" . smn_db_input($store_id) . "', '" . smn_db_input($tax_class_title) . "', '" . smn_db_input($tax_class_description) . "', now())");

        smn_redirect(smn_href_link(FILENAME_TAX_CLASSES));
        break;
      case 'save':
        $tax_class_id = smn_db_prepare_input($_GET['tID']);
        $tax_class_title = smn_db_prepare_input($_POST['tax_class_title']);
        $tax_class_description = smn_db_prepare_input($_POST['tax_class_description']);

        smn_db_query("update " . TABLE_TAX_CLASS . " set tax_class_id = '" . (int)$tax_class_id . "', tax_class_title = '" . smn_db_input($tax_class_title) . "', tax_class_description = '" . smn_db_input($tax_class_description) . "', last_modified = now() where tax_class_id = '" . (int)$tax_class_id . "' and store_id = '" . $store_id ."'");

        smn_redirect(smn_href_link(FILENAME_TAX_CLASSES, 'page=' . $_GET['page'] . '&tID=' . $tax_class_id));
        break;
      case 'deleteconfirm':
        $tax_class_id = smn_db_prepare_input($_GET['tID']);

        smn_db_query("delete from " . TABLE_TAX_CLASS . " where tax_class_id = '" . (int)$tax_class_id . "' and store_id = '" . $store_id ."'");

        smn_redirect(smn_href_link(FILENAME_TAX_CLASSES, 'page=' . $_GET['page']));
        break;
    }
  }
  
  $content_page = basename($_SERVER['PHP_SELF']);
  
  require('templates/default/layout.php');

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>