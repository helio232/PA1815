<!DOCTYPE html>

<html>
	<head>
		<link rel="stylesheet" href="index.css">
		<script type="text/javascript" src="jquery-3.3.1.min.js" ></script>
		<style>
		
		</style>
	</head>

</div>
	<body>
		<header>
		<div class="head">
			<h1>ParaMed 360</h1>
			<div class="dropdown">
				<div class="menu" onclick="menudropdown()">
					<div id="myDropdown" class="dropdown-content">
					    <a href="index.php">Home</a>
					    <a href="archivedphoto.php">Archived Photos</a>
					    <a href="360screen.php">360 Screen</a>
					    <a href="settings.php">Settings</a>
				  	</div>

				<div class="menuline"></div>
				<div class="menuline"></div>
				<div class="menuline"></div>
				</div>
			</div>
		</div>

		</header>


<?php
		$config = include("config.php");
		foreach($config as $key => $value){
    		echo "<b>".$key.": </b>".$value . "<br>";
		}
?>
		<!-- 		Clear Thumbnails: -->
		<button onclick="topFunction()" id="topBtn" title="Go to top">Top</button>

	</body>


<script language="JavaScript">

		// When the user scrolls down 20px from the top of the document, show the button
		window.onscroll = function() {scrollFunction()};

		function scrollFunction() {
		    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
		        document.getElementById("topBtn").style.display = "block";
		    } else {
		        document.getElementById("topBtn").style.display = "none";
		    }
		}

		// When the user clicks on the button, scroll to the top of the document
		function topFunction() {
		    document.body.scrollTop = 0; // For Safari
		    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
		}

		function menudropdown(){
			 document.getElementById("myDropdown").classList.toggle("show");
		}		

</script>
</html>

