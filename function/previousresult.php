<?php

function previousresult_old($user){

	$conn	= start_conection();
	
	$sql 	= "SELECT `id` FROM `user` WHERE `username` = '" . $user . "';";
	$rs 	= mysqli_query($conn, $sql);
	$result = mysqli_fetch_assoc($rs);
	$id_us	= $result["id"];
	
	$prev	= "";
	
	$sql 	= "SELECT `test` FROM `permission_test` WHERE `user` = '" . $id_us . "';";

	if ($rs = mysqli_query($conn, $sql)) {

		while ($result = mysqli_fetch_assoc($rs)){
	
		if ($result["test"]) {
		
		$sql1 	= "SELECT DATE_FORMAT(`test`.`date`, '%b %d %Y %h:%i %p') AS `fecha`, `test`.`name`, `test`.`owner`, `test`.`dir` AS 'testdir', `project`.`dir`  AS 'projdir', `project`.`file`  AS 'book', `project`.`array`  AS 'array' FROM `test` INNER JOIN `project` ON `test`.`project` = `project`.`id` WHERE `test`.`id` = '" . $result["test"] . "' ORDER BY `test`.`date` DESC;";

		if ($rs1 = mysqli_query($conn, $sql1)) {

			while ($result1 = mysqli_fetch_assoc($rs1)){
			
			$dir_result 	=	"projects/".$result1["projdir"]."/".$result1["testdir"]."/result/result.php";
			
			if (file_exists($dir_result)) {
			$testdir 	 =  $result1["testdir"];
				$prev		.=  "<tr><td width=\"35%\">" . $result1["fecha"] . "</td><td width=\"45%\"><a href =\"step/C1.php?testdir=$testdir&user=$user&dir_result=/clondiag/$dir_result\">" . $result1['name'] . "</a>";
			}
			else {
				$projdir	 =  $result1["projdir"];
				$testdir 	 =  $result1["testdir"];
				$book 		 =  $result1["book"];
				$array 		 =  $result1["array"];
			
				$prev		.=  "<tr><td width=\"35%\">" . $result1["fecha"] . "</td><td width=\"45%\"><a href =\"step/A1.php?projdir=$projdir&testdir=$testdir&book=$book&user=$user&array=$array\">" . $result1["name"] . "</a>";
			
			}			
			
			/*		
			if ($result1["owner"] == $user) {
			$prev		.=  "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src=\"images/delete.png\" title=\"delete\">";
			}
			*/
			$prev		.=  "</td><td width=\"20%\">" . $result1["owner"] . "</td></tr>";
					
			}
		
		}
		
		}
		
		}
	
	}
	
	return $prev;	
	
	mysqli_close($conn);
	
}
function previousresult($user){

	$conn	= start_conection();
	
	$sql 	= "SELECT `id` FROM `user` WHERE `username` = '" . $user . "';";
	$rs 	= mysqli_query($conn, $sql);
	$result = mysqli_fetch_assoc($rs);
	$id_us	= $result["id"];
	
	$prev	= "";
	
	$sql 	= "SELECT `test` FROM `permission_test` WHERE `user` = '" . $id_us . "';";

	if ($rs = mysqli_query($conn, $sql)) {

		while ($result = mysqli_fetch_assoc($rs)){
	
			if ($result["test"]) {
			
				$sql1 	= "SELECT DATE_FORMAT(`test`.`date`, '%b %d %Y %h:%i %p') AS `fecha`, `test`.`name`, `test`.`owner`, `test`.`dir` AS 'testdir', `project`.`dir`  AS 'projdir', `project`.`file`  AS 'book', `project`.`array`  AS 'array' , `test`.`id` AS 'id' FROM `test` INNER JOIN `project` ON `test`.`project` = `project`.`id` WHERE `test`.`id` = '" . $result["test"] . "' ORDER BY `test`.`date` DESC;";

				if ($rs1 = mysqli_query($conn, $sql1)) {

					while ($result1 = mysqli_fetch_assoc($rs1)){
					
						$dir_result 	=	"projects/".$result1["projdir"]."/".$result1["testdir"]."/result/result.php";
						
						if (file_exists($dir_result)) {
							$testdir 	 =  $result1["testdir"];
							$prev		.=  "<tr><td width=\"35%\">" . $result1["fecha"] . "</td><td width=\"45%\"><a href =\"step/C1.php?testdir=$testdir&user=$user&dir_result=/clondiag/$dir_result\">" . $result1['name'] . "</a>";
						}
						else {
							$projdir	 =  $result1["projdir"];
							$testdir 	 =  $result1["testdir"];
							$book 		 =  $result1["book"];
							$array 		 =  $result1["array"];
						
							$prev		.=  "<tr><td width=\"35%\">" . $result1["fecha"] . "</td><td width=\"45%\"><a href =\"step/A1.php?projdir=$projdir&testdir=$testdir&book=$book&user=$user&array=$array\">" . $result1["name"] . "</a>";				
						}			
												
						$prev		.=  "</td><td width=\"20%\">" . $result1["owner"] . "</td>";
						
						if ($result1["owner"] == $user) {
						
							if(strlen($result1["testdir"]) > 0){
						
								$dir_del 	=	"projects/".$result1["projdir"]."/".$result1["testdir"];
								$prev		.=  "<td width=\"20%\"><form name='form1' method='POST' action=''><input type='submit'  name='delete' id='delete' value='Delete' onclick='return confirm(\"Are you sure you want to delete " . $result1["testdir"] . " test?\")'><input type='hidden' id='id' name='id' value='" . $result1["id"] . "' /><input type='hidden' id='dir' name='dir' value='" . $dir_del . "' /></form></td></tr>";	
								
							}
						}
						else {
						$prev		.= "<td width=\"20%\">-</td></tr>";
						}
					}				
				}		
			}		
		}	
	}
	
	return $prev;	
	
	mysqli_close($conn);
	
}

function previousdelete($idd, $dir){

	$conn		= start_conection();
	$status 	= "perm_test_error";	
	$delete_id 	= $idd;
	
	$id 		= count($delete_id );
	
	if (count($id) ==1){		  		 
		$sql 	= "DELETE FROM `test` WHERE id='$delete_id'";
		$delete = mysqli_query($conn, $sql);					
	}
	
	if($delete){
		$status	= "proyect_ok";	
		
		system("rm -rf ".escapeshellarg($dir));			
	}
	
	mysqli_close($conn);
		
	return $status;
}