<?php
include "connection.php";
?>
<!doctype html>
<html>

<body>

    <form name="payfrm" id="payfrm" action="<?= BASE_URL ?>payscript.php" method="post" style="padding: 25px;">
        
        <input type="hidden" id="desct" value="9999">
        <input type="hidden" name="merchant_param3" value="">
        <input type="hidden" name="merchant_param4" value="">
        <input type="hidden" name="merchant_id" value="353687">
        <input type="hidden" name="language" value="EN">
        <input type="hidden" name="amount" value="1">
        <input type="hidden" name="currency" value="INR">
        <input type="hidden" name="redirect_url" value="<?= BASE_URL ?>success.php">
        <input type="hidden" name="cancel_url" value="<?= BASE_URL ?>success.php">
        <input type="hidden" value="<?php echo 'TXN' . time() . rand(100, 10000); ?>" name="order_id">
        <input type="hidden" name="merchant_param2" value="Subscription">
        <input type="hidden" name="billing_name" value="test name">
        <input type="hidden" name="billing_email" value="test@gmail.com">
        <input type="hidden" name="billing_tel" value="9944227700">

        <button type="submit" class="btn btn_addons"><i class="fa fa-pencil-square"></i> Pay Now</button>

    </form>
</body>

</html>

