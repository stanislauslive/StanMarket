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
    <?php echo smn_draw_form('create_account', smn_href_link(FILENAME_CREATE_FINANCIAL_ACCOUNT, '', 'NONSSL'), 'post', 'onSubmit="return check_form(create_account);"') . smn_draw_hidden_field('action', 'process'); ?><table border="0" width="100%" cellspacing="0" cellpadding="0">
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
  if ($messageStack->size('create_financial_account') > 0) {
?>
      <tr>
        <td><?php echo $messageStack->output('create_financial_account'); ?></td>
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
            <td class="main"><b><?php echo CATEGORY_FINANCIAL_INFORMATION; ?></b></td>
           <td class="inputRequirement" align="right"><?php echo FORM_REQUIRED_INFORMATION; ?></td>
          </tr>
        </table></td>
      </tr>
        
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
                <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
              </tr>
              <tr>
                <td class="main"><?php echo ENTRY_BANK_NAME; ?></td>
                <td class="main"><?php echo smn_draw_input_field('bank_name') . '&nbsp;' . (smn_not_null(ENTRY_BANK_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_BANK_NAME_TEXT . '</span>': ''); ?></td>
              </tr>
                <tr>
                    <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                </tr>       
              <tr>
                <td class="main"><?php echo ENTRY_BANK_ROUTING_CODE; ?></td>
                <td class="main"><?php echo smn_draw_input_field('bank_routing_code') . '&nbsp;' . (smn_not_null(ENTRY_BANK_ROUTING_CODE_TEXT) ? '<span class="inputRequirement">' . ENTRY_BANK_ROUTING_CODE_TEXT . '</span>': ''); ?></td>
              </tr>
              <tr>
                    <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                </tr>
              <tr>
                <td class="main"><?php echo ENTRY_BANK_ACCOUNT_NUMBER; ?></td>
                <td class="main"><?php echo smn_draw_input_field('bank_account_number') . '&nbsp;' . (smn_not_null(ENTRY_BANK_ACCOUNT_NUMBER_TEXT) ? '<span class="inputRequirement">' . ENTRY_BANK_ACCOUNT_NUMBER_TEXT . '</span>': ''); ?></td>
              </tr>
              <tr>
                    <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                </tr>
                </td>
              </tr>
            </table></td>
          </tr>
        </table></td>          
      <tr>
         <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php      
if (ACCOUNT_CC == 'true')      
      {
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main"><b><?php echo CATEGORY_CREDIT_CARD_INFORMATION; ?></b></td>
           <td class="inputRequirement" align="right"><?php echo FORM_OPTIONAL_INFORMATION; ?></td>
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
                <td width="10">               
              <tr>
                <td class="main"><?php echo ENTRY_CC_NUMBER; ?></td>
                <td class="main"><?php echo smn_draw_input_field('cc_number') . '&nbsp;' . (smn_not_null(ENTRY_CC_NUMBER_TEXT) ? '<span class="inputRequirement">' . ENTRY_CC_NUMBER_TEXT . '</span>': ''); ?></td>
              </tr>
              <tr>
                <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
              </tr>
              <tr>
                <td class="main"><?php echo ENTRY_CVV2_CODE; ?></td>
                <td class="main"><?php echo smn_draw_input_field('cvv2') . '&nbsp;' . (smn_not_null(ENTRY_CVV2_CODE_TEXT) ? '<span class="inputRequirement">' . ENTRY_CVV2_CODE_TEXT . '</span>': ''); ?></td>
              </tr>
              <tr>
                    <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                </tr>
              <tr>
                <td class="main"><?php echo ENTRY_CC_EXPIRY_DATE; ?></td>
                <td class="main"><?php echo smn_draw_input_field('expiry_date') . '&nbsp;' . (smn_not_null(ENTRY_CC_EXPIRY_DATE_TEXT) ? '<span class="inputRequirement">' . ENTRY_CC_EXPIRY_DATE_TEXT . '</span>': ''); ?></td>
              </tr>
              <tr>
                    <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                </tr>
                </td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
         <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
      }
if (ACCOUNT_BANK_ADDRESS == 'true')      
      {
?>      
      
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main"><b><?php echo CATEGORY_BANK_ADDRESS_INFORMATION; ?></b></td>
           <td class="inputRequirement" align="right"><?php echo FORM_OPTIONAL_INFORMATION; ?></td>
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
                <td width="10">
                
                <tr>
                    <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                </tr>       
              <tr>
                <td class="main"><?php echo ENTRY_BANK_REP_FIRST_NAME; ?></td>
                <td class="main"><?php echo smn_draw_input_field('firstname') . '&nbsp;' . (smn_not_null(ENTRY_BANK_REP_FIRST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_BANK_REP_FIRST_NAME_TEXT . '</span>': ''); ?></td>
              </tr>
                <tr>
                    <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                </tr>            
              <tr>
                <td class="main"><?php echo ENTRY_BANK_LAST_NAME; ?></td>
                <td class="main"><?php echo smn_draw_input_field('lastname') . '&nbsp;' . (smn_not_null(ENTRY_BANK_REP_LAST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_BANK_REP_LAST_NAME_TEXT . '</span>': ''); ?></td>
              </tr>
                <tr>
                    <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                </tr>                
              <tr>
                <td class="main"><?php echo ENTRY_BANK_TELEPHONE_NUMBER; ?></td>
                <td class="main"><?php echo smn_draw_input_field('telephone') . '&nbsp;' . (smn_not_null(ENTRY_BANK_TELEPHONE_NUMBER_TEXT) ? '<span class="inputRequirement">' . ENTRY_BANK_TELEPHONE_NUMBER_TEXT . '</span>': ''); ?></td>
              </tr>
              <tr>
                <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
              </tr>              
              <tr>
                <td class="main"><?php echo ENTRY_BANK_STREET_ADDRESS; ?></td>
                <td class="main"><?php echo smn_draw_input_field('street_address') . '&nbsp;' . (smn_not_null(ENTRY_BANK_STREET_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_BANK_STREET_ADDRESS_TEXT . '</span>': ''); ?></td>
              </tr>
             <tr>
                    <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                </tr>
              <tr>
                <td class="main"><?php echo ENTRY_BANK_POST_CODE; ?></td>
                <td class="main"><?php echo smn_draw_input_field('postcode') . '&nbsp;' . (smn_not_null(ENTRY_BANK_POST_CODE_TEXT) ? '<span class="inputRequirement">' . ENTRY_BANK_POST_CODE_TEXT . '</span>': ''); ?></td>
              </tr>
             <tr>
                    <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                </tr>
              <tr>
                <td class="main"><?php echo ENTRY_BANK_CITY; ?></td>
                <td class="main"><?php echo smn_draw_input_field('city') . '&nbsp;' . (smn_not_null(ENTRY_BANK_CITY_TEXT) ? '<span class="inputRequirement">' . ENTRY_BANK_CITY_TEXT . '</span>': ''); ?></td>
              </tr>
             <tr>
                    <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                </tr>
<?php
  if (ACCOUNT_STATE == 'true') {
?>
              <tr>
                <td class="main"><?php echo ENTRY_BANK_STATE; ?></td>
                <td class="main">
<?php
    if ($process == true) {
      if ($entry_state_has_zones == true) {
        $zones_array = array();
        $zones_query = smn_db_query("select zone_name from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country . "' order by zone_name");
        while ($zones_values = smn_db_fetch_array($zones_query)) {
          $zones_array[] = array('id' => $zones_values['zone_name'], 'text' => $zones_values['zone_name']);
        }
        echo smn_draw_pull_down_menu('state', $zones_array);
      } else {
        echo smn_draw_input_field('state');
      }
    } else {
      echo smn_draw_input_field('state');
    }

    if (smn_not_null(ENTRY_BANK_STATE_TEXT)) echo '&nbsp;<span class="inputRequirement">' . ENTRY_BANK_STATE_TEXT;
?>
                </td>
              </tr>
<?php
  }
?>
            </table></td>
          </tr>
        </table></td>
      </tr>
<?php
    }
?>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>  
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td><?php echo smn_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE); ?></td>
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></form></td>