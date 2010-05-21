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

  class store_modules {
      
      function store_modules($modulesType = 'shipping', $module = false){
        global $customer_store_id, $store_id;
          if (smn_session_is_registered('store_id')){
              $this->store_id = $store_id;
          }else{
              $this->store_id = $customer_store_id;
          }
          $this->module = array(
              'type'         => $modulesType,
              'key'          => 'MODULE_' . strtoupper($modulesType) . '_INSTALLED',
              'headingTitle' => @constant('HEADING_TITLE_MODULES_' . strtoupper($modulesType)),
              'installed'    => @constant('MODULE_' . strtoupper($modulesType) . '_INSTALLED'),
              'installedS'   => @constant('MODULE_' . strtoupper($modulesType) . '_INSTALLED'),
              'directory'    => DIR_FS_CATALOG . DIR_WS_MODULES . $modulesType . '/'
          );
          if ($module !== false){
              if (file_exists($this->module['directory'] . $module . '.php')){
                  $this->module['installed'] = $module . '.php';
              }
          }
          
          $this->loadModules();
          $this->loadLanguageDefines();
      }
      
      function loadModules(){
          $file_extension = '.php';
          $installedArray = array();
          $notInstalledArray = array();
          $moduleDir = $this->module['directory'];
          $installed_modules_array = explode(';', $this->module['installed']);
          if ($dir = @dir($moduleDir)) {
              while ($file = $dir->read()) {
                  if (!is_dir($moduleDir . $file)) {
                      if (substr($file, strrpos($file, '.')) == $file_extension){
                          if (in_array($file, $installed_modules_array)){
                              $installedArray[] = $file;
                          }else{
                              $notInstalledArray[] = $file;
                          }
                      }
                  }
              }
              sort($installedArray);
              sort($notInstalledArray);
              $dir->close();
          }
          $this->installedModules = $installedArray;
          $this->notInstalledModules = $notInstalledArray;
      }
      
      function isInstalled($moduleName){
          $checkArray = explode(';', $this->module['installedS']);
        return (in_array($moduleName . '.php', $checkArray));
      }
      
      function loadLanguageDefines(){
          $prepare_module_string = str_replace('.php', '', $this->module['installed']);
          $initial_module_string = str_replace(";", "' or page_name= '", $prepare_module_string);
          $conditions = " ( page_name = '" . $initial_module_string ."' )";
          $Qcontent = smn_db_query("select text_key, text_content from " . TABLE_WEB_SITE_CONTENT . " where " . $conditions);
          while ($content = smn_db_fetch_array($Qcontent)){
              define($content['text_key'], $content['text_content']);
          }
      }
      
      function getInstalledModules(){
        global $store_id;
          $installedModules = $this->installedModules;
          $this->installedModules = array();
          $this->modulesInfo = array();
          for ($i=0, $n=sizeof($installedModules); $i<$n; $i++) {
              $file = $installedModules[$i];
              $module = $this->moduleClass(substr($file, 0, strrpos($file, '.')));
              if ($module !== false) {
                  if ($module->check() > 0) {
                      if ($module->sort_order > 0) {
                          $this->installedModules[$module->sort_order] = $file;
                      } else {
                          $this->installedModules[] = $file;
                      }
                  }
                  
                  $this->loadModuleInfo($module);
              }
          }
        return $this->modulesInfo;
      }
      
      function loadModuleInfo($module){
          $modulesKeys = $module->keys();
          $keysValues = array();
          for($j=0, $k=sizeof($modulesKeys); $j<$k; $j++){
              $Qvalues = smn_db_query("select configuration_title, configuration_value, configuration_description, use_function, set_function from " . TABLE_CONFIGURATION . " where configuration_key = '" . $modulesKeys[$j] . "' and store_id = '" . $this->store_id . "'");
              $values = smn_db_fetch_array($Qvalues);
              
              $keysValues[$modulesKeys[$j]] = array(
                  'title'        => $values['configuration_title'],
                  'value'        => $values['configuration_value'],
                  'description'  => $values['configuration_description'],
                  'use_function' => $values['use_function'],
                  'set_function' => $values['set_function']
              );
          }
          
          $this->modulesInfo[$module->code] = array(
              'code'        => $module->code,
              'title'       => $module->title,
              'description' => $module->description,
              'status'      => $module->enabled,
              'keys'        => $keysValues,
              'sort_order'  => $module->sort_order
          );
      }
      
      function moduleIsLoaded($module){
          return (class_exists($module));
      }
      
      function getNotInstalledModules(){
          $smn_file_list_array = array(array(
              'id'   => '',
              'text' => TEXT_NONE
          ));
          
          foreach($this->notInstalledModules as $fileName){
              $smn_file_list_array[] = array(
                  'id'   => substr($fileName, 0, strrpos($fileName, '.')),
                  'text' => substr($fileName, 0, strrpos($fileName, '.'))
              );
          }
          sort($smn_file_list_array);
          
        return $smn_file_list_array;
      }
      
      function moduleClass($moduleName){
          if (!$this->moduleIsLoaded($moduleName)){
              if (file_exists($this->module['directory'] . $moduleName . '.php')){
                  include($this->module['directory'] . $moduleName . '.php');
              }else{
                  return false;
              }
          }
        return new $moduleName;
      }
      
      function installModule($moduleName){
        global $languages_id;
          $module = $this->moduleClass($moduleName);
          $module->install();
          smn_module_laguage_install($moduleName, $languages_id, $this->store_id);
          $updated_modules_array = $this->module['installedS'] . ';' . $moduleName . '.php';
          smn_db_query("update " . TABLE_CONFIGURATION . " set configuration_value = '" . $updated_modules_array  . "', last_modified = now() where configuration_key = '" . $this->module['key'] . "' and store_id = '" . $this->store_id . "'");
      }
      
      function uninstallModule($moduleName){
        global $languages_id;
          $module = $this->moduleClass($moduleName);
          if ($module !== false){
              $module->remove();
              $updated_modules = explode(';', $this->module['installedS']);
              for ($i = 0; $i < sizeof($updated_modules); $i++){
                  $fileName = $moduleName . '.php';
                  if ($fileName == $updated_modules[$i]){
                      unset($updated_modules[$i]);
                  }
              }
              $updated_modules_array = implode(';', $updated_modules);
              smn_db_query("delete from " . TABLE_WEB_SITE_CONTENT . " where store_id = '" . $this->store_id . "' and page_name = '" . $moduleName . "'");
              smn_db_query("update " . TABLE_CONFIGURATION . " set configuration_value = '" . $updated_modules_array  . "', last_modified = now() where configuration_key = '" . $this->module['key'] . "' and store_id = '" . $this->store_id . "'");
          }
      }
      
      function getModuleEdit($moduleName){
          if (!isset($this->modulesInfo[$moduleName])){
              $module = $this->moduleClass($moduleName);
              $this->loadModuleInfo($module);
          }
          $moduleInfo = $this->modulesInfo[$moduleName];

          $inputFields = '<span class="main">';
          $moduleKeys = $moduleInfo['keys'];
          reset($moduleKeys);
          while (list($key, $value) = each($moduleKeys)) {
              $inputFields .= '<b>' . $value['title'] . '</b><br>' . $value['description'] . '<br>';

              if ($value['set_function']) {
                  eval('$inputFields .= ' . $value['set_function'] . "'" . $value['value'] . "', '" . $key . "');");
              } else {
                  $inputFields .= smn_draw_input_field('configuration[' . $key . ']', $value['value']);
              }
              $inputFields .= '<br><br>';
          }
          $inputFields = substr($inputFields, 0, strrpos($inputFields, '<br><br>')) . '</span>';
        return $inputFields;
      }
  }
?>