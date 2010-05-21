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
  <table cellpadding="3" cellspacing="0" border="0">
<?php
  if (class_exists('store_path')){
      $sp = new store_path($customer_store_id);
      if ($sp->get_store_path() == ''){
?>  
   <tr>
    <td colspan="2"><?php
     echo $sp->store_path_radio(false);
    ?><hr></td>
   </tr>
<?php
      }else{
?>
   <tr>
    <td class="main"><label for="storename"><?php echo ENTRY_STORE_PATH;?></label></td>
    <td class="main"><a href="<?php echo HTTP_SERVER . DIR_WS_CATALOG . $sp->get_store_path();?>" target="_blank"><?php echo $sp->get_store_path();?></a></td>
   </tr>
<?php      
      }
  }
?>     
   <tr>
    <td class="main"><label for="storename"><?php echo ENTRY_STORE_NAME;?></label></td>
    <td><?php echo smn_draw_input_field('storename', $customersStore->get_store_name(), 'id="storename"');?></td>
   </tr>
<?php
     if ($customersStore->get_store_logo() != ''){
         echo '   <tr>' . "\n" . 
              '    <td colspan="2" align="center">' . smn_image(DIR_WS_CATALOG_IMAGES . $customersStore->get_store_logo(), '150', '100') . '</td>' . "\n" . 
              '   </tr>';
     }
?>   
   <tr>
    <td class="main" valign="top"><label for="store_image"><?php echo TEXT_STORES_IMAGE;?></label></td>
    <td><?php
     echo smn_draw_file_field('store_image');
    ?></td>
   </tr>
   <tr>
    <td class="main"><label for="store_catagory"><?php echo ENTRY_CATAGORY;?></label></td>
    <td><?php echo smn_draw_pull_down_menu('store_catagory', $store_categories, $customersStore->get_store_category(), 'id="store_catagory"');?></td>
   </tr>
  </table>