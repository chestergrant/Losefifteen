<?php
 include_once "common.php";
 include_once "../classes/site.php";
 
 $email = trim($_POST['email']);
 $mySite = new site($db);
 $mySite->sendRecoverEmail($email);
 
?>
