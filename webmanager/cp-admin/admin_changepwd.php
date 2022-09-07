<?php
ob_start();
require("../template.php");
if($_SESSION['admin_user_id']=='')					redirect('index');
if(isset($_POST['mode']))
{
 if($_POST['mode']=='update_password') 					update_password();
}
else												disphtml("main();");


ob_end_flush();

function main(){?>
<div id="page-wrapper">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12 breadcrumb-header"><div id="breadcrumb" class="tooltip-demo"> <a href="<?=URL?>" title="Go to Home" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-home fa-fw"></i> Home</a><a href="#" class="current">Password</a></div>
      </div>
    </div>
    <!-- /.row -->
    <div class="row">
      <div class="col-lg-12">
        <div class="panel tabbed-panel panel-success">
          <div class="panel-heading clearfix">
            <div class="panel-title pull-left"><a data-toggle="collapse" href="#collapseOne" aria-expanded="false"><strong>Change password</strong></a></div>
          </div>
          <div class="panel-body" id="collapseOne" aria-expanded="true">
              <!-- Content Alert part -->
                <?php if(isset($_SESSION['MSG_ALERT'])){?>
                <div id="hide_allert" class="alert  <?php  echo $_SESSION['DIV_CLASS']?> alert-dismissible"><strong><i class="fa <?php  echo $_SESSION['IMG_PATH']?> fa-fw"></i> Alert!</strong> &nbsp;&nbsp; 
					<?php  echo  $_SESSION['MSG_ALERT'];
						unset($_SESSION['MSG_ALERT']);
						unset($_SESSION['IMG_PATH']); 
						unset($_SESSION['DIV_CLASS']); 
					?>
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                </div>
                <?php }?>
                <!--End content Alert part -->
                <div class="panel-body" style="background: #eef9f0;border-radius: 4px;">
                <form id="testForm" method="post" action="<?php  echo $_SERVER['PHP_SELF']?>">
                <table width="100%">
                    <tbody>
                      <tr>
                        <td colspan="3">(<font color="#ff0000">All * mark fields are mandatory</font>)</td>
                      </tr>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr class="alt-row">
                        <td width="15%">Old Password<font color="#FF0000">*</font></span></td>
                        <td width="3%">&nbsp;</td>
                        <td width="82%"><div class="col-lg-6">
                        <div class="form-group">
                          <input type="password" name="oldpass" class="form-control" id="oldpass" placeholder="Old Password" autocomplete="off">
                        </div>
                          </div></td>
                      </tr>
                      <tr class="alt-row">
                        <td width="15%">New Password<font color="#FF0000">*</font></span></td>
                        <td width="3%">&nbsp;</td>
                        <td width="82%"><div class="col-lg-6">
                        <div class="form-group">
                          <input type="password" name="newpass" class="form-control" id="newpass" placeholder="New Password" autocomplete="off">
                        </div>
                          </div></td>
                      </tr>
                      <tr class="alt-row">
                        <td width="15%">Confirm Password<font color="#FF0000">*</font></span></td>
                        <td width="3%">&nbsp;</td>
                        <td width="82%"><div class="col-lg-6">
                        <div class="form-group">
                          <input type="password" name="retypass" class="form-control" id="retypass" placeholder="Confirm Password" autocomplete="off">
                        </div>
                          </div></td>
                      </tr>
                      <tr>
                        <td colspan="3">
                        <input type="hidden" name="mode" value="update_password">
                  		<button type="submit" class="btn btn-success">Submit</button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </form>
              </div>
              <!-- /.card -->
            </div>
          </div>
          <!-- /.col -->
        </div>
  	</div>
  </div>
</div>
<?php  }
function update_password()
{

	 global $link;
	 
	 $sql = "SELECT * FROM ".LOGIN_MASTER." WHERE password='".base64_encode($_POST['oldpass'])."' AND type_id ='".$_SESSION['type_id']."' AND login_id='".$_SESSION['admin_user_id']."'";
	 $rs = mysqli_query($link,$sql) or die(mysqli_error($link));
  	 $row = mysqli_num_rows($rs);
  	 if($row)
	 {
	if(trim($_POST['newpass']) == trim($_POST['retypass']))
	{

    $sql = "UPDATE ".LOGIN_MASTER."
			SET
			password = '".base64_encode(ConvertRealString($_POST['newpass']))."'
			
			WHERE
			login_id = '".$_SESSION['admin_user_id']."'";
			
		
	$rs = mysqli_query($link,$sql) or die(mysqli_error($link));
	
	  $_SESSION['MSG_ALERT'] = 'Admin Password is successfully updated';
	  $_SESSION['IMG_PATH'] ="fa-check"; 
	  $_SESSION['DIV_CLASS'] ="alert-success";
	  
	  
	  session_destroy();
	  redirect('index');
	  exit();

	}
}

  else
  {
  	$_SESSION['MSG_ALERT'] = 'Sorry the old password is not match. Please try again.';
	$_SESSION['IMG_PATH'] ="fa-exclamation-triangle";
	$_SESSION['DIV_CLASS'] = "alert-warning";
	
	
	redirect_cp('admin_changepwd');
  }
  
}
?>

<script language="javascript">

$(document).ready(function () {
	$('input[type="password"]').change(function() {
		$(this).val($(this).val().trim());
		return false;
	});
$('#testForm').validate({
		rules: {
        oldpass: {
            required: true,
            rangelength: [4, 20]
        },
        newpass: {
            required: true,
            rangelength: [4, 20],
			checklower: true,
			checkupper: true,
			checkdigit: true
        },
        retypass: {
            required: true,
            equalTo: "#newpass"
        }
		},
		messages: {
		oldpass: {
            required: "Please provide a old password",
            rangelength: "Your password at least 4 to 20 characters long"
        },
		newpass: {
            required: "Please provide a password",
            rangelength: "Your password at least 4 to 20 characters long",
			checklower: "Need atleast 1 lowercase alphabet",
			checkupper: "Need atleast 1 uppercase alphabet",
			checkdigit: "Need atleast 1 digit"
        },
        retypass: {
            required: "Please provide a confirm password",
            equalTo: "Please enter the same password as above"

    	}
		},
		errorElement: 'label',
		errorPlacement: function (error, element) {
		  error.addClass('has-warning');
		  element.closest('.form-group').append(error);
		},
		highlight: function (element, errorClass, validClass) {
		  $(element).addClass('has-warning');
		  $(element).removeClass('has-success');
		},
		unhighlight: function (element, errorClass, validClass) {
		  $(element).removeClass('has-warning');
		  $(element).addClass('has-success');
		},
         submitHandler: function(form) {
			if (confirm('Are you sure change this password...?')) {
            form.submit();
        	}
        }
	  });

});
</script>

