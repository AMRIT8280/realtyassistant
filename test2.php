<?php
include "connection.php";
?>

<script src="<?php echo BASE_URL; ?>lib/jquery/jquery.min.js"></script>

<p id="p-1" class="pall">Click Here P1</p>
<p id="p-2" class="pall">Click Here P2</p>
<p id="p-3" class="pall">Click Here P3</p>

<input type="checkbox" id="c-1" class="pcheckbox" style="display: none;">
<input type="checkbox" id="c-2" class="pcheckbox" style="display: none;">
<input type="checkbox" id="c-3" class="pcheckbox" style="display: none;">
<p>jbyjtxdxgchvjbknm</p>

<script>
  $(document).ready(function() {
    $(".pall").click(function() {
      var pid = ($(this).attr("id")).split("-")[1];
      console.log("pid=", pid);
      $(`#c-${pid}`).click();


    });

    $(document).on("change", ".pcheckbox", function() {
      var arrSelectBuilding = [];
      $(".pcheckbox:checked").each(function() {
        arrSelectBuilding[arrSelectBuilding.length] = ($(this).attr("id")).split("-")[1];
      });
      console.log(arrSelectBuilding.toString());
    });

  });
</script>


function submitFilterForm(all_building_ids, all_room_sizes){
            console.log("Buildings:",all_building_ids.toString());
            console.log("RoomSizes:",all_room_sizes.toString());
            
        }