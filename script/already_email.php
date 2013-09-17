<?php
include_once "common.php";
include_once "../classes/site.php";

$email = trim($_GET['email']);
$mySite = new site($db);
if($mySite->alreadyUsed($email)){
    echo "Email already exist.";
}
?>
