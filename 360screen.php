<!DOCTYPE html>
<html>
	<head>
		<?php $config = include("config.php"); ?>
		<link rel="stylesheet" href="360screen.css">
		<script type="text/javascript" src="jquery-3.3.1.min.js" ></script>
	</head>

	<header>
		<div class="head">
			<h1>ParaMed 360</h1> 
			<div class="dropdown">
				<div class="menu" onclick="menudropdown()">
					<div id="myDropdown" class="dropdown-content">
					    <a href="index.php">Home</a>
					    <a href="archivedphoto.php">Archived Photos</a>
					    <a href="settings.php">Settings</a>
				  	</div>
				<div class="menuline"></div>
				<div class="menuline"></div>
				<div class="menuline"></div>
				</div>
			</div>
		</div>
	</header>
	
	<body>
		<h2>
		Welcome to the ParaMed 360 screen! Please select a panoramic photo to display.
		</h2>
		<div id="myModal" class="modal">
			<span class="close"> &times;</span>
			<img class="modal-content" id="image" src="">
		</div>
	</body>

	<script>
		function menudropdown(){
			 document.getElementById("myDropdown").classList.toggle("show");
		}
		// Get the modal
		var modal = document.getElementById('myModal');

		// Get the <span> element that closes the modal
		var span = document.getElementsByClassName("close")[0];

		// When the user clicks on <span> (x), close the modal
		span.onclick = function() { 
		    modal.style.display = "none";
		}


		//WebSocket
		var wsUri = "<?php echo $config['ws_uri'];?>";
		var pano_images_library = "<?php echo $config['pano_images_library'];?>";

		function init()
		{
		    initialiseWebSocket();
		}

		function initialiseWebSocket(){
			websocket = new WebSocket(wsUri);
			websocket.onopen = function(evt){ onOpen(evt) };
			websocket.onclose = function(evt) { onClose(evt) };
		    websocket.onmessage = function(evt) { onMessage(evt) };
		}

		function onOpen(evt){
			console.log("CONNECTED");
			//writeToScreen("CONNECTED");
		}
		
		function onClose(evt)
		{
			console.log("DISCONNECTED");
		    //writeToScreen("DISCONNECTED");
		}

		function onMessage(evt)
		{
		    console.log("Response: " + evt.data);
		    document.getElementById("image").src = pano_images_library + evt.data;
		    modal.style.display = "block";
		    //websocket.close();
		}

		window.addEventListener("load", init, false);

	</script>
</html>


