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


  define('PAGE_NAME' , FILENAME_ARTICLES);
  
  if (isset($_GET ['page_id'])){
    $page_query = smn_db_query("select text_content from " . TABLE_ARTICLES . " where page_id = '".$_GET ['page_id']."' and language_id = '" .$languages_id . "' and store_id='" . $store_id ."'");
    $page_text = smn_db_fetch_array($page_query);
    define('TEXT_BODY', $page_text['text_content']);
  }else{
        $page_query = smn_db_query("select d.page_id, d.page_name, d.page_type, a.page_title, a.date_modified  from " . TABLE_DYNAMIC_PAGE_INDEX . " d, " . TABLE_ARTICLES . " a where d.page_type='articles' and d.page_id = a.page_id and d.page_name='" . $page_name . "'and a.language_id ='". $languages_id ."' and d.store_id='" . $store_id ."' and a.store_id='" . $store_id ."' order by page_name");
    }

  $breadcrumb->add(NAVBAR_TITLE, smn_href_link(FILENAME_ARTICLES, 'type='. $page_name));

?>