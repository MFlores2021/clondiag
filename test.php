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

<?php include_once "includes/header.php"; ?>	
<?php include_once "includes/includes.php"; ?>	
<?php include_once "function/optionproject.php"; ?>	
<?php include_once "function/createtest.php"; ?>	

<?php
	
	if(!isset($_SESSION)) {
	session_start();
	}
	
	if(isset($_SESSION['ClonDiagType'])){
	
		$ClonDiagType		=	$_SESSION["ClonDiagType"];
	
		if (!($ClonDiagType == "administrator" OR $ClonDiagType == "user")){
				
		echo "<script language=\"javascript\">top.location.href=\"index.php\"</script>";
		
		}
	
	} else {
	
	echo "<script language=\"javascript\">top.location.href=\"index.php\"</script>";
	
	}
	
	$status	=  "";
	
	if (isset($_POST['project_name']) && isset($_POST['test_name']) ){
		
		$project_name	=	stripslashes(trim($_POST['project_name']));
		$test_name		=	stripslashes(trim($_POST['test_name']));

		$status			= 	createtest($project_name,$test_name);
				
		if($status     ==   "test_ok"){
				
		echo "<script language=\"javascript\">top.location.href=\"step/A.php\"</script>";
		
		}
		
	} else {
	
	$status     		=   "test_error";
	
	}
	
?>
<div class="content">
   	<div class="wrap">
	
	<?php include "includes/banner.php"; ?>	
	
	<div class="grids">	
		<div class="contact">
		<div class="contact-left">
		<h2>New Read</h2>
 		<div id="contact-form-cont" class="one_half">
		
		<div class="contact-form">
		<form id="contact-form" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" class="form-validate" enctype="multipart/form-data">
		<br/>
		<fieldset>
		    <dl>
				<?php
				if ( $status == "test_exist" ) {
				echo "<div align=\"center\"><span style=\"color: #B40404;\">" . test_exist . "</span></div><br/>";
				}
				?>
				<dt><label id="jform_contact_name-lbl" for="project_name" class="hasTip required invalid" title="" aria-invalid="true">Select Array Layout<span class="star"></span>
				</label></dt>		
				<dd><div class="styled-select"><select name="project_name" id="project_name" class="contenedor-select" class="required invalid">
				<?php				
				
				if(isset($_POST['project_name'])){ 
				$project_name = $_POST['project_name']; 
				} else { 
				$project_name = ""; 
				}
				echo optionproject($project_name);
				
				?>
				</select>
				</div></dd>
				<dt><label id="jform_contact_name-lbl" for="test_name" class="hasTip required invalid" title="" aria-invalid="true">Read name<span class="star"></span>
				</label></dt>
				<dd><input type="text" name="test_name" id="test_name" value="<?php if(isset($_POST['test_name'])){ echo $_POST['test_name']; }?>" class="required invalid" size="30" aria-required="true" required="required" autocomplete="off" aria-invalid="true"></dd>				
				<br/>
				<div align="center">
				<dd><button class="button validate" type="submit">Submit</button></dd>
				</div>
								
			<?php include "includes/footer.php"; ?>
			
			</dl>
		</fieldset>
		</form>
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