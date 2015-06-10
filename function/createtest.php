<?php

function createtest($project_name,$test_name){

	$conn	= start_conection();
	
	$sql 		= 	"SELECT `name`, `dir`, `file`, `array` FROM `project` WHERE `id` = '" . $project_name . "';";
	$rs 		= 	mysqli_query($conn, $sql);
	$result 	= 	mysqli_fetch_assoc($rs);
	$name		=	$result["name"];
	$file		=	$result["file"];
	$proj_dir	=	$result["dir"];
	$array_size	=	$result["array"];
	$test_dir	=	strtolower(preg_replace('([^A-Za-z0-9])', '', $test_name));
	
	$path		=	"projects/" . $proj_dir . "/" . $test_dir;
	$path		=	dirname(__DIR__) . "/" . $path;
	
	mkdir($path,0777);
		
	$sql 	= "SELECT COUNT(*) AS `count` FROM `test` WHERE `name` = '" . $test_name . "' AND `project` = '" . $project_name . "';";

	if ($rs = mysqli_query($conn, $sql)) {

		$result = mysqli_fetch_assoc($rs);

		if ($result["count"]){
	
			$status = "test_exist";	
			mysqli_close($conn);	
			return $status;	
	} }
	
	$sql 	= "INSERT INTO `test` (`name`, `dir`, `project`, `owner`) VALUES ('" . $test_name . "', '" . $test_dir . "', '" . $project_name . "', '" . $_SESSION["ClonDiagUser"] . "');";
	$rs 	= mysqli_query($conn, $sql);
	
	$sql 	= "SELECT `id` FROM `test` WHERE `name` = '" . $test_name . "';";
	$rs 	= mysqli_query($conn, $sql);
	$result = mysqli_fetch_assoc($rs);
	$id_ts	= $result["id"];
	
	$sql 	= "SELECT `id` FROM `user` WHERE `username` = '" . $_SESSION["ClonDiagUser"] . "';";
	$rs 	= mysqli_query($conn, $sql);
	$result = mysqli_fetch_assoc($rs);
	$id_us	= $result["id"];
	
	$sql 	= "INSERT INTO `permission_test` (`test`, `user`) VALUES ('" . $id_ts . "', '" . $id_us . "');";
	$rs 	= mysqli_query($conn, $sql);	
	
	if ($rs){	
		$_SESSION["ClonDiagProject"] = $proj_dir;
		$_SESSION["ClonDiagTest"] 	 = $test_dir;
		$_SESSION["ClonDiagBook"] 	 = $file;
		$_SESSION["ClonDiagArray"] 	 = $array_size;
	
		$status	= "test_ok";	
	}
	
	mysqli_close($conn);
	
	return $status;
	
}

?>