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
.login_heading { font-family: Verdana, Arial, sans-serif; font-size: 12px; color: #000000;}
.login { font-family: Verdana, Arial, sans-serif; font-size: 12px; color: #000000;}
//--></style>
<table border="0" width="600" cellspacing="0" cellpadding="0" align="center" style="margin-top:10%">
  <tr>
    <td><table border="0" width="600" height="440" cellspacing="0" cellpadding="1" align="center" valign="middle">
      <tr bgcolor="#000000">
        <td><table border="0" width="600" height="440" cellspacing="0" cellpadding="0">
          <tr bgcolor="#ffffff">
            <td><?php echo smn_image(DIR_WS_IMAGES  . 'logo.gif', STORE_NAME, '200', ''); ?></td>
          </tr>
          <tr align="left" bgcolor="#ffffff">
            <td align="center" class="text" nowrap><?php echo '<a href="' . smn_catalog_href_link() . '">' . HEADER_TITLE_ONLINE_CATALOG . '</a>&nbsp;|&nbsp;<a href="http://forum.systemsmanager.net" target="_blank">' . HEADER_TITLE_SUPPORT_SITE . '</a>'; ?>&nbsp;&nbsp;</td>
          </tr>
          <tr bgcolor="#ffffff">
            <td colspan="2" align="center" valign="middle">
                            <table width="280" border="0" cellspacing="0" cellpadding="2">
                              <tr>
                                <td class="login_heading" valign="top"><b><?php echo HEADING_TITLE; ?></b></td>
                              </tr>
                              <tr>
                                <td class="login_heading"><?php echo TEXT_MAIN; ?></td>
                              </tr>
                              <tr>
                                <td colspan="2"><?php echo smn_draw_separator('pixel_trans.gif', '100%', '30'); ?></td>
                              </tr>
                              <tr>
                                <td class="login_heading" align="right"><?php echo '<a class="login_heading" href="' . smn_href_link(FILENAME_LOGIN, '', 'NONSSL') . '">' . smn_image_button('button_login.gif', IMAGE_BUTTON_LOGIN) . '</a>'; ?></td>
                              </tr>
                              <tr>
                                <td colspan="2"><?php echo smn_draw_separator('pixel_trans.gif', '100%', '30'); ?></td>
                              </tr>
                            </table>
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