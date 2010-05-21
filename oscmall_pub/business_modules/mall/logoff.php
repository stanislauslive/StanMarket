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


  $breadcrumb->add(NAVBAR_TITLE);
  if(smn_session_is_registered('customer_store_id')) smn_session_unregister('customer_store_id');
  smn_session_unregister('customer_id');
  smn_session_unregister('customer_default_address_id');
  smn_session_unregister('customer_first_name');
  smn_session_unregister('customer_country_id');
  smn_session_unregister('customer_zone_id');
  smn_session_unregister('affiliate_ref');
  smn_session_unregister('affiliate_clickthroughs_id');
  smn_session_unregister('affiliate_id');
  smn_session_unregister('affiliate_email');
  smn_session_unregister('affiliate_name');
  smn_session_unregister('comments');
  smn_session_unregister('gv_id');
  smn_session_unregister('cc_id');
  
  $cart->reset();
  smn_redirect(smn_href_link(FILENAME_DEFAULT, '', 'NONSSL'));
?>