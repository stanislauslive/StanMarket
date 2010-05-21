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

  $descriptionEditButton = $jQuery->getPluginClass('button', array(
      'id'   => 'descriptionEditButton',
      'text' => 'Edit Description'
  ));
  
/* Description Edit Window Setup - BEGIN */
  $languageTabs = array();
  $languageTabsContent = array();
  for($i=0, $n=sizeof($languages); $i<$n; $i++){
      $tabID = 'langTabs-description_edit-content' . $languages[$i]['id'];
      $languageTabs[] = array(
          'tabID' => $tabID,
          'text'  => $languages[$i]['name']
      );
         
      $languageTabsContent[] = array(
          'tabID'   => $tabID,
          'content' => '
              <table cellpadding="3" cellspacing="0" border="0">
               <tr>
                <td>' . smn_draw_textarea_field('store_description[' . $languages[$i]['id'] . ']', 'soft', '100', '30', '', 'id="store_description_' . $languages[$i]['id'] . '"') . '</td>
               </tr>
              </table>'
      );
  }
  
  $descriptionEditWindowLangTabs = $jQuery->getPluginClass('tabs', array(
      'id'          => 'langTabs-description_edit',
      'tabs'        => $languageTabs,
      'tabsContent' => $languageTabsContent
  ));
  $descriptionEditWindowLangTabs->removeScriptOutput();

  $descriptionEditWindow = $jQuery->getStandAloneClass('box_window', array(
      'id'          => 'div_description_edit',
      'show_header' => true,
      'show_footer' => true,
      'header_text' => 'Edit Store Description',
      'form'        => '<form id="form_description_edit" action="' . $jQuery->link(basename($_SERVER['PHP_SELF']), 'action=saveDescription') . '" method="post">',
      'buttons'     => array($commonSaveButton, $commonCancelButton),
      'content'     => $descriptionEditWindowLangTabs->output()
  ));
/* Description Edit Window Setup - END */
?>
 <script language="Javascript">
     $(document).ready(function (){
         $('#<?php echo $descriptionEditButton->getID();?>').unbind('click').click(function (){
             var $mainTable = $('#descriptionTable');
             var newWidth = $('#tab-description').width();
             var newHeight = $('#tab-description').height();
             
             var $editWindow = $('#<?php echo $descriptionEditWindow->getID();?>').clone().each(function (){
                 var $windowObj = $(this);
                 $('textarea', $windowObj).val($('#descriptionContainer').html());
             
                 $('#<?php echo $commonCancelButton->getID();?>', $windowObj).unbind('click').click(function (){
                     $('textarea', $windowObj).tinyMCE_remove();
                     $windowObj.remove();
                     $mainTable.show();
                 });
             
                 $('#<?php echo $commonSaveButton->getID();?>', $windowObj).unbind('click').click(function (){
                     $(this.form).ajaxForm({
                         cache: false,
                         dataType: 'json',
                         success: function (data){
                             if (data.success == true){
                                 $('#descriptionContainer').html(data.description);
                                 $('textarea', $windowObj).tinyMCE_remove();
                                 $windowObj.remove();
                                 $mainTable.show();
                             }else{
                                 $.ajax_unsuccessful_message_box(data);
                             }
                         }
                     });
                 });

                 $('div[id!=""], li a, textarea, input[type="text"]', $windowObj).each(function (){
                     if (this.className == 'tabLink'){
                         $(this).attr('href', $(this).attr('href') + '_clone');
                     }else{
                         $(this).attr('id', $(this).attr('id') + '_clone');
                     }
                 });

                 $mainTable.hide();
                 $windowObj.appendTo('#tab-description').show();
                 $('textarea', $windowObj).tinyMCE();
                 $('ul', $windowObj).tabs();
             });
         });
     });
 </script>
 <table cellpadding="0" cellspacing="0" border="0" id="descriptionTable">
  <tr>
   <td id="descriptionContainer"><?php echo str_replace(array("\n", "\r"), '', stripslashes($store->get_store_description()));?></td>
  </tr>
  <tr>
   <td align="center"><br><?php echo $descriptionEditButton->output();?></td>
  </tr>
 </table>
 <?php
  echo $descriptionEditWindow->output();
 ?>