<?php

class dietician{
    private $conn;
    private $error;
    function __construct($db){
        $this->conn = $db;
        $this->error = "";
    }
    function getError(){
        return $this->error;
    }
    function checkin($email,$weight,$diary,$calories,$obstacles,$solution,$whylose){
        if($this->isValidCheckinData($email,$weight,$diary,$calories,$whylose)){
            $sql = "INSERT INTO check_in ( email, checkin_time, weight, diary, calories, obstacles, solution, whylose)VALUES(?,?,?,?,?,?,?,?)";
            if($stmt = $this->conn->prepare($sql)){
                $stmt->bind_param("siisisss", $email, time(), $weight, $diary, $calories, $obstacles, $solution, $whylose);
                $stmt->execute();
            }
        }
    }
    
    function isValidCheckinData($email,$weight,$diary,$calories,$whylose){
        $output= true;
        if((!emptyStr($weight))&&(!is_numeric($weight))){
            $this->error .= "Weight is not number.<br>";
            $output = false;
        }
        if(!is_numeric($calories)){
            $this->error .= "Calories is not number.<br>";
            $output = false;
        }
        if(emptyStr($whylose)){
            $this->error .= "You didn't enter a reason why you want to lose.<br>";
            $output = false;
        }
        
        if(emptyStr($diary)){
            $this->error .= "You didn't enter what you ate today.<br>";
            $output = false;
        }
        
        if(!$this->validEmail($email)){
            $this->error .= "Invalid email/login";
            $output = false;
        }
        if(!$this->validCheckinTime($email)&& $output){
          $this->error .= "Not time to check-in. Please check back later";
          $output = false;
        }
        return $output;
    }
    
    function validCheckinTime($email){
     $theTime = time();
     $sql = "SELECT max(checkin_time) AS checkin_time FROM check_in WHERE email = ?";
     if($stmt = $this->conn -> prepare($sql)){
         $stmt -> bind_param("s", $email);
      	 $stmt -> execute();
         $stmt->store_result();
         $stmt->bind_result($checkin_time);
         if($stmt->num_rows == 0){
            return true;
         }
         
         $stmt->fetch();     
         $lastCheckin = $checkin_time;
             
         if($theTime-86400 >= $lastCheckin){
            return true;
         }
         /*$res = $stmt -> get_result();

	 if($res !== false){
             if($res->num_rows == 0){
                 return true;
             }
             $arr = niceArray($res);
             $lastCheckin = $arr[0]['checkin_time'];
             
             if($theTime-86400 >= $lastCheckin){
                 return true;
             }
         }*/
     }
     return false;
    }
    
    function validEmail($email){
        if($stmt = $this->conn -> prepare("SELECT * FROM users WHERE email=?")) {
                $stmt -> bind_param("s", $email);
      		$stmt -> execute();
                $stmt->store_result();
                if($stmt->num_rows != 0){
                    return true;
                }
      		/*$res = $stmt -> get_result();

	        if($res !== false){
                   if($res->num_rows != 0){
                      return true;
                   }
                }*/
     		 /* Close statement */
      		$stmt -> close(); 
         }
         return false;
    }
    
    function getGroupContact($email){
        $inner = "SELECT email FROM groups WHERE active = 'y' AND group_id IN (SELECT group_id FROM groups WHERE email = ?)";
        $sql = "SELECT firstname, lastname, email, password, phone, skype, signup_time FROM users WHERE email != ? AND email IN(".$inner.")";
        $output = array();
        if($stmt = $this->conn -> prepare($sql)) {
                $stmt -> bind_param("ss", $email, $email);
      		$stmt -> execute();
                $stmt->store_result();
                $stmt->bind_result($firstname, $lastname, $email, $password, $phone, $skype, $signup_time);
                if($stmt->num_rows > 0){
                    $count = 0;
                    while($stmt->fetch()){
                        $output[$count]['firstname'] = $firstname;
                        $output[$count]['lastname'] = $lastname;
                        $output[$count]['email'] = $email;
                        $output[$count]['password'] = $password;
                        $output[$count]['phone'] = $phone;
                        $output[$count]['skype'] = $skype;
                        $output[$count]['signup_time'] = $signup_time;
                        $count++;
                    }                                      
                }
      		/*$res = $stmt -> get_result();

	        if($res !== false){
                   $output = niceArray($res);
                }*/
     		 /* Close statement */
      		$stmt -> close(); 
         }
         return $output;
    }
    
    function isNew($site, $email){
        $signup_time = $site->getUserData("signup_time", $email);
        if($signup_time == ""){
            $signup_time = 1357020000;
        }
        $diff = time() - $signup_time;
        $seven_days_ago = (7 * 86400);
        if($diff < $seven_days_ago){
            return true;
        }
        return false;
    }
    
    function getLastCheckin($email){
        $sql = "SELECT max(checkin_time)AS checkin_time FROM check_in WHERE email =?";
        $output = 0;
        if($stmt = $this->conn -> prepare($sql)) {
                $stmt -> bind_param("s", $email);
      		$stmt -> execute();
                $stmt->store_result();
                $stmt->bind_result($checkin_time);
                if($stmt->num_rows > 0){
                    $stmt->fetch();
                    $output = $checkin_time;
                }
      		/*$res = $stmt -> get_result();

	        if($res !== false){
                   $arr = niceArray($res);
                   if(count($arr)> 0){
                       $output = $arr[0]["checkin_time"];
                   }
                }*/
     		 /* Close statement */
      		$stmt -> close(); 
         }
         return $output;
    }
    
    function isMissing($site, $email){
        $signup_time = $site->getUserData("signup_time", $email);
        if($signup_time == ""){
            $signup_time = 1357020000;
        }
        $last_checkin = $this->getLastCheckin($email);
        if($last_checkin == 0){
            $last_checkin = $signup_time;
        }
        $diff = time() - $last_checkin;
        if($diff > 86400){
            return true;
        }
        return false;
        
    }
    function getWeightMinMax($email, $function){
        $sql = "SELECT weight FROM check_in WHERE email = ? AND checkin_time IN (SELECT ".$function."(checkin_time) FROM check_in WHERE email =? AND weight <> '' AND weight IS NOT NULL )";
        $output = 0;
        //echo $sql."<br>";
        if($stmt = $this->conn -> prepare($sql)) {
                $stmt -> bind_param("ss", $email, $email);
      		$stmt -> execute();
                $stmt->store_result();
                $stmt->bind_result($weight);
                if($stmt->num_rows > 0){
                    $stmt->fetch();
                    $output = $weight;
                }
      		/*$res = $stmt -> get_result();

	        if($res !== false){
                   $arr = niceArray($res);
                   if(count($arr)> 0){
                       $output = $arr[0]["weight"];
                   }
                }*/
     		 /* Close statement */
      		$stmt -> close(); 
         }
         return $output;
    }
    
    function getWeightLoss($email){
        $min = $this->getWeightMinMax($email, "MIN");
        $max = $this->getWeightMinMax($email, "MAX");
        
        return $min-$max;
    }
    
    function addDate($feed){
        for($i = 0; $i < count($feed); $i++){
            $feed[$i]['date'] = date("j F Y",$feed[$i]['checkin_time']);
        }
        return $feed;
    }
    function getWeightLossFromEmail($email, $data){
     $output = "";
     for($i = 0; $i < count($data); $i++){
         if($data[$i]['email'] == $email){
             $output = $data[$i]['weight_loss'];
         }
     }
     return $output;
        
    }
    
    function addWeight($feed){
        $data = array();
        $count = 0;
        for($i = 0; $i < count($feed); $i++){
            $in = false;
            for($j=0; $j < count($data); $j++){
                if($feed[$i]['email'] == $data[$j]['email']){
                   $in = true; 
                }                
            }
            if(!$in){
                $data[$count]['email'] =$feed[$i]['email'];
                $data[$count]['weight_loss'] =  $this->getWeightLoss($feed[$i]['email']);
                $count++;
            }
        }
        
        for($i = 0; $i < count($feed); $i++){
            $feed[$i]['weight_loss']= $this->getWeightLossFromEmail($feed[$i]['email'],$data);
        }
        return $feed;
    }
    
    function getFeed($email, $page){
        if(!is_int($page)){
            $page = 1;
        }
        $set_limit = (($page - 1) * 2) . ",2";

        $inner = "SELECT email FROM groups WHERE active='y' AND group_id IN(SELECT group_id FROM groups WHERE active ='y' AND email= ?)";
        $sql = "SELECT check_in.email, checkin_time, weight, diary, calories, obstacles, solution, whylose, firstname, lastname, password, phone, skype, signup_time FROM check_in, users WHERE users.email=check_in.email AND check_in.email IN (".$inner.") ORDER BY checkin_time DESC LIMIT ".$set_limit;
        $output = array();
        
        if($stmt = $this->conn -> prepare($sql)) {
                $stmt -> bind_param("s", $email);
      		$stmt -> execute();
                $stmt->store_result();
                $stmt->bind_result($email, $checkin_time, $weight, $diary, $calories, $obstacles, $solution, $whylose, $firstname, $lastname, $password, $phone, $skype, $signup_time);
                if($stmt->num_rows > 0){
                    $count = 0;
                    while($stmt->fetch()){
                        $output[$count]['checkin_time'] = $checkin_time;
                        $output[$count]['weight'] = $weight;
                        $output[$count]['diary'] = $diary;
                        $output[$count]['calories'] = $calories;
                        $output[$count]['obstacles'] = $obstacles;
                        $output[$count]['solution'] = $solution;
                        $output[$count]['whylose'] = $whylose;
                        $output[$count]['firstname'] = $firstname;
                        $output[$count]['lastname'] = $lastname;
                        $output[$count]['email'] = $email;
                        $output[$count]['password'] = $password;
                        $output[$count]['phone'] = $phone;
                        $output[$count]['skype'] = $skype;
                        $output[$count]['signup_time'] = $signup_time;
                        $count++;
                    }                                      
                }
      		/*$res = $stmt -> get_result();

	        if($res !== false){
                   $output = niceArray($res);
                   
                }*/
     		 /* Close statement */
      		$stmt -> close(); 
         }
         $output = $this->addDate($output);
         $output = $this->addWeight($output);
         return $output;
    }
}
?>
