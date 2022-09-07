<?php
$pageName="Terms-and-Conditions";
include "00header.php";
?>
<section class="subpage_body">
    <div class="container">
       
        
        <div class="buy_body mb-4">
            <div class="row">
                
                <div class="col-lg-12">
                    <div class="buy_right_area">
                        <div class="buy_checkout_heading">
                            <h2>Terms and Conditions</h2>
                        </div>

                        <div class="booking_room_boxes">
                        <div class="row" style="padding: 31px;">
                        <p>
                         <?php echo getRecordFlied(DB_COMMON_CONTENT,"id='3'","descript");?>
                        </p>
                        </div>
                    </div>

                    </div>         
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include "01footer.php";
?>