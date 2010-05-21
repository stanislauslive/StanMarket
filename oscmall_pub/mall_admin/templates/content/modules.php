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
<script language="Javascript">
 $(document).ready(function (){
<?php
  echo $jQuery->getScriptOutput();
?>
 });
 function addButtonEvents($row, $gridObj){
     $row.click(function (){
         var $gridObj = $($(this).parent().parent()).data('gridObj');
         if ($(this).hasClass($gridObj.config.selectedClass)){
             $('#<?php echo $modulesGridInstallButton->getID();?>', $gridObj.gridObj).show();
             $('#<?php echo $modulesGridUninstallButton->getID();?>', $gridObj.gridObj).show();
             $('#<?php echo $modulesGridEditButton->getID();?>', $gridObj.gridObj).show();
         }
     }).bind('unselect', function (){
         var $gridObj = $($(this).parent().parent()).data('gridObj').gridObj;
         $('#<?php echo $modulesGridInstallButton->getID();?>', $gridObj).show();
         $('#<?php echo $modulesGridUninstallButton->getID();?>', $gridObj).hide();
         $('#<?php echo $modulesGridEditButton->getID();?>', $gridObj).hide();
     });
 }
</script>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
   <tr>
    <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
     <tr>
      <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
     </tr>
    </table></td>
   </tr>
   <tr>
    <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>          
   </tr>
   <tr>
    <td><?php
     echo $tabPanel->output();
    ?></td>
   </tr>
  </table>