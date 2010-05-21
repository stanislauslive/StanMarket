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
  define('FILENAME_ADMIN', 'admin.php');
  
  $current_boxes = DIR_FS_ADMIN . DIR_WS_BOXES;
  
  function randomize() {
      $salt = "abchefghjkmnpqrstuvwxyz0123456789";
      srand((double)microtime()*1000000);
      $i = 0;
      while ($i <= 7) {
          $num = rand() % 33;
          $tmp = substr($salt, $num, 1);
          $pass = $pass . $tmp;
          $i++;
      }
  	return $pass;
  }
          
  if ($_GET['action']) {
      switch ($_GET['action']) {
          case 'saveMember':
              $email_address = smn_db_prepare_input($_POST['admin_email_address']);
              $group_id = smn_db_prepare_input($_POST['admin_groups_id']);
              $firstname = smn_db_prepare_input($_POST['admin_firstname']);
              $lastname = smn_db_prepare_input($_POST['admin_lastname']);
              if (!isset($_POST['admin_id']) || (isset($_POST['admin_id']) && empty($_POST['admin_id']))){
                  $extraWhere = '';
                  $makePassword = randomize();
                  $emailPassword = $makePassword;
                  $emailStoreName = STORE_OWNER;
              }else{
                  $admin_id = $_POST['admin_id'];
                  $extraWhere = ' and admin_id != "' . $admin_id . '"';
                  $emailPassword = '--HIDDEN--';
                  $emailStoreName = MALL_NAME;
              }
              $Qcheck = smn_db_query('select admin_email_address from ' . TABLE_ADMIN . ' where admin_email_address = "' . $email_address . '"' . $extraWhere);
              if (smn_db_num_rows($Qcheck) > 0){
                  echo '{ success: false, errorMsg: "Admin Email Address Already Exists." }';
                  exit;
              }
              
              $sql_data_array = array(
                  'admin_groups_id'     => $group_id,
                  'admin_firstname'     => $firstname,
                  'admin_lastname'      => $lastname,
                  'admin_email_address' => $email_address
              );
              if (isset($makePassword)){
                  $sql_data_array['admin_password'] = smn_encrypt_password($makePassword);
                  $sql_data_array['admin_created'] = 'now()';
                  
                  smn_db_perform(TABLE_ADMIN, $sql_data_array);
                  $admin_id = smn_db_insert_id();
              }else{
                  $sql_data_array['admin_modified'] = 'now()';
                  smn_db_perform(TABLE_ADMIN, $sql_data_array, 'update', 'admin_id = "' . $admin_id . '"');
              }
              
              smn_mail($firstname . ' ' . $lastname, 
                      $email_address, 
                      ADMIN_EMAIL_SUBJECT, 
                      sprintf(ADMIN_EMAIL_TEXT, 
                              $firstname, 
                              HTTP_SERVER . DIR_WS_CATALOG . 'account.php', 
                              $email_address, 
                              $emailPassword, 
                              $emailStoreName
                      ),
                      STORE_OWNER, 
                      STORE_OWNER_EMAIL_ADDRESS
              );
              
              $Qmember = smn_db_query('select a.*, ag.admin_groups_name from ' . TABLE_ADMIN . ' a left join ' . TABLE_ADMIN_GROUPS . ' ag using(admin_groups_id) where admin_id = "' . $admin_id . '"');
              $member = smn_db_fetch_array($Qmember);
              echo '{ 
                  success: true,
                  admin_id: "' . $member['admin_id'] . '",
                  admin_firstname: "' . $member['admin_firstname'] . '", 
                  admin_lastname: "' . $member['admin_lastname'] . '", 
                  admin_email_address: "' . $member['admin_email_address'] . '", 
                  admin_groups_id: "' . $member['admin_groups_id'] . '",
                  admin_groups_name: "' . $member['admin_groups_name'] . '",
                  store_id: "' . $member['store_id'] . '",
                  customer_id: "' . $member['customer_id'] . '",
                  admin_name: "' . $member['admin_firstname'] . ' ' . $member['admin_lastname'] . '", 
                  admin_password: "' . $member['admin_password'] . '",
                  admin_created: "' . $member['admin_created'] . '",
                  admin_modified: "' . $member['admin_modified'] . '",
                  admin_logdate: "' . $member['admin_logdate'] . '",
                  admin_lognum: "' . $member['admin_lognum'] . '"
              }';
              exit;
          break;
          case 'deleteMember':
              $admin_id = smn_db_prepare_input($_GET['admin_id']);
              smn_db_query("delete from " . TABLE_ADMIN . " where admin_id = '" . $admin_id . "'");
              
              echo '{ success: true }';
              exit;
          break;
          case 'saveGroup':
              $admin_groups_id = (isset($_POST['admin_groups_id']) ? $_POST['admin_groups_id'] : false);
              $admin_groups_name = ucwords(strtolower(smn_db_prepare_input($_POST['admin_groups_name'])));
              $name_replace = ereg_replace (" ", "%", $admin_groups_name);
              if (($admin_groups_name == '' || NULL) || (strlen($admin_groups_name) <= 5) ) {
                  echo '{ success: false, errorMsg: "' . addslashes(TEXT_INFO_GROUPS_NAME_FALSE) . '" }';
                  exit;
              }
              
              if ($admin_groups_id === false){
                  $Qaction = 'insert';
                  $extraWhere = '';
              }else{
                  $Qaction = 'update';
                  $extraWhere = ' and admin_groups_id != "' . $admin_groups_id . '"';
              }
              
              $Qcheck = smn_db_query('select admin_groups_name as group_name_edit from ' . TABLE_ADMIN_GROUPS . ' where admin_groups_name = "' . $admin_groups_name . '"' . $extraWhere);
              if (smn_db_num_rows($Qcheck) > 0){
                  echo '{ success: false, errorMsg: "' . addslashes(TEXT_INFO_GROUPS_NAME_USED) . '" }';
                  exit;
              }
              
              $sql_data_array = array(
                  'admin_groups_name'         => $admin_groups_name,
                  'admin_groups_store_type'   => smn_db_prepare_input($_POST['admin_groups_store_types']),
                  'admin_sales_cost'          => smn_db_prepare_input($_POST['admin_sales_cost']),
                  'admin_groups_max_products' => smn_db_prepare_input($_POST['admin_groups_max_products'])
              );
              
              $error = true;
              if ($Qaction == 'update'){
                  smn_db_perform(TABLE_ADMIN_GROUPS, $sql_data_array, 'update', "admin_groups_id = '" . $admin_groups_id . "'");
                  
                  $Qgroup = smn_db_query('select * from ' . TABLE_ADMIN_GROUPS . ' where admin_groups_id = "' . $admin_groups_id . '"');
                  $group = smn_db_fetch_array($Qgroup);
                  $error = false;
              }else{
                  $sql_product_data_array = array(
                      'products_quantity'       => '1000',
		              'products_model'          => 'mem_6_',
		              'products_price'          => smn_db_prepare_input($_POST['admin_groups_cost']),
		              'products_date_available' => date('Y-m-d'),
		              'store_id'                => 1,
		              'products_weight'         => '0',
		              'products_status'         => '1',
		              'products_tax_class_id'   => '',
		              'products_date_added'     => 'now()',
		              'products_image'          => '',
		              'manufacturers_id'        => ''
		          );
		          smn_db_perform(TABLE_PRODUCTS, $sql_product_data_array);
		          $products_id = smn_db_insert_id();
		          smn_db_query("insert into " . TABLE_PRODUCTS_TO_CATEGORIES . " (products_id, categories_id) values ('" . (int)$products_id . "', '1')");
		          $languages = smn_get_languages();
		          for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
		               $language_id = $languages[$i]['id']; 
		               $sql_desc_data_array = array(
		                   'products_id'   => $products_id,
		                   'products_name' => smn_db_prepare_input($admin_groups_name),
		                   'language_id'   => $language_id,
		                   'products_url'  => HTTP_CATALOG_SERVER
		               );
		               smn_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_desc_data_array);  
		          }
		          
		          $sql_data_array['admin_groups_products_id'] = $products_id;
		          smn_db_perform(TABLE_ADMIN_GROUPS, $sql_data_array);
		          $admin_groups_id = smn_db_insert_id();

		          $set_groups_id = smn_db_prepare_input($_POST['set_groups_id']);
		          $add_group_id = $set_groups_id . ', "' . $admin_groups_id . '"';
		          smn_db_query('alter table ' . TABLE_ADMIN_FILES . ' change admin_groups_id admin_groups_id set(' . $add_group_id . ') NOT NULL DEFAULT "1"');
		          $error = false;
              }
              
              if ($error === false){
                  echo '{
                      success: true,
                      admin_groups_id: "' . addslashes($group['admin_groups_id']) . '",
                      admin_groups_name: "' . addslashes($group['admin_groups_name']) . '",
                      admin_groups_store_type: "' . addslashes($group['admin_groups_store_type']) . '",
                      admin_sales_cost: "' . addslashes($group['admin_sales_cost']) . '",
                      admin_groups_max_products: "' . addslashes($group['admin_groups_max_products']) . '",
                      admin_groups_products_id: "' . addslashes($group['admin_groups_products_id']) . '"
                  }';
              }else{
                  echo '{ success: false, errorMsg: "Unknown Error, Data Not Saved" }';
              }
              exit;
          break;
          case 'deleteGroup':
              $set_groups_id = smn_db_prepare_input($_POST['set_groups_id']);
              $admin_groups_id = smn_db_prepare_input($_GET['gID']);
              
              smn_db_query("alter table " . TABLE_ADMIN_FILES . " change admin_groups_id admin_groups_id set( " . $set_groups_id . " ) NOT NULL DEFAULT '1' ");
              smn_db_query("delete from " . TABLE_ADMIN_GROUPS . " where admin_groups_id = '" . $admin_groups_id . "'");
              smn_db_query("delete from " . TABLE_ADMIN . " where admin_groups_id = '" . $admin_groups_id . "'");
              
              echo '{ success:true }';
              exit;
          break;
          case 'setGroupPermissions':
              $selected_checkbox = $_POST['groups_to_boxes'];
              $define_files_query = smn_db_query('select admin_files_id from ' . TABLE_ADMIN_FILES . ' order by admin_files_id');
              while ($define_files = smn_db_fetch_array($define_files_query)) {
                  $admin_files_id = $define_files['admin_files_id'];
                  
                  if (in_array ($admin_files_id, $selected_checkbox)) {
                      $postVar = 'checked_' . $admin_files_id;
                  } else {
                      $postVar = 'unchecked_' . $admin_files_id;
                  }
                  $sql_data_array = array(
                      'admin_groups_id' => smn_db_prepare_input($_POST[$postVar])
                  );
                  smn_db_perform(TABLE_ADMIN_FILES, $sql_data_array, 'update', 'admin_files_id = "' . $admin_files_id . '"');
              }
              
              echo '{ success: true }';
              exit;
          break;
          case 'boxAction':
              if ($_GET['actionType'] == 'install'){
                  $sql_data_array = array(
                      'admin_files_name'     => smn_db_prepare_input($_GET['box']),
                      'admin_files_is_boxes' => '1'
                  );
                  smn_db_perform(TABLE_ADMIN_FILES, $sql_data_array);
                  $admin_boxes_id = smn_db_insert_id();
              
                  $Qbox = smn_db_query('select * from ' . TABLE_ADMIN_FILES . ' where admin_files_id = "' . $admin_boxes_id . '"');
                  $box = smn_db_fetch_array($Qbox);
              }else{
                  // NOTE: ALSO DELETE FILES STORED IN REMOVED BOX //
                  $admin_boxes_id = smn_db_prepare_input($_GET['boxID']);
                  
                  smn_db_query('delete from ' . TABLE_ADMIN_FILES . ' where admin_files_id = "' . $admin_boxes_id . '" or admin_files_to_boxes = "' . $admin_boxes_id . '"');
                  
                  $box = array(
                      'admin_files_id'       => 'b',
                      'admin_files_name'     => $box['admin_files_name'],
                      'admin_files_is_boxes' => '0',
                      'admin_files_to_boxes' => '0',
                      'admin_groups_id'      => $box['admin_groups_id']
                  );
              }
        
              echo '{ 
                  success: true,
                  admin_files_id: "' . $box['admin_files_id'] . '",
                  admin_files_name: "' . $box['admin_files_name'] . '",
                  admin_files_status: "' . ($_GET['actionType'] == 'install' ? 'True' : 'False') . '", 
                  admin_files_is_boxes: "' . $box['admin_files_is_boxes'] . '",
                  admin_files_to_boxes: "' . $box['admin_files_to_boxes'] . '",
                  admin_groups_id: "' . $box['admin_groups_id'] . '" 
              }';
              exit;
          break;
          case 'getBoxFiles':
              $file_query = smn_db_query("select admin_files_name from " . TABLE_ADMIN_FILES . " where admin_files_is_boxes = '0' and admin_files_is_tab = '0'");
              while ($fetch_files = smn_db_fetch_array($file_query)) {
                  $files_array[] = $fetch_files['admin_files_name'];        
              }
              
              $file_dir = array();
              $dir = dir(DIR_FS_ADMIN);
              
              while ($file = $dir->read()) {
                  if ((substr("$file", -4) == '.php') && $file != FILENAME_DEFAULT && $file != FILENAME_LOGIN && $file != FILENAME_LOGOFF && $file != FILENAME_FORBIDEN && $file != FILENAME_POPUP_IMAGE && $file != FILENAME_PASSWORD_FORGOTTEN && $file != FILENAME_ADMIN_ACCOUNT && $file != 'invoice.php' && $file != 'packingslip.php') {
                      $file_dir[] = $file;
                  }
              }
              
              $result = $file_dir;      
              if (sizeof($files_array) > 0) {
                  $result = array_values (array_diff($file_dir, $files_array));
              }
              
              sort ($result);
              reset ($result);
              while (list ($key, $val) = each ($result)) {
                  $show[] = '["' . $val . '", "' . $val . '"]';
              }
              
              $db_file_query = smn_db_query('select * from ' . TABLE_ADMIN_FILES . ' where admin_files_to_boxes = ' . $_GET['boxID'] . ' and admin_files_is_tab = "0" order by admin_files_name');
              $currentFiles = array();
              while ($files = smn_db_fetch_array($db_file_query)) {
                  $tabDir = str_replace('.php', '', $files['admin_files_name']);
                  $directory = DIR_FS_TEMPLATES . 'content/tabs/' . $tabDir . '/';
                  $tabs = array();
                  if (is_dir($directory)){
                      $dir = dir($directory);
                      while(($file = $dir->read()) !== false){
                          if ($file != '.' && $file != '..' && is_file($directory . $file)){
                              $Qtab = smn_db_query('select * from ' . TABLE_ADMIN_FILES . ' where admin_tabs_to_files = "' . $files['admin_files_id'] . '" and admin_files_name = "' . $file . '"');
                              $tab = smn_db_fetch_array($Qtab);
                              $tabs[] = '["' . $tab['admin_files_id'] . '", "' . $file . '", "' . (smn_db_num_rows($Qtab) ? 'true' : 'false') . '"]';
                          }
                      }
                      $currentFiles[] = '["' . $files['admin_files_id'] . '", {
                          mainFile: "' . $files['admin_files_name'] . '",
                          tabs: [' . implode(',', $tabs) . ']
                      }]';
                  }else{
                      $currentFiles[] = '["' . $files['admin_files_id'] . '", "' . $files['admin_files_name'] . '"]';
                  }
              }
              
              echo '{
                  success: true,
                  boxData: [' . implode(',', $show) . '],
                  currentFiles: [' . implode(',', $currentFiles) . ']
              }';
              exit;
          break;
          case 'boxFileAction':
              if ($_GET['actionType'] == 'store'){
                  if (isset($_GET['masterFileID'])){
                      $sql_data_array = array(
                          'admin_files_name'     => smn_db_prepare_input($_GET['fileName']),
                          'admin_tabs_to_files'  => smn_db_prepare_input($_GET['masterFileID']),
                          'admin_files_is_tab'   => '1',
                          'admin_files_to_boxes' => smn_db_prepare_input($_GET['boxID'])
                      );
                  }else{
                      $sql_data_array = array(
                          'admin_files_name'     => smn_db_prepare_input($_GET['fileName']),
                          'admin_files_to_boxes' => smn_db_prepare_input($_GET['boxID'])
                      );
                  }
              
                  smn_db_perform(TABLE_ADMIN_FILES, $sql_data_array);
                  $masterFileID = smn_db_insert_id();
              
                  $tabDir = str_replace('.php', '', $_GET['fileName']);
                  $directory = DIR_FS_TEMPLATES . 'content/tabs/' . $tabDir . '/';
                  $tabs = array();
                  if (is_dir($directory)){
                      $dir = dir($directory);
                      while(($file = $dir->read()) !== false){
                          if ($file != '.' && $file != '..' && is_file($directory . $file)){
                              $sql_data_array = array(
                                  'admin_files_name'     => smn_db_prepare_input($file),
                                  'admin_files_is_tab'   => '1',
                                  'admin_tabs_to_files'  => $masterFileID,
                                  'admin_files_to_boxes' => smn_db_prepare_input($_GET['boxID'])
                              );
                          
                              smn_db_perform(TABLE_ADMIN_FILES, $sql_data_array);
                              $fileID = smn_db_insert_id();
                              $tabs[] = '["' . $fileID . '", "' . $file . '"]';
                          }
                      }
                  }
              
                  echo '{
                      success: true,
                      file_id: "' . $masterFileID . '",
                      tabs: [' . implode(',', $tabs) . ']
                  }';
              }else{
                  $admin_files_name = smn_db_prepare_input($_GET['fileName']);
                  $admin_boxes_id = smn_db_prepare_input($_GET['boxID']);
                  $Qcheck = smn_db_query('select admin_files_id from ' . TABLE_ADMIN_FILES . ' where admin_files_is_boxes = "0" and admin_files_to_boxes = "' . $admin_boxes_id . '" and admin_files_name = "' . $admin_files_name . '"');
                  if (smn_db_num_rows($Qcheck)){
                      $check = smn_db_fetch_array($Qcheck);
                      smn_db_query('delete from ' . TABLE_ADMIN_FILES . ' where admin_files_id = "' . $check['admin_files_id'] . '" or admin_tabs_to_files = "' . $check['admin_files_id'] . '"');
                      
                      echo '{success: true}';
                  }else{
                      echo '{success: false}';
                  }
              }
              exit;
          break;
          case 'getPermissions':
              $groupID = $_GET['gID'];
              $selectedBoxes = array();
              $selectedFiles = array();
              $selectedTabs = array();
              $Qboxes = smn_db_query('select admin_files_id as id, admin_files_name as name, admin_groups_id as group_id from ' . TABLE_ADMIN_FILES . ' where find_in_set("' . $_GET['gID'] . '", admin_groups_id) and admin_files_is_boxes = "1" and admin_files_is_tab = "0" order by admin_files_name');
              while($boxes = smn_db_fetch_array($Qboxes)) {
                  $selectedBoxes[] = $boxes['id'];
                  $Qfiles = smn_db_query('select admin_files_id as id, admin_files_name as name, admin_groups_id as group_id from ' . TABLE_ADMIN_FILES . ' where find_in_set("' . $_GET['gID'] . '", admin_groups_id) and admin_files_is_boxes = "0" and admin_files_is_tab = "0" and admin_files_to_boxes = "' . $boxes['id'] . '" order by admin_files_name');
                  while($files = smn_db_fetch_array($Qfiles)) {
                      $selectedFiles[] = $files['id'];
                      $Qtabs = smn_db_query('select admin_files_id as id, admin_files_name as name, admin_groups_id as group_id from ' . TABLE_ADMIN_FILES . ' where find_in_set("' . $_GET['gID'] . '", admin_groups_id) and admin_files_is_boxes = "0" and admin_files_is_tab = "1" and admin_tabs_to_files = "' . $files['id'] . '" order by admin_files_name');
                      while($tabs = smn_db_fetch_array($Qtabs)){
                          $selectedTabs[] = $tabs['id'];
                      }
                  }
              }
              echo '{
                  success: true,
                  selectedBoxes: "' . $jQuery->jsonHtmlPrepare(implode(',', $selectedBoxes)) . '",
                  selectedFiles: "' . $jQuery->jsonHtmlPrepare(implode(',', $selectedFiles)) . '",
                  selectedTabs: "' . $jQuery->jsonHtmlPrepare(implode(',', $selectedTabs)) . '"
              }';
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
      'commonCancelButton',
      'store'
  ));

  $tabsArray = array();
//  if ($store->smn_admin_check_page_tabs(basename($_SERVER['PHP_SELF']), 'tab_members.php') === true){
      $tabsArray[] = array(
          'tabID'    => 'tab-members',
          'filename' => 'tab_members.php',
          'text'     => 'Members'
      );
//  }
 
//  if ($store->smn_admin_check_page_tabs(basename($_SERVER['PHP_SELF']), 'tab_groups.php') === true){
      $tabsArray[] = array(
          'tabID'    => 'tab-groups',
          'filename' => 'tab_groups.php',
          'text'     => 'Groups'
      );
//  }
   
//  if ($store->smn_admin_check_page_tabs(basename($_SERVER['PHP_SELF']), 'tab_files.php') === true){ 
      $tabsArray[] = array(
          'tabID'    => 'tab-files',
          'filename' => 'tab_files.php',
          'text'     => 'Files'
      );
//  }

  $tabPanelHelpButton = $jQuery->getPluginClass('button', array(
      'id'   => 'helpButton',
      'text' => 'Help'
  ));
    
  $tabPanel = $jQuery->getPluginClass('tabs', array(
      'id'            => 'initialPane',
      'tabDir'        => DIR_FS_ADMIN . 'templates/content/tabs/admin/',
      'tabs'          => $tabsArray,
      'footerButtons' => array($tabPanelHelpButton),
      'showFooter'    => true
  ));
  
  $tabPanel->setHelpButton('helpButton', true);
/* Setup Tabs - END */
  
  $content_page = basename($_SERVER['PHP_SELF']);
  
  require('templates/default/layout.php');

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>