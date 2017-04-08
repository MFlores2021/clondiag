<!--
Author: MFlores (CIP)
-->

<?php include_once "includes/includes.php"; ?>
<?php include_once "function/previousresult.php"; ?>
<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete']) && isset($_POST['dir']) && isset($_POST['id'])){
  
		$status		=	previousdelete($_POST['id'],$_POST['dir']);
	    
	}
?>
	
<!DOCTYPE HTML>
<html>
	<head>
		<title>Clondiag</title>	
		<meta name="keywords" content="clondiag,potato,sweetpotato,cipotato,research" />
		<script type="application/x-javascript"> 
			addEventListener("load", function() { 
			setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } 
		</script>
		<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
		<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link href="css/flexnav.css" rel="stylesheet" type="text/css" media="all" />
		<script src="js/jquery.min.js"></script>
		<style type='text/css' title='currentStyle'>
			@import 'css/demo_page.css';
			@import 'css/demo_table_jui.css';
			@import 'css/jquery-ui-1.8.4.custom.css';
		</style>
		<script type='text/javascript' language='javascript' src='js/jquery.js'></script>
		<script type='text/javascript' language='javascript' src='js/jquery.dataTables.js'></script>
		<script type='text/javascript' language='javascript' src='js/mootools-core-1.4.5-full-compat-yc.js'></script>
		<script type='text/javascript' charset='utf-8'>
			$(document).ready(function() {
				oTable = $('#example').dataTable({
					'aaSorting': [ [0,'desc']],
					'iDisplayLength': 25,
					'aLengthMenu': [[25, 50, 100, -1], [25, 50, 100, 'All']],
					'bJQueryUI': true
				});
			} );
		</script>
	</head>
<body id='dt_example'>

	<?php
		include_once "includes/header.php"; 
		
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
		
	?>
			
	<div class="content">
		<div class="wrap">	
			<?php include "includes/banner.php"; ?>			
			<div class="grids">	
				<div class="contact">
					<div class="contact-left">
						<h2>Previous result</h2>			
						<div class="clear">
							<div class='demo_jui'>					
								<table cellpadding='0' cellspacing='0' border='0' class='display' id='example'>
									<thead>
										<tr>
											<th>Date</th>
											<th>Read</th>
											<th>Owner</th>
											<th>Project</th>
											<th>Del</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$result		=	previousresult($_SESSION["ClonDiagUser"]);
										echo $result;
										?>
									</tbody>
								</table>
							</div>
							<?php include "includes/footer.php"; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
</body>
</html>