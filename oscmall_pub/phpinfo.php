<?php
	//echo phpinfo();
	/*include("includes/configure.php");
	$sql_data_array = array('zname1' => 'Sobin1',
                              'zname2' => 'Sobin1'
                            );
	smn_db_perform('ztest', $sql_data_array);*/
	mysql_connect('localhost','oscdevsh_sobin','babu3245fgs');
	mysql_select_db('oscdevsh_oscmalldev');
	$qry = "insert into ztest(zname1,zname2) values('Sobin2','Sobin2')";
	mysql_query($qry);
	
	echo "Ztest Id" .mysql_insert_id();
?>