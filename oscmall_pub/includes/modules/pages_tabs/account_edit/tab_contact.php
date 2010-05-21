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

     $telephone = explode('-', $customerInfo->telephone);
     $tollfree = explode('-', $customerInfo->tollfree);
     $fax = explode('-', $customerInfo->fax);

     if (smn_session_is_registered('customer_store_id') || smn_session_is_registered('affiliate_id')){
?>  
  <fieldset class="x-fieldset">
   <legend>Sales Agent</legend>
   <table cellpadding="3" cellspacing="0" border="0">
    <tr>
     <td class="main" valign="top"><label style="width:125px;"><?php echo (!empty($customerInfo->affiliate_data) ? 'Affiliate Info:' : 'Affiliate Id:');?></label></td>
     <td class="main" width="300"><?php
      if (smn_session_is_registered('affiliate_id')){
          echo $affiliate_id;
      }else{
          if (!empty($customerInfo->affiliate_data)){
              echo '<label id="affiliate_moreinfo" style="color:blue" onmouseover="this.style.cursor=\'pointer\'">Show Contact Info</label>' . "\n" . 
                   '<div id="affiliate_info" style="display:none">' . "\n" . 
                   '<b>Name:</b> ' . $customerInfo->affiliate_data['affiliate_firstname'] . ' ' . $customerInfo->affiliate_data['affiliate_lastname'] . '' . "\n" . 
                   '<br>' . "\n" . 
                   '<b>Email:</b> <a href="mailto:' . $customerInfo->affiliate_data['affiliate_email_address'] . '">' . $customerInfo->affiliate_data['affiliate_email_address'] . '</a>' . "\n" . 
                   '<br>' . "\n" . 
                   '<b>Telephone:</b> ' . $customerInfo->affiliate_data['affiliate_telephone'] . '' . "\n" . 
                   '<br>' . "\n" . 
                   '<b>Fax:</b> ' . $customerInfo->affiliate_data['affiliate_fax'] . '' . "\n" . 
                   '</div>'; 
          }else{
              echo '<input type="text" name="affiliate_id" value="' . $customerInfo->customer_data['affiliate_id'] . '">';
          }
      }
     ?></td>
    </tr>
<?php
  if (smn_session_is_registered('customer_store_id')){
?>    
    <tr>
     <td class="main"><label style="width:125px;">Vendor Id:</label></td>
     <td class="main" class="main"><?php echo $customer_store_id;?></td>
    </tr>
<?php
  }
?>    
   </table>
  </fieldset>
<?php
  }
?>    
  <fieldset>
   <legend><?php echo CATEGORY_CONTACT;?></legend>
   <table cellpadding="3" cellspacing="0" border="0">
    <tr>
     <td class="main"><label for="telephone_0"><?php echo ENTRY_TELEPHONE_NUMBER;?></label></td>
     <td><?php
      echo smn_draw_input_field('telephone_0', $telephone[0], 'id="telephone_0" size="3" maxlength="3"') . '&nbsp;&nbsp;' . 
           smn_draw_input_field('telephone_1', $telephone[1], 'id="telephone_1" size="3" maxlength="3"') . '&nbsp;&nbsp;' .
           smn_draw_input_field('telephone_2', $telephone[2], 'id="telephone_2" size="4" maxlength="4"');
     ?></td>
    </tr>
    <tr>
     <td class="main"><label for="tollfree_0"><?php echo ENTRY_TOLL_FREE_NUMBER;?></label></td>
     <td><?php
      echo smn_draw_input_field('tollfree_0', $tollfree[0], 'id="tollfree_0" size="3" maxlength="3"') . '&nbsp;&nbsp;' . 
           smn_draw_input_field('tollfree_1', $tollfree[1], 'id="tollfree_1" size="3" maxlength="3"') . '&nbsp;&nbsp;' .
           smn_draw_input_field('tollfree_2', $tollfree[2], 'id="tollfree_2" size="4" maxlength="4"');
     ?></td>
    </tr>
    <tr>
     <td class="main"><label for="fax_0"><?php echo ENTRY_FAX_NUMBER;?></label></td>
     <td><?php
      echo smn_draw_input_field('fax_0', $fax[0], 'id="fax_0" size="3" maxlength="3"') . '&nbsp;&nbsp;' . 
           smn_draw_input_field('fax_1', $fax[1], 'id="fax_1" size="3" maxlength="3"') . '&nbsp;&nbsp;' .
           smn_draw_input_field('fax_2', $fax[2], 'id="fax_2" size="4" maxlength="4"');
     ?></td>
    </tr>
   </table>
  </fieldset>
  <fieldset>
   <legend><?php echo CATEGORY_OPTIONS;?></legend>
   <table cellpadding="3" cellspacing="0" border="0">
    <tr>
     <td class="main"><label for="newsletter"><?php echo ENTRY_NEWSLETTER;?></label></td>
     <td><?php echo smn_draw_checkbox_field('newsletter', '1', $customerInfo->customer_data['customers_newsletter'], 'id="newsletter"');?></td>
    </tr>
   </table>
  </fieldset>