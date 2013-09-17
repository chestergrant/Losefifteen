<?php
 session_start();
 include_once "common.php";
 include_once "../classes/site.php";
 $firstname = trim($_POST['firstname']);
 $lastname = trim($_POST['lastname']);
 $email = trim($_POST['email']);
 $password = trim($_POST['password']);
 $phone = trim($_POST['phone']);
 $skype = trim($_POST['skype']);
 
 $mySite = new site($db);
 $mySite->signup($firstname,$lastname,$email,$password,$phone,$skype);
 $mySite->signupErrors();
?>
