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
	 $con='';
	if(isset($_REQUEST['scarch_main_title'])){
		$product=$_REQUEST['scarch_main_title'];
		$con=" and main_title_id=".$product."";
	}	
$sql_list_about = "SELECT * FROM ".DB_IDEA_CRETED."  WHERE 1 ".$con." AND status!='D' ORDER BY id DESC";	
$qry_list_about = mysqli_query($link,$sql_list_about);
$num_list_about = mysqli_num_rows($qry_list_about);


$countShow="SELECT count(*) FROM ".DB_IDEA_CRETED."  WHERE 1 ".$con." AND status!='D' ORDER BY id DESC";
$qry_countshow=mysqli_query($link,$countShow) or die(mysqli_error($link));
$count=mysqli_num_rows($qry_countshow);
?>
<div id="page-wrapper">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12 breadcrumb-header">
        <div id="breadcrumb" class="tooltip-demo"> <a href="<?=URL?>" title="Go to Home" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-home fa-fw"></i> Home</a><a href="#" class="current">Publishing people</a></div>
      </div>
    </div>
    <!-- /.row -->
    <div class="row">
      <div class="col-lg-12">
        <div class="panel tabbed-panel panel-success">
          <div class="panel-heading clearfix">
            <div class="panel-title pull-left"><a data-toggle="collapse" href="#collapseOne" aria-expanded="false"><strong>Publishing people Details</strong></a></div>
            <div class="pull-right">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#tab-success-1" data-toggle="tab">Data List</a></li>
                <!--<li><a href="#tab-success-2" data-toggle="tab">Add New</a></li>-->
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
              <div class="tab-pane fade in active" id="tab-success-1">
                <div class="panel-body">
                  <form name="frm_chk_about" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                    <input type="hidden" name="mode" value="" />
                    <div class="table-responsive">
                      <table id="export_contact" class="table table-striped table-bordered">
                        <thead>
                          <tr>
                            <th width="10">#</th>
                            <th>Company Name</th>
                            <th>Email</th>
                            <th>Phone</th>
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
                            <td><input class="cheak_all" type="checkbox" id="public_chkbox" name="public_chkbox[]"value="<?php  echo $row_list_about['id']; ?>" autocomplete="off"></td>
                            <td><?php  echo $row_list_about['company_name']; ?></td>
                            <td><?php  echo $row_list_about['email']; ?></td>
                            <td><?php  echo $row_list_about['contact_no']; ?></td>
                            <td><?php if(stripslashes($row_list_about['status'])=='A'){?>
                              <span class="btn btn-success btn-xs">Active</span>
                              <?php }else{?>
                              <span class="btn btn-danger btn-xs">Inactive</span>
                              <?php }?></td>
                            <td class="tooltip-demo"><a title="View" data-toggle="tooltip" data-placement="bottom" href="javascript:Edit('<?php  echo $row_list_about['id']?>','<?php  echo $GLOBALS['start']?>');" class="btn btn-info btn-circle"><i class="fa fa-eye fa-fw"></i></a> <a title="Delete" data-toggle="tooltip" data-placement="bottom" href="javascript:Delete('<?php  echo $row_list_about['id']?>','<?php  echo $GLOBALS['start']?>');" class="btn btn-danger btn-circle"><i class="fa fa-trash fa-fw"></i></a></td>
                          </tr>
                          <?php }}?>
                        </tbody>
                      </table>
                      <div class="col-lg-2" id="on_option" style="display:none;">
                        <div class="row" style="display: flex;">
                          <select class="form-control" name="choose_action" id="choose_action">
                            <option value="0">Choose action</option>
                            <option value="D">Delete</option>
                            <option value="A">Active</option>
                            <option value="I">Inactive</option>
                          </select>
                          &nbsp;
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
	var UserResp = window.confirm("Are you sure to delete this Publishing people?");
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
                  <form action="" method="post" name="add_frm" id="add_frm" enctype="multipart/form-data" novalidate="novalidate">
                    <input type="hidden" name="mode" value="insert_about">
                    <div class="table-responsive">
                      <table width="100%">
                        <tbody>
                          <tr>
                            <td colspan="3">(<font color="#ff0000">All * mark fields are mandatory</font>)</td>
                          </tr>
                          <tr>
                            <td colspan="3">&nbsp;</td>
                          </tr>                                          
                          <tr>
                            <td width="15%"> Company Name <font color="#ff0000">*</font></td>
                            <td width="3%">&nbsp;</td>
                            <td width="87%"><div class="col-lg-6">
                                <div class="form-group"> <span class="input">
                                  <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Enter company name" autocomplete="off">
                                  </span></div>
                                <!-- /input-group --> 
                              </div></td>
                          </tr>
                          <tr>
                            <td width="15%">Contact No <font color="#ff0000">*</font></td>
                            <td width="3%">&nbsp;</td>
                            <td width="87%"><div class="col-lg-6">
                                <div class="form-group">
                                  <input type="text" class="form-control" id="contact_no" name="contact_no"placeholder="Enter Mobile" autocomplete="off">
                                </div>
                                <!-- /input-group --> 
                              </div></td>
                          </tr>
                          <tr>
                            <td width="15%">Email <font color="#ff0000">*</font></td>
                            <td width="3%">&nbsp;</td>
                            <td width="87%"><div class="col-lg-6">
                                <div class="form-group">
                                  <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" autocomplete="off">
                                </div>
                                <!-- /input-group --> 
                              </div></td>
                          </tr>                          
                          <tr>
                            <td width="15%">Message <font color="#ff0000">*</font></td>
                            <td width="3%">&nbsp;</td>
                            <td width="87%"><div class="col-lg-6">
                                <div class="form-group">
                                  <textarea id="myTextarea" name="message" class="form-control" placeholder="Enter Description"></textarea>
                                </div>
                              </div></td>
                          </tr> 
                          <tr>
                            <td colspan="3">&nbsp;</td>
                          </tr>
                          <tr>
                            <td colspan="3"><input type="hidden" name="id" value="">
                              <input type="hidden" name="hold_page" value="">
                              <input type="submit" value="Submit" class="btn btn-success">
                              <a href="manamge_collaborat_people.php" class="btn btn-default">Cancel</a></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
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
		
	 $sql_inset_post="INSERT INTO ".DB_IDEA_CRETED." 

		SET 
		company_name	= '".ConvertRealString(ucwords($_REQUEST['company_name']))."',
		contact_no		= '".ConvertRealString($_REQUEST['contact_no'])."',
		email 			= '".ConvertRealString($_REQUEST['email'])."',
		message			= '".addslashes(nl2br($_REQUEST['message']))."'";

	$qry_inset_post	=mysqli_query($link,$sql_inset_post);	

		

		$_SESSION['MSG_ALERT'] = "Latest Information inserted successfully";
		$_SESSION['IMG_PATH'] ="fa-check"; 
		$_SESSION['DIV_CLASS'] ="alert-success"; 
		
		 redirect_mp('manamge_collaborat_people');
	exit();
			
}

function delete_about()
{

global $link;
		$sql_delete_about= "UPDATE ".DB_IDEA_CRETED." 
                    SET 
					status= 'D'
                    where id='".$_REQUEST['id']."'";   
		$qry_delete_about=mysqli_query($link,$sql_delete_about) or die(mysqli_error());
		
		$_SESSION['MSG_ALERT'] = "Latest member has been successfully deleted.";
		$_SESSION['IMG_PATH'] ="fa-ban"; 
		$_SESSION['DIV_CLASS'] ="alert-danger"; 
		redirect_mp('manamge_collaborat_people');
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
					
							$sql_deletepublication = "UPDATE ".DB_IDEA_CRETED." 
											SET 
											status= 'D'
											where id='".$val."'";
					
					$qry_deletepublication	=mysqli_query($link,$sql_deletepublication) or die(mysqli_error($link));
							
							$count_del++;
							
					}
				}
				
				if($count_del > 0)
				{
				$_SESSION['MSG_ALERT'] = "Successfully deleted.";
				$_SESSION['IMG_PATH'] ="fa-ban"; 
				$_SESSION['DIV_CLASS'] ="alert-danger"; 
				redirect_mp('manamge_collaborat_people');
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
					$sql_deletepublication = "UPDATE ".DB_IDEA_CRETED." 
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
				redirect_mp('manamge_collaborat_people');
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
					$sql_deletepublication = "UPDATE ".DB_IDEA_CRETED." 
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
				redirect_mp('manamge_collaborat_people');
				exit();
				}
}


?>
<?php
function edit(){
	
	global $link;
$sql_edit_about = "SELECT * FROM ".DB_IDEA_CRETED."  where id ='".$_REQUEST['id']."'";
$qry_edit_about = mysqli_query($link,$sql_edit_about) or die(mysqli_error());
$row_edit_about = mysqli_fetch_array($qry_edit_about);

?>
<div id="page-wrapper">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12 breadcrumb-header">
        <div id="breadcrumb" class="tooltip-demo"> <a href="<?=URL?>" title="Go to Home" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-home fa-fw"></i> Home</a><a href="<?=$_SERVER['PHP_SELF']?>">Publishing people</a><a href="#" class="current">View</a></div>
      </div>
    </div>
    <!-- /.row -->
    <div class="row">
      <div class="col-lg-12">
        <div class="panel tabbed-panel panel-success">
          <div class="panel-heading clearfix">
            <div class="panel-title pull-left"><a data-toggle="collapse" href="#collapseOne" aria-expanded="false"><strong><i class="fa fa-eye fa-fw"></i> View Publishing people</strong></a></div>
          </div>
          <div class="panel-body" id="collapseOne" aria-expanded="true" style="background: #eef9f0;margin: 1em;border-radius: 4px;">
            <div class="panel-body">
              <form action="<?php echo  $_SERVER['PHP_SELF']?>" method="post" name="edit_frm" id="edit_frm"enctype="multipart/form-data">
                <input type="hidden" name="mode" value="edit_about">
                <input type="hidden" name="id" value="<?php  echo $_REQUEST['id']?>">
                <div class="table-responsive">
                  <table width="100%">
                    <tbody>
                      <tr>
                        <td colspan="3"><!--(<font color="#ff0000">All * mark fields are mandatory</font>)--></td>
                      </tr>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                      </tr>                      
                      <tr>
                        <td width="15%">Contact Date</td>
                        <td width="3%">&nbsp;</td>
                        <td width="87%"><div class="col-lg-6">
                            <div class="form-group"> <span class="input">
                              : <?php echo $row_edit_about['date_time'];?>
                              </span></div>
                            <!-- /input-group --> 
                          </div></td>
                      </tr>                   
                      <tr>
                        <td width="15%"> Name of Company/Educational Institute</td>
                        <td width="3%">&nbsp;</td>
                        <td width="87%"><div class="col-lg-6">
                            <div class="form-group"> <span class="input">
                             : <?php echo $row_edit_about['company_name'];?>
                              </span></div>
                            <!-- /input-group --> 
                          </div></td>
                      </tr>
                      <tr>
                        <td width="15%">Email</td>
                        <td width="3%">&nbsp;</td>
                        <td width="87%"><div class="col-lg-6">
                            <div class="form-group">
                              : <?php echo $row_edit_about['email'];?>
                            </div>
                            <!-- /input-group --> 
                          </div></td>
                      </tr>
                      <tr>
                        <td width="15%">Contact No</td>
                        <td width="3%">&nbsp;</td>
                        <td width="87%"><div class="col-lg-6">
                            <div class="form-group">
                              : <?php echo $row_edit_about['contact_no'];?>
                            </div>
                            <!-- /input-group --> 
                          </div></td>
                      </tr>
                      <tr>
                        <td width="15%">Project Brief</td>
                        <td width="3%">&nbsp;</td>
                        <td width="87%"><div class="col-lg-6">
                            <div class="form-group">
                              : <?php echo stripslashes(($row_edit_about['description']));?>
                            </div>
                            <!-- /input-group --> 
                          </div></td>
                      </tr>               
                      <tr>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="3">
                        	<!--<input type="submit" value="Submit" class="btn btn-success"/>-->
                          <a href="javascript:history.back()" class="btn btn-default">Back</a></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
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
	
			 $sql_inset_post="UPDATE ".DB_IDEA_CRETED." 
                    SET
					company_name	= '".ConvertRealString(ucwords($_REQUEST['company_name']))."',
					contact_no		= '".ConvertRealString($_REQUEST['contact_no'])."',
					email 			= '".ConvertRealString($_REQUEST['email'])."',
					message			= '".addslashes(nl2br($_REQUEST['message']))."'
					
                    where id='".$_REQUEST['id']."'";
		$qry_inset_post	=mysqli_query($link,$sql_inset_post) or die(mysqli_error($link));
			
	    
	if($qry_inset_post)
		{
		$_SESSION['MSG_ALERT'] = "Latest Information updated successfully";
		$_SESSION['IMG_PATH'] ="fa-check";
		$_SESSION['DIV_CLASS'] ="alert-success"; 
		redirect_mp('manamge_collaborat_people');
		
		exit();	
	}
	else
	{
	    $_SESSION['MSG_ALERT'] = "Latest Information already exist";
		$_SESSION['IMG_PATH'] ="fa-exclamation-triangle";
		$_SESSION['DIV_CLASS'] = "alert-warning";
		redirect_mp('manamge_collaborat_people');
	}
		
	}
 ?>
<script type="text/javascript">
	$(document).ready(function () {
	$('#export_contact').DataTable({
			"processing": true,
			"dom": "<'row'<'col-sm-2'l><'col-sm-6'B><'col-sm-4'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>",
			"buttons": [
				{
					extend: 'collection',
					text: 'Export To&nbsp; <b class="caret"></b>',
					buttons: [{
					  extend: 'pdf',
					  exportOptions : {
					   columns : [ 1, 2, 3, 4],
					   search: 'applied',
					   order: 'applied'
					  },
					  title: '<?=SITETITLE?> Contact',
					  filename: '<?=SITETITLE?>-Contact'
					}, {
					  extend: 'excel',
					  exportOptions : {
					   columns : [ 1, 2, 3, 4]
					  },
					  title: '<?=SITETITLE?> Contact',
					  filename: '<?=SITETITLE?>-Contact'
					}, {
					  extend: 'csv',
					  exportOptions : {
					   columns : [ 1, 2, 3, 4]
					  },
					  title: '<?=SITETITLE?> Contact',
					  filename: '<?=SITETITLE?>-Contact'
					}, {
					  extend: 'print',
					  text: 'Print',
					  title: '<?=SITETITLE?> Contact',
					  filename: '<?=SITETITLE?>-Contact',
					  exportOptions : {
					   columns : [ 1, 2, 3, 4]
					  },
					  customize: function(win) {
						  $(win.document.body)
							.prepend(
								'<img src="<?php echo BASE_URL.'uploads/admin/'.get_siteconfig('logo'); ?>" style="position:absolute; top:0; left:0;width:100px;" />'
							);
							$(win.document.body).find('table')
								.css('margin-top', '100pt');
							}
					},]
				}
			],
	  lengthMenu:[
		[10,25,50,100,-1],
		[10,25,50,100,"All"]
	  ]
	});
});
</script>