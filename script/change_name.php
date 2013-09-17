<?php
 session_start();
 include_once "common.php";
 include_once "../classes/site.php";
 
 $firstname = trim($_POST['firstname']);
 $lastname = trim($_POST['lastname']);
 $mySite = new site($db);
 $mySite->chgName($firstname, $lastname, $_SESSION['email']);
?>
