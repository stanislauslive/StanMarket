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

// check if the 'install' directory exists, and warn of its existence
  if (WARN_INSTALL_EXISTENCE == 'true') {
    if (file_exists(dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']) . '/install')) {
      $messageStack->add('header', WARNING_INSTALL_DIRECTORY_EXISTS, 'warning');
    }
  }

// check if the configure.php file is writeable
  if (WARN_CONFIG_WRITEABLE == 'true') {
    if ( (file_exists(dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']) . '/includes/configure.php')) && (is_writeable(dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']) . '/includes/configure.php')) ) {
      $messageStack->add('header', WARNING_CONFIG_FILE_WRITEABLE, 'warning');
    }
  }

// check if the session folder is writeable
  if (WARN_SESSION_DIRECTORY_NOT_WRITEABLE == 'true') {
    if (STORE_SESSIONS == '') {
      if (!is_dir(smn_session_save_path())) {
        $messageStack->add('header', WARNING_SESSION_DIRECTORY_NON_EXISTENT, 'warning');
      } elseif (!is_writeable(smn_session_save_path())) {
        $messageStack->add('header', WARNING_SESSION_DIRECTORY_NOT_WRITEABLE, 'warning');
      }
    }
  }

// check session.auto_start is disabled
  if ( (function_exists('ini_get')) && (WARN_SESSION_AUTO_START == 'true') ) {
    if (ini_get('session.auto_start') == '1') {
      $messageStack->add('header', WARNING_SESSION_AUTO_START, 'warning');
    }
  }

  if ( (WARN_DOWNLOAD_DIRECTORY_NOT_READABLE == 'true') && (DOWNLOAD_ENABLED == 'true') ) {
    if (!is_dir(DIR_FS_DOWNLOAD)) {
      $messageStack->add('header', WARNING_DOWNLOAD_DIRECTORY_NON_EXISTENT, 'warning');
    }
  }

  if ($messageStack->size('header') > 0) {
    echo $messageStack->output('header');
  }
?>

<?php
  if (isset($HTTP_GET_VARS['error_message']) && smn_not_null($HTTP_GET_VARS['error_message'])) {
?>
<table border="0" width="100%" cellspacing="0" cellpadding="2">
  <tr class="headerError">
    <td class="headerError"><?php echo htmlspecialchars(stripslashes(urldecode($HTTP_GET_VARS['error_message']))); ?></td>
  </tr>
</table>
<?php
  }

  if (isset($HTTP_GET_VARS['info_message']) && smn_not_null($HTTP_GET_VARS['info_message'])) {
?>
<table border="0" width="100%" cellspacing="0" cellpadding="2">
  <tr class="headerInfo">
    <td class="headerInfo"><?php echo htmlspecialchars(stripslashes($HTTP_GET_VARS['info_message'])); ?></td>
  </tr>
</table>
<?php
  }
?>







<!-- header //-->



<!-- Top table with logo -->
<table valign="top" align="center" border="0" cellpadding="0" cellspacing="0" width="750">
<tbody><tr><td align="CENTER">
<!--- top logo header --->
<table border="0" cellpadding="0" cellspacing="0" width="750">
<tbody><tr>
   <td class="topbanner_td1" valign="top" width="180"><?php echo '<a href="' . smn_href_link(FILENAME_DEFAULT) . '">' . smn_image(DIR_WS_IMAGES . 'logo.gif') . '</a>'; ?></td>
   <td class="topbanner_td2" valign="top"><table class="expender_tb" width="100%"><tbody><tr><td></td></tr></tbody></table></td>
   <td class="topbanner_td3" valign="top" width="500">
	<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody><tr><td class="top_nav_td_2" align="right">&nbsp;&nbsp;<?php echo strftime(DATE_FORMAT_LONG); ?>&nbsp;&nbsp;</td></tr>
	<tr><td align="right">
	<table class="top_nav_td_1" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody><tr>
		<td class="topmenu_cart_td1" style="padding-left: 3px; padding-right: 3px;" align="right"><?php echo $cart->count_contents();?> item(s) in your <a href="<?php echo smn_href_link(FILENAME_SHOPPING_CART, 'ID=' . $store_id); ?>">cart</a>&nbsp;Total:&nbsp;<?php echo $currencies->format($cart->show_total());?></td>

		<td align="center">|</td>
		<td style="padding-left: 3px; padding-right: 3px;" align="center"><a href="<?php echo smn_href_link(FILENAME_SHOPPING_CART, 'ID=' . $store_id); ?>">Shopping Cart</a></td>
		<td align="center">|</td>
		<td style="padding-left: 3px; padding-right: 3px;" align="center"><a href="<?php echo smn_href_link(FILENAME_CHECKOUT_SHIPPING, 'ID=' . $store_id); ?>">Checkout</a></td>
	</tr>
	</tbody></table>
	</td></tr>
	</tbody></table>
   </td>
</tr>
</tbody></table>
<table class="menubarmain" border="0" cellpadding="0" cellspacing="0" width="750">
<tbody><tr>

<td align="right" width="6"><?php echo smn_image(TEMPLATE_IMAGES . 'folder_left.gif'); ?></td>
<td class="folder" align="center"><a href="<?php echo smn_href_link(FILENAME_INDEX, 'ID=1'); ?>">Home</a></td>
<td align="left" width="6"><?php echo smn_image(TEMPLATE_IMAGES . 'folder_right.gif'); ?></td>

<td align="right" width="6"><?php echo smn_image(TEMPLATE_IMAGES . 'folder_left.gif'); ?></td>
<td class="folder" align="center"><a href="<?php echo smn_href_link(FILENAME_SPECIALS, 'ID=' . $store_id); ?>">Specials</a></td>
<td align="left" width="6"><?php echo smn_image(TEMPLATE_IMAGES . 'folder_right.gif'); ?></td>

<td align="right" width="6"><?php echo smn_image(TEMPLATE_IMAGES . 'folder_left.gif'); ?></td>
<td class="folder" align="center"><a href="<?php echo smn_href_link(FILENAME_ALLPRODS, 'ID=1'); ?>">All Products</a></td>
<td align="left" width="6"><?php echo smn_image(TEMPLATE_IMAGES . 'folder_right.gif'); ?></td>

<td align="right" width="6"><?php echo smn_image(TEMPLATE_IMAGES . 'folder_left.gif'); ?></td>
<td class="folder" align="center"><a href="<?php echo smn_href_link(FILENAME_SITEMAP, 'ID=' . $store_id); ?>">Site Map</a></td>
<td align="left" width="6"><?php echo smn_image(TEMPLATE_IMAGES . 'folder_right.gif'); ?></td>

<td align="right" width="6"><?php echo smn_image(TEMPLATE_IMAGES . 'folder_left.gif'); ?></td>
<td class="folder" align="center"><a href="<?php echo smn_href_link(FILENAME_LOGIN, 'account=new_store&ID=1'); ?>">Sellers</a></td>
<td align="left" width="6"><?php echo smn_image(TEMPLATE_IMAGES . 'folder_right.gif'); ?></td>

<td align="right" width="6"><?php echo smn_image(TEMPLATE_IMAGES . 'folder_left.gif'); ?></td>
<td class="folder" align="center"><a href="<?php echo smn_href_link(FILENAME_LOGIN, 'account=new_agent&ID=1'); ?>">Sales Agents</a></td>
<td align="left" width="6"><?php echo smn_image(TEMPLATE_IMAGES . 'folder_right.gif'); ?></td>

<td align="right" width="6"><?php echo smn_image(TEMPLATE_IMAGES . 'folder_left.gif'); ?></td>
<td class="folder" align="center"><a href="<?php echo smn_href_link(FILENAME_CONDITIONS, 'ID=1'); ?>">Conditions</a></td>
<td align="left" width="6"><?php echo smn_image(TEMPLATE_IMAGES . 'folder_right.gif'); ?></td>

<?php
  if(isset($customer_id)){
  ?>
<td align="right" width="6"><?php echo smn_image(TEMPLATE_IMAGES . 'folder_left.gif'); ?></td>
<td class="folder" align="center"><a href="<?php echo smn_href_link(FILENAME_ACCOUNT, 'ID=' . $store_id); ?>">Account</a></td>
<?php
  }else{
  ?>
<td align="right" width="6"><?php echo smn_image(TEMPLATE_IMAGES . 'folder_left.gif'); ?></td>
<td class="folder" align="center"><a href="<?php echo smn_href_link(FILENAME_LOGIN, 'account=new_customer&ID=1'); ?>">Buyers</a></td>
<?php
  }
?>



<td align="left" width="6"><?php echo smn_image(TEMPLATE_IMAGES . 'folder_right.gif'); ?></td>

<td align="right" width="6"><?php echo smn_image(TEMPLATE_IMAGES . 'folder_left.gif'); ?></td>
<td class="folder" align="center"><a href="<?php echo smn_href_link(FILENAME_HELP); ?>">Help</a></td>
<td align="left" width="6"><?php echo smn_image(TEMPLATE_IMAGES . 'folder_right.gif'); ?></td>

<td align="right" width="6"><?php echo smn_image(TEMPLATE_IMAGES . 'folder_left.gif'); ?></td>
<td class="folder" align="center"><a href="<?php echo smn_href_link(FILENAME_SHIPPING, 'ID=' . $store_id); ?>">Shipping</a></td>
<td align="left" width="6"><?php echo smn_image(TEMPLATE_IMAGES . 'folder_right.gif'); ?></td>

<td align="right" width="6"><?php echo smn_image(TEMPLATE_IMAGES . 'folder_left.gif'); ?></td>
<td class="folder" align="center"><a href="<?php echo smn_href_link(FILENAME_CONTACT_US, 'ID=1'); ?>">Contact Mall</a></td>
<td align="left" width="6"><?php echo smn_image(TEMPLATE_IMAGES . 'folder_right.gif'); ?></td>  
</tr>
</tbody></table>
<table class="info_bar" border="0" cellpadding="0" cellspacing="0" width="750">
<tbody><tr>
<td class="info_bar_td" align="left" width="250">
   <table border="0" cellpadding="0" cellspacing="0" width="100%">
 		 <!-- search //-->
          <tbody><tr>
            <td>
<table class="infoBoxSearch" border="0" cellpadding="0" cellspacing="0" width="100%">
  <tbody><tr>
    <td><table class="infoBoxContentsSearch" border="0" cellpadding="0" cellspacing="0" width="100%">
  <tbody><tr>
    <td><img src="images/pixel_trans.gif" alt="" border="0" height="1" width="100%"></td>
  </tr>
  <tr>
    <td class="boxText" align="center"><form name="quick_find" action="<?php echo smn_href_link(FILENAME_ADVANCED_SEARCH_RESULT); ?>" method="get">Quick Find&nbsp;<input name="keywords" size="10" maxlength="30" style="width: 95px;" type="text">&nbsp;<input src="includes/template/smn_original/template_images/button_quick_find.gif" alt="Quick Find" title=" Quick Find " class="submit_button" align="absmiddle" border="0" type="image"><?php
     echo smn_draw_hidden_field(session_name(), session_id()) . 
          smn_draw_hidden_field('ID', $store_id);
    ?></form></td>
  </tr>
  <tr>
    <td><img src="images/pixel_trans.gif" alt="" border="0" height="1" width="100%"></td>
  </tr>
</tbody></table>
</td>
  </tr>
</tbody></table>
            </td>
          </tr>
<!-- search_eof //-->
		</tbody></table>
</td>
<td><table class="expender_tb" width="100%"><tbody><tr><td></td></tr></tbody></table></td>
<td class="info_bar_td" align="right" width="440">
   <table border="0" cellpadding="0" cellspacing="0" width="100%">
 		 <!-- loginbox //-->
          <tbody><tr>
            <td>
<table class="infoBoxLogin" border="0" cellpadding="0" cellspacing="0" width="100%">
  <tbody><tr>
    <td><table class="infoBoxContentsLogin" border="0" cellpadding="0" cellspacing="0" width="100%">
  <tbody><tr>
    <td><img src="images/pixel_trans.gif" alt="" border="0" height="1" width="100%"></td>
  </tr>
  <tr>
    <td class="boxText" align="center">
            <form name="login" method="post" action="<?php echo  smn_href_link(FILENAME_LOGIN, 'action=process'); ?>">
            <table class="login_box" border="0" cellpadding="0" cellspacing="0" width="100%">
              <tbody><tr>
                <td class="boxText" align="center">
                  &nbsp;&nbsp;E-Mail Address:
                </td>
                <td class="boxText" align="center">
                  <input name="email_address" maxlength="96" size="15" value="" type="text">
                </td>
                <td class="boxText" align="center">
                  Password:
                </td>
                <td class="boxText" align="center">
                  <input name="password" maxlength="40" size="15" value="" type="password"></td>
                <td class="boxText" align="center">
                  <input src="includes/template/smn_original/template_images/button_login.gif" alt="Sign In" title=" Sign In " class="submit_button" border="0" type="image">
                </td>
              </tr>
            
            </tbody></table></form></td>
  </tr>
  <tr>
    <td><img src="images/pixel_trans.gif" alt="" border="0" height="1" width="100%"></td>
  </tr>
</tbody></table>
</td>
  </tr>
</tbody></table>
	
            </td>
          </tr>
<!-- loginbox_eof //-->

		</tbody></table>
</td> 
</tr>
</tbody></table>
 

<!-- header_eof //-->
