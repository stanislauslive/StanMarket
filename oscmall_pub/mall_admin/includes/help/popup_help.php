<?php
/*
  Copyright (c) 2006 SystemsManager.Net

  SystemsManager Technologies
  AnySiteAffiliate Version 1.0       (June 2006)
  http://www.systemsmanager.net
  
  Portions Copyright (c) 2002 osCommerce
  
  This source file is subject to version 2.0 of the GPL license,   
  that is bundled with this package in the file LICENSE. If you
  did not receive a copy of the AnySiteAffiliate license and are unable 
  to obtain it through the world-wide-web, please send a note to    
  license@systemsmanager.net so we can mail you a copy immediately.
*/

  
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html dir="ltr" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>YourVacationMaker Help Files for <?php echo $_GET['HelpID']; ?></title>
<base href="<?php echo $_SERVER['SERVER_NAME']  . '/mall_admin/includes/help/'; ?>">

<script language="javascript"><!--
function resize() {
    window.resizeTo(500, 800);
}
//--></script>

<style type="text/css"><!--
body { background-color: #7187bb; color: #000000; margin: 0px; }
.headerBar { background-color: #000093; }
.headerBarContent { font-family: Verdana, Arial, sans-serif; font-size: 10px; color: #ffffff; font-weight: bold; padding: 2px; }
.columnLeft { background-color: #F0F1F1; border-color: #999999; border-width: 1px; border-style: solid; padding: 2px; }
.pageHeading { font-family: Verdana, Arial, sans-serif; font-size: 18px; color: #727272; font-weight: bold; }
.smallText { font-family: Verdana, Arial, sans-serif; font-size: 10px; }
.main { font-family: Verdana, Arial, sans-serif; font-size: 12px; }

/* Styles for dhtml tabbed-pages */
.ontab {
	background-color: #003366;
	border-left: 1px outset #003366;
	border-right: outset 1px #003366;
	border-top: 1px outset #003366;
	border-bottom: none;
	text-align: center;
	cursor: hand;
	font-family : Tahoma, Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #FFFFFF;
}
.offtab {
	background-color : #FFDF9D;
	border-left: outset 1px #003366;
	border-right: outset 1px #003366;
	border-top: outset 1px #003366;
	border-bottom: none;
	text-align: center;
	font-family : Tahoma, Arial, Helvetica, sans-serif;
	cursor: hand;
	font-weight: normal;
	font-size: 11px;
}
.tabpadding {
}

.tabheading {
	background-color: #003366;
	text-align: left;
}

.pagetext {
	visibility: hidden;
	display: none;
	position: relative;
	top: 0;
}

table.adminform {
	background-color: #FFDF9D;
        font-family : Tahoma, Arial, Helvetica, sans-serif;
	color: #003366;
	font-size: 11px;
	border-bottom: solid 1px #003366;
	border-top: solid 1px #003366;
	border-left: solid 1px #003366;
	border-right: solid 1px #003366;
	text-align: left;
	height: 25px;
	background-repeat: repeat;
}
--></style>

</head>

<body onLoad="resize();">
<script language="javascript" src="http://www.yourvacationmaker.com/mall_admin/includes/help/javascript/dhtml.js"></script>
<!-- <a href="javascript:;" onclick="javascript:top.window.close();"> //-->
<?php
if(is_file($_SERVER['DOCUMENT_ROOT']  . '/mall_admin/includes/help/' . $_GET['HelpID'] . '.php')){
  //include($_SERVER['DOCUMENT_ROOT']  . '/mall_admin/includes/help/' . $_GET['HelpID'] . '.php');
  include($_GET['HelpID'] . '.php');
}else{
  //include($_SERVER['DOCUMENT_ROOT']  . '/mall_admin/includes/help/default.php');
  include('default.php');
}
?>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><u><?php // echo TEXT_CLOSE_WINDOW; ?></u></td>
  </tr>
</table>
<!-- footer //-->
<br/>
<br/>
<br/>
<center>E-Commerce oscMall System<br>Copyright &copy; 2002 - 2006 <a href="http://www.systemsmanager.net" target="_blank">SystemsManager Technologies</a><br></center>
<br/>
<br/>
<br/>
<!-- footer_eof //-->
</body>
</html>