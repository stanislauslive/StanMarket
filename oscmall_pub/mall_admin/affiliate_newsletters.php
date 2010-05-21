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
      case 'lock':
      case 'unlock':
        $affiliate_newsletter_id = smn_db_prepare_input($_GET['nID']);
        $status = (($action == 'lock') ? '1' : '0');

        smn_db_query("update " . TABLE_AFFILIATE_NEWSLETTERS . " set locked = '" . $status . "' where affiliate_newsletters_id = '" . (int)$affiliate_newsletter_id . "'");

        smn_redirect(smn_href_link(FILENAME_AFFILIATE_NEWSLETTERS, 'page=' . $_GET['page'] . '&nID=' . $_GET['nID']));
        break;
      case 'insert':
      case 'update':
        if (isset($_POST['newsletter_id'])) $affiliate_newsletter_id = smn_db_prepare_input($_POST['newsletter_id']);
        $affiliate_newsletter_module = smn_db_prepare_input($_POST['module']);
        $title = smn_db_prepare_input($_POST['title']);
        $content = smn_db_prepare_input($_POST['content']);

        $affiliate_newsletter_error = false;
        if (empty($title)) {
          $messageStack->add(ERROR_NEWSLETTER_TITLE, 'error');
          $affiliate_newsletter_error = true;
        }

        if (empty($module)) {
          $messageStack->add(ERROR_NEWSLETTER_MODULE, 'error');
          $affiliate_newsletter_error = true;
        }

        if ($affiliate_newsletter_error == false) {
          $sql_data_array = array('title' => $title,
                                  'content' => $content,
                                  'module' => $affiliate_newsletter_module);

          if ($action == 'insert') {
            $sql_data_array['date_added'] = 'now()';
            $sql_data_array['status'] = '0';
            $sql_data_array['locked'] = '0';

            smn_db_perform(TABLE_AFFILIATE_NEWSLETTERS, $sql_data_array);
            $affiliate_newsletter_id = smn_db_insert_id();
          } elseif ($action == 'update') {
            smn_db_perform(TABLE_AFFILIATE_NEWSLETTERS, $sql_data_array, 'update', "affiliate_newsletters_id = '" . (int)$affiliate_newsletter_id . "'");
          }

          smn_redirect(smn_href_link(FILENAME_AFFILIATE_NEWSLETTERS, (isset($_GET['page']) ? 'page=' . $_GET['page'] . '&' : '') . 'nID=' . $affiliate_newsletter_id));
        } else {
          $action = 'new';
        }
        break;
      case 'deleteconfirm':
        $affiliate_newsletter_id = smn_db_prepare_input($_GET['nID']);

        smn_db_query("delete from " . TABLE_AFFILIATE_NEWSLETTERS . " where affiliate_newsletters_id = '" . (int)$affiliate_newsletter_id . "'");

        smn_redirect(smn_href_link(FILENAME_AFFILIATE_NEWSLETTERS, 'page=' . $_GET['page']));
        break;
      case 'delete':
      case 'new': if (!isset($_GET['nID'])) break;
      case 'send':
      case 'confirm_send':
        $affiliate_newsletter_id = smn_db_prepare_input($_GET['nID']);

        $check_query = smn_db_query("select locked from " . TABLE_AFFILIATE_NEWSLETTERS . " where affiliate_newsletters_id = '" . (int)$affiliate_newsletter_id . "'");
        $check = smn_db_fetch_array($check_query);

        if ($check['locked'] < 1) {
          switch ($action) {
            case 'delete': $error = ERROR_REMOVE_UNLOCKED_NEWSLETTER; break;
            case 'new': $error = ERROR_EDIT_UNLOCKED_NEWSLETTER; break;
            case 'send': $error = ERROR_SEND_UNLOCKED_NEWSLETTER; break;
            case 'confirm_send': $error = ERROR_SEND_UNLOCKED_NEWSLETTER; break;
          }

          $messageStack->add_session($error, 'error');

          smn_redirect(smn_href_link(FILENAME_AFFILIATE_NEWSLETTERS, 'page=' . $_GET['page'] . '&nID=' . $_GET['nID']));
        }
        break;
    }
  }
  
  $content_page = basename($_SERVER['PHP_SELF']);
  
  require('templates/default/layout.php');

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>