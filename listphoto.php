
<?php

header('Content-Type: application/json');

$photos = glob("test photo/*.jpg");

// 	usort($photos, function($a, $b) {
// 	    return filemtime($a) < filemtime($b);
// 	});

$list = array(); //main array

 	for ($i=0; $i < count($photos); $i++){
 		$photo = $photos[$i];

 		$photolist = array(
                'filename' => basename($photo), 
                'size' => filesize($photo) );
                array_push($list, $photolist);

 	}
    $return_array = array('files'=> $list);

    //echo json_encode($return_array);
    $data = json_encode($return_array);
    
    //output a JSON FILE
    file_put_contents('filelist.json', $data);
    
    //echo $data;
    
?>


