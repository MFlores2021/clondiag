<?php

	if ($_GET["projdir"] && $_GET["testdir"] && $_GET["book"] && $_GET["user"] && $_GET["array"]){
		session_start();
		$_SESSION["ClonDiagProject"] = $_GET["projdir"];
		$_SESSION["ClonDiagTest"] 	 = $_GET["testdir"];
		$_SESSION["ClonDiagBook"]	 = $_GET["book"];
		$_SESSION["ClonDiagUser"]	 = $_GET["user"];
		$_SESSION["ClonDiagArray"]	 = $_GET["array"];
		echo "<script language=\"javascript\">top.location.href=\"A.php\"</script>";
		
	} else{
	
		echo "<script language=\"javascript\">top.location.href=\"../index.php\"</script>";
	
	}
	
?>