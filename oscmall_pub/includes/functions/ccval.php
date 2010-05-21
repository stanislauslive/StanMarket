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


  Credit Card Validation Solution version 3.5 PHP Edition
  COPYRIGHT NOTICE:
  a) This code is property of The Analysis and Solutions Company.
  b) It is being distributed free of charge and on an "as is" basis.
  c) Use of this code, or any part thereof, is contingent upon leaving
      this copyright notice, name and address information in tact.
  d) Written permission must be obtained from us before this code, or any
      part thereof, is sold or used in a product which is sold.
  e) By using this code, you accept full responsibility for its use
      and will not hold the Analysis and Solutions Company, its employees
      or officers liable for damages of any sort.
  f) This code is not to be used for illegal purposes.
  g) Please email us any revisions made to this code.

  Copyright 2000                 http://www.AnalysisAndSolutions.com/code/
  The Analysis and Solutions Company         info@AnalysisAndSolutions.com
*/

  function CCValidationSolution($Number) {
    global $CardName, $CardNumber, $language;

    require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_CCVAL_FUNCTION); 


// Get rid of spaces and non-numeric characters.
    $Number = OnlyNumericSolution($Number);

// Do the first four digits fit within proper ranges? If so, who's the card issuer and how long should the number be?
    $NumberLeft = substr($Number, 0, 4);
    $NumberLength = strlen($Number);

    if ( ($NumberLeft >= 3000) && ($NumberLeft <= 3059) ) {
      $CardName = 'Diners Club';
      $ShouldLength = 14;
    } elseif ( ($NumberLeft >= 3600) && ($NumberLeft <= 3699) ) {
      $CardName = 'Diners Club';
      $ShouldLength = 14;
    } elseif ( ($NumberLeft >= 3800) && ($NumberLeft <= 3889) ) {
      $CardName = 'Diners Club';
      $ShouldLength = 14;
    } elseif ( ($NumberLeft >= 3400) && ($NumberLeft <= 3499) ) {
      $CardName = 'American Express';
      $ShouldLength = 15;
    } elseif ( ($NumberLeft >= 3700) && ($NumberLeft <= 3799) ) {
      $CardName = 'American Express';
      $ShouldLength = 15;
    } elseif ( ($NumberLeft >= 3528) && ($NumberLeft <= 3589) ) {
      $CardName = 'JCB';
      $ShouldLength = 16;
    } elseif ( ($NumberLeft >= 3890) && ($NumberLeft <= 3899) ) {
      $CardName = 'Carte Blache';
      $ShouldLength = 14;
    } elseif ( ($NumberLeft >= 4000) && ($NumberLeft <= 4999) ) {
      $CardName = 'Visa';
      if ($NumberLength > 14) {
        $ShouldLength = 16;
      } elseif ($NumberLength < 14) {
        $ShouldLength = 13;
      }
    } elseif ( ($NumberLeft >= 5100) && ($NumberLeft <= 5599) ) {
      $CardName = 'MasterCard';
      $ShouldLength = 16;
    } elseif ($NumberLeft == 5610) {
      $CardName = 'Australian BankCard';
      $ShouldLength = 16;
    } elseif ($NumberLeft == 6011) {
      $CardName = 'Discover/Novus';
      $ShouldLength = 16;
    } else {
      $cc_val = sprintf(TEXT_CCVAL_ERROR_UNKNOWN_CARD, $NumberLeft);
      return $cc_val;
    }

// Is the number the right length?
    if ($NumberLength <> $ShouldLength) {
      $Missing = $NumberLength - $ShouldLength;
      if ($Missing < 0) {
        $cc_val = sprintf(TEXT_CCVAL_ERROR_INVALID_NUMBER, $CardName, $Number);
      } else {
        $cc_val = sprintf(TEXT_CCVAL_ERROR_INVALID_NUMBER, $CardName, $Number);
      }

      return $cc_val;
    }

// Does the number pass the Mod 10 Algorithm Checksum?
    if (Mod10Solution($Number)) {
     $CardNumber = $Number;
     return true;
    } else {
      $cc_val = sprintf(TEXT_CCVAL_ERROR_INVALID_NUMBER, $CardName, $Number);
      return $cc_val;
    }
  }

  function OnlyNumericSolution($Number) {
// Remove any non numeric characters.
// Ensure number is no more than 19 characters long.
    return substr(ereg_replace('[^0-9]', '', $Number) , 0, 19);
  }

  function Mod10Solution($Number) {
    $NumberLength = strlen($Number);
    $Checksum = 0;

// Add even digits in even length strings or odd digits in odd length strings.
    for ($Location = 1-($NumberLength%2); $Location<$NumberLength; $Location+=2) {
      $Checksum += substr($Number, $Location, 1);
    }

// Analyze odd digits in even length strings or even digits in odd length strings.
    for ($Location = ($NumberLength%2); $Location<$NumberLength; $Location+=2) {
      $Digit = substr($Number, $Location, 1) * 2;
      if ($Digit < 10) {
        $Checksum += $Digit;
      } else {
        $Checksum += $Digit - 9;
      }
    }

// Is the checksum divisible by ten?
    return ($Checksum % 10 == 0);
  }

  function ValidateExpiry ($month, $year) {
    $cc_val = '';
    $year = '20' . $year;

    if (date('Y') == $year) {
      if (date('m') <= $month) {
        $cc_val = '1';
      } else {
        $cc_val = sprintf(TEXT_CCVAL_ERROR_INVALID_DATE, $month, $year);
      }
    } elseif (date('Y') > $year) {
        $cc_val = sprintf(TEXT_CCVAL_ERROR_INVALID_DATE, $month, $year);
    } else {
      $cc_val = '1';
    }

    return $cc_val;
  }
?>