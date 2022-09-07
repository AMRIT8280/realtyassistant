<?php
$pageName = "booking";
include "00header.php";

$isApNotFount=0;
if(!isset($_REQUEST["ap_slug"]) || (isset($_REQUEST["ap_slug"]) && empty($_REQUEST["ap_slug"]))){
    echo "Not found Apartment";
    $isApNotFount++;
}
$ap_room_st = get_apartment_structure($_REQUEST["ap_slug"]);
if($ap_room_st["status"]!="success"){
    echo "Not found Apartment";
    $isApNotFount++;
   
}
if($isApNotFount==0){
?>
<section class="subpage_body">
    <div class="container">
        <div class="booking_search_area">
            <div class="booking_top_area border_none">
                <div class="row align-items-center">
                    <div class="col-md-4 left">
                        <p><?php echo $ap_room_st["ap_details"]["name"] . " | " . $ap_room_st["ap_details"]["city"] . ", " . $ap_room_st["ap_details"]["country"]; ?></p>
                    </div>
                    <div class="col-md-8 right">
                        <p> Only Available <i class="fa fa-check" aria-hidden="true"></i> <strong>Only Available <?php echo $ap_room_st["available_status"]["available"] + 0; ?> Available</strong> | <span><?php echo $ap_room_st["available_status"]["booked"] + 0; ?> Sold Out</span></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="booking_room_boxes">
            <div class="row">
                <div class="col-sm-9">
                    <div class="area_box">
                        <div class="row">
                            <div class="col-12">
                                <h2>Area</h2>
                                <ul>
                                    <!--  <li class="area_active">
                                        <figure>
                                        <img src="<?php echo BASE_URL; ?>images/building-icon.png" alt="">
                                        </figure>
                                        <p>
                                        Fuchsia
                                        </p>
                                    </li> -->
                                    <?php
                                    foreach ($ap_room_st["all_buildings"] as $bKey => $building) {
                                    ?>
                                        <li class="selectBuilding" id="buildingId-<?php echo $bKey; ?>">
                                            <figure>
                                                <img src="<?php echo BASE_URL; ?>images/building-icon.png" alt="">
                                            </figure>
                                            <p><?php echo $building["building"]; ?></p>
                                        </li>
                                        <input type="checkbox" id="checkboxSelectBuildingId-<?php echo $bKey; ?>" class="checkboxSelectBuilding" style="display: none;">
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-12 unit_type">
                                <h2>Unit Type</h2>
                                <?php
                                foreach ($ap_room_st["all_sizes"] as $unit_key => $unit) {
                                    echo '<p><input type="checkbox" class="selectUnitSize" id="unitSize-' . $unit_key . '"> ' . explode("_", $unit_key)[0] . ' (' . explode("_", $unit_key)[1] . ' Sq.Ft.)... <span>' . $unit . '</span></p>';
                                }
                                ?>
                            </div>
                        </div>

                    </div>

                    <!-- START -->
                    <div id="ajaxFilterDataDiv">
                    </div>

                </div>

                <div class="col-sm-3" id="ajax_room_details">
                </div>

            </div>
        </div>
    </div>
</section>
<?php
}
include "01footer.php";
?>


<script>
    $(document).ready(function() {
        $(document).on("click", ".roomIdForGetRoom", function() {
            const roomId = ($(this).attr("id")).split("-")[1];
            //console.log("Room Id:" + roomId);
            var urlString = `<?php echo BASE_URL; ?>ajax_get_room.php?room_id=${roomId}`;
            $(".page-loader").css("display", "block");
            $.ajax({
                url: urlString,
                success: function(result) {
                    const data = JSON.parse(result);
                    if (data["status"] == "success") {
                        $("#ajax_room_details").html(data["data"]);
                    } else {
                        $("#ajax_room_details").html('<h4>Data Not Found</h4>');
                    }
                    $(".page-loader").css("display", "none");
                }
            });
        });


        /* Filter JS */
        var allBuildingIds = [];
        var allRoomSizes = [];
        $(document).on("change", ".selectUnitSize", function() {
            var tempArrSize = [];
            $(".selectUnitSize:checked").each(function() {
                tempArrSize[tempArrSize.length] = ($(this).attr("id")).split("-")[1];
            });
            allRoomSizes = tempArrSize;
            //console.log("RoomSizes:",tempArrSize.toString());
            callAjaxFilterRequest(allBuildingIds, allRoomSizes);
        });

        $(document).on("click", ".selectBuilding", function() {
            $(".selectBuilding").removeClass("area_active");
            var checkboxSelectBuildingId = ($(this).attr("id")).split("-")[1];
            $(`#checkboxSelectBuildingId-${checkboxSelectBuildingId}`).click();
        });

        $(document).on("change", ".checkboxSelectBuilding", function() {
            var tempArrBuilding = [];
            $(".checkboxSelectBuilding:checked").each(function() {
                tempArrBuilding[tempArrBuilding.length] = ($(this).attr("id")).split("-")[1];
                $(`#buildingId-${($(this).attr("id")).split("-")[1]}`).addClass("area_active");
            });
            allBuildingIds = tempArrBuilding;
            //console.log("Buildings:",tempArrBuilding.toString());
            callAjaxFilterRequest(allBuildingIds, allRoomSizes);
        });

        function callAjaxFilterRequest(all_building_ids="", all_room_sizes="") {
            $(".page-loader").css("display", "block");
            var ap_slug = "<?php echo $_REQUEST["ap_slug"]; ?>";
            var urlString = `<?php echo BASE_URL; ?>ajax_get_room_structure.php`;

            $.ajax({
                type: "GET",
                url: urlString,
                data: {
                    apSlug: ap_slug,
                    buildingIds: all_building_ids.toString(),
                    roomSizes: all_room_sizes.toString()
                },
                success: function(result) {
                    $("#ajaxFilterDataDiv").html(result);
                    //console.log(result);
                    $(".page-loader").css("display", "none");
                }
            });

        }

        //To show all room structure list just call this function
        //callAjaxFilterRequest();

    });
</script>