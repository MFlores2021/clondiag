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
<?php include_once "function/authentication.php"; ?>	

<?php

	session_start();
	
	if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['type'])){
	
		$username	=	stripslashes(trim($_POST['username']));
		$password	=	stripslashes(trim($_POST['password']));
		$type		=	stripslashes(trim($_POST['type']));
		
		$status		= 	authentication($username,$password,$type);
		
		if ( $status == "auth_external" OR $status == "auth_local" ) {
		
		echo "<script language=\"javascript\">top.location.href=\"index.php\"</script>";
		
		}
		
	}
?>
<div class="content">
   	<div class="wrap">
	
	<?php include "includes/banner.php"; ?>	
	
	<div class="grids">	
		<div class="contact">
		<div class="contact-left">
		<h2>Login</h2>
 		<div id="contact-form-cont" class="one_half">
		
		<div class="contact-form">
		<form id="contact-form" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" class="form-validate">
		<br/>
		<fieldset>
		    <dl>
				<?php
				if ( $status == "error_local" OR $status == "error_external" ) {
				echo "<div align=\"center\"><span style=\"color: #B40404;\">" . error_login . "</span></div><br/>";
				}
				?>
				<dt>
				<label id="jform_contact_name-lbl" for="username" class="hasTip required invalid" title="" aria-invalid="true">Username<span class="star"></span>
				</label></dt>
				<dd><input type="text" name="username" id="username" value="<?php if(isset($_POST['username'])){ echo $_POST['username']; }?>" class="required invalid" size="30" aria-required="true" required="required" autocomplete="off" aria-invalid="true"></dd>			
				<dt><label id="jform_contact_emailmsg-lbl" for="password" class="hasTip required invalid" title="" aria-invalid="true">Password<span class="star"></span></label></dt>
				<dd><input type="password" name="password" id="password" value="" class="required invalid" size="60" aria-required="true" required="required" autocomplete="off" aria-invalid="true"></dd>
				<dd><input type="radio" name="type" value="local" <?php if(isset($_POST['type'])){ if ($_POST['type']=="local"){ echo "checked"; }} else { echo "checked"; } ?>><label id="jform_contact_name-lbl" class="hasTip required invalid" title="" aria-invalid="true">Login with CGIAR account</label></dd>
				<dd><input type="radio" name="type" value="external" <?php if(isset($_POST['type'])){ if ($_POST['type']=="external"){ echo "checked"; }} ?>><label id="jform_contact_name-lbl" class="hasTip required invalid" title="" aria-invalid="true">External account</label></dd>
				<br/>
				<div align="center">
				<dd><button class="button validate" type="submit">Login</button></dd>
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