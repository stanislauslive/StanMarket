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
ob_start();
   global $page_name; 

  if (!smn_session_is_registered('customer_id')) {
    $navigation->set_snapshot();
    smn_redirect(smn_href_link(FILENAME_LOGIN, '', 'NONSSL'));
  }
  
   include("editor_complex.php");

  $languages = smn_get_languages();
    
if (($_GET ['type'])=='site_text'){
 $db_table = TABLE_WEB_SITE_CONTENT;
}else{
 $db_table = TABLE_ARTICLES;
}

            
  if ($_GET['action']) {
    switch ($_GET['action']) {
        
      case 'cancel':
        smn_redirect(smn_href_link(FILENAME_STORE_TEXT_EDITOR,'ID='.$store_id));
        break;
        
      case 'deleteconfirm':
       switch ($_GET['type']) {
            
        case 'articles':    
          $article_total_query = smn_db_query("select count(*) as total from " .TABLE_DYNAMIC_PAGE_INDEX . " where page_name = '" . $_GET['page_name'] . "' and store_id = '" . $store_id . "'");
          $article_query = smn_db_fetch_array($article_total_query);
          smn_db_query("delete from " . TABLE_DYNAMIC_PAGE_INDEX . " where page_id = '" . $_GET['page_id'] . "' and store_id = '" . $store_id . "'");
          smn_db_query("delete from " . TABLE_ARTICLES . " where page_id = '" . $_GET['page_id'] . "' and store_id = '" . $store_id . "'");          
         
          if ($article_query['total'] == '1') { //only one article in db table with page catagory, so delete the site text.... 
            $languages = smn_get_languages();
            for ($i = 0, $n = sizeof($languages); $i < $n; $i++){
              $language_id = $languages[$i]['id'];
              smn_db_query("delete from " . TABLE_WEB_SITE_CONTENT . " where page_name = '" . $_GET['page_name'] . "' and language_id='" . $language_id . "' and store_id = '" . $store_id . "'");
            }
          }
        break;
            
        case 'web_pages':    
            smn_db_query("delete from " . TABLE_ARTICLES . " where page_id= '" . $_GET['page_id']."' and store_id = '" . $store_id . "'");
            smn_db_query("delete from " . TABLE_DYNAMIC_PAGE_INDEX . " where page_id = '" . $_GET['page_id'] . "' and store_id = '" . $store_id . "'");
            $languages = smn_get_languages();
            for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
            $language_id = $languages[$i]['id'];
            smn_db_query("delete from " . TABLE_WEB_SITE_CONTENT . " where page_name = '" . $_GET['page_name'] . "' and store_id = '" . $store_id . "'");
            }
        break;
        
        case 'site_text':
        if ($_GET ['type'] == 'site_text') {
          smn_db_query("delete from " . TABLE_WEB_SITE_CONTENT . " where page_name = '" . $_GET['page_name'] . "' and text_key= '" . $_GET['text_key']."' and store_id = '" . $store_id . "'" );
        }
        break;
       }
        smn_redirect(smn_href_link(FILENAME_STORE_TEXT_EDITOR,'ID='.$store_id));
        break;
        
      case 'delete':
       if ($_GET ['type'] == 'site_text'){
        smn_redirect(html_entity_decode(smn_href_link(FILENAME_STORE_TEXT_EDITOR, 'action=confirmdelete&type='. $_GET ['type']. '&page_name=' .$_GET['page_name'] . '&text_key=' . $_GET['text_key'].'&ID='.$store_id)));
        }else{
        smn_redirect(html_entity_decode(smn_href_link(FILENAME_STORE_TEXT_EDITOR, 'action=confirmdelete&type=' . $_GET ['type']. '&page_id=' . $_GET['page_id']. '&page_name=' .$_GET['page_name'].'&ID='.$store_id)));
        }
        break;
    case 'new':    
            $new_page_array = array(array('text' => TEXT_NONE));
            if ($_GET ['type'] == 'site_text') {
              $new_page_query = smn_db_query("select distinct page_name from " . TABLE_WEB_SITE_CONTENT . " where store_id = '" . $store_id . "' order by page_name" );
            } else{
              $new_page_query = smn_db_query("select distinct page_name from " . TABLE_DYNAMIC_PAGE_INDEX . " where page_name = '". $_GET ['page_name']."'  and store_id = '" . $store_id . "' order by page_name" );
            }
            while ($new_page = smn_db_fetch_array($new_page_query)) {
              $page_name =  str_replace('_', ' ',  $new_page['page_name']);    
              $new_page_array[] = array('id' => $new_page['page_name'],
                                        'text' => $page_name);
            }
       // $pInfo = new objectInfo($new_page_array);
    break;
        
    case 'newsave':
      if (($_POST ['use_current_catagory']) != ''){
        $page_name = smn_db_prepare_input($_POST['use_current_catagory']);
        $store_page_title =  str_replace(' ', '_', $page_name);
      } elseif (($_POST ['new_catagory']) != ''){            
         $page_name = smn_db_prepare_input($_POST['new_catagory']);
         $store_page_title =  str_replace(' ', '_', $page_name);
        }
    if (($_GET ['type'])!='site_text'){ 
        $sql_index_page_data_array = array('page_id' => '',
                                            'page_name' => $store_page_title,
                                            'store_id' => $store_id,
                                            'page_type' => $_GET['type']);
         smn_db_perform(TABLE_DYNAMIC_PAGE_INDEX, $sql_index_page_data_array, 'insert'); 
         $page_id = smn_db_insert_id();      
         
        $languages = smn_get_languages();
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
         $language_id = $languages[$i]['id'];
        if (($_POST ['new_catagory']) != '') {
         $sql_navbar_data_array = array('page_name' => $store_page_title,
                                        'language_id' => $language_id,
                                        'store_id' => $store_id,
                                        'text_key' => 'NAVBAR_TITLE',
                                        'text_content' => smn_db_prepare_input($_POST['page_navbar'][$language_id]),
                                        'date_modified' => 'now()');                     
         $sql_heading_data_array = array('page_name' => $store_page_title,
                                         'language_id' => $language_id,
                                         'store_id' => $store_id,
                                         'text_key' =>'HEADING_TITLE',
                                         'text_content' => smn_db_prepare_input($_POST['page_header'][$language_id]),
                                         'date_modified' => 'now()');
         $sql_header_data_array = array('page_name' => $store_page_title,
                                        'language_id' => $language_id,
                                        'store_id' => $store_id,
                                        'text_key' =>'HEADER_TITLE',
                                        'text_content' => smn_db_prepare_input($_POST['page_heading'][$language_id]),
                                        'date_modified' => 'now()');
         smn_db_perform(TABLE_WEB_SITE_CONTENT, $sql_navbar_data_array, 'insert');
         smn_db_perform(TABLE_WEB_SITE_CONTENT, $sql_heading_data_array, 'insert');
         smn_db_perform(TABLE_WEB_SITE_CONTENT, $sql_header_data_array, 'insert');
        }
         $sql_page_data_array = array('page_id' => $page_id,
                                      'language_id' => $language_id,
                                      'store_id' => $store_id,
                                      'page_title' =>smn_db_prepare_input($_POST['page_title'][$language_id]),
                                      'text_content' => '',
                                      'date_modified' => 'now()');
         smn_db_perform($db_table, $sql_page_data_array, 'insert');
         }
        } elseif (($_GET ['type'])=='site_text'){
          $languages = smn_get_languages();
          for ($i = 0, $n = sizeof($languages); $i < $n; $i++){
            $language_id = $languages[$i]['id'];
            $sql_text_key_data_array = array('page_name' => $store_page_title,
                                             'language_id' => $language_id,
                                              'store_id' => $store_id,
                                              'text_key' =>  smn_db_prepare_input($_POST['text_key']),
                                              'text_content' => '',
                                              'date_modified' => 'now()');
          smn_db_perform(TABLE_WEB_SITE_CONTENT, $sql_text_key_data_array, 'insert');
          }
        smn_redirect(html_entity_decode(smn_href_link(FILENAME_STORE_TEXT_EDITOR, 'page_name=' .$store_page_title . '&action=edit' . '&type=' . $_GET ['type'] . '&text_key=' . $_POST['text_key'].'&ID='.$store_id)));
        break;
        }
        smn_redirect(html_entity_decode(smn_href_link(FILENAME_STORE_TEXT_EDITOR, 'page_id=' .$page_id . '&action=edit' . '&type=' . $_GET ['type'].'&ID='.$store_id)));
      break; 
      case 'save':
        $languages = smn_get_languages();
        if ($_GET ['type'] =='site_text'){
          for ($i = 0, $n = sizeof($languages); $i < $n; $i++){
            $language_id = $languages[$i]['id'];
            $sql_data_array = array('text_content' => addslashes($_POST['file_content'][$language_id]),
                                    'date_modified' => 'now()');
            smn_db_perform($db_table, $sql_data_array,'update', "page_name='" .  $_POST['page_name'] . "' and text_key='" . $_POST['text_key'] . "' and language_id='" . $language_id . "' and store_id = '" . $store_id . "'");
         }
        }elseif ($_GET ['type'] =='save_mainpage'){
          for ($i = 0, $n = sizeof($languages); $i < $n; $i++){
            $language_id = $languages[$i]['id'];
            $store_description = addslashes($_POST['mainpage']);
             smn_db_query("update " . TABLE_STORE_DESCRIPTION . " set store_description = '" . $store_description. "' where language_id='" . $language_id . "' and store_id = '" . $store_id . "'");                        
          }
        }else{
        $languages = smn_get_languages();
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++){
          $language_id = $languages[$i]['id'];
          $sql_data_array = array('text_content' => addslashes($_POST['file_content'][$language_id]),
                                  'date_modified' => 'now()');
            smn_db_perform($db_table, $sql_data_array,'update', "page_id='" . $_POST['page_id'] . "' and language_id='" . $language_id . "' and store_id = '" . $store_id . "'");
          }
        }
         smn_redirect(smn_href_link(FILENAME_STORE_TEXT_EDITOR,'ID='.$store_id));
      break;    
    }
  }





  $breadcrumb->add(NAVBAR_TITLE, smn_href_link(FILENAME_STORE_TEXT_EDITOR, 'ID='.$store_id, 'NONSSL'));
?>