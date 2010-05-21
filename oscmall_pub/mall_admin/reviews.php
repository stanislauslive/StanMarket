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
      case 'update':
        $reviews_id = smn_db_prepare_input($_GET['rID']);
        $reviews_rating = smn_db_prepare_input($_POST['reviews_rating']);
        $reviews_text = smn_db_prepare_input($_POST['reviews_text']);

        smn_db_query("update " . TABLE_REVIEWS . " set reviews_rating = '" . smn_db_input($reviews_rating) . "', last_modified = now() where reviews_id = '" . (int)$reviews_id . "' and store_id = '" . $store_id . "'");
        smn_db_query("update " . TABLE_REVIEWS_DESCRIPTION . " set reviews_text = '" . smn_db_input($reviews_text) . "' where reviews_id = '" . (int)$reviews_id . "' and store_id = '" . $store_id . "'");

        smn_redirect(smn_href_link(FILENAME_REVIEWS, 'page=' . $_GET['page'] . '&rID=' . $reviews_id));
        break;
      case 'deleteconfirm':
        $reviews_id = smn_db_prepare_input($_GET['rID']);

        smn_db_query("delete from " . TABLE_REVIEWS . " where reviews_id = '" . (int)$reviews_id . "' and store_id = '" . $store_id . "'");
        smn_db_query("delete from " . TABLE_REVIEWS_DESCRIPTION . " where reviews_id = '" . (int)$reviews_id . "' and store_id = '" . $store_id . "'");

        smn_redirect(smn_href_link(FILENAME_REVIEWS, 'page=' . $_GET['page']));
        break;
    }
  }
  
  $content_page = basename($_SERVER['PHP_SELF']);
  
  require('templates/default/layout.php');

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>