<?php
include('connection.php');
if (isset($_REQUEST['mode'])) {

	if ($_REQUEST['mode'] == "Forgot") Forgot();



	elseif ($_REQUEST['mode'] == "logout")	logout();
}
ob_end_flush();



if (isset($_SESSION['user_name_id'])) {



	if (!empty($_SESSION['user_name_id'])) {



		header('location:profile');



		exit;
	}
}



?>

<!DOCTYPE html>

<html lang="en">

<head>

	<meta charset="utf-8">

	<title><?php echo get_siteconfig('website_name'); ?></title>

	<link type="image/ico" rel="icon" href="<?php echo BASE_URL . 'uploads/admin/' . get_siteconfig('favicon'); ?>">

	<meta content="width=device-width, initial-scale=1.0" name="viewport">

	<meta content="" name="keywords">

	<meta content="" name="description">



	<!-- Bootstrap CSS -->

	<link href="<?php echo BASE_URL; ?>lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">



	<!-- Libraries CSS Files -->

	<link href="<?php echo BASE_URL; ?>lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">

	<link href="<?php echo BASE_URL; ?>lib/animate/animate.min.css" rel="stylesheet">

	<link href="<?php echo BASE_URL; ?>lib/ionicons/css/ionicons.min.css" rel="stylesheet">



	<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/owl.carousel.min.css">

	<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/owl.theme.default.min.css">



	<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/best-responsive.min.css">

	<!-- Main Stylesheet File -->

	<link href="<?php echo BASE_URL; ?>css/style.css" rel="stylesheet">

	<link href="<?php echo BASE_URL; ?>css/media_screen.css" rel="stylesheet">

	<!-- JavaScript Libraries -->

	<script src="<?php echo BASE_URL; ?>lib/jquery/jquery.min.js"></script>

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


					<?php if (isset($_SESSION['MSG_REGIST'])) { ?>

						<p id="hide_allert" class="<?php echo $_SESSION['MSG_CLASS']; ?>">

							<i class="fa fa-bell" aria-hidden="true"></i> <?php echo $_SESSION['MSG_REGIST'];

																			unset($_SESSION['MSG_REGIST']);

																			unset($_SESSION['MSG_CLASS']);

																			?>

						</p>

					<?php } ?>


					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="logfrm" name="logfrm">

						<input type="hidden" name="mode" value="Forgot">

						<div class="row text-left">

							<div class="col-12">

								<h2>Forgot Password</h2>

							</div>

							<div class="col-12">

								<p>Email Address</p>

								<input type="email" id="contact_mail" name="contact_mail" placeholder="Enter email address" class="form_input" />

							</div>





							<div class="col-12">

								<input type="submit" value="Submit" class="form_submit2" />

							</div>



							<!-- <div class="col-12 text-center">

                            <h3>Or sign in with</h3>

                        </div>

    

                        <div class="col-12">

                            <a href="#" class="google_but"><i class="fa fa-google-plus" aria-hidden="true"></i> Sign up with google</a>

                        </div>-->



							<div class="col-12 text-center mt-4">

								<p>Get Password? <a href="<?php echo BASE_URL; ?>signin">Sign In</a></p>

							</div>

						</div>



					</form>

				</div>

			</div>

		</div>

	</section>



	<?php

	function Forgot()
	{

		global $link;



		$login_sql = "SELECT * FROM " . DB_REGISTER . " WHERE contact_mail ='" . $_POST['contact_mail'] . "'";



		$login_rs = mysqli_query($link, $login_sql) or die("User login error:" . mysqli_error($link));



		$login_row = mysqli_fetch_array($login_rs);



		//print_r($login_row);



		$num_fetch = mysqli_num_rows($login_rs);



		if ($num_fetch > 0) {

			$pass = rand(0000, 999999);

			/*---------- Send Email User ---------- */

			$to_name 			=	'User';

			$to_email 			=	$_REQUEST['contact_mail'];

			$from_name 			= 	get_siteconfig('website_name');

			$from_email 		= 	get_siteconfig('email');



			$subject		=	"Regeneration Of Password";

			$message = "<html>

							<body>

								<table style='width: 70%;background-color: #f5f5f5;padding:18px' align='center'>

									<tr>

										<th style='text-align: center; padding:10px 0px'> <img src='" . BASE_URL . "uploads/admin/" . get_siteconfig('logo') . "'/></th>

									</tr>

									

									<tr>

										<td>

											<p>

												<b>New Password- " . $pass . "</b>

											</p>

											

										</td>

									</tr>



									<tr>

										<td>

											Visit at <b>" . get_siteconfig('website_name') . ",</b> By 

										</td>

									</tr>

									<tr>

										<td style='text-align: center;'>

											<br/>

											<a href='" . BASE_URL . "' style='border: 0;background-color: #337ab7;border-radius: 50px;padding: 10px 20px;color:#fff;font-size: 14px;

											    outline: none;text-decoration: none;' >

											Click here 

											</a>

										

										</td>

									</tr>



									

									<tr>

										<td>

											 Thank You, <br/>

											 <b>Team " . get_siteconfig('website_name') . " </b>

										</td>

									</tr>

								

								</table>

							</body>

						</html>

					";


			send_mail_common($to_name, $to_email, $from_name, $from_email, $subject, $message, $bcc = '');



			$mail_status 		= 	send_mail_common($to_name, $to_email, $from_name, $from_email, $subject, $message, $useSendGrid = 'no', $type = '');



			$sql_inset_post = "UPDATE " . DB_REGISTER . " 

						SET 	

						 passw='" . md5($pass) . "'

						 

						 where contact_mail='" . $_REQUEST['contact_mail'] . "'";



			$qry_inset_post	= mysqli_query($link, $sql_inset_post) or die(mysqli_error($link));



			header('location:signin');

			exit;
		} else {

			$_SESSION['MSG_REGIST'] = "Invalid User Name!";

			$_SESSION['MSG_CLASS'] = "msg_warning";

			header('location:forgot_pass');



			exit;
		}
	}

	?>



	<!-- JavaScript Libraries -->

	<script src="<?php echo BASE_URL; ?>lib/bootstrap/js/bootstrap.bundle.min.js"></script>

	<script src="<?php echo BASE_URL; ?>lib/superfish/superfish.min.js"></script>

	<script src="<?php echo BASE_URL; ?>lib/wow/wow.min.js"></script>



	<script src="<?php echo BASE_URL; ?>js/owl.carousel.js"></script>



	<script src='<?php echo BASE_URL; ?>js/best-responsive.min.js'></script>

	<script src="<?php echo BASE_URL; ?>js/tab.js"></script>

	<!-- Template Main Javascript File -->

	<script src="<?php echo BASE_URL; ?>js/nav_menu.js"></script>

	<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

	<script src="<?= BASE_URL ?>webmanager/assets/js/jquery-validation/jquery.validate.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {

			setTimeout(function() {

				$('#hide_allert').hide('fast');

			}, 10000);

			$(':input').change(function() {

				$(this).val($(this).val().trim());

			});

			$('#logfrm').validate({

				rules: {

					contact_mail: {

						required: true,

						email: true

					}

				},

				messages: {

					contact_mail: {

						required: "Please provide registered email...!"

					}

				},

				errorElement: 'span',

				errorPlacement: function(error, element) {

					//error.addClass('has-warning');

					element.closest('.col-12').append(error);

				},

				highlight: function(element, errorClass, validClass) {

					$(element).addClass('has-warning');

					$(element).removeClass('has-success');

				},

				unhighlight: function(element, errorClass, validClass) {

					$(element).removeClass('has-warning');

					$(element).addClass('has-success');

				},

				submitHandler: function(form) {

					form.submit();

				}

			});

		});
	</script>

</body>

</html>