<form name="checkout_confirmation" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">		<table border="0" width="100%" cellspacing="0" cellpadding="0">
<input type="hidden" name="cmd" value="_cart">
<input type="hidden" name="upload" value="1">
<input type="hidden" name="item_name_1" value="new product">
<input type="hidden" name="amount_1" value="1.00">
<input type="hidden" name="tax_1" value="0.00">
<input type="hidden" name="quantity_1" value="2">
<input type="hidden" name="shipping_1" value="3.66">
<input type="hidden" name="num_cart_items" value="1">
<input type="hidden" name="amount" value="2.00">
<input type="hidden" name="business" value="sales@oscdevshed.com">
<input type="hidden" name="no_shipping" value="2">
<input type="hidden" name="address_name" value="test00 test00">
<input type="hidden" name="address_street" value="street 12">
<input type="hidden" name="address_city" value="Boston">
<input type="hidden" name="address_zip" value="02108">
<input type="hidden" name="address_state" value="MA">
<input type="hidden" name="address_country_code" value="US">
<input type="hidden" name="address_country" value="United States">
<input type="hidden" name="payer_email" value="cimijose@yahoo.com">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="invoice" value="114">
<input type="hidden" name="custom" value="2">
<input type="hidden" name="no_note" value="1">
<input type="hidden" name="notify_url" value="http://mall.oscdevshed.com/oscmall/ext/modules/payment/paypal_ipn/ipn.php">
<input type="hidden" name="cbt" value="Complete your Order Confirmation">
<input type="hidden" name="return" value="http://mall.oscdevshed.com/oscmall/checkout_process.php">
<input type="hidden" name="cancel_return" value="http://mall.oscdevshed.com/oscmall/checkout_payment.php">
<input type="hidden" name="bn" value="osCommerce PayPal IPN v2.1">
<input type="hidden" name="lc" value="US">
<input type="image" src="includes/template/smn_original/blue/english_buttons/button_confirm_order.gif" border="0" alt="Confirm Order" title=" Confirm Order ">
</form>