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

  $breadcrumb->add(NAVBAR_TITLE, smn_href_link(FILENAME_AFFILIATE_CLICKS, '', 'NONSSL'));

  $affiliate_clickthroughs_raw = "
    select a.*, pd.products_name from " . TABLE_AFFILIATE_CLICKTHROUGHS . " a 
    left join " . TABLE_PRODUCTS . " p on (p.products_id = a.affiliate_products_id) 
    left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on (pd.products_id = p.products_id and pd.language_id = '" . $languages_id . "') 
    where a.affiliate_id = '" . $affiliate_id . "'  ORDER BY a.affiliate_clientdate desc
    ";
  $affiliate_clickthroughs_split = new splitPageResults($affiliate_clickthroughs_raw, MAX_DISPLAY_SEARCH_RESULTS);

  $affiliate_clickthroughs_numrows_raw = "select count(*) as count from " . TABLE_AFFILIATE_CLICKTHROUGHS . " where affiliate_id = '" . $affiliate_id . "'";
  $affiliate_clickthroughs_query = smn_db_query($affiliate_clickthroughs_numrows_raw);
  $affiliate_clickthroughs_numrows = smn_db_fetch_array($affiliate_clickthroughs_query);
  $affiliate_clickthroughs_numrows =$affiliate_clickthroughs_numrows['count'];

?> 