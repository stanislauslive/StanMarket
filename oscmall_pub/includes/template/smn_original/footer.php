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

<!-- footer //-->




<table class="bottom_boxes" align="center" border="0" cellpadding="0" cellspacing="0" width="750">
<tbody><tr>
  <td class="box1" align="left" valign="top" width="25%">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <!-- information //-->
          <tbody><tr>
            <td>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tbody><tr>
    <td class="infoBoxHeadingLcornerBottom" height="14"> </td>
    <td class="infoBoxHeadingBottom" height="14">Information&nbsp;</td>
    <td class="infoBoxHeadingRcornerBottom" height="14"> </td>
  </tr>
</tbody></table>
<table class="infoBoxBottom" border="0" cellpadding="0" cellspacing="0" width="100%">
  <tbody><tr>
    <td><table class="infoBoxContentsBottom" border="0" cellpadding="3" cellspacing="0" width="100%">
  <tbody><tr>
    <td><img src="images/pixel_trans.gif" alt="" border="0" height="1" width="100%"></td>
  </tr>
  <tr>
    <td class="boxText"><a href="<?php echo smn_href_link(FILENAME_SHIPPING, 'ID=' . $store_id); ?>">Shipping &amp; Returns</a><br>
    <a href="<?php echo smn_href_link(FILENAME_PRIVACY, 'ID=' . $store_id); ?>">Privacy Notice</a><br>
    <a href="<?php echo smn_href_link(FILENAME_CONDITIONS, 'ID=' . $store_id); ?>">Conditions of Use</a><br>
    <a href="<?php echo smn_href_link(FILENAME_CONTACT_US, 'ID=' . $store_id); ?>">Contact Us</a></td>
  </tr>
  <tr>
    <td><img src="images/pixel_trans.gif" alt="" border="0" height="1" width="100%"></td>
  </tr>
</tbody></table>
</td>
  </tr>
</tbody></table>
            </td>
          </tr>
<!-- information_eof //-->
	</tbody></table>
  </td>
  <td class="box_div" align="left" valign="top" width="1"><img src="<?php echo DIR_WS_INFOBOX; ?>boxtop_div.gif"></td>
  <td class="box2" align="left" valign="top" width="25%">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
	<!-- manufacturers //-->
          <tbody><tr>
            <td>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tbody><tr>
    <td class="infoBoxHeadingLcornerBottom" height="14"> </td>
    <td class="infoBoxHeadingBottom" height="14"><?php echo BOX_HEADING_BESTSELLERS;?></td>
    <td class="infoBoxHeadingRcornerBottom" height="14"> </td>
  </tr>
</tbody></table>
<?php
  if (isset($current_category_id) && ($current_category_id > 0)) {
    $best_sellers_query = smn_db_query("select distinct p.products_id, pd.products_name, p.store_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c where p.products_status = '1' and p.products_ordered > 0 and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' and p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and '" . (int)$current_category_id . "' in (c.categories_id, c.parent_id) order by p.products_ordered desc, pd.products_name limit " . MAX_DISPLAY_BESTSELLERS);
  } else {
    $best_sellers_query = smn_db_query("select distinct p.products_id, pd.products_name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_ordered > 0 and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' order by p.products_ordered desc, pd.products_name limit " . MAX_DISPLAY_BESTSELLERS);
  }

  if (smn_db_num_rows($best_sellers_query) >= MIN_DISPLAY_BESTSELLERS) {
    $rows = 0;
    $bestsellers_list = '<table border="0" width="100%" cellspacing="0" cellpadding="1">';
    while ($best_sellers = smn_db_fetch_array($best_sellers_query)) {
      $rows++;
      $bestsellers_list .= '<tr><td class="infoBoxContents" valign="top">' . smn_row_number_format($rows) . '.</td><td class="infoBoxContents"><a href="' . smn_href_link(FILENAME_PRODUCT_INFO, 'ID=' . $best_sellers['store_id'] . '&products_id=' . $best_sellers['products_id']) . '">' . $best_sellers['products_name'] . '</a></td></tr>';
    }
    $bestsellers_list .= '</table>';

    $info_box_contents = array();
    $info_box_contents[] = array('text' => $bestsellers_list);

    new infoBox($info_box_contents);
  }
?>
            </td>
          </tr>
<!-- manufacturers_eof //-->
	</tbody></table>
  </td>
  <td class="box_div" align="left" valign="top" width="1"><img src="<?php echo DIR_WS_INFOBOX; ?>boxtop_div.gif"></td>
  <td class="box3" align="left" valign="top" width="25%">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
	

    
<!-- languages //-->
          <tbody><tr>
            <td>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tbody><tr>
    <td class="infoBoxHeadingLcornerBottom" height="14"> </td>
    <td class="infoBoxHeadingBottom" height="14"><?php echo BOX_HEADING_WHATS_NEW;?>&nbsp;</td>
    <td class="infoBoxHeadingRcornerBottom" height="14"> </td>
  </tr>
</tbody></table>
<?php
  if ($random_product = smn_random_select("select products_id, products_image, products_tax_class_id, products_price, store_id from " . TABLE_PRODUCTS . " where products_status = '1' order by products_date_added desc limit " . MAX_RANDOM_SELECT_NEW)) {
    $random_product['products_name'] = smn_get_products_name($random_product['products_id']);
    $random_product['specials_new_products_price'] = smn_get_products_special_price($random_product['products_id']);
    if (smn_not_null($random_product['specials_new_products_price'])) {
      $whats_new_price = '<s>' . $currencies->display_price($random_product['products_price'], smn_get_tax_rate($random_product['products_tax_class_id'])) . '</s><br>';
      $whats_new_price .= '<span class="productSpecialPrice">' . $currencies->display_price($random_product['specials_new_products_price'], smn_get_tax_rate($random_product['products_tax_class_id'])) . '</span>';
    } else {
      $whats_new_price = $currencies->display_price($random_product['products_price'], smn_get_tax_rate($random_product['products_tax_class_id']));
    }

    $info_box_contents = array();
    $imageDir = 'images/' . $random_product['store_id'] . '_images/';
    $info_box_contents[] = array('align' => 'center',
                                 'text' => '<a href="' . smn_href_link(FILENAME_PRODUCT_INFO, 'ID=' . $random_product['store_id'] . '&products_id=' . $random_product['products_id']) . '">' . smn_image($imageDir . $random_product['products_image'], $random_product['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a><br><a href="' . smn_href_link(FILENAME_PRODUCT_INFO, 'ID=' . $random_product['store_id'] . '&products_id=' . $random_product['products_id']) . '">' . $random_product['products_name'] . '</a><br>' . $whats_new_price);

    new infoBox($info_box_contents);
  }
?>
            </td>
          </tr>
<!-- languages_eof //-->

	</tbody></table>
  </td>
  <td class="box_div" align="left" valign="top" width="1"><img src="<?php echo DIR_WS_INFOBOX; ?>boxtop_div.gif"></td>
  <td class="box4" align="left" valign="top" width="25%">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody>
		  <tr>
		  <td>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td class="infoBoxHeadingLcornerBottom" height="14"> </td>
    <td class="infoBoxHeadingBottom" height="14"><?php echo BOX_HEADING_TELL_A_FRIEND;?></td>
    <td class="infoBoxHeadingRcornerBottom" height="14"> </td>
  </tr>
</table>
<table border="0" width="100%" cellspacing="0" cellpadding="1" class="infoBox">
  <tr>
    <td><table border="0" width="100%" cellspacing="0" cellpadding="3" class="infoBoxContents">
  <tr>
    <td><img src="images/pixel_trans.gif" border="0" alt="" width="100%" height="1"></td>
  </tr>
  <tr>
    <td align="center" class="boxText"><form name="tell_a_friend" action="<?php echo smn_href_link(FILENAME_TELL_A_FRIEND, 'ID=' . $store_id);?>" method="get"><input type="text" name="to_email_address" size="10">&nbsp;<?php echo smn_image_submit('button_tell_a_friend.gif', 'Tell A Friend');?><input type="hidden" name="method" value="shop"><input type="hidden" name="origin" value="<?php echo basename($_SERVER['PHP_SELF']);?>"><br>Please enter the email address of someone you know to tell them about this shop.</form></td>
  </tr>
  <tr>
    <td><img src="images/pixel_trans.gif" border="0" alt="" width="100%" height="1"></td>
  </tr>
</table>
</td>
  </tr>
</table>	</td></tr></tbody></table>
  </td>
</tr>
</tbody></table>
<table class="footer_line" align="center" border="0" cellpadding="0" cellspacing="0" width="750">
<tbody><tr>
  <td class="footer_td" align="left">Copyright ©  <a href="http://www.oscdevshed.com/" target="_blank">The osCMall System</a><br><br>Developed by <a href="http://www.systemsmanager.net/" target="_blank">SystemsManager Technologies</a></td>
  <td class="footer_td1" align="right">
  <table class="footer_menu_tb" border="0" cellpadding="0" cellspacing="0" width="400">
	<tbody><tr>
		<td align="center">
  				<span style="margin-right: 5px;">	
					<a href="<?php echo smn_href_link(FILENAME_INDEX, 'ID=' . $store_id); ?>">Home</a>
				</span>
		</td>
		<td align="center">
  				<span style="margin-right: 5px;">|</span>
		</td>
		<td align="center">
  				<span style="margin-right: 5px; margin-left: 5px;">	
					<a href="<?php echo smn_href_link(FILENAME_CONTACT_US, 'ID=' . $store_id); ?>">Contact us</a>
				</span>
		</td>
		<td align="center">
  				<span style="margin-right: 5px;">|</span>
		</td>
		<td align="center">
  				<span style="margin-right: 5px; margin-left: 5px;">	
					<a href="<?php echo smn_href_link(FILENAME_SPECIALS, 'ID=' . $store_id); ?>">Specials</a>
				</span>
		</td>
		<td align="center">
  				<span style="margin-right: 5px;">|</span>
		</td>
		<td align="center">
  				<span style="margin-right: 5px; margin-left: 5px;">	
					<a href="<?php echo smn_href_link(FILENAME_CHECKOUT_SHIPPING, 'ID=' . $store_id); ?>">Checkout</a>
				</span>
		</td>
		<td align="center">
  				<span style="margin-right: 5px;">|</span>
		</td>
		<td align="center">
  				<span style="margin-right: 5px; margin-left: 5px;">	
					<a href="<?php echo smn_href_link(FILENAME_ACCOUNT, 'ID=' . $store_id); ?>">Your Account</a>
				</span>
		</td>
  </tr></tbody></table>
  </td>
</tr>
</tbody></table>
<!-- footer_eof //-->