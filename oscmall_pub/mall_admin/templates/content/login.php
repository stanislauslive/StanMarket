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
     var loadingImg;
     $('#loginForm').ajaxForm({
         dataType: 'json',
         cache: false,
         success: function (data){
             if (data.success == false){
                 $.ajax_unsuccessful_message_box(data);
                 loadingImg.remove();
                 $('#<?php echo $submitButton->getID();?>').show();
             }else{
                 loadingImg.remove();
                 window.location = data.redirectUrl;
             }
         },
         error: $.ajax_error_message_box
     });
     
     $('#email_address').focus();
     
     $('#<?php echo $submitButton->getID();?>').click(function (){
         loadingImg = jQuery('<img src="<?php echo DIR_WS_EXT;?>jQuery/common_images/ajax-loader-small.gif">');
         $(this).hide().parent().append(loadingImg);
     });
 });
</script>
<table border="0" width="600" cellspacing="0" cellpadding="0" align="center" style="margin-top:10%;">
 <tr>
  <td><table border="0" width="600" height="440" cellspacing="0" cellpadding="1" align="center" valign="middle">
   <tr bgcolor="#000000">
    <td><table border="0" width="600" height="440" cellspacing="0" cellpadding="0">
     <tr bgcolor="#ffffff" height="50">
      <td align="left" width="100%"><?php echo smn_image(DIR_WS_IMAGES  . 'logo.gif', STORE_NAME, '200', ''); ?></td>
     </tr>
     <tr bgcolor="#ffffff">
      <td align="center" width="100%"><?php echo 'If not a vendor please use our <a href="' . smn_catalog_href_link() . '">' . HEADER_TITLE_ONLINE_CATALOG . '</a><br/>For technical support please go to our <a href="http://forum.systemsmanager.net" target="_blank">' . HEADER_TITLE_SUPPORT_SITE . '</a>'; ?></td>
     </tr>
     <tr bgcolor="#ffffff">
      <td colspan="2" align="center" valign="middle"><table cellpadding="0" cellspacing="0" border="0">
       <tr>
        <td><form id="loginForm" action="<?php echo smn_href_link(FILENAME_LOGIN, 'action=process');?>" method="post">
         <table cellpadding="3" cellspacing="0" border="0">
          <tr>
           <td class="main"><?php echo ENTRY_EMAIL_ADDRESS;?></td>
           <td><input id="email_address" name="email_address" type="text"></td>
          </tr>
          <tr>
           <td class="main"><?php echo ENTRY_PASSWORD;?></td>
           <td><input id="password" name="password" type="password"></td>
          </tr>
          <tr>
           <td colspan="2" align="right"><?php echo $submitButton->output();?></td>
          </tr>
         </table>
        </form></td>
       </tr>
      </table></td>
     </tr>
    </table></td>
   </tr>
  </table></td>
 </tr>
</table>