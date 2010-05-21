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
<!-- loginbox //-->
<?php
    if (!smn_session_is_registered('customer_id')) {

        $boxContent = "
            <table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
              <tr>
                <td align=\"left\" class=\"main\">
                <a href=\"" . smn_href_link(FILENAME_LOGIN, 'ID=1&account=new_customer', 'NONSSL') . "\">" . smn_image_button('button_create_account.gif', IMAGE_CREATE_CUSTOMER). "</a>
                </td>
              </tr>
              <tr>
                <td align=\"left\" class=\"main\">
                  <a href=\"" . smn_href_link(FILENAME_LOGIN, 'ID=1&account=new_agent', 'NONSSL') . "\">" . smn_image_button('button_create_agent.gif', IMAGE_CREATE_AGENT). "</a>
                </td>
              </tr>
              <tr>
                <td align=\"left\" class=\"main\">
                  <a href=\"" . smn_href_link(FILENAME_LOGIN, 'ID=1&account=new_store', 'NONSSL') . "\">" . smn_image_button('button_create_store.gif', IMAGE_CREATE_STORE). "</a>
                </td>
              </tr>
            <form name=\"login\" method=\"post\" action=\"" . smn_href_link(FILENAME_LOGIN, 'action=process', 'NONSSL') . "\">
              <tr>
                <td align=\"left\" class=\"main\">
                  " . BOX_LOGINBOX_EMAIL . "
                </td>
              </tr>
              <tr>
                <td align=\"left\" class=\"main\">
                  <input type=\"text\" name=\"email_address\" maxlength=\"96\" size=\"20\" value=\"\">
                </td>
              </tr>
              <tr>
                <td align=\"left\" class=\"main\">
                  " . BOX_LOGINBOX_PASSWORD . "
                </td>
              </tr>
              <tr>
                <td align=\"left\" class=\"main\">
                  <input type=\"password\" name=\"password\" maxlength=\"40\" size=\"20\" value=\"\">
                </td>
              </tr>
              <tr>
                <td class=\"main\" align=\"left\"><br>
                  " . smn_image_submit('button_login.gif', IMAGE_BUTTON_LOGIN) . "
                </td>
              </tr>
            </form>
            </table> ";
?>
<?php
  }elseif (smn_session_is_registered('customer_id')){  
  $check_store_owner_query  = smn_db_query("select c.customers_firstname, a.store_id, sd.store_name, a.admin_email_address from " . TABLE_CUSTOMERS . " c, " . TABLE_STORE_DESCRIPTION . " sd, " . TABLE_ADMIN . " a where  c.customers_id = '". $customer_id ."' and c.customers_email_address = a.admin_email_address and a.store_id = sd.store_id");

	if (smn_db_num_rows($check_store_owner_query)){  
	    $check_store_owner = smn_db_fetch_array($check_store_owner_query);
	    //$store_site_address = $check_store_owner['store_site_address'];
	    $owner_store_id = $check_store_owner['store_id'];
	    $display_store_name = $check_store_owner['store_name'];
		
	    $admin = HTTP_SERVER . DIR_WS_ADMIN .  FILENAME_DEFAULT;
  	    $store_site_address = HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_DEFAULT . '?ID=' . $owner_store_id;
		

 $boxContent = '<table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" class="main">Welcome Back ' . $check_store_owner['customers_firstname'] . '<br>' .
		'<a href=" '. $admin .' " target="_blank" class="main"><b>Store Administration</b></a><br>' .
                '<a href="' . $store_site_address . '" class="main"><b>Go to your store '. $display_store_name .'</b></a><br><br>'.
                '<a href="' . smn_href_link(FILENAME_ACCOUNT, 'ID=' . $owner_store_id, 'NONSSL') . '">' . LOGIN_BOX_MY_ACCOUNT . '</a><br>' .
                '<a href="' . smn_href_link(FILENAME_ACCOUNT_EDIT, 'ID=' . $owner_store_id, 'NONSSL') . '">' . LOGIN_BOX_ACCOUNT_EDIT . '</a><br>' .
                 '<a href="' . smn_href_link(FILENAME_ACCOUNT_HISTORY, 'ID=' . $owner_store_id, 'NONSSL') . '">' . LOGIN_BOX_ACCOUNT_HISTORY . '</a><br>' .
                 '<a href="' . smn_href_link(FILENAME_ADDRESS_BOOK, 'ID=' . $owner_store_id, 'NONSSL') . '">' . LOGIN_BOX_ADDRESS_BOOK . '</a><br>' .
                '<a href="' . smn_href_link(FILENAME_ACCOUNT_NOTIFICATIONS, 'ID=' . $owner_store_id, 'NONSSL') . '">' . LOGIN_BOX_PRODUCT_NOTIFICATIONS . '</a><br>' .
                '<a href="' . smn_href_link(FILENAME_LOGOFF, '', 'NONSSL') . '">' . LOGIN_BOX_LOGOFF . '</a><br></td>
              </tr>
            </table>'; 
}else {
?>
<!-- my_account_info //-->
<?php

 $boxContent = '<table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" class="main">Welcome Back ' . $GLOBALS['customer_first_name'] . '<BR><br>' .
               '<a href="' . smn_href_link(FILENAME_ACCOUNT, '', 'NONSSL') . '">' . LOGIN_BOX_MY_ACCOUNT . '</a><br>' .
                '<a href="' . smn_href_link(FILENAME_ACCOUNT_EDIT, '', 'NONSSL') . '">' . LOGIN_BOX_ACCOUNT_EDIT . '</a><br>' .
               '<a href="' . smn_href_link(FILENAME_ACCOUNT_HISTORY, '', 'NONSSL') . '">' . LOGIN_BOX_ACCOUNT_HISTORY . '</a><br>' .
               '<a href="' . smn_href_link(FILENAME_ADDRESS_BOOK, '', 'NONSSL') . '">' . LOGIN_BOX_ADDRESS_BOOK . '</a><br>' .
               '<a href="' . smn_href_link(FILENAME_ACCOUNT_NOTIFICATIONS, '', 'NONSSL') . '">' . LOGIN_BOX_PRODUCT_NOTIFICATIONS . '</a><br>' .
               '<a href="' . smn_href_link(FILENAME_LOGOFF, '', 'NONSSL') . '">' . LOGIN_BOX_LOGOFF . '</a><br></td>
              </tr>
            </table>';
?>
<!-- my_account_info_eof //-->
<?php
  }
 }
?>
<!-- loginbox //-->
