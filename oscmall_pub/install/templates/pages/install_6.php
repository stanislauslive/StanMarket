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
<p class="pageTitle">New Installation</p>

<p><b>oscMall Configuration</b></p>

<form name="install" action="install.php?step=7" method="post">

<table width="95%" border="0" cellpadding="2" class="formPage">
  <tr>
    <td width="30%" valign="top">Database Server:</td>
    <td width="70%" class="smallDesc">
      <?php echo osc_draw_input_field('DB_SERVER'); ?>
      <div id="dbHostSD">Hostame or IP-address of the database server</div>
      <div id="dbHost" class="longDescription">The database server can be in the form of a hostname, such as db1.myserver.com, or as an IP-address, such as 192.168.0.1</div>
    </td>
  </tr>
  <tr>
    <td width="30%" valign="top">Username:</td>
    <td width="70%" class="smallDesc">
      <?php echo osc_draw_input_field('DB_SERVER_USERNAME'); ?>
      <div id="dbUserSD">Database username</div>
      <div id="dbUser" class="longDescription">The username used to connect to the database server. An example username is 'mysql_10'.<br><br>Note: Create and Drop permissions <b>are not required</b> for the general use of osCommerce.</div>
    </td>
  </tr>
  <tr>
    <td width="30%" valign="top">Password:</td>
    <td width="70%" class="smallDesc">
      <?php echo osc_draw_password_field('DB_SERVER_PASSWORD'); ?>
      <div id="dbPassSD">Database password</div>
      <div id="dbPass" class="longDescription">The password is used together with the username, which forms the database user account.</div>
    </td>
  </tr>
  <tr>
    <td width="30%" valign="top">Database Name:</td>
    <td width="70%" class="smallDesc">
      <?php echo osc_draw_input_field('DB_DATABASE'); ?>
      <div id="dbNameSD">Database Name</div>
      <div id="dbName" class="longDescription">The database used to hold the data. An example database name is 'osCommerce'.</div>
    </td>
  </tr>
  <tr>
    <td width="30%" valign="top">Persistent Connections:</td>
    <td width="70%" class="smallDesc">
      <?php echo osc_draw_checkbox_field('USE_PCONNECT', 'true'); ?>
      <div id="dbConnSD"></div>
      <div id="dbConn" class="longDescription">Enable persistent database connections.<br><br>Note: Persistent connections should be disabled for shared servers.</div>
    </td>
  </tr>
  <tr>
    <td width="30%" valign="top">Session Storage:</td>
    <td width="70%" class="smallDesc">
      <?php echo osc_draw_radio_field('STORE_SESSIONS', 'files', (isset($_POST['STORE_SESSIONS']) ? '' : true)); ?>&nbsp;Files&nbsp;&nbsp;<?php echo osc_draw_radio_field('STORE_SESSIONS', 'mysql'); ?>&nbsp;Database&nbsp;&nbsp;
      <div id="dbSessSD"></div>
      <div id="dbSess" class="longDescription">Store user session data as files on the server, or in the database.<br><br>Note: Due to security related issues, database session storage is recommended for shared servers.</td></div>
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
    if (($key != 'x') && ($key != 'y') && ($key != 'DB_SERVER') && ($key != 'DB_SERVER_USERNAME') && ($key != 'DB_SERVER_PASSWORD') && ($key != 'DB_DATABASE') && ($key != 'USE_PCONNECT') && ($key != 'STORE_SESSIONS')) {
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
