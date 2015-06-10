<?php

	if ($_GET["testdir"] && $_GET["user"] && $_GET["dir_result"]){
		session_start();
		$_SESSION["ClonDiagTest"] 	 = $_GET["testdir"];
		$_SESSION["ClonDiagUser"]	 = $_GET["user"];
		
		echo "<script language=\"javascript\">top.location.href =\"". $_GET["dir_result"] ."\"</script>";
	} else{
	
		echo "<script language=\"javascript\">top.location.href=\"../index.php\"</script>";
	
	}
	
?>