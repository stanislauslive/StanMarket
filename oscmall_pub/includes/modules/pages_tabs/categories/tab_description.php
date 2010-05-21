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

 $langTabPanel = $jQuery->getPluginClass('tabs');
 $langTabPanel->setID('descriptionTabPane');
 for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
     $tabID = 'description-' . $languages[$i]['name'];
     $langTabPanel->addTab($tabID, smn_image(DIR_WS_CATALOG_LANGUAGES . 'images/' . $languages[$i]['image'], $languages[$i]['name']) . ' ' . $languages[$i]['name']);
     
     ob_start();
?>
 <table border="0" cellspacing="0" cellpadding="5" width="96%">
  <tr>
   <td class="main" valign="top"><?php TEXT_PRODUCTS_DESCRIPTION; ?></td>
  </tr>
  <tr>
   <td><table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
     <td class="main" valign="top" width="100%"><?php echo smn_draw_textarea_field('products_description[' . $languages[$i]['id'] . ']', 'soft', '70', '15', (isset($products_description[$languages[$i]['id']]) ? $products_description[$languages[$i]['id']] : smn_get_products_description($pInfo->products_id, $languages[$i]['id']))); ?></td>
    </tr>
   </table></td>
  </tr>
  <tr>
   <td colspan="2" class="main"><hr><?php echo TEXT_PRODUCT_METTA_INFO; ?></td>
  </tr>
  <tr>
   <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
  </tr>          
  <tr>
   <td class="main" valign="top"><?php echo TEXT_PRODUCTS_PAGE_TITLE; ?></td>
  </tr>
  <tr>
   <td><table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
     <td class="main" valign="top" width="100%"><?php echo smn_draw_textarea_field('products_head_title_tag[' . $languages[$i]['id'] . ']', 'soft', '70', '5', (isset($products_head_title_tag[$languages[$i]['id']]) ? $products_head_title_tag[$languages[$i]['id']] : smn_get_products_head_title_tag($pInfo->products_id, $languages[$i]['id']))); ?></td>
    </tr>
   </table></td>
  </tr>
  <tr>
   <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
  </tr>          
  <tr>
   <td class="main" valign="top"><?php echo TEXT_PRODUCTS_HEADER_DESCRIPTION; ?></td>
  </tr>
  <tr>
   <td><table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
     <td class="main" valign="top" width="100%"><?php echo smn_draw_textarea_field('products_head_desc_tag[' . $languages[$i]['id'] . ']', 'soft', '70', '5', (isset($products_head_desc_tag[$languages[$i]['id']]) ? $products_head_desc_tag[$languages[$i]['id']] : smn_get_products_head_desc_tag($pInfo->products_id, $languages[$i]['id']))); ?></td>
    </tr>
   </table></td>
  </tr>
  <tr>
   <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
  </tr>          
  <tr>
   <td class="main" valign="top"><?php echo TEXT_PRODUCTS_KEYWORDS; ?></td>
  </tr>
  <tr>
   <td><table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
     <td class="main" valign="top" width="100%"><?php echo smn_draw_textarea_field('products_head_keywords_tag[' . $languages[$i]['id'] . ']', 'soft', '70', '5', (isset($products_head_keywords_tag[$languages[$i]['id']]) ? $products_head_keywords_tag[$languages[$i]['id']] : smn_get_products_head_keywords_tag($pInfo->products_id, $languages[$i]['id']))); ?></td>
    </tr>
   </table></td>
  </tr>
 </table>
<?php
     $langTabContent = ob_get_contents();
     ob_end_clean();
 
     $langTabPanel->addTabContent($tabID, $langTabContent);
     unset($langTabContent);
 }
 echo $langTabPanel->output();
?> 