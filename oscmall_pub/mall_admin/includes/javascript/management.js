function check_form() {
  var error = 0;
  var error_message = "<?php echo JS_ERROR; ?>";
  var new_store_name = document.new_store.new_store_name.value;
  var customers_firstname = document.new_store.customers_firstname.value;
  var customers_lastname = document.new_store.customers_lastname.value;
<?php 
if (ACCOUNT_COMPANY == 'true') {
?>
  var entry_company = document.new_store.entry_company.value;
<?php 
}

if (ACCOUNT_DOB == 'true') {
?>
	var customers_dob = document.new_store.customers_dob.value;
<?php
}
?>
  var customers_email_address = document.new_store.customers_email_address.value;
  var entry_street_address = document.new_store.entry_street_address.value;
  var entry_postcode = document.new_store.entry_postcode.value;
  var entry_city = document.new_store.entry_city.value;
  var customers_telephone = document.new_store.customers_telephone.value;
<?php if (ACCOUNT_GENDER == 'true') { ?>
  if (document.new_store.customers_gender[0].checked || document.new_store.customers_gender[1].checked) {
  } else {
    error_message = error_message + "<?php echo JS_GENDER; ?>";
    error = 1;
  }
<?php } ?>
  if (new_store_name == "" || new_store_name.length < <?php echo ENTRY_STORE_NAME_MIN_LENGTH; ?>) {
    error_message = error_message + "<?php echo ENTRY_STORE_NAME_ERROR; ?>";
    error = 1;
  }
  if (customers_firstname == "" || customers_firstname.length < <?php echo ENTRY_FIRST_NAME_MIN_LENGTH; ?>) {
    error_message = error_message + "<?php echo JS_FIRST_NAME; ?>";
    error = 1;
  }
  if (customers_lastname == "" || customers_lastname.length < <?php echo ENTRY_LAST_NAME_MIN_LENGTH; ?>) {
    error_message = error_message + "<?php echo JS_LAST_NAME; ?>";
    error = 1;
  }
<?php if (ACCOUNT_DOB == 'true') { ?>
  if (customers_dob == "" || customers_dob.length < <?php echo ENTRY_DOB_MIN_LENGTH; ?>) {
    error_message = error_message + "<?php echo JS_DOB; ?>";
    error = 1;
  }
<?php } ?>
  if (customers_email_address == "" || customers_email_address.length < <?php echo ENTRY_EMAIL_ADDRESS_MIN_LENGTH; ?>) {
    error_message = error_message + "<?php echo JS_EMAIL_ADDRESS; ?>";
    error = 1;
  }
  if (entry_street_address == "" || entry_street_address.length < <?php echo ENTRY_STREET_ADDRESS_MIN_LENGTH; ?>) {
    error_message = error_message + "<?php echo JS_ADDRESS; ?>";
    error = 1;
  }
  if (entry_postcode == "" || entry_postcode.length < <?php echo ENTRY_POSTCODE_MIN_LENGTH; ?>) {
    error_message = error_message + "<?php echo JS_POST_CODE; ?>";
    error = 1;
  }
  if (entry_city == "" || entry_city.length < <?php echo ENTRY_CITY_MIN_LENGTH; ?>) {
    error_message = error_message + "<?php echo JS_CITY; ?>";
    error = 1;
  }
<?php
  if (ACCOUNT_STATE == 'true') {
?>
  if (document.new_store.elements['entry_state'].type != "hidden") {
    if (document.new_store.entry_state.value == '' || document.new_store.entry_state.value.length < <?php echo ENTRY_STATE_MIN_LENGTH; ?> ) {
       error_message = error_message + "<?php echo JS_STATE; ?>";
       error = 1;
    }
  }
<?php
  }
?>
  if (document.new_store.elements['entry_country_id'].type != "hidden") {
    if (document.new_store.entry_country_id.value == 0) {
      error_message = error_message + "<?php echo JS_COUNTRY; ?>";
      error = 1;
    }
  }
  if (customers_telephone == "" || customers_telephone.length < <?php echo ENTRY_TELEPHONE_MIN_LENGTH; ?>) {
    error_message = error_message + "<?php echo JS_TELEPHONE; ?>";
    error = 1;
  }
  if (error == 1) {
    alert(error_message);
    return false;
  } else {
    return true;
  }
}

