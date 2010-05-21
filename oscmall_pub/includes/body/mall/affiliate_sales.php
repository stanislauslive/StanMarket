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
            <td align="right"><img src="images/affiliate_images/affiliate_sales.gif" align="<?=HEADING_TITLE?>" /><?php //echo smn_image(DIR_WS_IMAGES . 'affiliate_sales.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="4">
          <tr>
            <td class="main" colspan="5"><?php echo TEXT_AFFILIATE_HEADER . ' <b>' . smn_db_num_rows(smn_db_query($affiliate_sales_raw)); ?></b></td>
          </tr>
          <tr>
            <td colspan="5"><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
          <tr>
            <td class="infoBoxHeading" align="center"><?php echo TABLE_HEADING_DATE; ?><?php echo '<a href="javascript:popupWindow(\'' . smn_href_link(FILENAME_AFFILIATE_HELP_12) . '\')"> ' . TEXT_SALES_HELP . '</a>'; ?></td>
            <td class="infoBoxHeading" align="right"><?php echo TABLE_HEADING_VALUE; ?><?php echo '<a href="javascript:popupWindow(\'' . smn_href_link(FILENAME_AFFILIATE_HELP_13) . '\')"> ' . TEXT_SALES_HELP . '</a>'; ?></td>
            <td class="infoBoxHeading" align="right"><?php echo TABLE_HEADING_PERCENTAGE; ?><?php echo '<a href="javascript:popupWindow(\'' . smn_href_link(FILENAME_AFFILIATE_HELP_14) . '\')"> ' . TEXT_SALES_HELP . '</a>'; ?></td>
            <td class="infoBoxHeading" align="right"><?php echo TABLE_HEADING_SALES; ?><?php echo '<a href="javascript:popupWindow(\'' . smn_href_link(FILENAME_AFFILIATE_HELP_15) . '\')"> ' . TEXT_SALES_HELP . '</a>'; ?></td>
            <td class="infoBoxHeading" align="right"><?php echo TABLE_HEADING_STATUS; ?><?php echo '<a href="javascript:popupWindow(\'' . smn_href_link(FILENAME_AFFILIATE_HELP_16) . '\')"> ' . TEXT_SALES_HELP . '</a>'; ?></td>
          </tr>
<?php
  if ($affiliate_sales_split->number_of_rows > 0) {
    $affiliate_sales_values = smn_db_query($affiliate_sales_split->sql_query);
    $number_of_sales = 0;
    $sum_of_earnings = 0;
    while ($affiliate_sales = smn_db_fetch_array($affiliate_sales_values)) {
      $number_of_sales++;
      if ($affiliate_sales['orders_status_id'] >= AFFILIATE_PAYMENT_ORDER_MIN_STATUS) $sum_of_earnings += $affiliate_sales['affiliate_payment'];
      if (($number_of_sales / 2) == floor($number_of_sales / 2)) {
        echo '          <tr class="productListing-even">';
      } else {
        echo '          <tr class="productListing-odd">';
      }
?>
            <td class="smallText" align="center"><?php echo smn_date_short($affiliate_sales['affiliate_date']); ?></td>
            <td class="smallText" align="right"><?php echo $currencies->display_price($affiliate_sales['affiliate_value'], ''); ?></td>
            <td class="smallText" align="right"><?php echo $affiliate_sales['affiliate_percent'] . " %"; ?></td>
            <td class="smallText" align="right"><?php echo $currencies->display_price($affiliate_sales['affiliate_payment'], ''); ?></td>
            <td class="smallText" align="right"><?php if ($affiliate_sales['orders_status']) echo $affiliate_sales['orders_status']; else echo TEXT_DELETED_ORDER_BY_ADMIN; ?></td>
          </tr>
<?php
    }
  } else {
?>
          <tr class="productListing-odd">
            <td class="main" colspan="5"><?php echo TEXT_NO_SALES; ?></td>
          </tr>
<?php
  }
?>
          <tr>
            <td colspan="5"><?php echo smn_draw_separator(); ?></td>
          </tr>
<?php 
  if ($affiliate_sales_split->number_of_rows > 0) {
?>
          <tr>
            <td colspan="5"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td class="smallText"><?php echo $affiliate_sales_split->display_count(TEXT_DISPLAY_NUMBER_OF_SALES); ?></td>
                <td class="smallText" align="right"><?php echo TEXT_RESULT_PAGE; ?> <?php echo $affiliate_sales_split->display_links(MAX_DISPLAY_PAGE_LINKS, smn_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>
              </tr>
            </table></td>
          </tr>
          <tr>
<?php
  }
?>
            <td class="main" colspan="5"><br><?php echo TEXT_INFORMATION_SALES_TOTAL . ' <b>' .  $currencies->display_price($sum_of_earnings,''), '</b>' . TEXT_INFORMATION_SALES_TOTAL2; ?></td>
          </tr>
                <tr>
                  <td colspan="5"><?php echo smn_draw_separator(); ?></td>
                </tr>
                 <tr>
                  <td align="center" class="boxtext" colspan="5"><b><?php echo TEXT_SALES; ?><b></td>
                </tr>
                <tr>
                  <td colspan="5"><?php echo smn_draw_separator(); ?></td>
                </tr>
        </table></td>
      </tr>
    </table>
