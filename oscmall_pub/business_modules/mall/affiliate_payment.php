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

  
  if (!smn_session_is_registered('affiliate_id')) {
    $navigation->set_snapshot();
    smn_redirect(smn_href_link(FILENAME_AFFILIATE, '', 'NONSSL'));
  }

  $breadcrumb->add(NAVBAR_TITLE, smn_href_link(FILENAME_AFFILIATE_PAYMENT, '', 'NONSSL'));

  $affiliate_payment_raw = "
    select p.* , s.affiliate_payment_status_name 
           from " . TABLE_AFFILIATE_PAYMENT . " p, " . TABLE_AFFILIATE_PAYMENT_STATUS . " s 
           where p.affiliate_payment_status = s.affiliate_payment_status_id 
           and s.affiliate_language_id = '" . $languages_id . "' 
           and p.affiliate_id =  '" . $affiliate_id . "' 
           order by p.affiliate_payment_id DESC
           ";

  $affiliate_payment_split = new splitPageResults($affiliate_payment_raw, MAX_DISPLAY_SEARCH_RESULTS);
?> 