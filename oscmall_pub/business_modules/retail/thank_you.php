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

   global $page_name; 

  $switch_store = 'TRUE';  
  smn_session_unregister('switch_store_id');
  smn_session_register('switch_store_id');
  $switch_store_id = (intval($_GET['newID']));

   if ($store_id == 1)
  {
      smn_redirect(smn_href_link(FILENAME_GOTO_STORE, 'newID=' . $switch_store_id));
  }

  $breadcrumb->add(NAVBAR_TITLE, smn_href_link(FILENAME_THANK_YOU)); 
?>