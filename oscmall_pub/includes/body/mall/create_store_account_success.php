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
<?php
// systemsmanager begin - Dec 13, 2005
if (smn_session_is_registered('error_text')) {
    $messageStack->add('create_store_account_success', $error_text);
?>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><?php echo $messageStack->output('create_store_account_success'); ?></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
	  smn_session_unregister('error_text');
}
// systemsmanager end
?>
      <tr>
      <td valign="top" class="main"><div align="center" class="pageHeading"><?php echo SUCCESS_HEADING_TITLE; ?></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
               <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
            
            <td valign="top" class="main"><div align="left" class="pageHeading"><?php echo smn_image(DIR_WS_IMAGES . 'table_background_man_on_board.gif', HEADING_TITLE); ?></div><?php echo TEXT_ACCOUNT_CREATED; ?></td>
              </tr>
            </table></td>
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
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '20', '1'); ?></td>
	  	<td align="left"><?php echo TEXT_GO_TO_NEW_STORE;  ?> </td>
        <td align="right"><?php echo '<a href="' . smn_href_link(FILENAME_DEFAULT, 'ID=' . $customer_store_id) . '">' . smn_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a>'; ?></td>
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '20', '1'); ?></td>
              </tr>
              
                                          <tr>
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '20', '1'); ?></td>
	  	<td align="left"><?php //echo TEXT_FINANCIAL_STORE_INFORMATION;  ?> </td>
        <td align="right"><?php //echo '<a href="' . FILENAME_CREATE_FINANCIAL_ACCOUNT .'" target="_blank">' . smn_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a>'; ?></td>
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      
    </table>