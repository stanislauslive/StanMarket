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

  $rows = 0;                                  
  $storeData = array();
  while ($store_query = smn_db_fetch_array($store_info_query)){
     $rows++;
     if (file_exists(DIR_FS_CATALOG . '/images/' .$store_query['store_id'] . '_images/' .$store_query['store_image']) && $store_query['store_image'] != ''){
     	$storeImage = smn_image(DIR_WS_CATALOG_IMAGES . $store_query['store_image'], '', SUBCATEGORY_IMAGE_WIDTH, SUBCATEGORY_IMAGE_HEIGHT);
     }else{
     	$storeImage = smn_image(DIR_WS_IMAGES . 'default/default_store_logo.gif', '', SUBCATEGORY_IMAGE_WIDTH, SUBCATEGORY_IMAGE_HEIGHT);
     }
     
     $Qcustomer = smn_db_query('select c.* from ' . TABLE_CUSTOMERS . ' c, ' . TABLE_STORE_MAIN . ' s where s.store_id = "' . $store_query['store_id'] . '" and s.customer_id = c.customers_id');
     $customer = smn_db_fetch_array($Qcustomer);

	$storeData[] = '[
     "' . addslashes($storeImage) . '", 
     "' . $store_query['store_name'] . '", 
     "<a href=\"' .smn_href_link(FILENAME_INDEX, 'ID=' . $store_query['store_id']) . '\">' . addslashes(smn_image_button('go.jpg')) . '</a>", 
     "' . $store_query['store_description'] . '",
     "<a href=\"' . smn_href_link(FILENAME_CONTACT_US,'ID='.$store_query['store_id']) . '\" target=\"_blank\">Contact Store Owner</a>",
     "' . addslashes(smn_image(DIR_WS_CATALOG_IMAGES . $store_query['store_banner'], $store_query['store_name'], '500')) . '",
     "' . $customer['customers_telephone'] . '",
     "' . $customer['customers_fax'] . '",
     "' . $customer['customers_email_address'] . '"
     ]';
   }
?>
<td>
<div id="storeListing"></div>
<div id="storeListing_preview" style="padding-top:10px;"></div>
<textarea id="preview-tpl" style="display:none;">
 <div class="post-data">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
   <tr>
	<td width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
     <tr>
	  <td><div align="center">{banner}</div></td>
	 </tr>
     <tr>
      <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
     </tr>
     <tr>
      <td class="storedescription"><table width="100%" border="0" cellpadding="0" cellspacing="0">
       <tr>
        <td colspan="2"><br />{description}</font></td>
       </tr>
       <tr>
        <td align="left"><br /><font size="2">&nbsp;</font></td>
        <td align="right"><br /><font size="1">Telephone: {telephone}<br>Fax: {fax}<br>Email: {email}</td>
       </tr>
       <tr>
        <td align="left"><br /><font size="2">{name}</font></td>
        <td align="right"><br /><font size="2">{contact}</font></td>
       </tr>
      </table></td>
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
        renderTo: 'storeListing_preview',
        cls:'preview',
        autoScroll: true,
        width:500,
        height:400,
        bodyStyle: 'padding:5px;',
//        title: 'Store Information',
        tbar: ['<b>Store Information</b>'/*, '->', new Ext.Button({text: 'Visit Store', pressed: true})*/]//,
//        bbar: ['->', new Ext.Button({text: 'Visit Store', pressed: true})]
      });
      
      var myData = [<?php echo implode(',', $storeData);?>];
      var store = new Ext.data.SimpleStore({
          fields: [<?php
          $data = array(
            '{name: \'image\'}',
            '{name: \'name\'}',
            '{name: \'link\'}',
            '{name: \'description\'}',
            '{name: \'contact\'}',
            '{name: \'banner\'}',
            '{name: \'telephone\'}',
            '{name: \'fax\'}',
            '{name: \'email\'}'
            );
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
         title:'Stores In This Category',
         renderTo: 'storeListing',
         autoHeight:true,
         width:500,
         columns: [<?php
          $data = array(
            '{id: \'image\', header: \'Image\', width:200, sortable: true, dataIndex: \'image\'}',
            '{id: \'name\', header: \'Store Name\', width:200, sortable: true, dataIndex: \'name\'}',
            '{id: \'link\', header: \'Go To Store\', width:200, sortable: true, dataIndex: \'link\'}'
          );
          echo implode(',', $data);
         ?>]
        });
        sm.selectFirstRow();
     });
    </script>
</td>