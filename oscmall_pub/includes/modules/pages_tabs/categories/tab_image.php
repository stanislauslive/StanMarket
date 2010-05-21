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
 <table border="0" cellspacing="0" cellpadding="5" width="96%">
  <tr>
   <td class="main"><?php echo TEXT_PRODUCTS_IMAGE; ?></td>
   <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_file_field('products_image') . '<br>' . smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_image(DIR_WS_CATALOG_IMAGES . $pInfo->products_image) . smn_draw_hidden_field('products_previous_image', $pInfo->products_image); ?></td>
  </tr>
 </table>