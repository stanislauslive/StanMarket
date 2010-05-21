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

  $helpTextEditButton = $jQuery->getPluginClass('button', array(
      'id'   => 'helpTextEditButton',
      'text' => 'Edit Selected'
  ));
  
  $customTextButton = $jQuery->getPluginClass('button', array(
      'id'   => 'customTextButton',
      'text' => 'Create Custom'
  ));
  
  $helpTextSaveButton = $jQuery->getPluginClass('button', array(
      'id'   => 'helpTextSaveButton',
      'type' => 'submit',
      'text' => 'Save Help Page'
  ));
  
  $dir = dir(DIR_FS_CATALOG);
  $helpFilesArray = array();
  $ignoredFiles = array('checkout_process.php', 'editor.php', 'editor_complex.php', 'help.php', 'download.php', 'phpinfo.php', 'redirect.php', 'test_ipn.php');
  while(($file = $dir->read()) !== false){
      if ($file != '.' && $file != '..' && strstr($file, '.php') && !in_array($file, $ignoredFiles)){
          if (is_dir(DIR_FS_CATALOG . DIR_WS_MODULES . str_replace('.php', '', $file))){
              $hasTabs = 'True';
          }else{
              $hasTabs = 'False';
          }
          $helpFilesArray[] = $file;
      }
  }
  sort($helpFilesArray);
  reset($helpFilesArray);
  $filesDropArray = array(array(
      'id'   => 'null',
      'text' => 'Please Select A File'
  ));
  for($i=0, $n=sizeof($helpFilesArray); $i<$n; $i++){
      $filesDropArray[] = array(
          'id'   => $helpFilesArray[$i],
          'text' => $helpFilesArray[$i]
      );
  }
  
  $helpTextGrid = $jQuery->getPluginClass('basicgrid', array(
      'id' => 'helpTextGrid',
      'buttons' => $helpTextEditButton,
      'columns' => array(
          array('id' => 'help_file', 'text' => 'Page'),
          array('id' => 'has_tabs', 'text' => 'Has Tabs')
      ),
      'data' => array()
  ));
?>
<script language="Javascript">
 $(document).ready(function (){
     var $tabPanel = $('#helpTextContainer');
     $('ul', $tabPanel).tabs();
     $('#helpTextContainer').hide();
     $('#helpFile').change(function (){
         var tabsRemove = new Array();
         $('.ui-tabs-nav a', $tabPanel).each(function (i, arr){
             var $tabsPanel = $($(this).attr('href'));
             if (typeof tinyMCE != 'undefined'){
                 $('textarea', $tabsPanel).tinyMCE_remove();
             }
             if ($tabsPanel.attr('id') != 'fullPage'){
                 tabsRemove.push(i);
             }
         });
         tabsRemove.reverse();
         jQuery(tabsRemove).each(function (i){
             $('ul', $tabPanel).tabs('remove', tabsRemove[i]);
         });
         $('#fullPage').empty();
         if (this.value != 'null'){
             jQuery.ajax({
                 url: '<?php echo $jQuery->link(basename($_SERVER['PHP_SELF']), 'action=getHelpText');?>&pageName=' + this.value,
                 cache: false,
                 dataType: 'json',
                 success: function (data){
                     if (data.success == true){
                         $('#helpTextContainer').show();
                         $('#fullPage').append('<textarea style="width:100%;height:200px;" id="fullPageHelp" name="fullPageHelp[catalog]">' + data.pageHelp + '</textarea>');
                         if (data.pageTabs.length > 0){
                             jQuery(data.pageTabs).each(function (i, arr){
                                 var $tabPanelHelp = jQuery('<div class="ui-tabs-panel ui-tabs-hide" id="tab-help_' + i + '"></div>');
                                 $tabPanelHelp.append('<textarea style="width:100%;height:200px;" id="tab-' + i + '-content" name="tab[' + arr[0] + ']">' + arr[1] + '</textarea>');
                                 $tabPanel.append($tabPanelHelp);
                                 $('ul', $tabPanel).tabs('add', '#tab-help_' + i, arr[0]);
                             });
                         }
                         $('#pageContainer .ui-tabs-footer').show();
                         $('textarea', $tabPanel).tinyMCE();
                     }else{
                         $.ajax_unsuccessful_message_box(data);
                     }
                 },
                 error: $.ajax_error_message_box
             });
         }else{
             $('#helpTextContainer').hide();
             $('#initialPane-footer').hide();
         }
     });
     
     $('#helpTextSaveButton').click(function (){
         tinyMCE.triggerSave();
     
         $(this.form).ajaxForm({
             cache: false,
             dataType: 'json',
             success: function (data){
                 if (data.success == true){
                     alert('SAVED');
                 }else{
                     $.ajax_unsuccessful_message_box(data);
                 }
             },
             error: $.ajax_error_message_box
         });
     });
     
     $('#<?php echo $customTextButton->getID();?>').click(function (){
         if ($('#customHelp').val() != ''){
             $('#helpFile').selectOptions('null', true);
             var tabsRemove = new Array();
             $('.ui-tabs-nav a', $tabPanel).each(function (i, arr){
                 var $tabsPanel = $($(this).attr('href'));
                 if (typeof tinyMCE != 'undefined'){
                     $('textarea', $tabsPanel).tinyMCE_remove();
                 }
                 if ($tabsPanel.attr('id') != 'fullPage'){
                     tabsRemove.push(i);
                 }
             });
             tabsRemove.reverse();
             jQuery(tabsRemove).each(function (i){
                 $('ul', $tabPanel).tabs('remove', tabsRemove[i]);
             });
             $('#fullPage').empty();
             
             jQuery.ajax({
                 url: '<?php echo $jQuery->link(basename($_SERVER['PHP_SELF']), 'action=checkCustom');?>&string=' + $('#customHelp').val(),
                 cache: false,
                 dataType: 'json',
                 success: function (data){
                     if (data.success == true){
                         $('#helpTextContainer').show();
                         $('#fullPage').append('<textarea style="width:100%;height:200px;" id="customHelpContent" name="customHelpContent[catalog]">' + data.helpData + '</textarea>');
                         $('textarea', $('#fullPage')).tinyMCE();
                         $('#pageContainer .ui-tabs-footer').show();
                     }else{
                         $.ajax_unsuccessful_message_box(data);
                     }
                 },
                 error: $.ajax_error_message_box
             });
         }
       return false;
     });
 });
</script>
<div id="pageContainer">
 <form id="form_helpText" action="<?php echo $jQuery->link(basename($_SERVER['PHP_SELF']), 'action=saveHelpPage');?>" method="post">
  <div>
   Catalog Files: <?php 
     echo smn_draw_pull_down_menu('helpFile', $filesDropArray, '', 'id="helpFile"')/* . '&nbsp;&nbsp;&nbsp;&nbsp;' . 
          'Admin Files: ' . smn_draw_pull_down_menu('adminHelpFile', $adminFilesDropArray, '', 'id="adminHelpFile"')*/;
   ?>&nbsp;&nbsp;&nbsp;Create Custom: <input type="text" value="" name="customHelp" id="customHelp">&nbsp;&nbsp;<?php echo $customTextButton->output();?>
  </div>
  <br>
  <div id="helpTextContainer" class="ui-tabs-hide">
   <ul>
    <li><a class="tabLink" href="#fullPage"><span>Full Page Help</span></a></li>
   </ul>
   <div id="fullPage" class="ui-tabs-hide"></div>
  </div>
  <div id="initialPane-footer" class="ui-tabs-hide ui-tabs-footer" align="right">
   <?php echo $helpTextSaveButton->output();?>
  </div>
 </form>
</div>