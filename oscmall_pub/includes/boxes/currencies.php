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

  if (isset($currencies) && is_object($currencies)) {
    $boxHeading = BOX_HEADING_CURRENCIES;
    $box_base_name = 'currencies'; 
    $box_id = $box_base_name . 'Box';
    reset($currencies->currencies);
    $currencies_array = array();
    while (list($key, $value) = each($currencies->currencies)) {
      $currencies_array[] = array('id' => $key, 'text' => $value['title']);
    }
    $hidden_get_variables = '';
    reset($_GET);
    while (list($key, $value) = each($_GET)) {
      if ( ($key != 'currency') && ($key != smn_session_name()) && ($key != 'x') && ($key != 'y') ) {
        $hidden_get_variables .= smn_draw_hidden_field($key, $value);
      }
    }
    $boxContent = smn_draw_form('currencies', smn_href_link(basename($PHP_SELF), '', $request_type, false), 'get');
    $boxContent .= smn_draw_pull_down_menu('currency', $currencies_array, $currency, 'onChange="this.form.submit();" style="width: 100%"');
    $boxContent .= $hidden_get_variables;
    $boxContent .= smn_hide_session_id();
    $boxContent .= '</form>';

    if(file_exists(DIR_WS_BOX_TEMPLATES . $box_base_name . '.php')) {
        require(DIR_WS_BOX_TEMPLATES . $box_base_name . '.php');
    } else {
        require(DEFAULT_TEMPLATENAME_BOX);
    }
  $boxContent_attributes = '';
  }

?>
