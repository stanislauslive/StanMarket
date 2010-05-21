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
            <td class="pageHeading" align="right"><img src="images/affiliate_images/affiliate_clicks.gif" align="<?=HEADING_TITLE?>" /><?php //echo smn_image(DIR_WS_IMAGES . 'affiliate_clicks.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main" colspan="4"><?php echo TEXT_AFFILIATE_HEADER;?><b><?php echo $affiliate_clickthroughs_numrows; ?></b></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="4">
          <tr>
            <td class="infoBoxHeading"><?php echo TABLE_HEADING_DATE; ?><?php echo '<a href="javascript:popupWindow(\'' . smn_href_link(FILENAME_AFFILIATE_HELP_9) . '\')"> ' . TEXT_CLICKTHROUGH_HELP . '</a>'; ?></td>
 	        <td class="infoBoxHeading"><?php echo TABLE_HEADING_CLICKED_PRODUCT; ?><?php echo '<a href="javascript:popupWindow(\'' . smn_href_link(FILENAME_AFFILIATE_HELP_10) . '\')"> ' . TEXT_CLICKTHROUGH_HELP . '</a>'; ?></td>
	        <td class="infoBoxHeading"><?php echo TABLE_HEADING_REFFERED; ?><?php echo '<a href="javascript:popupWindow(\'' . smn_href_link(FILENAME_AFFILIATE_HELP_11) . '\')"> ' . TEXT_CLICKTHROUGH_HELP . '</a>'; ?></td>
          </tr>
<?php
  if ($affiliate_clickthroughs_split->number_of_rows > 0) {
    $affiliate_clickthroughs_values = smn_db_query($affiliate_clickthroughs_split->sql_query);
    $number_of_clickthroughs = '0';
    while ($affiliate_clickthroughs = smn_db_fetch_array($affiliate_clickthroughs_values)) {
      $number_of_clickthroughs++;

      if (($number_of_clickthroughs / 2) == floor($number_of_clickthroughs / 2)) {
        echo '          <tr class="productListing-even">';
      } else {
        echo '          <tr class="productListing-odd">';
      }
?>
            <td class="smallText"><?php echo smn_date_short($affiliate_clickthroughs['affiliate_clientdate']); ?></td>
<?php
      if ($affiliate_clickthroughs['affiliate_products_id'] > 0) {
        $link_to = '<a href="' . smn_href_link (FILENAME_PRODUCT_INFO, 'products_id=' . $affiliate_clickthroughs['affiliate_products_id']) . '" target="_blank">' . $affiliate_clickthroughs['products_name'] . '</a>';
      } else {
        $link_to = "Startpage";
      }
?>
            <td class="smallText"><?php echo $link_to; ?></td>
            <td class="smallText"><?php echo $affiliate_clickthroughs['affiliate_clientreferer']; ?></td>
          </tr>
<?php
    }
  } else {
?>
          <tr class="productListing-odd">
            <td colspan="4" class="smallText"><?php echo TEXT_NO_CLICKS; ?></td>
          </tr>
<?php
  }
?>
          <tr>
            <td colspan="4"><?php echo smn_draw_separator(); ?></td>
          </tr>
<?php 
  if ($affiliate_clickthroughs_split->number_of_rows > 0) {
?>
          <tr>
            <td colspan="4"><table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td class="smallText"><?php echo $affiliate_clickthroughs_split->display_count(TEXT_DISPLAY_NUMBER_OF_CLICKS); ?></td>
                <td align="right" class="smallText"><?php echo TEXT_RESULT_PAGE; ?> <?php echo $affiliate_clickthroughs_split->display_links(MAX_DISPLAY_PAGE_LINKS, smn_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>
              </tr>
            </table></td>
          </tr>
<?php
  }
?>
                <tr>
                  <td colspan="4"><?php echo smn_draw_separator(); ?></td>
                </tr>
                 <tr>
                  <td align="center" class="boxtext" colspan="4"><b><?php echo TEXT_CLICKS; ?><b></td>
                </tr>
                <tr>
                  <td colspan="4"><?php echo smn_draw_separator(); ?></td>
                </tr>
        </table></td>
      </tr>
    </table>
