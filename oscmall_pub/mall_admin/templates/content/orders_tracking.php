<?php
/*
  Copyright (c) 2003 - 2005 SystemsManager.Net
  SystemsManager Technologies
  Sales Reporter 3
  http://www.systemsmanager.net
  
  Portions Copyright (c) 2002 osCommerce
  
  This source file is subject to version 2.0 of the GPL license,   
  that is bundled with this package in the file LICENSE. If you
  did not receive a copy of the oscMall System license and are unable 
  to obtain it through the world-wide-web, please send a note to    
  license@systemsmanager.net so we can mail you a copy immediately. 
  
  possible views (srView):
  1 yearly
  2 monthly
  3 weekly
  4 daily
  
  possible options (srDetail):
  0 no detail
  1 show details (products)
  2 show details only (products)
  
  export
  0 normal view
  1 html view without left and right
  2 csv
  
  sort
  0 no sorting
  1 product description asc
  2 product description desc
  3 #product asc, product descr asc
  4 #product desc, product descr desc
  5 revenue asc, product descr asc
  6 revenue desc, product descr desc
  
*/

  require('includes/application_top.php');

  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

  // default detail no detail
  $srDefaultDetail = 0;
  // default view (daily)
  $srDefaultView = 2;
  // default export
  $srDefaultExp = 0;
  // default sort
  $srDefaultSort = 4;
  //set default download
  $srDownload = 'false';
  //set default download file created
  $file_created = 'false';
  
  
  // report views (1: yearly 2: monthly 3: weekly 4: daily)
  if ( ($HTTP_GET_VARS['report']) && (smn_not_null($HTTP_GET_VARS['report'])) ) {
    $srView = $HTTP_GET_VARS['report'];
  }
  if ($srView < 1 || $srView > 4) {
    $srView = $srDefaultView;
  }

  // detail
  if ( ($HTTP_GET_VARS['detail']) && (smn_not_null($HTTP_GET_VARS['detail'])) ) {
    $srDetail = $HTTP_GET_VARS['detail'];
  }
  if ($srDetail < 0 || $srDetail > 2) {
    $srDetail = $srDefaultDetail;
  }
  
  // report views (1: yearly 2: monthly 3: weekly 4: daily)
  if ( ($HTTP_GET_VARS['export']) && (smn_not_null($HTTP_GET_VARS['export'])) ) 
{    $srExp = $HTTP_GET_VARS['export'];
  }
  if ($srExp < 0 || $srExp > 3) {
    $srExp = $srDefaultExp;
  }
  elseif (($srExp == 2) || ($srExp == 3))
  {
    $srDownload = 'true';
  }
  
  // item_level
  if ( ($HTTP_GET_VARS['max']) && (smn_not_null($HTTP_GET_VARS['max'])) ) {
    $srMax = $HTTP_GET_VARS['max'];
  }
  if (!is_numeric($srMax)) {
    $srMax = 0;
  }
      
  // order status
  if ( ($HTTP_GET_VARS['status']) && (smn_not_null($HTTP_GET_VARS['status'])) ) {
    $srStatus = $HTTP_GET_VARS['status'];
  }
  if (!is_numeric($srStatus)) {
    $srStatus = 0;
  }
  
  // sort
  if ( ($HTTP_GET_VARS['sort']) && (smn_not_null($HTTP_GET_VARS['sort'])) ) {
    $srSort = $HTTP_GET_VARS['sort'];
  }
  if ($srSort < 1 || $srSort > 6) {
    $srSort = $srDefaultSort;
  }
  
  
    
  // check start and end Date
  $startDate = "";
  $startDateG = 0;
  if ( ($HTTP_GET_VARS['startD']) && (smn_not_null($HTTP_GET_VARS['startD'])) ) {
    $sDay = $HTTP_GET_VARS['startD'];
    $startDateG = 1;
  } else {
    $sDay = 1;
  }
  if ( ($HTTP_GET_VARS['startM']) && (smn_not_null($HTTP_GET_VARS['startM'])) ) {
    $sMon = $HTTP_GET_VARS['startM'];
    $startDateG = 1;
  } else {
    $sMon = 1;
  }
  if ( ($HTTP_GET_VARS['startY']) && (smn_not_null($HTTP_GET_VARS['startY'])) ) {
    $sYear = $HTTP_GET_VARS['startY'];
    $startDateG = 1;
  } else {
    $sYear = date("Y");
  }
  if ($startDateG) {
    $startDate = mktime(0, 0, 0, $sMon, $sDay, $sYear);
  } else {
    $startDate = mktime(0, 0, 0, date("m"), 1, date("Y"));
  }
    
  $endDate = "";
  $endDateG = 0;
  if ( ($HTTP_GET_VARS['endD']) && (smn_not_null($HTTP_GET_VARS['endD'])) ) {
    $eDay = $HTTP_GET_VARS['endD'];
    $endDateG = 1;
  } else {
    $eDay = 1;
  }
  if ( ($HTTP_GET_VARS['endM']) && (smn_not_null($HTTP_GET_VARS['endM'])) ) {
    $eMon = $HTTP_GET_VARS['endM'];
    $endDateG = 1;
  } else {
    $eMon = 1;
  }
  if ( ($HTTP_GET_VARS['endY']) && (smn_not_null($HTTP_GET_VARS['endY'])) ) {
    $eYear = $HTTP_GET_VARS['endY'];
    $endDateG = 1;
  } else {
    $eYear = date("Y");
  }
  if ($endDateG) {
    $endDate = mktime(0, 0, 0, $eMon, $eDay + 1, $eYear);
  } else {
    $endDate = mktime(0, 0, 0, date("m"), date("d") + 1, date("Y"));
  }
  /**/
  if ( ($HTTP_GET_VARS['separator']) && (smn_not_null($HTTP_GET_VARS['separator'])) ) 
    $srSeparator= $HTTP_GET_VARS['separator'];

                       
  if ( ($HTTP_GET_VARS['billing']) && (smn_not_null($HTTP_GET_VARS['billing'])) ) 
    $srBilling= $HTTP_GET_VARS['billing'];

                       
  if ( ($HTTP_GET_VARS['delivery']) && (smn_not_null($HTTP_GET_VARS['delivery'])) ) 
    $srDelivery= $HTTP_GET_VARS['delivery'];

      
  if ( ($HTTP_GET_VARS['customer']) && (smn_not_null($HTTP_GET_VARS['customer'])) ) 
  $srCustomer= $HTTP_GET_VARS['customer'];


  require(DIR_WS_CLASSES . FILENAME_ORDERS_TRACKING);
  $sr = new sales_report($srView, $startDate, $endDate, $srSort, $srStatus, $srFilter);
  $startDate = $sr->startDate;
  $endDate = $sr->endDate;

 if ($srExp == 2) {
     $file_created = $sr-> DownloadFile($srStatus, $startDate, $endDate, $srDownload, $srCustomer, $srDelivery, $srSeparator, $srBilling);
     if ($file_created == 'true'){
        header('Content-type: application/x-octet-stream');
        header('Content-disposition: attachment; filename=orders.csv');
        readfile(DIR_FS_ADMIN .'orders.csv');
        unlink(DIR_FS_ADMIN .'orders.csv');
     }
 }elseif ($srExp == 3){
    
     $OrderFilterString = 'order by date, orders_id, store_id';
     $StatusFilterString = '';
     $file_created = $sr-> DownloadOrdersFile($srStatus, $startDate, $endDate, $srDownload, $StatusFilterString, $OrderFilterString);
     if ($file_created == 'true') {
        header('Content-type: application/x-octet-stream');
        header('Content-disposition: attachment; filename=orders.html');
        readfile(DIR_FS_ADMIN .'orders.html');
        unlink(DIR_FS_ADMIN .'orders.html');
     }
 }
  if ($srExp < 2) {
    // not for csv export
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=<?php echo 
CHARSET; ?>">  <title><?php echo TITLE; ?></title>
  <link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF"><!-- header //-->
<?php
    if ($srExp < 1) {
      require(DIR_WS_INCLUDES . 'header.php');
    }
?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
<?php
    if ($srExp < 1) {
?>
    <td width="<?php echo BOX_WIDTH; ?>" valign="top">
      <table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1"cellpadding="1" class="columnLeft">
      <!-- left_navigation //-->
<?php
      require(DIR_WS_INCLUDES . 'column_left.php');
?>
      <!-- left_navigation_eof //-->
      </table>
    </td>
<!-- body_text //-->
<?php
    } // end sr_exp
?>
    <td width="100%" valign="top">
      <table border="0" width="100%" cellspacing="0" cellpadding="2">
        <tr>
          <td colspan=2>
            <table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
              </tr>
            </table>
          </td>
        </tr>
<?php
    if ($srExp < 1) {
      echo smn_draw_form('orders_tracking', FILENAME_ORDERS_TRACKING, '', 'get');
?>
        <tr>
          <td colspan="2">
              <table border="0" width="100%" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="left" rowspan="2" class="menuBoxHeading">
                    <input type="radio" name="report" value="1" <?php if ($srView == 1) echo "checked"; ?>><?php echo REPORT_TYPE_YEARLY; ?><br>
                    <input type="radio" name="report" value="2" <?php if ($srView == 2) echo "checked"; ?>><?php echo REPORT_TYPE_MONTHLY; ?><br>
                    <input type="radio" name="report" value="3" <?php if ($srView == 3) echo "checked"; ?>><?php echo REPORT_TYPE_WEEKLY; ?><br>
                    <input type="radio" name="report" value="4" <?php if ($srView == 4) echo "checked"; ?>><?php echo REPORT_TYPE_DAILY; ?><br>
                  </td>
                  <td class="menuBoxHeading">
<?php echo REPORT_START_DATE; ?><br>
                    <select name="startD" size="1">
<?php
      if ($startDate) {
        $j = date("j", $startDate);
      } else {
        $j = 1;
      }
      for ($i = 1; $i < 32; $i++) {
?>
                        <option<?php if ($j == $i) echo " selected"; ?>><?php echo $i; ?></option>
<?php
      }
?>
                    </select>
                    <select name="startM" size="1">
<?php
      if ($startDate) {
        $m = date("n", $startDate);
      } else {
        $m = 1;
      }
      for ($i = 1; $i < 13; $i++) {
?>
                      <option<?php if ($m == $i) echo " selected"; ?> value="<?php echo $i; ?>"><?php echo strftime("%B", mktime(0, 0, 0, $i, 1)); ?></option>
<?php
      }
?>
                    </select>
                    <select name="startY" size="1">
<?php
      if ($startDate) {
        $y = date("Y") - date("Y", $startDate);
      } else {
        $y = 0;
      }
      for ($i = 10; $i >= 0; $i--) {
?>
                      <option<?php if ($y == $i) echo " selected"; ?>><?php echo date("Y") - $i; ?></option>
<?php
    }
?>
                    </select>
                  </td>
                  <td rowspan="2" align="left" class="menuBoxHeading">
                    <?php echo REPORT_DETAIL; ?><br>
                    <select name="detail" size="1">
                      <option value="0"<?php if ($srDetail == 0) echo "selected"; ?>><?php echo DET_HEAD_ONLY; ?></option>
                      <option value="1"<?php if ($srDetail == 1) echo " selected"; ?>><?php echo DET_DETAIL; ?></option>
                      <option value="2"<?php if ($srDetail == 2) echo " selected"; ?>><?php echo DET_DETAIL_ONLY; ?></option>
                    </select><br>
<?php echo REPORT_MAX; ?><br>
                    <select name="max" size="1">
                      <option value="0"><?php echo REPORT_ALL; ?></option>
                      <option<?php if ($srMax == 1) echo " selected"; ?>>1</option>
                      <option<?php if ($srMax == 3) echo " selected"; ?>>3</option>
                      <option<?php if ($srMax == 5) echo " selected"; ?>>5</option>
                      <option<?php if ($srMax == 10) echo " selected"; ?>>10</option>
                      <option<?php if ($srMax == 25) echo " selected"; ?>>25</option>
                      <option<?php if ($srMax == 50) echo " selected"; ?>>50</option>
                    </select>
                  </td>
                  <td rowspan="2" align="left" class="menuBoxHeading">
                    <?php echo REPORT_STATUS_FILTER; ?><br>
                    <select name="status" size="1">
                      <option value="0"><?php echo REPORT_ALL; ?></option>
<?php
                        foreach ($sr->status as $value) {
?>
                      <option value="<?php echo $value["orders_status_id"]?>"<?php if ($srStatus == $value["orders_status_id"]) echo " selected"; ?>><?php echo $value["orders_status_name"] ; ?></option>
<?php
                         }
?>
                    </select><br>
                  </td>
                  <td rowspan="2" align="left" class="menuBoxHeading">
                    <?php echo REPORT_EXP; ?><br>
                    <select name="export" size="1">
                      <option value="0"><?php echo EXP_NORMAL; ?></option>
                      <option value="1"><?php echo EXP_HTML; ?></option>
                      <option value="2"><?php echo EXP_CSV; ?></option>
                      <option value="3" selected><?php echo EXP_ORDERS_HTML; ?></option>
                    </select><br>
                    <?php echo REPORT_SORT; ?><br>
                    <select name="sort" size="1">
                      <option value="0"<?php if ($srSort == 0) echo " selected"; ?>><?php echo SORT_VAL0; ?></option>
                      <option value="1"<?php if ($srSort == 1) echo " selected"; ?>><?php echo SORT_VAL1; ?></option>
                      <option value="2"<?php if ($srSort == 2) echo " selected"; ?>><?php echo SORT_VAL2; ?></option>
                      <option value="3"<?php if ($srSort == 3) echo " selected"; ?>><?php echo SORT_VAL3; ?></option>
                      <option value="4"<?php if ($srSort == 4) echo " selected"; ?>><?php echo SORT_VAL4; ?></option>
                      <option value="5"<?php if ($srSort == 5) echo " selected"; ?>><?php echo SORT_VAL5; ?></option>
                      <option value="6"<?php if ($srSort == 6) echo " selected"; ?>><?php echo SORT_VAL6; ?></option>
                    </select><br>
                  </td>
                </tr>
                <tr>
                  <td class="menuBoxHeading">
<?php echo REPORT_END_DATE; ?><br>
                    <select name="endD" size="1">
<?php
    if ($endDate) {
      $j = date("j", $endDate - 60* 60 * 24);
    } else {
      $j = date("j");
    }
    for ($i = 1; $i < 32; $i++) {
?>
                      <option<?php if ($j == $i) echo " selected"; ?>><?php echo $i; ?></option>
<?php
    }
?>
                    </select>
                    <select name="endM" size="1">
<?php
    if ($endDate) {
      $m = date("n", $endDate - 60* 60 * 24);
    } else {
      $m = date("n");
    }
    for ($i = 1; $i < 13; $i++) {
?>
                      <option<?php if ($m == $i) echo " selected"; ?> value="<?php echo $i; ?>"><?php echo strftime("%B", mktime(0, 0, 0, $i, 1)); ?></option>
<?php
    }
?>
                    </select>
                    <select name="endY" size="1">
<?php
    if ($endDate) {
      $y = date("Y") - date("Y", $endDate - 60* 60 * 24);
    } else {
      $y = 0;
    }
    for ($i = 10; $i >= 0; $i--) {
?>
                      <option<?php if ($y == $i) echo " selected"; ?>>
<?php echo date("Y") - $i; ?></option><?php
    }
?>
                    </select>
                  </td>
                </tr>
                </table>
                <table>
                <tr>
                  <td class="menuBoxHeading" align="left"><br><br>
                    <input type="radio" name="separator" value="1"><?php echo TEXT_SR_SEPARATOR1; ?><br>
                    <input type="radio" name="separator" value="2" checked><?php echo TEXT_SR_SEPARATOR2; ?><br><br>

                    <input type="radio" name="billing" value="0"><?php echo TEXT_NOT_INCLUDE_BILLING_ADDRESS; ?><br>
                    <input type="radio" name="billing" value="1" checked><?php echo TEXT_INCLUDE_BILLING_ADDRESS; ?><br><br>
                    <input type="radio" name="delivery" value="0"><?php echo TEXT_NOT_INCLUDE_DELIVERY_ADDRESS; ?><br>
                    <input type="radio" name="delivery" value="1" checked><?php echo TEXT_INCLUDE_DELIVERY_ADDRESS; ?><br><br>
                    <input type="radio" name="customer" value="0"><?php echo TEXT_NOT_INCLUDE_CUSTOMER_ADDRESS; ?><br>
                    <input type="radio" name="customer" value="1" checked><?php echo TEXT_INCLUDE_CUSTOMER_ADDRESS; ?><br><br>

                </tr>
                <tr>
                <td>
                    <input type="submit" value="<?php echo REPORT_SEND; ?>">
                 </td>
                 </tr>
              </table>
            </form>
          </td>
        </tr>
<?php
  } // end of ($srExp < 1)
?>
        <tr>
          <td width=100% valign=top>
            <table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td valign="top">
                  <table border="0" width="100%" cellspacing="0" cellpadding="2">
                    <tr class="dataTableHeadingRow">
                    <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_STATUS; ?></td>
                      <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_START_DATE; ?></td>
                      <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_END_DATE; ?></td>
                      <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ORDERS;?></td>
                      <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ITEMS; ?></td>
                      <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_REVENUE;?></td>
                      <td class="dataTableHeadingContent" align="right"><?php echo  TABLE_HEADING_SHIPPING;?></td>
                    </tr>
<?php
} // end of if $srExp < 2 csv export
$sum = 0;
while ($sr->actDate < $sr->endDate) {
  $info = $sr->getNext();
  $last = sizeof($info) - 1;
  if ($srExp < 2)                              
 {
     $order_status = $sr->status;
     
     if ($srStatus == '0')
     {
     $status = 'all';
     }
     else
     {
         $status = $order_status[($srStatus - 1)]['orders_status_name'];
     }
?>
                    <tr class="dataTableRow" onmouseover="this.className='dataTableRowOver';this.style.cursor='hand'" onmouseout="this.className='dataTableRow'">
                    <td class="dataTableContent" align="right"><?php echo $status; ?></td>
<?php
    switch ($srView) {
      case '3':
?>
                      <td class="dataTableContent" align="right"><?php echo smn_date_long(date("Y-m-d\ H:i:s", $sr->showDate)); ?> <td class="dataTableContent" align="right"> <?php echo smn_date_short(date("Y-m-d\ H:i:s", $sr->showDateEnd)); ?></td>
<?php
        break;
      case '4':
?>
                      <td class="dataTableContent" align="right"><?php echo smn_date_long(date("Y-m-d\ H:i:s", $sr->showDate)); ?> <td class="dataTableContent" align="right"> <?php echo smn_date_short(date("Y-m-d\ H:i:s", $sr->showDateEnd)); ?></td>
<?php
        break;
      default;
?>
                      <td class="dataTableContent" align="right"><?php echo smn_date_short(date("Y-m-d\ H:i:s", $sr->showDate)); ?> <td class="dataTableContent" align="right"> <?php echo smn_date_short(date("Y-m-d\ H:i:s", $sr->showDateEnd)); ?></td>
<?php
    }
?>
                      <td class="dataTableContent" align="right"><?php echo $info[0]['order']; ?></td>
                      <td class="dataTableContent" align="right"><?php echo $info[$last - 1]['totitem']; ?></td>
                      <td class="dataTableContent" align="right"><?php echo $currencies->format($info[$last - 1]['totsum']);?></td>
                      <td class="dataTableContent" align="right"><?php echo $currencies->format($info[0]['shipping']);?></td>
                    </tr>
<?php
  } elseif ($srDetail) {
    for ($i = 0; $i < $last; $i++) {
      if ($srMax == 0 or $i < $srMax) {
        if ($srExp < 2) {
?>
                    <tr class="dataTableRow" onmouseover="this.className='dataTableRowOver';this.style.cursor='hand'" onmouseout="this.className='dataTableRow'">
                    <td class="dataTableContent">&nbsp;</td>
                    <td class="dataTableContent" align="left"><a href="<?php echo smn_catalog_href_link("product_info.php?products_id=" . $info[$i]['pid']) ?>" target="_blank"><?php echo $info[$i]['pname']; ?></a></td>
                    <td class="dataTableContent" align="right"><?php echo $info[$i]['pquant']; ?></td>
<?php
          if ($srDetail == 2) {?>
                    <td class="dataTableContent" align="right"><?php echo $currencies->format($info[$i]['psum']); ?></td>
<?php
          } else { ?>
                    <td class="dataTableContent">&nbsp;</td>
<?php
          }
?>
                  </tr>
<?php
        }
      }
    }
  }
}
if ($srExp < 2) {
?>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->
 <table align="center">
 <tr>
    <td class="smallText"><br><br><a href="http://www.systemsmanager.net"><b>Copyright &copy; 2005 SystemsManager.Net Technologies</b></a></td><td></td>
</tr></table>
<!-- footer //-->
<?php
  if ($srExp < 1) {
    require(DIR_WS_INCLUDES . 'footer.php');
  }
?>
<!-- footer_eof //-->

</body>
</html>
<?php
  require(DIR_WS_INCLUDES . 'application_bottom.php');
} // end if $srExp < 2
?>
