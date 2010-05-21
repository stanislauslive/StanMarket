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

/* Site Text Grid Setup - BEGIN */
  $pagesArray = $siteText->getTextPagesArray();
  
  $siteText->loadTextPage('text_editor');
  
  $siteTextGridData = $siteText->siteTextListing(array(
      'response_type' => 'php'
  ));
  
  $siteTextGridEditButton = $jQuery->getPluginClass('button', array(
      'id'   => 'siteTextEditButton',
      'text' => $siteText->getText('image_button_edit')
  ));
  
  $siteTextGridDeleteButton = $jQuery->getPluginClass('button', array(
      'id'   => 'siteTextDeleteButton',
      'text' => $siteText->getText('image_button_delete')
  ));
  
  $siteTextGridInsertButton = $jQuery->getPluginClass('button', array(
      'id'   => 'siteTextInsertButton',
      'text' => $siteText->getText('image_button_new')
  ));
  
  $pageNameDeleteButton = $jQuery->getPluginClass('button', array(
      'id'   => 'pageNameDeleteButton',
      'text' => $siteText->getText('image_button_delete_page')
  ));
  
  $gridColumns = array(
      array('id' => 'text_key',      'text' => $siteText->getText('table_heading_text_key')),
      array('id' => 'page_name',     'text' => $siteText->getText('table_heading_page_name')),
      array('id' => 'date_modified', 'text' => $siteText->getText('table_heading_date_modified'), 'hidden'   => true)
  );
  
  for($i=0, $n=sizeof($languages); $i<$n; $i++){
      $gridColumns[] = array(
          'id'     => 'text_content_' . $languages[$i]['id'],
          'text'   => $siteText->getText('table_heading_page_content') . ($languages[$i]['id'] == $languages_id ? '' : ' [' . $languages[$i]['name'] . ']'),
          'hidden' => ($languages[$i]['id'] == $languages_id ? false : true)
      );
  }

  $siteTextGrid = $jQuery->getPluginClass('basicgrid', array(
      'id'        => 'siteTextGrid',
      'paging'    => true,
      'mode'      => 'local',
      'page_size' => 20,
      'columns'   => $gridColumns,
//      'url'       => $jQuery->link(basename($_SERVER['PHP_SELF']), 'action=siteTextListing');
      'data'      => $siteTextGridData,
      'buttons'   => array($siteTextGridInsertButton, $siteTextGridEditButton, $siteTextGridDeleteButton)
  ));
/* Site Text Grid Setup - END */
  
/* Site Text Grid Edit Window Setup - BEGIN */
  $languageTabs = array();
  $languageTabsContent = array();
  for($i=0, $n=sizeof($languages); $i<$n; $i++){
      $tabID = 'langTabs-site_text_edit-content' . $languages[$i]['id'];
      $languageTabs[] = array(
          'tabID' => $tabID,
          'text'  => $languages[$i]['name']
      );
         
      $languageTabsContent[] = array(
          'tabID'   => $tabID,
          'content' => smn_draw_textarea_field('text_content[' . $languages[$i]['id'] . ']', 'soft', '60', '7', '', 'id="text_content_' . $languages[$i]['id'] . '"')
      );
  }
  
  $siteTextEditWindowLangTabs = $jQuery->getPluginClass('tabs', array(
      'id'          => 'langTabs-site_text_edit',
      'tabs'        => $languageTabs,
      'tabsContent' => $languageTabsContent
  ));
  $siteTextEditWindowLangTabs->removeScriptOutput();
  
  $siteTextEditWindow = $jQuery->getStandAloneClass('box_window', array(
      'id'          => 'div_site_text_edit',
      'show_header' => true,
      'show_footer' => true,
      'header_text' => '&nbsp;',
      'buttons'     => array($commonSaveButton, $commonCancelButton),
      'form'        => '<form id="form_siteTextEdit" action="' . $jQuery->link(basename($_SERVER['PHP_SELF']), 'action=saveSiteText') . '" method="post"><input type="hidden" name="hidden_action" id="hidden_action" value="new">',
      'content'     => '<table cellpadding="3" cellspacing="0" border="0">
                         <tr>
                          <td class="main">' . $siteText->getText('text_info_text_key') . '</td>
                          <td>' . smn_draw_input_field('text_key', '', 'id="text_key"') . '</td>
                         </tr>
                         <tr>
                          <td class="main">' . $siteText->getText('text_info_page_name') . '</td>
                          <td>' . smn_draw_pull_down_menu('page_name', $pagesArray, '', 'id="page_name"') . '</td>
                         </tr>
                         <tr>
                          <td class="main">' . $siteText->getText('text_info_new_page_name') . '</td>
                          <td>' . smn_draw_input_field('new_page_name', '', 'id="new_page_name"') . '</td>
                         </tr>
                         <tr>
                          <td valign="top" class="main" colspan="2">' . $siteTextEditWindowLangTabs->output() . '</td>
                         </tr>
                        </table>'
  ));
/* Site Text Grid Edit Window Setup - END */
  
/* Site Text Grid Delete Window Setup - BEGIN */
  $siteTextDeleteWindow = $jQuery->getStandAloneClass('box_window', array(
      'id'          => 'div_site_text_delete',
      'show_header' => true,
      'show_footer' => true,
      'header_text' => '&nbsp;',
      'buttons'     => array($commonDeleteButton, $commonCancelButton),
      'content'     => '<table cellpadding="3" cellspacing="0" border="0">
                         <tr>
                          <td class="main">' . $siteText->getText('text_info_delete_intro') . '<br><br><b id="text_key"></b></td>
                         </tr>
                        </table>'
  ));
/* Site Text Grid Delete Window Setup - END */
?>
<script language="Javascript">
 $(document).ready(function (){
     var $siteTextGrid = $('#<?php echo $siteTextGrid->getID();?>');
     
     function editNewWindow(type){
         var selectedRow = false;
         if (type == 'edit'){
             selectedRow = $siteTextGrid.data('gridObj').getSelectedRows();
         }
         if ((selectedRow && type == 'edit') || (!selectedRow && type == 'new')){
             $siteTextGrid.data('gridObj').showWindow({
                 title: (type == 'edit' ? '<?php echo $siteText->getText('site_text_window_edit');?>' : '<?php echo $siteText->getText('site_text_window_new');?>'),
                 selectedRow: selectedRow,
                 appendTo: '#tab-site_text',
                 selector: '#<?php echo $siteTextEditWindow->getID();?>',
                 onLoad: function (e, windowObj){
                     var $windowObj = $(windowObj);
                     if (type == 'edit'){
                         $('#text_key_clone', $windowObj).attr('readonly', 'readonly');
                         $('#page_name_clone', $windowObj).attr('disabled', 'disabled');
                         $('#new_page_name_clone', $windowObj).parent().parent().hide();
                     }else{
                         $('#page_name_clone', $windowObj).selectOptions($('#load_page').val(), true);
                     }
                     $('#hidden_action', $windowObj).val(type);
                     
                     $('#<?php echo $commonSaveButton->getID();?>', $windowObj).unbind('click').click(function (){
                         $('#page_name_clone', $windowObj).removeAttr('disabled');
                         $(this.form).ajaxForm({
                             cache: false,
                             dataType: 'json',
                             success: function (data){
                                 if (data.success == true){
                                     if (type == 'edit'){
                                         selectedRow.updateValues(data);
                                     }else{
                                         $siteTextGrid.data('gridObj').addRow(data);
                                     }
                                     $windowObj.remove();
                                     $siteTextGrid.show();
                                     $('#load_page').parent().show();
                                 }else{
                                     $.ajax_unsuccessful_message_box(data);
                                 }
                             }
                         });
                     });
                     
                     $('#<?php echo $commonCancelButton->getID();?>', $windowObj).unbind('click').click(function (){
                         $('textarea', $windowObj).tinyMCE_remove();
                         $windowObj.remove();
                         $('#load_page').parent().show();
                         $siteTextGrid.show();
                       return false;
                     });
                     
                     $('#load_page').parent().hide();
                     $('textarea', $windowObj).tinyMCE();
                     $('ul', $windowObj).tabs();
//                     $('textarea', $windowObj).markItUp(mySettings);
                 }
             });
         }
       return false;
     }
     
     $('#<?php echo $siteTextGridEditButton->getID();?>').unbind('click').click(function (){
         return editNewWindow('edit');
     });
     
     $('#<?php echo $siteTextGridInsertButton->getID();?>').unbind('click').click(function (){
         return editNewWindow('new');
     });
     
     $('#<?php echo $siteTextGridDeleteButton->getID();?>').unbind('click').click(function (){
         var selectedRow = $siteTextGrid.data('gridObj').getSelectedRows();
         if (selectedRow){
             $siteTextGrid.data('gridObj').showWindow({
                 title: '<?php echo $siteText->getText('site_text_window_delete');?>',
                 selectedRow: selectedRow,
                 appendTo: '#tab-site_text',
                 selector: '#<?php echo $siteTextDeleteWindow->getID();?>',
                 onLoad: function (e, windowObj){
                     var $windowObj = $(windowObj);
                     
                     $('#<?php echo $commonDeleteButton->getID();?>', $windowObj).unbind('click').click(function (){
                         jQuery.ajax({
                             url: '<?php echo $jQuery->link(basename($_SERVER['PHP_SELF']), 'action=deleteSiteText');?>&text_key=' + selectedRow.getColValue('text_key') + '&page_name=' + selectedRow.getColValue('page_name'),
                             dataType: 'json',
                             success: function (data){
                                 if (data.success == true){
                                     $(selectedRow).remove();
                                     $windowObj.remove();
                                     $('#load_page').parent().show();
                                     $siteTextGrid.show();
                                 }else{
                                     $.ajax_unsuccessful_message_box(data);
                                 }
                             }
                         });
                       return false;
                     });
                 
                     $('#<?php echo $commonCancelButton->getID();?>', $windowObj).unbind('click').click(function (){
                         $windowObj.remove();
                         $('#load_page').parent().show();
                         $siteTextGrid.show();
                       return false;
                     });
                     
                     $('#load_page').parent().hide();
                 }
             });
         }
       return false;
     });
     
     $('#<?php echo $pageNameDeleteButton->getID();?>').unbind('click').click(function (){
         var pageName = $('#load_page').val();
         $.ajax({
             cache: false,
             url: '<?php echo $jQuery->link(basename($_SERVER['PHP_SELF']), 'action=deleteTextPage');?>&page_name=' + pageName,
             dataType: 'json',
             success: function (data){
                 if (data.success == true){
                     $('#load_page').removeOption(pageName).trigger('change');
                 }else{
                     $.ajax_unsuccessful_message_box(data);
                 }
             }
         });
     });
     
     $('#load_page').unbind('change').change(function (){
         var $grid = $siteTextGrid;
         var $gridClass = $siteTextGrid.data('gridObj');
         $gridClass.showLoading();
         $.ajax({
             url: '<?php echo $jQuery->link(basename($_SERVER['PHP_SELF']), 'action=siteTextListing');?>&pageName=' + this.value,
             dataType: 'json',
             success: function (data){
                 if (data.success == true){
                     $('tbody[id!="loading"]', $grid).empty();
                     jQuery.each(data.arr, function (){
                         $gridClass.addRow(this);
                     });
                     $grid.focus();
                     $grid.trigger('update');
                     $gridClass.pagerObj.onGridContentUpdate();
                     $gridClass.removeLoading();
                 }else{
                     $.ajax_unsuccessful_message_box(data);
                 }
             }
         });
     });
 });
</script>
<?php
  echo '<div>' . $siteText->getText('text_info_select_page') . ' ' . smn_draw_pull_down_menu('load_page', $pagesArray, '', 'id="load_page"') . '&nbsp;&nbsp;' . 
       $pageNameDeleteButton->output() . 
       '<br><br></div>';
  echo $siteTextGrid->outputHTML();
  echo $siteTextEditWindow->output();
  echo $siteTextDeleteWindow->output();
?>