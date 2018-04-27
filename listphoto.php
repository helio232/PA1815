
<?php

    header('Content-Type: application/json');
    $config = include("config.php");
    $pano_images_library = $config['pano_images_library'];

    $photos = glob($pano_images_library."*.jpg");

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
    
    echo $data;
    
?>


