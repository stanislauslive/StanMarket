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
 <script language="Javascript">
  $(document).ready(function (){
      $('select[name="country"]').change(function (){
          $('#stateInput').html('<img src="<?php echo DIR_WS_EXT;?>jQuery/common_images/ajax-loader-small.gif" border="0" width="16" height="16">');
          jQuery.ajax({
              cache: false,
              url: '<?php echo str_replace('&amp;', '&', smn_href_link(basename($_SERVER['PHP_SELF']), 'action=getZones'));?>&country_id=' + $(this).val(),
              dataType: 'html',
              success: function (html){
                  $('#stateInput').html(html);
              }
          });
      });
  });
 </script>
 <table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td width="100%" valign="top"><?php echo smn_draw_form('create_store_account', smn_href_link(FILENAME_CREATE_STORE_ACCOUNT, '', 'NONSSL'), 'post', 'enctype="multipart/form-data" onSubmit="return check_form(create_store_account);"') . smn_draw_hidden_field('action', 'process'); ?>
    <table border="0" width="100%" cellspacing="0" cellpadding="0">
    <?php echo smn_draw_hidden_field('store_type', $_POST['store_type']); ?>
    <?php echo smn_draw_hidden_field('conditions', $_POST['conditions']); ?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo smn_image(DIR_WS_IMAGES . 'table_background_account.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td class="smallText"><br><?php echo sprintf(TEXT_ORIGIN_LOGIN, smn_href_link(FILENAME_LOGIN, smn_get_all_get_params(), 'NONSSL')); ?></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
  if ($messageStack->size('create_store_account') > 0) {
?>
      <tr>
        <td><?php echo $messageStack->output('create_store_account'); ?></td>
      </tr>
<?php
  }
?>

     <tr>
            <td colspan="2"><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
         <tr>
         <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td> 
         <td class="inputRequirement" align="left"><?php echo FORM_REQUIRED_INFORMATION; ?></td>
        </tr>
        <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
        </table></td>
      </tr>     
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main" valign="top"><b><?php echo ENTRY_CATAGORY; ?>*&nbsp;</b></td>
            <td align="left"><table border="0" cellspacing="0" cellpadding="0" align="left">
              <tr align="left">
                <td class="main" align="left"><?php echo  smn_draw_pull_down_menu('store_catagory', $spath_setup->smn_get_store_category_tree('0','', '0'), '', 'id="store_catagory"');?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      
    
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main" valign="top"><b><?php echo TEXT_STORE_DESCRIPTION; ?>*</b></td>
            <td>
              <tr>
                <td class="main"><?php echo smn_draw_textarea_field('store_description', 'soft', '50', '15', '', 'id="store_description"');?></td>
              </tr>
            </td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main"><b><?php echo CATEGORY_PERSONAL; ?></b></td>
           <td class="inputRequirement" align="right"></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" cellspacing="2" cellpadding="2">

              <tr>
                <td class="main"><?php echo ENTRY_GENDER; ?></td>
                <td class="main"><?php echo smn_draw_radio_field('gender', 'm') . '&nbsp;&nbsp;' . MALE . '&nbsp;&nbsp;' . smn_draw_radio_field('gender', 'f') . '&nbsp;&nbsp;' . FEMALE . '&nbsp;' . (smn_not_null(ENTRY_GENDER_TEXT) ? '<span class="inputRequirement">' . ENTRY_GENDER_TEXT . '</span>': ''); ?></td>
                <td class="main"></td>
              </tr>
              <tr>
                <td class="main"><?php echo ENTRY_STORE_NAME; ?></td>
                <td class="main"><?php echo smn_draw_input_field('storename', '', 'id="storename"') . '&nbsp;' . (smn_not_null(ENTRY_STORE_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_STORE_NAME_TEXT . '</span>': ''); ?></td>
                <td class="main"></td>
              </tr>
              <tr>
                <td class="main"><?php echo ENTRY_FIRST_NAME; ?></td>
                <td class="main"><?php echo smn_draw_input_field('firstname', '', 'id="firstname"') . '&nbsp;' . (smn_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_FIRST_NAME_TEXT . '</span>': ''); ?></td>
                <td class="main"></td>
              </tr>
              <tr>
                <td class="main"><?php echo ENTRY_LAST_NAME; ?></td>
                <td class="main"><?php echo smn_draw_input_field('lastname', '', 'id="lastname"') . '&nbsp;' . (smn_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_LAST_NAME_TEXT . '</span>': ''); ?></td>
                <td class="main"></td>
              </tr>

              <tr>
                <td class="main"><?php echo ENTRY_DATE_OF_BIRTH; ?></td>
                <td class="main"><?php echo smn_draw_pull_down_menu('dob_day', $day_drop_down_array) . smn_draw_pull_down_menu('dob_month', $month_drop_down_array) . smn_draw_pull_down_menu('dob_year', $year_drop_down_array) . '&nbsp;' . (smn_not_null(ENTRY_DATE_OF_BIRTH_TEXT) ? '<span class="inputRequirement">' . ENTRY_DATE_OF_BIRTH_TEXT . '</span>': NOT_REQUIRED_TEXT); ?></td>
                <td class="main">&nbsp;</td>
              </tr>

              <tr>
                <td class="main"><?php echo ENTRY_EMAIL_ADDRESS; ?></td>
                <td class="main"><?php echo smn_draw_input_field('email_address', '', 'id="email_address"') . '&nbsp;' . (smn_not_null(ENTRY_EMAIL_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_EMAIL_ADDRESS_TEXT . '</span>': ''); ?></td>
                <td class="main">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><b><?php echo CATEGORY_COMPANY; ?></b></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" cellspacing="2" cellpadding="2">
              <tr>
                <td class="main"><?php echo ENTRY_COMPANY; ?></td>
                <td class="main"><?php echo smn_draw_input_field('company', '', 'id="company"') . '&nbsp;' . (smn_not_null(ENTRY_COMPANY_TEXT) ? '<span class="inputRequirement">' . ENTRY_COMPANY_TEXT . '</span>': NOT_REQUIRED_TEXT); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><b><?php echo CATEGORY_ADDRESS; ?></b></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" cellspacing="2" cellpadding="2">
              <tr>
                <td class="main"><?php echo ENTRY_STREET_ADDRESS; ?></td>
                <td class="main"><?php echo smn_draw_input_field('street_address', '', 'id="street_address"') . '&nbsp;' . (smn_not_null(ENTRY_STREET_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_STREET_ADDRESS_TEXT . '</span>': ''); ?></td>
              </tr>
              <tr>
                <td class="main"><?php echo ENTRY_CITY; ?></td>
                <td class="main"><?php echo smn_draw_input_field('city', '', 'id="city"') . '&nbsp;' . (smn_not_null(ENTRY_CITY_TEXT) ? '<span class="inputRequirement">' . ENTRY_CITY_TEXT . '</span>': ''); ?></td>
              </tr>
              <tr>
                <td class="main"><?php echo ENTRY_POST_CODE; ?></td>
                <td class="main"><?php echo smn_draw_input_field('postcode', '', 'id="postcode"') . '&nbsp;' . (smn_not_null(ENTRY_POST_CODE_TEXT) ? '<span class="inputRequirement">' . ENTRY_POST_CODE_TEXT . '</span>': ''); ?></td>
              </tr>
              <tr>
                <td class="main"><?php echo ENTRY_COUNTRY; ?></td>
                <td class="main"><?php echo smn_get_country_list('country') . '&nbsp;' . (smn_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="inputRequirement">' . ENTRY_COUNTRY_TEXT . '</span>': ''); ?></td>
              </tr>
              <tr>
                <td class="main"><?php echo ENTRY_STATE; ?></td>
                <td class="main" id="stateInput"><?php echo smn_draw_input_field('state', '', 'id="state"') . '&nbsp;' . (smn_not_null(ENTRY_STATE_TEXT) ? '<span class="inputRequirement">' . ENTRY_STATE_TEXT . '</span>': ''); ?>
<?php
   /* $state = smn_get_zone_name($country, $zone_id, $state);
    if ($is_read_only) {
      echo smn_get_zone_name($account['entry_country_id'], $account['entry_zone_id'], $account['entry_state']);
    } elseif ($error) {
      if ($entry_state_error) {
        if ($entry_state_has_zones) {
          $zones_array = array();
          $zones_query = smn_db_query("select zone_name from " . TABLE_ZONES . " where zone_country_id = '" . smn_db_input($country) . "' order by zone_name");
          while ($zones_values = smn_db_fetch_array($zones_query)) {
            $zones_array[] = array('id' => $zones_values['zone_name'], 'text' => $zones_values['zone_name']);
          }
          echo smn_draw_pull_down_menu('state', $zones_array) . '&nbsp;' . ENTRY_STATE_ERROR;
        } else {
          echo smn_draw_input_field('state') . '&nbsp;' . ENTRY_STATE_ERROR;
        }
      } else {
        echo $state . smn_draw_hidden_field('zone_id') . smn_draw_hidden_field('state');
      }
    } else {
      echo smn_draw_input_field('state', smn_get_zone_name($account['entry_country_id'], $account['entry_zone_id'], $account['entry_state'])) . '&nbsp;' . '<span class="inputRequirement">' . ENTRY_STATE_TEXT . '</span>';
    }*/
?>

                </td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><b><?php echo CATEGORY_CONTACT; ?></b></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" cellspacing="2" cellpadding="2">
              <tr>
                <td class="main"><?php echo ENTRY_TELEPHONE_NUMBER; ?></td>
                <td class="main"><?php echo smn_draw_input_field('telephone_area', '', 'maxlength="3" size="3"') . '&nbsp;-&nbsp;' .smn_draw_input_field('telephone_prefix', '','maxlength="3" size="3"') . '&nbsp;-&nbsp;' . smn_draw_input_field('telephone_post', '','maxlength="4" size="4"') .'&nbsp;' . (smn_not_null(ENTRY_TELEPHONE_NUMBER_TEXT) ? '<span class="inputRequirement">' . ENTRY_TELEPHONE_NUMBER_TEXT . '</span>': '') .  NOT_REQUIRED_TEXT; ?></td>
              </tr>
              <tr>
                <td class="main"><?php echo ENTRY_FAX_NUMBER; ?></td>
                <td class="main"><?php echo  smn_draw_input_field('fax_area', '', 'maxlength="3" size="3"') . '&nbsp;-&nbsp;' .smn_draw_input_field('fax_prefix', '','maxlength="3" size="3"') . '&nbsp;-&nbsp;' . smn_draw_input_field('fax_post', '','maxlength="4" size="4"') . '&nbsp;' . (smn_not_null(ENTRY_FAX_NUMBER_TEXT) ? '<span class="inputRequirement">' . ENTRY_FAX_NUMBER_TEXT . '</span>': '') . NOT_REQUIRED_TEXT; ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><b><?php echo CATEGORY_OPTIONS; ?></b></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" cellspacing="2" cellpadding="2">
              <tr>
                <td class="main"><?php echo ENTRY_NEWSLETTER; ?></td>
                <td class="main"><?php echo smn_draw_checkbox_field('newsletter', '1') . '&nbsp;' . (smn_not_null(ENTRY_NEWSLETTER_TEXT) ? '<span class="inputRequirement">' . ENTRY_NEWSLETTER_TEXT . '</span>': ''); ?></td>
              </tr>
              <tr>
                <td class="main"><?php echo TEXT_STORES_IMAGE; ?></td>
                <td class="main"><?php echo  smn_draw_file_field('store_image'). '&nbsp;<br>' .(smn_not_null(ENTRY_LOGO_TEXT) ? '<span class="inputRequirement">' . sprintf(ENTRY_LOGO_TEXT, MAX_IMAGE_FILE_SIZE) . '</span>': ''); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><b><?php echo CATEGORY_PASSWORD; ?></b></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" cellspacing="2" cellpadding="2">
              <tr>
                <td class="main"><?php echo ENTRY_PASSWORD; ?></td>
                <td class="main"><?php echo smn_draw_password_field('password', '', 'id="password"') . '&nbsp;' . (smn_not_null(ENTRY_PASSWORD_TEXT) ? '<span class="inputRequirement">' . ENTRY_PASSWORD_TEXT . '</span>': ''); ?></td>
              </tr>
              <tr>
                <td class="main"><?php echo ENTRY_PASSWORD_CONFIRMATION; ?></td>
                <td class="main"><?php echo smn_draw_password_field('confirmation', '', 'id="confirmation"') . '&nbsp;' . (smn_not_null(ENTRY_PASSWORD_CONFIRMATION_TEXT) ? '<span class="inputRequirement">' . ENTRY_PASSWORD_CONFIRMATION_TEXT . '</span>': ''); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td><?php echo smn_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE, 'onClick="return checksubmit(this)"'); ?></td>
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></form></td>
  </tr>
  </table>