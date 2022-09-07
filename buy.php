<?php
$pageName = "buy";
include "00header.php";
//print_r($_REQUEST);
//echo $_REQUEST["ap_slug"];

$apartment_details = get_apartment($_REQUEST['ap_slug']);
if($apartment_details["status"]=="success"){
    //print_r($apartment_details["data"]);
    $app_details=$apartment_details["data"];
}else{
    header('location:'.BASE_URL.'home');
    exit();
}


$all_rooms = get_room("id='" . $_REQUEST["room_id"]."'");


if(empty($all_rooms)){
    header('location:'.BASE_URL.'booking/'.$_REQUEST["ap_slug"]);
    exit();
}

$user_details = [];
if (isset($_SESSION['user_name_id']) and !empty($_SESSION['user_name_id'])) {
    $user_details = get_user("id=" . $_SESSION['user_name_id']);
    if (!empty($user_details)) {
        $user_details = $user_details[0];
    }
}

//print_r($user_details);
//print_r($_REQUEST);
//echo base64_decode($_REQUEST["plan"]);
//echo base64_decode($_REQUEST["room_id"]);

?>
<style>
    .msg_warning {

      color: #ae7676;

    }

    .msg_success {

      color: #0c240a8f;

    }

    .error {

      color: #f00;

    }
  </style>
<section class="subpage_body">
    <div class="container">
        <div class="booking_search_area">
            <div class="booking_top_area">
                <div class="row align-items-center">
                    <div class="col-md-6 left">
                        <p><?php echo ucfirst($all_rooms[0]["room_name"])." | ".$app_details["ap_name"]." | ".$app_details["city"]; ?></p>
                    </div>
                </div>
            </div>

            <div class="buy_bottom_area">
                <div class="row align-items-center">
                    <div class="col-md-8 left">
                        <p><strong>Building:</strong> 
                        <?php 
                            echo json_decode($app_details["building_floors"], true)[$all_rooms[0]["building_id"]]["building"];
                        ?></p>
                        <p><strong>Floor:</strong> <?php echo $all_rooms[0]["floor_number"];?></p>
                        <p><strong>Unit:</strong> <?php echo strtoupper($all_rooms[0]["room_number"]);?></p>
                        <p><strong>Size:</strong> <?php echo $all_rooms[0]["size_bhk"]." (".$all_rooms[0]["size_sqft"]."sq.ft.)";?></p>
                    </div>

                    <div class="col-md-4 right">
                        <h2>Total Price: <?php echo number_format($all_rooms[0]["price"],2);?></h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="buy_body mb-4">
            <div class="row">
                <div class="col-lg-4">
                    <div class="buy_left_box">
                        <div class="top_heading">
                            <h2><?php echo $_REQUEST["plan"]; ?></h2>
                        </div>
                        <div class="top_sub_heading">
                            <h2>Price Breakup</h2>
                        </div>
                        <div class="box1">
                            <p>Consideration Value</p>
                            <h2><?php echo number_format($all_rooms[0]["consideration_value"],2);?> <br /> <strong><?php echo AmountInWords($all_rooms[0]["consideration_value"]); ?></strong></h2>
                        </div>
                        <div class="box1">
                            <p>Other Charges</p>
                            <h2><?php echo number_format($all_rooms[0]["other_charges"],2);?> <br /> <strong><?php echo AmountInWords($all_rooms[0]["other_charges"]); ?></strong></h2>
                        </div>
                        <div class="box1">
                            <p>GST</p>
                            <h2><?php echo number_format($all_rooms[0]["gst"],2);?> <br /> <strong><?php echo AmountInWords($all_rooms[0]["gst"]); ?></strong></h2>
                        </div>
                        <div class="box1">
                            <p>Total Price</p>
                            <h2><?php echo number_format($all_rooms[0]["price"],2);?> <br /> <strong><?php echo AmountInWords($all_rooms[0]["price"]); ?></strong></h2>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="buy_right_area">
                    <form  id="formCheckout" action='<?php echo BASE_URL."ccavenue/ccavRequestHandler.php"; ?>' method="POST">
                        <div class="buy_checkout_heading">
                            <h2>Checkout</h2>
                        </div>

                        <div class="buy_billing_area">
                            <div class="row">
                                <div class="col-12 heading">
                                    <h2>Billing Details</h2>
                                </div>
                                <input type="hidden" name="room_id" value="<?php echo $all_rooms[0]["id"];?>">
                                <input type="hidden" name="room_plan" value="<?php echo $_REQUEST["plan"];?>">

                                <div class="col-md-12">
                                    <input type="text" name="billing_name" value="<?php if (!empty($user_details)) {
                                                                    echo $user_details["main_title"];
                                                                } ?>" class="input_style3" placeholder="Full name*" />
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="billing_tel" value="<?php if (!empty($user_details)) {
                                                                    echo $user_details["mobile_no"];
                                                                } ?>" class="input_style3" placeholder="Phone Number*" />
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="billing_email" value="<?php if (!empty($user_details)) {
                                                                    echo $user_details["contact_mail"];
                                                                } ?>" class="input_style3" placeholder="Email*" />
                                </div>

                                <div class="col-12">
                                    <textarea name="billing_address" class="textarea_style3" placeholder="Address*"><?php if (!empty($user_details)) {
                                                                                                    echo $user_details["address"];
                                                                                                } ?></textarea>
                                </div>

                                <div class="col-md-6">
                                    <input type="text" name="billing_city" value="<?php if (!empty($user_details)) {
                                                                    echo $user_details["city"];
                                                                } ?>" class="input_style3" placeholder="City*" />
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="billing_state" value="<?php if (!empty($user_details)) {
                                                                    echo $user_details["state"];
                                                                } ?>" class="input_style3" placeholder="State*" />
                                </div>

                                <div class="col-md-6">
                                    <input type="text" name="billing_zip" value="<?php if (!empty($user_details)) {
                                                                    echo $user_details["pin"];
                                                                } ?>" class="input_style3" placeholder="Pin Code*" />
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="billing_pan" value="<?php if (!empty($user_details)) {
                                                                    echo $user_details["pan"];
                                                                } ?>" class="input_style3" placeholder="Pan Number*" />
                                </div>

                                <div class="col-md-6">
                                    <input type="text" name="agent_code" value="<?php if(isset($_SESSION['agent_code'])){ echo $_SESSION['agent_code']; } ?>" class="input_style3" placeholder="Agent Code" />
                                </div>
                                <div class="col-md-6">
                                   <select class="input_style3" name="booking_blocking" id="booking_blocking_amount">
                                       <option>Choose anyone</option>
                                       <option value="blocking">Blocking ( Amount - <?php echo number_format($all_rooms[0]["blocking_amount"],2);?> )</option>
                                       <option value="booking" selected>Booking ( Amount - <?php echo number_format($all_rooms[0]["booking_amount"],2);?> )</option>
                                   </select>
                                </div>
                                <div class="col-md-12 checkbox">
                                    <p><input type="checkbox" id="terms" checked="checked" > I have read and agree to the <a target="_blank" href="<?= BASE_URL?>Terms-and-Conditions">Terms & Conditions</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="buy_payment_area">
                            <div class="heading">
                                <h2>Payment Method</h2>
                            </div>
                               <!--  <div class="pymt-radio">
                                    <div class="row-payment-method payment-row-last">
                                        <div class="select-icon">
                                            <input type="radio" id="radio1" name="payment_type" value="cash">
                                            <label for="radio1"></label>
                                        </div>
                                        <div class="select-txt">
                                            <p class="pymt-type-name">By Cash</p>
                                            <p class="pymt-type-desc">Safe payment online. Credit card needed. PayPal account is not necessary.</p>
                                        </div>
                                        <div class="select-logo">
                                            <img src="https://www.dropbox.com/s/pycofx0gngss4ef/logo-paypal.png?raw=1" alt="By Cash" />
                                        </div>
                                    </div>
                                </div> -->
                                <div class="pymt-radio">
                                    <div class="row-payment-method payment-row">
                                        <div class="select-icon hr">
                                            <input type="radio" id="radio2" name="payment_type" value="online" checked>
                                            <label for="radio2"></label>
                                        </div>
                                        <div class="select-txt hr">
                                            <p class="pymt-type-name">Pay Online Mode</p>
                                            <p class="pymt-type-desc">Safe money transfer using your bank account. Safe payment online. Credit card needed. Visa, Maestro, Discover, American Express</p>
                                        </div>
                                        <div class="select-logo">
                                            <div class="select-logo-sub logo-spacer">
                                                <img src="https://www.dropbox.com/s/by52qpmkmcro92l/logo-visa.png?raw=1" alt="Visa" />
                                            </div>
                                            <div class="select-logo-sub">
                                                <img src="https://www.dropbox.com/s/6f5dorw54xomw7p/logo-mastercard.png?raw=1" alt="MasterCard" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-cc">
                                    <div class="row-cc">
                                        <div class="cc-field">
                                            <button type="submit" name="pay_now_btn" value="pay_now_btn" class="submit_style3" id="pay__now_btn">Pay Now<!-- Payble Amount 4,700,000 --></button>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include "01footer.php";
?>

  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

  <script src="<?= BASE_URL ?>webmanager/assets/js/jquery-validation/jquery.validate.min.js"></script>
<script>
    $(document).ready(function(){
        $('#formCheckout').validate({
            rules: {
                billing_name: 'required',
                billing_email: {
                    required:true,
                    email:true
                },
                billing_tel: {
                    required:true,
                    number:true,
                    minlength:10,
                    maxlength:10
                },
                billing_address:'required',
                billing_city: 'required',
                billing_state: 'required',
                billing_zip:{
                    required:true,
                    number:true,
                    minlength:6,
                    maxlength:6
                },
                billing_pan: {
                    required:true,
                    minlength:10,
                    maxlength:10
                },
                booking_blocking:'required',
		  		terms: {
                    required:true
                }
            },
            messages: {
                billing_name: "Please enter name...!",
                billing_email: {
                    required:"Please enter email...!",
                    email:"Please enter a valid email...!"
                },
                billing_tel: {
                    required:"Please enter phone...!",
                    number:"Only numbers allowed...!",
                    minlength:"Phone number should be 10 digit...!",
                    maxlength:"Phone number should be 10 digit...!"
                },
                billing_address: "Please enter address...!",
                billing_city: "Please enter city...!",
                billing_state: "Please enter state...!",
                billing_zip: {
                    required:"Please enter postal code...!",
                    number:"Only numbers allowed...!",
                    minlength:"Postal code should be 6 digit only...!",
                    maxlength:"Postal code should be 6 digit only...!"
                },
                billing_pan: {
                    required:"Please enter PAN number...!",
                    minlength:"PAN number should be 10 digit only...!",
                    maxlength:"PAN number should be 10 digit only...!"
                },
                booking_blocking:"Please select booking or blocking...!",
				terms: {
                    required:"Please Agree Terms & Conditions"
                }
            }
        });
    });
</script>