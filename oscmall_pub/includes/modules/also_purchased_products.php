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

  if (isset($_GET['products_id'])) {
    $orders_query = smn_db_query("select p.store_id, p.products_id, p.products_image from " . TABLE_ORDERS_PRODUCTS . " opa, " . TABLE_ORDERS_PRODUCTS . " opb, " . TABLE_ORDERS . " o, " . TABLE_PRODUCTS . " p where opa.products_id = '" . (int)$_GET['products_id'] . "' and opa.orders_id = opb.orders_id and opb.products_id != '" . (int)$_GET['products_id'] . "' and opb.products_id = p.products_id and opb.orders_id = o.orders_id and p.products_status = '1' group by p.products_id order by o.date_purchased desc limit " . MAX_DISPLAY_ALSO_PURCHASED);
    $num_products_ordered = smn_db_num_rows($orders_query);
    if ($num_products_ordered >= MIN_DISPLAY_ALSO_PURCHASED) {
?>
<!-- also_purchased_products //-->
<table border="0" width="100%" cellspacing="0" cellpadding="0">
			<tr>
			    <td class="infoBoxHeading" width="100%"><?php echo TEXT_ALSO_PURCHASED_PRODUCTS ?></td>
			</tr>
		    </table>
<?php
      $info_box_contents = array();
      $info_box_contents[] = array('text' => TEXT_ALSO_PURCHASED_PRODUCTS);

      //new contentBoxHeading($info_box_contents);

      $row = 0;
      $col = 0;
      $info_box_contents = array();
      while ($orders = smn_db_fetch_array($orders_query)) {
        $orders['products_name'] = smn_get_products_name($orders['products_id']);
        $info_box_contents[$row][$col] = array('align' => 'center',
                                               'params' => 'class="smallText" width="33%" valign="top"',
                                               'text' => '<a href="' . smn_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $orders['products_id'] . '&ID=' . $orders['store_id']) . '">' . smn_image(DIR_WS_CATALOG_IMAGES . $orders['products_image'], $orders['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a><br><a href="' . smn_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $orders['products_id']. '&ID=' . $orders['store_id']) . '">' . $orders['products_name'] . '</a>');

        $col ++;
        if ($col > 0) {
          $col = 0;
          $row ++;
        }
      }

      new contentBox($info_box_contents); 
   
	$info_box_contents = array(); 
  	$info_box_contents[] = array('align' => 'left', 
                                'text'  => '&nbsp;' 
                              ); 
  //new infoBoxDefault($info_box_contents, true, true);
?>
<!-- also_purchased_products_eof //-->
<?php
    }
  }
?>
