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
  <table border="0" width="100%" cellspacing="0" cellpadding="0"> 
      <tr> 
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0"> 
          <tr> 
         <td class="pageHeading"><?php echo HEADING_TITLE; ?></td> 
            <td align="right"></td> 
          </tr> 
        </table></td> 
      </tr> 
      <tr> 
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td> 
      </tr> 
      <tr> 
        <td> 
        <table border="0" width="100%" cellspacing="0" cellpadding="2"> 
        <tr class="productListing-heading"> 
        <td align="left" class="productListing-heading"><?php echo TABLE_HEADING_PRODUCTS; ?></td> 
        <td align="left" class="productListing-heading"><?php echo TABLE_HEADING_MODEL; ?></td> 
       <td align="center" class="productListing-heading"><?php echo TABLE_HEADING_MANUFACTURER; ?></td> 
       <td align="right" class="productListing-heading"><?php echo TABLE_HEADING_PRICE; ?>&nbsp;&nbsp;</td> 
       
  
       
       </tr> 
             <?php    
             
               
           
             
                             
          $languages_query = smn_db_query("select languages_id, name, code, image, directory from " . TABLE_LANGUAGES . " order by sort_order"); 
          while ($languages = smn_db_fetch_array($languages_query)) { 
            $languages_array[] = array('id' => $languages['languages_id'], 
                                       'name' => $languages['name'], 
                                       'code' => $languages['code'], 
                                       'image' => $languages['image'], 
                                       'directory'   => $languages['directory']); 
          } 
          for ($i=0; $i<sizeof($languages_array); $i++) {          
            $this_language_id = $languages_array[$i]['id']; 
            $this_language_name = $languages_array[$i]['name']; 
            $this_language_code = $languages_array[$i]['code']; 
            $this_language_image = $languages_array[$i]['image']; 
            $this_language_directory = $languages_array[$i]['directory']; 
				echo " <tr>\n";

          $products_query = smn_db_query("select p.store_id, p.products_id, p.products_model ,pd.products_name, p.products_price, p.products_tax_class_id, p.products_date_added, m.manufacturers_name from " . TABLE_PRODUCTS . " p left join " . TABLE_MANUFACTURERS . " m on p.manufacturers_id = m.manufacturers_id, " . TABLE_CATEGORIES . " c, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p2c.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' left join " . TABLE_SPECIALS . " s on pd.products_id = s.products_id where p.products_id = p2c.products_id and c.categories_id = p2c.categories_id and products_status = '1' order by pd.products_name");
                         
            $products_array = array(); 
            while($products = smn_db_fetch_array($products_query)) 
            { 
               $products_array[] = array('id'=> $products['products_id'], 
                             'name'    => $products['products_name'], 
                             'model'    => $products['products_model'], 
                             'manufacturer'  => $products['manufacturers_name'], 
                             'price'   => $products['products_price'], 
                             'store_id'     => $products['store_id'], 
                             'special' => $products['specials_new_products_price']); 
            } 
             
            $num_prods = sizeof($products_array);  // This optimizes that slow FOR loop... 
             
            for ($i = 0; $i < $num_prods; $i++)    // Traverse Rows 
            { 
               // Rotate Row Colors 
               if ($i % 2)  // Odd Row 
               { 
                  $row_col = 'class="productListing-odd"'; 
               } 
               else   // Guess... 
               { 
                  $row_col = 'class="productListing-even"'; 
               } 
                
						
               $this_id = $products_array[$i]['id']; 
               $this_name = $products_array[$i]['name']; 
               $this_model = $products_array[$i]['model']; 
               $this_manufacturer = $products_array[$i]['manufacturer']; 
               $this_price = $products_array[$i]['price']; 
               $this_special = $products_array[$i]['special']; 
               $this_store_id = $products_array[$i]['store_id']; 
               $this_url = smn_href_link(FILENAME_PRODUCT_INFO,  'name=' . urlencode($this_name). '&ID=' . $this_store_id . '&products_id=' . $this_id . (($this_language_code == DEFAULT_LANGUAGE) ? '' : ('&language=' . $this_language_code)), 'NONSSL', false); 

               echo "<tr $row_col>"; 
               echo "<td class='productListing-data' align='left'><a href='$this_url'>$this_name</a></td>"; 
               echo "<td class='productListing-data' align='left'><a href='$this_url'>$this_model</a></td>"; 
               echo "<td class='productListing-data' align='center'><a href='$this_url'>$this_manufacturer</a></td>"; 
               if (smn_not_null($this_special)) 
               { 
                  echo "<td class='productListing-data' align='right'><a href='$this_url'><span class='productSpecialPrice'>".$currencies->display_price($this_special, '')."</span></a></td>"; 
               } 
               else 
               { 
                  echo "<td class='productListing-data' align='right'><a href='$this_url'>".$currencies->display_price($this_price, '')."</a></td>"; 
               } 
               echo "</tr>\n"; 
            } 
         } 
?> 
            </td> 
          </tr> 
        </table></td> 
      </tr> 
      <tr> 
    <td align="right" class="main"><br><?php echo '<a href="' . smn_href_link(FILENAME_DEFAULT, '', 'NONSSL') . '">' . smn_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a>'; ?></td> 
      </tr> 
    </table>
