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

/* Tax Classes Grid Setup - BEGIN */
  $classes_query = smn_db_query("select tax_class_id, tax_class_title, tax_class_description, last_modified, date_added from " . TABLE_TAX_CLASS . " where store_id = '" . $store_id ."' order by tax_class_title");
  $classesGridData = array();
  while ($classes = smn_db_fetch_array($classes_query)){
      $classesGridData[] = array(
          $classes['tax_class_id'], 
          $classes['tax_class_title'], 
          $classes['tax_class_description'], 
          $classes['last_modified'],
          $classes['date_added']
      );
  }
  
  $classesGridEditButton = $jQuery->getPluginClass('button', array(
      'id'   => 'classesGridEditButton',
      'text' => IMAGE_BUTTON_EDIT_SELECTED
  ));
  
  $classesGridDeleteButton = $jQuery->getPluginClass('button', array(
      'id'   => 'classesGridDeleteButton',
      'text' => IMAGE_BUTTON_DELETE_SELECTED
  ));
  
  $classesGridInsertButton = $jQuery->getPluginClass('button', array(
      'id'   => 'classesGridInsertButton',
      'text' => IMAGE_BUTTON_INSERT_NEW
  ));
  
  $classesGrid = $jQuery->getPluginClass('basicgrid', array(
      'id' => 'taxClassesGrid',
      'columns' => array(
          array('id' => 'tax_class_id', 'text' => TABLE_HEADING_TAX_CLASS_ID),
          array('id' => 'tax_class_title', 'text' => TABLE_HEADING_TAX_CLASS_TITLE),
          array('id' => 'tax_class_description', 'text' => TABLE_HEADING_TAX_CLASS_DESCRIPTION, 'hidden' => true),
          array('id' => 'last_modified', 'text' => TABLE_HEADING_LAST_MODIFIED, 'hidden' => true),
          array('id' => 'date_added', 'text' => TABLE_HEADING_DATE_ADDED, 'hidden' => true)
      ),
      'data' => $classesGridData,
      'buttons' => array($classesGridInsertButton, $classesGridEditButton, $classesGridDeleteButton)
  ));
/* Tax Classes Grid Setup - END */

/* Tax Classes Grid Edit Window Setup - BEGIN */
  $classesGridEditWindow = $jQuery->getStandAloneClass('box_window', array(
      'id'          => 'div_classes_edit',
      'show_header' => true,
      'show_footer' => true,
      'header_text' => WINDOW_HEADING_EDIT_TAX_CLASS,
      'buttons'     => array($commonSaveButton, $commonCancelButton),
      'form'        => '<form id="form_classesEdit" action="' . $jQuery->link(basename($_SERVER['PHP_SELF']), 'action=saveClass&ID=' . $store_id) . '" method="POST"><input type="hidden" name="hidden_action" id="hidden_action" value="new"><input type="hidden" name="tax_class_id" id="tax_class_id" value="">',
      'content'     => '<table cellpadding="3" cellspacing="0" border="0">
                         <tr>
                          <td class="main">' . TEXT_INFO_CLASS_TITLE . '</td>
                          <td>' . smn_draw_input_field('tax_class_title', '', 'id="tax_class_title"') . '</td>
                         </tr>
                         <tr>
                          <td class="main">' . TEXT_INFO_CLASS_DESCRIPTION . '</td>
                          <td>' . smn_draw_input_field('tax_class_description', '', 'id="tax_class_description"') . '</td>
                         </tr>
                        </table>'
  ));
/* Tax Classes Grid Edit Window Setup - END */
  
/* Tax Classes Grid Delete Window Setup - BEGIN */
  $classesGridDeleteWindow = $jQuery->getStandAloneClass('box_window', array(
      'id'          => 'div_classes_delete',
      'show_header' => true,
      'show_footer' => true,
      'header_text' => WINDOW_HEADING_DELETE_TAX_CLASS,
      'buttons'     => array($commonDeleteButton, $commonCancelButton),
      'content'     => '<table cellpadding="3" cellspacing="0" border="0">
                         <tr>
                          <td class="main" align="center">' . TEXT_INFO_DELETE_INTRO . '</td>
                         </tr>
                         <tr>
                          <td class="main" align="center"><br><b></b></td>
                         </tr>
                        </table>'
  ));
/* Tax Classes Grid Delete Window Setup - END */
?>
<script language="Javascript">
$(document).ready(function (){
    var $gridObj = $('#<?php echo $classesGrid->getID();?>');
    
    $('#<?php echo $classesGridInsertButton->getID();?>', $gridObj).unbind('click').click(function (){
        var $insertWindow = $('#<?php echo $classesGridEditWindow->getID();?>').clone().each(function (){
            var $windowObj = $(this);
            $('.basicGrid_windowHeader', $windowObj).html('<?php echo WINDOW_HEADING_INSERT_TAX_CLASS;?>');
            $('#hidden_action', $windowObj).val('new');
            $('#<?php echo $commonSaveButton->getID();?>', $windowObj).unbind('click').click(function (){
                $(this.form).ajaxForm({
                    cache: false,
                    dataType: 'json',
                    success: function(data) {
                        if (data.success == true){
                            $gridObj.addRow({
                                cols: [
                                    {text: data.db.tax_class_id},
                                    {text: data.db.tax_class_title},
                                    {text: data.db.tax_class_description},
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
            $windowObj.appendTo('#tab-classes').show();
        })
      return false;
    });
    
    $('#<?php echo $classesGridEditButton->getID();?>').unbind('click').click(function (){
        var $selectedRow = $gridObj.getSelected();
        if ($selectedRow.length > 0){
            var inputIDs = new Array(
                'tax_class_id', 
                'tax_class_title', 
                'tax_class_description', 
                'last_modified', 
                'date_added'
            );
            var values = $selectedRow.values(inputIDs);
            var $editWindow = $('#<?php echo $classesGridEditWindow->getID();?>').clone().each(function (){
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
                $windowObj.appendTo('#tab-classes').show();
            });
        }
       return false;
    });
    
    $('#<?php echo $classesGridDeleteButton->getID();?>').unbind('click').click(function (){
        var $selectedRow = $gridObj.getSelected();
        if ($selectedRow.length > 0){
            var inputIDs = new Array(
                'tax_class_id', 
                'tax_class_title', 
                'tax_class_description', 
                'last_modified', 
                'date_added'
            );
            var values = $selectedRow.values(inputIDs);
            
            var $deleteWindow = $('#<?php echo $classesGridDeleteWindow->getID();?>').clone().each(function (){
                var $windowObj = $(this);
                $('b', $windowObj).html(values['tax_class_title']);
                
                $('#<?php echo $commonDeleteButton->getID();?>', $windowObj).unbind('click').click(function (){
                    jQuery.ajax({
                        url: '<?php echo $jQuery->link(basename($_SERVER['PHP_SELF']), 'ID='.$store_id.'&action=deleteClass');?>&class_id='+values['tax_class_id'],
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
                $windowObj.appendTo('#tab-classes').show();
            })
        }
       return false;
    });
});
</script>
<?php
  echo $classesGrid->outputGrid();
  echo $classesGridEditWindow->output();
  echo $classesGridDeleteWindow->output();
?>