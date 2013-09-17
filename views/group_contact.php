<div>
<?php
 include_once "script/common.php";
 include_once "classes/dietician.php";
 
 $dietician = new dietician($db);
 $contact = $dietician->getGroupContact($_SESSION["email"]);
 
 if(count($contact) == 0){
     echo "Sorry there is no one else in your group.  Please be patience, new group members will be added shortly<br>";
 }else{
?>
    <table width="100%" cellspacing="20px">
        <?php
          $newRow = false;
           for($i = 0; $i< count($contact); $i++){
               $newRow = false;
               if($i % 2 == 0){
                   $newRow = true;
               }
               if($newRow){
                   echo "<tr>";
               }
               echo "<td>";
               include 'views/contact_card.php';
               echo "</td>";
               if(!$newRow){
                   echo "</tr>";
               }
           }
           if($newRow){
               echo "<td>&nbsp</td></tr>";
           }
        ?>
        
    </table>
<?php } ?>
</div>