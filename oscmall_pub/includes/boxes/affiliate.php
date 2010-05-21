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
?>          
<!-- affiliate //-->
<?php
  $boxHeading = BOX_HEADING_AFFILIATE;
  $box_base_name = 'affiliate';
  $box_id = $box_base_name . 'Box';

  if (smn_session_is_registered('affiliate_id')) {
    $info_box_contents = array();

    $boxContent =  '<b><a href="' . smn_href_link(FILENAME_AFFILIATE_SUMMARY, '', 'NONSSL') . '">' . BOX_AFFILIATE_SUMMARY . '</a></b><br>' .
                   '&nbsp;&nbsp;<a href="' . smn_href_link(FILENAME_AFFILIATE_ACCOUNT, '', 'NONSSL') . '">' . BOX_AFFILIATE_ACCOUNT . '</a><br>' .
                   '&nbsp;&nbsp;<a href="' . smn_href_link(FILENAME_AFFILIATE_PASSWORD, '', 'NONSSL') . '">' . BOX_AFFILIATE_PASSWORD . '</a><br>' .
                   '&nbsp;&nbsp;<a href="' . smn_href_link(FILENAME_AFFILIATE_NEWSLETTER, '', 'NONSSL') . '">' . BOX_AFFILIATE_NEWSLETTER . '</a><br>' .
                   '&nbsp;&nbsp;<a href="' . smn_href_link(FILENAME_AFFILIATE_NEWS, '', 'NONSSL') . '">' . BOX_AFFILIATE_NEWS . '</a><br>' .
		    '<b><a href="' . smn_href_link(FILENAME_AFFILIATE_BANNERS, '', 'NONSSL') . '">' . BOX_AFFILIATE_BANNERS . '</a></b><br>' .
		    '&nbsp;&nbsp;<a href="' . smn_href_link(FILENAME_AFFILIATE_BANNERS_BANNERS, '', 'NONSSL') . '">' . BOX_AFFILIATE_BANNERS_BANNERS . '</a><br>' .
                    '&nbsp;&nbsp;<a href="' . smn_href_link(FILENAME_AFFILIATE_BANNERS_BUILD, '', 'NONSSL') . '">' . BOX_AFFILIATE_BANNERS_BUILD . '</a><br>' .
                   '&nbsp;&nbsp;<a href="' . smn_href_link(FILENAME_AFFILIATE_BANNERS_PRODUCT, '', 'NONSSL') . '">' . BOX_AFFILIATE_BANNERS_PRODUCT . '</a><br>' .
                   '&nbsp;&nbsp;<a href="' . smn_href_link(FILENAME_AFFILIATE_BANNERS_TEXT, '', 'NONSSL') . '">' . BOX_AFFILIATE_BANNERS_TEXT . '</a><br>' .
                   '<b><a href="' . smn_href_link(FILENAME_AFFILIATE_REPORTS, '', 'NONSSL') . '">' . BOX_AFFILIATE_REPORTS . '</a></b><br>' .
                    '&nbsp;&nbsp;<a href="' . smn_href_link(FILENAME_AFFILIATE_CLICKS, '', 'NONSSL'). '">' . BOX_AFFILIATE_CLICKRATE . '</a><br>' .
                    '&nbsp;&nbsp;<a href="' . smn_href_link(FILENAME_AFFILIATE_SALES, '', 'NONSSL'). '">' . BOX_AFFILIATE_SALES . '</a><br>' .
                   '&nbsp;&nbsp;<a href="' . smn_href_link(FILENAME_AFFILIATE_PAYMENT, '', 'NONSSL'). '">' . BOX_AFFILIATE_PAYMENT . '</a><br>' .
                   '<a href="' . smn_href_link(FILENAME_AFFILIATE_CONTACT, '', 'NONSSL') . '">' . BOX_AFFILIATE_CONTACT . '</a><br>' .
                  '<a href="' . smn_href_link(FILENAME_AFFILIATE_FAQ, '', 'NONSSL') . '">' . BOX_AFFILIATE_FAQ . '</a><br>' .
                   '<a href="' . smn_href_link(FILENAME_AFFILIATE_LOGOUT). '">' . BOX_AFFILIATE_LOGOUT . '</a>';
?>
<!-- affiliate_eof //-->
<?php
  } else {
    $boxContent =  '<a href="' . smn_href_link(FILENAME_AFFILIATE, '', 'NONSSL') . '">' . BOX_AFFILIATE_LOGIN . '</a>';
?>
<!-- affiliate_eof //-->
<?php
  }
    if(file_exists(DIR_WS_BOX_TEMPLATES . $box_base_name . '.php')){
        require(DIR_WS_BOX_TEMPLATES . $box_base_name . '.php');
    }else {
        require(DEFAULT_TEMPLATENAME_BOX);
    }
  $boxContent_attributes = '';  
  
?>