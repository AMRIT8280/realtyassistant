<?php
include "connection.php";
if (isset($_REQUEST["apSlug"]) && !empty($_REQUEST["apSlug"])) {
    $apSlug = $_REQUEST["apSlug"];
    $buildingIds = "";
    $roomSizes = "";
    if (isset($_REQUEST["buildingIds"])) {
        $buildingIds = $_REQUEST["buildingIds"];
    }
    if (isset($_REQUEST["roomSizes"])) {
        $roomSizes = $_REQUEST["roomSizes"];
    }

    $ap_room_st = get_apartment_structure($apSlug);
?>
    <div class="available_box">
        <div class="available_box_top_heading">
            <!-- <h3><input type="checkbox"> Only Available </h3> -->
            <p><?php echo $ap_room_st["available_status"]["available"] + 0; ?> Available | <span><?php echo $ap_room_st["available_status"]["booked"] + 0; ?> Sold Out</span></p>
        </div>
        <div class="booking_slider">
           <!--  <div id="owl-four" class="owl-carousel owl-theme"> -->
                <?php
                $building_room_details = get_apartment_room_structure($apSlug, $buildingIds, $roomSizes);
                if ($building_room_details["status"] == "success") {
                    foreach ($building_room_details["data"] as $building_id => $all_room_details) {
                ?>
                        <div class="item">
                            <div class="booking_bulding">
                                <div class="booking_bulding_heading" style="background-color: #2d5a99; color:white;">
                                    <?php echo $ap_room_st["all_buildings"][$building_id]["building"]; ?>
                                </div>

                                <div class="booking_bulding_wingBox">
                                    <?php
                                    foreach ($all_room_details as $room_floor_num => $floor_rooms) {
                                    ?>
                                        <ul>
                                            <li class="florNo tooltipBottom">
                                                Floor-<?php echo $room_floor_num; ?>
                                            </li>
                                            <?php
                                            if ($floor_rooms["status"] == "success") {
                                                foreach ($floor_rooms["data"] as $one_room) {
                                                    $bookedItemClassTxt = "available";
                                                    if ($one_room["booking_status"] == "booked") {
                                                        $bookedItemClassTxt = "sold";
                                                    }
                                            ?>
                                                    <li class="<?php echo $bookedItemClassTxt; ?> tooltipBottom roomIdForGetRoom" id="roomIdForGetRoom-<?php echo $one_room["id"]; ?>">
                                                        <input id="unit-37200" type="hidden" value="{&quot;priceBreakup&quot;:[[{&quot;displayName&quot;:&quot;Total Cost&quot;,&quot;fieldName&quot;:&quot; 6,981,704 &quot;,&quot;id&quot;:44323,&quot;name&quot;:&quot;10:80:10&quot;,&quot;planId&quot;:250},{&quot;displayName&quot;:&quot;Booking Amount&quot;,&quot;fieldName&quot;:&quot;100,000&quot;,&quot;id&quot;:44323,&quot;name&quot;:&quot;10:80:10&quot;,&quot;planId&quot;:250},{&quot;displayName&quot;:&quot;Blocking Amount&quot;,&quot;fieldName&quot;:&quot;100,000&quot;,&quot;id&quot;:44323,&quot;name&quot;:&quot;10:80:10&quot;,&quot;planId&quot;:250}]],&quot;unitId&quot;:37200,&quot;pid&quot;:119,&quot;unitNumber&quot;:&quot;Gardenia - B1405&quot;,&quot;floor&quot;:&quot;Floor-14&quot;,&quot;bhkSize&quot;:&quot;983.3&quot;,&quot;onlineBookingEnabled&quot;:true,&quot;reserveEnabled&quot;:false,&quot;floorPlan2d&quot;:null}">
                                                        <div class="tooltipBox">
                                                            <div class="floorType">
                                                                <p><small>Unit No: <?php echo $one_room["room_number"]; ?></small></p>
                                                                <p><small> Size : <?php echo $one_room["size_bhk"] . " (" . $one_room["size_sqft"] . " sq.ft.)"; ?></small></p>
                                                            </div>
                                                        </div>
                                                    </li>
                                            <?php
                                                }
                                            } else {
                                                echo '<li class="notAvailable  tooltipBottom tooltipLeft"></li>';
                                            }
                                            ?>
                                        </ul>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
            <!-- </div> -->
        </div>
    </div>
    <?php
} else {
    echo "Invalid Slug";
}
?>