<?php
/*
  Copyright (c) 2002 - 2005 SystemsManager.Net
  SystemsManager Technologies
  oscMall System Version 4
  http://www.systemsmanager.net
  
  Portions Copyright (c) 2002 osCommerce
  
  This source file is subject to version 2.0 of the GPL license,   
  that is bundled with this package in the file LICENSE. If you
  did not receive a copy of the oscMall System license and are unable 
  to obtain it through the world-wide-web, please send a note to    
  license@systemsmanager.net so we can mail you a copy immediately. 
 
  Portions Copyright (c) 2003 Suomedia - Dynamic Content Management
    
*/

  $listing_split = new splitPageResults($master_sql, MAX_DISPLAY_SEARCH_RESULTS, 'products_master');
   


  if ( ($listing_split->number_of_rows > 0) && ( (MASTER_PREV_NEXT_BAR_LOCATION == '1') || (MASTER_PREV_NEXT_BAR_LOCATION == '3') ) ) {


?>


<table border="0" width="100%" cellspacing="0" cellpadding="2">
  <tr>
    <td class="smallText"><?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></td>
    <td class="smallText" align="right"><?php echo TEXT_RESULT_PAGE . ' ' . $listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, smn_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>
  </tr>
</table>
<?php
  }


  
  $list_box_contents = array();

  for ($col=0, $n=sizeof($column_list); $col<$n; $col++) {
    switch ($column_list[$col]) {
      case 'MASTER_LIST_MODEL':
        $lc_text = TABLE_HEADING_MODEL;
        $lc_align = '';
        break;
      case 'MASTER_LIST_NAME':
        $lc_text = TABLE_HEADING_PRODUCTS;
        $lc_align = '';
        break;
      case 'MASTER_LIST_DESCRIPTION':
        $lc_text = TABLE_HEADING_DESCRIPTION;
        $lc_align = 'center';
        break;
      case 'MASTER_LIST_ATTRIBUTES':
        $lc_text = TABLE_HEADING_ATTRIBUTES;
        $lc_align = 'center';
        break;                
      case 'MASTER_LIST_MANUFACTURER':
        $lc_text = TABLE_HEADING_MANUFACTURER;
        $lc_align = '';
        break;
      case 'MASTER_LIST_QUANTITY':
        $lc_text = TABLE_HEADING_QUANTITY;
        $lc_align = 'right';
        break;
      case 'MASTER_LIST_IMAGE':
        $lc_text = TABLE_HEADING_IMAGE;
        $lc_align = 'center';
        break;

    }

    if (  ($column_list[$col] != 'MASTER_LIST_IMAGE' && ($column_list[$col] != 'MASTER_LIST_MULTIPLE' && ($column_list[$col] != 'MASTER_LIST_DESCRIPTION'))) ) {
      $lc_text = smn_create_sort_heading($_GET['sort'], $col+1, $lc_text);
    }

    $list_box_contents[0][] = array('align' => $lc_align,
                                    'params' => 'class="productListing-heading"',
                                    'text' => '&nbsp;' . $lc_text . '&nbsp;');
  }

  if ($listing_split->number_of_rows > 0) {
    $rows = 0;
    $master_query = smn_db_query($listing_split->sql_query);
    while ($listing = smn_db_fetch_array($master_query)) {
      $rows++;

      if (($rows/2) == floor($rows/2)) {
        $list_box_contents[] = array('params' => 'class="productListing-even"');
      } else {
        $list_box_contents[] = array('params' => 'class="productListing-odd"');
      }

      $cur_row = sizeof($list_box_contents) - 1;

      for ($col=0, $n=sizeof($column_list); $col<$n; $col++) {
        $lc_align = '';
        $lc_params = '';
        $listing_product_type = $cart->check_product_type((int)$listing['products_id']);
        switch ($column_list[$col]) {
          case 'MASTER_LIST_MODEL':
            $lc_align = '';
            $lc_text = '&nbsp;' . $listing['products_model'] . '&nbsp;';
            break;
          case 'MASTER_LIST_NAME':
            $lc_align = '';
            if (isset($_GET['manufacturers_id'])) {
              $lc_text = '<a href="' . smn_href_link(FILENAME_PRODUCT_INFO, 'manufacturers_id=' . $_GET['manufacturers_id'] . '&products_id=' . $listing['products_id']) . '">' . $listing['products_name'] . '</a>';
            }elseif ($listing_product_type == 'date_price') {
              $lc_text = '&nbsp;<a href="' .  smn_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $listing['products_id'] .'&action=custom_dates') . '">' . $listing['products_name'] . '</a>&nbsp;' ;
            } elseif ($listing_product_type == 'price_mod') {
              $lc_text = '&nbsp;<a href="' .  smn_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $listing['products_id'] .'&action=selected_dates') . '">' . $listing['products_name'] . '</a>&nbsp;';
            } else {
              $lc_text = '&nbsp;<a href="' .  smn_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $listing['products_id']) . '">' . $listing['products_name'] . '</a>&nbsp;';
            }
            break;
          case 'MASTER_LIST_DESCRIPTION':
            $lc_align = '';
            $lc_text = '&nbsp;' . osc_trunc_string(strip_tags($listing['products_description'], '<a><b><em><font><i><s><span><strong><sub><sup><u>'), MASTER_LIST_DESCRIPTION_LENGTH) . '&nbsp;';

            break;            
          case 'MASTER_LIST_MANUFACTURER':
            $lc_align = '';
            $lc_text = '&nbsp;<a href="' . smn_href_link(FILENAME_DEFAULT, 'manufacturers_id=' . $listing['manufacturers_id']) . '">' . $listing['manufacturers_name'] . '</a>&nbsp;';
            break;
          case 'MASTER_LIST_PRICE':
            $lc_align = 'right';
            if (smn_not_null($listing['specials_new_products_price'])) {
              $lc_text = '&nbsp;<s>' .  $currencies->display_price($listing['products_price'], smn_get_tax_rate($listing['products_tax_class_id'], '', '', $listing['store_id'])) . '</s>&nbsp;&nbsp;<span class="productSpecialPrice">' . $currencies->display_price($listing['specials_new_products_price'], smn_get_tax_rate($listing['products_tax_class_id'], '', '', $listing['store_id'])) . '</span>&nbsp;';
            } else {
              $lc_text = '&nbsp;' . $currencies->display_price($listing['products_price'], smn_get_tax_rate($listing['products_tax_class_id'], '', '', $listing['store_id'])) . '&nbsp;';
            }
            break; 
          case 'MASTER_LIST_QUANTITY':
            $lc_align = 'center';
            $lc_text = '&nbsp;' . $listing['products_quantity'] . '&nbsp;';
            break;
          case 'MASTER_LIST_WEIGHT':
            $lc_align = 'right';
            $lc_text = '&nbsp;' . $listing['products_weight'] . '&nbsp;';
            break;
          case 'MASTER_LIST_IMAGE':
            $lc_align = 'center';
            if (isset($_GET['manufacturers_id'])) {
              $lc_text = '<a href="' . smn_href_link(FILENAME_PRODUCT_INFO, 'manufacturers_id=' . $_GET['manufacturers_id'] . '&products_id=' . $listing['products_id']) . '">' . smn_image(DIR_WS_IMAGES . $listing['products_image'], $listing['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a>';
            } else {
              $lc_text = '&nbsp;<a href="' . smn_href_link(FILENAME_PRODUCT_INFO, ($cPath ? 'cPath=' . $cPath . '&' : '') . 'products_id=' . $listing['products_id']) . '">' . smn_image(DIR_WS_IMAGES . $listing['products_image'], $listing['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a>&nbsp;';
            }
            break;
          
        } 

        $list_box_contents[$cur_row][] = array('align' => $lc_align,
                                               'valign' => $lc_valign,
                                               'params' => 'class="productListing-data"',
                                               'text'  => $lc_text);
      }
    }

    new productListingBox($list_box_contents);
  } else {
    $list_box_contents = array();

    $list_box_contents[0] = array('params' => 'class="productListing-odd"');
    $list_box_contents[0][] = array('params' => 'class="productListing-data"',
                                   'text' => TEXT_NO_PRODUCTS);

    new productListingBox($list_box_contents);
  }
?>
     <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>

     </table>
<?php
  if ( ($listing_split->number_of_rows > 0) && ((MASTER_PREV_NEXT_BAR_LOCATION == '2') || (MASTER_PREV_NEXT_BAR_LOCATION == '3')) ) {
?>     
     <table border="0" width="100%" cellspacing="0" cellpadding="2">          
     <tr>
        <td class="smallText"><?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></td>
        <td class="smallText" align="right"><?php echo TEXT_RESULT_PAGE . ' ' . $listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, smn_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>
     </tr>
    </table>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>

<?php
  }
?>