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

  if (!isset($is_read_only)) $is_read_only = false;
  if (!isset($processed)) $processed = false;
?>
<table border="0" width="100%" cellspacing="0" cellpadding="2">
   <tr>
    <td class="formAreaTitle"><?php echo MESSAGE_AGENT; ?></td>
  </tr>
    <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
  <tr>
    <td class="formAreaTitle"><?php echo CATEGORY_PERSONAL; ?></td>
  </tr>
  <tr>
    <td class="main"><table border="0" width="100%" cellspacing="0" cellpadding="2" class="formArea">
      <tr>
        <td class="main"><table border="0" cellspacing="0" cellpadding="2">
<?php
  if (ACCOUNT_GENDER == 'true') {
    $male = ($affiliate['affiliate_gender'] == 'm') ? true : false;
    $female = ($affiliate['affiliate_gender'] == 'f') ? true : false;
?>
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_GENDER; ?></td>
            <td class="main">&nbsp;
<?php
    if ($is_read_only == true) {
      echo ($affiliate['affiliate_gender'] == 'm') ? MALE : FEMALE;
    } elseif ($error == true) {
      if ($entry_gender_error == true) {
        echo smn_draw_radio_field('a_gender', 'm', $male) . '&nbsp;&nbsp;' . MALE . '&nbsp;&nbsp;' . smn_draw_radio_field('a_gender', 'f', $female) . '&nbsp;&nbsp;' . FEMALE . '&nbsp;' . ENTRY_GENDER_ERROR;
      } else {
        echo ($a_gender == 'm') ? MALE : FEMALE;
        echo smn_draw_hidden_field('a_gender');
      }
    } else {
      echo smn_draw_radio_field('a_gender', 'm', $male) . '&nbsp;&nbsp;' . MALE . '&nbsp;&nbsp;' . smn_draw_radio_field('a_gender', 'f', $female) . '&nbsp;&nbsp;' . FEMALE . '&nbsp;' . ENTRY_GENDER_TEXT;
    }
?>
            </td>
          </tr>
<?php
  }
?>
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_FIRST_NAME; ?></td>
            <td class="main">&nbsp;
<?php
  if ($is_read_only == true) {
    echo $affiliate['affiliate_firstname'];
  } elseif ($error == true) {
    if ($entry_firstname_error == true) {
      echo smn_draw_input_field('a_firstname') . '&nbsp;' . ENTRY_FIRST_NAME_ERROR;
    } else {
      echo $a_firstname . smn_draw_hidden_field('a_firstname');
    }
  } else {
    echo smn_draw_input_field('a_firstname', $affiliate['affiliate_firstname']) . '&nbsp;' . ENTRY_FIRST_NAME_TEXT;
  }
?>
            </td>
          </tr>
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_LAST_NAME; ?></td>
            <td class="main">&nbsp;
<?php
  if ($is_read_only == true) {
    echo $affiliate['affiliate_lastname'];
  } elseif ($error == true) {
    if ($entry_lastname_error == true) {
      echo smn_draw_input_field('a_lastname') . '&nbsp;' . ENTRY_LAST_NAME_ERROR;
    } else {
      echo $a_lastname . smn_draw_hidden_field('a_lastname');
    }
  } else {
    echo smn_draw_input_field('a_lastname', $affiliate['affiliate_lastname']) . '&nbsp;' . ENTRY_FIRST_NAME_TEXT;
  }
?>
            </td>
          </tr>
<!--Changed the dob field to drop down menu,By Cimi-->
<!--<?php
  //if (ACCOUNT_DOB == 'true') {
?>
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_DATE_OF_BIRTH; ?></td>
            <td class="main">&nbsp;
<?php
/*    if ($is_read_only == true) {
      echo smn_date_short($affiliate['affiliate_dob']);
    } elseif ($error == true) {
      if ($entry_date_of_birth_error == true) {
        echo smn_draw_input_field('a_dob') . '&nbsp;' . ENTRY_DATE_OF_BIRTH_ERROR;
      } else {
        echo $a_dob . smn_draw_hidden_field('a_dob');
      }
    } else {
      echo smn_draw_input_field('a_dob', smn_date_short($affiliate['affiliate_dob'])) . '&nbsp;' . ENTRY_DATE_OF_BIRTH_TEXT;
    }
*/?>
            </td>
          </tr>
<?php
  //}
?>
--> 
<?php
  if (ACCOUNT_DOB == 'true') {
?>
              <tr>
                <td class="main"><?php echo ENTRY_DATE_OF_BIRTH; ?></td>
                
                <td class="main">&nbsp;&nbsp;<?php 
                
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
                
                echo smn_draw_pull_down_menu('dob_day', $day_drop_down_array) . '&nbsp;' . smn_draw_pull_down_menu('dob_month', $month_drop_down_array) . '&nbsp;' . smn_draw_pull_down_menu('dob_year', $year_drop_down_array) . '&nbsp;' . (smn_not_null(ENTRY_DATE_OF_BIRTH_TEXT) ? '<span class="inputRequirement">' . ENTRY_DATE_OF_BIRTH_TEXT . '</span>': NOT_REQUIRED_TEXT); 
                
                ?></td>
              </tr>
<?php
  }
?>

          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_EMAIL_ADDRESS; ?></td>
            <td class="main">&nbsp;
<?php
  if ($is_read_only == true) {
    echo $affiliate['affiliate_email_address'];
  } elseif ($error == true) {
    if ($entry_email_address_error == true) {
      echo smn_draw_input_field('a_email_address') . '&nbsp;' . ENTRY_EMAIL_ADDRESS_ERROR;
    } elseif ($entry_email_address_check_error == true) {
      echo smn_draw_input_field('a_email_address') . '&nbsp;' . ENTRY_EMAIL_ADDRESS_CHECK_ERROR;
    } elseif ($entry_email_address_exists == true) {
      echo smn_draw_input_field('a_email_address') . '&nbsp;' . ENTRY_EMAIL_ADDRESS_ERROR_EXISTS;
    } else {
      echo $a_email_address . smn_draw_hidden_field('a_email_address');
    }
  } else {
    echo smn_draw_input_field('a_email_address', $affiliate['affiliate_email_address']) . '&nbsp;' . ENTRY_EMAIL_ADDRESS_TEXT;
  }
?>
            </td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
<?php
  if (ACCOUNT_COMPANY == 'true') {
?>  
  <tr>
    <td class="formAreaTitle"><br><?php echo CATEGORY_COMPANY; ?></td>
  </tr>
  <tr>
    <td class="main"><table border="0" width="100%" cellspacing="0" cellpadding="2" class="formArea">
      <tr>
        <td class="main"><table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_AFFILIATE_COMPANY; ?></td>
            <td class="main">&nbsp;
<?php
    if ($is_read_only == true) {
      echo $affiliate['affiliate_company'];
    } elseif ($error == true) {
      if ($entry_company_error == true) {
        echo smn_draw_input_field('a_company') . '&nbsp;' . ENTRY_AFFILIATE_COMPANY_ERROR;
      } else {
        echo $a_company . smn_draw_hidden_field('a_company');
      }
    } else {
      echo smn_draw_input_field('a_company', $affiliate['affiliate_company']) . '&nbsp;' . ENTRY_AFFILIATE_COMPANY_TEXT;
    }
?>
            </td>
          </tr>
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_AFFILIATE_COMPANY_TAXID; ?></td>
            <td class="main">&nbsp;
<?php
    if ($is_read_only == true) {
      echo $affiliate['affiliate_company_taxid'];
    } elseif ($error == true) {
      if ($entry_company_taxid_error == true) {
        echo smn_draw_input_field('a_company_taxid') . '&nbsp;' . ENTRY_AFFILIATE_COMPANY_TAXID_ERROR;
      } else {
        echo $a_company_taxid . smn_draw_hidden_field('a_company_taxid');
      }
    } else {
      echo smn_draw_input_field('a_company_taxid', $affiliate['affiliate_company_taxid']) . '&nbsp;' . ENTRY_AFFILIATE_COMPANY_TAXID_TEXT;
    }
?>
            </td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
<?php
  }
?>  

  <tr>
    <td class="formAreaTitle"><br><?php echo CATEGORY_ADDRESS; ?></td>
  </tr>
  <tr>
    <td class="main"><table border="0" width="100%" cellspacing="0" cellpadding="2" class="formArea">
      <tr>
        <td class="main"><table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_STREET_ADDRESS; ?></td>
            <td class="main">&nbsp;
<?php
  if ($is_read_only == true) {
    echo $affiliate['affiliate_street_address'];
  } elseif ($error == true) {
    if ($entry_street_address_error == true) {
      echo smn_draw_input_field('a_street_address') . '&nbsp;' . ENTRY_STREET_ADDRESS_ERROR;
    } else {
      echo $a_street_address . smn_draw_hidden_field('a_street_address');
    }
  } else {
    echo smn_draw_input_field('a_street_address', $affiliate['affiliate_street_address']) . '&nbsp;' . ENTRY_STREET_ADDRESS_TEXT;
  }
?>
            </td>
          </tr>
<?php
  if (ACCOUNT_SUBURB == 'true') {
?>
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_SUBURB; ?></td>
            <td class="main">&nbsp;
<?php
    if ($is_read_only == true) {
      echo $affiliate['affiliate_suburb'];
    } elseif ($error == true) {
      if ($entry_suburb_error == true) {
        echo smn_draw_input_field('a_suburb') . '&nbsp;' . ENTRY_SUBURB_ERROR;
      } else {
        echo $a_suburb . smn_draw_hidden_field('a_suburb');
      }
    } else {
      echo smn_draw_input_field('a_suburb', $affiliate['affiliate_suburb']) . '&nbsp;' . ENTRY_SUBURB_TEXT;
    }
?>
            </td>
          </tr>
<?php
  }
?>
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_POST_CODE; ?></td>
            <td class="main">&nbsp;
<?php
  if ($is_read_only == true) {
    echo $affiliate['affiliate_postcode'];
  } elseif ($error == true) {
    if ($entry_post_code_error == true) {
      echo smn_draw_input_field('a_postcode') . '&nbsp;' . ENTRY_POST_CODE_ERROR;
    } else {
      echo $a_postcode . smn_draw_hidden_field('a_postcode');
    }
  } else {
    echo smn_draw_input_field('a_postcode', $affiliate['affiliate_postcode']) . '&nbsp;' . ENTRY_POST_CODE_TEXT;
  }
?>
            </td>
          </tr>
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_CITY; ?></td>
            <td class="main">&nbsp;
<?php
  if ($is_read_only == true) {
    echo $affiliate['affiliate_city'];
  } elseif ($error == true) {
    if ($entry_city_error == true) {
      echo smn_draw_input_field('a_city') . '&nbsp;' . ENTRY_CITY_ERROR;
    } else {
      echo $a_city . smn_draw_hidden_field('a_city');
    }
  } else {
    echo smn_draw_input_field('a_city', $affiliate['affiliate_city']) . '&nbsp;' . ENTRY_CITY_TEXT;
  }
?>
            </td>
          </tr>
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_COUNTRY; ?></td>
            <td class="main">&nbsp;
<?php
  if ($is_read_only == true) {
    echo smn_get_country_name($affiliate['affiliate_country_id']);
  } elseif ($error == true) {
    if ($entry_country_error == true) {
      echo smn_get_country_list('a_country') . '&nbsp;' . ENTRY_COUNTRY_ERROR;
    } else {
      echo smn_get_country_name($a_country) . smn_draw_hidden_field('a_country');
    }
  } else {
    echo smn_get_country_list('a_country', $affiliate['affiliate_country_id']) . '&nbsp;' . ENTRY_COUNTRY_TEXT;
  }
?>
            </td>
          </tr>
<?php
  if (ACCOUNT_STATE == 'true') {
?>
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_STATE; ?></td>
            <td class="main">&nbsp;
<?php
    $state = smn_get_zone_name($a_country, $a_zone_id, $a_state);
    if ($is_read_only == true) {
      echo smn_get_zone_name($affiliate['affiliate_country_id'], $affiliate['affiliate_zone_id'], $affiliate['affiliate_state']);
    } elseif ($error == true) {
      if ($entry_state_error == true) {
        if ($entry_state_has_zones == true) {
          $zones_array = array();
          $zones_query = smn_db_query("select zone_name from " . TABLE_ZONES . " where zone_country_id = '" . smn_db_input($a_country) . "' order by zone_name");
          while ($zones_values = smn_db_fetch_array($zones_query)) {
            $zones_array[] = array('id' => $zones_values['zone_name'], 'text' => $zones_values['zone_name']);
          }
          echo smn_draw_pull_down_menu('a_state', $zones_array) . '&nbsp;' . ENTRY_STATE_ERROR;
        } else {
          echo smn_draw_input_field('a_state') . '&nbsp;' . ENTRY_STATE_ERROR;
        }
      } else {
        echo $state . smn_draw_hidden_field('a_zone_id') . smn_draw_hidden_field('a_state');
      }
    } else {
      echo smn_draw_input_field('a_state', smn_get_zone_name($affiliate['affiliate_country_id'], $affiliate['affiliate_zone_id'], $affiliate['affiliate_state'])) . '&nbsp;' . ENTRY_STATE_TEXT;
    }
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
  <tr>
    <td class="formAreaTitle"><br><?php echo CATEGORY_CONTACT; ?></td>
  </tr>
  <tr>
    <td class="main"><table border="0" width="100%" cellspacing="0" cellpadding="2" class="formArea">
      <tr>
        <td class="main"><table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_TELEPHONE_NUMBER; ?></td>
            <td class="main">&nbsp;
<?php
  if ($is_read_only == true) {
    echo $affiliate['affiliate_telephone'];
  } elseif ($error == true) {
    if ($entry_telephone_error == true) {
      echo smn_draw_input_field('a_telephone') . '&nbsp;' . ENTRY_TELEPHONE_NUMBER_ERROR;
    } else {
      echo $a_telephone . smn_draw_hidden_field('a_telephone');
    }
  } else {
    echo smn_draw_input_field('a_telephone', $affiliate['affiliate_telephone']) . '&nbsp;' . ENTRY_TELEPHONE_NUMBER_TEXT;
  }
?>
            </td>
          </tr>
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_FAX_NUMBER; ?></td>
            <td class="main">&nbsp;
<?php
  if ($is_read_only == true) {
    echo $affiliate['affiliate_fax'];
  } elseif ($error == true) {
    if ($entry_fax_error == true) {
      echo smn_draw_input_field('a_fax') . '&nbsp;' . ENTRY_FAX_NUMBER_ERROR;
    } else {
      echo $a_fax . smn_draw_hidden_field('a_fax');
    }
  } else {
    echo smn_draw_input_field('a_fax', $affiliate['affiliate_fax']) . '&nbsp;' . ENTRY_FAX_NUMBER_TEXT;
  }
?>
            </td>
          </tr>
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_AFFILIATE_HOMEPAGE; ?></td>
            <td class="main">&nbsp;
<?php
  if ($is_read_only == true) {
    echo $affiliate['affiliate_homepage'];
  } elseif ($error == true) {
    if ($entry_homepage_error == true) {
      echo smn_draw_input_field('a_homepage') . '&nbsp;' . ENTRY_AFFILIATE_HOMEPAGE_ERROR;
    } else {
      echo $a_homepage . smn_draw_hidden_field('a_homepage');
    }
  } else {
    echo smn_draw_input_field('a_homepage', $affiliate['affiliate_homepage']) . '&nbsp;' . ENTRY_AFFILIATE_HOMEPAGE_TEXT;
  }
?>
            </td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
<?php
  if ($is_read_only == false) {
?>
  <tr>
    <td class="formAreaTitle"><br><?php echo CATEGORY_PASSWORD; ?></td>
  </tr>
  <tr>
    <td class="main"><table border="0" width="100%" cellspacing="0" cellpadding="2" class="formArea">
      <tr>
        <td class="main"><table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_PASSWORD; ?></td>
            <td class="main">&nbsp;
<?php
    if ($error == true) {
      if ($entry_password_error == true) {
        echo smn_draw_password_field('a_password') . '&nbsp;' . ENTRY_PASSWORD_ERROR;
      } else {
        echo PASSWORD_HIDDEN . smn_draw_hidden_field('a_password') . smn_draw_hidden_field('a_confirmation');
      }
    } else {
      echo smn_draw_password_field('a_password') . '&nbsp;' . ENTRY_PASSWORD_TEXT;
    }
?>
            </td>
          </tr>
<?php
    if ( ($error == false) || ($entry_password_error == true) ) {
?>
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_PASSWORD_CONFIRMATION; ?></td>
            <td class="main">&nbsp;
<?php
      echo smn_draw_password_field('a_confirmation') . '&nbsp;' . ENTRY_PASSWORD_CONFIRMATION_TEXT;
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
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><b><?php echo CATEGORY_OPTIONS; ?></b></td>
      </tr>
  <tr>
    <td class="main"><table border="0" width="100%" cellspacing="0" cellpadding="2" class="formArea">
      <tr>
        <td class="main"><table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_AFFILIATE_NEWSLETTER; ?></td>
            <td class="main">&nbsp;
<?php
  if ($is_read_only == true) {
    echo $affiliate['affiliate_newsletter'];
  } elseif ($error == true) {
    if ($entry_newsletter_error == true) {
      echo smn_draw_checkbox_field('a_newsletter', '1') . '&nbsp;' . ENTRY_AFFILIATE_NEWSLETTER_ERROR;
    } else {
      echo $a_newsletter . smn_draw_checkbox_field('a_newsletter', '1');
    }
  } else {
    echo smn_draw_checkbox_field('a_newsletter', '1', $affiliate['affiliate_newsletter']) . '&nbsp;' . ENTRY_AFFILIATE_NEWSLETTER_TEXT;
  }
?>
            </td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="formAreaTitle"><br></td>
  </tr>
  <tr>
    <td class="main"><table border="0" width="100%" cellspacing="0" cellpadding="2" class="formArea">
      <tr>
        <td class="main"><table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main">&nbsp;</td>
            <td class="main">&nbsp;
<?php 
	echo smn_draw_checkbox_field('a_agb', $value = '1', $checked = $affiliate['affiliate_agb']) . ENTRY_AFFILIATE_ACCEPT_AGB . '<b>' . ENTRY_AFFILIATE_ACCEPT_AGB_TEXT . '</b>';
    if ($entry_agb_error == true) {
      echo "<br>".ENTRY_AFFILIATE_AGB_ERROR;
    }
?>
            </td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
<?php
  }
?>
</table>