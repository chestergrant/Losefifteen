<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Lose Fifteen</title>
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/forgotten.js?<?php echo time();?>"></script>
        <script type="text/javascript" src="js/homepage.js?<?php echo time();?>"></script>
	<link rel="stylesheet" charset="utf-8" media="screen" href="css/style.css?<?php echo time();?>">        
	<link rel="stylesheet" charset="utf-8" media="screen" href="css/forgotten.css?<?php echo time();?>">
</head>
    <body>
        <?php include_once("script/analyticstracking.php") ?>
        <div id=top_bar>
          <div id="logo"><span id="lose">lose</span><span id="fifteen">Fifteen</span></div>
          
      </div>
        <div id="bottom-panel">
            <div id="shell">
                <div id="text"><h2>Forgot your password?</h2></div>
                <div id="instructions">Please enter your email for your account below.</div>
                <div id="aform">
                    <form id="recoverFrm" name="recoverFrm" method="post" action="#" onsubmit="return recoverPassword()">
                        <input type="text" id="email" name="email" placeholder="Email">
                        <span id="email-error" class="email-error-bubble">#</span>    
                        <input type="submit" value="submit" name="submit" class="lt-button-submit">   
                            
                    </form>
                </div>
            </div>
        </div>    
    </body>
</html>