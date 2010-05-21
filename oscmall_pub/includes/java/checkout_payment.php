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
<script language="javascript">
function popupWindow(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=480,height=360,screenX=150,screenY=150,top=150,left=150')
}

var selected;
var submitter = null;
function submitFunction() {
   submitter = 1;
   }
function selectRowEffect(object, buttonSelect) {

  if (!document.checkout_payment.payment[0].disabled){
    if (!selected) {

    if (document.getElementById) {
      selected = document.getElementById('defaultSelected');
    } else {
      selected = document.all['defaultSelected'];
    }
  }

  if (selected) selected.className = 'moduleRow';
  object.className = 'moduleRowSelected';
  selected = object;

// one button is not an array
    if (document.checkout_payment.payment[0]) {
        document.checkout_payment.payment[buttonSelect].checked=true;
    } else {
        document.checkout_payment.payment.checked=true;
    }
  }
}

function rowOverEffect(object) {
  if (object.className == 'moduleRow') object.className = 'moduleRowOver';
}

function rowOutEffect(object) {
  if (object.className == 'moduleRowOver') object.className = 'moduleRow';
}
<?php
if (MODULE_ORDER_TOTAL_INSTALLED)
	$temp = $order_total_modules->process();
	$temp = $temp[count($temp)-1];
	$temp = $temp['value'];
	$gv_query = smn_db_query("select amount from " . TABLE_COUPON_GV_CUSTOMER . " where customer_id = '" . $customer_id . "'");
	$gv_result = smn_db_fetch_array($gv_query);
if ($gv_result['amount']>=$temp){ $coversAll=true;

?>

function clearRadeos(){
document.checkout_payment.cot_gv.checked=!document.checkout_payment.cot_gv.checked;
for (counter = 0; counter < document.checkout_payment.payment.length; counter++)
{
if (document.checkout_payment.cot_gv.checked){
document.checkout_payment.payment[counter].checked = false;
document.checkout_payment.payment[counter].disabled=true;

} else {
document.checkout_payment.payment[counter].disabled=false;

}
}
}<? } else { $coversAll=false;?>
function clearRadeos(){
document.checkout_payment.cot_gv.checked=!document.checkout_payment.cot_gv.checked;
}<? } ?>
//--></script>



<?php echo $payment_modules->javascript_validation($coversAll); ?>