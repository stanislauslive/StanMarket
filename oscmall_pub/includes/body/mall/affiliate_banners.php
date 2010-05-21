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
 
 $tabsArray = array();
 $tabsArray[] = array(
     'id'       => 'tab-banner',
     'filename' => 'tab_banner.php',
     'text'     => TEXT_AFFILIATE_BANNERS
 );
 
 $tabsArray[] = array(
     'id'       => 'tab-product',
     'filename' => 'tab_product.php',
     'text'     => TEXT_AFFILIATE_BANNERS_PRODUCT
 );
 
 $tabsArray[] = array(
     'id'       => 'tab-build',
     'filename' => 'tab_build.php',
     'text'     => TEXT_AFFILIATE_BANNERS_BUILD
 );

 $tabsArray[] = array(
     'id'       => 'tab-text',
     'filename' => 'tab_text.php',
     'text'     => TEXT_AFFILIATE_BANNERS_TEXT
 );
 
 require(DIR_WS_CLASSES . 'jQuery.php');
 $jQuery = new jQuery();
 $jQuery->loadPlugin(array('tabs', 'facebox', 'button', 'form'));
 
 $tabPanel = $jQuery->getPluginClass('tabs');
 $tabPanel->setID('initialPane');
 for($tabCounter=0, $tabTotal=sizeof($tabsArray); $tabCounter<$tabTotal; $tabCounter++){
     $tabPanel->addTab($tabsArray[$tabCounter]['id'], $tabsArray[$tabCounter]['text']);
 
     ob_start();
     include('includes/modules/affiliate_banners/' . $tabsArray[$tabCounter]['filename']);
     $tabContent = ob_get_contents();
     ob_end_clean();
 
     $tabPanel->addTabContent($tabsArray[$tabCounter]['id'], $tabContent);
     unset($tabContent);
 }
 
 $backButton = $jQuery->getPluginClass('button');
 $backButton->setID('backButton');
 $backButton->setText(IMAGE_BACK);
 $backButton->setHref(smn_href_link(FILENAME_ACCOUNT, 'ID=' . $store_id));
 
 $buildLinkButton = $jQuery->getPluginClass('button');
 $buildLinkButton->setID('buildLinkButton');
 $buildLinkButton->setText('Build Link');
 $buildLinkButton->setType('submit');
 
 $helpButton = $jQuery->getPluginClass('button');
 $helpButton->setID('helpButton');
 $helpButton->setText('Help');
 
 $tabPanel->addFooterButton($backButton);
 $tabPanel->addFooterButton($helpButton);
 
 $tabPanel->setHelpButton('helpButton', true);
 
 echo $jQuery->getHeadOutput();
?>
<script language="Javascript">
$(document).ready(function (){
<?php
  echo $jQuery->getScriptOutput();
?>
  $('#form-buildLink').ajaxForm({
      dataType: 'json',
      cache: false,
      success: function (data, textStatus){
          var $bannerOutput = $('#bannerOutput').clone();
          $bannerOutput.find('#products_name').html(data.products_name);
          $bannerOutput.find('span[id="link"]').html(data.link);
          $bannerOutput.find('textarea[id="link1"]').val(data.link1);
          $bannerOutput.find('span[id="link2"]').html(data.link2);
          $bannerOutput.find('textarea[id="link2"]').val(data.link2);
              
          $('#bannerOutputListing').append($bannerOutput);
          $bannerOutput.show();
      },
      error: function (XMLHttpRequest, textStatus, errorThrown){
          alert('AJAX Request Failed.' + "\nStatus: " + textStatus + "\nError Thrown: " + errorThrown);
      }
  });
});
</script>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
 <tr>
  <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
 </tr>
 <tr>
  <td class="main"><?php echo TEXT_INFORMATION; ?></td>
 </tr>
 <tr>
  <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
 </tr>
</table>
<?php
  echo $tabPanel->output();
?>