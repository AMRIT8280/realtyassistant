<?php
include "connection.php";

$workingKey = '22FA4980C56ACF3EF4B5A931F9879EBC';		//Working Key should be provided here.
$encResponse = $_POST["encResp"];						//This is the response sent by the CCAvenue Server
$rcvdString = decrypt($encResponse, $workingKey);		//Crypto Decryption used as per the specified working key.
$order_status = "";
$decryptValues = explode('&', $rcvdString);
$dataSize = sizeof($decryptValues);

for ($i = 0; $i < $dataSize; $i++) {
	$information = explode('=', $decryptValues[$i]);
	$responseMap[$information[0]] = $information[1];
}
$order_status = $responseMap['order_status'];
$frmtypes = $responseMap['merchant_param4'];


if ($order_status === "Success") {
	echo "success";
} else if ($order_status === "Aborted") {
	echo "Transaction has been Canceled";
			
} else if ($order_status === "Failure") {
	echo "However,the transaction has been declined.";

} else {
	echo "Security Error. Illegal access detected";
		
}


