<?php
if(!isset($_SESSION)) {
	session_start();
	$currentProject	=	$_SESSION["ClonDiagProject"];
	$currentTest	=	$_SESSION["ClonDiagTest"];
	$currentBook	=	$_SESSION["ClonDiagBook"];	
if (!($currentProject AND $currentTest AND $currentBook)){
	echo "<script language=\"javascript\">top.location.href=\"../login.php\"</script>";
	}
} else {
	echo "<script language=\"javascript\">top.location.href=\"../login.php\"</script>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
  <title>Step D</title>
  <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
   <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(
hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="../css/style.css" rel="stylesheet" type="text/css" media="all" />
<link rel="shortcut icon" type="image/x-icon" href="../images/favicon.ico" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href="../css/flexnav.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
<?php include "../includes/header.php"; ?>
<div class="content">
   	<div class="wrap">
   <script src="http://davidlynch.org/projects/maphilight/jquery.maphilight.js" type="text/javascript" ></script>
	  
<div class="row">
<!--<div class="span12">-->
<div class="jc-demo-box">
<?php include "../includes/banner.php"; 

	$dir_c	= "../projects/$currentProject/$currentTest/result/"; 
	
	echo "<br>";

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	echo "<img src=\"". $dir_c .$_POST['photo']." 2.png\" width=\"900\"\">";
	echo "<br>";
	echo "<img src=\"". $dir_c .$_POST['photo']." .png\" width=\"900\"\">";
	}	
?>
	<?php include "../includes/footer.php"; ?>
</div>
</div>
</div>
</div>
</body>
</html>