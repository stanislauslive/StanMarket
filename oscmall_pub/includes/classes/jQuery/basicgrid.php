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

  class jQuery_basicgrid {
      
      function jQuery_basicgrid($config = array()){
        global $jQuery;
          $this->colIndex = 0;
          $this->rowIndex = 0;
          $this->firstColumn = false;
          $this->config = array(
              'id'          => $jQuery->getRandomID('basicgrid'),
              'buttons'     => array(),
              'add_buttons' => array(),
              'columns'     => array(),
              'data'        => array(),
              'url'         => false,
              'paging'      => false,
              'mode'        => 'local',
              'page_size'   => '20',
              'hidden'      => false
          );
          if (is_array($config) && sizeof($config) > 0){
              $this->config = array_merge($this->config, $config);
              if (isset($config['id'])){
                  $this->setID($config['id']);
              }
              if (isset($config['buttons'])){
                  $this->addButton($config['buttons']);
              }
              if (isset($config['columns'])){
                  $this->addColumns($config['columns']);
              }
              if (isset($config['data'])){
                  $this->addData($config['data']);
              }
          }
      }
      
      function setID($id){
        global $jQuery;
          $this->config['id'] = $id;
          $gridSettings = array();
          if ($this->config['mode'] == 'remote'){
              $gridSettings[] = 'mode: "remote"';
              if (!empty($this->config['url'])){
                  $gridSettings[] = 'url: "' . $this->config['url'] . '"';
              }
          }
          
          if ($this->config['paging'] === true){
              $gridSettings[] = 'paging: true';
              $gridSettings[] = 'page_size: ' . (int)$this->config['page_size'];
          }
          $scriptString = '$(\'#' . $this->config['id'] . '\').basicGrid(' . (!empty($gridSettings) ? '{' . implode(',', $gridSettings) . '}' : '') . ')';
          if ($this->config['hidden'] === true){
              $scriptString .= '.css(\'display\', \'none\')';
          }
          $scriptString .= ';';
          
          if (isset($this->jqInitIndex)){
              $this->jqInitIndex = $jQuery->addScriptOutput($scriptString, $this->jqInitIndex);
          }else{
              $this->jqInitIndex = $jQuery->addScriptOutput($scriptString);
          }
          
          if ($jQuery->pluginIsLoaded('tablesorter')){
              $scriptString = '$(\'#' . $this->config['id'] . '\').tablesorter();';
              if (isset($this->jqSortIndex)){
                  $this->jqSortIndex = $jQuery->addScriptOutput($scriptString, $this->jqSortIndex);
              }else{
                  $this->jqSortIndex = $jQuery->addScriptOutput($scriptString);
              }
          }
      }
      
      function getID(){
          return $this->config['id'];
      }
      
      function addColumn($col){
          if (($this->firstColumn === false || $this->colIndex == 0) && (!isset($col['hidden']) || (isset($col['hidden']) && $col['hidden'] === false))){
              $this->firstColumn = $this->colIndex;
          }
          $this->gridCols[$this->colIndex] = array(
              'id'     => $col['id'],
              'text'   => $col['text'],
              'hidden' => (isset($col['hidden']) ? $col['hidden'] : false)
          );
          if (!isset($col['hidden']) || (isset($col['hidden']) && $col['hidden'] === false)){
              $this->lastColumn = $this->colIndex;
          }
          $this->colIndex++;
      }
      
      function addColumns($columns){
          for($i=0, $n=sizeof($columns); $i<$n; $i++){
              $this->addColumn($columns[$i]);
          }
      }
      
      function addRow($row){
          for ($i=0; $i<sizeof($this->gridCols); $i++){
              $rowText = $row[$this->gridCols[$i]['id']];
              $this->gridRows[$this->rowIndex][] = array(
                  'id'     => $this->gridCols[$i]['id'] . '_row_' . $this->rowIndex . 'col_' . $i,
                  'text'   => $rowText,
                  'hidden' => $this->gridCols[$i]['hidden']
              );
          }
      }
      
      function addData($data){
          $cols = array();
          if (sizeof($data) > 0){
              for($i=0, $n=sizeof($data); $i<$n; $i++){
                  $this->addRow($data[$i]);
                  $this->rowIndex++;
              }
          }
      }
      
      function addButton($buttonObj){
          if (is_array($buttonObj)){
              foreach($buttonObj as $obj){
                  $this->config['add_buttons'][$obj->getID()] = $obj->output();
              }
          }else{
             $this->config['add_buttons'][$buttonObj->getID()] = $buttonObj->output();
          }
      }
      
      function getButtons(){
          $buttons = '';
          foreach($this->config['add_buttons'] as $button){
              $buttons .= '&nbsp;' . $button;
          }
        return $buttons . '&nbsp;';
      }

      function outputHTML(){
          return $this->outputGrid();
      }
      
      function outputGrid(){
        global $jQuery;
          $grid = '<div class="basicGrid-container' . ($this->config['hidden'] === true ? ' basicGrid_hidden' : '') . '"><table id="' . $this->config['id'] . '" cellpadding="0" cellspacing="0" border="0" class="basicGrid"' . ($this->config['mode'] == 'remote' ? ' url="' . $this->config['url'] . '" page_size="' . $this->config['page_size'] . '"' : '') . '>' . "\n" . 
                  ' <thead>' . "\n" . 
                  '  <tr>' . "\n";
                  
          $colspan = 0;
          for($i=0, $n=sizeof($this->gridCols); $i<$n; $i++){
              if ($this->gridCols[$i]['hidden'] !== true){
                  $colspan++;
              }
              $grid .= '   <th id="' . $this->gridCols[$i]['id'] . '" class="basicGrid_header' . ($this->gridCols[$i]['hidden'] === true ? ' basicGrid_hidden' : '') . '">' . ($i > 0 ? '<span id="colExpander"></span>' : '') . '<span id="colText">' . strip_tags($this->gridCols[$i]['text']) . '</span><span id="colMenu"><div></div></span><span id="colSorter"></span></th>' . "\n";
          }
          
          $grid .= '  </tr>' . "\n" . 
                   ' </thead>' . "\n" . 
                   ' <tfoot>' . "\n";
                   
          if (!empty($this->config['add_buttons']) || $this->config['paging'] === true){
              $paging = '';
              if ($this->config['paging'] === true){
                  $paging = '<div class="basicGrid_pager" page_size="' . $this->config['page_size'] . '"></div>';
              }
              $grid .= '  <tr>' . "\n" . 
                       '   <td class="basicGrid_footer" colspan="' . $colspan . '">' . $paging . $this->getButtons() . '</td>' . "\n" . 
                       '  </tr>' . "\n";
          }
                   
          $grid .= ' </tfoot>' . "\n" . 
                   ' <tbody>' . "\n";
          
          if (sizeof($this->gridRows) > 0){
              foreach($this->gridRows as $rIndex => $rInfo){
                  $grid .= '  <tr>' . "\n";
                  for($j=0, $m=sizeof($this->gridRows[$rIndex]); $j<$m; $j++){
                      $grid .= '   <td col="' . $j . '" class="basicGrid_column' . ($this->gridRows[$rIndex][$j]['hidden'] === true ? ' basicGrid_hidden' : '') . '">' . $this->gridRows[$rIndex][$j]['text'] . '</td>' . "\n";
                  }
                  $grid .= '  </tr>' . "\n";
              }
          }
          
          $grid .= ' </tbody>' . "\n" . 
                   '</table></div>' . "\n";
        return $grid;
      }
  }
?>