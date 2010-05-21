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
			<!--Changed the path of the image,by Cimi -->
            <td class="pageHeading" align="right"><img src="images/affiliate_images/affiliate_summary.gif" border="0" alt="The Affiliate Agent Program" width="85" height="60"></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
  if ($messageStack->size('account') > 0) {
?>
      <tr>
        <td><?php echo $messageStack->output('account'); ?></td>
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
            <td class="main"><?php echo TEXT_GREETING . $affiliate['affiliate_firstname'] . ' ' . $affiliate['affiliate_lastname'] . '<br>' . TEXT_AFFILIATE_ID . $affiliate_id; ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
      
      <td class="footers" align="center"><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?><?php echo '<a href="http://www.tourbec.info/voyage/index.php?ref=' . $affiliate_id . '&affiliate_banner_id=2"><img src="https://tourbec.info/voyage/affiliate_show_banner.php?ref=' . $affiliate_id . '&affiliate_banner_id=2" border="0" alt="Réservez / Reserve"></a>';?></td>
	</tr>
	<tr>
         <td class="footers" align="center"><?php echo '<a href="http://www.tourbec.info/voyage/index.php?ref=' . $affiliate_id . '&affiliate_banner_id=2">' . TEXT_AFFILIATE_BOOKING . '</a>';?></td>
      </tr>
      <tr>
         <td class="footerz" align="center"><?php echo '<a href="http://www.tourbec.info/voyage/index.php?ref=' . $affiliate_id . '&affiliate_banner_id=2">' . TEXT_AFFILIATE_BOOKING1 . '</a>';?><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
       <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td class="infoboxheading"><?php echo TEXT_SUMMARY_TITLE; ?></td>
              </tr>
            </table></td>
          </tr> 
          <tr>
            <td><table width="100%" border="0" cellpadding="4" cellspacing="2">
              <center>
                <tr>
                  <td width="35%" align="right" class="main"><?php echo TEXT_IMPRESSIONS; ?><?php echo '<a href="javascript:popupWindow(\'' . smn_href_link(FILENAME_AFFILIATE_HELP_1) . '\')">' . TEXT_SUMMARY_HELP . '</a>'; ?></td>
                  <td width="15%" class="main"><?php echo $affiliate_impressions; ?></td>
                  <td width="35%" align="right" class="main"><?php echo TEXT_VISITS; ?><?php echo '<a href="javascript:popupWindow(\'' . smn_href_link(FILENAME_AFFILIATE_HELP_2) . '\')">' . TEXT_SUMMARY_HELP . '</a>'; ?></td>
                  <td width="15%" class="main"><?php echo $affiliate_clickthroughs; ?></td>
                </tr>
                <tr>
                  <td width="35%" align="right" class="main"><?php echo TEXT_TRANSACTIONS; ?><?php echo '<a href="javascript:popupWindow(\'' . smn_href_link(FILENAME_AFFILIATE_HELP_3) . '\')">' . TEXT_SUMMARY_HELP . '</a>'; ?></td>
                  <td width="15%" class="main"><?php echo $affiliate_transactions; ?></td>
                  <td width="35%" align="right" class="main"><?php echo TEXT_CONVERSION; ?><?php echo '<a href="javascript:popupWindow(\'' . smn_href_link(FILENAME_AFFILIATE_HELP_4) . '\')">' . TEXT_SUMMARY_HELP . '</a>'; ?></td>
                  <td width="15%" class="main"><?php echo $affiliate_conversions;?></td>
                </tr>
                <tr>
                  <td width="35%" align="right" class="main"><?php echo TEXT_AMOUNT; ?><?php echo '<a href="javascript:popupWindow(\'' . smn_href_link(FILENAME_AFFILIATE_HELP_5) . '\')">' . TEXT_SUMMARY_HELP . '</a>'; ?></td>
                  <td width="15%" class="main"><?php echo $currencies->display_price($affiliate_amount, ''); ?></td>
                  <td width="35%" align="right" class="main"><?php echo TEXT_AVERAGE; ?><?php echo '<a href="javascript:popupWindow(\'' . smn_href_link(FILENAME_AFFILIATE_HELP_6) . '\')">' . TEXT_SUMMARY_HELP . '</a>'; ?></td>
                  <td width="15%" class="main"><?php echo $currencies->display_price($affiliate_average, ''); ?></td>
                </tr>
                <tr>
                   <td align="right" class="main"><?php echo TEXT_CLICKTHROUGH_RATE; ?><?php echo '<a href="javascript:popupWindow(\'' . smn_href_link(FILENAME_AFFILIATE_HELP_17) . '\')">' . TEXT_SUMMARY_HELP . '</a>'; ?></td>
                   <td class="main"><?php echo  $currencies->display_price(AFFILIATE_PAY_PER_CLICK, ''); ?></td>
                   <td align="right" class="main"><?php echo TEXT_PAYPERSALE_RATE; ?><?php echo '<a href="javascript:popupWindow(\'' . smn_href_link(FILENAME_AFFILIATE_HELP_18) . '\')">' . TEXT_SUMMARY_HELP . '</a>'; ?></td>
                   <td class="main"><?php echo  $currencies->display_price(AFFILIATE_PAYMENT, ''); ?></td>
                </tr>
                <tr>
                  <td width="35%" align="right" class="main"><?php echo TEXT_COMMISSION_RATE; ?><?php echo '<a href="javascript:popupWindow(\'' . smn_href_link(FILENAME_AFFILIATE_HELP_7) . '\')">' . TEXT_SUMMARY_HELP . '</a>'; ?></td>
                  <td width="15%" class="main"><?php echo smn_round($affiliate_percent, 2). '%'; ?></td>
                  <td width="35%" align="right" class="main"><?php echo TEXT_COMMISSION; ?><?php echo '<a href="javascript:popupWindow(\'' . smn_href_link(FILENAME_AFFILIATE_HELP_8) . '\')">' . TEXT_SUMMARY_HELP . '</a>'; ?></td>
                  <td width="15%" class="main"><?php echo $currencies->display_price($affiliate_commission, ''); ?>Info</td>
                </tr>
                <tr>
                  <td colspan="4"><?php echo smn_draw_separator(); ?></td>
                </tr>
                 <tr>
                  <td align="center" class="main" colspan="4"><b><?php echo TEXT_SUMMARY; ?><b></td>
                </tr>
                <tr>
                  <td colspan="4"><?php echo smn_draw_separator(); ?></td>
                </tr>

              </center>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table>
