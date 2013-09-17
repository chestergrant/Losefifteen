
$(document).ready(function(){
    $("#logout").click(function(){ $.get('script/logout.php', 
    function(data){         
        window.location="index.php";
    });
   
});
   var count = 2;  
          $(window).scroll(function(){  
                  if  ($(window).scrollTop() == $(document).height() - $(window).height()){  
                     loadArticle(count);  
                     count++;  
                  }  
          });   
  
          function loadArticle(pageNumber){      
                  $('a#inifiniteLoader').show('fast');  
                  $.ajax({  
                      url: "script/home.php",  
                      type:'POST',  
                      data: "page_no="+ pageNumber ,   
                      success: function(html){  
                          $('a#inifiniteLoader').hide('1000');  
                          $("#content").append(html);    // This will be the div where our content will be loaded  
                      }  
                  });  
              return false;  
          }  

});

function closeBubbles(){
    $("#diary_error");
    $("#calories_error").css('visibility','hidden');
    $("#whylose_error").css('visibility','hidden');
    $("#weight_error").css('visibility','hidden');
}

function validateCheckin(){
 var diary = $.trim($("#diary").val());
 var calories = $.trim($("#calories").val());
 var whylose = $.trim($("#whylose").val());
 var weight = $.trim($("#weight").val());
 var error = false;
 closeBubbles();
 if(diary == ""){
     $("#diary_error").css('visibility','visible');
     $("#diary_error").html("Please enter what you ate today.");
     error = true;
 }
 if(calories == ""){
     $("#calories_error").css('visibility','visible');
     $("#calories_error").html("Please enter calories consumed today.");
     error = true;
 }else{
     if(!$.isNumeric(calories)){
         $("#calories_error").css('visibility','visible');
         $("#calories_error").html("Please enter the number of calories consumed today.");
         error = true;
     }
 }
 if(whylose == ""){
     $("#whylose_error").css('visibility','visible');
     $("#whylose_error").html("Please enter why you want lose weight.");
     error = true;
 }
 if(weight != ""){
     if(!$.isNumeric(weight)){
         $("#weight_error").css('visibility','visible');
         $("#weight_error").html("Please enter a number for your weight.");
         error = true;
     }
 }
 if(!error){
     submitCheckin();
 }
 return false;
}

function submitCheckin(){
    var url = "script/checkin.php";
    $.ajax({
        type:"POST",
        url: url,
        data: $("#checkinFrm").serialize(),
        success: function(data){
           $("#checkinPanel").html("Good job.  Your check-in for today has been recorded. Please return tomorrow to check-in.");
        }
    });return false;
    
}

function changeName(){
   var error = false;
   var firstname = $.trim($("#firstname").val());
   var lastname = $.trim($("#lastname").val());
   if(firstname == ""){
       error = true;
       $("#user-error").html("Please enter your first name");
       $("#user-error").css("visibility","visible");
   }else if(lastname == ""){
       error = true;
       $("#user-error").html("Please enter your last name");
       $("#user-error").css("visibility","visible");
   }
   if(!error){
       submitNameChg();
   }
   return false;
}
function submitNameChg(){
     var url = "script/change_name.php";
    $.ajax({
        type:"POST",
        url: url,
        data: $("#nameChgFrm").serialize(),
        success: function(data){
            if($.trim(data).length < 2){
                $("#shell").html("Your name has been changed appropriately.");
            }else{
                $("#shell").html("An unexpected error has occurred. "+data);
            }
        }
    });
    return false;
}
function changePassword(){
    var error = false;
    var password =  $.trim($("#password").val());
    var retypepassword = $.trim($("#retypepassword").val());
    if(password == ""){
       error = true; 
       $("#user-error").html("Password is blank");
       $("#user-error").css("visibility","visible");
    }else if( password.length < 8){
       error = true; 
       $("#user-error").html("Password must be atleast 8 characters");
       $("#user-error").css("visibility","visible");
    }else if(password != retypepassword){
       error = true; 
       $("#user-error").html("Password don't match");
       $("#user-error").css("visibility","visible");
    }
    if(!error){
        submitPasswordChg();
    }
    return false;
}

function submitPasswordChg(){
     var url = "script/change_password.php";
    $.ajax({
        type:"POST",
        url: url,
        data: $("#passwordChgFrm").serialize(),
        success: function(data){
            if($.trim(data).length < 2){
                $("#shell").html("Your password has been changed appropriately.");
            }else{
                $("#shell").html("An unexpected error has occurred. "+data);
            }
        }
    });
    return false;
}
function changePhoneSkype(){
    var error = false;
    var phone = $.trim($("#phone").val());
    var skype = $.trim($("#skype").val());
    if(phone == ""){
       error = true; 
       $("#user-error").html("Phone is a blank field");
       $("#user-error").css("visibility","visible");
    }else if(skype == ""){
        error = true; 
       $("#user-error").html("Skype ID is not set");
       $("#user-error").css("visibility","visible");
    }
    if(!error){
        submitPhoneSkype();
    }
    return false;
}
function submitPhoneSkype(){
     var url = "script/change_phone_skype.php";
    $.ajax({
        type:"POST",
        url: url,
        data: $("#phoneskypeChgFrm").serialize(),
        success: function(data){
            if($.trim(data).length < 2){
                $("#shell").html("Your phone/skype id has been changed appropriately.");
            }else{
                $("#shell").html("An unexpected error has occurred. "+data);
            }
        }
    });
    return false;
}

function validateContact(){
    var error = false;
    var subject = $.trim($("#subject").val());
    var message = $.trim($("#message").val());
    if(subject == ""){
       error = true; 
       $("#user-error").html("Subject is a blank field");
       $("#user-error").css("visibility","visible");
    }else if(message == ""){
       error = true; 
       $("#user-error").html("Message is a blank field");
       $("#user-error").css("visibility","visible");        
    }
    if(!error){
        submitContact();
    }
    return false;
}
function submitContact(){
     var url = "script/contact_us.php";
    $.ajax({
        type:"POST",
        url: url,
        data: $("#contactFrm").serialize(),
        success: function(data){
            if($.trim(data).length < 2){
                $("#contact-us-panel").html("Your message was successfully sent.");
            }else{
                $("#contact-us-panel").html("An unexpected error has occurred. "+data);
            }
        }
    });
    return false;
}