<?php
$pageName = "buy";
include "00header.php";
if (empty($_SESSION['user_name_id'])) {
	header('location:signin');
}
global $link;
if (isset($_POST['mode'])) {
	if ($_POST['mode'] == 'update') 			update();
}
$sql_list_about = "SELECT * FROM " . DB_REGISTER . "  WHERE id=" . $_SESSION['user_name_id'] . " ORDER BY id DESC";

$qry_list_about = mysqli_query($link, $sql_list_about);
$row_list_about = mysqli_fetch_array($qry_list_about)
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
							<a href="<?php echo BASE_URL ?>profile">
								<h2><i class="fa fa-user" aria-hidden="true"></i> Profile</h2>
							</a>
						</div>
						<div class="top_sub_heading">
							<a href="<?php echo BASE_URL ?>my_booking">
								<h2><i class="fa fa-bookmark" aria-hidden="true"></i> My Booking</h2>
							</a>
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
							<h2>Profile</h2>
						</div>

						<div class="buy_billing_area">
							<form id="pro_frm" name="pro_frm" action="<?php echo ($_SERVER["PHP_SELF"]); ?>" method="post">
								<input type="hidden" name="mode" value="update" />
								<div class="row">
									<?php if (isset($_SESSION['MSG_REGIST'])) { ?>
										<p id="hide_allert" class="<?php echo $_SESSION['MSG_CLASS']; ?>">
											<i class="fa fa-bell" aria-hidden="true"></i> <?php echo $_SESSION['MSG_REGIST'];
																							unset($_SESSION['MSG_REGIST']);
																							unset($_SESSION['MSG_CLASS']);
																							?>
										</p>
									<?php } ?>
									<div class="col-md-12">
										<input type="text" id="main_title" name="main_title" placeholder="Enter Name" class="input_style3" value="<?php if (!empty($row_list_about['main_title'])) {
																																						echo $row_list_about['main_title'];
																																					} ?>" />
									</div>
									<div class="col-md-6">
										<input type="email" id="contact_mail" name="contact_mail" placeholder="Enter email address" class="input_style3" value="<?php if (!empty($row_list_about['contact_mail'])) {
																																									echo $row_list_about['contact_mail'];
																																								} ?>" />
										<input type="hidden" name="old_email" value="<?php if (!empty($row_list_about['contact_mail'])) {
																							echo $row_list_about['contact_mail'];
																						} ?>" />
									</div>
									<div class="col-md-6">
										<input type="text" id="mobile_no" name="mobile_no" placeholder="Enter mobile number" class="input_style3" value="<?php if (!empty($row_list_about['mobile_no'])) {
																																								echo $row_list_about['mobile_no'];
																																							} ?>" />
									</div>

									<div class="col-12">
										<textarea placeholder="Address*" class="textarea_style3"><?php if (!empty($row_list_about['address'])) {
																										echo $row_list_about['address'];
																									} ?></textarea>
									</div>

									<div class="col-md-6">
										<input type="text" id="city" name="city" class="input_style3" placeholder="City" value="<?php if (!empty($row_list_about['city'])) {
																																	echo $row_list_about['city'];
																																} ?>" />
									</div>
									<div class="col-md-6">
										<input type="text" id="state" name="state" class="input_style3" placeholder="State" value="<?php if (!empty($row_list_about['state'])) {
																																		echo $row_list_about['state'];
																																	} ?>" />
									</div>

									<div class="col-md-6">
										<input type="text" id="pin" name="pin" class="input_style3" placeholder="Pin Code" value="<?php if (!empty($row_list_about['pin'])) {
																																		echo $row_list_about['pin'];
																																	} ?>" />
									</div>
									<div class="col-md-6">
										<input type="text" id="pan" name="pan" class="input_style3" placeholder="Pan Number" value="<?php if (!empty($row_list_about['pan'])) {
																																		echo $row_list_about['pan'];
																																	} ?>" />
									</div>

									<div class="col-md-6">
										<input type="password" id="passw" name="passw" class="input_style3" placeholder="Password" />
									</div>
									<div class="col-md-6">
										<input type="password" id="conPassw" name="conPassw" class="input_style3" placeholder="Confirm Password" />
									</div>

									<div class="col-md-3">
										<input type="submit" value="Update" class="submit_style3" />
									</div>
								</div>
							</form>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
include "01footer.php";

function update()
{
	global $link;
	if (isset($_REQUEST['mode']) && $_REQUEST['mode'] == 'update') {
		$sqls = "";
		if (!empty($_REQUEST['passw'])) {
			$sqls = "passw='" . (md5($_REQUEST['passw'])) . "',";
		}
		if ($_REQUEST['old_email'] == $_REQUEST['contact_mail']) {
			$sql_inset_post = "UPDATE " . DB_REGISTER . " 
					SET 	
					 main_title='" . ucwords($_REQUEST['main_title']) . "',
					 mobile_no='" . ($_REQUEST['mobile_no']) . "',
					 city='" . ucwords($_REQUEST['city']) . "',
					 state='" . ucwords($_REQUEST['state']) . "',
					 pin='" . ($_REQUEST['pin']) . "',
					 " . $sqls . "
					 pan='" . ($_REQUEST['pan']) . "'
					 
                     where id=" .  $_SESSION['user_name_id'] . "";

			$qry_inset_post	= mysqli_query($link, $sql_inset_post) or die(mysqli_error($link));
			$_SESSION['MSG_REGIST'] = "User update successfull.";
			$_SESSION['MSG_CLASS'] = "msg_success";
			header('location:signin');
			exit();
		} else {
			$sql_chk_email = "select * from " . DB_REGISTER . " where contact_mail='" . $_REQUEST['contact_mail'] . "'";
			$qry_chk_email = mysqli_query($link, $sql_chk_email) or die(mysqli_error($link));
			$num_chk_email = mysqli_num_rows($qry_chk_email);
			if ($num_chk_email <= 0) {
				$sql_inset_post = "UPDATE " . DB_REGISTER . " 
						SET 	
						 main_title='" . ucwords($_REQUEST['main_title']) . "',
						 contact_mail='" . ($_REQUEST['contact_mail']) . "',
						 mobile_no='" . ($_REQUEST['mobile_no']) . "',
						 city='" . ucwords($_REQUEST['city']) . "',
						state='" . ucwords($_REQUEST['state']) . "',
						pin='" . ($_REQUEST['pin']) . "',
						pan='" . ($_REQUEST['pan']) . "',
						 " . $sqls . "
						 address='" . ucwords($_REQUEST['address']) . "'
					 
                         where id='" . $_SESSION['user_name_id'] . "'";

				$qry_inset_post	= mysqli_query($link, $sql_inset_post) or die(mysqli_error($link));
				$_SESSION['MSG_REGIST'] = "User update successfull.";
				$_SESSION['MSG_CLASS'] = "msg_success";
				header('location:signin');
				exit();
			} else {
				$_SESSION['MSG_REGIST'] = "User already exists.";
				$_SESSION['MSG_CLASS'] = "msg_warning";
				header('location:signup');
				exit();
			}
		}
	}
}
?>

<script src="<?= BASE_URL ?>webmanager/assets/js/jquery-validation/jquery.validate.min.js"></script>
<script>
	$.validator.addMethod("email", function(value) {
		return /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/.test(value);
	});
	$('input[type="text"]').change(function() {
		$(this).val($(this).val().trim());
	});
	$(document).ready(function() {
		$('#pro_frm').validate({
			rules: {
				main_title: 'required',
				contact_mail: {
					required: true,
					email: true
				},
				mobile_no: 'required number',
				address: 'required',
				passw: {
					minlength: 3
				},
				conPassw: {
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
				address: "Please enter address.",
				passw: {
					minlength: "Your password must be at least 3 characters long"
				},
				conPassw: {
					minlength: "Your password must be at least 3 characters long",
					equalTo: "Please enter the same password as above"

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
			}
		});
	});
</script>