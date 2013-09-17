<div id="topic-bar">
 <div class="home-topic">Weight Loss <span class="loss">
<?php
 include_once "script/common.php";
 include_once "classes/dietician.php";
 include_once "classes/site.php";  
 
 $dietician = new dietician($db);
 $weight_loss = $dietician->getWeightLoss($_SESSION['email']);
 echo $weight_loss;
 $feed = $dietician->getFeed($_SESSION['email'],1);
 ?></span>lb<?php if($weight_loss != 1){ echo "s";}?></div>
</div>
<div id="content" class="contentPanel">
    <?php 
        for($i = 0; $i < count($feed); $i++){
            include 'views/data_point.php';
        }
    ?>   
</div>
<div id="footer">
    <a id="inifiniteLoader">Loading... <img src="images/ajax-loader.gif" /></a>
</div>
