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

 if ($_GET['action'] == 'edit_process') {
     echo smn_draw_form('account', FILENAME_ADMIN_ACCOUNT, 'action=save_account', 'post', 'enctype="multipart/form-data"');
 } elseif ($_GET['action'] == 'check_account') {
     echo smn_draw_form('account', FILENAME_ADMIN_ACCOUNT, 'action=check_password', 'post', 'enctype="multipart/form-data"');
 } else {
     echo smn_draw_form('account', FILENAME_ADMIN_ACCOUNT, 'action=check_account', 'post', 'enctype="multipart/form-data"');
 }
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
   <td><table border="0" width="100%" cellspacing="0" cellpadding="0" align="center">
    <tr>
     <td valign="top">
<?php
  $my_account_query = smn_db_query ("select a.admin_id, a.admin_firstname, a.admin_lastname, a.admin_email_address, a.admin_created, a.admin_modified, a.admin_logdate, a.admin_lognum, g.admin_groups_name from " . TABLE_ADMIN . " a, " . TABLE_ADMIN_GROUPS . " g where a.admin_id= " . $login_id . " and g.admin_groups_id= " . $login_groups_id . "");
  $myAccount = smn_db_fetch_array($my_account_query);
?>
     <table border="0" width="100%" cellspacing="0" cellpadding="2" align="center">
      <tr class="dataTableHeadingRow">
       <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_ACCOUNT; ?></td>
      </tr>
      <tr class="dataTableRow">
       <td><table border="0" cellspacing="0" cellpadding="3">
<?php
    if ( ($_GET['action'] == 'edit_process') && (smn_session_is_registered('confirm_account')) ) {
?>
        <tr>
         <td class="dataTableContent"><nobr><?php echo TEXT_INFO_FIRSTNAME; ?>&nbsp;&nbsp;&nbsp;</nobr></td>
         <td class="dataTableContent"><?php echo smn_draw_input_field('admin_firstname', $myAccount['admin_firstname']); ?></td>
        </tr>
        <tr>
         <td class="dataTableContent"><nobr><?php echo TEXT_INFO_LASTNAME; ?>&nbsp;&nbsp;&nbsp;</nobr></td>
         <td class="dataTableContent"><?php echo smn_draw_input_field('admin_lastname', $myAccount['admin_lastname']); ?></td>
        </tr>
        <tr>
         <td class="dataTableContent"><nobr><?php echo TEXT_INFO_EMAIL; ?>&nbsp;&nbsp;&nbsp;</nobr></td>
         <td class="dataTableContent"><?php if ($_GET['error']) { echo smn_draw_input_field('admin_email_address', $myAccount['admin_email_address']) . ' <nobr>' . TEXT_INFO_ERROR . '</nobr>'; } else { echo smn_draw_input_field('admin_email_address', $myAccount['admin_email_address']); } ?></td>
        </tr>
        <tr>
         <td class="dataTableContent"><nobr><?php echo TEXT_INFO_PASSWORD; ?>&nbsp;&nbsp;&nbsp;</nobr></td>
         <td class="dataTableContent"><?php echo smn_draw_password_field('admin_password'); ?></td>
        </tr>
        <tr>
         <td class="dataTableContent"><nobr><?php echo TEXT_INFO_PASSWORD_CONFIRM; ?>&nbsp;&nbsp;&nbsp;</nobr></td>
         <td class="dataTableContent"><?php echo smn_draw_password_field('admin_password_confirm'); ?></td>
        </tr>
<?php
    } else {
    if (smn_session_is_registered('confirm_account')) {
      smn_session_unregister('confirm_account');
    }
?>                        
        <tr>
         <td class="dataTableContent"><nobr><?php echo TEXT_INFO_FULLNAME; ?>&nbsp;&nbsp;&nbsp;</nobr></td>
         <td class="dataTableContent"><?php echo $myAccount['admin_firstname'] . ' ' . $myAccount['admin_lastname']; ?></td>
        </tr>
        <tr>
         <td class="dataTableContent"><nobr><?php echo TEXT_INFO_EMAIL; ?>&nbsp;&nbsp;&nbsp;</nobr></td>
         <td class="dataTableContent"><?php echo $myAccount['admin_email_address']; ?></td>
        </tr>
        <tr>
         <td class="dataTableContent"><nobr><?php echo TEXT_INFO_PASSWORD; ?>&nbsp;&nbsp;&nbsp;</nobr></td>
         <td class="dataTableContent"><?php echo TEXT_INFO_PASSWORD_HIDDEN; ?></td>
        </tr>
        <tr class="dataTableRowSelected">
         <td class="dataTableContent"><nobr><?php echo TEXT_INFO_GROUP; ?>&nbsp;&nbsp;&nbsp;</nobr></td>
         <td class="dataTableContent"><?php echo $myAccount['admin_groups_name']; ?></td>
        </tr>
        <tr>
         <td class="dataTableContent"><nobr><?php echo TEXT_INFO_CREATED; ?>&nbsp;&nbsp;&nbsp;</nobr></td>
         <td class="dataTableContent"><?php echo $myAccount['admin_created']; ?></td>
        </tr>
        <tr>
         <td class="dataTableContent"><nobr><?php echo TEXT_INFO_LOGNUM; ?>&nbsp;&nbsp;&nbsp;</nobr></td>
         <td class="dataTableContent"><?php echo $myAccount['admin_lognum']; ?></td>
        </tr>
        <tr>
         <td class="dataTableContent"><nobr><?php echo TEXT_INFO_LOGDATE; ?>&nbsp;&nbsp;&nbsp;</nobr></td>
         <td class="dataTableContent"><?php echo $myAccount['admin_logdate']; ?></td>
        </tr>
<?php
  }
?>                       
       </table></td>
      </tr>
      <tr>
       <td><table width="100%" border="0" cellspacing="0" cellpadding="3">
        <tr>
         <td class="smallText" valign="top"><?php echo TEXT_INFO_MODIFIED . $myAccount['admin_modified']; ?></td>
         <td align="right"><?php
          if ($_GET['action'] == 'edit_process') {
              echo '<a href="' . smn_href_link(FILENAME_ADMIN_ACCOUNT) . '">' . smn_image_button('button_back.gif', IMAGE_BACK) . '</a> ';
              if (smn_session_is_registered('confirm_account')) {
                  echo smn_image_submit('button_save.gif', IMAGE_SAVE);
              }
          } elseif ($_GET['action'] == 'check_account') {
              echo '&nbsp;';
          } else {
              echo smn_image_submit('button_edit.gif', IMAGE_EDIT);
          }
         ?></td>
        </tr>
       </table></td>
      </tr>              
     </table></td>
<?php
  $heading = array();
  $contents = array();
  switch ($_GET['action']) {
    case 'edit_process':
      $heading[] = array('text' => '<b>&nbsp;' . TEXT_INFO_HEADING_DEFAULT . '</b>');
      
      $contents[] = array('text' => TEXT_INFO_INTRO_EDIT_PROCESS . smn_draw_hidden_field('id_info', $myAccount['admin_id']));
      //$contents[] = array('align' => 'center', 'text' => '<a href="' . smn_href_link(FILENAME_ADMIN_ACCOUNT) . '">' . smn_image_button('button_back.gif', IMAGE_BACK) . '</a> ' . smn_image_submit('button_confirm.gif', IMAGE_CONFIRM, 'onClick="validateForm();return document.returnValue"') . '<br>&nbsp');
      break; 
    case 'check_account':
      $heading[] = array('text' => '<b>&nbsp;' . TEXT_INFO_HEADING_CONFIRM_PASSWORD . '</b>');
      
      $contents[] = array('text' => '&nbsp;' . TEXT_INFO_INTRO_CONFIRM_PASSWORD . smn_draw_hidden_field('id_info', $myAccount['admin_id']));
      if ($_GET['error']) {
        $contents[] = array('text' => '&nbsp;' . TEXT_INFO_INTRO_CONFIRM_PASSWORD_ERROR);
      }
      $contents[] = array('align' => 'center', 'text' => smn_draw_password_field('password_confirmation'));
      $contents[] = array('align' => 'center', 'text' => '<a href="' . smn_href_link(FILENAME_ADMIN_ACCOUNT) . '">' . smn_image_button('button_back.gif', IMAGE_BACK) . '</a> ' . smn_image_submit('button_confirm.gif', IMAGE_CONFIRM) . '<br>&nbsp');
      break; 
    default:
      $heading[] = array('text' => '<b>&nbsp;' . TEXT_INFO_HEADING_DEFAULT . '</b>');
      
      $contents[] = array('text' => TEXT_INFO_INTRO_DEFAULT);
      //$contents[] = array('align' => 'center', 'text' => smn_image_submit('button_edit.gif', IMAGE_EDIT) . '<br>&nbsp');
      if ($myAccount['admin_email_address'] == 'admin@localhost') {
        $contents[] = array('text' => sprintf(TEXT_INFO_INTRO_DEFAULT_FIRST, $myAccount['admin_firstname']) . '<br>&nbsp');
      } elseif (($myAccount['admin_modified'] == '0000-00-00 00:00:00') || ($myAccount['admin_logdate'] <= 1) ) {
        $contents[] = array('text' => sprintf(TEXT_INFO_INTRO_DEFAULT_FIRST_TIME, $myAccount['admin_firstname']) . '<br>&nbsp');
      }
      
  }
  
  if ( (smn_not_null($heading)) && (smn_not_null($contents)) ) {
    echo '     <td width="25%" valign="top">' . "\n";

    $box = new box;
    echo $box->infoBox($heading, $contents);

    echo '     </td>' . "\n";
  }
?>
    </tr>
   </table></td>
  </tr>
 </table></form>