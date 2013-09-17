<?php
 session_start();
 include_once "common.php";
 include_once "../classes/site.php";
 $phone = trim($_POST['phone']);
 $skype = trim($_POST['skype']);
 $mySite = new site($db);
 $mySite->chgPhoneSkype($phone, $skype, $_SESSION['email']);
?>
