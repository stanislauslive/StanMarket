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
            <td rowspan="2" class="pageHeading" align="right"><?php echo smn_image(DIR_WS_IMAGES . 'table_background_login.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
  if (isset($_GET['login']) && ($_GET['login'] == 'fail')) {
    $info_message = TEXT_LOGIN_ERROR;
  }

  if (isset($info_message)) {
?>
      <tr>
        <td class="smallText"><?php echo $info_message; ?></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
  }
?>
      <tr>
      </tr>
	<td class="main"><?php echo TEXT_INTRO; ?></td>
      <tr>
        <td><?php echo smn_draw_form('login', smn_href_link(FILENAME_AFFILIATE, 'action=process', 'NONSSL')); ?><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main" width="50%" valign="top"><b><?php echo HEADING_NEW_AFFILIATE; ?></b></td>
            <td class="main" width="50%" valign="top"><b><?php echo HEADING_RETURNING_AFFILIATE; ?></b></td>
          </tr>
          <tr>
            <td width="50%" height="100%" valign="top"><table border="0" width="100%" height="100%" cellspacing="0" cellpadding="1" class="infoBox">
              <tr>
                <td><table border="0" width="100%" height="100%" cellspacing="0" cellpadding="2" class="infoBoxContents">
                  <tr>
                    <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                  </tr>
                  <tr>
                    <td class="main" valign="top"><?php echo TEXT_NEW_AFFILIATE . '<br><br>' . TEXT_NEW_AFFILIATE_INTRODUCTION; ?></td>
                  </tr>
                  <tr>
                    <td class="main" colspan="2"><?php echo '<a  href="' . smn_href_link(FILENAME_AFFILIATE_TERMS, '', 'NONSSL') . '">' . TEXT_NEW_AFFILIATE_TERMS . '</a>'; ?></td>
                  </tr>
                  <tr>
                    <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
            <td width="50%" height="100%" valign="top"><table border="0" width="100%" height="100%" cellspacing="0" cellpadding="1" class="infoBox">
              <tr>
                <td><table border="0" width="100%" height="100%" cellspacing="0" cellpadding="2" class="infoBoxContents">
                  <tr>
                    <td colspan="2"><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                  </tr>
                  <tr>
                    <td class="main" colspan="2"><?php echo TEXT_RETURNING_AFFILIATE; ?></td>
                  </tr>
                  <tr>
                    <td colspan="2"><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                  </tr>
                  <tr>
                    <td class="main"><b><?php echo TEXT_AFFILIATE_ID; ?></b></td>
                    <td class="main"><?php echo smn_draw_input_field('affiliate_username'); ?></td>
                  </tr>
                  <tr>
                    <td class="main"><b><?php echo TEXT_AFFILIATE_PASSWORD; ?></b></td>
                    <td class="main"><?php echo smn_draw_password_field('affiliate_password'); ?></td>
                  </tr>
                  <tr>
                    <td colspan="2"><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                  </tr>
                  <tr>
                    <td class="main" colspan="2"><?php echo '<a href="' . smn_href_link(FILENAME_AFFILIATE_PASSWORD_FORGOTTEN, '', 'NONSSL') . '">' . TEXT_AFFILIATE_PASSWORD_FORGOTTEN . '</a>'; ?></td>
                  </tr>
                  <tr>
                    <td colspan="2"><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td width="50%" align="right" valign="top"><?php echo '<a href="' . smn_href_link(FILENAME_AFFILIATE_SIGNUP, '', 'NONSSL') . '">' . smn_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a>'; ?></td>
            <td width="50%" align="right" valign="top"><?php echo smn_image_submit('button_login.gif', IMAGE_BUTTON_LOGIN); ?></td>
          </tr>
        </table></form></td>
      </tr>
    </table>
