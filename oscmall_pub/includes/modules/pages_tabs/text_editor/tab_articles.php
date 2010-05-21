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

/* Articles Grid Setup - BEGIN */
  $articlesGridData = $siteText->articleListing(array(
      'response_type' => 'php'
  ));
 
  $articlesGridEditButton = $jQuery->getPluginClass('button', array(
      'id'   => 'articlesEditButton',
      'text' => 'Edit Selected'
  ));
  
  $articlesGridDeleteButton = $jQuery->getPluginClass('button', array(
      'id'   => 'articlesDeleteButton',
      'text' => 'Delete Selected'
  ));
  
  $articlesGridInsertButton = $jQuery->getPluginClass('button', array(
      'id'   => 'articlesInsertButton',
      'text' => 'Insert New'
  ));
  
  $gridColumns = array(
      array('id' => 'page_id',       'text' => 'Page ID',       'hidden' => true),
      array('id' => 'page_name',     'text' => 'Page name'),
      array('id' => 'page_type',     'text' => 'Page Type',     'hidden' => true),
      array('id' => 'date_modified', 'text' => 'Date Modified', 'hidden' => true),
  );

  for($i=0, $n=sizeof($languages); $i<$n; $i++){
      $langID = $languages[$i]['id'];
      array_push($gridColumns, array(
          'id'     => 'page_title_' . $langID,
          'text'   => 'Title of Page Body' . ($langID != $languages_id ? ' [' . $languages[$i]['name'] . ']' : ''),
          'hidden' => ($langID == $languages_id ? false : true)
      ), array(
          'id'     => 'page_navbar_' . $langID,
          'text'   => 'Page Navbar' . ($langID != $languages_id ? ' [' . $languages[$i]['name'] . ']' : ''),
          'hidden' => true
      ), array(
          'id'     => 'page_header_' . $langID,
          'text'   => 'Page Header' . ($langID != $languages_id ? ' [' . $languages[$i]['name'] . ']' : ''),
          'hidden' => true
      ), array(
          'id'     => 'page_heading_' . $langID,
          'text'   => 'Page Heading' . ($langID != $languages_id ? ' [' . $languages[$i]['name'] . ']' : ''),
          'hidden' => true
      ), array(
          'id'     => 'text_content_' . $langID,
          'text'   => 'Page Content' . ($langID != $languages_id ? ' [' . $languages[$i]['name'] . ']' : ''),
          'hidden' => true
      ));
  }  
  
  $articlesGrid = $jQuery->getPluginClass('basicgrid', array(
      'id'      => 'articlesGrid',
      'columns' => $gridColumns,
      'data'    => $articlesGridData,
      'buttons' => array($articlesGridInsertButton, $articlesGridEditButton, $articlesGridDeleteButton)
  ));
/* Articles Grid Setup - END */

/* Articles Grid Edit Window Setup - BEGIN */
  $languageTabs = array();
  $languageTabsContent = array();
  for($i=0, $n=sizeof($languages); $i<$n; $i++){
      $lID = $languages[$i]['id'];
      $tabID = 'langTabs-articles_edit-content' . $lID;
      $languageTabs[] = array(
          'tabID' => $tabID,
          'text'  => $languages[$i]['name']
      );
         
      $languageTabsContent[] = array(
          'tabID'   => $tabID,
          'content' => '
              <table cellpadding="3" cellspacing="0" border="0">
               <tr>
                <td valign="top"><table cellpadding="3" cellspacing="0" border="0">
                 <tr>
                  <td class="main"><b>Title of Article:</b></td>
                 </tr>
                 <tr>
                  <td>' . smn_draw_input_field('page_title[' . $lID . ']', '', 'id="page_title_' . $lID . '"') . '</td>
                 </tr>
                 <tr>
                  <td class="main"><b>Navigation Bar Text:</b></td>
                 </tr>
                 <tr>
                  <td>' . smn_draw_input_field('page_navbar[' . $lID . ']', '', 'id="page_navbar_' . $lID . '"') . '</td>
                 </tr>
                 <tr>
                  <td class="main"><b>Page Body Title:</b></td>
                 </tr>
                 <tr>
                  <td>' . smn_draw_input_field('page_header[' . $lID . ']', '', 'id="page_header_' . $lID . '"') . '</td>
                 </tr>
                 <tr>
                  <td class="main"><b>Title of New Page:</b></td>
                 </tr>
                 <tr>
                  <td>' . smn_draw_input_field('page_heading[' . $lID . ']', '', 'id="page_heading_' . $lID . '"') . '</td>
                 </tr>
                </table></td>
                <td valign="top"><table cellpadding="3" cellspacing="0" border="0">
                 <tr>
                  <td valign="top" class="main"><b>Page Contents:</b></td>
                 </tr>
                 <tr>
                  <td>' . smn_draw_textarea_field('text_content[' . $lID . ']', 'soft', '100', '30', '', 'id="text_content_' . $lID . '"') . '</td>
                 </tr>
                </table></td>
               </tr>
              </table>'
      );
  }
  
  $articlesEditWindowLangTabs = $jQuery->getPluginClass('tabs', array(
      'id'          => 'langTabs-articles_edit',
      'tabs'        => $languageTabs,
      'tabsContent' => $languageTabsContent
  ));
  $articlesEditWindowLangTabs->removeScriptOutput();

  $articlesEditWindow = $jQuery->getStandAloneClass('box_window', array(
      'id'          => 'div_articles_edit',
      'show_header' => true,
      'show_footer' => true,
      'header_text' => 'Edit Article',
      'buttons'     => array($commonSaveButton, $commonCancelButton),
      'form'        => '<form id="form_articlesEdit" action="' . $jQuery->link(basename($_SERVER['PHP_SELF']), 'action=saveArticle') . '" method="post"><input type="hidden" name="hidden_action" id="hidden_action" value="new"><input type="hidden" name="page_id" id="page_id" value="">',
      'content'     => '<table cellpadding="3" cellspacing="0" border="0">
                         <tr>
                          <td class="main"><b>Create New Page Category:</b>&nbsp;' . smn_draw_input_field('page_name', '', 'id="page_name"') . '</td>
                         </tr>
                         <tr>
                          <td>' . $articlesEditWindowLangTabs->output() . '</td>
                         </tr>
                        </table>'
  ));
/* Articles Grid Edit Window Setup - END */

/* Articles Grid Delete Window Setup - BEGIN */
  $articlesDeleteWindow = $jQuery->getStandAloneClass('box_window', array(
      'id'          => 'div_articles_delete',
      'show_header' => true,
      'show_footer' => true,
      'header_text' => 'Delete Article',
      'buttons'     => array($commonDeleteButton, $commonCancelButton),
      'content'     => '<table cellpadding="3" cellspacing="0" border="0">
                         <tr>
                          <td class="main">Are You Sure You Want To Delete This Article?<br><br><b id="page_name"></b></td>
                         </tr>
                        </table>'
  ));
/* Articles Grid Delete Window Setup - END */

/*
                   xtype: 'textfield',
                   name: 'use_current_catagory',
                   id: 'use_current_catagory_input_'+action,
                   readOnly: (action == 'edit'),
                   width: '100%',
                   fieldLabel: 'Use Current Categories',
                   value: (action == 'edit' ? rowData.use_current_catagory : '')
  */
?>
<script language="Javascript">
 $(document).ready(function (){
     var $articlesGrid = $('#<?php echo $articlesGrid->getID();?>');
     
     function editNewWindow(type){
         var selectedRow = false;
         if (type == 'edit'){
             selectedRow = $articlesGrid.data('gridObj').getSelectedRows();
         }
         if ((selectedRow && type == 'edit') || (!selectedRow && type == 'new')){
             $articlesGrid.data('gridObj').showWindow({
                 selectedRow: selectedRow,
                 selector: '#<?php echo $articlesEditWindow->getID();?>',
                 appendTo: '#tab-articles',
                 title: (type == 'edit' ? 'Edit Article ( %page_name% )' : 'New Article'),
                 onLoad: function (e, windowObj){
                     var $windowObj = $(windowObj);
                     if (type == 'new'){
                         $('#page_name_clone', $windowObj).unbind('blur').blur(function (){
                             var newValue = this.value;
                             for(var i=0; i<newValue.length; i++){
                                 if (newValue.charCodeAt(i) == 32){
                                     newValue = newValue.replace(' ', '_');
                                 }
                             }
                             this.value = newValue;
                           return true;
                         });
                     }else{
                         $('#page_name_clone', $windowObj).attr('disabled', 'disabled');
                     }
                     
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
                                         $articlesGrid.data('gridObj').addRow(data);
                                     }
                                     $windowObj.remove();
                                     $articlesGrid.trigger('update');
                                     $articlesGrid.show();
                                 }else{
                                     $.ajax_unsuccessful_message_box(data);
                                 }
                             }
                         });
                     });
                     
                     $('#<?php echo $commonCancelButton->getID();?>', $windowObj).unbind('click').click(function (){
                         $('textarea', $windowObj).tinyMCE_remove();
                         $windowObj.remove();
                         $articlesGrid.show();
                       return false;
                     });
                     
                     $('#hidden_action', $windowObj).val(type);
                     $('textarea', $windowObj).tinyMCE();
                     $('ul', $windowObj).tabs();
                 }
             });
         }
       return false;
     }
     
     $('#<?php echo $articlesGridEditButton->getID();?>').unbind('click').click(function (){
         return editNewWindow('edit');
     });
     
     $('#<?php echo $articlesGridInsertButton->getID();?>').unbind('click').click(function (){
         return editNewWindow('new');
     });
     
     $('#<?php echo $articlesGridDeleteButton->getID();?>').unbind('click').click(function (){
         var selectedRow = $articlesGrid.data('gridObj').getSelectedRows();
         if (selectedRow){
             $articlesGrid.data('gridObj').showWindow({
                 selectedRow: selectedRow,
                 appendTo: '#tab-articles',
                 selector: '#<?php echo $articlesDeleteWindow->getID();?>',
                 onLoad: function (e, windowObj){
                     var $windowObj = $(windowObj);
                     $('#<?php echo $commonDeleteButton->getID();?>', $windowObj).unbind('click').click(function (){
                         jQuery.ajax({
                             cache: false,
                             url: '<?php echo $jQuery->link(basename($_SERVER['PHP_SELF']), 'action=deleteArticle');?>&page_id=' + selectedRow.getColValue('page_id') + '&page_name=' + selectedRow.getColValue('page_name'),
                             dataType: 'json',
                             success: function (data){
                                 if (data.success == true){
                                     $(selectedRow).remove();
                                     $windowObj.remove();
                                     $articlesGrid.trigger('update');
                                     $articlesGrid.show();
                                 }else{
                                     $.ajax_unsuccessful_message_box(data);
                                 }
                             }
                         });
                       return false;
                     });
                     
                     $('#<?php echo $commonCancelButton->getID();?>', $windowObj).unbind('click').click(function (){
                         $windowObj.remove();
                         $articlesGrid.show();
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
  echo $articlesGrid->outputHTML();
  echo $articlesEditWindow->output();
  echo $articlesDeleteWindow->output();
?>