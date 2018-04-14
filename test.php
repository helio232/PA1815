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
		// get photo from a directory, format: jpg, gif, png
		//$photos = glob("test photo/"."*.{jpg,gif,png}",GLOB_BRACE);
		$photos = glob("test photo/*.jpg");
		$thumbnails = glob("thumbnails/*.jpg");


		//sort photo according to date modified
		usort($photos, function($a, $b) {
    		return filemtime($a) < filemtime($b);
		});

		//echo images
		echo '<div class="row">';
		for ($i=0; $i < count($photos); $i++){
			$photo = $photos[$i];
			$thumbnail = $thumbnails[$i];
			
			// GD library thumbnails
			list($old_width, $old_height) = getimagesize($photo);
			
			//$new_width = $old_width * 0.5;
			//$new_height = $old_height * 0.5;
			$new_width = 900;
			$new_height = 250;

			//begin cropping x and y
		    $crop_top = floor(($old_width - $new_width) / 2);
		    $crop_left = floor(($old_height - $new_height) / 2);
			$new_image = imagecreatetruecolor($new_width, $new_height);
			$old_image = imagecreatefromjpeg($photo);

			imagecopy($new_image,$old_image,0,0,$crop_top,$crop_left,$old_width,$old_height);
			imagejpeg($new_image, 'thumbnails/'.basename($photo),100);
			imagedestroy($old_image);
			imagedestroy($new_image);
			
			$x=($i+1);
			echo '<div class="imageContainer" onmouseover="disDelBtn('.$i.')" onmouseout="hidDelBtn('.$i.')">';
			//echo '<img class="images" id="img'.$x.'"  onclick="doSend('.$i.')" src="'.$photo.'" >';
			echo '<img class="images" id="img'.$x.'"  onclick="doSend('.$i.')" src="'.$thumbnail.'" >';
			echo '<div class="bottom-left">'.basename($photo).'</div>';
			echo '<input type="submit" name="delete" class="delBtn" value="delete" onclick="deleteImage(\''.basename($photo).'\')" />';
			echo '</div>';
																			//"deleteImage(\'' + result.name + '\')" />'

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
		          		 'thumbnail':  "<?php echo dirname(__FILE__) . '/thumbnails/'?>" + file_name
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
		var wsUri = "wss://echo.websocket.org";

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
		    //writeToScreen('<span style="color: blue;">RESPONSE: ' + evt.data+'</span>');
		    console.log("Response: " + evt.data);
		    //websocket.close();
		}

		function onError(evt)
		{
		    //writeToScreen('<span style="color: red;">ERROR:</span> ' + evt.data);
		    console.log("ERROR: " + evt.data);
		}

		function doSend(evt){
			var photoSrc = document.getElementsByClassName("images")[evt].src;
			console.log("Sent: " + photoSrc);
			websocket.send(photoSrc);
			
		}
		window.addEventListener("load", init, false);


		//Set Interval: Refresh
	    var previous = null;
	    var current = null;
	    setInterval(function() {
	        $.getJSON("filelist.json", function(json) {

	        	$.ajax({
			            url: 'listphoto.php',
			            data: {},
			            success: function (response) {
			             // do something
	                    current = JSON.stringify(json);            
	                    if (previous && current && previous !== current) {
	                        console.log('refresh');
	                        location.reload();
	                    }
	                    previous = current;
	                    
			            },
			            error: function () {
			             // do something

			            }
			        });

	        });       
	    }, 4000);  
	</script>
</html>
