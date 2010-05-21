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
  $boxHeading = "";
  $box_base_name = 'side_banner';
  $box_id = $box_base_name . 'Box'; 
  
  $boxContent = '';
   if ($banner = smn_banner_exists('dynamic', 'Side', isset($_GET['products_id']) ? $_GET['products_id'] : 0, isset($_GET['cPath']) ? $_GET['cPath'] : 0) ) {
		$boxContent = smn_display_banner('static', $banner);
	}

  if(file_exists(DIR_WS_BOX_TEMPLATES . $box_base_name . '.php')){
      require(DIR_WS_BOX_TEMPLATES . $box_base_name . '.php');
  }else {
      require(DEFAULT_TEMPLATENAME_BOX);
  }
  $boxContent_attributes = '';
?>
