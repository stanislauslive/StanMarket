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

 $paymentModules = new store_modules('payment');
 $shippingModules = new store_modules('shipping');
 $orderTotalModules = new store_modules('order_total');
     
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
 
 $tabPanelBackButton = $jQuery->getPluginClass('button');
 $tabPanelBackButton->setID('backButton');
 $tabPanelBackButton->setText('Back To Account');
 $tabPanelBackButton->setHref(smn_href_link(FILENAME_ACCOUNT, 'ID=' . $store_id));

 $tabPanel = $jQuery->getPluginClass('tabs', array(
     'id'            => 'initialPane',
     'tabDir'        => DIR_FS_CATALOG . 'includes/modules/pages_tabs/store_modules/',
     'tabs'          => $tabsArray,
     'footerButtons' => array($tabPanelHelpButton),
     'showFooter'    => true
 ));
 
 $tabPanel->setHelpButton('helpButton', true);
?>
<script language="Javascript">
$(document).ready(function (){
<?php
     echo $jQuery->getScriptOutput();
?>
});
</script>
<?php
     echo $tabPanel->output();
?>
