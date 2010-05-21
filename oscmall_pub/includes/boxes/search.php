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
  $boxHeading = BOX_HEADING_SEARCH;
  $box_base_name = 'search';
  $box_id = $box_base_name . 'Box'; 
  $boxContent = smn_draw_form('quick_find', smn_href_link(FILENAME_ADVANCED_SEARCH_RESULT, 'ID=1', 'NONSSL', false), 'get');
  $boxContent .= smn_draw_hidden_field('ID',$store_id) . smn_draw_hidden_field('search_in_description','1') . smn_draw_input_field('keywords', '', 'size="25" maxlength="30" ') . '&nbsp;' . smn_hide_session_id() . smn_image_submit('search.jpg', BOX_HEADING_SEARCH) . '<br>' . BOX_SEARCH_TEXT . '<br><a href="' . smn_href_link(FILENAME_ADVANCED_SEARCH) . '"><b>' . BOX_SEARCH_ADVANCED_SEARCH . '</b></a>';
  $boxContent .= '</form>';

  if(file_exists(DIR_WS_BOX_TEMPLATES . $box_base_name . '.php')){
    require(DIR_WS_BOX_TEMPLATES . $box_base_name . '.php');
 }else {
    //  require(DEFAULT_TEMPLATENAME_BOX);
  }
  $boxContent_attributes = '';
?>
