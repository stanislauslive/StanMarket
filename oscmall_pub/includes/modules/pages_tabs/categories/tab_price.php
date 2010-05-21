<script language="Javascript">
 var tax_rates = new Array();
<?php
    for ($i=0, $n=sizeof($tax_class_array); $i<$n; $i++) {
      if ($tax_class_array[$i]['id'] > 0) {
        echo ' tax_rates["' . $tax_class_array[$i]['id'] . '"] = ' . smn_get_tax_rate_value($tax_class_array[$i]['id']) . ';' . "\n";
      }
    }
?>
 function doRound(x, places) {
     return Math.round(x * Math.pow(10, places)) / Math.pow(10, places);
 }

 $(document).ready(function (){
     $('#products_price').keyup(function (){
         var grossValue = $('#products_price').val();
         var taxRate = $('#products_tax_class_id').val();
         if (taxRate.length > 0 && tax_rates[taxRate] > 0) {
             taxRate = tax_rates[taxRate];
         } else {
             taxRate = 0;
         }
         if (taxRate > 0) {
             grossValue = grossValue * ((taxRate / 100) + 1);
         }
         $('#products_price_gross').val(doRound(grossValue, 4));
     });
     
     $('#products_price_gross').keyup(function (){
         var netValue = $('#products_price_gross').val();
         var taxRate = $('#products_tax_class_id').val();
         if (taxRate.length > 0 && tax_rates[taxRate] > 0) {
             taxRate = tax_rates[taxRate];
         } else {
             taxRate = 0;
         }
         if (taxRate > 0) {
             netValue = netValue / ((taxRate / 100) + 1);
         }
         $('#products_price').val(doRound(netValue, 4));
     });
     $('#products_tax_class_id').change(function (){
         $('#products_price').trigger('keyup');
     });
     $('#products_price').trigger('keyup');
 });
</script>
 <table border="0" cellspacing="0" cellpadding="5" width="96%">
  <tr bgcolor="#ebebff">
   <td class="main"><?php echo TEXT_PRODUCTS_TAX_CLASS; ?></td>
   <td><?php echo smn_draw_separator('pixel_trans.gif', '150', '15') . '' . smn_draw_pull_down_menu('products_tax_class_id', $tax_class_array, $pInfo->products_tax_class_id, 'id="products_tax_class_id"'); ?></td>
  </tr>
  <tr bgcolor="#ebebff">
   <td class="main"><?php echo TEXT_PRODUCTS_PRICE_NET; ?></td>
   <td><?php echo smn_draw_separator('pixel_trans.gif', '150', '15') . '' . smn_draw_input_field('products_price', $pInfo->products_price, 'id="products_price"'); ?></td>
  </tr>
  <tr bgcolor="#ebebff">
   <td class="main"><?php echo TEXT_PRODUCTS_PRICE_GROSS; ?></td>
   <td><?php echo smn_draw_separator('pixel_trans.gif', '150', '15') . '' . smn_draw_input_field('products_price_gross', $pInfo->products_price, 'id="products_price_gross"'); ?></td>
  </tr>
 </table>