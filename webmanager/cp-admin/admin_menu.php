<?php
ob_start();
require("../template.php");
if($_SESSION['admin_user_id']=='')					redirect('index');
require_once("../authonication.php");
if(isset($_REQUEST['mode']))
{
if($_REQUEST['mode']=='insert_menu') 			insert_menu();
if($_REQUEST['mode']=='insert_submenu')		insert_submenu();
if($_REQUEST['mode']=='Delete_Sub')				Delete_Sub();
if($_REQUEST['mode']=='delete_about')			delete_about();
if($_REQUEST['mode']=='change_status_about')	change_status_about();
if($_REQUEST['mode']=='delete_chk_about')		delete_chk_about();
if($_REQUEST['mode']=='active_chk_about')		active_chk_about();
if($_REQUEST['mode']=='inactive_chk_about')		inactive_chk_about();
if($_REQUEST['mode']=='edit_about')				edit_about();

if($_REQUEST['mode']=='edit')						disphtml("edit();");

if($_REQUEST['mode']=='')						disphtml("main();");
}
else												disphtml("main();");


ob_end_flush();
?>
<form name="frm_opts" action="<?php  echo $_SERVER['PHP_SELF']?>" method="post" >
  <input type="hidden" name="mode" value="">
  <input type="hidden" name="pageNo" value="<?php if(isset($_REQUEST['pageNo']))echo $_REQUEST['pageNo']; else { echo 1;}?>">
  <input type="hidden" name="url" value="<?php  echo $_SERVER['PHP_SELF']?>">
  <input type="hidden" name="id" value="">
  <input type="hidden" name="main_id" value="">
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
$sql_list_about = "SELECT * FROM ".MENU_MASTER." WHERE 1 ".$con." AND submenu_id!=1 AND menu_id=0 AND status!='D' ORDER BY order_by asc";	

$qry_list_about = mysqli_query($link,$sql_list_about);
$num_list_about = mysqli_num_rows($qry_list_about);


$countShow="SELECT * FROM ".MENU_MASTER." WHERE 1 ".$con." AND submenu_id!=1 AND menu_id=0 AND status!='D' ORDER BY order_by asc";
$qry_countshow=mysqli_query($link,$countShow) or die(mysqli_error($link));
$count=mysqli_num_rows($qry_countshow);
?>
<div id="page-wrapper">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12 breadcrumb-header"><div id="breadcrumb" class="tooltip-demo"> <a href="<?=URL?>" title="Go to Home" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-home fa-fw"></i> Home</a><a href="#" class="current">Menu</a></div>
      </div>
    </div>
    <!-- /.row -->
    <div class="row">
      <div class="col-lg-12">
        <div class="panel tabbed-panel panel-success">
          <div class="panel-heading clearfix">
            <div class="panel-title pull-left"><a data-toggle="collapse" href="#collapseOne" aria-expanded="false"><strong>Menu Details</strong></a></div>
            <div class="pull-right">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#tab-success-1" data-toggle="tab">Menu List</a></li>
                <li><a href="#tab-success-2" data-toggle="tab">Add Menu</a></li>
                <li><a href="#tab-success-3" data-toggle="tab">Add Sub-Menu</a></li>
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
                              <th width="5">#</th>
                              <th width="40">Sl no.</th>
                              <th>Menu Name</th>
                              <th>Status</th>
                              <th class="text-center">Action</th>
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
                              <input class="cheak_all" type="checkbox" id="public_chkbox" name="public_chkbox[]"value="<?php  echo $row_list_about['submenu_id']; ?>"/></td>
                              <td><?php  echo $cnt++?></td>
                              <td><?php  echo $row_list_about['menuLabel']; ?></td>
                              
                              <td><?php if(stripslashes($row_list_about['status'])=='A'){?>
                              <span class="btn btn-success btn-xs">Active</span>
                              <?php }else{?>
                               <span class="btn btn-danger btn-xs">Inactive</span>
                              <?php }?>
                              </td>
                              <td class="text-center tooltip-demo">
                              <a title="Edit" data-toggle="tooltip" data-placement="bottom" href="javascript:Edit('<?php  echo $row_list_about['submenu_id']?>','<?php  echo $GLOBALS['start']?>');" class="btn btn-info btn-circle"><i class="fa fa-edit fa-fw"></i></a>
                            <!--<a title="Delete" href="javascript:Delete('<?php  echo $row_list_about['submenu_id']?>','<?php  echo $GLOBALS['start']?>');" class="btn btn-danger btn-circle"><i class="fa fa-trash fa-fw"></i></a>-->
                            </td>
                            </tr>
                            <?php } ?>
                            
                            <?php }?>   
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
                     </div>
                   </form>
                  </div>
                  </div>
 
 <script language="javascript">
function Delete(ID,record_no)
{

	
	var UserResp = window.confirm("Are you sure to delete this menu and respected sub-menu also?");
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

	var flag=false;
	
	var e = document.getElementById("choose_action");
	var result = e.options[e.selectedIndex].value;
	
	if(result=='D')
	{
	document.frm_chk_about.mode.value='delete_chk_about';
	}
	if(result=='A')
	{
	document.frm_chk_about.mode.value='active_chk_about';
	}
	if(result=='I')
	{
	document.frm_chk_about.mode.value='inactive_chk_about';
	}

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
		document.frm_chk_about.submit();
		

	}
</script>                 
                  
                  
              <div class="tab-pane fade" id="tab-success-2"> 
                <div class="panel-body">
                  <form action="<?php  echo $_SERVER['PHP_SELF']?>" method="post" name="add_menu_frm" id="add_menu_frm"  enctype="multipart/form-data">
                    <input type="hidden" name="mode" value="insert_menu">
                      <table width="100%">
                        <tbody>
                          <tr>
                            <td colspan="3">
                              <div class="col-lg-9">(<font color="#ff0000">All * mark fields are mandatory</font>)</div>
                              <div class="col-lg-3">
                                <a class="btn btn-success pull-right" href="<?=CP_URL?>icon.php">Icon List</a></div>
                             </td>
                          </tr>
                          <tr>
                            <td colspan="3">&nbsp;</td>
                          </tr>
                          <tr class="alt-row">
                            <td width="15%">Menu Label<font color="#FF0000">*</font></td>
                            <td width="3%">&nbsp;</td>
                            <td width="82%"><div class="col-lg-6">
                                <div class="form-group"> <span class="input">
                                  <input type="text" class="form-control" id="menu_Lebel" name="menu_Lebel" placeholder="Enter menu name" autocomplete="off" title="Please enter menu name">
                                  </span></div>
                                <!-- /input-group --> 
                              </div></td>
                          </tr>
                          <tr class="alt-row">
                            <td width="15%">Menu Icon</td>
                            <td width="3%">&nbsp;</td>
                            <td width="82%"><div class="col-lg-6">
                                <div class="form-group">
                                  <input type="text" class="form-control" id="icons" name="icons" placeholder="Enter Icon" autocomplete="off"></div>
                                <!-- /input-group --> 
                              </div></td>
                          </tr>
                          <tr>
                            <td width="15%">Order By<font color="#FF0000">*</font></td>
                            <td width="3%">&nbsp;</td>
                            <td width="82%"><div class="col-lg-6">
                                <div class="form-group"> <span class="input">
                                  <input type="text" class="form-control" id="order_by" name="order_by" placeholder="Enter order by" autocomplete="off"/>
                                  </span></div>
                                <!-- /input-group --> 
                              </div></td>
                          </tr>
                          <tr>
                            <td colspan="3">&nbsp;</td>
                          </tr>
                          <tr>
                            <td colspan="3"><input type="hidden" name="id" value="">
                              <input type="hidden" name="hold_page" value="">
                              <input type="submit" value="Submit" class="btn btn-success">
                              <a href="admin_menu.php" class="btn btn-default">Cancel</a></td>
                          </tr>
                        </tbody>
                      </table>
                  </form>
                </div>
              </div>
              <!-- /.tab-pane -->
              
              <div class="tab-pane fade" id="tab-success-3">
                <div class="panel-body">
                  <form action="<?php  echo $_SERVER['PHP_SELF']?>" method="post" name="add_sub_menu_frm" id="add_sub_menu_frm"  enctype="multipart/form-data">
                    <input type="hidden" name="mode" value="insert_submenu">
                    <table width="100%">
                      <tbody>
                        <tr>
                          <td colspan="3">
                          <div class="col-lg-9">(<font color="#ff0000">All * mark fields are mandatory</font>)</div>
                          <div class="col-lg-3">
                            <a class="btn btn-success pull-right" href="<?=CP_URL?>icon.php">Icon List</a></div>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="3">&nbsp;</td>
                        </tr>
                        <tr>
                          <td width="15%">Select Menu<font color="#FF0000">*</font></td>
                          <td width="3%">&nbsp;</td>
                          <td width="82%"><div class="col-lg-6">
                              <div class="form-group">
                                <select class="form-control" name="menu_id" id="menu_id">
                                  <option value="">Select Menu</option>
                                  <?php 
                                           global $link;
                                           $sql_select= "SELECT * FROM ".MENU_MASTER."  where menu_id ='0' AND status='A' ORDER BY order_by asc";
                                           $sql_query= mysqli_query($link,$sql_select);
                                           while($row= mysqli_fetch_array($sql_query)){
                                         ?>
                                  <option value="<?php  echo $row['submenu_id']; ?>">
                                  <?php  echo $row['menuLabel']; ?>
                                  </option>
                                  <?php }?>
                                </select>
                              </div>
                              <!-- /input-group --> 
                            </div></td>
                        </tr>
                        <tr>
                          <td width="15%">Sub Menu Lebel<font color="#FF0000">*</font></td>
                          <td width="3%">&nbsp;</td>
                          <td width="82%"><div class="col-lg-6">
                              <div class="form-group">
                                <input type="text" class="form-control" id="menuLabel" name="menuLabel" Placeholder="Enter sub menu" autocomplete="off"></div>
                              <!-- /input-group --> 
                            </div></td>
                        </tr>
                        <tr>
                          <td width="15%">Menu Icon</td>
                          <td width="3%">&nbsp;</td>
                          <td width="82%"><div class="col-lg-6">
                              <div class="form-group">
                                <input type="text" class="form-control" id="icons" name="icons" placeholder="Enter Icon" autocomplete="off" value="<?php echo isset($results->icons) ? $results->icons : '' ;?>">
                              </div>
                            </div></td>
                        </tr>
                        <tr>
                          <td width="15%">File Name<font color="#FF0000">*</font></td>
                          <td width="3%">&nbsp;</td>
                          <td width="82%"><div class="col-lg-6">
                              <div class="form-group"> <span class="input">
                                <input type="text" class="form-control" id="file_name" name="file_name" Placeholder="Enter file name" autocomplete="off"/>
                                </span></div>
                              <!-- /input-group --> 
                            </div></td>
                        </tr>
                        <tr>
                          <td width="15%">Order By<font color="#FF0000">*</font></td>
                          <td width="3%">&nbsp;</td>
                          <td width="82%"><div class="col-lg-6">
                              <div class="form-group"> <span class="input">
                                <input type="text" class="form-control" id="submenu_order" name="submenu_order" Placeholder="Enter order by" autocomplete="off"/>
                                </span></div>
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
                        <a href="admin_menu.php" class="btn btn-default">Cancel</a>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- /.card --> 
        </div>
        <!-- /.card -->
        </section>
        
        <!-- /.content --> 
      </div>
    </div>
  </div>
</div>
<?php  }

function insert_menu(){
	global $link;
	
	$sql_inset_post="INSERT INTO ".MENU_MASTER." 

			SET 
			menuLabel = '".ConvertRealString($_REQUEST['menu_Lebel'])."',
			icons 	= '".ConvertRealString($_REQUEST['icons'])."',
			order_by = '".ConvertRealString($_REQUEST['order_by'])."'";	
		 

		$qry_inset_post	=mysqli_query($link,$sql_inset_post) or die(mysqli_error($link)); 

			$_SESSION['MSG_ALERT'] = "Latest menu inserted successfully";
			$_SESSION['IMG_PATH'] ="fa-check"; 
			$_SESSION['DIV_CLASS'] ="alert-success"; 
	
	 redirect_cp('admin_menu');
exit();
}
function insert_submenu(){
	global $link;
	
	$sql_inset_post="INSERT INTO ".MENU_MASTER." 

			SET 
			menu_id = '".ConvertRealString($_REQUEST['menu_id'])."',
			menuLabel = '".ConvertRealString($_REQUEST['menuLabel'])."',
			icons 	= '".ConvertRealString($_REQUEST['icons'])."',
			file_name = '".ConvertRealString($_REQUEST['file_name'])."',
			order_by = '".ConvertRealString($_REQUEST['submenu_order'])."'";	
			
		$qry_inset_post	=mysqli_query($link,$sql_inset_post) or die(mysqli_error($link));
			
	    
	if($qry_inset_post)
		{
		$_SESSION['MSG_ALERT'] = "Latest sub menu inserted successfully";
		$_SESSION['IMG_PATH'] ="fa-check";
		$_SESSION['DIV_CLASS'] ="alert-success"; 
		 redirect_cp('admin_menu');
		exit();
		}
}

function delete_about()
{

global $link;
	$sql_delete_about= "DELETE FROM ".MENU_MASTER." where menu_id='".$_REQUEST['id']."'";   
	$qry_delete_about=mysqli_query($link,$sql_delete_about) or die(mysqli_error());
	
	$sql_delete_about= "DELETE FROM ".MENU_MASTER." where submenu_id='".$_REQUEST['id']."'";   
	$qry_delete_about=mysqli_query($link,$sql_delete_about) or die(mysqli_error());
	
	$_SESSION['MSG_ALERT'] = "Latest information has been successfully deleted.";
	$_SESSION['IMG_PATH'] ="fa-ban"; 
	$_SESSION['DIV_CLASS'] ="alert-danger"; 
	redirect_cp('admin_menu');
	exit();
}

function Delete_Sub()
{

global $link;
		$sql_delete_about= "DELETE FROM ".MENU_MASTER." where submenu_id='".$_REQUEST['id']."'";   
		$qry_delete_about=mysqli_query($link,$sql_delete_about) or die(mysqli_error());
		
		$_SESSION['MSG_ALERT'] = "Latest information has been successfully deleted.";
		$_SESSION['IMG_PATH'] ="fa-ban"; 
		$_SESSION['DIV_CLASS'] ="alert-danger"; 
		header('location:admin_menu.php?mode=edit&id='.$_REQUEST['main_id']);
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
					
							$sql_deletepublication = "DELETE FORM ".MENU_MASTER." where login_id='".$val."'";
					
					$qry_deletepublication	=mysqli_query($link,$sql_deletepublication) or die(mysqli_error($link));
							
							$count_del++;
							
					}
				}
				
				if($count_del > 0)
				{
				$_SESSION['MSG_ALERT'] = "Successfully deleted.";
				$_SESSION['IMG_PATH'] ="fa-ban"; 
				$_SESSION['DIV_CLASS'] ="alert-danger"; 
				redirect_cp('admin_menu');
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
					$sql_deletepublication = "UPDATE ".MENU_MASTER." 
											SET 
											status= 'A'
											where submenu_id='".$val."'";
					
					$qry_deletepublication	=mysqli_query($link,$sql_deletepublication) or die(mysqli_error($link));
							
							$count_del++;
							
					}
				}
				
				if($count_del > 0)
				{
				$_SESSION['MSG_ALERT'] = "Updated successfully";
				$_SESSION['IMG_PATH'] ="fa-check";
				$_SESSION['DIV_CLASS'] ="alert-success"; 
				redirect_cp('admin_menu');
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
					$sql_deletepublication = "UPDATE ".MENU_MASTER." 
											  SET 
											  status= 'I'
											where submenu_id='".$val."'";
					
					$qry_deletepublication	=mysqli_query($link,$sql_deletepublication) or die(mysqli_error($link));
							
							$count_del++;
							
					}
				}
				
				if($count_del > 0)
				{
				$_SESSION['MSG_ALERT'] = "Updated successfully";
				$_SESSION['IMG_PATH'] ="fa-check";
				$_SESSION['DIV_CLASS'] ="alert-success"; 
				redirect_cp('admin_menu');
				exit();
				}
}


 ?>
<?php
function edit(){
	
	global $link;

	
$sql_edit_about = "SELECT * FROM ".MENU_MASTER."  where submenu_id ='".$_REQUEST['id']."'";
$qry_edit_about = mysqli_query($link,$sql_edit_about) or die(mysqli_error());
$row_edit_about = mysqli_fetch_array($qry_edit_about);

?>
<div id="page-wrapper">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12 breadcrumb-header"><div id="breadcrumb" class="tooltip-demo"> <a href="<?=URL?>" title="Go to Home" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-home fa-fw"></i> Home</a><a href="<?php echo $_SERVER['PHP_SELF']?>">Menu</a><a href="#" class="current">Edit</a></div>
      </div>
    </div>
    <!-- /.row -->
    <div class="row">
      <div class="col-lg-12">
        <div class="panel tabbed-panel panel-success">
          <div class="panel-heading clearfix">
            <div class="panel-title pull-left"><a data-toggle="collapse" href="#collapseOne" aria-expanded="false"><strong><i class="fa fa-edit fa-fw"></i> Edit Menu</strong></a></div>
          </div>
          <div class="panel-body" id="collapseOne" aria-expanded="true" style="background: #eef9f0;margin: 1em;border-radius: 4px;">
              
                <div class="panel-body">
             	<form action="<?php echo  $_SERVER['PHP_SELF']?>" method="post" name="edit_frm" id="edit_frm" enctype="multipart/form-data">
          <input type="hidden" name="mode" value="edit_about">
          <input type="hidden" name="id" value="<?php  echo $_REQUEST['id']?>">
          <table width="100%">
            <tbody>
              <tr>
                <td width="15%"><i class="<?php if(!empty($row_edit_about['icons'])){echo $row_edit_about['icons'];}else{?>fa fa-th-list fa-fw<?php }?>"></i> Menu Name</td>
                <td width="3%">&nbsp;</td>
                <td width="82%"><div class="col-lg-6">
                    <div class="form-group"> <span class="input">
                      <input type="text" class="form-control" id="menuLabel" name="menuLabel" value="<?php echo $row_edit_about['menuLabel'];?>"  placeholder="Enter menu name" autocomplete="off"/>
                      </span></div>
                      
                    <!-- /input-group --> 
                  </div></td>
              </tr>
              <tr>
                  <td width="15%"> &nbsp; &nbsp; <i class="glyphicon glyphicon-arrow-right"></i> Menu Icon</td>
                  <td width="3%">&nbsp;</td>
                  <td width="82%"><div class="col-lg-6">
                      <div class="form-group">
                        <input type="text" class="form-control" id="icons" name="icons" placeholder="Enter Icon" autocomplete="off" value="<?php echo $row_edit_about['icons'];?>">
                      </div>
                    </div></td>
                </tr>
              <tr>
                <td> &nbsp; &nbsp; <i class="glyphicon glyphicon-arrow-right"></i> Order By</td>
                <td>&nbsp;</td>
                <td><div class="col-lg-6">
                  <div class="form-group"> <span class="input">
                    <input type="text" class="form-control" id="order_by" name="order_by" value="<?php echo $row_edit_about['order_by'];?>" autocomplete"off"  placeholder="Order by no"/>
                  </span></div>
                  <!-- /input-group -->
                </div></td>
              </tr>
              
              
              <tr class="alt-row">
                <td colspan='4' style="color:#C9F;;padding:1rem;border-bottom: 1px solid;"><i class="fa fa-chevron-right fa-fw"></i> Sub Menu List <a style="float: right;" href="<?=CP_URL?>icon.php"><i class="fa fa-bitbucket fa-fw"></i>Icon List</a> </td>
              </tr>
              <tr>
              	<td colspan="4">
                	<div class="row">
                    <div class="col-lg-2" style="padding-left: 3em;"> </div>
                    <div class="col-lg-3" style="padding-left: 3em;"> <strong>Submenu Name</strong> </div>
                    <div class="col-lg-3" style="padding-left: 2em;"> <strong>Submenu Icon</strong> </div>
                    <div class="col-lg-2" style="padding-left: 2em;"> <strong>File Name</strong> </div>
                    <div class="col-lg-2"> <strong>Order No</strong> </div>
                    </div>
                </td>
              </tr>
 <?php
$sql_sub = "SELECT * FROM ".MENU_MASTER." WHERE 1 AND menu_id=".$_REQUEST['id']." AND status!='D' ORDER BY order_by asc";	
$qry_sub = mysqli_query($link,$sql_sub);
$num_sub = mysqli_num_rows($qry_sub);
if($num_sub>0){
$i=1;
while($row_sub=mysqli_fetch_array($qry_sub)){
 ?>             
              <tr>
              <td colspan='3' style="padding: 10px;">
              <div class="row">
               <div class="col-lg-2">
                  <div class="form-group"> <span class="input" style="font-weight:bold;"><i class="<?php if(!empty($row_sub['icons'])){echo $row_sub['icons'];}else{?>fa fa-dot-circle-o fa-fw<?php }?>"></i> Sub-Menu-<?php echo $i;?></span></div>
                </div>
               <div class="col-lg-3">
                  <div class="form-group"> <span class="input">
                <input type="hidden" name="submenu_id[]" value="<?php echo $row_sub['submenu_id'];?>" />
                    <input type="text" class="form-control name" id="SmenuLabel_<?php echo $i;?>" name="SmenuLabel[]" value="<?php echo $row_sub['menuLabel'];?>" placeholder="Enter sub-menu name" />
                  </span></div>
                </div>
               <div class="col-lg-3">
                  <div class="form-group">
                    <input type="text" class="form-control" id="Sicons_<?php echo $i;?>" name="Sicons[]" value="<?php echo $row_sub['icons'];?>" placeholder="Enter sub-menu icon" />
                  </div>
                </div>
               <div class="col-lg-2">
                  <div class="form-group"> <span class="input">
                    <input type="text" class="form-control" id="Sfile_name_<?php echo $i;?>" name="Sfile_name[]" value="<?php echo $row_sub['file_name'];?>" placeholder="Enter sub-menu file name" />
                  </span></div>
                </div>
                <div class="col-lg-1">
                  <div class="form-group"> <span class="input">
                    <input type="text" class="form-control" id="Sorder_by_<?php echo $i;?>" name="Sorder_by[]" value="<?php echo $row_sub['order_by'];?>" placeholder="Order by" />
                  </span></div>
                </div>
                <div class="col-lg-1">
                  <div class="form-group"> <span class="input tooltip-demo">
                    <a title="Delete" data-toggle="tooltip" data-placement="bottom" href="javascript:DeleteSub('<?php  echo $row_sub['submenu_id']?>','<?php  echo $_REQUEST['id']?>');" class="btn btn-danger btn-circle"><i class="fa fa-trash fa-fw"></i></a>
                  </span></div>
                </div>
                
                </div>
               </td>
              </tr>
 <?php $i++;}}?>             
            </tbody>
          </table>
          <div class="row">
            <div class="col-12">
              <input type="submit" id="submits" name="submits" value="Submit" class="btn btn-success" onclick="return btn_submit();">
            <a href="javascript:history.back()" class="btn btn-default">Cancel</a> </div>
          </div>
        </form>                
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

<script>
function btn_submit()
{
	<?php
	for($s=1; $s<=$num_sub; $s++){
	?>
		if($('#SmenuLabel_'+<?php echo $s;?>).val().trim()==''){
			$('#SmenuLabel_'+<?php echo $s;?>).addClass('has-warning');
			$('#SmenuLabel_'+<?php echo $s;?>).focus();
			$('#SmenuLabel_'+<?php echo $s;?>).removeClass('has-success');
			return false;
		}
		if($('#Sfile_name_'+<?php echo $s;?>).val().trim()==''){
			$('#Sfile_name_'+<?php echo $s;?>).addClass('has-warning');
			$('#Sfile_name_'+<?php echo $s;?>).focus();
			$('#Sfile_name_'+<?php echo $s;?>).removeClass('has-success');
			return false;
		}
		if($('#Sorder_by_'+<?php echo $s;?>).val().trim()==''){
			$('#Sorder_by_'+<?php echo $s;?>).addClass('has-warning');
			$('#Sorder_by_'+<?php echo $s;?>).focus();
			$('#Sorder_by_'+<?php echo $s;?>).removeClass('has-success');
			return false;
		}
	<?php }?>
	
}
function DeleteSub(ID,MAIN,record_no,cat,val)
{
	var UserResp = window.confirm("Are you sure to delete this?");
	if( UserResp == true )
	{
	document.frm_opts.mode.value='Delete_Sub';
	document.frm_opts.id.value=ID;
	document.frm_opts.main_id.value=MAIN;
	document.frm_opts.hold_page.value = record_no*1;	
	document.frm_opts.submit();
	}
}
</script>
<?php 
}

function edit_about()
	{
	global $link;;
	
		 $sql_inset_post="UPDATE ".MENU_MASTER." 
                    SET 
					menuLabel = '".ConvertRealString($_REQUEST['menuLabel'])."',
					icons 	= '".ConvertRealString($_REQUEST['icons'])."',
					order_by ='".ConvertRealString($_REQUEST['order_by'])."'
                    where submenu_id='".$_REQUEST['id']."'";
			
		$qry_inset_post	=mysqli_query($link,$sql_inset_post) or die(mysqli_error($link));
		
		$total=count($_REQUEST['submenu_id']);
		
			for($i=0;$i<$total;$i++)
			{
				 $sql_inset_post="UPDATE ".MENU_MASTER." 
                    SET 
					menuLabel= '".$_REQUEST['SmenuLabel'][$i]."',
					file_name= '".$_REQUEST['Sfile_name'][$i]."',
					icons= '".$_REQUEST['Sicons'][$i]."',
					order_by='".$_REQUEST['Sorder_by'][$i]."'
                    where submenu_id='".$_REQUEST['submenu_id'][$i]."'";
			
				$qry_inset_post	=mysqli_query($link,$sql_inset_post) or die(mysqli_error($link));
			}
		
	    
	if($qry_inset_post)
		{
		$_SESSION['MSG_ALERT'] = "Latest Information updated successfully";
		$_SESSION['IMG_PATH'] ="fa-check";
		$_SESSION['DIV_CLASS'] ="alert-success"; 
		 redirect_cp('admin_menu');
		exit();
		
	}
	else
	{
	    $_SESSION['MSG_ALERT'] = "Latest Information already exist";
		$_SESSION['IMG_PATH'] ="fa-exclamation-triangle";
		$_SESSION['DIV_CLASS'] = "alert-warning";
		redirect_cp('admin_menu');
		exit();
	}
		
	}
 ?>
<script language="javascript">

$(document).ready(function () {
	
//---------------------------------add menu Insert validation   -------------------------------	  
	$('#add_menu_frm').validate({
		rules: {
		  menu_Lebel: 'required',
		  order_by: 'required number'
		},
		messages: {
			menu_Lebel: "Please provide a menu name.",
			order_by: {
				required: "Please provide a order by no."
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
            form.submit();
        }
	  });
//---------------------------------add sub menu Insert validation   ----------------------------
	
		 
		$('#add_sub_menu_frm').validate({
		rules: {
		  menu_id: 'required',
		  menuLabel: 'required',
		  file_name: 'required',
		  submenu_order: 'required number'
		},
		messages: {
			menu_id: "Please select menu...!",
			menuLabel: "Please enter sub menu name...!",
			file_name: "Please enter file name...!",
			submenu_order: {
				required: "Please provide a order by no."
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
            form.submit();
        }
	  });

//---------------------------------Menu Edit validation   ----------------------------
		 
		$('#edit_frm').validate({
		rules: {
		  menuLabel: 'required',
		  order_by: 'required number'
		},
		messages: {
			menuLabel: "Please provide a menu name...!",
			order_by: {
				required: "Please provide a order by no."
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
            form.submit();
        }
	  });

});
</script> 