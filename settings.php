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
			<nav>
				<div class="nav-wrapper">
				<div class="col s12">
			        <a href="#!" class="breadcrumb">Settings</a>
			    </div>
			    <a href="index.php" class="brand-logo center">ParaMed 360</a>
			  </div>
			</nav>

			  <ul id="slide-out" class="sidenav">
<!-- 			    <li><div class="user-view">
			      <div class="background">
			        <img src="">
			      </div>
			      </div></li> -->
			    <li><a href="index.php"  class='waves-effect'><i class="material-icons">home</i>Home</a></li>
			  	<li class="divider"></li>
			  	<li><a href="archivedphoto.php" class='waves-effect'><i class="material-icons">archive</i>Archived Photos</a></li>
			  	<li class="divider"></li>
			  	<li><a href="360screen.php" class='waves-effect'><i class="material-icons">airplay</i>360 Screen</a></li>
			  	<li class="divider"></li>
			  	 <li><a href="settings.php" class='waves-effect'><i class="material-icons">settings</i>Settings</a></li>
			  </ul>
			  <a href="#" id="menu" data-target="slide-out" class="sidenav-trigger white-text"><i class="material-icons">menu</i></a>

			  
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
		
		//initialise sidenav
		  document.addEventListener('DOMContentLoaded', function() {
		    var elems = document.querySelectorAll('.sidenav');
		    var instances = M.Sidenav.init(elems);
		  });
</script>
</html>

