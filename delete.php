<?php 
   //unlink($_GET['file']);
   rename($_GET['sourcefile'],$_GET['newfile']);
   unlink($_GET['thumbnail']);
   //GET repsonse

?>