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

class customer {

	var $customer_data, 
	    $address_data,
	    $errno,
	    $gender,
	    $dob,
	    $firstname,
	    $lastname,
	    $email_address,
	    $telephone,
	    $fax,
	    $newsletter,
	    $password,
	    $street_address,
	    $postcode,
	    $city,
	    $country_id,
	    $company,
	    $zone_id,
	    $state,
	    $customer_id,
	    $address_id;
//constructor

	function customer($customer_id=0) {
		//set the customer id 
		$this->customer_data = array();
		$this->address_data = array();
		$this->errno = 0;
		$this->zone_id = 0;
		// customer_id=0 means we are going to add a new customer
		if ($customer_id != 0) {
		    $this->customer_id = $customer_id;
		    $this->query($customer_id);
		}
	}

	function create($customers_id = 0) {

		//if customer is 0, then is a new account...(needs to be added in for editing)
		//add data for table customers which hold most of the primary customers info
		$sql_data_array = array('customers_firstname' => $this->firstname,
					'customers_lastname' => $this->lastname,
					'customers_email_address' => $this->email_address,
					'customers_telephone' => $this->telephone,
					'customers_fax' => $this->fax,
					'customers_newsletter' => $this->newsletter,
					'customers_gender' => $this->gender,
					'customers_dob' => $this->dob);

		if($customers_id == 0){
			$sql_data_array['customers_password'] = $this->password;
			smn_db_perform(TABLE_CUSTOMERS, $sql_data_array);
			$this->customer_id = smn_db_insert_id();  //primary KEY for customer
		}else{
			smn_db_perform(TABLE_CUSTOMERS, $sql_data_array, 'update', 'customers_id=' . (int)$customers_id);
			$this->customer_id = (int)$customers_id;
		}
	//start building array for adress book entries using the default address given on sign up  
		$sql_data_array = array('customers_id' => $this->customer_id,
					'entry_firstname' => $this->firstname,
					'entry_lastname' => $this->lastname,
					'entry_company' => $this->company,
					'entry_street_address' => $this->street_address,
					'entry_postcode' => $this->postcode,
					'entry_city' => $this->city,
					'entry_country_id' => $this->country_id,
					'entry_gender' => $this->gender,
					'entry_zone_id' => $this->zone_id,
					'entry_state' => $this->state);
		if($customers_id == 0){
			smn_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array);
			$this->address_id = smn_db_insert_id();
			smn_db_query("update " . TABLE_CUSTOMERS . " set customers_default_address_id = '" . (int)$this->address_id . "' where customers_id = '" . (int)$this->customer_id . "'");
			smn_db_query("insert into " . TABLE_CUSTOMERS_INFO . " (customers_info_id, customers_info_number_of_logons, customers_info_date_account_created) values ('" . (int)$this->customer_id . "', '0', now())");
		}else{
			smn_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array, 'update', 'customers_id=' . (int)$customers_id);
			smn_db_query("update " . TABLE_CUSTOMERS_INFO . " set customers_info_date_account_last_modified = now() where customers_info_id = '" . (int)$customer_id . "'");
		}
		if (SESSION_RECREATE == 'True') {
			smn_session_recreate();
		}
		return $this->customer_id;
	}

	function set_company($company_name) {
		$this->company = smn_db_prepare_input(addslashes($company_name) );
	}
        
	function set_zone_id($zone) {
		$this->zone_id = smn_db_prepare_input($zone);
	}

	function set_state($state_name) {
		$this->state = smn_db_prepare_input($state_name);
	}

	function set_street_address($street_address) {
		$this->street_address = smn_db_prepare_input(addslashes($street_address) );
	}

	function set_postcode($zip_code) {
		$this->postcode = smn_db_prepare_input($zip_code);
	}

	function set_city($city_name) {
		$this->city = smn_db_prepare_input(addslashes($city_name) );
	}
	function set_country_id($country_iso_code) {
		$this->country_id = smn_db_prepare_input($country_iso_code);
	}
        
	function set_gender($gender) {
		$this->gender = smn_db_prepare_input($gender);
	}
	function set_dob($birth_date) {
		$this->dob = smn_db_prepare_input($birth_date);
	}

	function set_firstname($first_name) {
		$this->firstname = smn_db_prepare_input(addslashes($first_name) );

	}

	function set_lastname($last_name) {
		$this->lastname = smn_db_prepare_input(addslashes($last_name) );
	}

	function set_email_address($email_address) {
		$this->email_address = smn_db_prepare_input($email_address);
	}

	function set_telephone($phone_number) {
		$this->telephone = smn_db_prepare_input($phone_number);
	}

	function set_fax($fax_number) {
		$this->fax= smn_db_prepare_input($fax_number);
	}

	function set_newsletter($subscribe) {
		$this->newsletter = smn_db_prepare_input($subscribe);
	}

	function set_password($password, $encrypted = false) {
		if (!$encrypted) 
		    $this->password = smn_encrypt_password($password);
		else
		    $this->password = $password;
	}
	
	function query($customer_id) {
		$qry1 = smn_db_query("SELECT * FROM " . TABLE_CUSTOMERS . " WHERE customers_id= '" . $customer_id . "'");
		if (smn_db_num_rows($qry1) > 0) {
			$this->customer_data = smn_db_fetch_array($qry1);
			$this->address_id = $this->customers_data['customers_default_address_id'];
			$qry2 = smn_db_query("SELECT * FROM " . TABLE_ADDRESS_BOOK . " WHERE address_book_id='" . $this->customers_data['customers_default_address_id'] . "'");
			if (smn_db_num_rows($qry2) > 0) {
				$this->address_data = smn_db_fetch_array($qry2);
			}else {
				$this->errno = 2;
			}
		}else {
			$this->errno = 1;
		}
	}
}
?>