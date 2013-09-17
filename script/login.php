<?php
session_start();
 include_once "common.php";
 include_once "../classes/site.php";
 
 $email = trim($_POST['log_email']);
 $password = trim($_POST['log_password']);
 $mySite = new site($db);
 $mySite->login($email,$password);
 $mySite->loginErrors();
?>