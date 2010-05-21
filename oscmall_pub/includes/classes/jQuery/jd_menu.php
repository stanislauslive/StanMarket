<?php
  class jQuery_jd_menu {
      
      function jQuery_jd_menu(){
        global $jQuery;
          $this->menuBlocks = array();
          $this->id = $jQuery->getRandomID('jd_menu');
      }
      
      function addMenuBlock($bInfo){
          $this->menuBlocks[] = ' <li><a class="accessible">' . $bInfo['heading'] . '</a><ul>' . "\n" . 
                                $this->parseChildren($bInfo['children']) . "\n" . 
                                ' </ul></li>' . "\n";
      }
      
      function parseChildren($childArray){
          $blockLinks = array();
          for($i=0, $n=sizeof($childArray); $i<$n; $i++){
              if (!empty($childArray[$i]['text'])){
                  if (isset($childArray[$i]['ajax']) && $childArray[$i]['ajax'] === true){
                      $blockLinks[] = '  <li><a ajaxlink="true" href="' . (empty($childArray[$i]['link']) ? 'javascript:void(0);' : $childArray[$i]['link']) . '">' . $childArray[$i]['text'] . '</a></li>';
                  }else{
                      $blockLinks[] = '  <li><a onclick="window.location=\'' . (empty($childArray[$i]['link']) ? 'javascript:void(0);' : $childArray[$i]['link']) . '\'">' . $childArray[$i]['text'] . '</a></li>';
                  }
              }
          }
        return implode("\n", $blockLinks);
      }
      
      function outputHTML(){
          return '<ul class="jd_menu" id="' . $this->id . '">' . "\n" . 
                 implode("\n", $this->menuBlocks) . 
                 '</ul>';
      }
  }
?>