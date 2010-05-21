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

  class jQuery_standAlone_box_window {
      
      function jQuery_standAlone_box_window($config = array()){
        global $jQuery;
          $this->config = array(
              'id'          => $jQuery->getRandomID('box_window'),
              'show_header' => false,
              'show_footer' => false,
              'allow_close' => false,
              'form'        => false,
              'content'     => false,
              'buttons'     => array(),
              'add_buttons' => array(),
              'header_text' => '',
              'template'    => '<div id="{ID_PH}" style="display:none;width:100%" align="center">
                                 {FORM_PH}
                                 <table class="basicGrid_window" cellpadding="0" cellspacing="0" border="0" width="100%">
                                 {HEADER_PH}
                                  <tr>
                                   <td align="center" class="basicGrid_windowContent">{CONTENT_PH}</td>
                                  </tr>
                                  {FOOTER_PH}
                                 </table>
                                 {FORM_END_PH}
                                </div>'
          );
          if (is_array($config) && sizeof($config) > 0){
              $this->config = array_merge($this->config, $config);
              if (isset($config['buttons'])){
                  $this->addButton($config['buttons']);
              }
          }
      }
      
      function setID($id){
          $this->config['id'] = $id;
      }
      
      function getID(){
          return $this->config['id'];
      }
      
      function showHeader($val = true){
          $this->config['show_header'] = $val;
      }
      
      function showFooter($val = true){
          $this->config['show_footer'] = $val;
      }
      
      function allowClose($val = true){
          $this->config['allow_close'] = $val;
      }
      
      function setHeaderText($val = ''){
          $this->config['header_text'] = $val;
      }
      
      function setForm($form = false){
          $this->config['form'] = $form;
      }
      
      function setContent($val = ''){
          $this->config['content'] = $val;
      }
      
      function addButton($buttonObj){
          if (is_array($buttonObj)){
              foreach($buttonObj as $obj){
                  if (is_object($obj)){
                      $this->config['add_buttons'][$obj->getID()] = $obj->output();
                  }
              }
          }else{
              if (is_object($buttonObj)){
                  $this->config['add_buttons'][$buttonObj->getID()] = $buttonObj->output();
              }
          }
      }
      
      function getButtons(){
          $buttons = '';
          if (!empty($this->config['add_buttons'])){
              foreach($this->config['add_buttons'] as $button){
                  $buttons .= $button . '&nbsp;&nbsp;';
              }
          }
        return $buttons;
      }
      
      function output(){
          $hTemp = '';
          if ($this->config['show_header'] === true){
              $closeButton = '';
              if ($this->config['allow_close'] === true){
                  $closeButton = '<div style="position:relative;float:right;">[X]</div>';
              }
              $hTemp = '<tr>
                         <td class="basicGrid_windowHeader" align="center">' . $this->config['header_text'] . $closeButton . '</td>
                        </tr>';
          }
          
          $fTemp = '';
          if ($this->config['show_footer'] === true){
              $closeButton = '';
              if ($this->config['allow_close'] === true && $this->config['show_header'] === false){
                  $closeButton = '<button id="close_button" class="jQuery-button"><span>Close</span></button>';
              }
              $fTemp = '<tr>
                         <td class="basicGrid_windowFooter" align="center">' . $this->getButtons() . $closeButton . '</td>
                        </tr>';
          }
          
          $form = '';
          $formEnd = '';
          if ($this->config['form'] !== false){
              $form = $this->config['form'];
              $formEnd = '</form>';
          }
          
          $this->config['template'] = str_replace('{ID_PH}', $this->config['id'], $this->config['template']);
          $this->config['template'] = str_replace('{FORM_PH}', $form, $this->config['template']);
          $this->config['template'] = str_replace('{HEADER_PH}', $hTemp, $this->config['template']);
          $this->config['template'] = str_replace('{CONTENT_PH}', $this->config['content'], $this->config['template']);
          $this->config['template'] = str_replace('{FOOTER_PH}', $fTemp, $this->config['template']);
          $this->config['template'] = str_replace('{FORM_END_PH}', $formEnd, $this->config['template']);
        return $this->config['template'];
      }
  }
?>