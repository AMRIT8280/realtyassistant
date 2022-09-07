<?php
ob_start();
require("../template.php");
if($_SESSION['admin_user_id']=='')					redirect('index');
require_once("../authonication.php");
if(isset($_POST['mode']))
{
if($_POST['mode']=='insert_about') 			insert_about();
if($_POST['mode']=='delete_about')			delete_about();
if($_POST['mode']=='delete_chk_about')		delete_chk_about();
if($_POST['mode']=='active_chk_about')		active_chk_about();
if($_POST['mode']=='inactive_chk_about')		inactive_chk_about();
if($_POST['mode']=='edit_about')				edit_about();


if($_POST['mode']=='edit')						disphtml("edit();");

if($_POST['mode']=='')						disphtml("main();");
}
else												disphtml("main();");


ob_end_flush();
?>
<form name="frm_opts" action="<?php  echo $_SERVER['PHP_SELF']?>" method="post" >
<input type="hidden" name="mode" value="">
<input type="hidden" name="pageNo" value="<?php if(isset($_POST['pageNo']))echo $_POST['pageNo']; else { echo 1;}?>">
<input type="hidden" name="url" value="<?php  echo $_SERVER['PHP_SELF']?>">
<input type="hidden" name="id" value="">

<input type="hidden" name="hold_page" value="">
<input type="hidden" name="menu_cat" id="menu_cat" />
<input type="hidden" name="menu_subcat" id="menu_subcat"/>
<input type="hidden" name="cp" id="cp"/>
<input type="hidden" name="np" id="np"/>
<?php if(isset($_REQUEST['scarch_main_title']))
{ ?>
<input type="hidden" name="scarch_main_title" id="scarch_main_title" value="<?php echo $_REQUEST['scarch_main_title']; ?>"/>
<?php } ?>
</form>


<?php
function main(){
	global $link;
		
$sql_list_about = "SELECT * FROM ".LOGIN_MASTER."  WHERE 1 AND status!='D' AND login_id!=1 ORDER BY login_id DESC";	
$qry_list_about = mysqli_query($link,$sql_list_about);
$num_list_about = mysqli_num_rows($qry_list_about);


$countShow="SELECT count(*) FROM ".LOGIN_MASTER."  WHERE 1 AND status!='D' AND login_id!=1 ORDER BY login_id DESC";
$qry_countshow=mysqli_query($link,$countShow) or die(mysqli_error($link));
$count=mysqli_num_rows($qry_countshow);
?>
<div id="page-wrapper">
  <div class="container-fluid">
  	<div class="row">
      <div class="col-lg-12 breadcrumb-header"><div id="breadcrumb" class="tooltip-demo"> <a href="<?=URL?>" title="Go to Home" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-home fa-fw"></i> Home</a><a href="#" class="current">User</a></div>
      </div>
    </div>    
    <!-- /.row -->
    <div class="row">
      <div class="col-lg-12">
        <div class="panel tabbed-panel panel-success">
          <div class="panel-heading clearfix">
            <div class="panel-title pull-left"><a data-toggle="collapse" href="#collapseOne" aria-expanded="false"><strong>User Details</strong></a></div>
            <div class="pull-right">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#tab-success-1" data-toggle="tab">User List</a></li>
                <li><a href="#tab-success-2" data-toggle="tab">Add New</a></li>
              </ul>
            </div>
          </div>
          <div class="panel-body" id="collapseOne" aria-expanded="true">
            <div class="tab-content">
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
              <div class="tab-pane fade in active" id="tab-success-1">
                <div class="panel-body">
                  <form name="frm_chk_about" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
					<input type="hidden" name="mode" value="" />
                <div class="table-responsive">
                    <table id="dataTables-example" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Member Type</th>
                                <th>User Id</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if($num_list_about > 0){?>
						<?php  
						$cnt=$GLOBALS['start']+1;
						while($row_list_about=mysqli_fetch_array($qry_list_about)){
						?>
                            <tr>
                                <td><input class="cheak_all" type="checkbox" id="public_chkbox" name="public_chkbox[]"value="<?php  echo $row_list_about['login_id']; ?>" autocomplete="off"></td>
                                <td><?php  echo get_membertype($row_list_about['type_id']); ?></td>
                                <td><?php  echo $row_list_about['user_id']; ?></td>
                                <td><?php  echo $row_list_about['fname']; ?> <?php  echo $row_list_about['lname']; ?></td>
                                <td><?php  echo $row_list_about['username']; ?></td>
                                <td><?php if(stripslashes($row_list_about['status'])=='A'){?>
                      <span class="btn btn-success btn-xs">Active</span>
                      <?php }else{?>
                       <span class="btn btn-danger btn-xs">Inactive</span>
                      <?php }?></td>
                      		<td class="tooltip-demo">
                            <a title="Edit" data-toggle="tooltip" data-placement="bottom" href="javascript:Edit('<?php  echo $row_list_about['login_id']?>','','2');" class="btn btn-info btn-circle"><i class="fa fa-edit fa-fw"></i></a>
                            <a title="Delete" data-toggle="tooltip" data-placement="bottom" href="javascript:Delete('<?php  echo $row_list_about['login_id']?>','<?php  echo $GLOBALS['start']?>');" class="btn btn-danger btn-circle"><i class="fa fa-trash fa-fw"></i></a>
                            </td>
                            </tr>
                        <?php }}?>  
                        </tbody>
                    </table>
                    <div class="col-lg-2" id="on_option" style="display:none;width: 19% !important;">
                    <div class="row" style="display: flex;">
                        <select class="form-control" name="choose_action" id="choose_action">
                            <option value="0">Choose action</option>
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
                </div> 
              </div>
              <script language="javascript">
function Delete(ID,record_no)
{

	
	var UserResp = window.confirm("Are you sure to delete this User?");
	if( UserResp == true )
	{
		document.frm_opts.mode.value='delete_about';
		document.frm_opts.id.value=ID;
		document.frm_opts.hold_page.value = record_no*1;
		document.frm_opts.submit();
	}
	
}

function Edit(ID,record_no,cat,val)
{
	document.frm_opts.mode.value='edit';
	document.frm_opts.id.value=ID;
	document.frm_opts.hold_page.value = record_no*1;	
	document.frm_opts.submit();
}
function delete_chk_about()
	{
	var do_action=document.frm_chk_about.choose_action.value;
	
	/*if(flag==false)
		{
		alert("Please select atleat one User");
		return false;
		}*/
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
              <div class="tab-pane fade" id="tab-success-2">
              <div class="panel-body">
              <form action="" method="post" name="add_frm" id="add_frm" enctype="multipart/form-data" novalidate="novalidate">
				  <input type="hidden" name="mode" value="insert_about">
                  <table width="100%">
                    <tbody>
                      <tr>
                        <td colspan="3">(<font color="#ff0000">All * mark fields are mandatory</font>)</td>
                      </tr>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr>
                        <td width="15%">Users ID <font color="#ff0000">*</font></td>
                        <td width="3%">&nbsp;</td>
                        <td width="82%"><div class="col-lg-6"><div class="form-group"> <span class="input">
                            <input type="text" value="<?php echo generate_new_user_id(); ?>" readonly class="form-control" id="user_id" name="user_id" autocomplete="off">
                            </span></div>
                            <!-- /input-group -->
                          </div></td>
                      </tr>
                      <tr>
                        <td width="15%">First Name <font color="#ff0000">*</font></td>
                        <td width="3%">&nbsp;</td>
                        <td width="82%"><div class="col-lg-6"><div class="form-group"> <span class="input">
                            <input type="text" class="form-control" id="fname" name="fname" placeholder="Enter First Name" autocomplete="off">
                            </span></div>
                            <!-- /input-group -->
                          </div></td>
                      </tr>
                      <tr>
                        <td width="15%">Last Name <font color="#ff0000">*</font></td>
                        <td width="3%">&nbsp;</td>
                        <td width="82%"><div class="col-lg-6"><div class="form-group"> <span class="input">
                            <input type="text" class="form-control" id="lname" name="lname" placeholder="Enter Last Name" autocomplete="off">
                            </span></div>
                            <!-- /input-group -->
                          </div></td>
                      </tr>
                      <tr>
                        <td width="15%">Phone No <font color="#ff0000">*</font></td>
                        <td width="3%">&nbsp;</td>
                        <td width="82%"><div class="col-lg-6"><div class="form-group"> <span class="input">
                            <input type="text" class="form-control" id="mobile_no" name="mobile_no" placeholder="Enter Contact No" autocomplete="off">
                            </span></div>
                            <!-- /input-group -->
                          </div></td>
                      </tr>
                      <tr>
                        <td width="15%">Email ID <font color="#ff0000">*</font></td>
                        <td width="3%">&nbsp;</td>
                        <td width="82%"><div class="col-lg-6"><div class="form-group"> <span class="input">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email ID" autocomplete="off">
                            </span></div>
                            <!-- /input-group -->
                          </div></td>
                      </tr>
                      <tr>
                        <td width="15%">Address <font color="#ff0000">*</font></td>
                        <td width="3%">&nbsp;</td>
                        <td width="82%"><div class="col-lg-6"><div class="form-group"> <span class="input">
                            <input type="text" class="form-control" id="address" name="address" placeholder="Enter Address" autocomplete="off">
                            </span></div>
                            <!-- /input-group -->
                          </div></td>
                      </tr>
                      <tr>
                        <td width="15%">User Type <font color="#ff0000">*</font></td>
                        <td width="3%">&nbsp;</td>
                        <td width="82%"><div class="col-lg-6">
                              <div class="form-group">
                                <select class="form-control" name="type_id" id="type_id">
                                	<option value="">Select Type</option>
                                    <?php 
							  			$sql_select= "SELECT * FROM ".MEMBER_TYPE." WHERE type_id!='1' AND status!='I'";
                                       $sql_query= mysqli_query($link,$sql_select);
                                       while($row= mysqli_fetch_array($sql_query))
										{
							  		?>
								 	<option value="<?php  echo $row['type_id']; ?>"><?php  echo $row['member_type']; ?></option>
                                    <?php }?>
                                </select>
                    		   </div>
                            <!-- /input-group -->
                          </div></td>
                      </tr>
                      <tr>
                        <td width="15%">User Name <font color="#ff0000">*</font></td>
                        <td width="3%">&nbsp;</td>
                        <td width="82%"><div class="col-lg-6"><div class="form-group"> <span class="input">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter user name" autocomplete="off">
                            </span></div>
                            <!-- /input-group -->
                          </div></td>
                      </tr>
                      <tr>
                        <td width="15%">Password <font color="#ff0000">*</font></td>
                        <td width="3%">&nbsp;</td>
                        <td width="82%"><div class="col-lg-6"><div class="form-group"> <span class="input">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter user password" autocomplete="off">
                            </span></div>
                            <!-- /input-group -->
                          </div></td>
                      </tr>
                      <tr>
                        <td width="15%">Confirm Password <font color="#ff0000">*</font></td>
                        <td width="3%">&nbsp;</td>
                        <td width="82%"><div class="col-lg-6"><div class="form-group"> <span class="input">
                            <input type="password" class="form-control" id="conf_pwd" name="conf_pwd" placeholder="Enter user confirm password" autocomplete="off">
                            </span></div>
                            <!-- /input-group -->
                          </div></td>
                      </tr>
                      <tr>
                        <td width="15%" height="33">Status <font color="#ff0000">*</font></td>
                        <td width="3%">&nbsp;</td>
                        <td width="82%"><div class="col-lg-6">
                          <div class="form-group">
                            <select class="form-control" name="status" id="status" data-select2-id="status" tabindex="-1" aria-hidden="true">
                            	<option value="" data-select2-id="4">Select Status</option>
                                <option value="I">Inactive</option>
                                <option value="A">Active</option>
                            </select>
                           </div>
                        <!-- /input-group -->
                      </div></td>
                      </tr>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="3">
                          <input type="hidden" name="id" value="">
                          <input type="hidden" name="hold_page" value="">
                          <input type="submit" value="Submit" class="btn btn-success">
                          <a href="admin_users.php" class="btn btn-default">Cancel</a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  </form>
               </div>
              </div>
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
<?php  }

function insert_about(){
	global $link;

		 $sql_check_category="select * from ".LOGIN_MASTER." where username='".$_REQUEST['username']."'";	
		$qry_check_category=mysqli_query($link,$sql_check_category) or die(mysqli_error($link));
		$num_check_category=mysqli_num_rows($qry_check_category);
		if($num_check_category==0)
			{
	
	
					 $sql_inset_post="INSERT INTO ".LOGIN_MASTER." 
	
						SET 
            user_id = '".ConvertRealString($_REQUEST['user_id'])."',
						fname = '".ConvertRealString($_REQUEST['fname'])."',
						lname = '".ConvertRealString($_REQUEST['lname'])."',
						email = '".ConvertRealString($_REQUEST['email'])."',
						username = '".ConvertRealString($_REQUEST['username'])."',
						type_id = '".ConvertRealString($_REQUEST['type_id'])."',
						status = '".ConvertRealString($_REQUEST['status'])."',
						password = '".base64_encode(ConvertRealString($_POST['password']))."',
						address='".ConvertRealString($_REQUEST['address'])."',
						mobile_no='".ConvertRealString($_REQUEST['mobile_no'])."'";	
	
					$qry_inset_post	=mysqli_query($link,$sql_inset_post);	
	
			
	
			$_SESSION['MSG_ALERT'] = "Latest User Profile inserted successfully";
			$_SESSION['IMG_PATH'] ="fa-check"; 
			$_SESSION['DIV_CLASS'] ="alert-success"; 
			
			 redirect_cp('admin_users');
		exit();
		}else{
			$_SESSION['MSG_ALERT'] = "Latest Information already exist";
			$_SESSION['IMG_PATH'] ="fa-exclamation-triangle";
			$_SESSION['DIV_CLASS'] = "alert-warning";			
			 redirect_cp('admin_users');
		}
	
			
}

function delete_about()
{

global $link;
		$sql_delete_about= "UPDATE ".LOGIN_MASTER." 
                    SET 
					status= 'D'
                    where login_id='".$_REQUEST['id']."'";   
		$qry_delete_about=mysqli_query($link,$sql_delete_about) or die(mysqli_error());
		
		$_SESSION['MSG_ALERT'] = "Latest User has been successfully deleted.";
		$_SESSION['IMG_PATH'] ="fa-ban"; 
		$_SESSION['DIV_CLASS'] ="alert-danger"; 
		redirect_cp('admin_users');
		   exit();
}

function delete_chk_about()
{
	global $link;
		$count_del=0;
		foreach($_REQUEST['public_chkbox'] as $val)
				{
				if($val!='on')
					{
					
							$sql_deletepublication = "UPDATE ".LOGIN_MASTER." 
											SET 
											status= 'D'
											where login_id='".$val."'";
					
					$qry_deletepublication	=mysqli_query($link,$sql_deletepublication) or die(mysqli_error($link));
							
							$count_del++;
							
					}
				}
				
				if($count_del > 0)
				{
				$_SESSION['MSG_ALERT'] = "Successfully deleted.";
				$_SESSION['IMG_PATH'] ="fa-ban"; 
				$_SESSION['DIV_CLASS'] ="alert-danger"; 
				redirect_cp('admin_users');
				exit();
				}
				
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
											where login_id='".$val."'";
					
					$qry_deletepublication	=mysqli_query($link,$sql_deletepublication) or die(mysqli_error($link));
							
							$count_del++;
							
					}
				}
				
				if($count_del > 0)
				{
				$_SESSION['MSG_ALERT'] = "Updated successfull";
				$_SESSION['IMG_PATH'] ="fa-check";
				$_SESSION['DIV_CLASS'] ="alert-success"; 
				redirect_cp('admin_users');
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
											where login_id='".$val."'";
					
					$qry_deletepublication	=mysqli_query($link,$sql_deletepublication) or die(mysqli_error($link));
							
							$count_del++;
							
					}
				}
				
				if($count_del > 0)
				{
				$_SESSION['MSG_ALERT'] = "Updated successfull";
				$_SESSION['IMG_PATH'] ="fa-check";
				$_SESSION['DIV_CLASS'] ="alert-success"; 
				redirect_cp('admin_users');
				exit();
				}
}


?>
<?php
function edit(){
	
	global $link;
$sql_edit_about = "SELECT * FROM ".LOGIN_MASTER."  where login_id ='".$_REQUEST['id']."'";
$qry_edit_about = mysqli_query($link,$sql_edit_about) or die(mysqli_error());
$row_edit_about = mysqli_fetch_array($qry_edit_about);

?>
<div id="page-wrapper">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12 breadcrumb-header"><div id="breadcrumb" class="tooltip-demo"> <a href="<?=URL?>" title="Go to Home" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-home fa-fw"></i> Home</a><a href="<?php echo $_SERVER['PHP_SELF']?>">User</a><a href="#" class="current">Edit</a></div>
      </div>
    </div>
    <!-- /.row -->
    <div class="row">
      <div class="col-lg-12">
        <div class="panel tabbed-panel panel-success">
          <div class="panel-heading clearfix">
            <div class="panel-title pull-left"><a data-toggle="collapse" href="#collapseOne" aria-expanded="false"><strong><i class="fa fa-edit fa-fw"></i> Edit user profile</strong></a></div>
          </div>
          <div class="panel-body" id="collapseOne" aria-expanded="true" style="background: #eef9f0;margin: 1em;border-radius: 4px;">
              
                <div class="panel-body">
             	<form action="<?php echo  $_SERVER['PHP_SELF']?>" method="post" name="edit_frm" id="edit_frm"enctype="multipart/form-data">
		<input type="hidden" name="mode" value="edit_about">
		<input type="hidden" name="id" value="<?php  echo $_REQUEST['id']?>">
                  <table width="100%">
                    <tbody>
                      <tr>
                        <td colspan="3">(<font color="#ff0000">All * mark fields are mandatory</font>)</td>
                      </tr>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr>
                        <td width="15%">Users ID <font color="#ff0000">*</font></td>
                        <td width="3%">&nbsp;</td>
                        <td width="82%"><div class="col-lg-6"><div class="form-group"> <span class="input">
                            <input type="text" value="<?php echo $row_edit_about['user_id']; ?>" readonly class="form-control" id="user_id" name="user_id" autocomplete="off">
                            </span></div>
                            <!-- /input-group -->
                          </div></td>
                      </tr>

                      <tr>
                        <td width="15%">First Name <font color="#ff0000">*</font></td>
                        <td width="3%">&nbsp;</td>
                        <td width="82%"><div class="col-lg-6"><div class="form-group"> <span class="input">
                            <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $row_edit_about['fname'];?>" autocomplete="off">
                            </span></div>
                            <!-- /input-group -->
                          </div></td>
                      </tr>
                      <tr>
                        <td width="15%">Last Name <font color="#ff0000">*</font></td>
                        <td width="3%">&nbsp;</td>
                        <td width="82%"><div class="col-lg-6"><div class="form-group"> <span class="input">
                            <input type="text" class="form-control" id="lname" name="lname"  value="<?php echo $row_edit_about['lname'];?>" autocomplete="off">
                            </span></div>
                            <!-- /input-group -->
                          </div></td>
                      </tr>
                      <tr>
                        <td width="15%">Phone No <font color="#ff0000">*</font></td>
                        <td width="3%">&nbsp;</td>
                        <td width="82%"><div class="col-lg-6"><div class="form-group"> <span class="input">
                            <input type="text" class="form-control" id="mobile_no" name="mobile_no" value="<?php echo $row_edit_about['mobile_no'];?>" autocomplete="off">
                            </span></div>
                            <!-- /input-group -->
                          </div></td>
                      </tr>
                      <tr>
                        <td width="15%">Email ID <font color="#ff0000">*</font></td>
                        <td width="3%">&nbsp;</td>
                        <td width="82%"><div class="col-lg-6"><div class="form-group"> <span class="input">
                            <input type="text" class="form-control" id="email" name="email" value="<?php echo $row_edit_about['email'];?>" autocomplete="off">
                            </span></div>
                            <!-- /input-group -->
                          </div></td>
                      </tr>
                      <tr>
                        <td width="15%">Address <font color="#ff0000">*</font></td>
                        <td width="3%">&nbsp;</td>
                        <td width="82%"><div class="col-lg-6"><div class="form-group"> <span class="input">
                            <input type="text" class="form-control" id="address" name="address" value="<?php echo $row_edit_about['address'];?>" autocomplete="off">
                            </span></div>
                            <!-- /input-group -->
                          </div></td>
                      </tr>
                      <tr>
                        <td width="15%">User Type <font color="#ff0000">*</font></td>
                        <td width="3%">&nbsp;</td>
                        <td width="82%"><div class="col-lg-6">
                              <div class="form-group">
                              
                                <select class="form-control" name="type_id" id="type_id">
                                	<option value="">Select Type</option>
								 	<?php 
							  			$sql_select= "SELECT * FROM ".MEMBER_TYPE." WHERE type_id!='1'";
                                       $sql_query= mysqli_query($link,$sql_select);
                                       while($row= mysqli_fetch_array($sql_query))
										{
							  		?>
								 	<option value="<?php  echo $row['type_id']; ?>" <?php if($row['type_id']==$row_edit_about['type_id']) {echo "selected";}?>><?php  echo $row['member_type']; ?></option>
                                    <?php }?>
                                </select>
                    		   </div>
                            <!-- /input-group -->
                          </div></td>
                      </tr>
                      <tr>
                        <td width="15%">User Name <font color="#ff0000">*</font></td>
                        <td width="3%">&nbsp;</td>
                        <td width="82%"><div class="col-lg-6"><div class="form-group"> <span class="input">
                            <input type="text" class="form-control" id="username" name="username" value="<?php echo $row_edit_about['username'];?>" autocomplete="off">
                            </span></div>
                            <!-- /input-group -->
                          </div></td>
                      </tr>
                      <tr>
                        <td width="15%">Password <font color="#ff0000">*</font></td>
                        <td width="3%">&nbsp;</td>
                        <td width="82%"><div class="col-lg-6"><div class="form-group"> <span class="input">
                            <input type="text" class="form-control" id="password" name="password" value="<?php echo base64_decode($row_edit_about['password']);?>" autocomplete="off">
                            </span></div>
                            <!-- /input-group -->
                          </div></td>
                      </tr>
                      <tr>
                        <td width="15%">Confirm Password <font color="#ff0000">*</font></td>
                        <td width="3%">&nbsp;</td>
                        <td width="82%"><div class="col-lg-6"><div class="form-group"> <span class="input">
                            <input type="password" class="form-control" id="conf_pwd" name="conf_pwd" value="<?php echo base64_decode($row_edit_about['password']);?>" autocomplete="off">
                            </span></div>
                            <!-- /input-group -->
                          </div></td>
                      </tr>
                      <tr>
                        <td width="15%" height="31">Status <font color="#ff0000">*</font></td>
                        <td width="3%">&nbsp;</td>
                        <td width="82%"><div class="col-lg-6">
                          <div class="form-group">
                            <select class="form-control" name="status" id="status">
                                <option value="I"<?php if($row_edit_about['status']=='I') echo "selected";?>>Inactive</option>
                                <option value="A" <?php if($row_edit_about['status']=='A') echo "selected";?>>Active</option>
                            </select>
                           </div>
                        <!-- /input-group -->
                      </div></td>
                      </tr>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="3">
                        <input type="submit" value="Submit" class="btn btn-success"/>
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

function edit_about()
	{
	global $link;
	
		 $sql_inset_post="UPDATE ".LOGIN_MASTER." 
                    SET 
					fname = '".ConvertRealString($_REQUEST['fname'])."',
					lname = '".ConvertRealString($_REQUEST['lname'])."',
					email = '".ConvertRealString($_REQUEST['email'])."',
					username = '".ConvertRealString($_REQUEST['username'])."',
					type_id = '".ConvertRealString($_REQUEST['type_id'])."',
					status = '".ConvertRealString($_REQUEST['status'])."',
					password = '".base64_encode(ConvertRealString($_POST['password']))."',
					address='".ConvertRealString($_REQUEST['address'])."',
					mobile_no='".ConvertRealString($_REQUEST['mobile_no'])."'
					
                    where login_id='".$_REQUEST['id']."'";
			
		$qry_inset_post	=mysqli_query($link,$sql_inset_post) or die(mysqli_error($link));
			
	    
	if($qry_inset_post)
		{
		$_SESSION['MSG_ALERT'] = "Latest User Profile updated successfully";
		$_SESSION['IMG_PATH'] ="fa-check";
		$_SESSION['DIV_CLASS'] ="alert-success"; 
		 redirect_cp('admin_users');
		exit();
		
	}
	else
	{
	    $_SESSION['MSG_ALERT'] = "Latest Information already exist";
		$_SESSION['IMG_PATH'] ="fa-exclamation-triangle";
		$_SESSION['DIV_CLASS'] = "alert-warning";
		redirect_cp('admin_users');
		exit();
	}
		
	}
 ?>
<script type="text/javascript">
	$(document).ready(function () {
	  
//--------------------------------- Insert validation   ---------------------------------
		
	  	$('#add_frm').validate({
		rules: {
		  fname: 'required',
		  lname: 'required',
		  mobile_no: 'required number',
		  email:{
			  required: true,
			  email:true
		  },
		  address: 'required',
		  type_id: 'required',
		  username: {
            required: true,
            rangelength: [4, 8]
		  },
		  password: {
            required: true,
            rangelength: [4, 8],
			checklower: true,
			checkupper: true,
			checkdigit: true
		  },
		  conf_pwd: {
			  required: true,
			  equalTo: "#password"
		  },
		  status: 'required'
		},
		messages: {
			fname: "Please enter first name...!",
			lname: "Please enter last name...!",
			mobile_no: "Please enter mobile number...!",
			email: {
				required: "Please enter a email address"
			},
			address: "Please enter address...!",
			type_id: "Please select a user type...!",
			username: {
			  required: "Please enter user name...!",
			  rangelength: "Your username at least 4 to 8 characters long"
			},
			password: {
			  required: "Please enter password...!",
			  rangelength: "Your password at least 4 to 8 characters long",
			  checklower: "Need atleast 1 lowercase alphabet",
			  checkupper: "Need atleast 1 uppercase alphabet",
			  checkdigit: "Need atleast 1 digit"
			},
			conf_pwd: {
			  required: "Please enter confirm password...!",
			  equalTo: "Please enter the same password as above"
	
			},
			status: "Please select a Status...!"
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
            form.submit();
        }
	  });
		
//--------------------------------- Edit validation   ---------------------------------
		$('#edit_frm').validate({
		rules: {
		  fname: 'required',
		  lname: 'required',
		  mobile_no: 'required number',
		  email:{
			  required: true,
			  email:true
		  },
		  address: 'required',
		  type_id: 'required',
		  username: {
            required: true,
            rangelength: [4, 20]
		  },
		  password: {
            required: true,
            rangelength: [4, 20],
			checklower: true,
			checkupper: true,
			checkdigit: true
		  },
		  conf_pwd: {
			  required: true,
			  equalTo: "#password"
		  },
		  status: 'required'
		},
		messages: {
			fname: "Please enter first name...!",
			lname: "Please enter last name...!",
			mobile_no: "Please enter mobile number...!",
			email: {
				required: "Please enter a email address"
			},
			address: "Please enter address...!",
			type_id: "Please select a user type...!",
			username: {
			  required: "Please enter user name...!",
			  rangelength: "Your username at least 4 to 20 characters long"
			},
			password: {
			  required: "Please enter password...!",
			  rangelength: "Your password at least 4 to 20 characters long",
			  checklower: "Need atleast 1 lowercase alphabet",
			  checkupper: "Need atleast 1 uppercase alphabet",
			  checkdigit: "Need atleast 1 digit"
			},
			conf_pwd: {
			  required: "Please enter confirm password...!",
			  equalTo: "Please enter the same password as above"
	
			},
			status: "Please select a Status...!"
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
            form.submit();
        }
	  });
	});
	
</script>