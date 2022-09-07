<?php

include "connection.php";

echo "<br>------------------------<br><pre>";
$room_id=5;

/* $room_deatils=get_room("id=".$room_id);
if(!empty($room_deatils)){
    $app_deatils=get_appartment("id=".$room_deatils[0]["ap_id"]);
    if(!empty($app_deatils)){
        $final_data=json_decode($app_deatils[0]["building_floors"], true);
        $ressult=$final_data[$room_deatils[0]["building_id"]];
        $ressult["key"]=$room_deatils[0]["building_id"];
        print_r($ressult);
    }
} */

//print_r(get_building_name($room_id=6));
//print_r(get_all_featured_apartments());

//print_r(get_apartment('ttest-with-room'));
//print_r(get_apartment_room_structure("ttest-with-room"));

//print_r(get_apartment_structure($ap_slug="ttest-with-room"));
echo "<br>--------------<br>";
$ressult=(get_apartment_room_structure($ap_slug="ttest-with-room","1",""));

print_r($ressult);

?>