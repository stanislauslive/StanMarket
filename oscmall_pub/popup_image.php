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
  require('includes/application_top.php');
  
    $product_info_query = smn_db_query("select pd.products_name, pd.products_description, p.store_id, p.products_model, p.products_image, pd.products_url, p.products_price from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = '" . (int)$HTTP_GET_VARS['pID'] . "' and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "'");
    $product_info = smn_db_fetch_array($product_info_query);
    $products_image = $product_info['products_image'];
    $products_name = $product_info['products_name'];
    $store_images = 'images/'. $product_info['store_id'] . '_images/';

  
  ?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo $product_info['products_name']; ?></title>
<base href="<?php echo (($request_type == 'NONSSL') ? HTTP_SERVER : HTTPS_SERVER) . DIR_WS_CATALOG; ?>">
<script language="javascript"><!--
var i=0;
function resize() {
  if (navigator.appName == 'Netscape') i=40;
  if (document.images[0]) window.resizeTo(document.images[0].width +30, document.images[0].height+60-i);
  self.focus();
}
//--></script>
</head>
<body onLoad="resize();">
<?php echo smn_image($store_images . $products_image, $products_name); ?>
</body>
</html>
<?php require('includes/application_bottom.php'); ?>