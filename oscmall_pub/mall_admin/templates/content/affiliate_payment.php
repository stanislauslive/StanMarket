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
<table border="0" width="100%" cellspacing="0" cellpadding="0">
<?php
  if ( ($_GET['action'] == 'edit') && ($payments_exists) ) {
    $affiliate_address['firstname'] = $payments['affiliate_firstname'];
    $affiliate_address['lastname'] = $payments['affiliate_lastname'];
    $affiliate_address['street_address'] = $payments['affiliate_street_address'];
    $affiliate_address['suburb'] = $payments['affiliate_suburb'];
    $affiliate_address['city'] = $payments['affiliate_city'];
    $affiliate_address['state'] = $payments['affiliate_state'];
    $affiliate_address['country'] = $payments['affiliate_country'];
    $affiliate_address['postcode'] = $payments['affiliate_postcode'];
?>
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
          </tr>
        </table></td>
      </tr>
          <tr>
            <td align="right"><?php echo '<a href="' . smn_href_link(FILENAME_AFFILIATE_PAYMENT, smn_get_all_get_params(array('action'))) . '">' . smn_image_button('button_back.gif', IMAGE_BACK) . '</a>'; ?></td>
          </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td colspan="2"><?php echo smn_draw_separator(); ?></td>
          </tr>
          <tr>
            <td valign="top"><table border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td class="main" valign="top"><b><?php echo TEXT_AFFILIATE; ?></b></td>
                <td class="main"><?php echo smn_address_format($payments['affiliate_address_format_id'], $affiliate_address, 1, '&nbsp;', '<br>'); ?></td>
              </tr>
              <tr>
                <td colspan="2"><?php echo smn_draw_separator('pixel_trans.gif', '1', '5'); ?></td>
              </tr>
              <tr>
                <td colspan="2"><?php echo smn_draw_separator('pixel_trans.gif', '1', '5'); ?></td>
              </tr>
              <tr>
                <td class="main"><b><?php echo TEXT_AFFILIATE_PAYMENT; ?></b></td>
                <td class="main">&nbsp;<?php echo $currencies->format($payments['affiliate_payment_total']); ?></td>
              </tr>
              <tr>
                <td colspan="2"><?php echo smn_draw_separator('pixel_trans.gif', '1', '5'); ?></td>
              </tr>
              <tr>
                <td class="main"><b><?php echo TEXT_AFFILIATE_BILLED; ?></b></td>
                <td class="main">&nbsp;<?php echo smn_date_short($payments['affiliate_payment_date']); ?></td>
              </tr>
              <tr>
                <td colspan="2"><?php echo smn_draw_separator('pixel_trans.gif', '1', '5'); ?></td>
              </tr>
              <tr>
                <td class="main" valign="top"><b><?php echo TEXT_AFFILIATE_PAYING_POSSIBILITIES; ?></b></td>
                <td class="main"><table border="1" cellspacing="0" cellpadding="5">
                  <tr>
<?php
  if (AFFILIATE_USE_BANK == 'true') {
?>
                    <td class="main"  valign="top"><?php echo '<b>' . TEXT_AFFILIATE_PAYMENT_BANK_TRANSFER . '</b><br><br>' . TEXT_AFFILIATE_PAYMENT_BANK_NAME . ' ' . $payments['affiliate_payment_bank_name'] . '<br>' . TEXT_AFFILIATE_PAYMENT_BANK_BRANCH_NUMBER . ' ' . $payments['affiliate_payment_bank_branch_number'] . '<br>' . TEXT_AFFILIATE_PAYMENT_BANK_SWIFT_CODE . ' ' . $payments['affiliate_payment_bank_swift_code'] . '<br>' . TEXT_AFFILIATE_PAYMENT_BANK_ACCOUNT_NAME . ' ' . $payments['affiliate_payment_bank_account_name'] . '<br>' . TEXT_AFFILIATE_PAYMENT_BANK_ACCOUNT_NUMBER . ' ' . $payments['affiliate_payment_bank_account_number'] . '<br>'; ?></td>
<?php
  }
  if (AFFILIATE_USE_PAYPAL == 'true') {
?>
                    <td class="main"  valign="top"><?php echo '<b>' . TEXT_AFFILIATE_PAYMENT_PAYPAL . '</b><br><br>' . TEXT_AFFILIATE_PAYMENT_PAYPAL_EMAIL . '<br>' . $payments['affiliate_payment_paypal'] . '<br>'; ?></td>
<?php
  }
  if (AFFILIATE_USE_CHECK == 'true') {
?>
                    <td class="main"  valign="top"><?php echo '<b>' . TEXT_AFFILIATE_PAYMENT_CHECK . '</b><br><br>' . TEXT_AFFILIATE_PAYMENT_CHECK_PAYEE . '<br>' . $payments['affiliate_payment_check'] . '<br>'; ?></td>
<?php
  }
?>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
<?php echo smn_draw_form('status', FILENAME_AFFILIATE_PAYMENT, smn_get_all_get_params(array('action')) . 'action=update_payment'); ?>
        <td><table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td><table border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td class="main"><b><?php echo PAYMENT_STATUS; ?></b> <?php echo smn_draw_pull_down_menu('status', $payments_statuses, $payments['affiliate_payment_status']); ?></td>
              </tr>
              <tr>
                <td class="main"><b><?php echo PAYMENT_NOTIFY_AFFILIATE; ?></b><?php echo smn_draw_checkbox_field('notify', '', true); ?></td>
              </tr>
            </table></td>
            <td valign="top"><?php echo smn_image_submit('button_update.gif', IMAGE_UPDATE); ?></td>
          </tr>
        </table></td>
      </form></tr>

      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><table border="1" cellspacing="0" cellpadding="5">
          <tr>
            <td class="smallText" align="center"><b><?php echo TABLE_HEADING_NEW_VALUE; ?></b></td>
            <td class="smallText" align="center"><b><?php echo TABLE_HEADING_OLD_VALUE; ?></b></td>
            <td class="smallText" align="center"><b><?php echo TABLE_HEADING_DATE_ADDED; ?></b></td>
            <td class="smallText" align="center"><b><?php echo TABLE_HEADING_AFFILIATE_NOTIFIED; ?></b></td>
          </tr>
<?php
    $affiliate_history_query = smn_db_query("select affiliate_new_value, affiliate_old_value, affiliate_date_added, affiliate_notified from " . TABLE_AFFILIATE_PAYMENT_STATUS_HISTORY . " where affiliate_payment_id = '" . smn_db_input($pID) . "' order by affiliate_status_history_id desc");
    if (smn_db_num_rows($affiliate_history_query)) {
      while ($affiliate_history = smn_db_fetch_array($affiliate_history_query)) {
        echo '          <tr>' . "\n" .
             '            <td class="smallText">' . $payments_status_array[$affiliate_history['affiliate_new_value']] . '</td>' . "\n" .
             '            <td class="smallText">' . (smn_not_null($affiliate_history['affiliate_old_value']) ? $payments_status_array[$affiliate_history['affiliate_old_value']] : '&nbsp;') . '</td>' . "\n" .
             '            <td class="smallText" align="center">' . smn_date_short($affiliate_history['affiliate_date_added']) . '</td>' . "\n" .
             '            <td class="smallText" align="center">';
        if ($affiliate_history['affiliate_notified'] == '1') {
          echo smn_image(DIR_WS_ICONS . 'tick.gif', ICON_TICK);
        } else {
          echo smn_image(DIR_WS_ICONS . 'cross.gif', ICON_CROSS);
        }
        echo '          </tr>' . "\n";
      }
    } else {
        echo '          <tr>' . "\n" .
             '            <td class="smallText" colspan="4">' . TEXT_NO_PAYMENT_HISTORY . '</td>' . "\n" .
             '          </tr>' . "\n";
    }
?>
        </table></td>
      </tr>
      <tr>
        <td colspan="2" align="right"><?php echo '<a href="' . smn_href_link(FILENAME_AFFILIATE_INVOICE, 'pID=' . $_GET['pID']) . '" TARGET="_blank">' . smn_image_button('button_invoice.gif', IMAGE_ORDERS_INVOICE) . '</a> <a href="' . smn_href_link(FILENAME_AFFILIATE_PAYMENT, smn_get_all_get_params(array('action'))) . '">' . smn_image_button('button_back.gif', IMAGE_BACK) . '</a>'; ?></td>
      </tr>
<?php
  } else {
?>
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
           </tr>
        </table></td>
      </tr>
           <tr>
            <td align="right"><table>
             <tr>
              <td><?php echo '<a href="' . smn_href_link(FILENAME_AFFILIATE_PAYMENT, 'pID=' . $pInfo->affiliate_payment_id. '&action=start_billing' ) . '">' . smn_image_button('button_affiliate_billing.gif', IMAGE_AFFILIATE_BILLING) . '</a>'; ?></td>
              <td align="right"><?php echo smn_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>
              <td align="right"><table border="0" width="100%" cellspacing="0" cellpadding="0">
               <tr><?php echo smn_draw_form('orders', FILENAME_AFFILIATE_PAYMENT, '', 'get'); ?>
                 <td class="smallText" align="right"><?php echo HEADING_TITLE_SEARCH . ' ' . smn_draw_input_field('sID', '', 'size="12"') . smn_draw_hidden_field('action', 'edit'); ?></td>
               </form></tr>
               <tr><?php echo smn_draw_form('status', FILENAME_AFFILIATE_PAYMENT, '', 'get'); ?>
                 <td class="smallText" align="right"><?php echo HEADING_TITLE_STATUS . ' ' . smn_draw_pull_down_menu('status', array_merge(array(array('id' => '', 'text' => TEXT_ALL_PAYMENTS)), $payments_statuses), '', 'onChange="this.form.submit();"'); ?></td>
               </form></tr>
             </table></td>
           </tr>
          </table></td>
         </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_AFILIATE_NAME; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_NET_PAYMENT; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_PAYMENT; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_DATE_BILLED; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
    if ($_GET['sID']) {
      // Search only payment_id by now
      $sID = smn_db_prepare_input($_GET['sID']);
      $payments_query_raw = "select p.* , s.affiliate_payment_status_name from " . TABLE_AFFILIATE_PAYMENT . " p , " . TABLE_AFFILIATE_PAYMENT_STATUS . " s where p.affiliate_payment_id = '" . smn_db_input($sID) . "' and p.affiliate_payment_status = s.affiliate_payment_status_id and s.affiliate_language_id = '" . $languages_id . "' order by p.affiliate_payment_id DESC";
    } elseif (is_numeric($_GET['status'])) {
      $status = smn_db_prepare_input($_GET['status']);
      $payments_query_raw = "select p.* , s.affiliate_payment_status_name from " . TABLE_AFFILIATE_PAYMENT . " p , " . TABLE_AFFILIATE_PAYMENT_STATUS . " s where s.affiliate_payment_status_id = '" . smn_db_input($status) . "' and p.affiliate_payment_status = s.affiliate_payment_status_id and s.affiliate_language_id = '" . $languages_id . "' order by p.affiliate_payment_id DESC";
    } else {
      $payments_query_raw = "select p.* , s.affiliate_payment_status_name from " . TABLE_AFFILIATE_PAYMENT . " p , " . TABLE_AFFILIATE_PAYMENT_STATUS . " s where p.affiliate_payment_status = s.affiliate_payment_status_id and s.affiliate_language_id = '" . $languages_id . "' order by p.affiliate_payment_id DESC";
    }
    $payments_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $payments_query_raw, $payments_query_numrows);
    $payments_query = smn_db_query($payments_query_raw);
    while ($payments = smn_db_fetch_array($payments_query)) {
      if (((!$_GET['pID']) || ($_GET['pID'] == $payments['affiliate_payment_id'])) && (!$pInfo)) {
        $pInfo = new objectInfo($payments);
      }

      if ( (is_object($pInfo)) && ($payments['affiliate_payment_id'] == $pInfo->affiliate_payment_id) ) {
        echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . smn_href_link(FILENAME_AFFILIATE_PAYMENT, smn_get_all_get_params(array('pID', 'action')) . 'pID=' . $pInfo->affiliate_payment_id . '&action=edit') . '\'">' . "\n";
      } else {
        echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . smn_href_link(FILENAME_AFFILIATE_PAYMENT, smn_get_all_get_params(array('pID')) . 'pID=' . $payments['affiliate_payment_id']) . '\'">' . "\n";
      }
?>
                <td class="dataTableContent"><?php echo '<a href="' . smn_href_link(FILENAME_AFFILIATE_PAYMENT, smn_get_all_get_params(array('pID', 'action')) . 'pID=' . $pInfo->affiliate_payment_id . '&action=edit') . '">' . smn_image(DIR_WS_ICONS . 'preview.gif', ICON_PREVIEW) . '</a>&nbsp;' . $payments['affiliate_firstname'] . ' ' . $payments['affiliate_lastname']; ?></td>
                <td class="dataTableContent" align="right"><?php echo $currencies->format(strip_tags($payments['affiliate_payment'])); ?></td>
                <td class="dataTableContent" align="right"><?php echo $currencies->format(strip_tags($payments['affiliate_payment'] + $payments['affiliate_payment_tax'])); ?></td>
                <td class="dataTableContent" align="center"><?php echo smn_date_short($payments['affiliate_payment_date']); ?></td>
                <td class="dataTableContent" align="right"><?php echo $payments['affiliate_payment_status_name']; ?></td>
                <td class="dataTableContent" align="right"><?php if ( (is_object($pInfo)) && ( $payments['affiliate_payment_id'] == $pInfo->affiliate_payment_id) ) { echo smn_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . smn_href_link(FILENAME_AFFILIATE_PAYMENT, smn_get_all_get_params(array('pID')) . 'pID=' . $payments['affiliate_payment_id']) . '">' . smn_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    }
?>
              <tr>
                <td colspan="6"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $payments_split->display_count($payments_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_PAYMENTS); ?></td>
                    <td class="smallText" align="right"><?php echo $payments_split->display_links($payments_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], smn_get_all_get_params(array('page', 'pID', 'action'))); ?></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
<?php
  $heading = array();
  $contents = array();
  switch ($_GET['action']) {
    case 'delete':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_PAYMENT . '</b>');

      $contents = array('form' => smn_draw_form('payment', FILENAME_AFFILIATE_PAYMENT, smn_get_all_get_params(array('pID', 'action')) . 'pID=' . $pInfo->affiliate_payment_id. '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO . '<br>');
      $contents[] = array('align' => 'center', 'text' => '<br>' . smn_image_submit('button_delete.gif', IMAGE_DELETE) . ' <a href="' . smn_href_link(AFFILIATE_PAYMENT, smn_get_all_get_params(array('pID', 'action')) . 'pID=' . $pInfo->affiliate_payment_id) . '">' . smn_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;
    default:
      if (is_object($pInfo)) {
        $heading[] = array('text' => '<b>[' . $pInfo->affiliate_payment_id . ']&nbsp;&nbsp;' . smn_datetime_short($pInfo->affiliate_payment_date) . '</b>');

        $contents[] = array('align' => 'center', 'text' => '<a href="' . smn_href_link(FILENAME_AFFILIATE_PAYMENT, smn_get_all_get_params(array('pID', 'action')) . 'pID=' . $pInfo->affiliate_payment_id . '&action=edit') . '">' . smn_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . smn_href_link(FILENAME_AFFILIATE_PAYMENT, smn_get_all_get_params(array('pID', 'action')) . 'pID=' . $pInfo->affiliate_payment_id  . '&action=delete') . '">' . smn_image_button('button_delete.gif', IMAGE_DELETE) . '</a>');
        $contents[] = array('align' => 'center', 'text' => '<a href="' . smn_href_link(FILENAME_AFFILIATE_INVOICE, 'pID=' . $pInfo->affiliate_payment_id ) . '" TARGET="_blank">' . smn_image_button('button_invoice.gif', IMAGE_ORDERS_INVOICE) . '</a> ');
      }
      break;
  }

  if ( (smn_not_null($heading)) && (smn_not_null($contents)) ) {
    echo '            <td  width="25%" valign="top">' . "\n";

    $box = new box;
    echo $box->infoBox($heading, $contents);

    echo '            </td>' . "\n";
  }
?>
          </tr>
        </table></td>
      </tr>
<?php
  }
?>
    </table>