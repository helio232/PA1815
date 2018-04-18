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
		$photos = glob("deleted photo/*.jpg");
		$thumbnails = glob("deleted thumbnails/*.jpg");

		//echo images
		echo '<div class="row">';
		for ($i=0; $i < count($thumbnails); $i++){
			$photo = $photos[$i];
			$thumbnail = $thumbnails[$i];
			$x=($i+1);
			echo '<div class="imageContainer" onmouseover="disDelBtn('.$i.')" onmouseout="hidDelBtn('.$i.')">';
			echo '<img class="images" id="img'.$x.'"  onclick="doSend('.$i.')" src="'.$thumbnail.'" >';
			echo '<div class="bottom-left">'.basename($thumbnail).'</div>';
			echo '<input type="submit" name="delete" class="delBtn" value="delete" onclick="deleteImage(\''.basename($thumbnail).'\')" />';
			echo '</div>';
																			//"deleteImage(\'' + result.name + '\')" />'

		}
		echo '</div>';
?>


<!-- Delete All photo
 -->
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
		    var r = confirm("Are you sure you want to delete this Image permanently?")
		    if(r == true)
		    {	
		    	
		        $.ajax({
		          url: 'permdelete.php',
		          data: {'photo': "<?php echo dirname(__FILE__) . '/deleted photo/'?>" + file_name,
		          'thumbnail': "<?php echo dirname(__FILE__) . '/deleted thumbnails/'?>" + file_name },
		          success: function (response) {
		             // do something
		             alert("Photo Permanently Deleted");
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
</script>
</html>