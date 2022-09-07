<?php
ob_start();
require("../template.php");
if($_SESSION['admin_user_id']=='')					redirect('index');
require_once("../authonication.php");
if(isset($_POST['mode']))
{
if($_POST['mode']=='insert_about') 			insert_about();
if($_POST['mode']=='delete_about')			delete_about();
if($_POST['mode']=='change_status_about')	change_status_about();
if($_POST['mode']=='delete_chk_about')		delete_chk_about();
if($_POST['mode']=='active_chk_about')		active_chk_about();
if($_POST['mode']=='inactive_chk_about')		inactive_chk_about();
if($_POST['mode']=='edit_about')				edit_about();
if($_POST['mode']=='update_position')				update_position();
if($_POST['mode']=='change_position')				change_position();

if($_POST['mode']=='view')						disphtml("view();");
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
		
$sql_list_about = "SELECT * FROM ".MEMBER_TYPE."  WHERE 1 AND status!='D' AND type_id!='1' ORDER BY type_id desc";	
$qry_list_about = mysqli_query($link,$sql_list_about);
$num_list_about = mysqli_num_rows($qry_list_about);


$countShow="SELECT count(*) FROM ".MEMBER_TYPE."  WHERE 1 AND status!='D' AND type_id!='1' ORDER BY type_id desc";
$qry_countshow=mysqli_query($link,$countShow) or die(mysqli_error($link));
$count=mysqli_num_rows($qry_countshow);
?>
<div id="page-wrapper">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12 breadcrumb-header"><div id="breadcrumb" class="tooltip-demo"> <a href="<?=URL?>" title="Go to Home" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-home fa-fw"></i> Home</a><a href="#" class="current">Acess</a></div>
      </div>
    </div>
    <!-- /.row -->
    <div class="row">
      <div class="col-lg-12">
        <div class="panel tabbed-panel panel-success">
          <div class="panel-heading clearfix">
            <div class="panel-title pull-left"><a data-toggle="collapse" href="#collapseOne" aria-expanded="false"><strong>Acess Details</strong></a></div>
            <div class="pull-right">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#tab-success-1" data-toggle="tab">Member List</a></li>
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
                            <th width="10">#</th>
                            <th width="40">Sl no.</th>
                            <th>Member Type</th>
                            <th>Status</th>
                            <th style="text-align: center;">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
				   if($num_list_about > 0)
					{
					?>
                          <?php  
					$cnt=$GLOBALS['start']+1;
					while($row_list_about=mysqli_fetch_array($qry_list_about))
						{
					?>
                          <tr>
                            <td>
                            <?php if($row_list_about['type_id']!=3){?>
                            <input class="cheak_all" type="checkbox" id="public_chkbox" name="public_chkbox[]"value="<?php  echo $row_list_about['type_id']; ?>" autocomplete="off">
                            <?php }?>
                            </td>
                            <td><?php  echo $cnt++?></td>
                            <td><?php  echo $row_list_about['member_type']; ?></td>
                            <td><?php if(stripslashes($row_list_about['status'])=='A'){?>
                              <span class="btn btn-success btn-xs">Active</span>
                              <?php }else{?>
                              <span class="btn btn-danger btn-xs">Inactive</span>
                              <?php }?></td>
                            <td class="text-center tooltip-demo"><a title="Edit" data-toggle="tooltip" data-placement="bottom" href="javascript:Edit('<?php  echo $row_list_about['type_id']?>','','2');" class="btn btn-info btn-circle"><i class="fa fa-edit fa-fw"></i></a>
                            
                            <?php if($row_list_about['type_id']!=3){?>
                            <!-- <a title="Delete" data-toggle="tooltip" data-placement="bottom" href="javascript:Delete('<?php  echo $row_list_about['type_id']?>','<?php  echo $GLOBALS['start']?>');" class="btn btn-danger btn-circle"><i class="fa fa-trash fa-fw"></i></a>-->
                             <?php }?></td>
                          </tr>
                          <?php }}?>
                        </tbody>
                      </table>
                      <div class="col-lg-2" id="on_option" style="display:none;width: 19% !important;">
                        <div class="row" style="display: flex;">
                          <select class="form-control" name="choose_action" id="choose_action">
                            <option value="0">Choose action</option>
                           <!-- <option value="D">Delete</option>-->
                            <option value="A">Active</option>
                            <option value="I">Inactive</option>
                          </select>&nbsp;
                          <button type="button" class="btn btn-success btn-sm" onclick="return delete_chk_about();">Apply</button>
                        </div>
                      </div>
                    <!-- /.table-responsive -->
                    </div>
                  </form>
                </div>
              </div>
              <script language="javascript">
function Delete(ID,record_no)
{

	
	var UserResp = window.confirm("Are you sure to delete this Member?");
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
                  <form action="<?php  echo $_SERVER['PHP_SELF']?>" method="post" name="add_frm" id="add_frm"  enctype="multipart/form-data">
                    <input type="hidden" name="mode" value="insert_about">
                    <table width="100%" align="center">
                      <tbody>
                        <tr>
                        <td colspan="8">(<font color="#ff0000">All * mark fields are mandatory</font>)</td>
                      </tr>
                        <tr>
                          <td colspan="2" align="left">Member Type<font color="#ff0000">*</font></td>
                          <td width="4%">&nbsp;</td>
                          <td colspan="5" width="78%" align="left"><div class="col-lg-6">
                              <div class="form-group"> <span class="input">
                                <input type="text" class="form-control" id="member_type" name="member_type" autocomplete="off" placeholder="Enter member type">
                                </span></div>
                              <!-- /input-group --> 
                            </div></td>
                        </tr>
                        <tr>
                        	<td colspan="8" style="color:#C9F;;padding:1rem;border-bottom: 1px solid;"><strong><i class="fa fa-chevron-right fa-fw"></i> Please any field checked for acess menu to your new member.</strong></td>
                        </tr>
                        <tr>
                          <?php 
$sql_select= "SELECT * FROM ".MENU_MASTER."  where  menu_id ='0' AND submenu_id !=1 AND status='A' ORDER BY order_by asc";
$sql_query= mysqli_query($link,$sql_select);
$sql_row=mysqli_num_rows($sql_query);
if($sql_row>0){
$i=0;
while($row= mysqli_fetch_array($sql_query)){
?>
                          <td width="20%" colspan="2" valign="top" align="left" style="padding: 10px;;border-left: 1px solid;border-bottom: 1px solid;border-right: 1px solid;"><b style="border-bottom: 1px solid;">
                            <?php  echo $row['menuLabel'];?>
                            </b><br>
                            <?php 
					$sql_select_sub= "SELECT * FROM ".MENU_MASTER."  where menu_id =".$row['submenu_id']." AND status='A' ORDER BY order_by asc";
					$sql_query_sub= mysqli_query($link,$sql_select_sub);
					$sql_row_sub=mysqli_num_rows($sql_query_sub);
					if($sql_row_sub>0){
					while($row_sub= mysqli_fetch_array($sql_query_sub)){
					?>
                            <input type="checkbox" name="public_chkbox[]" id="public_chkbox" value="<?php  echo $row_sub['submenu_id'];?>" autocomplete="off">
                            &nbsp;
                            <?php  echo $row_sub['menuLabel'];?>
                            <br>
                            <?php }}?></td>
                          <?php $i++;
					if($i % 4 == 0)
					{
						echo '</tr><tr>';
					} }}?>
                        </tr>
                        <tr>
                          <td colspan="8">&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="8">
                            <input type="hidden" name="id" value="">
                            <input type="hidden" name="hold_page" value="">
                            <input type="submit" value="Submit" class="btn btn-success">
                            <a href="admin_acess.php" class="btn btn-default">Cancel</a>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    
                  </form>
                </div>
              </div>
            </div>
            <!-- /.card --> 
          </div>
        </div>
      </div>
    </div>
    <!-- /.row --> 
  </div>
</div>
<?php  }

function insert_about(){
	global $link;
	
		 $sql_check_category="select * from ".MEMBER_TYPE." where member_type='".$_REQUEST['member_type']."'";	
		$qry_check_category=mysqli_query($link,$sql_check_category) or die(mysqli_error());
		$num_check_category=mysqli_num_rows($qry_check_category);
		if($num_check_category==0)
			{
				$sql_inset_post="INSERT INTO ".MEMBER_TYPE." 	
					SET 	
					member_type='".ConvertRealString($_REQUEST['member_type'])."'";	
					
				$qry_inset_post	=mysqli_query($link,$sql_inset_post);
				$last_id = mysqli_insert_id($link);
				
				$count_acess=count($_REQUEST['public_chkbox']);
				for($i=0; $i<$count_acess; $i++){
					$sql_inset="INSERT INTO ".PRIVILEGES." 	
					SET 	
					type_id='".$last_id."', 	 	
					submenu_id='".$_REQUEST['public_chkbox'][$i]."'";	
					
					$qry_inset	=mysqli_query($link,$sql_inset);
					}
				
				$_SESSION['MSG_ALERT'] = "Latest member type inserted successfully";
				$_SESSION['IMG_PATH'] ="fa-check"; 
				$_SESSION['DIV_CLASS'] ="alert-success"; 
				
				redirect_cp('admin_acess');
				exit();
		}else{
			$_SESSION['MSG_ALERT'] = "Latest Information already exist";
			$_SESSION['IMG_PATH'] ="fa-exclamation-triangle";
			$_SESSION['DIV_CLASS'] = "alert-warning";			
			 redirect_cp('admin_acess');
			 exit();
		}
	
			
}

function delete_about()
{

global $link;
		$sql_delete_about= "UPDATE ".MEMBER_TYPE." 
                    SET 
					status= 'D'
                    where type_id='".$_REQUEST['id']."'";   
		$qry_delete_about=mysqli_query($link,$sql_delete_about) or die(mysqli_error());
		
		$_SESSION['MSG_ALERT'] = "Latest member type has been successfully deleted.";
		$_SESSION['IMG_PATH'] ="fa-ban"; 
		$_SESSION['DIV_CLASS'] ="alert-danger"; 
		redirect_cp('admin_acess');
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
					
							$sql_deletepublication = "UPDATE ".MEMBER_TYPE." 
											SET 
											status= 'D'
											where type_id='".$val."'";
					
					$qry_deletepublication	=mysqli_query($link,$sql_deletepublication) or die(mysqli_error($link));
							
							$count_del++;
							
					}
				}
				
				if($count_del > 0)
				{
				$_SESSION['MSG_ALERT'] = "Successfully deleted.";
				$_SESSION['IMG_PATH'] ="fa-ban"; 
				$_SESSION['DIV_CLASS'] ="alert-danger"; 
				redirect_cp('admin_acess');
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
					$sql_deletepublication = "UPDATE ".MEMBER_TYPE." 
											SET 
											status= 'A'
											where type_id='".$val."'";
					
					$qry_deletepublication	=mysqli_query($link,$sql_deletepublication) or die(mysqli_error($link));
							
							$count_del++;
							
					}
				}
				
				if($count_del > 0)
				{
				$_SESSION['MSG_ALERT'] = "Updated successfull";
				$_SESSION['IMG_PATH'] ="fa-check";
				$_SESSION['DIV_CLASS'] ="alert-success"; 
				redirect_cp('admin_acess');
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
					$sql_deletepublication = "UPDATE ".MEMBER_TYPE." 
											  SET 
											  status= 'I'
											  where type_id='".$val."'";
					
					$qry_deletepublication	=mysqli_query($link,$sql_deletepublication) or die(mysqli_error($link));
							
							$count_del++;
							
					}
				}
				
				if($count_del > 0)
				{
				$_SESSION['MSG_ALERT'] = "Updated successfully";
				$_SESSION['IMG_PATH'] ="fa-check";
				$_SESSION['DIV_CLASS'] ="alert-success"; 
				redirect_cp('admin_acess');
				exit();
				}
}


?>
<?php
function edit(){
global $link;
$sql_edit_about = "SELECT * FROM ".MEMBER_TYPE."  where type_id ='".$_REQUEST['id']."'";
$qry_edit_about = mysqli_query($link,$sql_edit_about) or die(mysqli_error());
$row_edit_about = mysqli_fetch_array($qry_edit_about);

?>
<div id="page-wrapper">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12 breadcrumb-header"><div id="breadcrumb" class="tooltip-demo"> <a href="<?=URL?>" title="Go to Home" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-home fa-fw"></i> Home</a><a href="<?php echo $_SERVER['PHP_SELF']?>">Acess</a><a href="#" class="current">Edit</a></div>
      </div>
    </div>
    <!-- /.row -->
    <div class="row">
      <div class="col-lg-12">
        <div class="panel tabbed-panel panel-success">
          <div class="panel-heading clearfix">
            <div class="panel-title pull-left"><a data-toggle="collapse" href="#collapseOne" aria-expanded="false"><strong><i class="fa fa-edit fa-fw"></i> Edit Acess</strong></a></div>
          </div>
          <div class="panel-body" id="collapseOne" aria-expanded="true" style="background: #eef9f0;margin: 1em;border-radius: 4px;">
            <div class="panel-body">
              <form action="<?php echo  $_SERVER['PHP_SELF']?>" method="post" name="edit_frm" id="edit_frm"enctype="multipart/form-data">
                <input type="hidden" name="mode" value="edit_about">
                <input type="hidden" name="id" value="<?php  echo $_REQUEST['id']?>">
                <input type="hidden" name="prv_name" value="<?php echo $row_edit_about['member_type']; ?>">
                <table width="100%">
                  <tbody>
                    <tr>
                      <td colspan="8"><!--(<font color="#ff0000">All * mark fields are mandatory</font>)--></td>
                    </tr>
                    <tr>
                      <td colspan="2" align="left">Type Name<font color="#ff0000">*</font></td>
                      <td width="2%">&nbsp;</td>
                      <td colspan="5" width="76%" align="left"><div class="col-lg-6">
                          <div class="form-group"> <span class="input">
                            <input type="text" class="form-control" id="member_type" name="member_type" autocomplete="off" value="<?php echo $row_edit_about['member_type']; ?>">
                            </span></div>
                          <!-- /input-group --> 
                        </div></td>
                    </tr>
                    <tr>
                        	<td colspan="8" style="color:#C9F;;padding:1rem;border-bottom: 1px solid;"><strong><i class="fa fa-chevron-right fa-fw"></i> Please checked for acess menu to your existing member.</strong></td>
                        </tr>
                    <tr>
                      <?php 
$sql_select_edit= "SELECT * FROM ".MENU_MASTER."  where menu_id ='0' AND submenu_id !=1 AND status='A' ORDER BY order_by asc";
$sql_query_edit= mysqli_query($link,$sql_select_edit);
$sql_row_edit=mysqli_num_rows($sql_query_edit);
if($sql_row_edit>0){
$i=0;
while($row_edit= mysqli_fetch_array($sql_query_edit)){
?>
                      <td width="20%" colspan="2" valign="top" align="left" style="padding: 10px;;border-left: 1px solid;border-bottom: 1px solid;border-right: 1px solid;"><b>
                        <?php  echo $row_edit['menuLabel'];?>
                        </b><br>
                        <?php 
					$sql_select_sub_edit= "SELECT * FROM ".MENU_MASTER."  where menu_id =".$row_edit['submenu_id']." AND status='A' ORDER BY order_by asc";
					$sql_query_sub_edit= mysqli_query($link,$sql_select_sub_edit);
					$sql_row_sub_edit=mysqli_num_rows($sql_query_sub_edit);
					if($sql_row_sub_edit>0){
					while($row_sub_edit= mysqli_fetch_array($sql_query_sub_edit)){
					?>
                        <input type="checkbox" name="public_chkbox[]" id="public_chkbox" value="<?php  echo $row_sub_edit['submenu_id'];?>" autocomplete="off" <?php if(!privliges_check($_REQUEST['id'],$row_sub_edit['submenu_id'])) { ?> checked="checked" <?php } ?>>
                        &nbsp;
                        <?php  echo $row_sub_edit['menuLabel'];?>
                        <br>
                        <?php }}?></td>
                      <?php $i++;
					if($i % 4 == 0)
					{
						echo '</tr><tr>';
					} }}?>
                    </tr>
                    <tr>
                      <td colspan="8">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="8">
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
$sql_check_category="select * from ".MEMBER_TYPE." where member_type='".$_REQUEST['member_type']."' AND member_type!='".$_REQUEST['prv_name']."' AND status!='D'";

$qry_check_category=mysqli_query($link,$sql_check_category) or die(mysqli_error());
$num_check_category=mysqli_num_rows($qry_check_category);
if($num_check_category==0)
	{
	$sql_check_categoryE="DELETE from ".PRIVILEGES." where type_id='".$_REQUEST['id']."'";	
	$qry_check_categoryE=mysqli_query($link,$sql_check_categoryE) or die(mysqli_error());
		
			$sql_edit_about= "UPDATE ".MEMBER_TYPE." 
                    SET 
					member_type= '".ConvertRealString($_REQUEST['member_type'])."'
                    where type_id='".$_REQUEST['id']."'";   
			$qry_edit_about=mysqli_query($link,$sql_edit_about) or die(mysqli_error());
		
				$count_acess=count($_REQUEST['public_chkbox']);
				for($i=0; $i<$count_acess; $i++){
					$sql_inset_edit="INSERT INTO ".PRIVILEGES." 	
					SET 	
					type_id='".$_REQUEST['id']."', 	 	
					submenu_id='".$_REQUEST['public_chkbox'][$i]."'";	
					
					$qry_inset_edit	=mysqli_query($link,$sql_inset_edit);
					}
				
				$_SESSION['MSG_ALERT'] = "Latest member type update successfully";
				$_SESSION['IMG_PATH'] ="fa-check"; 
				$_SESSION['DIV_CLASS'] ="alert-success"; 
				
				redirect_cp('admin_acess');
				exit();
			}else{
		$_SESSION['MSG_ALERT'] = "Latest Information already exist";
		$_SESSION['IMG_PATH'] ="fa-exclamation-triangle";
		$_SESSION['DIV_CLASS'] = "alert-warning";			
		 redirect_cp('admin_acess');
		 exit();
	}
		
	}
 ?>
<script type="text/javascript">
	
	$(document).ready(function () {
		
		//--------------------------------- Insert validation   ---------------------------------
		
		$('#add_frm').validate({
		rules: {
		  member_type: 'required'
		},
		messages: {
			member_type: "Please enter a member type...!"
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
		
		
//--------------------------------- Edit validation   ---------------------------------
		 $('#edit_frm').validate({
		rules: {
		  member_type: 'required'
		},
		messages: {
			member_type: "Please enter a member type...!"
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
	});
	
</script>