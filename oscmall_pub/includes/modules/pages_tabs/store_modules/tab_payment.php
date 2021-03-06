<?php
/*
  Copyright (c) 2002 - 2005 SystemsManager.Net

  SystemsManager Technologies
  oscMall System Version 4
  http://www.systemsmanager.net
  
  This source file is subject to version 2.0 of the GPL license,   
  that is bundled with this package in the file LICENSE. If you
  did not receive a copy of the oscMall System license and are unable 
  to obtain it through the world-wide-web, please send a note to    
  license@systemsmanager.net so we can mail you a copy immediately.
*/

/* Payment Grid Setup - BEGIN */
  $modules = $paymentModules->getInstalledModules();
  $paymentGridContent = array();
  foreach($modules as $mInfo){
      $paymentGridContent[] = array(
          'title'      => $mInfo['title'],
          'sort_order' => $mInfo['sort_order'],
          'code'       => $mInfo['code'],
          'status'     => ($mInfo['status'] === true ? 'true' : 'false')
      );
  }

  $paymentGrid = $jQuery->getPluginClass('basicgrid', array(
      'id'      => 'paymentGrid',
      'columns' => $modulesGridColumns,
      'data'    => $paymentGridContent,
      'buttons' => array($modulesGridEditButton, $modulesGridUninstallButton, $modulesGridInstallButton)
  ));
/* Payment Grid Setup - END */

/* Payment Grid Delete Window Setup - BEGIN */
  $paymentEditWindow = $jQuery->getStandAloneClass('box_window', array(
      'id'          => 'div_payment_module_edit',
      'form'        => '<form id="form-editPayment" action="#" method="post">',
      'show_header' => true,
      'show_footer' => true,
      'header_text' => WINDOW_HEADING_EDIT_PAYMENT,
      'buttons'     => array($commonSaveButton, $commonCancelButton)
  ));
  
  $saveButton = $commonSaveButton;
  $saveButton->setHidden(true);
  $paymentInstallWindow = $jQuery->getStandAloneClass('box_window', array(
      'id'          => 'div_payment_module_install',
      'form'        => '<form id="form-installPayment" action="#" method="post">',
      'show_header' => true,
      'show_footer' => true,
      'header_text' => WINDOW_HEADING_INSTALL_PAYMENT,
      'buttons'     => array($saveButton, $commonCancelButton),
      'content'     => '<table cellpadding="0" cellspacing="0" border="0">
                         <tr>
                          <td class="main">' . TEXT_INFO_INSTALL_MODULE . '</td>
                         </tr>
                         <tr>
                          <td><select id="module" name="module"></select></td>
                         </tr>
                        </table>'
  ));
/* Payment Grid Delete Window Setup - END */
?>
<script language="Javascript">
    $(document).ready(function (){
        var $gridObj = $('#<?php echo $paymentGrid->getID();?>');
        
        $('tbody > tr', $gridObj).each(function (){
            addButtonEvents($(this), $gridObj);
        });
        
        $('#<?php echo $modulesGridEditButton->getID();?>', $gridObj).unbind('click').click(function (){
            var selectedRow = $gridObj.data('gridObj').getSelectedRows();
            if (selectedRow){
                $gridObj.data('gridObj').showWindow({
                    title: 'Edit Module Settings',
                    selectedRow: selectedRow,
                    appendTo: '#tab-payment',
                    selector: '#<?php echo $paymentEditWindow->getID();?>',
                    onLoad: function (e, windowObj){
                        var $windowObj = $(windowObj);
                        var $cancelButton = $('#<?php echo $commonCancelButton->getID();?>', $windowObj);
                        var $saveButton = $('#<?php echo $saveButton->getID();?>', $windowObj);
                        
                        jQuery.ajax({
                            cache: false,
                            dataType: 'json',
                            url: '<?php echo $jQuery->link(basename($_SERVER['PHP_SELF']), 'action=getModuleEditFields&moduleType=payment');?>&moduleName=' + selectedRow.getColValue('code'),
                            success: function (data){
                                if (data.success == true){
                                    $('.basicGrid_windowContent', $windowObj).append(data.html);
                                    
                                    $saveButton.unbind('click').click(function (){
                                        $(this.form).ajaxForm({
                                            cache: false,
                                            dataType: 'json',
                                            url: '<?php echo $jQuery->link(basename($_SERVER['PHP_SELF']), 'action=saveModuleSettings&moduleType=payment');?>&moduleName=' + selectedRow.getColValue('code'),
                                            success: function (data){
                                                if (data.success == true){
                                                    selectedRow.updateValues(data);
                                                    $windowObj.remove();
                                                    $gridObj.show();
                                                }else{
                                                    $.ajax_unsuccessful_message_box(data);
                                                }
                                            }
                                        });
                                    }).show();
                                    
                                    $cancelButton.unbind('click').click(function (){
                                        $windowObj.remove();
                                        $gridObj.show();
                                      return false;
                                    });
                                }else{
                                    $.ajax_unsuccessful_message_box(data);
                                }
                            }
                        });
                    }
                });
            }
          return false;
        });
        
        $('#<?php echo $modulesGridInstallButton->getID();?>', $gridObj).unbind('click').click(function (){
            $gridObj.data('gridObj').showWindow({
                title: 'Install New Module',
                appendTo: '#tab-payment',
                selector: '#<?php echo $paymentInstallWindow->getID();?>',
                onLoad: function (e, windowObj){
                    var $windowObj = $(windowObj);
                    var $cancelButton = $('#<?php echo $commonCancelButton->getID();?>', $windowObj);
                    var $saveButton = $('#<?php echo $saveButton->getID();?>', $windowObj);
                        
                    jQuery.ajax({
                        cache: false,
                        url: '<?php echo $jQuery->link(basename($_SERVER['PHP_SELF']), 'action=getInstallArray&moduleType=payment');?>',
                        dataType: 'json',
                        success: function (data){
                            if (data.success == true){
                                $('select[name="module"]', $windowObj).each(function (){
                                    var $selectBox = $(this);
                                    $(data.arr).each(function (i, arr){
                                        $selectBox.addOption(arr[0], arr[1]);
                                    });
                                    $selectBox.selectOptions('');
                                        
                                    $(this).unbind('change').change(function (){
                                        jQuery.ajax({
                                            cache: false,
                                            dataType: 'json',
                                            url: '<?php echo $jQuery->link(basename($_SERVER['PHP_SELF']), 'action=getModuleEditFields&moduleType=payment');?>&moduleName=' + $(this).val(),
                                            success: function (data){
                                                if (data.success == true){
                                                    $('.basicGrid_windowContent > table', $windowObj).hide();
                                                    $('.basicGrid_windowContent', $windowObj).append(data.html);
                                                        
                                                    $saveButton.unbind('click').click(function (){
                                                        $(this.form).ajaxForm({
                                                            cache: false,
                                                            dataType: 'json',
                                                            url: '<?php echo $jQuery->link(basename($_SERVER['PHP_SELF']), 'action=saveModuleSettings&moduleType=payment');?>&moduleName=' + $selectBox.val(),
                                                            success: function (data){
                                                                if (data.success == true){
                                                                    var newRow = $gridObj.data('gridObj').addRow(data);
                                                                    addButtonEvents(newRow, $gridObj);
                                                                    $windowObj.remove();
                                                                    $gridObj.show();
                                                                }else{
                                                                    $.ajax_unsuccessful_message_box(data);
                                                                }
                                                            }
                                                        });
                                                    }).show();
                                                        
                                                    $cancelButton.unbind('click').click(function (){
                                                        jQuery.ajax({
                                                            cache: false,
                                                            dataType: 'json',
                                                            url: '<?php echo $jQuery->link(basename($_SERVER['PHP_SELF']), 'action=uninstallModule&moduleType=payment');?>&moduleName=' + $selectBox.val(),
                                                            success: function (data){
                                                                if (data.success == true){
                                                                    $('.basicGrid_windowContent > table', $windowObj).show();
                                                                    $('#moduleFields', $windowObj).remove();
                                                                    $cancelButton.unbind('click').click(function (){
                                                                        $saveButton.hide();
                                                                        $windowObj.remove();
                                                                        $gridObj.show();
                                                                      return false;
                                                                    });
                                                                }else{
                                                                    $.ajax_unsuccessful_message_box(data);
                                                                }
                                                            }
                                                        });
                                                      return false;
                                                    });
                                                }else{
                                                    $.ajax_unsuccessful_message_box(data);
                                                }
                                            }
                                        });
                                    });
                                });
                            }else{
                                $.ajax_unsuccessful_message_box(data);
                            }
                        }
                    });
                
                    $cancelButton.unbind('click').click(function (){
                        $windowObj.remove();
                        $gridObj.show();
                      return false;
                    });
                }
            });
        });
        
        $('#<?php echo $modulesGridUninstallButton->getID();?>', $gridObj).unbind('click').click(function (){
            var selectedRow = $gridObj.data('gridObj').getSelectedRows();
            if (selectedRow){
                jQuery.ajax({
                    cache: false,
                    dataType: 'json',
                    url: '<?php echo $jQuery->link(basename($_SERVER['PHP_SELF']), 'action=uninstallModule&moduleType=payment');?>&moduleName=' + selectedRow.getColValue('code'),
                    success: function (data){
                        if (data.success == true){
                            $(selectedRow).trigger('deselect').remove();
                        }else{
                            $.ajax_unsuccessful_message_box(data);
                        }
                    }
                });
            }
          return false;
        });
    });
</script>
<?php  
  echo $paymentGrid->outputGrid();
  echo $paymentEditWindow->output();
  echo $paymentInstallWindow->output();
?>