<!DOCTYPE html>
<html>
	<head>
		<?php $config = include("config.php"); ?>
		<script type="text/javascript" src="js/jquery-3.3.1.min.js" ></script>
		<!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
         <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="css/360screen.css" media="screen,projection"/>
        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	</head>

	<body>
		<header>
			<nav>
				<div class="nav-wrapper">
				<div class="col s12">
			        <a href="#!" class="breadcrumb">360 Screen</a>
			    </div>
			    <a href="index.php" class="brand-logo center">ParaMed 360</a>
			    <ul class="right">
			    <li><img class="status" id="statusicon" src="src/redicon.png"></li>
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
			  </ul>
			  <a href="#" id="menu" data-target="slide-out" class="sidenav-trigger white-text"><i class="material-icons">menu</i></a>

			  
		</header>
	
		<h3>
			Welcome to the ParaMed 360 screen! Please select a panoramic photo to display.
		</h3>
		<div id="myModal" class="modal360">
			<span class="close"> &times;</span>
			<img class="modal-content360" id="image" src="">
		</div>
		<div id="myModal2" class="modal360">
		</div>

      <!--JavaScript at end of body for optimized loading-->
      <script type="text/javascript" src="js/materialize.min.js"></script>
      <script type="text/javascript" src="js/reconnecting-websocket.min.js"></script>
	</body>

<script language="JavaScript">
		// Get the modal
		var modal = document.getElementById('myModal');
		var modal2 = document.getElementById('myModal2');

		// Get the <span> element that closes the modal
		var span = document.getElementsByClassName("close")[0];

		// When the user clicks on <span> (x), close the modal
		span.onclick = function() { 
		    modal.style.display = "none";
		}

		//initialise sidenav
		  document.addEventListener('DOMContentLoaded', function() {
		    var elems = document.querySelectorAll('.sidenav');
		    var instances = M.Sidenav.init(elems);
		  });


		//WebSocket
		var wsUri = "<?php echo $config['ws_uri'];?>";
		var pano_images_library = "<?php echo $config['pano_images_library'];?>";

		function init()
		{
		    initialiseWebSocket();
		}

		function initialiseWebSocket(){
			//websocket = new WebSocket(wsUri);
			websocket = new ReconnectingWebSocket(wsUri);
			websocket.onopen = function(evt){ onOpen(evt) };
			websocket.onclose = function(evt) { onClose(evt) };
		    websocket.onmessage = function(evt) { onMessage(evt) };
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

		    if (evt.data.split('.').pop() == "jpg"){
		    	document.getElementById("image").src = pano_images_library + evt.data;
		    	modal.style.display="none";
		    	modal2.style.display="block";
		    	setTimeout(function (){
					modal2.style.display= "none";
					modal.style.display = "block";
				}, 300);
		    }
		    //websocket.close();
		}
		window.addEventListener("load", init, false);

	</script>
</html>


