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
  $boxHeading = "";
  $box_base_name = 'search2';
  $box_id = $box_base_name . 'Box'; 

  $boxContent = smn_draw_form('quick_find', smn_href_link(FILENAME_ADVANCED_SEARCH_RESULT, 'ID=1', 'NONSSL', false), 'post');
  $boxContent .= '<table HEIGHT="40" CELLSPACING="0" CELLPADDING="0" align="left"><tr><td HEIGHT="40" class="search_css">' . 'SEARCH: ';
  $boxContent .= smn_draw_pull_down_menu('categories_id', smn_get_categories_extended(array(array('id' => '', 'text' => 'All Stores'))), '0', '') . '&nbsp;&nbsp;';
  $boxContent .= smn_draw_hidden_field('search_in_description','1');
  $boxContent .= '<br/>FOR: ' . smn_draw_input_field('keywords', '', 'size="20" maxlength="30" ') . '&nbsp;' . smn_hide_session_id() . smn_image_submit('button_quick_find.gif', 'Go Search', 'align="absmiddle"');
  $boxContent .= '&nbsp;&nbsp;&nbsp;<a href="' . smn_href_link(FILENAME_ADVANCED_SEARCH) . '"><b>' . BOX_SEARCH_ADVANCED_SEARCH . '</b></a>';
  $boxContent .= '</td></tr></table></form>';

  if(file_exists(DIR_WS_BOX_TEMPLATES . $box_base_name . '.php')){
      require(DIR_WS_BOX_TEMPLATES . $box_base_name . '.php');
  }else {
      require(DEFAULT_TEMPLATENAME_BOX);
  }
  $boxContent_attributes = '';
?>
