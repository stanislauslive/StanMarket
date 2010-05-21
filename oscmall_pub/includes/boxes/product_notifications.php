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

  if (isset($_GET['products_id'])) {

    $boxHeading = BOX_HEADING_NOTIFICATIONS;
    $boxLink = '<a href="' . smn_href_link(FILENAME_ACCOUNT_NOTIFICATIONS, '', 'NONSSL') . '"><img src="images/infobox/arrow_right.gif" border="0" alt="more" title=" more " width="12" height="10"></a>';
    $box_base_name = 'product_notifications';
    $box_id = $box_base_name . 'Box';
    if (smn_session_is_registered('customer_id')) {
      $check_query = smn_db_query("select count(*) as count from " . TABLE_PRODUCTS_NOTIFICATIONS . " where products_id = '" . (int)$_GET['products_id'] . "' and customers_id = '" . (int)$customer_id . "'");
      $check = smn_db_fetch_array($check_query);

      $notification_exists = (($check['count'] > 0) ? true : false);
    } else {
      $notification_exists = false;
    }

    if ($notification_exists == true) {
      $boxContent = '<table border="0" cellspacing="0" cellpadding="2"><tr><td class="infoBoxContents"><a href="' . smn_href_link(basename($PHP_SELF), smn_get_all_get_params(array('action')) . 'action=notify_remove', $request_type) . '">' . smn_image(DIR_WS_IMAGES . 'box_products_notifications_remove.gif', IMAGE_BUTTON_REMOVE_NOTIFICATIONS) . '</a></td><td class="infoBoxContents"><a href="' . smn_href_link(basename($PHP_SELF), smn_get_all_get_params(array('action')) . 'action=notify_remove', $request_type) . '">' . sprintf(BOX_NOTIFICATIONS_NOTIFY_REMOVE, smn_get_products_name($_GET['products_id'])) .'</a></td></tr></table>';
    } else {
      $boxContent = '<table border="0" cellspacing="0" cellpadding="2"><tr><td class="infoBoxContents"><a href="' . smn_href_link(basename($PHP_SELF), smn_get_all_get_params(array('action')) . 'action=notify', $request_type) . '">' . smn_image(DIR_WS_IMAGES . 'box_products_notifications.gif', IMAGE_BUTTON_NOTIFICATIONS) . '</a></td><td class="infoBoxContents"><a href="' . smn_href_link(basename($PHP_SELF), smn_get_all_get_params(array('action')) . 'action=notify', $request_type) . '">' . sprintf(BOX_NOTIFICATIONS_NOTIFY, smn_get_products_name($_GET['products_id'])) .'</a></td></tr></table>';
    }
  if(file_exists(DIR_WS_BOX_TEMPLATES . $box_base_name . '.php')){
      require(DIR_WS_BOX_TEMPLATES . $box_base_name . '.php');
  }else {
      require(DEFAULT_TEMPLATENAME_BOX);
  }
  $boxContent_attributes = '';

    $boxLink = '';
  }
?>
