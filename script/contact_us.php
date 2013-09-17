<?php
 session_start();
 include_once "common.php";
 include_once "../classes/site.php";
 $subject = trim($_POST['subject']);
 $message = trim($_POST['message']);
 $mySite = new site($db);
 $mySite->contact_us($subject,$message, $_SESSION['email']);
?>
