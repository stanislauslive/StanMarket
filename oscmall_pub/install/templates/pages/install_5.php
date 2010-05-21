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

  $https_www_address = str_replace('http://', 'https://', $_POST['HTTP_WWW_ADDRESS']);
?>

<p class="pageTitle">New Installation</p>

<p><b>oscMall Configuration</b></p>

<form name="install" action="install.php?step=6" method="post">

<p><b>Please enter the secure web server information:</b></p>

<table width="95%" border="0" cellpadding="2" class="formPage">
  <tr>
    <td width="30%" valign="top">Secure WWW Address:</td>
    <td width="70%" class="smallDesc">
      <?php echo osc_draw_input_field('HTTPS_WWW_ADDRESS', $https_www_address); ?>
      <div id="httpsWWWSD">The full website address to the online store on the secure server</div>
      <div id="httpsWWW" class="longDescription">The secure web address to the online store, for example <i>https://ssl.my-hosting-company.com/my_name/catalog/</i></div>
    </td>
  </tr>
  <tr>
    <td width="30%" valign="top">Secure Cookie Domain:</td>
    <td width="70%" class="smallDesc">
      <?php echo osc_draw_input_field('HTTPS_COOKIE_DOMAIN', $_POST['HTTP_COOKIE_DOMAIN']); ?>
      <div id="httpsCookieDSD">The secure domain to store cookies in</div>
      <div id="httpsCookieD" class="longDescription">The full or top-level domain of the secure server to store the cookies in, for example <i>ssl.my-hosting-company.com</i></div>
    </td>
  </tr>
  <tr>
    <td width="30%" valign="top">Secure Cookie Path:</td>
    <td width="70%" class="smallDesc">
      <?php echo osc_draw_input_field('HTTPS_COOKIE_PATH', $_POST['HTTP_COOKIE_PATH']); ?>
      <div id="dbCookiePSD">The secure path to store cookies under</div>
      <div id="dbCookieP" class="longDescription">The web address of the secure server to limit the cookie to, for example <i>/my_name/catalog/</i></div>
    </td>
  </tr>
</table>

<p>&nbsp;</p>

<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><a href="index.php"><img src="images/button_cancel.gif" border="0" alt="Cancel"></a></td>
    <td align="center"><input type="image" src="images/button_continue.gif" border="0" alt="Continue"></td>
  </tr>
</table>

<?php
  reset($_POST);
  while (list($key, $value) = each($_POST)) {
    if (($key != 'x') && ($key != 'y')) {
      if (is_array($value)) {
        for ($i=0; $i<sizeof($value); $i++) {
          echo osc_draw_hidden_field($key . '[]', $value[$i]);
        }
      } else {
        echo osc_draw_hidden_field($key, $value);
      }
    }
  }
?>

</form>
