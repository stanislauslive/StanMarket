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

  $affiliate_banner_extension = smn_banner_image_extension();

  if ($_GET['action']) {
    switch ($_GET['action']) {
      case 'setaffiliate_flag':
        if ( ($_GET['affiliate_flag'] == '0') || ($_GET['affiliate_flag'] == '1') ) {
          smn_set_banner_status($_GET['abID'], $_GET['affiliate_flag']);
          $messageStack->add_session(SUCCESS_BANNER_STATUS_UPDATED, 'success');
        } else {
          $messageStack->add_session(ERROR_UNKNOWN_STATUS_FLAG, 'error');
        }

        smn_redirect(smn_href_link(FILENAME_AFFILIATE_BANNER_MANAGER, 'selected_box=affiliate&page=' . $_GET['page'] . '&abID=' . $_GET['abID']));
        break;
      case 'insert':
      case 'update':
        $affiliate_banners_id = smn_db_prepare_input($_POST['affiliate_banners_id']);
        $affiliate_banners_title = smn_db_prepare_input($_POST['affiliate_banners_title']);
        $affiliate_products_id  = smn_db_prepare_input($_POST['affiliate_products_id']);
        $new_affiliate_banners_group = smn_db_prepare_input($_POST['new_affiliate_banners_group']);
        $affiliate_banners_group = (empty($new_affiliate_banners_group)) ? smn_db_prepare_input($_POST['affiliate_banners_group']) : $new_affiliate_banners_group;
        $affiliate_banners_image_target = smn_db_prepare_input($_POST['affiliate_banners_image_target']);
        $affiliate_html_text = smn_db_prepare_input($_POST['affiliate_html_text']);
        $affiliate_banners_image_local = smn_db_prepare_input($_POST['affiliate_banners_image_local']);
        $affiliate_banners_image_target = smn_db_prepare_input($_POST['affiliate_banners_image_target']);
        $db_image_location = '';

        $affiliate_banner_error = false;
        if (empty($affiliate_banners_title)) {
          $messageStack->add(ERROR_BANNER_TITLE_REQUIRED, 'error');
          $affiliate_banner_error = true;
        }
/*      if (empty($affiliate_banners_group)) {
          $messageStack->add(ERROR_BANNER_GROUP_REQUIRED, 'error');
          $affiliate_banner_error = true;
        }
*/
        if ( ($affiliate_banners_image) && ($affiliate_banners_image != 'none') && (is_uploaded_file($affiliate_banners_image)) ) {
          if (!is_writeable(DIR_FS_CATALOG_IMAGES . $affiliate_banners_image_target)) {
            if (is_dir(DIR_FS_CATALOG_IMAGES . $affiliate_banners_image_target)) {
              $messageStack->add(ERROR_IMAGE_DIRECTORY_NOT_WRITEABLE, 'error');
            } else {
              $messageStack->add(ERROR_IMAGE_DIRECTORY_DOES_NOT_EXIST, 'error');
            }
            $affiliate_banner_error = true;
          }
        }

        if (!$affiliate_banner_error) {
          if (empty($affiliate_html_text)) {
            if ( ($affiliate_banners_image) && ($affiliate_banners_image != 'none') && (is_uploaded_file($affiliate_banners_image)) ) {
              $image_location = DIR_FS_CATALOG_IMAGES . $affiliate_banners_image_target . $affiliate_banners_image_name;
              copy($affiliate_banners_image, $image_location);
            }
            $db_image_location = (!empty($affiliate_banners_image_local)) ? $affiliate_banners_image_local : $affiliate_banners_image_target . $affiliate_banners_image_name;
          }

          if (!$affiliate_products_id) $affiliate_products_id="0";
            $sql_data_array = array('affiliate_banners_title' => $affiliate_banners_title,
                                    'affiliate_products_id' => $affiliate_products_id,
                                    'affiliate_banners_image' => $db_image_location,
                                    'affiliate_banners_group' => $affiliate_banners_group);

          if ($_GET['action'] == 'insert') {
            $insert_sql_data = array('affiliate_date_added' => 'now()',
                                     'affiliate_status' => '1');
            $sql_data_array = array_merge($sql_data_array, $insert_sql_data);
            smn_db_perform(TABLE_AFFILIATE_BANNERS, $sql_data_array);
            $affiliate_banners_id = smn_db_insert_id();

          // Banner ID 1 is generic Product Banner
            if ($affiliate_banners_id==1) smn_db_query("update " . TABLE_AFFILIATE_BANNERS . " set affiliate_banners_id = affiliate_banners_id + 1");
            $messageStack->add_session(SUCCESS_BANNER_INSERTED, 'success');
          } elseif ($_GET['action'] == 'update') {
            $insert_sql_data = array('affiliate_date_status_change' => 'now()');
            $sql_data_array = array_merge($sql_data_array, $insert_sql_data);
            smn_db_perform(TABLE_AFFILIATE_BANNERS, $sql_data_array, 'update', 'affiliate_banners_id = \'' . $affiliate_banners_id . '\'');
            $messageStack->add_session(SUCCESS_BANNER_UPDATED, 'success');
          }

          smn_redirect(smn_href_link(FILENAME_AFFILIATE_BANNER_MANAGER, 'selected_box=affiliate&page=' . $_GET['page'] . '&abID=' . $affiliate_banners_id));
        } else {
          $_GET['action'] = 'new';
        }
        break;
      case 'deleteconfirm':
        $affiliate_banners_id = smn_db_prepare_input($_GET['abID']);
        $delete_image = smn_db_prepare_input($_POST['delete_image']);

        if ($delete_image == 'on') {
          $affiliate_banner_query = smn_db_query("select affiliate_banners_image from " . TABLE_AFFILIATE_BANNERS . " where affiliate_banners_id = '" . smn_db_input($affiliate_banners_id) . "'");
          $affiliate_banner = smn_db_fetch_array($affiliate_banner_query);
          if (is_file(DIR_FS_CATALOG_IMAGES . $affiliate_banner['affiliate_banners_image'])) {
            if (is_writeable(DIR_FS_CATALOG_IMAGES . $affiliate_banner['affiliate_banners_image'])) {
              unlink(DIR_FS_CATALOG_IMAGES . $affiliate_banner['affiliate_banners_image']);
            } else {
              $messageStack->add_session(ERROR_IMAGE_IS_NOT_WRITEABLE, 'error');
            }
          } else {
            $messageStack->add_session(ERROR_IMAGE_DOES_NOT_EXIST, 'error');
          }
        }

        smn_db_query("delete from " . TABLE_AFFILIATE_BANNERS . " where affiliate_banners_id = '" . smn_db_input($affiliate_banners_id) . "'");
        smn_db_query("delete from " . TABLE_AFFILIATE_BANNERS_HISTORY . " where affiliate_banners_id = '" . smn_db_input($affiliate_banners_id) . "'");

        $messageStack->add_session(SUCCESS_BANNER_REMOVED, 'success');

        smn_redirect(smn_href_link(FILENAME_AFFILIATE_BANNER_MANAGER, 'selected_box=affiliate&page=' . $_GET['page']));
        break;
    }
  }
  
  $content_page = basename($_SERVER['PHP_SELF']);
  
  require('templates/default/layout.php');

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>