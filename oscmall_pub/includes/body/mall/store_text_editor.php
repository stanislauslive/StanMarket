<table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
		  <tr>
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
  	<tr >
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>          
            <td class="dataTableHeadingContent"><?php echo TEXT_SITE_DELETE_HEADING; ?></td>
          </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>
      </tr>
      <tr>
        <td>
            <table align="center" border="0" width="70%" cellspacing="0" cellpadding="2">
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
          <td align="center" class="main"><?php  echo '<a href="' . smn_href_link(FILENAME_STORE_TEXT_EDITOR, 'action=deleteconfirm&type=' . $_GET ['type']. '&page_id=' . $_GET['page_id']. '&page_name=' . $_GET['page_name'].'&ID='.$store_id ) . '">' . smn_image_button('small_delete.gif', IMAGE_DELETE) . '</a>' . '&nbsp;&nbsp;' . '<a href="' . smn_href_link(FILENAME_STORE_TEXT_EDITOR,'ID='.$store_id) . '">' . smn_image_button('small_cancel.gif', IMAGE_CANCEL) . '</a>'; ?></td>
        </tr>
        <tr>
          <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>
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
        <tr>   
          <td align="center" class="main"><?php  echo '<a href="' . smn_href_link(FILENAME_STORE_TEXT_EDITOR, 'action=deleteconfirm&type='. $_GET ['type']. '&page_name=' .$_GET['page_name'] . '&text_key=' . $_GET['text_key'].'&ID='.$store_id) . '">' . smn_image_button('small_delete.gif', IMAGE_DELETE) . '</a>' . '&nbsp;&nbsp;' . '<a href="' . smn_href_link(FILENAME_STORE_TEXT_EDITOR,'ID='.$store_id) . '">' . smn_image_button('small_cancel.gif', IMAGE_CANCEL) . '</a>'; ?></td>
        </tr>
        <tr>
          <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>
        </tr>
        
    </table></td></tr>
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
      </tr>
      <tr>
        <td class="main"><?php echo TEXT_SITE_INTRO_HEADING; ?></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>
      </tr>
      <tr>
        <td><table align="center" border="0" width="70%" cellspacing="0" cellpadding="2">
          <tr class="dataTableHeadingRow">
            <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_INTRO; ?></td>
          </tr>
<?php 
      echo '<tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . smn_href_link(FILENAME_STORE_TEXT_EDITOR, 'type=site_text&ID='.$store_id).'\'">' . "\n";
      echo '  <td class="dataTableContent" align="left">Web Site Text Editor &nbsp;</td> ';
      echo '</tr>';
      echo '<tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . smn_href_link(FILENAME_STORE_TEXT_EDITOR, 'type=web_pages&ID='.$store_id) . '\'">' . "\n";
      echo '  <td class="dataTableContent" align="left">Web Site Information Pages &nbsp;</td> ';
      echo '</tr>';
      echo '<tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . smn_href_link(FILENAME_STORE_TEXT_EDITOR, 'type=articles&ID='.$store_id) .'\'">' . "\n";
      echo '  <td class="dataTableContent" align="left">Web Articles &nbsp;</td> ';
      echo '</tr>';
      echo '<tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . smn_href_link(FILENAME_STORE_TEXT_EDITOR, 'type=mainpage&ID='.$store_id) .'\'">' . "\n";
      echo '  <td class="dataTableContent" align="left">Store Description &nbsp;</td> ';
      echo '</tr>';
?>
            
          </table></td></tr>

<?php
  }
  if (($_GET['action'] != 'confirmdelete') && ($_GET['action'] != 'edit') && ($_GET['action'] != 'new') && (!isset ($_GET ['page_name'])) && (($_GET ['type'])=='site_text')){
  /* editing the site text.......find out which page of  site text to edit.....*/ 
?>
  <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td> </tr>         
          <tr>
            <td class="main"><?php echo TEXT_SITE_INFO_HEADING; ?></td>
          </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>
      </tr>
      <tr>
        <td><table align ="center" border="0" width="100%" cellspacing="0" cellpadding="2">
             
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_GROUP; ?></td>
               </tr>
<?php 
$page_query_raw = ("select distinct page_name from " . TABLE_WEB_SITE_CONTENT . " where language_id ='". $languages_id ."' and store_id = '" . $store_id . "'order by page_name" );
$page_query = smn_db_query($page_query_raw);
      while ($page_list_query = smn_db_fetch_array($page_query)){
	$page_name =  str_replace('_', ' ', $page_list_query['page_name']);
	$contents[] = array('name' => $page_name);	 
/*	for ($i=0; $i<sizeof($contents); $i++){
          $tInfo = new objectInfo($contents[$i]);
      }
*/
    if ($page_name) {
      echo '<tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . smn_href_link(FILENAME_STORE_TEXT_EDITOR, 'page_name=' .$page_list_query['page_name'] .'&type=site_text'.'&ID='.$store_id) . '\'">' . "\n";
      echo '<td class="dataTableContent" align="left">' . nl2br($page_name).'&nbsp;</td> ';
      echo '</tr>';
    }
  }
?>
             <tr>
            <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>
            </tr>
            <tr>
                <td align="right" class="main"><?php  echo '<a href="' . smn_href_link(FILENAME_STORE_TEXT_EDITOR,'ID='.$store_id) . '">' . smn_image_button('small_back.gif', IMAGE_BACK) . '</a>&nbsp;&nbsp;<a href="' . smn_href_link(FILENAME_STORE_TEXT_EDITOR, 'action=new&type=' . $_GET ['type'].'&ID='.$store_id) . '">' . smn_image_button('small_insert.gif', IMAGE_INSERT) . '</a>'; ?></td>
            </tr>
            <tr>
            <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>
            </tr>
               
            </table></td></tr>
<?php
  }elseif (($_GET['action'] != 'confirmdelete') && ($_GET['action'] != 'edit') && ($_GET['action'] != 'new') && (!isset ($_GET ['page_name'])) && (($_GET ['type'])=='web_pages'  || ($_GET ['type'])=='articles')){
/*  if the choice is to edit web pages or articles find out page to edit......*/
?>
  <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>   </tr>       
          <tr>
            <td class="main"><?php echo TEXT_SITE_INFO_PAGE_HEADING; ?></td>
          </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>
      </tr>
      <tr>
        <td><table align="center" border="0" width="90%" cellspacing="0" cellpadding="2">
             
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
/*    for ($i=0; $i<sizeof($contents); $i++){
      $tInfo = new objectInfo($contents[$i]);
    }
*/    if ($page_name){
      echo '<tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . smn_href_link(FILENAME_STORE_TEXT_EDITOR, 'page_id=' .$page_query['page_id'] . '&action=edit' . '&type=' . $_GET ['type'].'&ID='.$store_id) .  '\'">' . "\n";
      echo '<td class="dataTableContent" align="left">' . nl2br($page_name).'&nbsp;</td> ';
      echo '<td class="dataTableContent" align="left">' . nl2br($page_query['page_title']).'&nbsp;</td> ';
      echo '<td class="dataTableContent" align="left">' . nl2br($page_query['date_modified']).'&nbsp;</td> ';
      echo '</tr>';
    }
  }
?>
            <tr>
                <td align="center" class="smallText"></td>
                <td align="right" class="main"><?php  echo '<a href="' . smn_href_link(FILENAME_STORE_TEXT_EDITOR,'ID='.$store_id) . '">' . smn_image_button('small_back.gif', IMAGE_BACK) . '</a>'; ?></td>
                  <td align="right" class="main"><?php  echo '<a href="' . smn_href_link(FILENAME_STORE_TEXT_EDITOR, 'action=new&type=' . $_GET ['type'].'&ID='.$store_id) . '">' . smn_image_button('button_new_page.gif', IMAGE_NEW) . '</a>'; ?></td>
            </tr>
            </table></td></tr>

<?php
}    
 if (($_GET['action'] != 'confirmdelete') && ($_GET['action'] != 'edit') && ($_GET['action'] != 'new') && (isset ($_GET ['page_name'])) && (($_GET ['type'])== 'site_text')){

  /* editing the site text.......find out which line of text to edit.....*/ 
?>

 <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td> </tr>         
           <tr> <td class="main"><?php echo TEXT_PAGE_INFO_HEADING; ?></td>
          </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
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
/*    for ($i=0; $i<sizeof($contents); $i++) {
      $tInfo = new objectInfo($contents[$i]);
    }
*/    if ($page_name) {
      echo '<tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . smn_href_link(FILENAME_STORE_TEXT_EDITOR, 'page_name=' .$_GET ['page_name']. '&text_key=' . $page_list_query['text_key'] . '&type=' . $_GET ['type'] .'&action=edit'.'&ID='.$store_id) . '\'">' . "\n";
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
</table></td></tr>
				<tr>
                    <td align="right" class="main"><?php  echo '<a href="' . smn_href_link(FILENAME_STORE_TEXT_EDITOR,'ID='.$store_id) . '">' . smn_image_button('small_back.gif', IMAGE_BACK) . '</a>'; ?></td>
                 </tr>
                  <tr>
                  <td align="center" class="smallText"></td>
                   <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>
                   </tr>  
            
<?php 
}
if ($_GET['action'] == 'new'){
/* add in a new web page or articles......*/
?>
  <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td> </tr>         
          <tr>
            <td class="main"><?php echo NEW_TEXT_SITE_INFO_PAGE_HEADING; ?></td><td></td>
          </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>
      </tr>
   <tr>
        <td><table width="100%">   
<?php
    echo smn_draw_form('new_text_content', FILENAME_STORE_TEXT_EDITOR.'?action=newsave&type='.$_GET ['type'].'&ID='.$store_id, 'POST'); 
    if ($_GET ['type'] == 'web_pages'){   
?>
    <tr>  
      <td class="main"><?php echo NEW_TEXT_PAGE_NAME; ?></td>
      <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_input_field('new_catagory', $pInfo[page_name]). '&nbsp;' .NEW_TEXT_WEB_PAGE_REQUIREMENT; ?></td>
    </tr>  
<?php    
    $languages = smn_get_languages();
    for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {    
?>
      <tr>
        <td class="main" valign="center" align="left"><?php echo $languages[$i]['directory'] .'&nbsp;&nbsp;' . smn_image(DIR_WS_LANGUAGES .  'images/' . $languages[$i]['image'], $languages[$i]['name']); ?>&nbsp;&nbsp;&nbsp;</td>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '40'); ?></td>
      </tr>     
    <tr>
	<td class="main"><?php echo NEW_TEXT_ARTICLE_TITLE; ?></td>
    <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_input_field('page_title[' . $languages[$i]['id'] . ']', $pInfo[page_title]). '&nbsp;' .NEW_TEXT_WEB_PAGE_REQUIREMENT; ?></td>
    </tr>
     <tr>  
    <td class="main"><?php echo NEW_TEXT_PAGE_NAVBAR; ?></td>
    <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_input_field('page_navbar[' . $languages[$i]['id'] . ']', $pInfo[page_navbar]). '&nbsp;' .NEW_TEXT_WEB_PAGE_REQUIREMENT; ?></td>
    </tr>
         <tr>  
    <td class="main"><?php echo NEW_TEXT_HEADER_TITLE; ?></td>
    <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_input_field('page_header[' . $languages[$i]['id'] . ']', $pInfo[page_header]). '&nbsp;' .NEW_TEXT_WEB_PAGE_REQUIREMENT; ?></td>
    </tr>  
     <tr>  
    <td class="main"><?php echo NEW_TEXT_HEADING_TITLE; ?></td>
    <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_input_field('page_heading[' . $languages[$i]['id'] . ']', $pInfo[page_heading]). '&nbsp;' .NEW_TEXT_WEB_PAGE_REQUIREMENT; ?></td>
    </tr>    
<?php
      }
    }
    if ($_GET ['type'] == 'articles'){
?>
    <tr>  
      <td class="main"><?php echo NEW_TEXT_PAGE_NAME; ?></td>
      <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_input_field('new_catagory', $pInfo[page_name]). '&nbsp;' .NEW_TEXT_ARTICLE_REQUIREMENT; ?></td>
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
        <td class="main" valign="center" align="left"><?php echo $languages[$i]['directory'] .'&nbsp;&nbsp;' . smn_image(DIR_WS_LANGUAGES .  'images/' . $languages[$i]['image'], $languages[$i]['name']); ?>&nbsp;&nbsp;&nbsp;</td>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '40'); ?></td>
      </tr>
      <tr>  
        <td class="main"><?php echo NEW_TEXT_ARTICLE_TITLE; ?></td>
        <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_input_field('page_title[' . $languages[$i]['id'] . ']', $pInfo[page_title]). '&nbsp;' .NEW_TEXT_WEB_PAGE_REQUIREMENT; ?></td>
      </tr>
      <tr>  
        <td class="main"><?php echo NEW_TEXT_PAGE_NAVBAR; ?></td>
        <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_input_field('page_navbar[' . $languages[$i]['id'] . ']', $pInfo[page_navbar]). '&nbsp;' .NEW_TEXT_ARTICLE_REQUIREMENT; ?></td>
      </tr>
      <tr>  
        <td class="main"><?php echo NEW_TEXT_HEADER_TITLE; ?></td>
        <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_input_field('page_header[' . $languages[$i]['id'] . ']', $pInfo[page_header]). '&nbsp;' .NEW_TEXT_ARTICLE_REQUIREMENT; ?></td>
      </tr>
      <tr>  
        <td class="main"><?php echo NEW_TEXT_HEADING_TITLE; ?></td>
        <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_input_field('page_heading[' . $languages[$i]['id'] . ']', $pInfo[page_heading]). '&nbsp;' .NEW_TEXT_ARTICLE_REQUIREMENT; ?></td>
      </tr>
<?php
      }
    }
    if ($_GET ['type'] == 'site_text') {
?>
      <tr>  
        <td class="main" valign="top"><?php echo NEW_TEXT_PAGE_NAME; ?></td>
        <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_input_field('new_catagory', $pInfo[page_name]). '<br>'.smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' .NEW_TEXT_ARTICLE_REQUIREMENT; ?></td>
      </tr>
      <tr>
        <td class="main"><?php echo CURRENT_TEXT_PAGE_NAME; ?></td>
        <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_pull_down_menu('use_current_catagory', $new_page_array, $new_page_array[1]); ?></td>
      </tr>    
      <tr>  
        <td class="main" valign="top"><?php echo NEW_TEXT_KEY_TITLE; ?></td>
        <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_input_field('text_key', $pInfo[text_key]). '<br>'.smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' .NEW_TEXT_KEY_REQUIREMENT; ?></td>
      </tr>
<?php
        }
?>
                  <tr>
                    <td align="right" class="main"><?php echo smn_image_submit('small_save.gif', IMAGE_SAVE); ?></td>
                    <td align="left" class="main"><?php  echo '<a href="' . smn_href_link(FILENAME_STORE_TEXT_EDITOR,'ID='.$store_id) . '">' . smn_image_button('small_cancel.gif', IMAGE_CANCEL) . '</a>'; ?></td>
                  </tr>
                  <tr>                 
                  <td align="center" class="smallText"></td>
                   <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>
                   </tr>  
        </table></td></tr>
   
    </form>
<?php
}
if ($_GET['action'] == 'edit'){
/* do the editing for the text or pages with the html editor or the form box......*/
?>
      <tr><?php echo smn_draw_form('text_content', FILENAME_STORE_TEXT_EDITOR.'?action=save&type='.$_GET ['type'].'&ID='.$store_id, 'POST'); ?>
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
            <td class="main" valign="top" align="left"><?php echo $languages[$i]['directory'] .'&nbsp;&nbsp;' . smn_image(DIR_WS_LANGUAGES .  'images/' . $languages[$i]['image'], $languages[$i]['name']); ?>&nbsp;&nbsp;&nbsp;</td>
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
             <td align="left" class="main">
            <?php
            if ($page_id){
            echo '<a href="' . smn_href_link(FILENAME_STORE_TEXT_EDITOR .'?action=delete&type='. $_GET ['type']. '&page_name=' . $text_list_query['page_name']. '&page_id=' . $text_list_query['page_id'].'&ID='.$store_id) . '">' . smn_image_button('small_delete.gif', IMAGE_DELETE) . '</a>&nbsp;&nbsp;';
            }else{
            echo '<a href="' . smn_href_link(FILENAME_STORE_TEXT_EDITOR .'?action=delete&type='. $_GET ['type'] . '&page_name=' . $text_list_query['page_name'] . '&text_key=' . $text_list_query['text_key'].'&ID='.$store_id) . '">' . smn_image_button('small_delete.gif', IMAGE_DELETE) . '</a>&nbsp;&nbsp;';
            }
            echo smn_image_submit('small_save.gif', IMAGE_SAVE) . '&nbsp;&nbsp;';
            echo '<a href="' . smn_href_link(FILENAME_STORE_TEXT_EDITOR,'ID='.$store_id) . '">' . smn_image_button('small_cancel.gif', IMAGE_CANCEL) . '</a>&nbsp;&nbsp;';
            echo '<a href="' . smn_href_link(FILENAME_STORE_TEXT_EDITOR, 'page_name=' . $text_list_query['page_name'].'&ID='.$store_id ) . '">' . smn_image_button('small_back.gif', IMAGE_BACK) . '</a>'; ?></td>
          </tr>  
          <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>
      </tr>         
          <tr>
            <td align="center" class="main">
               </tr>
        </table></td>
      </tr></form>
<?php
}elseif ($_GET['type'] == 'mainpage'){
?>
      <tr><?php echo smn_draw_form('text_content', FILENAME_STORE_TEXT_EDITOR.'?action=save&type=save_mainpage&ID='.$store_id, 'POST'); ?>
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
            <td align="left" class="main">
            <?php
            echo smn_image_submit('small_save.gif', IMAGE_SAVE) . '&nbsp;&nbsp;';
            echo '<a href="' . smn_href_link(FILENAME_STORE_TEXT_EDITOR,'ID='.$store_id) . '">' . smn_image_button('small_cancel.gif', IMAGE_CANCEL) . '</a>&nbsp;&nbsp;'; ?></td>
          </tr>  
          <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>
      </tr>         
      <tr>
        <td align="center" class="main">
      </tr>
    </table>
  </form>
<?php
}
?>
</td>
      </tr>
    </table>