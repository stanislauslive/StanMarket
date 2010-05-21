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

  class ot_gv {
    var $title, $output;

    function ot_gv() {
      $this->code = 'ot_gv';
      $this->title = MODULE_ORDER_TOTAL_GV_TITLE;
      $this->header = MODULE_ORDER_TOTAL_GV_HEADER;
      $this->description = MODULE_ORDER_TOTAL_GV_DESCRIPTION;
      $this->user_prompt = MODULE_ORDER_TOTAL_GV_USER_PROMPT;
      $this->enabled = MODULE_ORDER_TOTAL_GV_STATUS;
      $this->sort_order = MODULE_ORDER_TOTAL_GV_SORT_ORDER;
      $this->include_shipping = MODULE_ORDER_TOTAL_GV_INC_SHIPPING;
      $this->include_tax = MODULE_ORDER_TOTAL_GV_INC_TAX;
      $this->calculate_tax = MODULE_ORDER_TOTAL_GV_CALC_TAX;
      $this->credit_tax = MODULE_ORDER_TOTAL_GV_CREDIT_TAX;
      $this->tax_class  = MODULE_ORDER_TOTAL_GV_TAX_CLASS;
      $this->show_redeem_box = MODULE_ORDER_TOTAL_GV_REDEEM_BOX;
     $this->credit_class = true;

//      $this->checkbox = $this->user_prompt . '<input type="checkbox" onClick="submitFunction()" name="' . 'c' . $this->code . '">';
	$this->checkbox = $this->user_prompt . '<input type="checkbox" onClick="clearRadeos()" name="' . 'c' . $this->code . '">';

      $this->output = array();
    }

 // #################### if you set it in admin to not include tax or shipping in the amount

    function process() {
      global $order, $currencies, $cot_gv;

       if (smn_session_is_registered('cot_gv')) {
        $order_total = $this->get_order_total();
        $od_amount = $this->calculate_credit($order_total);
        if ($this->calculate_tax != "None") {
          $tod_amount = $this->calculate_tax_deduction($order_total, $od_amount, $this->calculate_tax);
          $od_amount = $this->calculate_credit($order_total);
        }
        $this->deduction = $od_amount;
        $order->info['total'] = $order->info['total'] - $od_amount;
        if ($od_amount > 0) {
          $this->output[] = array('title' => $this->title . ':',
                           'text' => '<b>' . $currencies->format($od_amount) . '</b>',
                           'value' => $od_amount);
        }
      }
    }

function mod_process() {
     global $currencies;
       $my_order_total = $this->get_order_total();
       $my_od_amount = $this->calculate_credit($my_order_total);
       if ($this->calculate_tax != "None") {
         $tod_amount = $this->calculate_tax_deduction($my_order_total, $my_od_amount, $this->calculate_tax);
         $my_od_amount = $this->calculate_credit($my_order_total);
       }
       $this->deduction = $my_od_amount;

       if ($my_od_amount > 0) {
         $this->my_output[] = array('title' => $this->title . ':',
                          'text' => '<b>' . $currencies->format($my_od_amount) . '</b>',
                          'value' => $my_od_amount);
       }
   }


    function selection_test() {
      global $customer_id;
      if ($this->user_has_gv_account($customer_id)) {
        return true;
      } else {
        return false;
      }
    }

  function pre_confirmation_check($order_total) {
    global $cot_gv, $order;
    $od_amount = 0; // set the default amount we will send back
    if (smn_session_is_registered('cot_gv')) {
// pre confirmation check doesn't do a true order process. It just attempts to see if
// there is enough to handle the order. But depending on settings it will not be shown
// all of the order so this is why we do this runaround jane. What do we know so far.
// nothing. Since we need to know if we process the full amount we need to call get order total
// if there has been something before us then

              if ($this->include_tax == 'false') {
                                        $order_total = $order_total - $order->info['tax'];
                                }
              if ($this->include_shipping == 'false') {
                                        $order_total = $order_total - $order->info['shipping_cost'];
                                }
                                $od_amount = $this->calculate_credit($order_total);


                                if ($this->calculate_tax != "None") {
                                        $tod_amount = $this->calculate_tax_deduction($order_total, $od_amount, $this->calculate_tax);
                                        $od_amount = $this->calculate_credit($order_total)+$tod_amount;
                                }
                        }
                return $od_amount;
        }


    function use_credit_amount() {
		global $cot_gv, $currencies;

      $cot_gv = false;
      if ($this->selection_test()) {
        $output_string = $this->checkbox . '</b>' . '</td>' . "\n";}

      return $output_string;
    }

	function use_credit_amount_sub() {
		global $cot_gv;

      $cot_gv = false;
      if ($this->selection_test()) {
        $output_string .=  '    <td align="right" class="main" colspan=2>';
        $output_string .= '<b>' . $this->checkbox . '</b>' . '</td>' . "\n";
      }
      return $output_string;
    }


    function update_credit_account($i) {

      global $order, $customer_id, $insert_id, $REMOTE_ADDR;
      if (ereg('^GIFT', addslashes($order->products[$i]['model']))) {
        $gv_order_amount = ($order->products[$i]['final_price'] * $order->products[$i]['qty']);
        if ($this->credit_tax=='true') $gv_order_amount = $gv_order_amount * (100 + $order->products[$i]['tax']) / 100;
        $gv_order_amount = $gv_order_amount * 100 / 100;
        if (MODULE_ORDER_TOTAL_GV_QUEUE == 'false') {
          // GV_QUEUE is true so release amount to account immediately
          $gv_query=smn_db_query("select amount from " . TABLE_COUPON_GV_CUSTOMER . " where customer_id = '" . $customer_id . "'");
          $customer_gv = false;
          $total_gv_amount = 0;
          if ($gv_result = smn_db_fetch_array($gv_query)) {
            $total_gv_amount = $gv_result['amount'];
            $customer_gv = true;
          }
          $total_gv_amount = $total_gv_amount + $gv_order_amount;
          if ($customer_gv) {
            $gv_update=smn_db_query("update " . TABLE_COUPON_GV_CUSTOMER . " set amount = '" . $total_gv_amount . "' where customer_id = '" . $customer_id . "'");
          } else {
            $gv_insert=smn_db_query("insert into " . TABLE_COUPON_GV_CUSTOMER . " (customer_id, amount) values ('" . $customer_id . "', '" . $total_gv_amount . "')");
          }
        } else {
         // GV_QUEUE is true - so queue the gv for release by store owner
          $gv_insert=smn_db_query("insert into " . TABLE_COUPON_GV_QUEUE . " (customer_id, order_id, amount, date_created, ipaddr) values ('" . $customer_id . "', '" . $insert_id . "', '" . $gv_order_amount . "', NOW(), '" . $REMOTE_ADDR . "')");
        }
      }
    }

    function credit_selection() {
      global $customer_id, $currencies, $language;
      $selection_string = '';
      $gv_query = smn_db_query("select coupon_id from " . TABLE_COUPONS . " where coupon_type = 'G' and coupon_active='Y'");
      if (smn_db_num_rows($gv_query)) {
        $selection_string .= '<tr>' . "\n";
        $selection_string .= '  <td width="10">' .  smn_draw_separator('pixel_trans.gif', '10', '1') .'</td>';
        $selection_string .= '  <td class="main">' . "\n";
        $image_submit = '<input type="image" name="submit_redeem" onClick="submitFunction()" src="' . DIR_WS_LANGUAGES . $language . '/images/buttons/button_redeem.gif" border="0" alt="' . IMAGE_REDEEM_VOUCHER . '" title = "' . IMAGE_REDEEM_VOUCHER . '">';
        $selection_string .= TEXT_ENTER_GV_CODE . smn_draw_input_field('gv_redeem_code') . '</td>';
        $selection_string .= ' <td align="right">' . $image_submit . '</td>';
        $selection_string .= '  <td width="10">' . smn_draw_separator('pixel_trans.gif', '10', '1') . '</td>';
        $selection_string .= '</tr>' . "\n";
      }
    return $selection_string;
    }

    function apply_credit() {
      global $order, $customer_id, $coupon_no, $cot_gv;
      if (smn_session_is_registered('cot_gv')) {
        $gv_query = smn_db_query("select amount from " . TABLE_COUPON_GV_CUSTOMER . " where customer_id = '" . $customer_id . "'");
        $gv_result = smn_db_fetch_array($gv_query);
        $gv_payment_amount = $this->deduction;
        $gv_amount = $gv_result['amount'] - $gv_payment_amount;
        $gv_update = smn_db_query("update " . TABLE_COUPON_GV_CUSTOMER . " set amount = '" . $gv_amount . "' where customer_id = '" . $customer_id . "'");
      }
      return $gv_payment_amount;
    }

    function collect_posts() {
// Security Update URL parameters of all smn_redirect function called inside this function
      global $currencies, $_POST, $customer_id, $coupon_no, $REMOTE_ADDR, $cot_gv;

          
      if ($_POST['gv_redeem_code']) {
        $gv_query = smn_db_query("select coupon_id, coupon_type, coupon_amount from " . TABLE_COUPONS . " where coupon_code = '" . smn_db_input($_POST['gv_redeem_code']) . "'");
        $gv_result = smn_db_fetch_array($gv_query);
        if (smn_db_num_rows($gv_query) != 0) {
          $redeem_query = smn_db_query("select * from " . TABLE_COUPON_REDEEM_TRACK . " where coupon_id = '" . $gv_result['coupon_id'] . "'");
          if ( (smn_db_num_rows($redeem_query) != 0) && ($gv_result['coupon_type'] == 'G') ) {
                  // error, this coupon has been redeemed already.
            smn_redirect(smn_href_link(FILENAME_CHECKOUT_PAYMENT, 'payment_error='.$this->code.'&error=' . urlencode(ERROR_NO_INVALID_REDEEM_GV), 'NONSSL'));
          }
        }
        // Next line added by Rigadin in v5.13 to give an error when unknown code entered
        elseif ($_POST['submit_redeem_x']) smn_redirect(smn_href_link(FILENAME_CHECKOUT_PAYMENT, 'payment_error='.$this->code.'&error=' . urlencode(ERROR_NO_INVALID_REDEEM_GV), 'NONSSL'));
                
        if ($gv_result['coupon_type'] == 'G') {
          $gv_amount = $gv_result['coupon_amount'];
          // Things to set
          // ip address of claimant
          // customer id of claimant
          // date
          // redemption flag
          // now update customer account with gv_amount
          $gv_amount_query=smn_db_query("select amount from " . TABLE_COUPON_GV_CUSTOMER . " where customer_id = '" . $customer_id . "'");
          $customer_gv = false;
          $total_gv_amount = $gv_amount;
          if ($gv_amount_result = smn_db_fetch_array($gv_amount_query)) {
            $total_gv_amount = $gv_amount_result['amount'] + $gv_amount;
            $customer_gv = true;
          }
          $gv_update = smn_db_query("update " . TABLE_COUPONS . " set coupon_active = 'N' where coupon_id = '" . $gv_result['coupon_id'] . "'");
          $gv_redeem = smn_db_query("insert into  " . TABLE_COUPON_REDEEM_TRACK . " (coupon_id, customer_id, redeem_date, redeem_ip) values ('" . $gv_result['coupon_id'] . "', '" . $customer_id . "', now(),'" . $REMOTE_ADDR . "')");
          if ($customer_gv) {
            // already has gv_amount so update
            $gv_update = smn_db_query("update " . TABLE_COUPON_GV_CUSTOMER . " set amount = '" . $total_gv_amount . "' where customer_id = '" . $customer_id . "'");
          } else {
            // no gv_amount so insert
            $gv_insert = smn_db_query("insert into " . TABLE_COUPON_GV_CUSTOMER . " (customer_id, amount) values ('" . $customer_id . "', '" . $total_gv_amount . "')");
          }
          smn_redirect(smn_href_link(FILENAME_CHECKOUT_PAYMENT, 'payment_error='.$this->code.'&error=' . urlencode(ERROR_REDEEMED_AMOUNT. $currencies->format($gv_amount)), 'NONSSL'));
       }
     }
     // v5.13a Generates an error if redeem button pressed without code entered
     if ($_POST['submit_redeem_x'] && !$_POST['gv_redeem_code']) smn_redirect(smn_href_link(FILENAME_CHECKOUT_PAYMENT, 'payment_error='.$this->code.'&error=' . urlencode(ERROR_NO_REDEEM_CODE), 'NONSSL'));
   }

    function calculate_credit($amount) {
      global $customer_id, $order;
      $gv_query=smn_db_query("select amount from " . TABLE_COUPON_GV_CUSTOMER . " where customer_id = '" . $customer_id . "'");
      $gv_result=smn_db_fetch_array($gv_query);
      $gv_payment_amount = $gv_result['amount'];
      $gv_amount = $gv_payment_amount;
      $save_total_cost = $amount;
      $full_cost = $save_total_cost - $gv_payment_amount;
      if ($full_cost <= 0) {
        $full_cost = 0;
        $gv_payment_amount = $save_total_cost;
      }
      return smn_round($gv_payment_amount,2);
    }

    function calculate_tax_deduction($amount, $od_amount, $method) {
      global $order;
      switch ($method) {
        case 'Standard':

        $ratio1= ($amount == 0 ? 0 : smn_round($od_amount / $amount,2) );
        $tod_amount = 0;
        reset($order->info['tax_groups']);
        while (list($key, $value) = each($order->info['tax_groups'])) {
          $tax_rate = smn_get_tax_rate_from_desc($key);
          $total_net += $tax_rate * $order->info['tax_groups'][$key];
        }
        if ($od_amount > $total_net) $od_amount = $total_net;
        reset($order->info['tax_groups']);
        while (list($key, $value) = each($order->info['tax_groups'])) {
          $tax_rate = smn_get_tax_rate_from_desc($key);
          $net = $tax_rate * $order->info['tax_groups'][$key];
          if ($net > 0) {
            $god_amount = $order->info['tax_groups'][$key] * $ratio1;
            $tod_amount += $god_amount;
            $order->info['tax_groups'][$key] = $order->info['tax_groups'][$key] - $god_amount;
          }
        }
        $order->info['tax'] -= $tod_amount;
        $order->info['total'] -= $tod_amount;
        break;
        case 'Credit Note':
          $tax_rate = smn_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
          $tax_desc = smn_get_tax_description($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
          $tod_amount = $this->deduction / (100 + $tax_rate)* $tax_rate;
          $order->info['tax_groups'][$tax_desc] -= $tod_amount;
        break;
        default:
      }
      return $tod_amount;
    }

    function user_has_gv_account($c_id) {
      $gv_query = smn_db_query("select amount from " . TABLE_COUPON_GV_CUSTOMER . " where customer_id = '" . $c_id . "'");
      if ($gv_result = smn_db_fetch_array($gv_query)) {
        if ($gv_result['amount']>0) {
          return true;
        }
      }
      return false;
    }

    function get_order_total() {
      global $order;
      $order_total = $order->info['total'];
      if ($this->include_tax == 'false') $order_total = $order_total - $order->info['tax'];
      if ($this->include_shipping == 'false') $order_total = $order_total - $order->info['shipping_cost'];

      return $order_total;
    }
        
// START added by Rigadin in v5.13, needed to show module errors on checkout_payment page
    function get_error() {
      global $_GET;

      $error = array('title' => MODULE_ORDER_TOTAL_GV_TEXT_ERROR,
                     'error' => stripslashes(urldecode($_GET['error'])));

      return $error;
    }
// END added by Rigadin                

    function check() {
      global $store_id;

      if (!isset($this->check)) {
        $check_query = smn_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_ORDER_TOTAL_GV_STATUS' and store_id = '" . $store_id . "'");
        $this->check = smn_db_num_rows($check_query);
      }

      return $this->check;
    }

    function keys() {
      return array('MODULE_ORDER_TOTAL_GV_STATUS', 'MODULE_ORDER_TOTAL_GV_SORT_ORDER', 'MODULE_ORDER_TOTAL_GV_QUEUE', 'MODULE_ORDER_TOTAL_GV_INC_SHIPPING', 'MODULE_ORDER_TOTAL_GV_INC_TAX', 'MODULE_ORDER_TOTAL_GV_CALC_TAX', 'MODULE_ORDER_TOTAL_GV_TAX_CLASS', 'MODULE_ORDER_TOTAL_GV_CREDIT_TAX');
    }

    function install() {
      global $store_id;
      
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ($store_id, 'Display Total', 'MODULE_ORDER_TOTAL_GV_STATUS', 'true', 'Do you want to display the Gift Voucher value?', '6', '1','smn_cfg_select_option(array(\'true\', \'false\'), ', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ($store_id, 'Sort Order', 'MODULE_ORDER_TOTAL_GV_SORT_ORDER', '740', 'Sort order of display.', '6', '2', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ($store_id, 'Queue Purchases', 'MODULE_ORDER_TOTAL_GV_QUEUE', 'true', 'Do you want to queue purchases of the Gift Voucher?', '6', '3','smn_cfg_select_option(array(\'true\', \'false\'), ', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function ,date_added) values ($store_id, 'Include Shipping', 'MODULE_ORDER_TOTAL_GV_INC_SHIPPING', 'true', 'Include Shipping in calculation', '6', '5', 'smn_cfg_select_option(array(\'true\', \'false\'), ', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function ,date_added) values ($store_id, 'Include Tax', 'MODULE_ORDER_TOTAL_GV_INC_TAX', 'true', 'Include Tax in calculation.', '6', '6','smn_cfg_select_option(array(\'true\', \'false\'), ', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function ,date_added) values ($store_id, 'Re-calculate Tax', 'MODULE_ORDER_TOTAL_GV_CALC_TAX', 'None', 'Re-Calculate Tax', '6', '7','smn_cfg_select_option(array(\'None\', \'Standard\', \'Credit Note\'), ', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ($store_id, 'Tax Class', 'MODULE_ORDER_TOTAL_GV_TAX_CLASS', '0', 'Use the following tax class when treating Gift Voucher as Credit Note.', '6', '0', 'smn_get_tax_class_title', 'smn_cfg_pull_down_tax_classes(', now())");
      smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function ,date_added) values ($store_id, 'Credit including Tax', 'MODULE_ORDER_TOTAL_GV_CREDIT_TAX', 'false', 'Add tax to purchased Gift Voucher when crediting to Account', '6', '8','smn_cfg_select_option(array(\'true\', \'false\'), ', now())");
    }

    function remove() {
      global $store_id;
      smn_db_query("delete from " . TABLE_CONFIGURATION . " where store_id=$store_id and configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }
  }
?>
