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

  if (!smn_session_is_registered('customer_id')) {
      $navigation->set_snapshot();
      smn_redirect(smn_href_link(FILENAME_LOGIN, 'ID=1', 'NONSSL'));
  }
  
  $languages = smn_get_languages();
  
  require('includes/classes/site_text.php');
  $siteText = new site_text($languages_id, $store_id);
    
  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  if (smn_not_null($action)) {
      if (method_exists($siteText, $action)){
          $siteText->$action();
      }else{
          $siteText->setJsonResponse('{
              success: false,
              errorMsg: "Unknown Action (' . $action . ')"
          }');
      }
      
      if ($siteText->hasResponse() === true){
          echo $siteText->getJsonResponse();
          exit;
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
  $tabsArray[] = array(
      'tabID'    => 'tab-site_text',
      'filename' => 'tab_site_text.php',
      'text'     => 'Site Text'
  );
 
  $tabsArray[] = array(
      'tabID'    => 'tab-articles',
      'filename' => 'tab_articles.php',
      'text'     => 'Web Articles'
  );
    
  $tabsArray[] = array(
      'tabID'    => 'tab-info_pages',
      'filename' => 'tab_info_pages.php',
      'text'     => 'Info Pages'
  );
    
  $tabsArray[] = array(
      'tabID'    => 'tab-description',
      'filename' => 'tab_description.php',
      'text'     => 'Store Description'
  );
/*    
  $tabsArray[] = array(
      'tabID'    => 'tab-help_text',
      'filename' => 'tab_help_text.php',
      'text'     => 'Help Text'
  );
*/ 
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
      'tabDir'        => DIR_FS_CATALOG . 'includes/modules/pages_tabs/text_editor/',
      'tabs'          => $tabsArray,
      'footerButtons' => array($tabPanelBackButton, $tabPanelHelpButton),
      'showFooter'    => true
  ));
 
  $tabPanel->setHelpButton('helpButton', true);
/* Setup Tabs - END */

  $breadcrumb->add(NAVBAR_TITLE, smn_href_link(FILENAME_STORE_TEXT_EDITOR, 'ID='.$store_id, 'NONSSL'));
?>