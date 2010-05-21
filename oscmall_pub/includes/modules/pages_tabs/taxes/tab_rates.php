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

/* Tax Rates Grid Setup - BEGIN */
  $rates_query = smn_db_query("select r.tax_rates_id, z.geo_zone_id, z.geo_zone_name, tc.tax_class_title, tc.tax_class_id, r.tax_priority, r.tax_rate, r.tax_description, r.date_added, r.last_modified from " . TABLE_TAX_CLASS . " tc, " . TABLE_TAX_RATES . " r left join " . TABLE_GEO_ZONES . " z on r.tax_zone_id = z.geo_zone_id where r.tax_class_id = tc.tax_class_id and z.store_id = '" . $store_id ."' and r.store_id = '" . $store_id ."' and tc.store_id = '" . $store_id ."'");
  $ratesGridData = array();
  while ($rates = smn_db_fetch_array($rates_query)){
      $ratesGridData[] = array(
          $rates['tax_priority'], 
          $rates['tax_class_title'], 
          $rates['geo_zone_name'], 
          $rates['tax_rate'],
          $rates['tax_rates_id'],
          $rates['geo_zone_id'],
          $rates['tax_class_id'],
          $rates['tax_description'],
          $rates['last_modified'],
          $rates['date_added']
      );
  }
  
  $ratesGridEditButton = $jQuery->getPluginClass('button', array(
      'id'   => 'ratesGridEditButton',
      'text' => IMAGE_BUTTON_EDIT_SELECTED
  ));
  
  $ratesGridDeleteButton = $jQuery->getPluginClass('button', array(
      'id'   => 'ratesGridDeleteButton',
      'text' => IMAGE_BUTTON_DELETE_SELECTED
  ));
  
  $ratesGridInsertButton = $jQuery->getPluginClass('button', array(
      'id'   => 'ratesGridInsertButton',
      'text' => IMAGE_BUTTON_INSERT_NEW
  ));

  $ratesGrid = $jQuery->getPluginClass('basicgrid', array(
      'id' => 'taxRatesGrid',
      'columns' => array(
          array('id' => 'tax_priority', 'text' => TABLE_HEADING_TAX_PRIORITY),
          array('id' => 'tax_class_title', 'text' => TABLE_HEADING_TAX_CLASS_TITLE),
          array('id' => 'geo_zone_name', 'text' => TABLE_HEADING_GEO_ZONE_NAME),
          array('id' => 'tax_rate', 'text' => TABLE_HEADING_TAX_RATE),
          array('id' => 'tax_rates_id', 'text' => TABLE_HEADING_TAX_RATE_ID, 'hidden' => true),
          array('id' => 'tax_zone_id', 'text' => TABLE_HEADING_TAX_ZONE_ID, 'hidden' => true),
          array('id' => 'tax_class_id', 'text' => TABLE_HEADING_TAX_CLASS_ID, 'hidden' => true),
          array('id' => 'tax_description', 'text' => TABLE_HEADING_TAX_DESCRIPTION, 'hidden' => true),
          array('id' => 'last_modified', 'text' => TABLE_HEADING_LAST_MODIFIED, 'hidden' => true),
          array('id' => 'date_added', 'text' => TABLE_HEADING_DATE_ADDED, 'hidden' => true)
      ),
      'data' => $ratesGridData,
      'buttons' => array($ratesGridInsertButton, $ratesGridEditButton, $ratesGridDeleteButton)
  ));
/* Tax Rates Grid Setup - END */

/* Tax Rates Grid Edit Window Setup - BEGIN */
  $ratesGridEditWindow = $jQuery->getStandAloneClass('box_window', array(
      'id'          => 'div_rates_edit',
      'show_header' => true,
      'show_footer' => true,
      'header_text' => WINDOW_HEADING_EDIT_TAX_RATE,
      'buttons'     => array($commonSaveButton, $commonCancelButton),
      'form'        => '<form id="form_classesEdit" action="' . $jQuery->link(basename($_SERVER['PHP_SELF']), 'action=saveRate&ID=' . $store_id) . '" method="POST"><input type="hidden" name="hidden_action" id="hidden_action" value="new"><input type="hidden" name="tax_rates_id" id="tax_rates_id" value="">',
      'content'     => '<table cellpadding="3" cellspacing="0" border="0">
                         <tr>
                          <td class="main">' . TEXT_INFO_CLASS_TITLE . '</td>
                          <td>' . smn_tax_classes_pull_down('name="tax_class_id" id="tax_class_id" style="font-size:10px"') . '</td>
                         </tr>
                         <tr>
                          <td class="main">' . TEXT_INFO_ZONE_NAME . '</td>
                          <td>' . smn_geo_zones_pull_down('name="tax_zone_id" id="tax_zone_id" style="font-size:10px"') . '</td>
                         </tr>
                         <tr>
                          <td class="main">' . TEXT_INFO_TAX_RATE . '</td>
                          <td>' . smn_draw_input_field('tax_rate', '', 'id="tax_rate"') . '</td>
                         </tr>
                         <tr>
                          <td class="main">' . TEXT_INFO_RATE_DESCRIPTION . '</td>
                          <td>' . smn_draw_input_field('tax_description', '', 'id="tax_description"') . '</td>
                         </tr>
                         <tr>
                          <td class="main">' . TEXT_INFO_TAX_RATE_PRIORITY . '</td>
                          <td>' . smn_draw_input_field('tax_priority', '', 'id="tax_priority"') . '</td>
                         </tr>
                        </table>'
  ));
/* Tax Rates Grid Edit Window Setup - END */
  
/* Tax Rates Grid Delete Window Setup - BEGIN */
  $ratesGridDeleteWindow = $jQuery->getStandAloneClass('box_window', array(
      'id'          => 'div_rates_delete',
      'show_header' => true,
      'show_footer' => true,
      'header_text' => WINDOW_HEADING_DELETE_TAX_RATE,
      'buttons'     => array($commonDeleteButton, $commonCancelButton),
      'content'     => '<table cellpadding="3" cellspacing="0" border="0">
                         <tr>
                          <td class="main" align="center">' . TEXT_INFO_DELETE_TAX_RATE_INTRO . '</td>
                         </tr>
                         <tr>
                          <td class="main" align="center"><br><b></b></td>
                         </tr>
                        </table>'
  ));
/* Tax Rates Grid Delete Window Setup - END */
?>
<script language="Javascript">
$(document).ready(function (){
    var $gridObj = $('#<?php echo $ratesGrid->getID();?>');
    
    $('#<?php echo $ratesGridInsertButton->getID();?>').unbind('click').click(function (){
        var $insertWindow = $('#<?php echo $ratesGridEditWindow->getID();?>').clone().each(function (){
            var $windowObj = $(this);
            $('.basicGrid_windowHeader', $windowObj).html('<?php echo WINDOW_HEADING_INSERT_TAX_RATE;?>');
            $('#hidden_action', $windowObj).val('new');
            $('#<?php echo $commonSaveButton->getID();?>', $windowObj).unbind('click').click(function (){
                $(this.form).ajaxForm({
                    dataType: 'json',
                    success: function(data) {
                        if (data.success == true){
                            $gridObj.addRow({
                                cols: [
                                    {text: data.db.tax_priority},
                                    {text: data.db.tax_class_title},
                                    {text: data.db.geo_zone_name},
                                    {text: data.db.tax_rate},
                                    {text: data.db.tax_rates_id},
                                    {text: data.db.geo_zone_id},
                                    {text: data.db.tax_class_id},
                                    {text: data.db.tax_description},
                                    {text: data.db.last_modified},
                                    {text: data.db.date_added}
                                ]
                            });
                            $windowObj.remove();
                            $gridObj.show();
                        }else{
                            $.ajax_unsuccessful_message_box(data);
                        }
                    },
                    error: $.ajax_error_message_box
                });
            });
            
            $('#<?php echo $commonCancelButton->getID();?>', $windowObj).unbind('click').click(function (){
                $windowObj.remove();
                $gridObj.show();
              return false;
            });
            $gridObj.hide();
            $windowObj.appendTo('#tab-rates').show();
        });
      return false;
    });
    
    $('#<?php echo $ratesGridEditButton->getID();?>').unbind('click').click(function (){
        var $selectedRow = $gridObj.getSelected();
        if ($selectedRow.length > 0){
            var inputIDs = new Array(
                'tax_priority', 
                'tax_class_title', 
                'geo_zone_name', 
                'tax_rate', 
                'tax_rates_id',
                'tax_zone_id', 
                'tax_class_id', 
                'tax_description', 
                'last_modified', 
                'date_added' 
            );
            var values = $selectedRow.values(inputIDs);
            
            var $editWindow = $('#<?php echo $ratesGridEditWindow->getID();?>').clone().each(function (){
                var $windowObj = $(this);
                $('input', $windowObj).each(function (){
                    $(this).val(values[$(this).attr('id')]);
                });
        
                $('select', $windowObj).each(function (){
                    $(this).selectOptions(values[$(this).attr('id')]);
                });
        
                $('#hidden_action', $windowObj).val('edit');
                $('#<?php echo $commonSaveButton->getID();?>', $windowObj).unbind('click').click(function (){
                    $(this.form).ajaxForm({
                        dataType: 'json',
                        success: function(data) {
                            if (data.success == true){
                                $('th', $gridObj).each(function (){
                                    $('td[col="' + $(this).attr('col') + '"]', $selectedRow).html(eval('data.' + $(this).attr('id')));
                                });
                                $windowObj.remove();
                                $gridObj.show();
                            }else{
                                $.ajax_unsuccessful_message_box(data);
                            }
                        },
                        error: $.ajax_error_message_box
                    });
                });
                
                $('#<?php echo $commonCancelButton->getID();?>', $windowObj).unbind('click').click(function (){
                    $windowObj.remove();
                    $gridObj.show();
                  return false;
                });
                $gridObj.hide();
                $windowObj.appendTo('#tab-rates').show();
            });
        }
       return false;
    });
    
    $('#<?php echo $ratesGridDeleteButton->getID();?>').unbind('click').click(function (){
        var $selectedRow = $gridObj.getSelected();
        if ($selectedRow.length > 0){
            var inputIDs = new Array(
                'tax_priority', 
                'tax_class_title', 
                'geo_zone_name', 
                'tax_rate', 
                'tax_rates_id',
                'tax_zone_id', 
                'tax_class_id', 
                'tax_description', 
                'last_modified', 
                'date_added' 
            );
            var values = $selectedRow.values(inputIDs);

            var $deleteWindow = $('#<?php echo $ratesGridDeleteWindow->getID();?>').clone().each(function (){
                var $windowObj = $(this);
                $('b', $windowObj).html(values['tax_class_title'] + '&nbsp;&nbsp;' + values['tax_rate']);
                
                $('#<?php echo $commonDeleteButton->getID();?>', $windowObj).unbind('click').click(function (){
                    jQuery.ajax({
                        url: '<?php echo $jQuery->link(basename($_SERVER['PHP_SELF']), 'ID='.$store_id.'&action=deleteRate');?>&rate_id='+values['tax_rates_id'],
                        dataType: 'json',
                        cache: false,
                        success: function (data, textStatus){
                            if (data.success == true){
                                $selectedRow.remove();
                                $windowObj.remove();
                                $gridObj.show();
                            }else{
                                $.ajax_unsuccessful_message_box(data);
                            }
                        },
                        error: $.ajax_error_message_box
                    });
                  return false;
                });
                
                $('#<?php echo $commonCancelButton->getID();?>', $windowObj).unbind('click').click(function (){
                    $windowObj.remove();
                    $gridObj.show();
                  return false;
                });
                $gridObj.hide();
                $windowObj.appendTo('#tab-rates').show();
            });
        }
       return false;
    });
});
</script>
<?php
  echo $ratesGrid->outputGrid();
  echo $ratesGridEditWindow->output();
  echo $ratesGridDeleteWindow->output();
?>