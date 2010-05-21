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
  
  Gift Voucher System v1.0
  Copyright (c) 2001, 2002 Ian C Wilson
  http://www.phesis.org

*/
?>

<!-- body_text //-->
<table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td align="right"><?php echo smn_image(DIR_WS_IMAGES . 'table_background_specials.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
  if ($_GET['action'] == 'process') {
?>
      <tr>
        <td class="main"><?php echo smn_image(DIR_WS_IMAGES . 'table_background_man_on_board.gif', HEADING_TITLE, '0', '0', 'align="left"') . TEXT_SUCCESS; ?><br><br><?php echo 'gv '.$id1; ?></td>
      </tr>
      <tr>
        <td align="right"><br><a href="<?php echo smn_href_link(FILENAME_DEFAULT, '', 'NONSSL'); ?>"><?php echo smn_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE); ?></a></td>
      </tr>
<?php
  }  
  if ($_GET['action'] == 'send' && !$error) {
    // validate entries
      $gv_amount = (double) $gv_amount;
      $gv_query = smn_db_query("select customers_firstname, customers_lastname from " . TABLE_CUSTOMERS . " where customers_id = '" . $customer_id . "'");
      $gv_result = smn_db_fetch_array($gv_query);
      $send_name = $gv_result['customers_firstname'] . ' ' . $gv_result['customers_lastname'];
?>
      <tr>
        <td><form action="<?php echo smn_href_link(FILENAME_GV_SEND, 'action=process', 'NONSSL'); ?>" method="post"><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main"><?php echo sprintf(MAIN_MESSAGE, $currencies->format($_POST['amount']), stripslashes($_POST['to_name']), $_POST['email'], stripslashes($_POST['to_name']), $currencies->format($_POST['amount']), $send_name); ?></td>
          </tr>
<?php
      if ($_POST['message']) {
?>
           <tr>
            <td class="main"><?php echo sprintf(PERSONAL_MESSAGE, $gv_result['customers_firstname']); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo stripslashes($_POST['message']); ?></td>
          </tr>
<?php
      }

      echo smn_draw_hidden_field('send_name', $send_name) . smn_draw_hidden_field('to_name', stripslashes($_POST['to_name'])) . smn_draw_hidden_field('email', $_POST['email']) . smn_draw_hidden_field('amount', $gv_amount) . smn_draw_hidden_field('message', stripslashes($_POST['message']));
?>
          <tr>
            <td class="main"><?php echo smn_image_submit('button_back.gif', IMAGE_BUTTON_BACK, 'name=back') . '</a>'; ?></td>
            <td align="right"><br><?php echo smn_image_submit('button_send.gif', IMAGE_BUTTON_CONTINUE); ?></td>
          </tr>
        </table></form></td>
      </tr>
<?php
  } elseif ($_GET['action']=='' || $error) {
?>
      <tr>
        <td class="main"><?php echo HEADING_TEXT; ?></td>
      </tr>
      <tr>
        <td><form action="<?php echo smn_href_link(FILENAME_GV_SEND, 'action=send', 'NONSSL'); ?>" method="post"><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main"><?php echo ENTRY_NAME; ?><br><?php echo smn_draw_input_field('to_name', stripslashes($_POST['to_name']));?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_EMAIL; ?><br><?php echo smn_draw_input_field('email', $_POST['email']); if ($error) echo $error_email; ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_AMOUNT; ?><br><?php echo smn_draw_input_field('amount', $_POST['amount'], '', '', false); if ($error) echo $error_amount; ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_MESSAGE; ?><br><?php echo smn_draw_textarea_field('message', 'soft', 50, 15, stripslashes($_POST['message'])); ?></td>
          </tr>
        </table>
        <table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
<?php
    $back = sizeof($navigation->path)-2;
?>
            <td class="main"><?php echo '<a href="' . smn_href_link($navigation->path[$back]['page'], smn_array_to_string($navigation->path[$back]['get'], array('action')), $navigation->path[$back]['mode']) . '">' . smn_image_button('button_back.gif', IMAGE_BUTTON_BACK) . '</a>'; ?></td>
            <td class="main" align="right"><?php echo smn_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE); ?></td>
          </tr>
        </table></form></td>
      </tr>
<?php
  }
?>
    </table>
    <!-- body_text_eof //-->