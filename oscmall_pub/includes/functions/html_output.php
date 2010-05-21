<?php
//echo SEO_ENABLED;
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

////
// The HTML href link wrapper function
  if (SEO_ENABLED == 'true') {
     function smn_href_link($page = '', $parameters = '', $connection = 'NONSSL', $add_session_id = true, $search_engine_safe = true) {
      global $seo_urls;                
       if ( !is_object($seo_urls) ){
          if ( !class_exists('SEO_URL') ){
             include_once(DIR_WS_CLASSES . 'seo.class.php');
          }
          global $languages_id;
          $seo_urls = new SEO_URL($languages_id);
       }
      return $seo_urls->href_link($page, $parameters, $connection, $add_session_id, $search_engine_safe);
     }
  } else {
     function smn_href_link($page = '', $parameters = '', $connection = 'NONSSL', $add_session_id = true, $search_engine_safe = true) {
       global $request_type, $session_started, $SID, $_GET;

       if (!smn_not_null($page)) {
         die('</td></tr></table></td></tr></table><br><br><font color="#ff0000"><b>Error!</b></font><br><br><b>Unable to determine the page link!<br><br>');
       }

       if ($connection == 'NONSSL') {
         $link = HTTP_SERVER . DIR_WS_HTTP_CATALOG;
       } elseif ($connection == 'NONSSL') {
         if (ENABLE_NONSSL == true) {
           $link = HTTPS_SERVER . DIR_WS_HTTPS_CATALOG;
         } else {
           $link = HTTP_SERVER . DIR_WS_HTTP_CATALOG;
         }
       } else {
         die('</td></tr></table></td></tr></table><br><br><font color="#ff0000"><b>Error!</b></font><br><br><b>Unable to determine connection method on a link!<br><br>Known methods: NONSSL NONSSL</b><br><br>');
       }
       $first_separator = '?';
       $second_separator = '&';
       $add_on = 'ID=1';
    
       if (smn_not_null($parameters)) {
         $set_add_on = strpos($parameters, 'ID');
       }
      
       if((isset($_GET['ID'])) && (($_GET['ID'] != '') || ((int)$_GET['ID'] > 0))){
         $add_on = 'ID=' . $_GET['ID'];
       }
    
       if (smn_not_null($parameters)) {
          $link .= $page . '?' . smn_output_string($parameters);
          if($set_add_on === false){
            $link .=  $second_separator . $add_on;
          }
       } else {
          $link .= $page;
          $link .=   $first_separator . $add_on;
       }
    
       while ( (substr($link, -1) == '&') || (substr($link, -1) == '?') ) $link = substr($link, 0, -1);

// Add the session ID when moving from different HTTP and HTTPS servers, or when SID is defined
       if ( ($add_session_id == true) && ($session_started == true) && (SESSION_FORCE_COOKIE_USE == 'False') ) {
          if (smn_not_null($SID)) {
            $_sid = $SID;
          } elseif ( ( ($request_type == 'NONSSL') && ($connection == 'NONSSL') && (ENABLE_NONSSL == true) ) || ( ($request_type == 'NONSSL') && ($connection == 'NONSSL') ) ) {
            if (HTTP_COOKIE_DOMAIN != HTTPS_COOKIE_DOMAIN) {
              $_sid = smn_session_name() . '=' . smn_session_id();
            }
          }
        }

        if ( (SEARCH_ENGINE_FRIENDLY_URLS == 'true') && ($search_engine_safe == true) ) {
          while (strstr($link, '&&')) $link = str_replace('&&', '&', $link);
          $link = str_replace('?', '/', $link);
          $link = str_replace('&', '/', $link);
          $link = str_replace('=', '/', $link);
        }
        if (isset($_sid)) {
          return ($link  . $second_separator . $_sid);
        }else{
          return ($link);
        }
     }
  }


////
// The HTML image wrapper function
  function smn_image($src, $alt = '', $width = '', $height = '', $parameters = '') {
    if ( (empty($src) || ($src == DIR_WS_IMAGES)) && (IMAGE_REQUIRED == 'false') ) {
      return false;
    }

// alt is added to the img tag even if it is null to prevent browsers from outputting
// the image filename as default
    $image = '<img src="' . smn_output_string($src) . '" border="0" alt="' . smn_output_string($alt) . '"';

    if (smn_not_null($alt)) {
      $image .= ' title=" ' . smn_output_string($alt) . ' "';
    }

    if ( (CONFIG_CALCULATE_IMAGE_SIZE == 'true') && (empty($width) || empty($height)) ) {
      if ($image_size = @getimagesize($src)) {
        if (empty($width) && smn_not_null($height)) {
          $ratio = $height / $image_size[1];
          $width = $image_size[0] * $ratio;
        } elseif (smn_not_null($width) && empty($height)) {
          $ratio = $width / $image_size[0];
          $height = $image_size[1] * $ratio;
        } elseif (empty($width) && empty($height)) {
          $width = $image_size[0];
          $height = $image_size[1];
        }
      } elseif (IMAGE_REQUIRED == 'false') {
        return false;
      }
    }

    if (smn_not_null($width) && smn_not_null($height)) {
      $image .= ' width="' . smn_output_string($width) . '" height="' . smn_output_string($height) . '"';
    }

    if (smn_not_null($parameters)) $image .= ' ' . $parameters;

    $image .= '>';

    return $image;
  }

////
// The HTML form submit button wrapper function
// Outputs a button in the selected language
  function smn_image_submit($image, $alt = '', $parameters = '') {
    global $language;

    $image_submit = '<input type="image" src="' . smn_output_string(DIR_WS_BUTTONS . $image) . '" border="0" alt="' . smn_output_string($alt) . '"';

    if (smn_not_null($alt)) $image_submit .= ' title=" ' . smn_output_string($alt) . ' "';

    if (smn_not_null($parameters)) $image_submit .= ' ' . $parameters;

    $image_submit .= '>';

    return $image_submit;
  }

////
// Output a function button in the selected language
  function smn_image_button($image, $alt = '', $parameters = '') {
    global $language;

    return smn_image(DIR_WS_BUTTONS . $image, $alt, '', '', $parameters);
  }

////
// Output a separator either through whitespace, or with an image
  function smn_draw_separator($image = 'pixel_black.gif', $width = '100%', $height = '1') {
    return smn_image(DIR_WS_IMAGES . $image, '', $width, $height);
  }

////
// Output a form
  function smn_draw_form($name, $action, $method = 'post', $parameters = '') {
    $form = '<form name="' . smn_output_string($name) . '" action="' . str_replace('&amp;', '&', smn_output_string($action)) . '" method="' . smn_output_string($method) . '"';

    if (smn_not_null($parameters)) $form .= ' ' . $parameters;

    $form .= '>';

    return $form;
  }

////
// Output a form input field
  function smn_draw_input_field($name, $value = '', $parameters = '', $type = 'text', $reinsert_value = true) {
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

  	$field .= ' value="' . smn_output_string_protected($value) . '"';

 }


    if (smn_not_null($parameters)) $field .= ' ' . $parameters;

    $field .= '>';

    return $field;
  }

////
// Output a form password field
  function smn_draw_password_field($name, $value = '', $parameters = 'maxlength="40"') {
    return smn_draw_input_field($name, $value, $parameters, 'password', false);
  }

////
// Output a selection field - alias function for smn_draw_checkbox_field() and smn_draw_radio_field()
  function smn_draw_selection_field($name, $type, $value = '', $checked = false, $parameters = '') {
    global $HTTP_GET_VARS, $HTTP_POST_VARS;
    $selection = '<input type="' . smn_output_string($type) . '" name="' . smn_output_string($name) . '"';

    if (smn_not_null($value)) $selection .= ' value="' . smn_output_string($value) . '"';

    if ( ($checked == true) || (isset($HTTP_GET_VARS[$name]) && is_string($HTTP_GET_VARS[$name]) && (($HTTP_GET_VARS[$name] == 'on') || (stripslashes($HTTP_GET_VARS[$name]) == $value))) || (isset($HTTP_POST_VARS[$name]) && is_string($HTTP_POST_VARS[$name]) && (($HTTP_POST_VARS[$name] == 'on') || (stripslashes($HTTP_POST_VARS[$name]) == $value))) ) {      
      $selection .= ' CHECKED';
    }

    if (smn_not_null($parameters)) $selection .= ' ' . $parameters;

    $selection .= '>';

    return $selection;
  }

////
// Output a form checkbox field
  function smn_draw_checkbox_field($name, $value = '', $checked = false, $parameters = '') {
    return smn_draw_selection_field($name, 'checkbox', $value, $checked, $parameters);
  }

////
// Output a form radio field
  function smn_draw_radio_field($name, $value = '', $checked = false, $parameters = '') {
    return smn_draw_selection_field($name, 'radio', $value, $checked, $parameters);
  }

////
// Output a form textarea field
  function smn_draw_textarea_field($name, $wrap, $width, $height, $text = '', $parameters = '', $reinsert_value = true) {
    global $HTTP_GET_VARS, $HTTP_POST_VARS;
    $field = '<textarea name="' . smn_output_string($name) . '" wrap="' . smn_output_string($wrap) . '" cols="' . smn_output_string($width) . '" rows="' . smn_output_string($height) . '"';

    if (smn_not_null($parameters)) $field .= ' ' . $parameters;

    $field .= '>';

// systemsmanager begin - Dec 1, 2005 security patch		
/*
    if ( (isset($GLOBALS[$name])) && ($reinsert_value == true) ) {
      $field .= stripslashes($GLOBALS[$name]);
    } elseif (smn_not_null($text)) {
      $field .= $text;
    }
*/
if ( ($reinsert_value == true) && ( (isset($HTTP_GET_VARS[$name]) && is_string($HTTP_GET_VARS[$name])) || (isset($HTTP_POST_VARS[$name]) && is_string($HTTP_POST_VARS[$name])) ) ) {
	if (isset($HTTP_GET_VARS[$name]) && is_string($HTTP_GET_VARS[$name])) {
  		$field .= smn_output_string_protected(stripslashes($HTTP_GET_VARS[$name]));
  	} elseif (isset($HTTP_POST_VARS[$name]) && is_string($HTTP_POST_VARS[$name])) {
		$field .= smn_output_string_protected(stripslashes($HTTP_POST_VARS[$name]));
	}
} elseif (smn_not_null($text)) {

  $field .= smn_output_string_protected($text);

}

// systemsmanager end

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
    global $session_started, $SID;

    if (($session_started == true) && smn_not_null($SID)) {
      return smn_draw_hidden_field(smn_session_name(), smn_session_id());
    }
  }

////
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

////
// Creates a pull-down list of countries
  function smn_get_country_list($name, $selected = '', $parameters = '') {
    $countries_array = array(array('id' => '', 'text' => PULL_DOWN_DEFAULT));
    $countries = smn_get_countries();

    for ($i=0, $n=sizeof($countries); $i<$n; $i++) {
      $countries_array[] = array('id' => $countries[$i]['countries_id'], 'text' => $countries[$i]['countries_name']);
    }

    return smn_draw_pull_down_menu($name, $countries_array, $selected, $parameters);
  }
  
  ////
// Output a form filefield
  function smn_draw_file_field($name, $required = false) {
    $field = smn_draw_input_field($name, '', '', 'file');

    return $field;
  }

?>
