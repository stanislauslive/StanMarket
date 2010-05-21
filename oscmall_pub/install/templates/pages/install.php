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

<form name="install" action="install.php?step=2" method="post">

<p><b>Please customize the new installation with the following options:</b></p>

<table width="95%" border="0" cellpadding="2" class="formPage">
  <tr>
    <td width="30%" valign="top">Import Catalog Database:</td>
    <td width="70%" class="smallDesc">
      <?php echo osc_draw_checkbox_field('install[]', 'database', true); ?>
      <img src="images/layout/help_icon.gif" onClick="toggleBox('dbImport');"><br>
      <div id="dbImportSD">Install the database and add the sample data</div>
      <div id="dbImport" class="longDescription">Checking this box will import the database structure, required data, and some sample data. (required for first time installations)</div>
    </td>
  </tr>
  <tr>
    <td width="30%" valign="top">Automatic Configuration:</td>
    <td width="70%" class="smallDesc">
      <?php echo osc_draw_checkbox_field('install[]', 'configure', true); ?>
      <img src="images/layout/help_icon.gif" onClick="toggleBox('autoConfig');"><br>
      <div id="autoConfigSD">Save configuration values</div>
      <div id="autoConfig" class="longDescription">Checking this box will save all entered data during the installation procedure to the appropriate configuration files on the server.</div>
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

</form>
