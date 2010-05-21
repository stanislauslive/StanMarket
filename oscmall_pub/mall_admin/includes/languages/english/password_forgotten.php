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


define('HEADING_PASSWORD_FORGOTTEN', 'Forgotten My Password!');

define('TEXT_MAIN', 'If you\'ve forgotten your password, enter your e-mail address below and we\'ll send you an e-mail message containing your new password.');

define('TEXT_FORGOTTEN_ERROR', 'Error: The E-Mail Address was not found in our records, please try again.');


define('EMAIL_PASSWORD_REMINDER_SUBJECT', 'New Password for oscMall');
define('EMAIL_PASSWORD_REMINDER_BODY', 'A new password was requested from ' . $REMOTE_ADDR . '.' . "\n\n" . 'Your new password to the oscMall Admin is:' . "\n\n" . '   %s' . "\n\n");

define('TEXT_FORGOTTEN_SUCCESS', 'Success: A new password has been sent to your e-mail address.');
?>