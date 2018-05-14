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
			    <li><img class="status" id="statusicon" src="src/redicon.png"></li>
				<li><a href="#"><i class="material-icons" onclick="refresh()">refresh</i></a></li>

			      <!-- Dropdown Trigger -->
			      <li><a class="dropdown-trigger" href="#!" data-target="dropdown1"><i class="material-icons">more_vert</i></a></li>
			    </ul>
			  </div>
			</nav>
		</header>
<?php
		$config = include("config.php");
		$pano_images_library = $config['pano_images_library'];
		$thumbnails_library = $config['thumbnails_library'];
		$archived_pano_images_library = $config['archived_pano_images_library'];
		$archived_thumbnails_library = $config['archived_thumbnails_library'];
		//$photos = glob($archived_pano_images_library."*.jpg");
		$thumbnails = glob($archived_thumbnails_library."*.jpg");

		//echo thumbnails
		echo '<div class="row">';
		for ($i=0; $i < count($thumbnails); $i++){
			//$photo = $photos[$i];
			$thumbnail = $thumbnails[$i];
			$x=($i+1);
			echo '<div class="imageContainer" onmouseover="disDelBtn('.$i.'); disRecBtn('.$i.'); " onmouseout="hidDelBtn('.$i.'); hidRecBtn('.$i.');" ">';
			echo '<img class="images" id="img'.$x.'"  onclick="doSend('.$i.')" src="'.$thumbnail.'" >';
			echo '<div class="bottom-left">'.basename($thumbnail).'</div>';
			echo '<input type="submit" name="delete" class="delBtn" value="delete" onclick="deleteImage(\''.basename($thumbnail).'\')" />';
			echo '<input type="submit" name="recover" class="recBtn" value="recover" onclick="recoverImage(\''.basename($thumbnail).'\')" />';
			echo '</div>';

		}
		echo '</div>';
?>

		<!--Top button-->
		<div  class="fixed-action-btn">
			<a id="topBtn" class="btn-floating btn-large">
	    		<i class="large material-icons" onclick="topFunction()">expand_less</i>
	  		</a>
  		</div>

      <!--JavaScript at end of body for optimized loading-->
      <script type="text/javascript" src="js/materialize.min.js"></script>
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

		function deleteImage(file_name)
		{
		    var r = confirm("Are you sure you want to delete this Image?")
		    if(r == true)
		    {	
		    	
		        $.ajax({
		          url: 'delete.php',
		          data: {'photo': "<?php echo dirname(__FILE__) . '/'.$archived_pano_images_library.''?>" + file_name,
		          'thumbnail': "<?php echo dirname(__FILE__) . '/'.$archived_thumbnails_library.''?>" + file_name },
		          success: function (response) {
		             // do something
		             alert("Photo Deleted");
		             location.reload();
		          },
		          error: function () {
		             // do something

		          }
		        });
		        
		    }
		}

		// display delete button
		function disDelBtn(x) {
			var delBtn = document.getElementsByClassName("delBtn")[x];
			delBtn.style.display = "initial";
		}

		//hide delete button
		function hidDelBtn(x){
			var delBtn = document.getElementsByClassName("delBtn")[x];
			delBtn.style.display = "none";
		}

		//dropdown menu
		$(".dropdown-trigger").dropdown();

		function recoverImage(file_name)
		{	
		    var r = confirm("Are you sure you want to recover this Image?")
		    if(r == true)
		    {	
		    	
		        $.ajax({
		          url: 'recover.php',
		          data: {
		          		'sourcefile' : "<?php echo dirname(__FILE__) . '/'.$archived_pano_images_library.''?>" + file_name  ,
		          		'newfile': "<?php echo dirname(__FILE__) . '/'.$pano_images_library.''?>" + file_name ,
		          		'sourcethumbnail':  "<?php echo dirname(__FILE__) . '/'.$archived_thumbnails_library.''?>" + file_name , 
		          		'newthumbnail':  "<?php echo dirname(__FILE__) . '/'.$thumbnails_library.''?>" + file_name
		          		},
		          success: function (response) {
		             // do something
		             alert("Photo Recovered");
		             location.reload();
		          },
		          error: function () {
		             // do something
		          }
		        });
		        
		    }
		}

				// display delete button
		function disRecBtn(x) {
			var recBtn = document.getElementsByClassName("recBtn")[x];
			recBtn.style.display = "initial";
		}

		//hide delete button
		function hidRecBtn(x){
			var recBtn = document.getElementsByClassName("recBtn")[x];
			recBtn.style.display = "none";
		}

</script>
</html>