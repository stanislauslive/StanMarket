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
<!-- order_details -->
<?php
  echo '  <tr>' . "\n";

  $colspan = 3;

  if (strstr($PHP_SELF, FILENAME_SHOPPING_CART)) {
    $colspan++;
    echo '    <td align="center" class="smallText"><b>' . TABLE_HEADING_REMOVE . '</b></td>' . "\n";
  }

  echo '    <td align="center" class="tableHeading">' . TABLE_HEADING_QUANTITY . '</td>' . "\n";

  if ((PRODUCT_LIST_MODEL > 0) && strstr($PHP_SELF, FILENAME_SHOPPING_CART)) {
    $colspan++;
    echo '    <td class="tableHeading">' . TABLE_HEADING_MODEL . '</td>' . "\n";
  }

  echo '    <td class="tableHeading">' . TABLE_HEADING_PRODUCTS . '</td>' . "\n";

  if (!strstr($PHP_SELF, FILENAME_SHOPPING_CART)) {
    $colspan++;
    echo '    <td align="center" class="tableHeading">' . TABLE_HEADING_TAX . '</td>' . "\n";
  }

  echo '    <td align="right" class="tableHeading">' . TABLE_HEADING_TOTAL . '</td>' . "\n" .
       '  </tr>' . "\n" .
       '  <tr>' . "\n" .
       '    <td colspan="' . $colspan . '">' . smn_draw_separator() . '</td>' . "\n" .
       '  </tr>' . "\n";

  for ($i=0, $n=sizeof($products); $i<$n; $i++) {
    echo '  <tr>' . "\n";

// Delete box only for shopping cart
    if (strstr($PHP_SELF, FILENAME_SHOPPING_CART)) {
      echo '    <td align="center" valign="top">' . smn_draw_checkbox_field('cart_delete[]', $products[$i]['id']) . '</td>' . "\n";
    }

// Quantity box or information as an input box or text
    if (strstr($PHP_SELF, FILENAME_SHOPPING_CART)) {
      echo '    <td align="center" valign="top">' . smn_draw_input_field('cart_quantity[]', $products[$i]['quantity'], 'size="4"') . smn_draw_hidden_field('products_id[]', $products[$i]['id']) . '</td>' . "\n";
    } else {
      echo '    <td align="center" valign="top" class ="main">' . $products[$i]['quantity'] . '</td>' . "\n";
    }

// Model
    if ((PRODUCT_LIST_MODEL > 0) && strstr($PHP_SELF, FILENAME_SHOPPING_CART)) {
      echo '    <td valign="top" class="main"><a href="' . smn_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products[$i]['id']) . '">' . $products[$i]['model'] . '</a></td>' . "\n";
    }
  
// Product name, with or without link
    if (strstr($PHP_SELF, FILENAME_SHOPPING_CART)) {
      echo '    <td valign="top" class="main"><a href="' . smn_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products[$i]['id']) . '"><b>' . $products[$i]['name'] . '</b></a>';
    } else {
      echo '    <td valign="top" class="main"><b>' . $products[$i]['name'] . '</b>';
    }

// Display marker if stock quantity insufficient
    if (!strstr($PHP_SELF, FILENAME_ACCOUNT_HISTORY_INFO)) {
      if (STOCK_CHECK == 'true') {
        echo $stock_check = smn_check_stock($products[$i]['id'], $products[$i]['quantity']);
        if ($stock_check) $any_out_of_stock = 1;
      }
    }

// Product options names
    $attributes_exist = ((isset($products[$i]['attributes'])) ? 1 : 0);

    if ($attributes_exist == 1) {
      reset($products[$i]['attributes']);
      while (list($option, $value) = each($products[$i]['attributes'])) {
        echo '<br><small><i> - ' . $products[$i][$option]['products_options_name'] . ' ' . $products[$i][$option]['products_options_values_name'] . '</i></small>';
      }
    }

    echo '</td>' . "\n";

// Tax (not in shopping cart, tax rate may be unknown)
    if (!strstr($PHP_SELF, FILENAME_SHOPPING_CART)) {
      echo '    <td align="center" valign="top" class="main">' . number_format($products[$i]['tax'], TAX_DECIMAL_PLACES) . '%</td>' . "\n";
    }

// Product price  
    if (!strstr($PHP_SELF, FILENAME_ACCOUNT_HISTORY_INFO)) {
      echo '    <td align="right" valign="top" class="main"><b>' . $currencies->display_price($products[$i]['price'], smn_get_tax_rate($products[$i]['tax_class_id'], '', '', $products[$i]['store_id']), $products[$i]['quantity']) . '</b>';
    } else {
      echo '    <td align="right" valign="top" class="main"><b>' . $currencies->display_price($products[$i]['price'], $products[$i]['tax'], $products[$i]['quantity']) . '</b>';
    }

// Product options prices
    if ($attributes_exist == 1) {
      reset($products[$i]['attributes']);
      while (list($option, $value) = each($products[$i]['attributes'])) {
        if ($products[$i][$option]['options_values_price'] != 0) {
          if (!strstr($PHP_SELF, FILENAME_ACCOUNT_HISTORY_INFO)) {
            echo '<br><small><i>' . $products[$i][$option]['price_prefix'] . $currencies->display_price($products[$i][$option]['options_values_price'], smn_get_tax_rate($products[$i]['tax_class_id'], '', '', $products[$i]['store_id']), $products[$i]['quantity']) . '</i></small>';
          } else {
            echo '<br><small><i>' . $products[$i][$option]['price_prefix'] . $currencies->display_price($products[$i][$option]['options_values_price'], $products[$i]['tax'], $products[$i]['quantity']) . '</i></small>';
          }
        } else {
// Keep price aligned with corresponding option
          echo '<br><small><i>&nbsp;</i></small>';
        }
      }
    }

    echo '</td>' . "\n" .
         '  </tr>' . "\n";
  }
?>
<!-- order_details_eof -->
