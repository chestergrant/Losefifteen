<?php
 session_start();
 include_once "common.php";
 include_once "../classes/dietician.php";
 include_once "../classes/site.php";  
 
 $dietician = new dietician($db);
 $page_no = (int)$_POST['page_no'];
 $feed = $dietician->getFeed($_SESSION['email'],$page_no);
 //echo $page_no;
 for($i=0; $i < count($feed); $i++){
     include '../views/data_point.php';
 }
?>
