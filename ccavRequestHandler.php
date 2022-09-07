<html>

<head>
	<title> Non-Seamless-kit</title>
</head>

<body>
	<center>

		<?php
		include("config.php");
		include("crypto.php");

		error_reporting(0);

		if (isset($_POST["pay_now_btn"])) {
			$processToPayment = procceed_to_payment($_POST);
			if ($processToPayment["status"] == "success") {

				$merchant_data = '';
				$working_key = $CC_AV_WORKING_KEY; //Shared by CCAVENUES
				$access_code = $CC_AV_ACCESS_CODE; //Shared by CCAVENUES

				//Compulsory
				$merchant_data .= 'tid=' . $processToPayment["data"]["tnx_id"] . '&';
				$merchant_data .= 'merchant_id=' . $CC_AV_MERCHANT_ID . '&';
				$merchant_data .= 'order_id=' . $processToPayment["data"]["order_id"] . '&';
				$merchant_data .= 'amount=' . $processToPayment["data"]["amount"] . '&';
				$merchant_data .= 'currency=INR&';
				$merchant_data .= 'redirect_url=' . $CC_AV_REDIRECT_URL . '&';
				$merchant_data .= 'cancel_url=' . $CC_AV_CANCEL_URL . '&';
				$merchant_data .= 'language=EN&';


				//optional
				$merchant_data .= 'billing_name=' . $_POST["billing_name"] . '&';
				$merchant_data .= 'billing_address=' . $_POST["billing_address"] . '&';
				$merchant_data .= 'billing_city=' . $_POST["billing_city"] . '&';
				$merchant_data .= 'billing_state=' . $_POST["billing_state"] . '&';
				$merchant_data .= 'billing_zip=' . $_POST["billing_zip"] . '&';
				$merchant_data .= 'billing_country=INDIA&';
				$merchant_data .= 'billing_tel=' . $_POST["billing_tel"] . '&';
				$merchant_data .= 'billing_email=' . $_POST["billing_email"] . '&';

				/*foreach ($_POST as $key => $value){
					$merchant_data.=$key.'='.$value.'&';
				}*/
				$encrypted_data = encrypt($merchant_data, $working_key); // Method for encrypting the data.


				?>
				<form method="post" name="redirect" action="https://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction">
					<?php
					echo "<input type=hidden name=encRequest value=$encrypted_data>";
					echo "<input type=hidden name=access_code value=$access_code>";
					?>
				</form>

				<?php
			} else {
				print_r($processToPayment["message"]);
			}
		}else{
			header("location: ".BASE_URL);
		}
		?>
	</center>
	<script language='javascript'>
		document.redirect.submit();
	</script>
</body>

</html>