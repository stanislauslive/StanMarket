<?php
// systemsmanager begin - Dec 5, 2005

define('NUM_PATH_SUGGESTIONS',5);
class store_path {
	var $db_table = TABLE_STORE_PATHS;
	var $store_path;
	var $store_path_mc;
	var $store_machinename;
  var $store_domain;
	var $store_id;
	var $path_allowed_chars = "\w-_";
	var $ERRORS = Array();
	function store_path($id="") {
	  if($id != "") {
			$this->store_id = $id;
		}
	}
	function get_store_id($path="",$host="") {
		if($path != "") {
			$this->store_path_mc = $this->path_prep($path);
			$this->store_path = strtolower($this->store_path_mc);
		}
		if($this->store_path != "") {
			$sql = "select store_id from " . $this->db_table . " WHERE store_path='" . $this->dbEscape($this->store_path) . "'";
		  if($host != "") {
				$host = preg_replace("/^https{0,1}:\/\//","",strtolower($host));
				if(preg_match("/^(.*)\.([\w\-]+\.\w{2,4})$/",$host,$MATCHES)) {
					$this->store_machinename = $MATCHES[1];
					$this->store_domain = $MATCHES[2];
			  }
			  // no need to escape these, since we did not allow ' in the preg_match
  			$sql .= " AND (store_machinename is null or store_machinename IN('','" . $this->store_machinename . "'))";
  			$sql .= " AND (store_domain is null or store_domain IN('','" . $this->store_domain . "'))";
			}
			$sql .= " AND (expires is null or expires in ('0000-00-00 00:00:00','') or expires > '" . date("Y-m-d H:i:s") . "')";
			$sql .= " order by created desc limit 1";
			if($GLOBALS['debugging'] == "Y") {
				 echo "CHECKING: $sql\n\n";
			 }
			
			$qry = smn_db_query($sql);
			if (smn_db_num_rows($qry) > 0) {
			  $row1 = smn_db_fetch_array($qry);
			  // $this->store_id = $row1['store_id'];
			  return($row1['store_id']);
			} else {
				// $this->store_id = "";
				return('');
			}
			
		} else {
			$this->store_id = "";
			return('');
		}
  }
	function get_store_path($id="",$host="") {
		if($id != "") {
			$this->store_id = $id;
		}
		if($this->store_id != "") {
			$sql = "select store_path_mc from " . $this->db_table . " WHERE store_id='" . $this->store_id . "'";
		  if($host != "") {
				$host = preg_replace("/^https{0,1}:\/\//","",strtolower($host));
				if(preg_match("/^(.*)\.([\w\-]+\.\w{2,4})$/",$host,$MATCHES)) {
					$this->store_machinename = $MATCHES[1];
					$this->store_domain = $MATCHES[2];
			  }
			  // no need to escape these, since we did not allow ' in the preg_match
  			$sql .= " AND (store_machinename is null or store_machinename IN('','" . $this->store_machinename . "'))";
  			$sql .= " AND (store_domain is null or store_domain IN('','" . $this->store_domain . "'))";
			}
			$sql .= " AND (expires is null or expires='0000-00-00 00:00:00' or expires > '" . date("Y-m-d H:i:s") . "')";
			$sql .= " order by created desc limit 1";
if($GLOBALS['debugging'] == "Y") {
  echo "get_Store_path_sql=" . $sql . "</br>\n";
}
			$qry = smn_db_query($sql);
			if (smn_db_num_rows($qry) > 0) {
			  $row1 = smn_db_fetch_array($qry);
if($GLOBALS['debugging'] == "Y") {
  echo "returnin " . $row1['store_path_mc'] . "<br>";
}
			  return($row1['store_path_mc']);
			} else {
				return('');
			}
			
		} else {
			return('');
		}
		
  }
  function is_store_path_ok($path,$myid="") {
		if($myid != "") {
			$this->store_id = $myid;
		}
		$id = $this->get_store_id($path);
		if($GLOBALS['debugging'] == "Y") {
			echo "get_store_id($path) = $id\n";
			echo "This store: " . $this->store_id . "<br>";
		}
		if( ($id != "") && ($id != $this->store_id) ) {
			return false;
		} else {
		  return true;
		}
	}
	function suggest_store_paths($path) {
		$path = $this->path_prep($path);
		$suggestions = Array();
		$kill = 0;
		$pathnum = preg_replace("/\d+$/","",$path);
		$pathyear = $pathnum . date("Y");
		if($this->is_store_path_ok($pathyear)) {
			$suggestions[] = $pathyear;
		}
		$i=0;
		while( (count($suggestions) < NUM_PATH_SUGGESTIONS) && ($kill == 0) ) {
			$i++;
			$pathnum1 = $pathnum . $i;
			$pathnum2 = $pathnum . "-" . $i;
			if($this->is_store_path_ok($pathnum1)) {
			  $suggestions[] = $pathnum1;
		  }
			if($i >= 999) {
				$kill=1; // in case the break doesnt work right
				break;
			}
	  }
	  return($suggestions);
	}
  function suggest_store_paths_radio($path="",$data=Array()) {
		if($path == "") {
			if($data['sp_store_path'] != "") {
			  $path=$data['sp_store_path'];
			} else if ($data['sp_store_path_text'] != "") {
			  $path=$data['sp_store_path_text'];
			} else {
			  $path = $this->store_path;
			}
		}
		$suggestions = $this->suggest_store_paths($path);
		$spmc = $this->get_store_path();
		$txt = '<table border="0" width="350" cellspacing="0" cellpadding="4" class=sp_table>';
		$txt .= smn_draw_form('create_store_account', $this->post_url(), 'post', ' onSubmit="/* return check_form(create_store_account); */"') .
		$txt .= smn_draw_hidden_field('action', 'set_store_path');
		$txt .= smn_draw_hidden_field('sp_store_id',$this->store_id);
		$txt .= $this->draw_hidden_session_field();
		$txt .= "<tr class=sp_header_row><td colspan=2><b>It appears the url you chose, '" . $path . "' is already in use. Please try again.</b></td></tr>";
		$txt .= "<input type=hidden name=sp_store_id value=\"". $this->store_id . "\">";
		foreach($suggestions as $thispath) {
			$txt .= "<tr class=sp_row><td><input type=radio name=sp_store_path value=\"$thispath\""; 
			if($found == 0) {
			  $found = 1;
			  $txt .= " checked defaultChecked";
			}
			
		  $txt .= " onClick=\"this.form.sp_store_path_text.value='';\"></td><td width=100%>" . HTTP_SERVER ."/" . "$thispath</td></tr>\n";
		}
    $txt .= "<tr class=sp_row><td><input type=radio name=sp_store_path id=\"freeform\" value=\"\"";
	  if($found == 0) {
			$txt .= " checked defaultChecked";
		}
	  $txt .= "></td>" . 
	    	"<td>" . HTTP_SERVER . "/" . "<input type=text name=\"sp_store_path_text\" value=\"$spmc\" onFocus=\"this.form.sp_store_path[" . count($suggestions) . "].click()\"></td></tr>\n";
	  $txt .= "<tr class=sp_footer_row><td>&nbsp;</td><td valign=top>type something else above</td></tr>";
	  $txt .= "<tr class=sp_footer_row><Td colspan=2 align=center>";
	  // $txt .= '<input type=submit name="sp" value="Submit your Store Url">'; //
	  $txt .= smn_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE);
		$txt .= "</td></tr>";
	  $txt .= "</form>";
	  $txt .= "</table>";
	  return $txt;
	}
	function store_path_radio() {
		// $this->store_id
		// $store_name,$cust_name;
	  $sql = "SELECT c.customers_firstname, c.customers_lastname,sn.customer_id, sd.store_name, sd.store_description FROM " . TABLE_STORE_MAIN . " sn, " . TABLE_STORE_DESCRIPTION . " sd, " . TABLE_CUSTOMERS . " c WHERE sn.store_id=sd.store_id AND sn.store_id='" . (int)$this->store_id . "' AND c.customers_id=sn.customer_id";
    $qry_store = smn_db_query($sql);
		if (smn_db_num_rows($qry_store) > 0) {
			$store = smn_db_fetch_array($qry_store);
			if($GLOBALS['debugging'] == "Y") echo "<pre>STORE (" . $this->store_id .")\n" . var_export($store,true) . "</pre>";
		} else {
		  $this->ERRORS[]= "Store NOT FOUND. Please Login, or contact support if you feel this is an error.";
		  if($GLOBALS['debugging'] == "Y") echo "NOTHING FOUND ON SQL: $sql\n" . $this->error_message();
		  return $this->error_message();
		}
    $store_name= $store['store_name']; //"Toys R Us";
    $cust_name= $store['customers_firstname'] . " " . $store['customers_lastname']; //"Chester Tester";
		$store_name = $this->path_prep($store_name);
		$cust_name = $this->path_prep($cust_name);
		$spmc = $this->get_store_path();
		if($spmc == "") {
			$spmc = $store_name;
		}
		if($spmc == "") {
			$spmc = $cust_name;
		}
		$found = 0;
		$txt = '<table border="0" width="350" cellspacing="0" cellpadding="4" class=sp_table>';
    // $txt .= smn_draw_form('create_store_account', smn_href_link(FILENAME_DEFAULT, '', 'NONSSL'), 'post', ' onSubmit="/* return check_form(create_store_account); */"') .
    // $txt .= smn_draw_form('create_store_account', FILENAME_DEFAULT, 'post', ' onSubmit="/* return check_form(create_store_account); */"') .
    $txt .= smn_draw_form('create_store_account', $this->post_url(), 'post', ' onSubmit="/* return check_form(create_store_account); */"') .
		$txt .= smn_draw_hidden_field('action', 'set_store_path');
		$txt .= smn_draw_hidden_field('sp_store_id',$this->store_id);
                $txt .= $this->draw_hidden_session_field();
		$txt .= "<tr class=sp_header_row><td colspan=3><b>Choose your Store Url <i>(accessible as http://www.yourstore.com/YOUR_STORE_URL)</i></b></td></tr>\n";
		$txt .=	"<tr class=sp_row><td>Use your STORE Name:</td><td><input type=radio name=sp_store_path value=\"$store_name\""; 
		if($spmc == $store_name) {
		  $found = 1;
		  $txt .= " checked defaultChecked";
		}
		$txt .= " onClick=\"this.form.sp_store_path_text.value='';\"></td><td>" . HTTP_SERVER . "/" . "$store_name</td></tr>\n";
		
		$txt .= "<tr class=sp_row><td>Use your OWN Name:</td><td><input type=radio name=sp_store_path value=\"$cust_name\"";
	  if($spmc == $cust_name) {
		  $found = 1;
			$txt .= " checked defaultChecked";
		}
		$txt .= " onClick=\"this.form.sp_store_path_text.value='';\"></td><td>" . HTTP_SERVER . "/" . "$cust_name</td></tr>\n";
		
	  $txt .= "<tr class=sp_row><td>Custom Url: </td><td><input type=radio name=sp_store_path value=\"\"";
	  if($found == 0) {
			$txt .= " checked defaultChecked";
		}
	  $txt .= "></td>" . 
			    	"<td>" . HTTP_SERVER . "/" . "<input type=text name=\"sp_store_path_text\" value=\"$spmc\" onFocus=\"this.form.sp_store_path[2].click();\"></td></tr>\n";
	  
	  // $txt .= "<td>&nbsp;</td><td valign=top>type something else above</td><td>&nbsp;</td></tr>";
					  
	  
	  $txt .= "<tr class=sp_footer_row><Td colspan=3 align=center>";
	  // $txt .= '<input type=submit name="sp" value="Submit your Store Url">'; //
	  $txt .= smn_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE);
		$txt .= "</td></tr>";
	  $txt .= "</form>";
	  $txt .= "</table>";
	  return $txt;
	}
	function choose_path($data) {
		if($data['sp_store_id'] == "") {
			$this->ERRORS[] = "NO STORE ID In choose_path";
			return(false);
		} 
		if($data['sp_store_path'] != "") {
		  $rv = $this->put_store_path($data['sp_store_path'],$data['sp_store_id']);
	  } else if($data['sp_store_path_text'] != "") {
			$rv = $this->put_store_path($data['sp_store_path_text'],$data['sp_store_id']);
		} else {
			$this->ERRORS[] = "No Store_Url Specified in choose_path";
			return false;
		}
		if($rv == true) {
			return $rv;
		} else {
			$this->ERRORS[] = "It appears your path is already chosen";
			return false;
		}
	}
	function success_message() {
		$txt = "Successfully Set Store URL to: <blockquote><b>" . HTTP_SERVER . "/" . $this->store_path_mc . "</b></blockquote>" . 
			"(If you have a previous store URL, it will remain accessible for 3 months)"; //<br>Please give this url to your friends and customers-->";
		return($txt);
	}
	function error_message() {
	  $txt = join("<br>", $this->ERRORS);
	  return($txt);
	}
	function put_store_path($path="",$id="",$host="") {	
    if($path != "") {
			$this->store_path_mc = $this->path_prep($path);
			$this->store_path = strtolower($this->store_path_mc);
		} else if($this->store_path_mc == "") {
			$this->store_path_mc = $this->store_path;
		}
		if($id != "") {
			$this->store_id = $id;
		}
		$now = date("Y-m-d H:i:s");
		
		if($this->store_path == "") {
			$this->ERRORS[] = "NO STORE PATH GIVEN";
			return(false);
		} 
		if($this->store_id == "") {
			$this->ERRORS[] = "NO STORE ID GIVEN";
			return(false);
		}
		$pathid = $this->get_store_id($path);
		if($pathid == "") {
      // ok
      // try an insert
    } else if($pathid == $this->store_id) {
			// ok, but don't insert;
			return(true);
		} else {
			// not ok. this belongs to someone else
			$this->ERRORS[] = "Store path '" . $this->store_path_mc . "' is already in use";
			return false;
		}
		$sqlF = "store_path,store_path_mc,store_id,created,expires";
		$sqlV = "'" . $this->dbEscape($this->store_path) . "'," . 
				"'" . $this->dbEscape($this->store_path_mc) . "'," .
				"'" . $this->dbEscape($this->store_id) . "',".
				"'" . $now . "'," .
				"'" . $this->get_exp_date($now) . "'";
		
		if($host != "") {
		  $host = preg_replace("/^https{0,1}:\/\//","",strtolower($host));
			if(preg_match("/^(.*)\.([\w\-]+\.\w{2,4})$/",$host,$MATCHES)) {
				$this->store_machinename = $MATCHES[1];
				$this->store_domain = $MATCHES[2];
				$sqlF .= ",store_machinename,store_domain";
				$sqlV .= ",'" . $this->store_machinename . "'" . 
								",'" . $this->store_domain . "'" . 
								"";
		  }
		}
		$new_exp_date = date("Y-m-d",mktime(0,0,0,date("m")+3, date("d"), date("Y"))) . " 00:00:00"; 
// expires > '" . date("Y-m-d H:i:s") . "')"
		$sqlA = "update " . $this->db_table . " set expires='" .$new_exp_date . "' WHERE store_id='" . $this->store_id . "' AND (expires IS NULL or expires in ('0000-00-00 00:00:00','') OR expires > '" . $new_exp_date . "')";
 		$rv = smn_db_query($sqlA);
		$sql = "insert into " . $this->db_table . "(" . $sqlF . ") VALUES(" . $sqlV . ")";
		$rv = smn_db_query($sql);
		return(true);
	}
  
  function get_exp_date($date) {
		// currently never expire
		return('0000-00-00 00:00:00');
	}
		
  function path_prep_insert($txt) {
		return($this->dbEscape(strtolower($this->path_prep($txt))));
	}
  function path_prep($txt) {
		$txt = preg_replace("/[^" . $this->path_allowed_chars . "]/","",$txt);
		return($txt);
	}
  function dbEscape($txt) {
    $txt = str_replace("\'","'",$txt);
    $txt = str_replace("'","\\'",$txt);
    return($txt);
  }
  function draw_hidden_session_field() {
    if($SID != "") {
      list($name,$value) = split($SID);
    } else {
      $name =  smn_session_name();
      $value = smn_session_id();
    }
    // $sess=smn_href_link();
    // list($name,$val) = split("=",$sess);
    if($name != "") {
      return(smn_draw_hidden_field($name,$value));
    } else {
      return("NO NAME IN draw_hidden_session_field");
    }
  }  
  function post_url() {
      $URL = FILENAME_DEFAULT . "?ID=" . $this->store_id . "&" . smn_session_name() ."=" . smn_session_id();
	if($this->store_path != "") {
	  $URL .= "&sp_url=" . urlencode($this->store_path);
	}
      return($URL);
   
  }

}
?>