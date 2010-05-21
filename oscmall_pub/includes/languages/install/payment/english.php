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

function smn_module_laguage_install($module_name, $new_language_id, $prefix){
    switch($module_name){
        
// secpay installs
        case 'secpay':
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'secpay', 'MODULE_PAYMENT_SECPAY_TEXT_TITLE', " . (int)$new_language_id . ", 'SECPay', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'secpay', 'MODULE_PAYMENT_SECPAY_TEXT_DESCRIPTION', " . (int)$new_language_id . ", 'Credit Card Test Info:<br><br>CC#: 4444333322221111<br>Expiry: Any', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'secpay', 'MODULE_PAYMENT_SECPAY_TEXT_ERROR', " . (int)$new_language_id . ", 'Credit Card Error!', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'secpay', 'MODULE_PAYMENT_SECPAY_TEXT_ERROR_MESSAGE', " . (int)$new_language_id . ", 'There has been an error processing your credit card. Please try again.', now());");
        break;

// psigate installs
        case 'psigate':
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'psigate', 'MODULE_PAYMENT_PSIGATE_TEXT_TITLE', " . (int)$new_language_id . ", 'PSiGate', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'psigate', 'MODULE_PAYMENT_PSIGATE_TEXT_DESCRIPTION', " . (int)$new_language_id . ", 'Credit Card Test Info:<br><br>CC#: 4111111111111111<br>Expiry: Any', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'psigate', 'MODULE_PAYMENT_PSIGATE_TEXT_CREDIT_CARD_OWNER', " . (int)$new_language_id . ", 'Credit Card Owner:', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'psigate', 'MODULE_PAYMENT_PSIGATE_TEXT_CREDIT_CARD_NUMBER', " . (int)$new_language_id . ", 'Credit Card Number:', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'psigate', 'MODULE_PAYMENT_PSIGATE_TEXT_CREDIT_CARD_EXPIRES', " . (int)$new_language_id . ", 'Credit Card Expiry Date:', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'psigate', 'MODULE_PAYMENT_PSIGATE_TEXT_TYPE', " . (int)$new_language_id . ", 'Type:', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'psigate', 'MODULE_PAYMENT_PSIGATE_TEXT_JS_CC_NUMBER', " . (int)$new_language_id . ", '* The credit card number has too few characters.\n', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'psigate', 'MODULE_PAYMENT_PSIGATE_TEXT_ERROR_MESSAGE', " . (int)$new_language_id . ", 'There has been an error processing your credit card. Please try again.', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'psigate', 'MODULE_PAYMENT_PSIGATE_TEXT_ERROR', " . (int)$new_language_id . ", 'Credit Card Error!', now());");
        break;

// pm2checkout installs
        case 'pm2checkout':
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'pm2checkout', 'MODULE_PAYMENT_2CHECKOUT_TEXT_TITLE', " . (int)$new_language_id . ", '2CheckOut', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'pm2checkout', 'MODULE_PAYMENT_2CHECKOUT_TEXT_DESCRIPTION', " . (int)$new_language_id . ", 'Credit Card Test Info:<br><br>CC#: 4111111111111111<br>Expiry: Any', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'pm2checkout', 'MODULE_PAYMENT_2CHECKOUT_TEXT_TYPE', " . (int)$new_language_id . ", 'Type:', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'pm2checkout', 'MODULE_PAYMENT_2CHECKOUT_TEXT_CREDIT_CARD_OWNER', " . (int)$new_language_id . ", 'Credit Card Owner:', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'pm2checkout', 'MODULE_PAYMENT_2CHECKOUT_TEXT_CREDIT_CARD_OWNER_FIRST_NAME', " . (int)$new_language_id . ", 'Credit Card Owner First Name:', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'pm2checkout', 'MODULE_PAYMENT_2CHECKOUT_TEXT_CREDIT_CARD_OWNER_LAST_NAME', " . (int)$new_language_id . ", 'Credit Card Owner Last Name:', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'pm2checkout', 'MODULE_PAYMENT_2CHECKOUT_TEXT_CREDIT_CARD_NUMBER', " . (int)$new_language_id . ", 'Credit Card Number:', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'pm2checkout', 'MODULE_PAYMENT_2CHECKOUT_TEXT_CREDIT_CARD_EXPIRES', " . (int)$new_language_id . ", 'Credit Card Expiry Date:', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'pm2checkout', 'MODULE_PAYMENT_2CHECKOUT_TEXT_CREDIT_CARD_CHECKNUMBER', " . (int)$new_language_id . ", 'Credit Card Checknumber:', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'pm2checkout', 'MODULE_PAYMENT_2CHECKOUT_TEXT_CREDIT_CARD_CHECKNUMBER_LOCATION', " . (int)$new_language_id . ", '(located at the back of the credit card)', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'pm2checkout', 'MODULE_PAYMENT_2CHECKOUT_TEXT_JS_CC_NUMBER', " . (int)$new_language_id . ", '* The credit card number has too few characters.\n', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'pm2checkout', 'MODULE_PAYMENT_2CHECKOUT_TEXT_ERROR_MESSAGE', " . (int)$new_language_id . ", 'There has been an error processing your credit card. Please try again.', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'pm2checkout', 'MODULE_PAYMENT_2CHECKOUT_TEXT_ERROR', " . (int)$new_language_id . ", 'Credit Card Error!', now());");
        break;

// paypal installs
        case 'paypal':
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'paypal', 'MODULE_PAYMENT_PAYPAL_TEXT_TITLE', " . (int)$new_language_id . ", 'PayPal', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'paypal', 'MODULE_PAYMENT_PAYPAL_TEXT_DESCRIPTION', " . (int)$new_language_id . ", 'PayPal', now());");
        break;

// nochex installs
        case 'nochex':
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'nochex', 'MODULE_PAYMENT_NOCHEX_TEXT_TITLE', " . (int)$new_language_id . ", 'NOCHEX', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'nochex', 'MODULE_PAYMENT_NOCHEX_TEXT_DESCRIPTION', " . (int)$new_language_id . ", 'NOCHEX<br>Requires the GBP currency.', now());");
        break;

// moneyorder installs
        case 'moneyorder':
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'moneyorder', 'MODULE_PAYMENT_MONEYORDER_TEXT_TITLE', " . (int)$new_language_id . ", 'Check/Money Order', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'moneyorder', 'MODULE_PAYMENT_MONEYORDER_TEXT_DESCRIPTION', " . (int)$new_language_id . ", 'Make Payable To:&nbsp;<br><br>Send To:<br> Our Store Address <br><br>Your order will not ship until we receive payment.', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'moneyorder', 'MODULE_PAYMENT_MONEYORDER_TEXT_EMAIL_FOOTER', " . (int)$new_language_id . ", 'Make Payable To: Our Shop <br><br>Send To:<br> Our Store Address  <br><br>our order will not ship until we receive payment.', now());");
        break;

// freecharger installs
        case 'freecharger':
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'freecharger', 'MODULE_PAYMENT_FREECHARGER_TEXT_TITLE', " . (int)$new_language_id . ", 'Download File', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'freecharger', 'MODULE_PAYMENT_FREECHARGER_TEXT_DESCRIPTION', " . (int)$new_language_id . ", 'Download your file', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'freecharger', 'MODULE_PAYMENT_FREECHARGER_TEXT_EMAIL_FOOTER', " . (int)$new_language_id . ", 'Will Provide a link when payment is verified', now());");
        break;


// ipayment installs
        case 'ipayment':
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ipayment', 'MODULE_PAYMENT_IPAYMENT_TEXT_TITLE', " . (int)$new_language_id . ", 'iPayment', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ipayment', 'MODULE_PAYMENT_IPAYMENT_TEXT_DESCRIPTION', " . (int)$new_language_id . ", 'Credit Card Test Info:<br><br>CC#: 4111111111111111<br>Expiry: Any', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ipayment', 'IPAYMENT_ERROR_HEADING', " . (int)$new_language_id . ", 'There has been an error processing your credit card', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ipayment', 'IPAYMENT_ERROR_MESSAGE', " . (int)$new_language_id . ", 'Please check your credit card details!', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ipayment', 'MODULE_PAYMENT_IPAYMENT_TEXT_CREDIT_CARD_OWNER', " . (int)$new_language_id . ", 'Credit Card Owner:', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ipayment', 'MODULE_PAYMENT_IPAYMENT_TEXT_CREDIT_CARD_NUMBER', " . (int)$new_language_id . ", 'Credit Card Number:', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ipayment', 'MODULE_PAYMENT_IPAYMENT_TEXT_CREDIT_CARD_EXPIRES', " . (int)$new_language_id . ", 'Credit Card Expiry Date:', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ipayment', 'MODULE_PAYMENT_IPAYMENT_TEXT_CREDIT_CARD_CHECKNUMBER', " . (int)$new_language_id . ", 'Credit Card Checknumber:', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ipayment', 'MODULE_PAYMENT_IPAYMENT_TEXT_CREDIT_CARD_CHECKNUMBER_LOCATION', " . (int)$new_language_id . ", '(located at the back of the credit card)', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ipayment', 'MODULE_PAYMENT_IPAYMENT_TEXT_JS_CC_OWNER', " . (int)$new_language_id . ", '* The owner\'s name of the credit card has too few characters.\n', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'ipayment', 'MODULE_PAYMENT_IPAYMENT_TEXT_JS_CC_NUMBER', " . (int)$new_language_id . ", '* The credit card number has too few characters.\n', now());");
        break;

// cod installs
        case 'cod':
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'cod', 'MODULE_PAYMENT_COD_TEXT_TITLE', " . (int)$new_language_id . ", 'Cash on Delivery', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'cod', 'MODULE_PAYMENT_COD_TEXT_DESCRIPTION', " . (int)$new_language_id . ", 'Cash on Delivery', now());");
        break;
        
// cc installs
        case 'cc':
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'cc', 'MODULE_PAYMENT_CC_TEXT_TITLE', " . (int)$new_language_id . ", 'Credit Card', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'cc', 'MODULE_PAYMENT_CC_TEXT_DESCRIPTION', " . (int)$new_language_id . ", 'Credit Card Test Info:<br><br>CC#: 4111111111111111<br>Expiry: Any', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'cc', 'MODULE_PAYMENT_CC_TEXT_CREDIT_CARD_TYPE', " . (int)$new_language_id . ", 'Credit Card Type:', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'cc', 'MODULE_PAYMENT_CC_TEXT_CREDIT_CARD_OWNER', " . (int)$new_language_id . ", 'Credit Card Owner:', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'cc', 'MODULE_PAYMENT_CC_TEXT_CREDIT_CARD_NUMBER', " . (int)$new_language_id . ", 'Credit Card Number:', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'cc', 'MODULE_PAYMENT_CC_TEXT_CREDIT_CARD_EXPIRES', " . (int)$new_language_id . ", 'Credit Card Expiry Date:', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'cc', 'MODULE_PAYMENT_CC_TEXT_JS_CC_OWNER', " . (int)$new_language_id . ", '* The owner\'s name of the credit card  has too few characters.\n', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'cc', 'MODULE_PAYMENT_CC_TEXT_JS_CC_NUMBER', " . (int)$new_language_id . ", '* The credit card number has too few characters.\n', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'cc', 'MODULE_PAYMENT_CC_TEXT_ERROR', " . (int)$new_language_id . ", 'Credit Card Error!', now());");
        break;
        
// authorizenet installs
        case 'authorizenet':
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'authorizenet', 'MODULE_PAYMENT_AUTHORIZENET_TEXT_TITLE', " . (int)$new_language_id . ", 'Authorize.net', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'authorizenet', 'MODULE_PAYMENT_AUTHORIZENET_TEXT_DESCRIPTION', " . (int)$new_language_id . ", 'Credit Card Test Info:<br><br>CC#: 4111111111111111<br>Expiry: Any', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'authorizenet', 'MODULE_PAYMENT_AUTHORIZENET_TEXT_TYPE', " . (int)$new_language_id . ", 'Type:', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'authorizenet', 'MODULE_PAYMENT_AUTHORIZENET_TEXT_CREDIT_CARD_OWNER', " . (int)$new_language_id . ", 'Credit Card Owner:', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'authorizenet', 'MODULE_PAYMENT_AUTHORIZENET_TEXT_CREDIT_CARD_NUMBER', " . (int)$new_language_id . ", 'Credit Card Number:', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'authorizenet', 'MODULE_PAYMENT_AUTHORIZENET_TEXT_CREDIT_CARD_EXPIRES', " . (int)$new_language_id . ", 'Credit Card Expiry Date:', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'authorizenet', 'MODULE_PAYMENT_AUTHORIZENET_TEXT_JS_CC_OWNER', " . (int)$new_language_id . ", '* The owner\'s name of the credit card  has too few characters.\n', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'authorizenet', 'MODULE_PAYMENT_AUTHORIZENET_TEXT_JS_CC_NUMBER', " . (int)$new_language_id . ", '* The credit card number has too few characters.\n', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'authorizenet', 'MODULE_PAYMENT_AUTHORIZENET_TEXT_ERROR_MESSAGE', " . (int)$new_language_id . ", 'There has been an error processing your credit card. Please try again.', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'authorizenet', 'MODULE_PAYMENT_AUTHORIZENET_TEXT_DECLINED_MESSAGE', " . (int)$new_language_id . ", 'Your credit card was declined. Please try another card or contact your bank for more info.', now());");
              smn_db_query ("INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (".$prefix.", 'authorizenet', 'MODULE_PAYMENT_AUTHORIZENET_TEXT_ERROR', " . (int)$new_language_id . ", 'Credit Card Error!', now());");
        break;
    }
}