<?php

	ob_start();
	include_once "/var/www/clondiag/conn/conn.php";
	include_once "/var/www/clondiag/function/checkpermission.php";

	if(!isset($_SESSION)) {
		session_start();
		$currentProject	=	$_SESSION["ClonDiagProject"];
		$currentTest	=	$_SESSION["ClonDiagTest"];
		$currentBook	=	"datavirus.csv"; //$_SESSION["ClonDiagBook"];	
		$size_array		=	$_SESSION["ClonDiagArray"];
		$currentUser	=	$_SESSION["ClonDiagUser"];
		
		if (!($currentProject AND $currentTest AND $currentBook AND $size_array AND checkpermission($currentUser,$currentTest))){
			echo "<script language=\"javascript\">top.location.href=\"/clondiag/login.php\"</script>";
		}
	} else {
		echo "<script language=\"javascript\">top.location.href=\"/clondiag/login.php\"</script>";
	}

	$dir_c				= "../projects/$currentProject/$currentTest/"; 
	$dir_d				= "/clondiag/projects/$currentProject/$currentTest/"; 
	$dir_thmb			= $dir_c . "thumbnail/";
	$dir_result			= $dir_c . "result/";
	$dir_result1		= $dir_d . "result/";
	$dir_book			= "../projects/$currentProject/" . $currentBook ;
	$dir_book1			= "../projects/$currentProject/";
	if (!file_exists($dir_result)) {
		mkdir($dir_result);
	}	

	$photo_		=	 $dir_thmb . $_GET['photo']; 			
	$photo_dir =  "/var/www/clondiag/projects/$currentProject/$currentTest/";
	$proj_dir =  "/var/www/clondiag/projects/$currentProject/";
		
	include "../function/imagecreatefromfile.php"; 

		//$coords = exec ("R --vanilla --slave '--args " . $_GET['photo'] . " " . $photo_dir . "' < /var/www/clondiag/R/recutlnx.R");
		// $coord	= preg_split("/\s+/", $coords); 
		
		// if(count($coord)==5){	
		
			// $src_image	= $dir_thmb . "output.jpg";
			// $src0 		= $dir_thmb . $_GET['photo']; 		
				
			// $img_r 	= imagecreatefromfile($src_image);
			// $dst_r 	= ImageCreateTrueColor($coord[1],$coord[2]);

			// imagecopyresized($dst_r,$img_r,0,0,$coord[3],$coord[4],$coord[1],$coord[2],$coord[1],$coord[2]);
			// imagejpeg($dst_r,$src0);
		// }

	$result   	= exec ("R --vanilla --slave '--args " . $_GET['photo'] . " " . $photo_dir . " " . $size_array . " " . $proj_dir ." " . $currentProject ."' < /var/www/clondiag/R/code.R");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
	<title>Step C</title>
	<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
	<link rel="stylesheet" href="/clondiag/css/tipTip.css" type="text/css" >
	<link rel="stylesheet" href="/clondiag/css/main.css" type="text/css" />
	<link rel="stylesheet" href="/clondiag/css/demos.css" type="text/css" />
	<link rel="stylesheet" href="/clondiag/css/table.css" type="text/css" />
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
	<link href="/clondiag/css/style.css" rel="stylesheet" type="text/css" media="all" />
	<link rel="shortcut icon" type="image/x-icon" href="../images/favicon.ico" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link href="/clondiag/css/flexnav.css" rel="stylesheet" type="text/css" media="all" />

	<style type='text/css' title='currentStyle'>
			@import '/clondiag/css/demo_page.css';
			@import '/clondiag/css/demo_table_jui.css';
			@import '/clondiag/css/jquery-ui-1.8.4.custom.css';
	</style>

	<script src="/clondiag/js/jquery.tipTip.minified.js"></script> 	
	<script type="text/javascript"> 
	$(function() {
		$('.map').maphilight({groupBy: 'alt', fillOpacity:0}).tipTip({maxWidth: "auto", edgeOffset: 10, defaultPosition: "right"});	 
			$('#squidheadlink').mouseover(function(e) {
				$('area[id^=squidhead]').mouseover();
			}).mouseout(function(e) {
				$('area[id^=squidhead]').mouseout();
			}).click(function(e) { e.preventDefault(); }); 
		
	// for table link
		$('a[id^=similarlink]').mouseover(function(e) {
			mapitem = $(this).attr('id');
			mapitem = mapitem.replace("similarlink", "squid");
			$('area[id^=' + mapitem + ']').mouseover();
			
			mapitem1 = $(this).attr('id');
			mapitem1 = mapitem1.replace("similarlink", "squidhead");
			$('area[id^=' + mapitem1 + ']').mouseover();	
			
		}).mouseout(function(e) {
			$('area[id^=' + mapitem + ']').mouseout();
			$('area[id^=' + mapitem1 + ']').mouseout();
		}); 
	});
	</script>
</head>
<body style="background-color:#ffffff;">
	
	<?php include "../includes/header.php"; ?>
	
	<div class="content">
		<div class="wrap">
			<script src="http://davidlynch.org/projects/maphilight/jquery.maphilight.js" type="text/javascript" ></script>
			<div class="row">
				<div class="jc-demo-box">
					<?php include "../includes/banner.php"; ?>	
					<div class="page-header" style="position: relative">
						<h1>Step C: Run R</h1>
					</div>
					<?php
						if (isset($_GET['photo'])) {

							$x_sixe = $_GET['screen']*0.9;
							$photo_		=	$dir_thmb . $_GET['photo']; 
							$size_ 		= 	GetImageSize("$photo_");
							$x1_		=	$size_[0]; 
							$y1_		=	$size_[1]; 		
							$prop_		=	$x1_ / $x_sixe;
							$y_sixe_	=	$y1_ / $prop_;								
							$new_image  =	$dir_result . "2" . $_GET['photo'];   
							$new_image1 =	$dir_result1 . "2" . $_GET['photo']; 								
							$img_r 		=	imagecreatefromfile($photo_);								
							$dst_r 		=	ImageCreateTrueColor( $x_sixe, $y_sixe_); 
							
							imagecopyresampled($dst_r, $img_r, 0, 0, 0, 0, $x_sixe, $y_sixe_, $x1_, $y1_);
							imagejpeg($dst_r,$new_image);
							
							echo "<img src=\"" . $new_image1 . "\" width=\"". $x_sixe ."\" height=\"" . $y_sixe_ . "\" class=\"map\" usemap=\"#Mapa\"/>";
						}
						$dx			=	$x_sixe / $size_array ;
						$dy			=	$y_sixe_ / $size_array ;
					?>
					<script src="/clondiag/js/jquery.tipTip.minified.js"></script> 
					<map id="Mapa" name="Mapa">
					<?php
						$fila = 0;
						if (($gestor = fopen($dir_result .$_GET['photo']."-int.csv", "r")) !== FALSE) {
							while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {
								$numero = count($datos);
								$fila++;
								for ($c=0; $c < $numero; $c++) {
									$valor[$fila][$c+1] = $datos[$c];
								}		
							}
							fclose($gestor);
						}

						$fila2 = $size_array -2 ; $fila2x = -1; $cont = 0;

						if (($gestor2 = fopen($dir_book, "r")) !== FALSE) {
							while (($datos2 = fgetcsv($gestor2, 1000, ",")) !== FALSE) {
								$numero2 = count($datos2);										
								
								while ( $datos2[0] > $cont && $datos2[0] != "ID" &&  $fila2 > -2){										
									$valor2[$fila2+1][$fila2x] = "NA"; 
									
									if($fila2x >$size_array-2){
										$fila2x = -1;	 $fila2--; 	 
									}
										$fila2x++; $cont++;
								}
								$valor2[$fila2+1][$fila2x] = $datos2[1];
								$names[$cont] = $datos2[1];
								
								if($fila2x > $size_array -2){
									$fila2x = -1;	 $fila2--; 	 
								}
								$fila2x++; 	$cont++;
							}
							fclose($gestor2);								
						}
						else { echo "nothing"; }

						$fila3 = 0;
						if (($gestor3 = fopen($dir_result .$_GET['photo']."-pos.csv", "r")) !== FALSE) {
							while (($datos3 = fgetcsv($gestor3, 1000, ",")) !== FALSE) {
								$numero3 = count($datos3);
								$fila3++;
								
								for ($c3=0; $c3 < $numero3; $c3++) {
								 $valor3[$fila3][$c3+1] = $datos3[$c3];		
								}		
							}
							fclose($gestor3);
						}

						$count=1; $a= 0;
						for ($j = 0; $j < $size_array; $j++){
							$yIni	=	$dy *  $j;
							$yFin	=	$dy * ($j + 1);
							
							for ($i = 0; $i < $size_array; $i++){
								$xIni	=	$dx *  $i;
								$xFin	=	$dx * ($i + 1);

								if ($valor3[$j+2][$i+1] == "TRUE"){
									$tablavirus2[$count] = $valor2[$j][$i];
									$name = "squidhead" . $tablavirus2[$count] . $count;
								} else {
									$name = "squid" . $valor2[$j][$i].count;
								}
								$name = str_replace(' ', '_', $name);

								if ( $valor2[$j][$i]  != "NA"){
									echo "<area id=\"".$name."\" alt=\"" . $valor2[$j][$i] . "\" shape=\"poly\" coords=\"". $xIni .",". $yIni .","  . $xIni .",".$yFin.","  .$xFin.",".$yFin.",".$xFin.",".$yIni."\" href=\"#\" class=\"map\" style=\"position: absolute\" usemap=\"#Mapa\" title=\" Infected = " . $valor3[$j+2][$i+1] . " <br> Value = ".$valor[$j+2][$i+1]."  <br> Virus: " . $valor2[$j][$i] . " \">";
									#echo $name." -". $valor2[$j][$i]." coords=". $xIni .",". $yIni .","  . $xIni .",".$yFin.","  .$xFin.",".$yFin.",".$xFin.",".$yIni ."Infected = " . $valor3[$j+2][$i+1] . " Value = ".$valor[$j+2][$i+1]." Virus: " . $valor2[$j][$i] ;
								}
								$count=$count+1;
							}
						}
					?>
					</map>
				</div>
				<?php
					$nameslist	= file_get_contents($dir_book1."names.txt");
					$tablavirus2= str_replace(' ', '_', $tablavirus2);
					$names 		= str_replace(' ', '_', $names);
					$resulta 	= exec ("R --vanilla --slave '--args " . $_GET['photo'] . " " . implode("@",$tablavirus2).$nameslist . " " . $photo_dir . " " . implode("@",$names) . "' < /var/www/clondiag/R/code2.R");
					$fila4 = 0;
					
					if (($gestor4 = fopen($dir_result .$_GET['photo']."-mm.csv", "r")) !== FALSE) {

						while (($datos4 = fgetcsv($gestor4, 1000, ",")) !== FALSE) {
							$numero4 = count($datos4);
							$fila4++;
							
							for ($c4=0; $c4 < $numero4; $c4++) {
								$valor4[$fila4][$c4+1] = $datos4[$c4];										
							}
						}
						fclose($gestor4);
					}
				?>
				<div>
					<table>
						<tr>
							<td>
								<table class="CSSTableGenerator">
									<tr><td>Virus</td><td>Frec.</td></tr>
									<?php
										for ($k = 1; $k < $fila4; $k++){
											$color = 'black';
											
											if ($valor4[$k+1][2]/$valor4[$k+1][3]>=0.5){
												$color = 'red';
											}
										 
											if ($valor4[$k+1][1]=='plant_18S' || $valor4[$k+1][1]=='neg-' || $valor4[$k+1][1]=='Biotin-Marke_2,5uM' || $valor4[$k+1][1]=='Spotting_Puffer'){
												$color = 'blue';
											}
											echo "<tr><td>";
											echo "<a id=\"similarlink" . $valor4[$k+1][1] . "\" href=\"#\"><font color='".$color."'>" . $valor4[$k+1][1] . "</font></a><br>";
											//echo "<a id=\"similarlink" . $valor4[$k+1][1] . "\" onmouseover=\"light('" . $valor4[$k+1][1] . "');\" href=\"#\"><font color='".$color."'>" . $valor4[$k+1][1] . "</font></a><br>";
											echo "</td><td><font color='".$color."'>" . $valor4[$k+1][2] ."/" . $valor4[$k+1][3] ."</font></td></tr>"; //
										}
									?>
								</table>
							</td>
							<td>
								<form action="D.php" method="post">
									<input type="hidden" id="photo" name="photo" value="<?php echo $_GET['photo']; ?>"/>
								</form><br>
								<a href="#" onclick="return light();"><p style="text-align: left;"><input id="squidheadlink" type="submit" value="+ Controls" class="btn btn-large btn-inverse" /></p></a>
							</td>
						</tr>
					</table>
					<?php
						$dir_c	= "/clondiag/projects/$currentProject/$currentTest/result/"; 
						
						echo "<br>";
						echo "<img src=\"". $dir_c .$_GET['photo']." 2.png\" width=\"900\"\">";
						echo "<br>";
						echo "<img src=\"". $dir_c .$_GET['photo']." .png\" width=\"900\"\">";
						
						include "../includes/footer.php";
						
						$myStaticHtml = ob_get_clean();
						
						$forstart		= "<?php  
											include '/var/www/clondiag/conn/conn.php';
											include '/var/www/clondiag/function/checkpermission.php'; 
											if(!isset($"."_SESSION)) {
											session_start();
											$"."currentUser	=	$"."_SESSION['ClonDiagUser'];
											$"."currentTest	=	$"."_SESSION['ClonDiagTest'];
											if (checkpermission($"."currentUser,$"."currentTest)!=TRUE){
												echo '<script language=\"javascript\">top.location.href=\"/clondiag/index.php\"</script>';
												}
											} else {
												echo '<script language=\"javascript\">top.location.href=\"/clondiag/login.php\"</script>';
											} ?>
											";

						$fp = fopen($dir_result."result.php","w");  
						fwrite($fp,$forstart);  
						fwrite($fp,$myStaticHtml);  
						fclose($fp); 
						   
						echo "<script language=\"javascript\">top.location.href=\"/clondiag/projects/".$currentProject."/".$currentTest."/result/result.php\"</script>";
					?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>