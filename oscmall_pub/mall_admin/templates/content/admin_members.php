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
?>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">
<?php
 if ($_GET['gPath']) {
   $group_name_query = smn_db_query("select admin_groups_name, admin_sales_cost, admin_groups_max_products from " . TABLE_ADMIN_GROUPS . " where admin_groups_id = " . $_GET['gPath']);
   $group_name = smn_db_fetch_array($group_name_query);
  
   if ($_GET['gPath'] == 1) {
     echo smn_draw_form('defineForm', FILENAME_ADMIN_MEMBERS, 'gID=' . $_GET['gPath']);
   } elseif ($_GET['gPath'] != 1) {
     echo smn_draw_form('defineForm', FILENAME_ADMIN_MEMBERS, 'gID=' . $_GET['gPath'] . '&action=group_define', 'post', 'enctype="multipart/form-data"');
     echo smn_draw_hidden_field('admin_groups_id', $_GET['gPath']); 
   }
?>
            <table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td colspan=2 class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_GROUPS_DEFINE; ?></td>
              </tr>
<?php
  $db_boxes_query = smn_db_query("select admin_files_id as admin_boxes_id, admin_files_name as admin_boxes_name, admin_groups_id as boxes_group_id from " . TABLE_ADMIN_FILES . " where admin_files_is_boxes = '1' order by admin_files_name");
  while ($group_boxes = smn_db_fetch_array($db_boxes_query)) {
    $group_boxes_files_query = smn_db_query("select admin_files_id, admin_files_name, admin_groups_id from " . TABLE_ADMIN_FILES . " where admin_files_is_boxes = '0' and admin_files_to_boxes = '" . $group_boxes['admin_boxes_id'] . "' order by admin_files_name");

    $selectedGroups = $group_boxes['boxes_group_id'];
    $groupsArray = explode(",", $selectedGroups);

    if (in_array($_GET['gPath'], $groupsArray)) {     
      $del_boxes = array($_GET['gPath']);
      $result = array_diff ($groupsArray, $del_boxes);
      sort($result);
      $checkedBox = $selectedGroups;
      $uncheckedBox = implode (",", $result);
      $checked = true;
    } else {
      $add_boxes = array($_GET['gPath']);
      $result = array_merge ($add_boxes, $groupsArray);
      sort($result);
      $checkedBox = implode (",", $result);
      $uncheckedBox = $selectedGroups;
      $checked = false;
    }    
?>
              <tr class="dataTableRowBoxes">
                <td class="dataTableContent" width="23"><?php echo smn_draw_checkbox_field('groups_to_boxes[]', $group_boxes['admin_boxes_id'], $checked, '', 'id="groups_' . $group_boxes['admin_boxes_id'] . '" onClick="checkGroups(this)"'); ?></td>
                <td class="dataTableContent"><b><?php echo ucwords(substr_replace ($group_boxes['admin_boxes_name'], '', -4)) . ' ' . smn_draw_hidden_field('checked_' . $group_boxes['admin_boxes_id'], $checkedBox) . smn_draw_hidden_field('unchecked_' . $group_boxes['admin_boxes_id'], $uncheckedBox); ?></b></td>
              </tr>
              <tr class="dataTableRow">
                <td class="dataTableContent">&nbsp;</td>
                <td class="dataTableContent">
                  <table border="0" cellspacing="0" cellpadding="0">
<?php
     //$group_boxes_files_query = smn_db_query("select admin_files_id, admin_files_name, admin_groups_id from " . TABLE_ADMIN_FILES . " where admin_files_is_boxes = '0' and admin_files_to_boxes = '" . $group_boxes['admin_boxes_id'] . "' order by admin_files_name");
     while($group_boxes_files = smn_db_fetch_array($group_boxes_files_query)) {
       $selectedGroups = $group_boxes_files['admin_groups_id'];
       $groupsArray = explode(",", $selectedGroups);

       if (in_array($_GET['gPath'], $groupsArray)) {     
         $del_boxes = array($_GET['gPath']);
         $result = array_diff ($groupsArray, $del_boxes);
         sort($result);
         $checkedBox = $selectedGroups;
         $uncheckedBox = implode (",", $result);
         $checked = true;
       } else {
         $add_boxes = array($_GET['gPath']);
         $result = array_merge ($add_boxes, $groupsArray);
         sort($result);
         $checkedBox = implode (",", $result);
         $uncheckedBox = $selectedGroups;
         $checked = false;
       }
?>
                                       
                    <tr>
                      <td width="20"><?php echo smn_draw_checkbox_field('groups_to_boxes[]', $group_boxes_files['admin_files_id'], $checked, '', 'id="subgroups_' . $group_boxes['admin_boxes_id'] . '" onClick="checkSub(this)"'); ?></td>
                      <td class="dataTableContent"><?php echo $group_boxes_files['admin_files_name'] . ' ' . smn_draw_hidden_field('checked_' . $group_boxes_files['admin_files_id'], $checkedBox) . smn_draw_hidden_field('unchecked_' . $group_boxes_files['admin_files_id'], $uncheckedBox);?></td>
                    </tr>
<?php       
     }
?>
                  </table>
                </td>
              </tr>              
<?php
  }
?>
              <tr class="dataTableRowBoxes">
                <td colspan=2 class="dataTableContent" valign="top" align="right"><?php if ($_GET['gPath'] != 1) { echo  '<a href="' . smn_href_link(FILENAME_ADMIN_MEMBERS, 'gID=' . $_GET['gPath']) . '">' . smn_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a> ' . smn_image_submit('button_save.gif', IMAGE_INSERT); } else { echo smn_image_submit('button_back.gif', IMAGE_BACK); } ?>&nbsp;</td>
              </tr>
            </table></form>
<?php
 } elseif ($_GET['gID']) {
?>
            <table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent" align="left">&nbsp;<?php echo TABLE_HEADING_GROUPS_NAME; ?></td>
		<td class="dataTableHeadingContent" align="center">&nbsp;<?php echo TABLE_HEADING_GROUPS_MAX_PRODUCTS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
  $db_groups_query = smn_db_query("select * from " . TABLE_ADMIN_GROUPS . " order by admin_groups_id");
  
  $add_groups_prepare = '\'0\'' ;
  $del_groups_prepare = '\'0\'' ;
  $count_groups = 0;
  while ($groups = smn_db_fetch_array($db_groups_query)) {
    $add_groups_prepare .= ',\'' . $groups['admin_groups_id'] . '\'' ;
    if (((!$_GET['gID']) || ($_GET['gID'] == $groups['admin_groups_id']) || ($_GET['gID'] == 'groups')) && (!$gInfo) ) {
      $gInfo = new objectInfo($groups);
    }
   
    if ( (is_object($gInfo)) && ($groups['admin_groups_id'] == $gInfo->admin_groups_id) ) {
      echo '                <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . smn_href_link(FILENAME_ADMIN_MEMBERS, 'gID=' . $groups['admin_groups_id'] . '&action=edit_group') . '\'">' . "\n";
    } else {
      echo '                <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . smn_href_link(FILENAME_ADMIN_MEMBERS, 'gID=' . $groups['admin_groups_id']) . '\'">' . "\n";
      $del_groups_prepare .= ',\'' . $groups['admin_groups_id'] . '\'' ;
    }
?>
                <td class="dataTableContent" align="left">&nbsp;<b><?php echo $groups['admin_groups_name']; ?></b></td>
		<td class="dataTableContent" align="center">&nbsp;<b><?php echo $groups['admin_groups_max_products']; ?></b></td>
		<td class="dataTableContent" align="right"><?php if ( (is_object($gInfo)) && ($groups['admin_groups_id'] == $gInfo->admin_groups_id) ) { echo smn_image(DIR_WS_IMAGES . 'icon_arrow_right.gif'); } else { echo '<a href="' . smn_href_link(FILENAME_ADMIN_MEMBERS, 'gID=' . $groups['admin_groups_id']) . '">' . smn_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    $count_groups++;
  } 
?>
              <tr>
                <td colspan="2"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo TEXT_COUNT_GROUPS . $count_groups; ?></td>
                    <td class="smallText" valign="top" align="right"><?php echo '<a href="' . smn_href_link(FILENAME_ADMIN_MEMBERS) . '">' . smn_image_button('button_back.gif', IMAGE_BACK) . '</a> <a href="' . smn_href_link(FILENAME_ADMIN_MEMBERS, 'gID=' . $gInfo->admin_groups_id . '&action=new_group') . '">' . smn_image_button('button_admin_group.gif', IMAGE_NEW_GROUP) . '</a>'; ?>&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
            </table>
<?php
 } else {
?> 
            <table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_NAME; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_EMAIL; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_GROUPS; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_LOGNUM; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
  $db_admin_query_raw = "select * from " . TABLE_ADMIN . " order by admin_firstname";
  
  $db_admin_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $db_admin_query_raw, $db_admin_query_numrows);
  $db_admin_query = smn_db_query($db_admin_query_raw);
  //$db_admin_num_row = smn_db_num_rows($db_admin_query);
  
  while ($admin = smn_db_fetch_array($db_admin_query)) {
    $admin_group_query = smn_db_query("select admin_groups_name from " . TABLE_ADMIN_GROUPS . " where admin_groups_id = '" . $admin['admin_groups_id'] . "'");
    $admin_group = smn_db_fetch_array ($admin_group_query);
    if (((!$_GET['mID']) || ($_GET['mID'] == $admin['admin_id'])) && (!$mInfo) ) {
      $mInfo_array = array_merge($admin, $admin_group);
      $mInfo = new objectInfo($mInfo_array);
    }
   
    if ( (is_object($mInfo)) && ($admin['admin_id'] == $mInfo->admin_id) ) {
      echo '                  <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . smn_href_link(FILENAME_ADMIN_MEMBERS, 'page=' . $_GET['page'] . '&mID=' . $admin['admin_id'] . '&action=edit_member') . '\'">' . "\n";
    } else {
      echo '                  <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . smn_href_link(FILENAME_ADMIN_MEMBERS, 'page=' . $_GET['page'] . '&mID=' . $admin['admin_id']) . '\'">' . "\n";
    }
?>
                <td class="dataTableContent">&nbsp;<?php echo $admin['admin_firstname']; ?>&nbsp;<?php echo $admin['admin_lastname']; ?></td>
                <td class="dataTableContent"><?php echo $admin['admin_email_address']; ?></td>
                <td class="dataTableContent" align="center"><?php echo $admin_group['admin_groups_name']; ?></td>
                <td class="dataTableContent" align="center"><?php echo $admin['admin_lognum']; ?></td>
                <td class="dataTableContent" align="right"><?php if ( (is_object($mInfo)) && ($admin['admin_id'] == $mInfo->admin_id) ) { echo smn_image(DIR_WS_IMAGES . 'icon_arrow_right.gif'); } else { echo '<a href="' . smn_href_link(FILENAME_ADMIN_MEMBERS, 'page=' . $_GET['page'] . '&mID=' . $admin['admin_id']) . '">' . smn_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
  } 
?>
              <tr>
                <td colspan="5"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $db_admin_split->display_count($db_admin_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_MEMBERS); ?><br><?php echo $db_admin_split->display_links($db_admin_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                    <td class="smallText" valign="top" align="right"><?php echo '<a href="' . smn_href_link(FILENAME_ADMIN_MEMBERS, 'gID=groups') . '">' . smn_image_button('button_admin_groups.gif', IMAGE_GROUPS) . '</a>'; //echo ' <a href="' . smn_href_link(FILENAME_ADMIN_MEMBERS, 'page=' . $_GET['page'] . '&mID=' . $mInfo->admin_id . '&action=new_member') . '">' . smn_image_button('button_admin_member.gif', IMAGE_NEW_MEMBER) . '</a>'; ?>&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
            </table>
<?php
 }
?>
            </td>
<?php
  $heading = array();
  $contents = array();
  switch ($_GET['action']) {  
    case 'new_member': 
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_NEW . '</b>');

      $contents = array('form' => smn_draw_form('newmember', FILENAME_ADMIN_MEMBERS, 'action=member_new&page=' . $page . 'mID=' . $_GET['mID'], 'post', 'enctype="multipart/form-data"')); 
      if ($_GET['error']) {
        $contents[] = array('text' => TEXT_INFO_ERROR); 
      }
      $contents[] = array('text' => '<br>&nbsp;' . TEXT_INFO_FIRSTNAME . '<br>&nbsp;' . smn_draw_input_field('admin_firstname')); 
      $contents[] = array('text' => '<br>&nbsp;' . TEXT_INFO_LASTNAME . '<br>&nbsp;' . smn_draw_input_field('admin_lastname'));
      $contents[] = array('text' => '<br>&nbsp;' . TEXT_INFO_EMAIL . '<br>&nbsp;' . smn_draw_input_field('admin_email_address')); 
      
      $groups_array = array(array('id' => '0', 'text' => TEXT_NONE));
      $groups_query = smn_db_query("select admin_groups_id, admin_groups_name from " . TABLE_ADMIN_GROUPS);
      while ($groups = smn_db_fetch_array($groups_query)) {
        $groups_array[] = array('id' => $groups['admin_groups_id'],
                                'text' => $groups['admin_groups_name']);
      }
      $contents[] = array('text' => '<br>&nbsp;' . TEXT_INFO_GROUP . '<br>&nbsp;' . smn_draw_pull_down_menu('admin_groups_id', $groups_array, '0')); 
      $contents[] = array('align' => 'center', 'text' => '<br>' . smn_image_submit('button_insert.gif', IMAGE_INSERT, 'onClick="validateForm();return document.returnValue"') . ' <a href="' . smn_href_link(FILENAME_ADMIN_MEMBERS, 'page=' . $_GET['page'] . '&mID=' . $_GET['mID']) . '">' . smn_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');    
      break;
    case 'edit_member': 
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_NEW . '</b>');
      
      $contents = array('form' => smn_draw_form('newmember', FILENAME_ADMIN_MEMBERS, 'action=member_edit&page=' . $page . '&mID=' . $_GET['mID'], 'post', 'enctype="multipart/form-data"')); 
      if ($_GET['error']) {
        $contents[] = array('text' => TEXT_INFO_ERROR); 
      }
      $contents[] = array('text' => smn_draw_hidden_field('admin_id', $mInfo->admin_id)); 
      $contents[] = array('text' => '<br>&nbsp;' . TEXT_INFO_FIRSTNAME . '<br>&nbsp;' . smn_draw_input_field('admin_firstname', $mInfo->admin_firstname)); 
      $contents[] = array('text' => '<br>&nbsp;' . TEXT_INFO_LASTNAME . '<br>&nbsp;' . smn_draw_input_field('admin_lastname', $mInfo->admin_lastname));
      $contents[] = array('text' => '<br>&nbsp;' . TEXT_INFO_EMAIL . '<br>&nbsp;' . smn_draw_input_field('admin_email_address', $mInfo->admin_email_address)); 
      if ($mInfo->admin_id == 1) {      
        $contents[] = array('text' => smn_draw_hidden_field('admin_groups_id', $mInfo->admin_groups_id));
      } else {
        $groups_array = array(array('id' => '0', 'text' => TEXT_NONE));
        $groups_query = smn_db_query("select admin_groups_id, admin_groups_name from " . TABLE_ADMIN_GROUPS);
        while ($groups = smn_db_fetch_array($groups_query)) {
          $groups_array[] = array('id' => $groups['admin_groups_id'],
                                  'text' => $groups['admin_groups_name']);
        }
        $contents[] = array('text' => '<br>&nbsp;' . TEXT_INFO_GROUP . '<br>&nbsp;' . smn_draw_pull_down_menu('admin_groups_id', $groups_array, $mInfo->admin_groups_id)); 
      }
      $contents[] = array('align' => 'center', 'text' => '<br>' . smn_image_submit('button_insert.gif', IMAGE_INSERT, 'onClick="validateForm();return document.returnValue"') . ' <a href="' . smn_href_link(FILENAME_ADMIN_MEMBERS, 'page=' . $_GET['page'] . '&mID=' . $_GET['mID']) . '">' . smn_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');    
      break;
    case 'del_member': 
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE . '</b>');
      if ($mInfo->admin_id == 1 || $mInfo->admin_email_address == STORE_OWNER_EMAIL_ADDRESS) {
      $contents[] = array('align' => 'center', 'text' => '<br><a href="' . smn_href_link(FILENAME_ADMIN_MEMBERS, 'page=' . $_GET['page'] . '&mID=' . $mInfo->admin_id) . '">' . smn_image_button('button_back.gif', IMAGE_BACK) . '</a><br>&nbsp;');
      } else {
      $contents = array('form' => smn_draw_form('edit', FILENAME_ADMIN_MEMBERS, 'action=member_delete&page=' . $page . '&mID=' . $admin['admin_id'], 'post', 'enctype="multipart/form-data"')); 
      $contents[] = array('text' => smn_draw_hidden_field('admin_id', $mInfo->admin_id));
      $contents[] = array('align' => 'center', 'text' =>  sprintf(TEXT_INFO_DELETE_INTRO, $mInfo->admin_firstname . ' ' . $mInfo->admin_lastname));    
      $contents[] = array('align' => 'center', 'text' => '<br>' . smn_image_submit('button_delete.gif', IMAGE_DELETE) . ' <a href="' . smn_href_link(FILENAME_ADMIN_MEMBERS, 'page=' . $_GET['page'] . '&mID=' . $_GET['mID']) . '">' . smn_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');    
      }
      break;
    case 'new_group':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_GROUPS . '</b>');
      $contents = array('form' => smn_draw_form('new_group', FILENAME_ADMIN_MEMBERS, 'action=group_new&gID=' . $gInfo->admin_groups_id, 'post', 'enctype="multipart/form-data"')); 
      if ($_GET['gName'] == 'false') {
        $contents[] = array('text' => TEXT_INFO_GROUPS_NAME_FALSE . '<br>&nbsp;');
      } elseif ($_GET['gName'] == 'used') {
        $contents[] = array('text' => TEXT_INFO_GROUPS_NAME_USED . '<br>&nbsp;');
      }
      $contents[] = array('align' => 'left', 'text' => smn_draw_hidden_field('set_groups_id', substr($add_groups_prepare, 4)) );
      $contents[] = array('align' => 'left', 'text' => TEXT_INFO_GROUPS_NAME  . '<br>' .TEXT_INFO_EDIT_GROUP_NAME . '<br>&nbsp;<br>' . smn_draw_input_field('admin_groups_name'));
      $contents[] = array('align' => 'left', 'text' => TEXT_INFO_EDIT_GROUP_STORE_TYPE . '<br>&nbsp;<br>' . smn_pull_down_store_list());
      $contents[] = array('align' => 'left', 'text' => TEXT_INFO_EDIT_GROUP_COST . '<br>&nbsp;<br>' . smn_draw_input_field('admin_groups_cost')); 
      $contents[] = array('align' => 'left', 'text' => TEXT_INFO_EDIT_GROUP_MAX_PRODUCTS . '<br>&nbsp;<br>' . smn_draw_input_field('admin_groups_max_products'));
      $contents[] = array('align' => 'left', 'text' => TEXT_INFO_EDIT_SALES_COST . '<br>&nbsp;<br>' . smn_draw_input_field('admin_sales_cost')); 
      $contents[] = array('align' => 'center', 'text' => '<br><a href="' . smn_href_link(FILENAME_ADMIN_MEMBERS, 'gID=' . $gInfo->admin_groups_id) . '">' . smn_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a> ' . smn_image_submit('button_next.gif', IMAGE_NEXT) );    
      break;
    case 'edit_group': 
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_GROUP . '</b>');

      $contents = array('form' => smn_draw_form('edit_group', FILENAME_ADMIN_MEMBERS, 'action=group_edit&gID=' . $_GET['gID'], 'post', 'enctype="multipart/form-data"')); 
      if ($_GET['gName'] == 'false') {
        $contents[] = array('text' => TEXT_INFO_GROUPS_NAME_FALSE . '<br>&nbsp;');
      } elseif ($_GET['gName'] == 'used') {
        $contents[] = array('text' => TEXT_INFO_GROUPS_NAME_USED . '<br>&nbsp;');
      }      
      $contents[] = array('align' => 'left', 'text' => TEXT_INFO_EDIT_GROUP_NAME . '<br>&nbsp;<br>' . smn_draw_input_field('admin_groups_name', $gInfo->admin_groups_name));
      $contents[] = array('align' => 'left', 'text' => TEXT_INFO_EDIT_GROUP_STORE_TYPE . '<br>&nbsp;<br>' . smn_pull_down_store_list($gInfo->admin_groups_store_type)); 
      $contents[] = array('align' => 'left', 'text' => TEXT_INFO_EDIT_GROUP_MAX_PRODUCTS . '<br>&nbsp;<br>' . smn_draw_input_field('admin_groups_max_products', $gInfo->admin_groups_max_products));
      $contents[] = array('align' => 'left', 'text' => TEXT_INFO_EDIT_SALES_COST . '<br>&nbsp;<br>' . smn_draw_input_field('admin_sales_cost', $gInfo->admin_sales_cost));
      $contents[] = array('align' => 'center', 'text' => '<br>' . smn_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . smn_href_link(FILENAME_ADMIN_MEMBERS, 'gID=' . $gInfo->admin_groups_id) . '">' . smn_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');    
      break;
    case 'del_group': 
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_GROUPS . '</b>');

      $contents = array('form' => smn_draw_form('delete_group', FILENAME_ADMIN_MEMBERS, 'action=group_delete&gID=' . $gInfo->admin_groups_id, 'post', 'enctype="multipart/form-data"')); 
      if ($gInfo->admin_groups_id == 1) {
        $contents[] = array('align' => 'center', 'text' => sprintf(TEXT_INFO_DELETE_GROUPS_INTRO_NOT, $gInfo->admin_groups_name));
        $contents[] = array('align' => 'center', 'text' => '<br><a href="' . smn_href_link(FILENAME_ADMIN_MEMBERS, 'gID=' . $_GET['gID']) . '">' . smn_image_button('button_back.gif', IMAGE_BACK) . '</a><br>&nbsp;');
      } else {
        $contents[] = array('text' => smn_draw_hidden_field('set_groups_id', substr($del_groups_prepare, 4)) );
        $contents[] = array('align' => 'center', 'text' => sprintf(TEXT_INFO_DELETE_GROUPS_INTRO, $gInfo->admin_groups_name));    
        $contents[] = array('align' => 'center', 'text' => '<br>' . smn_image_submit('button_delete.gif', IMAGE_DELETE) . ' <a href="' . smn_href_link(FILENAME_ADMIN_MEMBERS, 'gID=' . $_GET['gID']) . '">' . smn_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a><br>&nbsp;');    
      }
      break;
    case 'define_group':      
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DEFINE . '</b>');
      	
      $contents[] = array('text' => sprintf(TEXT_INFO_DEFINE_INTRO, $group_name['admin_groups_name']));
      if ($_GET['gPath'] == 1) {
        $contents[] = array('align' => 'center', 'text' => '<a href="' . smn_href_link(FILENAME_ADMIN_MEMBERS, 'gID=' . $_GET['gPath']) . '">' . smn_image_button('button_back.gif', IMAGE_CANCEL) . '</a><br>');      
      }
      break;
    case 'show_group': 
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_GROUP . '</b>');
        $check_email_query = smn_db_query("select admin_email_address from " . TABLE_ADMIN . "");
        //$stored_email[];
        while ($check_email = smn_db_fetch_array($check_email_query)) {
          $stored_email[] = $check_email['admin_email_address'];
        }
        
        if (in_array($_POST['admin_email_address'], $stored_email)) {
          $checkEmail = "true";
        } else {
          $checkEmail = "false";
        }
      $contents = array('form' => smn_draw_form('show_group', FILENAME_ADMIN_MEMBERS, 'action=show_group&gID=groups', 'post', 'enctype="multipart/form-data"')); 
      $contents[] = array('text' => $define_files['admin_files_name'] . smn_draw_input_field('level_edit', $checkEmail)); 
      //$contents[] = array('align' => 'center', 'text' => '<br>' . smn_image_submit('button_insert.gif', IMAGE_INSERT) . ' <a href="' . smn_href_link(FILENAME_ADMIN_MEMBERS, 'gID=' . $gInfo->admin_groups_id) . '">' . smn_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');    
      break;
    default:
      if (is_object($mInfo)) {
        $heading[] = array('text' => '<b>&nbsp;' . TEXT_INFO_HEADING_DEFAULT . '</b>');
        $contents[] = array('align' => 'center', 'text' => '<a href="' . smn_href_link(FILENAME_ADMIN_MEMBERS, 'page=' . $_GET['page'] . '&mID=' . $mInfo->admin_id . '&action=edit_member') . '">' . smn_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . smn_href_link(FILENAME_ADMIN_MEMBERS, 'page=' . $_GET['page'] . '&mID=' . $mInfo->admin_id . '&action=del_member') . '">' . smn_image_button('button_delete.gif', IMAGE_DELETE) . '</a><br>&nbsp;');
        $contents[] = array('text' => '&nbsp;<b>' . TEXT_INFO_FULLNAME . '</b><br>&nbsp;' . $mInfo->admin_firstname . ' ' . $mInfo->admin_lastname);
        $contents[] = array('text' => '&nbsp;<b>' . TEXT_INFO_EMAIL . '</b><br>&nbsp;' . $mInfo->admin_email_address);
        $contents[] = array('text' => '&nbsp;<b>' . TEXT_INFO_GROUP . '</b>' . $mInfo->admin_groups_name);
        $contents[] = array('text' => '&nbsp;<b>' . TEXT_INFO_CREATED . '</b><br>&nbsp;' . $mInfo->admin_created);
        $contents[] = array('text' => '&nbsp;<b>' . TEXT_INFO_MODIFIED . '</b><br>&nbsp;' . $mInfo->admin_modified);
        $contents[] = array('text' => '&nbsp;<b>' . TEXT_INFO_LOGDATE . '</b><br>&nbsp;' . $mInfo->admin_logdate);
        $contents[] = array('text' => '&nbsp;<b>' . TEXT_INFO_LOGNUM . '</b>' . $mInfo->admin_lognum);
        $contents[] = array('text' => '<br>');
      } elseif (is_object($gInfo)) {
        $heading[] = array('text' => '<b>&nbsp;' . TEXT_INFO_HEADING_DEFAULT_GROUPS . '</b>');
        
        $contents[] = array('align' => 'center', 'text' => '<a href="' . smn_href_link(FILENAME_ADMIN_MEMBERS, 'gPath=' . $gInfo->admin_groups_id . '&action=define_group') . '">' . smn_image_button('button_admin_permission.gif', IMAGE_FILE_PERMISSION) . '</a> <a href="' . smn_href_link(FILENAME_ADMIN_MEMBERS, 'gID=' . $gInfo->admin_groups_id . '&action=edit_group') . '">' . smn_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . smn_href_link(FILENAME_ADMIN_MEMBERS, 'gID=' . $gInfo->admin_groups_id . '&action=del_group') . '">' . smn_image_button('button_delete.gif', IMAGE_DELETE) . '</a>');
        $contents[] = array('text' => '<br>' . TEXT_INFO_DEFAULT_GROUPS_INTRO . '<br>&nbsp');
      }
  }
  
  if ( (smn_not_null($heading)) && (smn_not_null($contents)) ) {
    echo '            <td width="25%" valign="top">' . "\n";

    $box = new box;
    echo $box->infoBox($heading, $contents);

    echo '            </td>' . "\n";
  }
?>
          </tr>
        </table></td>
      </tr>
    </table>