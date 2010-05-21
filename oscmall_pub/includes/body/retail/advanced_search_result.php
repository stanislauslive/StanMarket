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
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE_2; ?></td>
            <td class="pageHeading" align="right"><?php echo smn_image(DIR_WS_IMAGES . 'table_background_browse.gif', HEADING_TITLE_2, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td>
<?php
// create column list
  $define_list = array('PRODUCT_LIST_MODEL' => PRODUCT_LIST_MODEL,
                       'PRODUCT_LIST_NAME' => PRODUCT_LIST_NAME,
                       'PRODUCT_LIST_INFO' => PRODUCT_LIST_INFO,
                       'PRODUCT_LIST_MANUFACTURER' => PRODUCT_LIST_MANUFACTURER,
                       'PRODUCT_LIST_PRICE' => PRODUCT_LIST_PRICE,
                       'PRODUCT_LIST_QUANTITY' => PRODUCT_LIST_QUANTITY,
                       'PRODUCT_LIST_WEIGHT' => PRODUCT_LIST_WEIGHT,
                       'PRODUCT_LIST_IMAGE' => PRODUCT_LIST_IMAGE,
                       'PRODUCT_LIST_BUY_NOW' => PRODUCT_LIST_BUY_NOW);

  asort($define_list);

  $column_list = array();
  reset($define_list);
  while (list($key, $value) = each($define_list)) {
    if ($value > 0) $column_list[] = $key;
  }

  $select_column_list = '';

  for ($i=0, $n=sizeof($column_list); $i<$n; $i++) {
    switch ($column_list[$i]) {
      case 'PRODUCT_LIST_MODEL':
        $select_column_list .= 'p.products_model, ';
        break;
      case 'PRODUCT_LIST_INFO':  
        $select_column_list .= 'pd.products_info, ';
        break;
      case 'PRODUCT_LIST_MANUFACTURER':
        $select_column_list .= 'm.manufacturers_name, ';
        break;
      case 'PRODUCT_LIST_QUANTITY':
        $select_column_list .= 'p.products_quantity, ';
        break;
      case 'PRODUCT_LIST_IMAGE':
        $select_column_list .= 'p.products_image, ';
        break;
      case 'PRODUCT_LIST_WEIGHT':
        $select_column_list .= 'p.products_weight, ';
        break;
    }
  }

  $select_str = "select distinct " . $select_column_list . " m.manufacturers_id, p.products_id, p.store_id, pd.products_name, p.products_price, p.products_tax_class_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, p.products_price) as final_price ";

  if ( (DISPLAY_PRICE_WITH_TAX == 'true') && (smn_not_null($pfrom) || smn_not_null($pto)) ) {
    $select_str .= ", SUM(tr.tax_rate) as tax_rate ";
  }

  $from_str = "from " . TABLE_PRODUCTS . " p left join " . TABLE_MANUFACTURERS . " m using(manufacturers_id), " . TABLE_PRODUCTS_DESCRIPTION . " pd left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_CATEGORIES . " c, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c";

 // if ( (DISPLAY_PRICE_WITH_TAX == 'true') && (smn_not_null($pfrom) || smn_not_null($pto)) ) {
    if (!smn_session_is_registered('customer_country_id')) {
      $customer_country_id = $store->get_store_country();
      $customer_zone_id = $store->get_store_zone();
    }
    $from_str .= " left join " . TABLE_TAX_RATES . " tr on p.products_tax_class_id = tr.tax_class_id left join " . TABLE_ZONES_TO_GEO_ZONES . " gz on tr.tax_zone_id = gz.geo_zone_id and (gz.zone_country_id is null or gz.zone_country_id = '0' or gz.zone_country_id = '" . (int)$customer_country_id . "') and (gz.zone_id is null or gz.zone_id = '0' or gz.zone_id = '" . (int)$customer_zone_id . "')";
  //}

  $where_str = " where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' and p.products_id = p2c.products_id and p2c.categories_id = c.categories_id";
  

// systemsmanager begin
  if (isset($_POST['categories_id']) && smn_not_null($_POST['categories_id'])) {
    if (isset($_POST['inc_subcat']) && ($_POST['inc_subcat'] == '1')) {
      $subcategories_array = array();
      smn_get_subcategories($subcategories_array, $_POST['categories_id']);

      $where_str .= " and p2c.products_id = p.products_id and p2c.products_id = pd.products_id and (p2c.categories_id = '" . (int)$_POST['categories_id'] . "'";

      for ($i=0, $n=sizeof($subcategories_array); $i<$n; $i++ ) {
        $where_str .= " or p2c.categories_id = '" . (int)$subcategories_array[$i] . "'";
      }

      $where_str .= ")";
    } else {
      $where_str .= " and p2c.products_id = p.products_id and p2c.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' and p2c.categories_id = '" . (int)$_POST['categories_id'] . "'";
    }
  }

	$select_str = "select p.*, pd.* ";
	$from_str = " from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd ";
	$where_str = " where p.products_id = pd.products_id and p.store_id!=1 ";

  if (isset($_POST['store_category']) && $_POST['store_category']!=0) {
  	$from_str .= " , " . TABLE_STORE_TO_CATEGORIES . " sc "; //on p.store_id=sc.store_id and sc.store_categories_id=" . $_POST['store_category'];
	$where_str .= " and p.store_id = sc.store_id and sc.store_categories_id = " . $_POST['store_category'];
  }

  if (isset($_POST['product_category']) && $_POST['product_category']!=0) {
    $from_str .= " , " . TABLE_PRODUCTS_TO_CATEGORIES . " pc ";
  	$where_str .= " and p.products_id = pc.products_id and pc.categories_id = " . $_POST['product_category'];
  }
  
 // if (isset($_POST['product_description']) && !empty($_POST['product_description'])) {
  	//$search_keywords[] = $_POST['product_description'];
	//$where_str .= " and (pd.products_name like '%" . $_POST['product_description'] . "%' or pd.products_description like '%" . $_POST['product_description'] . "%')";
  //}
    if (isset($_REQUEST['keywords']) && !empty($_REQUEST['keywords'])) {
  	//$search_keywords[] = $_POST['product_description'];
	$keywords = explode(',',$_REQUEST['keywords']);
		   $where_str .= " and ((pd.products_name like '%" . $keywords[0] . "%' or pd.products_description like '%" . $keywords[0] . "%' or pd.products_head_keywords_tag like '%" . $keywords[0] . "%')";
    if(sizeof($keywords)==1)$where_str .= ")";
	for($i=1 ; $i< sizeof($keywords);$i++){
	   $where_str .= " or (pd.products_name like '%" . $keywords[$i] . "%' or pd.products_description like '%" . $keywords[$i] . "%' or pd.products_head_keywords_tag like '%" . $keywords[0] . "%'))";
	}
  }
  
  if ($store_id != 1 && $_POST['inc_mall'] != '1'){
      $where_str .= ' and p.store_id = "' . $store_id . '"';
  }

  
  
/*
  if (isset($_GET['manufacturers_id']) && smn_not_null($_GET['manufacturers_id'])) {
    $where_str .= " and m.manufacturers_id = '" . (int)$_GET['manufacturers_id'] . "'";
  }
*/

// systemsmanager end

/*
  if (isset($search_keywords) && (sizeof($search_keywords) > 0)) {
    $where_str .= " and (";
    for ($i=0, $n=sizeof($search_keywords); $i<$n; $i++ ) {
      switch ($search_keywords[$i]) {
        case '(':
        case ')':
        case 'and':
        case 'or':
          $where_str .= " " . $search_keywords[$i] . " ";
          break;
        default:
          $keyword = smn_db_prepare_input($search_keywords[$i]);
          $where_str .= "(pd.products_name like '%" . smn_db_input($keyword) . "%' or p.products_model like '%" . smn_db_input($keyword) . "%' or m.manufacturers_name like '%" . smn_db_input($keyword) . "%'";
// systemsmanager begin
          if (isset($_POST['search_in_description']) && ($_POST['search_in_description'] == '1')) $where_str .= " or pd.products_description like '%" . smn_db_input($keyword) . "%'";
// systemsmanager end
          $where_str .= ')';
          break;
      }
    }
    $where_str .= " )";
  }

  if (smn_not_null($dfrom)) {
    $where_str .= " and p.products_date_added >= '" . smn_date_raw($dfrom) . "'";
  }

  if (smn_not_null($dto)) {
    $where_str .= " and p.products_date_added <= '" . smn_date_raw($dto) . "'";
  }

  if (smn_not_null($pfrom)) {
    if ($currencies->is_set($currency)) {
      $rate = $currencies->get_value($currency);

      $pfrom = $pfrom / $rate;
    }
  }

  if (smn_not_null($pto)) {
    if (isset($rate)) {
      $pto = $pto / $rate;
    }
  }

  if (DISPLAY_PRICE_WITH_TAX == 'true') {
    if ($pfrom > 0) $where_str .= " and (IF(s.status, s.specials_new_products_price, p.products_price) * if(gz.geo_zone_id is null, 1, 1 + (tr.tax_rate / 100) ) >= " . (double)$pfrom . ")";
    if ($pto > 0) $where_str .= " and (IF(s.status, s.specials_new_products_price, p.products_price) * if(gz.geo_zone_id is null, 1, 1 + (tr.tax_rate / 100) ) <= " . (double)$pto . ")";
  } else {
    if ($pfrom > 0) $where_str .= " and (IF(s.status, s.specials_new_products_price, p.products_price) >= " . (double)$pfrom . ")";
    if ($pto > 0) $where_str .= " and (IF(s.status, s.specials_new_products_price, p.products_price) <= " . (double)$pto . ")";
  }

  if ( (DISPLAY_PRICE_WITH_TAX == 'true') && (smn_not_null($pfrom) || smn_not_null($pto)) ) {
    $where_str .= " group by p.products_id, tr.tax_priority";
  }
*/

  if ( (!isset($_GET['sort'])) || (!ereg('[1-8][ad]', $_GET['sort'])) || (substr($_GET['sort'], 0, 1) > sizeof($column_list)) ) {
    for ($i=0, $n=sizeof($column_list); $i<$n; $i++) {
      if ($column_list[$i] == 'PRODUCT_LIST_NAME') {
        $_GET['sort'] = $i+1 . 'a';
        $order_str = ' order by pd.products_name';
        break;
      }
    }
  } else {
    $sort_col = substr($_GET['sort'], 0 , 1);
    $sort_order = substr($_GET['sort'], 1);
    $order_str = ' order by ';
    switch ($column_list[$sort_col-1]) {
      case 'PRODUCT_LIST_MODEL':
        $order_str .= "p.products_model " . ($sort_order == 'd' ? "desc" : "") . ", pd.products_name";
        break;
      case 'PRODUCT_LIST_NAME':
        $order_str .= "pd.products_name " . ($sort_order == 'd' ? "desc" : "");
        break;
      case 'PRODUCT_LIST_INFO':
        $order_str .= "pd.products_info " . ($sort_order == 'd' ? "desc" : "");
        break;
      case 'PRODUCT_LIST_MANUFACTURER':
        $order_str .= "m.manufacturers_name " . ($sort_order == 'd' ? "desc" : "") . ", pd.products_name";
        break;
      case 'PRODUCT_LIST_QUANTITY':
        $order_str .= "p.products_quantity " . ($sort_order == 'd' ? "desc" : "") . ", pd.products_name";
        break;
      case 'PRODUCT_LIST_IMAGE':
        $order_str .= "pd.products_name";
        break;
      case 'PRODUCT_LIST_WEIGHT':
        $order_str .= "p.products_weight " . ($sort_order == 'd' ? "desc" : "") . ", pd.products_name";
        break;
      case 'PRODUCT_LIST_PRICE':
        $order_str .= "final_price " . ($sort_order == 'd' ? "desc" : "") . ", pd.products_name";
        break;
    }
  }

  $listing_sql = $select_str . $from_str . $where_str . $order_str;
  
  
 //echo $listing_sql;
  
  require(DIR_WS_MODULES . FILENAME_PRODUCT_LISTING);
?>
        </td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><?php echo '<a href="' . smn_href_link(FILENAME_ADVANCED_SEARCH, smn_get_all_get_params(array('sort', 'page')), 'NONSSL', true, false) . '">' . smn_image_button('button_back.gif', IMAGE_BUTTON_BACK) . '</a>'; ?></td>
      </tr>
    </table>
