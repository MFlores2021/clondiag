<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE HTML>
<html>
<head>
<title>Clondiag</title>	
<meta name="keywords" content="clondiag,potato,sweetpotato,cipotato,research" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(
hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href="css/flexnav.css" rel="stylesheet" type="text/css" media="all" />
<script src="js/jquery.min.js"></script>
</head>
<body>

<?php include "includes/header.php"; ?>

<?php

	session_start();
	unset($_SESSION["ClonDiagUser"]);
	unset($_SESSION["ClonDiagType"]);
	unset($_SESSION["ClonDiagProject"]);
	unset($_SESSION["ClonDiagTest"]);
	echo "<script language=\"javascript\">top.location.href=\"index.php\"</script>";
	
?>
<div class="content">
   	<div class="wrap">
	
	<?php include "includes/banner.php"; ?>	
	
	<div class="grids">	
		<div class="contact">
		<div class="contact-left">
		<h2>Logout</h2>
 		<div id="contact-form-cont" class="one_half">	
		<div class="contact-form">
		<div class="clear"></div>
		</div>
		</div>
    </div>
	</div>
	</div>
	</div>
</div>	
</body>
</html>