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

  WebMakers.com Added: Header Tags Generator v2.3
*/
function clean_html_comments($clean_html) {
global $its_cleaned;

if ( strpos($clean_html,'<!--//*')>1 ) {
  $the_end1= strpos($clean_html,'<!--//*')-1;
  $the_start2= strpos($clean_html,'*//-->')+7;

  $its_cleaned= substr($clean_html,0,$the_end1);
  $its_cleaned.= substr($clean_html,$the_start2);
} else {
  $its_cleaned= $clean_html;
}
  return $its_cleaned;
}

?>
