<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Lose Fifteen</title>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/dashboard.js?<?php echo time();?>"></script>    
    <link rel="stylesheet" charset="utf-8" media="screen" href="css/style.css?<?php echo time();?>">
    <link rel="stylesheet" charset="utf-8" media="screen" href="css/dashboard.css?<?php echo time();?>">
</head>
<body>
    <?php include_once("script/analyticstracking.php") ?>
    <div id=top_bar>
          <div id="logo"><span id="lose">lose</span><span id="fifteen">Fifteen</span></div>
          <div><button id="logout" class="lt-button-submit">Logout</button></div>
      </div>
    <div id="bottom_panel">
        <div id="nav_menu">
            <ul>
                <li><a href="index.php?site=home" <?php if(($site == "")||($site == "home")){?> class="selected"<?php } ?>>Home</a></li>
                <?php 
                    if($site_class->expired_subscription($_SESSION['email'], time()+(8*24*60*60))){    
                ?>
                <li><a href="index.php?site=subscribe" <?php if($site == "subscribe"){?> class="selected"<?php } ?>>Subscribe</a></li>
                <?php } ?>
                <li><a href="index.php?site=check_in" <?php if($site == "check_in"){?> class="selected"<?php } ?>>Check-in</a></li>
                <li><a href="index.php?site=work" <?php if($site == "work"){?> class="selected"<?php } ?>>How it Works</a></li>
                <li><a href="index.php?site=account" <?php if($site == "account"){?> class="selected"<?php } ?>>Account</a></li>
                <li><a href="index.php?site=group_contact" <?php if($site == "group_contact"){?> class="selected"<?php } ?>>Group Contact</a></li>
              <!--  <li><a href="index.php?site=faq" <?php if($site == "faq"){?> class="selected"<?php } ?>>Faq</a></li> -->
                <li><a href="index.php?site=contact_us" <?php if($site == "contact_us"){?> class="selected"<?php } ?>>Contact Us</a></li>
            </ul>
            <?php include_once 'views/alerts.php';?>
        </div> 
        <div id="content-panel">
            <?php
               if($site == "check_in"){
                   include_once 'views/check_in.php';
               }
               
               if($site == "subscribe"){
                   include_once 'views/subscribe.php';
               }
               
               if($site == "work"){
                   include_once 'views/work.php';
               }
               if($site == "account"){
                   include_once 'views/account.php';
               }
               if($site == "group_contact"){
                   include_once 'views/group_contact.php';
               }
               if($site == "contact_us"){
                   include_once 'views/contact_us.php';
               }
               if(($site == "")||($site == "home")){
                   include_once 'views/home.php';
               }
            ?>
        </div>
    </div>    
</body>
</html>
