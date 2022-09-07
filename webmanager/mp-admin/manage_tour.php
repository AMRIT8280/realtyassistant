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
$sql_list_about = "SELECT * FROM ".DB_TOUR_PLAN."  WHERE 1 ".$con." AND status!='D' ORDER BY id DESC";	
$qry_list_about = mysqli_query($link,$sql_list_about);
$num_list_about = mysqli_num_rows($qry_list_about);


$countShow="SELECT count(*) FROM ".DB_TOUR_PLAN."  WHERE 1 ".$con." AND status!='D' ORDER BY id DESC";
$qry_countshow=mysqli_query($link,$countShow) or die(mysqli_error($link));
$count=mysqli_num_rows($qry_countshow);
?>
<div id="page-wrapper">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12 breadcrumb-header">
        <div id="breadcrumb" class="tooltip-demo"> <a href="<?=URL?>" title="Go to Home" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-home fa-fw"></i> Home</a><a href="#" class="current">Tour</a></div>
      </div>
    </div>
    <!-- /.row -->
    <div class="row">
      <div class="col-lg-12">
        <div class="panel tabbed-panel panel-success">
          <div class="panel-heading clearfix">
            <div class="panel-title pull-left"><a data-toggle="collapse" href="#collapseOne" aria-expanded="false"><strong>Tour Details</strong></a></div>
            <div class="pull-right">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#tab-success-1" data-toggle="tab">Data List</a></li>
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
              <div class="tab-pane fade in active" id="tab-success-1">
                <div class="panel-body">
                  <form name="frm_chk_about" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                    <input type="hidden" name="mode" value="" />
                    <div class="table-responsive">
                      <table id="export_tour" class="table table-striped table-bordered">
                        <thead>
                          <tr>
                            <th width="10">#</th>
                            <th>Tour Name</th>
                            <th>Country Name</th>
                            <th>City Name</th>
                            <th>Tour Price</th>
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
                            <!--<td><img src="../../uploads/tour/<?php echo $row_list_about['image_name']?>" width="50px" /></td>-->
                            <td><?php  echo $row_list_about['main_title']; ?></td>
                            <td><?php  echo get_country_name($row_list_about['con_id']); ?></td>
                            <td><?php  echo get_city_name($row_list_about['cty_id']); ?></td>
                            <td><?php  echo $row_list_about['price']; ?></td>
                            <td><?php if(stripslashes($row_list_about['status'])=='A'){?>
                              <span class="btn btn-success btn-xs">Active</span>
                              <?php }else{?>
                              <span class="btn btn-danger btn-xs">Inactive</span>
                              <?php }?></td>
                            <td class="tooltip-demo"><a title="Edit" data-toggle="tooltip" data-placement="bottom" href="javascript:Edit('<?php  echo $row_list_about['id']?>','<?php  echo $GLOBALS['start']?>');" class="btn btn-info btn-circle"><i class="fa fa-edit fa-fw"></i></a> <a title="Delete" data-toggle="tooltip" data-placement="bottom" href="javascript:Delete('<?php  echo $row_list_about['id']?>','<?php  echo $GLOBALS['start']?>');" class="btn btn-danger btn-circle"><i class="fa fa-trash fa-fw"></i></a></td>
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
	var UserResp = window.confirm("Are you sure to delete this Tour?");
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
                            <td colspan="6">(<font color="#ff0000">All * mark fields are mandatory</font>)</td>
                          </tr>
                          <tr>
                            <td colspan="6">&nbsp;</td>
                          </tr>
                          <tr>
                            <td width="14%">Tour Name<font color="#ff0000">*</font></td>
                            <td width="2%">&nbsp;</td>
                            <td width="84%"><div class="col-lg-6">
                                <div class="form-group">
                                  <input type="text" class="form-control" id="main_title" name="main_title" placeholder="Enter title" autocomplete="off">
                                </div>
                              </div></td>
                          </tr>
                          <tr>
                            <td width="15%">Choose Location <font color="#ff0000">*</font></td>
                            <td width="3%">&nbsp;</td>
                            <td width="82%"><div class="col-lg-6">
                                <div class="form-group">
                                  <select class="form-control" name="con_id" id="con_id" autocomplete="off">
                                    <option value="">Choose Country</option>
                                    <?php 
                                         $sql_select= "SELECT * FROM ".DB_COUNTRY." WHERE status='A'";
                                         $sql_query= mysqli_query($link,$sql_select);
                                         while($row= mysqli_fetch_array($sql_query)){
                                      ?>
                                    <option value="<?php  echo $row['id']; ?>">
                                    <?php  echo $row['main_title']; ?>
                                    </option>
                                    <?php }?>
                                  </select>
                                </div>
                              </div><div class="col-lg-6">
                                <div class="form-group">
                                  <select class="form-control" name="cty_id" id="cty_id" autocomplete="off">
                                    <option value="">Choose City</option>
                                  </select>
                                </div>
                              </div></td>
                          </tr>
                          <tr>
                            <td width="14%">Select Trip Date<font color="#ff0000">*</font></td>
                            <td width="2%">&nbsp;</td>
                            <td width="84%"><div class="col-lg-6 form-group">
                                <div class="input-group">
                                   <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
                                   <input type="text" class="form-control multi_date" id="trip_date" name="trip_date" placeholder="Select Date" autocomplete="off">
                                                </div>
                              </div></td>
                          </tr>
                          <tr>
                            <td width="14%">Set Board<font color="#ff0000">*</font></td>
                            <td width="2%">&nbsp;</td>
                            <td width="84%"><div class="col-lg-12 form-group">
                                  <div class="checkbox">
                            			<?php 
                                          $sql_select= "SELECT * FROM ".DB_BOARD_BASIS." WHERE status='A'";
                                         $sql_query= mysqli_query($link,$sql_select);
                                         while($row= mysqli_fetch_array($sql_query))
                                          {
                                      ?>
                                      <label style="width: 33%;">
                                           <input type="checkbox" id="board_value" name="board_value" autocomplete="off" value="<?php  echo $row['id']; ?>"> &nbsp; <?php  echo $row['main_title']; ?>
                                      </label>
                                    <?php }?>
                                  </div>
                              </div></td>
                          </tr>
                          <tr>
                            <td width="14%">Base Price<font color="#ff0000">*</font></td>
                            <td width="2%">&nbsp;</td>
                            <td width="84%"><div class="col-lg-6 form-group">
                                <div class="input-group">
                                   <span class="input-group-addon">£</span>
                                   <input type="text" class="form-control" id="price" name="price"  placeholder="Enter price"autocomplete="off">
                                 </div>
                              </div></td>
                          </tr>
                          <tr>
                            <td width="14%">Adult Section<font color="#ff0000">*</font></td>
                            <td width="2%">&nbsp;</td>
                            <td width="84%"><div class="col-lg-4 form-group">
                                <label>Min Person</label>
                                <div class="input-group">
                                   <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
                                   <input type="text" class="form-control" id="adult_total" name="adult_total" autocomplete="off">
                                 </div>
                              </div><div class="col-lg-4 form-group">
                                <label>Discount from Price</label>
                                <div class="input-group">
                                   <input type="text" class="form-control" id="adult_discount" name="adult_discount" autocomplete="off">
                                   <span class="input-group-addon" style="padding:0px;"><select name="discount_In" id="discount_In" style="padding: 5px;">
                                    <option value="per">%</option>
                                    <option value="amt">£</option>
                                  </select></span>
                                 </div>
                              </div><div class="col-lg-4 form-group">
                                <label>Actual Price</label>
                                <div class="input-group">
                                   <span class="input-group-addon">£</span>
                                   <input type="text" class="form-control" id="adult_value" name="adult_value" autocomplete="off">
                                 </div>
                              </div></td>
                          </tr>
                          <tr>
                            <td width="14%">Child Section<font color="#ff0000">*</font></td>
                            <td width="2%">&nbsp;</td>
                            <td width="84%"><div class="col-lg-4 form-group">
                                <label>Min Person</label>
                                <div class="input-group">
                                   <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
                                   <input type="text" class="form-control" id="adult_total" name="adult_total" autocomplete="off">
                                 </div>
                              </div><div class="col-lg-4 form-group">
                                <label>Discount from Price</label>
                                <div class="input-group">
                                   <input type="text" class="form-control" id="adult_discount" name="adult_discount" autocomplete="off">
                                   <span class="input-group-addon" style="padding:0px;"><select name="discount_In" id="discount_In" style="padding: 5px;">
                                    <option value="per">%</option>
                                    <option value="amt">£</option>
                                  </select></span>
                                 </div>
                              </div><div class="col-lg-4 form-group">
                                <label>Actual Price</label>
                                <div class="input-group">
                                   <span class="input-group-addon">£</span>
                                   <input type="text" class="form-control" id="adult_value" name="adult_value" autocomplete="off">
                                 </div>
                              </div></td>
                          </tr>
                          <!--<tr>
                            <td width="15%">Package No Of Days <font color="#ff0000">*</font></td>
                            <td width="3%">&nbsp;</td>
                            <td width="32%"><div class="col-lg-6">
                                <div class="form-group">
                                  <select class="form-control" name="con_id" id="con_id" autocomplete="off">
                                    <option value="">Choose Country</option>
                                    <?php 
                                         $sql_select= "SELECT * FROM ".DB_COUNTRY." WHERE status='A'";
                                         $sql_query= mysqli_query($link,$sql_select);
                                         while($row= mysqli_fetch_array($sql_query)){
                                      ?>
                                    <option value="<?php  echo $row['id']; ?>">
                                    <?php  echo $row['main_title']; ?>
                                    </option>
                                    <?php }?>
                                  </select>
                                </div>
                              </div></td>
                            <td width="15%">Minimum 2 Adults ? <font color="#ff0000">*</font></td>
                            <td width="3%">&nbsp;</td>
                            <td width="32%"><div class="col-lg-6">
                                <div class="form-group">
                                  <select class="form-control" name="cty_id" id="cty_id" autocomplete="off">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                  </select>
                                </div>
                              </div></td>
                          </tr>-->
                          <!--<tr>
                            <td width="14%">Upload Image <font color="#ff0000">*</font></td>
                            <td width="2%">&nbsp;</td>
                            <td width="84%"><div class="col-lg-6">
                                <div class="form-group">
                                  <input type="file" class="form-control" accept=".png, .jpg, .jpeg" id="image_name"name="image_name" onchange="validateimg_s(this.value)">
                                </div>
                                <p id="image_name_alert" style="color:#F00;"></p>
                              </div></td>
                          </tr>
                          <tr>
                            <td width="14%">Description</td>
                            <td width="2%">&nbsp;</td>
                            <td width="84%"><div class="col-lg-6">
                                <div class="form-group">
                                  <textarea id="myTextarea" name="descript" class="form-control" placeholder="Enter Description"></textarea>
                                </div>
                              </div></td>
                          </tr>
                          <tr>
                            <td width="14%">Multiple Image</td>
                            <td width="2%">&nbsp;</td>
                            <td width="84%"><label class="upload_img_main_box">
                              <input type="file" id="files" name="multi_file[]" multiple="multiple" style="display:none;">
                              <div class="uploadpicbutton_wrapper">
                                <div class="uploadpicbutton"> <i class="fa fa-cloud-upload"></i> Upload Photos </div>
                              </div>
                              </label></td>
                          </tr>-->
                          <tr>
                            <td colspan="3">&nbsp;</td>
                          </tr>
                          <tr>
                            <td colspan="3"><input type="hidden" name="id" value="">
                              <input type="hidden" name="hold_page" value="">
                              <input type="submit" value="Submit" class="btn btn-success">
                              <a href="manage_tour.php" class="btn btn-default">Cancel</a></td>
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
	$upload_dir='../../uploads/tour/';

	$file_name_image='';
	if($_FILES['image_name']['name']!="")
			{
				$file_explode = explode(".",$_FILES['image_name']['name']);
					$file_name_image=time()."_".str_replace(" ","_",$_FILES['image_name']['name']);
					$tmp_name=$_FILES['image_name']['tmp_name'];
					move_uploaded_file($tmp_name,$upload_dir.$file_name_image);
		    }
				
	 $sql_inset_post="INSERT INTO ".DB_TOUR_PLAN." 

		SET 
		image_name='".$file_name_image."',
		main_title = '".ConvertRealString($_REQUEST['main_title'])."',
		price = '".ConvertRealString($_REQUEST['price'])."',
		con_id = '".ConvertRealString($_REQUEST['con_id'])."',
		cty_id = '".ConvertRealString($_REQUEST['cty_id'])."',
		descript = '".addslashes(nl2br($_REQUEST['descript']))."'";

		$qry_inset_post	=mysqli_query($link,$sql_inset_post);	
		
		$last_id=mysqli_insert_id($link);
		
		if($_FILES['multi_file']['name'][0]!='')
		{
		$total_image=count($_FILES['multi_file']['name']);
			for($i=0;$i<=$total_image;$i++)
			{
			
			$_FILES['multi_file']['name'][$i];
			
			$file_explode = explode(".",$_FILES['multi_file']['name'][$i]);
			
			if($file_explode[1] == 'jpg'||$file_explode[1] == 'jpeg'||$file_explode[1] == 'png')
				{
					$file_name=time()."_".str_replace(" ","_",$_FILES['multi_file']['name'][$i]);
					$tmp_name=$_FILES['multi_file']['tmp_name'][$i];
					move_uploaded_file($tmp_name,$upload_dir.$file_name);
					
					
												
					  $sql_inset_post="INSERT INTO ".DB_TOUR_IMAGE." 
						SET
						tour_id=".$last_id.",
						image_name='".addslashes($file_name)."'";
								
					$qry_inset_post	=mysqli_query($link,$sql_inset_post) or die(mysqli_error($link));
					
				}
			}
		
		}
		

		$_SESSION['MSG_ALERT'] = "Latest Information inserted successfully";
		$_SESSION['IMG_PATH'] ="fa-check"; 
		$_SESSION['DIV_CLASS'] ="alert-success"; 
		
		 redirect_mp('manage_tour');
	exit();
			
}

function delete_about()
{

global $link;
		$sql_delete_about= "UPDATE ".DB_TOUR_PLAN." 
                    SET 
					status= 'D'
                    where id='".$_REQUEST['id']."'";   
		$qry_delete_about=mysqli_query($link,$sql_delete_about) or die(mysqli_error());
		
		$_SESSION['MSG_ALERT'] = "Latest country has been successfully deleted.";
		$_SESSION['IMG_PATH'] ="fa-ban"; 
		$_SESSION['DIV_CLASS'] ="alert-danger"; 
		redirect_mp('manage_tour');
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
					
							$sql_deletepublication = "UPDATE ".DB_TOUR_PLAN." 
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
				redirect_mp('manage_tour');
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
					$sql_deletepublication = "UPDATE ".DB_TOUR_PLAN." 
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
				redirect_mp('manage_tour');
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
					$sql_deletepublication = "UPDATE ".DB_TOUR_PLAN." 
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
				redirect_mp('manage_tour');
				exit();
				}
}


?>
<?php
function edit(){
	
	global $link;
$sql_edit_about = "SELECT * FROM ".DB_TOUR_PLAN."  where id ='".$_REQUEST['id']."'";
$qry_edit_about = mysqli_query($link,$sql_edit_about) or die(mysqli_error());
$row_edit_about = mysqli_fetch_array($qry_edit_about);

?>
<div id="page-wrapper">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12 breadcrumb-header">
        <div id="breadcrumb" class="tooltip-demo"> <a href="<?=URL?>" title="Go to Home" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-home fa-fw"></i> Home</a><a href="<?=$_SERVER['PHP_SELF']?>">Tour</a><a href="#" class="current">Edit</a></div>
      </div>
    </div>
    <!-- /.row -->
    <div class="row">
      <div class="col-lg-12">
        <div class="panel tabbed-panel panel-success">
          <div class="panel-heading clearfix">
            <div class="panel-title pull-left"><a data-toggle="collapse" href="#collapseOne" aria-expanded="false"><strong><i class="fa fa-edit fa-fw"></i> Edit Tour</strong></a></div>
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
                        <td colspan="3">(<font color="#ff0000">All * mark fields are mandatory</font>)</td>
                      </tr>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr>
                        <td width="15%">Existing Image</td>
                        <td width="3%">&nbsp;</td>
                        <td width="87%"><div class="col-lg-6">
                            <div class="form-group"><img src="../../uploads/tour/<?php echo $row_edit_about['image_name']?>" width="100px" /></div>
                            <!-- /input-group --> 
                          </div></td>
                      </tr>
                      <tr>
                        <td width="15%">Upload Image</td>
                        <td width="3%">&nbsp;</td>
                        <td width="87%"><div class="col-lg-6">
                            <div class="form-group">
                              <input type="file" class="form-control" accept=".png, .jpg, .jpeg" id="image_name"name="image_name" onchange="validateimg_s(this.value)">
                            </div>
                            <p id="image_name_alert" style="color:#F00;"></p>
                          </div></td>
                      </tr>
                      <tr>
                        <td width="15%">Tour Name <font color="#ff0000">*</font></td>
                        <td width="3%">&nbsp;</td>
                        <td width="87%"><div class="col-lg-6">
                            <div class="form-group"> <span class="input">
                              <input type="text" class="form-control" id="main_title" name="main_title" value="<?php echo $row_edit_about['main_title'];?>" autocomplete="off">
                              </span></div>
                            <!-- /input-group --> 
                          </div></td>
                      </tr>
                      <tr>
                        <td width="15%">Tour Price <font color="#ff0000">*</font></td>
                        <td width="3%">&nbsp;</td>
                        <td width="87%"><div class="col-lg-6">
                            <div class="form-group"> <span class="input">
                              <input type="text" class="form-control" id="price" name="price" value="<?php echo $row_edit_about['price'];?>" autocomplete="off">
                              </span></div>
                            <!-- /input-group --> 
                          </div></td>
                      </tr>
                      <tr>
                        <td width="15%">Country Name <font color="#ff0000">*</font></td>
                        <td width="3%">&nbsp;</td>
                        <td width="82%"><div class="col-lg-6">
                            <div class="form-group">
                              <select class="form-control" name="con_id" id="con_id" autocomplete="off">
                                <option value="">Choose Country</option>
                                <?php 
                                          $sql_select= "SELECT * FROM ".DB_COUNTRY." WHERE status='A'";
                                         $sql_query= mysqli_query($link,$sql_select);
                                         while($row= mysqli_fetch_array($sql_query))
                                          {
                                      ?>
                                <option value="<?php  echo $row['id']; ?>" <?php if($row['id']==$row_edit_about['con_id']){echo 'selected';}?>>
                                <?php  echo $row['main_title']; ?>
                                </option>
                                <?php }?>
                              </select>
                            </div>
                          </div></td>
                      </tr>
                      <tr>
                        <td width="15%">City Name <font color="#ff0000">*</font></td>
                        <td width="3%">&nbsp;</td>
                        <td width="82%"><div class="col-lg-6">
                            <div class="form-group">
                              <select class="form-control" name="cty_id" id="cty_id" autocomplete="off">
                                <option value="">Choose City</option>
                                <?php 
                                         $sql_select= "SELECT * FROM ".DB_CITY." ";
                                         $sql_query= mysqli_query($link,$sql_select);
                                         while($row= mysqli_fetch_array($sql_query)){
                                      ?>
                                <option value="<?php  echo $row['id']; ?>" <?php if($row['id']==$row_edit_about['cty_id']){echo 'selected';}?>>
                                <?php  echo $row['main_title']; ?>
                                </option>
                                <?php }?>
                              </select>
                            </div>
                          </div></td>
                      </tr>
                      <tr>
                        <td width="14%">Description</td>
                        <td width="2%">&nbsp;</td>
                        <td width="84%"><div class="col-lg-6">
                            <div class="form-group">
                              <textarea id="myTextarea" name="descript" class="form-control" placeholder="Enter Description"><?php echo stripslashes($row_edit_about['descript']);?></textarea>
                            </div>
                          </div></td>
                      </tr>
                      <tr>
                        <td width="15%">Existing Image</td>
                        <td width="3%">&nbsp;</td>
                        <td width="82%" id="show_img"><?php 
						 $sql_img="SELECT * FROM ".DB_TOUR_IMAGE." WHERE tour_id='".$_REQUEST['id']."' ORDER BY id ASC ";
						  $qry_img=mysqli_query($link,$sql_img) or die (mysqli_error($link));
						  $num_img=mysqli_num_rows($qry_img);
						  if($num_img>0)
							  {	  
								  while($row_img=mysqli_fetch_array($qry_img))
								  { ?>
                          <img src="../../uploads/tour/<?php echo $row_img['image_name']?>" alt="" width="100" />&nbsp;<a style="cursor:pointer; color:#FF0000;" onclick="delete_img(<?php echo $row_img['id']?>,<?php echo $row_img['tour_id']?>)"><i class="fa fa-remove fa-fw"></i></a>
                          <?php } }?></td>
                      </tr>
                      <tr class="alt-row">
                        <td width="15%">Multiple Image</td>
                        <td width="3%">&nbsp;</td>
                        <td width="82%"><label class="upload_img_main_box">
                          <input type="file" id="files" name="multi_file[]" multiple="multiple" style="display:none;">
                          <div class="uploadpicbutton_wrapper">
                            <div class="uploadpicbutton"> <i class="fa fa-cloud-upload"></i> Upload Photos </div>
                          </div>
                          </label></td>
                      </tr>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="3"><input type="submit" value="Submit" class="btn btn-success"/>
                          <a href="javascript:history.back()" class="btn btn-default">Cancel</a></td>
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
	
	$upload_dir='../../uploads/tour/';

	
	$file_name_image='';
	if($_FILES['image_name']['name']!="")

			{
				$file_explode = explode(".",$_FILES['image_name']['name']);
					$file_name_image=time()."_".str_replace(" ","_",$_FILES['image_name']['name']);
					$tmp_name=$_FILES['image_name']['tmp_name'];
					move_uploaded_file($tmp_name,$upload_dir.$file_name_image);
					$sql_inset_post="UPDATE ".DB_TOUR_PLAN." 
                    SET 
					image_name='".$file_name_image."'
                    where id='".$_REQUEST['id']."'";
					$qry_inset_post	=mysqli_query($link,$sql_inset_post);

		    }
		 $sql_inset_post="UPDATE ".DB_TOUR_PLAN." 
                    SET
					main_title = '".ConvertRealString($_REQUEST['main_title'])."',
					price = '".ConvertRealString($_REQUEST['price'])."',
					con_id = '".ConvertRealString($_REQUEST['con_id'])."',
					cty_id = '".ConvertRealString($_REQUEST['cty_id'])."',
					descript = '".ConvertRealString($_REQUEST['descript'])."'
					
                    where id='".$_REQUEST['id']."'";
		$qry_inset_post	=mysqli_query($link,$sql_inset_post) or die(mysqli_error($link));
		
		if($_FILES['multi_file']['name'][0]!='')
		{
		$total_image=count($_FILES['multi_file']['name']);
			for($i=0;$i<$total_image;$i++)
			{
			
			$_FILES['multi_file']['name'][$i];
			
			$file_explode = explode(".",$_FILES['multi_file']['name'][$i]);
			
			if($file_explode[1] == 'jpg'||$file_explode[1] == 'jpeg'||$file_explode[1] == 'png')
				{
					$file_name=time()."_".str_replace(" ","_",$_FILES['multi_file']['name'][$i]);
					$tmp_name=$_FILES['multi_file']['tmp_name'][$i];
					move_uploaded_file($tmp_name,$upload_dir.$file_name);
					
					
												
					  $sql_inset_post="INSERT INTO ".DB_TOUR_IMAGE." 
									SET
									tour_id=".$_REQUEST['id'].",
									image_name='".$file_name."'";
								
					$qry_inset_post	=mysqli_query($link,$sql_inset_post) or die(mysqli_error($link));
					
				}
			}
		
		}
	    
	if($qry_inset_post)
		{
		$_SESSION['MSG_ALERT'] = "Latest Information updated successfully";
		$_SESSION['IMG_PATH'] ="fa-check";
		$_SESSION['DIV_CLASS'] ="alert-success"; 
		redirect_mp('manage_tour');
		
		exit();	
	}
	else
	{
	    $_SESSION['MSG_ALERT'] = "Latest Information already exist";
		$_SESSION['IMG_PATH'] ="fa-exclamation-triangle";
		$_SESSION['DIV_CLASS'] = "alert-warning";
		redirect_mp('manage_tour');
	}
		
	}
 ?>
<script type="text/javascript">
	$(document).ready(function () {
	  
//--------------------------------- Insert validation   ---------------------------------
		
	  	$('#add_frm').validate({
		rules: {
		  main_title: 'required',
		  price: 'required',
		  con_id: 'required',
		  cty_id: 'required',
		  image_name: 'required'
		},
		messages: {
			main_title: "Please enter tour name...!",
			price: "Please enter tour price...!",
			con_id: "Please enter country name...!",
			cty_id: "Please enter city name...!",
			image_name: "Please upload image...!"
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
		
//--------------------------------- Edit validation   -----------------------------------

	  	$('#edit_frm').validate({
		rules: {
		  main_title: 'required',
		  price: 'required',
		  con_id: 'required',
		  cty_id: 'required'
		},
		messages: {
			main_title: "Please enter tour name...!",
			price: "Please enter tour price...!",
			con_id: "Please enter country name...!",
			cty_id: "Please enter city name...!"
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
//------------------------------ Image validation ---------------------------------------
	  function validateimg_s(file) {
		var ext = file.split(".");
		ext = ext[ext.length-1].toLowerCase();      
		var arrayExtensions = ["jpg" , "jpeg", "png"];

		if (arrayExtensions.lastIndexOf(ext) == -1) {
			$("#image_name_alert").html("Wrong extension type.");
			$('#image_name').focus();
			$("#image_name").val("");
		}else{
			$("#image_name_alert").css('display','none');
		}
	}
//------------------------------ City Listing -----------------------------------------------
	$('#con_id').on('change',function(e){
			 e.preventDefault();
			 var cat=$('#con_id').val();
			 $.ajax({
				type: 'post',
				url: '../ajax/get_city_list.php',
				data: {'cty': cat},
				success: function(data)
				{
					//alert(data);
					$('#cty_id').html(data);
				}
			 });
		});
//------------------------------ Multiple Image  -----------------------------------------------
$(document).ready(function() {
  if (window.File && window.FileList && window.FileReader) {
    $("#files").on("change", function(e) {
		$(".pip").css('display','none');
      var files = e.target.files,
        filesLength = files.length;
      for (var i = 0; i < filesLength; i++) {
        var f = files[i]
        var fileReader = new FileReader();
        fileReader.onload = (function(e) {
          var file = e.target;
          $("<span class=\"pip\">" +
            "<img class=\"thumb\" src=\"" + e.target.result + "\" />" +
            "</span>").insertAfter("#files");
         
          
        });
        fileReader.readAsDataURL(f);
      }
    });
  } else {
    alert("Your browser doesn't support to File API")
  }
});
function delete_img(ID,TID)
	{
	
	jQuery.ajax({
	url: "../ajax/ajax_delete_img.php",
	data:'id='+ID+'& tourid='+TID,
	type: "POST",
	success:function(data){
	//alert(data);
document.getElementById("show_img").innerHTML=data;
		
	},
	error:function (){}
	});
	}
//------------------------------ Export Tour  -----------------------------------------------
$(document).ready(function () {
	$('#export_tour').DataTable({
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
					  title: '<?=SITETITLE?> Tour',
					  filename: '<?=SITETITLE?>-Tour'
					}, {
					  extend: 'excel',
					  exportOptions : {
					   columns : [ 1, 2, 3, 4]
					  },
					  title: '<?=SITETITLE?> Tour',
					  filename: '<?=SITETITLE?>-Tour'
					}, {
					  extend: 'csv',
					  exportOptions : {
					   columns : [ 1, 2, 3, 4]
					  },
					  title: '<?=SITETITLE?> Tour',
					  filename: '<?=SITETITLE?>-Tour'
					}, {
					  extend: 'print',
					  text: 'Print',
					  title: '<?=SITETITLE?> Tour',
					  filename: '<?=SITETITLE?>-Tour',
					  exportOptions : {
					   columns : [ 1, 2, 3, 4]
					  },
					  customize: function(win) {
						  $(win.document.body)
							.prepend(
								'<img src="<?=URL?>assets/img/logo.png" style="position:absolute; top:0; left:0;width:100px;" />'
							);
							$(win.document.body).find('table')
								.css('margin-top', '100pt');
							}
					},]
				}
			],
	  lengthMenu:[
		[5,10,25,50,100,-1],
		[5,10,25,50,100,"All"]
	  ]
	});
});
</script>