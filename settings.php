<!DOCTYPE html>

<html>
	<head>
		<script type="text/javascript" src="js/jquery-3.3.1.min.js" ></script>
		<!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
         <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
        <link type="text/css"rel="stylesheet" href="css/index.css" media="screen,projection"/>
        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <style>
        li {padding-left: 1.5vw;}
        </style>
	</head>

</div>
	<body>
		<header>
			<!-- Dropdown Structure -->
			<ul id="dropdown1" class="dropdown-content">
				<li><a href="index.php">Home</a></li>
			  	<li class="divider"></li>
			  	<li><a href="archivedphoto.php">Archived Photos</a></li>
			  	<li class="divider"></li>
			  	<li><a href="360screen.php">360 Screen</a></li>
			  	<li class="divider"></li>
			  	<li><a href="settings.php">Settings</a></li>
			</ul>
			<nav>
				<div class="nav-wrapper">
			    <a href="index.php" class="brand-logo">ParaMed 360</a>
			    <ul class="right hide-on-med-and-down">
			      <!-- Dropdown Trigger -->
			      <li><a class="dropdown-trigger" href="#!" data-target="dropdown1"><i class="material-icons">more_vert</i></a></li>
			    </ul>
			  </div>
			</nav>
		</header>


<?php
		$config = include("config.php");
		echo "<ul>";
		foreach($config as $key => $value){
    		echo "<li><b>".$key.": </b>".$value . "</li>";
		}
		echo "</ul>";
?>
		<!-- 		Clear Thumbnails:  ???-->

		<!--JavaScript at end of body for optimized loading-->
    	<script type="text/javascript" src="js/materialize.min.js"></script>
	</body>


<script language="JavaScript">		
		//dropdown menu
		$(".dropdown-trigger").dropdown();
</script>
</html>

