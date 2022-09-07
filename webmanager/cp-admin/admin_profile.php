<?php
ob_start();
require("../template.php");
if($_SESSION['admin_user_id']=='')					redirect('index');

if(isset($_POST['mode']))
{
 if($_POST['mode']=='edit') 					disphtml("edit();");
 if($_POST['mode']=='update') 					update();
 
if($_POST['mode']=='delete_chk_about')		delete_chk_about();
if($_POST['mode']=='active_chk_about')		active_chk_about();
if($_POST['mode']=='inactive_chk_about')		inactive_chk_about();
 }

else												disphtml("main();");

ob_end_flush();

function main(){
global $link;
$sql = "SELECT * FROM ".LOGIN_MASTER."  WHERE 1 AND login_id='".$_SESSION['admin_user_id']."' AND status='A'";

$rs = mysqli_query($link,$sql) or die(mysqli_error($link));

$row = mysqli_num_rows($rs);
?>
<!-------------top----------------------> 
<div id="page-wrapper">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12 breadcrumb-header"><div id="breadcrumb" class="tooltip-demo"> <a href="<?=URL?>" title="Go to Home" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-home fa-fw"></i> Home</a><a href="#" class="current">Profile</a></div>
      </div>
    </div>
    <!-- /.row -->
    <div class="row">
      <div class="col-lg-12">
        <div class="panel tabbed-panel panel-success">
          <div class="panel-heading clearfix">
            <div class="panel-title pull-left"><a data-toggle="collapse" href="#collapseOne" aria-expanded="false"><strong><?php if($_SESSION['admin_user_id']=='1'){echo 'Admin';}else{echo 'User';}?> Details</strong></a></div>
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
				<?php  if($row > 0){ ?>
                    <form name="frm_chk_about" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                    <input type="hidden" name="mode" value="" />
                <div class="table-responsive">
					
                    
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th style="text-align: center;">ID</th>
                                <th style="text-align: center;">Name</th>
                                <th style="text-align: center;">Email</th>
                                <th style="text-align: center;">Status</th>
                                <th style="text-align: center;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php  
							$sl=1;
							while($rec=mysqli_fetch_assoc($rs)){
						 ?>
                            <tr class="text-center">
                                <td><?php  echo stripslashes($rec['user_id'])?></td>
                                <td><a href="javascript:Edit('<?php  echo $rec['login_id']?>');" title="Edit"><?php  echo stripslashes(ucfirst(strtolower($rec['fname'])))?>&nbsp;<?php  echo stripslashes(ucfirst(strtolower($rec['lname'])))?></a></td>
                                <td><?php  echo stripslashes($rec['email'])?></td>
                                <td><?php if(stripslashes($rec['status'])=='A'){?>
                      <span class="btn btn-success btn-xs">Active</span>
                      <?php }else{?>
                       <span class="btn btn-danger btn-xs">Inactive</span>
                      <?php }?></td>
                                <td><a title="Edit" href="javascript:Edit('<?php  echo $rec['login_id']?>','','2');" class="btn btn-info btn-circle"><i class="fa fa-edit fa-fw"></i></a></td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                    <div class="col-lg-2" id="on_option" style="display:none;">
                <div class="row" style="display: flex;">
                	<select class="form-control">
                        <option value="">Choose action</option>
                        <option value="D">Delete</option>
                        <option value="A">Active</option>
                        <option value="I">Inactive</option>
                    </select>&nbsp;
                    <button type="button" class="btn btn-success btn-sm" onclick="return delete_chk_about();">Apply</button>
                    </div>
                    </div>
                </div>
                <!-- /.table-responsive -->
                
                </form>
                <?php }?>
                </div>
          </div>
        </div>
        <!-- /.panel --> 
      </div>
    </div>
    <!-- /.row --> 
  </div>
  <!-- /.container-fluid --> 
</div>
<!-- /#page-wrapper -->
<script language="javascript">
function Edit(ID)
{
	document.frm_opts.mode.value='edit';
	document.frm_opts.id.value=ID;
	document.frm_opts.submit();
}
function delete_chk_about()
	{
	var do_action=document.frm_chk_about.choose_action.value;
	
	alert(do_action);
	var flag=false;
	for (i = 0; i < document.frm_chk_about.elements['public_chkbox[]'].length; i++)
	  {
	  
		  if(document.frm_chk_about.elements['public_chkbox[]'][i].checked==true)
		  {
			  flag=true;
				break;
		  }
	  }
	
		
	
		
		if(document.frm_chk_about.choose_action.value==0)
			{
			alert("Please select the action");
			document.frm_chk_about.choose_action.focus();
			return false;
			}
	if(do_action=='D')
	{
	document.frm_chk_about.mode.value='delete_chk_about';
	}
	if(do_action=='A')
	{
	document.frm_chk_about.mode.value='active_chk_about';
	}
	if(do_action=='I')
	{
	document.frm_chk_about.mode.value='inactive_chk_about';
	}
		document.frm_chk_about.submit();
		
		
	}
</script>
<?php  }
function edit(){
	
	global $link;
$rec = mysqli_fetch_assoc(mysqli_query($link,"SELECT * FROM ".LOGIN_MASTER." WHERE login_id='".$_POST['id']."'"));

?>
<div id="page-wrapper">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12 breadcrumb-header"><div id="breadcrumb" class="tooltip-demo"> <a href="<?=URL?>" title="Go to Home" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-home fa-fw"></i> Home</a><a href="<?php echo $_SERVER['PHP_SELF']?>">Profile</a><a href="#" class="current">Edit</a></div>
      </div>
    </div>
    <!-- /.row -->
    <div class="row">
      <div class="col-lg-12">
        <div class="panel tabbed-panel panel-success">
          <div class="panel-heading clearfix">
            <div class="panel-title pull-left"><a data-toggle="collapse" href="#collapseOne" aria-expanded="false"><strong><i class="fa fa-edit fa-fw"></i> Edit <?php if($_SESSION['admin_user_id']=='1'){echo 'admin';}else{echo 'user';}?> profile</strong></a></div>
          </div>
          <div class="panel-body" id="collapseOne" aria-expanded="true"  style="background: #eef9f0;margin: 1em;border-radius: 4px;">
              
                <div class="panel-body">
                <form action="<?php echo  $_SERVER['PHP_SELF']?>" method="post" name="edit_frm" id="edit_frm"enctype="multipart/form-data">
          <table width="100%">
            <tbody>
              <tr>
                <td colspan="3"><!--(<font color="#ff0000">All * mark fields are mandatory</font>)--></td>
              </tr>
              <tr>
                <td width="15%">ID</td>
                <td width="3%">&nbsp;</td>
                <td width="82%"><div class="col-lg-6">
                    <div class="form-group"> <span class="input">
                      <input type="text" readonly class="form-control" id="user_id" value="<?php echo $rec['user_id'];?>">
                      </span></div>
                    <!-- /input-group --> 
                  </div></td>
              </tr>
              <tr>
                <td width="15%">First Name</td>
                <td width="3%">&nbsp;</td>
                <td width="82%"><div class="col-lg-6">
                    <div class="form-group"> <span class="input">
                      <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $rec['fname'];?>">
                      </span></div>
                    <!-- /input-group --> 
                  </div></td>
              </tr>
              <tr>
                <td width="15%">Last Name</td>
                <td width="3%">&nbsp;</td>
                <td width="82%"><div class="col-lg-6">
                    <div class="form-group"> <span class="input">
                      <input type="text" class="form-control" id="lname" name="lname" value="<?php echo $rec['lname'];?>">
                      </span></div>
                    <!-- /input-group --> 
                  </div></td>
              </tr>
              <tr>
                <td width="15%">Email</td>
                <td width="3%">&nbsp;</td>
                <td width="82%"><div class="col-lg-6">
                    <div class="form-group"> <span class="input">
                      <input type="text" class="form-control" id="email" name="email" value="<?php echo $rec['email'];?>">
                      </span></div>
                    <!-- /input-group --> 
                  </div></td>
              </tr>
              <tr>
                <td width="15%">User Name</td>
                <td width="3%">&nbsp;</td>
                <td width="82%"><div class="col-lg-6">
                    <div class="form-group"> <span class="input">
                      <input type="text" class="form-control" id="username" name="username" value="<?php echo $rec['username'];?>">
                      </span></div>
                    <!-- /input-group --> 
                  </div></td>
              </tr>
              <tr>
                <td width="15%">Mobile No</td>
                <td width="3%">&nbsp;</td>
                <td width="82%"><div class="col-lg-6">
                    <div class="form-group"> <span class="input">
                      <input type="text" class="form-control" id="mobile_no" name="mobile_no" value="<?php echo $rec['mobile_no'];?>">
                      </span></div>
                    <!-- /input-group --> 
                  </div></td>
              </tr>
              <tr>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="3">
                <input type="hidden" name="mode" value="update">
                <input type="hidden" name="id" value="<?php  echo $_POST['id']?>">
                <input type="submit" value="Submit" class="btn btn-success">
                <a href="javascript:history.back()" class="btn btn-default">Cancel</a>
                </td>
              </tr>
            </tbody>
          </table>
        </form>
                <!-- /.table-responsive -->
                
                </div>
          </div>
        </div>
        <!-- /.panel --> 
      </div>
    </div>
    <!-- /.row --> 
  </div>
  <!-- /.container-fluid --> 
</div>

<?php 
}

function active_chk_about()
{
	global $link;
		$count_del=0;
		foreach($_REQUEST['public_chkbox'] as $val)
				{
				if($val!='on')
					{
					$sql_deletepublication = "UPDATE ".LOGIN_MASTER." 
											SET 
											status= 'A'
											where id='".$val."'";
					
					$qry_deletepublication	=mysqli_query($link,$sql_deletepublication) or die(mysqli_error($link));
							
							$count_del++;
							
					}
				}
				
				if($count_del > 0)
				{
				$_SESSION['MSG_ALERT'] = "Updated successfully";
				$_SESSION['IMG_PATH'] ="fa-check";
				$_SESSION['DIV_CLASS'] ="alert-success"; 
				redirect_cp('admin_profile');
				exit();
				}
				
}
function inactive_chk_about()
{
	global $link;
		$count_del=0;
		foreach($_REQUEST['public_chkbox'] as $val)
				{
				if($val!='on')
					{
					$sql_deletepublication = "UPDATE ".LOGIN_MASTER." 
											SET 
											status= 'I'
											where id='".$val."'";
					
					$qry_deletepublication	=mysqli_query($link,$sql_deletepublication) or die(mysqli_error($link));
							
							$count_del++;
							
					}
				}
				
				if($count_del > 0)
				{
				$_SESSION['MSG_ALERT'] = "Updated successfully";
				$_SESSION['IMG_PATH'] ="fa-check";
				$_SESSION['DIV_CLASS'] ="alert-success"; 
				redirect_cp('admin_profile');
				exit();
				}
}
function update()
{

	global $link;

    $sql = "UPDATE ".LOGIN_MASTER."
			SET
			fname = '".ConvertRealString($_POST['fname'])."',
			lname = '".ConvertRealString($_POST['lname'])."',
			email = '".ConvertRealString($_POST['email'])."',
			username = '".ConvertRealString($_POST['username'])."',				
			mobile_no ='".ConvertRealString($_POST['mobile_no'])."'
			
			WHERE
			login_id = '".$_POST['id']."'";
			
		
	$rs = mysqli_query($link,$sql) or die(mysqli_error($link));
	
	if($rs)
	{
	  $_SESSION['MSG_ALERT'] = 'Your profile is successfully updated';
	  $_SESSION['IMG_PATH'] ="fa-check"; 
	  $_SESSION['DIV_CLASS'] ="alert-success"; 
	  redirect_cp('admin_profile');
	  exit();
	}		

  else
  {
  	$_SESSION['MSG_ALERT'] = 'Sorry the Email-Id is already exist. Please choose another.';
	$_SESSION['IMG_PATH'] ="fa-exclamation-triangle";
	$_SESSION['DIV_CLASS'] = "alert-warning";
	redirect_cp('admin_profile');
	exit();
  }
  disphtml("main();");
}
?>
<form name="frm_opts" action="<?php  echo $_SERVER['PHP_SELF']?>" method="post" >
<input type="hidden" name="mode" value="">
<input type="hidden" name="id" value="">
<input type="hidden" name="hold_page" value="">
</form>
<script type="text/javascript">
	
	$('#edit_frm').validate({
		rules: {
		  fname: 'required',
		  lname: 'required',
		  email: 'required email',
		  username: {
            required: true,
            rangelength: [4, 8]
          },
		  mobile_no: 'required number'
		},
		messages: {
			fname: "Please enter first name...!",
			lname: "Please enter last name...!",
			email: {
			required: "Please enter a email address"
			},
			username: {
			required: "Please enter user name...!",
			rangelength: "Your username at least 4 to 8 characters long"
			},
			mobile_no: {
			required: "Please enter mobile no...!"
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
		}
	  });
	
	
</script>
