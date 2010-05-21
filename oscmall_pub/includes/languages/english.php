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

global $page_name, $language, $store_id;

@setlocale(LC_TIME, 'en_US.ISO_8859-1');

define('DATE_FORMAT_SHORT', '%m/%d/%Y');  // this is used for strftime()
define('DATE_FORMAT_LONG', '%A %d %B, %Y'); // this is used for strftime()
define('DATE_FORMAT', 'm/d/Y'); // this is used for date()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');

define('HEAD_REPLY_TAG_ALL', $store->get_store_owner_email_address());

////
// Return date in raw format
// $date should be in format mm/dd/yyyy
// raw date is in format YYYYMMDD, or DDMMYYYY
function smn_date_raw($date, $reverse = false) {
  if ($reverse) {
    return substr($date, 3, 2) . substr($date, 0, 2) . substr($date, 6, 4);
  } else {
    return substr($date, 6, 4) . substr($date, 0, 2) . substr($date, 3, 2);
  }
}

// if USE_DEFAULT_LANGUAGE_CURRENCY is true, use the following currency, instead of the applications default currency (used when changing language)
define('LANGUAGE_CURRENCY', 'USD');

    //get the text files from the DB used throughout the site

  if (ALLOW_STORE_SITE_TEXT == 'true'){
    $store_language_condition = " and store_id = '" . $store_id . "'";
  }else{
    $store_language_condition =  " and store_id = '1'";
  }
  
  $content_query_all = smn_db_query("select text_key, text_content from " . TABLE_WEB_SITE_CONTENT . " where language_id = '" . $languages_id . "'" . $store_language_condition . " AND ( page_name = '" . $page_name . "' OR page_name = 'all' )") ;
    while ($all_contents = smn_db_fetch_array($content_query_all)){
        define($all_contents['text_key'], stripslashes($all_contents['text_content']));
    }
  define('MODULE_PAYMENT_PAYPAL_IPN_TEXT_TITLE', 'Credit/Debit Card (via PayPal)');
  define('MODULE_PAYMENT_PAYPAL_IPN_TEXT_DESCRIPTION', 'PayPal IPN');

  // Sets the text for the "continue" button on the PayPal Payment Complete Page
  // Maximum of 60 characters!  
  define('CONFIRMATION_BUTTON_TEXT', 'Complete your Order Confirmation');
  
define('EMAIL_PAYPAL_PENDING_NOTICE', 'Your payment is currently pending. We will send you a copy of your order once the payment has cleared.');
  
define('EMAIL_TEXT_SUBJECT', 'Order Process');
define('EMAIL_TEXT_ORDER_NUMBER', 'Order Number:');
define('EMAIL_TEXT_INVOICE_URL', 'Detailed Invoice:');
define('EMAIL_TEXT_DATE_ORDERED', 'Date Ordered:');
define('EMAIL_TEXT_PRODUCTS', 'Products');
define('EMAIL_TEXT_SUBTOTAL', 'Sub-Total:');
define('EMAIL_TEXT_TAX', 'Tax:        ');
define('EMAIL_TEXT_SHIPPING', 'Shipping: ');
define('EMAIL_TEXT_TOTAL', 'Total:    ');
define('EMAIL_TEXT_DELIVERY_ADDRESS', 'Delivery Address');
define('EMAIL_TEXT_BILLING_ADDRESS', 'Billing Address');
define('EMAIL_TEXT_PAYMENT_METHOD', 'Payment Method');

define('EMAIL_SEPARATOR', '------------------------------------------------------');
define('TEXT_EMAIL_VIA', 'via'); 
define('EMAIL_TEXT_SUBJECT', 'Order Update');
define('EMAIL_TEXT_ORDER_NUMBER', 'Order Number:');
define('EMAIL_TEXT_INVOICE_URL', 'Detailed Invoice:');
define('EMAIL_TEXT_DATE_ORDERED', 'Date Ordered:');
define('EMAIL_TEXT_STATUS_UPDATE', 'Your order has been updated to the following status.' . "\n\n" . 'New status: %s' . "\n\n" . 'Please reply to this email if you have any questions.' . "\n");
define('EMAIL_TEXT_COMMENTS_UPDATE', 'The comments for your order are' . "\n\n%s\n\n");

define('PAYPAL_ADDRESS', 'Customer PayPal address');

/* If you want to include a message with the order email, enter text here: */
/* Use \n for line breaks */
define('MODULE_PAYMENT_PAYPAL_IPN_TEXT_EMAIL_FOOTER', '');
    
//get the java language info
  $content_query_java = smn_db_query("select text_key, text_content from " . TABLE_WEB_SITE_CONTENT . " where language_id = '" . $languages_id . "' AND page_name = 'java' " . $store_language_condition);
    while ($java_contents = smn_db_fetch_array($content_query_java)){
      define($java_contents['text_key'], stripslashes($java_contents['text_content']));
    }
    
define('ENTRY_FIRST_NAME_ERROR', 'Your First Name must contain a minimum of ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' characters.');
define('ENTRY_LAST_NAME_ERROR', 'Your Last Name must contain a minimum of ' . ENTRY_LAST_NAME_MIN_LENGTH . ' characters.');
define('ENTRY_EMAIL_ADDRESS_ERROR', 'Your E-Mail Address must contain a minimum of ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' characters.');
define('ENTRY_STREET_ADDRESS_ERROR', 'Your Street Address must contain a minimum of ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' characters.');
define('ENTRY_POST_CODE_ERROR', 'Your Post Code must contain a minimum of ' . ENTRY_POSTCODE_MIN_LENGTH . ' characters.');
define('ENTRY_CITY_ERROR', 'Your City must contain a minimum of ' . ENTRY_CITY_MIN_LENGTH . ' characters.');
define('ENTRY_STATE_ERROR', 'Your State must contain a minimum of ' . ENTRY_STATE_MIN_LENGTH . ' characters.');
define('ENTRY_TELEPHONE_NUMBER_ERROR', 'Your Telephone Number must contain a minimum of ' . ENTRY_TELEPHONE_MIN_LENGTH . ' characters.');
define('ENTRY_PASSWORD_ERROR', 'Your Password must contain a minimum of ' . ENTRY_PASSWORD_MIN_LENGTH . ' characters.');
define('ENTRY_PASSWORD_CURRENT_ERROR', 'Your Password must contain a minimum of ' . ENTRY_PASSWORD_MIN_LENGTH . ' characters.');
define('ENTRY_PASSWORD_NEW_ERROR', 'Your new Password must contain a minimum of ' . ENTRY_PASSWORD_MIN_LENGTH . ' characters.');

define('TEXT_REVIEW_BY', 'by %s');
define('TEXT_REVIEW_WORD_COUNT', '%s words');
define('TEXT_REVIEW_RATING', 'Rating: %s [%s]');
define('TEXT_REVIEW_DATE_ADDED', 'Date Added: %s');

//Images
define('IMAGE_ICON_EDIT', 'Edit');
define('IMAGE_ICON_DELETE', 'Delete');
define('IMAGE_CANCEL', 'Cancel');
define('IMAGE_UPDATE', 'Update');
define('IMAGE_DELETE', 'Delete');
define('IMAGE_INSERT', 'Insert');
define('ICON_FOLDER', 'Folder');
define('IMAGE_BACK', 'Back');

// constants for use in smn_prev_next_display function
define('TEXT_RESULT_PAGE', 'Result Pages:');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> products)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> orders)');
define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> reviews)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> new products)');
define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> specials)');
define('TEXT_DISPLAY_NUMBER_OF_COUNTRIES', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> countries)');
define('TEXT_DISPLAY_NUMBER_OF_TAX_CLASSES', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> tax classes)');
define('TEXT_DISPLAY_NUMBER_OF_TAX_ZONES', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> tax zones)');
define('TEXT_DISPLAY_NUMBER_OF_TAX_RATES', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> tax rates)');
define('TEXT_DISPLAY_NUMBER_OF_ZONES', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> zones)');

define('PREVNEXT_TITLE_PAGE_NO', 'Page %d');
define('PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE', 'Previous Set of %d Pages');
define('PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE', 'Next Set of %d Pages');
define('PREVNEXT_BUTTON_FIRST', '&lt;&lt;FIRST');
define('PREVNEXT_BUTTON_PREV', '[&lt;&lt;&nbsp;Prev]');
define('PREVNEXT_BUTTON_NEXT', '[Next&nbsp;&gt;&gt;]');
define('PREVNEXT_BUTTON_LAST', 'LAST&gt;&gt;');

define('TEXT_REVIEW_BY', 'by %s');
define('TEXT_REVIEW_WORD_COUNT', '%s words');
define('TEXT_REVIEW_RATING', 'Rating: %s [%s]');
define('TEXT_REVIEW_DATE_ADDED', 'Date Added: %s');
define('TEXT_NO_REVIEWS', 'There are currently no product reviews.');
define('BOX_REVIEWS_TEXT_OF_5_STARS', '%s of 5 Stars!');

define('BOX_NOTIFICATIONS_NOTIFY', 'Notify me of updates to <b>%s</b>');
define('BOX_NOTIFICATIONS_NOTIFY_REMOVE', 'Do not notify me of updates to <b>%s</b>');
define('BOX_MANUFACTURER_INFO_HOMEPAGE', '%s Homepage');

define('TEXT_NO_NEW_PRODUCTS', 'There are currently no products.');
define('TEXT_UNKNOWN_TAX_RATE', 'Unknown tax rate');
define('TEXT_REQUIRED', '<span class="errorText">Required</span>');
define('TEXT_MAIN', 'This is a <b>closed online-shop, any products purchased will not be delivered nor billed</b>. <br>Any information seen on these products are to be treated fictional.<br>This shop is based on <font color="#f0000"><b>' . PROJECT_VERSION . '</b></font>.');

define('ERROR_SMN_MAIL', '<font face="Verdana, Arial" size="2" color="#ff0000"><b><small>smn ERROR:</small> Cannot send the email through the specified SMTP server. Please check your php.ini setting and correct the SMTP server if necessary.</b></font>');
define('WARNING_INSTALL_DIRECTORY_EXISTS', 'Warning: Installation directory exists at: ' . dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']) . '/install. Please remove this directory for security reasons.');
define('WARNING_CONFIG_FILE_WRITEABLE', 'Warning: I am able to write to the configuration file: ' . dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']) . '/includes/configure.php. This is a potential security risk - please set the right user permissions on this file.');
define('WARNING_SESSION_DIRECTORY_NON_EXISTENT', 'Warning: The sessions directory does not exist: ' . smn_session_save_path() . '. Sessions will not work until this directory is created.');
define('WARNING_SESSION_DIRECTORY_NOT_WRITEABLE', 'Warning: I am not able to write to the sessions directory: ' . smn_session_save_path() . '. Sessions will not work until the right user permissions are set.');
define('WARNING_SESSION_AUTO_START', 'Warning: session.auto_start is enabled - please disable this php feature in php.ini and restart the web server.');
define('WARNING_DOWNLOAD_DIRECTORY_NON_EXISTENT', 'Warning: The downloadable products directory does not exist: ' . DIR_FS_DOWNLOAD . '. Downloadable products will not work until this directory is valid.');
define('WARNING_STORE_IS_CLOSED', 'Warning: this Store is currently closed, please see use durning regular business hours.');

define('TEXT_CCVAL_ERROR_INVALID_DATE', 'The expiry date entered for the credit card is invalid.<br>Please check the date and try again.');
define('TEXT_CCVAL_ERROR_INVALID_NUMBER', 'The credit card number entered is invalid.<br>Please check the number and try again.');
define('TEXT_CCVAL_ERROR_UNKNOWN_CARD', 'The first four digits of the number entered are: %s<br>If that number is correct, we do not accept that type of credit card.<br>If it is wrong, please try again.');

define('TEXT_GREETING_PERSONAL', 'Welcome back <span class="greetUser">%s!</span> Would you like to see which <a href="%s"><u>new products</u></a> are available to purchase?');
define('TEXT_GREETING_PERSONAL_RELOGON', '<small>If you are not %s, please <a href="%s"><u>log yourself in</u></a> with your account information.</small>');
define('TEXT_GREETING_GUEST', 'Welcome <span class="greetUser">Guest!</span> Would you like to <a href="%s"><u>log yourself in</u></a>? <br>Or would you prefer to <a href="%s"><u>create an account</u></a>?');
define('ENTRY_AFFILIATE_ACCEPT_AGB_TEXT', '<a href="' . smn_href_link('affiliate_terms.php', '') . '" target="_blank">Affiliate Agent Program Conditions</a>');

switch ($page_name){
case "affiliate_faq":
define('TEXT_INFORMATION', '' . MALL_NAME . ' has compiled this info so that you may be better informed about our Affiliate Agent program.<br>
 If you have any questions please <a href="' . smn_href_link(FILENAME_AFFILIATE_CONTACT). '">' . BOX_AFFILIATE_CONTACT . '</a> for more information.<br>
<ul>
<li><a href="' . smn_href_link(FILENAME_AFFILIATE_FAQ) . '#1">Question 1?</a>
<li><a href="' . smn_href_link(FILENAME_AFFILIATE_FAQ) . '#2">Question 2?</a>
<li><a href="' . smn_href_link(FILENAME_AFFILIATE_FAQ) . '#3">Question 3?</a>
<li><a href="' . smn_href_link(FILENAME_AFFILIATE_FAQ) . '#4">Question 4?</a>
<li><a href="' . smn_href_link(FILENAME_AFFILIATE_FAQ) . '#5">Question 5?</a>
<li><a href="' . smn_href_link(FILENAME_AFFILIATE_FAQ) . '#6">Question 6?</a>
<li><a href="' . smn_href_link(FILENAME_AFFILIATE_FAQ) . '#7">Question 7?</a>
<li><a href="' . smn_href_link(FILENAME_AFFILIATE_FAQ) . '#8">Question 8?</a>
<li><a href="' . smn_href_link(FILENAME_AFFILIATE_FAQ) . '#9">Question 9?</a>
<li><a href="' . smn_href_link(FILENAME_AFFILIATE_FAQ) . '#10">Question 10?</a>
<li><a href="' . smn_href_link(FILENAME_AFFILIATE_FAQ) . '#11">Question 11?</a>
<li><a href="' . smn_href_link(FILENAME_AFFILIATE_FAQ) . '#12">Question 12?</a>
</ul>
<hr width ="90%">
<BR>
<FONT COLOR="#000000" size="4"><B><U>Frequently Asked Questions</U></B></FONT>
<p style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"><font color="white">Question 1?</font><a name="1"></a><br>
Answer 1.</p>
<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"><a href="' . smn_href_link(FILENAME_AFFILIATE_FAQ) . '#0">top</a></p>
<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0">&nbsp;</p>
<p style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"><font color="white">Question 2?</font><a name="2"></a><br>
Answer 2.</p>
<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"><a href="' . smn_href_link(FILENAME_AFFILIATE_FAQ) . '#0">top</a></p>
<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0">&nbsp;</p>
<p style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"><font color="white">Question 3?</font><a name="3"></a><br>
Answer 3.</p>
<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"><a href="' . smn_href_link(FILENAME_AFFILIATE_FAQ) . '#0">top</a></p>
<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0">&nbsp;</p>
<p style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"><font color="white">Question 4?</font><a name="4"></a><br>
Answer 4.</p>
<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"><a href="' . smn_href_link(FILENAME_AFFILIATE_FAQ) . '#0">top</a></p>
<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0">&nbsp;</p>
<p style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"><font color="white">Question 5?</font><a name="5"></a><br>
Answer 5.</p>
<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"><a href="' . smn_href_link(FILENAME_AFFILIATE_FAQ) . '#0">top</a></p>
<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0">&nbsp;</p>
<p style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"><font color="white">Question 6?</font><a name="6"></a><br>
Answer 6.</p>
<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"><a href="' . smn_href_link(FILENAME_AFFILIATE_FAQ) . '#0">top</a></p>
<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0">&nbsp;</p>
<p style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"><font color="white">Question 7?</font><a name="7"></a><br>
Answer 7.</p>
<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"><a href="' . smn_href_link(FILENAME_AFFILIATE_FAQ) . '#0">top</a></p>
<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0">&nbsp;</p>
<p style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"><font color="white">Question 8?</font><a name="8"></a><br>
Answer 8.</p>
<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"><a href="' . smn_href_link(FILENAME_AFFILIATE_FAQ) . '#0">top</a></p>
<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0">&nbsp;</p>
<p style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"><font color="white">Question 9?</font><a name="9"></a><br>
Answer 9.</p>
<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"><a href="' . smn_href_link(FILENAME_AFFILIATE_FAQ) . '#0">top</a></p>
<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0">&nbsp;</p>
<p style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"><font color="white">Question 10?</font><a name="10"></a><br>
Answer 10.</p>
<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"><a href="' . smn_href_link(FILENAME_AFFILIATE_FAQ) . '#0">top</a></p>
<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0">&nbsp;</p>
<p style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"><font color="white">Question 11?</font><a name="11"></a><br>
Answer 11.</p>
<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"><a href="' . smn_href_link(FILENAME_AFFILIATE_FAQ) . '#0">top</a></p>
<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0">&nbsp;</p>
<p style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"><font color="white">Question 12?</font><a name="12"></a><br>
Answer 12.</p>
<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"><a href="' . smn_href_link(FILENAME_AFFILIATE_FAQ) . '#0">top</a></p>
<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0">&nbsp;</p>
');
break;

case "affiliate_clicks":
define('TEXT_DISPLAY_NUMBER_OF_CLICKS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> clickthroughs)');
break;

case "affiliate_info":
define('HEADING_AFFILIATE_PROGRAM_TITLE', 'The ' . MALL_NAME . ' Affiliate Agent Program');
break;

case "affiliate_sales":
define('TEXT_DISPLAY_NUMBER_OF_SALES', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> sales)');
break;

case "affiliate_password_forgotten":
define('EMAIL_PASSWORD_REMINDER_SUBJECT', MALL_NAME . ' - New Affiliate Agent Password');
define('EMAIL_PASSWORD_REMINDER_BODY', 'A new Affiliate Agent password was requested from ' . $REMOTE_ADDR . '.' . "\n\n" . 'Your new Affiliate Agent password to \'' . MALL_NAME . '\' is:' . "\n\n" . '   %s' . "\n\n");
break;

case "affiliate_affiliate":
define('TEXT_NEW_AFFILIATE_INTRODUCTION', 'By creating an Affiliate Agent account at ' . MALL_NAME . ' you will be able to earn valuable travel and rebates.');
break;

case "affiliate_signup":
define('MAIL_AFFILIATE_ID', 'Your Affiliate Agent ID is: ');
define('MAIL_AFFILIATE_USERNAME', 'Your Affiliate Agent Username is: ');
define('MAIL_AFFILIATE_PASSWORD', 'Your Password is: ');
define('MAIL_AFFILIATE_LINK', 'Link to your account here:');
define('MAIL_AFFILIATE_FOOTER', 'Have fun earning referal fees! Your Affiliate Agent Team');
define('MESSAGE_AGENT', 'You are invited to read the <a href="' . smn_href_link(FILENAME_AFFILIATE_TERMS, '') . '" target="_blank">Affiliate Agent Program Conditions</a> before signing up. Thank you.');
define('MAIL_AFFILIATE_SUBJECT', 'Welcome to the Affiliate Agent Program');
define('MAIL_AFFILIATE_HEADER', 'Dear Affiliate Agent,

thank you for joining the Affiliate Agent Program.

Your Account Information:
*************************
');
break;

case "affiliate_terms":
define('HEADING_AFFILIATE_PROGRAM_TITLE', 'The ' . MALL_NAME . ' Affiliate Agent Terms');
break;

case "affiliate_signup_ok":
define('TEXT_ACCOUNT_CREATED', 'Congratulations! Your new Affiliate Agent account application has been submitted! You will shortly receive an email containing important information regarding your Affiliate Agent Account, including you Affiliate Agent login details. If you have not received it within the hour, please <a href="' . smn_href_link(FILENAME_AFFILIATE_CONTACT) . '">contact us</a>.<br><br>If you have <small><b>ANY</b></small> questions about the Affiliate Agent program, please <a href="' . smn_href_link(FILENAME_AFFILIATE_CONTACT) . '">contact us</a>.');
break;

case "affiliate_payment":
define('TEXT_DISPLAY_NUMBER_OF_PAYMENTS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> payments)');
break;

case "account_history_info":		//account_history_info.php   
define('HEADING_ORDER_NUMBER', 'Order #%s');
break;

case "account_edit":		//account_edit.php   
define('ERROR_IMAGE_FILE_SIZE_EXCEED', 'The image file can be up to %s bytes! Please go to the admin area in order to add a new image.');
break;

case "address_book":		//address_book.php
define('TEXT_MAXIMUM_ENTRIES', '<font color="#ff0000"><b>NOTE:</b></font> A maximum of %s address book entries allowed.');
define('TEXT_MAXIMUM_ENTRIES_REACHED', '<font color="#ff0000"><b>NOTE:</b></font> Maximum of %s address book entries reached.');
break;

case "product_info":		//product_info.php
define('TEXT_MORE_INFORMATION', 'For more information, please visit this products <a href="%s" target="_blank"><u>webpage</u></a>.');
define('TEXT_DATE_ADDED', 'This product was added to our catalog on %s.');
define('TEXT_DATE_AVAILABLE', '<font color="#ff0000">This product will be in stock on %s.</font>');
break;

case "product_reviews":             //product_reviews.php
case "product_reviews_info":		//product_reviews_info.php
define('HEADER_TITLE', '%s Reviews');
define('TEXT_OF_5_STARS', '%s of 5 Stars!');
break;


case "reviews":		//reviews.php
define('TEXT_OF_5_STARS', '%s of 5 Stars!');
break;

case "tell_a_friend":             //tell_a_friend.php
define('HEADER_TITLE', 'Tell A Friend About \'%s\'');
define('TEXT_EMAIL_SUCCESSFUL_SENT', 'Your email about <b>%s</b> has been successfully sent to <b>%s</b>.');
define('TEXT_EMAIL_SUBJECT', 'Your friend %s has recommended this great product from %s');
define('TEXT_EMAIL_INTRO', 'Hi %s! "\n\n" Your friend, %s, thought that you would be interested in %s from %s.');
define('TEXT_EMAIL_LINK', 'To view the product click on the link below or copy and paste the link into your web browser:"\n\n" %s');
define('TEXT_EMAIL_SIGNATURE', 'Regards,"\n\n" %s');
break;

   
case "checkout_address":  //checkout_address.php
define('TEXT_MAXIMUM_ENTRIES_REACHED', '<font color="#ff0000"><b>NOTE:</b></font> Can\'t add new entries - maximum of ' . MAX_ADDRESS_BOOK_ENTRIES . ' address book entries reached.');
break;

case "checkout_confirmation":		//checkout_confirmation.php
define('SUB_TITLE_TAX', 'Tax %s%%:');
define('TEXT_STOCK_WARNING_DESC', 'The products marked with <span class="markProductOutOfStock">' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . '</span> are not available in the quantity you requested. Choose Multiple Shipments if you want the available quantity in stock to be delivered right away and the rest later or Single Shipment to wait until the quantity you requested is available in our stock.');
break;


case "checkout_process":	
define('EMAIL_TEXT_MEMBER_PRODUCT', 'We have added you as a member to our growing base of store vendors.' . "\n\n" . 'We hope your ecommerce experience with ' . MALL_NAME . ' is both rewarding and hassle free.' . "\n\n" . 'This membership will be billed to you next : ');
break;

case "checkout_success":		//checkout_success.php
define('TEXT_SEE_ORDERS', 'You can view your order history by going to the <a href="' . smn_href_link(FILENAME_ACCOUNT, '', 'NONSSL') . '">\'My Account\'</a> page and by clicking on <a href="' . smn_href_link(FILENAME_ACCOUNT_HISTORY, '', 'NONSSL') . '">\'History\'</a>.');
define('TEXT_CONTACT_STORE_OWNER', 'Please direct any questions you have to the <a href="' . smn_href_link(FILENAME_CONTACT_US) . '">store owner</a>.');
break;

case "create_account":		//create_account_process.php
define('TEXT_ORIGIN_LOGIN', '<font color="#FF0000"><small><b>NOTE:</b></font></small> If you already have an account with us, please login at the <a href="%s"><u>login page</u></a>.');  
define('EMAIL_SUBJECT', 'Welcome to ' . MALL_NAME);
define('EMAIL_GREET_MR', 'Dear Mr. ' . stripslashes($_POST['lastname']) . ',' . "\n\n");
define('EMAIL_GREET_MS', 'Dear Ms. ' . stripslashes($_POST['lastname']) . ',' . "\n\n");
define('EMAIL_GREET_NONE', 'Dear ' . stripslashes($_POST['firstname']) . ',' . "\n\n");
define('EMAIL_WELCOME', 'We welcome you to <b>' . MALL_NAME . '</b>.' . "\n\n");
define('EMAIL_CONTACT', 'For help with any of our online services, please email the mall administration: ' . MALL_EMAIL_ADDRESS . '.' . "\n\n");
define('EMAIL_WARNING', '<b>Note:</b> This email address was given to us by one of our customers. If you did not signup to be a vendor in our mall, please send a email to ' . MALL_EMAIL_ADDRESS . '.' . "\n");
define('EMAIL_GV_INCENTIVE_HEADER', "\n\n" .'As part of our welcome to new customers, we have sent you an e-Gift Tokens worth %s');
define('EMAIL_GV_REDEEM', 'The redeem code for the e-Gift Tokens is %s, you can enter the redeem code when checking out while making a purchase');
break;

case "create_account_success":		//create_account_success
define('TEXT_ACCOUNT_CREATED', 'Congratulations! Your new account has been successfully created! You can now take advantage of member priviledges to enhance your online shopping experience with us. If you have <small><b>ANY</b></small> questions about the operation of this online shop, please email the <a href="' . smn_href_link(FILENAME_CONTACT_US) . '">mall administration</a>.<br><br>A confirmation has been sent to the provided email address. If you have not received it within the hour, please <a href="' . smn_href_link(FILENAME_CONTACT_US) . '">contact us</a>.');
break;


case "index":		//default.php
  define('TABLE_HEADING_NEW_PRODUCTS', 'New Products For %s');
  define('TEXT_NO_PRODUCTS', 'There are no products to list in this category.');
  define('TEXT_NO_PRODUCTS2', 'There is no product available from this manufacturer.');
if ($category_depth == 'products' || $_GET['manufacturers_id']) {
  define('HEADING_TITLE', 'Let\'s See What We Have Here');
  define('TABLE_HEADING_IMAGE', '');
  define('TABLE_HEADING_MODEL', 'Model');
  define('TABLE_HEADING_PRODUCTS', 'Product Name');
  define('TABLE_HEADING_MANUFACTURER', 'Manufacturer');
  define('TABLE_HEADING_QUANTITY', 'Quantity');
  define('TABLE_HEADING_PRICE', 'Price');
  define('TABLE_HEADING_WEIGHT', 'Weight');
  define('TABLE_HEADING_BUY_NOW', 'Buy Now');

  define('TEXT_NUMBER_OF_PRODUCTS', 'Number of Products: ');
  define('TEXT_SHOW', '<b>Show:</b>');
  define('TEXT_BUY', 'Buy 1 \'');
  define('TEXT_NOW', '\' now');
  define('TEXT_ALL', 'All');
} elseif ($category_depth == 'top') {
  define('HEADING_TITLE', 'What\'s New Here?');
} elseif ($category_depth == 'nested') {
  define('HEADING_TITLE', 'Categories');
}
break;

case "login":		//login.php

define('TEXT_NEW_CUSTOMER_INTRODUCTION', 'By creating an account at ' . MALL_NAME . ' you will be able to shop faster, be up to date on an orders status, and keep track of the orders you have previously made.');
break;

case "password_forgotten":		//password_forgotten .php

define('EMAIL_PASSWORD_REMINDER_SUBJECT', MALL_NAME . ' - New Password');
define('EMAIL_PASSWORD_REMINDER_BODY', 'A new password was requested from ' . $REMOTE_ADDR . '.' . "\n\n" . 'Your new password to \'' . MALL_NAME . '\' is:' . "\n\n" . '   %s' . "\n\n");
break;

case "shopping_cart":		//shopping_cart.php

define('OUT_OF_STOCK_CANT_CHECKOUT', 'Products marked with ' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . ' dont exist in desired quantity in our stock.<br>Please alter the quantity of products marked with (' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . '), Thank you');
define('OUT_OF_STOCK_CAN_CHECKOUT', 'Products marked with ' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . ' dont exist in desired quantity in our stock.<br>You can buy them anyway and check the quantity we have in stock for immediate deliver in the checkout process.');
break;

case "create_store_account":		//create_store_account.php

define('EMAIL_SUBJECT', 'Welcome to ' . MALL_NAME);
define('EMAIL_GREET_MR', 'Dear Mr. ' . stripslashes($_POST['lastname']) . ',' . "\n\n");
define('EMAIL_GREET_MS', 'Dear Ms. ' . stripslashes($_POST['lastname']) . ',' . "\n\n");
define('EMAIL_GREET_NONE', 'Dear ' . stripslashes($_POST['firstname']) . ',' . "\n\n");
define('EMAIL_WELCOME', 'We welcome you to <b>' . MALL_NAME . '</b>.' . "\n\n");
define('ERROR_IMAGE_FILE_SIZE_EXCEED', 'The image file can be up to %s bytes! Please go to the admin area in order to add a new image.');


define('EMAIL_TEXT', 'You can now take part in the <b>various services</b> we have to offer you. Some of these services include:' . "\n\n" .
                     '<li><b>Permanent Cart</b> - Any customer items added to the online cart remain there until they remove them, or check them out.' . "\n" .
                     '<li><b>Free Product Listing</b> - We offer your business free listings without limit within our mall! This is perfect to market your services on a broad scale.' . "\n" .
                     '<li><b>Order History</b> - View history of purchases that you have been made with us from your free listing.' . "\n" .
                     '<li><b>Stores Reviews</b> - So customers can share opinions on your services with other customers.' . "\n\n");
define('EMAIL_STORE_CONTACT', 'For help with any of our online services, please email the mall-owner: ' . MALL_EMAIL_ADDRESS . '.' . "\n\n");
define('EMAIL_STORE_WARNING', '<b>Note:</b> This email address was given to us by one of our customers. If you did not signup to be a vendor at our mall, please send an email to ' . MALL_EMAIL_ADDRESS . '.' . "\n");



break;


case "create_store_account_products":		//create_store_account_products.php
case "account_products":		//account_products.php

$PRODUCTS_TYPE[] = array( 'id' => '0', 'text' => 'Please Select');
$PRODUCTS_TYPE[] = array( 'id' => '1', 'text' => 'New');
$PRODUCTS_TYPE[] = array( 'id' => '2', 'text' => 'Used');
$PRODUCTS_TYPE[] = array( 'id' => '3', 'text' => 'Good Condition');
$PRODUCTS_TYPE[] = array( 'id' => '4', 'text' => 'Fair Condition');
break;


case "thank_you":		//thank_you.php

define('TEXT_THANK_YOU_FOR_SHOPPING_HERE','Thank you for shopping here at the '. $store->get_store_name() .' store.  We hope you found what you were looking for.  If you have any questions, please feel free to Contact Us.  We look forward to serving you in the future.');
define('TEXT_BUY_PRODUCTS_IN_CART','You currently have products in your shopping cart.  If you leave this store they will will no longer be in your cart.  Do you wish to purchase them prior to leaving the ' . $store->get_store_name() .' store?');
define('TEXT_RETURN_TO_SHOPPING_HERE','Do you want to <b>go back</b>. and continue shopping in the ' . $store->get_store_name() .' store?');
break;

case "gv_redeem":		//gv_redeem.php
define('TEXT_INFORMATION', 'For more information regarding Gift Toekns, please see our <a href="' . smn_href_link(FILENAME_GV_FAQ,'','NONSSL').'">'.GV_FAQ.'.</a>');
define('TEXT_VALID_GV', 'Congratulations, you have redeemed Gift Tokens worth %s');
break;


case "gv_send":		//gv_redeem.php
define('EMAIL_SUBJECT', 'Enquiry from ' . STORE_NAME);
define('HEADING_TEXT','<br>Please enter below the details for the Tokens you wish to send. For more information, please see our <a href="' . smn_href_link(FILENAME_GV_FAQ,'','NONSSL').'">'.GV_FAQ.'.</a><br>');
define('EMAIL_GV_SEND_TO', 'Hi, %s');
define('EMAIL_GV_REDEEM', 'To redeem these tokens, please click on the link below. Please also write down the redemption code which is %s. In case you have problems.');
define('EMAIL_GV_TEXT_HEADER', 'Congratulations, You have received Gift Tokens worth %s');
define('EMAIL_GV_TEXT_SUBJECT', 'A gift from %s');
define('EMAIL_GV_FROM', 'These Gift Tokens has been sent to you by %s');
define('MAIN_MESSAGE', 'You have decided to post a gift Tokens worth %s to %s who\'s email address is %s<br><br>The text accompanying the email will read<br><br>Dear %s<br><br>You have been sent Gift Tokens worth %s by %s');
define('PERSONAL_MESSAGE', '%s says');

break;

case "gv_faq":		//gv_faq.php
define('TEXT_INFORMATION', '<a name="Top"></a>
  <a href="'.smn_href_link(FILENAME_GV_FAQ,'faq_item=1','NONSSL').'">Purchasing Gift Tokens</a><br>
  <a href="'.smn_href_link(FILENAME_GV_FAQ,'faq_item=2','NONSSL').'">How to send Gift Tokens</a><br>
  <a href="'.smn_href_link(FILENAME_GV_FAQ,'faq_item=3','NONSSL').'">Buying with Gift Tokens</a><br>
  <a href="'.smn_href_link(FILENAME_GV_FAQ,'faq_item=4','NONSSL').'">Redeeming Gift Tokens</a><br>
  <a href="'.smn_href_link(FILENAME_GV_FAQ,'faq_item=5','NONSSL').'">When problems occur</a><br>
');
switch ($_GET['faq_item']) {
  case '1':
define('SUB_HEADING_TITLE','Purchasing Gift Tokens.');
define('SUB_HEADING_TEXT','Gift Tokens are purchased just like any other item in our store. You can 
  pay for them using the stores standard payment method(s).
  Once purchased the value of the Gift Tokens will be added to your own personal 
  Gift Tokens Account. If you have funds in your Gift Tokens Account, you will 
  notice that the amount now shows in he Shopping Cart box, and also provides a 
  link to a page where you can send the Gift Tokens to some one via email.');
  break;
  case '2':
define('SUB_HEADING_TITLE','How to Send Gift Tokens.');
define('SUB_HEADING_TEXT','To send a Gift Tokens that you have purchased, you need to go to our Send Gift Tokens Page. You can
  find the link to this page in the Shopping Cart Box in the right hand column of 
  each page.
  When you send a Gift Tokens, you need to specify the following:<br> <br>
  The name of the person you are sending the Gift Tokens to.<br>
  The email address of the person you are sending the Gift Tokens to.<br>
  The amount you want to send. (Note you don\'t have to send the full amount that 
  is in your Gift Tokens Account.) <br>
  A short message which will apear in the email.<br><br>
  Please ensure that you have entered all of the information correctly, although 
  you will be given the opportunity to change this as much as you want before 
  the email is actually sent.');  
  break;
  case '3':
  define('SUB_HEADING_TITLE','Buying with Gift Tokens.');
  define('SUB_HEADING_TEXT','If you have funds in your Gift Tokens Account, you can use those funds to 
  purchase other items in our store. At the checkout stage, an extra box will
  appear. Clicking this box will apply those funds in your Gift Tokens Account.
  Please note, you will still have to select another payment method if there 
  is not enough in your Gift Tokens Account to cover the cost of your purchase. 
  If you have more funds in your Gift Tokens Account than the total cost of 
  your purchase the balance will be left in you Gift Tokens Account for the
  future.');
  break;
  case '4':
  define('SUB_HEADING_TITLE','Redeeming Gift Tokens.');
  define('SUB_HEADING_TEXT','If you receive a Gift Tokens by email it will contain details of who sent 
  you the Gift Tokens, along with possibly a short message from them. The Email 
  will also contain the Gift Tokens Number. It is probably a good idea to print 
  out this email for future reference. You can now redeem the Gift Tokens in 
  two ways.<br>
  1. By clicking on the link contained within the email for this express purpose.
  This will take you to the store\'s Redeem Tokens page. you will the be requested 
  to create an account, before the Gift Tokens is validated and placed in your 
  Gift Tokens Account ready for you to spend it on whatever you want.<br>
  2. During the checkout procces, on the same page that you select a payment method 
there will be a box to enter a Redeem Code. Enter the code here, and click the redeem button. The code will be
validated and added to your Gift Tokens account. You Can then use the amount to purchase any item from our store');
  break;
  case '5':
  define('SUB_HEADING_TITLE','When problems occur.');
  define('SUB_HEADING_TEXT','For any queries regarding the Gift Tokens System, please contact the store 
  by email at '. STORE_OWNER_EMAIL_ADDRESS . '. Please make sure you give 
  as much information as possible in the email. ');
  break;
  default:
  define('SUB_HEADING_TITLE','');
  define('SUB_HEADING_TEXT','Please choose from one of the questions above.');

  }
  break;
  
  case 'store_product_categories':
    define('HEADING_TITLE', 'Product Categories');
    define('HEADING_TITLE_SEARCH', 'Search');
    define('HEADING_TITLE_GOTO', 'Goto');
    define('TABLE_HEADING_CATEGORIES_PRODUCTS', 'Categories');
    define('TABLE_HEADING_STATUS', 'Staus');
    define('TABLE_HEADING_ACTION', 'Action');
    define('IMAGE_NEW_CATEGORY', 'New Category');
    define('TEXT_CATEGORIES', 'Categories');
    define('TEXT_PRODUCTS', 'Products');
	define('TEXT_TOP', 'Top');
	define('TEXT_NONE', '--none--');	
	
	define('IMAGE_ICON_MOVE', 'Move Category');
	define('IMAGE_ICON_COPY', 'Copy');
	define('IMAGE_SAVE', 'Save');
	define('IMAGE_MOVE', 'Move');
	define('IMAGE_NEW_PRODUCT', 'New Product');
	define('IMAGE_PREVIEW', 'Preview');	
	define('IMAGE_COPY', 'Copy');
	
	define('TEXT_EDIT_INTRO', 'Please make any necessary changes');
	define('TEXT_EDIT_CATEGORIES_ID', 'Category ID:');
	define('TEXT_EDIT_CATEGORIES_NAME', 'Category Name:');
	define('TEXT_EDIT_CATEGORIES_DESCRIPTION', 'Category Description:');
	define('TEXT_EDIT_CATEGORIES_IMAGE', 'Category Image:');
	define('TEXT_EDIT_SORT_ORDER', 'Sort Order:');
	define('TEXT_MAIN_CATEGORIES', 'Add into Main Mall Category: ');
	define('TEXT_INFO_COPY_TO_INTRO', 'Please choose a new category you wish to copy this product to');
	define('TEXT_INFO_CURRENT_CATEGORIES', 'Current Categories:');
	
	define('TEXT_INFO_HEADING_NEW_CATEGORY', 'New Category');
	define('TEXT_INFO_HEADING_EDIT_CATEGORY', 'Edit Category');
	define('TEXT_INFO_HEADING_DELETE_CATEGORY', 'Delete Category');
	define('TEXT_INFO_HEADING_MOVE_CATEGORY', 'Move Category');
	define('TEXT_INFO_HEADING_DELETE_PRODUCT', 'Delete Product');
	define('TEXT_INFO_HEADING_MOVE_PRODUCT', 'Move Product');
	define('TEXT_INFO_HEADING_COPY_TO', 'Copy To');
	
	define('TEXT_PRODUCT_METTA_INFO', '<b>Meta Tag Information</b>');
	define('TEXT_PRODUCTS_PAGE_TITLE', 'Products Page Title:');
	define('TEXT_PRODUCTS_HEADER_DESCRIPTION', 'Page Header Description:');
	define('TEXT_PRODUCTS_KEYWORDS', 'Product Keywords:');
	define('TEXT_CATEGORY_PAGE_TITLE', 'Header Tags Category Title');
	define('TEXT_CATEGORY_HEADER_DESCRIPTION', 'Header Tags Category Description');
	define('TEXT_CATEGORY_KEYWORDS', 'Header Tags Category Keywords');
	
	define('TEXT_NEW_CATEGORY_INTRO', 'Please fill out the following information for the new category');
	define('TEXT_CATEGORIES_NAME', 'Category Name:');
	define('TEXT_CATEGORIES_IMAGE', 'Category Image:');
	define('TEXT_SORT_ORDER', 'Sort Order:');
	
	define('TEXT_DELETE_CATEGORY_INTRO', 'Are you sure you want to delete this category?');
	define('TEXT_DELETE_PRODUCT_INTRO', 'Are you sure you want to permanently delete this product?');
	
	define('TEXT_MOVE_PRODUCTS_INTRO', 'Please select which category you wish <b>%s</b> to reside in');
	define('TEXT_MOVE_CATEGORIES_INTRO', 'Please select which category you wish <b>%s</b> to reside in');
	define('TEXT_MOVE', 'Move <b>%s</b> to:');
	
	define('TEXT_DELETE_WARNING_CHILDS', '<b>WARNING:</b> There are %s (child-)categories still linked to this category!');
	define('TEXT_DELETE_WARNING_PRODUCTS', '<b>WARNING:</b> There are %s products still linked to this category!');
	
	define('TEXT_NEW_PRODUCT', 'New Product in &quot;%s&quot;');
	define('TEXT_CATEGORIES', 'Categories:');
	define('TEXT_SUBCATEGORIES', 'Subcategories:');
	define('TEXT_PRODUCTS', 'Products:');
	define('TEXT_PRODUCTS_PRICE_INFO', 'Price:');
	define('TEXT_PRODUCTS_TAX_CLASS', 'Tax Class:');
	define('TEXT_PRODUCTS_AVERAGE_RATING', 'Average Rating:');
	define('TEXT_PRODUCTS_QUANTITY_INFO', 'Quantity:');
	define('TEXT_DATE_ADDED', 'Date Added:');
	define('TEXT_DATE_AVAILABLE', 'Date Available:');
	define('TEXT_LAST_MODIFIED', 'Last Modified:');
	define('TEXT_IMAGE_NONEXISTENT', 'IMAGE DOES NOT EXIST');
	define('TEXT_NO_CHILD_CATEGORIES_OR_PRODUCTS', 'Please insert a new category in this level.');
	define('TEXT_PRODUCT_MORE_INFORMATION', 'For more information, please visit this products <a href="http://%s" target="blank"><u>webpage</u></a>.');
	define('TEXT_PRODUCT_DATE_ADDED', 'This product was added to our catalog on %s.');
	define('TEXT_PRODUCT_DATE_AVAILABLE', 'This product will be in stock on %s.');
	
	define('TEXT_PRODUCTS_STATUS', 'Products Status:');
	define('TEXT_PRODUCTS_DATE_AVAILABLE', 'Date Available:');
	define('TEXT_PRODUCT_AVAILABLE', 'In Stock');
	define('TEXT_PRODUCT_NOT_AVAILABLE', 'Out of Stock');
	define('TEXT_PRODUCTS_MANUFACTURER', 'Products Manufacturer:');
	define('TEXT_PRODUCTS_NAME', 'Products Name:');
	define('TEXT_PRODUCTS_DESCRIPTION', 'Products Description:');
	define('TEXT_PRODUCTS_QUANTITY', 'Products Quantity:');
	define('TEXT_PRODUCTS_MODEL', 'Products Model:');
	define('TEXT_PRODUCTS_IMAGE', 'Products Image:');
	define('TEXT_PRODUCTS_URL', 'Products URL:');
	define('TEXT_PRODUCTS_URL_WITHOUT_HTTP', '<small>(without http://)</small>');
	define('TEXT_PRODUCTS_PRICE_NET', 'Products Price (Net):');
	define('TEXT_PRODUCTS_PRICE_GROSS', 'Products Price (Gross):');
	define('TEXT_PRODUCTS_WEIGHT', 'Products Weight:');
	
	define('TAB_NAME', 'Name ');
	define('TAB_DESC', 'Description ');
	define('TAB_PRICE', 'Price ');
	define('TAB_IMG', 'Image');
	
	define('TEXT_HOW_TO_COPY', 'Copy Method:');
	define('TEXT_COPY_AS_LINK', 'Link product');
	define('TEXT_COPY_AS_DUPLICATE', 'Duplicate product');

   break;
   
  case 'store_text_editor':
	define('HEADING_TITLE', 'Store Text Editor');
	define('NAVBAR_TITLE', 'Store Text Editor');
	define('TEXT_SITE_INFO_HEADING', 'To use this Text Editor, click on the osc page link,
	 this will bring you to the next page which lists all of the text contained on that page.  With this Editor, your site text is displayed with html enbedded.  
	Edit your store text to how you want it.  <b>Do not use</b> embedded php code with this system, since all of the text is  
	contained in a db table, and this currently is not compatable with php embedded code.  For addition information email <a href="mailto:pmcgrath@systemsmanager.net"><b><font size=2>SystemsManager Support</b></font></a>');
	define('TEXT_SITE_INTRO_HEADING','Welcome to Systemsmanager Technologies oscMall site text content editor system.  With this System you can add in new pages, alter the text throughout the site and add in new site pages (ie privacy, about us etc.).
       Find below three links, Web Site Text Editor, which allows you to edit the site text.  The Web Site information pages allows for adding in and editing of existing site information pages.  The Web articles allows
       you to add in articles of Interest to your site.');
	define('TABLE_HEADING_TEXTNAME', 'Name');
	define('TABLE_HEADING_TEXTNAME', 'Text Name');
	define('TABLE_HEADING_TEXTCONTENT', 'Text Contents');
	define('TABLE_HEADING_GROUP', 'Page Name');
	define('TABLE_HEADING_LAST_MODIFIED', 'Last Modified');
	define('TABLE_HEADING_INTRO', 'Choose An Action Below');
	define('TEXT_PAGE_INFO_HEADING', 'This is the text contained on the page.  Click on the desired text to edit, 
	and the next page will allow you to edit the selected text on the page.  For addition information email <a href="mailto:pmcgrath@systemsmanager.net"><b><font size=2>SystemsManager Support</b></font></a>');
	
	define('TEXT_FILE_CONTENTS', '<b><h3>Text Content Editor: </h3></b><p>This page allows text to be edited.  <b>DO NOT</b> embed php within this editor, since at present it is not compatable with this cms system.  For addition information email <a href="mailto:pmcgrath@systemsmanager.net"><b><font size=2>Peter McGrath</b></font></a>');
	define('TEXT_LAST_MODIFIED', 'Last Modified:');
	define('TEXT_CURRENT_TEXT', '<b>Currently the Text is as follows:<b>');
	
	define('TEXT_SITE_INFO_PAGE_HEADING','Listed below are the different web pages that are contained in this catagory.  To edit the
       page simply click on the appropriate link.  To add a new page under this catagory use the new page button');
	
	define('NEW_TEXT_SITE_INFO_PAGE_HEADING','This page sets up the new page title and page text required');
	define('NEW_TEXT_HEADER_TITLE','Page Body Title');
	define('NEW_TEXT_PAGE_NAVBAR','Navigation Bar text');
	define('NEW_TEXT_PAGE_TITLE','Window title text');
	define('NEW_TEXT_ARTICLE_REQUIREMENT','**not required for an existing catagory article**');
	define('NEW_TEXT_WEB_PAGE_REQUIREMENT','**This is required for a <b>New Web Page</b>**');
	define('NEW_TEXT_ARTICLE_TITLE','Title of Article');
	define('NEW_TEXT_PAGE_NAME','Create New Page Catagory');
	define('TABLE_HEADING_TEXTKEY','Key Defined');
	define('TABLE_HEADING_PAGE_NAME','Page name');
	define('TABLE_HEADING_TEXT_TITLE','Title of Page Body');
	define('CURRENT_TEXT_PAGE_NAME','Use Current Catagories');
	define('NEW_TEXT_HEADING_TITLE','Title of New Page ');
	define('NEW_TEXT_KEY_TITLE','Text tag name for page ');
	define('NEW_TEXT_KEY_REQUIREMENT','**This is required for a <b>New Web Page</b>**');
	
	define('TEXT_NEW_FOLDER_INTRO', 'Enter the name for the new folder:');
	define('TABLE_HEADING_DELETE','Delete Page ');
	define('TEXT_SITE_DELETE_HEADING','Confirm Page Deletion ');
	
	define('TEXT_NONE', '--none--');
		
	define('IMAGE_SAVE', 'Save');
	define('IMAGE_NEW', 'New');
	
	
  break;
  case 'countries':
  	define('HEADING_TITLE', 'Countries');

	define('TABLE_HEADING_COUNTRY_NAME', 'Country');
	define('TABLE_HEADING_COUNTRY_CODES', 'ISO Codes');
	define('TABLE_HEADING_ACTION', 'Action');
	
	define('TEXT_INFO_EDIT_INTRO', 'Please make any necessary changes');
	define('TEXT_INFO_COUNTRY_NAME', 'Name:');
	define('TEXT_INFO_COUNTRY_CODE_2', 'ISO Code (2):');
	define('TEXT_INFO_COUNTRY_CODE_3', 'ISO Code (3):');
	define('TEXT_INFO_ADDRESS_FORMAT', 'Address Format:');
	define('TEXT_INFO_INSERT_INTRO', 'Please enter the new country with its related data');
	define('TEXT_INFO_DELETE_INTRO', 'Are you sure you want to delete this country?');
	define('TEXT_INFO_HEADING_NEW_COUNTRY', 'New Country');
	define('TEXT_INFO_HEADING_EDIT_COUNTRY', 'Edit Country');
	define('TEXT_INFO_HEADING_DELETE_COUNTRY', 'Delete Country');
	define('IMAGE_NEW_COUNTRY', 'New Country');
	
	break;
  case 'zones':
	define('HEADING_TITLE', 'Zones');

	define('TABLE_HEADING_COUNTRY_NAME', 'Country');
	define('TABLE_HEADING_ZONE_NAME', 'Zones');
	define('TABLE_HEADING_ZONE_CODE', 'Code');
	define('TABLE_HEADING_ACTION', 'Action');
	
	define('TEXT_INFO_EDIT_INTRO', 'Please make any necessary changes');
	define('TEXT_INFO_ZONES_NAME', 'Zones Name:');
	define('TEXT_INFO_ZONES_CODE', 'Zones Code:');
	define('TEXT_INFO_COUNTRY_NAME', 'Country:');
	define('TEXT_INFO_INSERT_INTRO', 'Please enter the new zone with its related data');
	define('TEXT_INFO_DELETE_INTRO', 'Are you sure you want to delete this zone?');
	define('TEXT_INFO_HEADING_NEW_ZONE', 'New Zone');
	define('TEXT_INFO_HEADING_EDIT_ZONE', 'Edit Zone');
	define('TEXT_INFO_HEADING_DELETE_ZONE', 'Delete Zone');
	define('IMAGE_NEW_ZONE', 'New Zone');
	
break;
  case 'tax_zones':
	define('HEADING_TITLE', 'Tax Zones');
	
	define('TABLE_HEADING_COUNTRY', 'Country');
	define('TABLE_HEADING_COUNTRY_ZONE', 'Zone');
	define('TABLE_HEADING_TAX_ZONES', 'Tax Zones');
	define('TABLE_HEADING_ACTION', 'Action');
	
	define('TEXT_INFO_HEADING_NEW_ZONE', 'New Zone');
	define('TEXT_INFO_NEW_ZONE_INTRO', 'Please enter the new zone information');
	
	define('TEXT_INFO_HEADING_EDIT_ZONE', 'Edit Zone');
	define('TEXT_INFO_EDIT_ZONE_INTRO', 'Please make any necessary changes');
	
	define('TEXT_INFO_HEADING_DELETE_ZONE', 'Delete Zone');
	define('TEXT_INFO_DELETE_ZONE_INTRO', 'Are you sure you want to delete this zone?');
	
	define('TEXT_INFO_HEADING_NEW_SUB_ZONE', 'New Sub Zone');
	define('TEXT_INFO_NEW_SUB_ZONE_INTRO', 'Please enter the new sub zone information');
	
	define('TEXT_INFO_HEADING_EDIT_SUB_ZONE', 'Edit Sub Zone');
	define('TEXT_INFO_EDIT_SUB_ZONE_INTRO', 'Please make any necessary changes');
	
	define('TEXT_INFO_HEADING_DELETE_SUB_ZONE', 'Delete Sub Zone');
	define('TEXT_INFO_DELETE_SUB_ZONE_INTRO', 'Are you sure you want to delete this sub zone?');
	
	define('TEXT_INFO_DATE_ADDED', 'Date Added:');
	define('TEXT_INFO_LAST_MODIFIED', 'Last Modified:');
	define('TEXT_INFO_ZONE_NAME', 'Zone Name:');
	define('TEXT_INFO_NUMBER_ZONES', 'Number of Zones:');
	define('TEXT_INFO_ZONE_DESCRIPTION', 'Description:');
	define('TEXT_INFO_COUNTRY', 'Country:');
	define('TEXT_INFO_COUNTRY_ZONE', 'Zone:');
	define('TYPE_BELOW', 'All Zones');
	define('PLEASE_SELECT', 'All Zones');
	define('TEXT_ALL_COUNTRIES', 'All Countries');

break;
  case 'tax_classes':
	define('HEADING_TITLE', 'Tax Classes');
	
	define('TABLE_HEADING_TAX_CLASSES', 'Tax Classes');
	define('TABLE_HEADING_ACTION', 'Action');
	
	define('TEXT_INFO_EDIT_INTRO', 'Please make any necessary changes');
	define('TEXT_INFO_CLASS_TITLE', 'Tax Class Title:');
	define('TEXT_INFO_CLASS_DESCRIPTION', 'Description:');
	define('TEXT_INFO_DATE_ADDED', 'Date Added:');
	define('TEXT_INFO_LAST_MODIFIED', 'Last Modified:');
	define('TEXT_INFO_INSERT_INTRO', 'Please enter the new tax class with its related data');
	define('TEXT_INFO_DELETE_INTRO', 'Are you sure you want to delete this tax class?');
	define('TEXT_INFO_HEADING_NEW_TAX_CLASS', 'New Tax Class');
	define('TEXT_INFO_HEADING_EDIT_TAX_CLASS', 'Edit Tax Class');
	define('TEXT_INFO_HEADING_DELETE_TAX_CLASS', 'Delete Tax Class');
	define('IMAGE_NEW_TAX_CLASS', 'New Tax Class');
	
break;
  case 'tax_rates':
	define('HEADING_TITLE', 'Tax Rates');
	
	define('TABLE_HEADING_TAX_RATE_PRIORITY', 'Priority');
	define('TABLE_HEADING_TAX_CLASS_TITLE', 'Tax Class');
	define('TABLE_HEADING_COUNTRIES_NAME', 'Country');
	define('TABLE_HEADING_ZONE', 'Zone');
	define('TABLE_HEADING_TAX_RATE', 'Tax Rate');
	define('TABLE_HEADING_ACTION', 'Action');
	
	define('TEXT_INFO_EDIT_INTRO', 'Please make any necessary changes');
	define('TEXT_INFO_DATE_ADDED', 'Date Added:');
	define('TEXT_INFO_LAST_MODIFIED', 'Last Modified:');
	define('TEXT_INFO_CLASS_TITLE', 'Tax Class Title:');
	define('TEXT_INFO_COUNTRY_NAME', 'Country:');
	define('TEXT_INFO_ZONE_NAME', 'Zone:');
	define('TEXT_INFO_TAX_RATE', 'Tax Rate (%):');
	define('TEXT_INFO_TAX_RATE_PRIORITY', 'Tax rates at the same priority are added, others are compounded.<br><br>Priority:');
	define('TEXT_INFO_RATE_DESCRIPTION', 'Description:');
	define('TEXT_INFO_INSERT_INTRO', 'Please enter the new tax class with its related data');
	define('TEXT_INFO_DELETE_INTRO', 'Are you sure you want to delete this tax rate?');
	define('TEXT_INFO_HEADING_NEW_TAX_RATE', 'New Tax Rate');
	define('TEXT_INFO_HEADING_EDIT_TAX_RATE', 'Edit Tax Rate');
	define('TEXT_INFO_HEADING_DELETE_TAX_RATE', 'Delete Tax Rate');
	define('IMAGE_NEW_TAX_RATE', 'New Tax Rate');
break;
}
?>