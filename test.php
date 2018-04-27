<!DOCTYPE html>

<html>
	<head>
		<link rel="stylesheet" href="testcss.css">
		<script type="text/javascript" src="jquery-3.3.1.min.js" ></script>
	</head>

</div>
	<body>
		<header>
		<div class="head">
			<h1>ParaMed 360</h1> 
			<img class="refresh" src="src/refresh.png" onclick="refresh()">
			<div class="dropdown">
				<div class="menu" onclick="menudropdown()">
					<div id="myDropdown" class="dropdown-content">
					    <a href="test.php">Home</a>
					    <a href="deletedphoto.php">Deleted Photos</a>
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
		// get photo from a directory
		$photos = glob("test photo/*.jpg");
		$thumbnails = glob("thumbnails/*.jpg");


		//sort photo according to date modified
		usort($photos, function($a, $b) {
    		return filemtime($a) < filemtime($b);
		});

		// usort($thumbnails, function($a, $b) {
  //   		return filemtime($a) < filemtime($b);
		// });


		// GD library thumbnails
		for ($i=0; $i < count($photos); $i++){
			$photo = $photos[$i];	
			$filename = 'thumbnails/'.basename($photo);
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
				imagejpeg($new_image, 'thumbnails/'.basename($photo),100);
				imagedestroy($old_image);
				imagedestroy($new_image);
			}			
		}
		// //when a new photo is added, create a new thumbnail and refresh
		if (count($thumbnails) != count($photos)){
			header("Refresh:0");
		} 

		//echo images
		echo '<div class="row">';
		for ($i=0; $i < count($thumbnails); $i++){
			$thumbnail = $thumbnails[$i];
			$x=($i+1);
			echo '<div class="imageContainer" onmouseover="disDelBtn('.$i.')" onmouseout="hidDelBtn('.$i.')">';
			echo '<img class="images" id="img'.$x.'"  onclick="doSend('.$i.')" src="'.$thumbnail.'" >';
			echo '<div class="bottom-left">'.basename($thumbnail).'</div>';
			echo '<input type="submit" name="delete" class="delBtn" value="delete" onclick="deleteImage(\''.basename($thumbnail).'\')" />';
			echo '</div>';
		}
		echo '</div>';

	?>
		<!--Top button-->
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

		function deleteImage(file_name)
		{
		    var r = confirm("Are you sure you want to delete this Image?")
		    if(r == true)
		    {	
		    	
		        $.ajax({
		          url: 'delete.php',
		          data: {'sourcefile' : "<?php echo dirname(__FILE__) . '/test photo/'?>" + file_name  ,
		          		 'newfile': "<?php echo dirname(__FILE__) . '/deleted photo/'?>" + file_name ,
		          		 'sourcethumbnail':  "<?php echo dirname(__FILE__) . '/thumbnails/'?>" + file_name , 
		          		 'newthumbnail':  "<?php echo dirname(__FILE__) . '/deleted thumbnails/'?>" + file_name
		          		},
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

		function menudropdown(){
			 document.getElementById("myDropdown").classList.toggle("show");
		}


		//WebSocket
		var wsUri = "<?php echo $config['ws_uri'];?>";

		function init()
		{
		    initialiseWebSocket();
		}

		function initialiseWebSocket(){
			websocket = new WebSocket(wsUri);
			websocket.onopen = function(evt){ onOpen(evt) };
			websocket.onclose = function(evt) { onClose(evt) };
		    websocket.onmessage = function(evt) { onMessage(evt) };
		    websocket.onerror = function(evt) { onError(evt) };

		}

		function onOpen(evt){
			console.log("CONNECTED");
			//writeToScreen("CONNECTED");
			//doSend("WebSocket");
		}

		function onClose(evt)
		{
			console.log("DISCONNECTED");
		    //writeToScreen("DISCONNECTED");
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
