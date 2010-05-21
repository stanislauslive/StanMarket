<?php
/*
  Copyright (c) 2002 - 2005 SystemsManager.Net

  SystemsManager Technologies
  oscMall System Version 4
  http://www.systemsmanager.net
  
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
<?php
     echo $tabPanel->output();
?>
