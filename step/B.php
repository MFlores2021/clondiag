<?php

	if(!isset($_SESSION)) {
		session_start();
		$currentProject	=	$_SESSION["ClonDiagProject"];
		$currentTest	=	$_SESSION["ClonDiagTest"];
		//$currentBook	=	$_SESSION["ClonDiagBook"];	
		
		if (!($currentProject AND $currentTest)){
			echo "<script language=\"javascript\">top.location.href=\"../previous.php\"</script>";
		}
		
	} else {
		echo "<script language=\"javascript\">top.location.href=\"../login.php\"</script>";
	}

	$dir_c			=	"../projects/$currentProject/$currentTest/"; 
	$dir_files		=	$dir_c . "files/";
	$dir_thmb		=	$dir_c . "thumbnail/";
		
	//if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['w'] > 0) {
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
		if (!file_exists($dir_thmb)) {
			mkdir($dir_thmb);		
		}

		$jpeg_quality = 100;

		$src 		=	$dir_files . $_POST['photo']; 
		$info1 		= 	pathinfo($_POST['photo']);
		$src0 		=	$dir_thmb . $info1['filename'] . ".".  $info1['extension']; 
		$carp 		= 	explode("/", $_POST['folder']);
		$_folder	=	$carp[4];
		
	
		if (file_exists($dir_thmb. $_POST['photo'])) {
		
			$info 	= 	pathinfo($src0);
			$src 	=	$info['dirname'] . '/' . $info['filename'] . "_1." . $info['extension']; 
			
			copy($src0,$src) or die("Unable to rename $src0.");
			chmod($src, 0777);
			
			$src 	=	$dir_thmb . $info['filename'] . "_1." . $info['extension']; 
			$src0 	=	$dir_thmb . $info['filename'] . ".". $info['extension'];  //. ".jpg"; 	

			unlink($src0);		
		}
		
		///* Para guardar imagen

		include "../function/imagecreatefromfile.php"; 	
		include "../function/flipImage.php"; 	

		$img_r 		= imagecreatefromfile($src);
		
				
		if ($_POST['flip'] ==  "flip_v"){

				$img_ra=flipImage($img_r, 0,1);
				imagejpeg($img_ra,$src0);
		}
		else {
		
		$dst_r 		= ImageCreateTrueColor($_POST['w']*$_POST['prop'],$_POST['h']*$_POST['prop']);

		imagecopyresized($dst_r,$img_r,0,0,$_POST['x']*$_POST['prop'],$_POST['y']*$_POST['prop'],$_POST['w']*$_POST['prop'],$_POST['h']*$_POST['prop'],$_POST['w']*$_POST['prop'],$_POST['h']*$_POST['prop']);
		imagejpeg($dst_r,$src0);
		}
		chmod($src0, 0777);

	}

	// If not a POST request, display page below:
	
	$grilla = "grilla.png";
	
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
	<head>
		<title>B</title>
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<script src="../js/jquery.min.js"></script>
		<script src="../js/jquery.Jcrop.js"></script>
		<script src="../js/function_crop.js"></script>  
		<link rel="stylesheet" href="../css/main.css" type="text/css" />
		<link rel="stylesheet" href="../css/demos.css" type="text/css" />
		<link rel="stylesheet" href="../css/jquery.Jcrop.css" type="text/css" />
		<link rel="stylesheet" href="../css/style.css" type="text/css" media="all" />
		<link rel="stylesheet" href="../css/flexnav.css" type="text/css" media="all" />
		<link rel="shortcut icon" type="image/x-icon" href="../images/favicon.ico" />
		<style>
			.jcrop-holder {
				text-align: center;
			}
		</style>
	</head>
	<body>
		<?php include "../includes/header.php"; ?>
		<div class="content">
			<div class="wrap">
				<div class="row">
					<div class="jc-demo-box">
						<?php include "../includes/banner.php"; ?>	
						<div class="page-header"><h1>Step B: Image Crop</h1></div>
						<div style="text-align:center"  align="center">			
							<?php
								$_width = '100%';
								if (isset($_POST['photo'])) {
							?>
									<p style="text-align: right;">
										<a href="B.php?photo=<?php echo $_POST['photo']. "&screen=" . $_POST["screen"]; ?>"><img src="../css/return.png" width="12" height="20"><font>Original photo</font></a>
									</p>
							<?php
								}
							?>		
							<!-- This is the image we're attaching Jcrop to -->
							<?php				
								if (isset($_GET['photo'])) {
								
									echo "<table border=\"1\" width=\"". $_width ."\">";
									
									$x_sixe 	= 	$_GET['screen']*0.9;
									$info2 		= 	pathinfo($_GET['photo']);	
									$name_p		= 	$info2['filename']. ".". $info2['extension']; 
									
									if ($_GET['return']=='rotate')
										$dir_orig	=	$dir_thmb;
									else 
										$dir_orig	=	$dir_files;
									
									$photo		=	$dir_orig .  $name_p;
									$size 		= 	GetImageSize("$photo");
									$x1			=	$size[0]; 
									$y1			=	$size[1]; 		
									$prop		=	$x1 / $x_sixe;
									$y_sixe		=	$y1 / $prop;
									$screen		=	$_GET['screen'];
									
									echo "<tr><td width=\"".$_width."\" style=\"text-align:center\">";
									echo "<img src=\"" . $photo . "\" id=\"cropbox\" width=\"" . $x_sixe . "\" height=auto/>";
									echo "</td></tr>";	
							?>
									</table>
									
									<table border="1" width="<?php echo $_width; ?>">
										<tr>
											<td width="25%">
												<form action="B.php" method="post">
													
													<input type="hidden" id="screen" name="screen" value="<?php echo $_GET['screen']; ?>" />
													<input type="hidden" id="folder" name="folder" value="<?php echo $dir_orig; ?>"/>
													<input type="hidden" id="photo"  name="photo"  value="<?php echo $_GET['photo']; ?>"/>
													<input type="hidden" id="flip" name="flip" value="flip_v"/>
													<br/>
													<p style="text-align: center;"><input type="submit" value="Flip" class="btn btn-large btn-inverse" /></p>
												</form>
											</td>
											<td width="25%">
												<form action="B.php" method="post" onsubmit="return checkCoords();">
													<input type="hidden" id="x" name="x" />
													<input type="hidden" id="y" name="y" />
													<input type="hidden" id="w" name="w" />
													<input type="hidden" id="h" name="h" />
													<input type="hidden" id="screen" name="screen" value="<?php echo $_GET['screen']; ?>" />
													<input type="hidden" id="folder" name="folder" value="<?php echo $dir_orig; ?>"/>
													<input type="hidden" id="prop"   name="prop"   value="<?php echo $prop; ?>"/>
													<input type="hidden" id="photo"  name="photo"  value="<?php echo $_GET['photo']; ?>"/>
													<br/>
													<p style="text-align: center;"><input type="submit" value="Crop" class="btn btn-large btn-inverse" /></p>
												</form>
											</td>
							<?
								}

								if (isset($_POST['photo'])) {
									
									echo "<table border=\"1\" width=\"". $_width ."\">";
									
									$x_sixe 	= 	$_POST['screen']*0.9;
									$info3 		= 	pathinfo($_POST['photo']);	
									$name_p		= 	$info3['filename']. ".". $info3['extension']; 
									$photo_		=	$dir_thmb . $name_p;
									$size_ 		= 	GetImageSize("$photo_");
									$x1_		=	$size_[0]; 
									$y1_		=	$size_[1]; 		
									$prop_		=	$x1_ / $x_sixe;
									$y_sixe_	=	$y1_ / $prop_;
									$screen		=	$_POST['screen'];
									
									echo "<tr><td width=\"". $_width ."\" style=\"text-align:center\">";
									echo "<img src=\"" . $photo_ . "\" id=\"cropbox\" width=\"" . $x_sixe . "\" height=auto/>";
									echo "</td></tr>";
							?>
									</table>
									
									<table border="1" width="<?php echo $_width; ?>">
										<tr>
											<td width="25%">
												<form action="B.php" method="post">
													<input type="hidden" id="screen" name="screen" value="<?php echo $_POST['screen']; ?>" />
													<input type="hidden" id="folder" name="folder" value="thumbnail"/>
													<input type="hidden" id="photo" name="photo" value="<?php echo $name_p; ?>"/>
													<input type="hidden" id="flip" name="flip" value="flip_v"/>
													<br/>
													<p style="text-align: center;"><input type="submit" value="Flip" class="btn btn-large btn-inverse" /></p>
												</form>
											</td>
											<td width="25%">
												<form action="B.php" method="post">
													<input type="hidden" id="x" name="x" />
													<input type="hidden" id="y" name="y" />
													<input type="hidden" id="w" name="w" />
													<input type="hidden" id="h" name="h" />
													<input type="hidden" id="screen" name="screen" value="<?php echo $_POST['screen']; ?>" />
													<input type="hidden" id="folder" name="folder" value="thumbnail"/>
													<input type="hidden" id="prop"  name="prop" value="<?php echo $prop_; ?>"/>	
													<input type="hidden" id="photo" name="photo" value="<?php echo $name_p; ?>"/>
													<br/>
													<p style="text-align: center;"><input type="submit" value="Crop" class="btn btn-large btn-inverse" /></p>
												</form>
											</td>
							<?php
								}
							?>
											<td width="25%">
												<form action="B1.php" method="post">
													<input type="hidden" id="photo" name="photo" value="<?php echo $name_p; ?>"/>
													<input type="hidden" id="screen" name="screen" value="<?php echo $screen; ?>"/>												
													<br/>
													<p style="text-align: center;"><input type="submit" value="Rotate" class="btn btn-large btn-inverse" /></p>
												</form>
											</td>
											<td width="25%">
												<form action="C.php" method="get">
													<input type="hidden" id="screen" name="screen" value="<?php echo $screen; ?>" />
													<input type="hidden" id="photo" name="photo" value="<?php echo $name_p; ?>"/>
													<br/>		
													<p style="text-align: center;"><input type="submit" value="Run" class="btn btn-large btn-inverse"/></p>
												</form>
											</td>
									</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>