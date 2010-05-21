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
<script language="javascript">
function popupWindow(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=480,height=360,screenX=150,screenY=150,top=150,left=150')
}

function rowOverEffect(object) {
  if (object.className == 'moduleRow') object.className = 'moduleRowOver';
}

function rowOutEffect(object) {
  if (object.className == 'moduleRowOver') object.className = 'moduleRow';
}
//--></script>

<style type="text/css">
<!--
#toolTipBox {
	display: none;
	padding: 5;
	font-size: 12px;
	border: black solid 1px;
	font-family: verdana;
	position: absolute;
  background-color: #ffd038;
  color: 000000;
}
-->
</style>

<script type="text/javascript">
var theObj="";

function toolTip(text,me) {
  theObj=me;
  theObj.onmousemove=updatePos;
  document.getElementById('toolTipBox').innerHTML=text;
  document.getElementById('toolTipBox').style.display="block";
  window.onscroll=updatePos;
}

function updatePos() {
  var ev=arguments[0]?arguments[0]:event;
  var x=ev.clientX;
  var y=ev.clientY;
  diffX=24;
  diffY=0;
  document.getElementById('toolTipBox').style.top  = y-2+diffY+document.body.scrollTop+ "px";
  document.getElementById('toolTipBox').style.left = x-2+diffX+document.body.scrollLeft+"px";
  theObj.onmouseout=hideMe;
}
function hideMe() {
  document.getElementById('toolTipBox').style.display="none";
}
//-->
</script>