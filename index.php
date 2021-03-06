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

	<body>
		<header>
			<nav>
				<div class="nav-wrapper">
				<div class="col s12">
			        <a href="#!" class="breadcrumb">Home</a>
			    </div>
			    <a href="index.php" class="brand-logo center">ParaMed 360</a>
			    <ul class="right">
			    <li><img class="status" id="statusicon" src="src/redicon.png"></li>
				<li><a href="#"><i class="material-icons" onclick="refresh()">refresh</i></a></li>

			    </ul>
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
			  	<li><div class="divider"></div></li>
    			<li><a class="subheader">&copy; Western Sydney University</a></li>
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
		          		<div class="card-content black-text">
		          		<p>Are you sure you want to archive this image?</p>
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

		// get photo from a directory
		$photos = glob($pano_images_library."*.jpg");
		$thumbnails = glob($thumbnails_library."*.jpg");

		//sort photo according to date modified
		usort($photos, function($a, $b) {
    		return filemtime($a) < filemtime($b);
		});

		// GD library thumbnails
		for ($i=0; $i < count($photos); $i++){
			$photo = $photos[$i];	
			$filename = $thumbnails_library.basename($photo);
			if(!file_exists($filename)){
				//if thumbnail does not exist, create new one
				list($old_width, $old_height) = getimagesize($photo);
				$new_width = $config['thumbnail_width'];
				$new_height = $config['thumbnail_height'];

				//begin cropping x and y
			    $crop_top = floor(($old_width - $new_width) / 2);
			    $crop_left = floor(($old_height - $new_height) / 2);
				$new_image = imagecreatetruecolor($new_width, $new_height);
				$old_image = imagecreatefromjpeg($photo);

				imagecopy($new_image,$old_image,0,0,$crop_top,$crop_left,$old_width,$old_height);
				imagejpeg($new_image, $thumbnails_library.basename($photo),100);
				imagedestroy($old_image);
				imagedestroy($new_image);
			}			
		}
		// //when a new photo is added, create a new thumbnail and refresh
		if (count($thumbnails) < count($photos)){
			header("Refresh:0");
		}

		//echo images
		echo '<div class="gallery">';
		for ($i=0; $i < count($thumbnails); $i++){
			$thumbnail = $thumbnails[$i];
			$x=($i+1);
			echo '<div class="imageContainer" onmouseover="disDelBtn('.$i.')" onmouseout="hidDelBtn('.$i.')">';
			echo '<img class="images" id="img'.$x.'"  onclick="doSend('.$i.')" src="'.$thumbnail.'" >';
			echo '<div class="bottom-left">'.basename($thumbnail).'</div>';
			echo '<input type="submit" name="archive" class="delBtn" value="archive" onclick="archiveImage(\''.basename($thumbnail).'\')" />';
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
      <script type="text/javascript" src="js/reconnecting-websocket.min.js" ></script>
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

		function archiveImage(file_name)
		{	

			document.getElementById("archiveCardImage").src = "<?php echo''.$thumbnails_library.''?>" + file_name;
			document.getElementById("cardtext").innerHTML = "Archive: "+file_name;
			var arc = document.getElementById("arcCard");
			arc.style.display = "block";

			$('#confirmArc').click(function() {
			    $.ajax({
		        	url: 'archive.php',
		        	data: {
		          		'sourcefile' : "<?php echo dirname(__FILE__) . '/'.$pano_images_library.''?>" + file_name  ,
		          		'newfile': "<?php echo dirname(__FILE__) . '/'.$archived_pano_images_library.''?>" + file_name ,
		          		'sourcethumbnail':  "<?php echo dirname(__FILE__) . '/'.$thumbnails_library.''?>" + file_name , 
		          		'newthumbnail':  "<?php echo dirname(__FILE__) . '/'.$archived_thumbnails_library.''?>" + file_name
		          		},
		        	success: function (response) {
		            	// do something
		            	//alert("Photo Archived");
		            	M.toast({html: 'Photo Archived'},3000)
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


		//WebSocket
		var wsUri = "<?php echo $config['ws_uri'];?>";

		function init()
		{
		    initialiseWebSocket();
		    refresh();
		}

		function initialiseWebSocket(){
			//websocket = new WebSocket(wsUri);
			websocket = new ReconnectingWebSocket(wsUri);
			websocket.onopen = function(evt){ onOpen(evt) };
			websocket.onclose = function(evt) { onClose(evt) };
		    websocket.onmessage = function(evt) { onMessage(evt) };
		    websocket.onerror = function(evt) { onError(evt) };

		}

		function onOpen(evt){
			console.log("CONNECTED");
			document.getElementById('statusicon').src = "src/greenicon.png";
		}

		function onClose(evt)
		{
			console.log("DISCONNECTED");
			document.getElementById('statusicon').src = "src/redicon.png";
		}

		function onMessage(evt)
		{
		    console.log("Response: " + evt.data);			   
		    //websocket.close();
		}

		function onError(evt)
		{
		    //writeToScreen('<span style="color: red;">ERROR:</span> ' + evt.data);
		    console.log("ERROR: " + evt.data);
		}

		function doSend(evt){
			// send only the filename
			var filename = document.getElementsByClassName("images")[evt].src.split('/').pop();
			console.log("Sent: " + filename);
			websocket.send(filename);
						
		}
		window.addEventListener("load", init, false);

		var previous;
		var current;
		$.getJSON("filelist.json", function(json) {
			previous = JSON.stringify(json);
		});
		
	 	function refresh(){
	        $.ajax({
		        url: 'listphoto.php',
		        data: {},
		        success: function (response) {
			        // do something
			        $.getJSON("filelist.json", function(json) {         
	          			current = JSON.stringify(json);    
	                	if (previous && current && previous !== current) {
	                    	console.log('refresh');
	                    	location.reload();
	                	}
	                	previous = current;
	             	}); 
			    },
			    error: function () {
			        // do something
		            console.log('error');
			    }
			});			     
	 	}

	</script>
</html>
