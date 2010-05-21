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
    <td class="formAreaTitle"><?php echo CATEGORY_PERSONAL; ?></td>
  </tr>
  <tr>
    <td class="main"><table border="0" width="100%" cellspacing="0" cellpadding="2" class="formArea">
      <tr>
        <td class="main"><table border="0" cellspacing="0" cellpadding="2">
<?php
  if (ACCOUNT_GENDER == 'true') {
    $male = ($affiliate['customers_gender'] == 'm') ? true : false;
    $female = ($affiliate['customers_gender'] == 'f') ? true : false;
?>
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_GENDER; ?></td>
            <td class="main">&nbsp;
<?php
    if ($is_read_only == true) {
      echo ($affiliate['customers_gender'] == 'm') ? MALE : FEMALE;
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
    echo $affiliate['customers_firstname'];
  } elseif ($error == true) {
    if ($entry_firstname_error == true) {
      echo smn_draw_input_field('a_firstname') . '&nbsp;' . ENTRY_FIRST_NAME_ERROR;
    } else {
      echo $a_firstname . smn_draw_hidden_field('a_firstname');
    }
  } else {
    echo smn_draw_input_field('a_firstname', $affiliate['customers_firstname']) . '&nbsp;' . ENTRY_FIRST_NAME_TEXT;
  }
?>
            </td>
          </tr>
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_LAST_NAME; ?></td>
            <td class="main">&nbsp;
<?php
  if ($is_read_only == true) {
    echo $affiliate['customers_lastname'];
  } elseif ($error == true) {
    if ($entry_lastname_error == true) {
      echo smn_draw_input_field('a_lastname') . '&nbsp;' . ENTRY_LAST_NAME_ERROR;
    } else {
      echo $a_lastname . smn_draw_hidden_field('a_lastname');
    }
  } else {
    echo smn_draw_input_field('a_lastname', $affiliate['customers_lastname']) . '&nbsp;' . ENTRY_FIRST_NAME_TEXT;
  }
?>
            </td>
          </tr>
<?php
  if (ACCOUNT_DOB == 'true') {
?>
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_DATE_OF_BIRTH; ?></td>
            <td class="main">&nbsp;
<?php
      echo $affiliate['customers_dob'];
      echo smn_draw_hidden_field('a_dob', $affiliate['customers_dob']);
?>
            </td>
          </tr>
<?php
  }
?>
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_EMAIL_ADDRESS; ?></td>
            <td class="main">&nbsp;
<?php
  if ($is_read_only == true) {
    echo $affiliate['customers_email_address'];
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
    echo smn_draw_input_field('a_email_address', $affiliate['customers_email_address']) . '&nbsp;' . ENTRY_EMAIL_ADDRESS_TEXT;
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
      echo $affiliate['entry_company'];
    } elseif ($error == true) {
      if ($entry_company_error == true) {
        echo smn_draw_input_field('a_company') . '&nbsp;' . ENTRY_AFFILIATE_COMPANY_ERROR;
      } else {
        echo $a_company . smn_draw_hidden_field('a_company');
      }
    } else {
      echo smn_draw_input_field('a_company', $affiliate['entry_company']) . '&nbsp;' . ENTRY_AFFILIATE_COMPANY_TEXT;
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
    <td class="formAreaTitle"><br><?php echo CATEGORY_PAYMENT_DETAILS; ?></td>
  </tr>
  <tr>
    <td class="main"><table border="0" width="100%" cellspacing="0" cellpadding="2" class="formArea">
      <tr>
        <td class="main"><table border="0" cellspacing="0" cellpadding="2">
<?php
  if (AFFILIATE_USE_CHECK == 'true') {
?>  
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_AFFILIATE_PAYMENT_CHECK; ?></td>
            <td class="main">&nbsp;
<?php
    if ($is_read_only == true) {
      echo $affiliate['affiliate_payment_check'];
    } elseif ($error == true) {
      if ($entry_payment_check_error == true) {
        echo smn_draw_input_field('a_payment_check') . '&nbsp;' . ENTRY_AFFILIATE_PAYMENT_CHECK_ERROR;
      } else {
        echo $a_payment_check . smn_draw_hidden_field('a_payment_check');
      }
    } else {
      echo smn_draw_input_field('a_payment_check', $affiliate['affiliate_payment_check']) . '&nbsp;' . ENTRY_AFFILIATE_PAYMENT_CHECK_TEXT;
    }
?>
            </td>
          </tr>
<?php
  }
  if (AFFILIATE_USE_PAYPAL == 'true') {
?>  
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_AFFILIATE_PAYMENT_PAYPAL; ?></td>
            <td class="main">&nbsp;
<?php
    if ($is_read_only == true) {
      echo $affiliate['affiliate_payment_paypal'];
    } elseif ($error == true) {
      if ($entry_payment_paypal_error == true) {
        echo smn_draw_input_field('a_payment_paypal') . '&nbsp;' . ENTRY_AFFILIATE_PAYMENT_PAYPAL_ERROR;
      } else {
        echo $a_payment_paypal . smn_draw_hidden_field('a_payment_paypal');
      }
    } else {
      echo smn_draw_input_field('a_payment_paypal', $affiliate['affiliate_payment_paypal']) . '&nbsp;' . ENTRY_AFFILIATE_PAYMENT_PAYPAL_TEXT;
    }
?>
            </td>
          </tr>
<?php
  }
  if (AFFILIATE_USE_BANK == 'true') {
?>  
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_AFFILIATE_PAYMENT_BANK_NAME; ?></td>
            <td class="main">&nbsp;
<?php
    if ($is_read_only == true) {
      echo $affiliate['affiliate_payment_bank_name'];
    } elseif ($error == true) {
      if ($entry_payment_bank_name_error == true) {
        echo smn_draw_input_field('a_payment_bank_name') . '&nbsp;' . ENTRY_AFFILIATE_PAYMENT_BANK_NAME_ERROR;
      } else {
        echo $a_payment_bank_name . smn_draw_hidden_field('a_payment_bank_name');
      }
    } else {
      echo smn_draw_input_field('a_payment_bank_name', $affiliate['affiliate_payment_bank_name']) . '&nbsp;' . ENTRY_AFFILIATE_PAYMENT_BANK_NAME_TEXT;
    }
?>
            </td>
          </tr>
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_AFFILIATE_PAYMENT_BANK_BRANCH_NUMBER; ?></td>
            <td class="main">&nbsp;
<?php
    if ($is_read_only == true) {
      echo $affiliate['affiliate_payment_bank_branch_number'];
    } elseif ($error == true) {
      if ($entry_payment_bank_branch_number_error == true) {
        echo smn_draw_input_field('a_payment_bank_branch_number') . '&nbsp;' . ENTRY_AFFILIATE_PAYMENT_BANK_BRANCH_NUMBER_ERROR;
      } else {
        echo $a_payment_bank_branch_number . smn_draw_hidden_field('a_payment_bank_branch_number');
      }
    } else {
      echo smn_draw_input_field('a_payment_bank_branch_number', $affiliate['affiliate_payment_bank_branch_number']) . '&nbsp;' . ENTRY_AFFILIATE_PAYMENT_BANK_BRANCH_NUMBER_TEXT;
    }
?>
            </td>
          </tr>
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_AFFILIATE_PAYMENT_BANK_SWIFT_CODE; ?></td>
            <td class="main">&nbsp;
<?php
    if ($is_read_only == true) {
      echo $affiliate['affiliate_payment_bank_swift_code'];
    } elseif ($error == true) {
      if ($entry_payment_bank_swift_code_error == true) {
        echo smn_draw_input_field('a_payment_bank_swift_code') . '&nbsp;' . ENTRY_AFFILIATE_PAYMENT_BANK_SWIFT_CODE_ERROR;
      } else {
        echo $a_payment_bank_swift_code . smn_draw_hidden_field('a_payment_bank_swift_code');
      }
    } else {
      echo smn_draw_input_field('a_payment_bank_swift_code', $affiliate['affiliate_payment_bank_swift_code']) . '&nbsp;' . ENTRY_AFFILIATE_PAYMENT_BANK_SWIFT_CODE_TEXT;
    }
?>
            </td>
          </tr>
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_AFFILIATE_PAYMENT_BANK_ACCOUNT_NAME; ?></td>
            <td class="main">&nbsp;
<?php
    if ($is_read_only == true) {
      echo $affiliate['affiliate_payment_bank_account_name'];
    } elseif ($error == true) {
      if ($entry_payment_bank_account_name_error == true) {
        echo smn_draw_input_field('a_payment_bank_account_name') . '&nbsp;' . ENTRY_AFFILIATE_PAYMENT_BANK_ACCOUNT_NAME_ERROR;
      } else {
        echo $a_payment_bank_account_name . smn_draw_hidden_field('a_payment_bank_account_name');
      }
    } else {
      echo smn_draw_input_field('a_payment_bank_account_name', $affiliate['affiliate_payment_bank_account_name']) . '&nbsp;' . ENTRY_AFFILIATE_PAYMENT_BANK_ACCOUNT_NAME_TEXT;
    }
?>
            </td>
          </tr>
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_AFFILIATE_PAYMENT_BANK_ACCOUNT_NUMBER; ?></td>
            <td class="main">&nbsp;
<?php
    if ($is_read_only == true) {
      echo $affiliate['affiliate_payment_bank_account_number'];
    } elseif ($error == true) {
      if ($entry_payment_bank_account_number_error == true) {
        echo smn_draw_input_field('a_payment_bank_account_number') . '&nbsp;' . ENTRY_AFFILIATE_PAYMENT_BANK_ACCOUNT_NUMBER_ERROR;
      } else {
        echo $a_payment_bank_account_number . smn_draw_hidden_field('a_payment_bank_account_number');
      }
    } else {
      echo smn_draw_input_field('a_payment_bank_account_number', $affiliate['affiliate_payment_bank_account_number']) . '&nbsp;' . ENTRY_AFFILIATE_PAYMENT_BANK_ACCOUNT_NUMBER_TEXT;
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
    echo $affiliate['entry_street_address'];
  } elseif ($error == true) {
    if ($entry_street_address_error == true) {
      echo smn_draw_input_field('a_street_address') . '&nbsp;' . ENTRY_STREET_ADDRESS_ERROR;
    } else {
      echo $a_street_address . smn_draw_hidden_field('a_street_address');
    }
  } else {
    echo smn_draw_input_field('a_street_address', $affiliate['entry_street_address']) . '&nbsp;' . ENTRY_STREET_ADDRESS_TEXT;
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
    echo $affiliate['entry_postcode'];
  } elseif ($error == true) {
    if ($entry_post_code_error == true) {
      echo smn_draw_input_field('a_postcode') . '&nbsp;' . ENTRY_POST_CODE_ERROR;
    } else {
      echo $a_postcode . smn_draw_hidden_field('a_postcode');
    }
  } else {
    echo smn_draw_input_field('a_postcode', $affiliate['entry_postcode']) . '&nbsp;' . ENTRY_POST_CODE_TEXT;
  }
?>
            </td>
          </tr>
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_CITY; ?></td>
            <td class="main">&nbsp;
<?php
  if ($is_read_only == true) {
    echo $affiliate['entry_city'];
  } elseif ($error == true) {
    if ($entry_city_error == true) {
      echo smn_draw_input_field('a_city') . '&nbsp;' . ENTRY_CITY_ERROR;
    } else {
      echo $a_city . smn_draw_hidden_field('a_city');
    }
  } else {
    echo smn_draw_input_field('a_city', $affiliate['entry_city']) . '&nbsp;' . ENTRY_CITY_TEXT;
  }
?>
            </td>
          </tr>
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_COUNTRY; ?></td>
            <td class="main">&nbsp;
<?php
  if ($is_read_only == true) {
    echo smn_get_country_name($affiliate['entry_country_id']);
  } elseif ($error == true) {
    if ($entry_country_error == true) {
      echo smn_get_country_list('a_country') . '&nbsp;' . ENTRY_COUNTRY_ERROR;
    } else {
      echo smn_get_country_name($a_country) . smn_draw_hidden_field('a_country');
    }
  } else {
    echo smn_get_country_list('a_country', $affiliate['entry_country_id']) . '&nbsp;' . ENTRY_COUNTRY_TEXT;
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
      echo smn_get_zone_name($affiliate['entry_country_id'], $affiliate['entry_zone_id'], $affiliate['entry_state']);
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
      echo smn_draw_input_field('a_state', smn_get_zone_name($affiliate['entry_country_id'], $affiliate['entry_zone_id'], $affiliate['entry_state'])) . '&nbsp;' . ENTRY_STATE_TEXT;
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
    echo $affiliate['customers_telephone'];
  } elseif ($error == true) {
    if ($entry_telephone_error == true) {
      echo smn_draw_input_field('a_telephone') . '&nbsp;' . ENTRY_TELEPHONE_NUMBER_ERROR;
    } else {
      echo $a_telephone . smn_draw_hidden_field('a_telephone');
    }
  } else {
    echo smn_draw_input_field('a_telephone', $affiliate['customers_telephone']) . '&nbsp;' . ENTRY_TELEPHONE_NUMBER_TEXT;
  }
?>
            </td>
          </tr>
          <tr>
            <td class="main">&nbsp;<?php echo ENTRY_FAX_NUMBER; ?></td>
            <td class="main">&nbsp;
<?php
  if ($is_read_only == true) {
    echo $affiliate['customers_fax'];
  } elseif ($error == true) {
    if ($entry_fax_error == true) {
      echo smn_draw_input_field('a_fax') . '&nbsp;' . ENTRY_FAX_NUMBER_ERROR;
    } else {
      echo $a_fax . smn_draw_hidden_field('a_fax');
    }
  } else {
    echo smn_draw_input_field('a_fax', $affiliate['customers_fax']) . '&nbsp;' . ENTRY_FAX_NUMBER_TEXT;
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
</table>