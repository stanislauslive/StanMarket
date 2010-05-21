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

  //require(DIR_WS_INCLUDES . 'counter.php');
?>

<!-- footer //-->
<?php
  $boxHeading = BOX_HEADING_FOOTER;;
  $box_base_name = 'footer'; 
  $box_id = $box_base_name . 'Box';
  $boxContent = FOOTER_TEXT_BODY;
    if(file_exists(DIR_WS_BOX_TEMPLATES . $box_base_name . '.php')) {
        require(DIR_WS_BOX_TEMPLATES . $box_base_name . '.php');
    } else {
        require(DEFAULT_TEMPLATENAME_BOX);
    }
  $boxContent_attributes = '';
?>
<!-- footer //-->
