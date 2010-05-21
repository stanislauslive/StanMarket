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

   global $page_name; 

  
  if ($store_id != 1)
  {
      $store_id = 1;
      //$cart->reset(TRUE);
      smn_redirect(smn_href_link(FILENAME_CREATE_STORE, '', 'NONSSL'));
  }
  
  $store_selection_out_string .= '<td class="smallText">' . BASIC_STORE_PACKAGE_TEXT . '<br><br>';
  $store_selection_out_string .=  smn_draw_separator('pixel_trans.gif', '10', '10'); 
  $db_groups_query = smn_db_query("select ag.admin_groups_id, ag.admin_groups_name, ag.admin_groups_max_products, ag.admin_groups_store_type, p.products_price from " . TABLE_ADMIN_GROUPS . " ag,  " . TABLE_PRODUCTS . " p where ag.admin_groups_products_id = p.products_id order by ag.admin_groups_id");
    while ($groups = smn_db_fetch_array($db_groups_query)){
        if((int)$groups['admin_groups_max_products'] == 0)$groups['admin_groups_max_products'] = 'unlimited';  
     if ( (int)$sInfo->admin_groups_id == (int)$groups['admin_groups_id']){
          $store_selection_out_string .= smn_draw_radio_field('store_type', $groups['admin_groups_id'], true) . '&nbsp;' .  '<span class="inputRequirement"><b>' . $groups['admin_groups_name'] . '</b> ' . REGULAR_STORE_MAX_PRODUCTS . ' ' . $groups['admin_groups_max_products'] . ' ' . REGULAR_STORE_COST . ': <b>$' . round($groups['products_price'],2) . '</b></span><br>';
          $store_selection_out_string .=  smn_draw_separator('pixel_trans.gif', '10', '5');
     } elseif ($groups['admin_groups_id'] != '1'){
          $store_selection_out_string .= smn_draw_radio_field('store_type', $groups['admin_groups_id'], false) . '&nbsp;' .  '<span class="inputRequirement"><b>' . $groups['admin_groups_name'] . '</b> ' . REGULAR_STORE_MAX_PRODUCTS . ' ' . $groups['admin_groups_max_products'] . ' ' . REGULAR_STORE_COST . ': <b>$' . round($groups['products_price'],2) . '</b></span><br>';
          $store_selection_out_string .=  smn_draw_separator('pixel_trans.gif', '10', '5');
     }
    }
    $store_selection_out_string .=  smn_draw_separator('pixel_trans.gif', '10', '10');
    $store_selection_out_string .= '</td>';
  $breadcrumb->add(NAVBAR_TITLE, smn_href_link(FILENAME_CREATE_STORE, '', 'NONSSL'));
?>