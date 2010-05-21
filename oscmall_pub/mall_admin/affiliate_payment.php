<?php
/*
  Copyright (c) 2002 - 2005 SystemsManager.Net

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

  require('includes/application_top.php');

  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

  $payments_statuses = array();
  $payments_status_array = array();
  $payments_status_query = smn_db_query("select affiliate_payment_status_id, affiliate_payment_status_name from " . TABLE_AFFILIATE_PAYMENT_STATUS . " where affiliate_language_id = '" . $languages_id . "'");
  while ($payments_status = smn_db_fetch_array($payments_status_query)) {
    $payments_statuses[] = array('id' => $payments_status['affiliate_payment_status_id'],
                                 'text' => $payments_status['affiliate_payment_status_name']);
    $payments_status_array[$payments_status['affiliate_payment_status_id']] = $payments_status['affiliate_payment_status_name'];
  }

  switch ($_GET['action']) {
    case 'start_billing':
// Billing can be a lengthy process
      smn_set_time_limit(0);
// We are only billing orders which are AFFILIATE_BILLING_TIME days old
      $time = mktime(1, 1, 1, date("m"), date("d") - AFFILIATE_BILLING_TIME, date("Y"));
      $oldday = date("Y-m-d", $time);
// Select all affiliates who earned enough money since last payment
      $sql="
        SELECT a.affiliate_id, sum(a.affiliate_payment) 
          FROM " . TABLE_AFFILIATE_SALES . " a, " . TABLE_ORDERS . " o 
          WHERE a.affiliate_billing_status != 1 and a.affiliate_orders_id = o.orders_id and o.orders_status >= " . AFFILIATE_PAYMENT_ORDER_MIN_STATUS . " and a.affiliate_date <= '" . $oldday . "' 
          GROUP by a.affiliate_id 
          having sum(a.affiliate_payment) >= '" . AFFILIATE_THRESHOLD . "'
        ";
      $affiliate_payment_query = smn_db_query($sql);

// Start Billing:
      while ($affiliate_payment = smn_db_fetch_array($affiliate_payment_query)) {

// mysql does not support joins in update (planned in 4.x)

// Get all orders which are AFFILIATE_BILLING_TIME days old
        $sql="
        SELECT a.affiliate_orders_id 
          FROM " . TABLE_AFFILIATE_SALES . " a, " . TABLE_ORDERS . " o 
          WHERE a.affiliate_billing_status!=1 and a.affiliate_orders_id=o.orders_id and o.orders_status>=" . AFFILIATE_PAYMENT_ORDER_MIN_STATUS . " and a.affiliate_id='" . $affiliate_payment['affiliate_id'] . "' and a.affiliate_date <= '" . $oldday . "'
        ";
        $affiliate_orders_query=smn_db_query ($sql);
        $orders_id ="(";
        while ($affiliate_orders = smn_db_fetch_array($affiliate_orders_query)) {
          $orders_id .= $affiliate_orders['affiliate_orders_id'] . ",";
        }
        $orders_id = substr($orders_id, 0, -1) .")";

// Set the Sales to Temp State (it may happen that an order happend while billing)
        $sql="UPDATE " . TABLE_AFFILIATE_SALES . " 
        set affiliate_billing_status=99 
          where affiliate_id='" .  $affiliate_payment['affiliate_id'] . "' 
          and affiliate_orders_id in " . $orders_id . " 
        ";
        smn_db_query ($sql);

// Get Sum of payment (Could have changed since last selects);
        $sql="
        SELECT sum(affiliate_payment) as affiliate_payment
          FROM " . TABLE_AFFILIATE_SALES . " 
          WHERE affiliate_id='" .  $affiliate_payment['affiliate_id'] . "' and  affiliate_billing_status=99 
        ";
        $affiliate_billing_query = smn_db_query ($sql);
        $affiliate_billing = smn_db_fetch_array($affiliate_billing_query);
// Get affiliate Informations
        $sql="
        SELECT a.*, c.countries_id, c.countries_name, c.countries_iso_code_2, c.countries_iso_code_3, c.address_format_id 
          from " . TABLE_AFFILIATE . " a 
          left join " . TABLE_ZONES . " z on (a.affiliate_zone_id  = z.zone_id) 
          left join " . TABLE_COUNTRIES . " c on (a.affiliate_country_id = c.countries_id)
          WHERE affiliate_id = '" . $affiliate_payment['affiliate_id'] . "' 
        ";
        $affiliate_query=smn_db_query ($sql);
        $affiliate = smn_db_fetch_array($affiliate_query);

// Get need tax informations for the affiliate
        $affiliate_tax_rate = smn_get_affiliate_tax_rate(AFFILIATE_TAX_ID, $affiliate['affiliate_country_id'], $affiliate['affiliate_zone_id']);
        $affiliate_tax = smn_round(($affiliate_billing['affiliate_payment'] * $affiliate_tax_rate / 100), 2); // Netto-Provision
        $affiliate_payment_total = $affiliate_billing['affiliate_payment'] + $affiliate_tax;
// Bill the order
        $affiliate['affiliate_state'] = smn_get_zone_code($affiliate['affiliate_country_id'], $affiliate['affiliate_zone_id'], $affiliate['affiliate_state']);
        $sql_data_array = array('affiliate_id' => $affiliate_payment['affiliate_id'],
                                'affiliate_payment' => $affiliate_billing['affiliate_payment'],
                                'affiliate_payment_tax' => $affiliate_tax,
                                'affiliate_payment_total' => $affiliate_payment_total,
                                'affiliate_payment_date' => 'now()',
                                'affiliate_payment_status' => '0',
                                'affiliate_firstname' => $affiliate['affiliate_firstname'],
                                'affiliate_lastname' => $affiliate['affiliate_lastname'],
                                'affiliate_street_address' => $affiliate['affiliate_street_address'],
                                'affiliate_suburb' => $affiliate['affiliate_suburb'],
                                'affiliate_city' => $affiliate['affiliate_city'],
                                'affiliate_country' => $affiliate['countries_name'],
                                'affiliate_postcode' => $affiliate['affiliate_postcode'],
                                'affiliate_company' => $affiliate['affiliate_company'],
                                'affiliate_state' => $affiliate['affiliate_state'],
                                'affiliate_address_format_id' => $affiliate['address_format_id']);
        smn_db_perform(TABLE_AFFILIATE_PAYMENT, $sql_data_array);
        $insert_id = smn_db_insert_id(); 
// Set the Sales to Final State 
        smn_db_query("update " . TABLE_AFFILIATE_SALES . " set affiliate_payment_id = '" . $insert_id . "', affiliate_billing_status = 1, affiliate_payment_date = now() where affiliate_id = '" . $affiliate_payment['affiliate_id'] . "' and affiliate_billing_status = 99");

// Notify Affiliate
        if (AFFILIATE_NOTIFY_AFTER_BILLING == 'true') {
          $check_status_query = smn_db_query("select af.affiliate_email_address, ap.affiliate_lastname, ap.affiliate_firstname, ap.affiliate_payment_status, ap.affiliate_payment_date, ap.affiliate_payment_date from " . TABLE_AFFILIATE_PAYMENT . " ap, " . TABLE_AFFILIATE . " af where affiliate_payment_id  = '" . $insert_id . "' and af.affiliate_id = ap.affiliate_id ");
          $check_status = smn_db_fetch_array($check_status_query);
          $email = STORE_NAME . "\n" . EMAIL_SEPARATOR . "\n" . EMAIL_TEXT_AFFILIATE_PAYMENT_NUMBER . ' ' . $insert_id . "\n" . EMAIL_TEXT_INVOICE_URL . ' ' . smn_catalog_href_link(FILENAME_CATALOG_AFFILIATE_PAYMENT_INFO, 'payment_id=' . $insert_id, 'NONSSL') . "\n" . EMAIL_TEXT_PAYMENT_BILLED . ' ' . smn_date_long($check_status['affiliate_payment_date']) . "\n\n" . EMAIL_TEXT_NEW_PAYMENT;
          smn_mail($check_status['affiliate_firstname'] . ' ' . $check_status['affiliate_lastname'], $check_status['affiliate_email_address'], EMAIL_TEXT_SUBJECT, nl2br($email), STORE_OWNER, AFFILIATE_EMAIL_ADDRESS);
        }
      }
      $messageStack->add_session(SUCCESS_BILLING, 'success');

      smn_redirect(smn_href_link(FILENAME_AFFILIATE_PAYMENT, smn_get_all_get_params(array('action')) . 'action=edit'));
      break;
    case 'update_payment':
      $pID = smn_db_prepare_input($_GET['pID']);
      $status = smn_db_prepare_input($_POST['status']);

      $payment_updated = false;
      $check_status_query = smn_db_query("select af.affiliate_email_address, ap.affiliate_lastname, ap.affiliate_firstname, ap.affiliate_payment_status, ap.affiliate_payment_date, ap.affiliate_payment_date from " . TABLE_AFFILIATE_PAYMENT . " ap, " . TABLE_AFFILIATE . " af where affiliate_payment_id = '" . smn_db_input($pID) . "' and af.affiliate_id = ap.affiliate_id ");
      $check_status = smn_db_fetch_array($check_status_query);
      if ($check_status['affiliate_payment_status'] != $status) {
        smn_db_query("update " . TABLE_AFFILIATE_PAYMENT . " set affiliate_payment_status = '" . smn_db_input($status) . "', affiliate_last_modified = now() where affiliate_payment_id = '" . smn_db_input($pID) . "'");
        $affiliate_notified = '0';
// Notify Affiliate
        if ($_POST['notify'] == 'on') {
          $email = STORE_NAME . "\n" . EMAIL_SEPARATOR . "\n" . EMAIL_TEXT_AFFILIATE_PAYMENT_NUMBER . ' ' . $pID . "\n" . EMAIL_TEXT_INVOICE_URL . ' ' . smn_catalog_href_link(FILENAME_CATALOG_AFFILIATE_PAYMENT_INFO, 'payment_id=' . $pID, 'NONSSL') . "\n" . EMAIL_TEXT_PAYMENT_BILLED . ' ' . smn_date_long($check_status['affiliate_payment_date']) . "\n\n" . sprintf(EMAIL_TEXT_STATUS_UPDATE, $payments_status_array[$status]);
          smn_mail($check_status['affiliate_firstname'] . ' ' . $check_status['affiliate_lastname'], $check_status['affiliate_email_address'], EMAIL_TEXT_SUBJECT, nl2br($email), STORE_OWNER, AFFILIATE_EMAIL_ADDRESS);
          $affiliate_notified = '1';
        }

        smn_db_query("insert into " . TABLE_AFFILIATE_PAYMENT_STATUS_HISTORY . " (affiliate_payment_id, affiliate_new_value, affiliate_old_value, affiliate_date_added, affiliate_notified) values ('" . smn_db_input($pID) . "', '" . smn_db_input($status) . "', '" . $check_status['affiliate_payment_status'] . "', now(), '" . $affiliate_notified . "')");
        $order_updated = true;
      }

      if ($order_updated) {
       $messageStack->add_session(SUCCESS_PAYMENT_UPDATED, 'success');
      }

      smn_redirect(smn_href_link(FILENAME_AFFILIATE_PAYMENT, smn_get_all_get_params(array('action')) . 'action=edit'));
      break;
    case 'deleteconfirm':
      $pID = smn_db_prepare_input($_GET['pID']);

      smn_db_query("delete from " . TABLE_AFFILIATE_PAYMENT . " where affiliate_payment_id = '" . smn_db_input($pID) . "'");
      smn_db_query("delete from " . TABLE_AFFILIATE_PAYMENT_STATUS_HISTORY . " where affiliate_payment_id = '" . smn_db_input($pID) . "'");

      smn_redirect(smn_href_link(FILENAME_AFFILIATE_PAYMENT, smn_get_all_get_params(array('pID', 'action'))));
      break;
  }

  if ( ($_GET['action'] == 'edit') && smn_not_null($_GET['pID']) ) {
    $pID = smn_db_prepare_input($_GET['pID']);
    $payments_query = smn_db_query("select p.*,  a.affiliate_payment_check, a.affiliate_payment_paypal, a.affiliate_payment_bank_name, a.affiliate_payment_bank_branch_number, a.affiliate_payment_bank_swift_code, a.affiliate_payment_bank_account_name, a.affiliate_payment_bank_account_number from " .  TABLE_AFFILIATE_PAYMENT . " p, " . TABLE_AFFILIATE . " a where affiliate_payment_id = '" . smn_db_input($pID) . "' and a.affiliate_id = p.affiliate_id");
    $payments_exists = true;
    if (!$payments = smn_db_fetch_array($payments_query)) {
      $payments_exists = false;
      $messageStack->add(sprintf(ERROR_PAYMENT_DOES_NOT_EXIST, $pID), 'error');
    }
  }
  
  $content_page = basename($_SERVER['PHP_SELF']);
  
  require('templates/default/layout.php');

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>