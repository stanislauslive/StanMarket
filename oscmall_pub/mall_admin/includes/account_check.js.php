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
?>

<?php
if (substr(basename($PHP_SELF), 0, 12) == 'admin_member') {
?>

<script language="JavaScript" type="text/JavaScript">
<!--
function validateForm() { 
  var p,z,xEmail,errors='',dbEmail,result=0,i;

  var adminName1 = document.newmember.admin_firstname.value;
  var adminName2 = document.newmember.admin_lastname.value;
  var adminEmail = document.newmember.admin_email_address.value;
  
  if (adminName1 == '') { 
    errors+='<?php echo JS_ALERT_FIRSTNAME; ?>';
  } else if (adminName1.length < <?php echo ENTRY_FIRST_NAME_MIN_LENGTH; ?>) { 
    errors+='- Firstname length must over  <?php echo (ENTRY_FIRST_NAME_MIN_LENGTH); ?>\n';
  }

  if (adminName2 == '') { 
    errors+='<?php echo JS_ALERT_LASTNAME; ?>';
  } else if (adminName2.length < <?php echo ENTRY_FIRST_NAME_MIN_LENGTH; ?>) { 
    errors+='- Lastname length must over  <?php echo (ENTRY_LAST_NAME_MIN_LENGTH);  ?>\n';
  }

  if (adminEmail == '') {
    errors+='<?php echo JS_ALERT_EMAIL; ?>';
  } else if (adminEmail.indexOf("@") <= 1 || adminEmail.indexOf("@") >= (adminEmail.length - 3) || adminEmail.indexOf(".") <= 3 || adminEmail.indexOf(".") >= (adminEmail.length - 2) || adminEmail.indexOf("@.") >= 0 ) {
    errors+='<?php echo JS_ALERT_EMAIL_FORMAT; ?>';
  } else if (adminEmail.length < <?php echo ENTRY_EMAIL_ADDRESS_MIN_LENGTH; ?>) {
    errors+='<?php echo JS_ALERT_EMAIL_FORMAT; ?>';
  }

  if (errors) alert('The following error(s) occurred:\n'+errors);
  document.returnValue = (errors == '');
}


function checkGroups(obj) {
  var subgroupID,i;
  subgroupID = eval("this.defineForm.subgroups_"+parseFloat((obj.id).substring(7)));
    
  if (subgroupID.length > 0) {
    for (i=0; i<subgroupID.length; i++) {
      if (obj.checked == true) { subgroupID[i].checked = true; }
      else { subgroupID[i].checked = false; }
    }
  } else {
    if (obj.checked == true) { subgroupID.checked = true; }
    else { subgroupID.checked = false; }
  }
}

function checkSub(obj) {
  var groupID,subgroupID,i,num=0;
  groupID = eval("this.defineForm.groups_"+parseFloat((obj.id).substring(10)));
  subgroupID = eval("this.defineForm."+(obj.id));
      
  if (subgroupID.length > 0) {    
    for (i=0; i < subgroupID.length; i++) {
      if (subgroupID[i].checked == true) num++;
    }
  } else {
    if (subgroupID.checked == true) num++;
  }
  if (num>0) { groupID.checked = true; }
  else { groupID.checked = false; }
}
//-->
</script>

<?php
} else {
?>

<script language="JavaScript" type="text/JavaScript">
<!--
function validateForm() { 
  var p,z,xEmail,errors='',dbEmail,result=0,i;

  var adminName1 = document.account.admin_firstname.value;
  var adminName2 = document.account.admin_lastname.value;
  var adminEmail = document.account.admin_email_address.value;
  var adminPass1 = document.account.admin_password.value;
  var adminPass2 = document.account.admin_password_confirm.value;
  
  if (adminName1 == '') { 
    errors+='<?php echo JS_ALERT_FIRSTNAME; ?>';
  } else if (adminName1.length < <?php echo ENTRY_FIRST_NAME_MIN_LENGTH; ?>) { 
    errors+='<?php echo JS_ALERT_FIRSTNAME_LENGTH . ENTRY_FIRST_NAME_MIN_LENGTH; ?>\n';
  }

  if (adminName2 == '') { 
    errors+='<?php echo JS_ALERT_LASTNAME; ?>';
  } else if (adminName2.length < <?php echo ENTRY_LAST_NAME_MIN_LENGTH; ?>) { 
    errors+='<?php echo JS_ALERT_LASTNAME_LENGTH . ENTRY_LAST_NAME_MIN_LENGTH;  ?>\n';
  }

  if (adminEmail == '') {
    errors+='<?php echo JS_ALERT_EMAIL; ?>';
  } else if (adminEmail.indexOf("@") <= 1 || adminEmail.indexOf("@") >= (adminEmail.length - 3) || adminEmail.indexOf(".") <= 3 || adminEmail.indexOf(".") >= (adminEmail.length - 2) || adminEmail.indexOf("@.") >= 0 ) {
    errors+='<?php echo JS_ALERT_EMAIL_FORMAT; ?>';
  } else if (adminEmail.length < <?php echo ENTRY_EMAIL_ADDRESS_MIN_LENGTH; ?>) {
    errors+='<?php echo JS_ALERT_EMAIL_FORMAT; ?>';
  }
  
  if (adminPass1 == '') { 
    errors+='<?php echo JS_ALERT_PASSWORD; ?>';
  } else if (adminPass1.length < <?php echo ENTRY_PASSWORD_MIN_LENGTH; ?>) { 
    errors+='<?php echo JS_ALERT_PASSWORD_LENGTH . ENTRY_PASSWORD_MIN_LENGTH; ?>\n';
  } else if (adminPass1 != adminPass2) {
    errors+='<?php echo JS_ALERT_PASSWORD_CONFIRM; ?>';
  }
  
  if (errors) alert('The following error(s) occurred:\n'+errors);
  document.returnValue = (errors == '');
}

//-->
</script>

<?php
}
?>