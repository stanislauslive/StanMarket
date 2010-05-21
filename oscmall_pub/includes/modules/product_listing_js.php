<?php
/*
  Copyright (c) 2002 - 2005 SystemsManager.Net
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

  $listing_split = new splitPageResults($listing_sql, MAX_DISPLAY_SEARCH_RESULTS, 'p.products_id');
  if ($listing_split->number_of_rows > 0) {
    $rows = 0;
    $listing_query = smn_db_query($listing_split->sql_query);
    
    $storeData = array();
    $storeNames = array();
    
    while ($listing = smn_db_fetch_array($listing_query)) {
      $rows++;
      
      if (!isset($storeNames[$listing['store_id']])){
      	 $storeNames[$listing['store_id']] = smn_get_stores_name($listing['store_id']);
      }

      $rowData = array('"' . $storeNames[$listing['store_id']] . '"');
      
      for ($col=0, $n=sizeof($column_list); $col<$n; $col++) {
        $lc_align = '';
        $store_images = 'images/'. $listing['store_id'] . '_images/';
        switch ($column_list[$col]) {
          case 'PRODUCT_LIST_MODEL':
            $rowData[$col] = '"' . $listing['products_model'] . '"';
            break;
          case 'PRODUCT_LIST_NAME':
              $rowData[$col] = '"' . $listing['products_name'] . '"';
            break;
          case 'PRODUCT_LIST_MANUFACTURER':
            $rowData[$col] = '"' . $listing['manufacturers_name'] . '"';
            break;
          case 'PRODUCT_LIST_PRICE':
            if (smn_not_null($listing['specials_new_products_price'])) {
              $rowData[$col] = '"' . $listing['specials_new_products_price'] . '"';
            } else {
              $rowData[$col] = '"' . $listing['products_price'] . '"';
            }
            break;
          case 'PRODUCT_LIST_QUANTITY':
            $rowData[$col] = '"' . $listing['products_quantity'] . '"';
            break;
          case 'PRODUCT_LIST_WEIGHT':
            $rowData[$col] = '"' . $listing['products_weight'] . '"';
            break;
        }
      }
      $rowData[] = '"' . smn_get_products_description($listing['products_id'], $languages_id) . '"';
      $rowData[] = '"' . DIR_WS_IMAGES . $listing['products_image'] . '"';
      $rowData[] = '"' . $listing['products_id'] . '"';
      $rowData[] = '"' . $listing['store_id'] . '"';
      $storeData[] = '[' . implode(',', $rowData) . ']';
    }
  }
?>
<div id="productListing"></div>
<div id="productListing_preview" style="padding-top:10px;"></div>
<textarea id="preview-tpl" style="display:none;">
    <div class="post-data">
     <table width="100%" cellpadding="0" cellspacing="0" border="0">
     <tr>
     <td><img src="{image}"></td>
     <td>{description}</td>
     </tr>
     <tr>
      <td colspan="2" align="right"><a href="<?php echo smn_href_link(basename($PHP_SELF), smn_get_all_get_params(array('action')) . 'action=buy_now&ID={store_id}&products_id={product_id}');?>"><?php echo smn_image_button('button_buy_now.gif', IMAGE_BUTTON_BUY_NOW);?></a></tD>
     </tr>
     </table>
    </div>
</textarea>

    <link rel="stylesheet" type="text/css" href="ext/<?php echo EXTJS_VERSION;?>/resources/css/ext-all.css" />
	    
    <script type="text/javascript" src="ext/<?php echo EXTJS_VERSION;?>/adapter/ext/ext-base.js"></script>
 	<script type="text/javascript" src="ext/<?php echo EXTJS_VERSION;?>/ext-all.js"></script>
    <script type="text/javascript">
     Ext.onReady(function(){
      var tpl = Ext.Template.from('preview-tpl', {
        compiled:true
      });

        
        var previewPanel = new Ext.Panel({
          id: 'preview',
          renderTo: 'productListing_preview',
          cls:'preview', 
          autoScroll: true,
          width:500,
          height:400,
          bodyStyle: 'padding:5px;',
//          title: 'Product Preview',
          tbar: ['<b>Product Preview</b>'/*, '->', new Ext.Button({text: 'Buy Now', pressed: true})*/]//,
//          bbar: ['->', new Ext.Button({text: 'Buy Now', pressed: true})]
        });
      
      var myData = [<?php echo implode(',', $storeData);?>];
      var store = new Ext.data.SimpleStore({
          fields: [<?php
          $data = array('{name: \'vendor\'}');
          for ($i=0, $n=sizeof($column_list); $i<$n; $i++) {
            switch ($column_list[$i]) {
             case 'PRODUCT_LIST_MODEL':
              $data[] = '{name: \'model\'}';
             break;
             case 'PRODUCT_LIST_NAME':
              $data[] = '{name: \'name\'}';
             break;
             case 'PRODUCT_LIST_INFO':  
              $data[] = '{name: \'info\'}';
             break;
             case 'PRODUCT_LIST_MANUFACTURER':
              $data[] = '{name: \'manufacturer\'}';
             break;
             case 'PRODUCT_LIST_QUANTITY':
              $data[] = '{name: \'quantity\'}';
             break;
             case 'PRODUCT_LIST_PRICE':
              $data[] = '{name: \'price\'}';
             break;
             case 'PRODUCT_LIST_WEIGHT}';
              $data[] = '{name: \'weight\'}';
             break;
            }
          }
          $data[] = '{name: \'description\'}';
          $data[] = '{name: \'image\'}';
          $data[] = '{name: \'product_id\'}';
          $data[] = '{name: \'store_id\'}';
          echo implode(',', $data);
         ?>]
      });
      store.loadData(myData);

      var sm = new Ext.grid.RowSelectionModel({
         	listeners: {
         		'rowselect': function (sm, index, record){
         		  tpl.overwrite(previewPanel.body, record.data);
         		}
         	},
         	singleSelect:true
         });
     	
       var grid = new Ext.grid.GridPanel({
       	 store: store,
         sm: sm,
         viewConfig: {
           forceFit: true
         },
         frame:true,
         title:'Products Listing',
         renderTo: 'productListing',
         autoHeight:true,
         width:500,
         height: 400,
         columns: [<?php
          $data = array('{id: \'vendor\', header: \'Vendor\', width:200, sortable: true, dataIndex: \'vendor\'}');
          for ($i=0, $n=sizeof($column_list); $i<$n; $i++) {
            switch ($column_list[$i]) {
             case 'PRODUCT_LIST_MODEL':
              $data[] = '{id: \'model\', header: \'' . TABLE_HEADING_MODEL . '\', width: 200, sortable: true, dataIndex: \'model\'}';
             break;
             case 'PRODUCT_LIST_NAME':
              $data[] = '{id: \'name\', header: \'' . TABLE_HEADING_PRODUCTS . '\', width: 200, sortable: true, dataIndex: \'name\'}';
             break;
             case 'PRODUCT_LIST_INFO':  
              $data[] = '{id: \'info\', header: \'' . TABLE_HEADING_PRODUCTS . '\', width: 200, sortable: true, dataIndex: \'info\'}';
             break;
             case 'PRODUCT_LIST_MANUFACTURER':
              $data[] = '{id: \'manufacturer\', header: \'' . TABLE_HEADING_MANUFACTURER . '\', width: 200, sortable: true, dataIndex: \'manufacturer\'}';
             break;
             case 'PRODUCT_LIST_QUANTITY':
              $data[] = '{id: \'quantity\', header: \'' . TABLE_HEADING_QUANTITY . '\', width: 200, sortable: true, dataIndex: \'quantity\'}';
             break;
             case 'PRODUCT_LIST_PRICE':
              $data[] = '{id: \'price\', header: \'' . TABLE_HEADING_PRICE . '\', width: 200, sortable: true, renderer: Ext.util.Format.usMoney, dataIndex: \'price\'}';
             break;
             case 'PRODUCT_LIST_WEIGHT':
              $data[] = '{id: \'weight\', header: \'' . TABLE_HEADING_WEIGHT . '\', width: 200, sortable: true, dataIndex: \'weight\'}';
             break;
            }
          }
          echo implode(',', $data);
         ?>]
        });
        sm.selectFirstRow();
     });
    </script>
