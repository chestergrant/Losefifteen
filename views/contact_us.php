<?php
 $header = "Contact Us";
 $subscript = "If you wish to provide feedback or report an error please fill in the form below.";
 include_once 'script/topic_bar.php';
?>
<div id="contact-us-panel" class="contentPanel">
    <span id="user-error" class="user-error-bubble">#</span>
<form id="contactFrm" name="contactFrm" method="post" action="#" onsubmit="return validateContact()">
    <table>
        <tr>
            <td>Subject</td>
            <td><input id="subject" type="text" name="subject"></td>
        </tr>
        <tr>
            <td>Message</td>
            <td><textarea id="message" name="message"></textarea></td>
        </tr>
        <tr>
            <td colspan="2"><center><input type="submit" name="submit" class="lt-button-submit" id="submit" value="Send"></center></td>
        </tr>
    </table>    
</form>
</div>
