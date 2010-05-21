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

class store {
	var $store_type,
	    $store_customers_id,
	    $store_id,
	    $store_name,
	    $store_description,
	    $store_customers_data,
	    $store_header,
	    $store_logo,
	    $store_logo_image_name,
	    $store_category;
                
	function store($store_id = 0) {
		// store_id=0 and $customers_id=0 means we are going to add a new store
		if ($store_id == 0) {
			$this->store_type = 2;
			$this->store_category = 0;
			$this->store_customers_id = 0;
			$this->store_id = 0;
			$this->store_name = '';
			$this->store_description = '';
			$this->store_customers_data = array();
			$this->store_logo = '';
			$this->store_logo_image_name = 'logo.gif';
		}
		
		// $store_id=0 and $customers_id!=0 means we want to load the store corresponding to the passed customers_id
		if (!$store_id == 0) {
			$qry_store = smn_db_query("SELECT sn.*, sd.store_name, sd.store_description FROM " . TABLE_STORE_MAIN . " sn, " . TABLE_STORE_DESCRIPTION . " sd WHERE sn.store_id=sd.store_id AND sn.store_id='" . (int)$store_id . "'");
			if (smn_db_num_rows($qry_store) > 0) {
				$store = smn_db_fetch_array($qry_store);
				$this->store_id = $store_id;
				$this->set_store_type($store['store_type']);
				$this->set_store_name($store['store_name']);
				$this->set_store_description($store['store_description']);
			}
		}
	}

	function update_store_type() {
		$sql_array = array('customer_id' => $this->get_customers_id(),
				   'store_type' => $this->store_type);
		smn_db_perform(TABLE_STORE_MAIN, $sql_array, 'update', 'store_id=' . $this->store_id);
	}
	
	function update_store_info() {
		$sql_array = array('store_name' => $this->store_name,
				   'store_description' => $this->store_description);
		smn_db_perform(TABLE_STORE_DESCRIPTION, $sql_array, 'update', 'store_id=' . $this->store_id);			
	}

	function create_store($use_store_id = 0) {
		$this->store_id = $use_store_id;
		
		$sql_store_array = array('customer_id' => $this->get_customers_id(),
					'store_status' => ((DISPLAY_STORE_IMMEDIATELY == 'true') ? 1 : 0 ),
					'date_added' => date('Ymd'),
                             		'store_type' => $this->store_type);
		if($this->store_id == 0){
			smn_db_perform(TABLE_STORE_MAIN, $sql_store_array);
			$this->store_id = smn_db_insert_id();
			return $this->store_id;
		}else{
			smn_db_perform(TABLE_STORE_MAIN, $sql_store_array, 'update', 'store_id=' . $this->store_id);
			return $this->store_id;	
		}
	}

	function put_logo_image($action = '') {
		$newname = DIR_FS_CATALOG .'images/' . $this->store_id . '_images';
		if(!is_dir($newname)){
			mkdir($newname);
		}
		$allowed_files_types = array('gif', 'jpg', 'png');
		if (is_dir($newname)) {
			$store_logo_image = new upload($this->store_logo);
			$store_logo_image->set_destination($newname);
			$store_logo_image->set_extensions($allowed_files_types);        
			$parsed = $store_logo_image->parse();
			if ((!$parsed) && ($action == '')) {
			    if (copy(DIR_FS_CATALOG.'images/store_images/default/default_store_logo.gif', $newname.'/default_store_logo.gif')) {
				smn_db_query("update " . TABLE_STORE_MAIN . " set store_image = 'default_store_logo.gif' where store_id = '" . (int)$this->store_id . "'");
			    }
			}else{
			    if (($store_logo_image->file['size'] > MAX_IMAGE_FILE_SIZE) &&  ($parsed)){
				if (copy(DIR_FS_CATALOG.'images/store_images/default/default_store_logo.gif', $newname.'/default_store_logo.gif')) {
				    smn_db_query("update " . TABLE_STORE_MAIN . " set store_image = 'default_store_logo.gif' where store_id = '" . (int)$this->store_id . "'");
				}
				return sprintf(ERROR_IMAGE_FILE_SIZE_EXCEED, MAX_IMAGE_FILE_SIZE);
			    }elseif ($parsed) {
				$ext = (substr($store_logo_image->filename, -4));
				$store_logo_image->set_filename('logo' . $ext);
				$saved = $store_logo_image->save();
				if ($saved) {
				    smn_db_query("update " . TABLE_STORE_MAIN . " set store_image = '" . $store_logo_image->filename . "' where store_id = '" . (int)$this->store_id . "'");
				}elseif($action == '') {
                                    $this->store_logo_image_name = ''; 
				    if (copy(DIR_FS_CATALOG.'images/store_images/default/default_store_logo.gif', $newname.'/default_store_logo.gif')) {
					smn_db_query("update " . TABLE_STORE_MAIN . " set store_image = 'default_store_logo.gif' where store_id = '" . (int)$this->store_id . "'");
				    }
				}
			    }
			}
		} else {
		    return ERROR_CATALOG_IMAGE_DIRECTORY_DOES_NOT_EXIST;
		}
		return '';
	}
        
	function put_store_description() {
		global $languages_id;
	    $sql_data_array = array('store_name' => $this->store_name,
                            	    'store_description' => $this->store_description,
                            	    'store_id' => $this->store_id,
                            	    'language_id' => $languages_id);
	    smn_db_perform(TABLE_STORE_DESCRIPTION, $sql_data_array);		
	}

	function put_store_category() {
	    smn_db_query("insert into " . TABLE_STORE_TO_CATEGORIES . " (store_id, store_categories_id) values ('" . (int)$this->store_id . "', '" . (int)$this->store_category . "')");
	}	

	function put_store_admin() {

		$sql_data_array = array('admin_groups_id' => $this->store_type,
					'admin_firstname' => $this->store_customers_data['customers_firstname'],
					'admin_lastname' => $this->store_customers_data['customers_lastname'],
					'store_id' => $this->store_id,
					'customer_id' => $this->get_customers_id(),
					'admin_email_address' => $this->store_customers_data['customers_email_address'],
					'admin_password' => $this->store_customers_data['customers_password'],
					'admin_created' => date('Ymd'));
		smn_db_perform(TABLE_ADMIN, $sql_data_array);
	}
        
	function put_store_data() {
		require(DIR_WS_FUNCTIONS . $this->get_store_type() . '_store_sql.php');
		
		$newname = DIR_FS_CATALOG .'images/' . $this->store_id . '_images';
		$oldname = DIR_FS_CATALOG .'images/store_images';
		//$images_directory = my_dir_copy($oldname, $newname);

		$data = array('store_name' => $this->store_name,
			      'store_owner_firstname' => $this->store_customers_data['customers_firstname'],
			      'store_logo' => $store_logo_image_name,
			      'store_owner_lastname' => $this->store_customers_data['customers_lastname'],
			      'email_address' => $this->store_customers_data['customers_email_address'],
			      'country' => $this->store_customers_data['country'],
			      'street_address' => $this->store_customers_data['entry_street_address'],
			      'city' => $this->store_customers_data['entry_city'],
			      'postal_code' => $this->store_customers_data['entry_postcode'],
			      'store_id' => $this->store_id);
		$data_inserted = insert_data($data);
	}

	function put_store_language($language_type = 'english') {		
		require(DIR_WS_LANGUAGES . 'install/' . $language_type . '_install.php');
		$language_array = explode(',', smn_language_info ());
		$name = smn_db_prepare_input($language_array[0]);
		$code = smn_db_prepare_input($language_array[1]);
		$image = smn_db_prepare_input($language_array[2]);
		$directory = smn_db_prepare_input($language_array[3]);
		$new_language_id = 1; 
		$sort_order = 1;
		smn_db_query("insert into languages (store_id, languages_id, name, code, image, directory, sort_order) values ('" . smn_db_input($prefix) . "', '" . smn_db_input($new_language_id) . "', '" . smn_db_input($name) . "', '" . smn_db_input($code) . "', '" . smn_db_input($image) . "', '" . smn_db_input($directory) . "', '" . smn_db_input($sort_order) . "')");
		smn_install_language ($new_language_id, $prefix);
	}

	function put_store_cost() {
		global $store;
		$sql_costs_data_array = array('store_id' => $this->store_id,
					      'monthly_costs' => $store->smn_set_store_cost($this->store_type));
		smn_db_perform(TABLE_STORE_COSTS, $sql_costs_data_array);
	}

	function put_store_products() {
		global $cart, $store;
		$store_products_id = $store->smn_set_products_id($this->store_type);
		$product_model_query = smn_db_query("select products_model from " . TABLE_PRODUCTS . " where products_id = '" . (int)$store_products_id . "'");
		$product_model = smn_db_fetch_array($product_model_query);
		$member_product = explode('_', $product_model['products_model']);
		$start_day = getdate();
		$day = $start_day['mday'];
		$month = $start_day['mon'];
		$year = $start_day['year'];
		$product_end_date = strftime('%Y',mktime(0,0,0, $month + (int)$member_product[1], $day, $year)) . '-' . strftime('%m',mktime(0,0,0, $month + (int)$member_product[1], $day, $year)) . '-' . strftime('%d',mktime(0,0,0, $month + (int)$member_product[1], $day, $year));
		$sql_data_array = array('store_id' => $this->store_id,
					'products_id' => $store_products_id, 
					'customer_id' => $this->get_customers_id(), 
					'products_end_date' => $product_end_date); 
		smn_db_perform(TABLE_MEMBER_ORDERS, $sql_data_array);

		$customer_first_name = $this->store_customers_data['customers_firstname'];
		$customer_default_address_id = $this->store_customers_data['customers_default_address_id'];
		$customer_country_id = $this->store_customers_data['entry_country_id'];
		$customer_zone_id = $this->store_customers_data['entry_zone_id'];
		$name = $this->store_customers_data['customers_firstname'] . ' ' . $this->store_customers_data['customers_lastname'];

        //add to the cart now......
		$cart->add_cart($store_products_id, $cart->get_quantity($store_products_id)+1);

        // restore cart contents
	$cart->restore_contents();
	}

	function send_store_email($gender) {
	    global $store;
	    // include the mail classes
	    //require(DIR_WS_CLASSES . 'mime.php');
	    //require(DIR_WS_CLASSES . 'email.php');
            
	    $name = $this->store_customers_data['customers_firstname'] . ' ' . $this->store_customers_data['customers_lastname'];
	    if ($gender == 'm') {
		$email_text = EMAIL_GREET_MR . ' ' . $name . "\n\n";
	    } elseif ($gender == 'f'){
		$email_text = EMAIL_GREET_MS . ' ' . $name . "\n\n";
	    } else{
		$email_text = EMAIL_GREET_NONE . ' ' . $name . ' ' . $this->store_customers_data['customers_lastname'] . "\n\n";
	    }
    	//email new store owner
        $email_text .= EMAIL_WELCOME . EMAIL_TEXT . EMAIL_STORE_CONTACT . EMAIL_STORE_WARNING;
	smn_mail($name, $this->store_customers_data['customers_email_address'], EMAIL_SUBJECT, $email_text, MALL_NAME, MALL_EMAIL_ADDRESS);
    	//email mall owner
	smn_mail(MALL_NAME, MALL_EMAIL_ADDRESS, EMAIL_SUBJECT, $email_text, MALL_NAME, MALL_EMAIL_ADDRESS);
	}	

	function set_store_type($store_type) {
	  $this->store_type = (int)$store_type;
	}

	function get_store_type() {
//	  $sql = "select st.store_types_name from " . TABLE_ADMIN_GROUPS . " ag,  " . TABLE_STORE_TYPES . " st where ag.admin_groups_store_type = st.store_types_id and ag.admin_groups_id = '" . $this->store_type ."'";
	  $sql = "select st.store_types_name from " . TABLE_STORE_TYPES . " st where st.store_types_id = " . $this->store_type;	  
	  $store_type_query = smn_db_query($sql);
	  $store_type = smn_db_fetch_array($store_type_query);
	  return $store_type['store_types_name'];
	}

	function set_store_logo($store_image) {
		$this->store_logo = $store_image;
	}

	function set_store_name($name) {
		$this->store_name = smn_db_prepare_input(addslashes($name) );
	}

	function set_store_category($category) {
		$this->store_category = $category;
	}

	function set_store_description($desc) {
		$this->store_description = smn_db_prepare_input(addslashes($desc) );
	}



	function set_customers_data($customer_id = '') {
		$qry = smn_db_query("SELECT * FROM " . TABLE_CUSTOMERS . " WHERE customers_id='" . $this->get_customers_id() . "'");
		if (smn_db_num_rows($qry) > 0) {
		    $row1 = smn_db_fetch_array($qry);
		    $qry = smn_db_query("SELECT * FROM " . TABLE_ADDRESS_BOOK . " WHERE address_book_id='" . $row1['customers_default_address_id'] . "'");
		    if (smn_db_num_rows($qry) > 0) {
			$row2 = smn_db_fetch_array($qry);
			if ($row2['entry_country_id'] > 0) {
			    $r = smn_db_fetch_array(smn_db_query("SELECT * FROM " . TABLE_COUNTRIES . " WHERE countries_id='" . $row2['entry_country_id'] . "'"));
			    $row2['country'] = $r['countries_name'];
			}
			$this->store_customers_data = array_merge($row1, $row2);
		    }else {			
			$this->store_customers_data = $row1;
		    }
		}
	}	



	function set_customers_id($customer_id) {
		$this->store_customers_id = (int)$customer_id;
	}
	
	function get_customers_id() {
		return $this->store_customers_id;
	}
	
	function get_store_description() {
		return $this->store_description;
	}

	function get_store_name() {
		return $this->store_name;
	}
}

?>