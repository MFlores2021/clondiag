<div class="header">
<div class="wrap">
<header id="site-header">
	<div class="menu-button">Menu</div>
	<nav>
	  <ul data-breakpoint="800" class="flexnav">
	  
	  <?php
	  
	  session_start();
	  
	  if(isset($_SESSION['ClonDiagType'])){
	  
	  $ClonDiagType		=	$_SESSION["ClonDiagType"];
	  
	  } else {
	  
	  $ClonDiagType		=	"anonymous";
	  
	  }
	  
	  if ( $ClonDiagType  ==  "administrator") {
	 
	 ?>
		<li><a href="/clondiag/index.php">Home</a>
			<ul> </ul>
		</li>
		<li><a href="/clondiag/project.php">New Project</a>
			<ul> </ul>
		</li>
		<li><a href="/clondiag/test.php">New Test</a>
			<ul> </ul>
		</li>
		<li><a href="/clondiag/previous.php">Previous Results</a>
			 <ul> </ul>
		</li>
		<li><a href="/clondiag/project_admin.php">Administration Project</a>
		  <ul> </ul>
		</li>
		<li><a href="/clondiag/test_admin.php">Administration Test</a>
		  <ul> </ul>
		</li>
		<li><a href="/clondiag/newuser.php">New user</a>
		  <ul> </ul>
		</li>
		<li><a href="/clondiag/logout.php">Logout</a>
		  <ul> </ul>
		</li>
	  <?php

	  } else if ($ClonDiagType  ==  "user") {  

	  ?>
		<li><a href="/clondiag/index.php">Home</a>
		<ul> </ul>
		</li>
		<li><a href="/clondiag/_test.php">New Test</a>
			<ul> </ul>
		</li>
		<li><a href="/clondiag/previous.php">Previous Results</a>
			 <ul> </ul>
		</li>
		<li><a href="/clondiag/test_admin.php">Administration Test</a>
		  <ul> </ul>
		</li>
		<li><a href="/clondiag/logout.php">Logout</a>
		  <ul> </ul>
		</li>
	  <?php
	  
		} else if ($ClonDiagType  ==  "visit") {  
		
	  ?>
		<li><a href="/clondiag/index.php">Home</a>
		<ul> </ul>
		</li>
		<li><a href="/clondiag/logout.php">Logout</a>
		  <ul> </ul>
		</li>
	  <?php
	  
		} else if ( $ClonDiagType  ==  "anonymous" ) { 
	  
	  ?>
		<li><a href="/clondiag/index.php">Home</a>
			<ul> </ul>
		</li>
		<li><a href="/clondiag/login.php">Login</a>
		  <ul> </ul>
		</li>
	  <?php
	  
		}
	  
	  ?>
	  </ul>
	</nav>
</header>
</div>
<!--<script src="http://code.jquery.com/jquery-1.9.0.js" type="text/javascript"></script>-->
<script src="/clondiag/js/jquery.flexnav.min.js" type="text/javascript"></script>
<script type="text/javascript">$(".flexnav").flexNav({'animationSpeed': 150});</script>
</div><div class="clear"></div>
<div class="header-bot">
<!-- Title -->
</div>