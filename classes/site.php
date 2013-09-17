<?php
class site{
   private $conn;
   private $login_err;
   private $signup_err;
  function __construct($db) {
      $this->conn = $db;
      $this->login_err= "";
      $this->signup_err= "";
   }
   
   function sendRecoverEmail($email){
       if($this->validRecoveryEmail($email)){
           $resetStr = $this->setRecoveryStr($email);
           $msg = $this->getRecoveryEmailMsg($resetStr);
           $subject = "Reset Password";
           $this->sendEmail($email,$msg, $subject,"no-reply@losefifteen.com");
       }
   }
   function days_left($email){
    $inner = "SELECT max(payment_id) FROM payment WHERE email = ?";
    $sql = "SELECT end FROM payment WHERE payment_id IN(".$inner.")";
    if($stmt = $this->conn->prepare($sql)){
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->store_result();
                 $stmt->bind_result($end);
                if($stmt->num_rows > 0){
                    $stmt->fetch();
                    $end_time = strtotime($end);
                    $diff = $end_time - time();
                    if($diff <= 0 ){
                        return 0;
                    }else{
                        $days = ceil($diff /(24*60*60));
                        return $days;
                    }
                }else{
                    return 0;
                }
                
    }
   }
   
   function expired_subscription($email,$timestamp){
       $date = date("Y-m-d", $timestamp);
       $sql = "SELECT * FROM payment WHERE end >= '".$date."' AND email = ?";
       if($stmt = $this->conn->prepare($sql)){
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            if($stmt->num_rows == 0){
                  return true;  
            }
       }
       return false;
   }
   function contact_us($subject, $message, $email){
       $error = false;
       if(emptyStr($subject)){
           $error = true;
           echo "Subject is a blank field<br>";
       }else if(emptyStr($message)){
           $error = true;
           echo "Message is a blank field<br>";
       }
       if(!$error){
        $subject = "My Site: ".$subject;
        $this->sendEmail("chester.grant@yahoo.co.uk", $message, $subject, $email);
       }
   }
   
   function sendEmail($email, $msg, $subject,$from){
       $headers = 'From: '.$from . "\r\n" .
                  'Reply-To: '.$from . "\r\n" ;
       $headers .= "MIME-Version: 1.0\r\n";
       $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        
        mail($email, $subject, $msg, $headers);
   }
   
   function getRecoveryEmailMsg($resetStr){
       $output =  "<table cellspacing=0 cellpadding=0 style='border: 1px solid #AAA' border=0 align='center'>";
       $output .= "<tr colspan=3 height='36px'></tr>";
       $output .= '<tr>';
       $output .= '<td width="36px">&nbsp;';
       $output .= '</td>';
       $output .= '<td width="454px">';
       $output .= 'Hi,<br><br>';
       $output .= 'It was recently requested that you want to change your password.<br><br>';
       $output .= 'If this was indeed you, please click on the link below else ignore this email.<br><br>';
       $output .= '<center><a style="border:1px solid #2270AB; padding:14px 7px 14px 7px; margin: 0px auto 0px auto; font-size:16px; background:#33A0E8; width:210px;" href="http://www.losefifteen.com/index.php?site=reset&hash='.$resetStr.'">Reset</a><br><br></center>';
       $output .= 'Thanks,<br>';
       $output .= 'Lose Fifteen Team';
       $output .= '</td>';
       $output .= '<td width="36px">&nbsp;';
       $output .= '</td>';
       $output .= '</tr>';
       $output .= "<tr colspan=3 height='36px'></tr>";
       $output .= "</table>";
       return $output;
   }
   
   function setRecoveryStr($email){
       $output = $email.time();
       $output = md5($output);
       $sql = "INSERT INTO recovery (email, hash, time) VALUES(?,?,?)";
         
        if($stmt = $this->conn->prepare($sql)){
                $stmt->bind_param("ssi", $email,$output,time());
                $stmt->execute();
                $user = true;
         }
       return $output;
   }
   
   function validRecoveryEmail($email){
       $output = true;
       if(emptyStr($email)){
           $output = false;
           echo "Invalid Email";
       }
       if(!$this->alreadyUsed($email)){
           $output = false;
           echo "Email doesn't exist in our system.";
       }
       return $output;
   }
   
   function signup($firstname,$lastname,$email,$password,$phone,$skype){
       if($this->validSignupData($firstname,$lastname,$email,$password,$phone,$skype)){
         //hash password
         $salt = $this->generateSalt($email);
         $g_password = $this->generateHash($salt,$password);
         //store signup data
         $sql = "INSERT INTO users (firstname, lastname, email, password, phone, skype, signup_time) VALUES(?,?,?,?,?,?,?)";
         $user = false;
         if($stmt = $this->conn->prepare($sql)){
                $stmt->bind_param("ssssssi", ucwords(strtolower($firstname)), ucwords(strtolower($lastname)),$email,$g_password,$phone,$skype,time());
                $stmt->execute();
                $user = true;
         }
         //add user to a group
         if($user){
             $this->addToGroup($email);
             $this->freeTrial($email);
             $this->login($email, $password);
         }
         
       }
   }
   
   function freeTrial($email){
       $begin = date("Y-m-d", time());
       $end = date("Y-m-d", time()+(1000*7*24*60*60));
       $sql = "INSERT INTO `payment`(`payment_id`, `email`,`amount` ,`begin`,`end`,`type`)VALUES (NULL ,  ?,  '0',  '".$begin."',  '".$end."',  'F')";
       if($stmt = $this->conn->prepare($sql)){
                $stmt->bind_param("s", $email);
                $stmt->execute();              
       }
   }
   
   function maxGroupNum(){
       $sql = "SELECT max(group_id) AS group_id FROM groups";
       $res = $this->conn->query($sql);
       $arr = niceArray($res);
       if(count($arr) == 0){
           return 1;
       }
       return $arr[0]["group_id"];
   }
   
   function numInGroup($group_id){
       $sql = "SELECT * FROM groups WHERE group_id =".$group_id;
       $res = $this->conn->query($sql);
       $arr = niceArray($res);
       return count($arr);
       
   }
   
   function addToGroup($email){
       $num = $this->maxGroupNum();
       $size = $this->numInGroup($num);
       if($size >= 4){
           $num++;
       }
       $sql = "INSERT INTO groups(group_id, email)VALUES(?,?)";
       if($stmt = $this->conn->prepare($sql)){
                $stmt->bind_param("ss", $num, $email);
                $stmt->execute();
       }
   }
   
   function alreadyUsed($email){
       $output = false;
       $sql = "SELECT * FROM users WHERE email = ?";
       if($stmt = $this->conn->prepare($sql)){
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->store_result();
                if($stmt->num_rows > 0){
                    $output = true;
                }
                /*$res = $stmt -> get_result();
                $arr = niceArray($res);
                if(count($arr) > 0){
                    $output = true;
                }*/
       }
       return $output;
   }
   
   function validSignupData($firstname,$lastname,$email,$password,$phone,$skype){
       $output = true;
       if(emptyStr($firstname)){
           $this->signup_err .= "Please fill in your first name.<br>";
           $output = false;
       }
       if(emptyStr($lastname)){
           $this->signup_err .= "Please fill in your last name.<br>";
           $output = false;
       }
       if(emptyStr($email)){
          $this->signup_err .= "Please enter a valid email address.<br>";
          $output = false;
       }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
           $this->signup_err .= "Invalid email.<br>";
           $output = false;
       }else if($this->alreadyUsed($email)){
            $this->signup_err .= "This email already in use.<br>";
            $output = false;
       }
       if(emptyStr($password)){
           $this->signup_err .= "Please enter a password.<br>";
           $output = false;
       }else if(strlen($password)< 8){
           $this->signup_err .= "Please enter password atleast 8 characters long<br>";
           $output = false;
           
       }
       if(emptyStr($phone)){
           $this->signup_err .= "Please enter a phone number.<br>";
           $output = false;
       }
       if(emptyStr($skype)){
           $this->signup_err .= "Please enter a skype id.<br>";
           $output = false;
       }
       return $output;
   }
   
   function login($email, $password){
         $this->login_err= "";
         $salt = $this->generateSalt($email);
         $g_password = $this->generateHash($salt,$password);
         
         if($stmt = $this->conn -> prepare("SELECT * FROM users WHERE email=? AND password=?")) {
                $stmt -> bind_param("ss", $email, $g_password);

	      /* Execute it */
      		$stmt -> execute();
                
                $stmt->store_result();
                if($stmt->num_rows == 0){
                    $this->login_err .= "&bull; Couldn't login. Please try again.";
                }else{
                      $this->login_err = "";
                      $this->setupSessions($email);
                }
	      /* Bind results */
      	      /* $res = $stmt -> get_result();

	        if($res !== false){
                   if($res->num_rows == 0){
                      $this->login_err .= "&bull; Couldn't login. Please try again.";
                   }else{
                      $this->login_err = "";
                      $this->setupSessions($email);
                   }
                }else{
                     $this->login_err .= "Couldn't connect to the Database";
                }*/

     		 /* Close statement */
      		$stmt -> close(); 
         }else{
             $this->login_err .= "Couldn't connect to the Database";
	 }

   }
   
   function setupSessions($email){
         $_SESSION['email'] = $email;    
   }
   
   function loginErrors(){
       echo $this->login_err;
   }
   
   function signupErrors(){
       echo $this->signup_err;
   }
   
   function generateHash($salt, $password) {
	$hash = crypt($password, $salt);
	$hash = substr($hash, 29);
	return $hash;
   }
   
   function generateSalt($email) {
	$salt = '$2a$13$';
	$salt = $salt . md5(strtolower($email));
	return $salt;
   }
   
   function validHash($hash){
       $day_ago = time() - 86400;
       $sql =  "SELECT * FROM recovery WHERE hash=? AND time >= ".$day_ago;
       $output = false;
       if($stmt = $this->conn->prepare($sql)){
                $stmt->bind_param("s", $hash);
                $stmt->execute();
                $stmt->store_result();
                if($stmt->num_rows > 0){
                    $output = true;
                }
                /*$res = $stmt -> get_result();
                $arr = niceArray($res);
                if(count($arr) > 0){
                    $output = true;
                }*/
       }
       
       return $output;
   }
   
   function validPassword($password, $retypepassword){
       $output = true;
       if(emptyStr($password)){
           echo "Password is blank.<br>";
           $output = false;
       }else if(strlen($password) < 8){
           echo "Password must be atleast 8 characters.<br>";
           $output = false;
       }else if($password != $retypepassword){
           echo "Passwords don't match.<br>";
           $output = false;           
       }
       
       return $output;
       
   }
   
   function getEmailFromHash($hash){
       $output = "";
       $sql = "SELECT email FROM recovery WHERE hash = ?";
       if($stmt = $this->conn->prepare($sql)){
                $stmt->bind_param("s", $hash);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($email);
                if($stmt->num_rows > 0){
                    $stmt->fetch();                    
                    $output = $email;
                }
                /*$res = $stmt -> get_result();
                $arr = niceArray($res);
                if(count($arr) > 0){
                   $output = $arr[0]['email'];
                }*/
       }
       return $output;
   }
   
   function resetPassword($password,$retypepassword,$hash){
       if($this->validHash($hash)){
          if($this->validPassword($password,$retypepassword)){
              $email = $this->getEmailFromHash($hash);
              $salt = $this->generateSalt($email);
              $g_password = $this->generateHash($salt,$password);              
              $sql = "UPDATE users SET password='".$g_password."' WHERE email='".$email."'";
              $this->conn->query($sql);
              $this->login($email, $password);
          }           
       }else{
           echo "Invalid reset link.<br>";
       }
   }
   
   function getUserData($field,$email){
       $sql = "SELECT ".$field." FROM users WHERE email = ?";
       
       $output="";
       if($stmt = $this->conn->prepare($sql)){
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($col);
                if($stmt->num_rows > 0){
                    $stmt->fetch();                    
                    $output = $col;
                }
                /*$res = $stmt -> get_result();
                $arr = niceArray($res);
                if(count($arr) > 0){
                    $output = $arr[0][$field];
                }*/
       }
       return $output;
       
   }
   
   function getFirstname($email){
       return $this->getUserData("firstname", $email);
   }
   
   function getLastname($email){
       return $this->getUserData("lastname", $email);
   }
   
   function getPhone($email){
       return $this->getUserData("phone", $email);
   }
   
   function getSkype($email){
       return $this->getUserData("skype", $email);
   }
   
   function updateUserData($field,$value,$email){
       $sql = "UPDATE users SET ".$field." = '".$value."' WHERE email = ?";
       //echo $sql."<br>";
       $output="";
       if($stmt = $this->conn->prepare($sql)){
                $stmt->bind_param("s", $email);
                $stmt->execute();
       }
       return $output;
       
   }
   
   function chgName($firstname, $lastname, $email){
       $error = false;
       if(emptyStr($firstname)){
           $error = true;
           echo "Please enter your first name.<br>";
       }
       if(emptyStr($lastname)){
           $error = true;
           echo "Please enter your last name.<br>";
       }
       if(!$error){
           $this->updateUserData("firstname",ucwords(strtolower($firstname)), $email);
           $this->updateUserData("lastname", ucwords(strtolower($lastname)), $email);
       }
   }
   
   function chgPassword($password, $retypepassword, $email){
       $error = false;
       if(emptyStr($password)){
           $error = true;
           echo "Password is blank<br>";
       }else if( strlen($password) < 8){
           $error = true;
           echo "Passwords must be atleast 8 characters.<br>";
       }else if($password != $retypepassword){
           $error = true;
           echo "Passwords don't match.<br>";
       }
       if(!$error){
           $salt = $this->generateSalt($email);
           $g_password = $this->generateHash($salt,$password);
           $this->updateUserData("password", $g_password, $email);
       }
   }
   
   function chgPhoneSkype($phone, $skype, $email){
       $error = false;
       
       if(emptyStr($phone)){
           $error = true;
           echo "Phone is a blank field";
       }else if(emptyStr($skype)){
           $error = true;
           echo "Skype ID is a blank field";
       }
       if(!$error){
           $this->updateUserData("phone", $phone, $email);
           $this->updateUserData("skype", $skype, $email);
       }
          
   }
}
?>