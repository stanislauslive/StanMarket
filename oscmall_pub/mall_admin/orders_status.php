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
      case 'save':
        if (isset($_GET['oID'])) $orders_status_id = smn_db_prepare_input($_GET['oID']);

        $languages = smn_get_languages();
        for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
          $orders_status_name_array = $_POST['orders_status_name'];
          $language_id = $languages[$i]['id'];

          $sql_data_array = array('orders_status_name' => smn_db_prepare_input($orders_status_name_array[$language_id]), 
                                  'public_flag' => ((isset($HTTP_POST_VARS['public_flag']) && ($HTTP_POST_VARS['public_flag'] == '1')) ? '1' : '0'), 
                                  'downloads_flag' => ((isset($HTTP_POST_VARS['downloads_flag']) && ($HTTP_POST_VARS['downloads_flag'] == '1')) ? '1' : '0')); 

          if ($action == 'insert') {
            if (empty($orders_status_id)) {
              $next_id_query = smn_db_query("select max(orders_status_id) as orders_status_id from " . TABLE_ORDERS_STATUS . "");
              $next_id = smn_db_fetch_array($next_id_query);
              $orders_status_id = $next_id['orders_status_id'] + 1;
            }

            $insert_sql_data = array('orders_status_id' => $orders_status_id,
                                     'language_id' => $language_id);

            $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

            smn_db_perform(TABLE_ORDERS_STATUS, $sql_data_array);
          } elseif ($action == 'save') {
            smn_db_perform(TABLE_ORDERS_STATUS, $sql_data_array, 'update', "orders_status_id = '" . (int)$orders_status_id . "' and language_id = '" . (int)$language_id . "'");
          }
        }

        if (isset($_POST['default']) && ($_POST['default'] == 'on')) {
          smn_db_query("update " . TABLE_CONFIGURATION . " set configuration_value = '" . smn_db_input($orders_status_id) . "' where configuration_key = 'DEFAULT_ORDERS_STATUS_ID'");
        }

        smn_redirect(smn_href_link(FILENAME_ORDERS_STATUS, 'page=' . $_GET['page'] . '&oID=' . $orders_status_id));
        break;
      case 'deleteconfirm':
        $oID = smn_db_prepare_input($_GET['oID']);

        $orders_status_query = smn_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'DEFAULT_ORDERS_STATUS_ID'");
        $orders_status = smn_db_fetch_array($orders_status_query);

        if ($orders_status['configuration_value'] == $oID) {
          smn_db_query("update " . TABLE_CONFIGURATION . " set configuration_value = '' where configuration_key = 'DEFAULT_ORDERS_STATUS_ID'");
        }

        smn_db_query("delete from " . TABLE_ORDERS_STATUS . " where orders_status_id = '" . smn_db_input($oID) . "'");

        smn_redirect(smn_href_link(FILENAME_ORDERS_STATUS, 'page=' . $_GET['page']));
        break;
      case 'delete':
        $oID = smn_db_prepare_input($_GET['oID']);

        $status_query = smn_db_query("select count(*) as count from " . TABLE_ORDERS . " where orders_status = '" . (int)$oID . "'");
        $status = smn_db_fetch_array($status_query);

        $remove_status = true;
        if ($oID == DEFAULT_ORDERS_STATUS_ID) {
          $remove_status = false;
          $messageStack->add(ERROR_REMOVE_DEFAULT_ORDER_STATUS, 'error');
        } elseif ($status['count'] > 0) {
          $remove_status = false;
          $messageStack->add(ERROR_STATUS_USED_IN_ORDERS, 'error');
        } else {
          $history_query = smn_db_query("select count(*) as count from " . TABLE_ORDERS_STATUS_HISTORY . " where orders_status_id = '" . (int)$oID . "'");
          $history = smn_db_fetch_array($history_query);
          if ($history['count'] > 0) {
            $remove_status = false;
            $messageStack->add(ERROR_STATUS_USED_IN_HISTORY, 'error');
          }
        }
        break;
    }
  }
  
  $content_page = basename($_SERVER['PHP_SELF']);
  
  require('templates/default/layout.php');

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>