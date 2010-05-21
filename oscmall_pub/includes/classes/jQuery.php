<?php
  class jQuery {
      var $loadedPlugins = array();
      var $loadedExtensions = array();

      function jQuery(){
          $this->directory = DIR_FS_CATALOG . 'ext/jQuery/';
          $this->jqDir = DIR_WS_EXT . 'jQuery/';
          $this->classDir = DIR_FS_CATALOG . 'includes/classes/';
          $this->jsIncludes = array(
              'jQuery.js'
          );
          $this->cssIncludes = array();
          $this->randomIds = array();
          $this->scriptOutput = array(
              '$(document.body).focus();', 
              '$(\'button\').button();',
              '$.ajaxSetup({ error: $.ajax_error_message_box })'
          );
      }
      
      function setGlobalVars($vars = array()){
          if (is_array($vars)){
              if (!empty($vars)){
                  foreach($vars as $varName){
                      global ${$varName};
                      $this->globalVars[$varName] = ${$varName};
                  }
              }
          }else{
              global ${$vars};
              $this->globalVars[$vars] = ${$vars};
          }
      }
      
      function getGlobal($var){
          return $this->globalVars[$var];
      }
      
      function getGlobals(){
          return $this->globalVars;
      }
      
      function loadPlugin($plugin){
          if (is_array($plugin)){
              foreach($plugin as $plg){
                  $jsFile = 'plugins/' . $plg . '/jquery.' . $plg . '.js';
                  $cssFile = 'plugins/' . $plg . '/jquery.' . $plg . '.css';
                  if ($plg == 'grid'){
                     $cssFile = 'plugins/' . $plg . '/themes/office_blue/css/jquery.' . $plg . '.css';
                  }
                  if (file_exists($this->directory . $jsFile)){
                      $this->jsIncludes[] = $jsFile;
                      if (file_exists($this->directory . $cssFile)){
                          $this->cssIncludes[] = $cssFile;
                      }
                      $this->loadedPlugins[] = $plg;
                  }
              }
          }else{
              $jsFile = 'plugins/' . $plugin . '/jquery.' . $plugin . '.js';
              $cssFile = 'plugins/' . $plugin . '/jquery.' . $plugin . '.css';
              if (file_exists($this->directory . $jsFile)){
                  $this->jsIncludes[] = $jsFile;
                  if (file_exists($this->directory . $cssFile)){
                      $this->cssIncludes[] = $cssFile;
                  }
                  $this->loadedPlugins[] = $plugin;
              }
          }
      }
      
      function loadAllPlugins(){
          $dir = dir($this->directory . 'plugins/');
          while(($d = $dir->read()) !== false){
              if ($d != '.' && $d != '..' && is_dir($this->directory . 'plugins/' . $d)){
                  $this->loadPlugin($d);
              }
          }
          $dir->close();
      }
      
      function loadAllExtensions(){
          $dir = dir($this->directory . 'extensions/');
          while(($d = $dir->read()) !== false){
              if ($d != '.' && $d != '..' && is_file($this->directory . 'extensions/' . $d)){
                  $filename = explode('.', $d);
                  $this->loadExtension($filename[1]);
              }
          }
      }
      
      function getPluginClass($plugin, $settings = array()){
          if ($this->pluginIsLoaded($plugin) === true){
              if (file_exists($this->classDir . 'jQuery/' . $plugin . '.php')){
                  $className = 'jQuery_' . $plugin;
                  if (!class_exists($className)){
                      require($this->classDir . 'jQuery/' . $plugin . '.php');
                  }
                  return new $className($settings);
              }else{
                  die('No PHP Class For Plugin: ' . $plugin);
              }
          }else{
              die('Plugin Not Loaded: ' . $plugin);
          }
      }
      
      function getStandaloneClass($class, $settings = array()){
          if (file_exists($this->classDir . 'jQuery/' . $class . '.php')){
              $className = 'jQuery_standAlone_' . $class;
              if (!class_exists($className)){
                  require($this->classDir . 'jQuery/' . $class . '.php');
              }
            return new $className($settings);
          }else{
              die('Unknown jQuery Stand-alone PHP Class: ' . $class);
          }
      }
      
      function loadExtension($extension){
          $error = false;
          if (is_array($extension)){
              foreach($extension as $ext){
                  $jsFile = 'extensions/jquery.' . $ext . '.js';
                  if (file_exists($this->directory . $jsFile)){
                      $this->jsIncludes[] = $jsFile;
                      $this->loadedExtensions[] = $ext;
                  }else{
                      $error = true;
                  }
              }
          }else{
              $jsFile = 'extensions/jquery.' . $extension . '.js';
              if (file_exists($this->directory . $jsFile)){
                  $this->jsIncludes[] = $jsFile;
                  $this->loadedExtensions[] = $extension;
              }else{
                  $error = true;
              }
          }
      }
      
      function pluginIsLoaded($plugin){
          return (in_array($plugin, $this->loadedPlugins));
      }
      
      function getHeadOutput(){
          $return = '';
          foreach($this->cssIncludes as $filename){
              $return .= '<link rel="stylesheet" type="text/css" href="' . $this->jqDir . $filename . '" />' . "\n";
          }
          
          foreach($this->jsIncludes as $filename){
              $return .= '<script type="text/javascript" src="' . $this->jqDir . $filename . '"></script>' . "\n";
          }
        return $return;
      }
      
      function addScriptOutput($string, $index = false){
          if ($index === false){
              $index = sizeof($this->scriptOutput);
              if ($index == -1){
                  $index = 0;
              }
          }
          $this->scriptOutput[$index] = $string;
        return $index;
      }
      
      function setHelpButton($id, $linkParams = ''){
          if ($this->pluginIsLoaded('facebox')){
              $this->addScriptOutput('
                  $(\'#' . $id . '\').unbind(\'click\').click(function (e){
                      e.preventDefault();
                      $.facebox.settings.loading_image = "' . DIR_WS_CATALOG . 'ext/jQuery/plugins/facebox/loading.gif";
                      $.facebox.settings.close_image = "' . DIR_WS_CATALOG . 'ext/jQuery/plugins/facebox/closelabel.gif";
                      jQuery.facebox(function(){
                          $.ajaxSetup({ cache: false });
                          jQuery.get(\'' . $this->link('help.php', 'page=' . basename($_SERVER['PHP_SELF']) . (!empty($linkParams) ? '&' . $linkParams : '')) . '\', function (data){
                              jQuery.facebox(data);
                              $.ajaxSetup({ cache: true });
                          });
                      });
                  });
              ');
          }
      }
      
      function getRandomID($ident = ''){
          $ident = (!empty($ident) ? $ident . '_' : '');
          $check = 'jQuery_' . $ident . rand(0, 99999);
          while(isset($this->randomIds[$check])){
              $check = 'jQuery_' . $ident . rand(0, 99999);
          }
          $this->randomIds[$check] = $check;
        return $check;
      }
      
      function removeScriptOutput($index){
          unset($this->scriptOutput[$index]);
      }

      function getScriptOutput(){
          if (!empty($this->scriptOutput)){
              $return = implode("\n", $this->scriptOutput) . "\n";
              $this->scriptOutput = array();
              return $return;
          }
      }
      
      function link($fileName, $params = ''){
          return str_replace('&amp;', '&', smn_href_link($fileName, $params));
      }
      
      function jsonHtmlPrepare($html){
          return str_replace(array("\n", "\r"), array("\\n", "\\r"), addslashes($html));
      }
      
      function xmlHtmlPrepare(){
          die('XML response not implemented yet');
      }
  }
?>