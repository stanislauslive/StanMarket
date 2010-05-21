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

  if ($_GET['action'] == 'edit') {
?>
<script language="javascript"><!--
function resetStateText(theForm) {
  theForm.affiliate_state.value = '';
  if (theForm.affiliate_zone_id.options.length > 1) {
    theForm.affiliate_state.value = '<?php echo JS_STATE_SELECT; ?>';
  }
}

function resetZoneSelected(theForm) {
  if (theForm.affiliate_state.value != '') {
    theForm.affiliate_zone_id.selectedIndex = '0';
    if (theForm.affiliate_zone_id.options.length > 1) {
      theForm.affiliate_state.value = '<?php echo JS_STATE_SELECT; ?>';
    }
  }
}

function update_zone(theForm) {
  var NumState = theForm.affiliate_zone_id.options.length;
  var SelectedCountry = '';

  while(NumState > 0) {
    NumState--;
    theForm.affiliate_zone_id.options[NumState] = null;
  }

  SelectedCountry = theForm.affiliate_country_id.options[theForm.affiliate_country_id.selectedIndex].value;

<?php echo smn_js_zone_list('SelectedCountry', 'theForm', 'affiliate_zone_id'); ?>

  resetStateText(theForm);
}

function check_form() {
  var error = 0;
  var error_message = "<?php echo JS_ERROR; ?>";

  var affiliate_firstname = document.affiliate.affiliate_firstname.value;
  var affiliate_lastname = document.affiliate.affiliate_lastname.value;
<?php if (ACCOUNT_COMPANY == 'true') echo 'var affiliate_company = document.affiliate.affiliate_company.value;' . "\n"; ?>
  var affiliate_email_address = document.affiliate.affiliate_email_address.value;  
  var affiliate_street_address = document.affiliate.affiliate_street_address.value;
  var affiliate_postcode = document.affiliate.affiliate_postcode.value;
  var affiliate_city = document.affiliate.affiliate_city.value;
  var affiliate_telephone = document.affiliate.affiliate_telephone.value;

<?php if (ACCOUNT_GENDER == 'true') { ?>
  if (document.affiliate.affiliate_gender[0].checked || document.affiliate.affiliate_gender[1].checked) {
  } else {
    error_message = error_message + "<?php echo JS_GENDER; ?>";
    error = 1;
  }
<?php } ?>

  if (affiliate_firstname = "" || affiliate_firstname.length < <?php echo ENTRY_FIRST_NAME_MIN_LENGTH; ?>) {
    error_message = error_message + "<?php echo JS_FIRST_NAME; ?>";
    error = 1;
  }

  if (affiliate_lastname = "" || affiliate_lastname.length < <?php echo ENTRY_LAST_NAME_MIN_LENGTH; ?>) {
    error_message = error_message + "<?php echo JS_LAST_NAME; ?>";
    error = 1;
  }

  if (affiliate_email_address = "" || affiliate_email_address.length < <?php echo ENTRY_EMAIL_ADDRESS_MIN_LENGTH; ?>) {
    error_message = error_message + "<?php echo JS_EMAIL_ADDRESS; ?>";
    error = 1;
  }

  if (affiliate_street_address = "" || affiliate_street_address.length < <?php echo ENTRY_STREET_ADDRESS_MIN_LENGTH; ?>) {
    error_message = error_message + "<?php echo JS_ADDRESS; ?>";
    error = 1;
  }

  if (affiliate_postcode = "" || affiliate_postcode.length < <?php echo ENTRY_POSTCODE_MIN_LENGTH; ?>) {
    error_message = error_message + "<?php echo JS_POST_CODE; ?>";
    error = 1;
  }

  if (affiliate_city = "" || affiliate_city.length < <?php echo ENTRY_CITY_MIN_LENGTH; ?>) {
    error_message = error_message + "<?php echo JS_CITY; ?>";
    error = 1;
  }

<?php if (ACCOUNT_STATE == 'true') { ?>
  if (document.affiliate.affiliate_zone_id.options.length <= 1) {
    if (document.affiliate.affiliate_state.value == "" || document.affiliate.affiliate_state.length < 4 ) {
       error_message = error_message + "<?php echo JS_STATE; ?>";
       error = 1;
    }
  } else {
    document.affiliate.affiliate_state.value = '';
    if (document.affiliate.affiliate_zone_id.selectedIndex == 0) {
       error_message = error_message + "<?php echo JS_ZONE; ?>";
       error = 1;
    }
  }
<?php } ?>

  if (document.affiliate.affiliate_country_id.value == 0) {
    error_message = error_message + "<?php echo JS_COUNTRY; ?>";
    error = 1;
  }

  if (affiliate_telephone = "" || affiliate_telephone.length < <?php echo ENTRY_TELEPHONE_MIN_LENGTH; ?>) {
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
//--></script>
<?php
  }
?>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
<?php
  if ($_GET['action'] == 'edit') { 
  /*Changed the query to take data from customer table also by Cimi*/
//    $affiliate_query = smn_db_query("select * from " . TABLE_AFFILIATE . " where affiliate_id = '" . $_GET['acID'] . "'");
    $affiliate_query = smn_db_query("select * from " . TABLE_AFFILIATE . " a,". TABLE_CUSTOMERS." c,". TABLE_ADDRESS_BOOK." ab where a.affiliate_id = '" . $_GET['acID'] . "' and c.customers_id=a.affiliate_customer_id and c.customers_default_address_id=ab.address_book_id and c.customers_id=ab.customers_id");
    $affiliate = smn_db_fetch_array($affiliate_query);
    $aInfo = new objectInfo($affiliate);
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr><?php echo smn_draw_form('affiliate', FILENAME_AFFILIATE, smn_get_all_get_params(array('action')) . 'action=update', 'post', 'onSubmit="return check_form();"'); ?>
        <td class="formAreaTitle"><?php echo CATEGORY_PERSONAL; ?></td>
      </tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
<?php
    if (ACCOUNT_GENDER == 'true') {
?>
          <tr>
            <td class="main"><?php echo ENTRY_GENDER; ?></td>
			<!--Changed the $aInfo->affilaite_gender to $aInfo->customers_gender by Cimi -->
            <td class="main"><?php echo smn_draw_radio_field('affiliate_gender', 'm', false, $aInfo->customers_gender) . '&nbsp;&nbsp;' . MALE . '&nbsp;&nbsp;' . smn_draw_radio_field('affiliate_gender', 'f', false, $aInfo->customers_gender) . '&nbsp;&nbsp;' . FEMALE; ?></td>
          </tr>
<?php
    }
?>
          <tr>
            <td class="main"><?php echo ENTRY_FIRST_NAME; ?></td>
			<!--Changed the $aInfo->affiliate_firstname to $aInfo->customers_firstname by Cimi -->
            <td class="main"><?php echo smn_draw_input_field('affiliate_firstname', $aInfo->customers_firstname, 'maxlength="32"', true); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_LAST_NAME; ?></td>
			<!--Changed the $aInfo->affiliate_lastname to $aInfo->customers_lastname by Cimi -->
            <td class="main"><?php echo smn_draw_input_field('affiliate_lastname', $aInfo->customers_lastname, 'maxlength="32"', true); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_EMAIL_ADDRESS; ?></td>
			<!--Changed the $aInfo->affiliate_email_address to $aInfo->customers_email_address by Cimi -->
            <td class="main"><?php echo smn_draw_input_field('affiliate_email_address', $aInfo->customers_email_address, 'maxlength="96"', true); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
<?php
   if (AFFILATE_INDIVIDUAL_PERCENTAGE == 'true') {
?>
      <tr>
        <td class="formAreaTitle"><?php echo CATEGORY_COMMISSION; ?></td>
      </tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td class="main"><?php echo ENTRY_AFFILIATE_COMMISSION; ?></td>
            <td class="main"><?php echo smn_draw_input_field('affiliate_commission_percent', $aInfo->affiliate_commission_percent, 'maxlength="5"'); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
<?php
    }
?>
      <tr>
        <td class="formAreaTitle"><?php echo CATEGORY_COMPANY; ?></td>
      </tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td class="main"><?php echo ENTRY_COMPANY; ?></td>
			<!--Changed the $aInfo->affiliate_company to $aInfo->entry_company by Cimi -->
            <td class="main"><?php echo smn_draw_input_field('affiliate_company', $aInfo->entry_company, 'maxlength="32"'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_AFFILIATE_COMPANY_TAXID; ?></td>
            <td class="main"><?php echo smn_draw_input_field('affiliate_company_taxid', $aInfo->affiliate_company_taxid, 'maxlength="64"'); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="formAreaTitle"><?php echo CATEGORY_PAYMENT_DETAILS; ?></td>
      </tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
<?php
  if (AFFILIATE_USE_CHECK == 'true') {
?>
          <tr>
            <td class="main"><?php echo ENTRY_AFFILIATE_PAYMENT_CHECK; ?></td>
            <td class="main"><?php echo smn_draw_input_field('affiliate_payment_check', $aInfo->affiliate_payment_check, 'maxlength="100"'); ?></td>
          </tr>
<?php
  }
  if (AFFILIATE_USE_PAYPAL == 'true') {
?>
          <tr>
            <td class="main"><?php echo ENTRY_AFFILIATE_PAYMENT_PAYPAL; ?></td>
            <td class="main"><?php echo smn_draw_input_field('affiliate_payment_paypal', $aInfo->affiliate_payment_paypal, 'maxlength="64"'); ?></td>
          </tr>
<?php
  }
  if (AFFILIATE_USE_BANK == 'true') {
?>
          <tr>
            <td class="main"><?php echo ENTRY_AFFILIATE_PAYMENT_BANK_NAME; ?></td>
            <td class="main"><?php echo smn_draw_input_field('affiliate_payment_bank_name', $aInfo->affiliate_payment_bank_name, 'maxlength="64"'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_AFFILIATE_PAYMENT_BANK_BRANCH_NUMBER; ?></td>
            <td class="main"><?php echo smn_draw_input_field('affiliate_payment_bank_branch_number', $aInfo->affiliate_payment_bank_branch_number, 'maxlength="64"'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_AFFILIATE_PAYMENT_BANK_SWIFT_CODE; ?></td>
            <td class="main"><?php echo smn_draw_input_field('affiliate_payment_bank_swift_code', $aInfo->affiliate_payment_bank_swift_code, 'maxlength="64"'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_AFFILIATE_PAYMENT_BANK_ACCOUNT_NAME; ?></td>
            <td class="main"><?php echo smn_draw_input_field('affiliate_payment_bank_account_name', $aInfo->affiliate_payment_bank_account_name, 'maxlength="64"'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_AFFILIATE_PAYMENT_BANK_ACCOUNT_NUMBER; ?></td>
            <td class="main"><?php echo smn_draw_input_field('affiliate_payment_bank_account_number', $aInfo->affiliate_payment_bank_account_number, 'maxlength="64"'); ?></td>
          </tr>
<?php
  }
?>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="formAreaTitle"><?php echo CATEGORY_ADDRESS; ?></td>
      </tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td class="main"><?php echo ENTRY_STREET_ADDRESS; ?></td>
			<!--Changed the $aInfo->affiliate_street_address to $aInfo->entry_street_address by Cimi -->
            <td class="main"><?php echo smn_draw_input_field('affiliate_street_address', $aInfo->entry_street_address, 'maxlength="64"', true); ?></td>
          </tr>
<?php
  if (ACCOUNT_SUBURB == 'true') {
?>
          <tr>
            <td class="main"><?php echo ENTRY_SUBURB; ?></td>
            <td class="main"><?php echo smn_draw_input_field('affiliate_suburb', $aInfo->affiliate_suburb, 'maxlength="64"', false); ?></td>
          </tr>
<?php
  }
?>
          <tr>
            <td class="main"><?php echo ENTRY_CITY; ?></td>
			<!--Changed the $aInfo->affiliate_city to $aInfo->entry_city by Cimi -->
            <td class="main"><?php echo smn_draw_input_field('affiliate_city', $aInfo->entry_city, 'maxlength="32"', true); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_POST_CODE; ?></td>
			<!--Changed the $aInfo->affiliate_postcode to $aInfo->entry_postcode by Cimi -->
            <td class="main"><?php echo smn_draw_input_field('affiliate_postcode', $aInfo->entry_postcode, 'maxlength="8"', true); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_COUNTRY; ?></td>
			<!--Changed the $aInfo->affiliate_country_id to $aInfo->entry_country_id by Cimi -->
            <td class="main"><?php echo smn_draw_pull_down_menu('affiliate_country_id', smn_get_countries(), $aInfo->entry_country_id, 'onChange="update_zone(this.form);"'); ?></td>
          </tr>
<?php
    if (ACCOUNT_STATE == 'true') {
?>
          <tr>
            <td class="main"><?php echo ENTRY_STATE; ?></td>
			<!--Changed the $aInfo->affiliate_zone_id to $aInfo->entry_zone_id and $aInfo->affiliate_country_id to $aInfo->entry_country_id by Cimi -->
            <td class="main"><?php echo smn_draw_pull_down_menu('affiliate_zone_id', smn_prepare_country_zones_pull_down($aInfo->entry_country_id), $aInfo->entry_zone_id, 'onChange="resetStateText(this.form);"'); ?></td>
          </tr>
          <tr>
            <td class="main">&nbsp;</td>
            <td class="main"><?php echo smn_draw_input_field('affiliate_state', $aInfo->entry_state, 'maxlength="32" onChange="resetZoneSelected(this.form);"'); ?></td>
          </tr>
<?php
    }
?>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="formAreaTitle"><?php echo CATEGORY_CONTACT; ?></td>
      </tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td class="main"><?php echo ENTRY_TELEPHONE_NUMBER; ?></td>
			<!--Changed the $aInfo->affiliate_telephone to $aInfo->customers_telephone  by Cimi -->
            <td class="main"><?php echo smn_draw_input_field('affiliate_telephone', $aInfo->customers_telephone, 'maxlength="32"'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_FAX_NUMBER; ?></td>
			<!--Changed the $aInfo->affiliate_fax to $aInfo->customers_fax  by Cimi -->
            <td class="main"><?php echo smn_draw_input_field('affiliate_fax', $aInfo->customers_fax, 'maxlength="32"'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_AFFILIATE_HOMEPAGE; ?></td>
            <td class="main"><?php echo smn_draw_input_field('affiliate_homepage', $aInfo->affiliate_homepage, 'maxlength="64"', true); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
       <tr>
        <td align="right" class="main"><?php echo smn_image_submit('button_update.gif', IMAGE_UPDATE) . ' <a href="' . smn_href_link(FILENAME_AFFILIATE, smn_get_all_get_params(array('action'))) .'">' . smn_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>';?></td>
      </tr></form>
<?php
  } else {
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
          </tr>
        </table></td>
      </tr>
          <tr><?php echo smn_draw_form('search', FILENAME_AFFILIATE, '', 'get'); ?>
            <td class="smallText" align="right"><?php echo HEADING_TITLE_SEARCH . ' ' . smn_draw_input_field('search'); ?></td>
          </form></tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_AFFILIATE_ID; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_LASTNAME; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_FIRSTNAME; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_COMMISSION; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_USERHOMEPAGE; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
    $search = '';
    if ( ($_GET['search']) && (smn_not_null($_GET['search'])) ) {
      $keywords = smn_db_input(smn_db_prepare_input($_GET['search']));
	  /*Changed the query to take data from customer table by Cimi*/
      //$search = " where affiliate_id like '" . $keywords . "' or affiliate_firstname like '" . $keywords . "' or affiliate_lastname like '" . $keywords . "' or affiliate_email_address like '" . $keywords . "'";
      $search = " and a.affiliate_id like '" . $keywords . "' or c.customers_firstname like '" . $keywords . "' or c.customers_lastname like '" . $keywords . "' or c.customers_email_address like '" . $keywords . "'";
    }
	  /*Changed the query to take data from customer table by Cimi*/
    //$affiliate_query_raw = "select * from " . TABLE_AFFILIATE . $search . " order by affiliate_lastname";
    $affiliate_query_raw = "select * from ". TABLE_CUSTOMERS ." c," . TABLE_AFFILIATE ." a where c.customers_id=a.affiliate_customer_id ". $search . "  order by c.customers_lastname";
    $affiliate_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, 
    $affiliate_query_raw, $affiliate_query_numrows);
    $affiliate_query = smn_db_query($affiliate_query_raw);
    while ($affiliate = smn_db_fetch_array($affiliate_query)) {
	  /*Changed the query to take data from customer table by Cimi*/
     // $info_query = smn_db_query("select affiliate_commission_percent, affiliate_date_account_created as date_account_created, affiliate_date_account_last_modified as date_account_last_modified, affiliate_date_of_last_logon as date_last_logon, affiliate_number_of_logons as number_of_logons from " . TABLE_AFFILIATE . " where affiliate_id = '" . $affiliate['affiliate_id'] . "'");
      $info_query = smn_db_query("select a.affiliate_commission_percent, ci.customers_info_date_account_created as date_account_created, ci.customers_info_date_account_last_modified as date_account_last_modified, ci.customers_info_date_of_last_logon as date_last_logon, ci.customers_info_number_of_logons as number_of_logons from " . TABLE_AFFILIATE . " a,". TABLE_CUSTOMERS_INFO ." ci where a.affiliate_id = '" . $affiliate['affiliate_id'] . "' and a.affiliate_customer_id=ci.customers_info_id");
      $info = smn_db_fetch_array($info_query);

      if (((!$_GET['acID']) || (@$_GET['acID'] == $affiliate['affiliate_id'])) && (!$aInfo)) {
        $country_query = smn_db_query("select countries_name from " . TABLE_COUNTRIES . " where countries_id = '" . $affiliate['customers_country_id'] . "'");
        $country = smn_db_fetch_array($country_query);

        $affiliate_info = array_merge($country, $info);

        $aInfo_array = array_merge($affiliate, $affiliate_info);
        $aInfo = new objectInfo($aInfo_array);
      }

      if ( (is_object($aInfo)) && ($affiliate['affiliate_id'] == $aInfo->affiliate_id) ) {
        echo '          <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . smn_href_link(FILENAME_AFFILIATE, smn_get_all_get_params(array('acID', 'action')) . 'acID=' . $aInfo->affiliate_id . '&action=edit') . '\'">' . "\n";
      } else {
        echo '          <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . smn_href_link(FILENAME_AFFILIATE, smn_get_all_get_params(array('acID')) . 'acID=' . $affiliate['affiliate_id']) . '\'">' . "\n";
      }
      if (substr($affiliate['affiliate_homepage'],0,7) != "http://") $affiliate['affiliate_homepage']="http://".$affiliate['affiliate_homepage'];
?>
                <td class="dataTableContent"><?php echo $affiliate['affiliate_id']; ?></td>  
			<!--	Changed the array index affilaite_lastname to customers_lastname and affiliate_firstname to customers_firstname by Cimi -->    
                <td class="dataTableContent"><?php echo $affiliate['customers_lastname']; ?></td>
                <td class="dataTableContent"><?php echo $affiliate['customers_firstname']; ?></td>
                <td class="dataTableContent" align="right"><?php if($affiliate['affiliate_commission_percent'] > AFFILIATE_PERCENT) echo $affiliate['affiliate_commission_percent']; else echo  AFFILIATE_PERCENT; ?> %</td>
                <td class="dataTableContent"><?php echo '<a href="' . smn_href_link(FILENAME_AFFILIATE, smn_get_all_get_params(array('acID', 'action')) . 'acID=' . $affiliate['affiliate_id'] . '&action=edit') . '">' . smn_image(DIR_WS_ICONS . 'preview.gif', ICON_PREVIEW) . '</a>'; echo '<a href="' . $affiliate['affiliate_homepage'] . '" target="_blank">' . $affiliate['affiliate_homepage'] . '</a>'; ?></td>
				<!--Added the customer id to the url by Cimi -->
                <td class="dataTableContent" align="right"><?php echo '<a href="' . smn_href_link(FILENAME_AFFILIATE_STATISTICS, smn_get_all_get_params(array('acID')) . 'acID=' . $affiliate['affiliate_id']) . '">' . smn_image(DIR_WS_ICONS . 'statistics.gif', ICON_STATISTICS) . '</a>&nbsp;'; if ( (is_object($aInfo)) && ($affiliate['affiliate_id'] == $aInfo->affiliate_id) ) { echo smn_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . smn_href_link(FILENAME_AFFILIATE, smn_get_all_get_params(array('acID')) . 'acID=' . $affiliate['affiliate_id'].'&cID='.$affiliate['affiliate_customer_id']) . '">' . smn_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    }
?>
              <tr>
                <td colspan="6"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $affiliate_split->display_count($affiliate_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_AFFILIATES); ?></td>
                    <td class="smallText" align="right"><?php echo $affiliate_split->display_links($affiliate_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], smn_get_all_get_params(array('page', 'info', 'x', 'y', 'acID'))); ?></td>
                  </tr>
<?php
    if (smn_not_null($_GET['search'])) {
?>
                  <tr>
                    <td align="right" colspan="2"><?php echo '<a href="' . smn_href_link(FILENAME_AFFILIATE) . '">' . smn_image_button('button_reset.gif', IMAGE_RESET) . '</a>'; ?></td>
                  </tr>
<?php
    }
?>
                </table></td>
              </tr>
            </table></td>
<?php
  $heading = array();
  $contents = array();
  switch ($_GET['action']) {
    case 'confirm':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_CUSTOMER . '</b>');

      $contents = array('form' => smn_draw_form('affiliate', FILENAME_AFFILIATE, smn_get_all_get_params(array('acID', 'action')) . 'acID=' . $aInfo->affiliate_id . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_DELETE_INTRO . '<br><br><b>' . $aInfo->affiliate_firstname . ' ' . $aInfo->affiliate_lastname . '</b>');
      $contents[] = array('align' => 'center', 'text' => '<br>' . smn_image_submit('button_delete.gif', IMAGE_DELETE) . ' <a href="' . smn_href_link(FILENAME_AFFILIATE, smn_get_all_get_params(array('acID', 'action')) . 'acID=' . $aInfo->affiliate_id) . '">' . smn_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;
    default:
      if (is_object($aInfo)) {
        $heading[] = array('text' => '<b>' . $aInfo->affiliate_firstname . ' ' . $aInfo->affiliate_lastname . '</b>');
	/*Added the customer id to the url by Cimi*/
        $contents[] = array('align' => 'center', 'text' => '<a href="' . smn_href_link(FILENAME_AFFILIATE, smn_get_all_get_params(array('acID', 'action','cID')) . 'acID=' . $aInfo->affiliate_id . '&action=edit'.'&cID=' . $aInfo->affiliate_customer_id) . '">' . smn_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . smn_href_link(FILENAME_AFFILIATE, smn_get_all_get_params(array('acID', 'action')) . 'acID=' . $aInfo->affiliate_id . '&action=confirm') . '">' . smn_image_button('button_delete.gif', IMAGE_DELETE) . '</a> <a href="' . smn_href_link(FILENAME_AFFILIATE_CONTACT, 'selected_box=affiliate&affiliate=' . $aInfo->affiliate_email_address) . '">' . smn_image_button('button_email.gif', IMAGE_EMAIL) . '</a>');

        $affiliate_sales_raw = "select count(*) as count, sum(affiliate_value) as total, sum(affiliate_payment) as payment from " . TABLE_AFFILIATE_SALES . " a left join " . TABLE_ORDERS . " o on (a.affiliate_orders_id=o.orders_id) where o.orders_status >= " . AFFILIATE_PAYMENT_ORDER_MIN_STATUS . " and  affiliate_id = '" . $aInfo->affiliate_id . "'";
        $affiliate_sales_values = smn_db_query($affiliate_sales_raw);
        $affiliate_sales = smn_db_fetch_array($affiliate_sales_values);

        $contents[] = array('text' => '<br>' . TEXT_DATE_ACCOUNT_CREATED . ' ' . smn_date_short($aInfo->date_account_created));
        $contents[] = array('text' => '' . TEXT_DATE_ACCOUNT_LAST_MODIFIED . ' ' . smn_date_short($aInfo->date_account_last_modified));
        $contents[] = array('text' => '' . TEXT_INFO_DATE_LAST_LOGON . ' '  . smn_date_short($aInfo->date_last_logon));
        $contents[] = array('text' => '' . TEXT_INFO_NUMBER_OF_LOGONS . ' ' . $aInfo->number_of_logons);
        $contents[] = array('text' => '' . TEXT_INFO_COMMISSION . ' ' . $aInfo->affiliate_commission_percent . ' %');
        $contents[] = array('text' => '' . TEXT_INFO_COUNTRY . ' ' . $aInfo->countries_name);
        $contents[] = array('text' => '' . TEXT_INFO_NUMBER_OF_SALES . ' ' . $affiliate_sales['count'],'');
        $contents[] = array('text' => '' . TEXT_INFO_SALES_TOTAL . ' ' . $currencies->display_price($affiliate_sales['total'],''));
        $contents[] = array('text' => '' . TEXT_INFO_AFFILIATE_TOTAL . ' ' . $currencies->display_price($affiliate_sales['payment'],''));
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
<?php
  }
?>
    </table>