<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Lose Fifteen</title>
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/homepage.js?<?php echo time();?>"></script>
	<link rel="stylesheet" charset="utf-8" media="screen" href="css/style.css?<?php echo time();?>">        
	<link rel="stylesheet" charset="utf-8" media="screen" href="css/homepage.css?<?php echo time();?>">
</head>
<body>
    <?php include_once("script/analyticstracking.php") ?>
      <div id=top_bar>
          <div id="logo"><span id="lose">lose</span><span id="fifteen">Fifteen</span></div>
          <div id="login">
              <form id="loginFrm" method="post" action="#" onsubmit="return validateLogin()">
                  <table cellpadding="0">
                      <tr>
                          <td>Email</td>
                          <td colspan="2">Password</td>
                      </tr>
                      <tr>
                          <td><input type="text" name="log_email" id="log_email"></td>
                          <td><input type="password" name="log_password" id="log_password"></td>
                          <td><input type="submit" name="submit" id="submit" class="lt-button-submit" value="Log In"></td>
                      </tr> 
                      <tr>
                          <td colspan="3"><a href="index.php?site=forgotten">Forget Password?</a></td>
                          </tr>
                  </table>
              </form>   
              <span id="login_errors" class="speech">#</span> 
          </div>    
      </div>
      <div id ="bottom-panel">
          <div id="mission">
              Welcome to Lose Fifteen<br>
              <div id="mission-points">
               <p align="justify">The objective of this service is to lose atleast 15 pounds.  Sticking to a diet is difficult. Lose 
Fifteen is setup in such a way to maximize your chances of losing weight. Firstly, we have daily check-in which asks for your 
weight. It has been shown that those who daily weigh-in lose twice as much as those who don't. Additionally, as part of the 
daily check-in, you keep a food diary. In a study published in the August 2008 edition of the American Journal of Preventive 
Medicine, it was found a predictor of weight loss is how many days per week a food diary was kept. Lastly, we offer 
accountability. Each member of the site is placed into a group where members of the group contact(via skype or email) each 
other when they go missing from their daily check-in. 95% of participants in a University of Pennsylvania weight-loss program 
who join with friends stuck with the program compared to 76% who did the program solo.
<br><br>
Lose Fifteen is free. Give it a go, signup takes less than a minute.
              </p> </div>
          </div>
          <div id="signup">
             <strong>Sign up
              </strong>
              <form id="signupFrm" method="post" action="#" onsubmit="return validateSignup()">
                  <table>
                      <tr>
                        <td>
                            <label for="firstname">First Name</label>   
                        </td>
                        <td>
                            <input type="text" name="firstname" placeholder="First Name" id="firstname">
                        </td>
                      <tr>
                      <tr>
                          <td>
                            <label for="lastname">Last Name</label>   
                          </td>
                          <td>
                            <input type="text" name="lastname" placeholder="Last Name" id="lastname">
                           </td>
                      </tr>
                         <tr>
                          <td>
                  <label for="email">Email</label> 
                  </td>
                          <td>
                  <input type="text" name="email" placeholder="Email" id="email">    
                          </td>
                      </tr>
                          <tr>
                          <td>
                  <label for="password">Password</label>   
                  </td>
                          <td>
                  <input type="password" name="password" placeholder="Password" id="password">
                          </td>
                      </tr>
                          <tr>
                          <td>
                  <label for="phone">Phone</label> 
                  </td>
                          <td>
                  <input type="text" name="phone" placeholder="Phone" id="phone">
                          </td>
                      </tr>
                          <tr>
                          <td>
                  <label for="skype">Skype ID</label>  
                  </td>
                          <td>
                  <input type="text" name="skype" placeholder="Skype ID" id="skype">
                          </td>
                      </tr>
                          <tr>
                              <td colspan="2">
                   <input type="submit" name="submit" value="submit" id="submit" class="lt-button-submit">
                       </td></tr>
                       </table>
              </form>
          </div> 
          <div id="field-errors">
            <span id="firstname-error" class="signup-error-bubble signup-error-correction">#</span>
            <span id="lastname-error" class="signup-error-bubble signup-error-correction">#</span>
            <span id="email-error" class="signup-error-bubble signup-error-correction">#</span>
            <span id="password-error" class="signup-error-bubble signup-error-correction">#</span>
            <span id="phone-error" class="signup-error-bubble signup-error-correction">#</span>
            <span id="skype-error" class="signup-error-bubble signup-error-correction">#</span>
          </div>
      </div>
    
</body>
</html>