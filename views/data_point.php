<div class="data-point">
    <table width="100%">
        <tr>
            <td class="blue-label">Date</td>
            <td><?php 
                    if(!emptyStr($feed[$i]['date'])){
                        echo $feed[$i]['date'];
                      }else{
                        echo "&nbsp;";
                      }
                ?>
            </td>
        </tr>
        <tr>
            <td class="blue-label">By</td>
            <td>
                <?php 
                    if(!emptyStr($feed[$i]['firstname'])&& !emptyStr($feed[$i]['lastname'])){
                        echo htmlspecialchars($feed[$i]['firstname'])." ".htmlspecialchars($feed[$i]['lastname']);
                      }else{
                        echo "&nbsp;";
                      }
                ?>
            </td>
        </tr>
        <tr>
            <td class="blue-label">Weight Loss(lbs)</td>
            <td><?php 
                    if(!emptyStr($feed[$i]['weight_loss'])){
                        echo $feed[$i]['weight_loss'];
                      }else{
                        echo "&nbsp;";
                      }
                ?>
            </td>
        </tr>
        <tr>
            <td class="blue-label">Food Diary</td>
            <td>
               <?php 
                    if(!emptyStr($feed[$i]['diary'])){
                        $m = htmlspecialchars($feed[$i]['diary']);
                        echo nl2br($m);
                      }else{
                        echo "&nbsp;";
                      }
                ?>
            </td>
        </tr>
        <tr>
            <td class="blue-label">Calories</td>
            <td><?php 
                    if(!emptyStr($feed[$i]['calories'])){
                        echo htmlspecialchars($feed[$i]['calories']);
                      }else{
                        echo "&nbsp;";
                      }
                ?>
            </td>
        </tr>
        <tr>
            <td class="blue-label">Obstacles</td>
            <td><?php 
                    if(!emptyStr($feed[$i]['obstacles'])){
                        $m = htmlspecialchars($feed[$i]['obstacles']);
                        echo nl2br($m);
                      }else{
                        echo "&nbsp;";
                      }
                ?>
            </td>
        </tr>
        <tr>
            <td class="blue-label">Solution</td>
            <td><?php 
                    if(!emptyStr($feed[$i]['solution'])){
                        $m = htmlspecialchars($feed[$i]['solution']);
                        echo nl2br($m);
                      }else{
                        echo "&nbsp;";
                      }
                ?>
            </td>
        </tr>
        <tr>
            <td class="blue-label">Why?</td>
            <td><?php 
                    if(!emptyStr($feed[$i]['whylose'])){
                        $m = htmlspecialchars($feed[$i]['whylose']);
                        echo nl2br($m);
                      }else{
                        echo "&nbsp;";
                      }
                ?>
            </td>
        </tr>
    </table>
   </div>