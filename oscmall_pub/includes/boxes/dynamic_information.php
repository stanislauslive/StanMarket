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
    $boxHeading = BOX_HEADING_INFORMATION;
    $box_base_name = 'dynamic_information'; 
    $box_id = $box_base_name . 'Box';
  $web_page_query = smn_db_query("select page_name from " . TABLE_DYNAMIC_PAGE_INDEX ."  where page_type='web_pages' and store_id='" . $store_id ."' order by page_name");
// Display a drop-down
    
    $boxContent = '<form name="page_name" method="post" action="' . smn_href_link(FILENAME_INFORMATION) . '">';
    $boxContent .= '<select name="page_name" onChange="this.form.submit();" style="width: 100%">';
    $boxContent .= '<option value="">' . PULL_DOWN_DEFAULT . '</option>';
    while ($web_page_values = smn_db_fetch_array($web_page_query)){
      $name = str_replace('_', ' ', $web_page_values['page_name']);
      $boxContent .= '<option value="' . $web_page_values['page_name'] . '"';
      if ($_GET['page_name'] == $web_page_values['page_name'])
	$boxContent .= ' SELECTED';
	$boxContent .= '>' . $name . '</option>';
    }
    $boxContent .= "</select>";
    $boxContent .= smn_hide_session_id();
    $boxContent .= "</form>";   
				    
                                    
    if(file_exists(DIR_WS_BOX_TEMPLATES . $box_base_name . '.php')) {
      require(DIR_WS_BOX_TEMPLATES . $box_base_name . '.php');
    }else{
      require(DEFAULT_TEMPLATENAME_BOX);
    }
    $boxContent_attributes = '';
?>
