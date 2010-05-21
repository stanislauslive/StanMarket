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

/* Groups Grid Setup - END */
  $Qgroups = smn_db_query('select * from ' . TABLE_ADMIN_GROUPS . ' order by admin_groups_id');
  $groupsGridData = array();
  $add_groups_prepare = '\'0\''; // ONLY FOR NEW GROUPS
  $del_groups_prepare = '\'0\'';
  while ($groups = smn_db_fetch_array($Qgroups)){
      $add_groups_prepare .= ',\'' . $groups['admin_groups_id'] . '\''; // ONLY FOR NEW GROUPS
      $del_groups_prepare .= ',\'' . $groups['admin_groups_id'] . '\'';
//      $QstoreType = smn_db_query('select store_types_name from ' . TABLE_STORES_TYPES . ' where store_types_id = "' . $groups['admin_groups_store_type'] . '"');
//      $storeType = smn_db_fetch_array($QstoreType);
      $groupsGridData[] = array(
          'admin_groups_id'           => $groups['admin_groups_id'], 
          'admin_groups_name'         => $groups['admin_groups_name'], 
          'admin_groups_max_products' => $groups['admin_groups_max_products'], 
          'admin_sales_cost'          => $groups['admin_sales_cost'], 
          'admin_groups_store_type'   => $groups['admin_groups_store_type'], 
          'admin_groups_products_id'  => $groups['admin_groups_products_id']
      );
  }
  
  $groupsGridEditButton = $jQuery->getPluginClass('button', array(
      'id'   => 'groupsGridEditButton',
      'text' => 'Edit Selected'
  ));
  
  $groupsGridDeleteButton = $jQuery->getPluginClass('button', array(
      'id'   => 'groupsGridDeleteButton',
      'text' => 'Delete Selected'
  ));
  
  $groupsGridInsertButton = $jQuery->getPluginClass('button', array(
      'id'   => 'groupsGridInsertButton',
      'text' => 'Insert New'
  ));
  
  $groupsGridPermissionsButton = $jQuery->getPluginClass('button', array(
      'id'   => 'groupsGridPermissionsButton',
      'text' => 'Permissions'
  ));
  
  $groupsGrid = $jQuery->getPluginClass('basicgrid', array(
      'id'        => 'groupsGrid',
      'paging'    => true,
      'mode'      => 'local',
      'page_size' => 20,
      'data'      => $groupsGridData,
      'buttons'   => array($groupsGridInsertButton, $groupsGridEditButton, $groupsGridDeleteButton, $groupsGridPermissionsButton),
      'columns'   => array(
          array('id' => 'admin_groups_id',           'text' => 'Groups ID',                        'hidden'   => true),
          array('id' => 'admin_groups_name',         'text' => TABLE_HEADING_GROUPS_NAME),
          array('id' => 'admin_groups_max_products', 'text' => TABLE_HEADING_GROUPS_MAX_PRODUCTS),
          array('id' => 'admin_sales_cost',          'text' => 'Cost',                             'hidden'   => true),
          array('id' => 'admin_groups_store_type',   'text' => 'Store Type',                       'hidden'   => true),
          array('id' => 'admin_groups_products_id',  'text' => 'Products ID',                      'hidden'   => true)
      )
  ));
/* Groups Grid Setup - END */

/* Groups Grid Edit Window Setup - BEGIN */
  $groupsGridEditWindow = $jQuery->getStandAloneClass('box_window', array(
      'id'          => 'div_groups_edit',
      'show_header' => true,
      'show_footer' => true,
      'header_text' => TEXT_INFO_HEADING_GROUPS,
      'buttons'     => array($commonSaveButton, $commonCancelButton),
      'form'        => '<form id="form_membersEdit" action="' . $jQuery->link(FILENAME_ADMIN, 'action=saveGroup') . '" method="post"><input type="hidden" name="hidden_action" id="hidden_action" value="new"><input type="hidden" name="admin_groups_id" id="admin_groups_id" value=""><input type="hidden" name="set_groups_id" id="set_groups_id" value="">',
      'content'     => '<table cellpadding="3" cellspacing="0" border="0">
                         <tr>
                          <td colspan="2" class="main">' . TEXT_INFO_GROUPS_NAME . '</td>
                         </tr>
                         <tr>
                          <td class="main">' . TEXT_INFO_EDIT_GROUP_NAME . '</td>
                          <td>' . smn_draw_input_field('admin_groups_name', '', 'id="admin_groups_name"') . '</td>
                         </tr>
                         <tr>
                          <td class="main">' . TEXT_INFO_EDIT_GROUP_STORE_TYPE . '</td>
                          <td>' . smn_draw_pull_down_menu('admin_groups_store_types', smn_get_store_types(), '', 'id="admin_groups_store_type"') . '</td>
                         </tr>
                         <tr>
                          <td valign="top" class="main">' . TEXT_INFO_EDIT_GROUP_COST . '</td>
                          <td>' . smn_draw_input_field('admin_groups_cost', '', 'id="admin_groups_cost"') . '</td>
                         </tr>
                         <tr>
                          <td valign="top" class="main">' . TEXT_INFO_EDIT_GROUP_MAX_PRODUCTS . '</td>
                          <td>' . smn_draw_input_field('admin_groups_max_products', '', 'id="admin_groups_max_products"') . '</td>
                         </tr>
                         <tr>
                          <td valign="top" class="main">' . TEXT_INFO_EDIT_SALES_COST . '</td>
                          <td>' . smn_draw_input_field('admin_sales_cost', '', 'id="admin_sales_cost"') . '</td>
                         </tr>
                        </table>'
  ));
/* Groups Grid Edit Window Setup - END */

/* Groups Grid Delete Window Setup - BEGIN */
  $groupsGridDeleteWindow = $jQuery->getStandAloneClass('box_window', array(
      'id'          => 'div_groups_delete',
      'show_header' => true,
      'show_footer' => true,
      'header_text' => TEXT_INFO_HEADING_DELETE_GROUPS,
      'buttons'     => array($commonDeleteButton, $commonCancelButton),
      'content'     => '<table cellpadding="3" cellspacing="0" border="0">
                         <tr>
                          <td class="main">Are You Sure You Want To Delete This Admin Group?<br><br><b id="admin_groups_name"></b></td>
                         </tr>
                        </table>'
  ));
/* Groups Grid Delete Window Setup - END */

/* Groups Grid Permissions Window Setup - BEGIN */
  $checkBoxes = '<ul style="margin:0px;padding:0px;font-weight: bold;list-style:none;display:none;">';
  $groupID = $_GET['gID'];
  $Qboxes = smn_db_query("select admin_files_id as id, admin_files_name as name, admin_groups_id as group_id from " . TABLE_ADMIN_FILES . " where admin_files_is_boxes = '1' and admin_files_is_tab = '0' order by admin_files_name");
  while($boxes = smn_db_fetch_array($Qboxes)) {
        $checkBoxes .= '<li style="padding-bottom:5px;">' . 
                       smn_draw_checkbox_field('groups_to_boxes[]', $boxes['id'], false, '', 'id="boxes_' . $boxes['id'] . '"') . 
                       ucwords(substr_replace($boxes['name'], '', -4));
                       
        $Qfiles = smn_db_query("select admin_files_id as id, admin_files_name as name, admin_groups_id as group_id from " . TABLE_ADMIN_FILES . " where admin_files_is_boxes = '0' and admin_files_is_tab = '0' and admin_files_to_boxes = '" . $boxes['id'] . "' order by admin_files_name");
        $checkBoxes .= '<ul style="margin:0px;padding:0px;margin-left:18px;list-style:none;">';
        while($files = smn_db_fetch_array($Qfiles)) {
            $checkBoxes .= '<li>' . 
                           smn_draw_checkbox_field('groups_to_boxes[]', $files['id'], false, '', 'id="files_' . $files['id'] . '"') . 
                           ucwords(substr_replace($files['name'], '', -4));
                      
            $Qtabs = smn_db_query("select admin_files_id as id, admin_files_name as name, admin_groups_id as group_id from " . TABLE_ADMIN_FILES . " where admin_files_is_boxes = '0' and admin_files_is_tab = '1' and admin_tabs_to_files = '" . $files['id'] . "' order by admin_files_name");
            $checkBoxes .= '<ul style="margin:0px;padding:0px;margin-left:18px;list-style:none;">';
            while($tabs = smn_db_fetch_array($Qtabs)){
                $checkBoxes .= '<li>' . 
                               smn_draw_checkbox_field('groups_to_boxes[]', $tabs['id'], false, '', 'id="tabs_' . $tabs['id'] . '"') .
                               ucwords(substr_replace($tabs['name'], '', -4)) . 
                               '</li>';
            }
            $checkBoxes .= '</ul>';
            $checkBoxes .= '</li>';
        }
        $checkBoxes .= '</ul>';
        $checkBoxes .= '</li>';
  }
  $checkBoxes .= '</ul>';

  $groupsGridPermissionsWindow = $jQuery->getStandAloneClass('box_window', array(
      'id'          => 'div_groups_permissions',
      'show_header' => true,
      'show_footer' => true,
      'header_text' => TABLE_HEADING_GROUPS_DEFINE,
      'buttons'     => array($commonSaveButton, $commonCancelButton),
      'content'     => '<table cellpadding="3" cellspacing="0" border="0">
                         <tr>
                          <td class="main">Select files below that this group has access to.<br><br></td>
                         </tr>
                         <tr>
                          <td class="main" id="checkBoxes"><div id="loading">Loading Permissions...</div>' . $checkBoxes . '</td>
                         </tr>
                        </table>'
  ));
/* Groups Grid Permissions Window Setup - END */
?>
<script language="Javascript">
 $(document).ready(function (){
     var $groupsGrid = $('#<?php echo $groupsGrid->getID();?>');
      
     function editNewWindow(type){
         var selectedRow = false;
         if (type == 'edit'){
             selectedRow = $groupsGrid.data('gridObj').getSelectedRows();
         }
         if ((selectedRow && type == 'edit') || (!selectedRow && type == 'new')){
             $groupsGrid.data('gridObj').showWindow({
                 title: (type == 'edit' ? 'Edit Group' : 'Insert Group'),
                 selectedRow: selectedRow,
                 appendTo: '#tab-groups',
                 selector: '#<?php echo $groupsGridEditWindow->getID();?>',
                 onLoad: function (e, windowObj){
                     var $windowObj = $(windowObj);
                     
                     $('#hidden_action', $windowObj).val(type);
                     if (type == 'edit'){
                         $('#admin_groups_cost_clone', $windowObj).parent().parent().remove();
                     }
                     
                     $('#<?php echo $commonSaveButton->getID();?>', $windowObj).unbind('click').click(function (){
                         $(this.form).ajaxForm({
                             cache: false,
                             dataType: 'json',
                             success: function (data){
                                 if (data.success == true){
                                     if (type == 'edit'){
                                         selectedRow.updateValues(data);
                                     }else{
                                         $groupsGrid.data('gridObj').addRow(data);
                                     }
                                     $windowObj.remove();
                                     $groupsGrid.trigger('update');
                                     $groupsGrid.show();
                                 }else{
                                     $.ajax_unsuccessful_message_box(data);
                                 }
                             }
                         });
                     });
                     
                     $('#<?php echo $commonCancelButton->getID();?>', $windowObj).unbind('click').click(function (){
                         $windowObj.remove();
                         $groupsGrid.show();
                       return false;
                     });
                 }
             });
         }
     }
     
     $('#<?php echo $groupsGridInsertButton->getID();?>').unbind('click').click(function (){
         return editNewWindow('new');
     });

     $('#<?php echo $groupsGridEditButton->getID();?>').unbind('click').click(function (){
         return editNewWindow('edit');
      });
      
     $('#<?php echo $groupsGridDeleteButton->getID();?>').unbind('click').click(function (){
         var selectedRow = $groupsGrid.data('gridObj').getSelectedRows();
         if (selectedRow){
             $groupsGrid.data('gridObj').showWindow({
                 title: 'Delete Group',
                 selectedRow: selectedRow,
                 appendTo: '#tab-groups',
                 selector: '#<?php echo $groupsGridDeleteWindow->getID();?>',
                 onLoad: function (e, windowObj){
                     var $windowObj = $(windowObj);
                    
                     $('#<?php echo $commonDeleteButton->getID();?>', $windowObj).unbind('click').click(function (){
                         jQuery.ajax({
                             url: '<?php echo smn_href_link(FILENAME_ADMIN, 'action=deleteGroup');?>&admin_groups_id=' + selectedRow.getColValue('admin_groups_id'),
                             dataType: 'json',
                             cache: false,
                             success: function (data){
                                 if (data.success == true){
                                     $(selectedRow).remove();
                                     $windowObj.remove();
                                     $groupsGrid.trigger('update');
                                     $groupsGrid.show();
                                 }else{
                                     $.ajax_unsuccessful_message_box(data);
                                 }
                             }
                         });
                     });
                    
                     $('#<?php echo $commonCancelButton->getID();?>', $windowObj).unbind('click').click(function (){
                         $windowObj.remove();
                         $groupsGrid.show();
                       return false;
                     });
                 }
             });
         }
     });
      
     $('#<?php echo $groupsGridPermissionsButton->getID();?>').unbind('click').click(function (){
         var selectedRow = $groupsGrid.data('gridObj').getSelectedRows();
         if (selectedRow){
             $groupsGrid.data('gridObj').showWindow({
                 title: 'Group Permissions',
                 selectedRow: selectedRow,
                 appendTo: '#tab-groups',
                 selector: '#<?php echo $groupsGridPermissionsWindow->getID();?>',
                 onLoad: function (e, windowObj){
                     var $windowObj = $(windowObj);
                     
                     jQuery.ajax({
                         cache: false,
                         dataType: 'json',
                         url: '<?php echo $jQuery->link(FILENAME_ADMIN, 'action=getPermissions');?>&gID=' + selectedRow.getColValue('admin_groups_id'),
                         success: function (data){
                             if (data.success == true){
                                 var selectedBoxes = data.selectedBoxes.split(',');
                                 var selectedFiles = data.selectedFiles.split(',');
                                 var selectedTabs = data.selectedTabs.split(',');
                                 $(':checkbox', $windowObj).each(function (){
                                     var cbID = $(this).attr('id');
                                     var cbVal = $(this).val();
                                     var checkArray = new Array(0);
                                     if (cbID == 'boxes_' + cbVal){
                                         checkArray = selectedBoxes;
                                     }else if (cbID == 'files_' + cbVal){
                                         checkArray = selectedFiles;
                                     }else if (cbID == 'tabs_' + cbVal){
                                         checkArray = selectedTabs;
                                     }

                                     if ($.inArray(cbVal, checkArray) > -1){
                                         $(this).trigger('togglecheck');
                                         this.checked = true;
                                     }
                                     
                                     $(this).click(function (){
                                         var fileIDCheck = 'files_' + $(this).val();
                                         var tabIDCheck = 'tabs_' + $(this).val();
                                         $(':checkbox', $windowObj).each(function (){
                                             if (this.id == fileIDCheck || this.id == tabIDCheck){
                                                 $(this).trigger('togglecheck');
                                                // $(this).trigger('click');
                                             }
                                         });
                                     });
                                     $(this).checkbox({theme: 'safari'});
                                 });
                                 $('#checkBoxes > div[id="loading_clone"]', $windowObj).hide();
                                 $('#checkBoxes > ul', $windowObj).show();
                             }else{
                                 $.ajax_unsuccessful_message_box(data);
                             }
                         }
                     });
                     
                     $('#<?php echo $commonCancelButton->getID();?>', $windowObj).unbind('click').click(function (){
                         $windowObj.remove();
                         $groupsGrid.show();
                       return false;
                     });
                 }
             });
         }
     });
  });
</script>
<?php
  echo $groupsGrid->outputGrid();
  echo $groupsGridEditWindow->output();
  echo $groupsGridDeleteWindow->output();
  echo $groupsGridPermissionsWindow->output();
?>