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
<?php include_once "function/createproject.php"; ?>	

<?php
	
	if(!isset($_SESSION)) {
	session_start();
	}
	
	if(isset($_SESSION['ClonDiagType'])){
	
		$ClonDiagType		=	$_SESSION["ClonDiagType"];
	
		if (!($ClonDiagType == "administrator")){
				
		echo "<script language=\"javascript\">top.location.href=\"index.php\"</script>";
		
		}
	
	} else {
	
	echo "<script language=\"javascript\">top.location.href=\"index.php\"</script>";
	
	}
	$status	=  "";
	
	if (isset($_POST['project_name']) && isset($_POST['crop_name']) ){
	
		if ($_FILES['file']['name']) {
		
		$project_name	=	stripslashes(trim($_POST['project_name']));
		$crop_name		=	stripslashes(trim($_POST['crop_name']));
		$array_name		=	stripslashes(trim($_POST['array_name']));
		$file 			= 	"file";
		$status			= 	createproject($project_name,$crop_name,$file,$array_name);
		
		} else {
		
		$status			= 	"proyect_incomplete";
		
		}
		
		if($status  ==  "proyect_ok"){
		
		echo "<script language=\"javascript\">top.location.href=\"test.php\"</script>";
		
		}
		
	} 
	
?>
<div class="content">
   	<div class="wrap">
	
	<?php include "includes/banner.php"; ?>	
	
	<div class="grids">	
		<div class="contact">
		<div class="contact-left">
		<h2>New Array Layout</h2>
 		<div id="contact-form-cont" class="one_half">
		
		<div class="contact-form">
		<form id="contact-form" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" class="form-validate" enctype="multipart/form-data">
		<br/>
		<fieldset>
		    <dl>
				<?php
				if ( $status == "proyect_incomplete" ) {
				echo "<div align=\"center\"><span style=\"color: #B40404;\">" . proyect_incomplete . "</span></div><br/>";
				} else if ( $status == "proyect_exist" ) {
				echo "<div align=\"center\"><span style=\"color: #B40404;\">" . proyect_exist . "</span></div><br/>";
				}
				?>
				<dt><label id="jform_contact_name-lbl" for="project_name" class="hasTip required invalid" title="" aria-invalid="true">Array Layout<span class="star"></span>
				</label></dt>
				<dd><input type="text" name="project_name" id="project_name" value="<?php if(isset($_POST['project_name'])){ echo $_POST['project_name']; }?>" class="required invalid" size="30" aria-required="true" required="required" autocomplete="off" aria-invalid="true"></dd>			
				
				<dt><label id="jform_contact_name-lbl" for="array_name" class="hasTip required invalid" title="" aria-invalid="true">Array size<span class="star"></span>
				</label></dt>
				<dd><input type="text" name="array_name" id="array_name" value="<?php if(isset($_POST['array_name'])){ echo $_POST['array_name']; }?>" class="required invalid" size="30" aria-required="true" required="required" autocomplete="off" aria-invalid="true"></dd>			
				
				<dt><label id="jform_contact_name-lbl" for="crop_name" class="hasTip required invalid" title="" aria-invalid="true">Crop<span class="star"></span>
				</label></dt>
				<dd><div class="styled-select"><select name="crop_name" id="crop_name" class="contenedor-select">
				<option value="potato" <?php if(isset($_POST['crop_name'])){ if ($_POST['crop_name'] == "potato"){ echo "selected"; }}?>>Potato</option>
				<option value="sweetpotato" <?php if(isset($_POST['crop_name'])){ if ($_POST['crop_name'] == "sweetpotato"){ echo "selected"; }}?>>Sweetpotato</option></select></div></dd>	
				<br/>
				
				<dt><label id="jform_contact_name-lbl" for="file" class="hasTip required invalid" title="" aria-invalid="true">Upload file<span class="star"></span>
				</label></dt>
				<dd><input type="file" accept="application/vnd.ms-excel" name="file" required="required" ></dd>	
				
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