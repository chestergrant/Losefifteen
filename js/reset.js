function resetPassword(){
    var  password =$.trim($("#password").val());
    var  retypepassword =$.trim($("#retypepassword").val());  
    var error = false;
    if(password == ""){
        $("#password-error").html("Password is blank.");
        $("#password-error").css("visibility", "visible");
        error = true;
    }else if(password.length < 8){
        $("#password-error").html("Password is less than 8 character.");
        $("#password-error").css("visibility", "visible");
        error = true;
    }else if(password != retypepassword){
        $("#password-error").html("Passwords don't match.");
        $("#password-error").css("visibility", "visible");
        error = true;        
    }
    if(!error){
        submitReset();
    }
    return false;
}

function submitReset(){
    var url = "script/reset_password.php";
    
    $.ajax({
        type:"POST",
        url: url,
        data: $("#recoverFrm").serialize(),
        success: function(data){
           if($.trim(data).length < 2){
               $("#shell").html("Your password has been reset. To login click <a href='index.php'>here</a>.");
           }else{
               $("#shell").html("An unexpected error has occurred.<br>"+data);
           }          
        }
    });
    return false;
}

