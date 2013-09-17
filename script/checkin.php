<?php
session_start();
 include_once "common.php";
 include_once "../classes/dietician.php";
 if(!isset($_SESSION['email'])){
     exit();
 }
 
 $weight = $_POST['weight'];
 $diary = $_POST['diary'];
 $calories = $_POST['calories'];
 $obstacles = $_POST['obstacles'];
 $solution = $_POST['solution'];
 $whylose = $_POST['whylose'];
 $email = $_SESSION['email'];
 
 $dietician = new dietician($db);
 $dietician->checkin($email,$weight,$diary,$calories,$obstacles,$solution,$whylose);
 echo $dietician->getError();
 ?>
