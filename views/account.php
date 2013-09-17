<?php
if(isset($_REQUEST['sub_site'])){
    $sub_site = $_REQUEST['sub_site'];
}else{
    $sub_site = "";
}
if($sub_site == "change_name"){
    include_once 'views/change_name.php';
}else if($sub_site == "change_password"){
    include_once 'views/change_password.php';
}else if($sub_site == "change_phone_skype"){
    include_once 'views/change_phone_skype.php';
}else{
    include_once 'views/account_main.php';    
}
?>
