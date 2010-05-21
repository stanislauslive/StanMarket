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

  if ($store_id == 1){
      $filter = " and (store_id = '" . (int)$store_id . "' or store_id = '0' )";
  }else{
      $filter = " and store_id = '" . (int)$store_id . "'";
  }
  
  function getConfigValue($gID, $cID){
    global $filter;
      $configuration_query = smn_db_query("select configuration_value, use_function from " . TABLE_CONFIGURATION . " where configuration_id = '" . $cID . "' and configuration_group_id = '" . (int)$gID . "'" . $filter . " order by sort_order");
      $configuration = smn_db_fetch_array($configuration_query);
      if (smn_not_null($configuration['use_function'])) {
          $use_function = $configuration['use_function'];
          if (ereg('->', $use_function)) {
              $class_method = explode('->', $use_function);
              if (!is_object(${$class_method[0]})) {
                  include(DIR_WS_CLASSES . $class_method[0] . '.php');
                  ${$class_method[0]} = new $class_method[0]();
              }
              $cfgValue = smn_call_function($class_method[1], $configuration['configuration_value'], ${$class_method[0]});
          } else {
              $cfgValue = smn_call_function($use_function, $configuration['configuration_value']);
          }
      } else {
          $cfgValue = $configuration['configuration_value'];
      }
      
      if (empty($cfgValue) && !is_numeric($cfgValue)){
          $cfgValue = '&nbsp;';
      }
    return $cfgValue;
  }

  if (smn_not_null($action)) {
      switch ($action) {
          case 'save':
              $cID = smn_db_prepare_input($_GET['cID']);
              if (($_GET['store_logo']) == 'true'){
                  // copy image
                  $allowed_files_types = array('gif', 'jpg', 'jpeg', 'png');
                  $store_logo_image = new upload('configuration_value');
                  $store_logo_image->set_destination(DIR_FS_CATALOG_IMAGES);
                  $store_logo_image->set_extensions($allowed_files_types);
                  $parsed = $store_logo_image->parse();
                  $ext = (substr($store_logo_image->filename, -4));
                  $store_logo_image->set_filename('logo' . $ext);
                  $saved = $store_logo_image->save();
                  
                  if ($parsed && $saved){
                      $store_logo_image_name = $store_logo_image->filename;
                      smn_db_query("update " . TABLE_CONFIGURATION . " set configuration_value = '" . $store_logo_image_name . "', last_modified = now() where configuration_id = '" . (int)$cID . "'");
                  } 
              } elseif (($_GET['store_type']) == 'true'){
                  $group_count_query = smn_db_query("select count(*) as total from " . TABLE_STORE_TYPES);
                  $group_count = smn_db_fetch_array($group_count_query);
                  $count = (((int)$group_count['total'] + 1 ) - 1);
                  $sql_data_array = array('store_types_name' => smn_db_prepare_input($_POST['configuration_value']));
                  
                  smn_db_perform(TABLE_STORE_TYPES, $sql_data_array, 'insert');
                  smn_db_query("update " . TABLE_CONFIGURATION . " set configuration_value = '" . $count. "', last_modified = now() where configuration_id = '" . (int)$cID . "'");
              }else{
                  $configuration_value = smn_db_prepare_input($_POST['configuration_value']);
                  
                  smn_db_query("update " . TABLE_CONFIGURATION . " set configuration_value = '" . smn_db_input($configuration_value) . "', last_modified = now() where configuration_id = '" . (int)$cID . "'");
              }
              
              $cfgValue = getConfigValue($gID, $cID);
              
              $Qconfiguration = smn_db_query('select * from ' . TABLE_CONFIGURATION . ' where configuration_id = "' . $cID . '"');
              $configuration = smn_db_fetch_array($Qconfiguration);
              
              echo '{ 
                  success: true, 
                  configuration_value: "' . $jQuery->jsonHtmlPrepare($cfgValue) . '"
              }';
              exit;
          break;
          case 'edit':
              $configuration_query = smn_db_query("select * from " . TABLE_CONFIGURATION . " where configuration_id = '" . $_GET['cID'] . "' and configuration_group_id = '" . $_GET['gID'] . "'" . $filter . " order by sort_order");
              $configuration = smn_db_fetch_array($configuration_query);
              if (smn_not_null($configuration['use_function'])) {
                  $use_function = $configuration['use_function'];
                  if (ereg('->', $use_function)) {
                      $class_method = explode('->', $use_function);
                      if (!is_object(${$class_method[0]})) {
                          include(DIR_WS_CLASSES . $class_method[0] . '.php');
                          ${$class_method[0]} = new $class_method[0]();
                      }
                      $cfgValue = smn_call_function($class_method[1], $configuration['configuration_value'], ${$class_method[0]});
                  } else {
                      $cfgValue = smn_call_function($use_function, $configuration['configuration_value']);
                  }
              } else {
                  $cfgValue = $configuration['configuration_value'];
              }
              
              $isUpload = 'false';
              $form = $jQuery->link(FILENAME_CONFIGURATION, 'gID=' . $_GET['gID'] . '&cID=' . $configuration['configuration_id'] . '&action=save');
              if ($configuration['set_function']) {
                  eval('$value_field = ' . $configuration['set_function'] . '"' . htmlspecialchars($configuration['configuration_value']) . '");');
              } elseif ($configuration['configuration_key'] == 'STORE_LOGO'){
                  $value_field = smn_draw_file_field('configuration_value');
                  $form .= '&store_logo=true';
                  $isUpload = 'true';
              } elseif ($configuration['configuration_key'] == 'STORE_TYPES'){
                  $value_field = smn_cfg_pull_down_store_list() . '<br><br>' . TEXT_INFO_EDIT_STORE_TYPE . '<br><br>' . smn_draw_input_field('configuration_value');
                  $form .= '&store_type=true';
              }else{
                  $value_field = smn_draw_input_field('configuration_value', $configuration['configuration_value']);
              }
              echo '{
                  success: true,
                  formAction: "' . $form . '",
                  formParams: "' . $isUpload . '",
                  content: "' . $jQuery->jsonHtmlPrepare('
                    <table cellpadding="6" cellspacing="0" border="0">
                     <tr>
                      <td class="main">' . $configuration['configuration_description'] . '</td>
                     </tr>
                     <tr>
                      <td class="main">' . $value_field . '</td>
                     </tr>
                    </table>
                  ') . '"
              }';
              exit;
          break;
      }
  }

  $gID = (isset($_GET['gID'])) ? $_GET['gID'] : 1;

  $cfg_group_query = smn_db_query("select configuration_group_title from " . TABLE_CONFIGURATION_GROUP . " where configuration_group_id = '" . (int)$gID . "'");
  $cfg_group = smn_db_fetch_array($cfg_group_query);
  
  $content_page = basename($_SERVER['PHP_SELF']);
  
  require('templates/default/layout.php');

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>