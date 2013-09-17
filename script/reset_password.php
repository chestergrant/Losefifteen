<?php
 session_start();
 include_once "common.php";
 include_once "../classes/site.php";
 $password = trim($_POST['password']);
 $retypepassword = trim($_POST['retypepassword']);
 $hash = trim($_POST['hash']);
 
 $mySite = new site($db);
 $mySite->resetPassword($password,$retypepassword,$hash);
?>