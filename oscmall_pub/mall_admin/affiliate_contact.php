<?php
/*
  Copyright (c) 2002 - 2005 SystemsManager.Net

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

  require('includes/application_top.php');

  if ( ($_GET['action'] == 'send_email_to_user') && ($_POST['affiliate_email_address']) && (!$_POST['back_x']) ) {
    switch ($_POST['affiliate_email_address']) {
      case '***':
	  /*Changed the query to get the values from customer table, by cimi*/
        /*$mail_query = smn_db_query("select affiliate_firstname, affiliate_lastname, affiliate_email_address from " . TABLE_AFFILIATE . " ");*/
        $mail_query = smn_db_query("select customers_firstname, customers_lastname, customers_email_address from " . TABLE_AFFILIATE . " a,".TABLE_CUSTOMERS." c where a.affiliate_customer_id=c.customers_id ");
        $mail_sent_to = TEXT_ALL_AFFILIATES;
        break;
//      case '**D':
//        $mail_query = smn_db_query("select affiliate_firstname, affiliate_lastname, affiliate_email_address from " . TABLE_AFFILIATE . " where affiliate_newsletter = '1'");
//        $mail_sent_to = TEXT_NEWSLETTER_AFFILIATE;
//        break;
      default:
        $affiliate_email_address = smn_db_prepare_input($_POST['affiliate_email_address']);
	  /*Changed the query to get the values from customer table, by cimi*/
        /*$mail_query = smn_db_query("select affiliate_firstname, affiliate_lastname, affiliate_email_address from " . TABLE_AFFILIATE . " where affiliate_email_address = '" . smn_db_input($affiliate_email_address) . "'");*/
        $mail_query = smn_db_query("select customers_firstname, customers_lastname, customers_email_address from " . TABLE_CUSTOMERS . "  where customers_email_address = '" . smn_db_input($affiliate_email_address) . "'");
        $mail_sent_to = $_POST['affiliate_email_address'];
        break;
    }

    $from = smn_db_prepare_input($_POST['from']);
    $subject = smn_db_prepare_input($_POST['subject']);
    $message = smn_db_prepare_input($_POST['message']);

    // Instantiate a new mail object
    $mimemessage = new email(array('X-Mailer: osCommerce'));

    // Build the text version
    $text = strip_tags($text);
    if (EMAIL_USE_HTML == 'true') {
      $mimemessage->add_html($message);
    } else {
      $mimemessage->add_text($message);
    }

    // Send message
    $mimemessage->build_message();
    while ($mail = smn_db_fetch_array($mail_query)) {
	/*Changed the parameters to get the values from customer table,by Cimi*/
      /*$mimemessage->send($mail['affiliate_firstname'] . ' ' . $mail['affiliate_lastname'], $mail['affiliate_email_address'], '', $from, $subject);*/
      $mimemessage->send($mail['customers_firstname'] . ' ' . $mail['customers_lastname'], $mail['customers_email_address'], '', $from, $subject);
    }

    smn_redirect(smn_href_link(FILENAME_AFFILIATE_CONTACT, 'mail_sent_to=' . urlencode($mail_sent_to)));
  }

  if ( ($_GET['action'] == 'preview') && (!$_POST['affiliate_email_address']) ) {
    $messageStack->add(ERROR_NO_AFFILIATE_SELECTED, 'error');
  }

  if (smn_not_null($_GET['mail_sent_to'])) {
    $messageStack->add(sprintf(NOTICE_EMAIL_SENT_TO, $_GET['mail_sent_to']), 'notice');
  }
  
  $content_page = basename($_SERVER['PHP_SELF']);
  
  require('templates/default/layout.php');

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
