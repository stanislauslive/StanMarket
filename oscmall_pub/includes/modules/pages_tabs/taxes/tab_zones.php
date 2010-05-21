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

/* Tax Zones Grid Setup - BEGIN */
  $zones_query = smn_db_query("select geo_zone_id, geo_zone_name, geo_zone_description, last_modified, date_added from " . TABLE_GEO_ZONES . " where store_id = '" . $store_id . "' order by geo_zone_name");
  $zonesGridData = array();
  while ($zones = smn_db_fetch_array($zones_query)) {
      $zonesGridData[] = array(
          $zones['geo_zone_id'], 
          $zones['geo_zone_name'], 
          $zones['geo_zone_description'], 
          $zones['last_modified'],
          $zones['date_added']
      );
  }
  
  $zonesGridEditButton = $jQuery->getPluginClass('button', array(
      'id'   => 'zonesGridEditButton',
      'text' => IMAGE_BUTTON_EDIT_SELECTED
  ));
  
  $zonesGridDeleteButton = $jQuery->getPluginClass('button', array(
      'id'   => 'zonesGridDeleteButton',
      'text' => IMAGE_BUTTON_DELETE_SELECTED
  ));
  
  $zonesGridInsertButton = $jQuery->getPluginClass('button', array(
      'id'   => 'zonesGridInsertButton',
      'text' => IMAGE_BUTTON_INSERT_NEW
  ));

  $zonesGridViewButton = $jQuery->getPluginClass('button', array(
      'id'     => 'zonesGridViewButton',
      'text'   => IMAGE_BUTTON_VIEW_SUB_ZONES,
      'hidden' => true
  ));

  $zonesGrid = $jQuery->getPluginClass('basicgrid', array(
      'id' => 'taxZonesGrid',
      'columns' => array(
          array('id' => 'geo_zone_id', 'text' => TABLE_HEADING_GEO_ZONE_ID, 'hidden' => true),
          array('id' => 'geo_zone_name', 'text' => TABLE_HEADING_GEO_ZONE_NAME),
          array('id' => 'geo_zone_description', 'text' => TABLE_HEADING_GEO_ZONE_DESCRIPTION, 'hidden' => true),
          array('id' => 'last_modified', 'text' => TABLE_HEADING_LAST_MODIFIED, 'hidden' => true),
          array('id' => 'date_added', 'text' => TABLE_HEADING_DATE_ADDED, 'hidden' => true)
      ),
      'data' => $zonesGridData,
      'buttons' => array($zonesGridInsertButton, $zonesGridEditButton, $zonesGridDeleteButton, $zonesGridViewButton)
  ));
/* Tax Zones Grid Setup - END */

/* Tax Zones Grid Edit Window Setup - BEGIN */
  $zonesGridEditWindow = $jQuery->getStandAloneClass('box_window', array(
      'id'          => 'div_zones_edit',
      'show_header' => true,
      'show_footer' => true,
      'header_text' => WINDOW_HEADING_EDIT_TAX_ZONE,
      'buttons'     => array($commonSaveButton, $commonCancelButton),
      'form'        => '<form id="form_zonesEdit" action="' . $jQuery->link(basename($_SERVER['PHP_SELF']), 'action=saveZone&ID=' . $store_id) . '" method="POST"><input type="hidden" name="hidden_action" id="hidden_action" value="new"><input type="hidden" name="geo_zone_id" id="geo_zone_id" value="">',
      'content'     => '<table cellpadding="3" cellspacing="0" border="0">
                         <tr>
                          <td class="main">' . TEXT_INFO_ZONE_NAME . '</td>
                          <td>' . smn_draw_input_field('geo_zone_name', '', 'id="geo_zone_name"') . '</td>
                         </tr>
                         <tr>
                          <td class="main">' . TEXT_INFO_ZONE_DESCRIPTION . '</td>
                          <td>' . smn_draw_input_field('geo_zone_description', '', 'id="geo_zone_description"') . '</td>
                         </tr>
                        </table>'
  ));
/* Tax Zones Grid Edit Window Setup - END */

/* Tax Zones Grid Delete Window Setup - BEGIN */
  $zonesGridDeleteWindow = $jQuery->getStandAloneClass('box_window', array(
      'id'          => 'div_zones_delete',
      'show_header' => true,
      'show_footer' => true,
      'header_text' => WINDOW_HEADING_DELETE_TAX_ZONE,
      'buttons'     => array($commonDeleteButton, $commonCancelButton),
      'content'     => '<table cellpadding="3" cellspacing="0" border="0">
                         <tr>
                          <td class="main" align="center">' . TEXT_INFO_DELETE_ZONE_INTRO . '</td>
                         </tr>
                         <tr>
                          <td class="main" align="center"><br><b></b></td>
                         </tr>
                        </table>'
  ));
/* Tax Zones Grid Delete Window Setup - END */

/* Tax Sub Zones Grid Setup - BEGIN */
  $subZonesGridData = array();
  $subZonesGridEditButton = $jQuery->getPluginClass('button', array(
      'id'   => 'subZonesGridEditButton',
      'text' => IMAGE_BUTTON_EDIT_SELECTED
  ));
  
  $subZonesGridDeleteButton = $jQuery->getPluginClass('button', array(
      'id'   => 'subZonesGridDeleteButton',
      'text' => IMAGE_BUTTON_DELETE_SELECTED
  ));
  
  $subZonesGridInsertButton = $jQuery->getPluginClass('button', array(
      'id'   => 'subZonesGridInsertButton',
      'text' => IMAGE_BUTTON_INSERT_NEW
  ));

  $subZonesGridBackButton = $jQuery->getPluginClass('button', array(
      'id'   => 'subZonesGridBackButton',
      'text' => IMAGE_BUTTON_BACK_TO_ZONES
  ));

  $subZonesGrid = $jQuery->getPluginClass('basicgrid', array(
      'id' => 'taxSubZonesGrid',
      'hidden' => true,
      'columns' => array(
          array('id' => 'association_id', 'text' => TABLE_HEADING_ASSOCIATION_ID, 'hidden' => true),
          array('id' => 'zone_country_id', 'text' => TABLE_HEADING_ZONE_COUNTRY_ID, 'hidden' => true),
          array('id' => 'countries_name', 'text' => TABLE_HEADING_COUNTRY_NAME),
          array('id' => 'zone_id', 'text' => TABLE_HEADING_ZONE_ID, 'hidden' => true),
          array('id' => 'geo_zone_id', 'text' => TABLE_HEADING_GEO_ZONE_ID, 'hidden' => true),
          array('id' => 'last_modified', 'text' => TABLE_HEADING_LAST_MODIFIED, 'hidden' => true),
          array('id' => 'date_added', 'text' => TABLE_HEADING_DATE_ADDED, 'hidden' => true),
          array('id' => 'zone_name', 'text' => TABLE_HEADING_ZONE_NAME)
      ),
      'data' => $subZonesGridData,
      'buttons' => array($subZonesGridInsertButton, $subZonesGridEditButton, $subZonesGridDeleteButton, $subZonesGridBackButton)
  ));
/* Tax Sub Zones Grid Setup - END */

/* Tax Sub Zones Grid Edit Window Setup - BEGIN */
  $subZonesGridEditWindow = $jQuery->getStandAloneClass('box_window', array(
      'id'          => 'div_subzones_edit',
      'show_header' => true,
      'show_footer' => true,
      'header_text' => WINDOW_HEADING_EDIT_TAX_SUB_ZONE,
      'buttons'     => array($commonSaveButton, $commonCancelButton),
      'form'        => '<form id="form_subZonesEdit" action="' . $jQuery->link(basename($_SERVER['PHP_SELF']), 'action=saveSubZone&ID=' . $store_id) . '" method="POST"><input type="hidden" name="hidden_action" id="hidden_action" value="new"><input type="hidden" name="geo_zone_id" id="geo_zone_id" value=""><input type="hidden" name="association_id" id="association_id" value="">',
      'content'     => '<table cellpadding="3" cellspacing="0" border="0">
                         <tr>
                          <td class="main">' . TEXT_INFO_COUNTRY . '</td>
                          <td>' . smn_draw_pull_down_menu('zone_country_id', smn_get_countries_drop_down(TEXT_ALL_COUNTRIES), '', 'id="zone_country_id"') . '</td>
                         </tr>
                         <tr>
                          <td class="main">' . TEXT_INFO_COUNTRY_ZONE . '</td>
                          <td id="zone_id_col">' . smn_draw_input_field('zone_id', '', 'id="zone_id"') . '</td>
                         </tr>
                        </table>'
  ));
/* Tax Sub Zones Grid Edit Window Setup - END */

/* Tax Sub Zones Grid Delete Window Setup - BEGIN */
  $subZonesGridDeleteWindow = $jQuery->getStandAloneClass('box_window', array(
      'id'          => 'div_subzones_delete',
      'show_header' => true,
      'show_footer' => true,
      'header_text' => WINDOW_HEADING_DELETE_TAX_SUB_ZONE,
      'buttons'     => array($commonDeleteButton, $commonCancelButton),
      'content'     => '<table cellpadding="3" cellspacing="0" border="0">
                         <tr>
                          <td class="main" align="center">' . TEXT_INFO_DELETE_SUB_ZONE_INTRO . '</td>
                         </tr>
                         <tr>
                          <td class="main" align="center"><br><b></b></td>
                         </tr>
                        </table>'
  ));
/* Tax Sub Zones Grid Delete Window Setup - END */
?>
<script language="Javascript">
$(document).ready(function (){
    var $zonesGrid = $('#<?php echo $zonesGrid->getID();?>');
    var $subZonesGrid = $('#<?php echo $subZonesGrid->getID();?>');
    
    $('#<?php echo $zonesGridInsertButton->getID();?>').click(function (){
        var $insertWindow = $('#<?php echo $zonesGridEditWindow->getID();?>').clone().each(function (){
            $windowObj = $(this);
            $('.basicGrid_windowHeader', $windowObj).html('<?php echo WINDOW_HEADING_INSERT_TAX_ZONE;?>');
            $('#hidden_action', $windowObj).val('new');
            $('#<?php echo $commonSaveButton->getID();?>', $windowObj).unbind('click').click(function (){
                $(this.form).ajaxForm({
                    dataType: 'json',
                    success: function(data) {
                        if (data.success == true){
                            var $newRow = $zonesGrid.addRow({
                                cols: [
                                    {text: data.db.geo_zone_id},
                                    {text: data.db.geo_zone_name},
                                    {text: data.db.geo_zone_description},
                                    {text: data.db.last_modified},
                                    {text: data.db.date_added}
                                ]
                            });
                            $newRow.click(function (){
                                var colNum = $zonesGrid.find('th[id="geo_zone_id"]').attr('col');
                                showSubZonesButton(this, $zonesGrid.find('tr.basicGrid_rowSelected').find('td').get(colNum).innerHTML);
                            });
                            $windowObj.remove();
                            $zonesGrid.trigger('update');
                            $zonesGrid.show();
                        }else{
                            $.ajax_unsuccessful_message_box(data);
                        }
                    },
                    error: $.ajax_error_message_box
                });
            });
            
            $('#<?php echo $commonCancelButton->getID();?>', $windowObj).unbind('click').click(function (){
                $windowObj.remove();
                $zonesGrid.show();
              return false;
            });
            $zonesGrid.hide();
            $windowObj.appendTo('#tab-zones').show();
        });
      return false;
    });
   
    $('#<?php echo $zonesGridEditButton->getID();?>').click(function (){
        var $selectedRow = $zonesGrid.getSelected();
        if ($selectedRow.length > 0){
            var inputIDs = new Array(
                'geo_zone_id', 
                'geo_zone_name', 
                'geo_zone_description', 
                'last_modified', 
                'date_added'
            );
            var values = $selectedRow.values(inputIDs);
            
            var $editWindow = $('#<?php echo $zonesGridEditWindow->getID();?>').clone().each(function (){
                var $windowObj = $(this);
                $('input', $windowObj).each(function (){
                    $(this).val(values[$(this).attr('id')]);
                });
        
                $('#hidden_action', $windowObj).val('edit');
                $('#<?php echo $commonSaveButton->getID();?>', $windowObj).unbind('click').click(function (){
                    $(this.form).ajaxForm({
                        dataType: 'json',
                        success: function(data) {
                            if (data.success == true){
                                $('th', $zonesGrid).each(function (){
                                    $('td[col="' + $(this).attr('col') + '"]', $selectedRow).html(eval('data.' + $(this).attr('id')));
                                });
                                $zonesGrid.trigger('update');
                                $windowObj.remove();
                                $zonesGrid.show();
                            }else{
                                $.ajax_unsuccessful_message_box(data);
                            }
                        },
                        error: $.ajax_error_message_box
                    });
                });
                
                $('#<?php echo $commonCancelButton->getID();?>', $windowObj).unbind('click').click(function (){
                    $windowObj.remove();
                    $zonesGrid.show();
                  return false;
                });
                $zonesGrid.hide();
                $windowObj.appendTo('#tab-zones').show();
            })
        }
       return false;
    });
    
    $('#<?php echo $zonesGridDeleteButton->getID();?>').unbind('click').click(function (){
        var $selectedRow = $zonesGrid.getSelected();
        if ($selectedRow.length > 0){
            var inputIDs = new Array(
                'geo_zone_id', 
                'geo_zone_name', 
                'geo_zone_description', 
                'last_modified', 
                'date_added'
            );
            var values = $selectedRow.values(inputIDs);
            
            var $deleteWindow = $('#<?php echo $zonesGridDeleteWindow->getID();?>').clone().each(function (){
                var $windowObj = $(this);
                $('b', $windowObj).html(values['geo_zone_name']);
                $('#<?php echo $commonDeleteButton->getID();?>', $windowObj).unbind('click').click(function (){
                    jQuery.ajax({
                        url: '<?php echo $jQuery->link(basename($_SERVER['PHP_SELF']), 'ID='.$store_id.'&action=deleteZone');?>&zone_id='+values['geo_zone_id'],
                        dataType: 'json',
                        cache: false,
                        success: function (data, textStatus){
                            if (data.success == true){
                                $selectedRow.remove();
                                $zonesGrid.trigger('update');
                                $windowObj.remove();
                                $zonesGrid.show();
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
                    $zonesGrid.show();
                  return false;
                });
                $zonesGrid.hide();
                $windowObj.appendTo('#tab-zones').show();
            });
        }
       return false;
    });
    
    function showSubZonesButton(row, geoZoneID){
        $('#<?php echo $zonesGridViewButton->getID();?>').unbind('click').click(function (){
            $zonesGrid.hide();
            $subZonesGrid = $('#<?php echo $subZonesGrid->getID();?>').clone().each(function (){
                jQuery.ajax({
                    url:"<?php echo $jQuery->link(basename($_SERVER['PHP_SELF']), 'ID='.$store_id.'&action=subZonesListing');?>&geo_zone_id="+geoZoneID,
                    cache: false,
                    dataType: 'json',
                    success: function(data){
                        if (data.success == true){
                            $('#<?php echo $subZonesGridBackButton->getID();?>', $subZonesGrid).unbind('click').click(function (){
                                $subZonesGrid.remove();
                                $zonesGrid.show();
                            });
                            
                            $('#<?php echo $subZonesGridInsertButton->getID();?>', $subZonesGrid).unbind('click').click(function (){
                                var $selectedRow = $zonesGrid.getSelected();
                                if ($selectedRow.length > 0){
                                    var inputIDs = new Array(
                                        'geo_zone_id', 
                                        'geo_zone_name', 
                                        'geo_zone_description', 
                                        'last_modified', 
                                        'date_added'
                                    );
                                    var values = $selectedRow.values(inputIDs);
                                    
                                    $subZonesGrid.hide();
                                    var $insertWindow = $('#<?php echo $subZonesGridEditWindow->getID();?>').clone().each(function (){
                                        var $windowObj = $(this);
                                        $('.basicGrid_windowHeader', $windowObj).html('<?php echo WINDOW_HEADING_INSERT_TAX_SUB_ZONE;?>');
                                        var $countryDrop = $('#zone_country_id', $windowObj);
                                        $countryDrop.change(function (){
                                            $('#zone_id_col', $windowObj).empty();
                                            jQuery.ajax({
                                                url: '<?php echo $jQuery->link(basename($_SERVER['PHP_SELF']), 'ID='.$store_id.'&action=getZones');?>&country='+$countryDrop.val(),
                                                dataType: 'json',
                                                cache: false,
                                                success: function (data, textStatus){
                                                    if (data.success == true){
                                                        $insertWindow.find('#zone_id').remove();
                                                        if (data.hasZones == true){
                                                            var element = document.createElement('select');
                                                            $(element).addOption(data.zones, false);
                                                        }else{
                                                            var element = document.createElement('input');
                                                        }
                                                        $(element).attr('id', 'zone_id');
                                                        $(element).attr('name', 'zone_id');
                                                        $('#zone_id_col', $windowObj).append(element);
                                                        $(element).show();
                                                    }else{
                                                        $.ajax_unsuccessful_message_box(data);
                                                    }
                                                },
                                                error: $.ajax_error_message_box
                                            });
                                          return true;
                                        });
                                        
                                        $countryDrop.trigger('change');
                                        $('#hidden_action', $windowObj).val('new');
                                        $('#geo_zone_id', $windowObj).val(values['geo_zone_id']);
                                        $('#<?php echo $commonSaveButton->getID();?>', $windowObj).unbind('click').click(function (){
                                            $(this.form).ajaxForm({
                                                dataType: 'json',
                                                success: function(data) {
                                                    if (data.success == true){
                                                        $subZonesGrid.addRow({
                                                            cols: [
                                                                {text: data.db.association_id},
                                                                {text: data.db.zone_country_id},
                                                                {text: data.db.countries_name},
                                                                {text: data.db.zone_id},
                                                                {text: data.db.geo_zone_id},
                                                                {text: data.db.last_modified},
                                                                {text: data.db.date_added},
                                                                {text: data.db.zone_name}
                                                            ]
                                                        });
                                                        $subZonesGrid.trigger('update');
                                                        $windowObj.remove();
                                                        $zonesGrid.show();
                                                    }else{
                                                        $.ajax_unsuccessful_message_box(data);
                                                    }
                                                },
                                                error: $.ajax_error_message_box
                                            });
                                        });
                                        
                                        $('#<?php echo $commonCancelButton->getID();?>', $windowObj).unbind('click').click(function (){
                                            $windowObj.remove();
                                            $subZonesGrid.show();
                                          return false;
                                        });
                                        $windowObj.appendTo('#tab-zones').show();
                                    });
                                }
                              return false;
                            });

                            $('#<?php echo $subZonesGridEditButton->getID();?>', $subZonesGrid).unbind('click').click(function (){
                                var $selectedRow = $subZonesGrid.getSelected();
                                if ($selectedRow.length > 0){
                                    var inputIDs = new Array(
                                        'association_id',
                                        'zone_country_id',
                                        'countries_name',
                                        'zone_id',
                                        'geo_zone_id',
                                        'last_modified',
                                        'date_added',
                                        'zone_name'
                                    );
                                    var values = $selectedRow.values(inputIDs);

                                    $subZonesGrid.hide();
                                    var $editWindow = $('#<?php echo $subZonesGridEditWindow->getID();?>').clone().each(function (){
                                        var $windowObj = $(this);
                                        var $countryDrop = $('#zone_country_id', $windowObj);
                                        $countryDrop.selectOptions(values['zone_country_id'], true);
                                        $countryDrop.change(function (){
                                            $('#zone_id_col', $windowObj).empty();
                                            jQuery.ajax({
                                                url: '<?php echo $jQuery->link(basename($_SERVER['PHP_SELF']), 'ID='.$store_id.'&action=getZones');?>&country='+$countryDrop.val(),
                                                dataType: 'json',
                                                cache: false,
                                                success: function (data, textStatus){
                                                    if (data.success == true){
                                                        $('#zone_id', $windowObj).remove();
                                                        if (data.hasZones == true){
                                                            var element = document.createElement('select');
                                                            $(element).addOption(data.zones, false);
                                                            $(element).selectOptions(values['zone_id'], true);
                                                        }else{
                                                            var element = document.createElement('input');
                                                        }
                                                        $(element).attr('id', 'zone_id');
                                                        $(element).attr('name', 'zone_id');
                                                        $('#zone_id_col', $windowObj).append(element);
                                                        $(element).show();
                                                    }else{
                                                        $.ajax_unsuccessful_message_box(data);
                                                    }
                                                },
                                                error: $.ajax_error_message_box
                                            });
                                          return true;
                                        });
                                        $countryDrop.trigger('change');
                                        
                                        $('#hidden_action', $windowObj).val('edit');
                                        $('#geo_zone_id', $windowObj).val(values['geo_zone_id']);
                                        $('#association_id', $windowObj).val(values['association_id']);
                                        $('#<?php echo $commonSaveButton->getID();?>', $windowObj).unbind('click').click(function (){
                                            $(this.form).ajaxForm({
                                                dataType: 'json',
                                                success: function(data) {
                                                    if (data.success == true){
                                                        $('th', $subZonesGrid).each(function (){
                                                            $('td[col="' + $(this).attr('col') + '"]', $selectedRow).html(eval('data.' + $(this).attr('id')));
                                                        });
                                                        $subZonesGrid.trigger('update');
                                                        $windowObj.remove();
                                                        $subZonesGrid.show();
                                                    }else{
                                                        $.ajax_unsuccessful_message_box(data);
                                                    }
                                                },
                                                error: $.ajax_error_message_box
                                            });
                                        });
                                        
                                        $('#<?php echo $commonCancelButton->getID();?>', $windowObj).unbind('click').click(function (){
                                            $windowObj.remove();
                                            $subZonesGrid.show();
                                          return false;
                                        });
                                        $windowObj.appendTo('#tab-zones').show();
                                    });
                                }
                              return false;
                            });
                            
                            $('#<?php echo $subZonesGridDeleteButton->getID();?>', $subZonesGrid).unbind('click').click(function (){
                                var $selectedRow = $subZonesGrid.getSelected();
                                if ($selectedRow.length > 0){
                                    var inputIDs = new Array(
                                        'association_id',
                                        'zone_country_id',
                                        'countries_name',
                                        'zone_id',
                                        'geo_zone_id',
                                        'last_modified',
                                        'date_added',
                                        'zone_name'
                                    );
                                    var values = $selectedRow.values(inputIDs);
                                
                                    var $deleteWindow = $('#<?php echo $subZonesGridDeleteWindow->getID();?>').clone().each(function (){
                                        var $windowObj = $(this);
                                        $('b', $windowObj).html(values['countries_name']);
                                        $('#<?php echo $commonDeleteButton->getID();?>', $windowObj).unbind('click').click(function (){
                                            jQuery.ajax({
                                                url: '<?php echo $jQuery->link(basename($_SERVER['PHP_SELF']), 'ID='.$store_id.'&action=deleteSubZone');?>&association_id='+values['association_id'],
                                                dataType: 'json',
                                                cache: false,
                                                success: function (data, textStatus){
                                                    if (data.success == true){
                                                        $selectedRow.remove();
                                                        $subZonesGrid.trigger('update');
                                                        $windowObj.remove();
                                                        $subZonesGrid.show();
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
                                            $subZonesGrid.show();
                                          return false;
                                        });
                                        $subZonesGrid.hide();
                                        $windowObj.appendTo('#tab-zones').show();
                                    });
                                }
                              return false;
                            });
                        
                            $.each(data.arr, function(i,item){
                                $subZonesGrid.addRow({
                                    cols: [
                                        {text: item.association_id},
                                        {text: item.zone_country_id},
                                        {text: item.countries_name},
                                        {text: item.zone_id},
                                        {text: item.geo_zone_id},
                                        {text: item.last_modified},
                                        {text: item.date_added},
                                        {text: item.zone_name}
                                    ]
                                });
                            });
                            $subZonesGrid.trigger('update');
                            $subZonesGrid.appendTo('#tab-zones').show();
                        }else{
                            $.ajax_unsuccessful_message_box(data);
                        }
                    },
                    error: $.ajax_error_message_box
                });
              return false;
            }).show();
        }).show();
    }
    
    $('tbody > tr', $zonesGrid).each(function (){
        $(this).click(function (){
            var colNum = $('th[id="geo_zone_id"]', $zonesGrid).attr('col');
            showSubZonesButton(this, $('tr.basicGrid_rowSelected', $zonesGrid).find('td').get(colNum).innerHTML);
        });
    });    
});
</script>
<?php
  echo $zonesGrid->outputGrid();
  echo $zonesGridEditWindow->output();
  echo $zonesGridDeleteWindow->output();
  
  echo $subZonesGrid->outputGrid();
  echo $subZonesGridEditWindow->output();
  echo $subZonesGridDeleteWindow->output();
?>