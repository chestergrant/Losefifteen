<div id="shell">
            <?php
                include_once "script/common.php";
                include_once "classes/site.php";
               
                $mySite = new site($db);
                $firstname = $mySite->getFirstname($_SESSION['email']);
                $lastname = $mySite->getLastname($_SESSION['email']);
            ?>
            
            
            
                <div id="text"><h2>Reset Name?</h2></div>
                <div id="instructions">Please enter your new name.</div>
                <div id="aform">
                    <span id="user-error" class="user-error-bubble">#</span>
                    <form id="nameChgFrm" name="nameChgFrm" method="post" action="#" onsubmit="return changeName()">
                        <table width="100%">
                            <tr>
                                <td width="20%">First Name:</td>
                                <td width="80%"><input type="text" id="firstname" name="firstname" placeholder="First Name" value="<?php echo $firstname;?>" class="input-text"><br></td>
                            </tr>
                            <tr>
                                <td width="20%">Last Name:</td>
                                <td width="100%"><input type="text" id="lastname" name="lastname" placeholder="Last Name" value="<?php echo $lastname;?>"class="input-text"><br></td>    
                            </tr>
                            <tr>
                                <td colspan="2"><input type="submit" value="submit" name="submit" class="lt-button-submit"></td>
                            </tr>
                        </table>
                        
                            
                    </form>
                </div>
           
            
           </div> 
