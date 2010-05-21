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
    <table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
          </tr>
          <tr>
            <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
          <tr>
<?php
  session_start();
  $old_user = $affiliate_id;  // store  to test if they *were* logged in
  $result = session_unregister("affiliate_id");

//session_destroy();

  if (!empty($old_user)) {
    if ($result) { // if they were logged in and are not logged out 
      echo '            <td class="main">' . TEXT_INFORMATION . '</td>';
    } else { // they were logged in and could not be logged out
      echo '            <td class="main">' . TEXT_INFORMATION_ERROR_1 . '</td>';
    } 
  } else { // if they weren't logged in but came to this page somehow
    echo '            <td class="main">' . TEXT_INFORMATION_ERROR_2 . '</td>';
  }
?>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td align="right" class="main"><br><?php echo '<a href="' . smn_href_link(FILENAME_DEFAULT) . '">' . smn_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a>'; ?></td>
      </tr>
    </table>
