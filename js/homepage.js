function validateLogin(){
 error_msg = "";
 if($("#log_email").val() == ""){
     error_msg+="&bull; Please enter email address.<br>";     
 }
 if($("#log_password").val() == ""){
     error_msg +="&bull; Please enter password.<br>";
     
 }
 if(error_msg != ""){
     $("#login_errors").html(error_msg);
     $("#login_errors").css('visibility','visible');
     return false;
 }
 submitLogin();
 return false;
}

function validateSignup(){
 var error = false;
 var firstname = $.trim($("#firstname").val());
 var lastname =  $.trim($("#lastname").val());
 var email =  $.trim($("#email").val());
 var password =  $.trim($("#password").val());
 var phone =  $.trim($("#phone").val());
 var skype =  $.trim($("#skype").val());
 
 $(".signup-error-correction").css('visibility','hidden');
 if(firstname == ""){
      $("#firstname-error").html("Please enter first name.");
      $("#firstname-error").css('visibility','visible');
      error = true;
 }
 if(lastname == ""){
      $("#lastname-error").html("Please enter last name.");
      $("#lastname-error").css('visibility','visible');
      error = true;
 }
 if(email == ""){
      $("#email-error").html("Please enter email.");
      $("#email-error").css('visibility','visible');
      error = true;
 } else if(!isValidateEmail(email)){
     $("#email-error").html("Invalid email format.");
     $("#email-error").css('visibility','visible');
      error = true;
 }else if(alreadyEmail(email)){
     $("#email-error").html("Email already exist.");
     $("#email-error").css('visibility','visible');
      error = true;     
 }
 if(password == ""){
      $("#password-error").html("Please enter password.");
      $("#password-error").css('visibility','visible');
      error = true;
 }else if(password.length < 8){
     $("#password-error").html("Password must be atleast 8 characters.");
     $("#password-error").css('visibility','visible');
     error = true;
 }
 if(phone == ""){
      $("#phone-error").html("Please enter phone.");
      $("#phone-error").css('visibility','visible');
      error = true;
 }
 if(skype == ""){
      $("#skype-error").html("Please enter skype id.");
      $("#skype-error").css('visibility','visible');
      error = true;
 }
 if(error == false){
     submitSignup();
 }
 return false;    
}
function alreadyEmail(email){
    var url = "script/already_email.php?email="+email;
    var already = false;   
    $.ajax({
        url: url,        
        success: function(data){
           if($.trim(data).length >= 2){
               already = true;
           }
        },
        async:false
    });
    
    return already;
}
function submitSignup(){
    var url = "script/signup.php";
    
    $.ajax({
        type:"POST",
        url: url,
        data: $("#signupFrm").serialize(),
        success: function(data){
           window.location="index.php?site=work";           
        }
    });return false;
}

function isValidateEmail(email){
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function submitLogin(){
    var url = "script/login.php";
    $.ajax({
        type:"POST",
        url: url,
        data: $("#loginFrm").serialize(),
        success: function(data){
            if($.trim(data).length < 2){
                window.location="index.php";
            }else{ 
                $("#login_errors").html(data);
                $("#login_errors").css('visibility','visible');
                $("#log_password").val("");
            }
        }
    });return false;
    
    
}
