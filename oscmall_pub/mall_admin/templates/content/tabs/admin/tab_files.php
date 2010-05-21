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

/* Boxes Grid Setup - END */
  $QinstalledBoxes = smn_db_query('select admin_files_name from ' . TABLE_ADMIN_FILES . ' where admin_files_is_boxes = "1" order by admin_files_name');
  $installedBoxesArray = array();
  while($installedBoxes = smn_db_fetch_array($QinstalledBoxes)) {
      $installedBoxesArray[] = $installedBoxes['admin_files_name'];
  }
  
  $none = 0;
  $dir = dir(DIR_FS_ADMIN . DIR_WS_BOXES);
  $boxesGridData = array();
  while (($boxes_file = $dir->read()) !== false) {
      if (substr($boxes_file, -4) == '.php'){
          if (in_array($boxes_file, $installedBoxesArray)){
              $Qbox = smn_db_query('select * from ' . TABLE_ADMIN_FILES . ' where admin_files_is_boxes = "1" and admin_files_name = "' . $boxes_file . '"');
              $box = smn_db_fetch_array($Qbox);
          }else{
              $box = array(
                  'admin_files_id'       => 'b' . $none, 
                  'admin_files_name'     => $boxes_file, 
                  'admin_files_is_boxes' => null, 
                  'admin_files_to_boxes' => null, 
                  'admin_groups_id'      => null
              );
          }
          $boxesGridData[] = array(
              'admin_files_id'       => $box['admin_files_id'], 
              'admin_files_name'     => $box['admin_files_name'], 
              'admin_files_status'   => ($box['admin_files_id'] == 'b' . $none ? 'False' : 'True'), 
              'admin_files_is_boxes' => $box['admin_files_is_boxes'], 
              'admin_files_to_boxes' => $box['admin_files_to_boxes'], 
              'admin_groups_id'      => $box['admin_groups_id']
          );
      }
      $none++;
  }
  $dir->close();

  $boxesGridStoreFilesButton = $jQuery->getPluginClass('button', array(
      'id'   => 'boxesGridStoreFilesButton',
      'text' => 'Store Files'
  ));
  
  $boxesGridInstallBoxButton = $jQuery->getPluginClass('button', array(
      'theme'  => 'red',
      'id'     => 'boxesGridInstallBoxButton',
      'text'   => 'Install Box',
      'hidden' => true
  ));
  
  $boxesGridUninstallBoxButton = $jQuery->getPluginClass('button', array(
      'theme'  => 'black',
      'id'     => 'boxesGridUninstallBoxButton',
      'text'   => 'Uninstall Box',
      'hidden' => true
  ));
  
  $boxesGrid = $jQuery->getPluginClass('basicgrid', array(
      'id'        => 'boxesGrid',
      'paging'    => true,
      'mode'      => 'local',
      'page_size' => 20,
      'data'      => $boxesGridData,
      'buttons'   => array($boxesGridStoreFilesButton, $boxesGridInstallBoxButton, $boxesGridUninstallBoxButton),
      'columns'   => array(
          array('id' => 'admin_files_id',       'text' => 'Groups ID',   'hidden' => true),
          array('id' => 'admin_files_name',     'text' => 'File Name'),
          array('id' => 'admin_files_status',   'text' => 'Installed'),
          array('id' => 'admin_files_is_boxes', 'text' => 'File Is Box', 'hidden' => true),
          array('id' => 'admin_files_to_boxes', 'text' => 'Box ID',      'hidden' => true),
          array('id' => 'admin_groups_id',      'text' => 'Groups Id',   'hidden' => true)
      )
  ));
/* Boxes Grid Setup - END */

/* Boxes Grid Store Files Window Setup - BEGIN */
  $boxesGridStoreFilesWindowBackButton = $jQuery->getPluginClass('button', array(
      'id'   => 'boxesGridStoreFilesWindowBackButton',
      'text' => 'Back To Boxes'
  ));
  
  $boxesGridStoreFilesWindow = $jQuery->getStandAloneClass('box_window', array(
      'id'          => 'div_store_files',
      'show_header' => true,
      'show_footer' => true,
      'header_text' => TEXT_INFO_HEADING_NEW_FILE,
      'buttons'     => $boxesGridStoreFilesWindowBackButton,
      'content'     => '<table cellpadding="3" cellspacing="0" border="0">
                         <tr>
                          <td class="main">Use Drop Menu To Store Files, Use Checkbox To Remove Files.<br><br><span id="dropBox"></span><br><br><span id="fileList"></span></td>
                         </tr>
                        </table>'
  ));
/* v Window Setup - END */
?>
<script language="Javascript">
  $(document).ready(function (){
      var $boxesGrid = $('#<?php echo $boxesGrid->getID();?>');
      
      $('tbody[id!="loading"] > tr', $boxesGrid).each(function (){
          $(this).click(function (){
              var $gridObj = $($(this).parent().parent()).data('gridObj');
              if ($(this).hasClass($gridObj.config.selectedClass)){
                  var boxStatus = this.getColValue('admin_files_status');
                  if (boxStatus == 'False'){
                      $('#<?php echo $boxesGridInstallBoxButton->getID();?>').show();
                      $('#<?php echo $boxesGridUninstallBoxButton->getID();?>').hide();
                      $('#<?php echo $boxesGridStoreFilesButton->getID();?>').hide();
                  }else{
                      $('#<?php echo $boxesGridInstallBoxButton->getID();?>').hide();
                      $('#<?php echo $boxesGridUninstallBoxButton->getID();?>').show();
                      $('#<?php echo $boxesGridStoreFilesButton->getID();?>').show();
                  }
              }
          }).bind('unselect', function (){
              $('#<?php echo $boxesGridInstallBoxButton->getID();?>').hide();
              $('#<?php echo $boxesGridUninstallBoxButton->getID();?>').hide();
              $('#<?php echo $boxesGridStoreFilesButton->getID();?>').show();
          });
      });
      
      function boxAction(type){
          var selectedRow = $boxesGrid.data('gridObj').getSelectedRows();
          if (selectedRow){
              jQuery.ajax({
                  url: '<?php echo $jQuery->link(FILENAME_ADMIN, 'action=boxAction');?>&actionType=' + type + '&boxID=' + selectedRow.getColValue('admin_files_id') + '&box=' + selectedRow.getColValue('admin_files_name'),
                  cache: false,
                  dataType: 'json',
                  success: function (data){
                      if (data.success == true){
                          selectedRow.updateValues(data);
                          selectedRow.trigger('click');
                          $boxesGrid.trigger('update');
                      }else{
                          $.ajax_unsuccessful_message_box(data);
                      }
                  }
              });
          }
      }
      
      $('#<?php echo $boxesGridInstallBoxButton->getID();?>').unbind('click').click(function (){
          boxAction('install');
        return false;
      });
      
      $('#<?php echo $boxesGridUninstallBoxButton->getID();?>').unbind('click').click(function (){
          boxAction('uninstall');
        return false;
      });
      
      function generateCheckbox(title, value, checked){
          var $checkbox = $('<input type="checkbox">').attr('title', title).attr('alt', title).attr('value', value);
          if (jQuery.browser.msie == true){
              $checkbox.attr('wasChecked', (checked == 'true' ? true : false));
          }else{
              $checkbox.attr('checked', (checked == 'true' ? true : false));
          }
          $checkbox.click(function (){
              var urlVars = '&boxID=' + $(this).attr('boxID') + '&fileName=' + $(this).attr('fileName');
              var actionType = 'none';
              if (this.checked == false){
                  actionType = 'remove';
              }else{
                  actionType = 'store';
                  if ($(this).attr('isTab') == 'true'){
                      urlVars = urlVars + '&masterFileID=' + $(this).attr('masterFileID');
                  }
              }
              jQuery.ajax({
                  url: '<?php echo $jQuery->link(FILENAME_ADMIN, 'action=boxFileAction');?>&actionType=' + actionType + urlVars,
                  cache: false,
                  dataType: 'json',
                  success: function (data){
                      if (data.success == true){
                          if ($checkbox.attr('isTab') == 'false'){
                              $(':checkbox', $checkbox.parent().parent().parent().parent()).each(function (i, arr){
                                  if (i > 0){
                                      $(this).trigger('togglecheck');
                                  }
                              });
                          }
                      }else{
                          $.ajax_unsuccessful_message_box(data);
                      }
                  }
              });
            return false;
          });
        return $checkbox;
      }
      
      $('#<?php echo $boxesGridStoreFilesButton->getID();?>').unbind('click').click(function (){
          var selectedRow = $boxesGrid.data('gridObj').getSelectedRows();
          if (selectedRow){
              $boxesGrid.data('gridObj').showWindow({
                  title: 'Store Admin Files',
                  selectedRow: selectedRow,
                  appendTo: '#tab-files',
                  selector: '#<?php echo $boxesGridStoreFilesWindow->getID();?>',
                  onLoad: function (e, windowObj){
                      var $windowObj = $(windowObj);
                      jQuery.ajax({
                          url: '<?php echo $jQuery->link(FILENAME_ADMIN, 'action=getBoxFiles');?>&boxID=' + selectedRow.getColValue('admin_files_id'),
                          cache: false,
                          dataType: 'json',
                          success: function (data){
                              if (data.success == true){
                                  var $dropBox = jQuery('<select id="boxesMenu"><option value="false" selected="">Please Select A File</option></select>');
                                  jQuery(data.boxData).each(function (i, arr){
                                      $dropBox.addOption(arr[0], arr[1]);
                                  });
                                  $dropBox.selectOptions('false');
                                  $dropBox.change(function (){
                                      if (this.value != 'false'){
                                          jQuery.ajax({
                                              url: '<?php echo $jQuery->link(FILENAME_ADMIN, 'action=boxFileAction');?>&actionType=store&fileName=' + this.value + '&boxID=' + selectedRow.getColValue('admin_files_id'),
                                              cache: false,
                                              dataType: 'json',
                                              success: function (data){
                                                  if (data.success == true){
                                                      var $checkbox = generateCheckbox($dropBox.val(), data.file_id, 'true').attr('isTab', 'false').attr('boxID', selectedRow.getColValue('admin_files_id')).attr('fileName', $dropBox.val());
                                                      var $element = $('<div>').attr('id', $dropBox.val()).append($checkbox).append($checkbox.attr('title'));
                                                      $dropBox.removeOption($dropBox.val());
                                                      $dropBox.selectOptions('false');
                                                      if (data.tabs.length > 0){
                                                          jQuery(data.tabs).each(function (i, arr){
                                                              var $tabCheckbox = generateCheckbox(arr[1], arr[0], 'true');
                                                              $tabCheckbox.attr('boxID', selectedRow.getColValue('admin_files_id')).attr('isTab', 'true').attr('masterFileID', data.file_id).attr('fileName', arr[1]);
                                                              $element.append('<br>&nbsp;&nbsp;&nbsp;').append($tabCheckbox).append('&nbsp;' + $tabCheckbox.attr('title'));
                                                          });
                                                      }
                                                      $('#fileList', $windowObj).append($element);
                                                      $(':checkbox', $element).checkbox({ theme: 'safari' });
                                                  }else{
                                                      $.ajax_unsuccessful_message_box(data);
                                                  }
                                              }
                                          });
                                      }
                                  });
                                  $dropBox.appendTo($('#dropBox', $windowObj));
                                  
                                  jQuery(data.currentFiles).each(function (i, arr){
                                      var $element = $('<div>');
                                      if (typeof arr[1] == 'object'){
                                          var $checkbox = generateCheckbox(arr[1].mainFile, arr[0], 'true').attr('isTab', 'false').attr('boxID', selectedRow.getColValue('admin_files_id')).attr('fileName', arr[1].mainFile);
                                          $element.attr('id', arr[1].mainFile).append($checkbox).append(arr[1].mainFile);
                                          jQuery(arr[1].tabs).each(function (j, arr2){
                                              var $tabCheckbox = generateCheckbox(arr2[1], arr2[0], arr2[2]).attr('boxID', selectedRow.getColValue('admin_files_id')).attr('isTab', 'true').attr('masterFileID', arr[0]).attr('fileName', arr2[1]);
                                              $element.append('<br>&nbsp;&nbsp;&nbsp;').append($tabCheckbox).append('&nbsp;' + arr2[1]);
                                          });
                                      }else{
                                          var $checkbox = generateCheckbox(arr[1], arr[0], 'true').attr('boxID', selectedRow.getColValue('admin_files_id')).attr('isTab', 'false').attr('masterFileID', arr[0]).attr('fileName', arr[1]);
                                          $element.attr('id', arr[1]).append($checkbox).append('&nbsp;' + arr[1]);
                                      }
                                      $('#fileList', $windowObj).append($element);
                                      $(':checkbox', $element).checkbox({ theme: 'safari' });
                                  });
                                  
                                  $('#<?php echo $boxesGridStoreFilesWindowBackButton->getID();?>', $windowObj).click(function (){
                                      $windowObj.remove();
                                      $boxesGrid.show();
                                    return false;
                                  });
                              
                                  if (jQuery.browser.msie == true){
                                      $(':checkbox', $windowObj).each(function (){
                                          $(this).attr('checked', ($(this).attr('wasChecked') == 'true' ? true : false));
                                      });
                                  }
                              }else{
                                  $.ajax_unsuccessful_message_box(data);
                              }
                          }
                      });
                  }
              });
          }
        return false;
      });
  });
</script>
<?php
  echo $boxesGrid->outputHTML();
  echo $boxesGridStoreFilesWindow->output();
?>