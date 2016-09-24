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
<?php include_once "function/permissiontest.php"; ?>	
<?php include_once "function/optiontest.php"; ?>	
<?php include_once "function/optionuser.php"; ?>	
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
	
	if (isset($_POST['test_name']) && isset($_POST['username']) ){
		
		$test_name		=	stripslashes(trim($_POST['test_name']));
		$username		=	stripslashes(trim($_POST['username']));		
		$status			= 	verifypermissiontest($test_name,$username);

		if($status     ==   "no_exist"){						
			$status			= 	permissiontest($test_name,$username);			
		} 		
	} 
	
?>
<div class="content">
   	<div class="wrap">
	
	<?php include "includes/banner.php"; ?>	
	
	<div class="grids">	
		<div class="contact">
		<div class="contact-left">
		<h2>Permission Read</h2>
 		<div id="contact-form-cont" class="one_half">
		
		<div class="contact-form">
		<form id="contact-form" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" class="form-validate" enctype="multipart/form-data">
		<br/>
		<fieldset>
		    <dl>
				<?php
				if ( $status == "perm_test_ok" ) {
					echo "<div align=\"center\"><span style=\"color: #B40404;\">Permission saved</span></div><br/>";
				} else if ( $status == "perm_test_error" ) {
					echo "<div align=\"center\"><span style=\"color: #B40404;\">There is a problem with this permission</span></div><br/>";
				} else if ( $status == "exist" ) {
					echo "<div align=\"center\"><span style=\"color: #B40404;\">Permission already exist</span></div><br/>";
				}
				?>
				<dt><label id="jform_contact_name-lbl" for="test_name" class="hasTip required invalid" title="" aria-invalid="true">Select Read<span class="star"></span>
				</label></dt>		
				<dd><div class="styled-select"><select name="test_name" id="test_name" class="contenedor-select" class="required invalid">
				<?php				
				
				if(isset($_POST['test_name'])){ 
				$test_name = $_POST['test_name']; 
				} else { 
				$test_name = ""; 
				}
				echo optiontest($test_name);
				
				?>
				</select>
				</div></dd>
				<dt><label id="jform_contact_name-lbl" for="username" class="hasTip required invalid" title="" aria-invalid="true">Select user<span class="star"></span>
				</label></dt>		
				<dd><div class="styled-select"><select name="username" id="username" class="contenedor-select" class="required invalid">
				<?php				
				
				if(isset($_POST['username'])){ 
				$username = $_POST['username']; 
				} else { 
				$username = ""; 
				}
				echo optionuser($username);
				
				?>
				</select>
				</div></dd>			
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