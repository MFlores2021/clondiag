<?php

function optionproject($project_name) {

	$options= "";
	
	$conn   = start_conection();
	$sql    = "SELECT `id` FROM `user` WHERE `username` = '" . $_SESSION["ClonDiagUser"] . "';";
	$rs     = mysqli_query($conn, $sql);
	$result = mysqli_fetch_assoc($rs);
	$id_us  = $result["id"];

	$sql    = "SELECT `project` FROM `permission_main` WHERE `user` = '" . $id_us . "';";

	if ($rs = mysqli_query($conn, $sql)) {

	while ($result = mysqli_fetch_assoc($rs)){
	
	if ($result) {

	$sqls    = "SELECT `id`, `name` FROM `project` WHERE `id` = '" . $result["project"] . "';";
	$rss     = mysqli_query($conn, $sqls);
	$resuls  = mysqli_fetch_assoc($rss);
	
	$name  = $resuls["name"];
	$id      = $resuls["id"];

	$options= $options . "<option value=\"".$id."\"";
	
	if ($id == $project_name){
	
	$options= $options . " selected ";
	
	}
	
	$options= $options . ">".$name."</option>";
	
	}
	
	}
	
	}
	
	mysqli_close($conn);
	
	return $options;

}

?>
