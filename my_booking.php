<?php
$pageName="buy";
include "00header.php";
if (empty($_SESSION['user_name_id'])) {
	header('location:signin');
}
?>
<section class="subpage_body">
    <div class="container">
       
        
        <div class="buy_body mb-4">
            <div class="row">
                <div class="col-lg-4">
                    <div class="buy_left_box">
                        <div class="top_heading">
                            <h2>Menu</h2>
                        </div>
                        <div class="top_sub_heading">
                            <a href="<?php echo BASE_URL?>profile"><h2><i class="fa fa-user" aria-hidden="true"></i> Profile</h2></a>
                        </div>
                        <div class="top_sub_heading">
                           <a href="<?php echo BASE_URL?>my_booking"> <h2><i class="fa fa-bookmark" aria-hidden="true"></i> My Booking</h2></a>
                        </div>
                        <div class="top_sub_heading">
                            <a onclick="return confirm('Are you sure to Logout?');" href="<?php echo BASE_URL;?>logout">
								<i class="fa fa-sign-out" aria-hidden="true"></i> Logout
							</a>   
                        </div>
                        
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="buy_right_area">
                        <div class="buy_checkout_heading">
                            <h2>My Booking List</h2>
                        </div>

                        <div class="booking_room_boxes">
            <div class="row" style="padding: 31px;">
            
            
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="booking_room_box1">
                        <div class="booking_room_box_heading">
                            Yuva, Floor-2
                        </div>

                        <div class="booking_room_box_inside_area">                           

                            <div class="booking_room_feature_box1">
                                <h3>Unit Number</h3>
                                <p>Unit - 05.14.01</p>
                            </div>

                            <div class="booking_room_feature_box1">
                                <h3>Floor Number</h3>
                                <p>2nd Floor</p>
                            </div>

                            <div class="booking_room_feature_box1">
                                <h3>Size</h3>
                                <p>2BHK (888 Sq.Ft.)</p>
                            </div>

                            <div class="booking_room_feature_box1">
                                <h3>Booking Amount</h3>
                                <p>80,000</p>
                            </div>

                            <a href="#" ><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Download</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="booking_room_box1">
                        <div class="booking_room_box_heading">
                            Yuva, Floor-2
                        </div>

                        <div class="booking_room_box_inside_area">                           

                            <div class="booking_room_feature_box1">
                                <h3>Unit Number</h3>
                                <p>Unit - 05.14.01</p>
                            </div>

                            <div class="booking_room_feature_box1">
                                <h3>Floor Number</h3>
                                <p>2nd Floor</p>
                            </div>

                            <div class="booking_room_feature_box1">
                                <h3>Size</h3>
                                <p>2BHK (888 Sq.Ft.)</p>
                            </div>

                            <div class="booking_room_feature_box1">
                                <h3>Booking Amount</h3>
                                <p>80,000</p>
                            </div>

                            <a href="#" ><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Download</a>
                        </div>
                    </div>
                </div>
            

                
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