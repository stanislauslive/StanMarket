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

<?php

// do the manufacturers

 $manufacturers_product = "select manufacturers_id 
                           from products
                           where products_id = '" . $_GET['products_id'] . "'";
    $manufacturers_query  = smn_db_query($manufacturers_product);
          if (smn_db_num_rows($manufacturers_query)) {
    $manufacturers_array=smn_db_fetch_array($manufacturers_query);
       $sql = "select additional_description
               from additional_desc_info 
               where context = 'MANUFACTURER'
               and  context_value = '".$manufacturers_array['manufacturers_id']."'
               and  language = '$language' ";
          $res = mysql_query($sql);
       if (mysql_num_rows($res) > '0') {
      echo "".mysql_result($res,0)."<br>";

         }
  }



// Do the categories

 $categories_product  = "select categories_id
                         from products_to_categories
                         where products_id = '" . $_GET['products_id'] . "'";
    $categories_query  = smn_db_query($categories_product);
    if (smn_db_num_rows($categories_query)) {
 while ($category_array=smn_db_fetch_array($categories_query)){
       $sql = "select additional_description
               from additional_desc_info 
               where context = 'CATEGORY'
               and  context_value = '".$category_array['categories_id']."'
               and  language = '$language' ";
          $res = mysql_query($sql);
       if (mysql_num_rows($res) > '0') {
      echo "".mysql_result($res,0)."&nbsp;";

                                     }
			}
       }     

?>
<!-- additional_info_eof //-->
