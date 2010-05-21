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
  <fieldset>
   <legend><?php echo CATEGORY_PERSONAL;?></legend>
   <table cellpadding="3" cellspacing="0" border="0">
    <tr>
     <td class="main"><label for="firstname"><?php echo ENTRY_FIRST_NAME;?></label></td>
     <td><?php echo smn_draw_input_field('firstname', $customerInfo->customer_data['customers_firstname'], 'id="firstname"');?></td>
    </tr>
    <tr>
     <td class="main"><label for="lastname"><?php echo ENTRY_LAST_NAME;?></label></td>
     <td><?php echo smn_draw_input_field('lastname', $customerInfo->customer_data['customers_lastname'], 'id="lastname"');?></td>
    </tr>
    <tr>
     <td class="main"><label for="dob"><?php echo ENTRY_DATE_OF_BIRTH;?></label></td>
     <td><?php 
      $dob = explode('-', $customerInfo->customer_data['customers_dob']);
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
                
      echo smn_draw_pull_down_menu('dob_day', $day_drop_down_array, $dob[0], 'id="dob_day"') . '&nbsp;' . smn_draw_pull_down_menu('dob_month', $month_drop_down_array, $dob[1], 'id="dob_month"') . '&nbsp;' . smn_draw_pull_down_menu('dob_year', $year_drop_down_array, $dob[2], 'id="dob_year"'); 
                
     ?></td>
    </tr>
    <tr>
     <td class="main"><label for="email_address"><?php echo ENTRY_EMAIL_ADDRESS;?></label></td>
     <td><?php echo smn_draw_input_field('email_address', $customerInfo->customer_data['customers_email_address'], 'id="email_address"');?></td>
    </tr>
   </table>
  </fieldset>
  <fieldset>
   <legend><?php echo CATEGORY_COMPANY;?></legend>
   <table cellpadding="3" cellspacing="0" border="0">
    <tr>
     <td class="main"><label for="company"><?php echo ENTRY_COMPANY;?></label></td>
     <td><?php echo smn_draw_input_field('company', $customerInfo->customer_data['entry_company'], 'id="company"');?></td>
    </tr>
   </table>
  </fieldset>
  <fieldset>
   <legend><?php echo CATEGORY_ADDRESS;?></legend>
   <table cellpadding="3" cellspacing="0" border="0">
    <tr>
     <td class="main"><label for="street_address"><?php echo ENTRY_STREET_ADDRESS;?></label></td>
     <td><?php echo smn_draw_input_field('street_address', $customerInfo->address_data['entry_street_address'], 'id="street_address"');?></td>
    </tr>
    <tr>
     <td class="main"><label for="city"><?php echo ENTRY_CITY;?></label></td>
     <td><?php echo smn_draw_input_field('city', $customerInfo->address_data['entry_city'], 'id="city"');?></td>
    </tr>
    <tr>
     <td class="main"><label for="postcode"><?php echo ENTRY_POST_CODE;?></label></td>
     <td><?php echo smn_draw_input_field('postcode', $customerInfo->address_data['entry_postcode'], 'id="postcode"');?></td>
    </tr>
    <tr>
     <td class="main"><label for="country"><?php echo ENTRY_COUNTRY;?></label></td>
     <td><?php echo smn_get_country_list('country', $customerInfo->address_data['entry_country_id'], 'id="country"');?></td>
    </tr>
    <tr>
     <td class="main"><label for="state"><?php echo ENTRY_STATE;?></label></td>
     <td id="state_col"><?php echo smn_draw_input_field('state', $customerInfo->address_data['entry_state'], 'id="state"');?></td>
    </tr>
   </table>
  </fieldset>