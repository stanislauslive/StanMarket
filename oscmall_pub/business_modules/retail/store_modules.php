<?php
/*
  Copyright (c) 2002 - 2006 SystemsManager.Net

  SystemsManager Technologies
  oscMall System Version 4
  http://www.systemsmanager.net
  
  This source file is subject to version 2.0 of the GPL license,   
  that is bundled with this package in the file LICENSE. If you
  did not receive a copy of the oscMall System license and are unable 
  to obtain it through the world-wide-web, please send a note to    
  license@systemsmanager.net so we can mail you a copy immediately.
*/
   
   if (!smn_session_is_registered('customer_id')) {
    //$navigation->set_snapshot();
       smn_redirect(smn_href_link(FILENAME_LOGIN, 'ID=' . $store_id, 'SSL'));
   }
   
   $set = (isset($_GET['set']) ? $_GET['set'] : 'payment');
   $action = (isset($_GET['action']) ? $_GET['action'] : '');
   
   require(DIR_WS_CLASSES . 'store_modules.php');
   $paymentModules = new store_modules('payment');
   $shippingModules = new store_modules('shipping');
   $orderTotalModules = new store_modules('order_total');
   
   if (smn_not_null($action)){
       $moduleType = $_GET['moduleType'];
       $moduleName = $_GET['moduleName'];
       require(DIR_WS_LANGUAGES . 'install/' . $moduleType . '/' . $language . '.php');
       
       switch($action){
           case 'getInstallArray':
               $moduleInfo = new store_modules($moduleType);
               
               $notInstalled = $moduleInfo->getNotInstalledModules();
               
               $json = array();
               for($i=0, $n=sizeof($notInstalled); $i<$n; $i++){
                   $json[] = '["' . $notInstalled[$i]['id'] . '", "' . $notInstalled[$i]['text'] . '"]';
               }
               
               echo '{
                   success: true,
                   arr: [' . implode(',', $json) . ']
               }';
               exit;
           break;
           case 'getModuleEditFields':
               $moduleInfo = new store_modules($moduleType, $moduleName);
               if ($moduleInfo->isInstalled($moduleName) === false){
                   $moduleInfo->installModule($moduleName);
               }
               $fields = $moduleInfo->getModuleEdit($moduleName);
               echo '{
                   success: true,
                   html: "' . $jQuery->jsonHtmlPrepare('<div id="moduleFields" align="left">' . $fields . '</div>') . '"
               }';
               exit;
           break;
           case 'uninstallModule':
               $moduleInfo = new store_modules($moduleType, $moduleName);
               $moduleInfo->uninstallModule($moduleName);
               echo '{ success: true }';
               exit;
           break;
           case 'saveModuleSettings':
               while (list($key, $value) = each($_POST['configuration'])) {
                   if (is_array($value)){
                       $value = implode( ", ", $value);
                       $value = ereg_replace (", --none--", "", $value);
                   }
                   smn_db_query("update " . TABLE_CONFIGURATION . " set configuration_value = '" . $value . "' where configuration_key = '" . $key . "' and store_id = '" . $customer_store_id . "'");
               }
               
               $moduleInfo = new store_modules($moduleType, $moduleName);
               $module = $moduleInfo->moduleClass($moduleName);
               echo '{
                   success: true,
                   title: "' . addslashes($module->title) . '",
                   code: "' . $module->code . '",
                   sort_order: "' . $module->sort_order . '",
                   status: "' . ($module->enabled ? 'true' : 'false') . '"
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

/* Common Grid Elements - BEGIN */ 
   $modulesGridEditButton = $jQuery->getPluginClass('button', array(
       'id'     => 'modulesGridEditButton',
       'text'   => 'Edit Module',
       'hidden' => true
   ));
  
   $modulesGridUninstallButton = $jQuery->getPluginClass('button', array(
       'id'     => 'modulesGridUninstallButton',
       'text'   => 'Uninstall Module',
       'hidden' => true
   ));
  
   $modulesGridInstallButton = $jQuery->getPluginClass('button', array(
       'id'   => 'modulesGridInstallButton',
       'text' => 'Install Module'
   ));
     
   $modulesGridColumns = array(
       array('id' => 'title',      'text' => 'Module Name'),
       array('id' => 'sort_order', 'text' => 'Sort Order'),
       array('id' => 'code',       'text' => 'Code', 'hidden' => true),
       array('id' => 'status',     'text' => 'Status', 'hidden' => true)
   );
/* Common Grid Elements - END */ 
 
   $jQuery->setGlobalVars(array(
       'languages',
       'languages_id',
       'store_id',
       'modulesGridEditButton',
       'modulesGridUninstallButton',
       'modulesGridInstallButton',
       'commonSaveButton',
       'commonDeleteButton',
       'commonCancelButton',
       'paymentModules',
       'shippingModules',
       'orderTotalModules',
       'modulesGridColumns',
       'store'
   ));

   $tabsArray = array();
   $tabsArray[] = array(
       'tabID'    => 'tab-payment',
       'filename' => 'tab_payment.php',
       'text'     => 'Payment Modules'
   );
 
   $tabsArray[] = array(
       'tabID'    => 'tab-shipping',
       'filename' => 'tab_shipping.php',
       'text'     => 'Shipping Modules'
   );
 
   $tabsArray[] = array(
       'tabID'    => 'tab-order_total',
       'filename' => 'tab_order_total.php',
       'text'     => 'Order Total Modules'
   );
     
   $tabPanelHelpButton = $jQuery->getPluginClass('button', array(
       'id'   => 'helpButton',
       'text' => 'Help'
   ));
 
   $tabPanelBackButton = $jQuery->getPluginClass('button', array(
       'id'   => 'backButton',
       'text' => 'Back To Account',
       'href' => smn_href_link(FILENAME_ACCOUNT, 'ID=' . $store_id)
   ));

   $tabPanel = $jQuery->getPluginClass('tabs', array(
       'id'            => 'initialPane',
       'tabDir'        => DIR_FS_CATALOG . 'includes/modules/pages_tabs/store_modules/',
       'tabs'          => $tabsArray,
       'footerButtons' => array($tabPanelBackButton, $tabPanelHelpButton),
       'showFooter'    => true
   ));
 
   $tabPanel->setHelpButton('helpButton', true);
    
   $breadcrumb->add(NAVBAR_TITLE, smn_href_link(FILENAME_STORE_MODULES));
?>