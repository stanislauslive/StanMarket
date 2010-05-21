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
?>
<!-- articles //-->
<?php
    $boxHeading = BOX_HEADING_ARTICLES;
    $box_base_name = 'articles'; 
    $box_id = $box_base_name . 'Box';
    $boxContent = '';
    $articles_query = smn_db_query("select distinct page_name from " . TABLE_DYNAMIC_PAGE_INDEX ."  where page_type='articles' and store_id='" . $store_id ."' order by page_name");
// Display a drop-down
  while ($articles_values = smn_db_fetch_array($articles_query)){
    $name = str_replace('_', ' ', $articles_values['page_name']);
    $boxContent .= '<a href="'  . smn_href_link(FILENAME_ARTICLES, 'ID=1&type=' . $articles_values['page_name']) . '">' . $name . '</a><br>';
  }
    $boxContent .= smn_hide_session_id();
    $boxContent .= '<br><br>';
    
    if(file_exists(DIR_WS_BOX_TEMPLATES . $box_base_name . '.php')) {
      require(DIR_WS_BOX_TEMPLATES . $box_base_name . '.php');
    }else{
      require(DEFAULT_TEMPLATENAME_BOX);
    }
    $boxContent_attributes = '';
?>
<!-- articles_eof //-->