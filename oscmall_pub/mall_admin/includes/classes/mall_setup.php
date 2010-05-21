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

class mall_setup {
	    var $store_id,
		$store_city_state,
		$store_company,
		$store_dob,
		$store_telephone,
		$store_fax,
		$store_name,
		$store_owner,
		$store_logo,
		$store_zone,
		$store_owner_email_address,
		$email_from,
		$store_country,
		$store_name_address,
		$shipping_origin_country,
		$shipping_origin_zip,
		$store_image,
		$store_status,
		$store_group_id,
		$store_description,
		$store_type;

	function mall_setup($store_id = 1) {
		$this->set_store_id((int)$store_id); 

	    require(DIR_WS_INCLUDES . 'database_tables.php');
	    smn_set_database_tables();

		$store_query = smn_db_query("select sm.*, sd.store_description, sd.store_name, a.admin_groups_id from " . TABLE_STORE_MAIN . " sm, " . TABLE_STORE_DESCRIPTION . " sd, " . TABLE_ADMIN . " a WHERE sm.store_id = '". $this->store_id ."' and sd.store_id = '". $this->store_id ."' and a.store_id = '". $this->store_id ."'");
		if (smn_db_num_rows($store_query) == 0){
		    $this->store_id = 1;
		    $store_query = smn_db_query("select sm.*, sd.store_description, sd.store_name, a.admin_groups_id from " . TABLE_STORE_MAIN . " sm, " . TABLE_STORE_DESCRIPTION . " sd, " . TABLE_ADMIN . " a WHERE sm.store_id = '1' and sd.store_id = '1' and a.store_id = '1'");	
		}
		$store_array = smn_db_fetch_array($store_query);
		$store_info_query = smn_db_query("select c.*, ab.* from " . TABLE_CUSTOMERS . " c, " . TABLE_ADDRESS_BOOK . " ab WHERE c.customers_id = '". $store_array['customer_id'] ."' and c.customers_id = ab.customers_id and c.customers_default_address_id = ab.address_book_id");
		$store_info_array = smn_db_fetch_array($store_info_query);
		$this->set_store_customer_id($store_array['customer_id']);
		$this->set_store_group_id($store_array['admin_groups_id']);
		$this->set_store_company($store_info_array['entry_company']);
		$this->set_store_dob($store_info_array['customers_dob']);
		$this->set_store_telephone($store_info_array['customers_telephone']); 
		$this->set_store_fax($store_info_array['customers_fax']); 
		$this->set_store_name(stripslashes($store_array['store_name']));
		$this->set_store_logo($store_array['store_image']);
		$this->set_store_zone($store_info_array['entry_zone_id']);
		$this->set_store_owner_email_address($store_info_array['customers_email_address']);
		$this->set_email_from($this->get_store_name() . '<' . $this->get_store_owner_email_address() . '>' );
		$this->set_store_country($store_info_array['entry_country_id']);
		$this->set_store_name_address($this->get_store_name() . "\n" . $store_info_array['entry_street_address'] . "\n"  . $store_info_array['entry_city']. "\n" . $store_info_array['entry_state'] . "\n" . 'USA' . "\n" . $store_info_array['entry_postcode']. "\n");
		$this->set_shipping_origin_country($store_info_array['entry_country_id']);
		$this->set_shipping_origin_zip($store_info_array['entry_postcode']);
		$this->set_store_type((int)$store_array['store_type']);
		$this->set_store_description($store_array['store_description']);
		$this->set_store_status((int)$store_array['store_status']);
		$this->set_store_image($store_array['store_image']);

		$this->set_db_tables();
	}



  // set the mall application parameters

	function set_store_parameters() {
	    $use_store_configuration = $this->store_id;
		/*Changed the query to display the orders placed from substores in the account history by Cimi*/
		/*$sql = "select store_id, configuration_key as cfgKey, configuration_value as cfgValue from " . TABLE_CONFIGURATION . " where store_id ='" . $use_store_configuration ."' or store_id = '0'";*/
		$sql = "select store_id, configuration_key as cfgKey, configuration_value as cfgValue from " . TABLE_CONFIGURATION . " where store_id ='" . $use_store_configuration ."' or store_id = '0' order by store_id desc";
	    $configuration_query = smn_db_query($sql);
	    while ($configuration = smn_db_fetch_array($configuration_query)) {
			define($configuration['cfgKey'], $configuration['cfgValue']);
	    }
		
		$sql = "SELECT sd.*, sm.* FROM " . TABLE_STORE_DESCRIPTION . " sd, " . TABLE_STORE_MAIN . " sm WHERE sd.store_id=sm.store_id AND sd.store_id=" . $this->store_id;
		$qry = smn_db_query($sql);
		if (smn_db_num_rows($qry) > 0) {
			$row = smn_db_fetch_array($qry);
			define('STORE_NAME', $row['store_name']);
			define('STORE_LOGO', $row['store_image']);
		}
		
		if ($this->store_id > 1) {
			$sql = "SELECT * FROM " . TABLE_ADMIN . " WHERE store_id=" . $this->store_id;
			$qry = smn_db_query($sql);
			if (smn_db_num_rows($qry) > 0) {
				$row = smn_db_fetch_array($qry);
				define('EMAIL_FROM', $row['admin_email_address']);
			}
		}
		else {
			define('EMAIL_FROM', MALL_EMAIL_FROM);
		}
		define('DIR_WS_EXT', '../ext/');
        define('DIR_WS_TEMPLATES', '/templates/');
        define('DIR_FS_TEMPLATES', DIR_FS_ADMIN . 'templates/');
	}

	function set_store_group_id($group_id) {
	    $this->store_group_id = $group_id;
	}
        
	function set_store_customer_id($store_customer_id) {
	    $this->store_customer_id = $store_customer_id;
	}

	function set_store_image($image) {
	    $this->store_image = $image;
	}

	function get_store_image() {
	    return $this->store_image;
	}

	function set_store_status($status) {
	    $this->store_status = $status;
	}

	function get_store_status() {
	    return $this->store_status;
	}

	function set_store_description($desc) {
		$this->store_description = stripslashes($desc);
	}

	function get_store_description() {
		return $this->store_description;
	}

	function set_store_type($type) {
		$this->store_type = $type;
	}

	function get_store_type() {
		return $this->store_type;
	}

	function get_store_type_name() {
  		$store_type_query = smn_db_query("select st.store_types_name from " . TABLE_ADMIN_GROUPS . " ag,  " . TABLE_STORE_TYPES . " st where ag.admin_groups_store_type = st.store_types_id and ag.admin_groups_id = '" . $this->store_type . "'");
	       $store_type = smn_db_fetch_array($store_type_query);
	       return $store_type['store_types_name'];
	}
	
	
	
	
	
	

	function set_store_city_state($city) {
	    $this->store_city_state = stripslashes($city);
	}

	function set_store_company($company) {
	    $this->store_company = stripslashes($company);
	}

	function get_store_company() {
	    return $this->store_company;
	}

	function set_store_dob($dob) {
	    $this->store_dob = $dob;
	}

	function get_store_dob() {
	    return $this->store_dob;
	}

	function set_store_telephone($phone) {
	    $this->store_telephone = $phone;
	}

	function get_store_telephone() {
	    return $this->store_telephone;
	}	

	function set_store_fax($fax) {
	    $this->store_fax = $fax;
	}

	function get_store_fax() {
	    return $this->store_fax;
	}

	function set_store_name($name) {
	    $this->store_name = stripslashes($name);
	}
	
	function set_store_owner($owner) {
		$this->store_owner = stripslashes($owner);
	}
	function get_store_owner() {
		return $this->store_owner;
	}

	function get_store_name() {
	    return $this->store_name;
	}

	function set_store_logo($logo) {
	    $this->store_logo = $logo;
	}

	function get_store_logo() {
	    return $this->store_logo;
	}

	function set_store_id($store_id) {
	    $this->store_id = $store_id;
	}

	function get_store_id() {
	    return $this->store_id;
	}

	function set_store_zone($zone) {
	    $this->store_zone = $zone;
	}

	function get_store_zone() {
	    return $this->store_zone;
	}

	function set_store_owner_email_address($email) {
	    $this->store_owner_email_address = $email;
	}

	function get_store_owner_email_address() {
		return $this->store_owner_email_address;
	}

	function set_email_from($from) {
	    $this->email_from = $from;
	}

	function set_store_country($country) {
	    $this->store_country = stripslashes($country);
	}

	function get_store_country() {
	    return $this->store_country;
	}

	function set_store_name_address($address) {
	    $this->store_name_address = stripslashes($address);
	}

	function get_store_name_address() {
	    return $this->store_name_address;
	}			  

	function set_shipping_origin_country($country) {
	    $this->shipping_origin_country = $country;
	}

	function get_shipping_origin_country() {
		return $this->shipping_origin_country;
	}

	function set_shipping_origin_zip($zip) {
		$this->shipping_origin_zip = $zip;
	}

	function get_shipping_origin_zip() {
		return $this->shipping_origin_zip;
	}

	function is_store_owner($customer_id) {
		return (((int)$customer_id == (int)$this->store_customer_id) ? true : false);
	}

	function set_db_tables() {
		define('DIR_WS_BODY', DIR_WS_INCLUDES . 'body/' . $this->get_store_type_name() . '/');
		define('DIR_WS_JAVA', DIR_WS_INCLUDES . 'java/');
		require(DIR_WS_INCLUDES . $this->get_store_type_name() . '_filenames.php');
		define('DIR_WS_ADMIN',  DIR_WS_HTTP_CATALOG . 'mall_admin/');
		if((int)$this->store_group_id > 2){
		    define('DIR_WS_IMAGES', 'images/'. $this->store_id . '_images/');
		}else{
		    define('DIR_WS_IMAGES', 'images/1_images/');
		}
		define('DIR_WS_CATALOG_IMAGES', DIR_WS_CATALOG . 'images/'. $this->store_id . '_images/');
		define('DIR_WS_STORE_CATALOG', $this->get_store_type_name() . '/');
		define('DIR_WS_ICONS', DIR_WS_IMAGES . 'icons/');
		define('DIR_FS_CATALOG_IMAGES', DIR_FS_CATALOG .'images/'. $this->store_id . '_images/');		

  define('TABLE_STORE_MAIN','store_main');
  define('TABLE_ADMIN_GROUPS', 'admin_groups');
  define('TABLE_STORE_TYPES', 'store_types');
  define('TABLE_STORE_DESCRIPTION', 'store_description');

	}

	function smn_set_store_status($store_status){   
		global $store_registered;
		if ($store_status != 1)	{
			return ($store_registered = FALSE);
		}else{
			return ($store_registered = TRUE);
		}
	}

	function smn_set_store_type ($store_type = 1){
	  $store_type_query = smn_db_query("select st.store_types_name from " . TABLE_ADMIN_GROUPS . " ag,  " . TABLE_STORE_TYPES . " st where ag.admin_groups_store_type = st.store_types_id and ag.admin_groups_id = '" . $store_type ."'");
	  $store_type = smn_db_fetch_array($store_type_query);
          $this->$store_type['store_types_name'] = $store_type['store_types_name'];
	  return $store_type['store_types_name'];
	}
        
	function smn_new_store_type ($new_store_type = 1){
	  $store_type_query = smn_db_query("select store_types_name from " . TABLE_STORE_TYPES . " where store_types_id = '" . $new_store_type ."'");
	  $store_type = smn_db_fetch_array($store_type_query);
	  return $store_type['store_types_name'];
	}
        
	function smn_set_products_id ($store_type = 1){
	  $store_products_id_query = smn_db_query("select admin_groups_products_id from " . TABLE_ADMIN_GROUPS . " where admin_groups_id = '" . $store_type ."'");
	  $store_products_id = smn_db_fetch_array($store_products_id_query);
	  return $store_products_id['admin_groups_products_id'];
	}
        
	function smn_set_store_cost ($store_type = 1){
	  $store_cost_query = smn_db_query("select p.products_price from " . TABLE_ADMIN_GROUPS . " ag,  " . TABLE_PRODUCTS . " p where ag.admin_groups_products_id = p.products_id and ag.admin_groups_store_type = '" . $store_type ."'");
	  $store_cost = smn_db_fetch_array($store_cost_query);
	  return $store_cost['products_price'];
	}
        
	function smn_get_store_names ($store_id = 1){        
		$store_names_array = array(array('id' => '0', 'text' => TEXT_NONE));
		$where = '';
		if ($store_id > 1){
			$where = " where store_id = '" . $store_id . "'";
		}
		$store_names_query = smn_db_query("select store_id, store_name from " . TABLE_STORE_DESCRIPTION . $where);
		while ($store_name_= smn_db_fetch_array($store_names_query)) {
		    $store_names_array[] = array('id' => $store_names['store_id'], 'text' => $store_names['store_name']);
		}
		return $store_names_array;          
	}
	
////
//Return 'true' or 'false' value to display boxes and files in index.php and column_left.php
	function smn_admin_check_boxes($filename, $boxes='') {
	  global $login_groups_id;
	  
	  $is_boxes = 1;
	  if ($boxes == 'sub_boxes') {
		$is_boxes = 0;
	  }
	  $dbquery = smn_db_query("select admin_files_id from " . TABLE_ADMIN_FILES . " where FIND_IN_SET( '" . $login_groups_id . "', admin_groups_id) and admin_files_is_boxes = '" . $is_boxes . "' and admin_files_name = '" . $filename . "'");
	  
	  $return_value = false;
	  if (smn_db_num_rows($dbquery)) {
		$return_value = true;
	  }
	  return $return_value;
	}

	function smn_admin_check_page_tabs($pageName, $tabName) {
	  global $login_groups_id;
	  $Qcheck = smn_db_query("select admin_files_id from " . TABLE_ADMIN_FILES . " where FIND_IN_SET( '" . $login_groups_id . "', admin_groups_id) and admin_files_is_boxes = '0' and admin_files_name = '" . $pageName . "'");
	  if (smn_db_num_rows($Qcheck)){
	      $check = smn_db_fetch_array($Qcheck);
	      $Qcheck2 = smn_db_query("select admin_files_id from " . TABLE_ADMIN_FILES . " where FIND_IN_SET( '" . $login_groups_id . "', admin_groups_id) and admin_files_is_boxes = '0' and admin_files_is_tab = '1' and admin_tabs_to_files = '" . $check['admin_files_id'] . "' and admin_files_name = '" . $tabName . "'");
	      if (smn_db_num_rows($Qcheck2)){
	          return true;
	      }else{
	          return false;
	      }
	  }else{
	      return false;
	  }
	  
	  
	  $return_value = false;
	  if (smn_db_num_rows($dbquery)) {
		$return_value = true;
	  }
	  return $return_value;
	}

	function smn_selected_file($filename) {
	  global $login_groups_id;
	  $randomize = FILENAME_ADMIN_ACCOUNT;
	  
	  $dbquery = smn_db_query("select admin_files_id as boxes_id from " . TABLE_ADMIN_FILES . " where FIND_IN_SET( '" . $login_groups_id . "', admin_groups_id) and admin_files_is_boxes = '1' and admin_files_name = '" . $filename . "'");
	  if (smn_db_num_rows($dbquery)) {
		$boxes_id = smn_db_fetch_array($dbquery);
		$randomize_query = smn_db_query("select admin_files_name from " . TABLE_ADMIN_FILES . " where FIND_IN_SET( '" . $login_groups_id . "', admin_groups_id) and admin_files_is_boxes = '0' and admin_files_to_boxes = '" . $boxes_id['boxes_id'] . "'");
		if (smn_db_num_rows($randomize_query)) {
		  $file_selected = smn_db_fetch_array($randomize_query);
		  $randomize = $file_selected['admin_files_name'];
		}
	  }
	  return $randomize;
	}
	
	////
	//Return files stored in box that can be accessed by user
	function smn_admin_files_boxes($filename, $sub_box_name, $linkParams = '', $ajaxLink = false, $useAnchor = '') {
	  global $login_groups_id;
	  $sub_boxes = '';
	  
	  $dbquery = smn_db_query("select admin_files_name from " . TABLE_ADMIN_FILES . " where FIND_IN_SET( '" . $login_groups_id . "', admin_groups_id) and admin_files_is_boxes = '0' and admin_files_name = '" . $filename . "'");
	  if (smn_db_num_rows($dbquery)) {
		$sub_boxes = array(
		    'text'   => $sub_box_name,
		    'link'   => smn_href_link($filename, $linkParams),
		    'ajax'   => $ajaxLink
		);
	  }
	  return $sub_boxes;
	}

  function smn_get_store_category_tree($store_parent_id = '0', $spacing = '', $exclude = '', $store_category_tree_array = '', $include_itself = false) {
    global $languages_id;

    if (!is_array($store_category_tree_array)) $store_category_tree_array = array();
    if ( (sizeof($store_category_tree_array) < 1) && ($exclude != '0') ) $store_category_tree_array[] = array('id' => '0', 'text' => 'Top');

    if ($include_itself) {
      $store_category_query = smn_db_query("select cd.store_categories_name from " . TABLE_STORE_CATEGORIES_DESCRIPTION . " cd where cd.language_id = '" . (int)$languages_id . "' and cd.store_categories_id = '" . (int)$store_parent_id . "'");
      $store_category = smn_db_fetch_array($store_category_query);
      $store_category_tree_array[] = array('id' => $store_parent_id, 'text' => $store_category['store_categories_name']);
    }

    $store_categories_query = smn_db_query("select c.store_categories_id, cd.store_categories_name, c.store_parent_id from " . TABLE_STORE_CATEGORIES . " c, " . TABLE_STORE_CATEGORIES_DESCRIPTION . " cd where c.store_categories_id = cd.store_categories_id and cd.language_id = '" . (int)$languages_id . "' and c.store_parent_id = '" . (int)$store_parent_id . "' order by c.sort_order, cd.store_categories_name");
    while ($store_categories = smn_db_fetch_array($store_categories_query)) {
      if ($exclude != $store_categories['store_categories_id']) $store_category_tree_array[] = array('id' => $store_categories['store_categories_id'], 'text' => $spacing . $store_categories['store_categories_name']);
      $store_category_tree_array = $this->smn_get_store_category_tree($store_categories['store_categories_id'], $spacing . '&nbsp;&nbsp;&nbsp;', $exclude, $store_category_tree_array);
    }

    return $store_category_tree_array;
  }

  ////
// Count how many subcategories exist in a category
// TABLES: categories
  function smn_childs_in_store_category_count($store_categories_id) {
    $store_categories_count = 0;

    $store_categories_query = smn_db_query("select store_categories_id from " . TABLE_STORE_CATEGORIES . " where store_parent_id = '" . (int)$store_categories_id . "'");
    while ($store_categories = smn_db_fetch_array($store_categories_query)) {
      $store_categories_count++;
      $store_categories_count += $this->smn_childs_in_store_category_count($store_categories['store_categories_id']);
    }

    return $store_categories_count;
  }

  function smn_store_in_category_count($store_categories_id, $include_deactivated = false) {
    $stores_count = 0;

    if ($include_deactivated) {
      $store_query = smn_db_query("select count(*) as total from " . TABLE_STORE_MAIN . " s, " . TABLE_STORE_TO_CATEGORIES . " s2c where s.store_id = s2c.store_id and s2c.store_categories_id = '" . (int)$store_categories_id . "'");
    } else {
      $store_query = smn_db_query("select count(*) as total from " . TABLE_STORE_MAIN . " s, " . TABLE_STORE_TO_CATEGORIES . " s2c where s.store_id = s2c.store_id and s.store_status = '1' and s2c.store_categories_id = '" . (int)$store_categories_id . "'");
    }

    $store = smn_db_fetch_array($store_query);

    $store_count += $store['total'];

    $childs_query = smn_db_query("select store_categories_id from " . TABLE_STORE_CATEGORIES . " where store_parent_id = '" . (int)$store_categories_id . "'");
    if (smn_db_num_rows($childs_query)) {
      while ($childs = smn_db_fetch_array($childs_query)) {
        $store_count += $this->smn_store_in_category_count($childs['store_categories_id'], $include_deactivated);
      }
    }
    return $store_count;
  }

  function smn_get_spath($current_store_category_id = '') {
    global $sPath_array;

    if ($current_store_category_id == '') {
      $sPath_new = implode('_', $sPath_array);
    } else {
      if (sizeof($sPath_array) == 0) {
        $sPath_new = $current_store_category_id;
      } else {
        $sPath_new = '';
        $last_store_category_query = smn_db_query("select store_parent_id from " . TABLE_STORE_CATEGORIES . " where store_categories_id = '" . (int)$sPath_array[(sizeof($sPath_array)-1)] . "'");
        $last_store_category = smn_db_fetch_array($last_store_category_query);

        $current_store_category_query = smn_db_query("select store_parent_id from " . TABLE_STORE_CATEGORIES . " where store_categories_id = '" . (int)$current_store_category_id . "'");
        $current_store_category = smn_db_fetch_array($current_store_category_query);

        if ($last_store_category['store_parent_id'] == $current_store_category['store_parent_id']) {
          for ($i = 0, $n = sizeof($sPath_array) - 1; $i < $n; $i++) {
            $sPath_new .= '_' . $sPath_array[$i];
          }
        } else {
          for ($i = 0, $n = sizeof($sPath_array); $i < $n; $i++) {
            $sPath_new .= '_' . $sPath_array[$i];
          }
        }

        $sPath_new .= '_' . $current_store_category_id;

        if (substr($sPath_new, 0, 1) == '_') {
          $sPath_new = substr($sPath_new, 1);
        }
      }
    }
   return 'sPath=' . $sPath_new;
  }

  function smn_get_store_category_name($store_category_id, $language_id) {
    $store_category_query = smn_db_query("select store_categories_name from " . TABLE_STORE_CATEGORIES_DESCRIPTION . " where store_categories_id = '" . (int)$store_category_id . "' and language_id = '" . (int)$language_id . "'");
    $store_category = smn_db_fetch_array($store_category_query);
    return $store_category['store_categories_name'];
  }

  function smn_get_store_category_description($store_category_id, $language_id) {
    $store_category_query = smn_db_query("select store_categories_description from " . TABLE_STORE_CATEGORIES_DESCRIPTION . " where store_categories_id = '" . (int)$store_category_id . "' and language_id = '" . (int)$language_id . "'");
    $store_category = smn_db_fetch_array($store_category_query);
    return $store_category['store_categories_description'];
  }

}
?>