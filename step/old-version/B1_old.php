<?php
session_start();
if(isset($_SESSION)) {
	
	$currentProject	=	$_SESSION["ClonDiagProject"]; 
	$currentTest	=	$_SESSION["ClonDiagTest"]; 
	$currentBook	=	$_SESSION["ClonDiagBook"];
		
	if (!($currentProject AND $currentTest AND $currentBook)){
		echo "<script language=\"javascript\">top.location.href=\"../login.php\"</script>";
	}
} else {
	echo "<script language=\"javascript\">top.location.href=\"../login.php\"</script>";
}

	$dir_c			=	"../projects/$currentProject/$currentTest/"; 

	$dir_thmb		=	$dir_c . "thumbnail/";
	
	
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

	if (!file_exists($dir_thmb)) {
		mkdir($dir_thmb);		
	}

	$jpeg_quality = 100;

	$src0 		=	$dir_thmb . $_POST['photo'];  

	if($_POST['folder']  ==  "thumbnail"){
	
		$info 	= 	pathinfo($src0);
		$src 	=	$info['dirname'] . '/' . $info['filename'] . "_2." . $info['extension']; 

		copy($src0,$src) or die("Unable to rename $src0.");
		chmod($src, 0777);
	
		$src 	=	$dir_thmb . $info['filename'] . "_2." . $info['extension']; 
		$src0 	=	$dir_thmb . $_POST['photo']; 	

		unlink($src0);				
	
	///* Para guardar imagen
	include "../function/imagecreatefromfile.php"; 

	$img_r 	= imagecreatefromfile($src);
	$angle = $_POST['angle'];
	$rotar = imagerotate($img_r, $angle*-1, 0);

	// Imprimir
	imagejpeg($rotar,$src0);

	header("location:C.php?photo=". $_POST['photo'] . "&screen=" . $_POST["screen"]);
		exit();	
	}
}

// If not a POST request, display page below:

?>
<!DOCTYPE html>
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
  <script src="raphael.js"></script>
  <script type="text/javascript">

	function loadImage(width,height){
			var src = document.getElementById("bee").src,
				angle = 0;
			document.getElementById("holder").innerHTML = "";
			
			var R = Raphael("holder", width, $(window).width()+50);
			R.circle(320, 240, 50).attr({fill: "#fff", "fill-opacity": .5, "stroke-width": 0});
			if (height>width) {
				size = height/width;	
				marginw =10+(height-width)/10; //height/8;	
				marginh =50;
			} else{
				size = 1.25;
				marginw =10;	
				marginh =50+(width-height)/8; //width/2;
							
			}
				marbut1=$(window).width()*1/3-40;	
				marbut2=$(window).width()*2/3-40;
			var img = R.image(src, marginw,marginh,  width/size, height/size);
			var butt1 = R.set(),
				butt2 = R.set();
			butt1.push(R.circle(24.833, 26.917, 26.667).attr({stroke: "#ccc", fill: "#fff", "fill-opacity": .4, "stroke-width": 2}),
					   R.path("M12.582,9.551C3.251,16.237,0.921,29.021,7.08,38.564l-2.36,1.689l4.893,2.262l4.893,2.262l-0.568-5.36l-0.567-5.359l-2.365,1.694c-4.657-7.375-2.83-17.185,4.352-22.33c7.451-5.338,17.817-3.625,23.156,3.824c5.337,7.449,3.625,17.813-3.821,23.152l2.857,3.988c9.617-6.893,11.827-20.277,4.935-29.896C35.591,4.87,22.204,2.658,12.582,9.551z").attr({stroke: "none", fill: "#000"}),
					   R.circle(24.833, 26.917, 26.667).attr({fill: "#fff", opacity: 0}));
			butt2.push(R.circle(24.833, 26.917, 26.667).attr({stroke: "#ccc", fill: "#fff", "fill-opacity": .4, "stroke-width": 2}),
					   R.path("M37.566,9.551c9.331,6.686,11.661,19.471,5.502,29.014l2.36,1.689l-4.893,2.262l-4.893,2.262l0.568-5.36l0.567-5.359l2.365,1.694c4.657-7.375,2.83-17.185-4.352-22.33c-7.451-5.338-17.817-3.625-23.156,3.824C6.3,24.695,8.012,35.06,15.458,40.398l-2.857,3.988C2.983,37.494,0.773,24.109,7.666,14.49C14.558,4.87,27.944,2.658,37.566,9.551z").attr({stroke: "none", fill: "#000"}),
					   R.circle(24.833, 26.917, 26.667).attr({fill: "#fff", opacity: 0}));
			butt1.translate(marbut1, 0);
			butt2.translate(marbut2, 0);
			butt1[2].click(function () {
				angle -= Number(document.getElementById("angle1").value);
				img.stop().animate({transform: "r" + angle}, 1000, "<>");	
				document.getElementById("angle").value=angle; 
				
			}).mouseover(function () {
				butt1[1].animate({fill: "#fc0"}, 300);
			}).mouseout(function () {
				butt1[1].stop().attr({fill: "#000"});
			});
			butt2[2].click(function () {
				angle += Number(document.getElementById("angle1").value);
				img.animate({transform: "r" + angle}, 1000, "<>");	document.getElementById("angle").value=angle;
			}).mouseover(function () {
				butt2[1].animate({fill: "#fc0"}, 300);
			}).mouseout(function () {
				butt2[1].stop().attr({fill: "#000"});
			});
			
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
<div class="page-header"><h1>Step B: Image Rotate</h1></div>
<?php
if (isset($_POST['photo'])) {
?>
<p style="text-align: right;">
<a href="B.php?photo=<?php echo $_POST['photo']. "&screen=" . $_POST["screen"]; ?>"><img src="../css/return.png" width="12" height="20"><font>Original photo</font></a>
</p>
Angle: <input id="angle1" type="text" name="angle1">
<?php
}
?>		<!-- This is the image we're attaching Jcrop to -->
		<?php				
		if (isset($_POST['photo'])) {
			$x_sixe 	= 	$_POST['screen']*0.9;
			$photo		=	$dir_thmb . $_POST['photo'];
			$size 		= 	GetImageSize("$photo");
			$x1			=	$size[0]; 
			$y1			=	$size[1]; 		
			$prop		=	$x1 / $x_sixe;
			$y_sixe		=	$y1 / $prop;
			
			echo "<div id='holder'>";
			echo "<img id='bee' src=\"" . $photo . "\" width=\"" . $x_sixe . "\" height=\"" .$y_sixe . "\" onload=\"loadImage(" . $x_sixe . "," .$y_sixe . ")\"/>";
			echo "</div>";
			
		?>
		<!-- This is the form that our event handler fills -->
		
		<form action="B1.php" method="post">
			<input type="hidden" id="angle" name="angle" />
			<input type="hidden" id="screen" name="screen" value="<?php echo $_POST['screen']; ?>" />
			<input type="hidden" id="folder" name="folder" value="thumbnail"/>
			<input type="hidden" id="prop"  name="prop" value="<?php echo $prop_; ?>"/>	
			<input type="hidden" id="photo" name="photo" value="<?php echo $_POST['photo']; ?>"/>
			<p style="text-align: center;"><input type="submit" name="run"  value="Run" class="btn btn-small btn-info"/></p>
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