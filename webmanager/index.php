<?php 
ob_start();
require("../connection.php");
if(isset($_REQUEST['mode']))



	{



	if($_REQUEST['mode']=="login") login();

	elseif($_REQUEST['mode']=="forgot") forgot();



    elseif($_REQUEST['mode']=="logout")	logout();



 }ob_end_flush();



if(isset($_SESSION['admin_user_id']))



{



	if($_SESSION['admin_user_id']!=""){ 



		redirect_cp('admin_home');



		exit;



}	}





function login(){

	

	global $link;



	//if($_POST["captcha"]==$_SESSION["code"]){

		

	$login_sql="SELECT * FROM ".LOGIN_MASTER." WHERE username ='".$_POST['username']."' AND  password ='".base64_encode($_POST['password'])."'";	



	$login_rs=mysqli_query($link,$login_sql) or die("Admin login error:".mysqli_error($link));



	$login_row=mysqli_fetch_array($login_rs);



	//print_r($login_row);



	$num_fetch = mysqli_num_rows($login_rs);

	

	if($num_fetch > 0)



	{

		if($login_row['status']=='A'){

		

		#==========set cookie===============



		if($_REQUEST['check_cook'])// This section for remember me 



				 {



						   $Month = 86400 + time();



						 //this adds 30 days to the current time



						 setcookie("user_name",$login_row['username'], $Month);



						 setcookie("pwd",$login_row['password'] , $Month);



				 }



		#===== end set Cookie ==============



		//session_register("admin_user_id");



		//session_register("admin_username");

		$sql_inset_login="INSERT INTO ".ADMIN_LOGIN_DETAILS." 	

			SET 	

			a_id = '".$login_row['login_id']."',

			userType = '".get_membertype($login_row['type_id'])." - ".$login_row['fname']."',

			login_time = '".date('Y-m-d h:i:s')."',

			login_ip = '".$_SERVER['REMOTE_ADDR']."'";	

	

		$qry_inset_login	=mysqli_query($link,$sql_inset_login);

		$last_admin_id=mysqli_insert_id($link);

		

		$_SESSION['last_admin_id'] = $last_admin_id;

		$_SESSION['admin_username'] = $login_row['username'];



		$_SESSION['admin_user_id'] = $login_row['login_id'];



		$_SESSION['first_name'] = $login_row['fname'];



		$_SESSION['last_name'] = $login_row['lname'];



		$_SESSION['type_id'] = $login_row['type_id'];

		$_SESSION["user_id"]=$login_row['user_id'];



		redirect_cp('admin_home');

		}else{

			$_SESSION['INDEX_ALERT']="You are temporarly bolcked.";

			$_SESSION['IMG_PATH'] = "fa fa-exclamation-triangle  fa-fw";

			$_SESSION['DIV_CLASS'] = "alert-warning";

			redirect('index');

	

			exit;

		}

	}	



	else{



	   



		$_SESSION['INDEX_ALERT']="Invalid User Name or Password.";

		$_SESSION['IMG_PATH'] = "fa fa-exclamation-triangle  fa-fw";

		$_SESSION['DIV_CLASS'] = "alert-warning";

		redirect('index');



		exit;



	}

	/*}else {

		$_SESSION['INDEX_ALERT']='Captcha Mismatch...!';

		$_SESSION['DIV_CLASS'] = "alert-danger";

		redirect('index');



		exit;

	}*/
	}

	

function forgot(){

	

	global $link;



	//if($_POST["captcha"]==$_SESSION["code"]){

		

	$login_sql="SELECT * FROM ".LOGIN_MASTER." WHERE email ='".$_POST['email']."'";	



	$login_rs=mysqli_query($link,$login_sql) or die("Admin login error:".mysqli_error());



	$login_row=mysqli_fetch_array($login_rs);



	//print_r($login_row);

	//exit;

	$num_fetch = mysqli_num_rows($login_rs);

	

	if($num_fetch > 0)



	{

		if($login_row['status']=='A'){

		

		

		$code = rand(111111,9999999);

		

		$sql_inset_post="UPDATE ".LOGIN_MASTER." 

                    SET 

					password = '".base64_encode($code)."'

					

                    where email='".$_REQUEST['email']."'";

					

		$qry_inset_post	=mysqli_query($link,$sql_inset_post) or die(mysqli_error($link));

		

		

		if($qry_inset_post){

			#email send#

			

			/*---------- Send Email User ---------- */

			$to_name 			=	'Admin-User';

			$to_email 			=	$_REQUEST['email'];

			$from_name 			= 	get_siteconfig_define('website_name');

			$from_email 		= 	get_siteconfig_define('email');

			$subject		=	"Regeneration Of Password";		

			$message = " <html>

				<body>

					<table style='width: 70%;background-color: #f5f5f5;padding:18px' align='center'>

						<tr>

							<th style='text-align: center; padding:10px 0px'> <img style='width:25%' src='".BASE_URL."uploads/admin/".get_siteconfig_define('logo')."'/></th>

						</tr>

						<tr>

							<td>Hi, ".$to_name."</td>

						</tr>

	

						<tr>

							<td>

								<p>

									Your New Login details are <br/>

									<b>

										User Name: ".$login_row['username']."

										<br/>

										Password: ".$code."

									</b>

								</p>

								

							</td>

						</tr>

	

						<tr>

							<td>

								Visit at <b>".get_siteconfig('website_name').",</b>

							</td>

						</tr>

						<tr>

							<td style='text-align: center;'>

								<br/>

								<a href='".URL."'style='border: 0;background-color: #ff5937;border-radius: 50px;padding: 10px 20px;color:#fff;font-size: 14px;

									outline: none;text-decoration: none;' >

								Login Now

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

			</html>";

			//send_mail_common($to_name, $to_email, $form_name, $form_email, $subject, $message, $bcc='');	

			$mail_status 			= 	send_mail_common($to_name,$to_email,$from_name,$from_email,$subject,$message,$useSendGrid='no',$type='');

			

			//--------------------------------------------mailfunction end-------------------------------------------------------//

			

		$_SESSION['INDEX_ALERT'] = "Successful, Check your email. If did't get email plz cantact owner.";

		$_SESSION['IMG_PATH'] ="fa-check"; 

		$_SESSION['DIV_CLASS'] ="alert-success"; 

		redirect('index');

		}else{

			$_SESSION['INDEX_ALERT']="Error,Try Again!";

			$_SESSION['IMG_PATH'] = "fa fa-exclamation-triangle  fa-fw";

			$_SESSION['DIV_CLASS'] = "alert-warning";

			redirect('index');	

			exit;

		}

		exit;

		}else{

			$_SESSION['INDEX_ALERT']="You are temporarly bolcked.";

			$_SESSION['IMG_PATH'] = "fa fa-exclamation-triangle  fa-fw";

			$_SESSION['DIV_CLASS'] = "alert-warning";

			redirect('index');	

			exit;

		}

	}	



	else{

		$_SESSION['INDEX_ALERT']="Invalid Email-Id.";

		$_SESSION['IMG_PATH'] = "fa fa-exclamation-triangle  fa-fw";

		$_SESSION['DIV_CLASS'] = "alert-warning";

		redirect('index');

		exit;



	}

	/*}else {

		$_SESSION['INDEX_ALERT']='Captcha Mismatch...!';

		$_SESSION['DIV_CLASS'] = "alert-danger";

		redirect('index');

		exit;

	}*/
	}

?>

<!DOCTYPE html>

<html lang="en">

    

<head>

        <title><?php  echo SITETITLE?> | <?php  echo ADMIN_TITLE?></title>

        <meta charset="UTF-8" />

        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<link rel="stylesheet" href="<?=URL?>assets/css/bootstrap.min.css" />

		<link rel="stylesheet" href="<?=URL?>assets/css/bootstrap-responsive.min.css" />

        <link rel="stylesheet" href="<?=URL?>assets/css/matrix-login.css" />

        <link type="image/ico" rel="icon" href="<?php echo BASE_URL.'uploads/admin/'.get_siteconfig('favicon'); ?>">

        <link href="<?=URL?>assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">

		<script src="<?=URL?>assets/js/jquery.min.js"></script>  

        

        <!-- Bootstrap Core JavaScript -->

        <script src="<?=URL?>assets/js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->

        <script src="<?=URL?>assets/js/metisMenu.min.js"></script>



        <!-- Custom Theme JavaScript -->

        <script src="<?=URL?>assets/js/startmin.js"></script>

        <!-- jquery-validation -->

		<script src="<?=URL?>assets/js/jquery-validation/jquery.validate.min.js"></script>

		<script src="<?=URL?>assets/js/matrix.login.js"></script> 

		<script src="<?=URL?>assets/js/jquery-validation/additional-methods.js"></script>

    </head>

    <body class="login_body">

        <div id="loginbox">

        <div class="loginbox_inside">

         	<?php if(isset($_SESSION['INDEX_ALERT'])){?>  

            <div  id="hide_allert" class="alert <?=$_SESSION['DIV_CLASS']?>">

              <strong><i class="<?php  echo $_SESSION['IMG_PATH']?>"></i> Alert!</strong>

              <?php  

				  echo  $_SESSION['INDEX_ALERT'];

				  unset($_SESSION['INDEX_ALERT']);

				  unset($_SESSION['IMG_PATH']);

				  unset($_SESSION['DIV_CLASS']);

			  ?>

              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

             </div>

             <?php }?>

                <!--End content Alert part -->

            <form  method="post" id="loginform" name="loginform" class="form-vertical login_valid" action="<?php  echo $_SERVER['PHP_SELF'];?>">

            <input type="hidden" name="mode" value="login">

				 <div class="control-group normal_text"> <a href="<?=BASE_URL?>" target="_blank"><h3><img src="<?php echo BASE_URL.'uploads/admin/'.get_siteconfig('logo'); ?>" alt="<?=SITETITLE?>" width="200" /></h3></a></div>

                <div class="control-group">

                    <div class="controls">

                        <div class="main_input_box">

                            <span class="add-on bg_lg"><i class="fa fa-user fa-fw"></i></span><input type="text" placeholder="Username" name="username" id="username" autocomplete="off" autofocus />

                        </div>

                    </div>

                </div>

                <div class="control-group">

                    <div class="controls">

                        <div class="main_input_box">

                            <span class="add-on bg_ly"><i class="fa fa-lock fa-fw"></i></span><input type="password" placeholder="Password" name="password" id="password" autocomplete="off" />

                        </div>

                    </div>

                </div>

                <!--<div class="control-group">

                    <div class="controls">

                        <div class="main_input_box">

                            <span><img id="captchaReload" src="cp-admin/captcha.php" height="30px" width="80px" /></span><a href="<?=URL?>"><i  onClick="refreshCaptcha()" class="fa fa-refresh" style="width: 2.286em;font-size: 20px;vertical-align: middle;cursor:pointer;"></i></a><input type="text" placeholder="Enter Captcha" name="captcha" id="captcha" autocomplete="off" style="width:50%;" />

                        </div>

                    </div>

                </div>-->

                <div class="form-actions">

                    <span class="pull-left"><a href="#" class="flip-link btn btn-info" id="to-recover">Lost password?</a></span>

                    <span class="pull-right"><input type="submit" class="btn btn-success" value="Login" /></span>

                </div>

            </form>

            

            <form id="recoverform" name="recoverform" action="<?php  echo $_SERVER['PHP_SELF'];?>" class="form-vertical recover_valid" method="post">

             <input type="hidden" name="mode" value="forgot">

				<p class="normal_text">Enter your e-mail address below and we will send you instructions how to recover a password.</p>

				

                    <div class="controls">

                        <div class="main_input_box">

                            <span class="add-on bg_lo"><i class="fa fa-envelope fa-fw"></i></span><input type="text" id="email" name="email" placeholder="E-mail address" autocomplete="off" autofocus />

                        </div>

                    </div>

               

                <!--<div class="control-group">

                    <div class="controls">

                        <div class="main_input_box">

                            <span><img id="captchaReload" src="cp-admin/captcha.php" height="30px" width="80px" /></span><a href="<?=URL?>"><i  onClick="refreshCaptcha()" class="fa fa-refresh" style="width: 2.286em;font-size: 20px;vertical-align: middle;cursor:pointer;"></i></a><input type="text" placeholder="Enter Captcha" name="captcha" id="captcha" autocomplete="off" style="width:50%;" />

                        </div>

                    </div>

                </div>-->

                <div class="form-actions">

                    <span class="pull-left"><a href="#" class="flip-link btn btn-success" id="to-login">&laquo; Back to login</a></span>

                    <span class="pull-right"><input type="submit" class="btn btn-info" value="Reecover"/></span>

                </div>

            </form>

            </div>

        </div>



<script language="javascript">

function refreshCaptcha()

{

	//alert('hii');

	$('#captchaReload').attr('src','cp-admin/captcha.php');



} 

</script>

  </body>



</html>

