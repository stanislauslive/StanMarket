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
<!-- standard information//-->
<?php
  $boxHeading = BOX_HEADING_INFORMATION;
  $box_base_name = 'information';
  $box_id = $box_base_name . 'Box'; 
  $boxContent = '<a href="' . smn_href_link(FILENAME_SHIPPING) . '"> ' . BOX_INFORMATION_SHIPPING . '</a><br>' .
                '<a href="' . smn_href_link(FILENAME_PRIVACY) . '"> ' . BOX_INFORMATION_PRIVACY . '</a><br>' .
                '<a href="' . smn_href_link(FILENAME_CONDITIONS) . '"> ' . BOX_INFORMATION_CONDITIONS . '</a><br>' .
                '<a href="' . smn_href_link(FILENAME_GV_FAQ) . '">' . BOX_INFORMATION_GV . '</a><br>' .
                '<a href="' . smn_href_link(FILENAME_CONTACT_US) . '"> ' . BOX_INFORMATION_CONTACT . '</a>';
  if(file_exists(DIR_WS_BOX_TEMPLATES . $box_base_name . '.php')) {
      require(DIR_WS_BOX_TEMPLATES . $box_base_name . '.php');
  }else {
      require(DEFAULT_TEMPLATENAME_BOX);
  }
?>
<!-- standard information//-->