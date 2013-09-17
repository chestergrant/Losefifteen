<div id="shell">
            <?php
                include_once "script/common.php";
                include_once "classes/site.php";
               
                $mySite = new site($db);
                $phone = $mySite->getPhone($_SESSION['email']);
                $skype = $mySite->getSkype($_SESSION['email']);
            ?>
            
            
            
                <div id="text"><h2>Reset Phone/Skype ID?</h2></div>
                <div id="instructions">Please enter your new phone/skype id.</div>
                <div id="aform">
                    <span id="user-error" class="user-error-bubble">#</span>
                    <form id="phoneskypeChgFrm" name="phoneskypeChgFrm" method="post" action="#" onsubmit="return changePhoneSkype()">
                        <table width="100%">
                            <tr>
                                <td width="20%">Phone:</td>
                                <td width="80%"><input type="text" id="phone" name="phone" placeholder="Phone" value="<?php echo $phone;?>" class="input-text"><br></td>
                            </tr>
                            <tr>
                                <td width="20%">Skype ID:</td>
                                <td width="100%"><input type="text" id="skype" name="skype" placeholder="Skype ID" value="<?php echo $skype;?>"class="input-text"><br></td>    
                            </tr>
                            <tr>
                                <td colspan="2"><input type="submit" value="submit" name="submit" class="lt-button-submit"></td>
                            </tr>
                        </table>
                        
                            
                    </form>
                </div>
           
            
           </div> 

