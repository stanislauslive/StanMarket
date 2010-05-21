<?php
/*
  $Id: lang.php,v 1  December 13, 2003
  
  developed for
  osCommerce, Open Source E-Commerce Solutions
  http://www.com-host.com

  Copyright (c) 2003 http://www.com-host.com

Supported by osCommerce  

  Released under the GNU General Public License
*/

  if (!isset($lng) || (isset($lng) && !is_object($lng))) {
    include(DIR_WS_CLASSES . 'language.php');
    $lng = new language;
  }

  $languages_string = '';
  reset($lng->catalog_languages);
  while (list($key, $value) = each($lng->catalog_languages)) {
    $languages_string .= ' <a href="' . smn_href_link(basename($PHP_SELF), smn_get_all_get_params(array('language', 'currency')) . 'language=' . $key, $request_type) . '">' . smn_image(DIR_WS_LANGUAGES .  $value['directory'] . '/images/' . $value['image'], $value['name']) . '</a> ';
  }

  $info_box_contents = array();
  $info_box_contents[] = array('align' => 'center', 'valign' => 'bottom',
                               'text' => $languages_string);

  new LangBox($info_box_contents);

?>