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

define('HEADING_TITLE', 'Admin Account');

define('TABLE_HEADING_ACCOUNT', 'My Account');

define('TEXT_INFO_FULLNAME', '<b>Name: </b>');
define('TEXT_INFO_FIRSTNAME', '<b>Firstname: </b>');
define('TEXT_INFO_LASTNAME', '<b>Lastname: </b>');
define('TEXT_INFO_EMAIL', '<b>Email Address: </b>');
define('TEXT_INFO_PASSWORD', '<b>Password: </b>');
define('TEXT_INFO_PASSWORD_HIDDEN', '-Hidden-');
define('TEXT_INFO_PASSWORD_CONFIRM', '<b>Confirm Password: </b>');
define('TEXT_INFO_CREATED', '<b>Account Created: </b>');
define('TEXT_INFO_LOGDATE', '<b>Last Access: </b>');
define('TEXT_INFO_LOGNUM', '<b>Log Number: </b>');
define('TEXT_INFO_GROUP', '<b>Group Level: </b>');
define('TEXT_INFO_ERROR', '<font color="red">Email address has already been used! Please try again.</font>');
define('TEXT_INFO_MODIFIED', 'Modified: ');

define('TEXT_INFO_HEADING_DEFAULT', 'Edit Account ');
define('TEXT_INFO_HEADING_CONFIRM_PASSWORD', 'Password Confirmation ');
define('TEXT_INFO_INTRO_CONFIRM_PASSWORD', 'Password:');
define('TEXT_INFO_INTRO_CONFIRM_PASSWORD_ERROR', '<font color="red"><b>ERROR:</b> wrong password!</font>');
define('TEXT_INFO_INTRO_DEFAULT', 'Click <b>edit button</b> below to change your account.');
define('TEXT_INFO_INTRO_DEFAULT_FIRST_TIME', '<br><b>WARNING:</b><br>Hello <b>%s</b>, you just come here for the first time. We recommend you to change your password!');
define('TEXT_INFO_INTRO_DEFAULT_FIRST', '<br><b>WARNING:</b><br>Hello <b>%s</b>, we recommend you to change your email (<font color="red">admin@localhost</font>) and password!');
define('TEXT_INFO_INTRO_EDIT_PROCESS', 'All fields are required. Click save to submit.');


define('ADMIN_EMAIL_SUBJECT', 'oscMall Admin Changed');
define('ADMIN_EMAIL_TEXT', '<b>oscMall Changed Admin Settings<b>' . "\n\n" . 'Your oscMall System Admin has been changed to the following :' . "\n\n" . '   %s' . "\n\n" . 'Please retain for your records.' . "\n\n" );


define('JS_ALERT_FIRSTNAME',        '- Required: Firstname \n');
define('JS_ALERT_LASTNAME',         '- Required: Lastname \n');
define('JS_ALERT_EMAIL',            '- Required: Email address \n');
define('JS_ALERT_PASSWORD',         '- Required: Password \n');
define('JS_ALERT_FIRSTNAME_LENGTH', '- Firstname length must over ');
define('JS_ALERT_LASTNAME_LENGTH',  '- Lastname length must over ');
define('JS_ALERT_PASSWORD_LENGTH',  '- Password length must over ');
define('JS_ALERT_EMAIL_FORMAT',     '- Email address format is invalid! \n');
define('JS_ALERT_EMAIL_USED',       '- Email address has already been used! \n');
define('JS_ALERT_PASSWORD_CONFIRM', '- Miss typing in Password Confirmation field! \n');

?>
