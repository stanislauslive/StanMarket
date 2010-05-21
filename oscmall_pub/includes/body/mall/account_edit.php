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
<script language="Javascript">
$(document).ready(function (){
<?php
  echo $jQuery->getScriptOutput();
?>
	$('#country').change(function (){
	        jQuery.ajax({
	            url: '<?php echo $jQuery->link(FILENAME_ACCOUNT_EDIT, 'ID='.$store_id.'&action=getZones');?>&country='+$('#country').val(),
	            dataType: 'json',
	            cache: false,
	            success: function (data, textStatus){
	                $('#state').remove();
	                if (data.hasZones == true){
	                    var element = document.createElement('select');
                        $(element).addOption(data.zones, false);
                        $(element).selectOptions('<?php echo $customerInfo->address_data['entry_state'];?>');
	                }else{
	                    var element = document.createElement('input');
	                }
	                $(element).attr('id', 'state');
	                $(element).attr('name', 'state');
	                $('#state_col').append(element);
                    $(element).show();
	            }
	        });
	        return true;
	});
	
    $('#form-account_edit').ajaxForm({
        cache: false,
        dataType: 'json',
        timeout: '30000',
        success: function (data, textStatus){
            if (data.success == false){
                alert('AJAX Request Successful. Data Save Failed.' + "\n" + data.errors.message);
            }else if (data.success == true){
                window.location = '<?php echo str_replace('&amp;', '&', smn_href_link(FILENAME_ACCOUNT, 'ID='.$store_id));?>';
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown){
            alert('AJAX Request Failed.' + "\nStatus: " + textStatus + "\nError Thrown: " + errorThrown);
        }
    });
    $('#country').trigger('change');
});
</script>
<form id="form-account_edit" action="<?php echo smn_href_link(FILENAME_ACCOUNT_EDIT, 'ID=' . $store_id . '&action=save');?>" method="post" enctype="multipart/form-data">
<?php
  echo $tabPanel->output();
?>
</form>