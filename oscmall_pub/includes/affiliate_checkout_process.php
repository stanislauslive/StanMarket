<?php
/*
  Copyright (c) 2004 SystemsManager.Net
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

// fetch the net total of an order
  $affiliate_total = 0;
  for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
    $affiliate_total += $order->products[$i]['final_price'] * $order->products[$i]['qty'];
  }
  $affiliate_total = smn_round($affiliate_total, 2);

// Check for individual commission
  $affiliate_percentage = 0;
  if (AFFILATE_INDIVIDUAL_PERCENTAGE == 'true') {
    $affiliate_commission_query = smn_db_query ("select affiliate_commission_percent from " . TABLE_AFFILIATE . " where affiliate_id = '" . $affiliate_ref . "'");
    $affiliate_commission = smn_db_fetch_array($affiliate_commission_query);
    $affiliate_percent = $affiliate_commission['affiliate_commission_percent'];
  }
  if ($affiliate_percent < AFFILIATE_PERCENT) $affiliate_percent = AFFILIATE_PERCENT;
  $affiliate_payment = smn_round(($affiliate_total * $affiliate_percent / 100), 2);
  
   
  if ($HTTP_SESSION_VARS['affiliate_ref']) {
    $sql_data_array = array('affiliate_id' => $affiliate_ref,
                            'affiliate_date' => $affiliate_clientdate,
                            'affiliate_browser' => $affiliate_clientbrowser,
                            'affiliate_ipaddress' => $affiliate_clientip,
                            'affiliate_value' => $affiliate_total,
                            'affiliate_payment' => $affiliate_payment,
                            'affiliate_orders_id' => $insert_id,
                            'affiliate_clickthroughs_id' => $affiliate_clickthroughs_id,
                            'affiliate_percent' => $affiliate_percent,
                            'affiliate_salesman' => $affiliate_ref);
    smn_db_perform(TABLE_AFFILIATE_SALES, $sql_data_array);

    if (AFFILATE_USE_TIER == 'true') {
      $affiliate_tiers_query = smn_db_query ("SELECT aa2.affiliate_id, (aa2.affiliate_rgt - aa2.affiliate_lft) as height
                                                      FROM affiliate_affiliate AS aa1, affiliate_affiliate AS aa2
                                                      WHERE  aa1.affiliate_root = aa2.affiliate_root 
                                                            AND aa1.affiliate_lft BETWEEN aa2.affiliate_lft AND aa2.affiliate_rgt
                                                            AND aa1.affiliate_rgt BETWEEN aa2.affiliate_lft AND aa2.affiliate_rgt
                                                            AND aa1.affiliate_id =  '" . $affiliate_ref . "'
                                                      ORDER by height asc limit 1, " . AFFILIATE_TIER_LEVELS . " 
                                              ");
      $affiliate_tier_percentage = split("[;]" , AFFILIATE_TIER_PERCENTAGE);
      $i=0;
      while ($affiliate_tiers_array = smn_db_fetch_array($affiliate_tiers_query)) {

        $affiliate_percent = $affiliate_tier_percentage[$i];
        $affiliate_payment = smn_round(($affiliate_total * $affiliate_percent / 100), 2);
        if ($affiliate_payment > 0) {
          $sql_data_array = array('affiliate_id' => $affiliate_tiers_array['affiliate_id'],
                                  'affiliate_date' => $affiliate_clientdate,
                                  'affiliate_browser' => $affiliate_clientbrowser,
                                  'affiliate_ipaddress' => $affiliate_clientip,
                                  'affiliate_value' => $affiliate_total,
                                  'affiliate_payment' => $affiliate_payment,
                                  'affiliate_orders_id' => $insert_id,
                                  'affiliate_clickthroughs_id' => $affiliate_clickthroughs_id,
                                  'affiliate_percent' => $affiliate_percent,
                                  'affiliate_salesman' => $affiliate_ref);
          smn_db_perform(TABLE_AFFILIATE_SALES, $sql_data_array);
        }
        $i++;
      }
    }
  }
?>