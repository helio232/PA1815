<?php 
   //unlink($_GET['file']);
   rename($_GET['sourcefile'],$_GET['newfile']);
   rename($_GET['sourcethumbnail'],$_GET['newthumbnail']);
   //unlink($_GET['thumbnail']);
   //GET repsonse

?>