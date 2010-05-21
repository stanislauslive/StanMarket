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
    <tr>
      <td><table width="100%">
       <tr>

<?php
    if (($product_info['products_image_sm_1'] != '') && ($product_info['products_image_xl_1'] == '')) {
?>
     <td align="center" class="smallText">
           <?php echo smn_image(DIR_WS_IMAGES . $product_info['products_image_sm_1'], $product_info['products_name'], ULT_THUMB_IMAGE_WIDTH, ULT_THUMB_IMAGE_HEIGHT, 'hspace="1" vspace="1"'); ?>
      </td>
<?php
    } elseif
       (($product_info['products_image_sm_1'] != '') && ($product_info['products_image_sm_1'] != '')) {
?>
     <td align="center" class="smallText">
      <script language="javascript"><!--
         document.write('<?php echo '<a href="javascript:popupWindow(\\\'' . smn_href_link(FILENAME_POPUP_IMAGE, 'pID=' . $product_info['products_id'] . '&image=1') . '\\\')">' . smn_image(DIR_WS_IMAGES . $product_info['products_image_sm_1'], addslashes($product_info['products_name']), ULT_THUMB_IMAGE_WIDTH, ULT_THUMB_IMAGE_HEIGHT, 'hspace="1" vspace="1"') . '<br>' . smn_image_button('image_enlarge.gif', TEXT_CLICK_TO_ENLARGE) . '</a>'; ?>');
//--></script>
         <noscript>
           <?php echo '<a href="' . smn_href_link(DIR_WS_IMAGES . $product_info['products_image_sm_1']) . '">' . smn_image(DIR_WS_IMAGES . $product_info['products_image_sm_1'], $product_info['products_name'], ULT_THUMB_IMAGE_WIDTH, ULT_THUMB_IMAGE_HEIGHT, 'hspace="1" vspace="1"') . '<br>' . smn_image_button('image_enlarge.gif', TEXT_CLICK_TO_ENLARGE) . '</a>'; ?>
          </noscript>
      </td>
<?php
    } elseif
      (($products_info['products_image_sm_1'] == '') && ($product_info['products_image_xl_1'] != '')) {
?>
     <td align="center" class="smallText">
           <?php echo smn_image(DIR_WS_IMAGES . $product_info['products_image_xl_1'], $product_info['products_name'], LARGE_IMAGE_WIDTH, LARGE_IMAGE_HEIGHT, 'hspace="1" vspace="1"'); ?>
      </td>
<?php
    }
?>

</tr>
<tr>

<?php
    if (($product_info['products_image_sm_2'] != '') && ($product_info['products_image_xl_2'] == '')) {
?>
     <td align="center" class="smallText">
           <?php echo smn_image(DIR_WS_IMAGES . $product_info['products_image_sm_2'], $product_info['products_name'], ULT_THUMB_IMAGE_WIDTH, ULT_THUMB_IMAGE_HEIGHT, 'hspace="1" vspace="1"'); ?>
      </td>
<?php
    } elseif
       (($product_info['products_image_sm_2'] != '') && ($product_info['products_image_sm_2'] != '')) {
?>
     <td align="center" class="smallText">
      <script language="javascript"><!--
         document.write('<?php echo '<a href="javascript:popupWindow(\\\'' . smn_href_link(FILENAME_POPUP_IMAGE, 'pID=' . $product_info['products_id'] . '&image=2') . '\\\')">' . smn_image(DIR_WS_IMAGES . $product_info['products_image_sm_2'], addslashes($product_info['products_name']), ULT_THUMB_IMAGE_WIDTH, ULT_THUMB_IMAGE_HEIGHT, 'hspace="1" vspace="1"') . '<br>' . smn_image_button('image_enlarge.gif', TEXT_CLICK_TO_ENLARGE) . '</a>'; ?>');
//--></script>
         <noscript>
           <?php echo '<a href="' . smn_href_link(DIR_WS_IMAGES . $product_info['products_image_sm_2']) . '">' . smn_image(DIR_WS_IMAGES . $product_info['products_image_sm_2'], $product_info['products_name'], ULT_THUMB_IMAGE_WIDTH, ULT_THUMB_IMAGE_HEIGHT, 'hspace="1" vspace="1"') . '<br>' . smn_image_button('image_enlarge.gif', TEXT_CLICK_TO_ENLARGE) . '</a>'; ?>
          </noscript>
      </td>
<?php
    } elseif
      (($products_info['products_image_sm_2'] == '') && ($product_info['products_image_xl_2'] != '')) {
?>
     <td align="center" class="smallText">
           <?php echo smn_image(DIR_WS_IMAGES . $product_info['products_image_xl_2'], $product_info['products_name'], LARGE_IMAGE_WIDTH, LARGE_IMAGE_HEIGHT, 'hspace="1" vspace="1"'); ?>
      </td>
<?php
    }
?>

</tr>
<tr>

<?php
    if (($product_info['products_image_sm_3'] != '') && ($product_info['products_image_xl_3'] == '')) {
?>
     <td align="center" class="smallText">
           <?php echo smn_image(DIR_WS_IMAGES . $product_info['products_image_sm_3'], $product_info['products_name'], ULT_THUMB_IMAGE_WIDTH, ULT_THUMB_IMAGE_HEIGHT, 'hspace="1" vspace="1"'); ?>
      </td>
<?php
    } elseif
       (($product_info['products_image_sm_3'] != '') && ($product_info['products_image_sm_3'] != '')) {
?>
     <td align="center" class="smallText">
      <script language="javascript"><!--
         document.write('<?php echo '<a href="javascript:popupWindow(\\\'' . smn_href_link(FILENAME_POPUP_IMAGE, 'pID=' . $product_info['products_id'] . '&image=3') . '\\\')">' . smn_image(DIR_WS_IMAGES . $product_info['products_image_sm_3'], addslashes($product_info['products_name']), ULT_THUMB_IMAGE_WIDTH, ULT_THUMB_IMAGE_HEIGHT, 'hspace="1" vspace="1"') . '<br>' . smn_image_button('image_enlarge.gif', TEXT_CLICK_TO_ENLARGE) . '</a>'; ?>');
//--></script>
         <noscript>
           <?php echo '<a href="' . smn_href_link(DIR_WS_IMAGES . $product_info['products_image_sm_3']) . '">' . smn_image(DIR_WS_IMAGES . $product_info['products_image_sm_3'], $product_info['products_name'], ULT_THUMB_IMAGE_WIDTH, ULT_THUMB_IMAGE_HEIGHT, 'hspace="1" vspace="1"') . '<br>' . smn_image_button('image_enlarge.gif', TEXT_CLICK_TO_ENLARGE) . '</a>'; ?>
          </noscript>
      </td>
<?php
    } elseif
      (($products_info['products_image_sm_3'] == '') && ($product_info['products_image_xl_3'] != '')) {
?>
     <td align="center" class="smallText">
           <?php echo smn_image(DIR_WS_IMAGES . $product_info['products_image_xl_3'], $product_info['products_name'], LARGE_IMAGE_WIDTH, LARGE_IMAGE_HEIGHT, 'hspace="1" vspace="1"'); ?>
      </td>
<?php
    }
?>



     </tr>
        </table></td>
     </tr>
<!-- // BOF MaxiDVD: Modified For Ultimate Images Pack! //-->
