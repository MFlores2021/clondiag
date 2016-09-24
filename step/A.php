<?php
include_once "/var/www/clondiag/conn/conn.php";
include_once "/var/www/clondiag/function/checkpermission.php";

	if(!isset($_SESSION)) {
		session_start();
		$currentProject	=	$_SESSION["ClonDiagProject"]; 
		$currentTest	=	$_SESSION["ClonDiagTest"]; 
		$currentBook	=	$_SESSION["ClonDiagBook"];
		$currentUser	=	$_SESSION["ClonDiagUser"];
			
		if (!($currentProject AND $currentTest AND $currentBook AND checkpermission($currentUser,$currentTest))){
			echo "<script language=\"javascript\">top.location.href=\"/clondiag/login.php\"</script>";
		}
	} else {
		echo "<script language=\"javascript\">top.location.href=\"/clondiag/login.php\"</script>";
	}

	$dir_c			= "/var/www/clondiag/projects/$currentProject/$currentTest/files/";

	if (!file_exists($dir_c)) {
	   mkdir($dir_c);
	}
	
	$upload_dir 		= "../files"; 					// The directory for the images to be saved in
	$upload_path 		= $dir_c;						// The path to where the image will be saved
	$max_file 			= "8"; 							// Maximum file size in MB

	// Only one of these image types should be allowed for upload
	$image_location 	= $upload_path.$_FILES['image']['name'];	
	$allowed_image_typ 	= array('image/pjpeg'=>"jpg","JPG",'image/jpeg'=>"jpg",'image/jpg'=>"jpg",'image/png'=>"png",'image/x-png'=>"png",'image/gif'=>"gif");
	$allowed_image_ext 	= array_unique($allowed_image_typ); // do not change this
	$image_ext 			= "";	// initialise variable, do not change this.

foreach ($allowed_image_ext as $mime_type => $ext) {
    $image_ext.= strtoupper($ext)." ";
}

if (isset($_POST["upload"])) {

	//Get the file information
	$userfile_name 	= $_FILES['image']['name'];
	$userfile_tmp 	= $_FILES['image']['tmp_name'];
	$userfile_size 	= $_FILES['image']['size'];
	$userfile_type 	= $_FILES['image']['type'];
	$filename 		= basename($_FILES['image']['name']);
	$file_ext 		= strtolower(substr($filename, strrpos($filename, '.') + 1));
	
	//Only process if the file is a JPG, PNG or GIF and below the allowed limit
	
	if((!empty($_FILES["image"])) && ($_FILES['image']['error'] == 0)) {
		
		foreach ($allowed_image_typ as $mime_type => $ext) {

			if($file_ext==$ext && $userfile_type==$mime_type){
				$error = "";
				break;
			}else{
				$error = "Only <strong>".$image_ext."</strong> images accepted for upload<br />";
			}
		}

		if ($userfile_size > ($max_file*1048576)) {
			$error.= "Images must be under ".$max_file."MB in size";
		}
		
	}else{
		$error= "Select an image for upload"; 
	}
	
	if (strlen($error)==0){
		
		if (isset($_FILES['image']['name'])){
			
			move_uploaded_file($userfile_tmp, $image_location);
			chmod($image_location, 0777);
			//Refresh the page to show the new uploaded image
			header("location:B.php?photo=".$_FILES['image']['name'] . "&screen=" . $_POST["screen"]);
			exit();			
		}				
	}
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
  <title>A</title>
  <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
 <!-- <link rel="stylesheet" href="../css/main.css" type="text/css" />-->
  <link rel="stylesheet" href="../css/demos.css" type="text/css" />
  <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(
hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="../css/style.css" rel="stylesheet" type="text/css" media="all" />
<link rel="shortcut icon" type="image/x-icon" href="../images/favicon.ico" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href="../css/flexnav.css" rel="stylesheet" type="text/css" media="all" />
<script src="../js/jquery.min.js"></script>
  <script type="text/javascript">

  $(function(){
  $('#screen').val($(window).width());
   });
     </script>
</head>
<body>
<?php include "../includes/header.php"; ?>
<div class="content">
   	<div class="wrap">
	
	<?php include "../includes/banner.php"; ?>	
	
	<div class="grids">	<div class="jc-demo-box">
	<div class="span12">
	
	<div align="center"><span style="color: #23C6C1">Analysis Page</span></div>
	<br/><br/>
	<h1>Step A: Photo Upload</h1>
	</div>
	<br/><br/>
	<form name="photo" enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
	<p style="text-align: center;">
	<input type="file" class="file" name="image"  />
	</p>
	<br/><br/>
	<p style="text-align: center;"><input type="submit" name="upload" value="Upload Image" class="btn btn-large btn-inverse" /></p>
	 <input type="hidden" name="screen" ID="screen"/>
	</form>
	<?php include "../includes/footer.php"; ?>

		</div>
		</div>
	</div>
	</div>
</body>
</html>