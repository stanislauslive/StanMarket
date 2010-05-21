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

class modules {
	var $store_id,
	    $module_type,
            $module_name,
            $languages_id;
        
	//add in checkout modules info here
        function modules($use_store_id = 1) {
            $error = TRUE;
            if((int)$use_store_id <= 0){
                $this->store_id = 1;   
            }else{
                $this->store_id = (int)$use_store_id;  
            }
        }
        
        function set_store_modules($module_type = '') {
            $module_array = '';
	    if($module_type != ''){
		$key_value_query = smn_db_query("select modules_key, modules_value from " . TABLE_MODULES . " where modules_type = '" . $module_type . "' and store_id = '" . $this->store_id  . "'");
		$key_value = smn_db_fetch_array($key_value_query);
                while ($text_contents = smn_db_fetch_array($content_query)) {
                    define($text_contents['modules_key'], $text_contents['modules_value']);
                } 
	    }
        }
        
        function get_store_modules($module_type = '') {
            $module_array = '';
	    if($module_type != ''){
		    $key_value_query = smn_db_query("select " . $module_type . " from " . TABLE_STORE_MAIN . " where store_id = '" . $this->store_id  . "'");
		    $key_value = smn_db_fetch_array($key_value_query);
		    $module_array = explode(';', $key_value[$module_type]);
		    return $module_array;
	    }else{
		    return $module_array;
	    }
        }
        
        function get_store_module_language($modules_installed) {
            global $languages_id;
            $prepare_module_string = str_replace('.php', '', $modules_installed);
            $initial_module_string = str_replace(";", "' or page_name= '", $prepare_module_string);
            $text_contents_conditions =  " and ( page_name= '" . $initial_module_string ."' )";
            $content_query = smn_db_query("select text_key, text_content from " . TABLE_WEB_SITE_CONTENT . " where store_id = '" . $this->store_id . "' " . $text_contents_conditions ." and language_id ='" . (int)$languages_id ."'");
            while ($text_contents = smn_db_fetch_array($content_query)) {
                define($text_contents['text_key'], $text_contents['text_content']);
            }  
        }
        
        function set_store_module_language($module_type, $module_name) {
            global $languages_id, $language;
	    $module_name = str_replace('.php', '', $module_name);
	    switch ($module_type) {
		case 'shipping':
		    include_once(DIR_FS_CATALOG_LANGUAGES . 'install/' . $module_type . '/' . $language . '.php');
		    smn_module_shipping_install($module_name, $languages_id, $this->store_id); 
		break;
		case 'order_total':
		    include_once(DIR_FS_CATALOG_LANGUAGES . 'install/' . $module_type . '/' . $language . '.php');
		    smn_module_order_total_install($module_name, $languages_id, $this->store_id); 
		break;
		case 'payment':
		    include_once(DIR_FS_CATALOG_LANGUAGES . 'install/' . $module_type . '/' . $language . '.php');
		    smn_module_payment_install($module_name, $languages_id, $this->store_id); 
		break;
            }
        }
        
	function install_store_module_data($module_type, $module_name) {
		
	    if (smn_not_null($module_type)) {
		switch ($module_type) {
			case 'shipping':
			    $module_directory = DIR_FS_CATALOG . 'includes/modules/shipping/';
			break;
			case 'order_total':
			    $module_directory = DIR_FS_CATALOG . 'includes/modules/order_total/';
			break;
			case 'payment':
			    $module_directory = DIR_FS_CATALOG . 'includes/modules/payment/';
			break;
                    }
            }else{
		exit();
	    }
	    $installed_modules = $this->get_store_modules($module_type);
	    if(!in_array($module_name, $installed_modules)){
		
		
		    $module_names = implode(';', $installed_modules);
		    $module_names .= ';' . $module_name;
	    }else{
		$module_names = implode(';', $installed_modules);
	    }
	    if (file_exists($module_directory . $module_name)) {
		
		include_once($module_directory . $module_name);
		$module = str_replace('.php', '', $module_name);
		$install_module = new $module;
		$install_module->install($this->store_id);
		$this->set_store_module_language($module_type, $module_name);  
		smn_db_query("update " . TABLE_STORE_MAIN . " set " . $module_type . " = '" . smn_db_prepare_input($module_names) . "' where store_id = '" . (int)$this->store_id . "'");
		$error = FALSE;
	    }  
	    return $error;
	}
	
	function delete_store_module_data($module_type, $module_name) {
	    if (smn_not_null($module_type)) {
		switch ($module_type) {
			case 'shipping':
			    $module_directory = DIR_FS_CATALOG . 'includes/modules/shipping/';
			break;
			case 'order_total':
			    $module_directory = DIR_FS_CATALOG . 'includes/modules/order_total/';
			break;
			case 'payment':
			    $module_directory = DIR_FS_CATALOG . 'includes/modules/payment/';
			break;
                    }
            }else{
		exit();
	    }
	    $installed_modules = $this->get_store_modules($module_type);
	    foreach($installed_modules as $module){
		if($module_name != $module){
		    $module_names[] = $module . ';';
		}
	    }
	    $lenght = strlen($module_names);
	    $module_names = substr($module_names, 0, ($lenght -1));
	    if (file_exists($module_directory . $module_name)) {
		include($module_directory . $module_name);
		$module = str_replace('.php', '', $module_name);
		$delete_module = new $module;
		$delete_module->remove($this->store_id);
		//need to add in delete text for PRO shops
		//$this->set_store_module_language($module_name, $languages_id, $this->store_id );  
		smn_db_query("update " . TABLE_STORE_MAIN . " set " . $module_type . " = '" . smn_db_prepare_input($module_names) . "' where store_id = '" . (int)$this->store_id . "'");
		$error = FALSE;
	    } 
		return $error;
	}	
}