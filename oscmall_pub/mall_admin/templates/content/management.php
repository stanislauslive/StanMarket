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
<SCRIPT LANGUAGE="JavaScript">
function textCounter(field,cntfield,maxlimit) {
	if (field.value.length > maxlimit) // if too long...trim it!
		field.value = field.value.substring(0, maxlimit);
	// otherwise, update 'characters left' counter
	else
		cntfield.value = maxlimit - field.value.length;
}
</script>

<script language="javascript" src="includes/general.js"></script>

<script language="javascript">
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
/*
<?php if (ACCOUNT_DOB == 'true') { ?>
  if (customers_dob == "" || customers_dob.length < <?php echo ENTRY_DOB_MIN_LENGTH; ?>) {
    error_message = error_message + "<?php echo JS_DOB; ?>";
    error = 1;
  }
<?php } ?>
*/
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

</script>
<?php
if (isset($_GET['action']) && $_GET['action'] == 'edit_store_category') {
	// DO NOTHING (OR ADD EXTRA CODE LATER...)
}
else {
	if (($request_type == 'NONSSL')) {
	   //include(DIR_FS_ADMIN . "editor.php");
	}else{
	  //@include(HTTPS_CATALOG_SERVER . DIR_WS_ADMIN . "editor.php");
	  }
}
?>
<style type="text/css"><!--
  .btn   { BORDER-WIDTH: 1; width: 26px; height: 24px; }
  .btnDN { BORDER-WIDTH: 1; width: 26px; height: 24px; BORDER-STYLE: inset; BACKGROUND-COLOR: buttonhighlight; }
  .btnNA { BORDER-WIDTH: 1; width: 26px; height: 24px; filter: alpha(opacity=25); }
--></style>
<!-- END : EDITOR HEADER -->
<?php
if ($action == 'process' || $action == 'edit_store' ||$action == 'new_store' ||$action == 'update_store') {
      if ($action == 'process' ||$action == 'new_store'){
        $set_action = 'process';
      }elseif ($action == 'edit_store' || $action == 'update_store'){
        $set_action = 'update';
    }
    $parameters = array('store_name' => '',
                       'store_description' => '',
                       'store_id' => '',
                       'date_added' => '',
                       'password' => '',
                       'store_status' => '',
                       'customers_id' => '',
                       'customers_email_address' => '',
                       'store_image' => '',
                       'store_description' => '',
                       'admin_groups_id' => '',
                       'customers_firstname' => '',
                       'customers_lastname' => '',
                       'customers_telephone' => '',
                       'customers_fax' => '',
                       'customers_newsletter' => '',
                       'entry_street_address' => '',
                       'entry_postcode' => '',
                       'entry_city' => '',
                       'entry_company' => '',
                       'entry_state' => '',
                       'entry_country_id' => '',
                       'customers_gender' => '',
                       'customers_dob' => '');
    $sInfo = new objectInfo($parameters);
    echo smn_draw_form('new_store', FILENAME_MANAGEMENT, smn_get_all_get_params(array('action')) . (isset($_GET['sID']) ? '&sID=' . $_GET['sID'] : '') . '&action=' . $set_action, 'post', 'onSubmit="return check_form();"  enctype="multipart/form-data"') . smn_draw_hidden_field('default_address_id', $sInfo->customers_default_address_id);
    if (isset($_GET['sID']) && empty($_POST)) {
      $store_query = smn_db_query("select a.admin_groups_id, a.admin_password as password, a.admin_email_address as customers_email_address, sd.store_name as store_name, s.store_image, s.store_status, s.store_type, sd.store_description from " . TABLE_STORE_MAIN . " s, " . TABLE_STORE_DESCRIPTION . " sd, " . TABLE_ADMIN ." a where s.store_id = '" . (int)$sID . "' AND s.store_id = sd.store_id AND s.store_id = a.store_id and sd.language_id = '" . (int)$languages_id . "'");
      $store_info = smn_db_fetch_array($store_query);
      $store_owner_info_array_query = smn_db_query("select c.*, ab.* from " . TABLE_CUSTOMERS . " c, " . TABLE_ADDRESS_BOOK . " ab WHERE c.customers_email_address = '". $store_info['customers_email_address'] ."' and c.customers_id = ab.customers_id and c.customers_default_address_id = ab.address_book_id");
      $store_owner_info_array = smn_db_fetch_array($store_owner_info_array_query);
      $store_arr = array_merge($store_info, $store_owner_info_array);  
      $sInfo = new objectInfo($store_arr);
      echo smn_draw_hidden_field('customers_id', $sInfo->customers_id);
    } elseif (smn_not_null($_POST)) {
      $sInfo->objectInfo($_POST);
      $new_store_name = $_POST['store_name'];
      $store_description = $_POST['store_description'];
      echo smn_draw_hidden_field('customers_id', $sInfo->customers_id);
    }
    $languages = smn_get_languages();
    if (!isset($sInfo->store_status)) $sInfo->store_status = '1';
    switch ($sInfo->store_status) {
      case '0': $in_status = false; $out_status = true; break;
      case '1':
      default: $in_status = true; $out_status = false;
    }
    
  $store_selection_out_string .= '<td class="smallText">' . BASIC_STORE_PACKAGE_TEXT . '<br><br>';
  $store_selection_out_string .=  smn_draw_separator('pixel_trans.gif', '10', '10'); 
  $db_groups_query = smn_db_query("select ag.admin_groups_id, 
                                          ag.admin_groups_name, 
										  ag.admin_groups_max_products, 
										  ag.admin_groups_store_type, 
										  p.products_price 
									from " . TABLE_ADMIN_GROUPS . " ag,  " . TABLE_PRODUCTS . " p 
									where ag.admin_groups_products_id = p.products_id 
									order by ag.admin_groups_id");
    while ($groups = smn_db_fetch_array($db_groups_query)){
      if ((int)$sInfo->store_type == (int)$groups['admin_groups_id']) {
          $store_selection_out_string .= smn_draw_radio_field('store_type', $groups['admin_groups_id'], true) . '&nbsp;' .  '<span class="inputRequirement"><b>' . $groups['admin_groups_name'] . '</b> ' . REGULAR_STORE_MAX_PRODUCTS . ' ' . $groups['admin_groups_max_products'] . ' ' . REGULAR_STORE_COST . ': <b>$' . round($groups['products_price'],2) . '</b></span><br>';
          $store_selection_out_string .=  smn_draw_separator('pixel_trans.gif', '10', '5');
      } elseif ($groups['admin_groups_id'] != '1'){
          $store_selection_out_string .= smn_draw_radio_field('store_type', $groups['admin_groups_id'], false) . '&nbsp;' .  '<span class="inputRequirement"><b>' . $groups['admin_groups_name'] . '</b> ' . REGULAR_STORE_MAX_PRODUCTS . ' ' . $groups['admin_groups_max_products'] . ' ' . REGULAR_STORE_COST . ': <b>$' . round($groups['products_price'],2) . '</b></span><br>';
          $store_selection_out_string .=  smn_draw_separator('pixel_trans.gif', '10', '5');
      }
    }
    $store_selection_out_string .=  smn_draw_separator('pixel_trans.gif', '10', '10');
    $store_selection_out_string .= '</td>';
    
    $today = getdate();
    for ($i=1; $i<= 31; $i++){
      $day_drop_down_array[] = array('id' =>  sprintf('%02d', $i), 'text' => $i);
    }
    for ($i=1; $i<= 12; $i++){
      $month_drop_down_array[] = array('id' => sprintf('%02d', $i), 'text' => strftime('%B',mktime(0,0,0,$i,1,$today['year'])));
    }
    for ($i=1935; $i<= (int)$today['year']; $i++){
      $year_drop_down_array[] = array('id' => $i, 'text' => $i);
    }
  
    
?>
    <table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo sprintf(TEXT_NEW_STORE, smn_output_generated_store_category_path($current_store_category_id)); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="pageHeading_orig"><?php echo $sInfo->store_name ?></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <?php if((int)$_GET['sID'] != 1) echo $store_selection_out_string; ?>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main"><?php echo TEXT_STORES_STATUS; ?></td>
            <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_radio_field('store_status', '1', $in_status) . '&nbsp;' . TEXT_STORE_AVAILABLE . '&nbsp;' . smn_draw_radio_field('store_status', '0', $out_status) . '&nbsp;' . TEXT_STORE_NOT_AVAILABLE; ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_STORES_NAME; ?></td>
            <td class="main">
<?php
  if ($error == true) {
    if ($entry_storename_error == true) {
      echo smn_draw_input_field('new_store_name', $sInfo->store_name, 'maxlength="32"') . '&nbsp;' . ENTRY_STORE_NAME_ERROR;
    } else {
      echo $sInfo->store_name . smn_draw_hidden_field('new_store_name');
    }
  } else {
    echo smn_draw_input_field('new_store_name', $sInfo->store_name, 'maxlength="32"', true);
  }
?></td>
          </tr>
          <tr>
            <td class="main" valign="top"><?php echo TEXT_STORE_DESCRIPTION; ?></td>
            <td><table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="main">
<?php
                echo smn_draw_textarea_field('store_description', 'soft', '70', '15', $sInfo->store_description);
                $java_editor = 'store_description';
?>
                </td>
                <br>
              </tr>
            </table></td>
          </tr>
<?php
    $newsletter_array = array(array('id' => '1', 'text' => ENTRY_NEWSLETTER_YES),
                              array('id' => '0', 'text' => ENTRY_NEWSLETTER_NO));
?>
       <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '20'); ?></td>
      </tr>
      <tr>
      <td class="main" valign="top"></td>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
<?php
    if ((ACCOUNT_GENDER == 'true') && ($set_action == 'process')) {
?>
          <tr>
            <td class="main"><?php echo ENTRY_GENDER; ?></td>
            <td class="main">
<?php
    if ($error == true) {
      if ($entry_gender_error == true) {
        echo smn_draw_radio_field('customers_gender', 'm', false, $sInfo->customers_gender) . '&nbsp;&nbsp;' . MALE . '&nbsp;&nbsp;' . smn_draw_radio_field('customers_gender', 'f', false, $sInfo->customers_gender) . '&nbsp;&nbsp;' . FEMALE . '&nbsp;' . ENTRY_GENDER_ERROR;
      } else {
        echo ($sInfo->customers_gender == 'm') ? MALE : FEMALE;
        echo smn_draw_hidden_field('customers_gender');
      }
    } else {
      echo smn_draw_radio_field('customers_gender', 'm', false, $sInfo->customers_gender) . '&nbsp;&nbsp;' . MALE . '&nbsp;&nbsp;' . smn_draw_radio_field('customers_gender', 'f', false, $sInfo->customers_gender) . '&nbsp;&nbsp;' . FEMALE;
    }
?>
            </td>
          </tr>
<?php
    }
?>
          <tr>
            <td class="main"><?php echo ENTRY_FIRST_NAME; ?></td>
            <td class="main">
<?php
  if ($error == true) {
    if ($entry_firstname_error == true) {
      echo smn_draw_input_field('customers_firstname', $sInfo->customers_firstname, 'maxlength="32"') . '&nbsp;' . ENTRY_FIRST_NAME_ERROR;
    } else {
      echo $sInfo->customers_firstname . smn_draw_hidden_field('customers_firstname');
    }
  } else {
    echo smn_draw_input_field('customers_firstname', $sInfo->customers_firstname, 'maxlength="32"', true);
  }
?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_LAST_NAME; ?></td>
            <td class="main">
<?php
  if ($error == true) {
    if ($entry_lastname_error == true) {
      echo smn_draw_input_field('customers_lastname', $sInfo->customers_lastname, 'maxlength="32"') . '&nbsp;' . ENTRY_LAST_NAME_ERROR;
    } else {
      echo $sInfo->customers_lastname . smn_draw_hidden_field('customers_lastname');
    }
  } else {
    echo smn_draw_input_field('customers_lastname', $sInfo->customers_lastname, 'maxlength="32"', true);
  }
?></td>
          </tr>
<?php
/*
    if (ACCOUNT_DOB == 'true') {
      $dob =  explode('-', $sInfo->customers_dob);
      $dob_day = $dob[0];
      $dob_month = $dob[1];
      $dob_year = $dob[2];
?>
          <tr>
            <td class="main"><?php echo ENTRY_DATE_OF_BIRTH; ?></td>
            <td class="main">
<?php
    if ($error == true) {
      if ($entry_date_of_birth_error == true) {
        echo smn_draw_pull_down_menu('dob_day', $day_drop_down_array, $dob_day) . smn_draw_pull_down_menu('dob_month', $month_drop_down_array, $dob_month) . smn_draw_pull_down_menu('dob_year', $year_drop_down_array, $dob_year) . '&nbsp;' . ENTRY_DATE_OF_BIRTH_ERROR;
      } else {
        echo $sInfo->customers_dob . smn_draw_hidden_field('customers_dob');
      }
    } else {
      echo smn_draw_pull_down_menu('dob_day', $day_drop_down_array, $dob_day) . smn_draw_pull_down_menu('dob_month', $month_drop_down_array, $dob_month) . smn_draw_pull_down_menu('dob_year', $year_drop_down_array, $dob_year);
    }
?></td>
          </tr>
<?php
    }
*/	
?>
          <tr>
            <td class="main"><?php echo ENTRY_EMAIL_ADDRESS; ?></td>
            <td class="main">
<?php
  if ($error == true) {
    if ($entry_email_address_error == true) {
      echo smn_draw_input_field('customers_email_address', $sInfo->customers_email_address, 'maxlength="96"') . '&nbsp;' . ENTRY_EMAIL_ADDRESS_ERROR;
    } elseif ($entry_email_address_check_error == true) {
      echo smn_draw_input_field('customers_email_address', $sInfo->customers_email_address, 'maxlength="96"') . '&nbsp;' . ENTRY_EMAIL_ADDRESS_CHECK_ERROR;
    } elseif ($entry_email_address_exists == true) {
      echo smn_draw_input_field('customers_email_address', $sInfo->customers_email_address, 'maxlength="96"') . '&nbsp;' . ENTRY_EMAIL_ADDRESS_ERROR_EXISTS;
    } else {
      echo $customers_email_address . smn_draw_hidden_field('customers_email_address');
    }
  } else {
    echo smn_draw_input_field('customers_email_address', $sInfo->customers_email_address, 'maxlength="96"', true);
  }
?></td>
          </tr>
        </table></td>
      </tr>
<?php
    if (ACCOUNT_COMPANY == 'true') {
?>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
      <td class="main" valign="top"></td>
        <td class="formAreaTitle"><?php echo CATEGORY_COMPANY; ?></td>
      </tr>
      <tr>
      <td class="main" valign="top"></td>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td class="main"><?php echo ENTRY_COMPANY; ?></td>
            <td class="main">
<?php
    if ($error == true) {
      if ($entry_company_error == true) {
        echo smn_draw_input_field('entry_company', $sInfo->entry_company, 'maxlength="32"') . '&nbsp;' . ENTRY_COMPANY_ERROR;
      } else {
        echo $sInfo->entry_company . smn_draw_hidden_field('entry_company');
      }
    } else {
      echo smn_draw_input_field('entry_company', $sInfo->entry_company, 'maxlength="32"');
    }
?></td>
          </tr>
        </table></td>
      </tr>
<?php
    }
?>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
      <td class="main" valign="top"></td>
        <td class="formAreaTitle"><?php echo CATEGORY_ADDRESS; ?></td>
      </tr>
      <tr>
      <td class="main" valign="top"></td>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td class="main"><?php echo ENTRY_STREET_ADDRESS; ?></td>
            <td class="main">
<?php
  if ($error == true) {
    if ($entry_street_address_error == true) {
      echo smn_draw_input_field('entry_street_address', $sInfo->entry_street_address, 'maxlength="64"') . '&nbsp;' . ENTRY_STREET_ADDRESS_ERROR;
    } else {
      echo $sInfo->entry_street_address . smn_draw_hidden_field('entry_street_address');
    }
  } else {
    echo smn_draw_input_field('entry_street_address', $sInfo->entry_street_address, 'maxlength="64"', true);
  }
?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_POST_CODE; ?></td>
            <td class="main">
<?php
  if ($error == true) {
    if ($entry_post_code_error == true) {
      echo smn_draw_input_field('entry_postcode', $sInfo->entry_postcode, 'maxlength="8"') . '&nbsp;' . ENTRY_POST_CODE_ERROR;
    } else {
      echo $sInfo->entry_postcode . smn_draw_hidden_field('entry_postcode');
    }
  } else {
    echo smn_draw_input_field('entry_postcode', $sInfo->entry_postcode, 'maxlength="8"', true);
  }
?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_CITY; ?></td>
            <td class="main">
<?php
  if ($error == true) {
    if ($entry_city_error == true) {
      echo smn_draw_input_field('entry_city', $sInfo->entry_city, 'maxlength="32"') . '&nbsp;' . ENTRY_CITY_ERROR;
    } else {
      echo $sInfo->entry_city . smn_draw_hidden_field('entry_city');
    }
  } else {
    echo smn_draw_input_field('entry_city', $sInfo->entry_city, 'maxlength="32"', true);
  }
?></td>
          </tr>
<?php
    if (ACCOUNT_STATE == 'true') {
?>
          <tr>
            <td class="main"><?php echo ENTRY_STATE; ?></td>
            <td class="main">
<?php
    $entry_state = smn_get_zone_name($sInfo->entry_country_id, $sInfo->entry_zone_id, $sInfo->entry_state);
    if ($error == true) {
      if ($entry_state_error == true) {
        if ($entry_state_has_zones == true) {
          $zones_array = array();
          $zones_query = smn_db_query("select zone_name from " . TABLE_ZONES . " where zone_country_id = '" . smn_db_input($sInfo->entry_country_id) . "' order by zone_name");
          while ($zones_values = smn_db_fetch_array($zones_query)) {
            $zones_array[] = array('id' => $zones_values['zone_name'], 'text' => $zones_values['zone_name']);
          }
          echo smn_draw_pull_down_menu('entry_state', $zones_array) . '&nbsp;' . ENTRY_STATE_ERROR;
        } else {
          echo smn_draw_input_field('entry_state', smn_get_zone_name($sInfo->entry_country_id, $sInfo->entry_zone_id, $sInfo->entry_state)) . '&nbsp;' . ENTRY_STATE_ERROR;
        }
      } else {
        echo $entry_state . smn_draw_hidden_field('entry_zone_id') . smn_draw_hidden_field('entry_state');
      }
    } else {
      echo smn_draw_input_field('entry_state', smn_get_zone_name($sInfo->entry_country_id, $sInfo->entry_zone_id, $sInfo->entry_state));
    }
?></td>
         </tr>
<?php
    }
?>
          <tr>
            <td class="main"><?php echo ENTRY_COUNTRY; ?></td>
            <td class="main">
<?php
  if ($error == true) {
    if ($entry_country_error == true) {
      echo smn_draw_pull_down_menu('entry_country_id', smn_get_countries(), $sInfo->entry_country_id) . '&nbsp;' . ENTRY_COUNTRY_ERROR;
    } else {
      echo smn_get_country_name($sInfo->entry_country_id) . smn_draw_hidden_field('entry_country_id');
    }
  } else {
    echo smn_draw_pull_down_menu('entry_country_id', smn_get_countries(), $sInfo->entry_country_id);
  }
?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
      <td class="main" valign="top"></td>
        <td class="formAreaTitle"><?php echo CATEGORY_CONTACT; ?></td>
      </tr>
      <tr>
      <td class="main" valign="top"></td>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td class="main"><?php echo ENTRY_TELEPHONE_NUMBER; ?></td>
            <td class="main">
<?php
  if ($error == true) {
    if ($entry_telephone_error == true) {
      echo smn_draw_input_field('customers_telephone', $sInfo->customers_telephone, 'maxlength="32"') . '&nbsp;' . ENTRY_TELEPHONE_NUMBER_ERROR;
    } else {
      echo $sInfo->customers_telephone . smn_draw_hidden_field('customers_telephone');
    }
  } else {
    echo smn_draw_input_field('customers_telephone', $sInfo->customers_telephone, 'maxlength="32"', true);
  }
?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_FAX_NUMBER; ?></td>
            <td class="main">
<?php
  if ($processed == true) {
    echo $sInfo->customers_fax . smn_draw_hidden_field('customers_fax');
  } else {
    echo smn_draw_input_field('customers_fax', $sInfo->customers_fax, 'maxlength="32"');
  }
?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
      <td class="main" valign="top"></td>
        <td class="formAreaTitle"><?php echo CATEGORY_OPTIONS; ?></td>
      </tr>
      <tr>
      <td class="main" valign="top"></td>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td class="main"><?php echo ENTRY_NEWSLETTER; ?></td>
            <td class="main">
<?php
  if ($processed == true) {
    if ($sInfo->customers_newsletter == '1') {
      echo ENTRY_NEWSLETTER_YES;
    } else {
      echo ENTRY_NEWSLETTER_NO;
    }
    echo smn_draw_hidden_field('customers_newsletter');
  } else {
    echo smn_draw_pull_down_menu('customers_newsletter', $newsletter_array, (($sInfo->customers_newsletter == '1') ? '1' : '0'));
  }
?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      
       <tr>
      <td class="main" valign="top"></td>
        <td class="formAreaTitle"><?php echo CATEGORY_PASSWORD; ?></td>
      </tr>
      <tr>
      <td class="main" valign="top"></td>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td class="main"><?php echo ENTRY_PASSWORD; ?></td>
             <td class="main"><?php echo smn_draw_password_field('password') . '&nbsp;' . (smn_not_null(ENTRY_PASSWORD_TEXT) ? '<span class="inputRequirement">' . ENTRY_PASSWORD_TEXT . '</span>': ''); ?></td>
          </tr>
              <tr>
                <td class="main"><?php echo ENTRY_PASSWORD_CONFIRMATION; ?></td>
                <td class="main"><?php echo smn_draw_password_field('confirmation') . '&nbsp;' . (smn_not_null(ENTRY_PASSWORD_CONFIRMATION_TEXT) ? '<span class="inputRequirement">' . ENTRY_PASSWORD_CONFIRMATION_TEXT . '</span>': ''); ?></td>
          </tr>
        </table></td> </tr>    
          <tr>
            <td colspan="2"><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
<?php 
  if($set_action == 'process'){
?>          
          <tr>
            <td class="main"><?php echo TEXT_STORES_IMAGE; ?></td>
            <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_file_field('store_image') . '<br>' . smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . $pInfo->store_image . smn_draw_hidden_field('store_previous_image', $pInfo->store_image); ?></td>
          </tr>
<?php 
}
?>  
          <tr>
            <td colspan="2"><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td class="main" align="right"><?php echo smn_draw_hidden_field('date_added', (smn_not_null($pInfo->date_added) ? $pInfo->date_added : date('Y-m-d'))) . smn_image_submit('button_insert.gif', IMAGE_INSERT) . '&nbsp;&nbsp;<a href="' . smn_href_link(FILENAME_MANAGEMENT, (isset($_GET['sID']) ? '&sID=' . $_GET['sID'] : '')) . '">' . smn_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>'; ?></td>
      </tr>
    </table></form>
<?php
  } elseif ($action == 'new_store_preview') {
    if (smn_not_null($_POST)) {
      $pInfo = new objectInfo($_POST);
      $new_store_name = $_POST['store_name'];
      $store_description = $_POST['store_description'];
      $store_url = $_POST['store_url'];
    } else {
      $store_query = smn_db_query("select s.store_id, s.customer_id, sd.store_name, sd.store_description, s.store_image, s.date_added, s.store_status, s.store_type  from " . TABLE_STORE_MAIN . " s, " . TABLE_STORE_DESCRIPTION . " sd where s.store_id = sd.store_id and s.store_id = '" . (int)$_GET['sID'] . "' and sd.language_id = '" . (int)$languages_id . "'");
      $store_arr = smn_db_fetch_array($store_query);
      $pInfo = new objectInfo($store);
      $store_image_name = $pInfo->store_image;
    }
    $form_action = (isset($_GET['sID'])) ? 'update_store' : 'insert_store';
    $languages = smn_get_languages();
    for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
      if (isset($_GET['read']) && ($_GET['read'] == 'only')) {
        $pInfo->store_name = smn_get_store_name($pInfo->store_id, $languages[$i]['id']);
        $pInfo->store_description = smn_get_store_description($pInfo->store_id, $languages[$i]['id']);
      } else {
        $pInfo->store_name = smn_db_prepare_input($new_store_name[$languages[$i]['id']]);
        $pInfo->store_description = smn_db_prepare_input($store_description[$languages[$i]['id']]);
      }
?>
    <table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading_orig"><?php echo smn_image(DIR_WS_CATALOG_LANGUAGES . 'images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . $pInfo->store_name; ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><?php echo smn_image(DIR_WS_CATALOG_IMAGES . $store_image_name, $pInfo->store_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'align="right" hspace="5" vspace="5"') . $pInfo->store_description; ?></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
<?php
      if ($pInfo->store_date_available > date('Y-m-d')) {
?>
      <tr>
        <td align="center" class="smallText"><?php echo sprintf(TEXT_STORE_DATE_AVAILABLE, smn_date_long($pInfo->store_date_available)); ?></td>
      </tr>
<?php
      } else {
?>
      <tr>
        <td align="center" class="smallText"><?php echo sprintf(TEXT_date_added, smn_date_long($pInfo->date_added)); ?></td>
      </tr>
<?php
      }
?>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
<?php
    }
    if (isset($_GET['read']) && ($_GET['read'] == 'only')) {
      if (isset($_GET['origin'])) {
        $pos_params = strpos($_GET['origin'], '?', 0);
        if ($pos_params != false) {
          $back_url = substr($_GET['origin'], 0, $pos_params);
          $back_url_params = substr($_GET['origin'], $pos_params + 1);
        } else {
          $back_url = $_GET['origin'];
          $back_url_params = '';
        }
      } else {
        $back_url = FILENAME_MANAGEMENT;
        $back_url_params = 'sPath=' . $sPath . '&sID=' . $pInfo->store_id;
      }
?>
      <tr>
        <td align="right"><?php echo '<a href="' . smn_href_link($back_url, $back_url_params, 'NONSSL') . '">' . smn_image_button('button_back.gif', IMAGE_BACK) . '</a>'; ?></td>
      </tr>
<?php
    } else {
?>
      <tr>
        <td align="right" class="smallText">
<?php
/* Re-Post all POST'ed variables */
      reset($_POST);
      while (list($key, $value) = each($_POST)) {
        if (!is_array($_POST[$key])) {
          echo smn_draw_hidden_field($key, htmlspecialchars(stripslashes($value)));
        }
      }
      $languages = smn_get_languages();
      for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
        echo smn_draw_hidden_field('store_name[' . $languages[$i]['id'] . ']', htmlspecialchars(stripslashes($new_store_name[$languages[$i]['id']])));
        echo smn_draw_hidden_field('store_description[' . $languages[$i]['id'] . ']', htmlspecialchars(stripslashes($store_description[$languages[$i]['id']])));
      }
      echo smn_draw_hidden_field('store_image', stripslashes($store_image_name));
      echo smn_image_submit('button_back.gif', IMAGE_BACK, 'name="edit"') . '&nbsp;&nbsp;';
      if (isset($_GET['sID'])) {
        echo smn_image_submit('button_update.gif', IMAGE_UPDATE);
      } else {
        echo smn_image_submit('button_insert.gif', IMAGE_INSERT);
      }
      echo '&nbsp;&nbsp;<a href="' . smn_href_link(FILENAME_MANAGEMENT, 'sPath=' . $sPath . (isset($_GET['sID']) ? '&sID=' . $_GET['sID'] : '')) . '">' . smn_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>';
?></td>
      </tr>
    </table></form>
<?php
    }
  } else {
?>
    <table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
          </tr>
        </table></td>
      </tr>
          <tr>
            <td align="right"><table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td class="smallText" align="right">
<?php
    echo smn_draw_form('search', FILENAME_MANAGEMENT, '', 'get');
    echo HEADING_TITLE_SEARCH . ' ' . smn_draw_input_field('search');
    echo '</form>';
?>
                </td>
              </tr>
              <tr>
                <td class="smallText" align="right">
<?php
    echo smn_draw_form('goto', FILENAME_MANAGEMENT, '', 'get');
    echo HEADING_TITLE_GOTO . ' ' . smn_draw_pull_down_menu('sPath', $store->smn_get_store_category_tree(), $current_store_category_id, 'onChange="this.form.submit();"');
    echo '</form>';
?>
                </td>
              </tr>
            </table></td>
          </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_CATEGORIES_STORES; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
    $store_categories_count = 0;
    $rows = 0;
    if (isset($_GET['search'])) {
      $search = smn_db_prepare_input($_GET['search']);
      $store_categories_query = smn_db_query("select c.store_categories_id, cd.store_categories_description, cd.store_categories_name, c.store_categories_image, c.store_parent_id, c.sort_order, c.date_added, c.last_modified from " . TABLE_STORE_CATEGORIES . " c, " . TABLE_STORE_CATEGORIES_DESCRIPTION . " cd where c.store_categories_id = cd.store_categories_id and cd.language_id = '" . (int)$languages_id . "' and cd.store_categories_name like '%" . smn_db_input($search) . "%' order by c.sort_order, cd.store_categories_name");
    } else {
      $store_categories_query = smn_db_query("select c.store_categories_id, cd.store_categories_description, cd.store_categories_name, c.store_categories_image, c.store_parent_id, c.sort_order, c.date_added, c.last_modified from " . TABLE_STORE_CATEGORIES . " c, " . TABLE_STORE_CATEGORIES_DESCRIPTION . " cd where c.store_parent_id = '" . (int)$current_store_category_id . "' and c.store_categories_id = cd.store_categories_id and cd.language_id = '" . (int)$languages_id . "' order by c.sort_order, cd.store_categories_name");
    }
    while ($store_categories = smn_db_fetch_array($store_categories_query)) {
      $store_categories_count++;
      $rows++;
// Get store_parent_id for subcategories if search
      if (isset($_GET['search'])) $sPath= $store_categories['store_parent_id'];
      if ((!isset($_GET['cID']) && !isset($_GET['sID']) || (isset($_GET['cID']) && ($_GET['cID'] == $store_categories['store_categories_id']))) && !isset($cInfo) && (substr($action, 0, 3) != 'new')) {
        $store_category_childs = array('childs_count' => $store->smn_childs_in_store_category_count($store_categories['store_categories_id']));
        $store_category = array('store_count' => $store->smn_store_in_category_count($store_categories['store_categories_id']));
        $cInfo_array = array_merge($store_categories, $store_category_childs, $store_category);
        $cInfo = new objectInfo($cInfo_array);
      }
      if (isset($cInfo) && is_object($cInfo) && ($store_categories['store_categories_id'] == $cInfo->store_categories_id) ) {
        echo '              <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . smn_href_link(FILENAME_MANAGEMENT, $store->smn_get_spath($store_categories['store_categories_id'])) . '\'">' . "\n";
      } else {
        echo '              <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . smn_href_link(FILENAME_MANAGEMENT, 'sPath=' . $sPath . '&cID=' . $store_categories['store_categories_id']) . '\'">' . "\n";
      }
?>
                <td class="dataTableContent"><?php echo '<a href="' . smn_href_link(FILENAME_MANAGEMENT, $store->smn_get_spath($store_categories['store_categories_id'])) . '">' . smn_image(DIR_WS_ICONS . 'folder.gif', ICON_FOLDER) . '</a>&nbsp;<b>' . $store_categories['store_categories_name'] . '</b>'; ?></td>
                <td class="dataTableContent" align="center">&nbsp;</td>
                <td class="dataTableContent" align="right"><?php if (isset($cInfo) && is_object($cInfo) && ($store_categories['store_categories_id'] == $cInfo->store_categories_id) ) { echo smn_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . smn_href_link(FILENAME_MANAGEMENT, 'sPath=' . $sPath . '&cID=' . $store_categories['store_categories_id']) . '">' . smn_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    }
    $store_count = 0;
    if (isset($_GET['search'])) {
      $store_query = smn_db_query("select sd.store_id, sd.store_name, s.store_image, s.date_added, s.store_status, s2c.store_categories_id from " . TABLE_STORE_MAIN . " s, " . TABLE_STORE_DESCRIPTION . " sd, " . TABLE_STORE_TO_CATEGORIES . " s2c where s.store_id = sd.store_id and sd.language_id = '" . (int)$languages_id . "' and s.store_id = s2c.store_id and sd.store_name like '%" . smn_db_input($search) . "%' order by sd.store_name");
    } else {
     $store_query = smn_db_query("select sd.store_id, sd.store_name, s.store_image, s.date_added, s.store_status from " . TABLE_STORE_MAIN . " s, " . TABLE_STORE_DESCRIPTION . " sd, " . TABLE_STORE_TO_CATEGORIES . " s2c where s.store_id = sd.store_id and sd.language_id = '" . (int)$languages_id . "' and s.store_id = s2c.store_id and s2c.store_categories_id = '" . (int)$current_store_category_id . "' order by sd.store_name");
    }
    while ($store_arr = smn_db_fetch_array($store_query)) {
      $store_count++;
      $rows++;
// Get categories_id for store if search
      if (isset($_GET['search'])) $sPath = $store_arr['store_categories_id'];
      if ( (!isset($_GET['sID']) || (isset($_GET['sID']) && ($_GET['sID'] == $store_arr['store_id']))) && !isset($pInfo) && !isset($cInfo) && (substr($action, 0, 3) != 'new')) {
// find out the rating average from customer reviews
        $reviews_query = smn_db_query("select (avg(reviews_rating) / 5 * 100) as average_rating from " . TABLE_STORE_REVIEWS . " where store_id = '" . (int)$store_arr['store_id'] . "'");
        $reviews = smn_db_fetch_array($reviews_query);
        $pInfo_array = array_merge($store_arr, $reviews);
        $pInfo = new objectInfo($pInfo_array);
       }
      if (isset($pInfo) && is_object($pInfo) && ($store_arr['store_id'] == $pInfo->store_id) ) {
        echo '              <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . smn_href_link(FILENAME_MANAGEMENT, 'sPath=' . $sPath . '&sID=' . $store_arr['store_id'] . '&action=new_store_preview&read=only') . '\'">' . "\n";
      } else {
        echo '              <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . smn_href_link(FILENAME_MANAGEMENT, 'sPath=' . $sPath . '&sID=' . $store_arr['store_id']) . '\'">' . "\n";
      }
?>
                <td class="dataTableContent"><?php echo '<a href="' . smn_href_link(FILENAME_MANAGEMENT, 'sPath=' . $sPath . '&sID=' . $store_arr['store_id'] . '&action=new_store_preview&read=only') . '">' . smn_image(DIR_WS_ICONS . 'preview.gif', ICON_PREVIEW) . '</a>&nbsp;' . $store_arr['store_name']; ?></td>
                <td class="dataTableContent" align="center">
<?php
      if ($store_arr['store_status'] == '1') {
        echo smn_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . smn_href_link(FILENAME_MANAGEMENT, 'action=setflag&flag=0&sID=' . $store_arr['store_id'] . '&sPath=' . $sPath) . '">' . smn_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
      } else {
        echo '<a href="' . smn_href_link(FILENAME_MANAGEMENT, 'action=setflag&flag=1&sID=' . $store_arr['store_id'] . '&sPath=' . $sPath) . '">' . smn_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . smn_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
      }
?></td>
                <td class="dataTableContent" align="right"><?php if (isset($pInfo) && is_object($pInfo) && ($store_arr['store_id'] == $pInfo->store_id)) { echo smn_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . smn_href_link(FILENAME_MANAGEMENT, 'sPath=' . $sPath . '&sID=' . $store_arr['store_id']) . '">' . smn_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    }
    $sPath_back = '';
    if (sizeof($sPath_array) > 0) {
      for ($i=0, $n=sizeof($sPath_array)-1; $i<$n; $i++) {
        if (empty($sPath_back)) {
          $sPath_back .= $sPath_array[$i];
        } else {
          $sPath_back .= '_' . $sPath_array[$i];
        }
      }
    }
    $sPath_back = (smn_not_null($sPath_back)) ? 'sPath=' . $sPath_back . '&' : '';
?>
              <tr>
                <td colspan="3"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText"><?php echo TEXT_CATEGORIES . '&nbsp;' . $store_categories_count . '<br>' . TEXT_STORES . '&nbsp;' . $store_count; ?></td>
                    <td align="right" class="smallText">
                    
                    <?php if (sizeof($sPath_array) > 0)
                      echo '<a href="' . smn_href_link(FILENAME_MANAGEMENT, $sPath_back . 'cID=' . $current_store_category_id) . '">' . smn_image_button('button_back.gif', IMAGE_BACK) . '</a>&nbsp;'; if (!isset($_GET['search'])) echo '<a href="' . smn_href_link(FILENAME_MANAGEMENT, 'sPath=' . $sPath . '&action=new_store_category') . '">' . smn_image_button('button_new_category.gif', IMAGE_NEW_CATEGORY) . '</a>';
                    
                    if ($sPath > 0 )
                      echo '&nbsp;<a href="' . smn_href_link(FILENAME_MANAGEMENT, 'sPath=' . $sPath . '&action=new_store') . '">' . smn_image_button('button_new_store.gif', IMAGE_NEW_) . '</a>'; ?>&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
<?php
    $heading = array();
    $contents = array();
    switch ($action) {
      case 'new_store_category':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_NEW_CATEGORY . '</b>');
        $contents = array('form' => smn_draw_form('newstore_category', FILENAME_MANAGEMENT, 'action=insert_store_category&sPath=' . $sPath, 'post', 'enctype="multipart/form-data"'));
        $contents[] = array('text' => TEXT_NEW_CATEGORY_INTRO);
        $store_category_inputs_string = '';
        $languages = smn_get_languages();
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
          $store_category_inputs_string .= '<br>' . smn_image(DIR_WS_CATALOG_LANGUAGES . 'images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . smn_draw_input_field('store_categories_name[' . $languages[$i]['id'] . ']');
		  $store_category_description_input_string .= '<br>' . smn_image(DIR_WS_CATALOG_LANGUAGES .  'images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;<br><textarea name="store_categories_description[' . $languages[$i]['id'] . ']" wrap="physical" cols="28" rows="5" onKeyDown="textCounter(this,document.newstore_category.remLen1,125)" onKeyUp="textCounter(this,document.newstore_category.remLen1,125)"></textarea>' .
				      '<br><input readonly type="text" name="remLen1" size="3" maxlength="3" value="125">characters left<br>';
        }
        $contents[] = array('text' => '<br>' . TEXT_CATEGORIES_NAME . $store_category_inputs_string);
        $contents[] = array('text' => '<br>' . TEXT_CATEGORIES_DESCRIPTION . $store_category_description_input_string);
        $contents[] = array('text' => '<br>' . TEXT_CATEGORIES_IMAGE . '<br>' . smn_draw_file_field('store_categories_image'));
        $contents[] = array('text' => '<br>' . TEXT_SORT_ORDER . '<br>' . smn_draw_input_field('sort_order', '', 'size="2"'));
        $contents[] = array('align' => 'center', 'text' => '<br>' . smn_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . smn_href_link(FILENAME_MANAGEMENT, 'sPath=' . $sPath) . '">' . smn_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
        break;
      case 'edit_store_category':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_CATEGORY . '</b>');
        $contents = array('form' => smn_draw_form('store_categories', FILENAME_MANAGEMENT, 'action=update_store_category&sPath=' . $sPath, 'post', 'enctype="multipart/form-data"') . smn_draw_hidden_field('store_categories_id', $cInfo->store_categories_id));
        $contents[] = array('text' => TEXT_EDIT_INTRO);
        $store_category_inputs_string = '';
        $languages = smn_get_languages();
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
		  $category_description_input_string .= '<br>' . smn_image(DIR_WS_CATALOG_LANGUAGES .  'images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;<br><textarea name="store_categories_description[' . $languages[$i]['id'] . ']" wrap="physical" cols="28" rows="5" onKeyDown="textCounter(this,document.store_categories.remLen2,125)" onKeyUp="textCounter(this,document.store_categories.remLen2,125)" value="' . $cInfo->categories_id . '">' . 
		  	  $store->smn_get_store_category_description($cInfo->store_categories_id, $languages[$i]['id']) . '</textarea>' .
				      '<br><input readonly type="text" name="remLen2" size="3" maxlength="3" value="125">characters left<br>';

          $store_category_inputs_string .= '<br>' . smn_image(DIR_WS_CATALOG_LANGUAGES . 'images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . smn_draw_input_field('store_categories_name[' . $languages[$i]['id'] . ']', 
			  $store->smn_get_store_category_name(
			  										$cInfo->store_categories_id, 
													$languages[$i]['id']));
        }
        $contents[] = array('text' => '<br>' . TEXT_EDIT_CATEGORIES_NAME . $store_category_inputs_string);
        $contents[] = array('text' => '<br>' . TEXT_EDIT_CATEGORIES_DESCRIPTION . $category_description_input_string);
        $contents[] = array('text' => '<br>' . smn_image(DIR_WS_CATALOG_IMAGES . $cInfo->store_categories_image, $cInfo->store_categories_name) . '<br>' . DIR_WS_CATALOG_IMAGES . '<br><b>' . $cInfo->store_categories_image . '</b>');
        $contents[] = array('text' => '<br>' . TEXT_EDIT_CATEGORIES_IMAGE . '<br>' . smn_draw_file_field('store_categories_image'));
        $contents[] = array('text' => '<br>' . TEXT_EDIT_SORT_ORDER . '<br>' . smn_draw_input_field('sort_order', $cInfo->sort_order, 'size="2"'));
        $contents[] = array('align' => 'center', 'text' => '<br>' . smn_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . smn_href_link(FILENAME_MANAGEMENT, 'sPath=' . $sPath . '&cID=' . $cInfo->store_categories_id) . '">' . smn_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
        break;
      case 'delete_store_category':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_CATEGORY . '</b>');
        $contents = array('form' => smn_draw_form('store_categories', FILENAME_MANAGEMENT, 'action=delete_store_category_confirm&sPath=' . $sPath) . smn_draw_hidden_field('store_categories_id', $cInfo->store_categories_id));
        $contents[] = array('text' => TEXT_DELETE_CATEGORY_INTRO);
        $contents[] = array('text' => '<br><b>' . $cInfo->store_categories_name . '</b>');
        if ($cInfo->childs_count > 0) $contents[] = array('text' => '<br>' . sprintf(TEXT_DELETE_WARNING_CHILDS, $cInfo->childs_count));
        if ($cInfo->store_count > 0) $contents[] = array('text' => '<br>' . sprintf(TEXT_DELETE_WARNING_STORES, $cInfo->store_count));
        $contents[] = array('align' => 'center', 'text' => '<br>' . smn_image_submit('button_delete.gif', IMAGE_DELETE) . ' <a href="' . smn_href_link(FILENAME_MANAGEMENT, 'sPath=' . $sPath . '&cID=' . $cInfo->store_categories_id) . '">' . smn_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
        break;
      case 'move_store_category':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_MOVE_CATEGORY . '</b>');
        $contents = array('form' => smn_draw_form('store_categories', FILENAME_MANAGEMENT, 'action=move_store_category_confirm&sPath=' . $sPath) . smn_draw_hidden_field('store_categories_id', $cInfo->store_categories_id));
        $contents[] = array('text' => sprintf(TEXT_MOVE_CATEGORIES_INTRO, $cInfo->store_categories_name));
        $contents[] = array('text' => '<br>' . sprintf(TEXT_MOVE, $cInfo->store_categories_name) . '<br>' . smn_draw_pull_down_menu('move_to_store_category_id', $store->smn_get_store_category_tree(), $current_store_category_id));
        $contents[] = array('align' => 'center', 'text' => '<br>' . smn_image_submit('button_move.gif', IMAGE_MOVE) . ' <a href="' . smn_href_link(FILENAME_MANAGEMENT, 'sPath=' . $sPath . '&cID=' . $cInfo->store_categories_id) . '">' . smn_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
        break;
      case 'delete_store':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_STORE . '</b>');
        $contents = array('form' => smn_draw_form('store', FILENAME_MANAGEMENT, 'action=delete_store_confirm&sPath=' . $sPath) . smn_draw_hidden_field('list_store_id', $pInfo->store_id));
        $contents[] = array('text' => TEXT_DELETE_STORE_INTRO);
        $contents[] = array('text' => '<br><b>' . $pInfo->store_name . '</b>');
        $store_categories_string = '';
        $store_categories = smn_generate_store_category_path($pInfo->store_id, 'store');
        for ($i = 0, $n = sizeof($store_categories); $i < $n; $i++) {
          $store_category_path = '';
          for ($j = 0, $k = sizeof($store_categories[$i]); $j < $k; $j++) {
            $store_category_path .= $store_categories[$i][$j]['text'] . '&nbsp;&gt;&nbsp;';
          }
          $store_category_path = substr($store_category_path, 0, -16);
          $store_categories_string .= smn_draw_checkbox_field('store_categories[]', $store_categories[$i][sizeof($store_categories[$i])-1]['id'], true) . '&nbsp;' . $store_category_path . '<br>';
        }
        $store_categories_string = substr($store_categories_string, 0, -4);
        $contents[] = array('text' => '<br>' . $store_categories_string);
        $contents[] = array('align' => 'center', 'text' => '<br>' . smn_image_submit('button_delete.gif', IMAGE_DELETE) . ' <a href="' . smn_href_link(FILENAME_MANAGEMENT, 'sPath=' . $sPath . '&sID=' . $pInfo->store_id) . '">' . smn_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
        break;
      case 'move_store':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_MOVE_STORE . '</b>');
        $contents = array('form' => smn_draw_form('store', FILENAME_MANAGEMENT, 'action=move_store_confirm&sPath=' . $sPath) . smn_draw_hidden_field('list_store_id', $pInfo->store_id));
        $contents[] = array('text' => sprintf(TEXT_MOVE_STORES_INTRO, $pInfo->store_name));
        $contents[] = array('text' => '<br>' . TEXT_INFO_CURRENT_CATEGORIES . '<br><b>' . smn_output_generated_store_category_path($pInfo->store_id, 'store') . '</b>');
        $contents[] = array('text' => '<br>' . sprintf(TEXT_MOVE, $pInfo->store_name) . '<br>' . smn_draw_pull_down_menu('move_to_store_category_id', $store->smn_get_store_category_tree(), $current_store_category_id));
        $contents[] = array('align' => 'center', 'text' => '<br>' . smn_image_submit('button_move.gif', IMAGE_MOVE) . ' <a href="' . smn_href_link(FILENAME_MANAGEMENT, 'sPath=' . $sPath . '&sID=' . $pInfo->store_id) . '">' . smn_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
        break;
      case 'copy_to':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_COPY_TO . '</b>');
        $contents = array('form' => smn_draw_form('copy_to', FILENAME_MANAGEMENT, 'action=copy_to_confirm&sPath=' . $sPath) . smn_draw_hidden_field('list_store_id', $pInfo->store_id));
        $contents[] = array('text' => TEXT_INFO_COPY_TO_INTRO);
        $contents[] = array('text' => '<br>' . TEXT_INFO_CURRENT_CATEGORIES . '<br><b>' . smn_output_generated_store_category_path($pInfo->store_id, 'store') . '</b>');
        $contents[] = array('text' => '<br>' . TEXT_CATEGORIES . '<br>' . smn_draw_pull_down_menu('store_categories_id', $store->smn_get_store_category_tree(), $current_store_category_id));
        $contents[] = array('text' => '<br>' . TEXT_HOW_TO_COPY . '<br>' . smn_draw_radio_field('copy_as', 'link', true) . ' ' . TEXT_COPY_AS_LINK . '<br>');
        $contents[] = array('align' => 'center', 'text' => '<br>' . smn_image_submit('button_copy.gif', IMAGE_COPY) . ' <a href="' . smn_href_link(FILENAME_MANAGEMENT, 'sPath=' . $sPath . '&sID=' . $pInfo->store_id) . '">' . smn_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
        break;
      default:
        if ($rows > 0) {
          if (isset($cInfo) && is_object($cInfo)) { // store_category info box contents
            $heading[] = array('text' => '<b>' . $cInfo->store_categories_name . '</b>');
            $contents[] = array('align' => 'center', 'text' => '<a href="' . smn_href_link(FILENAME_MANAGEMENT, 'sPath=' . $sPath . '&cID=' . $cInfo->store_categories_id . '&action=edit_store_category') . '">' . smn_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . smn_href_link(FILENAME_MANAGEMENT, 'sPath=' . $sPath . '&cID=' . $cInfo->store_categories_id . '&action=delete_store_category') . '">' . smn_image_button('button_delete.gif', IMAGE_DELETE) . '</a> <a href="' . smn_href_link(FILENAME_MANAGEMENT, 'sPath=' . $sPath . '&cID=' . $cInfo->store_categories_id . '&action=move_store_category') . '">' . smn_image_button('button_move.gif', IMAGE_MOVE) . '</a>');
            $contents[] = array('text' => '<br>' . TEXT_DATE_ADDED . ' ' . smn_date_short($cInfo->date_added));
            if (smn_not_null($cInfo->last_modified)) $contents[] = array('text' => TEXT_LAST_MODIFIED . ' ' . smn_date_short($cInfo->last_modified));
            $contents[] = array('text' => '<br>' . smn_info_image($cInfo->store_categories_image, $cInfo->store_categories_name, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT) . '<br>' . $cInfo->store_categories_image);
            $contents[] = array('text' => '<br>' . TEXT_SUBCATEGORIES . ' ' . $cInfo->childs_count . '<br>' . TEXT_STORES . ' ' . $cInfo->store_count);
          } elseif (isset($pInfo) && is_object($pInfo)) { // store info box contents
            $heading[] = array('text' => '<b>' . $pInfo->store_name . '</b>');
            $contents[] = array('align' => 'center', 'text' => '<a href="' . smn_href_link(FILENAME_MANAGEMENT, 'sPath=' . $sPath . '&sID=' . $pInfo->store_id . '&action=edit_store') . '">' . smn_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . smn_href_link(FILENAME_MANAGEMENT, 'sPath=' . $sPath . '&sID=' . $pInfo->store_id . '&action=delete_store') . '">' . smn_image_button('button_delete.gif', IMAGE_DELETE) . '</a> <a href="' . smn_href_link(FILENAME_MANAGEMENT, 'sPath=' . $sPath . '&sID=' . $pInfo->store_id . '&action=move_store') . '">' . smn_image_button('button_move.gif', IMAGE_MOVE) . '</a> <a href="' . smn_href_link(FILENAME_MANAGEMENT, 'sPath=' . $sPath . '&sID=' . $pInfo->store_id . '&action=copy_to') . '">' . smn_image_button('button_copy_to.gif', IMAGE_COPY_TO) . '</a>');
            $contents[] = array('text' => '<br>' . TEXT_DATE_ADDED . ' ' . smn_date_short($pInfo->date_added));
             } else { // create store_category/store info
          $heading[] = array('text' => '<b>' . EMPTY_CATEGORY . '</b>');
          $contents[] = array('text' => TEXT_NO_CHILD_CATEGORIES_OR_STORES);
        }
        }
        break;
    }
    if ( (smn_not_null($heading)) && (smn_not_null($contents)) ) {
      echo '            <td width="25%" valign="top">' . "\n";
      $box = new box;
      echo $box->infoBox($heading, $contents);
      echo '            </td>' . "\n";
    }
?>
          </tr>
        </table></td>
      </tr>
    </table>
<?php
  }
?>