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
		$store_query = smn_db_query("select sm.*, sd.store_description, sd.store_name, a.admin_groups_id from " . TABLE_STORE_MAIN . " sm, " . TABLE_STORE_DESCRIPTION . " sd, " . TABLE_ADMIN . " a WHERE sm.store_id = '". $this->store_id ."' and sd.store_id = '". $this->store_id ."' and a.store_id = '". $this->store_id ."'");
		if (smn_db_num_rows($store_query) == 0){
		    $this->store_id = 1;
		    $store_query = smn_db_query("select sm.*, sd.store_description, sd.store_name, a.admin_groups_id from " . TABLE_STORE_MAIN . " sm, " . TABLE_STORE_DESCRIPTION . " sd, " . TABLE_ADMIN . " a WHERE sm.store_id = '1' and sd.store_id = '1' and a.store_id = '1' LIMIT 1");	
		}
		$store_array = smn_db_fetch_array($store_query);
		$store_info_query = smn_db_query("select c.*, ab.* from " . TABLE_CUSTOMERS . " c, " . TABLE_ADDRESS_BOOK . " ab WHERE c.customers_id = '". $store_array['customer_id'] ."' and c.customers_id = ab.customers_id and c.customers_default_address_id = ab.address_book_id LIMIT 1");
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
		
		$state_name_query = smn_db_query("select zone_name from " . TABLE_ZONES . " where zone_id = '" . (int)$store_info_array['entry_zone_id'] . "' LIMIT 1");
	        $state_name_value = smn_db_fetch_array($state_name_query);
		$state = $state_name_value['zone_name'];
		
		$country_query = smn_db_query("select countries_name from " . TABLE_COUNTRIES . " where countries_id = '" . (int)$store_info_array['entry_country_id'] . "' LIMIT 1");
	        $country_name = smn_db_fetch_array($country_query);
		$country = $country_name['countries_name'];
		
		$this->set_store_name_address($this->get_store_name() . "<br />" . $store_info_array['entry_street_address'] . "<br />"  . $store_info_array['entry_city']. "<br />" . $state . "<br />" . $country . "<br />" . $store_info_array['entry_postcode']. "<br />");
		$this->set_shipping_origin_country($store_info_array['entry_country_id']);
		$this->set_shipping_origin_zip($store_info_array['entry_postcode']);
		$this->set_store_type((int)$store_array['store_type']);
		$this->set_store_description($store_array['store_description']);
		$this->set_store_status((int)$store_array['store_status']);
	}

  // set the mall application parameters

	function set_store_parameters() {
	    $use_store_configuration = $this->store_id;
		/*Changed the query to display the orders placed from substores in the account history by Cimi*/
	    /*$configuration_query = smn_db_query("select store_id, configuration_key as cfgKey, configuration_value as cfgValue from " . TABLE_CONFIGURATION . " where store_id ='" . $use_store_configuration ."' or store_id = '0'");*/
	    $configuration_query = smn_db_query("select store_id, configuration_key as cfgKey, configuration_value as cfgValue from " . TABLE_CONFIGURATION . " where store_id ='" . $use_store_configuration ."' or store_id='0' order by store_id desc");
	    while ($configuration = smn_db_fetch_array($configuration_query)) {
		define($configuration['cfgKey'], $configuration['cfgValue']);
	    }
	    define('DIR_WS_EXT', 'ext/');
	}
        
	function set_store_customer_id($store_customer_id) {
	    $this->store_customer_id = $store_customer_id;
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
        
	function set_store_group_id($group_id) {
		$this->store_group_id = (int)$group_id;
	}
        
	function set_store_type($store_type = 1) {
	  $store_type_query = smn_db_query("select st.store_types_name from " . TABLE_ADMIN_GROUPS . " ag,  " . TABLE_STORE_TYPES . " st where ag.admin_groups_store_type = st.store_types_id and ag.admin_groups_id = '" . $store_type ."'");
	  $store_type_name = smn_db_fetch_array($store_type_query);
	  $this->store_type = $store_type_name['store_types_name'];
	}

	function get_store_type() {
		return $this->store_type;
	}

	function get_store_type_name() {
		$row = smn_db_fetch_array(smn_db_query("SELECT store_types_name FROM " . TABLE_STORE_TYPES . " WHERE store_types_id='" . $this->store_type . "' LIMIT 1"));
		return $row['store_types_name'];
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
	    $this->shipping_origin_country = stripslashes($country);
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

	function set_store_variables( $store_type = 'retail') {
		define('DIR_WS_BODY', DIR_WS_INCLUDES . 'body/' . $store_type . '/');
		define('DIR_WS_JAVA', DIR_WS_INCLUDES . 'java/');
		require(DIR_WS_INCLUDES . $store_type . '_filenames.php');
		define('DIR_WS_ADMIN',  DIR_WS_HTTP_CATALOG . 'mall_admin/');
	        define('DIR_WS_IMAGES', 'images/1_images/');
		define('DIR_WS_CATALOG_IMAGES', 'images/'. $this->store_id . '_images/');
		define('DIR_WS_STORE_CATALOG', $store_type . '/');
		define('DIR_WS_ICONS', DIR_WS_IMAGES . 'icons/');
		define('DIR_FS_CATALOG_IMAGES', DIR_FS_CATALOG .'images/'. $this->store_id . '_images/');		
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
}

?>