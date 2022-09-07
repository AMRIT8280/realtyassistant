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
  if(isset($_GET["ap_id"])){
    $appartment_id = $_GET["ap_id"];
  }else{
    redirect_mp("manage_appartment");
  }
  
  

  global $link;
  $con = '';
  if (isset($_REQUEST['scarch_main_title'])) {
    $product = $_REQUEST['scarch_main_title'];
    $con = " and main_title_id=" . $product . "";
  }
  $sql_list_about = "SELECT * FROM " . DB_AP_ROOM . "  WHERE 1 AND `ap_id`=" . $appartment_id . " " . $con . " AND status!='D' ORDER BY id DESC";
  $qry_list_about = mysqli_query($link, $sql_list_about);
  $num_list_about = mysqli_num_rows($qry_list_about);


  $countShow = "SELECT count(*) FROM " . DB_AP_ROOM . "  WHERE 1 " . $con . " AND status!='D' ORDER BY id DESC";
  $qry_countshow = mysqli_query($link, $countShow) or die(mysqli_error($link));
  $count = mysqli_num_rows($qry_countshow);
?>
  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12 breadcrumb-header">
          <div id="breadcrumb" class="tooltip-demo"> <a href="<?= URL ?>" title="Go to Home" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-home fa-fw"></i> Home</a> <a href="<?= URL."mp-admin/manage_appartment.php"; ?>" title="Go to Apartment" data-toggle="tooltip" data-placement="bottom">
          Manage Apartment</a><a href="#" class="current">Manage Unit</a></div>
        </div>
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-lg-12">
          <div class="panel tabbed-panel panel-success">
            <div class="panel-heading clearfix">
              <div class="panel-title pull-left"><a data-toggle="collapse" href="#collapseOne" aria-expanded="false"><strong>Manage Unit 
                  </strong></a> - [<?php 
                  $appartment_details=get_appartment("id=".$appartment_id)[0];
                    echo $appartment_details["ap_name"]
                  ?>] </div>
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
                        <table id="dataTables-example" class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th width="10">#</th>
                              <th width="45">SL No.</th>
                              <th>Unit Number</th>
                              <th>Building</th>
                              <th>Floor</th>
                              <th>Size(BHK)</th>
                              <th>Size(Sqft)</th>
                              <th>Price</th>
                              <th>Date</th>
                              <th>Booking Status</th>
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
                                  <td>
                                  <?php
                                    if (stripslashes($row_list_about['booking_status']) != 'booked') { ?>
                                    <input class="cheak_all" type="checkbox" id="public_chkbox" name="public_chkbox[]" value="<?php echo $row_list_about['id']; ?>" autocomplete="off">
                                    <?php
                                    }
                                  ?>
                                  </td>
                                  <td><?php echo $cnt++ ?></td>
                                  <td><?php echo $row_list_about['room_number']; ?></td>
                                  <td><?php
                                    echo get_building_name($room_id=$row_list_about['id'])["building"];
                                  ?></td>
                                  <td><?php echo $row_list_about['floor_number']; ?></td>
                                  <td><?php echo $row_list_about["size_bhk"]; ?></td>
                                  <td><?php echo $row_list_about["size_sqft"]; ?></td>
                                  <td><?php echo $row_list_about['price']; ?></td>
                                  <td><?php echo explode(" ",$row_list_about['date_time'])[0]; ?></td>
                                  <td>
                                    <?php
                                    if (stripslashes($row_list_about['booking_status']) == 'booked') { ?>
                                      <span class="btn btn-danger btn-xs">Booked</span>
                                    <?php } else { ?>
                                      <span class="btn btn-success btn-xs">Available</span>
                                    <?php } ?>
                                </td>
                                  
                                  <td><?php if (stripslashes($row_list_about['status']) == 'A') { ?>
                                      <span class="btn btn-success btn-xs">Active</span>
                                    <?php } else { ?>
                                      <span class="btn btn-danger btn-xs">Inactive</span>
                                    <?php } ?>
                                  </td>
                                  <td class="tooltip-demo">
                                  <?php
                                    if (stripslashes($row_list_about['booking_status']) != 'booked') { ?>
                                      <a title="Edit" data-toggle="tooltip" data-placement="bottom" href="javascript:Edit('<?php echo $row_list_about['id'] ?>','<?php echo $GLOBALS['start'] ?>');" class="btn btn-info btn-circle"><i class="fa fa-edit fa-fw"></i></a>
                                      
                                      <a title="Delete" data-toggle="tooltip" data-placement="bottom" href="javascript:Delete('<?php echo $row_list_about['id'] ?>','<?php echo $GLOBALS['start'] ?>');" class="btn btn-danger btn-circle"><i class="fa fa-trash fa-fw"></i></a>
                                    <?php
                                    }
                                  ?></td>
                                </tr>
                            <?php }
                            } ?>
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
                  function Delete(ID, record_no) {
                    var UserResp = window.confirm("Are you sure to delete this Banner?");
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
                      <input type="hidden" name="appartment_id" value="<?php echo $_GET["ap_id"] ?>">
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
                              <td width="14%">Select Building & Floor <font color="#ff0000">*</font>
                              </td>
                              <td width="2%">&nbsp;</td>
                              <td width="84%">
                                <div class="col-lg-3">
                                  <div class="form-group">
                                    <select class="form-control" name="building" id="building">
                                      <option value="">Choose Building</option>
                                      <?php
                                      $all_ap_building_floors = get_appartment("id=".$_GET["ap_id"]);
                                      $building_floors = json_decode($all_ap_building_floors[0]["building_floors"], true);
                                      foreach ($building_floors as $key=>$building_floor) { ?>
                                        <option value="<?php echo $key; ?>">
                                          <?php echo $building_floor['building']; ?>
                                        </option>
                                      <?php }
                                      ?>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-lg-3">
                                  <div class="form-group">
                                    <select class="form-control" name="floor" id="floor">
                                      <option value="">Choose Floor</option>
                                      <script>
                                        $(document).ready(function() {
                                          $(document).on("change", "#building", function() {
                                            $("#floor").html(`<option value="">Choose Floor</option>`);
                                            var building_id = $(this).val();
                                            var var_all_building_floor = <?php echo json_encode($building_floors); ?>;
                                            for (i=0;i<=var_all_building_floor[building_id]["floor"]; i++){
                                              if(i==0){
                                                $("#floor").append(`<option value="${i}">Ground Floor</option>`);
                                              }else{
                                                $("#floor").append(`<option value="${i}">Floor-${i}</option>`);
                                              }
                                            }
                                          });
                                        });
                                      </script>
                                    </select>
                                  </div>
                                </div>
                              </td>
                            </tr>

                            <tr>
                              <td width="14%">Unit Number<font color="#ff0000">*</font>
                              </td>
                              <td width="2%">&nbsp;</td>
                              <td width="84%">
                                <div class="col-lg-6">
                                  <div class="form-group">
                                    <input type="text" class="form-control" id="room_number" name="room_number" placeholder="Enter Unit Number" autocomplete="off">
                                  </div>
                                </div>
                              </td>
                            </tr>

                            <tr>
                              <td width="14%">Unit Name
                              </td>
                              <td width="2%">&nbsp;</td>
                              <td width="84%">
                                <div class="col-lg-6">
                                  <div class="form-group">
                                    <input type="text" class="form-control" id="room_name" name="room_name" placeholder="Enter Unit Name" autocomplete="off">
                                  </div>
                                </div>
                              </td>
                            </tr>

                          <tr>
                            <td width="14%">Unit Size in BHK<font color="#ff0000">*</font>
                            </td>
                            <td width="2%">&nbsp;</td>
                            <td width="84%">
                              <div class="col-lg-6">
                                <div class="form-group">
                                  <input type="text" value="3BHK" class="form-control" id="room_size_bhk" name="room_size_bhk" placeholder="Enter Unit Size eg. 2BHK, 3BHK" autocomplete="off">
                                </div>
                              </div>
                            </td>
                          </tr>

                          <tr>
                            <td width="14%">Unit Size in Sq.Ft.<font color="#ff0000">*</font>
                            </td>
                            <td width="2%">&nbsp;</td>
                            <td width="84%">
                              <div class="col-lg-6">
                                <div class="form-group">
                                  <input type="text" class="form-control" id="room_size_sqft" name="room_size_sqft" placeholder="Enter Unit Size eg. 888" autocomplete="off">
                                </div>
                              </div>
                            </td>
                          </tr>


                            <tr style="display: none;">
                              <td width="14%">Consideration Value<font color="#ff0000">*</font>
                              </td>
                              <td width="2%">&nbsp;</td>
                              <td width="84%">
                                <div class="col-lg-6">
                                  <div class="form-group">
                                    <input type="text" value="50000" class="form-control" id="cons_value" name="cons_value" placeholder="Enter Consideration Value" autocomplete="off">
                                  </div>
                                </div>
                              </td>
                            </tr>

                            <tr style="display: none;">
                              <td width="14%">Other Charges<font color="#ff0000">*</font>
                              </td>
                              <td width="2%">&nbsp;</td>
                              <td width="84%">
                                <div class="col-lg-6">
                                  <div class="form-group">
                                    <input type="text" value="0" class="form-control" id="other_charges" name="other_charges" placeholder="Enter Other Charges" autocomplete="off">
                                  </div>
                                </div>
                              </td>
                            </tr>

                            <tr style="display: none;">
                              <td width="14%">GST<font color="#ff0000">*</font>
                              </td>
                              <td width="2%">&nbsp;</td>
                              <td width="84%">
                                <div class="col-lg-6">
                                  <div class="form-group">
                                    <input type="text" value="10000" class="form-control" id="gst" name="gst" placeholder="Enter GST" autocomplete="off">
                                  </div>
                                </div>
                              </td>
                            </tr>

                            <tr style="display: none;">
                              <td width="14%">Blocking Amount<font color="#ff0000">*</font>
                              </td>
                              <td width="2%">&nbsp;</td>
                              <td width="84%">
                                <div class="col-lg-6">
                                  <div class="form-group">
                                    <input type="text" value="100000" class="form-control" id="blocking_amount" name="blocking_amount" placeholder="Enter Blocking Amount" autocomplete="off">
                                  </div>
                                </div>
                              </td>
                            </tr>

                            <tr style="display: none;">
                              <td width="14%">Booking Amount<font color="#ff0000">*</font>
                              </td>
                              <td width="2%">&nbsp;</td>
                              <td width="84%">
                                <div class="col-lg-6">
                                  <div class="form-group">
                                    <input type="text" value="100000" class="form-control" id="booking_amount" name="booking_amount" placeholder="Enter Booking Amount" autocomplete="off">
                                  </div>
                                </div>
                              </td>
                            </tr>

                            <tr style="display: none;">
                              <td width="14%">Price <font color="#ff0000">*</font>
                              </td>
                              <td width="2%">&nbsp;</td>
                              <td width="84%">
                                <div class="col-lg-3">
                                  <div class="form-group">
                                    <input type="text" value="1800000" class="form-control" id="room_price" name="room_price" placeholder="Enter Price" autocomplete="off">
                                  </div>
                                </div>
                              </td>
                            </tr>

                            <tr style="display: none;">
                              <td width="14%">Date <font color="#ff0000">*</font>
                              </td>
                              <td width="2%">&nbsp;</td>
                              <td width="84%">
                                <div class="col-lg-3">
                                  <div class="form-group">
                                    <input type="date" value="<?php echo date("Y-m-d") ?>" class="form-control" id="main_date" name="main_date" autocomplete="off">
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
                                <a href="manage_unit.php" class="btn btn-default">Cancel</a>
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
  $sql_inset_post = "INSERT INTO " . DB_AP_ROOM . " 
      SET 
      ap_id = '" . ConvertRealString($_REQUEST['appartment_id']) . "',
      room_number='" . ConvertRealString(strtoupper($_REQUEST['room_number'])) . "',
      room_name = '" . ConvertRealString(ucfirst($_REQUEST['room_name'])) . "',
      building_id = '" . ConvertRealString($_REQUEST['building']) . "',
      floor_number = '" . ConvertRealString($_REQUEST['floor']) . "',
      size_bhk = '" . ConvertRealString(strtoupper($_REQUEST['room_size_bhk'])) . "',
      size_sqft = '" . ConvertRealString($_REQUEST['room_size_sqft']) . "',
      consideration_value = '" . ConvertRealString($_REQUEST['cons_value']) . "',
      other_charges = '" . ConvertRealString($_REQUEST['other_charges']) . "',
      gst = '" . ConvertRealString($_REQUEST['gst']) . "',
      blocking_amount = '" . ConvertRealString($_REQUEST['blocking_amount']) . "',
      booking_amount = '" . ConvertRealString($_REQUEST['booking_amount']) . "',
      price = '" . ConvertRealString($_REQUEST['room_price']) . "',
      date_time = '" . ConvertRealString($_REQUEST['main_date']) . "'";

  $qry_inset_post  = mysqli_query($link, $sql_inset_post);
  if ($qry_inset_post) {
    $_SESSION['MSG_ALERT'] = "Latest Information inserted successfully";
    $_SESSION['IMG_PATH'] = "fa-check";
    $_SESSION['DIV_CLASS'] = "alert-success";
  } else {
    $_SESSION['MSG_ALERT'] = "Latest Information not interted!!!";
    $_SESSION['IMG_PATH'] = "fa-exclamation-triangle";
    $_SESSION['DIV_CLASS'] = "alert-warning";
  }

  //redirect_mp('manage_unit');
  redirect_mp_with_param("manage_unit.php?ap_id=".$_REQUEST["appartment_id"]);

  exit();
}

function delete_about()
{
  $result = deleteRecord(DB_AP_ROOM, 'id=' . $_REQUEST['id']);
  $_SESSION['MSG_ALERT'] = "Latest Information has been successfully deleted.";
  $_SESSION['IMG_PATH'] = "fa-ban";
  $_SESSION['DIV_CLASS'] = "alert-danger";
  redirect_mp('manage_unit');
  exit();
}

function delete_chk_about()
{
  global $link;
  $count_del = 0;
  foreach ($_REQUEST['public_chkbox'] as $val) {
    if ($val != 'on') {

      $sql_deletepublication = "UPDATE " . DB_AP_ROOM . " 
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
    redirect_mp('manage_unit');
    exit();
  }
}
function active_chk_about()
{
  global $link;
  $count_del = 0;
  foreach ($_REQUEST['public_chkbox'] as $val) {
    if ($val != 'on') {
      $sql_deletepublication = "UPDATE " . DB_AP_ROOM . " 
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
    redirect_mp('manage_unit');
    exit();
  }
}
function inactive_chk_about()
{
  global $link;
  $count_del = 0;
  foreach ($_REQUEST['public_chkbox'] as $val) {
    if ($val != 'on') {
      $sql_deletepublication = "UPDATE " . DB_AP_ROOM . " 
											SET 
											status= 'I'
											where id='" . $val . "'";

      $qry_deletepublication  = mysqli_query($link, $sql_deletepublication) or die(mysqli_error($link));

      $count_del++;
    }
  }

  if ($count_del > 0) {
    $_SESSION['MSG_ALERT'] = "Updated successfully";
    $_SESSION['IMG_PATH'] = "fa-check";
    $_SESSION['DIV_CLASS'] = "alert-success";
    redirect_mp('manage_unit');
    exit();
  }
}


?>
<?php
function edit()
{


  global $link;
  $sql_edit_about = "SELECT * FROM " . DB_AP_ROOM . "  where id ='" . $_REQUEST['id'] . "'";
  $qry_edit_about = mysqli_query($link, $sql_edit_about) or die(mysqli_error($link));
  $row_edit_about = mysqli_fetch_array($qry_edit_about);


  $apartment_details=get_appartment("id=".$row_edit_about["ap_id"]);
  //print_r($apartment_details);

?>
  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12 breadcrumb-header">
          <div id="breadcrumb" class="tooltip-demo"> <a href="<?= URL ?>" title="Go to Home" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-home fa-fw"></i> Home</a><a href="<?= $_SERVER['PHP_SELF'] ?>?ap_id=<?php echo $row_edit_about["ap_id"]; ?>">Manage Unit</a><a href="#" class="current">Edit Unit</a></div>
        </div>
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-lg-12">
          <div class="panel tabbed-panel panel-success">
            <div class="panel-heading clearfix">
              <div class="panel-title pull-left"><a data-toggle="collapse" href="#collapseOne" aria-expanded="false"><strong><i class="fa fa-edit fa-fw"></i> Edit Unit</strong></a> 
                [<?php 
                  $appartment_details=get_appartment("id=".$row_edit_about["ap_id"])[0];
                    echo $appartment_details["ap_name"]
                  ?>]
            </div>
            </div>
            <div class="panel-body" id="collapseOne" aria-expanded="true" style="background: #eef9f0;margin: 1em;border-radius: 4px;">
              <div class="panel-body">
                <form action="<?php echo  $_SERVER['PHP_SELF'] ?>" method="post" name="edit_frm" id="edit_frm" enctype="multipart/form-data">
                  <input type="hidden" name="mode" value="edit_about">
                  <input type="hidden" name="edit_id" value="<?php echo $_REQUEST['id']; ?>">
                  <input type="hidden" name="ap_id" value="<?php echo $row_edit_about["ap_id"]; ?>">
                  <div class="table-responsive">
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
                            <td width="14%">Select Building & Floor <font color="#ff0000">*</font>
                            </td>
                            <td width="2%">&nbsp;</td>
                            <td width="84%">
                              <div class="col-lg-3">
                                <div class="form-group">
                                  <select class="form-control" name="building" id="building">
                                    <option value="">Choose Building</option>
                                    <?php
                                    $all_ap_building_floors = get_appartment("id=" . $row_edit_about["ap_id"]);
                                    $building_floors = json_decode($all_ap_building_floors[0]["building_floors"], true);
                                    foreach ($building_floors as $key=>$building_floor) {
                                      if ($key == $row_edit_about["building_id"]) {
                                      ?>
                                        <option value="<?php echo $key; ?>" selected>
                                          <?php echo $building_floor['building']; ?>
                                        </option>
                                      <?php
                                      } else {
                                      ?>
                                        <option value="<?php echo $key; ?>">
                                          <?php echo $building_floor['building']; ?>
                                        </option>
                                    <?php
                                      }
                                    }
                                    ?>
                                  </select>
                                </div>
                              </div>
                              <div class="col-lg-3">
                                <div class="form-group">
                                  <select class="form-control" name="floor" id="floor">
                                    <option value="">Choose Floor</option>
                                    <script>
                                      $(document).ready(function() {
                                        $("#floor").html(`<option value="">Choose Floor</option>`);
                                        var building_id= "<?php echo $row_edit_about['building_id']; ?>";
                                        var var_all_building_floor = <?php echo json_encode($building_floors); ?>;
                                        var existsFloorNum = <?php echo $row_edit_about['floor_number']; ?>;
                                        var isSelectedTxt = "";
                                        for (i=0;i<=var_all_building_floor[building_id]["floor"]; i++){
                                          if (i == existsFloorNum) {
                                            isSelectedTxt = "selected";
                                          }
                                          if (i == 0) {
                                            $("#floor").append(`<option value="${i}" ${isSelectedTxt}>Ground Floor</option>`);
                                          } else {
                                            $("#floor").append(`<option value="${i}" ${isSelectedTxt}>Floor - ${i}</option>`);
                                          }
                                          isSelectedTxt = "";
                                        }

                                        $(document).on("change", "#building", function() {
                                            $("#floor").html(`<option value="">Choose Floor</option>`);
                                            var building_id = $(this).val();
                                            var var_all_building_floor = <?php echo json_encode($building_floors); ?>;
                                            for (i=0;i<=var_all_building_floor[building_id]["floor"]; i++){
                                              if(i==0){
                                                $("#floor").append(`<option value="${i}">Ground Floor</option>`);
                                              }else{
                                                $("#floor").append(`<option value="${i}">Floor-${i}</option>`);
                                              }
                                            }
                                        });
                                        


                                      });
                                    </script>
                                  </select>
                                </div>
                              </div>
                            </td>
                          </tr>

                          <tr>
                            <td width="14%">Unit Number<font color="#ff0000">*</font>
                            </td>
                            <td width="2%">&nbsp;</td>
                            <td width="84%">
                              <div class="col-lg-6">
                                <div class="form-group">
                                  <input type="text" value="<?php echo $row_edit_about['room_number']; ?>" class="form-control" id="room_number" name="room_number" placeholder="Enter Unit Number" autocomplete="off">
                                </div>
                              </div>
                            </td>
                          </tr>

                          <tr>
                            <td width="14%">Unit Name
                            </td>
                            <td width="2%">&nbsp;</td>
                            <td width="84%">
                              <div class="col-lg-6">
                                <div class="form-group">
                                  <input type="text" value="<?php echo $row_edit_about['room_name']; ?>" class="form-control" id="room_name" name="room_name" placeholder="Enter Unit Name" autocomplete="off">
                                </div>
                              </div>
                            </td>
                          </tr>

                          <tr>
                            <td width="14%">Unit Size in BHK<font color="#ff0000">*</font>
                            </td>
                            <td width="2%">&nbsp;</td>
                            <td width="84%">
                              <div class="col-lg-6">
                                <div class="form-group">
                                  <input type="text" value="<?php echo $row_edit_about['size_bhk']; ?>" class="form-control" id="room_size_bhk" name="room_size_bhk" placeholder="Enter Unit Size eg. 2BHK, 3BHK" autocomplete="off">
                                </div>
                              </div>
                            </td>
                          </tr>

                          <tr>
                            <td width="14%">Unit Size in Sq.Ft.<font color="#ff0000">*</font>
                            </td>
                            <td width="2%">&nbsp;</td>
                            <td width="84%">
                              <div class="col-lg-6">
                                <div class="form-group">
                                  <input type="text" value="<?php echo $row_edit_about['size_sqft']; ?>" class="form-control" id="room_size_sqft" name="room_size_sqft" placeholder="Enter Unit Size eg. 888" autocomplete="off">
                                </div>
                              </div>
                            </td>
                          </tr>

                          <tr>
                            <td width="14%">Consideration Value<font color="#ff0000">*</font>
                            </td>
                            <td width="2%">&nbsp;</td>
                            <td width="84%">
                              <div class="col-lg-6">
                                <div class="form-group">
                                  <input type="text" value="<?php echo $row_edit_about['consideration_value']; ?>" class="form-control" id="cons_value" name="cons_value" placeholder="Enter Consideration Value" autocomplete="off">
                                </div>
                              </div>
                            </td>
                          </tr>

                          <tr>
                            <td width="14%">Other Charges<font color="#ff0000">*</font>
                            </td>
                            <td width="2%">&nbsp;</td>
                            <td width="84%">
                              <div class="col-lg-6">
                                <div class="form-group">
                                  <input type="text" value="<?php echo $row_edit_about['other_charges']; ?>" class="form-control" id="other_charges" name="other_charges" placeholder="Enter Other Charges" autocomplete="off">
                                </div>
                              </div>
                            </td>
                          </tr>

                          <tr>
                            <td width="14%">GST<font color="#ff0000">*</font>
                            </td>
                            <td width="2%">&nbsp;</td>
                            <td width="84%">
                              <div class="col-lg-6">
                                <div class="form-group">
                                  <input type="text" value="<?php echo $row_edit_about['gst']; ?>" class="form-control" id="gst" name="gst" placeholder="Enter GST" autocomplete="off">
                                </div>
                              </div>
                            </td>
                          </tr>

                          <tr>
                            <td width="14%">Blocking Amount<font color="#ff0000">*</font>
                            </td>
                            <td width="2%">&nbsp;</td>
                            <td width="84%">
                              <div class="col-lg-6">
                                <div class="form-group">
                                  <input type="text" value="<?php echo $row_edit_about['blocking_amount']; ?>" class="form-control" id="blocking_amount" name="blocking_amount" placeholder="Enter Blocking Amount" autocomplete="off">
                                </div>
                              </div>
                            </td>
                          </tr>

                          <tr>
                            <td width="14%">Booking Amount<font color="#ff0000">*</font>
                            </td>
                            <td width="2%">&nbsp;</td>
                            <td width="84%">
                              <div class="col-lg-6">
                                <div class="form-group">
                                  <input type="text" value="<?php echo $row_edit_about['booking_amount']; ?>" class="form-control" id="booking_amount" name="booking_amount" placeholder="Enter Booking Amount" autocomplete="off">
                                </div>
                              </div>
                            </td>
                          </tr>

                          <tr>
                            <td width="14%">Price <font color="#ff0000">*</font>
                            </td>
                            <td width="2%">&nbsp;</td>
                            <td width="84%">
                              <div class="col-lg-3">
                                <div class="form-group">
                                  <input type="text" value="<?php echo $row_edit_about['price']; ?>" class="form-control" id="room_price" name="room_price" placeholder="Enter Price" autocomplete="off">
                                </div>
                              </div>
                            </td>
                          </tr>

                          <tr>
                            <td width="14%">Date <font color="#ff0000">*</font>
                            </td>
                            <td width="2%">&nbsp;</td>
                            <td width="84%">
                              <div class="col-lg-3">
                                <div class="form-group">
                                  <input type="date" value="<?php echo explode(" ", $row_edit_about['date_time'])[0]; ?>" class="form-control" id="main_date" name="main_date" autocomplete="off">
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
                              <a href="manage_unit.php?ap_id=<?php echo $row_edit_about["ap_id"]; ?>" class="btn btn-default">Cancel</a>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
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

  $sql_inset_post = "UPDATE " . DB_AP_ROOM . " 
      SET 
      room_number='" . ConvertRealString(strtoupper($_REQUEST['room_number'])) . "',
      room_name = '" . ConvertRealString(ucfirst($_REQUEST['room_name'])) . "',
      building_id = '" . ConvertRealString($_REQUEST['building']) . "',
      floor_number = '" . ConvertRealString($_REQUEST['floor']) . "',
      size_bhk = '" . ConvertRealString(strtoupper($_REQUEST['room_size_bhk'])) . "',
      size_sqft = '" . ConvertRealString($_REQUEST['room_size_sqft']) . "',
      consideration_value = '" . ConvertRealString($_REQUEST['cons_value']) . "',
      other_charges = '" . ConvertRealString($_REQUEST['other_charges']) . "',
      gst = '" . ConvertRealString($_REQUEST['gst']) . "',
      blocking_amount = '" . ConvertRealString($_REQUEST['blocking_amount']) . "',
      booking_amount = '" . ConvertRealString($_REQUEST['booking_amount']) . "',
      price = '" . ConvertRealString($_REQUEST['room_price']) . "',
      date_time = '" . ConvertRealString($_REQUEST['main_date']) . "'
      WHERE id='" . $_REQUEST['edit_id'] . "'";

  $qry_inset_post  = mysqli_query($link, $sql_inset_post);
  if ($qry_inset_post) {
    $_SESSION['MSG_ALERT'] = "Latest Information updated successfully";
    $_SESSION['IMG_PATH'] = "fa-check";
    $_SESSION['DIV_CLASS'] = "alert-success";
  } else {
    $_SESSION['MSG_ALERT'] = "Latest Information not updated!!!";
    $_SESSION['IMG_PATH'] = "fa-exclamation-triangle";
    $_SESSION['DIV_CLASS'] = "alert-warning";
  }

  //redirect_mp('manage_unit');
  redirect_mp_with_param("manage_unit.php?ap_id=".$_REQUEST["ap_id"]);
  exit();
}
?>
<script type="text/javascript">
  $(document).ready(function() {

    //--------------------------------- Insert validation   ---------------------------------

    $('#add_frm').validate({
      rules: {
        building: 'required',
        floor: 'required',
        room_number: 'required',
        room_size_bhk: 'required',
        room_size_sqft: 'required',
        cons_value: 'required',
        other_charges: 'required',
        gst: 'required',
        blocking_amount: 'required',
        booking_amount: 'required',
        quantity: 'required',
        room_price: 'required',
        main_date: 'required'

      },
      messages: {
        building: 'Please Select Building...!',
        floor: 'Please Select Floor Number...!',
        room_number: 'Please enter Unit Number...!',
        room_size_bhk: 'Please enter Unit Size in bhk...!',
        room_size_sqft: 'Please enter Unit Size in sqft...!',
        cons_value: 'Please enter Consideration Value...!',
        other_charges: 'Please enter Other Charges...!',
        gst: 'Please enter GST...!',
        blocking_amount: 'Please enter Blocking Amount...!',
        booking_amount: 'Please enter Booking Amount...!',
        room_price: 'Please enter Unit Price...!',
        main_date: 'Please Select Date...!'
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

    //--------------------------------- Edit validation   -----------------------------------
    $('#edit_frm').validate({
      rules: {
        building: 'required',
        floor: 'required',
        room_number: 'required',
        room_name: 'required',
        room_size_bhk: 'required',
        room_size_sqft: 'required',
        cons_value: 'required',
        other_charges: 'required',
        gst: 'required',
        blocking_amount: 'required',
        booking_amount: 'required',
        room_price: 'required',
        main_date: 'required'

      },
      messages: {
        building: 'Please Select Building...!',
        floor: 'Please Select Floor Number...!',
        room_number: 'Please enter Unit Number...!',
        room_name: 'Please enter Unit Name...!',
        room_size_bhk: 'Please enter Unit Size in bhk...!',
        room_size_sqft: 'Please enter Unit Size in sqft...!',
        cons_value: 'Please enter Consideration Value...!',
        other_charges: 'Please enter Other Charges...!',
        gst: 'Please enter GST...!',
        blocking_amount: 'Please enter Blocking Amount...!',
        booking_amount: 'Please enter Booking Amount...!',
        room_price: 'Please enter Unit Price...!',
        main_date: 'Please Select Date...!'
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
  //------------------------------ Image validation ---------------------------------------
  function validateimg_s(file) {
    var ext = file.split(".");
    ext = ext[ext.length - 1].toLowerCase();
    var arrayExtensions = ["jpg", "jpeg", "png"];

    if (arrayExtensions.lastIndexOf(ext) == -1) {
      $("#image_name_alert").html("Wrong extension type.");
      $('#image_name').focus();
      $("#image_name").val("");
    } else {
      $("#image_name_alert").css('display', 'none');
    }
  }
</script>