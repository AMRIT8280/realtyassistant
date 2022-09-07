<?php

include("connection.php");

if(isset($_REQUEST['city_id']) && $_REQUEST['city_id']!='' && $_REQUEST['ap_type']!='')
{
	//echo "<pre>";
	$result=[];
	$sql_select_ap = "SELECT `id`, `ap_name`, `ap_city_id`, `ap_price`, `ap_bullet_points`, `ap_images`, `slug` FROM " . DB_APPARTMENT . " WHERE ap_city_id=".$_REQUEST['city_id']." AND ap_type_id=".$_REQUEST['ap_type']." AND `status`='A' ORDER BY `id` DESC";
	$sql_query_ap = mysqli_query($link, $sql_select_ap);
	$all_ap = mysqli_fetch_all($sql_query_ap, MYSQLI_ASSOC);

	foreach($all_ap as $key=>$app){
		$app["ap_price"]=convertCurrency($app["ap_price"]);
		$city=get_city("id=".$app['ap_city_id'])[0];
		$country=get_country("id=".$city['country_id'])[0];
		$result[$key]=$app;
		$result[$key]["city"]=$city["main_title"];
		$result[$key]["country"]=$country["main_title"];
	}

	//print_r($result);

	echo json_encode($result);
}
?>