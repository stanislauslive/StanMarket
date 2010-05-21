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
            <td class="pageHeading" align="right"><?php echo smn_image(DIR_WS_IMAGES . 'table_background_account.gif', NAVBAR_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
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

  if (smn_count_customer_orders() > 0) {
?>
      <tr>
        <td><table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main"><b><?php echo OVERVIEW_TITLE; ?></b></td>
            <td class="main"><?php echo '<a href="' . smn_href_link(FILENAME_ACCOUNT_HISTORY, '', 'NONSSL') . '"><u>' . OVERVIEW_SHOW_ALL_ORDERS . '</u></a>'; ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td class="main" align="center" valign="top" width="130"><?php echo '<b>' . OVERVIEW_PREVIOUS_ORDERS . '</b><br>' . smn_image(DIR_WS_IMAGES . 'arrow_south_east.gif'); ?></td>
                <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php
    $orders_query = smn_db_query("select o.orders_id, o.date_purchased, o.delivery_name, o.delivery_country, o.billing_name, o.billing_country, ot.text as order_total, s.orders_status_name from " . TABLE_ORDERS . " o, " . TABLE_ORDERS_TOTAL . " ot, " . TABLE_ORDERS_STATUS . " s where o.customers_id = '" . (int)$customer_id . "' and o.orders_id = ot.orders_id and ot.class = 'ot_total' and o.orders_status = s.orders_status_id and s.language_id = '" . (int)$languages_id . "' and s.public_flag = '1' order by orders_id desc limit 3");
    while ($orders = smn_db_fetch_array($orders_query)) {
      if (smn_not_null($orders['delivery_name'])) {
        $order_name = $orders['delivery_name'];
        $order_country = $orders['delivery_country'];
      } else {
        $order_name = $orders['billing_name'];
        $order_country = $orders['billing_country'];
      }
?>
                  <tr class="moduleRow" onMouseOver="rowOverEffect(this)" onMouseOut="rowOutEffect(this)" onClick="document.location.href='<?php echo smn_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $orders['orders_id'], 'NONSSL'); ?>'">
                    <td class="main" width="80"><?php echo smn_date_short($orders['date_purchased']); ?></td>
                    <td class="main"><?php echo '#' . $orders['orders_id']; ?></td>
                    <td class="main"><?php echo smn_output_string_protected($order_name) . ', ' . $order_country; ?></td>
                    <td class="main"><?php echo $orders['orders_status_name']; ?></td>
                    <td class="main" align="right"><?php echo $orders['order_total']; ?></td>
                    <td class="main" align="right"><?php echo '<a href="' . smn_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $orders['orders_id'], 'NONSSL') . '">' . smn_image_button('small_view.gif', SMALL_IMAGE_BUTTON_VIEW) . '</a>'; ?></td>
                  </tr>
<?php
    }
?>
                </table></td>
                <td><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
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
            <td class="main"><b><?php echo MY_ACCOUNT_TITLE; ?></b></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td width="60"><?php echo smn_image(DIR_WS_IMAGES . 'account_personal.gif'); ?></td>
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="main"><?php echo  smn_image(DIR_WS_IMAGES . 'arrow_green.gif');if($affiliate_id){echo ' <a href="' . smn_href_link(FILENAME_AFFILIATE_ACCOUNT, '', 'NONSSL'). '">' . MY_ACCOUNT_INFORMATION . '</a>';}else{echo ' <a href="' . smn_href_link(FILENAME_ACCOUNT_EDIT, '', 'NONSSL') . '">' . MY_ACCOUNT_INFORMATION . '</a>';} ?></td>
                  </tr>
                  <tr>
                    <td class="main"><?php echo smn_image(DIR_WS_IMAGES . 'arrow_green.gif') . ' <a href="' . smn_href_link(FILENAME_ADDRESS_BOOK, '', 'NONSSL') . '">' . MY_ACCOUNT_ADDRESS_BOOK . '</a>'; ?></td>
                  </tr>
                  <tr>
                    <td class="main"><?php echo smn_image(DIR_WS_IMAGES . 'arrow_green.gif') . ' <a href="' . smn_href_link(FILENAME_ACCOUNT_PASSWORD, '', 'NONSSL') . '">' . MY_ACCOUNT_PASSWORD . '</a>'; ?></td>
                  </tr>
				  <?php if ($affiliate_id) {?> 
				  <tr>
                    <td class="main"><?php echo smn_image(DIR_WS_IMAGES . 'arrow_green.gif') . ' <a href="' . smn_href_link(FILENAME_AFFILIATE_NEWSLETTER, '', 'NONSSL'). '">' . TEXT_AFFILIATE_NEWSLETTER . '</a>'; ?></td>
                  </tr>
				  <tr>
                    <td class="main"><?php echo smn_image(DIR_WS_IMAGES . 'arrow_green.gif') . ' <a href="' . smn_href_link(FILENAME_AFFILIATE_NEWS, '', 'NONSSL'). '">' . TEXT_AFFILIATE_NEWS . '</a>'; ?></td>
                  </tr>
				  <?php } ?>
                </table></td>
                <td width="10" align="right"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
<!--Added to include affiliate tools in account area by Cimi-->	  
<?php //if ($affiliate_id) {?> 	  
	  
	 <tr>
        <td colspan="4"><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td colspan="4"><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main"><b><?php echo '<a href="' . smn_href_link(FILENAME_AFFILIATE_BANNERS, '', 'NONSSL'). '">' . TEXT_AFFILIATE_BANNERS . '</a>';?></b></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="4"><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
			<!--Changed the image path from images to images/affiliate_images,by Cimi -->                
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td width="60"><?php echo smn_image('images/affiliate_images/affiliate_links.gif'); ?></td>
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="main" width="50%"><?php echo smn_image(DIR_WS_IMAGES . 'arrow_green.gif') ; echo ' <a href="' . smn_href_link(FILENAME_AFFILIATE_BANNERS_BANNERS, '', 'NONSSL'). '">' . TEXT_AFFILIATE_BANNERS_BANNERS . '</a>';?></td>
                    <td class="main" width="50%"><?php echo smn_image(DIR_WS_IMAGES . 'arrow_green.gif') ; echo ' <a href="' . smn_href_link(FILENAME_AFFILIATE_BANNERS_BUILD, '', 'NONSSL'). '">' . TEXT_AFFILIATE_BANNERS_BUILD . '</a>';?></td>
                  </tr>
                  <tr>
                    <td class="main" width="50%"><?php echo smn_image(DIR_WS_IMAGES . 'arrow_green.gif') ; echo ' <a href="' . smn_href_link(FILENAME_AFFILIATE_BANNERS_PRODUCT, '', 'NONSSL'). '">' . TEXT_AFFILIATE_BANNERS_PRODUCT . '</a>';?></td>
                    <td class="main" width="50%"><?php echo smn_image(DIR_WS_IMAGES . 'arrow_green.gif') ; echo ' <a href="' . smn_href_link(FILENAME_AFFILIATE_BANNERS_TEXT, '', 'NONSSL'). '">' . TEXT_AFFILIATE_BANNERS_TEXT . '</a>';?></td>
                  </tr>
                  </table></td>
                <td width="10" align="right"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
             </tr>
           </table></td>
         </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="4"><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td colspan="4"><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main"><b><?php echo '<a href="' . smn_href_link(FILENAME_AFFILIATE_REPORTS, '', 'NONSSL'). '">' . TEXT_AFFILIATE_REPORTS . '</a>';?></b></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="4"><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
<!--Changed the image path from images to images/affiliate_images,by Cimi -->
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td width="60"><?php echo smn_image('images/affiliate_images/affiliate_reports.gif'); ?></td>
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="main" width="50%"><?php echo smn_image(DIR_WS_IMAGES . 'arrow_green.gif') ;  echo ' <a href="' . smn_href_link(FILENAME_AFFILIATE_CLICKS, '', 'NONSSL'). '">' . TEXT_AFFILIATE_CLICKRATE . '</a>';?></td>
                    <td class="main" width="50%"><?php echo smn_image(DIR_WS_IMAGES . 'arrow_green.gif') ;  echo ' <a href="' . smn_href_link(FILENAME_AFFILIATE_PAYMENT, '', 'NONSSL'). '">' . TEXT_AFFILIATE_PAYMENT . '</a>';?></td>
                  </tr>
                  <tr>
                    <td class="main" width="50%"><?php echo smn_image(DIR_WS_IMAGES . 'arrow_green.gif') ;  echo ' <a href="' . smn_href_link(FILENAME_AFFILIATE_SALES, '', 'NONSSL'). '">' . TEXT_AFFILIATE_SALES . '</a>';?></td>
                    <td class="main" width="50%">&nbsp;</td>
                  </tr>
                  </table></td>
                <td width="10" align="right"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
             </tr>
           </table></td>
         </tr>
        </table></td>
      </tr>
<?// } ?>	
<!--end of code-->     
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main"><b><?php echo MY_ORDERS_TITLE; ?></b></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td width="60"><?php echo smn_image(DIR_WS_IMAGES . 'account_orders.gif'); ?></td>
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="main"><?php echo smn_image(DIR_WS_IMAGES . 'arrow_green.gif') . ' <a href="' . smn_href_link(FILENAME_ACCOUNT_HISTORY, '', 'NONSSL') . '">' . MY_ORDERS_VIEW . '</a>'; ?></td>
                  </tr>
				 <!-- Order Tool for store vendors Added By Cimi -->
				  <?php if($customer_store_id){ ?>
				  <tr>
                    <td class="main"><?php echo smn_image(DIR_WS_IMAGES . 'arrow_green.gif') . ' <a href="' . smn_href_link(FILENAME_STORE_ORDER_DETAILS, '', 'NONSSL') . '">' . MY_ORDERS_FROM_ME_SINGLE_CHECKOUT . '</a>'; ?></td>
                  </tr>
				  <tr>
                    <td class="main"><?php echo smn_image(DIR_WS_IMAGES . 'arrow_green.gif') . ' <a href="' . smn_href_link(FILENAME_STORE_ORDER_TOOL, '', 'NONSSL') . '">' . MY_ORDERS_TOOL . '</a>'; ?></td>
                  </tr>
				  <?php }?>
                </table></td>
                <td width="10" align="right"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main"><b><?php echo EMAIL_NOTIFICATIONS_TITLE; ?></b></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td width="60"><?php echo smn_image(DIR_WS_IMAGES . 'account_notifications.gif'); ?></td>
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="main"><?php echo smn_image(DIR_WS_IMAGES . 'arrow_green.gif') . ' <a href="' . smn_href_link(FILENAME_ACCOUNT_NEWSLETTERS, '', 'NONSSL') . '">' . EMAIL_NOTIFICATIONS_NEWSLETTERS . '</a>'; ?></td>
                  </tr>
                  <tr>
                    <td class="main"><?php echo smn_image(DIR_WS_IMAGES . 'arrow_green.gif') . ' <a href="' . smn_href_link(FILENAME_ACCOUNT_NOTIFICATIONS, '', 'NONSSL') . '">' . EMAIL_NOTIFICATIONS_PRODUCTS . '</a>'; ?></td>
                  </tr>
                </table></td>
                <td width="10" align="right"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table>
