<?php
/*
  Copyright (c) 2002 - 2005 SystemsManager.Net

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

////
// The HTML href link wrapper function
  function smn_href_link($page = '', $parameters = '', $connection = 'NONSSL') {
    if ($page == '') {
      die('</td></tr></table></td></tr></table><br><br><font color="#ff0000"><b>Error!</b></font><br><br><b>Unable to determine the page link!<br><br>Function used:<br><br>smn_href_link(\'' . $page . '\', \'' . $parameters . '\', \'' . $connection . '\')</b>');
    }
    if ($connection == 'NONSSL') {
      $link = HTTP_SERVER . DIR_WS_ADMIN;
    } elseif ($connection == 'NONSSL') {
      if (ENABLE_SSL == 'true') {
        $link = HTTPS_SERVER . DIR_WS_ADMIN;
      } else {
        $link = HTTP_SERVER . DIR_WS_ADMIN;
      }
    } else {
      die('</td></tr></table></td></tr></table><br><br><font color="#ff0000"><b>Error!</b></font><br><br><b>Unable to determine connection method on a link!<br><br>Known methods: NONSSL NONSSL<br><br>Function used:<br><br>smn_href_link(\'' . $page . '\', \'' . $parameters . '\', \'' . $connection . '\')</b>');
    }
    
    $first_separator = '?';
    $second_separator = '&';
    $add_on = 'ID=1';
    
    if (smn_not_null($parameters)) {
      $set_add_on = strpos($parameters, 'ID');
      }
    
    if (($GLOBALS ['store_id'] == 1) || ($GLOBALS ['store_id'] == '')){
        if ($parameters == ''){
            $link = $link . $page . '?' . SID;
        } else{
            $link = $link . $page . '?' . $parameters . '&' . SID;
        }
    } else{
        if ($parameters == ''){
            $link = $link . $page . '?' . 'ID=' . $GLOBALS ['store_id'].  '&' . SID ;
        } else{
            $link = $link . $page . '?' . 'ID=' . $GLOBALS ['store_id']. '&' .$parameters . '&' . SID ;
        }
    }

    while ( (substr($link, -1) == '&') || (substr($link, -1) == '?') ) $link = substr($link, 0, -1);

    return $link;
  }

  function smn_catalog_href_link($page = '', $parameters = '', $connection = 'NONSSL') {
    if ($connection == 'NONSSL') {
      $link = HTTP_CATALOG_SERVER . DIR_WS_CATALOG;
    } elseif ($connection == 'NONSSL') {
      if (ENABLE_SSL_CATALOG == 'true') {
        $link = HTTPS_CATALOG_SERVER . DIR_WS_CATALOG;
      } else {
        $link = HTTP_CATALOG_SERVER . DIR_WS_CATALOG;
      }
    } else {
      die('</td></tr></table></td></tr></table><br><br><font color="#ff0000"><b>Error!</b></font><br><br><b>Unable to determine connection method on a link!<br><br>Known methods: NONSSL NONSSL<br><br>Function used:<br><br>smn_href_link(\'' . $page . '\', \'' . $parameters . '\', \'' . $connection . '\')</b>');
    }
    
    $add_on ='';
    if ($parameters == '') {
      $link .= $page;
      $add_on = '?ID=' . $GLOBALS ['store_id'];
    } else {
      $link .= $page . '?' . $parameters;
      $add_on = '&ID=' . $GLOBALS ['store_id'];
    }

    while ( (substr($link, -1) == '&') || (substr($link, -1) == '?') ) $link = substr($link, 0, -1);

    if (($GLOBALS ['store_id'] != '') && ($GLOBALS ['store_id'] != 1) )
    {
        return ($link  . $add_on);
    }
    else
    {
        return ($link);
    }
  }

////
// The HTML image wrapper function
  function smn_image($src, $alt = '', $width = '', $height = '', $params = '') {
    $image = '<img src="' . $src . '" border="0" alt="' . $alt . '"';
    if ($alt) {
      $image .= ' title=" ' . $alt . ' "';
    }
    if ($width) {
      $image .= ' width="' . $width . '"';
    }
    if ($height) {
      $image .= ' height="' . $height . '"';
    }
    if ($params) {
      $image .= ' ' . $params;
    }
    $image .= '>';

    return $image;
  }

////
// The HTML form submit button wrapper function
// Outputs a button in the selected language
  function smn_image_submit($image, $alt = '', $parameters = '') {
    global $language;

    $image_submit = '<input type="image" src="' . smn_output_string(DIR_WS_LANGUAGES . $language . '/images/buttons/' . $image) . '" border="0" alt="' . smn_output_string($alt) . '"';

    if (smn_not_null($alt)) $image_submit .= ' title=" ' . smn_output_string($alt) . ' "';

    if (smn_not_null($parameters)) $image_submit .= ' ' . $parameters;

    $image_submit .= '>';

    return $image_submit;
  }

////
// Draw a 1 pixel black line
  function smn_black_line() {
    return smn_image(DIR_WS_IMAGES . 'pixel_black.gif', '', '100%', '1');
  }

////
// Output a separator either through whitespace, or with an image
  function smn_draw_separator($image = 'pixel_black.gif', $width = '100%', $height = '1') {
    return smn_image(DIR_WS_IMAGES . $image, '', $width, $height);
  }

////
// Output a function button in the selected language
  function smn_image_button($image, $alt = '', $params = '') {
    global $language;

    return smn_image(DIR_WS_LANGUAGES . $language . '/images/buttons/' . $image, $alt, '', '', $params);
  }

////
// javascript to dynamically update the states/provinces list when the country is changed
// TABLES: zones
  function smn_js_zone_list($country, $form, $field) {
    $countries_query = smn_db_query("select distinct zone_country_id from " . TABLE_ZONES . " order by zone_country_id");
    $num_country = 1;
    $output_string = '';
    while ($countries = smn_db_fetch_array($countries_query)) {
      if ($num_country == 1) {
        $output_string .= '  if (' . $country . ' == "' . $countries['zone_country_id'] . '") {' . "\n";
      } else {
        $output_string .= '  } else if (' . $country . ' == "' . $countries['zone_country_id'] . '") {' . "\n";
      }

      $states_query = smn_db_query("select zone_name, zone_id from " . TABLE_ZONES . " where zone_country_id = '" . $countries['zone_country_id'] . "' order by zone_name");

      $num_state = 1;
      while ($states = smn_db_fetch_array($states_query)) {
        if ($num_state == '1') $output_string .= '    ' . $form . '.' . $field . '.options[0] = new Option("' . PLEASE_SELECT . '", "");' . "\n";
        $output_string .= '    ' . $form . '.' . $field . '.options[' . $num_state . '] = new Option("' . $states['zone_name'] . '", "' . $states['zone_id'] . '");' . "\n";
        $num_state++;
      }
      $num_country++;
    }
    $output_string .= '  } else {' . "\n" .
                      '    ' . $form . '.' . $field . '.options[0] = new Option("' . TYPE_BELOW . '", "");' . "\n" .
                      '  }' . "\n";

    return $output_string;
  }

////
// Output a form
  function smn_draw_form($name, $action, $parameters = '', $method = 'post', $params = '') {
    $form = '<form name="' . smn_output_string($name) . '" action="';
    if (smn_not_null($parameters)) {
      $form .= smn_href_link($action, $parameters);
    } else {
      $form .= smn_href_link($action);
    }
    $form .= '" method="' . smn_output_string($method) . '"';
    if (smn_not_null($params)) {
      $form .= ' ' . $params;
    }
    $form .= '>';

    return $form;
  }

////
// Output a form input field
  function smn_draw_input_field($name, $value = '', $parameters = '', $required = false, $type = 'text', $reinsert_value = true) {
    global $HTTP_GET_VARS, $HTTP_POST_VARS;
    $field = '<input type="' . smn_output_string($type) . '" name="' . smn_output_string($name) . '"';

    if ( ($reinsert_value == true) && ( (isset($HTTP_GET_VARS[$name]) && is_string($HTTP_GET_VARS[$name])) || (isset($HTTP_POST_VARS[$name]) && is_string($HTTP_POST_VARS[$name])) ) ) {
      if (isset($HTTP_GET_VARS[$name]) && is_string($HTTP_GET_VARS[$name])) {
	  	$value = stripslashes($HTTP_GET_VARS[$name]);
	  } elseif (isset($HTTP_POST_VARS[$name]) && is_string($HTTP_POST_VARS[$name])) {
    	$value = stripslashes($HTTP_POST_VARS[$name]);
	  }
	}
	if (smn_not_null($value)) {
	  $field .= ' value="' . smn_output_string($value) . '"';
	}  	

    if (smn_not_null($parameters)) $field .= ' ' . $parameters;

    $field .= '>';

    if ($required == true) $field .= TEXT_FIELD_REQUIRED;

    return $field;
  }

////
// Output a form password field
  function smn_draw_password_field($name, $value = '', $required = false) {
    $field = smn_draw_input_field($name, $value, 'maxlength="40"', $required, 'password', false);

    return $field;
  }

////
// Output a form filefield
  function smn_draw_file_field($name, $required = false) {
    $field = smn_draw_input_field($name, '', '', $required, 'file');

    return $field;
  }

////
// Output a selection field - alias function for smn_draw_checkbox_field() and smn_draw_radio_field()
  function smn_draw_selection_field($name, $type, $value = '', $checked = false, $compare = '', $parameter = '') {
    global $HTTP_GET_VARS, $HTTP_POST_VARS;
    $selection = '<input type="' . smn_output_string($type) . '" name="' . smn_output_string($name) . '"';

    if (smn_not_null($value)) $selection .= ' value="' . smn_output_string($value) . '"';

    if ( ($checked == true) || (isset($HTTP_GET_VARS[$name]) && is_string($HTTP_GET_VARS[$name]) && (($HTTP_GET_VARS[$name] == 'on') || (stripslashes($HTTP_GET_VARS[$name]) == $value))) || (isset($HTTP_POST_VARS[$name]) && is_string($HTTP_POST_VARS[$name]) && (($HTTP_POST_VARS[$name] == 'on') || (stripslashes($HTTP_POST_VARS[$name]) == $value))) || (smn_not_null($compare) && ($value == $compare)) ) {
      $selection .= ' CHECKED';
    }

    if ($parameter != '') {
      $selection .= ' ' . $parameter;
    }   
    $selection .= '>';

    return $selection;
  }
  

////
// Output a form checkbox field
  function smn_draw_checkbox_field($name, $value = '', $checked = false, $compare = '', $parameter = '') {
    return smn_draw_selection_field($name, 'checkbox', $value, $checked, $compare, $parameter);
  }

////
// Output a form radio field
  function smn_draw_radio_field($name, $value = '', $checked = false, $compare = '', $parameter = '') {
    return smn_draw_selection_field($name, 'radio', $value, $checked, $compare, $parameter);
  }


////
// Output a form textarea field
  function smn_draw_textarea_field($name, $wrap, $width, $height, $text = '', $parameters = '', $reinsert_value = true) {
    global $HTTP_GET_VARS, $HTTP_POST_VARS;
    $field = '<textarea name="' . smn_output_string($name) . '" wrap="' . smn_output_string($wrap) . '" cols="' . smn_output_string($width) . '" rows="' . smn_output_string($height) . '"';

    if (smn_not_null($parameters)) $field .= ' ' . $parameters;

    $field .= '>';

    if (($reinsert_value == true) && ((isset($HTTP_GET_VARS[$name]) && is_string($HTTP_GET_VARS[$name])) || (isset($HTTP_POST_VARS[$name]) && is_string($HTTP_POST_VARS[$name])) ) ) {
	  if (isset($HTTP_GET_VARS[$name]) && is_string($HTTP_GET_VARS[$name])) {
        $field .= smn_output_string_protected(stripslashes($HTTP_GET_VARS[$name]));
	  } elseif (isset($HTTP_POST_VARS[$name]) && is_string($HTTP_POST_VARS[$name])) {
	    $field .= smn_output_string_protected(stripslashes($HTTP_POST_VARS[$name]));
	  }	
    } elseif (smn_not_null($text)) {
      $field .= $text;
    }

    $field .= '</textarea>';

    return $field;
  }

////
// Output a form hidden field
  function smn_draw_hidden_field($name, $value = '', $parameters = '') {
    global $HTTP_GET_VARS, $HTTP_POST_VARS;
    $field = '<input type="hidden" name="' . smn_output_string($name) . '"';

    if (smn_not_null($value)) {
      $field .= ' value="' . smn_output_string($value) . '"';
    } elseif ( (isset($HTTP_GET_VARS[$name]) && is_string($HTTP_GET_VARS[$name])) || (isset($HTTP_POST_VARS[$name]) && is_string($HTTP_POST_VARS[$name])) ) {
	  if ( (isset($HTTP_GET_VARS[$name]) && is_string($HTTP_GET_VARS[$name])) ) {
        $field .= ' value="' . smn_output_string(stripslashes($HTTP_GET_VARS[$name])) . '"';
	  } elseif ( (isset($HTTP_POST_VARS[$name]) && is_string($HTTP_POST_VARS[$name])) ) {
	    $field .= ' value="' . smn_output_string(stripslashes($HTTP_POST_VARS[$name])) . '"';
	  }	
    }

    if (smn_not_null($parameters)) $field .= ' ' . $parameters;

    $field .= '>';

    return $field;
  }

////

// Hide form elements
  function smn_hide_session_id() {
    $string = '';
	if (defined('SID') && smn_not_null(SID)) {
	  $string = smn_draw_hidden_field(smn_session_name(), smn_session_id());
	}
	return $string;
  }
///

// Output a form pull down menu
  function smn_draw_pull_down_menu($name, $values, $default = '', $parameters = '', $required = false) {
    global $HTTP_GET_VARS, $HTTP_POST_VARS;
    $field = '<select name="' . smn_output_string($name) . '"';

    if (smn_not_null($parameters)) $field .= ' ' . $parameters;

    $field .= '>';

    if (empty($default) && ( (isset($HTTP_GET_VARS[$name]) && is_string($HTTP_GET_VARS[$name])) || (isset($HTTP_POST_VARS[$name]) && is_string($HTTP_POST_VARS[$name])) ) ) {
	  if (isset($HTTP_GET_VARS[$name]) && is_string($HTTP_GET_VARS[$name])) {
	    $default = stripslashes($HTTP_GET_VARS[$name]);
	  } elseif (isset($HTTP_POST_VARS[$name]) && is_string($HTTP_POST_VARS[$name])) {
	    $default = stripslashes($HTTP_POST_VARS[$name]);
	  }
	}

    for ($i=0, $n=sizeof($values); $i<$n; $i++) {
      $field .= '<option value="' . smn_output_string($values[$i]['id']) . '"';
      if ($default == $values[$i]['id']) {
        $field .= ' SELECTED';
      }

      $field .= '>' . smn_output_string($values[$i]['text'], array('"' => '&quot;', '\'' => '&#039;', '<' => '&lt;', '>' => '&gt;')) . '</option>';
    }
    $field .= '</select>';

    if ($required == true) $field .= TEXT_FIELD_REQUIRED;

    return $field;
  }
  
  function smn_draw_mselect_menu($name, $values, $selected_vals, $params = '', $required = false) {
    $field = '<select name="' . $name . '"';
    if ($params) $field .= ' ' . $params;
    $field .= ' multiple>';
    for ($i=0; $i<sizeof($values); $i++) {
	if ($values[$i]['id'])
	{
      	$field .= '<option value="' . $values[$i]['id'] . '"';
      	if ( ((strlen($values[$i]['id']) > 0) && ($GLOBALS[$name] == $values[$i]['id'])) ) {
      	  $field .= ' SELECTED';
      	}
    		else 
		{
			for ($j=0; $j<sizeof($selected_vals); $j++) {
				if ($selected_vals[$j]['id'] == $values[$i]['id'])
				{
			        $field .= ' SELECTED';
				}
			}
		}
	}
      $field .= '>' . $values[$i]['text'] . '</option>';
    }
    $field .= '</select>';

    if ($required) $field .= TEXT_FIELD_REQUIRED;

    return $field;
  }
?>
