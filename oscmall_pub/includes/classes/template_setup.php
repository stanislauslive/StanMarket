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

class template_setup {
	
	function template_setup (){
		
		// set the template and theme parameters (can be modified through the administration interface)
		if (ALLOW_STORE_TEMPLATE == 'true'){ 
			$template_query = smn_db_query("select thema as themeKey, template_name as templateValue from " . TABLE_TEMPLATE . " where template_id = '" . TEMPLATE_ID . "'");
		}else{
			$template_query = smn_db_query("select thema as themeKey, template_name as templateValue from " . TABLE_TEMPLATE . " where template_id = '" . DEFAULT_TEMPLATE_ID . "'");
		}
		$this->template = smn_db_fetch_array($template_query);
	}
	
	function smn_set_template (){
		global $language;
			define('THEME_STYLE', $this->template['themeKey']);
			define('TEMPLATE', $this->template['templateValue']);
			define('TEMPLATE_STYLE', DIR_WS_TEMPLATE . TEMPLATE . '/catalog.php');
			define('DIR_WS_SITE_FILES', DIR_WS_TEMPLATE . TEMPLATE . '/');
			define('THEMA_STYLE', DIR_WS_SITE_FILES . THEME_STYLE . '/stylesheet.css');  
			define('DIR_WS_BOX_TEMPLATES', DIR_WS_SITE_FILES . 'theme_boxes/');
			define('DEFAULT_TEMPLATENAME_BOX', DIR_WS_BOX_TEMPLATES . 'box.php');
			define('DIR_WS_BUTTONS', DIR_WS_SITE_FILES . THEME_STYLE . '/'. $language . '_buttons/');
			define('DIR_WS_INFOBOX', DIR_WS_SITE_FILES . THEME_STYLE . '/infobox/');
			define('TEMPLATE_IMAGES', DIR_WS_SITE_FILES . 'template_images/');
	}
}
?>