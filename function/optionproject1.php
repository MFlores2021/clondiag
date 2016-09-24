<?php

function optionproject1($project_name) {

	$options= "";
	
	$conn	= start_conection();

	$sql 	= "SELECT `id`, `name` FROM `project` WHERE `owner` = '" . $_SESSION["ClonDiagUser"] . "';";

	if ($rs = mysqli_query($conn, $sql)) {

	while ($result = mysqli_fetch_assoc($rs)){
	
	if ($result) {

	$name	= $result["name"];
	$id		= $result["id"];

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