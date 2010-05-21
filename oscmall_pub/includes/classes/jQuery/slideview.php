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

  class jQuery_slideview {
      
      function jQuery_slideview(){
        global $jQuery;
          $this->images = array();
          $this->id = $jQuery->getRandomID('slideshow');
          $this->width = 150;
          $this->height = 150;
      }
      
      function addImage($image, $alt = '', $description = ''){
          $this->images[] = '<li>' . smn_image($image, $alt, $this->width, $this->height) . (!empty($description) ? '<br><center>' . $description . '</center>' : '') . '</li>' . "\n";
      }
      
      function setID($id){
          $this->id = $id;
      }
      
      function setWidth($width){
          $this->width = $width;
      }
      
      function setHeight($height){
          $this->height = $height;
      }
      
      function outputScript(){
          return '$(\'#' . $this->id . '\').slideView();' . "\n";
      }
      
      function outputHTML(){
          return '<table cellpadding="0" cellspacing="0" border="0">' . "\n" . 
                 ' <tr>' . "\n" . 
                 '  <td width="30">&nbsp;<div class="stripTransmitter" id="' . $this->id . '_prev"><a href="#"><img src="ext/jQuery/plugins/slideview/images/prev.gif" border="0"></a></div>&nbsp;</td>' . "\n" . 
                 '  <td><div id="' . $this->id . '" class="svw">' . "\n" . 
                 '   <ul>' . "\n" . 
                 implode('', $this->images) . "\n" . 
                 '   </ul>' . "\n" . 
                 '  </div></td>' . "\n" . 
                 '  <td width="30">&nbsp;<div class="stripTransmitter" id="' . $this->id . '_next"><a href="#"><img src="ext/jQuery/plugins/slideview/images/next.gif" border="0"></a></div>&nbsp;</td>' . "\n" . 
                 ' </tr>' . "\n" . 
                 '</table>' . "\n";
      }
  }
?>