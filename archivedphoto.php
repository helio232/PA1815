<!DOCTYPE html>

<html>
	<head>
		<link rel="stylesheet" href="index.css">
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


		function menudropdown(){
			 document.getElementById("myDropdown").classList.toggle("show");
		}
</script>
</html>