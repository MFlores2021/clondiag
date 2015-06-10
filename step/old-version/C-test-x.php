<?php
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$photo_		=	 '../thumbnail/image.jpg'; 
	}

	//$result   = exec ("R --vanilla --slave '--args image.jpg' < /var/www/clondiag/R/code.R");
	//echo $result;

?>
<!DOCTYPE html> 
<html lang="en">
.background {
width:900px;
height:900px;
-moz-background-size: 100% 100%;
}
<head>
  <title>Step C</title>
  <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />

  <link rel="stylesheet" href="../css/main.css" type="text/css" />
  <link rel="stylesheet" href="../css/demos.css" type="text/css" />  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js" type="text/javascript"></script>
  <script src="http://davidlynch.org/projects/maphilight/jquery.maphilight.js" type="text/javascript" > </script>
  <script type="text/javascript">
	$(function() {
	
	//  $(".map").maphilight({maxWidth:"auto", edgeOffset: 10});
	
      $('.map').maphilight({backgroundSize: "100% 100%",groupBy: 'alt'});
      $('#squidheadlink').mouseover(function(e) {
            $('area[id^=squidhead]').mouseover();
        }).mouseout(function(e) {
            $('area[id^=squidhead]').mouseout();
        }).click(function(e) { e.preventDefault(); });
	});
	
  </script>
  <style type="text/css">
	area[shape="poly"]:hover {border:1px solid red; }
  </style>
</head>
<body>
<div class="container">
<div class="row">
<div class="span12">
<div class="jc-demo-box">
<div class="page-header">
<h1>Step C: Run R</h1>
</div>
<?php
    function imagecreatefromfile( $filename ) {
    if (!file_exists($filename)) {
        throw new InvalidArgumentException('File "'.$filename.'" not found.');
    }
    switch ( strtolower( pathinfo( $filename, PATHINFO_EXTENSION ))) {
        case 'jpeg':
        case 'jpg':
            return $img_r=imagecreatefromjpeg($filename);
        break;
        case 'png':
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
$fila = 0;
if (($gestor = fopen("../result/test.csv", "r")) !== FALSE) {
    while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {
        $numero = count($datos);
		$fila++;
        for ($c=0; $c < $numero; $c++) {
         $valor[$fila][$c+1] = $datos[$c];
        }		
    }
    fclose($gestor);
}
$fila2 = 0;
if (($gestor2 = fopen("../step/data-virus.csv", "r")) !== FALSE) {
    while (($datos2 = fgetcsv($gestor2, 1000, ",")) !== FALSE) {
        $numero2 = count($datos2);
		$fila2++;
		
        for ($c2=0; $c2 < $numero; $c2++) {
         $valor2[$fila2][$c2+1] = $datos2[$c2];
        }		
    }
    fclose($gestor);
}

else { echo "nothing"; }

//if (isset('image.jpg')) {
	$photo_		=	'../result/image.jpg'; 

	$size_ 		= 	GetImageSize("$photo_");
	$x1_		=	$size_[0]; 
	$y1_		=	$size_[1]; 		
	$prop_		=	$x1_ / 900;
	$y_sixe_	=	$y1_ / $prop_;
	
	$new_image = '../result/imagexx.jpg'; 
	$img_r 	= imagecreatefromfile($photo_);
	$dst_r 	= ImageCreateTrueColor( 900, $y_sixe_);
	imagecopyresampled($dst_r, $img_r, 0, 0, 0, 0, 900, $y_sixe_, $x1_, $y1_);
 	imagejpeg($dst_r,$new_image);

	#echo "<DIV STYLE=\"position:absolute; top:100px; left:50px; width:900px; height:" . $y_sixe_ . "px; visibility:visible z-index:2\">";
	#echo "<img src=\"" . $photo_ . "\" width=\"900\" height=\"" . $y_sixe_ . "\" style=\"display:block; max-height:100%; max-width:100%; \" ismap=\"ismap\" usemap=\"#Mapa\"/>";
	#echo "</DIV>";
	#echo "<DIV STYLE=\"position:absolute; top:100px; left:50px; width:900px; height:" . $y_sixe_ . "px; visibility:hidden z-index:1 ; opacity: 0.5;\">";
	echo "<img src=\"" . $new_image . "\"  width=\"900\" height=\"" . $y_sixe_ . "\" class=\"map\" usemap=\"#Mapa\"/>";
	#echo "</DIV>";	
//}

	$dx			=	900 / 14 ;
	$dy			=	$y_sixe_ / 14 ;
?>

<map id="Mapa" name="Mapa">
<?php


$count=1; 

for ($j = 0; $j < 14; $j++){
$yIni	=	$dy *  $j;
$yFin	=	$dy * ($j + 1);
for ($i = 0; $i < 14; $i++){
$xIni	=	$dx *  $i;
$xFin	=	$dx * ($i + 1);

if ( $valor2[$count][2] != "NA"){
echo "<area id=\"squidhead".$count."\" alt=\"" . $valor2[$count][2] . "\" href=\"#\" shape=\"poly\" coords=\"".$xIni.",".$yIni.","  .$xIni.",".$yFin.","  .$xFin.",".$yFin.",".$xFin.",".$yIni."\"  title=\" (+/-) <br><br><br> Value = ".$valor[$j+2][$i+1]."  <br><br><br> Virus: " . $valor2[$count][2] . " \" stroke: true strokeColor: 'ff0000' >";
}
$count=$count+1;
$array1[$count] = $valor[$j+2][$i+1];

$array2[$count] = $valor2[$count][2];

$result_[$count] = array_merge($valor[$j+2][$i+1] , $valor2[$count][2] );
#echo $valor2[$count][2];
}}

?>
<!--0,0,0,15,15,15,15,0-->
</map>

</div>
<form action="C-test.php" method="post" onsubmit="return checkCoords();">
			<p style="text-align: center;"><input type="submit" value="Stadistic" class="btn btn-large btn-inverse" /></p>
		</form>
		
	<a  href="#" onclick="return light();"><p style="text-align: left;"><input id="squidheadlink" type="submit" value="Positive Controls " class="btn btn-large btn-inverse" /></p></a>
</div>
</div>
</div>
</body>

</html>