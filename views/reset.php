<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Lose Fifteen</title>
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/reset.js?<?php echo time();?>"></script>
        <script type="text/javascript" src="js/homepage.js?<?php echo time();?>"></script>
	<link rel="stylesheet" charset="utf-8" media="screen" href="css/style.css?<?php echo time();?>">
        <link rel="stylesheet" charset="utf-8" media="screen" href="css/forgotten.css?<?php echo time();?>">    
	<link rel="stylesheet" charset="utf-8" media="screen" href="css/reset.css?<?php echo time();?>">
</head>
    <body>
        <?php include_once("script/analyticstracking.php") ?>
        <div id=top_bar>
          <div id="logo"><span id="lose">lose</span><span id="fifteen">Fifteen</span></div>
          
      </div>
        <div id="bottom-panel">
            <div id="shell">
            <?php
                include_once "script/common.php";
                include_once "classes/site.php";
                if(isset($_REQUEST['hash'])){
                    $hash = trim($_REQUEST['hash']);
                }else{
                    $hash = "";
                }
                $mySite = new site($db);
                if($mySite->validHash($hash)){
            ?>
            
            
            
                <div id="text"><h2>Reset Password?</h2></div>
                <div id="instructions">Please enter your new password.</div>
                <div id="aform">
                    <span id="password-error" class="password-error-bubble">#</span>
                    <form id="recoverFrm" name="recoverFrm" method="post" action="#" onsubmit="return resetPassword()">
                        <input type="hidden" name="hash" id="hash" value="<?php echo $hash;?>">
                        <table width="100%">
                            <tr>
                                <td width="20%">Password:</td>
                                <td width="80%"><input type="password" id="password" name="password" placeholder="Password" class="input-text"><br></td>
                            </tr>
                            <tr>
                                <td width="20%">Retype Password:</td>
                                <td width="100%"><input type="password" id="retypepassword" name="retypepassword" placeholder="Retype Password" class="input-text"><br></td>    
                            </tr>
                            <tr>
                                <td colspan="2"><input type="submit" value="submit" name="submit" class="lt-button-submit"></td>
                            </tr>
                        </table>
                        
                            
                    </form>
                </div>
           
            <?php }else{ ?>
                <div>Sorry the link is invalid. A link to reset your password is only valid for 24 hours. To request a new link click <a href="index.php?site=forgotten">here</a>.</div>
            <?php } ?>
           </div>      
        </div>    
    </body>
</html>