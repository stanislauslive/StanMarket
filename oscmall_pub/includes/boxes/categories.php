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

  $boxHeading = BOX_HEADING_VENDOR_CATEGORIES;
  $box_base_name = 'categories'; 
  $box_id = $box_base_name . 'Box';
  
 /*Added parameter $store_id in the function to get the store id in the url by Cimi on June 08,2007*/
  function smn_show_category($counter,$store_id) {
    global $foo, $boxContent , $id, $aa;
    for ($a=0; $a<$foo[$counter]['level']; $a++) {
      if ($a == $foo[$counter]['level']-1)
	  	{
		$boxContent .=  "<span class='subCat'>&nbsp;|_  </span>";
     	} else
	  		{
	  		$boxContent .=  "<span class='subCat'>&nbsp;&nbsp;</span>";
     		}
		}
    if ($foo[$counter]['level'] == 0){  
      if ($aa == 1){ 
		$boxContent  .= "";
      }else
		{$aa=1;}
	}
    $boxContent  .= '<a href="';
    if ($foo[$counter]['parent'] == 0) {
 /*Added  $store_id in $cPath_new to get the store id in the url by Cimi on June 08,2007*/
      $cPath_new = 'ID='.$store_id.'&cPath=' . $counter;
    } else {
 /*Added  $store_id in $cPath_new to get the store id in the url by Cimi on June 08,2007*/
      $cPath_new = 'ID='.$store_id.'&cPath=' . $foo[$counter]['path'];
    }
    $boxContent  .= smn_href_link(FILENAME_DEFAULT, $cPath_new);
    $boxContent  .= '">';
    if ( ($id) && (in_array($counter, $id)) ) {
      $boxContent  .= "<span class='subCat'>";
    }
// display category name
    $boxContent  .= $foo[$counter]['name'];
    if ( ($id) && (in_array($counter, $id)) ) {
      $boxContent  .= '</span>';
    }
    $boxContent  .= '</a>';
    $boxContent  .= '<br>';
    if ($foo[$counter]['next_id']) {
	 /*Added parameter $store_id in the function to get the store id in the url by Cimi on June 08,2007*/
      smn_show_category($foo[$counter]['next_id'],$store_id);
    } }
  $aa = 0;
  $boxContent  = '';
  $categories_query = smn_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '0' and c.categories_id = cd.categories_id and cd.language_id='" . $languages_id ."' and c.store_id = '" . $store_id . "' and cd.store_id = '" . $store_id . "' order by sort_order, cd.categories_name");
  while ($categories = smn_db_fetch_array($categories_query))  {
    $foo[$categories['categories_id']] = array(
                                        'name' => $categories['categories_name'],
                                        'parent' => $categories['parent_id'],
                                        'level' => 0,
                                        'path' => $categories['categories_id'],
                                        'next_id' => false
                                       );
    if (isset($prev_id)) {
      $foo[$prev_id]['next_id'] = $categories['categories_id'];
    }

    $prev_id = $categories['categories_id'];

    if (!isset($first_element)) {
      $first_element = $categories['categories_id'];
    }
  }
  //------------------------
  if ($cPath) {
    $new_path = '';
    $id = split('_', $cPath);
    reset($id);
    while (list($key, $value) = each($id)) {
      unset($prev_id);
      unset($first_id);
      $categories_query = smn_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . $value . "' and c.categories_id = cd.categories_id and cd.language_id='" . $languages_id ."' and c.store_id = '" . $store_id . "' and cd.store_id = '" . $store_id . "' order by sort_order, cd.categories_name");
      $category_check = smn_db_num_rows($categories_query);
      if ($category_check > 0) {
        $new_path .= $value;
        while ($row = smn_db_fetch_array($categories_query)) {
          $foo[$row['categories_id']] = array(
                                              'name' => $row['categories_name'],
                                              'parent' => $row['parent_id'],
                                              'level' => $key+1,
                                              'path' => $new_path . '_' . $row['categories_id'],
                                              'next_id' => false
                                             );
          if (isset($prev_id)) {
            $foo[$prev_id]['next_id'] = $row['categories_id'];
          }
          $prev_id = $row['categories_id'];
          if (!isset($first_id)) {
            $first_id = $row['categories_id'];
          }
          $last_id = $row['categories_id'];
        }
        $foo[$last_id]['next_id'] = $foo[$value]['next_id'];
        $foo[$value]['next_id'] = $first_id;
        $new_path .= '_';
      } else {
        break;
      }
    }
  }
/*Added parameter $store_id in the function to get the store id in the url by Cimi on June 08,2007*/
  smn_show_category($first_element,$store_id);

  if(file_exists(DIR_WS_BOX_TEMPLATES . $box_base_name . '.php')) {
      require(DIR_WS_BOX_TEMPLATES . $box_base_name . '.php');
  }else {
      require(DEFAULT_TEMPLATENAME_BOX);
  }

?>
