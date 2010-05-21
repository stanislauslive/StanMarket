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
  $newsletter_query = smn_db_query("select affiliate_newsletter from " . TABLE_AFFILIATE . " where affiliate_id = '" . (int)$affiliate_id . "'");
  $newsletter = smn_db_fetch_array($newsletter_query);

  if (isset($_POST['action']) && ($_POST['action'] == 'process')) {
    if (isset($_POST['newsletter_affiliate']) && is_numeric($_POST['newsletter_affiliate'])) {
      $newsletter_affiliate = smn_db_prepare_input($_POST['newsletter_affiliate']);
    } else {
      $newsletter_affiliate = '0';
    }

    if ($newsletter_affiliate != $newsletter['affiliate_newsletter']) {
      $newsletter_affiliate = (($newsletter['affiliate_newsletter'] == '1') ? '0' : '1');

      smn_db_query("update " . TABLE_AFFILIATE . " set affiliate_newsletter = '" . (int)$newsletter_affiliate . "' where affiliate_id = '" . (int)$affiliate_id . "'");
    }

    $messageStack->add_session('account', SUCCESS_NEWSLETTER_UPDATED, 'success');

    smn_redirect(smn_href_link(FILENAME_AFFILIATE_SUMMARY, '', 'NONSSL'));
  }

  $breadcrumb->add(NAVBAR_TITLE_1, smn_href_link(FILENAME_AFFILIATE_SUMMARY, '', 'NONSSL'));
  $breadcrumb->add(NAVBAR_TITLE_2, smn_href_link(FILENAME_AFFILIATE_NEWSLETTER, '', 'NONSSL'));
?> 