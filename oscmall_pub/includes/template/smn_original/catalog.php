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

  global $page_name;
?>

<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<?php
if ( file_exists(DIR_WS_INCLUDES . 'header_tags.php') ) {
  require(DIR_WS_INCLUDES . 'header_tags.php');
} else {
?> 
  <title><?php echo TITLE; ?></title>
<?php
}
?>
<base href="<?php echo (getenv('HTTPS') == 'on' ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>">
<link rel="stylesheet" type="text/css" href="<? echo THEMA_STYLE;?>">
<?php
  if ( file_exists(DIR_WS_JAVA . basename(PAGE_NAME)) ) {
    require(DIR_WS_JAVA. basename(PAGE_NAME));
  }
?>
  <?php echo $jQuery->getHeadOutput();?>
  <script language="Javascript">
      $(document).ready(function (){
          <?php echo $jQuery->getScriptOutput();?>
      });
  </script>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<span id="toolTipBox" width="500"></span>


<?php
  if ( file_exists(DIR_WS_SITE_FILES . 'header.php') ) {
    require(DIR_WS_SITE_FILES . 'header.php');
  }
?>
  
  </td></tr>
  <tr><td>
  <table WIDTH="778" ALIGN="center" valign="top">
  <tr><td WIDTH="515" valign="top" ALIGN="CENTER">
   <table WIDTH="500"  valign="top" ALIGN="CENTER" class="abcd"><tr>
    <td class="headerNavigation"><?php echo $breadcrumb->trail(' &raquo; '); ?></td>
   </tr><tr><td>
   
<?php
  if ( file_exists(DIR_WS_BODY  . basename(PAGE_NAME)) ) {
    require(DIR_WS_BODY . basename(PAGE_NAME));
  }
?>
   
   </td></tr><tr><td align="center"><?php echo smn_draw_separator('pixel_trans.gif', '10', '10'); ?></td></tr></table>

   </td>
   <td WIDTH="255" valign="top">
  <table WIDTH="250" valign="top">
  <tr><td valign="top" WIDTH="250">
  <?php require(DIR_WS_TEMPLATE . 'column_right.php'); ?>
  </td></tr>

  </table>
  </td></tr>  
  

<?php if (($request_type == 'NONSSL')) {

?>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '20'); ?></td>
      </tr>
      <tr>
        <td align="center" width="100%">


<script language='JavaScript' type='text/javascript' src='http://www.systemsmanager.net/banner_manager/adx.js'></script>
<script language='JavaScript' type='text/javascript'>
<!--
   if (!document.phpAds_used) document.phpAds_used = ',';
   phpAds_random = new String (Math.random()); phpAds_random = phpAds_random.substring(2,11);
   
   document.write ("<" + "script language='JavaScript' type='text/javascript' src='");
   document.write ("http://www.systemsmanager.net/banner_manager/adjs.php?n=" + phpAds_random);
   document.write ("&amp;clientid=2&amp;target=_blank&amp;block=1");
   document.write ("&amp;exclude=" + document.phpAds_used);
   if (document.referrer)
      document.write ("&amp;referer=" + escape(document.referrer));
   document.write ("'><" + "/script>");
//-->
</script><noscript><a href='http://www.systemsmanager.net/banner_manager/adclick.php?n=a195ffbd' target='_blank'><img src='http://www.systemsmanager.net/banner_manager/adview.php?clientid=2&amp;n=a195ffbd' border='0' alt=''></a></noscript>

        </td>
      </tr>
<?php 
	    }
?>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '20'); ?></td>
      </tr>
  </table>
  </td></tr>
  <tr ALIGN="CENTER"><td ALIGN="CENTER">
  <table WIDTH="778" ALIGN="CENTER" valign="top" class="abcde">
  <tr><td>
<?php
  if ( file_exists(DIR_WS_SITE_FILES . 'footer.php') ) {
    require(DIR_WS_SITE_FILES . 'footer.php');
  }
?>

</body>
</html>