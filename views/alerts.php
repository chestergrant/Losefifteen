
    <?php
                include_once "script/common.php";
                include_once "classes/dietician.php";
                include_once "classes/site.php";
                
                $mySite = new site($db);
                $dietician = new dietician($db);
                $contacts  = $dietician->getGroupContact($_SESSION["email"]);
                if(count($contacts) != 0){
    ?>
<table>
    <tr><td><h2><span style="margin-left:35px;">Group Members</span></h2></td></tr>
        <?php 
            for($i = 0; $i < count($contacts); $i++){
                $new = $dietician->isNew($mySite, $contacts[$i]['email']);
                $missing = $dietician->isMissing($mySite, $contacts[$i]['email']);
                include 'views/alert_bar.php';
            }
        ?>
</table>
                <?php } ?>


