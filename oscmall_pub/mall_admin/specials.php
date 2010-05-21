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

  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

  $action = (isset($_GET['action']) ? $_GET['action'] : '');

  if (smn_not_null($action)) {
    switch ($action) {
      case 'setflag':
        smn_set_specials_status($_GET['id'], $_GET['flag']);

        smn_redirect(smn_href_link(FILENAME_SPECIALS, (isset($_GET['page']) ? 'page=' . $_GET['page'] . '&' : '') . 'sID=' . $_GET['id'], 'NONSSL'));
        break;
      case 'insert':
        $products_id = smn_db_prepare_input($_POST['products_id']);
        $products_price = smn_db_prepare_input($_POST['products_price']);
        $specials_price = smn_db_prepare_input($_POST['specials_price']);
        $day = smn_db_prepare_input($_POST['day']);
        $month = smn_db_prepare_input($_POST['month']);
        $year = smn_db_prepare_input($_POST['year']);

        if (substr($specials_price, -1) == '%') {
          $new_special_insert_query = smn_db_query("select products_id, products_price from " . TABLE_PRODUCTS . " where products_id = '" . (int)$products_id . "' and store_id = '" . $store_id . "'");
          $new_special_insert = smn_db_fetch_array($new_special_insert_query);

          $products_price = $new_special_insert['products_price'];
          $specials_price = ($products_price - (($specials_price / 100) * $products_price));
        }

        $expires_date = '';
        if (smn_not_null($day) && smn_not_null($month) && smn_not_null($year)) {
          $expires_date = $year;
          $expires_date .= (strlen($month) == 1) ? '0' . $month : $month;
          $expires_date .= (strlen($day) == 1) ? '0' . $day : $day;
        }

        smn_db_query("insert into " . TABLE_SPECIALS . " (products_id, specials_new_products_price, specials_date_added, expires_date, status, store_id) values ('" . (int)$products_id . "', '" . smn_db_input($specials_price) . "', now(), '" . smn_db_input($expires_date) . "', '1',  '" . smn_db_input($store_id ) . "')");

        smn_redirect(smn_href_link(FILENAME_SPECIALS, 'page=' . $_GET['page']));
        break;
      case 'update':
        $specials_id = smn_db_prepare_input($_POST['specials_id']);
        $products_price = smn_db_prepare_input($_POST['products_price']);
        $specials_price = smn_db_prepare_input($_POST['specials_price']);
        $day = smn_db_prepare_input($_POST['day']);
        $month = smn_db_prepare_input($_POST['month']);
        $year = smn_db_prepare_input($_POST['year']);

        if (substr($specials_price, -1) == '%') $specials_price = ($products_price - (($specials_price / 100) * $products_price));

        $expires_date = '';
        if (smn_not_null($day) && smn_not_null($month) && smn_not_null($year)) {
          $expires_date = $year;
          $expires_date .= (strlen($month) == 1) ? '0' . $month : $month;
          $expires_date .= (strlen($day) == 1) ? '0' . $day : $day;
        }

        smn_db_query("update " . TABLE_SPECIALS . " set specials_new_products_price = '" . smn_db_input($specials_price) . "', specials_last_modified = now(), expires_date = '" . smn_db_input($expires_date) . "' where specials_id = '" . (int)$specials_id . "' and store_id = '" . $store_id . "'");

        smn_redirect(smn_href_link(FILENAME_SPECIALS, 'page=' . $_GET['page'] . '&sID=' . $specials_id));
        break;
      case 'deleteconfirm':
        $specials_id = smn_db_prepare_input($_GET['sID']);

        smn_db_query("delete from " . TABLE_SPECIALS . " where specials_id = '" . (int)$specials_id . "' and store_id = '" . $store_id . "'");

        smn_redirect(smn_href_link(FILENAME_SPECIALS, 'page=' . $_GET['page']));
        break;
    }
  }
  
  $content_page = basename($_SERVER['PHP_SELF']);
  
  require('templates/default/layout.php');

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>