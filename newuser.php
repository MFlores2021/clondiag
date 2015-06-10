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
<script type="application/x-javascript"> 
function detail(){
	if (document.getElementById) capa = eval("document.getElementById('details').style");
	if ((capa.visibility == 'hidden') || (capa.visibility == 'hide')){
	  capa.visibility = (document.layers) ? 'hide' : 'hidden' ;
	}else{
	  capa.visibility = (document.layers) ? 'show' : 'visible' ;
	}
	}
</script>
<?php include_once "includes/header.php"; ?>	
<?php include_once "includes/includes.php"; ?>	
<?php include_once "function/createuser.php"; ?>	
<?php include_once "function/optionproject1.php"; ?>	
<?php include_once "function/optionuser.php"; ?>	
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
	
	if (isset($_POST['fullname']) && isset( $_POST['username']) && isset( $_POST['type']) && isset( $_POST['permission']) && isset( $_POST['password']) ){
		
		$username		=	stripslashes(trim($_POST['username']));
		$fullname		=	trim($_POST['fullname']);
		$type			=	trim($_POST['type']);
		$permission		=	trim($_POST['permission']);
		$password		=	trim($_POST['password']);
		$status			= 	verifycreateuser($username);

		if($status     ==   "no_exist"){	
			$status			= 	createuser($username,$fullname,$type,$permission,$password);
		
			if($status     ==   "user_ok"){
					
			echo "<script language=\"javascript\">top.location.href=\"index.php\"</script>";
			
			}
		}
	} else {
	
	$status     		=   "perm_test_error";
	
	}
	
?>
<div class="content">
   	<div class="wrap">
	
	<?php include "includes/banner.php"; ?>	
	
	<div class="grids">	
		<div class="contact">
		<div class="contact-left">
		<h2>New User</h2>
 		<div id="contact-form-cont" class="one_half">
		
		<div class="contact-form">
		<form id="contact-form" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" class="form-validate" enctype="multipart/form-data">
		<br/>
		<fieldset>
		    <dl>
				<?php
					if ( $status == "perm_test_error" ) {
					
						echo "<div align=\"center\"><span style=\"color: #B40404;\">There is a problem</span></div><br/>";
						
					} else if ( $status == "exist" ) {
					
						echo "<div align=\"center\"><span style=\"color: #B40404;\">User already exist</span></div><br/>";
						
					}				
				?>
				<dt><label id="jform_contact_name-lbl" for="fullname" class="hasTip required invalid" title="" aria-invalid="true">Full Name<span class="star"></span>
				</label></dt>
				<dd><input type="text" name="fullname" id="fullname" value="<?php if(isset($_POST['fullname'])){ echo $_POST['fullname']; }?>" class="required invalid" size="30" aria-required="true" required="required" autocomplete="off" aria-invalid="true"></dd>			
				<dt><label id="jform_contact_name-lbl" for="username" class="hasTip required invalid" title="" aria-invalid="true">User Name<span class="star"></span>
				</label></dt>
				<dd><input type="text" name="username" id="username" value="<?php if(isset($_POST['username'])){ echo $_POST['username']; }?>" class="required invalid" size="30" aria-required="true" required="required" autocomplete="off" aria-invalid="true"></dd>			
				
				<dt><label id="jform_contact_name-lbl" for="type" class="hasTip required invalid" title="" aria-invalid="true">User CGIAR<span class="star"></span>
				</label></dt>
				<dd>
				<input type="radio" name="type" value="local" <?php if(isset($_POST['type'])){ if ($_POST['type'] == "local"){ echo "checked"; }}?> onclick='detail()'> Yes	
				<input type="radio" name="type" value="external" <?php if(isset($_POST['type'])){ if ($_POST['type'] == "external"){ echo "selected"; }}?> onclick='detail()'> No<br>
				<br/>
				<dt><label id="jform_contact_name-lbl" for="permission" class="hasTip required invalid" title="" aria-invalid="true">Permission<span class="star"></span>
				</label></dt><dd><div class="styled-select"><select name="permission" id="permission" class="contenedor-select">
				<option value="user" <?php if(isset($_POST['permission'])){ if ($_POST['permission'] == "user"){ echo "selected"; }}?>>User</option>
				<option value="administrator" <?php if(isset($_POST['permission'])){ if ($_POST['permission'] == "administrator"){ echo "selected"; }}?>>Administrator</option></select></div></dd>	
				<br/>
				<div id ="details">
				<dt><label id="jform_contact_name-lbl" for="password" class="hasTip required invalid" title="" aria-invalid="true">Password<span class="star"></span>
				</label></dt>
				<dd><input type="password" name="password" id="password" value="<?php if(isset($_POST['password'])){ echo $_POST['password']; }?>" class="required invalid" size="30" aria-required="true" autocomplete="off" aria-invalid="true"></dd>			
				</div>					
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