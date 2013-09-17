<?php
 session_start();
 include_once "common.php";
 include_once "../classes/site.php";
 $password = trim($_POST['password']);
 $retypepassword = trim($_POST['retypepassword']);
 $mySite = new site($db);
 $mySite->chgPassword($password, $retypepassword, $_SESSION['email']);
 ?>