<?php
/*
  Copyright (c) 2002 - 2005 SystemsManager.Net

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

define('HEADING_TITLE', 'Web Site Template Setup');

define('TABLE_HEADING_TEMPLATE', 'Web Site Templates');
define('TABLE_HEADING_TEMPLATE_ID', 'Template ID');
define('TABLE_HEADING_TEMPLATE_NAME', 'Template Name');
define('TABLE_HEADING_THEMA', 'Template Thema Options');
define('TABLE_HEADING_STATUS', 'Use Template');
define('TABLE_HEADING_ACTION', 'Action');

define('TEXT_NEW_TEMPLATE', 'Template Directory Name');
define('TABLE_HEADING_NEW_TEMPLATE', 'Install New Web Site Template');
define('TABLE_HEADING_NEW_TEMPLATE_INSTRUCTIONS', 'To install a <b>new</b> template or thema into the system the following actions need to be performed: <p>
       Upload the complete folder that has been created. <p> This folder is to be uploaded to your catalog/includes/template directory.
      <p> Note the name of the folder you are uploading.  <p>If you are planning to create your own templates, ensure you
       update the file contained in the folder <b>install.sql</b>.  This file contains the name of the template and the thema colour.  Leave it set to false.<br>
      <p> Next in the input field on the right side of this page, enter the name of the folder you just uploaded.  These names must match. <p>Hit enter to install the
        template package or cancel to return to main screen.');

define('HEADING_TEXT', 'For addition information email <a href="mailto:pmcgrath@systemsmanager.net"><b><font size=2>SystemsManager Technologies</b></font></a>');
define('TEXT_IN_USE', 'True');
define('TEXT_NOT_IN_USE', 'False');
?>
