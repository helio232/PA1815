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
	<body>
		<header>
			<nav>
				<div class="nav-wrapper">
				<div class="col s12">
			        <a href="#!" class="breadcrumb">Archived Photos</a>
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

		<!-- Archive Image Card -->
		<div id="arcCard"class="row">
		    <div class="col s12 m12">
		      	<div class="card small">
		        	<div class="card-image">
          				<img id="archiveCardImage"src="">
          				<span class="card-title white-text" id="cardtext">Card Title</span>
		          	</div>
		          		<div class="card-content black-text" id="cardquestion">
		          		<p>Are you sure you want to delete this image?</p>
		        	</div>
			        <div class="card-action">
			          <a href="#" id="cancelArc" class="left" >Cancel</a>
			          <a href="#" id="confirmArc" class="right">Confirm</a>
			        </div>
		     	</div>
		    </div>
		</div>

<?php
		$config = include("config.php");
		$pano_images_library = $config['pano_images_library'];
		$thumbnails_library = $config['thumbnails_library'];
		$archived_pano_images_library = $config['archived_pano_images_library'];
		$archived_thumbnails_library = $config['archived_thumbnails_library'];
		//$photos = glob($archived_pano_images_library."*.jpg");
		$thumbnails = glob($archived_thumbnails_library."*.jpg");

		//echo thumbnails
		echo '<div class="gallery">';
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

			document.getElementById("archiveCardImage").src = "<?php echo''.$archived_thumbnails_library.''?>" + file_name;
			document.getElementById("cardtext").innerHTML = "Delete: " + file_name;
			var arc = document.getElementById("arcCard");
			arc.style.display = "block";

			$('#confirmArc').click(function() {
			    $.ajax({
		        	url: 'delete.php',
		          	data: {'photo': "<?php echo dirname(__FILE__) . '/'.$archived_pano_images_library.''?>" + file_name,
		          	'thumbnail': "<?php echo dirname(__FILE__) . '/'.$archived_thumbnails_library.''?>" + file_name },
		        	success: function (response) {
		            	// do something
		            	//alert("Photo Archived");
		            	M.toast({html: 'Photo Deleted'},3000)
		            	setTimeout(function () {
				        	location.reload()
				    	}, 1000);
		          	},
		          	error: function () {
		            // do something
		          	}
		        });
			 });

			$('#cancelArc').click(function(){
				arc.style.display = "none";
			});
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


		//initialise sidenav
		document.addEventListener('DOMContentLoaded', function() {
			var elems = document.querySelectorAll('.sidenav');
		    var instances = M.Sidenav.init(elems);
		});

		function recoverImage(file_name)
		{	
			document.getElementById("archiveCardImage").src = "<?php echo''.$archived_thumbnails_library.''?>" + file_name;
			document.getElementById("cardtext").innerHTML = "Recover: "+ file_name;
			document.getElementById("cardquestion").innerHTML = "<p>Are you sure you want to recover this image?</p>";
			var arc = document.getElementById("arcCard");
			arc.style.display = "block";

			$('#confirmArc').click(function() {
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
		            	//alert("Photo Archived");
		            	M.toast({html: 'Photo Recovered'},3000)
		            	setTimeout(function () {
				        	location.reload()
				    	}, 1000);
		          	},
		          	error: function () {
		            // do something
		          	}
		        });
			 });

			$('#cancelArc').click(function(){
				arc.style.display = "none";
			});
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