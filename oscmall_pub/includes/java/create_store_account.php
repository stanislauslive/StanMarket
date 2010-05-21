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

var form = "";
var submitted = false;
var error = false;
var error_message = "";
var formerrormsg="You\'ve attempted to submit the form multiple times.\n Please reload page if you need to resubmit form."

function checksubmit(submitbtn){
var errorCheck = check_form(submitbtn.form);
if (errorCheck == true){
   checksubmit=blocksubmit
   return true;
}
return false
}

function checksubmit_orig(submitbtn){
check_form(submitbtn.form)
checksubmit=blocksubmit
return false
}

function blocksubmit(){
if (typeof formerrormsg!="undefined")
alert(formerrormsg)
return false
}

function check_input(field_name, field_size, message) {
  if (form.elements[field_name] && (form.elements[field_name].type != "hidden")) {
    var field_value = form.elements[field_name].value;

    if (field_value == '' || field_value.length < field_size) {
      error_message = error_message + "* " + message + "\n";
      error = true;
    }
  }
}

function check_radio(field_name, message) {
  var isChecked = false;

  if (form.elements[field_name] && (form.elements[field_name].type != "hidden")) {
    var radio = form.elements[field_name];
    
    if (radio.length == undefined){
        if (radio.checked == true){
            isChecked = true;
        }
    }else{
       for (var i=0; i<radio.length; i++) {
          if (radio[i].checked == true) {
            isChecked = true;
            break;
          }
        }
    }

    if (isChecked == false) {
      error_message = error_message + "* " + message + "\n";
      error = true;
    }
  }
}

function check_select(field_name, field_default, message) {
  if (form.elements[field_name] && (form.elements[field_name].type != "hidden")) {
    var field_value = form.elements[field_name].value;

    if (field_value == field_default) {
      error_message = error_message + "* " + message + "\n";
      error = true;
    }
  }
}

function check_password(field_name_1, field_name_2, field_size, message_1, message_2) {
  if (form.elements[field_name_1] && (form.elements[field_name_1].type != "hidden")) {
    var password = form.elements[field_name_1].value;
    var confirmation = form.elements[field_name_2].value;

    if (password == '' || password.length < field_size) {
      error_message = error_message + "* " + message_1 + "\n";
      error = true;
    } else if (password != confirmation) {
      error_message = error_message + "* " + message_2 + "\n";
      error = true;
    }
  }
}

function check_password_new(field_name_1, field_name_2, field_name_3, field_size, message_1, message_2, message_3) {
  if (form.elements[field_name_1] && (form.elements[field_name_1].type != "hidden")) {
    var password_current = form.elements[field_name_1].value;
    var password_new = form.elements[field_name_2].value;
    var password_confirmation = form.elements[field_name_3].value;

    if (password_current == '' || password_current.length < field_size) {
      error_message = error_message + "* " + message_1 + "\n";
      error = true;
    } else if (password_new == '' || password_new.length < field_size) {
      error_message = error_message + "* " + message_2 + "\n";
      error = true;
    } else if (password_new != password_confirmation) {
      error_message = error_message + "* " + message_3 + "\n";
      error = true;
    }
  }
}

function check_form(form_name) {
  error = false;
  form = form_name;
  error_message = "<?php echo JS_ERROR; ?>\n";
  
  $('#firstname[type!="hidden"]').each(function (){
      if ($(this).val().length < <?php echo ENTRY_FIRST_NAME_MIN_LENGTH; ?>){
          error_message = error_message + '* <?php echo ENTRY_FIRST_NAME_ERROR; ?>' + "\n";
          error = true;
      }
  });
  $('#lastname[type!="hidden"]').each(function (){
      if ($(this).val().length < <?php echo ENTRY_LAST_NAME_MIN_LENGTH; ?>){
          error_message = error_message + '* <?php echo ENTRY_LAST_NAME_ERROR; ?>' + "\n";
          error = true;
      }
  });

  $('#email_address[type!="hidden"]').each(function (){
      if ($(this).val().length < <?php echo ENTRY_EMAIL_ADDRESS_MIN_LENGTH; ?>){
          error_message = error_message + '* <?php echo ENTRY_EMAIL_ADDRESS_ERROR; ?>' + "\n";
          error = true;
      }
  });
  $('#street_address[type!="hidden"]').each(function (){
      if ($(this).val().length < <?php echo ENTRY_STREET_ADDRESS_MIN_LENGTH; ?>){
          error_message = error_message + '* <?php echo ENTRY_STREET_ADDRESS_ERROR; ?>' + "\n";
          error = true;
      }
  });
  $('#postcode[type!="hidden"]').each(function (){
      if ($(this).val().length < <?php echo ENTRY_POSTCODE_MIN_LENGTH; ?>){
          error_message = error_message + '* <?php echo ENTRY_POST_CODE_ERROR; ?>' + "\n";
          error = true;
      }
  });
  $('#city[type!="hidden"]').each(function (){
      if ($(this).val().length < <?php echo ENTRY_CITY_MIN_LENGTH; ?>){
          error_message = error_message + '* <?php echo ENTRY_CITY_ERROR; ?>' + "\n";
          error = true;
      }
  });

  $('#state[type!="hidden"]').each(function (){
      if ($(this).val() == '' || $(this).val() == 'null'){
          error_message = error_message + '* <?php echo ENTRY_STATE_ERROR; ?>' + "\n";
          error = true;
      }
  });
  $('#country[type!="hidden"]').each(function (){
      if ($(this).val() == '' || $(this).val() == 'null'){
          error_message = error_message + '* <?php echo ENTRY_COUNTRY_ERROR; ?>' + "\n";
          error = true;
      }
  });
  
  var tError = false;
  $('#telephone_area[type!="hidden"]').each(function (){
      if ($(this).val() == '' || $(this).val().length < 3){
          tError = true;
      }
  });
  
  if (tError == false){
      $('#telephone_prefix[type!="hidden"]').each(function (){
          if ($(this).val() == '' || $(this).val().length < 3){
              tError = true;
          }
      });
  }

  if (tError == false){
      $('#telephone_post[type!="hidden"]').each(function (){
          if ($(this).val() == '' || $(this).val().length < 4){
              tError = true;
          }
      });
  }
  
  if (tError == true){
      error_message = error_message + '* Telephone Number Appears To Be Invalid' + "\n"
      error = true;
  }

  if ($('#password[type!="hidden"]').length > 0){
      var $password = $('#password');
      var $passwordConf = $('#confirmation');
      var minLength = <?php echo ENTRY_PASSWORD_MIN_LENGTH; ?>;
      
      if ($password.val() == '' || $password.val().length < minLength) {
          error_message = error_message + "* <?php echo ENTRY_PASSWORD_ERROR; ?>\n";
          error = true;
      } else if ($password.val() != $passwordConf.val()) {
          error_message = error_message + "* <?php echo ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING; ?>\n";
          error = true;
      }
  }

  $('#storename[type!="hidden"]').each(function (){
      if ($(this).val().length < 3){
          error_message = error_message + '* You must enter a unique store name longer than 3 letters.' + "\n";
          error = true;
      }
  });
  $('#store_catagory[type!="hidden"]').each(function (){
      if ($(this).val() == '' || $(this).val() == 'null'){
          error_message = error_message + '* You must select a category for your store to be in.' + "\n";
          error = true;
      }
  });
  
  check_radio("store_type", "You must select a store type.");
  
  var reAddEditor = false;
  $('#store_description[type!="hidden"]').each(function (){
      if (typeof tinyMCE != 'undefined'){
          tinyMCE.execCommand('mceRemoveControl', false, $(this).attr('id'));
          reAddEditor = true;
      }
      if ($(this).val() == '' || $(this).val() == 'null'){
          error_message = error_message + '* You must enter a store description for your store.' + "\n";
          error = true;
      }
  });


  if (error == true) {
    checksubmit = checksubmit_orig
    
    alert(error_message);
    if (typeof tinyMCE != 'undefined' && reAddEditor == true){
        tinyMCE.execCommand('mceAddControl', false, 'store_description');
    }

    return false;
  } else {
    form_name.submit();
    submitted = true;
    return false;
  }
}
</script>