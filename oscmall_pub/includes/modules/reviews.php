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
<table border="0" cellspacing="0" cellpadding="2">
<?php
  if (sizeof($reviews_array) < 1) {
?>
  <tr>
    <td class="main"><?php echo TEXT_NO_REVIEWS; ?></td>
  </tr>
<?php
  } else {
    for($i=0, $n=sizeof($reviews_array); $i<$n; $i++) {
      $store_images = 'images/'. $reviews_array[$i]['store_id'] . '_images/';
?>
  <tr>
    <td valign="top" class="main"><?php echo '<a href="' . tep_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'ID=' . $reviews_array[$i]['store_id'] . '&products_id=' . $reviews_array[$i]['products_id'] . '&reviews_id=' . $reviews_array[$i]['reviews_id']) . '">' . tep_image($store_images . $reviews_array[$i]['products_image'], $reviews_array[$i]['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a>'; ?></td>
    <td valign="top" class="main"><?php echo '<a href="' . tep_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'ID=' . $reviews_array[$i]['store_id'] . '&products_id=' . $reviews_array[$i]['products_id'] . '&reviews_id=' . $reviews_array[$i]['reviews_id']) . '"><b><u>' . $reviews_array[$i]['products_name'] . '</u></b></a> (' . sprintf(TEXT_REVIEW_BY, $reviews_array[$i]['authors_name']) . ', ' . sprintf(TEXT_REVIEW_WORD_COUNT, $reviews_array[$i]['word_count']) . ')<br>' . $reviews_array[$i]['review'] . '<br><br><i>' . sprintf(TEXT_REVIEW_RATING, tep_image($store_images . 'stars_' . $reviews_array[$i]['rating'] . '.gif', sprintf(TEXT_OF_5_STARS, $reviews_array[$i]['rating'])), sprintf(TEXT_OF_5_STARS, $reviews_array[$i]['rating'])) . '<br>' . sprintf(TEXT_REVIEW_DATE_ADDED, $reviews_array[$i]['date_added']) . '</i>'; ?></td>
  </tr>
<?php
      if (($i+1) != $n) {
?>
  <tr>
    <td colspan="2" class="main">&nbsp;</td>
  </tr>
<?php
      }
    }
  }
?>
</table>
