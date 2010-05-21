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
      <?php echo smn_draw_form('login', smn_href_link(FILENAME_LOGIN, 'ID=' . $store_id . '&action=process', 'NONSSL')); ?>
      <table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo smn_image(DIR_WS_IMAGES . 'table_background_login.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>

<?php
  if ($messageStack->size('login') > 0) {
?>
      <tr>
        <td><?php echo $messageStack->output('login'); ?></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
  }

  if ($cart->count_contents() > 0) {
?>
      <tr>
        <td class="smallText"><?php echo TEXT_VISITORS_CART; ?></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
  }
?>
        <tr>
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
                <tr>
                <td><table class="loginBoxContents" border="0" width="100%" height="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                  </tr>
                  <tr>
                    <td class="main"><b><?php echo ENTRY_EMAIL_ADDRESS; ?></b></td>
                    <td class="main"><?php echo smn_draw_input_field('email_address'); ?></td>
                  </tr>
                  <tr>
                    <td class="main"><b><?php echo ENTRY_PASSWORD; ?></b></td>
                    <td class="main"><?php echo smn_draw_password_field('password'); ?></td>
                  </tr>
                  <tr>
                    <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                  </tr>
                  <tr>
                    <td class="smallText" colspan="2"><?php echo '<a href="' . smn_href_link(FILENAME_PASSWORD_FORGOTTEN, '', 'NONSSL') . '">' . TEXT_PASSWORD_FORGOTTEN . '</a>'; ?></td>
                  </tr>
                  <tr>
                    <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                  </tr>
                  <tr>
                    <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
                      <tr>
                        <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                        <td align="right"><?php echo smn_image_submit('button_login.gif', IMAGE_BUTTON_LOGIN); ?></td>
                        <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                      </tr>
                    </table></td>
                  </tr>
                </table></td>
            </tr>
        </table></td>
    </tr>
            
<?php
  if($_GET['account'] == 'new_customer'){
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <tr>
            <td class="main" width="50%" valign="top"><b><?php echo HEADING_NEW_CUSTOMER; ?></b></td>
          </tr>
              <tr>
                <td><table class="loginBoxContents" border="0" width="100%" height="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                  </tr>
                  <tr>
                    <td class="main" valign="top"><?php echo TEXT_NEW_CUSTOMER . '<br><br>' . TEXT_NEW_CUSTOMER_INTRODUCTION; ?></td>
                  </tr>
                  <tr>
                    <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                  </tr>
                  <tr>
                    <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
                      <tr>
                        <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                        <td align="right"><?php echo '<a href="' . smn_href_link(FILENAME_CREATE_ACCOUNT, '', 'NONSSL') . '">' . smn_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a>'; ?></td>
                        <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                      </tr>
                    </table></td>
                  </tr>
                </table></td>
              </tr>
                </table></td>
            </tr>
<?php
  }
  if($_GET['account'] == 'new_agent'){
?> 
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <tr>
            <td class="main" width="50%" valign="top"><b><?php echo HEADING_NEW_AGENT; ?></b></td>
          </tr>
              <tr>
                <td><table class="loginBoxContents" border="0" width="100%" height="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                  </tr>
                  <tr>
                    <td class="main" valign="top"><?php echo TEXT_NEW_AGENT . '<br><br>' . TEXT_NEW_AGENT_INTRODUCTION; ?></td>
                  </tr>
                  <tr>
                    <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                  </tr>
                  <tr>
                    <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
                      <tr>
                        <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                        <td align="right"><?php echo '<a href="' . smn_href_link(FILENAME_AFFILIATE_SIGNUP, '', 'NONSSL') . '">' . smn_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a>'; ?></td>
                        <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                      </tr>
                    </table></td>
                  </tr>
                </table></td>
            </tr>
                </table></td>
            </tr>
<?php
  }
  if($_GET['account'] == 'new_store'){
?> 
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <tr>
            <td class="main" width="50%" valign="top"><b><?php echo HEADING_NEW_STORE; ?></b></td>
          </tr>
              <tr>
                <td><table class="loginBoxContents" border="0" width="100%" height="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                  </tr>
                  <tr>
                    <td class="main" valign="top"><?php echo TEXT_NEW_STORE . '<br><br>' . TEXT_NEW_STORE_INTRODUCTION; ?></td>
                  </tr>
                  <tr>
                    <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                  </tr>
                  <tr>
                    <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
                      <tr>
                        <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                        <td align="right"><?php echo '<a href="' . smn_href_link(FILENAME_CREATE_STORE, 'ID=1', 'NONSSL') . '">' . smn_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a>'; ?></td>
                        <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                      </tr>
                    </table></td>
                  </tr>
                </table></td>
            </tr>
                </table></td>
            </tr>
<?php
  }
?>

        </td>
      </tr>
    </table></form>
