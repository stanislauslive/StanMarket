<?php
  class jQuery_accordion_menu {
      
      function jQuery_accordion_menu(){
        global $jQuery;
          $this->id = $jQuery->getRandomID('accordion_menu');
          $this->linkID = 0;
          $this->headerID = 0;
          $this->defaultSettings = '
              active: false,
              header: \'.accordion_block_header\',
              alwaysOpen: false,
              navigation: true,
              autoheight: true
          ';
          $this->menuBlocks = array();
          $this->jqInitIndex = $jQuery->addScriptOutput('
              $(\'#' . $this->id . '\').accordion_menu({' . $this->defaultSettings . '});
          ');
      }
      
      function setID($id){
        global $jQuery;
          $this->id = $id;
          if (isset($this->jqInitIndex)){
              $this->jqInitIndex = $jQuery->addScriptOutput('
                  $(\'#' . $this->id . '\').accordion_menu({' . $this->defaultSettings . '});
              ', $this->jqInitIndex);
          }else{
              $this->jqInitIndex = $jQuery->addScriptOutput('
                  $(\'#' . $this->id . '\').accordion_menu({' . $this->defaultSettings . '});
              ');
          }
      }
      
      function addMenuBlock($bInfo){
          $this->menuBlocks[] = ' <div class="accordion_menu_block">' . "\n" . 
                                '  <div class="accordion_menu_block_header" id="header_' . $this->headerID++ . '">' . "\n" . 
                                '   <table cellspacing="0" cellpadding="0" border="0" width="100%">' . "\n" . 
                                '    <tbody>' . "\n" .
                                '     <tr>' . "\n" . 
                                '      <td><div class="accordion_menu_block_header_text">' . $bInfo['heading'] . '</div></td>' . "\n" . 
                                '      <td align="right"><div class="accordion_menu_block_header_tools"><div class="accordion_menu_block_header_tools_expand" /></div></td>' . "\n" . 
                                '     </tr>' . "\n" . 
                                '    </tbody>' . "\n" . 
                                '   </table>' . "\n" . 
                                '  </div>' . "\n" . 
                                '  <div class="accordion_menu_block_content">' . "\n" . 
                                $this->parseChildren($bInfo['children']) . "\n" . 
                                '  </div>' . "\n" . 
                                ' </div>' . "\n";
      }
      
      function parseChildren($childArray){
          $blockLinks = array();
          for($i=0, $n=sizeof($childArray); $i<$n; $i++){
              if (!empty($childArray[$i]['text'])){
                  $blockLinks[] = '   <a class="accordion_menu_block_content_link" id="accordionLink_' . $this->linkID++ . '" href="' . (empty($childArray[$i]['link']) ? 'javascript:void(0);' : $childArray[$i]['link']) . '">' . $childArray[$i]['text'] . '</a>';
              }
          }
        return implode("\n", $blockLinks);
      }
      
      function outputHTML(){
          return '<div class="accordion_menu" id="' . $this->id . '">' . "\n" . 
                 implode("\n", $this->menuBlocks) . 
                 '</div>';
      }
  }
?>