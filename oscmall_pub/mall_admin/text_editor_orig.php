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

  require('includes/application_top.php');
  $languages = smn_get_languages();
    
if (($_GET ['type'])=='site_text'){
 $db_table = TABLE_WEB_SITE_CONTENT;
}else{
 $db_table = TABLE_ARTICLES;
}

            
  if ($_GET['action']) {
    switch ($_GET['action']) {
        
      case 'cancel':
        smn_redirect(smn_href_link(FILENAME_TEXT_EDITOR));
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
        smn_redirect(smn_href_link(FILENAME_TEXT_EDITOR));
        break;
        
      case 'delete':
       if ($_GET ['type'] == 'site_text'){
        smn_redirect(smn_href_link(FILENAME_TEXT_EDITOR, 'action=confirmdelete&type='. $_GET ['type']. '&page_name=' .$_GET['page_name'] . '&text_key=' . $_GET['text_key']));
        }else{
        smn_redirect(smn_href_link(FILENAME_TEXT_EDITOR, 'action=confirmdelete&type=' . $_GET ['type']. '&page_id=' . $_GET['page_id']. '&page_name=' .$_GET['page_name']));
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
        $pInfo = new objectInfo($new_page_array);
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
        smn_redirect(smn_href_link(FILENAME_TEXT_EDITOR, 'page_name=' .$store_page_title . '&action=edit' . '&type=' . $_GET ['type'] . '&text_key=' . $_POST['text_key']));
        break;
        }
        smn_redirect(smn_href_link(FILENAME_TEXT_EDITOR, 'page_id=' .$page_id . '&action=edit' . '&type=' . $_GET ['type']));
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
         smn_redirect(smn_href_link(FILENAME_TEXT_EDITOR));
      break;    
    }
  }
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<!-- ---------------------------------------------------------------------- -->
<!-- START : EDITOR HEADER - INCLUDE THIS IN ANY FILES USING EDITOR -->

<?php if (($request_type == 'NONSSL')) {
   include(DIR_FS_ADMIN . "editor_complex.php");
}else{
  @include(HTTPS_CATALOG_SERVER . DIR_WS_ADMIN . "editor_complex.php");
  }
?>

<style type="text/css"><!--
  .btn   { BORDER-WIDTH: 1; width: 26px; height: 24px; }
  .btnDN { BORDER-WIDTH: 1; width: 26px; height: 24px; BORDER-STYLE: inset; BACKGROUND-COLOR: buttonhighlight; }
  .btnNA { BORDER-WIDTH: 1; width: 26px; height: 24px; filter: alpha(opacity=25); }
--></style>
<!-- END : EDITOR HEADER -->
<!-- ---------------------------------------------------------------------- -->
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </table></td>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
            <td class="pageHeading"><?php echo HEADING_TITLE . '<br><span class="smallText">' . $_POST['?page_name'] . '</span>'; ?></td>
            <td class="pageHeading" align="right"><?php echo smn_draw_separator('pixel_trans.gif', '1', HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
<?php 
  if ($_GET['action'] == 'confirmdelete'){
   /*comfirm the deletion of the article, web page or page text..........
 
 delete the site text
 delete  site information page
 delete  article
 */
      if (($_GET ['type']=='web_pages')  || ($_GET ['type']=='articles')){
        $page_delete_raw = ("select d.page_name, d.page_type, a.page_title, a.date_modified  from " . TABLE_DYNAMIC_PAGE_INDEX . " d, " . TABLE_ARTICLES . " a where  a.page_id='" . $_GET ['page_id'] . "' and a.language_id ='". $languages_id ."' and a.store_id = '" . $store_id . "' and d.store_id = '" . $store_id . "'");
        $page_query = smn_db_query($page_delete_raw);
        $page_delete = smn_db_fetch_array($page_query);  
      }else{
        $text_delete_raw = ("select * from " . $db_table . " where text_key = '" . $_GET ['text_key'] . "' and page_name='" . $_GET ['page_name'] . "'and store_id = '" . $store_id . "'");
        $text_query = smn_db_query($text_delete_raw);
        $text_delete = smn_db_fetch_array($text_query);  
      }
 
?>
  <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>          
          <tr class="dataTableHeadingRow">
            <td class="dataTableHeadingContent"><?php echo TEXT_SITE_DELETE_HEADING; ?></td><td></td>
          </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="70%" cellspacing="0" cellpadding="20">
          <tr>
            <td valign="top">
            <table align="center" border="0" width="70%" cellspacing="0" cellpadding="2">
         </tr>
        <tr class="dataTableHeadingRow">
            <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_DELETE; ?></td>
        </tr>
               
               
<?php
if (($_GET ['type']=='web_pages')  || ($_GET ['type']=='articles')){
?>
        <tr>
          <td align="left" class="main"><?php  echo 'Delete Page :' . $page_delete['page_name']; ?> </td>
        </tr>
        <tr>
          <td align="left" class="main"><?php  echo  'With Page Title :' . $page_delete['page_title']; ?> </td>
        </tr>
        <tr>
          <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>
        </tr>
        <tr>
          <td align="center" class="main"><?php  echo '<a href="' . smn_href_link(FILENAME_TEXT_EDITOR, 'action=deleteconfirm&type=' . $_GET ['type']. '&page_id=' . $_GET['page_id']. '&page_name=' . $_GET['page_name'] ) . '">' . smn_image_button('button_delete.gif', IMAGE_DELETE) . '</a>' . '&nbsp;&nbsp;' . '<a href="' . smn_href_link(FILENAME_TEXT_EDITOR) . '">' . smn_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>'; ?></td>
        </tr>
        <tr>
          <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>
        </tr>
        <tr>
          <td align="center" class="smallText"><a href="http://www.systemsmanager.net"><br><b>Copyright &copy; 2005 SystemsManager Technologies</b></a></td>
        </tr>
    </table></td>
<?php
}else{
?>
<table align="center" border="0" width="70%" cellspacing="0" cellpadding="2">
        <tr>
          <td align="left" class="main"><?php  echo 'Delete Text Key :' ; ?> </td><td align="left" class="main"> <?php echo $text_delete['text_key']; ?> </td>
        </tr>
        <tr>
          <td align="left" class="main"><?php  echo 'On Page :' ; ?> </td><td align="left" class="main"> <?php echo $text_delete['page_name']; ?> </td>
        </tr>
         <tr>
          <td align="left" class="main"><?php  echo 'With The following Text :' ; ?> </td><td align="left" class="main"> <?php echo $text_delete['text_content']; ?> </td>
        </tr>
        <tr>
          <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>
        </tr>
      </table>
        <tr>   
          <td align="center" class="main"><?php  echo '<a href="' . smn_href_link(FILENAME_TEXT_EDITOR, 'action=deleteconfirm&type='. $_GET ['type']. '&page_name=' .$_GET['page_name'] . '&text_key=' . $_GET['text_key']) . '">' . smn_image_button('button_delete.gif', IMAGE_DELETE) . '</a>' . '&nbsp;&nbsp;' . '<a href="' . smn_href_link(FILENAME_TEXT_EDITOR) . '">' . smn_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>'; ?></td>
        </tr>
        <tr>
          <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>
        </tr>
        <tr>
          <td align="center" class="smallText"><a href="http://www.systemsmanager.net"><br><b>Copyright &copy; 2005 SystemsManager Technologies</b></a></td>
        </tr>
    </table></td>
<?php     
      }
  }
 if (($_GET['action'] != 'confirmdelete') && ($_GET['action'] != 'edit') && ($_GET['action'] != 'new') && (!isset ($_GET ['page_name'])) && (!isset ($_GET ['type']))){
 /*find which operation to perform from the following choices
 
 edit the site text
 edit site information pages
 edit articles
 */
?>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>          
      <tr>
      <tr>
        <td class="main"><?php echo TEXT_SITE_INTRO_HEADING; ?></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="70%" cellspacing="0" cellpadding="20">
          <tr>
            <td valign="top"><table align="center" border="0" width="70%" cellspacing="0" cellpadding="2">
         </tr>
          <tr class="dataTableHeadingRow">
            <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_INTRO; ?></td>
          </tr>
<?php 
      echo '<tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . smn_href_link(FILENAME_TEXT_EDITOR, 'type=site_text').'\'">' . "\n";
      echo '  <td class="dataTableContent" align="left">Web Site Text Editor &nbsp;</td> ';
      echo '</tr>';
      echo '<tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . smn_href_link(FILENAME_TEXT_EDITOR, 'type=web_pages') . '\'">' . "\n";
      echo '  <td class="dataTableContent" align="left">Web Site Information Pages &nbsp;</td> ';
      echo '</tr>';
      echo '<tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . smn_href_link(FILENAME_TEXT_EDITOR, 'type=articles') .'\'">' . "\n";
      echo '  <td class="dataTableContent" align="left">Web Articles &nbsp;</td> ';
      echo '</tr>';
      echo '<tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . smn_href_link(FILENAME_TEXT_EDITOR, 'type=mainpage') .'\'">' . "\n";
      echo '  <td class="dataTableContent" align="left">Store Description &nbsp;</td> ';
      echo '</tr>';
?>
            <tr>
              <td align="center" class="smallText"><a href="http://www.systemsmanager.net"><br><b>Copyright &copy; 2005 SystemsManager Technologies</b></a></td>
            </tr>
          </table></td>

<?php
  }
  if (($_GET['action'] != 'confirmdelete') && ($_GET['action'] != 'edit') && ($_GET['action'] != 'new') && (!isset ($_GET ['page_name'])) && (($_GET ['type'])=='site_text')){
  /* editing the site text.......find out which page of  site text to edit.....*/ 
?>
  <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>          
          <tr>
            <td class="main"><?php echo TEXT_SITE_INFO_HEADING; ?></td>
          </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="70%" cellspacing="0" cellpadding="20">
          <tr>
            <td valign="top"><table align ="center" border="0" width="100%" cellspacing="0" cellpadding="2">
         </tr>
             
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_GROUP; ?></td>
               </tr>
<?php 
$page_query_raw = ("select distinct page_name from " . TABLE_WEB_SITE_CONTENT . " where language_id ='". $languages_id ."' and store_id = '" . $store_id . "'order by page_name" );
$page_query = smn_db_query($page_query_raw);
      while ($page_list_query = smn_db_fetch_array($page_query)){
	$page_name =  str_replace('_', ' ', $page_list_query['page_name']);
	$contents[] = array('name' => $page_name);	 
	for ($i=0; $i<sizeof($contents); $i++){
          $tInfo = new objectInfo($contents[$i]);
      }

    if ($page_name) {
      echo '<tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . smn_href_link(FILENAME_TEXT_EDITOR, 'page_name=' .$page_list_query['page_name'] .'&type=site_text') . '\'">' . "\n";
      echo '<td class="dataTableContent" align="left">' . nl2br($page_name).'&nbsp;</td> ';
      echo '</tr>';
    }
  }
?>
             <tr>
            <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>
            </tr>
            <tr>
                <td align="right" class="main"><?php  echo '<a href="' . smn_href_link(FILENAME_TEXT_EDITOR) . '">' . smn_image_button('button_back.gif', IMAGE_BACK) . '</a>&nbsp;&nbsp;<a href="' . smn_href_link(FILENAME_TEXT_EDITOR, 'action=new&type=' . $_GET ['type']) . '">' . smn_image_button('button_insert.gif', IMAGE_INSERT) . '</a>'; ?></td>
            </tr>
            <tr>
            <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>
            </tr>
            <tr>
                <td align="center" class="smallText"><a href="http://www.systemsmanager.net"><br><b>Copyright &copy; 2005 SystemsManager Technologies</b></a></td>
            </tr>   
            </table></td>
<?php
  }elseif (($_GET['action'] != 'confirmdelete') && ($_GET['action'] != 'edit') && ($_GET['action'] != 'new') && (!isset ($_GET ['page_name'])) && (($_GET ['type'])=='web_pages'  || ($_GET ['type'])=='articles')){
/*  if the choice is to edit web pages or articles find out page to edit......*/
?>
  <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>          
          <tr>
            <td class="main"><?php echo TEXT_SITE_INFO_PAGE_HEADING; ?></td><td></td>
          </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="20">
          <tr>
            <td valign="top"><table align="center" border="0" width="90%" cellspacing="0" cellpadding="2">
         </tr>
             
              <tr class="dataTableHeadingRow">
               <td class="dataTableHeadingContent" width="20%"><?php echo TABLE_HEADING_PAGE_NAME; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_TEXT_TITLE; ?></td>
                <td class="dataTableHeadingContent" width="20%"><?php echo TABLE_HEADING_LAST_MODIFIED; ?></td>
                </tr>
               
<?php               
$page_name_query_raw = ("select a.page_id, d.page_name, d.page_type, a.page_title, a.date_modified  from " . TABLE_DYNAMIC_PAGE_INDEX . " d, " . TABLE_ARTICLES . " a where d.page_type='" . $_GET ['type'] . "' and d.page_id = a.page_id and a.language_id ='". $languages_id ."'and a.store_id = '" . $store_id . "'and d.store_id = '" . $store_id . "'  order by page_name");
$page_name_query = smn_db_query($page_name_query_raw);

  while ($page_query = smn_db_fetch_array($page_name_query)) {
    $page_name =  str_replace('_', ' ', $page_query['page_name']);
    $contents[] = array('page_id' => $page_query['page_id'],
	                'page_name' => $page_name,
			'page_title' => $page_query['page_title'],
                        'date_modified' => $page_query['date']);	 
    for ($i=0; $i<sizeof($contents); $i++){
      $tInfo = new objectInfo($contents[$i]);
    }
    if ($page_name){
      echo '<tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . smn_href_link(FILENAME_TEXT_EDITOR, 'page_id=' .$page_query['page_id'] . '&action=edit' . '&type=' . $_GET ['type']) .  '\'">' . "\n";
      echo '<td class="dataTableContent" align="left">' . nl2br($page_name).'&nbsp;</td> ';
      echo '<td class="dataTableContent" align="left">' . nl2br($page_query['page_title']).'&nbsp;</td> ';
      echo '<td class="dataTableContent" align="left">' . nl2br($page_query['date_modified']).'&nbsp;</td> ';
      echo '</tr>';
    }
  }
?>
            <tr>
                <td align="center" class="smallText"><a href="http://www.systemsmanager.net"><br><b>Copyright &copy; 2005 SystemsManager Technologies</b></a></td>
                <td align="right" class="main"><?php  echo '<a href="' . smn_href_link(FILENAME_TEXT_EDITOR) . '">' . smn_image_button('button_back.gif', IMAGE_BACK) . '</a>'; ?></td>
                  <td align="right" class="main"><?php  echo '<a href="' . smn_href_link(FILENAME_TEXT_EDITOR, 'action=new&type=' . $_GET ['type']) . '">' . smn_image_button('button_new_page.gif', IMAGE_NEW) . '</a>'; ?></td>
            </tr>
            </table></td>

<?php
}    
 if (($_GET['action'] != 'confirmdelete') && ($_GET['action'] != 'edit') && ($_GET['action'] != 'new') && (isset ($_GET ['page_name'])) && (($_GET ['type'])== 'site_text')){

  /* editing the site text.......find out which line of text to edit.....*/ 
?>

 <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>          
          <tr>
            <td class="main"><?php echo TEXT_PAGE_INFO_HEADING; ?></td><td></td>
          </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
              <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_TEXTKEY; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_TEXTCONTENT; ?></td>
                <td class="dataTableHeadingContent" align="right" width="15%"><?php echo TABLE_HEADING_LAST_MODIFIED; ?></td>
                </tr>

<?php
  $page_query_raw = ("select text_key, text_content, date_modified  from " . TABLE_WEB_SITE_CONTENT . " where page_name = '" . $_GET ['page_name'] . "' and language_id ='". $languages_id ."'and store_id = '" . $store_id . "' order by text_key");
  $page_query = smn_db_query($page_query_raw);
  while ($page_list_query = smn_db_fetch_array($page_query)){
    $page_name =  str_replace('_', ' ', $_GET ['page_name']); 	
    $contents[] = array('page_name' => $page_name,
						'text_key' => $page_list_query['text_key'],
						'text_content' => $page_list_query['text_content'],
						'date_modified' => $page_list_query['date_modified']);	 
    for ($i=0; $i<sizeof($contents); $i++) {
      $tInfo = new objectInfo($contents[$i]);
    }
    if ($page_name) {
      echo '<tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . smn_href_link(FILENAME_TEXT_EDITOR, 'page_name=' .$_GET ['page_name']. '&text_key=' . $page_list_query['text_key'] . '&type=' . $_GET ['type'] .'&action=edit') . '\'">' . "\n";
      echo '<td class="dataTableContent" align="left">' . nl2br($page_list_query['text_key']).'&nbsp;</td> ';
      echo '<td class="dataTableContent" align="left">' . nl2br($page_list_query['text_content']).'&nbsp;</td> ';
      echo '<td class="dataTableContent" align="right">' . nl2br($page_list_query['date_modified']).'&nbsp;</td> ';
      echo '</tr>';
    }
  }
?>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>
      </tr>
      <table>
                  <tr>
                    <td align="right" class="main"><?php  echo '<a href="' . smn_href_link(FILENAME_TEXT_EDITOR) . '">' . smn_image_button('button_back.gif', IMAGE_BACK) . '</a>'; ?></td>
                 </tr>
                  <tr>
                  <td align="center" class="smallText"><a href="http://www.systemsmanager.net"><b>Copyright &copy; 2005 SystemsManager Technologies</b></a></td>
                   <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>
                   </tr>  
</table>
            </table></td>
<?php 
}
if ($_GET['action'] == 'new'){
/* add in a new web page or articles......*/
?>
  <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>          
          <tr>
            <td class="main"><?php echo NEW_TEXT_SITE_INFO_PAGE_HEADING; ?></td><td></td>
          </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>
      </tr>
   <table>   
<?php
    echo smn_draw_form('new_text_content', FILENAME_TEXT_EDITOR, 'action=newsave&type='.$_GET ['type'], 'POST'); 
    if ($_GET ['type'] == 'web_pages'){   
?>
    <tr>  
      <td class="main"><?php echo NEW_TEXT_PAGE_NAME; ?></td>
      <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_input_field('new_catagory', $pInfo->page_name). '&nbsp;' .NEW_TEXT_WEB_PAGE_REQUIREMENT; ?></td>
    </tr>  
<?php    
    $languages = smn_get_languages();
    for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {    
?>
      <tr>
        <td class="main" valign="center" align="left"><?php echo $languages[$i]['directory'] .'&nbsp;&nbsp;' . smn_image(DIR_WS_CATALOG_LANGUAGES .  'images/' . $languages[$i]['image'], $languages[$i]['name']); ?>&nbsp;&nbsp;&nbsp;</td>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '40'); ?></td>
      </tr>     
    <td class="main"><?php echo NEW_TEXT_ARTICLE_TITLE; ?></td>
    <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_input_field('page_title[' . $languages[$i]['id'] . ']', $pInfo->page_title). '&nbsp;' .NEW_TEXT_WEB_PAGE_REQUIREMENT; ?></td>
    </tr>
     <tr>  
    <td class="main"><?php echo NEW_TEXT_PAGE_NAVBAR; ?></td>
    <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_input_field('page_navbar[' . $languages[$i]['id'] . ']', $pInfo->page_navbar). '&nbsp;' .NEW_TEXT_WEB_PAGE_REQUIREMENT; ?></td>
    </tr>
         <tr>  
    <td class="main"><?php echo NEW_TEXT_HEADER_TITLE; ?></td>
    <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_input_field('page_header[' . $languages[$i]['id'] . ']', $pInfo->page_header). '&nbsp;' .NEW_TEXT_WEB_PAGE_REQUIREMENT; ?></td>
    </tr>  
     <tr>  
    <td class="main"><?php echo NEW_TEXT_HEADING_TITLE; ?></td>
    <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_input_field('page_heading[' . $languages[$i]['id'] . ']', $pInfo->page_heading). '&nbsp;' .NEW_TEXT_WEB_PAGE_REQUIREMENT; ?></td>
    </tr>    
<?php
      }
    }
    if ($_GET ['type'] == 'articles'){
?>
    <tr>  
      <td class="main"><?php echo NEW_TEXT_PAGE_NAME; ?></td>
      <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_input_field('new_catagory', $pInfo->page_name). '&nbsp;' .NEW_TEXT_ARTICLE_REQUIREMENT; ?></td>
    </tr>
    <tr>
      <td class="main"><?php echo CURRENT_TEXT_PAGE_NAME; ?></td>
      <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_pull_down_menu('use_current_catagory', $new_page_array, $new_page_array[1]); ?></td>
    </tr>
<?php    
  $languages = smn_get_languages();
    for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {    
?>
      <tr>
        <td class="main" valign="center" align="left"><?php echo $languages[$i]['directory'] .'&nbsp;&nbsp;' . smn_image(DIR_WS_CATALOG_LANGUAGES .  'images/' . $languages[$i]['image'], $languages[$i]['name']); ?>&nbsp;&nbsp;&nbsp;</td>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '40'); ?></td>
      </tr>
      <tr>  
        <td class="main"><?php echo NEW_TEXT_ARTICLE_TITLE; ?></td>
        <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_input_field('page_title[' . $languages[$i]['id'] . ']', $pInfo->page_title). '&nbsp;' .NEW_TEXT_WEB_PAGE_REQUIREMENT; ?></td>
      </tr>
      <tr>  
        <td class="main"><?php echo NEW_TEXT_PAGE_NAVBAR; ?></td>
        <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_input_field('page_navbar[' . $languages[$i]['id'] . ']', $pInfo->page_navbar). '&nbsp;' .NEW_TEXT_ARTICLE_REQUIREMENT; ?></td>
      </tr>
      <tr>  
        <td class="main"><?php echo NEW_TEXT_HEADER_TITLE; ?></td>
        <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_input_field('page_header[' . $languages[$i]['id'] . ']', $pInfo->page_header). '&nbsp;' .NEW_TEXT_ARTICLE_REQUIREMENT; ?></td>
      </tr>
      <tr>  
        <td class="main"><?php echo NEW_TEXT_HEADING_TITLE; ?></td>
        <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_input_field('page_heading[' . $languages[$i]['id'] . ']', $pInfo->page_heading). '&nbsp;' .NEW_TEXT_ARTICLE_REQUIREMENT; ?></td>
      </tr>
<?php
      }
    }
    if ($_GET ['type'] == 'site_text') {
?>
      <tr>  
        <td class="main"><?php echo NEW_TEXT_PAGE_NAME; ?></td>
        <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_input_field('new_catagory', $pInfo->page_name). '&nbsp;' .NEW_TEXT_ARTICLE_REQUIREMENT; ?></td>
      </tr>
      <tr>
        <td class="main"><?php echo CURRENT_TEXT_PAGE_NAME; ?></td>
        <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_pull_down_menu('use_current_catagory', $new_page_array, $new_page_array[1]); ?></td>
      </tr>    
      <tr>  
        <td class="main"><?php echo NEW_TEXT_KEY_TITLE; ?></td>
        <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_input_field('text_key', $pInfo->text_key). '&nbsp;' .NEW_TEXT_KEY_REQUIREMENT; ?></td>
      </tr>
<?php
        }
?>
       <table>
                  <tr>
                    <td align="right" class="main"><?php echo smn_image_submit('button_save.gif', IMAGE_SAVE); ?></td>
                    <td align="right" class="main"><?php  echo '<a href="' . smn_href_link(FILENAME_TEXT_EDITOR) . '">' . smn_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>'; ?></td>
                  </tr>
                  <tr>                 
                  <td align="center" class="smallText"><a href="http://www.systemsmanager.net"><b>Copyright &copy; 2005 SystemsManager Technologies</b></a></td>
                   <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>
                   </tr>  
        </table>
    </table>
    </form>
<?php
}
if ($_GET['action'] == 'edit'){
/* do the editing for the text or pages with the html editor or the form box......*/
?>
      <tr><?php echo smn_draw_form('text_content', FILENAME_TEXT_EDITOR, 'action=save&type='.$_GET ['type'], 'POST'); ?>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>
      </tr>
          <tr>
            <td class="main"><?php echo TEXT_FILE_CONTENTS; ?></td>
          </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>
      </tr>    
<?php
if ($page_id){
$page_text_query_raw = ("select a.page_id, d.page_name, d.page_type, a.page_title, a.date_modified  from " . TABLE_DYNAMIC_PAGE_INDEX . " d, " . TABLE_ARTICLES . " a where a.page_id='" . $_GET ['page_id'] . "' and a.language_id ='". $languages_id ."'and a.store_id = '" . $store_id . "'and d.store_id = '" . $store_id . "'");
$text_query = smn_db_query($page_text_query_raw);
$text_list_query = smn_db_fetch_array($text_query);
?>
      <input type="hidden" name="page_name" value="<?php echo $text_list_query['page_name']; ?>">
      <input type="hidden" name="page_id" value="<?php echo $_GET ['page_id']; ?>">
      
<?php
}else{
$page_text_query_raw = ("select * from " . $db_table . " where text_key = '" . $_GET ['text_key'] . "' and page_name='" . $_GET ['page_name'] . "' and language_id ='". $languages_id ."' and store_id = '" . $store_id . "'");
$text_query = smn_db_query($page_text_query_raw);
$text_list_query = smn_db_fetch_array($text_query);
?>
      <input type="hidden" name="page_name" value="<?php echo $_GET ['page_name']; ?>">
      <input type="hidden" name="text_key" value="<?php echo $_GET ['text_key']; ?>">
<?php
}
  $languages = smn_get_languages();
    for ($i = 0, $n = sizeof($languages); $i < $n; $i++){
      if ($page_id){        
        $text_query_raw = smn_db_query("select * from " . TABLE_ARTICLES . " where  page_id= '" . $_GET ['page_id'] . "' and language_id = '" . $languages[$i]['id'] . "' and store_id = '" . $store_id . "'");
      }else{
        $text_query_raw = smn_db_query("select * from " . $db_table . " where  text_key = '" . $_GET ['text_key'] . "' and page_name='" . $_GET ['page_name'] . "' and language_id = '" . $languages[$i]['id'] . "' and store_id = '" . $store_id . "'");
      }
        $language_list_query = smn_db_fetch_array($text_query_raw);
      if ($page_id){
?>
          <tr>
            <td class="main"><?php echo TEXT_CURRENT_TEXT; ?></td>
          </tr>
           <tr>
            <td class="main"><?php echo $text_list_query['page_title']; ?></td>
          </tr>
<?php
}else{
 ?>
        <tr>
            <td class="main"><?php echo TEXT_CURRENT_TEXT; ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo $language_list_query['text_content']; ?></td>
          </tr>
<?php
}      
?>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>
      </tr>          
          <tr>
            <td class="main" valign="top" align="left"><?php echo $languages[$i]['directory'] .'&nbsp;&nbsp;' . smn_image(DIR_WS_CATALOG_LANGUAGES .  'images/' . $languages[$i]['image'], $languages[$i]['name']); ?>&nbsp;&nbsp;&nbsp;</td>
          </tr>
          <tr>
          <td class="main" align="center">
<?php
              echo smn_draw_textarea_field('file_content[' . $languages[$i]['id'] . ']', 'text', '80', '20', $language_list_query['text_content'], '');
              $java_editor = 'file_content[' . $languages[$i]['id'] . ']';
?>
           </td>     
             </tr>
          <tr>
            <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>     
<?php
    }
?>          
          <tr>    
            </td> <td align="left" class="main">
            <?php
            if ($page_id){
            echo '<a href="' . smn_href_link(FILENAME_TEXT_EDITOR .'?action=delete&type='. $_GET ['type']. '&page_name=' . $text_list_query['page_name']. '&page_id=' . $text_list_query['page_id']) . '">' . smn_image_button('button_delete.gif', IMAGE_DELETE) . '</a>&nbsp;&nbsp;';
            }else{
            echo '<a href="' . smn_href_link(FILENAME_TEXT_EDITOR .'?action=delete&type='. $_GET ['type'] . '&page_name=' . $text_list_query['page_name'] . '&text_key=' . $text_list_query['text_key']) . '">' . smn_image_button('button_delete.gif', IMAGE_DELETE) . '</a>&nbsp;&nbsp;';
            }
            echo smn_image_submit('button_save.gif', IMAGE_SAVE) . '&nbsp;&nbsp;';
            echo '<a href="' . smn_href_link(FILENAME_TEXT_EDITOR) . '">' . smn_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>&nbsp;&nbsp;';
            echo '<a href="' . smn_href_link(FILENAME_TEXT_EDITOR, 'page_name=' . $text_list_query['page_name'] ) . '">' . smn_image_button('button_back.gif', IMAGE_BACK) . '</a>'; ?></td>
          </tr>  
          <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>
      </tr>         
          <tr>
            <td align="center" class="main"><a href="http://www.systemsmanager.net"><b>Copyright &copy; 2005 SystemsManager Technologies</b></a>
               </tr>
        </table></td>
      </form></tr>
            </table></td>
<?php
}elseif ($_GET['type'] == 'mainpage'){
?>
      <tr><?php echo smn_draw_form('text_content', FILENAME_TEXT_EDITOR, 'action=save&type=save_mainpage', 'POST'); ?>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>
      </tr>  
        <tr>
            <td class="main"><?php echo TEXT_CURRENT_TEXT; ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo $store->get_store_description(); ?></td>
          </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>
      </tr>          
      <tr>
        <td class="main" align="center">
<?php
              echo smn_draw_textarea_field('mainpage', 'text', '80', '20', $store->get_store_description(), '');
              $java_editor = 'mainpage';
?>
        </td>     
      </tr>
          <tr>
            <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>     
          <tr>    
            </td> <td align="left" class="main">
            <?php
            echo smn_image_submit('button_save.gif', IMAGE_SAVE) . '&nbsp;&nbsp;';
            echo '<a href="' . smn_href_link(FILENAME_TEXT_EDITOR) . '">' . smn_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>&nbsp;&nbsp;'; ?></td>
          </tr>  
          <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>
      </tr>         
      <tr>
        <td align="center" class="main"><a href="http://www.systemsmanager.net"><b>Copyright &copy; 2005 SystemsManager Technologies</b></a>
      </tr>
    </table></td>
  </form></tr>
</table></td>
<?php
}
?>
          </tr>
        </table></td>
      </tr>
    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->
<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>