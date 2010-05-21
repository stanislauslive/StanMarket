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
<!-- languages //-->

<?php
//  $info_box_contents = array();
//  $info_box_contents[] = array('text' => BOX_HEADING_LANGUAGES);

//  new infoBoxHeading($info_box_contents, false, false, '', $side);

  if (!isset($lng) || (isset($lng) && !is_object($lng))) {
    include(DIR_WS_CLASSES . 'language.php');
    $lng = new language;
  }

  $languages_string = '';
  reset($lng->catalog_languages);
  while (list($key, $value) = each($lng->catalog_languages)) {
    $languages_string .= ' <a href="' . smn_href_link(basename($PHP_SELF), smn_get_all_get_params(array('language', 'currency')) . 'language=' . $key, $request_type) . '">' . smn_image(DIR_WS_LANGUAGES .  /* $value['directory'] . */ '/images/' . $value['image'], $value['name']) . '</a> ';
  }

  $info_box_contents = array();
  $info_box_contents[] = array('align' => 'center',
                               'text' => $languages_string);

  new infoBox($info_box_contents, $side);
?>

<!-- languages_eof //-->
