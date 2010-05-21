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
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
			<!--Changed the path of the image,by Cimi -->
            <td align="right"><img src="images/affiliate_images/affiliate_payment.gif" align="<?=HEADING_TITLE?>" /><?php //echo smn_image(DIR_WS_IMAGES . 'affiliate_payment.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main" colspan="4"><?php echo TEXT_AFFILIATE_HEADER . ' <b>' . smn_db_num_rows(smn_db_query($affiliate_payment_raw)); ?></b></td>
          </tr>
          <tr>
            <td colspan="4"><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
          <tr>
            <td class="infoBoxHeading" align="right"><?php echo TABLE_HEADING_PAYMENT_ID; ?><?php echo '<a href="javascript:popupWindow(\'' . smn_href_link(FILENAME_AFFILIATE_HELP_19) . '\')"> ' . TEXT_PAYMENT_HELP . '</a>'; ?></td>
            <td class="infoBoxHeading" align="center"><?php echo TABLE_HEADING_DATE; ?><?php echo '<a href="javascript:popupWindow(\'' . smn_href_link(FILENAME_AFFILIATE_HELP_20) . '\')"> ' . TEXT_PAYMENT_HELP . '</a>'; ?></td>
            <td class="infoBoxHeading" align="right"><?php echo TABLE_HEADING_PAYMENT; ?><?php echo '<a href="javascript:popupWindow(\'' . smn_href_link(FILENAME_AFFILIATE_HELP_21) . '\')"> ' . TEXT_PAYMENT_HELP . '</a>'; ?></td>
            <td class="infoBoxHeading" align="right"><?php echo TABLE_HEADING_STATUS; ?><?php echo '<a href="javascript:popupWindow(\'' . smn_href_link(FILENAME_AFFILIATE_HELP_22) . '\')"> ' . TEXT_PAYMENT_HELP . '</a>'; ?></td>
          </tr>
<?php
  if ($affiliate_payment_split->number_of_rows > 0) {
    $affiliate_payment_values = smn_db_query($affiliate_payment_split->sql_query);
    $number_of_payment = 0;
    while ($affiliate_payment = smn_db_fetch_array($affiliate_payment_values)) {
      $number_of_payment++;

      if (($number_of_payment / 2) == floor($number_of_payment / 2)) {
        echo '          <tr class="productListing-even">';
      } else {
        echo '          <tr class="productListing-odd">';
      }
?>
            <td class="smallText" align="right"><?php echo $affiliate_payment['affiliate_payment_id']; ?></td>
            <td class="smallText" align="center"><?php echo smn_date_short($affiliate_payment['affiliate_payment_date']); ?></td>
            <td class="smallText" align="right"><?php echo $currencies->display_price($affiliate_payment['affiliate_payment_total'], ''); ?></td>
            <td class="smallText" align="right"><?php echo $affiliate_payment['affiliate_payment_status_name']; ?></td>
          </tr>
<?php
    }
  } else {
?>
          <tr class="productListing-odd">
            <td colspan="4" class="main"><?php echo TEXT_NO_PAYMENTS; ?></td>
          </tr>
<?php
  }
?>
          <tr>
            <td colspan="4"><?php echo smn_draw_separator(); ?></td>
          </tr>
<?php 
  if ($affiliate_payment_split->number_of_rows > 0) {
?>    
          <tr>
            <td colspan="4"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td class="smallText"><?php echo $affiliate_payment_split->display_count(TEXT_DISPLAY_NUMBER_OF_PAYMENTS); ?></td>
                <td align="right" class="smallText"><?php echo TEXT_RESULT_PAGE; ?> <?php echo $affiliate_payment_split->display_links(MAX_DISPLAY_PAGE_LINKS, smn_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>
              </tr>
            </table></td>
          </tr>
<?php
  }
  $affiliate_payment_values = smn_db_query("select sum(affiliate_payment_total) as total from " . TABLE_AFFILIATE_PAYMENT . " where affiliate_id = '" . $affiliate_id . "'");
  $affiliate_payment = smn_db_fetch_array($affiliate_payment_values);
?>
          <tr>
            <td class="main" colspan="4"><br><?php echo TEXT_INFORMATION_PAYMENT_TOTAL . ' <b>' . $currencies->display_price($affiliate_payment['total'], ''); ?></b></td>
          </tr>
                <tr>
                  <td colspan="4"><?php echo smn_draw_separator(); ?></td>
                </tr>
                 <tr>
                  <td align="center" class="boxtext" colspan="4"><b><?php echo TEXT_PAYMENT; ?><b></td>
                </tr>
                <tr>
                  <td colspan="4"><?php echo smn_draw_separator(); ?></td>
                </tr>
        </table></td>
      </tr>
    </table>
