<?php

	$dir_c			=	"../projects/sweetpotatovirus/teat10/";  
	$dir_files		=	$dir_c . "files/";
	$dir_thmb		=	$dir_c . "thumbnail/";
	
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['w'] > 0) {
	$_POST['photo']	= 'image.jpg';

	$jpeg_quality = 90;
	$grados = 100;
	$src 		=	$dir_files . $_POST['photo']; 
	$src0 		=	$dir_thmb . $_POST['photo'];  

	if($_POST['folder']  ==  "thumbnail"){
	
		$info 	= 	pathinfo($src0);

		$src 	=	$info['dirname'] . '/' . $info['filename'] . "_1." . $info['extension']; 
		
		copy($src0,$src) or die("Unable to rename $src0.");
		chmod($src, 0777);
		$src 	=	$dir_thmb . $info['filename'] . "_1." . $info['extension']; 
		$src0 	=	$dir_thmb . $_POST['photo']; 	
		$src1 	=	$dir_thmb . $info['filename'] . "_2." . $info['extension']; 
		unlink($src0);		
	}
	///* Para guardar imagen

	function imagecreatefromfile( $filename ) {
		if (!file_exists($filename)) {
			throw new InvalidArgumentException('File "'.$filename.'" not found.');
		}
		switch ( strtolower( pathinfo( $filename, PATHINFO_EXTENSION ))) {
			case 'jpeg':
			case 'jpg':
			echo $img_r;
				return $img_r=imagecreatefromjpeg($filename);
			break;
			case 'png':
			echo $img_r;
				return $img_r=imagecreatefrompng($filename);
			break;
			case 'gif':
				return $img_r=imagecreatefromgif($filename);
			break;
			default:
				throw new InvalidArgumentException('File "'.$filename.'" is not valid jpg, png or gif image.');
			break;
			}
		}  

	$img_r 	= imagecreatefromfile($src);
	$dst_r 	= ImageCreateTrueColor($_POST['w']*$_POST['prop'],$_POST['h']*$_POST['prop']);

	imagecopyresized($dst_r,$img_r,0,0,$_POST['x']*$_POST['prop'],$_POST['y']*$_POST['prop'],$_POST['w']*$_POST['prop'],$_POST['h']*$_POST['prop'],$_POST['w']*$_POST['prop'],$_POST['h']*$_POST['prop']);
	imagejpeg($dst_r,$src0);
	chmod($src0, 0777);

	$rotar = imagerotate($img_r, $grados, 0);

	// Imprimir
	imagejpeg($rotar,$src1);

}

// If not a POST request, display page below:

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
  <title>B</title>
  <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
  <script src="../js/jquery.min.js"></script>
  <script src="../js/jquery.Jcrop.js"></script>
  <link rel="stylesheet" href="../css/main.css" type="text/css" />
<link rel="stylesheet" href="../css/demos.css" type="text/css" />
<link rel="stylesheet" href="../css/jquery.Jcrop.css" type="text/css" />
  <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(
hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="../css/style.css" rel="stylesheet" type="text/css" media="all" />
<link rel="shortcut icon" type="image/x-icon" href="../images/favicon.ico" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href="../css/flexnav.css" rel="stylesheet" type="text/css" media="all" />
  
  <script type="text/javascript">

  $(function(){
    $('#cropbox').Jcrop({      
      onSelect: updateCoords
    });
  });

  function updateCoords(c){
    $('#x').val(c.x);
    $('#y').val(c.y);
    $('#w').val(c.w);
    $('#h').val(c.h);
	$('#screen').val($(window).width());
  };

  function checkCoords(){
    if (parseInt($('#w').val())) return true;
    alert('Please select a crop region then press submit.');
    return false;
  };

  </script>

</head>

<body>
<?php include "../includes/header.php"; ?>
<div class="content">
   	<div class="wrap">
	  <script src="../js/jquery.Jcrop.js"></script>
	
<div class="row">
<!--<div class="span12">-->
<div class="jc-demo-box">
<?php include "../includes/banner.php"; ?>	
<div class="page-header"><h1>Step B: Image Crop</h1></div>
<?php
if (isset($_POST['photo'])) {
?>
<p style="text-align: right;">
<a href="E.php?photo=<?php echo $_POST['photo']. "&screen=" . $_POST["screen"]; ?>"><img src="../css/return.png" width="12" height="20"><font>Original photo</font></a>
</p>
<?php
}
?>		<!-- This is the image we're attaching Jcrop to -->
		<?php				
		if (isset($_GET['photo'])) {
			$x_sixe = $_GET['screen']*0.9;
			$photo		=	$dir_files . $_GET['photo'];
			$size 		= 	GetImageSize("$photo");
			$x1			=	$size[0]; 
			$y1			=	$size[1]; 		
			$prop		=	$x1 / $x_sixe;
			$y_sixe		=	$y1 / $prop;
		
			//echo "<img src=\"" . $photo . "\" id=\"cropbox\" width=\"100%\" />";
			echo "<img src=\"" . $photo . "\" id=\"cropbox\" width=\"" . $x_sixe . "\" height=\"" .$y_sixe . "\"/>";
			#echo "<img src=\"" . $photo . "\" id=\"cropbox\" width=\"900\" height=\"" . $y_sixe . "\"/>";
			
		?>
		<!-- This is the form that our event handler fills -->
		<form action="E.php" method="post" onsubmit="return checkCoords();">
			<input type="hidden" id="x" name="x" />
			<input type="hidden" id="y" name="y" />
			<input type="hidden" id="w" name="w" />
			<input type="hidden" id="h" name="h" />
			<input type="hidden" id="screen" name="screen" value="<?php echo $_GET['screen']; ?>" />
			<input type="hidden" id="folder" name="folder" value="files"/>
			<input type="hidden" id="prop"  name="prop" value="<?php echo $prop; ?>"/>
			<input type="hidden" id="photo" name="photo" value="<?php echo $_GET['photo']; ?>"/>
			<p style="text-align: center;"><input type="submit" value="Crop Image" class="btn btn-large btn-inverse" /></p>
		</form>
		<?
		}
		if (isset($_POST['photo'])) {
			$x_sixe = $_POST['screen']*0.9;
			$photo_		=	$dir_thmb . $_POST['photo']; 
			$size_ 		= 	GetImageSize("$photo_");
			$x1_		=	$size_[0]; 
			$y1_		=	$size_[1]; 		
			$prop_		=	$x1_ / $x_sixe;
			$y_sixe_	=	$y1_ / $prop_;
			
			//echo "<img src=\"" . $photo_ . "\" id=\"cropbox\" width=\"900\" />";
			echo "<img src=\"" . $photo_ . "\" id=\"cropbox\" width=\"" . $x_sixe . "\" height=\"" .$y_sixe_ . "\"/>";
		?>
			<!-- This is the form that our event handler fills -->
		<form action="E.php" method="post">
			<input type="hidden" id="x" name="x" />
			<input type="hidden" id="y" name="y" />
			<input type="hidden" id="w" name="w" />
			<input type="hidden" id="h" name="h" />
			<input type="hidden" id="screen" name="screen" value="<?php echo $_POST['screen']; ?>" />
			<input type="hidden" id="folder" name="folder" value="thumbnail"/>
			<input type="hidden" id="prop"  name="prop" value="<?php echo $prop_; ?>"/>	
			<input type="hidden" id="photo" name="photo" value="<?php echo $_POST['photo']; ?>"/>
			<p style="text-align: left;">
			<input type="submit" value="Resize" class="btn btn-small btn-info" /></p>
		</form>
		
		<form action="E.php" method="post">
			<input type="hidden" id="photo" name="photo" value="<?php echo $_POST['photo']; ?>"/>
			<input type="hidden" id="screen" name="screen" value="<?php echo $_POST['screen']; ?>"/>
			<p style="text-align: center;"><input type="submit" value="Run" class="btn btn-large btn-inverse" /></p>
		</form>
		<?php
		}
		?>
		
</div>
</div>
</div>
</div>
</body>

</html>