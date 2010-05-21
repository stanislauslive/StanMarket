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

/* Common Elements For Tabs - BEGIN */
  $commonCancelButton = $jQuery->getPluginClass('button', array(
      'id'   => 'cancel_button',
      'text' => 'Cancel'
  ));
  
  $commonSaveButton = $jQuery->getPluginClass('button', array(
      'id'   => 'save_button',
      'type' => 'submit',
      'text' => 'Save'
  ));
/* Common Elements For Tabs - END */

/* Configuration Grid Setup - BEGIN */
  if ($store_id == 1){
      $filter = ' and (store_id = "' . (int)$store_id . '" or store_id = "0")';
  }else{
      $filter = ' and store_id = "' . (int)$store_id . '"';
  }
  $configuration_query = smn_db_query("select configuration_id, configuration_title, configuration_value, configuration_group_id from " . TABLE_CONFIGURATION . " where configuration_group_id = '" . (int)$gID . "'" . $filter . " order by sort_order");
  $configGridData = array();
  while ($configuration = smn_db_fetch_array($configuration_query)){
      $configGridData[] = array(
          'configuration_id'       => $configuration['configuration_id'], 
          'configuration_group_id' => $configuration['configuration_group_id'], 
          'configuration_title'    => $configuration['configuration_title'], 
          'configuration_value'    => getConfigValue($configuration['configuration_group_id'], $configuration['configuration_id'])
      );
  }
  
  $configGridEditButton = $jQuery->getPluginClass('button', array(
      'id'   => 'editButton',
      'text' => 'Edit Selected'
  ));
  
  $configGridHelpButton = $jQuery->getPluginClass('button', array(
      'id'   => 'helpButton',
      'text' => 'Help'
  ));
  
  $configGrid = $jQuery->getPluginClass('basicgrid', array(
      'id' => 'configGrid',
      'sortName' => 'configuration_title',
      'paging' => true,
      'page_size' => 20,
      'columns' => array(
          array('id' => 'configuration_id',       'text' => 'cID', 'hidden' => true),
          array('id' => 'configuration_group_id', 'text' => 'gID', 'hidden' => true),
          array('id' => 'configuration_title',    'text' => TABLE_HEADING_CONFIGURATION_TITLE),
          array('id' => 'configuration_value',    'text' => TABLE_HEADING_CONFIGURATION_VALUE)
      ),
      'data' => $configGridData,
      'buttons' => array($configGridEditButton, $configGridHelpButton)
  ));
/* Configuration Grid Setup - END */

/* Configuration Grid Delete Window Setup - BEGIN */
  $configEditWindow = $jQuery->getStandAloneClass('box_window', array(
      'id'          => 'div_configuration_edit',
      'form'        => '<form id="configEditForm" action="#" method="post">',
      'show_header' => true,
      'show_footer' => true,
      'header_text' => 'Edit Configuration',
      'buttons'     => array($commonSaveButton, $commonCancelButton)
  ));
/* Configuration Grid Delete Window Setup - END */
  $jQuery->setHelpButton('helpButton');
?>
<script language="Javascript">
 $(document).ready(function (){
<?php
  echo $jQuery->getScriptOutput();
?>     
     var $configGrid = $('#<?php echo $configGrid->getID();?>');
    
     $('#<?php echo $configGridEditButton->getID();?>').unbind('click').click(function (){
         var selectedRow = $configGrid.data('gridObj').getSelectedRows();
         if (selectedRow){
             $configGrid.data('gridObj').showWindow({
                 title: '%configuration_title%',
                 selectedRow: selectedRow,
                 appendTo: '#contentColumnDiv',
                 selector: '#<?php echo $configEditWindow->getID();?>',
                 onLoad: function (e, windowObj){
                     var $windowObj = $(windowObj);
                     jQuery.ajax({
                         cache: false,
                         dataType: 'json',
                         url: '<?php echo smn_href_link(FILENAME_CONFIGURATION, 'action=edit');?>&gID=' + selectedRow.getColValue('configuration_group_id') + '&cID=' + selectedRow.getColValue('configuration_id'),
                         success: function (data){
                             if (data.success == true){
                                 $('.basicGrid_windowContent', $windowObj).html(data.content);
                                 $('#configEditForm', $windowObj).attr('action', data.formAction);
                                 if (data.isUpload == 'true'){
                                     $('#configEditForm', $windowObj).attr('enctype', 'multipart/form-data');
                                 }
                                 
                                 $('#<?php echo $commonSaveButton->getID();?>', $windowObj).unbind('click').click(function (){
                                     $(this.form).ajaxForm({
                                         dataType: 'json',
                                         cache: false,
                                         success: function(data) {
                                             if (data.success == true){
                                                 selectedRow.updateValues(data);
                                                 $windowObj.remove();
                                                 $configGrid.show();
                                             }else{
                                                 $.ajax_unsuccessful_message_box(data);
                                             }
                                         }
                                     });
                                 });
                                 
                                 $('#<?php echo $commonCancelButton->getID();?>', $windowObj).unbind('click').click(function (){
                                     $windowObj.remove();
                                     $configGrid.show();
                                   return false;
                                 });
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
 <table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
   <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
    <tr>
     <td class="pageHeading"><?php echo $cfg_group['configuration_group_title']; ?></td>
    </tr>
   </table></td>
  </tr>
 </table>
<?php
  echo '<div width="100%">' . $configGrid->outputHTML() . '</div>';
  echo $configEditWindow->output();
?>