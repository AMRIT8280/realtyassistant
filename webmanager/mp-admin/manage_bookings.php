<?php
ob_start();
require("../template.php");
if ($_SESSION['admin_user_id'] == '')          redirect('index');
require_once("../authonication.php");
if (isset($_POST['mode'])) {
  if ($_POST['mode'] == 'insert_about')       insert_about();
  if ($_POST['mode'] == 'delete_about')      delete_about();
  if ($_POST['mode'] == 'delete_chk_about')    delete_chk_about();
  if ($_POST['mode'] == 'active_chk_about')    active_chk_about();
  if ($_POST['mode'] == 'inactive_chk_about')    inactive_chk_about();
  if ($_POST['mode'] == 'edit_about')        edit_about();


  if ($_POST['mode'] == 'edit')            disphtml("edit();");

  if ($_POST['mode'] == '')            disphtml("main();");
} else                        disphtml("main();");


ob_end_flush();
?>

<form name="frm_opts" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
  <input type="hidden" name="mode" value="">
  <input type="hidden" name="pageNo" value="<?php if (isset($_POST['pageNo'])) echo $_POST['pageNo'];
                                            else {
                                              echo 1;
                                            } ?>">
  <input type="hidden" name="url" value="<?php echo $_SERVER['PHP_SELF'] ?>">
  <input type="hidden" name="id" value="">
  <input type="hidden" name="hold_page" value="">
  <input type="hidden" name="menu_cat" id="menu_cat" />
  <input type="hidden" name="menu_subcat" id="menu_subcat" />
  <input type="hidden" name="cp" id="cp" />
  <input type="hidden" name="np" id="np" />
  <?php if (isset($_REQUEST['scarch_main_title'])) { ?>
    <input type="hidden" name="scarch_main_title" id="scarch_main_title" value="<?php echo $_REQUEST['scarch_main_title']; ?>" />
  <?php } ?>
</form>
<?php
function main()
{
  global $link;
  $con = '';
  if (isset($_REQUEST['scarch_main_title'])) {
    $product = $_REQUEST['scarch_main_title'];
    $con .= " and main_title_id=" . $product . "";
  }


  if ($_SESSION["type_id"] == 3) {
    $con .= " AND agent_code='" . $_SESSION["user_id"] . "'";
  }

  $sql_list_about = "SELECT * FROM " . DB_BOOKING . "  WHERE 1 " . $con . " AND status!='D' ORDER BY id DESC";
  $qry_list_about = mysqli_query($link, $sql_list_about);
  $num_list_about = mysqli_num_rows($qry_list_about);


  $countShow = "SELECT count(*) FROM " . DB_BOOKING . "  WHERE 1 " . $con . " AND status!='D' ORDER BY id DESC";
  $qry_countshow = mysqli_query($link, $countShow) or die(mysqli_error($link));
  $count = mysqli_num_rows($qry_countshow);






?>
  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12 breadcrumb-header">
          <div id="breadcrumb" class="tooltip-demo"> <a href="<?= URL ?>" title="Go to Home" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-home fa-fw"></i> Home</a><a href="#" class="current">Bookings</a></div>
        </div>
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-lg-12">
          <div class="panel tabbed-panel panel-success">
            <div class="panel-heading clearfix">
              <div class="panel-title pull-left"><a data-toggle="collapse" href="#collapseOne" aria-expanded="false"><strong>Bookings Details</strong></a></div>
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
                <?php if (isset($_SESSION['MSG_ALERT'])) { ?>
                  <div id="hide_allert" class="alert  <?php echo $_SESSION['DIV_CLASS'] ?> alert-dismissible"><strong><i class="fa <?php echo $_SESSION['IMG_PATH'] ?> fa-fw"></i> Alert!</strong> &nbsp;&nbsp;
                    <?php echo  $_SESSION['MSG_ALERT'];
                    unset($_SESSION['MSG_ALERT']);
                    unset($_SESSION['IMG_PATH']);
                    unset($_SESSION['DIV_CLASS']);
                    ?>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  </div>
                <?php } ?>
                <div class="tab-pane fade in active" id="tab-success-1">
                  <div class="panel-body">
                    <form name="frm_chk_about" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                      <input type="hidden" name="mode" value="" />
                      <div class="table-responsive">
                        <table id="export_table" class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th width="10">#</th>
                              <th>Buyer Details</th>
                              <th>Unit Details</th>
                              <th>Other Details</th>
                              <th>Transaction Details</th>

                              <th>Status</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php if ($num_list_about > 0) { ?>
                              <?php
                              $cnt = $GLOBALS['start'] + 1;
                              while ($row_list_about = mysqli_fetch_array($qry_list_about)) {
                              ?>
                                <tr>
                                  <td><input class="cheak_all" type="checkbox" id="public_chkbox" name="public_chkbox[]" value="<?php echo $row_list_about['id']; ?>" autocomplete="off"></td>


                                  <td>
                                    Name : <?php echo ucfirst($row_list_about['full_name']); ?><br>
                                    Phone : <?php echo $row_list_about['phone']; ?><br>
                                    Email : <?php echo $row_list_about['email']; ?><br>
                                    Address : <?php echo $row_list_about['address']; ?>, <?php echo $row_list_about['city']; ?>, <?php echo $row_list_about['state']; ?> - <?php echo $row_list_about['pin']; ?><br>
                                  </td>

                                  <td>
                                    <?php
                                    $unit_details = get_room("id=" . $row_list_about["room_id"]);
                                    //print_r($unit_details);
                                    //exit();
                                    $unit_details = $unit_details[0];
                                    ?>
                                    Unit Number : <?php echo strtoupper($unit_details['room_number']); ?><br>
                                    Unit Name : <?php echo ucfirst($unit_details['room_name']); ?><br>
                                    Floor Number : Floor-<?php echo strtoupper($unit_details['floor_number']); ?><br>
                                    Unit Size : <?php echo strtoupper($unit_details['size_bhk']) . " (" . $unit_details['size_sqft'] . " sq.ft.)"; ?>
                                  </td>


                                  <td>
                                    Type : <?php echo ucfirst($row_list_about['booking_blocking']); ?><br>
                                    Amount : <?php echo number_format($row_list_about['amount'], 2); ?><br>
                                    Time : <?php echo $row_list_about['created_at']; ?>
                                  </td>

                                  <td>
                                    Order Id: <?php echo $row_list_about['order_id']; ?><br>
                                    TNX Id: <?php echo $row_list_about['tnx_id']; ?><br>
                                    TNX Amount: <?php echo number_format($row_list_about['amount'], 2); ?><br>
                                  </td>

                                  <td><?php if (strtolower($row_list_about['status']) == 'success') { ?>
                                      <span class="btn btn-success btn-xs">Success</span>
                                    <?php } else if (strtolower($row_list_about['status']) == 'cancel') { ?>
                                      <span class="btn btn-danger btn-xs">Cancel</span>
                                    <?php }else{
                                      ?>
                                      <span class="btn btn-warning btn-xs"><?php echo ucfirst($row_list_about['status']);?></span>
                                      <?php
                                    } ?>
                                  </td>
                                  <td class="tooltip-demo"><a title="View" data-toggle="tooltip" data-placement="bottom" href="javascript:Edit('<?php echo $row_list_about['id'] ?>','<?php echo $GLOBALS['start'] ?>');" class="btn btn-info btn-circle"><i class="fa fa-eye fa-fw"></i></a>

                                    <!-- <a title="Delete" data-toggle="tooltip" data-placement="bottom" href="javascript:Delete('<?php echo $row_list_about['id'] ?>','<?php echo $GLOBALS['start'] ?>');" class="btn btn-danger btn-circle"><i class="fa fa-trash fa-fw"></i></a> -->
                                  </td>
                                </tr>
                            <?php }
                            } ?>
                          </tbody>
                        </table>

                        <?php
                        if ($_SESSION["type_id"] == 1) {
                        ?>
                        <div class="col-lg-2" id="on_option" style="display:none;">
                          <div class="row" style="display: flex;">
                            <select class="form-control" name="choose_action" id="choose_action">
                              <option value="0">Choose action</option>
                              <!--  <option value="D">Delete</option> -->
                              <option value="success">Success</option>
                              <option value="cancel">Cancel</option>
                            </select>
                            &nbsp;
                            <button type="button" class="btn btn-success btn-sm" onclick="return delete_chk_about();">Apply</button>
                          </div>
                        </div>
                        <?php } ?>
                      </div>
                      <!-- /.table-responsive -->

                    </form>
                  </div>
                </div>
                <script language="javascript">
                  function Delete(ID, record_no) {
                    var UserResp = window.confirm("Are you sure to delete this Register?");
                    if (UserResp == true) {
                      document.frm_opts.mode.value = 'delete_about';
                      document.frm_opts.id.value = ID;
                      document.frm_opts.hold_page.value = record_no * 1;
                      document.frm_opts.submit();
                    }

                  }

                  function Edit(ID, record_no, cat, val) {
                    document.frm_opts.mode.value = 'edit';
                    document.frm_opts.id.value = ID;
                    document.frm_opts.hold_page.value = record_no * 1;
                    document.frm_opts.submit();
                  }

                  function delete_chk_about() {
                    var do_action = document.frm_chk_about.choose_action.value;
                    var flag = false;

                    for (i = 0; i < document.frm_chk_about.elements['public_chkbox[]'].length; i++) {

                      if (document.frm_chk_about.elements['public_chkbox[]'][i].checked == true) {
                        flag = true;
                        break;
                      }
                    }

                    if (document.frm_chk_about.choose_action.value == 0) {
                      alert("Please select the action");
                      document.frm_chk_about.choose_action.focus();
                      return false;
                    }

                    if (do_action == 'D') {
                      document.frm_chk_about.mode.value = 'delete_chk_about';
                    }
                    if (do_action == 'A') {
                      document.frm_chk_about.mode.value = 'active_chk_about';
                    }
                    if (do_action == 'I') {
                      document.frm_chk_about.mode.value = 'inactive_chk_about';
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
                              <td width="15%"> User Name <font color="#ff0000">*</font>
                              </td>
                              <td width="3%">&nbsp;</td>
                              <td width="87%">
                                <div class="col-lg-6">
                                  <div class="form-group"> <span class="input">
                                      <input type="text" class="form-control" id="main_title" name="main_title" placeholder="Enter Name" autocomplete="off">
                                    </span></div>
                                  <!-- /input-group -->
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td width="15%">Email <font color="#ff0000">*</font>
                              </td>
                              <td width="3%">&nbsp;</td>
                              <td width="87%">
                                <div class="col-lg-6">
                                  <div class="form-group">
                                    <input type="email" class="form-control" id="contact_mail" name="contact_mail" placeholder="Enter Email" autocomplete="off">
                                  </div>
                                  <!-- /input-group -->
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td width="15%">Mobile No <font color="#ff0000">*</font>
                              </td>
                              <td width="3%">&nbsp;</td>
                              <td width="87%">
                                <div class="col-lg-6">
                                  <div class="form-group">
                                    <input type="text" class="form-control" id="mobile_no" name="mobile_no" placeholder="Enter Mobile" autocomplete="off">
                                  </div>
                                  <!-- /input-group -->
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td width="15%">Password <font color="#ff0000">*</font>
                              </td>
                              <td width="3%">&nbsp;</td>
                              <td width="87%">
                                <div class="col-lg-6">
                                  <div class="form-group">
                                    <input type="text" class="form-control" id="passw" name="passw" placeholder="Enter Password" autocomplete="off">
                                  </div>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="3">&nbsp;</td>
                            </tr>
                            <tr>
                              <td colspan="3"><input type="hidden" name="id" value="">
                                <input type="hidden" name="hold_page" value="">
                                <input type="submit" value="Submit" class="btn btn-success">
                                <a href="manage_bookings.php" class="btn btn-default">Cancel</a>
                              </td>
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

function insert_about()
{
  global $link;

  $sql_inset_post = "INSERT INTO " . DB_BOOKING . " 

		SET 
		main_title = '" . ConvertRealString($_REQUEST['main_title']) . "',
		contact_mail = '" . ConvertRealString($_REQUEST['contact_mail']) . "',
		mobile_no = '" . ConvertRealString($_REQUEST['mobile_no']) . "',
		passw = '" . md5($_REQUEST['passw']) . "'";

  $qry_inset_post  = mysqli_query($link, $sql_inset_post);



  $_SESSION['MSG_ALERT'] = "Latest Information inserted successfully";
  $_SESSION['IMG_PATH'] = "fa-check";
  $_SESSION['DIV_CLASS'] = "alert-success";

  redirect_mp('manage_bookings');
  exit();
}

function delete_about()
{

  global $link;
  $sql_delete_about = "UPDATE " . DB_BOOKING . " 
                    SET 
					status= 'D'
                    where id='" . $_REQUEST['id'] . "'";
  $qry_delete_about = mysqli_query($link, $sql_delete_about) or die(mysqli_error());

  $_SESSION['MSG_ALERT'] = "Latest member has been successfully deleted.";
  $_SESSION['IMG_PATH'] = "fa-ban";
  $_SESSION['DIV_CLASS'] = "alert-danger";
  redirect_mp('manage_bookings');
  exit();
}

function delete_chk_about()
{
  global $link;
  $count_del = 0;
  foreach ($_REQUEST['public_chkbox'] as $val) {
    if ($val != 'on') {

      $sql_deletepublication = "UPDATE " . DB_BOOKING . " 
											SET 
											status= 'D'
											where id='" . $val . "'";

      $qry_deletepublication  = mysqli_query($link, $sql_deletepublication) or die(mysqli_error($link));

      $count_del++;
    }
  }

  if ($count_del > 0) {
    $_SESSION['MSG_ALERT'] = "Successfully deleted.";
    $_SESSION['IMG_PATH'] = "fa-ban";
    $_SESSION['DIV_CLASS'] = "alert-danger";
    redirect_mp('manage_bookings');
    exit();
  }
}
function active_chk_about()
{
  global $link;
  $count_del = 0;
  foreach ($_REQUEST['public_chkbox'] as $val) {
    if ($val != 'on') {
      $sql_deletepublication = "UPDATE " . DB_BOOKING . " 
											SET 
											status= 'A'
											where id='" . $val . "'";

      $qry_deletepublication  = mysqli_query($link, $sql_deletepublication) or die(mysqli_error($link));

      $count_del++;
    }
  }

  if ($count_del > 0) {
    $_SESSION['MSG_ALERT'] = "Updated successfully";
    $_SESSION['IMG_PATH'] = "fa-check";
    $_SESSION['DIV_CLASS'] = "alert-success";
    redirect_mp('manage_bookings');
    exit();
  }
}
function inactive_chk_about()
{
  global $link;
  $count_del = 0;
  foreach ($_REQUEST['public_chkbox'] as $val) {
    if ($val != 'on') {
      $sql_deletepublication = "UPDATE " . DB_BOOKING . " 
											SET 
											status= 'I'
											where id='" . $val . "'";

      $qry_deletepublication  = mysqli_query($link, $sql_deletepublication) or die(mysqli_error($link));


      $bookings_details = get_bookings("id=" . $val)[0];
      $room_details = get_room("id=" . $bookings_details["room_id"])[0];
      $sql_update_room = "UPDATE " . DB_AP_ROOM . " 
          SET 
          booking_status= 'available'
          where id='" . $room_details["id"] . "'";
      $sql_update_room_exe  = mysqli_query($link, $sql_update_room) or die(mysqli_error($link));

      $count_del++;
    }
  }


  if ($count_del > 0) {


    $_SESSION['MSG_ALERT'] = "Updated successfully";
    $_SESSION['IMG_PATH'] = "fa-check";
    $_SESSION['DIV_CLASS'] = "alert-success";
    redirect_mp('manage_bookings');
    exit();
  }
}


?>
<?php
function edit()
{

  global $link;
  $sql_edit_about = "SELECT * FROM " . DB_BOOKING . "  where id ='" . $_REQUEST['id'] . "'";
  $qry_edit_about = mysqli_query($link, $sql_edit_about) or die(mysqli_error($link));
  $row_edit_about = mysqli_fetch_array($qry_edit_about);
  
  $billing_details=$row_edit_about;
  $unit_details=getUnitDetailsByUnitId($row_edit_about['room_id'])["data"];
  $buyer_deatils=get_user($by = "id='".$row_edit_about['user_id']."'")[0];

?>
  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12 breadcrumb-header">
          <div id="breadcrumb" class="tooltip-demo"> <a href="<?= URL ?>" title="Go to Home" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-home fa-fw"></i> Home</a><a href="<?= $_SERVER['PHP_SELF'] ?>">Manage Bookings</a><a href="#" class="current">View</a></div>
        </div>
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-lg-12">
          <div class="panel tabbed-panel panel-success">
            <div class="panel-heading clearfix">
              <div class="panel-title pull-left"><a data-toggle="collapse" href="#collapseOne" aria-expanded="false"><strong><i class="fa fa-edit fa-fw"></i>View Details</strong></a></div>
            </div>
            <div class="panel-body" id="collapseOne" aria-expanded="true" style="background: #eef9f0;margin: 1em;border-radius: 4px;">
              <div class="panel-body">
                <form action="<?php echo  $_SERVER['PHP_SELF'] ?>" method="post" name="edit_frm" id="edit_frm" enctype="multipart/form-data">
                  <input type="hidden" name="mode" value="edit_about">
                  <input type="hidden" name="id" value="<?php echo $_REQUEST['id'] ?>">
                  <div class="table-responsive">
                    <table width="100%">
                      <tbody>
                        <tr>
                          <td colspan="3" style="color:black; background-color: yellowgreen; padding:5px; ">
                            Unit Details:
                          </td>
                        </tr>
                        <tr>
                          <td width="15%"> Apartment Name :</td>
                          <td width="3%">&nbsp;</td>
                          <td width="87%"><?php echo $unit_details["ap_details"]['ap_name']; ?></td>
                        </tr> 
                        <tr>
                          <td width="15%"> Address :</td>
                          <td width="3%">&nbsp;</td>
                          <td width="87%"><?php echo $unit_details["address_details"]['city'].", ".$unit_details["address_details"]['country']; ?></td>
                        </tr> 
                        <tr>
                          <td width="15%"> Unit Number :</td>
                          <td width="3%">&nbsp;</td>
                          <td width="87%"><?php echo $unit_details["unit_details"]['room_number']; ?></td>
                        </tr> 
                        <tr>
                          <td width="15%"> Unit Size :</td>
                          <td width="3%">&nbsp;</td>
                          <td width="87%"><?php echo $unit_details["unit_details"]['size_bhk']." (".$unit_details["unit_details"]['size_sqft']."sqft.)"; ?></td>
                        </tr> 
                        <tr>
                          <td width="15%"> Blocking Amount :</td>
                          <td width="3%">&nbsp;</td>
                          <td width="87%"><?php echo number_format($unit_details["unit_details"]['blocking_amount'],2); ?></td>
                        </tr> 
                        <tr>
                          <td width="15%"> Booking Amount :</td>
                          <td width="3%">&nbsp;</td>
                          <td width="87%"><?php echo number_format($unit_details["unit_details"]['booking_amount'],2); ?></td>
                        </tr> 
                        <tr>
                          <td width="15%"> Total Price :</td>
                          <td width="3%">&nbsp;</td>
                          <td width="87%"><?php echo number_format($unit_details["unit_details"]['price'],2); ?></td>
                        </tr> 
                        <tr>
                          <td width="15%"> Building & Floor :</td>
                          <td width="3%">&nbsp;</td>
                          <td width="87%"><?php echo "Building: ".$unit_details["building_floor"]['building']." & Floor: ".$unit_details["building_floor"]['floor']; ?></td>
                        </tr> 
                        
                        <tr>
                          <td colspan="3">&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="3" style="color:black; background-color: yellowgreen; padding:5px; ">
                            Buyer Details:
                          </td>
                        </tr>
                        <tr>
                          <td width="15%"> Buyer Name :</td>
                          <td width="3%">&nbsp;</td>
                          <td width="87%"><?php echo ucfirst($buyer_deatils["main_title"]); ?></td>
                        </tr>
                        <tr>
                          <td width="15%"> Mobile No :</td>
                          <td width="3%">&nbsp;</td>
                          <td width="87%"><?php echo $buyer_deatils["mobile_no"]; ?></td>
                        </tr>
                        <tr>
                          <td width="15%"> Email address :</td>
                          <td width="3%">&nbsp;</td>
                          <td width="87%"><?php echo $buyer_deatils["contact_mail"]; ?></td>
                        </tr>
                        <tr>
                          <td width="15%"> PAN Number :</td>
                          <td width="3%">&nbsp;</td>
                          <td width="87%"><?php echo $buyer_deatils["pan"]; ?></td>
                        </tr>
                        <tr>
                          <td width="15%"> Address :</td>
                          <td width="3%">&nbsp;</td>
                          <td width="87%"><?php echo $buyer_deatils["address"].", ".$buyer_deatils["city"].", ".$buyer_deatils["state"]." - ".$buyer_deatils["pin"]; ?></td>
                        </tr>
                        
                        <tr>
                          <td colspan="3">&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="3" style="color:black; background-color: yellowgreen; padding:5px; ">
                            Billing Details:
                          </td>
                        </tr>
                        <tr>
                          <td width="15%"> Billing Name :</td>
                          <td width="3%">&nbsp;</td>
                          <td width="87%"><?php echo ucfirst($billing_details["full_name"]); ?></td>
                        </tr>
                        <tr>
                          <td width="15%"> Mobile No :</td>
                          <td width="3%">&nbsp;</td>
                          <td width="87%"><?php echo $billing_details["phone"]; ?></td>
                        </tr>
                        <tr>
                          <td width="15%"> Email address :</td>
                          <td width="3%">&nbsp;</td>
                          <td width="87%"><?php echo $billing_details["email"]; ?></td>
                        </tr>
                        <tr>
                          <td width="15%"> PAN Number :</td>
                          <td width="3%">&nbsp;</td>
                          <td width="87%"><?php echo $billing_details["pan"]; ?></td>
                        </tr>
                        <tr>
                          <td width="15%"> Address :</td>
                          <td width="3%">&nbsp;</td>
                          <td width="87%"><?php echo $billing_details["address"].", ".$billing_details["city"].", ".$billing_details["state"]." - ".$billing_details["pin"]; ?></td>
                        </tr>


                        <tr>
                          <td colspan="3">&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="3" style="color:black; background-color: yellowgreen; padding:5px; ">
                            Transaction Details:
                          </td>
                        </tr>
                        <tr>
                          <td width="15%"> Booking for :</td>
                          <td width="3%">&nbsp;</td>
                          <td width="87%">Unit <?php echo ucfirst($billing_details["booking_blocking"]); ?></td>
                        </tr>
                        <tr>
                          <td width="15%"> Booking Id :</td>
                          <td width="3%">&nbsp;</td>
                          <td width="87%"><?php echo $billing_details["order_id"]; ?></td>
                        </tr>
                        <tr>
                          <td width="15%"> Transaction Id :</td>
                          <td width="3%">&nbsp;</td>
                          <td width="87%"><?php echo $billing_details["tnx_id"]; ?></td>
                        </tr>
                        <tr>
                          <td width="15%"> Transaction Amount :</td>
                          <td width="3%">&nbsp;</td>
                          <td width="87%"><?php echo number_format($billing_details["amount"],2); ?></td>
                        </tr>
                        <tr>
                          <td width="15%"> Transaction Time :</td>
                          <td width="3%">&nbsp;</td>
                          <td width="87%"><?php echo $billing_details["updated_at"]; ?></td>
                        </tr>
                        <tr>
                          <td width="15%"> Transaction Status :</td>
                          <td width="3%">&nbsp;</td>
                          <td width="87%"><?php echo ucfirst($billing_details["status"]); ?></td>
                        </tr>

                        <tr>
                          <td colspan="3">&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="3" style="color:black; background-color: yellowgreen; padding:5px; ">
                            Agent Details:
                          </td>
                        </tr>
                        <?php
                        $get_agent=get_agent_details($billing_details["agent_code"]);
                        if($get_agent["status"]=="success"){
                          ?>
                          <tr>
                            <td width="15%"> Agent Code :</td>
                            <td width="3%">&nbsp;</td>
                            <td width="87%"><?php echo $billing_details["agent_code"]; ?></td>
                          </tr>
                          <tr>
                            <td width="15%"> Agent Name :</td>
                            <td width="3%">&nbsp;</td>
                            <td width="87%"><?php echo $get_agent["data"]["fullname"]; ?></td>
                          </tr>
                          <tr>
                            <td width="15%"> Agent Phone :</td>
                            <td width="3%">&nbsp;</td>
                            <td width="87%"><?php echo $get_agent["data"]["email"]; ?></td>
                          </tr>
                          <tr>
                            <td width="15%"> Agent Email :</td>
                            <td width="3%">&nbsp;</td>
                            <td width="87%"><?php echo $get_agent["data"]["mobile_no"]; ?></td>
                          </tr>
                          <?php
                        }else{
                          ?>
                          <tr>
                          <td width="15%"></td>
                          <td width="3%">&nbsp;</td>
                          <td width="87%">Agent Details Not Found.</td>
                          </tr>
                          <?php
                        }
                        ?>
                        

                        <tr>
                          <td colspan="3">&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="3">&nbsp;</td>
                        </tr>
                        
                        <tr>
                          <td colspan="3">
                            <a href="javascript:history.back()" class="btn btn-default">Go Back</a>
                          </td>
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

  $sql_inset_post = "UPDATE " . DB_BOOKING . " 
                    SET
					main_title = '" . ConvertRealString($_REQUEST['main_title']) . "',
					contact_mail = '" . ConvertRealString($_REQUEST['contact_mail']) . "',
					mobile_no = '" . ConvertRealString($_REQUEST['mobile_no']) . "'
					
                    where id='" . $_REQUEST['id'] . "'";
  $qry_inset_post  = mysqli_query($link, $sql_inset_post) or die(mysqli_error($link));


  if ($qry_inset_post) {
    $_SESSION['MSG_ALERT'] = "Latest Information updated successfully";
    $_SESSION['IMG_PATH'] = "fa-check";
    $_SESSION['DIV_CLASS'] = "alert-success";
    redirect_mp('manage_bookings');

    exit();
  } else {
    $_SESSION['MSG_ALERT'] = "Latest Information already exist";
    $_SESSION['IMG_PATH'] = "fa-exclamation-triangle";
    $_SESSION['DIV_CLASS'] = "alert-warning";
    redirect_mp('manage_bookings');
  }
}
?>
<script type="text/javascript">
  $(document).ready(function() {

    //--------------------------------- Insert validation   ---------------------------------

    /*$('#add_frm').validate({
		rules: {
		  main_title: 'required',
		  addrss: 'required',
		  image_name: 'required'
		},
		messages: {
			main_title: "Please enter volunteer name...!",
			addrss: "Please enter volunteer platform...!",
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
	  });*/

    //--------------------------------- Edit validation   -----------------------------------
    $('#edit_frm').validate({
      rules: {
        main_title: 'required',
        contact_mail: 'required email',
        mobile_no: 'required number'
      },
      errorElement: 'label',
      errorPlacement: function(error, element) {
        error.addClass('has-warning');
        element.closest('.form-group').append(error);
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