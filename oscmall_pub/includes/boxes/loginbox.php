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
  $boxHeading = BOX_LOGINBOX_HEADING;
  $box_base_name = 'loginbox';
  $box_id = $box_base_name . 'Box'; 

    if (!smn_session_is_registered('customer_id')) {
        $boxHeading = BOX_LOGINBOX_HEADING;
        $boxContent = "
            <table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
              <tr>
                <td align=\"center\" class=\"main\">
                <a href=\"" . smn_href_link(FILENAME_LOGIN, 'ID=1&account=new_customer', 'NONSSL') . "\">" . smn_image_button('button_create_account.gif', IMAGE_CREATE_CUSTOMER). "</a><br/><br/>
                </td>
              </tr>
              <tr>
                <td align=\"center\" class=\"main\">
                  <a href=\"" . smn_href_link(FILENAME_LOGIN, 'ID=1&account=new_agent', 'NONSSL') . "\">" . smn_image_button('button_create_agent.gif', IMAGE_CREATE_AGENT). "</a><br/><br/>
                </td>
              </tr>
              <tr>
                <td align=\"center\" class=\"main\">
                  <a href=\"" . smn_href_link(FILENAME_LOGIN, 'ID=1&account=new_store', 'NONSSL') . "\">" . smn_image_button('button_create_store.gif', IMAGE_CREATE_STORE). "</a><br/><br/>
                </td>
              </tr>";
    if (substr(basename($PHP_SELF), 0, 5) != 'login') { 
        $boxContent .= "   <form name=\"login\" method=\"post\" action=\"" . smn_href_link(FILENAME_LOGIN, 'action=process', 'NONSSL') . "\">
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
                <td class=\"main\" align=\"center\"><br>
                  " . smn_image_submit('button_login.gif', IMAGE_BUTTON_LOGIN) . "
                </td>
              </tr>
            </form>";
    }   
        $boxContent .= "   </table> ";
  }elseif (smn_session_is_registered('customer_id')){
     $boxLinks = array(
          array('sort' => 10, 'filename' => FILENAME_ACCOUNT,               'text' => LOGIN_BOX_MY_ACCOUNT),
          array('sort' => 11, 'filename' => FILENAME_ACCOUNT_EDIT,          'text' => LOGIN_BOX_ACCOUNT_EDIT),
          array('sort' => 12, 'filename' => FILENAME_ACCOUNT_HISTORY,       'text' => LOGIN_BOX_ACCOUNT_HISTORY ),
          array('sort' => 13, 'filename' => FILENAME_ADDRESS_BOOK,          'text' => LOGIN_BOX_ADDRESS_BOOK),
          array('sort' => 50, 'filename' => FILENAME_LOGOFF,                'text' => LOGIN_BOX_LOGOFF),
          array('sort' => 49, 'filename' => FILENAME_ACCOUNT_NOTIFICATIONS, 'text' => LOGIN_BOX_PRODUCT_NOTIFICATIONS)
     );
     
     $check_store_owner_query  = smn_db_query("select c.customers_firstname, a.store_id, sd.store_name, a.admin_email_address from " . TABLE_CUSTOMERS . " c, " . TABLE_STORE_DESCRIPTION . " sd, " . TABLE_ADMIN . " a where  c.customers_id = '". $customer_id ."' and c.customers_email_address = a.admin_email_address and a.store_id = sd.store_id");
	if (smn_db_num_rows($check_store_owner_query)){  
	    $check_store_owner = smn_db_fetch_array($check_store_owner_query);
	    $linkStoreID = $customer_store_id;
	    $welcomeText = 'Welcome Back ' . $check_store_owner['customers_firstname'] . '<BR><br><br>' . 
	                   'Go to your store <a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_DEFAULT . '?ID=' . $linkStoreID . '" target="_blank"><b><u> '. $check_store_owner['store_name'] .'</u></b></a><br><br>';
        $boxHeading = BOX_HEADING_STORE_OWNER;
        $boxLinks[] = array('sort' => 14, 'filename' => FILENAME_STORE_PRODUCT_CATEGORIES, 'text' => LOGIN_BOX_PRODUCT_TOOL);
        $boxLinks[] = array('sort' => 15, 'filename' => FILENAME_STORE_TEXT_EDITOR, 'text' => LOGIN_BOX_STORE_TEXT_EDITOR);
        if ($box_menu=='tax'){
           $boxLinks[] = array('sort' => 16, 'filename' => FILENAME_TAX_ZONES, 'text' => LOGIN_BOX_TAX_ZONES);
           $boxLinks[] = array('sort' => 17, 'filename' => FILENAME_TAX_CLASSES, 'text' => LOGIN_BOX_TAX_CLASSES);
           $boxLinks[] = array('sort' => 18, 'filename' => FILENAME_TAX_RATES, 'text' => LOGIN_BOX_TAX_RATES);
        }
	}else{
	    $check_sales_agent_query  = smn_db_query("select c.customers_firstname, a.affiliate_customer_id, c.customers_email_address from " . TABLE_CUSTOMERS . " c,  " . TABLE_AFFILIATE . " a where  c.customers_id = '". $customer_id ."' and a.affiliate_customer_id = c.customers_id");
	    if (smn_db_num_rows($check_sales_agent_query)){
	       $linkStoreID = $store_id;
	       $check_sales_agent = smn_db_fetch_array($check_sales_agent_query);
           $boxHeading = BOX_HEADING_LOGIN_BOX_MY_ACCOUNT;
		   $welcomeText = 'Welcome Back ' . $check_sales_agent['customers_firstname'] . '<br><br>';
	       
           $boxLinks[] = array('sort' => 5, 'filename' => FILENAME_AFFILIATE_SUMMARY, 'text' => BOX_AFFILIATE_SUMMARY);
	    }else{
	       $linkStoreID = $store_id;
           $boxHeading = BOX_HEADING_LOGIN_BOX_MY_ACCOUNT;
		   $welcomeText = 'Welcome Back ' . $GLOBALS['customer_first_name'] . '<br><br>';
	    }
	}
?>
          <tr>
            <td>
<?php
    $orderedLinks = array();
    foreach($boxLinks as $index => $linkInfo){
      $orderedLinks[$linkInfo['sort']] = '<a href="' . smn_href_link($linkInfo['filename'], 'ID=' . $linkStoreID) . '">' . $linkInfo['text'] . '</a><br>';
    }
    ksort($orderedLinks);
		
    $boxContent = $welcomeText . 
                  implode("\n", $orderedLinks);
  }
  if(file_exists(DIR_WS_BOX_TEMPLATES . $box_base_name . '.php')){
      require(DIR_WS_BOX_TEMPLATES . $box_base_name . '.php');
  }else {
      require(DEFAULT_TEMPLATENAME_BOX);
  }
  $boxContent_attributes = ''; 
?>
<!-- loginbox //-->

