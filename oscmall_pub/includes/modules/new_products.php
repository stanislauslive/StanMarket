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
<!-- new_products //-->
<TABLE border="0" width="100%" cellspacing="0" cellpadding="0">
	<TR>
       <TD style="padding-right: 7px;">
			<TABLE border="0" width="100%" cellspacing="0" cellpadding="0">
				<TR>
       				<TD style="border-top: 1px solid #E4EFF4; border-bottom: 1px solid #E4EFF4; padding-bottom: 10px;">
<?php
//  $info_box_contents = array();
//  $info_box_contents[] = array('text' => sprintf(TABLE_HEADING_NEW_PRODUCTS, strftime('%B')));

//  new contentBoxHeading($info_box_contents);

  if ( (!isset($new_products_category_id)) || ($new_products_category_id == '0') ) {
  
  /* Changed the query to take store id from DB by Cimi on June 08,2007*/
  
    /*$new_products_query = smn_db_query("select p.products_id, p.products_image, p.products_tax_class_id, if(s.status, s.specials_new_products_price, p.products_price) as products_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id where p.store_id = $store_id and products_status = '1' order by p.products_date_added desc limit " . MAX_DISPLAY_NEW_PRODUCTS);*/
    $new_products_query = smn_db_query("select p.store_id,p.products_id, p.products_image, p.products_tax_class_id, if(s.status, s.specials_new_products_price, p.products_price) as products_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id where p.store_id = $store_id and products_status = '1' order by p.products_date_added desc limit " . MAX_DISPLAY_NEW_PRODUCTS);
  } else {
    $new_products_query = smn_db_query("select distinct p.products_id,p.store_id, p.products_image, p.products_tax_class_id, if(s.status, s.specials_new_products_price, p.products_price) as products_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c where p.store_id = $store_id and c.store_id = $store_id and p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and c.parent_id = '" . (int)$new_products_category_id . "' and p.products_status = '1' order by p.products_date_added desc limit " . MAX_DISPLAY_NEW_PRODUCTS);
  }

  $row = 0;
  $col = 0;
  $nr = 1;  
  $info_box_contents = array();
  while ($new_products = smn_db_fetch_array($new_products_query)) {
  
  if ($nr > 2) {
  $style1 = 'border-top: 1px solid #E4EFF4;';
  } else {
  $style1 = '';
  }  
  
  if ($col > 0) {
  $style2 = 'border-left: 1px solid #E4EFF4; ';
  } else {
  $style2 = '';
  }    
  
//    $new_products['products_name'] = smn_get_products_name($new_products['products_id']);
	
// ADDED BY CLEMENT
   $product_query = smn_db_query("select products_name, products_description from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . $new_products['products_id'] . "' and language_id = '" . $languages_id . "'");
    $product_details = smn_db_fetch_array($product_query);
  
  
    $new_products['products_name'] = $product_details['products_name'];
	$new_products['products_description'] = substr ($product_details['products_description'],0,96);

//**
/* Added 'ID=' . $new_products['store_id'] . '& in L92 to add the store id in the url by Cimi on June 08,2007*/
    $info_box_contents[$row][$col] = array('align' => 'left',
                                           'params' => 'width="50%" valign="top"',
                                           'text' => 
										   
    smn_draw_form('cart_quantity', smn_href_link(FILENAME_PRODUCT_INFO, smn_get_all_get_params(array('action')) . 'action=add_product&products_id=' . $new_products['products_id'])) . '
										 
			<TABLE border="0" width="100%" cellspacing="0" cellpadding="0">
				<TR>
       				<TD style="padding-left: 8px;">
					
					
					<TABLE border="0" width="100%" cellspacing="0" cellpadding="0">
						<TR>
       						<TD style="' . $style1 . '">' . smn_draw_separator('pixel_trans.gif', '100%', '7') . '</TD>
						</TR>
					</TABLE>
					
					
					
					</TD>					
				</TR>
				<TR>
       				<TD style="' . $style2 . 'padding-left: 7px;">
				<SPAN CLASS="priceNew">' . $currencies->display_price($new_products['products_price'], smn_get_tax_rate($new_products['products_tax_class_id'])) . '</SPAN><br>
				'.smn_draw_hidden_field('products_id', $new_products['products_id']). smn_image_submit('add_to_cart.gif', IMAGE_BUTTON_IN_CART).'<br>
				<a href="' . smn_href_link(FILENAME_PRODUCT_INFO, 'ID=' . $new_products['store_id'] . '&products_id=' . $new_products['products_id']) . '">' . smn_image(DIR_WS_CATALOG_IMAGES . $new_products['products_image'], $new_products['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a><br><a class="prodNameNew" href="' . smn_href_link(FILENAME_PRODUCT_INFO, 'ID=' . $new_products['store_id'] . '&products_id=' . $new_products['products_id']) . '">' . $new_products['products_name'] . '</a><br>' . $new_products['products_description'] . '
			    	</TD>
				</TR>
			</TABLE>										   						   
		      </FORM>');
	$nr ++;
    $col ++;
    if ($col > 1) {
      $col = 0;
      $row ++;
    }
  }

  new contentBox($info_box_contents);
?>
			    	</TD>
				</TR>
			</TABLE>
		</TD>
	</TR>
</TABLE>				
<!-- new_products_eof //-->
