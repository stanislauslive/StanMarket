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

  if ($messageStack->size > 0) {
    echo $messageStack->output();
  }

/* Menu Setup - BEGIN */
  $menu = $jQuery->getPluginClass(JQUERY_MENU);
  if ($store->smn_admin_check_boxes('administrator.php') == true) {
    include(DIR_WS_BOXES . 'administrator.php');
  } 
  if ($store->smn_admin_check_boxes('configuration.php') == true) {
    include(DIR_WS_BOXES . 'configuration.php');
  }
  
  if ($store->smn_admin_check_boxes('catalog.php') == true) {
    include(DIR_WS_BOXES . 'catalog.php');
  } 
  if ($store->smn_admin_check_boxes('modules.php') == true) {
    include(DIR_WS_BOXES . 'modules.php');
  } 
  if ($store->smn_admin_check_boxes('customers_info.php') == true) {
    include(DIR_WS_BOXES . 'customers_info.php');
  }
  if ($store->smn_admin_check_boxes('gv_admin.php') == true) {
    require(DIR_WS_BOXES . 'gv_admin.php');
  }
  if ($store->smn_admin_check_boxes('taxes.php') == true) {
    include(DIR_WS_BOXES . 'taxes.php');
  } 
  if ($store->smn_admin_check_boxes('localization.php') == true) {
    include(DIR_WS_BOXES . 'localization.php');
  } 
  if ($store->smn_admin_check_boxes('reports.php') == true) {
    include(DIR_WS_BOXES . 'reports.php');
  } 
  if ($store->smn_admin_check_boxes('tools.php') == true) {
    include(DIR_WS_BOXES . 'tools.php');
  }
  
  if ($store->smn_admin_check_boxes('layout.php') == true) {
    include(DIR_WS_BOXES . 'layout.php');
  }
  if ($store->smn_admin_check_boxes('affiliate.php') == true) {
    require(DIR_WS_BOXES . 'affiliate.php');
  }
/* Menu Setup - END */  
?>
 <table border="0" width="100%" cellspacing="0" cellpadding="0" id="headerTable">
  <tr bgcolor="#FFFFFF">
   <td><?php echo smn_info_image(STORE_LOGO, $store_name, '200', ''); ?></td>
   <td align="right" bgcolor="#FFFFFF"></td>
  </tr>
  <tr class="headerBar">
   <td class="headerBarContent">&nbsp;&nbsp;<?php
    if (smn_session_is_registered('login_id')) {
        echo '<a href="' . smn_href_link(FILENAME_ADMIN_ACCOUNT, '', 'NONSSL') . '" class="headerLink">' . HEADER_TITLE_ACCOUNT . '</a>' . 
             ' &nbsp;|&nbsp; <a href="' . smn_href_link(FILENAME_LOGOFF, '', 'NONSSL') . '" class="headerLink">' . HEADER_TITLE_LOGOFF . '</a>';
    } else {
        echo '<a href="' . smn_href_link(FILENAME_DEFAULT, '', 'NONSSL') . '" class="headerLink">' . HEADER_TITLE_TOP . '</a>';
    }
    echo ' &nbsp;|&nbsp; <a href="http://www.systemsmanager.net" class="headerLink">' . HEADER_TITLE_SUPPORT_SITE . '</a>' . 
         ' &nbsp;|&nbsp; <a href="' . smn_catalog_href_link() . '" class="headerLink">' . HEADER_TITLE_ONLINE_CATALOG . '</a>' . 
         ' &nbsp;|&nbsp; <a href="' . smn_href_link(FILENAME_DEFAULT, '', 'NONSSL') . '" class="headerLink">' . HEADER_TITLE_ADMINISTRATION . '</a>' . 
         ' &nbsp;|&nbsp;<a href="javascript:popupWindow(\'' . 'includes/help/' . FILENAME_POPUP_HELP . '?HelpID=' . str_replace('.php', '', basename($PHP_SELF)) . '\')" class="headerLink">' . HEADER_TITLE_HELP . '</a>';
   ?></td>
   <td class="headerBarContent" align="center"></td>
  </tr>
<?php
  if ($super_user == 'true'){
      $groups_array = array(array('id' => '0', 'text' => TEXT_NONE));
      $groups_query = smn_db_query("select store_id, store_name from " . TABLE_STORE_DESCRIPTION);
      while ($groups = smn_db_fetch_array($groups_query)){
          $groups_array[] = array('id' => $groups['store_id'],
                                  'text' => $groups['store_name']);
      }
?>
  <tr class="headerBar">
   <td class="headerBarContent">&nbsp;&nbsp;You are Signed in Store :&nbsp;&nbsp;<?php echo $store->get_store_name(); ?></td>
   <td class="headerBarContent" align="right"><?php
    echo smn_draw_form('store', basename($PHP_SELF), '', 'post') . 
         'Switch to New Store : ' . 
         smn_draw_pull_down_menu('store', $groups_array, '', 'onChange="this.form.submit();"') . 
         '&nbsp;&nbsp;&nbsp;&nbsp;' . 
         '</form>';
   ?></td>
  </tr>
<?php
  }
  if (JQUERY_MENU == 'jd_menu'){
?>
  <tr class="headerBar">
   <td class="headerBarContent" colspan="2"><?php echo $menu->outputHTML();?></td>
  </tr>
<?php
  }
?>  
 </table>