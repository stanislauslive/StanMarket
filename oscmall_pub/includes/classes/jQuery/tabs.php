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

  class jQuery_tabs {
      
      function jQuery_tabs($config = array()){
        global $jQuery;
          $this->config = array(
              'id'            => $jQuery->getRandomID('tabs'),
              'tabDir'        => DIR_FS_CATALOG . 'templates/content/tabs/',
              'tabs'          => array(),
              'tabContent'    => array(),
              'footerButtons' => array(),
              'showFooter'    => false
          );
          if (is_array($config) && sizeof($config) > 0){
              $jQueryGlobals = $jQuery->getGlobals();
              if (!empty($jQueryGlobals)){
                  foreach($jQueryGlobals as $varName => $varValue){
                      global ${$varName};
                  }
              }
              $this->config = array_merge($this->config, $config);
              if (isset($config['tabs'])){
                  for($tabCounter=0, $tabTotal=sizeof($config['tabs']); $tabCounter<$tabTotal; $tabCounter++){
                      $this->addTab($config['tabs'][$tabCounter]['tabID'], $config['tabs'][$tabCounter]['text']);
                      if (isset($config['tabs'][$tabCounter]['filename'])){
                          ob_start();
                          include($this->config['tabDir'] . $config['tabs'][$tabCounter]['filename']);
                          $tabContent = ob_get_contents();
                          ob_end_clean();
                              
                          $this->addTabContent($config['tabs'][$tabCounter]['tabID'], $tabContent);
                          unset($tabContent);
                      }
                  }
              }
              if (isset($config['tabsContent'])){
                  for($tabCounter=0, $tabTotal=sizeof($config['tabsContent']); $tabCounter<$tabTotal; $tabCounter++){
                      $this->addTabContent($config['tabsContent'][$tabCounter]['tabID'], $config['tabsContent'][$tabCounter]['content']);
                  }
              }
              if (isset($config['footerButtons'])){
                  $this->addFooterButton($config['footerButtons']);
              }
          }
          $this->setID($this->config['id']);
      }
      
      function addTab($tabID, $tabText){
          $this->tabs[] = array(
            'id'   => $tabID,
            'text' => $tabText
          );
      }
      
      function addTabContent($tabID, $content){
          $this->tabContent[$tabID] = $content;
      }
      
      function addFooterButton($buttonObj){
          $this->showFooter = true;
          if (is_array($buttonObj)){
              foreach($buttonObj as $obj){
                  $this->footerButtons[$obj->getID()] = $obj->output();
              }
          }else{
              $this->footerButtons[$buttonObj->getID()] = $buttonObj->output();
          }
      }
      
      function getTabs(){
          $tabHTML = '<ul>';
          for($i=0; $i<sizeof($this->tabs); $i++){
              $tabHTML .= '<li><a class="tabLink" href="#' . $this->tabs[$i]['id'] . '"><span>' . $this->tabs[$i]['text'] . '</span></a></li>';
          }
          $tabHTML .= '</ul>';
        return $tabHTML;
      }
      
      function getTabContent($id = ''){
          if (!empty($id)){
              if (isset($this->tabContent[$id])){
                  return $this->tabContent[$id];
              }
          }else{
              $return = '';
              foreach($this->tabContent as $id => $content){
                  $return .= '<div id="' . $id . '">' . 
                             $content . 
                             '</div>';
              }
              return $return;
          }
      }
      
      function getFooterButtons(){
          $buttons = '';
          foreach($this->footerButtons as $button){
              $buttons .= $button . '&nbsp;&nbsp;';
          }
        return $buttons;
      }
      
      function getTabFooter(){
          return '<div id="' . $this->config['id'] . '-footer" class="ui-tabs-footer" align="right">' . $this->getFooterButtons() . '</div>';
      }
      
      function setID($id){
        global $jQuery;
          $this->config['id'] = $id;
          if (isset($this->jqInitIndex)){
              $this->jqInitIndex = $jQuery->addScriptOutput('$(\'ul:first\', $(\'#' . $this->config['id'] . '\')).tabs();', $this->jqInitIndex);
          }else{
              $this->jqInitIndex = $jQuery->addScriptOutput('$(\'ul:first\', $(\'#' . $this->config['id'] . '\')).tabs();');
          }
      }
      
      function getID(){
          return $this->id;
      }
      
      function setHelpButton($id, $tabs = false){
        global $jQuery;
          if ($jQuery->pluginIsLoaded('facebox')){
              $linkParams = ($tabs === true ? 'tab=\' + $(\'#' . $this->config['id'] . ' > div:visible\').attr(\'id\') + \'' : '');
              $jQuery->setHelpButton($id, $linkParams);
          }
      }
      
      function removeScriptOutput(){
        global $jQuery;
          $jQuery->removeScriptOutput($this->jqInitIndex);
      }
      
      function output(){
          $output = '<div style="width:100%" id="' . $this->config['id'] . '">' . 
                    $this->getTabs() . 
                    $this->getTabContent() . 
                    ($this->showFooter ? $this->getTabFooter() : '') . 
                    '</div>';
        return $output;
      }
  }
?>