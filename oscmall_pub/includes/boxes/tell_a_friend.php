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

?>
<!-- tell_a_friend //-->

<?php
  $info_box_contents = array();
  $info_box_contents[] = array('text' => BOX_HEADING_TELL_A_FRIEND);

  new infoBoxHeading($info_box_contents, false, false, '', $side);

  $info_box_contents = array();
  $info_box_contents[] = array('form' => smn_draw_form('tell_a_friend', smn_href_link(FILENAME_TELL_A_FRIEND, '', 'NONSSL', false), 'get'),
                               'align' => 'center',
                               'text' => smn_draw_input_field('to_email_address', '', 'size="10"') . '&nbsp;' . smn_image_submit('button_tell_a_friend.gif', BOX_HEADING_TELL_A_FRIEND) . smn_draw_hidden_field('products_id', $_GET['products_id']) . smn_hide_session_id() . '<br>' . BOX_TELL_A_FRIEND_TEXT);

  if(file_exists(DIR_WS_BOX_TEMPLATES . $box_base_name . '.php')){
      require(DIR_WS_BOX_TEMPLATES . $box_base_name . '.php');
  }else {
      require(DEFAULT_TEMPLATENAME_BOX);
  }
  $boxContent_attributes = '';
  $boxLink = '';
?>
<!-- tell_a_friend_eof //-->