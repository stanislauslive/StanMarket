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

  class jQuery_button {
      
      function jQuery_button($config = array()){
        global $jQuery;
          $this->config = array(
              'theme'  => 'blue',
              'type'   => 'button',
              'hidden' => false,
              'text'   => 'No Text Set',   
              'id'     => $jQuery->getRandomID('button')
          );
          if (is_array($config) && sizeof($config) > 0){
              $this->config = array_merge($this->config, $config);
          }
          $this->setID($this->config['id']);
      }
      
      function setID($id){
        global $jQuery;
          $this->config['id'] = $id;
      }
      
      function setType($type){
          $this->config['type'] = $type;
      }
      
      function setTheme($theme){
          $this->config['theme'] = $theme;
      }
      
      function setText($text){
          $this->config['text'] = $text;
      }
      
      function setHref($href){
        global $jQuery;
          $this->config['href'] = str_replace('&amp;', '&', $href);
      }
      
      function setHidden($val){
          $this->config['hidden'] = $val;
      }
      
      function getID(){
          return $this->config['id'];
      }
      
      function getType(){
          return $this->config['type'];
      }
      
      function getText(){
          return $this->config['text'];
      }
      
      function getHref(){
          return $this->config['href'];
      }
      
      function output(){
        global $jQuery;
          if ($this->config['type'] == 'submit'){
              return '<button ' . ($this->config['hidden'] === true ? 'hidden="true"' : 'hidden="false"') . ' theme="' . $this->config['theme'] . '" type="submit" id="' . $this->config['id'] . '"><span>' . $this->config['text'] . '</span></button>';
          }elseif($this->config['type'] == 'text'){
              return '<a ' . ($this->config['hidden'] === true ? 'hidden="true"' : 'hidden="false"') . ' href="' . $this->config['href'] . '" id="' . $this->config['id'] . '">' . $this->config['text'] . '</a>';
          }else{
              if (isset($this->config['href'])){
                  $jQuery->addScriptOutput('
                      $(\'#' . $this->config['id'] . '\').click(function (e){
                          e.preventDefault();
                          window.location = \'' . $this->config['href'] . '\';
                      });
                  ');                  
              }
              return '<button ' . ($this->config['hidden'] === true ? 'hidden="true"' : 'hidden="false"') . ' type="button" theme="' . $this->config['theme'] . '" id="' . $this->config['id'] . '"><span>' . strip_tags($this->config['text']) . '</span></button>';
          }
      }
  }
?>