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
<!-- default_specials //-->

<tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>     
<?php
    $new = smn_db_query("select p.store_id, p.products_id, pd.products_name, pd.products_description, p.products_price, p.products_tax_class_id, p.products_image, s.specials_new_products_price from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_SPECIALS . " s where p.products_status = '1' and s.products_id = p.products_id and p.products_id = pd.products_id and pd.language_id = '" . $languages_id . "' and s.status = '1' order by s.specials_date_added DESC limit " . MAX_DISPLAY_SPECIAL_PRODUCTS);


  $count = 0;
  while ($default_specials = smn_db_fetch_array($new)) {

?>
    <td width="50%"><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="infoBoxHeading">
                        <img src="includes/classes/thema/<?php echo SITE_THEMA;?>/infobox/corner_left_right.gif" border="0"></td>
                        <td background="includes/classes/thema/<?php echo SITE_THEMA;?>/infobox/background_main.gif" width="100%" class="infoBoxHeading"><?php echo $default_specials['products_name'];?>
                        </td>
                        <td class="infoBoxHeading" nowrap>
                        <img src="includes/classes/thema/<?php echo SITE_THEMA;?>/infobox/corner_right_left.gif" border="0" ></td>
                      </tr>
                    </table>
<?php
$default_specials['products_description'] = smn_get_products_description($default_specials['products_id']);
    $default_specials['products_name'] = smn_get_products_name($default_specials['products_id']);
    $info_box_contents[] = array('align' => 'center',
                                            'text' => '<a href="' . smn_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $default_specials['products_id'] . '&ID=' .$default_specials['store_id']) . '">' . smn_image(DIR_WS_CATALOG_IMAGES . $default_specials['products_image'], $default_specials['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a></td><td><a href="' . smn_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $default_specials['products_id']) . '"></a></td><td align="center"><s>' . $currencies->display_price($default_specials['products_price'], smn_get_tax_rate($default_specials['products_tax_class_id'], '', '', $default_specials['store_id'])) . '</s><br><span class="productSpecialPrice">' . $currencies->display_price($default_specials['specials_new_products_price'], smn_get_tax_rate($default_specials['products_tax_class_id'], '', '', $default_specials['store_id'])).'</span><br><br><a href="' . smn_href_link(basename($PHP_SELF), smn_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $default_specials['products_id'], 'NONSSL') . '">' . smn_image_button('button_buy_now.gif') . '</a>&nbsp;<br></td><tr><td colspan="3" align="top" valign="top" height="100">'  . osc_trunc_string(strip_tags($default_specials['products_description'])) . '<br><br><a href="' . smn_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $default_specials['products_id']) . '">More Info...</a>
    '
);

  new infoBox($info_box_contents);
$info_box_contents = array();
  $info_box_contents[] = array('align' => 'left',
                                'text'  => ' '
                              );
  new infoBoxDefault($info_box_contents, true, true);

    $count ++;
    if ($count > 1) {
      $count = 0;
echo '</tr><tr>';

    }

  }

?>
</tr></table></td></tr>
<!-- default_specials_eof //-->