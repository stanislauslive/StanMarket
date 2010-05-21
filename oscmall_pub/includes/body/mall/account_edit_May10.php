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

    <?php echo smn_draw_form('account_edit', smn_href_link(FILENAME_ACCOUNT_EDIT, '', 'NONSSL'), 'post', 'onSubmit="return check_form(account_edit);" enctype="multipart/form-data"') . smn_draw_hidden_field('action', 'process'); ?>

    <table border="0" width="100%" cellspacing="0" cellpadding="0">

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

<?php

  if ($messageStack->size('account_edit') > 0) {

?>

      <tr>

        <td><?php echo $messageStack->output('account_edit'); ?></td>

      </tr>

      <tr>

        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>

      </tr>

<?php

  }

?>

      <tr>

        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">

          <tr>

            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">

              <tr>

                <td class="main"><b><?php echo MY_ACCOUNT_TITLE; ?></b></td>

                <td class="inputRequirement" align="right"><?php echo FORM_REQUIRED_INFORMATION; ?></td>

              </tr>

            </table></td>

          </tr>

          <tr>

            <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">

              <tr class="infoBoxContents">

                <td><table border="0" cellspacing="2" cellpadding="2">

                  <tr>

                    <td class="main"><?php echo ENTRY_FIRST_NAME; ?></td>

                    <td class="main"><?php echo smn_draw_input_field('firstname', $account['customers_firstname']) . '&nbsp;' . (smn_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_FIRST_NAME_TEXT . '</span>': ''); ?></td>

                  </tr>

                  <tr>

                    <td class="main"><?php echo ENTRY_LAST_NAME; ?></td>

                    <td class="main"><?php echo smn_draw_input_field('lastname', $account['customers_lastname']) . '&nbsp;' . (smn_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_LAST_NAME_TEXT . '</span>': ''); ?></td>

                  </tr>

                  <tr>

                    <td class="main"><?php echo ENTRY_DATE_OF_BIRTH; ?></td>

                    <td class="main"><?php echo substr($account['customers_dob'], 4, 2) . '-' . substr($account['customers_dob'], 6, 2) . '-' . substr($account['customers_dob'], 0, 4); ?></td>
                                     <?php echo smn_draw_hidden_field('customers_dob', $account['customers_dob']) .  smn_draw_hidden_field('customers_gender', $account['customers_gender']) ?>
                  </tr>
                  <tr>
                    <td class="main"><?php echo ENTRY_EMAIL_ADDRESS; ?></td>
                    <td class="main"><?php echo smn_draw_input_field('email_address', $account['customers_email_address']) . '&nbsp;' . (smn_not_null(ENTRY_EMAIL_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_EMAIL_ADDRESS_TEXT . '</span>': ''); ?></td>
                  </tr>
                <tr>
                    <td class="main"><?php echo ENTRY_FAX_NUMBER; ?></td>
                    <td class="main"><?php echo smn_draw_input_field('fax', $account['customers_fax']) . '&nbsp;' . (smn_not_null(ENTRY_FAX_NUMBER_TEXT) ? '<span class="inputRequirement">' . ENTRY_FAX_NUMBER_TEXT . '</span>': '') . '&nbsp;&nbsp;' . NOT_REQUIRED_TEXT  ?></td>
                </tr>
                <tr>
                    <td class="main"><?php echo ENTRY_COMPANY; ?></td>
                    <td class="main"><?php echo smn_draw_input_field('company', $account['entry_company']) . '&nbsp;' . (smn_not_null(ENTRY_COMPANY_TEXT) ? '<span class="inputRequirement">' . ENTRY_COMPANY_TEXT . '</span>': NOT_REQUIRED_TEXT); ?></td>
                </tr>
                  <tr>

                    <td class="main"><?php echo ENTRY_TELEPHONE_NUMBER; ?></td>

                    <td class="main"><?php echo smn_draw_input_field('telephone', $account['customers_telephone']) . '&nbsp;' . (smn_not_null(ENTRY_TELEPHONE_NUMBER_TEXT) ? '<span class="inputRequirement">' . ENTRY_TELEPHONE_NUMBER_TEXT . '</span>': '') ; ?></td>

                  </tr>

                  <tr>

                    <td class="main"><?php echo ENTRY_STREET_ADDRESS; ?></td>

                    <td class="main"><?php echo smn_draw_input_field('street_address', $account['entry_street_address']) . '&nbsp;' . (smn_not_null(ENTRY_STREET_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_STREET_ADDRESS_TEXT . '</span>': ''); ?></td>

                  </tr>

                  <tr>

                    <td class="main"><?php echo ENTRY_POST_CODE; ?></td>

                    <td class="main"><?php echo smn_draw_input_field('postcode', $account['entry_postcode']) . '&nbsp;' . (smn_not_null(ENTRY_POST_CODE_TEXT) ? '<span class="inputRequirement">' . ENTRY_POST_CODE_TEXT . '</span>': ''); ?></td>

                  </tr>

                  <tr>

                    <td class="main"><?php echo ENTRY_CITY; ?></td>

                    <td class="main"><?php echo smn_draw_input_field('city', $account['entry_city']) . '&nbsp;' . (smn_not_null(ENTRY_CITY_TEXT) ? '<span class="inputRequirement">' . ENTRY_CITY_TEXT . '</span>': ''); ?></td>

                  </tr>

          <tr>

            <td class="main"><?php echo ENTRY_STATE; ?></td>

            <td class="main">

<?php
        $zones_array = array();
        $zones_query = smn_db_query("select zone_id, zone_name from " . TABLE_ZONES . " where zone_country_id = '" . (int)$account['entry_country_id'] . "' order by zone_name");
        while ($zones_values = smn_db_fetch_array($zones_query)) {
          $zones_array[] = array('id' => $zones_values['zone_id'], 'text' => $zones_values['zone_name']);
        }
        echo smn_draw_pull_down_menu('state', $zones_array, $account['entry_zone_id']);

    if (smn_not_null(ENTRY_STATE_TEXT)) echo '&nbsp;<span class="inputRequirement">' . ENTRY_STATE_TEXT;

?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_COUNTRY; ?></td>
            <td class="main"><?php echo smn_get_country_list('country', $account['entry_country_id']) . '&nbsp;' . (smn_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="inputRequirement">' . ENTRY_COUNTRY_TEXT . '</span>': ''); ?></td>
          </tr>
          <tr>
                <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
              </tr>

<?php

        if ($store->is_store_owner($customer_id)){
?>

              
              <tr>
                <td class="main" width="10%" nowrap valign="top"><?php echo ENTRY_STORE_DESCRIPTION; ?></td>
                <td class="main"><?php echo smn_draw_textarea_field('store_description', 'soft', '50', '15', $store_edit->get_store_description()); ?></td>
              </tr>
              <tr>
                <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
             </tr>
              <tr>
                <td class="main"><?php echo ENTRY_STORE_NAME; ?></td>
                <td class="main"><?php echo smn_draw_input_field('store_edit_name', $store_edit->get_store_name()) . '&nbsp;' . (smn_not_null(ENTRY_STORE_NAME) ? '<span class="inputRequirement">' . ENTRY_STORE_NAME . '</span>': ''); ?></td>
                <td class="main"></td>
              </tr>
              <tr>
                <td class="main"><?php echo TEXT_STORES_IMAGE; ?></td>
                <td class="main"><?php echo  smn_draw_file_field('store_image'). '&nbsp;<br>' .(smn_not_null(ENTRY_LOGO_TEXT) ? '<span class="inputRequirement">' . sprintf(ENTRY_LOGO_TEXT, MAX_IMAGE_FILE_SIZE) . '</span>': ''); ?></td>
              </tr>
              
<?php
        }
?>               
              <tr>
                <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
             </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">

          <tr class="infoBoxContents">

            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">

              <tr>

                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>

                <td><?php echo '<a href="' . smn_href_link(FILENAME_ACCOUNT, '', 'NONSSL') . '">' . smn_image_button('button_back.gif', IMAGE_BUTTON_BACK) . '</a>'; ?></td>

                <td align="right"><?php echo smn_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE); ?></td>

                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>

              </tr>

            </table></td>

          </tr>

        </table></td>

      </tr>

    </table></form>