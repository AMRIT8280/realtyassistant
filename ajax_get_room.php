<?php

include("connection.php");

$result=[];

if(isset($_REQUEST['room_id']) && !empty($_REQUEST['room_id']))
{
    $sql="SELECT ".DB_AP_ROOM.".*, ".DB_APPARTMENT.".`slug` AS 'ap_slug', ".DB_APPARTMENT.".`ap_plans` AS 'plans', ".DB_APPARTMENT.".`building_floors` AS 'building_floors'  FROM ".DB_AP_ROOM.",".DB_APPARTMENT." WHERE ".DB_AP_ROOM.".`ap_id`=".DB_APPARTMENT.".`id` AND ".DB_AP_ROOM.".`id`='".$_REQUEST["room_id"]."' AND ".DB_AP_ROOM.".`status`='A'";

   
    $qry = mysqli_query($link, $sql);
	$numOfRecords = mysqli_num_rows($qry);
	if ($numOfRecords > 0) {
		$data = mysqli_fetch_all($qry, MYSQLI_ASSOC)[0];
        $data["building_name"]=json_decode($data["building_floors"],true)[$data["building_id"]]["building"];

        $plan="";
        foreach(json_decode($data["plans"], true) as $plan_name){
            $plan.="<option>".$plan_name."</option>";
        }

        $html='
        <div class="booking_room_box1">
            <form action="'.BASE_URL.'buy/'.$data["ap_slug"].'" method="POST">
                <div class="booking_room_box_heading">
                    '.$data["building_name"].', Floor-'.$data["floor_number"].'
                </div>

                <div class="booking_room_box_inside_area">
                    <div class="booking_room_box_plan">
                        <h3>Plan Name</h3>
                        <select class="select_style2" name="plan">
                            '.$plan.'
                        </select>
                    </div>

                    <div class="booking_room_feature_box1">
                        <h3>Unit Number</h3>
                        <p>Unit - '.$data["room_number"].'</p>
                    </div>

                    <div class="booking_room_feature_box1">
                        <h3>Floor Number</h3>
                        <p>Floor-'.$data["floor_number"].'</p>
                    </div>

                    <div class="booking_room_feature_box1">
                        <h3>Size</h3>
                        <p>'.$data["size_bhk"].' ('.$data["size_sqft"].' Sq.Ft.)</p>
                    </div>

                    <div class="booking_room_feature_box1">
                        <h3>Consideration Value</h3>
                        <p>'.number_format($data["consideration_value"],2).'</p>
                    </div>

                    <div class="booking_room_feature_box1">
                        <h3>Other Charges 1</h3>
                        <p>'.number_format($data["other_charges"],2).'</p>
                    </div>

                    <div class="booking_room_feature_box1">
                        <h3>GST</h3>
                        <p>'.number_format($data["gst"],2).'</p>
                    </div>

                    <div class="booking_room_feature_box1">
                        <h3>Total Unit Cost</h3>
                        <p>'.number_format($data["price"],2).'</p>
                    </div>

                    <div class="booking_room_feature_box1">
                        <h3>Blocking Amount</h3>
                        <p>'.number_format($data["blocking_amount"],2).'</p>
                    </div>

                    <div class="booking_room_feature_box1">
                        <h3>Booking Amount</h3>
                        <p>'.number_format($data["booking_amount"],2).'</p>
                    </div>
                    <input type="hidden" name="room_id" value="'.$data["id"].'">
                    <input type="hidden" name="agent" value="TestAgent">
                    <button type="submit" class="book_but">Book Now <i class="fa fa-angle-right" aria-hidden="true"></i></button>
                </div>
            </form>
        </div>
        ';

        if($data["booking_status"]=="booked"){
            $html="";
        }

        $result["status"]="success";
        $result["data"]=$html;
	}else{
		$result["status"]="warning";
		$result["message"]="not found";
	}
    

}else{
    $result["status"]="error";
    $result["message"]="Something Wrong.";
}

echo json_encode($result);
//echo "<pre>";
//print_r($result);

?>