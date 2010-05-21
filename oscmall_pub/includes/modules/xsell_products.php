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
*/

if ($_GET['products_id']) { 
$xsell_query = smn_db_query("select distinct p.store_id, p.products_id, p.products_image, pd.products_name, p.products_tax_class_id, products_price from " . TABLE_PRODUCTS_XSELL . " xp, " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.store_id = '". $store_id ."' and  xp.products_id = '" . $_GET['products_id'] . "' and xp.xsell_id = p.products_id and p.products_id = pd.products_id and pd.language_id = '" . $languages_id . "' and p.products_status = '1' order by xp.products_id asc limit " . MAX_DISPLAY_ALSO_PURCHASED); 
$num_products_xsell = smn_db_num_rows($xsell_query); 
if ($num_products_xsell >= MIN_DISPLAY_XSELL) { 
?> 
<!-- xsell_products //-->
<?php
      $info_box_contents = array();
      $info_box_contents[] = array('align' => 'left', 'text' => TEXT_XSELL_PRODUCTS);
      new contentBoxHeading($info_box_contents);

      $row = 0;
      $col = 0;
      $info_box_contents = array();
      while ($xsell = smn_db_fetch_array($xsell_query)) {
        $xsell['specials_new_products_price'] = smn_get_products_special_price($xsell['products_id']); 
	$store_images = 'images/'. $xsell['store_id'] . '_images/';
	
if ($xsell['specials_new_products_price']) { 
      $xsell_price =  '<s>' . $currencies->display_price($xsell['products_price'], smn_get_tax_rate($xsell['products_tax_class_id'], '', '', $xsell['store_id'])) . '</s><br>'; 
      $xsell_price .= '<span class="productSpecialPrice">' . $currencies->display_price($xsell['specials_new_products_price'], smn_get_tax_rate($xsell['products_tax_class_id'], '', '', $xsell['store_id'])) . '</span>'; 
    } else { 
      $xsell_price =  $currencies->display_price($xsell['products_price'], smn_get_tax_rate($xsell['products_tax_class_id'], '', '', $xsell['store_id'])); 
    } 
        $info_box_contents[$row][$col] = array('text' => '<TABLE><TR><TD align="center" class="infoBoxContents" width="100"><div align="left">
 					    <a href="' . smn_href_link(FILENAME_PRODUCT_INFO, 'ID=' . $xsell['store_id'] . '&products_id=' . $xsell['products_id']) . '">' . smn_image($store_images . $xsell['products_image'], $xsell['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a></TD><TD class="infoBoxContents">
					    <a href="' . smn_href_link(FILENAME_PRODUCT_INFO, 'ID=' . $xsell['store_id'] . '&products_id=' . $xsell['products_id']) . '</a><br>'. TEXT_PRICE_SOLO .'<br>' . $currencies->display_price($xsell['products_price'], smn_get_tax_rate($xsell['products_tax_class_id'], '', '', $xsell['store_id'])) . '</div></td></tr></table>');
        $col ++;
        if ($col > 0) {
          $col = 0;
          $row ++;
        }
      }
      new contentBox($info_box_contents);
   
$info_box_contents = array(); 
  $info_box_contents[] = array('align' => 'left', 
                                'text'  => ' ' 
                              ); 
  new infoBoxDefault($info_box_contents, true, true);
?>
<!-- xsell_products_eof //-->




<?php
    }
  }
?>
