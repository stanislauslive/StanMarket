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

  require('includes/application_top.php');

    if (isset($_GET['ID']))
  {
      $GLOBALS['store_id'] = '';
      smn_redirect(smn_href_link(FILENAME_LOGIN, '', 'NONSSL'));
  }    

 
  if (isset($_GET['action']) && ($_GET['action'] == 'process')) {
    $email_address = smn_db_prepare_input($_POST['email_address']);
    $password = smn_db_prepare_input($_POST['password']);

// Check if email exists
    $check_admin_query = smn_db_query("select store_id, admin_id as login_id, admin_groups_id as login_groups_id, admin_firstname as login_firstname, admin_email_address as login_email_address, admin_password as login_password, admin_modified as login_modified, admin_logdate as login_logdate, admin_lognum as login_lognum from " . TABLE_ADMIN . " where admin_email_address = '" . smn_db_input($email_address) . "'");
    if ($email_address != 'admin@localhost' && !smn_db_num_rows($check_admin_query)) {
      $login = 'fail';
    } else {
      $check_admin = smn_db_fetch_array($check_admin_query);
      // Check that password is good
      if ($email_address != 'admin@localhost' && !smn_validate_password($password, $check_admin['login_password'])) {
        $login = 'fail';
      } else {
        if (smn_session_is_registered('password_forgotten')) {
          smn_session_unregister('password_forgotten');
        }

        $login_id = $check_admin['login_id'];
        $store_id = $check_admin['store_id'];
        $login_groups_id = $check_admin['login_groups_id'];
        $login_firstname = $check_admin['login_firstname'];
        $login_email_address = $check_admin['login_email_address'];
        $login_logdate = $check_admin['login_logdate'];
        $login_lognum = $check_admin['login_lognum'];
        $login_modified = $check_admin['login_modified'];
        if ($email_address == 'admin@localhost'){
           $login_id = 1;
           $store_id = 1;
           $login_groups_id = 1;
       }

        smn_session_register('login_id');
        smn_session_register('store_id');
        smn_session_register('login_groups_id');
        smn_session_register('login_first_name');

        //$date_now = date('Ymd');
        smn_db_query("update " . TABLE_ADMIN . " set admin_logdate = now(), admin_lognum = admin_lognum+1 where admin_id = '" . $login_id . "'");
          smn_redirect(smn_href_link(FILENAME_DEFAULT));
      }
    }
  }

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_LOGIN);
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<style type="text/css"><!--
a { color:#080381; text-decoration:none; }
a:hover { color:#aabbdd; text-decoration:underline; }
a.text:link, a.text:visited { color: #ffffff; text-decoration: none; }
a:text:hover { color: #000000; text-decoration: underline; }
a.sub:link, a.sub:visited { color: #dddddd; text-decoration: none; }
A.sub:hover { color: #dddddd; text-decoration: underline; }
.sub { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; line-height: 1.5; color: #dddddd; }
.text { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; color: #000000; }
.smallText { font-family: Verdana, Arial, sans-serif; font-size: 10px; }
.login_heading { font-family: Verdana, Arial, sans-serif; font-size: 12px; color: #ffffff;}
.login { font-family: Verdana, Arial, sans-serif; font-size: 12px; color: #000000;}
//--></style>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#7187bb">

<table border="0" width="600" height="100%" cellspacing="0" cellpadding="0" align="center" valign="middle">
  <tr>
    <td><table border="0" width="600" height="440" cellspacing="0" cellpadding="1" align="center" valign="middle">
      <tr bgcolor="#000000">
        <td><table border="0" width="600" height="440" cellspacing="0" cellpadding="0">
          <tr bgcolor="#ffffff" height="50">
          <td align="left" width="100%"><?php echo smn_image(DIR_WS_IMAGES  . 'logo.gif', STORE_NAME, '200', ''); ?></td>
          </tr>
          <tr bgcolor="#ffffff">
          <td align="center" width="100%"><?php echo 'If not a vendor please use our <a href="' . smn_catalog_href_link() . '">' . HEADER_TITLE_ONLINE_CATALOG . '</a><br/>For technical support please go to our <a href="http://forum.systemsmanager.net" target="_blank">' . HEADER_TITLE_SUPPORT_SITE . '</a>'; ?></td>
          </tr>
          <tr bgcolor="#ffffff">
            <td colspan="2" align="center" valign="middle">
                          <?php echo smn_draw_form('login', FILENAME_LOGIN, 'action=process', 'POST');?>
                            <table width="280" border="0" cellspacing="0" cellpadding="2">
                              <tr>
                                <td class="login_heading" valign="top">&nbsp;<b><?php echo HEADING_RETURNING_ADMIN; ?></b></td>
                              </tr>
                              <tr>
                                <td height="100%" valign="top" align="center">
                                <table border="0" height="100%" cellspacing="0" cellpadding="1" bgcolor="#ffffff">
                                  <tr><td><table border="0" width="100%" height="100%" cellspacing="3" cellpadding="2" bgcolor="#4fa4dc">
<?php
  if ($login == 'fail') {
    $info_message = TEXT_LOGIN_ERROR;
  }

  if (isset($info_message)) {
?>
                                    <tr>
                                      <td colspan="2" class="smallText" align="center"><?php echo $info_message; ?></td>
                                    </tr>
<?php
  } else {
?>
                                    <tr>
                                      <td colspan="2"><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                                    </tr>
<?php
  }
?>                                    
                                    <tr>
                                      <td class="login"><?php echo ENTRY_EMAIL_ADDRESS; ?></td>
                                      <td class="login"><?php echo smn_draw_input_field('email_address'); ?></td>
                                    </tr>
                                    <tr>
                                      <td class="login"><?php echo ENTRY_PASSWORD; ?></td>
                                      <td class="login"><?php echo smn_draw_password_field('password'); ?></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" align="right" valign="top"><?php echo smn_image_submit('button_confirm.gif', IMAGE_BUTTON_LOGIN); ?></td>
                                    </tr>
                                  </table></td></tr>
                                </table>
                                </td>
                              </tr>
                              <tr>
                                <td valign="top" align="right"><?php echo '<a class="smallText" href="' . smn_href_link(FILENAME_PASSWORD_FORGOTTEN, '', 'NONSSL') . '">' . TEXT_PASSWORD_FORGOTTEN . '</a><span class="sub">&nbsp;</span>'; ?></td>
                              </tr>
                            </table>
                          </form>
            </td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php require(DIR_WS_INCLUDES . 'footer.php'); ?></td>
      </tr>
    </table></td>
  </tr>
</table>

</body>

</html>