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

  global $page_name; 


    $page_query = smn_db_query("select a.text_content from " . TABLE_ARTICLES . " a, " . TABLE_DYNAMIC_PAGE_INDEX ." d  where d.page_name = '". $page_name ."' and d.page_id = a.page_id  and a.language_id = '". $languages_id ."'");
    $page_text = smn_db_fetch_array($page_query);
    define('TEXT_BODY', $page_text['text_content']);
    
  $breadcrumb->add(NAVBAR_TITLE, smn_href_link(FILENAME_INFORMATION .'?page_name='.$page_name));

?>