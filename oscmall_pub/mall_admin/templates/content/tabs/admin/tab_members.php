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

/* Members Grid Setup - END */
  $Qmembers = smn_db_query('select a.*, ag.admin_groups_name from ' . TABLE_ADMIN . ' a left join ' . TABLE_ADMIN_GROUPS . ' ag using(admin_groups_id) order by a.admin_firstname');
  $membersGridData = array();
  while ($members = smn_db_fetch_array($Qmembers)){
      $membersGridData[] = array(
          'admin_id'            => $members['admin_id'], 
          'admin_groups_id'     => $members['admin_groups_id'], 
          'admin_groups_name'   => $members['admin_groups_name'], 
          'store_id'            => $members['store_id'], 
          'customer_id'         => $members['customer_id'], 
          'admin_firstname'     => $members['admin_firstname'], 
          'admin_lastname'      => $members['admin_lastname'], 
          'admin_name'          => $members['admin_firstname'] . ' ' . $members['admin_lastname'], 
          'admin_email_address' => $members['admin_email_address'], 
          'admin_password'      => $members['admin_password'], 
          'admin_created'       => $members['admin_created'], 
          'admin_modified'      => $members['admin_modified'], 
          'admin_logdate'       => $members['admin_logdate'], 
          'admin_lognum'        => $members['admin_lognum']
      );
  }
  
  $membersGridEditButton = $jQuery->getPluginClass('button', array(
      'id'   => 'membersGridEditButton',
      'text' => 'Edit Selected'
  ));
  
  $membersGridDeleteButton = $jQuery->getPluginClass('button', array(
      'id'   => 'membersGridDeleteButton',
      'text' => 'Delete Selected'
  ));
  
  $membersGridInsertButton = $jQuery->getPluginClass('button', array(
      'id'   => 'membersGridInsertButton',
      'text' => 'Insert New'
  ));
  
  $membersGrid = $jQuery->getPluginClass('basicgrid', array(
      'id'        => 'membersGrid',
      'paging'    => true,
      'mode'      => 'local',
      'page_size' => 20,
      'data'      => $membersGridData,
      'buttons'   => array($membersGridInsertButton, $membersGridEditButton, $membersGridDeleteButton),
      'columns'   => array(
          array('id' => 'admin_id',            'text' => 'ID',            'hidden'   => true),
          array('id' => 'admin_groups_id',     'text' => 'Group ID',      'hidden'   => true),
          array('id' => 'admin_groups_name',   'text' => TABLE_HEADING_GROUPS),
          array('id' => 'store_id',            'text' => 'Store ID',      'hidden'   => true),
          array('id' => 'customer_id',         'text' => 'Customer ID',   'hidden'   => true),
          array('id' => 'admin_firstname',     'text' => 'First Name',    'hidden'   => true),
          array('id' => 'admin_lastname',      'text' => 'Last Name',     'hidden'   => true),
          array('id' => 'admin_name',          'text' => TABLE_HEADING_NAME),
          array('id' => 'admin_email_address', 'text' => TABLE_HEADING_EMAIL),
          array('id' => 'admin_password',      'text' => 'Password',      'hidden'   => true),
          array('id' => 'admin_created',       'text' => 'Date Created',  'hidden'   => true),
          array('id' => 'admin_modified',      'text' => 'Date Modified', 'hidden'   => true),
          array('id' => 'admin_logdate',       'text' => 'Last Login',    'hidden'   => true),
          array('id' => 'admin_lognum',        'text' => TABLE_HEADING_LOGNUM)
      )
  ));
/* Members Grid Setup - END */

/* Members Grid Edit Window Setup - BEGIN */
  $groupsMenuArray = array(array('id' => '0', 'text' => TEXT_NONE));
  $QgroupsMenu = smn_db_query("select admin_groups_id, admin_groups_name from " . TABLE_ADMIN_GROUPS);
  while ($groupsMenu = smn_db_fetch_array($QgroupsMenu)) {
      $groupsMenuArray[] = array('id'   => $groupsMenu['admin_groups_id'],
                                 'text' => $groupsMenu['admin_groups_name']);
  }
      
  $membersGridEditWindow = $jQuery->getStandAloneClass('box_window', array(
      'id'          => 'div_members_edit',
      'show_header' => true,
      'show_footer' => true,
      'header_text' => TEXT_INFO_HEADING_NEW,
      'buttons'     => array($commonSaveButton, $commonCancelButton),
      'form'        => '<form id="form_membersEdit" action="' . $jQuery->link(FILENAME_ADMIN, 'action=saveMember') . '" method="post"><input type="hidden" name="hidden_action" id="hidden_action" value="new"><input type="hidden" name="admin_id" id="admin_id" value="">',
      'content'     => '<table cellpadding="3" cellspacing="0" border="0">
                         <tr>
                          <td class="main">' . TEXT_INFO_FIRSTNAME . '</td>
                          <td>' . smn_draw_input_field('admin_firstname', '', 'id="admin_firstname"') . '</td>
                         </tr>
                         <tr>
                          <td class="main">' . TEXT_INFO_LASTNAME . '</td>
                          <td>' . smn_draw_input_field('admin_lastname', '', 'id="admin_lastname"') . '</td>
                         </tr>
                         <tr>
                          <td valign="top" class="main">' . TEXT_INFO_EMAIL . '</td>
                          <td>' . smn_draw_input_field('admin_email_address', '', 'id="admin_email_address"') . '</td>
                         </tr>
                         <tr>
                          <td valign="top" class="main">' . TEXT_INFO_GROUP . '</td>
                          <td>' . smn_draw_pull_down_menu('admin_groups_id', $groupsMenuArray, '0', 'id="admin_groups_id"') . '</td>
                         </tr>
                        </table>'
  ));
/* Members Grid Edit Window Setup - END */

/* Members Grid Delete Window Setup - BEGIN */
  $membersGridDeleteWindow = $jQuery->getStandAloneClass('box_window', array(
      'id'          => 'div_members_delete',
      'show_header' => true,
      'show_footer' => true,
      'header_text' => TEXT_INFO_HEADING_DELETE,
      'buttons'     => array($commonDeleteButton, $commonCancelButton),
      'content'     => '<table cellpadding="3" cellspacing="0" border="0">
                         <tr>
                          <td class="main">Are You Sure You Want To Delete This Admin?<br><br><b id="admin_name"></b></td>
                         </tr>
                        </table>'
  ));
/* Members Grid Delete Window Setup - END */
?>
<script language="Javascript">
 $(document).ready(function (){
     var $membersGrid = $('#<?php echo $membersGrid->getID();?>');

     function editNewWindow(type){
         var selectedRow = false;
         if (type == 'edit'){
             selectedRow = $membersGrid.data('gridObj').getSelectedRows();
         }
         if ((selectedRow && type == 'edit') || (!selectedRow && type == 'new')){
             $membersGrid.data('gridObj').showWindow({
                 title: (type == 'edit' ? 'Edit Member' : 'Insert Member'),
                 selectedRow: selectedRow,
                 appendTo: '#tab-members',
                 selector: '#<?php echo $membersGridEditWindow->getID();?>',
                 onLoad: function (e, windowObj){
                     var $windowObj = $(windowObj);
                     $('#hidden_action', $windowObj).val(type);
                     
                     $('#<?php echo $commonSaveButton->getID();?>', $windowObj).unbind('click').click(function (){
                         $(this.form).ajaxForm({
                             cache: false,
                             dataType: 'json',
                             success: function (data){
                                 if (data.success == true){
                                     if (type == 'edit'){
                                         selectedRow.updateValues(data);
                                     }else{
                                         $membersGrid.data('gridObj').addRow(data);
                                     }
                                     $windowObj.remove();
                                     $membersGrid.trigger('update');
                                     $membersGrid.show();
                                 }else{
                                     $.ajax_unsuccessful_message_box(data);
                                 }
                             }
                         });
                     });
                     
                     $('#<?php echo $commonCancelButton->getID();?>', $windowObj).unbind('click').click(function (){
                         $windowObj.remove();
                         $membersGrid.show();
                       return false;
                     });
                 }
             });
         }
     }     
     
     $('#<?php echo $membersGridInsertButton->getID();?>').unbind('click').click(function (){
         return editNewWindow('new');
     });
     
     $('#<?php echo $membersGridEditButton->getID();?>').unbind('click').click(function (){
         return editNewWindow('edit');
     });
     
     $('#<?php echo $membersGridDeleteButton->getID();?>').unbind('click').click(function (){
         var selectedRow = $membersGrid.data('gridObj').getSelectedRows();
         if (selectedRow){
             $membersGrid.data('gridObj').showWindow({
                 title: 'Delete Member',
                 selectedRow: selectedRow,
                 appendTo: '#tab-members',
                 selector: '#<?php echo $membersGridDeleteWindow->getID();?>',
                 onLoad: function (e, windowObj){
                     var $windowObj = $(windowObj);
                     
                     $('#<?php echo $commonDeleteButton->getID();?>', $windowObj).unbind('click').click(function (){
                         jQuery.ajax({
                             url: '<?php echo $jQuery->link(FILENAME_ADMIN, 'action=deleteMember');?>&admin_id=' + selectedRow.getColValue('admin_id'),
                             dataType: 'json',
                             success: function (data){
                                 if (data.success == true){
                                     $(selectedRow).remove();
                                     $windowObj.remove();
                                     $membersGrid.trigger('update');
                                     $membersGrid.show();
                                 }else{
                                     $.ajax_unsuccessful_message_box(data);
                                 }
                             }
                         });
                       return false;
                     });
                     
                     $('#<?php echo $commonCancelButton->getID();?>', $windowObj).unbind('click').click(function (){
                         $windowObj.remove();
                         $membersGrid.show();
                       return false;
                     });
                 }
             });
         }
       return false;
     });
 });
</script>
<?php
  echo $membersGrid->outputHTML();
  echo $membersGridEditWindow->output();
  echo $membersGridDeleteWindow->output();
?>