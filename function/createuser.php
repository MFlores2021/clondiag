<?php

function createuser($username,$fullname,$type,$permission,$password) {

	$conn	= start_conection();
	$status = "perm_test_error";	
	
	if($type == 'local'){
		$password = 'NULL';
	}
	if($password == ''){
		$password = 'NULL';
	}
	
	if($type == 'external'){
		$password = "'".sha1($password)."'";
	}
	$sql 	= "INSERT INTO `user` (`username`,`fullname`,`type`,`permission`,`password`) VALUES ('" . $username  . "', '" . $fullname . "', '" .$type . "', '" .$permission . "', " .$password . ");";
	
	$rs 	= mysqli_query($conn, $sql);	
	
	if ($rs){
	
	$status	= "user_ok";
	
	}
	
	mysqli_close($conn);
		
	return $status;
	
}
function verifycreateuser($username) {

	$conn	= start_conection();
	$status = "no_exist";	
	
	$sql 	= "SELECT * FROM `user` WHERE `username`='" . $username . "';";
	$rs 	= mysqli_query($conn, $sql);

	if (mysqli_num_rows($rs) > 0) {
	
		$status	= "exist";
	}
	
	mysqli_close($conn);
		
	return $status;
	
}

?>