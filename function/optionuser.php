<?php

function optionuser($username) {

	$options= "";
	
	$conn	= start_conection();
	$sql 	= "SELECT `id`,`username` FROM `user`;";
	
	if ($rs = mysqli_query($conn, $sql)) {

	while ($result = mysqli_fetch_assoc($rs)){
	
	if ($result) {
	
	$user	= $result["username"];
	$id	 	= $result["id"];

	$options= $options . "<option value=\"".$id."\"";
	
	if ($id == $username){
	
	$options= $options . " selected ";
	
	}
	
	$options= $options . ">".$user."</option>";
	
	}
	
	}
	
	}
	
	mysqli_close($conn);
	
	return $options;

}

?>