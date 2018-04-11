<?php

//list of photos
	$photos = glob("test photo/*.jpg");

	usort($photos, function($a, $b) {
	    return filemtime($a) < filemtime($b);
	});

	for ($i=0; $i < count($photos); $i++){
		$photo = $photos[$i];
		echo $photo;
	}


?>