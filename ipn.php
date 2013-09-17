<?php
/**
 *  PHP-PayPal-IPN Example
 *
 *  This shows a basic example of how to use the IpnListener() PHP class to 
 *  implement a PayPal Instant Payment Notification (IPN) listener script.
 *
 *  For a more in depth tutorial, see my blog post:
 *  http://www.micahcarrick.com/paypal-ipn-with-php.html
 *
 *  This code is available at github:
 *  https://github.com/Quixotix/PHP-PayPal-IPN
 *
 *  @package    PHP-PayPal-IPN
 *  @author     Micah Carrick
 *  @copyright  (c) 2011 - Micah Carrick
 *  @license    http://opensource.org/licenses/gpl-3.0.html
 */
 
 
/*
Since this script is executed on the back end between the PayPal server and this
script, you will want to log errors to a file or email. Do not try to use echo
or print--it will not work! 

Here I am turning on PHP error logging to a file called "ipn_errors.log". Make
sure your web server has permissions to write to that file. In a production 
environment it is better to have that log file outside of the web root.
*/
ini_set('log_errors', true);
ini_set('error_log', dirname(__FILE__).'/ipn_errors.log');


include_once "script/common.php";
// instantiate the IpnListener class
include('ipnlistener.php');
$listener = new IpnListener();


/*
When you are testing your IPN script you should be using a PayPal "Sandbox"
account: https://developer.paypal.com
When you are ready to go live change use_sandbox to false.
*/
$listener->use_sandbox = false;

/*
By default the IpnListener object is going  going to post the data back to PayPal
using cURL over a secure SSL connection. This is the recommended way to post
the data back, however, some people may have connections problems using this
method. 

To post over standard HTTP connection, use:
$listener->use_ssl = false;

To post using the fsockopen() function rather than cURL, use:
$listener->use_curl = false;
*/

/*
The processIpn() method will encode the POST variables sent by PayPal and then
POST them back to the PayPal server. An exception will be thrown if there is 
a fatal error (cannot connect, your server is not configured properly, etc.).
Use a try/catch block to catch these fatal errors and log to the ipn_errors.log
file we setup at the top of this file.

The processIpn() method will send the raw data on 'php://input' to PayPal. You
can optionally pass the data to processIpn() yourself:
$verified = $listener->processIpn($my_post_data);
*/
try {
    $listener->requirePostMethod();
    $verified = $listener->processIpn();
} catch (Exception $e) {
    error_log($e->getMessage());
    exit(0);
}


/*
The processIpn() method returned true if the IPN was "VERIFIED" and false if it
was "INVALID".
*/
if ($verified) {
    /*
    Once you have a verified IPN you need to do a few more checks on the POST
    fields--typically against data you stored in your database during when the
    end user made a purchase (such as in the "success" page on a web payments
    standard button). The fields PayPal recommends checking are:
    
        1. Check the $_POST['payment_status'] is "Completed"
	    2. Check that $_POST['txn_id'] has not been previously processed 
	    3. Check that $_POST['receiver_email'] is your Primary PayPal email 
	    4. Check that $_POST['payment_amount'] and $_POST['payment_currency'] 
	       are correct
    
    Since implementations on this varies, I will leave these checks out of this
    example and just send an email using the getTextReport() method to get all
    of the details about the IPN.  
    */
    $item_name = $_POST['item_name'];
	$item_number = $_POST['item_number'];
	$payment_status = $_POST['payment_status'];
	$payment_amount = $_POST['mc_gross'];
	$payment_currency = $_POST['mc_currency'];
	$txn_id = $_POST['txn_id'];
	$receiver_email = $_POST['receiver_email'];
	$payer_email = $_POST['payer_email'];
        $custom = $_POST['custom'];
        $error = "";
         
    if($payment_status == 'Completed'){
        $sql = "SELECT * FROM log WHERE txn_id = ?";
       if($stmt = $db->prepare($sql)){
                $stmt->bind_param("s", $txn_id);
                $stmt->execute();
                $stmt->store_result();
                if($stmt->num_rows == 0){
                   if($receiver_email == "mr_chest@hotmail.com"){
                       if($payment_amount == '60.00'){
                           if($payment_currency == 'USD'){
                               //add txn_id to database
                               $sql2 = "INSERT INTO `log`( `log_id` ,`txn_id` ,`payer_email` ,`email` )VALUES (NULL ,  ?,  ?,  ?)";
                               if($stmt2 = $db->prepare($sql2)){
                                     $stmt2->bind_param("sss", $txn_id, $payer_email, $custom);
                                     $stmt2->execute();
                               }
                               //update payment table
                               update_payment($db,$custom);
                               
                           }else{
                               $error = " -  Wrong currency";
                           }
                           
                       }else{
                           $error = " - Wrong amount";
                       }
                       
                   }else{
                       $error = " - Wrong receiver email";
                   }
                }else{
                     $error = " - Duplicate txn_id";
                }
               
       }else{
           $error = " - Cannot connect to DB";
       }
        
    }else{
        $error = " - Payment not completed";
    }
    mail('chester.grant@yahoo.co.uk', 'Verified IPN'.$error, $listener->getTextReport());

} else {
    /*
    An Invalid IPN *may* be caused by a fraudulent transaction attempt. It's
    a good idea to have a developer or sys admin manually investigate any 
    invalid IPN.
    */
    mail('chester.grant@yahoo.co.uk', 'Invalid IPN', $listener->getTextReport());
}

function update_payment($db, $email){
    $end_of_last_subscription = getEndOfLastSubscription($db, 
$email);
    if($end_of_last_subscription < time()){
        $end_of_last_subscription = time();
    }
    $begin = date("Y-m-d",$end_of_last_subscription);
    $new_end = $end_of_last_subscription + 3*30*24*60*60;
    $end = date("Y-m-d", $new_end);
    $amount = 60.0;
    $type = 'T';  //T stands for Three months
    
    $sql2 = "INSERT INTO payment(email, amount, begin, end, type)VALUES(?,?,?,?,?)";
    if($stmt2 = $db->prepare($sql2)){
       $stmt2->bind_param("sdsss", $email,$amount,$begin,$end,$type);
       $stmt2->execute();
    }
    confirm_payment($db, $email, $end);
}
function confirm_payment($db, $email, $end){
    include_once "classes/site.php"; 
    $site = new site($db);
    $subject = "Subscription to Lose Fifteen";
    $from = "no-reply@losefifteen.com";
    $msg = getConfirmationMsg($end);
    $site->sendEmail($email, $msg, $subject, $from);
}
function getConfirmationMsg($end){
    $output =  "<table cellspacing=0 cellpadding=0 style='border: 1px solid #AAA' border=0 align='center'>";
       $output .= "<tr colspan=3 height='36px'></tr>";
       $output .= '<tr>';
       $output .= '<td width="36px">&nbsp;';
       $output .= '</td>';
       $output .= '<td width="454px">';
       $output .= 'Hi,<br><br>';
       $output .= 'This is to confirm your subscription to Lose Fifteen has been extended for<br>';
       $output .= 'the next 3 months. Your subscription ends on '.$end.'.<br><br>';
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
function getEndOfLastSubscription($db, $email){
    $inner = "SELECT max(payment_id) FROM payment WHERE email = ?";
    $sql = "SELECT end FROM payment WHERE payment_id IN(".$inner.")";
    if($stmt = $db->prepare($sql)){
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->store_result();
                 $stmt->bind_result($end);
                if($stmt->num_rows > 0){
                    $stmt->fetch();
                    return strtotime($end);
                }else{
                    return time();
                }
                
    }
}
?>