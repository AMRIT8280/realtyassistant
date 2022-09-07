<?php
include('connection.php');
ob_start();



if(isset($_POST['mode'])){

	if($_POST['mode']=='insert') 			insert();

}

else



ob_end_flush()

?>

<!DOCTYPE html>

<html lang="en">

<head>

  <meta charset="utf-8">

  <title><?php echo get_siteconfig('website_name');?></title>

  <link type="image/ico" rel="icon" href="<?php echo BASE_URL.'uploads/admin/'.get_siteconfig('favicon'); ?>">

  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <meta content="" name="keywords">

  <meta content="" name="description">



  <!-- Bootstrap CSS -->

  <link href="<?php echo BASE_URL;?>lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">



  <!-- Libraries CSS Files -->

  <link href="<?php echo BASE_URL;?>lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">

  <link href="<?php echo BASE_URL;?>lib/animate/animate.min.css" rel="stylesheet">

  <link href="<?php echo BASE_URL;?>lib/ionicons/css/ionicons.min.css" rel="stylesheet">



  <link rel="stylesheet" href="<?php echo BASE_URL;?>css/owl.carousel.min.css">

  <link rel="stylesheet" href="<?php echo BASE_URL;?>css/owl.theme.default.min.css">



  <link rel="stylesheet" href="<?php echo BASE_URL;?>css/best-responsive.min.css">

  <!-- Main Stylesheet File -->

  <link href="<?php echo BASE_URL;?>css/style.css" rel="stylesheet">

  <link href="<?php echo BASE_URL;?>css/media_screen.css" rel="stylesheet">

  <!-- JavaScript Libraries -->

  <script src="<?php echo BASE_URL;?>lib/jquery/jquery.min.js"></script>

  <style>

  .msg_warning{

	  color: #ae7676;

	}

  .msg_success{

	  color: #0c240a8f;

	}

  .error{

	  color: #f00;

	}

  </style>

</head>



<body>



<section class="login_register_pannel">
	<a href="<?php echo BASE_URL;?>" class="home_back"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back To Home</a>

    <div class="left">

        <img src="images/bulding.jpg" alt="" />

    </div>



    <div class="right">

        <div class="row">

            <div class="col-lg-8 mx-auto">

					<?php if(isset($_SESSION['MSG_REGIST'])){?>

                    <p id="hide_allert" class="<?php echo $_SESSION['MSG_CLASS'];?>">

                        <i class="fa fa-bell" aria-hidden="true"></i> <?php echo $_SESSION['MSG_REGIST'];

                              unset($_SESSION['MSG_REGIST']);

                              unset($_SESSION['MSG_CLASS']);

                        ?>

                    </p>

                    <?php }?>

                    <form id="reg_frm" name="reg_frm" action="" method="post">

                    <input type="hidden" name="mode" value="insert" />

                    <div class="row text-left">

                        <div class="col-12">

                            <h2>Sign Up</h2>

                        </div>

                        <div class="col-12">

                            <p>Name*</p>

                            <input type="text" id="main_title" name="main_title"  placeholder="Enter Name" class="form_input" />

                        </div>

                        <div class="col-12">

                            <p>Email Address*</p>

                            <input type="email" id="contact_mail" name="contact_mail"placeholder="Enter email address" class="form_input" value="<?php if(isset($_REQUEST['email'])) echo $_REQUEST['email']; ?>" />

                        </div>

                        <div class="col-12">

                            <p>Mobile number*</p>

                            <input type="text" id="mobile_no" name="mobile_no" placeholder="Enter mobile number" class="form_input" />

                        </div>

                        <div class="col-12">

                            <p>Address*</p>

                       		 <textarea id="address" name="address" class="form_input"></textarea>

                        </div>

                        <div class="col-12">

                            <p>Create password*</p>

                            <input type="password" id="passw" name="passw" placeholder="Create password" class="form_input" />

                        </div>

                        <div class="col-12">

                            <p>Confirm Password*</p>

                            <input type="password" id="conPassw" name="conPassw" placeholder="Confirm Password" class="form_input" />

                        </div>

    

                        <div class="col-12">

                            <input type="submit" value="Sign Up" class="form_submit2" />

                        </div>

    

                        <div class="col-12 text-center mt-4">

                            <p>Already signed up?  <a href="<?php echo BASE_URL;?>signin">Sign In</a></p>

                        </div>

                    </div>

					</form>

            </div>

        </div>

    </div>

</section>





<!-- JavaScript Libraries -->

<script src="<?php echo BASE_URL;?>lib/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="<?php echo BASE_URL;?>lib/superfish/superfish.min.js"></script>

<script src="<?php echo BASE_URL;?>lib/wow/wow.min.js"></script>



<script src="<?php echo BASE_URL;?>js/owl.carousel.js"></script>



<script src='<?php echo BASE_URL;?>js/best-responsive.min.js'></script>

<script  src="<?php echo BASE_URL;?>js/tab.js"></script>

<!-- Template Main Javascript File -->

<script src="<?php echo BASE_URL;?>js/nav_menu.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.js" integrity=  "sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

<script src="<?=BASE_URL?>webmanager/assets/js/jquery-validation/jquery.validate.min.js"></script> 

 



<script>

$.validator.addMethod("email", function(value) {

  return /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/.test(value);

});

$('input[type="text"]').change(function() {

	$(this).val($(this).val().trim());

});

$(document).ready(function () {

	$('#reg_frm').validate({

		rules: {

		  main_title: 'required',

		  contact_mail:{

			  required: true,

			  email:true

		  },

		  mobile_no: 'required number',

		  address: 'required',

		  passw: {

            required: true,

            minlength: 3

		  },

		  conPassw: {

			  required: true,

			  minlength: 3,

			  equalTo: "#passw"

		  }

		},

		messages: {

			main_title: "Please enter name",

			contact_mail: {

				required: "Please enter a email address",

				email: "Please enter a vaild email address"

			},

			mobile_no: {

				required: "Please enter mobile number",

				number: "Please enter a vaild number"

			},

			address: "Please enter Address",

			passw: {

			  required: "Please provide a password",

			  minlength: "Your password must be at least 3 characters long"

			},

			conPassw: {

			  required: "Please provide a confirm password",

			  minlength: "Your password must be at least 3 characters long",

			  equalTo: "Please enter the same password as above"

	

			}

		},

		errorElement: 'span',

		errorPlacement: function (error, element) {

		  //error.addClass('has-warning');

		  element.closest('.col-12').append(error);

		},

		highlight: function (element, errorClass, validClass) {

		  $(element).addClass('has-warning');

		  $(element).removeClass('has-success');

		},

		unhighlight: function (element, errorClass, validClass) {

		  $(element).removeClass('has-warning');

		  $(element).addClass('has-success');

		}

	  });

});

</script>

<?php 

function insert(){

	global $link;

	if(isset($_REQUEST['mode']) && $_REQUEST['mode']=='insert'){

		$sql_chk_email="select * from ".DB_REGISTER." where contact_mail='".$_REQUEST['contact_mail']."'";

		$qry_chk_email=mysqli_query($link,$sql_chk_email) or die(mysqli_error($link));

		$num_chk_email=mysqli_num_rows($qry_chk_email);

		if($num_chk_email <=0)

		{

			$sql_inset_post="INSERT INTO ".DB_REGISTER." 

					SET 	

					 main_title='".ucwords($_REQUEST['main_title'])."',

					 contact_mail='".($_REQUEST['contact_mail'])."',

					 mobile_no='".($_REQUEST['mobile_no'])."',

					 address='".ucwords($_REQUEST['address'])."',

					 passw='".(md5($_REQUEST['passw']))."'";	

			$qry_inset_post	=mysqli_query($link,$sql_inset_post) or die(mysqli_error($link)); 

			$_SESSION['MSG_REGIST'] = "User registration successfull.";

			$_SESSION['MSG_CLASS'] = "msg_success";

			

			/*---------- Send Email User ---------- */

		$to_name 			=	'User';

		$to_email 			=	$_REQUEST['contact_mail'];

		$from_name 			= 	get_siteconfig('website_name');

		$from_email 		= 	get_siteconfig('email');

		

		$subject		=	"Thank You For register Yourself With Us.";		

		$message = "<html>

							<body>

								<table style='width: 70%;background-color: #f5f5f5;padding:18px' align='center'>

									<tr>

										<th style='text-align: center; padding:10px 0px'> <img src='".BASE_URL."uploads/admin/".get_siteconfig('logo')."'/></th>

									</tr>

									

									<tr>

										<td>

											<p>Your login credentials are<br>

												</b>User Name: </b>".$_REQUEST['contact_mail']."<br>

												<b>Password: </b>".$_REQUEST['passw']."

											</p>

											

										</td>

									</tr>



									<tr>

										<td>

											Visit at <b>".get_siteconfig('website_name').",</b> By 

										</td>

									</tr>

									<tr>

										<td style='text-align: center;'>

											<br/>

											<a href='".BASE_URL."' style='border: 0;background-color: #337ab7;border-radius: 50px;padding: 10px 20px;color:#fff;font-size: 14px;

											    outline: none;text-decoration: none;' >

											Click here 

											</a>

										

										</td>

									</tr>



									

									<tr>

										<td>

											 Thank You, <br/>

											 <b>Team ".get_siteconfig('website_name')." </b>

										</td>

									</tr>

								

								</table>

							</body>

						</html>

					";

					

			//send_mail_common($to_name, $to_email, $from_name, $from_email, $subject, $message, $bcc='');		

			

			$mail_status 		= 	send_mail_common($to_name,$to_email,$from_name,$from_email,$subject,$message,$useSendGrid='no',$type='');

			

			header('location:signin');

			exit();

		}else{

			$_SESSION['MSG_REGIST'] = "User already exists.";

			$_SESSION['MSG_CLASS'] = "msg_warning";

			header('location:signup');

			exit();

		}

		

	}

}

?>

</body>

</html>



