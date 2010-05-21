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

  $manufacturers_query = smn_db_query("select manufacturers_id, manufacturers_name from " . TABLE_MANUFACTURERS . " order by manufacturers_name");
  if ($number_of_rows = smn_db_num_rows($manufacturers_query)) {

    $boxHeading = BOX_HEADING_MANUFACTURERS;
    $box_base_name = 'manufacturers';
    $box_id = $box_base_name . 'Box'; 
    if ($number_of_rows <= MAX_DISPLAY_MANUFACTURERS_IN_A_LIST) {
// Display a list
      $boxContent = '';
      while ($manufacturers = smn_db_fetch_array($manufacturers_query)) {
        $manufacturers_name = ((strlen($manufacturers['manufacturers_name']) > MAX_DISPLAY_MANUFACTURER_NAME_LEN) ? substr($manufacturers['manufacturers_name'], 0, MAX_DISPLAY_MANUFACTURER_NAME_LEN) . '..' : $manufacturers['manufacturers_name']);
        if (isset($_GET['manufacturers_id']) && ($_GET['manufacturers_id'] == $manufacturers['manufacturers_id'])) $manufacturers_name = '<b>' . $manufacturers_name .'</b>';
        $boxContent .= '<a href="' . smn_href_link(FILENAME_DEFAULT, 'ID=1&manufacturers_id=' . $manufacturers['manufacturers_id']) . '">' . $manufacturers_name . '</a><br>';
      }

      $boxContent = substr($boxContent, 0, -4);

    } else {
// Display a drop-down
      $manufacturers_array = array();
      if (MAX_MANUFACTURERS_LIST < 2) {
        $manufacturers_array[] = array('id' => '', 'text' => PULL_DOWN_DEFAULT);
      }

      while ($manufacturers = smn_db_fetch_array($manufacturers_query)) {
        $manufacturers_name = ((strlen($manufacturers['manufacturers_name']) > MAX_DISPLAY_MANUFACTURER_NAME_LEN) ? substr($manufacturers['manufacturers_name'], 0, MAX_DISPLAY_MANUFACTURER_NAME_LEN) . '..' : $manufacturers['manufacturers_name']);
        $manufacturers_array[] = array('id' => $manufacturers['manufacturers_id'],
                                       'text' => $manufacturers_name);
      }
    if (($session_started == true) && smn_not_null($SID)) {
      $link = 'ID=1&' . smn_session_name() .'='. smn_session_id();
    }else{
      $link = 'ID=1';
    }
      
      
      $boxContent = smn_draw_form('manufacturers', smn_href_link(FILENAME_DEFAULT, $link, 'NONSSL', false), 'get');

      $boxContent .= smn_draw_pull_down_menu('manufacturers_id', $manufacturers_array, (isset($_GET['manufacturers_id']) ? $_GET['manufacturers_id'] : ''), 'onChange="this.form.submit();" size="' . MAX_MANUFACTURERS_LIST . '" style="width: 100%"');

          $boxContent .= '</form>';
    }
    $boxContent .= smn_hide_session_id();
    if(file_exists(DIR_WS_BOX_TEMPLATES . $box_base_name . '.php')) {
      require(DIR_WS_BOX_TEMPLATES . $box_base_name . '.php');
    }else{
      require(DEFAULT_TEMPLATENAME_BOX);
    }
    $boxContent_attributes = '';
  }

?>
