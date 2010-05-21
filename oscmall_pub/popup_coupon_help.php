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

   global $page_name; 

  require('includes/application_top.php');

define('HEADING_COUPON_HELP', 'Discount Coupon Help');
define('TEXT_CLOSE_WINDOW', 'Close Window [x]');
define('TEXT_COUPON_HELP_HEADER', 'Congratulations, you have redeemed a Discount Coupon.');
define('TEXT_COUPON_HELP_NAME', '<br><br>Coupon Name : %s');
define('TEXT_COUPON_HELP_FIXED', '<br><br>The coupon is worth %s discount against your order');
define('TEXT_COUPON_HELP_MINORDER', '<br><br>You need to spend %s to use this coupon');
define('TEXT_COUPON_HELP_FREESHIP', '<br><br>This coupon gives you free shipping on your order');
define('TEXT_COUPON_HELP_DESC', '<br><br>Coupon Description : %s');
define('TEXT_COUPON_HELP_DATE', '<br><br>The coupon is valid between %s and %s');
define('TEXT_COUPON_HELP_RESTRICT', '<br><br>Product/Category Restrictions');
define('TEXT_COUPON_HELP_CATEGORIES', 'Category');
define('TEXT_COUPON_HELP_PRODUCTS', 'Product');

  $navigation->remove_current_page();

?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<base href="<?php echo (($request_type == 'NONSSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body marginwidth="10" marginheight="10" topmargin="10" bottommargin="10" leftmargin="10" rightmargin="10">

<?php
 $coupon_query = smn_db_query("select c.*, cd.* from " . TABLE_COUPONS . "c,  " . TABLE_COUPONS_DESCRIPTION . " cd where cd.coupon_id = '" . intval($HTTP_GET_VARS['cID']) . "' and c.coupon_id = '" . intval($HTTP_GET_VARS['cID']) . "' and cd.language_id = '" . $languages_id . "'");
 $coupon = smn_db_fetch_array($coupon_query);
  $text_coupon_help = TEXT_COUPON_HELP_HEADER;
  $text_coupon_help .= sprintf(TEXT_COUPON_HELP_NAME, $coupon['coupon_name']);
  if (smn_not_null($coupon['coupon_description'])) $text_coupon_help .= sprintf(TEXT_COUPON_HELP_DESC, $coupon['coupon_description']);
  $coupon_amount = $coupon['coupon_amount'];
  switch ($coupon['coupon_type']) {
    case 'F':
    $text_coupon_help .= sprintf(TEXT_COUPON_HELP_FIXED, $currencies->format($coupon['coupon_amount']));
    break;
    case 'P':
    $text_coupon_help .= sprintf(TEXT_COUPON_HELP_FIXED, number_format($coupon['coupon_amount'],2). '%');
    break;
    case 'S':
    $text_coupon_help .= TEXT_COUPON_HELP_FREESHIP;
    break;
    default:
  }
  if ($coupon['coupon_minimum_order'] > 0 ) $text_coupon_help .= sprintf(TEXT_COUPON_HELP_MINORDER, $currencies->format($coupon['coupon_minimum_order']));
  $text_coupon_help .= sprintf(TEXT_COUPON_HELP_DATE, smn_date_short($coupon['coupon_start_date']),smn_date_short($coupon['coupon_expire_date']));
  $text_coupon_help .= '<b>' . TEXT_COUPON_HELP_RESTRICT . '</b>';
  $text_coupon_help .= '<br><br>' .  TEXT_COUPON_HELP_CATEGORIES;

  $cat_ids = split("[,]", $coupon['restrict_to_categories']);
  for ($i = 0; $i < count($cat_ids); $i++) {
    $result = smn_db_query("SELECT * FROM categories, categories_description WHERE categories.categories_id = categories_description.categories_id and categories_description.language_id = '" . $languages_id . "' and categories.categories_id='" . $cat_ids[$i] . "'");
    if ($row = smn_db_fetch_array($result)) {
    $cats .= '<br>' . $row["categories_name"];
    }
  }
  if ($cats=='') $cats = '<br>NONE';
  $text_coupon_help .= $cats;
  $text_coupon_help .= '<br><br>' .  TEXT_COUPON_HELP_PRODUCTS;
  $pr_ids = split("[,]", $coupon['restrict_to_products']);
  for ($i = 0; $i < count($pr_ids); $i++) {
    $result = smn_db_query("SELECT * FROM products, products_description WHERE products.products_id = products_description.products_id and products_description.language_id = '" . $languages_id . "'and products.products_id = '" . $pr_ids[$i] . "'");
    if ($row = smn_db_fetch_array($result)) {
      $prods .= '<br>' . $row["products_name"];
    }
  }
  if ($prods=='') $prods = '<br>NONE';
  $text_coupon_help .= $prods;


  $info_box_contents = array();
  $info_box_contents[] = array('text' => HEADING_COUPON_HELP);


  new infoBoxHeading($info_box_contents, true, true);

  $info_box_contents = array();
  $info_box_contents[] = array('text' => $text_coupon_help);

  new infoBox($info_box_contents);
?>

<p class="smallText" align="right"><?php echo '<a href="javascript:window.close()">' . TEXT_CLOSE_WINDOW . '</a>'; ?></p>

</body>
</html>
<?php require('includes/application_bottom.php'); ?>
