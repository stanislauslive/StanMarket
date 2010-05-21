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
    <table border="0" width="100%" cellspacing="15" cellpadding="0">
      <tr>
        <td>
	 <table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="main"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo smn_image(DIR_WS_IMAGES . 'table_background_account.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td class="smallText"><br><?php echo sprintf(TEXT_ORIGIN_LOGIN, smn_href_link(FILENAME_LOGIN, '', 'NONSSL')); ?></td>
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
             </tr>
	     <tr>
	        <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td class="smallText"><br><?php echo TEXT_NEW_STORE_MESSAGE; ?></td>
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <form name="basic_store" method="post" <?php echo 'action="' . smn_href_link(FILENAME_CREATE_STORE_ACCOUNT, '', 'NONSSL') . '"'; ?>>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td class="smallText"><br><?php echo TEXT_CONDITIONS_MESSAGE ; ?></td>
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
              <tr>
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '5'); ?></td>
                <td class="main"><?php echo '<a href="' . smn_href_link(FILENAME_CONDITIONS) . '">' . VIEW_CONDITIONS_TEXT . '</a><br>';?>
                    <?php echo smn_draw_checkbox_field('conditions', '1') . '&nbsp;' .  '<span class="inputRequirement">' . AGREE_TO_CONDITIONS_CHECK_BOX . '</span>'; ?></td>
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
               <?php  echo $store_selection_out_string; ?>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>  
    <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
    </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td><?php echo smn_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE); ?></td>
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      </form>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
    </table>