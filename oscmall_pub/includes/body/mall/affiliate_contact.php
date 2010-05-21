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
            <td class="pageHeading" align="right"><?php echo smn_image(DIR_WS_IMAGES . 'table_background_contact_us.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
  if (isset($_GET['action']) && ($_GET['action'] == 'success')) {
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main"><?php echo smn_image(DIR_WS_IMAGES . 'table_background_man_on_board.gif', HEADING_TITLE, '0', '0', 'align="left"') . TEXT_SUCCESS; ?></td>
          </tr>
          <tr>
            <td align="right"><br><a href="<?php echo smn_href_link(FILENAME_AFFILIATE_SUMMARY); ?>"><?php echo smn_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE); ?></a></td>
          </tr>
        </table></td>
      </tr>
<?php
  } else {
?>
      <tr>
        <td><?php echo smn_draw_form('contact_us', smn_href_link(FILENAME_AFFILIATE_CONTACT, 'action=send')); ?><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main"><?php echo ENTRY_NAME; ?><br><?php echo smn_draw_input_field('name', $affiliate['affiliate_firstname'] . ' ' . $affiliate['affiliate_lastname'], 'size=40'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_EMAIL; ?><br><?php echo smn_draw_input_field('email', $affiliate['affiliate_email_address'], 'size=40'); if ($error) echo ENTRY_EMAIL_ADDRESS_CHECK_ERROR; ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_ENQUIRY; ?></td>
          </tr>
          <tr>
            <td><?php echo smn_draw_textarea_field('enquiry', 'soft', 50, 15, $_POST['enquiry']); ?></td>
          </tr>
          <tr>
            <td class="main" align="right"><br><?php echo smn_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE); ?></td>
          </tr>
        </table></form></td>
      </tr>
<?php
  }
?>
    </table>
