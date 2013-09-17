<?php
session_start();
if(isset($_REQUEST['site'])){
    $site = $_REQUEST['site'];
}else{
    $site ="";
}
if(isset($_SESSION['email'])){
 include_once "script/common.php";
 include_once "classes/site.php"; 
 $site_class = new site($db);
 if($site_class->expired_subscription($_SESSION['email'], time())){
     if($site != "subscribe"){
         header("Location: index.php?site=subscribe");
         die();
     }
 }
  include_once 'views/dashboard.php';
}else{
    if($site == "forgotten"){
        include_once 'views/forgotten.php';
    }else if($site == "reset"){
        include_once 'views/reset.php';
    }else{
        include_once 'views/homepage.php';
    }
}

?>