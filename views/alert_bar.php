<tr>
    <td>
            <div class="<?php if($missing){ echo "alert-alarm";}else{ echo "alert-panel";}?>">
                <?php  $name = $contacts[$i]['firstname']." ".$contacts[$i]['lastname'];
                       $name = substr($name,0,20);
                       echo htmlspecialchars($name);
                       if($missing){
                           echo " (missing!!)";
                       }else if($new){
                           echo " <span class='new_group_member'>(new!!)</span>";
                       }
                ?>
            </div>    
    </td>   
</tr>
