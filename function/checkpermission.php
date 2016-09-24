<?php

function checkpermission($user,$test){

	$status	= FALSE;

	$conn	= start_conection();
	
	$sql 	= "SELECT `id` FROM `user` WHERE `username` = '" . $user . "';";
	$rs 	= mysqli_query($conn, $sql);
	$result = mysqli_fetch_assoc($rs);
	$id_user= $result["id"];
	
	$sql 	= "SELECT `id` FROM `test` WHERE `dir` = '" . $test . "';";
	$rs 	= mysqli_query($conn, $sql);
	$result = mysqli_fetch_assoc($rs);
	$id_ts	= $result["id"];
	
	$sql 	= "SELECT COUNT(*) AS `COUNT` FROM `permission_test` WHERE `test` = '" .$id_ts. "' AND `user` = '" .$id_user. "';";
	$rs 	= mysqli_query($conn, $sql);	
	$result = mysqli_fetch_assoc($rs);
	
	if ($result["COUNT"]){
	$status	= TRUE;
	}

	mysqli_close($conn);
	
	return $status;
	
}

?>