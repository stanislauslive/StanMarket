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
    $info_box_contents = array();
    $info_box_contents[] = array('align' => 'left',
                                 'text'  => TABLE_HEADING_LATEST_NEWS);
    new contentBoxHeading($info_box_contents, true, true);

     $featured_products_category_id = $new_products_category_id;
  $cat_name_query = smn_db_query("select categories_name from categories_description where categories_id = '" . $featured_products_category_id . "' limit 1");
  $cat_name_fetch = smn_db_fetch_array($cat_name_query);
  $cat_name = $cat_name_fetch['categories_name'];
  $info_box_contents = array();
  if ( (!isset($featured_products_category_id)) || ($featured_products_category_id == '0') ) {
    $featured_products_query = smn_db_query("select p.products_id, p.products_image, p.products_tax_class_id, s.status as specstat, p.store_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, p.products_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id left join " . TABLE_FEATURED . " f on p.products_id = f.products_id where p.store_id = '". $store_id ."' and p.products_status = '1' and f.status = '1' order by rand() DESC limit " . MAX_DISPLAY_FEATURED_PRODUCTS);
  } else {

    $featured_products_query = smn_db_query("select distinct p.products_id, p.products_image, p.products_tax_class_id, s.status as specstat, s.specials_new_products_price, p.products_price, p.store_id from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c left join " . TABLE_FEATURED . " f on p.products_id = f.products_id where p.store_id = '". $store_id ."' and p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and c.parent_id = '" . $featured_products_category_id . "' and p.products_status = '1' and f.status = '1' order by rand() DESC limit " . MAX_DISPLAY_FEATURED_PRODUCTS);
  }



  $count = 0;
  while ($featured_products = smn_db_fetch_array($featured_products_query)) {
if ($featured_products['specials_new_products_price']) {
      $whats_new_price =  '<s>' . $currencies->display_price($featured_products['products_price'], smn_get_tax_rate($featured_products['products_tax_class_id'], '', '', $featured_products['store_id'])) . '</s><br>';
      $whats_new_price .= '<span class="productSpecialPrice">' . $currencies->display_price($featured_products['specials_new_products_price'], smn_get_tax_rate($featured_products['products_tax_class_id'], '', '', $featured_products['store_id'])) . '</span>';
    } else {
      $whats_new_price =  $currencies->display_price($featured_products['products_price'], smn_get_tax_rate($featured_products['products_tax_class_id'], '', '', $featured_products['store_id']));
    }


    $featured_products['products_description'] = smn_get_products_description($featured_products['products_id']);
    $featured_products['products_name'] = smn_get_products_name($featured_products['products_id']);
    $store_images = 'images/'. $featured_products['store_id'] . '_images/';

?>
    <td width="50%">
<?php
    $info_box_contents[] = array('align' => 'center',
                                            'text' => '<a href="' . smn_href_link(FILENAME_PRODUCT_INFO, 'ID=' .$featured_products['store_id'] . '&products_id=' . $featured_products['products_id']) . '">' . smn_image($store_images . $featured_products['products_image'], $featured_products['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT)
                                            . '</a></td><td><a href="' . smn_href_link(FILENAME_PRODUCT_INFO, 'ID=' .$featured_products['store_id'] . '&products_id=' . $featured_products['products_id']) . '"></a></td><td align="center">' .$whats_new_price
                                            . '<br><br><a href="' . smn_href_link(basename($PHP_SELF), smn_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $featured_products['products_id'], 'NONSSL') . '">'
                                            . smn_image_button('button_buy_now.gif') . '</a>&nbsp;<br></td><tr><td colspan="3" align="top" valign="top" height="100">'  . osc_trunc_string(strip_tags($featured_products['products_description']))
                                            . '<br><br><a href="' . smn_href_link(FILENAME_PRODUCT_INFO, 'ID=' . $featured_products['store_id'] . '&products_id=' . $featured_products['products_id']) . '">More Info...</a>');

  new infoBox($info_box_contents);
$info_box_contents = array();
  $info_box_contents[] = array('align' => 'left',
                                'text'  => ' '
                              );
  new infoBoxDefault($info_box_contents, true, true);
//echo '</td>';


    $count ++;
    if ($count > 1) {
      $count = 0;
echo '</tr><tr>';

    }

  }

?>
<!-- default_specials_eof //-->