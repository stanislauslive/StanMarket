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

   global $page_name; 


      // include the language translations
  require(DIR_WS_LANGUAGES . 'english.php');


  if (!smn_session_is_registered('customer_id')) {
    $navigation->set_snapshot();
    smn_redirect(smn_href_link(FILENAME_LOGIN, '', 'NONSSL'));
  }

  if (isset($_GET['action']) && ($_GET['action'] == 'update_notifications')) {
    $products = $_POST['products'];
    $remove = '';
    for ($i=0, $n=sizeof($products); $i<$n; $i++) {
      $remove .= '\'' . $products[$i] . '\',';
    }
    $remove = substr($remove, 0, -1);

    if (smn_not_null($remove)) {
      smn_db_query("delete from " . TABLE_PRODUCTS_NOTIFICATIONS . " where customers_id = '" . $customer_id . "' and products_id in (" . $remove . ")");
    }

    smn_redirect(smn_href_link(FILENAME_PRODUCT_NOTIFICATIONS, '', 'NONSSL'));
  } elseif (isset($_GET['action']) && ($_GET['action'] == 'global_notify')) {
    if (isset($_POST['global']) && ($_POST['global'] == 'enable')) {
      smn_db_query("update " . TABLE_CUSTOMERS_INFO . " set global_product_notifications = '1' where customers_info_id = '" . $customer_id . "'");
    } else {
      $check_query = smn_db_query("select count(*) as count from " . TABLE_CUSTOMERS_INFO . " where customers_info_id = '" . $customer_id . "' and global_product_notifications = '1'");
      $check = smn_db_fetch_array($check_query);
      if ($check['count'] > 0) {
        smn_db_query("update " . TABLE_CUSTOMERS_INFO . " set global_product_notifications = '0' where customers_info_id = '" . $customer_id . "'");
      }
    }

    smn_redirect(smn_href_link(FILENAME_PRODUCT_NOTIFICATIONS, '', 'NONSSL'));
  }

  $breadcrumb->add(NAVBAR_TITLE_1, smn_href_link(FILENAME_ACCOUNT, '', 'NONSSL'));
  $breadcrumb->add(NAVBAR_TITLE_2, smn_href_link(FILENAME_PRODUCT_NOTIFICATIONS, '', 'NONSSL'));

  $global_status_query = smn_db_query("select global_product_notifications from " . TABLE_CUSTOMERS_INFO . " where customers_info_id = '" . $customer_id . "'");
  $global_status = smn_db_fetch_array($global_status_query);
?>