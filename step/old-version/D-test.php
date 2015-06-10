<?php
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	$photo_		=	 '../thumbnail/image.jpg'; 
	
	}

	$codeR 		=	"library(EBImage)
	setwd(\"/var/www/clondiag/thumbnail/\")
	input <- \"/var/www/clondiag/thumbnail/image.jpg\"
	im  <- readImage(input)
	chan11 <- channel(im, \"green\")
	chan11";
		
	$fd = fopen ( "/var/www/clondiag/R/image.jpg.R", "w");
	fwrite ($fd, $codeR);
	fclose($fd);

	//$result   = exec ("R --vanilla --slave '--args image.jpg' < /var/www/clondiag/R/code.R");

	//echo $result;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
  <title>Step C</title>
  <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
  <link rel="stylesheet" href="../css/main.css" type="text/css" />
  <link rel="stylesheet" href="../css/demos.css" type="text/css" />  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js" type="text/javascript"></script>
  <script src="jquery.maphilight.js" type="text/javascript"></script>
  <script type="text/javascript">
  $(function() {
	$('.map').maphilight();
	$('#squidheadlink').mouseover(function(e) {
		$('#squidhead').mouseover();
	}).mouseout(function(e) {
		$('#squidhead').mouseout();
	}).click(function(e) { e.preventDefault(); });
  });
  </script>
  <style type="text/css">
	area[shape="poly"]:hover {border:5px solid red; no-repeat;}
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
//if (isset('image.jpg')) {
	$photo_		=	 '../result/image.jpg'; 
	$size_ 		= 	GetImageSize("$photo_");
	$x1_		=	$size_[0]; 
	$y1_		=	$size_[1]; 		
	$prop_		=	$x1_ / 900;
	$y_sixe_	=	$y1_ / $prop_;
	echo "<img src=\"" . $photo_ . "\" width=\"900\" height=\"" . $y_sixe_ . "\" style=\"display:block; max-height:100%; max-width:100%; \" class=\"map\"  usemap=\"#Mapa\"/>";
		
//}

	$dx			=	900 / 14 ;
	$dy			=	$y_sixe_ / 14 ;
?>
<map id="Mapa" name="Mapa">
<?php

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
//echo "valor => " . $valor2[5][2] . "<br/>";
//echo "valor => " . $valor2[222][2] . "<br/>";
$count=1; $a= 0;

for ($j = 0; $j < 14; $j++){
$yIni	=	$dy *  $j;
$yFin	=	$dy * ($j + 1);
for ($i = 0; $i < 14; $i++){
$xIni	=	$dx *  $i;
$xFin	=	$dx * ($i + 1);

//echo "valor[".$j."+1][".$i."]: " . $valor[$j+2][$i+1] . "<br/>";

echo "<area href=\"#\" shape=\"poly\" coords=\"".$xIni.",".$yIni.","  .$xIni.",".$yFin.","  .$xFin.",".$yFin.",".$xFin.",".$yIni."\"  alt=\"Link\" title=\" (+/-) <br><br><br> Value = ".$valor[$j+2][$i+1]."  <br><br><br> Virus: " . $valor2[$count][2] . " \">";
$count=$count+1;

}
}

//title=\"Value = ".$valor[$j+2][$i+1]."\"
?>

<!--- echo "<area shape=\"poly\" coords=\"".$xIni.",".$yIni.","  .$xIni.",".$yFin.","  .$xFin.",".$yFin.",".$xFin.",".$yIni."\" href=\"http://localhost/home.php?lg=".$count.",value=".$valor[$j+2][$i+1]."\">
	echo "<area shape=\"poly\" coords=\"".$xIni.",0,"  .$xFin.",0,".   $xFin.",".$dy.","  .$xIni.",".$dy."\" href=\"http://localhost/home.php?lg=".$count."\">";
  <area shape="poly" coords="0,0,0,15,15,15,15,0" href="http://localhost
  /home.php?lg=1">
--><!--0,0,0,15,15,15,15,0-->
</map>
</div>
</div>
</div>
</div>
</body>

</html>