function recoverPassword(){
    var email = $.trim($("#email").val());
    var error = false;
    if(email == ""){
        $("#email-error").css("visibility","visible");
        $("#email-error").html("Invalid Email");
        error = true;
        
    }else if(!alreadyEmail(email)){
        $("#email-error").css("visibility","visible");
        $("#email-error").html("Email doesn't exist in our system");
        error = true;
    }
    if(!error){
        submitRecovery();
    }
    return false;
    
}
function submitRecovery(){
    var url = "script/recover.php";
    
    $.ajax({
        type:"POST",
        url: url,
        data: $("#recoverFrm").serialize(),
        success: function(data){
           if($.trim(data).length < 2){
               $("#shell").html("A link has been sent to your email address to reset your password.<br>Please check your spam folder if it isn't in your inbox.");
           }else{
               $("#shell").html("An unexpected error has occurred.<br>"+data);
           }          
        }
    });return false;
}


