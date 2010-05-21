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
<link href="style.css" rel="stylesheet" type="text/css">
<table border="0" width="600" height="100%" cellspacing="0" cellpadding="0" align="center" valign="middle" style="padding-top:40px;">
  <tr>
    <td><table border="0" width="600" height="440" cellspacing="0" cellpadding="1" align="center" valign="middle">
      <tr bgcolor="#000000">
        <td><table border="0" width="600" height="440" cellspacing="0" cellpadding="0">
          <tr bgcolor="#ffffff" height="50">
            <td height="50"><?php echo smn_info_image(STORE_LOGO, STORE_NAME, '200', ''); ?></td>
            <td align="right" class="text" nowrap><?php echo '<a class="text" href="' . smn_href_link(FILENAME_DEFAULT) . '">' . HEADER_TITLE_ADMINISTRATION . '</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a class="text" href="' . smn_catalog_href_link() . '">' . HEADER_TITLE_ONLINE_CATALOG . '</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a class="text" href="http://www.systemsmanager.net" target="_blank">' . HEADER_TITLE_SUPPORT_SITE . '</a>'; ?>&nbsp;&nbsp;</td>
          </tr>
    <?php
       if ($super_user == 'true'){
?>
   <tr bgcolor="#ffffff" height="50">
   <td class="headerBarContent">&nbsp;Currently Working in Store :<br><b>&nbsp;<?php echo $store->get_store_name(); ?></b></td>

<?php 
          $groups_array = array(array('id' => '0', 'text' => TEXT_NONE));
          $groups_query = smn_db_query("select store_id, store_name from " . TABLE_STORE_DESCRIPTION);
            while ($groups = smn_db_fetch_array($groups_query))
            {
             $groups_array[] = array('id' => $groups['store_id'],
                                'text' => $groups['store_name']);
            }
          echo smn_draw_form('store', FILENAME_ADMIN_MEMBERS, '', 'post'); ?>
         <td class="headerBarContent" align="right">Switch to New Store : <?php echo smn_draw_pull_down_menu('store', $groups_array, $groups_selected, 'onChange="this.form.submit();"'); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
</tr>

</form>
<?php
}
?>      
          <tr bgcolor="#ffffff">
            <td colspan="2"><table border="0" width="460" height="390" cellspacing="0" cellpadding="2">
              <tr valign="top">
                <td width="140" valign="top"><table border="0" width="140" height="390" cellspacing="0" cellpadding="2">
                  <tr>
                    <td valign="top"><br>
<?php
  $heading = array();
  $contents = array();

  $heading[] = array('params' => 'class="menuBoxHeading"',
                     'text'  => 'oscMall System');

  $contents[] = array('params' => 'class="infoBox"',
                      'text'  => '<a href="http://download.systemsmanager.net" target="_blank">' . BOX_ENTRY_SUPPORT_SITE . '</a><br>' .
                                 '<a href="http://forum.systemsmanager.net/" target="_blank">' . BOX_ENTRY_SUPPORT_FORUMS . '</a><br>' .
                                 '<a href="http://www.systemsmanager.net/" target="_blank">' . BOX_ENTRY_MAILING_LISTS . '</a><br>' .
                                 '<a href="http://forum.systemsmanager.net/" target="_blank">' . BOX_ENTRY_BUG_REPORTS . '</a><br>' .
                                 '<a href="javascript:popupWindow(\'' .  DIR_WS_HELP . FILENAME_POPUP_HELP . '?HelpID=' . str_replace('.php', '', basename($PHP_SELF)) . '\')">' . BOX_ENTRY_INFORMATION_PORTAL . '</a>');

  $box = new box;
  echo $box->menuBox($heading, $contents);

  echo '<br>';

  $orders_contents = '';
  $orders_status_query = smn_db_query("select orders_status_name, orders_status_id from " . TABLE_ORDERS_STATUS . " where language_id = '" . $languages_id . "'");
  while ($orders_status = smn_db_fetch_array($orders_status_query)) {
    $orders_pending_query = smn_db_query("select count(*) as count from " . TABLE_ORDERS . " where orders_status = '" . $orders_status['orders_status_id'] . "' and store_id = '" .$store_id . "'");
    $orders_pending = smn_db_fetch_array($orders_pending_query);
    $orders_contents .= '<a href="' . smn_href_link(FILENAME_ORDERS, 'selected_box=customers&status=' . $orders_status['orders_status_id']) . '">' . $orders_status['orders_status_name'] . '</a>: ' . $orders_pending['count'] . '<br>';
  }
  $orders_contents = substr($orders_contents, 0, -4);

  $heading = array();
  $contents = array();

  $heading[] = array('params' => 'class="menuBoxHeading"',
                     'text'  => BOX_TITLE_ORDERS);

  $contents[] = array('params' => 'class="infoBox"',
                      'text'  => $orders_contents);

  $box = new box;
  echo $box->menuBox($heading, $contents);

  echo '<br>';

  $customers_query = smn_db_query("select count(*) as count from " . TABLE_CUSTOMERS);
  $customers = smn_db_fetch_array($customers_query);
  $products_query = smn_db_query("select count(*) as count from " . TABLE_PRODUCTS . " where products_status = '1' and store_id = '" .$store_id . "'");
  $products = smn_db_fetch_array($products_query);
  $reviews_query = smn_db_query("select count(*) as count from " . TABLE_REVIEWS . " where store_id = '" .$store_id . "'");
  $reviews = smn_db_fetch_array($reviews_query);

  $heading = array();
  $contents = array();

  $heading[] = array('params' => 'class="menuBoxHeading"',
                     'text'  => BOX_TITLE_STATISTICS);

  $contents[] = array('params' => 'class="infoBox"',
                      'text'  => BOX_ENTRY_CUSTOMERS . ' ' . $customers['count'] . '<br>' .
                                 BOX_ENTRY_PRODUCTS . ' ' . $products['count'] . '<br>' .
                                 BOX_ENTRY_REVIEWS . ' ' . $reviews['count']);

  $box = new box;
  echo $box->menuBox($heading, $contents);

  echo '<br>';

  $contents = array();

  if (getenv('HTTPS') == 'on') {
    $size = ((getenv('SSL_CIPHER_ALGKEYSIZE')) ? getenv('SSL_CIPHER_ALGKEYSIZE') . '-bit' : '<i>' . BOX_CONNECTION_UNKNOWN . '</i>');
    $contents[] = array('params' => 'class="infoBox"',
                        'text' => smn_image(DIR_WS_ICONS . 'locked.gif', ICON_LOCKED, '', '', 'align="right"') . sprintf(BOX_CONNECTION_PROTECTED, $size));
  } else {
    $contents[] = array('params' => 'class="infoBox"',
                        'text' => smn_image(DIR_WS_ICONS . 'unlocked.gif', ICON_UNLOCKED, '', '', 'align="right"') . BOX_CONNECTION_UNPROTECTED);
  }

  $box = new box;
  echo $box->tableBlock($contents);
?>
                    </td>
                  </tr>
                </table></td>
                <td width="460"><table border="0" width="460" height="390" cellspacing="0" cellpadding="2">
                  <tr>
                    <td colspan="2"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                      <tr><?php echo smn_draw_form('languages', 'index.php', '', 'get'); ?>
                        <td class="heading"><?php echo HEADING_TITLE; ?></td>
                        <td align="right"><?php echo smn_draw_pull_down_menu('language', $languages_array, $languages_selected, 'onChange="this.form.submit();"'); ?></td>
                      <?php echo smn_hide_session_id(); ?></form></tr>
                    </table></td>
                  </tr>
<?php
  $col = 2;
  $counter = 0;
  for ($i = 0, $n = sizeof($cat); $i < $n; $i++) {
    if ($cat[$i]['access'] == true) {
    $counter++;
    if ($counter < $col) {
      echo '                  <tr>' . "\n";
    }

    echo '                    <td><table border="0" cellspacing="0" cellpadding="2">' . "\n" .
         '                      <tr>' . "\n" .
         '                        <td><a href="' . $cat[$i]['href'] . '"></a></td>' . "\n" .
         '                        <td><table border="0" cellspacing="0" cellpadding="1">' . "\n" .
         '                          <tr>' . "\n" .
         '                            <td class="main"><a href="' . $cat[$i]['href'] . '" class="main">' . $cat[$i]['title'] . '</a></td>' . "\n" .
         '                          </tr>' . "\n" .
         '                          <tr>' . "\n" .
         '                            <td class="sub_false">';

    $children = '';
    for ($j = 0, $k = sizeof($cat[$i]['children']); $j < $k; $j++) {
      if ($cat[$i]['children'][$j]['access'] == true) {
        $children .= '<a href="' . $cat[$i]['children'][$j]['link'] . '" class="sub">' . $cat[$i]['children'][$j]['title'] . '</a>, ';
      } else {
        $children .= '' . $cat[$i]['children'][$j]['title'] . ', ';
      }
    }
    echo substr($children, 0, -2);

    echo '</td> ' . "\n" .
         '                          </tr>' . "\n" .
         '                        </table></td>' . "\n" .
         '                      </tr>' . "\n" .
         '                    </table></td>' . "\n";

    if ($counter >= $col) {
      echo '                  </tr>' . "\n";
      $counter = 0;
    }
    } elseif ($cat[$i]['access'] == false) {
    $counter++;
    if ($counter < $col) {
      echo '                  <tr>' . "\n";
    }

    echo '                    <td><table border="0" cellspacing="0" cellpadding="2">' . "\n" .
         '                      <tr>' . "\n" .
         '                        <td><table border="0" cellspacing="0" cellpadding="1">' . "\n" .
         '                          <tr>' . "\n" .
         '                            <td class="main_false">' . $cat[$i]['title'] . '</td>' . "\n" .
         '                          </tr>' . "\n" .
         '                          <tr>' . "\n" .
         '                            <td class="sub_false">';

    $children = '';
    for ($j = 0, $k = sizeof($cat[$i]['children']); $j < $k; $j++) {
      $children .= '' . $cat[$i]['children'][$j]['title'] . ', ';
    }
    echo substr($children, 0, -2);

    echo '</td> ' . "\n" .
         '                          </tr>' . "\n" .
         '                        </table></td>' . "\n" .
         '                      </tr>' . "\n" .
         '                    </table></td>' . "\n";

    if ($counter >= $col) {
      echo '                  </tr>' . "\n";
      $counter = 0;
    }
    }    
  }
?>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php require(DIR_WS_INCLUDES . 'footer.php'); ?></td>
      </tr>
    </table></td>
  </tr>
</table>