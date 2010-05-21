<?php
  if ($action == 'new_product') {
    $parameters = array('products_name' => '',
                       'products_description' => '',
                       'products_url' => '',
                       'products_id' => '',
                       'products_quantity' => '',
                       'products_model' => '',
                       'products_image' => '',
                       'products_price' => '',
                       'products_weight' => '',
                       'products_date_added' => '',
                       'products_last_modified' => '',
                       'products_date_available' => '',
                       'products_status' => '',
                       'products_tax_class_id' => '',
                       'manufacturers_id' => '');
   // $pInfo = new objectInfo($parameters);
    if (isset($_GET['pID']) && empty($_POST)) {
      $product_query = smn_db_query("select pd.products_name, pd.products_head_title_tag, pd.products_head_desc_tag, pd.products_head_keywords_tag, pd.products_description, pd.products_url, p.products_id, p.products_quantity, p.products_model, p.products_image, p.products_price, p.products_weight, p.products_date_added, p.products_last_modified, date_format(p.products_date_available, '%Y-%m-%d') as products_date_available, p.products_status, p.products_tax_class_id, p.manufacturers_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = '" . (int)$_GET['pID'] . "' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' and p.store_id = '" . (int)$store_id . "'");
      $pInfo = smn_db_fetch_array($product_query);
     // $pInfo->objectInfo($product);
    } elseif (smn_not_null($_POST)) {
     // $pInfo->objectInfo($_POST);
	  $pInfo = $_POST;
      $products_name = $_POST['products_name'];
      $products_description = $_POST['products_description'];
      $products_url = $_POST['products_url'];
    }
    $manufacturers_array = array(array('id' => '', 'text' => TEXT_NONE));
    $manufacturers_query = smn_db_query("select manufacturers_id, manufacturers_name from " . TABLE_MANUFACTURERS . " order by manufacturers_name");
    while ($manufacturers = smn_db_fetch_array($manufacturers_query)) {
      $manufacturers_array[] = array('id' => $manufacturers['manufacturers_id'],
                                     'text' => $manufacturers['manufacturers_name']);
    }
    $tax_class_array = array(array('id' => '0', 'text' => TEXT_NONE));
    $tax_class_query = smn_db_query("select tax_class_id, tax_class_title from " . TABLE_TAX_CLASS . " where store_id = '" . $store_id . "' order by tax_class_title");
	
    $languages = smn_get_languages();
	
    if($store_id != 1){
      $categories_selected = '';
      $categories_check_query = smn_db_query("select categories_id from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . (int)$products_id . "' and store_id = '1'");
      if (smn_db_num_rows($categories_check_query)) {
        $categories_check = smn_db_fetch_array($categories_check_query);
        $categories_selected = (int)$categories_check['categories_id'];
      }
      $categories_array = smn_get_main_categories(); 
    }
    
    while ($tax_class = smn_db_fetch_array($tax_class_query)) {
      $tax_class_array[] = array('id' => $tax_class['tax_class_id'],
                                 'text' => $tax_class['tax_class_title']);
    }
    
    
    if (!isset($pInfo[products_status])) $pInfo[products_status] = '1';
    switch ($pInfo[products_status]) {
      case '0': $in_status = false; $out_status = true; break;
      case '1':
      default: $in_status = true; $out_status = false;
    }
?>
<div id="spiffycalendar" class="text"></div>
<link rel="stylesheet" type="text/css" href="includes/javascript/spiffyCal/spiffyCal_v2_1.css">
<script language="JavaScript" src="includes/javascript/spiffyCal/spiffyCal_v2_1.js"></script>
<script language="javascript" src="includes/javascript/dhtml.js"></script>
<script language="javascript"><!--
  var dateAvailable = new ctlSpiffyCalendarBox("dateAvailable", "new_product", "products_date_available","btnDate1","<?php echo $pInfo[products_date_available]; ?>",scBTNMODE_CUSTOMBLUE);
//--></script>
<script language="javascript"><!--
var tax_rates = new Array();
<?php
    for ($i=0, $n=sizeof($tax_class_array); $i<$n; $i++) {
      if ($tax_class_array[$i]['id'] > 0) {
        echo 'tax_rates["' . $tax_class_array[$i]['id'] . '"] = ' . smn_get_tax_rate_value($tax_class_array[$i]['id']) . ';' . "\n";
      }
    }
?>
function doRound(x, places) {
  return Math.round(x * Math.pow(10, places)) / Math.pow(10, places);
}
function getTaxRate() {
  var selected_value = document.forms["new_product"].products_tax_class_id.selectedIndex;
  var parameterVal = document.forms["new_product"].products_tax_class_id[selected_value].value;
  if ( (parameterVal > 0) && (tax_rates[parameterVal] > 0) ) {
    return tax_rates[parameterVal];
  } else {
    return 0;
  }
}
function updateGross() {
  var taxRate = getTaxRate();
  var grossValue = document.forms["new_product"].products_price.value;
  if (taxRate > 0) {
    grossValue = grossValue * ((taxRate / 100) + 1);
  }
  document.forms["new_product"].products_price_gross.value = doRound(grossValue, 4);
}
function updateNet() {
  var taxRate = getTaxRate();
  var netValue = document.forms["new_product"].products_price_gross.value;
  if (taxRate > 0) {
    netValue = netValue / ((taxRate / 100) + 1);
  }
  document.forms["new_product"].products_price.value = doRound(netValue, 4);
}
//--></script>
    <?php echo smn_draw_form('new_product', FILENAME_STORE_PRODUCT_CATEGORIES.'?ID='.$store_id.'&cPath=' . $cPath . (isset($_GET['pID']) ? '&pID=' . $_GET['pID'] : '') . '&action=new_product_preview', 'post', 'enctype="multipart/form-data"'); ?>
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo sprintf(TEXT_NEW_PRODUCT, smn_output_generated_category_path($current_category_id)); ?></td>
            <td class="pageHeading" align="right"><?php echo smn_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
    <tr>
    
    <td>
    <table border="0" cellspacing="0" cellpadding="2">
      <table cellspacing="0" cellpadding="4" border="0" width="100%">
        <tr>
          <td id="tab1" class="offtab" onClick="dhtml.cycleTab(this.id)"><?php echo TAB_NAME; ?></td>
          <td id="tab2" class="offtab" onClick="dhtml.cycleTab(this.id)"><?php echo TAB_PRICE; ?></td>
          <td id="tab3" class="offtab" onClick="dhtml.cycleTab(this.id)"><?php echo TAB_DESC; ?></td>
          <td id="tab4" class="offtab" onClick="dhtml.cycleTab(this.id)"><?php echo TAB_IMG; ?></td>
          <td width="90%" class="tabpadding">&nbsp;</td>
        </tr>
      </table> 
        
      
      
      

	  
      
      <div id="page1" class="pagetext">
        <table border="0" cellspacing="0" cellpadding="5" class="adminform">
<?php
    for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
?>
          <tr>
            <td class="main"><?php if ($i == 0) echo TEXT_PRODUCTS_NAME; ?>
            </td>
<!-- systemsmanager begin - Dec 1, 2005 security patch - added stripslashes -->
            <td class="main"><?php echo smn_image(DIR_WS_LANGUAGES .  'images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . smn_draw_input_field('products_name[' . $languages[$i]['id'] . ']', (isset($products_name[$languages[$i]['id']]) ? stripslashes($products_name[$languages[$i]['id']]) : smn_get_products_name($pInfo[products_id], $languages[$i]['id'])), 'size="35"'); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>          
<?php
    }
?>

          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_MODEL; ?></td>
            <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_input_field('products_model', $pInfo[products_model]); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_STATUS; ?></td>
            <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_radio_field('products_status', '1', $in_status) . '&nbsp;' . TEXT_PRODUCT_AVAILABLE . '&nbsp;' . smn_draw_radio_field('products_status', '0', $out_status) . '&nbsp;' . TEXT_PRODUCT_NOT_AVAILABLE; ?></td>
          </tr>
          
<?php
  if($store_id != 1){
?>
          <tr>
            <td class="main"><?php echo TEXT_MAIN_CATEGORIES; ?></td>
            <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_pull_down_menu('main_category_id', $categories_array, $categories_selected); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
<?php
  }
?>
          
          <tr>
            <td colspan="2"><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_DATE_AVAILABLE; ?><br>
              <small>(YYYY-MM-DD)</small></td>
            <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;'; ?>
              <script language="javascript">dateAvailable.writeControl(); dateAvailable.dateFormat="yyyy-MM-dd";</script>
            </td>
          </tr>
        </table>
      </div>






      <div id="page2" class="pagetext">
        <table border="0" cellspacing="0" cellpadding="5" class="adminform">
          <tr>
            <td colspan="2"><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr bgcolor="#ebebff">
            <td class="main"><?php echo TEXT_PRODUCTS_TAX_CLASS; ?></td>
            <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_pull_down_menu('products_tax_class_id', $tax_class_array, $pInfo[products_tax_class_id], 'onchange="updateGross()"'); ?></td>
          </tr>
          <tr bgcolor="#ebebff">
            <td class="main"><?php echo TEXT_PRODUCTS_PRICE_NET; ?></td>
            <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_input_field('products_price', $pInfo[products_price], 'onKeyUp="updateGross()"'); ?></td>
          </tr>
          <tr bgcolor="#ebebff">
            <td class="main"><?php echo TEXT_PRODUCTS_PRICE_GROSS; ?></td>
            <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_input_field('products_price_gross', $pInfo[products_price], 'OnKeyUp="updateNet()"'); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
<script language="javascript"><!--
updateGross();
//--></script>
        </table>
      </div>




      <div id="page3" class="pagetext">
        <table cellpadding="5" cellspacing="0" border="0" class="adminform">

<?php
    for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
?>
         <tr>
            <td class="main" valign="top"><?php if ($i == 0) echo TEXT_PRODUCTS_DESCRIPTION; ?></td>
            <td><table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="main" valign="top"><?php echo smn_image(DIR_WS_LANGUAGES .  'images/' . $languages[$i]['image'], $languages[$i]['name']); ?>&nbsp;</td>
                <td class="main">
<?php

      echo smn_draw_textarea_field('products_description[' . $languages[$i]['id'] . ']', 'soft', '70', '15', (isset($products_description[$languages[$i]['id']]) ? $products_description[$languages[$i]['id']] : smn_get_products_description($pInfo[products_id], $languages[$i]['id'])),'ID=products_description'); $java_editor = 'products_description[' . $languages[$i]['id'] . ']';?></td>
              </tr>
            </table></td>
          </tr>
<?php
}
?>

	  <tr>
            <td colspan="2" class="main"><hr><?php echo TEXT_PRODUCT_METTA_INFO; ?></td>
          </tr>

<?php
    for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
?>
         <tr>
            <td colspan="2"><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>          
          <tr>
            <td class="main" valign="top"><?php if ($i == 0) echo TEXT_PRODUCTS_PAGE_TITLE; ?></td>
            <td><table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="main" valign="top"><?php echo smn_image(DIR_WS_LANGUAGES .  'images/' . $languages[$i]['image'], $languages[$i]['name']); ?>&nbsp;</td>
                <td class="main"><?php echo smn_draw_textarea_field('products_head_title_tag[' . $languages[$i]['id'] . ']', 'soft', '70', '5', (isset($products_head_title_tag[$languages[$i]['id']]) ? $products_head_title_tag[$languages[$i]['id']] : smn_get_products_head_title_tag($pInfo[products_id], $languages[$i]['id']))); ?></td>
              </tr>
            </table></td>
          </tr>
<?php
    }
    for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
?>
          <tr>
            <td colspan="2"><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>          
          <tr>
            <td class="main" valign="top"><?php if ($i == 0) echo TEXT_PRODUCTS_HEADER_DESCRIPTION; ?></td>
            <td><table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="main" valign="top"><?php echo smn_image(DIR_WS_LANGUAGES .  'images/' . $languages[$i]['image'], $languages[$i]['name']); ?>&nbsp;</td>
                <td class="main"><?php echo smn_draw_textarea_field('products_head_desc_tag[' . $languages[$i]['id'] . ']', 'soft', '70', '5', (isset($products_head_desc_tag[$languages[$i]['id']]) ? $products_head_desc_tag[$languages[$i]['id']] : smn_get_products_head_desc_tag($pInfo[products_id], $languages[$i]['id']))); ?></td>
              </tr>
            </table></td>
          </tr>
<?php
    }
    for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
?>
          <tr>
            <td colspan="2"><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>          
           <tr>
            <td class="main" valign="top"><?php if ($i == 0) echo TEXT_PRODUCTS_KEYWORDS; ?></td>
            <td><table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="main" valign="top"><?php echo smn_image(DIR_WS_LANGUAGES .  'images/' . $languages[$i]['image'], $languages[$i]['name']); ?>&nbsp;</td>
                <td class="main"><?php echo smn_draw_textarea_field('products_head_keywords_tag[' . $languages[$i]['id'] . ']', 'soft', '70', '5', (isset($products_head_keywords_tag[$languages[$i]['id']]) ? $products_head_keywords_tag[$languages[$i]['id']] : smn_get_products_head_keywords_tag($pInfo[products_id], $languages[$i]['id']))); ?></td>
              </tr>
            </table></td>
          </tr>
<?php
    }
?>

          <tr>
            <td colspan="2"><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
        </table>
      </div> 
          
      
      
          
          
      <div id="page4" class="pagetext">
        <table border="0" cellspacing="0" cellpadding="5" class="adminform">
          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_IMAGE; ?></td>
            <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_file_field('products_image') . '<br>' . smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . $pInfo[products_image] . smn_draw_hidden_field('products_previous_image', $pInfo[products_image]); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>

          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_QUANTITY; ?></td>
            <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_input_field('products_quantity', $pInfo[products_quantity]); ?></td>
          </tr>
          </tr>
            <td colspan="2"><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>          
<?php
    for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
?>
          <tr>
            <td class="main"><?php if ($i == 0) echo TEXT_PRODUCTS_URL . '<br>' . TEXT_PRODUCTS_URL_WITHOUT_HTTP . ''; ?></td>
            <td class="main"><?php echo smn_image(DIR_WS_LANGUAGES .  'images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . smn_draw_input_field('products_url[' . $languages[$i]['id'] . ']', (isset($products_url[$languages[$i]['id']]) ? stripslashes($products_url[$languages[$i]['id']]) : smn_get_products_url($pInfo[products_id], $languages[$i]['id']))); ?></td>
          </tr>
<?php
    }
?>
          <tr>
            <td colspan="2"><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_MANUFACTURER; ?></td>
            <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_pull_down_menu('manufacturers_id', $manufacturers_array, $pInfo[manufacturers_id]); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_WEIGHT; ?></td>
            <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_input_field('products_weight', $pInfo[products_weight]); ?></td>
          </tr>
          <tr>
          </tr>
            <td colspan="2"><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          </tr>
        </table>	
        </td>
        </tr>
      </div>
      <script language="javascript" type="text/javascript">dhtml.cycleTab('tab1');</script>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main" align="right"><?php echo smn_draw_hidden_field('products_date_added', (smn_not_null($pInfo[products_date_added]) ? $pInfo[products_date_added] : date('Y-m-d'))) . smn_image_submit('small_preview.gif', IMAGE_PREVIEW) . '&nbsp;&nbsp;<a href="' . smn_href_link(FILENAME_STORE_PRODUCT_CATEGORIES, 'cPath=' . $cPath . (isset($_GET['pID']) ? '&pID=' . $_GET['pID'] : '').'&ID='.$store_id) . '">' . smn_image_button('small_cancel.gif', IMAGE_CANCEL) . '</a>'; ?></td>
      </tr>
    </table></form>
<?php
  } elseif ($action == 'new_product_preview') {
    if (smn_not_null($_POST)) {
      $pInfo = $_POST;
      $products_name = $_POST['products_name'];
      $products_description = $_POST['products_description'];
      $products_url = $_POST['products_url'];
      $products_head_title_tag = $_POST['products_head_title_tag'];
      $products_head_desc_tag = $_POST['products_head_desc_tag'];
      $products_head_keywords_tag = $_POST['products_head_keywords_tag'];
    } else {
      $product_query = smn_db_query("select p.products_id, pd.language_id, pd.products_head_title_tag, pd.products_head_desc_tag, pd.products_head_keywords_tag, pd.products_name, pd.products_description, pd.products_url, p.products_quantity, p.products_model, p.products_image, p.products_price, p.products_weight, p.products_date_added, p.products_last_modified, p.products_date_available, p.products_status, p.manufacturers_id  from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = pd.products_id and p.products_id = '" . (int)$_GET['pID'] . "'");
      $product = smn_db_fetch_array($product_query);
      $pInfo = $product;
      $products_image_name = $pInfo[products_image];
    }

    $form_action = (isset($_GET['pID'])) ? 'update_store_product' : 'insert_product';
    echo smn_draw_form($form_action, FILENAME_STORE_PRODUCT_CATEGORIES.'?ID='.$store_id.'&cPath=' . $cPath . (isset($_GET['pID']) ? '&pID=' . $_GET['pID'] : '') . '&action=' . $form_action, 'post', 'enctype="multipart/form-data"');
    $languages = smn_get_languages();
    for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
      if (isset($_GET['read']) && ($_GET['read'] == 'only')) {
        $pInfo[products_name] = smn_get_products_name($pInfo[products_id], $languages[$i]['id']);
        $pInfo[products_description] = smn_get_products_description($pInfo[products_id], $languages[$i]['id']);
        $pInfo[products_head_title_tag] = $products_head_title_tag[$languages[$i]['id']];
        $pInfo[products_head_desc_tag]= $products_head_desc_tag[$languages[$i]['id']];
        $pInfo[products_head_keywords_tag] = $products_head_keywords_tag[$languages[$i]['id']];
        $pInfo[products_url] = smn_get_products_url($pInfo[products_id], $languages[$i]['id']);
      } else {
        $pInfo[products_name] = smn_db_prepare_input($products_name[$languages[$i]['id']]);
        $pInfo[products_description] = $products_description[$languages[$i]['id']];
        $pInfo[products_head_title_tag] = $products_head_title_tag[$languages[$i]['id']];
        $pInfo[products_head_desc_tag]= $products_head_desc_tag[$languages[$i]['id']];
        $pInfo[products_head_keywords_tag] = $products_head_keywords_tag[$languages[$i]['id']];
        $pInfo[products_url] = smn_db_prepare_input($products_url[$languages[$i]['id']]);
      } 
?>
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo smn_image(DIR_WS_LANGUAGES .  'images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . $pInfo[products_name]; ?></td>
            <td class="pageHeading" align="right"><?php echo $currencies->format($pInfo[products_price]); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><?php echo smn_image(DIR_WS_CATALOG_IMAGES . $products_image_name, $pInfo[products_name], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'align="right" hspace="5" vspace="5"') . $pInfo[products_description]; ?></td>
      </tr>
<?php
      if ($pInfo[products_url]) {
?>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><?php echo sprintf(TEXT_PRODUCT_MORE_INFORMATION, $pInfo[products_url]); ?></td>
      </tr>
<?php
      }
?>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
<?php
      if ($pInfo[products_date_available] > date('Y-m-d')) {
?>
      <tr>
        <td align="center" class="smallText"><?php echo sprintf(TEXT_PRODUCT_DATE_AVAILABLE, smn_date_long($pInfo[products_date_available])); ?></td>
      </tr>
<?php
      } else {
?>
      <tr>
        <td align="center" class="smallText"><?php echo sprintf(TEXT_PRODUCT_DATE_ADDED, smn_date_long($pInfo[products_date_added])); ?></td>
      </tr>
<?php
      }
?>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
<?php
    }
    if (isset($_GET['read']) && ($_GET['read'] == 'only')) {
      if (isset($_GET['origin'])) {
        $pos_params = strpos($_GET['origin'], '?', 0);
        if ($pos_params != false) {
          $back_url = substr($_GET['origin'], 0, $pos_params);
          $back_url_params = substr($_GET['origin'], $pos_params + 1);
        } else {
          $back_url = $_GET['origin'];
          $back_url_params = '';
        }
      } else {
        $back_url = FILENAME_STORE_PRODUCT_CATEGORIES;
        $back_url_params = 'cPath=' . $cPath . '&ID='.$store_id.'&pID=' . $pInfo[products_id] .'&ID='.$store_id;
      }
?>
      <tr>
        <td align="right"><?php echo '<a href="' . smn_href_link($back_url, $back_url_params, 'NONSSL') . '">' . smn_image_button('small_back.gif', IMAGE_BACK) . '</a>'; ?></td>
      </tr>
<?php
    } else {
?>
      <tr>
        <td align="right" class="smallText">
<?php
/* Re-Post all POST'ed variables */
      reset($_POST);
      while (list($key, $value) = each($_POST)) {
        if (!is_array($_POST[$key])) {
          echo smn_draw_hidden_field($key, htmlspecialchars(stripslashes($value)));
        }
      }
      $languages = smn_get_languages();
      for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
        echo smn_draw_hidden_field('products_name[' . $languages[$i]['id'] . ']', htmlspecialchars(stripslashes($products_name[$languages[$i]['id']])));
        echo smn_draw_hidden_field('products_description[' . $languages[$i]['id'] . ']', htmlspecialchars(stripslashes($products_description[$languages[$i]['id']])));
        echo smn_draw_hidden_field('products_head_title_tag[' . $languages[$i]['id'] . ']', htmlspecialchars(stripslashes($products_head_title_tag[$languages[$i]['id']])));
        echo smn_draw_hidden_field('products_head_desc_tag[' . $languages[$i]['id'] . ']', htmlspecialchars(stripslashes($products_head_desc_tag[$languages[$i]['id']])));
        echo smn_draw_hidden_field('products_head_keywords_tag[' . $languages[$i]['id'] . ']', htmlspecialchars(stripslashes($products_head_keywords_tag[$languages[$i]['id']])));
        echo smn_draw_hidden_field('products_url[' . $languages[$i]['id'] . ']', htmlspecialchars(stripslashes($products_url[$languages[$i]['id']])));
      }
      echo smn_draw_hidden_field('products_image', stripslashes($products_image_name));
      echo smn_image_submit('small_back.gif', IMAGE_BACK, 'name="edit"') . '&nbsp;&nbsp;';
      if (isset($_GET['pID'])) {
        if ($allow_insert == 'true') {
          echo smn_image_submit('small_save.gif', IMAGE_UPDATE);
        }
      } else {
        if ($allow_insert == 'true') {
          echo smn_image_submit('small_save.gif', IMAGE_INSERT);
        }
      }
      echo '&nbsp;&nbsp;<a href="' . smn_href_link(FILENAME_STORE_PRODUCT_CATEGORIES, 'cPath=' . $cPath . (isset($_GET['pID']) ? '&pID=' . $_GET['pID'] : '').'&ID='.$store_id) . '">' . smn_image_button('small_cancel.gif', IMAGE_CANCEL) . '</a>';
?></td>
      </tr>
    </table></form>
<?php
    }
  } else {
?>
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo smn_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>
            <td align="right"><table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td class="smallText" align="right">
<?php
    echo smn_draw_form('search', FILENAME_STORE_PRODUCT_CATEGORIES.'?ID='.$store_id, 'post');
    echo HEADING_TITLE_SEARCH . ' ' . smn_draw_input_field('search');
    echo smn_hide_session_id() . '</form>';
?>
                </td>
              </tr>
              <tr>
                <td class="smallText" align="right">
<?php
    echo smn_draw_form('goto', FILENAME_STORE_PRODUCT_CATEGORIES,'get');
    echo smn_draw_hidden_field('ID', $store_id);
	echo HEADING_TITLE_GOTO . ' ' . smn_draw_pull_down_menu('cPath', smn_get_category_tree(), $current_category_id, 'onChange="this.form.submit();"');
    echo smn_hide_session_id() . '</form>';
?>
                </td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">
		<?php if(!$action)	{?>
			<table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_CATEGORIES_PRODUCTS; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
}
    $categories_count = 0;
    $rows = 0;
    if (isset($_POST['search'])) {
      $search = smn_db_prepare_input($_POST['search']);

      $categories_query = smn_db_query("select cd.categories_description, c.category_head_title_tag, c.category_head_desc_tag, c.category_head_keywords_tag, c.categories_id, cd.categories_name, c.categories_image, c.parent_id, c.sort_order, c.date_added, c.last_modified from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where cd.store_id = '". $store_id . "' and c.store_id = '". $store_id . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' and cd.categories_name like '%" . smn_db_input($search) . "%' order by c.sort_order, cd.categories_name");
    } else {
      $categories_query = smn_db_query("select cd.categories_description, c.category_head_title_tag, c.category_head_desc_tag, c.category_head_keywords_tag, c.categories_id, cd.categories_name, c.categories_image, c.parent_id, c.sort_order, c.date_added, c.last_modified from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where cd.store_id = '". $store_id . "' and c.store_id = '". $store_id . "' and c.parent_id = '" . (int)$current_category_id . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' order by c.sort_order, cd.categories_name");
    }
    while ($categories = smn_db_fetch_array($categories_query)) {
      $categories_count++;
      $rows++;
// Get parent_id for subcategories if search
      if (isset($_POST['search'])) $cPath= $categories['parent_id'];
      if ((!isset($_GET['cID']) && !isset($_GET['pID']) || (isset($_GET['cID']) && ($_GET['cID'] == $categories['categories_id']))) && !isset($cInfo) && (substr($action, 0, 3) != 'new')) {
        $category_childs = array('childs_count' => smn_childs_in_category_count($categories['categories_id']));
        $category_products = array('products_count' => smn_products_in_category_count($categories['categories_id']));
        $cInfo = array_merge($categories, $category_childs, $category_products);
      }
?>
		<?php if(!$action)	{?>

                <td class="dataTableContent"><?php echo '<a href="' . smn_href_link(FILENAME_STORE_PRODUCT_CATEGORIES, smn_get_path($categories['categories_id']).'&ID='.$store_id) . '">' . smn_image(DIR_WS_ICONS . 'folder.gif', ICON_FOLDER) . '</a>&nbsp;<b>' . $categories['categories_name'] . '</b>'; ?></td>
                <td class="dataTableContent" align="center">&nbsp;</td>
                <td class="dataTableContent" align="right"><?php echo '<a href="' . smn_href_link(FILENAME_STORE_PRODUCT_CATEGORIES, 'cPath=' . $cPath . '&ID='.$store_id.'&cID=' . $categories[categories_id] . '&action=edit_category') . '">' . smn_image(DIR_WS_ICONS . 'edit.png', IMAGE_ICON_EDIT) . '</a> &nbsp;'; echo '<a href="' . smn_href_link(FILENAME_STORE_PRODUCT_CATEGORIES, 'cPath=' . $cPath . '&ID='.$store_id.'&cID=' . $categories[categories_id] . '&action=delete_category') . '">' . smn_image(DIR_WS_ICONS . 'delete.png', IMAGE_ICON_DELETE) . '</a> &nbsp;';echo '<a href="' . smn_href_link(FILENAME_STORE_PRODUCT_CATEGORIES, 'cPath=' . $cPath . '&ID='.$store_id.'&cID=' . $categories[categories_id] . '&action=move_category') . '">' . smn_image(DIR_WS_ICONS . 'move.png', IMAGE_ICON_MOVE) . '</a>'; ?>&nbsp;</td>
              </tr>
			  <? } ?>
<?php
    }
    $products_count = 0;
    if (isset($_POST['search'])) {
      $products_query = smn_db_query("select p.products_id, pd.products_name, p.products_quantity, p.products_image, p.products_price, p.products_date_added, p.products_last_modified, p.products_date_available, p.products_status, p2c.categories_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where  p2c.store_id = '". $store_id . "' and p.store_id = '" . $store_id . "' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' and p.products_id = p2c.products_id and pd.products_name like '%" . smn_db_input($search) . "%' order by pd.products_name");
    } else {
      $products_query = smn_db_query("select p.products_id, pd.products_name, p.products_quantity, p.products_image, p.products_price, p.products_date_added, p.products_last_modified, p.products_date_available, p.products_status from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where  p2c.store_id = '". $store_id . "' and p.store_id = '" . $store_id . "' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' and p.products_id = p2c.products_id and p2c.categories_id = '" . (int)$current_category_id . "' order by pd.products_name");
    }
    while ($products = smn_db_fetch_array($products_query)) {
      $products_count++;
      $rows++;
// Get categories_id for product if search
      if (isset($_POST['search'])) $cPath = $products['categories_id'];
      if ( (!isset($_GET['pID']) && !isset($_GET['cID']) || (isset($_GET['pID']) && ($_GET['pID'] == $products['products_id']))) && !isset($pInfo) && !isset($cInfo) && (substr($action, 0, 3) != 'new')) {
// find out the rating average from customer reviews
        $reviews_query = smn_db_query("select (avg(reviews_rating) / 5 * 100) as average_rating from " . TABLE_REVIEWS . " where products_id = '" . (int)$products['products_id'] . "'");
        $reviews = smn_db_fetch_array($reviews_query);
        $pInfo = array_merge($products, $reviews);
      }
?>
		<?php if(!$action)	{?>

                <td class="dataTableContent"><?php echo '<a href="' . smn_href_link(FILENAME_STORE_PRODUCT_CATEGORIES, 'cPath=' . $cPath . '&ID='.$store_id.'&pID=' . $products['products_id'] . '&action=new_product_preview&read=only'.'&ID='.$store_id) . '">' . smn_image(DIR_WS_ICONS . 'preview.gif', ICON_PREVIEW) . '</a>&nbsp;' . $products['products_name']; ?></td>
                <td class="dataTableContent" align="center">
				
<?php
      if ($products['products_status'] == '1') {
        echo smn_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . smn_href_link(FILENAME_STORE_PRODUCT_CATEGORIES, 'action=setflag&flag=0&pID=' . $products['products_id'] . '&cPath=' . $cPath.'&ID='.$store_id) . '">' . smn_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
      } else {
        echo '<a href="' . smn_href_link(FILENAME_STORE_PRODUCT_CATEGORIES, 'action=setflag&flag=1&pID=' . $products['products_id'] . '&cPath=' . $cPath.'&ID='.$store_id) . '">' . smn_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . smn_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
      }
?></td>
                <td class="dataTableContent" align="right"><?php echo '<a href="' . smn_href_link(FILENAME_STORE_PRODUCT_CATEGORIES, 'cPath=' . $cPath . '&ID='.$store_id.'&pID=' . $products[products_id] . '&action=new_product') . '">' . smn_image(DIR_WS_ICONS . 'edit.png', IMAGE_ICON_EDIT) . '</a>';  ?>&nbsp;<? echo '<a href="' . smn_href_link(FILENAME_STORE_PRODUCT_CATEGORIES, 'cPath=' . $cPath . '&ID='.$store_id.'&pID=' . $products[products_id] . '&action=delete_product') . '">' . smn_image(DIR_WS_ICONS . 'delete.png', IMAGE_ICON_DELETE) . '</a>';  ?>&nbsp;<? echo '<a href="' . smn_href_link(FILENAME_STORE_PRODUCT_CATEGORIES, 'cPath=' . $cPath . '&ID='.$store_id.'&pID=' . $products[products_id] . '&action=move_product') . '">' . smn_image(DIR_WS_ICONS . 'move.png', IMAGE_ICON_MOVE) . '</a>';  ?>&nbsp;<? echo '<a href="' . smn_href_link(FILENAME_STORE_PRODUCT_CATEGORIES, 'cPath=' . $cPath . '&ID='.$store_id.'&pID=' . $products[products_id] . '&action=copy_to') . '">' . smn_image(DIR_WS_ICONS . 'copy.gif', IMAGE_ICON_COPY) . '</a>';  ?>&nbsp;</td>
              </tr>
<?php
}
    }
    $cPath_back = '';
    if (sizeof($cPath_array) > 0) {
      for ($i=0, $n=sizeof($cPath_array)-1; $i<$n; $i++) {
        if (empty($cPath_back)) {
          $cPath_back .= $cPath_array[$i];
        } else {
          $cPath_back .= '_' . $cPath_array[$i];
        }
      }
    }
    $cPath_back = (smn_not_null($cPath_back)) ? 'cPath=' . $cPath_back . '&' : '';
?>
		<?php if(!$action)	{?>

              <tr>
                <td colspan="3"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText"><?php echo TEXT_CATEGORIES . '&nbsp;' . $categories_count . '<br>' . TEXT_PRODUCTS . '&nbsp;' . $products_count; ?></td>
                    <td align="right" class="smallText">
                    <?php if (sizeof($cPath_array) > 0)
                        echo '<a href="' . smn_href_link(FILENAME_STORE_PRODUCT_CATEGORIES, $cPath_back . 'cID=' . $current_category_id.'&ID='.$store_id) . '">' . smn_image_button('small_back.gif', IMAGE_BACK) . '</a>&nbsp;';
                        if (!isset($_POST['search'])){ echo '<a href="' . smn_href_link(FILENAME_STORE_PRODUCT_CATEGORIES, 'cPath=' . $cPath . '&ID='.$store_id.'&action=new_category') . '">' . smn_image_button('small_new_category.gif', IMAGE_NEW_CATEGORY) . '</a>';}
                        if (($allow_insert == 'true') && ($cPath > 0)) { echo '&nbsp;<a href="' . smn_href_link(FILENAME_STORE_PRODUCT_CATEGORIES, 'cPath=' . $cPath . '&ID='.$store_id.'&action=new_product') . '">' . smn_image_button('small_new_product.gif', IMAGE_NEW_PRODUCT) . '</a>'; }?>
                      </td>
                  </tr>
                </table></td>
              </tr>
            </table>
<? } ?>			
			
			</td>
<?php
    $heading = array();
    $contents = array();
    switch ($action) {
      case 'new_category':
?> 
<SCRIPT LANGUAGE="JavaScript">
function textCounter(field,cntfield,maxlimit) {
if (field.value.length > maxlimit) // if too long...trim it!
field.value = field.value.substring(0, maxlimit);
// otherwise, update 'characters left' counter
else
cntfield.value = maxlimit - field.value.length;
}
</script>
<?php      
      
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_NEW_CATEGORY . '</b>');
        $contents = array('form' => smn_draw_form('newcategory', FILENAME_STORE_PRODUCT_CATEGORIES.'?ID='.$store_id.'&action=insert_category&cPath=' . $cPath,  'post', 'enctype="multipart/form-data"'));
        $contents[] = array('text' => TEXT_NEW_CATEGORY_INTRO);
        $category_inputs_string = '';
		$category_description_input_string = '';
        $languages = smn_get_languages();
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
          $category_inputs_string .= '<br>' . smn_image(DIR_WS_LANGUAGES .  'images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . smn_draw_input_field('categories_name[' . $languages[$i]['id'] . ']');
         // $category_description_input_string .= '<br>' . smn_image(DIR_WS_LANGUAGES .  'images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . smn_draw_input_field('categories_description[' . $languages[$i]['id'] . ']');



$category_description_input_string .= '<br>' . smn_image(DIR_WS_LANGUAGES .  'images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;<br><textarea name="categories_description[' . $languages[$i]['id'] . ']" wrap="physical" cols="28" rows="5" onKeyDown="textCounter(this,document.newcategory.remLen1,125)" onKeyUp="textCounter(this,document.newcategory.remLen1,125)" ID="categories_description"></textarea>' .
				      '<br><input readonly type="text" name="remLen1" size="3" maxlength="3" value="125">characters left<br>';
	  
	  
	  
        }
        $contents[] = array('text' => '<br>' . TEXT_CATEGORIES_NAME . $category_inputs_string);
        $contents[] = array('text' => '<br>' . TEXT_EDIT_CATEGORIES_DESCRIPTION . $category_description_input_string);
        $contents[] = array('text' => '<br>' . TEXT_CATEGORIES_IMAGE . '<br>' . smn_draw_file_field('categories_image'));
        $contents[] = array('text' => '<br>' . TEXT_SORT_ORDER . '<br>' . smn_draw_input_field('sort_order', '', 'size="2"'));
        $contents[] = array('text' => '<br>' . TEXT_CATEGORY_PAGE_TITLE . '<br>' . smn_draw_input_field('htc_title', '', 'size="30"'));
        $contents[] = array('text' => '<br>' . TEXT_CATEGORY_HEADER_DESCRIPTION . '<br>' . smn_draw_input_field('htc_desc', '', 'size="30"'));
        $contents[] = array('text' => '<br>' . TEXT_CATEGORY_KEYWORDS . '<br>' . smn_draw_input_field('htc_keywords', '', 'size="30"'));
        $contents[] = array('align' => 'center', 'text' => '<br>' . smn_image_submit('small_save.gif', IMAGE_SAVE) . ' <a href="' . smn_href_link(FILENAME_STORE_PRODUCT_CATEGORIES, 'cPath=' . $cPath.'&ID='.$store_id) . '">' . smn_image_button('small_cancel.gif', IMAGE_CANCEL) . '</a>');

        break;
      case 'edit_category':
?> 
<SCRIPT LANGUAGE="JavaScript">
function textCounter(field,cntfield,maxlimit) {
if (field.value.length > maxlimit) // if too long...trim it!
field.value = field.value.substring(0, maxlimit);
// otherwise, update 'characters left' counter
else
cntfield.value = maxlimit - field.value.length;
}
</script>
<?php       
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_CATEGORY . '</b>');
        $contents = array('form' => smn_draw_form('categories', FILENAME_STORE_PRODUCT_CATEGORIES.'?ID='.$store_id.'&action=update_category&cPath=' . $cPath, 'post', 'enctype="multipart/form-data"') . smn_draw_hidden_field('categories_id', $cInfo[categories_id]));
        $contents[] = array('text' => TEXT_EDIT_INTRO);
        $category_inputs_string = '';
		$category_description_input_string = '';
        $languages = smn_get_languages();
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
          $category_inputs_string .= '<br>' . smn_image(DIR_WS_LANGUAGES .  'images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . smn_draw_input_field('categories_name[' . $languages[$i]['id'] . ']', smn_get_category_name($cInfo[categories_id], $languages[$i]['id']));
          //$category_description_input_string .= '<br>' . smn_image(DIR_WS_LANGUAGES .  'images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . smn_draw_input_field('categories_description[' . $languages[$i]['id'] . ']', smn_get_category_description($cInfo[categories_id], $languages[$i]['id']));
	  
 
	  
$category_description_input_string .= '<br>' . smn_image(DIR_WS_LANGUAGES .  'images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;<br><textarea name="categories_description[' . $languages[$i]['id'] . ']" wrap="physical" cols="28" rows="5" onKeyDown="textCounter(this,document.categories.remLen2,125)" onKeyUp="textCounter(this,document.categories.remLen2,125)" value="' . $cInfo[categories_id] . '" ID="categories_description">' . smn_get_category_description($cInfo[categories_id], $languages[$i]['id']) . '</textarea>' .
				      '<br><input readonly type="text" name="remLen2" size="3" maxlength="3" value="125">characters left<br>';
	  
	  
	  
        }
		
		$image_size = @getimagesize(DIR_WS_CATALOG_IMAGES . $cInfo[categories_image]);
		if($image_size[0]>450){
			$width = 450;
		}else{
			$width = $image_size[0];
		}

        $contents[] = array('text' => '<br>' . TEXT_EDIT_CATEGORIES_NAME . $category_inputs_string);
        $contents[] = array('text' => '<br>' . TEXT_EDIT_CATEGORIES_DESCRIPTION . $category_description_input_string);
        $contents[] = array('text' => '<br>' . smn_image(DIR_WS_CATALOG_IMAGES . $cInfo[categories_image], $cInfo[categories_name],$width) . '<br>' . DIR_WS_CATALOG_IMAGES . '<br><b>' . $cInfo[categories_image] . '</b>');
        $contents[] = array('text' => '<br>' . TEXT_EDIT_CATEGORIES_IMAGE . '<br>' . smn_draw_file_field('categories_image'));
        $contents[] = array('text' => '<br>' . TEXT_EDIT_SORT_ORDER . '<br>' . smn_draw_input_field('sort_order', $cInfo[sort_order], 'size="2"'));
        $contents[] = array('text' => '<br>' . TEXT_CATEGORY_PAGE_TITLE . '<br>' . smn_draw_input_field('htc_title', $cInfo[category_head_title_tag], 'size="30"'));
        $contents[] = array('text' => '<br>' . TEXT_CATEGORY_HEADER_DESCRIPTION . '<br>' . smn_draw_input_field('htc_desc', $cInfo[category_head_desc_tag], 'size="30"'));
        $contents[] = array('text' => '<br>' . TEXT_CATEGORY_KEYWORDS . '<br>' . smn_draw_input_field('htc_keywords', $cInfo[category_head_keywords_tag], 'size="30"')); 

        $contents[] = array('align' => 'center', 'text' => '<br>' . smn_image_submit('small_save.gif', IMAGE_SAVE) . ' <a href="' . smn_href_link(FILENAME_STORE_PRODUCT_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $cInfo[categories_id]) .'&ID='.$store_id. '">' . smn_image_button('small_cancel.gif', IMAGE_CANCEL) . '</a>');

        break;
      case 'delete_category':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_CATEGORY . '</b>');
        $contents = array('form' => smn_draw_form('categories', FILENAME_STORE_PRODUCT_CATEGORIES.'?ID='.$store_id.'&action=delete_category_confirm&cPath=' . $cPath, 'POST') . smn_draw_hidden_field('categories_id', $cInfo[categories_id]));
        $contents[] = array('text' => TEXT_DELETE_CATEGORY_INTRO);
        $contents[] = array('text' => '<br><b>' . $cInfo[categories_name] . '</b>');
        if ($cInfo[childs_count] > 0) $contents[] = array('text' => '<br>' . sprintf(TEXT_DELETE_WARNING_CHILDS, $cInfo[childs_count]));
        if ($cInfo[products_count] > 0) $contents[] = array('text' => '<br>' . sprintf(TEXT_DELETE_WARNING_PRODUCTS, $cInfo[products_count]));
        $contents[] = array('align' => 'center', 'text' => '<br>' . smn_image_submit('small_delete.gif', IMAGE_DELETE) . ' <a href="' . smn_href_link(FILENAME_STORE_PRODUCT_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $cInfo[categories_id]) .'&ID='.$store_id. '">' . smn_image_button('small_cancel.gif', IMAGE_CANCEL) . '</a>');

        break;
      case 'move_category':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_MOVE_CATEGORY . '</b>');
        $contents = array('form' => smn_draw_form('categories', FILENAME_STORE_PRODUCT_CATEGORIES.'?ID='.$store_id.'&action=move_category_confirm&cPath=' . $cPath) . smn_draw_hidden_field('categories_id', $cInfo[categories_id]));
        $contents[] = array('text' => sprintf(TEXT_MOVE_CATEGORIES_INTRO, $cInfo[categories_name]));
        $contents[] = array('text' => '<br>' . sprintf(TEXT_MOVE, $cInfo[categories_name]) . '<br>' . smn_draw_pull_down_menu('move_to_category_id', smn_get_category_tree(), $current_category_id));
        $contents[] = array('align' => 'center', 'text' => '<br>' . smn_image_submit('small_move.gif', IMAGE_MOVE) . ' <a href="' . smn_href_link(FILENAME_STORE_PRODUCT_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $cInfo[categories_id]) .'&ID='.$store_id. '">' . smn_image_button('small_cancel.gif', IMAGE_CANCEL) . '</a>');
  
        break;
      case 'delete_product':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_PRODUCT . '</b>');
        $contents = array('form' => smn_draw_form('products', FILENAME_STORE_PRODUCT_CATEGORIES.'?ID='.$store_id.'&action=delete_product_confirm&cPath=' . $cPath) . smn_draw_hidden_field('products_id', $pInfo[products_id]));
        $contents[] = array('text' => TEXT_DELETE_PRODUCT_INTRO);
        $contents[] = array('text' => '<br><b>' . $pInfo[products_name] . '</b>');
        $product_categories_string = '';
        $product_categories = smn_generate_category_path($pInfo[products_id], 'product');
        for ($i = 0, $n = sizeof($product_categories); $i < $n; $i++) {
          $category_path = '';
          for ($j = 0, $k = sizeof($product_categories[$i]); $j < $k; $j++) {
            $category_path .= $product_categories[$i][$j]['text'] . '&nbsp;&gt;&nbsp;';
          }
          $category_path = substr($category_path, 0, -16);
          $product_categories_string .= smn_draw_checkbox_field('product_categories[]', $product_categories[$i][sizeof($product_categories[$i])-1]['id'], true) . '&nbsp;' . $category_path . '<br>';
        }
        $product_categories_string = substr($product_categories_string, 0, -4);
        $contents[] = array('text' => '<br>' . $product_categories_string);
        $contents[] = array('align' => 'center', 'text' => '<br>' . smn_image_submit('small_delete.gif', IMAGE_DELETE) . ' <a href="' . smn_href_link(FILENAME_STORE_PRODUCT_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo[products_id]) .'&ID='.$store_id. '">' . smn_image_button('small_cancel.gif', IMAGE_CANCEL) . '</a>');
        break;
      case 'move_product':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_MOVE_PRODUCT . '</b>');
        $contents = array('form' => smn_draw_form('products', FILENAME_STORE_PRODUCT_CATEGORIES.'?ID='.$store_id.'&action=move_product_confirm&cPath=' . $cPath) . smn_draw_hidden_field('products_id', $pInfo[products_id]));
        $contents[] = array('text' => sprintf(TEXT_MOVE_PRODUCTS_INTRO, $pInfo[products_name]));
        $contents[] = array('text' => '<br>' . TEXT_INFO_CURRENT_CATEGORIES . '<br><b>' . smn_output_generated_category_path($pInfo[products_id], 'product') . '</b>');
        $contents[] = array('text' => '<br>' . sprintf(TEXT_MOVE, $pInfo[products_name]) . '<br>' . smn_draw_pull_down_menu('move_to_category_id', smn_get_category_tree(), $current_category_id));
        $contents[] = array('align' => 'center', 'text' => '<br>' . smn_image_submit('small_move.gif', IMAGE_MOVE) . ' <a href="' . smn_href_link(FILENAME_STORE_PRODUCT_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo[products_id]) .'&ID='.$store_id. '">' . smn_image_button('small_cancel.gif', IMAGE_CANCEL) . '</a>');
        break;
      case 'copy_to':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_COPY_TO . '</b>');
        $contents = array('form' => smn_draw_form('copy_to', FILENAME_STORE_PRODUCT_CATEGORIES.'?ID='.$store_id.'&action=copy_to_confirm&cPath=' . $cPath) . smn_draw_hidden_field('products_id', $pInfo[products_id]));
        $contents[] = array('text' => TEXT_INFO_COPY_TO_INTRO);
        $contents[] = array('text' => '<br>' . TEXT_INFO_CURRENT_CATEGORIES . '<br><b>' . smn_output_generated_category_path($pInfo[products_id], 'product') . '</b>');
        $contents[] = array('text' => '<br>' . TEXT_CATEGORIES . '<br>' . smn_draw_pull_down_menu('categories_id', smn_get_category_tree(), $current_category_id));
        $contents[] = array('text' => '<br>' . TEXT_HOW_TO_COPY . '<br>' . smn_draw_radio_field('copy_as', 'link', true) . ' ' . TEXT_COPY_AS_LINK . '<br>' . smn_draw_radio_field('copy_as', 'duplicate') . ' ' . TEXT_COPY_AS_DUPLICATE);
        $contents[] = array('align' => 'center', 'text' => '<br>' . smn_image_submit('small_copy.gif', IMAGE_COPY) . ' <a href="' . smn_href_link(FILENAME_STORE_PRODUCT_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo[products_id]) .'&ID='.$store_id. '">' . smn_image_button('small_cancel.gif', IMAGE_CANCEL) . '</a>');
        break;
    }
    if ( (smn_not_null($heading)) && (smn_not_null($contents)) ) {
      echo '            <td width="25%" valign="top">' . "\n";
      $box = new box;
      echo $box->infoBox($heading, $contents);
      echo '            </td>' . "\n";
    }
?>
          </tr>
        </table></td>
      </tr>
    </table>
	<?php
  }
?>
