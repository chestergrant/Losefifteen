<?php
 $header = "Subscribe";
 $subscript = "Pay for a subscription to lose fifteen.";
 include_once 'script/topic_bar.php';
?>
<div id="subscribePanel" class="contentPanel">
    <?php 
      if($site_class->expired_subscription($_SESSION['email'], time()+(8*24*60*60))){
          $days_to_expire = $site_class->days_left($_SESSION['email']);
          
          if($days_to_expire > 0){
              echo "Your subscription expires in <b>".$days_to_expire." day";
              if($days_to_expire > 1){
                 echo "s"; 
              }
              echo ".</b>";
          }else{
              echo "Your subscription has expired.";
          }
    ?>
    <table>
        <tr>
            <td>
                3 months subscription ($20/month)
            </td>
            <td>
    <form action="https://www.paypal.com/cgi-bin/webscr" method="post">

<!-- Identify your business so that you can collect the payments. -->
<input type="hidden" name="business" value="mr_chest@hotmail.com">

<!-- Specify a Buy Now button. -->
<input type="hidden" name="cmd" value="_xclick">

<!-- Specify details about the item that buyers will purchase. -->
<input type="hidden" name="item_name" value="3 months subscription">
<input type="hidden" name="item_number" value="1">
<input type="hidden" name="amount" value="60.00">
<input type="hidden" name="no_shipping" value="1">
<input type="hidden" name="no_note" value="1">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="bn" value="PP-BuyNowBF">
<input type="hidden" name="return" value="http://www.losefifteen.com">
<input type="hidden" name="cancel_return" value="http://www.losefifteen.com">
<input type="hidden" name="notify_url" value="http://www.losefifteen.com/ipn.php">
<input type="hidden" name="custom" value="<?php echo $_SESSION['email']?>">
<!-- Display the payment button. -->
<input type="image" name="submit" border="0"
src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif"
alt="PayPal - The safer, easier way to pay online">
<img alt="" border="0" width="1" height="1"
src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >

</form>
                </td>
           </tr>
         </table>
    <?php }else{
         echo "You have already paid for your subscription to Lose Fifteen.";
    }
?>
</div>
