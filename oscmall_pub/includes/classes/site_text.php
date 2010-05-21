<?php
  class site_text {
      
      function site_text($language_id = false, $use_store_id = false){
        global $languages_id, $store_id;
          if ($language_id === false){
              $language_id = $languages_id;
          }
          if ($use_store_id === false){
              $use_store_id = $store_id;
          }
          
          $this->languageID = $language_id;
          $this->storeID = $use_store_id;
          $this->langArray = smn_get_languages();
      }
      
      function loadText($pageName, $key){
          $QsiteText = smn_db_query('select text_content from ' . TABLE_WEB_SITE_CONTENT . ' where text_key = "' . $key . '" and language_id = "' . $this->languageID . '" and store_id = "' . $this->storeID . '" and page_name = "' . $pageName . '"');
          $siteText = smn_db_fetch_array($QsiteText);
          
          $this->setText($key, $siteText['text_content']);
      }
      
      function loadTextPage($pageName){
          $QsiteText = smn_db_query('select text_key, text_content from ' . TABLE_WEB_SITE_CONTENT . ' where language_id = "' . $this->languageID . '" and store_id = "' . $this->storeID . '" and page_name = "' . $pageName . '"');
          while($siteText = smn_db_fetch_array($QsiteText)){
              $this->setText($siteText['text_key'], $siteText['text_content']);
          }
      }
      
      function loadStoreDescription(){
      }
      
      function getText($key){
          if (isset($this->text[$key])){
              $return = $this->text[$key];
          }elseif (defined($key)){
              $return = constant($key);
          }elseif (defined(strtoupper($key))){
              $return = constant(strtoupper($key));
          }else{
              $return = $key;
          }
        return $return;
      }
      
      function getStoreDescription(){
          return $this->text['store_description'];
      }
      
      function setText($key, $val){
          $this->text[$key] = stripslashes($val);
      }
      
      function getTextPagesArray(){
          $pagesArray = array();
          $Qpages = smn_db_query("select distinct page_name from " . TABLE_WEB_SITE_CONTENT . " where language_id ='". $this->languageID ."' and store_id = '" . $this->storeID . "' order by page_name");
          while($pages = smn_db_fetch_array($Qpages)){
              $pagesArray[] = array(
                  'id'   => $pages['page_name'],
                  'text' => $pages['page_name']
              );
          }
        return $pagesArray;
      }
      
      function saveSiteText(){
        global $messageStack, $jQuery;
          $text_key = smn_db_prepare_input($_POST['text_key']);
          $page_name = smn_db_prepare_input($_POST['page_name']);
          $hiddenAction = smn_db_prepare_input($_POST['hidden_action']);
          if ($hiddenAction == 'new' && smn_not_null($_POST['new_page_name'])){
              $page_name = smn_db_prepare_input($_POST['new_page_name']);
          }
          $text_content = smn_db_prepare_input($_POST['text_content']);
          
          $error = false;
          $textExists = $this->exists($page_name, $text_key);
          if ($textExists && $hiddenAction == 'new'){
              $this->setJsonResponse('{
                  success: false,
                  error: "Duplicate Page/Key Combination Exsist."
              }');
              return false;
          }
          
          for($i=0, $n=sizeof($this->langArray); $i<$n; $i++){
              $sql_data_array = array(
                  'store_id'      => $this->storeID,
                  'page_name'     => $page_name,
                  'text_key'      => $text_key,
                  'language_id'   => $this->langArray[$i]['id'],
                  'text_content'  => $text_content[$this->langArray[$i]['id']],
                  'date_modified' => 'now()'
              );
               
              if ($textExists === true){
                  smn_db_perform(TABLE_WEB_SITE_CONTENT, $sql_data_array, 'update', 'page_name = "' . $page_name . '" and text_key = "' . $text_key . '" and language_id = "' . $this->langArray[$i]['id'] . '" and store_id = "' . $this->storeID . '"');
                  if (mysql_affected_rows() < 0){
                      smn_db_perform(TABLE_WEB_SITE_CONTENT, $sql_data_array);
                  }
              }else{
                  smn_db_perform(TABLE_WEB_SITE_CONTENT, $sql_data_array);
              }
          }
          
          $Qcontent = smn_db_query('select page_name, text_key, date_modified from ' . TABLE_WEB_SITE_CONTENT . ' where language_id = "' . $this->languageID . '" and store_id = "' . $this->storeID . '" and page_name = "' . $page_name . '" and text_key = "' . $text_key . '"');
          $content = smn_db_fetch_array($Qcontent);
          $multiLanguage = array();
          for($i=0, $n=sizeof($this->langArray); $i<$n; $i++){
              $multiLanguage[] = 'text_content_' . $this->langArray[$i]['id'] . ': "' . $jQuery->jsonHtmlPrepare($text_content[$this->langArray[$i]['id']]) . '"';
          }
          
          $this->setJsonResponse('{
              success: true,
              page_name: "' . $content['page_name'] . '",
              text_key: "' . $content['text_key'] . '",
              date_modified: "' . $content['date_modified'] . '",
              ' . implode(',', $multiLanguage) . '
          }');
        return true;
      }
      
      function deleteSiteText(){
          $text_key = smn_db_prepare_input($_GET['text_key']);
          $page_name = smn_db_prepare_input($_GET['page_name']);
          smn_db_query("delete from " . TABLE_WEB_SITE_CONTENT . " where page_name = '" . $page_name . "' and text_key= '" . $text_key."' and store_id = '" . $this->storeID . "'" );
          
          if (mysql_affected_rows() > 0){
              $this->setJsonResponse('{
                  success: true
              }');
          }else{
              $this->setJsonResponse('{
                  success: false,
                  errorMsg: "Text entry was not deleted."
              }');
          }
      }
      
      function siteTextListing($o = array()){
          $options = array(
              'language_id'   => $this->languageID,
              'page_name'     => 'account',
              'store_id'      => $this->storeID,
              'response_type' => 'json' //Options Are: xml, json, php
          );
          
          $options = array_merge($options, $o);
          
          if (isset($_GET['pageName']) && !empty($_GET['pageName'])){
              $options['page_name'] = $_GET['pageName'];
          }
            
          if (isset($_GET['languageID']) && !empty($_GET['languageID'])){
              $options['language_id'] = $_GET['language_id'];
          }
            
          if (isset($_GET['storeID']) && !empty($_GET['storeID'])){
              $options['store_id'] = $_GET['storeID'];
          }

          $content = array();
          $page_content_query = smn_db_query("select text_key, text_content, date_modified, page_name from " . TABLE_WEB_SITE_CONTENT . " where page_name = '" . $options['page_name'] . "' and language_id ='". $options['language_id'] ."' and store_id = '" . $options['store_id'] . "' order by text_key");
          $index = 0;
          $respType = $options['response_type'];
          while ($page_list_query = smn_db_fetch_array($page_content_query)){
              $content[$index] = array(
                  'text_key'      => $this->valuePrepare($respType, $page_list_query['text_key']),
                  'page_name'     => $this->valuePrepare($respType, $page_list_query['page_name']),
                  'date_modified' => $this->valuePrepare($respType, $page_list_query['date_modified'])
              );
              
              $contents = array();
              for ($i=0, $n=sizeof($this->langArray); $i<$n; $i++){
                  $Qdescription = smn_db_query('select text_content from ' . TABLE_WEB_SITE_CONTENT . ' where page_name = "' . $page_list_query['page_name'] . '" and text_key = "' . $page_list_query['text_key'] . '" and store_id = "' . $options['store_id'] . '" and language_id = "' . $this->langArray[$i]['id'] . '"');
                  if (smn_db_num_rows($Qdescription)){
                      $description = smn_db_fetch_array($Qdescription);
                      $value = $this->valuePrepare($respType, $description['text_content']);
                  }else{
                      $value = '';
                  }
                  $content[$index]['text_content_' . $this->langArray[$i]['id']] = $value;
              }
              $index++;
          }
          
          switch ($options['response_type']){
              case 'json':
                  $this->setJsonResponse('{
                      success: true,
                      arr: [' . implode(',', $this->arrayToJson($content)) . ']
                  }');
              break;
              case 'xml':
                  echo 'XML Response Not Implemented Yet';
                  exit;
              break;
              case 'php':
                  return $content;
              break;
          }
      }
      
      function arrayToJson($array){
          $jsonContent = array();
          foreach($array as $cInfo){
              $tempJsonContent = array();
              foreach($cInfo as $key => $val){
                  if (is_array($val)){
                      $tempJsonContent[] = $key . ': [' . $this->arrayToJson($val) . ']';
                  }else{
                      $tempJsonContent[] = $key . ': "' . $val . '"';
                  }
              }
              $jsonContent[] = '{' . implode(',', $tempJsonContent) . '}';
          }
        return $jsonContent;
      }
      
      function articleListing($o = array()){
          $options = array(
              'language_id'   => $this->languageID,
              'store_id'      => $this->storeID,
              'response_type' => 'json' //Options Are: xml, json, php
          );
          
          $options = array_merge($options, $o);
          
          if (isset($_GET['languageID']) && !empty($_GET['languageID'])){
              $options['language_id'] = $_GET['language_id'];
          }
            
          if (isset($_GET['storeID']) && !empty($_GET['storeID'])){
              $options['store_id'] = $_GET['storeID'];
          }

          $QarticlesPages = smn_db_query('select a.page_id, d.page_name, d.page_type, a.page_title, a.date_modified, a.text_content from ' . TABLE_DYNAMIC_PAGE_INDEX . ' d, ' . TABLE_ARTICLES . ' a where d.page_type = "articles" and d.page_id = a.page_id and a.language_id = "' . $options['language_id'] . '" and a.store_id = "' . $options['store_id'] . '" and d.store_id = a.store_id order by page_name');
          $articlesGridData = array();
          $rowIndex = 0;
          $respType = $options['response_type'];
          while ($articlesPages = smn_db_fetch_array($QarticlesPages)) {
              $multiLang = array();
              for($i=0, $n=sizeof($this->langArray); $i<$n; $i++){
                  $lID = $this->langArray[$i]['id'];
                  $Qarticle = smn_db_query('select page_title, text_content from ' . TABLE_ARTICLES . ' where language_id = "' . $lID . '" and store_id = "' . $options['store_id'] . '" and page_id = "' . $articlesPages['page_id'] . '" limit 1');
                  $article = smn_db_fetch_array($Qarticle);
                  
                  $QarticlesPagesHeader = smn_db_query('select text_content from ' . TABLE_WEB_SITE_CONTENT . ' where text_key = "HEADER_TITLE" and page_name = "' . $articlesPages['page_name'] . '" and language_id = "' . $lID . '" limit 1');
                  $articlesPagesHeader = smn_db_fetch_array($QarticlesPagesHeader);

                  $QarticlesPagesNavBar = smn_db_query('select text_content from ' . TABLE_WEB_SITE_CONTENT . ' where text_key = "NAVBAR_TITLE" and page_name = "' . $articlesPages['page_name'] . '" and language_id = "' . $lID . '" limit 1');
                  $articlesPagesNavBar = smn_db_fetch_array($QarticlesPagesNavBar);

                  $QarticlesPagesHeading = smn_db_query('select text_content from ' . TABLE_WEB_SITE_CONTENT . ' where text_key = "HEADING_TITLE" and page_name = "' . $articlesPages['page_name'] . '" and language_id = "' . $lID . '" limit 1');
                  $articlesPagesHeading = smn_db_fetch_array($QarticlesPagesHeading);
                  
                  $multiLang = array_merge($multiLang, array(
                      'page_title_' . $lID   => $this->valuePrepare($respType, $article['page_title']),
                      'text_content_' . $lID => $this->valuePrepare($respType, $article['text_content']),
                      'page_navbar_' . $lID  => $this->valuePrepare($respType, $articlesPagesNavBar['text_content']),
                      'page_header_' . $lID  => $this->valuePrepare($respType, $articlesPagesHeader['text_content']),
                      'page_heading_' . $lID => $this->valuePrepare($respType, $articlesPagesHeading['text_content'])
                  ));
              }
              
              $articlesGridData[$rowIndex] = array_merge(array(
                  'page_id'       => $this->valuePrepare($respType, $articlesPages['page_id']), 
                  'page_name'     => $this->valuePrepare($respType, $articlesPages['page_name']), 
                  'page_type'     => $this->valuePrepare($respType, $articlesPages['page_type']), 
                  'date_modified' => $this->valuePrepare($respType, $articlesPages['date_modified'])
              ), $multiLang);
              $rowIndex++;
          }
          
          switch ($respType){
              case 'json':
                  $this->setJsonResponse('{
                      success: true,
                      arr: [' . implode(',', $this->arrayToJson($articlesGridData)) . ']
                  }');
              break;
              case 'xml':
                  $this->setXmlResponse($articlesGridData);
              break;
              case 'php':
                  return $articlesGridData;
              break;
          }
      }
      
      function infoPageListing($o = array()){
          $options = array(
              'language_id'   => $this->languageID,
              'store_id'      => $this->storeID,
              'response_type' => 'json' //Options Are: xml, json, php
          );
          
          $options = array_merge($options, $o);
          
          if (isset($_GET['languageID']) && !empty($_GET['languageID'])){
              $options['language_id'] = $_GET['language_id'];
          }
            
          if (isset($_GET['storeID']) && !empty($_GET['storeID'])){
              $options['store_id'] = $_GET['storeID'];
          }

          $QarticlesPages = smn_db_query('select a.page_id, d.page_name, d.page_type, a.page_title, a.date_modified, a.text_content from ' . TABLE_DYNAMIC_PAGE_INDEX . ' d, ' . TABLE_ARTICLES . ' a where d.page_type = "web_pages" and d.page_id = a.page_id and a.language_id = "' . $options['language_id'] . '" and a.store_id = "' . $options['store_id'] . '" and d.store_id = a.store_id order by page_name');
          $articlesGridData = array();
          $rowIndex = 0;
          $respType = $options['response_type'];
          while ($articlesPages = smn_db_fetch_array($QarticlesPages)) {
              $multiLang = array();
              for($i=0, $n=sizeof($this->langArray); $i<$n; $i++){
                  $lID = $this->langArray[$i]['id'];
                  $Qarticle = smn_db_query('select page_title, text_content from ' . TABLE_ARTICLES . ' where language_id = "' . $lID . '" and store_id = "' . $options['store_id'] . '" and page_id = "' . $articlesPages['page_id'] . '" limit 1');
                  $article = smn_db_fetch_array($Qarticle);
                  
                  $QarticlesPagesHeader = smn_db_query('select text_content from ' . TABLE_WEB_SITE_CONTENT . ' where text_key = "HEADER_TITLE" and page_name = "' . $articlesPages['page_name'] . '" and language_id = "' . $lID . '" limit 1');
                  $articlesPagesHeader = smn_db_fetch_array($QarticlesPagesHeader);

                  $QarticlesPagesNavBar = smn_db_query('select text_content from ' . TABLE_WEB_SITE_CONTENT . ' where text_key = "NAVBAR_TITLE" and page_name = "' . $articlesPages['page_name'] . '" and language_id = "' . $lID . '" limit 1');
                  $articlesPagesNavBar = smn_db_fetch_array($QarticlesPagesNavBar);

                  $QarticlesPagesHeading = smn_db_query('select text_content from ' . TABLE_WEB_SITE_CONTENT . ' where text_key = "HEADING_TITLE" and page_name = "' . $articlesPages['page_name'] . '" and language_id = "' . $lID . '" limit 1');
                  $articlesPagesHeading = smn_db_fetch_array($QarticlesPagesHeading);
                  
                  $multiLang = array_merge($multiLang, array(
                      'page_title_' . $lID   => $this->valuePrepare($respType, $article['page_title']),
                      'text_content_' . $lID => $this->valuePrepare($respType, $article['text_content']),
                      'page_navbar_' . $lID  => $this->valuePrepare($respType, $articlesPagesNavBar['text_content']),
                      'page_header_' . $lID  => $this->valuePrepare($respType, $articlesPagesHeader['text_content']),
                      'page_heading_' . $lID => $this->valuePrepare($respType, $articlesPagesHeading['text_content'])
                  ));
              }
              
              $articlesGridData[$rowIndex] = array_merge(array(
                  'page_id'       => $this->valuePrepare($respType, $articlesPages['page_id']), 
                  'page_name'     => $this->valuePrepare($respType, $articlesPages['page_name']), 
                  'page_type'     => $this->valuePrepare($respType, $articlesPages['page_type']), 
                  'date_modified' => $this->valuePrepare($respType, $articlesPages['date_modified'])
              ), $multiLang);
              $rowIndex++;
          }
          
          switch ($respType){
              case 'json':
                  $this->setJsonResponse('{
                      success: true,
                      arr: [' . implode(',', $this->arrayToJson($articlesGridData)) . ']
                  }');
              break;
              case 'xml':
                  $this->setXmlResponse($articlesGridData);
              break;
              case 'php':
                  return $articlesGridData;
              break;
          }
      }
      
      function valuePrepare($respType, $val){
        global $jQuery;
          switch ($respType){
              case 'json':
                  return $jQuery->jsonHtmlPrepare($val);
              break;
              case 'xml':
                  return $jQuery->xmlHtmlPrepare($val);
              break;
              case 'php':
                  return $val;
              break;
          }
      }
      
      function getHelpText(){
        global $jQuery;
          $fileName = smn_db_prepare_input($_GET['pageName']);
          $QpageHelpText = smn_db_query('select hc.help_content from ' . TABLE_HELP . ' h, ' . TABLE_HELP_CONTENT . ' hc where h.help_id = hc.help_id and h.help_file = "' . $fileName . '" and h.help_file_tab = "false" and h.help_custom = "false" and hc.language_id = "' . $this->languageID . '"');
          $pageHelpText = smn_db_fetch_array($QpageHelpText);
          
          $tabsHelpArray = array();
          $dirName = str_replace('.php', '', $fileName);
          $disallowedTabs = array('shipping', 'payment', 'order_total');
          if (!in_array($dirName, $disallowedTabs) && is_dir(DIR_FS_CATALOG . 'includes/modules/' . $dirName)){
              $helpTabsIndex = 0;
              $dir = dir(DIR_FS_CATALOG . 'includes/modules/' . $dirName);
              while(($file = $dir->read()) !== false){
                  if ($file != '.' && $file != '..'){
                      $QtabsHelp = smn_db_query('select h.help_file_tab, hc.help_content from ' . TABLE_HELP . ' h, ' . TABLE_HELP_CONTENT . ' hc where h.help_id = hc.help_id and h.help_file = "' . $fileName . '" and h.help_file_tab = "' . $file . '" and h.help_custom = "false" and hc.language_id = "' . $this->languageID . '"');
                      $tabsHelp = smn_db_fetch_array($QtabsHelp);
                      $tabsHelpArray[$helpTabsIndex] = '["' . $file . '", "' . $jQuery->jsonHtmlPrepare($tabsHelp['help_content']) . '"]';
                      $helpTabsIndex++;
                  }
              }
          }
          
          $this->setJsonResponse('{
              success: true,
              pageHelp: "' . $jQuery->jsonHtmlPrepare($pageHelpText['help_content']) . '",
              pageTabs: [' . implode(',', $tabsHelpArray) . ']
          }');
      }
      
      function checkCustom(){
        global $jQuery;
          $Qcontent = smn_db_query('select hc.help_content from ' . TABLE_HELP . ' h, ' . TABLE_HELP_CONTENT . ' hc where hc.help_id = h.help_id and hc.language_id = "' . $this->languageID . '" and h.help_custom = "' . smn_db_prepare_input($_GET['string']) . '"');
          $content = smn_db_fetch_array($Qcontent);
          $this->setJsonResponse('{
              success: true,
              helpData: "' . $jQuery->jsonHtmlPrepare($content['help_content']) . '"
          }');
      }
      
      function deleteTextPage(){
          $pageName = smn_db_prepare_input($_GET['page_name']);
          smn_db_query('delete from ' . TABLE_WEB_SITE_CONTENT . ' where page_name = "' . $pageName . '" and store_id = "' . $this->storeID . '"');
          $this->setJsonResponse('{
              success: true
          }');
      }
      
      function getArticle(){
      }
      
      function saveArticle(){
          $this->saveSitePage('articles', $_POST['hidden_action']);
      }
      
      function deleteArticle(){
          $this->deleteSitePage('articles');
      }
      
      function getInfoPage(){
      }
      
      function saveInfoPage(){
          $this->saveSitePage('web_pages', $_POST['hidden_action']);
      }
      
      function deleteInfoPage(){
          $this->deleteSitePage('web_pages');
      }
      
      function deleteSitePage($pageType){
        global $messageStack, $jQuery;
          $page_id = smn_db_prepare_input($_GET['page_id']);
          $page_name = smn_db_prepare_input($_GET['page_name']);
          
          $error = false;
          smn_db_query('delete from ' . TABLE_DYNAMIC_PAGE_INDEX . ' where page_id = "' . $page_id . '" and page_type = "' . $pageType . '" and store_id = "' . $this->storeID . '"');
          if (mysql_affected_rows() < 0){
              $error = true;
              $messageStack->add('Error Deleting From Table ( ' . TABLE_DYNAMIC_PAGE_INDEX . ' )');
          }
          
          if ($error === false){
              smn_db_query('delete from ' . TABLE_WEB_SITE_CONTENT . ' where page_name = "' . $page_name . '" and store_id = "' . $this->storeID . '"');
              if (mysql_affected_rows() < 0){
                  $error = true;
                  $messageStack->add('Error Deleting From Table ( ' . TABLE_WEB_SITE_CONTENT . ' )');
              }
          }
          
          if ($error === false){
              smn_db_query('delete from ' . TABLE_ARTICLES . ' where page_id = "' . $page_id . '" and store_id = "' . $this->storeID . '"');
              if (mysql_affected_rows() < 0){
                  $error = true;
                  $messageStack->add('Error Deleting From Table ( ' . TABLE_ARTICLES . ' )');
              }
          }
          
          if ($error === false){
              $this->setJsonResponse('{
                  success: true
              }');
          }else{
              $this->setJsonResponse('{
                  success: false,
                  errorMsg: "' . $jQuery->jsonHtmlPrepare($messageStack->outputPlain()) . '"
              }');
          }
      }
      
      function saveSitePage($pageType, $action){
        global $jQuery;
          $error = false;
          $page_name = smn_db_prepare_input($_POST['page_name']);
          $page_title = $_POST['page_title'];
          $text_content = $_POST['text_content'];
          $page_navbar = $_POST['page_navbar'];
          $page_heading = $_POST['page_heading'];
          $page_header = $_POST['page_header'];

          $sql_data_array = array(
              'page_name' => $page_name,
              'store_id'  => $this->storeID,
              'page_type' => $pageType
          );
          if ($action == 'new'){
              smn_db_perform(TABLE_DYNAMIC_PAGE_INDEX, $sql_data_array);
              $page_id = smn_db_insert_id();      
          }elseif ($action == 'edit'){
              $page_id = $_POST['page_id'];
              smn_db_perform(TABLE_DYNAMIC_PAGE_INDEX, $sql_data_array, 'update', 'page_id = "' . $page_id . '"');
          }
          
          for ($i = 0, $n = sizeof($this->langArray); $i < $n; $i++) {
              $language_id = $this->langArray[$i]['id'];
              $sql_data_array = array(
                  'page_name'     => $page_name,
                  'language_id'   => $language_id,
                  'store_id'      => $this->storeID,
                  'text_key'      => '',
                  'text_content'  => '',
                  'date_modified' => 'now()'
              );
              
              $navbar_array = array_merge($sql_data_array, array(
                  'text_key'     => 'NAVBAR_TITLE',
                  'text_content' => smn_db_prepare_input($page_navbar[$language_id])
              ));
              
              $heading_array = array_merge($sql_data_array, array(
                  'text_key'     => 'HEADING_TITLE',
                  'text_content' => smn_db_prepare_input($page_heading[$language_id])
              ));
              
              $header_array = array_merge($sql_data_array, array(
                  'text_key'     => 'HEADER_TITLE',
                  'text_content' => smn_db_prepare_input($page_header[$language_id])
              ));
              
              $article_array = array(
                  'page_id'       => $page_id,
                  'language_id'   => $language_id,
                  'store_id'      => $this->storeID,
                  'page_title'    => smn_db_prepare_input($page_title[$language_id]),
                  'text_content'  => smn_db_prepare_input($text_content[$language_id]),
                  'date_modified' => 'now()'
              );
              
              if ($action == 'new'){
                  smn_db_perform(TABLE_WEB_SITE_CONTENT, $navbar_array);
                  smn_db_perform(TABLE_WEB_SITE_CONTENT, $heading_array);
                  smn_db_perform(TABLE_WEB_SITE_CONTENT, $header_array);
                  smn_db_perform(TABLE_ARTICLES, $article_array);
              }elseif ($action == 'edit'){
                  smn_db_perform(TABLE_WEB_SITE_CONTENT, $navbar_array, 'update', 'page_name = "' . $page_name . '" and text_key = "NAVBAR_TITLE" and language_id = "' . $language_id . '" and store_id = "' . $this->storeID . '"');
                  smn_db_perform(TABLE_WEB_SITE_CONTENT, $heading_array, 'update', 'page_name = "' . $page_name . '" and text_key = "HEADING_TITLE" and language_id = "' . $language_id . '" and store_id = "' . $this->storeID . '"');
                  smn_db_perform(TABLE_WEB_SITE_CONTENT, $header_array, 'update', 'page_name = "' . $page_name . '" and text_key = "HEADER_TITLE" and language_id = "' . $language_id . '" and store_id = "' . $this->storeID . '"');
                  smn_db_perform(TABLE_ARTICLES, $article_array, 'update', 'page_id = "' . $page_id . '" and language_id = "' . $language_id . '" and store_id = "' . $this->storeID . '"');
              }
          }
          
          if ($error === false){
              $jsonResponse = array();
              for($i=0, $n=sizeof($this->langArray); $i<$n; $i++){
                  $lID = $this->langArray[$i]['id'];
                  $jsonResponse[] = 'page_title_' . $lID . ': "' . $jQuery->jsonHtmlPrepare($page_title[$lID]) . '",
                                     text_content_' . $lID . ': "' . $jQuery->jsonHtmlPrepare($text_content[$lID]) . '",
                                     page_header_' . $lID . ': "' . $jQuery->jsonHtmlPrepare($page_header[$lID]) . '",
                                     page_heading_' . $lID . ': "' . $jQuery->jsonHtmlPrepare($page_heading[$lID]) . '",
                                     page_navbar_' . $lID . ': "' . $jQuery->jsonHtmlPrepare($page_navbar[$lID]) . '"';
              }
               
              $this->setJsonResponse('{
                  success: true,
                  page_id: "' . $page_id . '",
                  page_name: "' . $page_name . '",
                  date_modified: "' . date('Y-m-d') . '",
                  page_type: "' . $pageType . '",
                  ' . implode(',', $jsonResponse) . '
              }');
          }else{
              $this->setJsonResponse('{
                  success: false,
                  errorMsg: "There was an error saving the data."
              }');
          }
      }
      
      function saveHelpPage(){
          if (isset($_POST['customHelp'])){
              $helpContent = $_POST['customHelpContent']['catalog'];
              $customString = smn_db_prepare_input($_POST['customHelp']);
                
              $Qcheck = smn_db_query('select help_id from ' . TABLE_HELP . ' where help_custom = "' . $customString . '"');
              if (smn_db_num_rows($Qcheck)){
                  $check = smn_db_fetch_array($Qcheck);
                  smn_db_query('update ' . TABLE_HELP_CONTENT . ' set help_content = "' . $fullPageHelp . '" where help_id = "' . $check['help_id'] . '"');
              }else{
                  smn_db_query('insert into ' . TABLE_HELP . ' (help_file, help_file_tab, help_custom) values ("false", "false", "' . $customString . '")');
                  $helpID = smn_db_insert_id();
                  smn_db_query('insert into ' . TABLE_HELP_CONTENT . ' (help_id, help_content, language_id) values ("' . $helpID . '", "' . $helpContent . '", "1")');
              }
          }else{
              $pageName = $_POST['helpFile'];
              $fullPageHelp = smn_db_prepare_input($_POST['fullPageHelp']['catalog']);
              $tabs = $_POST['tab'];
                
              $Qcheck = smn_db_query('select * from ' . TABLE_HELP . ' where help_file = "' . $pageName . '"');
              if (smn_db_num_rows($Qcheck)){
                  $check = smn_db_fetch_array($Qcheck);
                  smn_db_query('update ' . TABLE_HELP_CONTENT . ' set help_content = "' . $fullPageHelp . '" where help_id = "' . $check['help_id'] . '"');
              }else{
                  smn_db_query('insert into ' . TABLE_HELP . ' (help_file, help_file_tab, help_custom) values ("' . $pageName . '", "false", "false")');
                  $fullHelpID = smn_db_insert_id();
                  smn_db_query('insert into ' . TABLE_HELP_CONTENT . ' (help_id, help_content, language_id) values ("' . $fullHelpID . '", "' . $fullPageHelp . '", "1")');
              }
                
              if (!empty($tabs)){
                  foreach($tabs as $tabFile => $helpContent){
                      $Qcheck = smn_db_query('select * from ' . TABLE_HELP . ' where help_file = "' . $pageName . '" and help_file_tab = "' . $tabFile . '"');
                      if (smn_db_num_rows($Qcheck)){
                          $check = smn_db_fetch_array($Qcheck);
                          smn_db_query('update ' . TABLE_HELP_CONTENT . ' set help_content = "' . $helpContent . '" where help_id = "' . $check['help_id'] . '"');
                      }else{
                          smn_db_query('insert into ' . TABLE_HELP . ' (help_file, help_file_tab, help_custom) values ("' . $pageName . '", "' . $tabFile . '", "false")');
                          $tabHelpID = smn_db_insert_id();
                          smn_db_query('insert into ' . TABLE_HELP_CONTENT . ' (help_id, help_content, language_id) values ("' . $tabHelpID . '", "' . $helpContent . '", "1")');
                      }
                  }
              }
          }
          
          $this->setJsonResponse('{
              success: true
          }');
      }
      
      function saveDescription(){
        global $jQuery;
          $error = false;
          $store_description = $_POST['store_description'];
          for ($i = 0, $n = sizeof($this->langArray); $i < $n; $i++){
              $lID = $this->langArray[$i]['id'];
              $storeDescription = addslashes($store_description[$lID]);
              smn_db_query("update " . TABLE_STORE_DESCRIPTION . " set store_description = '" . $storeDescription. "' where language_id='" . $lID . "' and store_id = '" . $this->storeID . "'");                        
          }
          
          if ($error === false){
              $this->setJsonResponse('{
                  success: true,
                  description: "' . $jQuery->jsonHtmlPrepare($store_description[$this->languageID]) . '"
              }');
          }else{
              $this->setJsonResponse('{
                  success: false,
                  errorMsg: "Store description not saved."
              }');
          }
      }
      
      function exists($page, $key, $checkLanguage = false, $checkStore = false){
          if ($checkLanguage === false){
              $checkLanguage = $this->languageID;
          }
          
          if ($checkStore === false){
              $checkStore = $this->storeID;
          }
          
          $pageExists = false;
          $keyExists = false;
          
          $QpageCheck = smn_db_query('select distinct page_name from ' . TABLE_WEB_SITE_CONTENT . ' where page_name = "' . $page . '" and language_id = "' . $checkLanguage . '" and store_id = "' . $checkStore . '"');
          if (smn_db_num_rows($QpageCheck)){
              $pageExists = true;
          }
          
          if ($pageExists === true){
              $QkeyCheck = smn_db_query('select text_key from ' . TABLE_WEB_SITE_CONTENT . ' where page_name = "' . $page . '" and text_key = "' . $key . '" and language_id = "' . $checkLanguage . '" and store_id = "' . $checkStore . '"');
              if (smn_db_num_rows($QkeyCheck)){
                  $keyExists = true;
              }
          }
        return ($keyExists === true);
      }
      
      function hasResponse(){
          return isset($this->tempJsonResponse);
      }
      
      function setJsonResponse($response){
          $this->tempJsonResponse = $response;
      }
      
      function setXmlResponse($response){
          die('XML response not implemented yet');
      }
      
      function getJsonResponse(){
          $response = $this->tempJsonResponse;
          unset($this->tempJsonResponse);
        return $response;
      }
  }
?>