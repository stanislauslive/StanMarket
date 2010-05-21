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

  $error = false;

/*
  if ( (isset($_POST['store_category']) && empty($_POST['store_category'])) &&
       (isset($_POST['dfrom']) && (empty($_POST['dfrom']) || ($_POST['dfrom'] == DOB_FORMAT_STRING))) &&
       (isset($_POST['dto']) && (empty($_POST['dto']) || ($_POST['dto'] == DOB_FORMAT_STRING))) &&
       (isset($_POST['pfrom']) && !is_numeric($_POST['pfrom'])) &&
       (isset($_POST['pto']) && !is_numeric($_POST['pto'])) ) {
*/
//echo "store:".$_POST['store_category'].":category:".$_POST['product_category'].":descrip:".$_POST['product_description'].":<br>";
  if ((isset($_POST['store_category']) && $_POST['store_category']==0) &&
      (isset($_POST['product_category']) && $_POST['product_category']==0) &&
	  (isset($_POST['product_description']) && empty($_POST['product_description']))) {
    $error = true;
    $messageStack->add_session('search', ERROR_AT_LEAST_ONE_INPUT);
  } else {
  }


  if ($error == true) {
    smn_redirect(smn_href_link(FILENAME_ADVANCED_SEARCH, 'ID='.$store_id .'&' . smn_get_all_get_params(), 'NONSSL', true, false));
  }

  $breadcrumb->add(NAVBAR_TITLE_1, smn_href_link(FILENAME_ADVANCED_SEARCH));
  $breadcrumb->add(NAVBAR_TITLE_2, smn_href_link(FILENAME_ADVANCED_SEARCH_RESULT, smn_get_all_get_params(), 'NONSSL', true, false));

?>