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
    $con = " and main_title_id=" . $product . "";
  }
  $sql_list_about = "SELECT * FROM " . DB_APPARTMENT . "  WHERE 1 " . $con . " AND status!='D' ORDER BY id DESC";
  $qry_list_about = mysqli_query($link, $sql_list_about);
  $num_list_about = mysqli_num_rows($qry_list_about);


  $countShow = "SELECT count(*) FROM " . DB_APPARTMENT . "  WHERE 1 " . $con . " AND status!='D' ORDER BY id DESC";
  $qry_countshow = mysqli_query($link, $countShow) or die(mysqli_error($link));
  $count = mysqli_num_rows($qry_countshow);
?>
  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12 breadcrumb-header">
          <div id="breadcrumb" class="tooltip-demo"> <a href="<?= URL ?>" title="Go to Home" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-home fa-fw"></i> Home</a><a href="#" class="current">Manage Apartment</a></div>
        </div>
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-lg-12">
          <div class="panel tabbed-panel panel-success">
            <div class="panel-heading clearfix">
              <div class="panel-title pull-left"><a data-toggle="collapse" href="#collapseOne" aria-expanded="false"><strong>Manage Apartment
                  </strong></a></div>
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
                              <th width="20">SL.</th>
                              <th>Image</th>
                              <th>Apartment Title</th>
                              <th>Ap Price</th>
                              <th>Address</th>
                              <th>Date</th>
                              <th>Status</th>
                              <th width="80">Action</th>
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
                                  <td><?php echo $cnt++ ?></td>
                                  <td>
                                  <?php if(!empty($row_list_about['ap_images'])){
									  $imgs=(json_decode($row_list_about['ap_images']));
									  if(isset($imgs[0])){
									  ?>
                                  <img src="../../uploads/appartment/<?php echo json_decode($row_list_about['ap_images'])[0]; ?>" width="70px" />
                                    <?php }else{?>
                                     <img src="../../images/society_default.jpg" width="70px" />
                                    <?php } }else{?>
                                     <img src="../../images/society_default.jpg" width="70px" />
                                    <?php }?>
                                  </td>
                                  <td><?php echo $row_list_about['ap_name']; ?></td>
                                  <td><?php echo number_format($row_list_about['ap_price'], 2); ?></td>
                                  <td>
                                    <?php
                                    $get_city = get_city("id=" . $row_list_about['ap_city_id']);
                                    $get_country = get_country("id=" . $get_city[0]["country_id"]);
                                    echo $get_city[0]["main_title"] . ", " . $get_country[0]["main_title"];
                                    ?>
                                  </td>
                                  <td><?php echo formatDate($row_list_about['date_time']); ?></td>
                                  <td><?php if (stripslashes($row_list_about['status']) == 'A') { ?>
                                      <span class="btn btn-success btn-xs">Active</span>
                                    <?php } else { ?>
                                      <span class="btn btn-danger btn-xs">Inactive</span>
                                    <?php } ?>
                                  </td>
                                  <td class="tooltip-demo">
                                    <a title="Unit" data-toggle="tooltip" data-placement="bottom" href='<?php echo BASE_URL."webmanager/mp-admin/manage_unit.php?ap_id=".$row_list_about['id']; ?>' class="btn btn-success btn-circle"><i class="fa fa-fort-awesome fa-fw"></i></a>
                                    <a title="Edit" data-toggle="tooltip" data-placement="bottom" href="javascript:Edit('<?php echo $row_list_about['id'] ?>','<?php echo $GLOBALS['start'] ?>');" class="btn btn-info btn-circle"><i class="fa fa-edit fa-fw"></i></a>
                                    <a title="Delete" data-toggle="tooltip" data-placement="bottom" href="javascript:Delete('<?php echo $row_list_about['id'] ?>','<?php echo $GLOBALS['start'] ?>');" class="btn btn-danger btn-circle"><i class="fa fa-trash fa-fw"></i></a>
                                  </td>
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
                    var UserResp = window.confirm("Are you sure to delete this Data?");
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
                              <td width="14%">Ap Title <font color="#ff0000">*</font>
                              </td>
                              <td width="2%">&nbsp;</td>
                              <td width="84%">
                                <div class="col-lg-6">
                                  <div class="form-group">
                                    <input type="text" class="form-control" id="main_title" name="main_title" placeholder="Enter Appartment Title" autocomplete="off">
                                  </div>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td width="14%">Title Slug<font color="#ff0000">*</font>
                              </td>
                              <td width="2%">&nbsp;</td>
                              <td width="84%">
                                <div class="col-lg-6">
                                  <div class="form-group">
                                    <input type="text" class="form-control" id="main_title_slug" name="main_title_slug" readonly autocomplete="off">
                                  </div>
                                </div>
                              </td>
                            </tr>


                            <tr>
                              <td width="14%">Bullet Points <font color="#ff0000">*</font>
                              </td>
                              <td width="2%">&nbsp;</td>
                              <td width="84%">
                                <table width="100%" id="bullet_point_table">
                                  <tr>
                                    <td width="100%">
                                      <div class="col-lg-6">
                                        <div class="form-group">
                                          <input type="text" class="form-control" id="bullet_points" name="bullet_points[]" placeholder="Enter Bullet Point" autocomplete="off">
                                        </div>
                                      </div>
                                      <div class="col-lg-2">
                                        <span class="btn btn-success btn-xs" id="add_new_bullet_point">New Points</span>
                                      </div>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>

                            <tr>
                              <td width="14%">Upload Images <font color="#ff0000">*</font>
                              </td>
                              <td width="2%">&nbsp;</td>
                              <td width="84%">
                                <table width="100%" id="ap_image_table">
                                  <tr>
                                    <td width="100%">
                                      <div class="col-lg-6">
                                        <div class="form-group">
                                          <input type="file" class="form-control" accept=".png, .jpg, .jpeg" id="image_name" name="image_name[]" onchange="validateimg_s(this.value)">
                                        </div>
                                        <p id="image_name_alert" style="color:#F00;"></p>
                                      </div>
                                      <div class="col-lg-2">
                                        <span class="btn btn-success btn-xs" id="add_new_ap_image">New Image</span>
                                      </div>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                            <tr>
                              <td width="14%">Country & City <font color="#ff0000">*</font>
                              </td>
                              <td width="2%">&nbsp;</td>
                              <td width="84%">
                                <div class="col-lg-3">
                                  <div class="form-group">
                                    <select class="form-control" name="country_id" id="country_id">
                                      <option value="">Choose Country</option>
                                      <?php
                                      $all_city = get_city();
                                      $all_country = get_country();
                                      foreach ($all_country as $country) { ?>
                                        <option value="<?php echo $country['id']; ?>">
                                          <?php echo $country['main_title']; ?>
                                        </option>
                                      <?php }
                                      ?>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-lg-3">
                                  <div class="form-group">
                                    <select class="form-control" name="city_id" id="city_id">
                                      <option value="">Choose City</option>
                                      <script>
                                        $(document).ready(function() {
                                          $(document).on("change", "#country_id", function() {
                                            $("#city_id").html(`<option value="">Choose City</option>`);
                                            var country_id = $(this).val();
                                            var var_all_city = <?php echo json_encode($all_city); ?>;
                                            for (const x in var_all_city) {
                                              if (var_all_city[x]["country_id"] == country_id) {
                                                $("#city_id").append(`<option value="${var_all_city[x]["id"]}">
                                                                      ${var_all_city[x]["main_title"]}
                                                                      </option>`);
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
                              <td width="14%">Appartment Type <font color="#ff0000">*</font>
                              </td>
                              <td width="2%">&nbsp;</td>
                              <td width="84%">
                                <div class="col-lg-3">
                                  <div class="form-group">
                                    <select class="form-control" name="appartment_type_id" id="appartment_type_id">
                                      <option value="">Choose Appartment Type</option>
                                      <?php
                                      $all_ap_type = get_ap_type();
                                      foreach ($all_ap_type as $ap_type) { ?>
                                        <option value="<?php echo $ap_type['id']; ?>">
                                          <?php echo $ap_type['main_title']; ?>
                                        </option>
                                      <?php }
                                      ?>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-lg-3">
                                  <div class="form-group">
                                    <select class="form-control" name="featured_or_not" id="featured_or_not">
                                      <option value="">Make Featured or not</option>
                                      <option value="yes">Yes</option>
                                      <option value="no" selected>No</option>
                                    </select>
                                  </div>
                                </div>
                              </td>
                            </tr>

                            <tr>
                              <td width="14%">Plans <font color="#ff0000">*</font>
                              </td>
                              <td width="2%">&nbsp;</td>
                              <td width="84%">
                                <table width="100%" id="ap_plans_table">
                                  <tr>
                                    <td width="100%">
                                      <div class="col-lg-6">
                                        <div class="form-group">
                                          <input type="text" class="form-control" id="ap_plans" name="ap_plans[]" placeholder="Enter Plans (eg. 25:25:50)" autocomplete="off">
                                        </div>
                                      </div>
                                      <div class="col-lg-2">
                                        <span class="btn btn-success btn-xs" id="add_new_ap_plans">New Plan</span>
                                      </div>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>

                            <tr>
                              <td width="14%">Buildings & floors <font color="#ff0000">*</font>
                              </td>
                              <td width="2%">&nbsp;</td>
                              <td width="84%">
                                <table width="100%" id="ap_buildings_table">
                                  <tr>
                                    <td width="100%">
                                      <div class="col-lg-3">
                                        <div class="form-group">
                                          <input type="text" class="form-control" id="ap_buildings" name="ap_buildings[]" placeholder="Enter Building (eg. Building-1 )" autocomplete="off">
                                        </div>
                                      </div>
                                      <div class="col-lg-3">
                                        <div class="form-group">
                                          <input type="text" class="form-control" id="ap_floors" name="ap_floors[]" placeholder="Enter Last Floor (eg. 25 )" autocomplete="off">
                                        </div>
                                      </div>
                                      <div class="col-lg-2">
                                        <span class="btn btn-success btn-xs" id="add_new_ap_buildings">New Building</span>
                                      </div>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>

                            <tr> 
                              <td width="14%">Price <font color="#ff0000">*</font>
                              </td>
                              <td width="2%">&nbsp;</td>
                              <td width="84%">
                                <div class="col-lg-3">
                                  <div class="form-group">
                                    <input type="text" class="form-control" value="" id="ap_price" name="ap_price" placeholder="Enter Price" autocomplete="off">
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
                                    <input type="date" class="form-control" value="<?php echo date('Y-m-d') ?>" id="main_date" name="main_date" autocomplete="off">
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
                                <a href="manage_appartment.php" class="btn btn-default">Cancel</a>
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
  
  $upload_dir = '../../uploads/appartment/';
  $all_ap_images = [];
  $numberOfImages = sizeof($_FILES['image_name']['name']);
  echo "Images=" . $numberOfImages . "<br>";
  $successImageUploaded = 0;
  if ($numberOfImages > 0) {
    for ($i = 0; $i < $numberOfImages; $i++) {
      if ($_FILES['image_name']['name'][$i] != "") {
        $all_ap_images[$i] = time() . rand(00000, 99999) . "_" . str_replace(" ", "_", $_FILES['image_name']['name'][$i]);
        $tmp_name = $_FILES['image_name']['tmp_name'][$i];
        if (move_uploaded_file($tmp_name, $upload_dir . $all_ap_images[$i])) {
          $successImageUploaded++;
        }
      }
    }
  }

  if ($successImageUploaded == $numberOfImages) {
  
    $building_floor = [];
    for ($i = 0; $i < sizeof($_REQUEST['ap_buildings']); $i++) {
      if (!empty($_REQUEST['ap_buildings'][$i]) && !empty($_REQUEST['ap_floors'][$i])) {
        $building_floor[] = ["building" => ucfirst($_REQUEST['ap_buildings'][$i]), "floor" =>  $_REQUEST['ap_floors'][$i]];
      }
    }

    $tempBullets=json_encode($_REQUEST['bullet_points']);
    $tempImages=json_encode($all_ap_images);
    $tempPlans=json_encode($_REQUEST['ap_plans']); 


    $sql_inset_post = "INSERT INTO " . DB_APPARTMENT . " 
      SET 
      ap_name = '" . ConvertRealString(ucfirst($_REQUEST['main_title'])) . "',
      ap_city_id='" . ConvertRealString($_REQUEST['city_id']) . "',
      ap_price = '" . ConvertRealString($_REQUEST['ap_price']) . "',
      ap_bullet_points = '" . $tempBullets . "',
      ap_images = '" . $tempImages . "',
      date_time = '" . ConvertRealString($_REQUEST['main_date']) . "',
      ap_type_id = '" . ConvertRealString($_REQUEST['appartment_type_id']) . "',
      ap_is_featured = '" . ConvertRealString($_REQUEST['featured_or_not']) . "',
      ap_plans = '" . $tempPlans . "',
      building_floors = '" . json_encode($building_floor) . "',
      slug= '" . ConvertRealString($_REQUEST['main_title_slug']) . "'";

    $qry_inset_post  = mysqli_query($link, $sql_inset_post);
    $last_id=mysqli_insert_id($link);
    if ($qry_inset_post) {
      $_SESSION['MSG_ALERT'] = "Latest Information inserted successfully";
      $_SESSION['IMG_PATH'] = "fa-check";
      $_SESSION['DIV_CLASS'] = "alert-success";
    } else {
      $_SESSION['MSG_ALERT'] = "Latest Information not interted!!!";
      $_SESSION['IMG_PATH'] = "fa-exclamation-triangle";
      $_SESSION['DIV_CLASS'] = "alert-warning";
    }
  } else {
    $_SESSION['MSG_ALERT'] = "Image upload fail!!!";
    $_SESSION['IMG_PATH'] = "fa-exclamation-triangle";
    $_SESSION['DIV_CLASS'] = "alert-warning";
  }

  //echo $sql_inset_post;

  redirect_mp('manage_appartment');
  redirect_mp_with_param("manage_unit.php?ap_id=".$last_id);


  exit();
}

function delete_about()
{
  $result = deleteRecord(DB_APPARTMENT, 'id=' . $_REQUEST['id']);
  $_SESSION['MSG_ALERT'] = "Latest Information has been successfully deleted.";
  $_SESSION['IMG_PATH'] = "fa-ban";
  $_SESSION['DIV_CLASS'] = "alert-danger";
  redirect_mp('manage_appartment');
  exit();
}

function delete_chk_about()
{
  global $link;
  $count_del = 0;
  foreach ($_REQUEST['public_chkbox'] as $val) {
    if ($val != 'on') {

      $sql_deletepublication = "UPDATE " . DB_APPARTMENT . " 
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
    redirect_mp('manage_appartment');
    exit();
  }
}
function active_chk_about()
{
  global $link;
  $count_del = 0;
  foreach ($_REQUEST['public_chkbox'] as $val) {
    if ($val != 'on') {
      $sql_deletepublication = "UPDATE " . DB_APPARTMENT . " 
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
    redirect_mp('manage_appartment');
    exit();
  }
}
function inactive_chk_about()
{
  global $link;
  $count_del = 0;
  foreach ($_REQUEST['public_chkbox'] as $val) {
    if ($val != 'on') {
      $sql_deletepublication = "UPDATE " . DB_APPARTMENT . " 
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
    redirect_mp('manage_appartment');
    exit();
  }
}


?>
<?php
function edit()
{

  global $link;
  $sql_edit_about = "SELECT * FROM " . DB_APPARTMENT . "  where id ='" . $_REQUEST['id'] . "'";
  $qry_edit_about = mysqli_query($link, $sql_edit_about) or die(mysqli_error($link));
  $row_edit_about = mysqli_fetch_array($qry_edit_about);

?>
  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12 breadcrumb-header">
          <div id="breadcrumb" class="tooltip-demo"> <a href="<?= URL ?>" title="Go to Home" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-home fa-fw"></i> Home</a><a href="<?= $_SERVER['PHP_SELF'] ?>">Edit Appartment</a><a href="#" class="current">Edit</a></div>
        </div>
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-lg-12">
          <div class="panel tabbed-panel panel-success">
            <div class="panel-heading clearfix">
              <div class="panel-title pull-left"><a data-toggle="collapse" href="#collapseOne" aria-expanded="false"><strong><i class="fa fa-edit fa-fw"></i> Edit Appartment</strong></a></div>
            </div>
            <div class="panel-body" id="collapseOne" aria-expanded="true" style="background: #eef9f0;margin: 1em;border-radius: 4px;">
              <div class="panel-body">
                <form action="<?php echo  $_SERVER['PHP_SELF'] ?>" method="post" name="edit_frm" id="edit_frm" enctype="multipart/form-data">
                  <input type="hidden" name="mode" value="edit_about">
                  <input type="hidden" name="edit_id" value="<?php echo $_REQUEST['id']; ?>">
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
                          <td width="14%">Ap Title <font color="#ff0000">*</font>
                          </td>
                          <td width="2%">&nbsp;</td>
                          <td width="84%">
                            <div class="col-lg-6">
                              <div class="form-group">
                                <input type="text" value="<?php echo $row_edit_about['ap_name']; ?>" class="form-control" id="main_title" name="main_title" placeholder="Enter Appartment Title" autocomplete="off">
                              </div>
                            </div>
                          </td>
                        </tr>

                        <tr>
                          <td width="14%">Title Slug<font color="#ff0000">*</font>
                          </td>
                          <td width="2%">&nbsp;</td>
                          <td width="84%">
                            <div class="col-lg-6">
                              <div class="form-group">
                                <input type="text" value="<?php echo $row_edit_about['slug']; ?>" class="form-control" id="main_title_old_slug" name="main_title_old_slug" readonly autocomplete="off">
                              </div>
                            </div>
                          </td>
                        </tr>

                        <tr>
                          <td width="14%">Bullet Points <font color="#ff0000">*</font>
                          </td>
                          <td width="2%">&nbsp;</td>
                          <td width="84%">
                            <table width="100%" id="bullet_point_table">
                              <?php
                              $allBullets = json_decode($row_edit_about['ap_bullet_points']);
                              $xy = 0;
                              foreach ($allBullets as $bulletPoint) {
                                if ($xy == 0) {
                                  $xy++;
                              ?>
                                  <tr>
                                    <td width="100%">
                                      <div class="col-lg-6">
                                        <div class="form-group">
                                          <input type="text" value="<?php echo $bulletPoint; ?>" class="form-control" id="bullet_points" name="bullet_points[]" placeholder="Enter Bullet Point" autocomplete="off">
                                        </div>
                                      </div>
                                      <div class="col-lg-2">
                                        <span class="btn btn-success btn-xs" id="add_new_bullet_point">New Points</span>
                                      </div>
                                    </td>
                                  </tr>
                                <?php
                                } else {
                                ?>
                                  <tr>
                                    <td width="100%">
                                      <div class="col-lg-6">
                                        <div class="form-group">
                                          <input type="text" value="<?php echo $bulletPoint; ?>" class="form-control" id="bullet_points" name="bullet_points[]" placeholder="Enter Bullet Point" autocomplete="off">
                                        </div>
                                      </div>
                                      <div class="col-lg-2">
                                        <span class="btn btn-danger btn-xs delete_new_bullet_point">Delete Points</span>
                                      </div>
                                    </td>
                                  </tr>
                              <?php
                                }
                              }
                              ?>

                            </table>
                          </td>
                        </tr>

                        <tr>
                          <td width="14%">Upload Images <font color="#ff0000">*</font>
                          </td>
                          <td width="2%">&nbsp;</td>
                          <td width="84%">
                            <table width="100%" id="ap_image_table">
                              <?php
                              $allImages = json_decode($row_edit_about['ap_images']);
                              $yz = 0;
                              foreach ($allImages as $apImage) {
                                if ($yz == 0) {
                                  $yz++;
                              ?>
                                  <tr>
                                    <td width="100%">
                                      <div class="col-lg-6">
                                        <div class="form-group">
                                          <input type="file" class="form-control" accept=".png, .jpg, .jpeg" id="image_name" name="image_name[]" onchange="validateimg_s(this.value)">
                                        </div>
                                        <p id="image_name_alert" style="color:#F00;"></p>
                                        <div class="form-group"><img src="../../uploads/appartment/<?php echo $apImage; ?>" width="100px" /></div>
                                      </div>
                                      <div class="col-lg-2">
                                        <span class="btn btn-success btn-xs" id="add_new_ap_image">New Image</span>
                                      </div>
                                    </td>
                                  </tr>
                                <?php
                                } else {
                                ?>
                                  <tr>
                                    <td width="100%">
                                      <div class="col-lg-6">
                                        <div class="form-group">
                                          <input type="file" class="form-control" accept=".png, .jpg, .jpeg" id="image_name" name="image_name[]" onchange="validateimg_s(this.value)">
                                        </div>
                                        <p id="image_name_alert" style="color:#F00;"></p>
                                        <div class="form-group"><img src="../../uploads/appartment/<?php echo $apImage; ?>" width="100px" /></div>
                                      </div>
                                      <div class="col-lg-2">
                                        <span class="btn btn-danger btn-xs delete_new_ap_image">Delete Image</span>
                                      </div>
                                    </td>
                                  </tr>
                              <?php
                                }
                              }
                              ?>
                            </table>
                          </td>
                        </tr>
                        <tr>
                          <td width="14%">Country & City <font color="#ff0000">*</font>
                          </td>
                          <td width="2%">&nbsp;</td>
                          <td width="84%">
                            <div class="col-lg-3">
                              <div class="form-group">
                                <select class="form-control" name="country_id" id="country_id">
                                  <option value="">Choose Country</option>
                                  <?php
                                  $prevCountryId = get_city("id=" . $row_edit_about['ap_city_id'])[0]["country_id"];
                                  $prevCountryAllCity = get_city("country_id=" . $prevCountryId);

                                  $all_city = get_city();
                                  $all_country = get_country();
                                  foreach ($all_country as $country) {
                                    if ($country["id"] == $prevCountryId) {
                                  ?>
                                      <option value="<?php echo $country['id']; ?>" selected>
                                        <?php echo $country['main_title']; ?>
                                      </option>
                                    <?php
                                    } else {
                                    ?>
                                      <option value="<?php echo $country['id']; ?>">
                                        <?php echo $country['main_title']; ?>
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
                                <select class="form-control" name="city_id" id="city_id">
                                  <option value="">Choose City</option>
                                  <?php
                                  foreach ($prevCountryAllCity as $prevCity) {
                                    if ($prevCity["id"] == $row_edit_about['ap_city_id']) {
                                  ?>
                                      <option value="<?php echo $prevCity['id']; ?>" selected>
                                        <?php echo $prevCity['main_title']; ?>
                                      </option>
                                    <?php
                                    } else {
                                    ?>
                                      <option value="<?php echo $prevCity['id']; ?>">
                                        <?php echo $prevCity['main_title']; ?>
                                      </option>
                                  <?php
                                    }
                                  }

                                  ?>
                                  <script>
                                    $(document).ready(function() {
                                      $(document).on("change", "#country_id", function() {
                                        $("#city_id").html(`<option value="">Choose City</option>`);
                                        var country_id = $(this).val();
                                        var var_all_city = <?php echo json_encode($all_city); ?>;
                                        for (const x in var_all_city) {
                                          if (var_all_city[x]["country_id"] == country_id) {
                                            $("#city_id").append(`<option value="${var_all_city[x]["id"]}">
                                                                      ${var_all_city[x]["main_title"]}
                                                                      </option>`);
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
                          <td width="14%">Appartment Type <font color="#ff0000">*</font>
                          </td>
                          <td width="2%">&nbsp;</td>
                          <td width="84%">
                            <div class="col-lg-3">
                              <div class="form-group">
                                <select class="form-control" name="appartment_type_id" id="appartment_type_id">
                                  <option value="">Choose Appartment Type</option>
                                  <?php
                                  $all_ap_type = get_ap_type();
                                  foreach ($all_ap_type as $ap_type) {
                                    if ($ap_type['id'] == $row_edit_about['ap_type_id']) {
                                  ?>
                                      <option value="<?php echo $ap_type['id']; ?>" selected>
                                        <?php echo $ap_type['main_title']; ?>
                                      </option>
                                    <?php
                                    } else {
                                    ?>
                                      <option value="<?php echo $ap_type['id']; ?>">
                                        <?php echo $ap_type['main_title']; ?>
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
                                <select class="form-control" name="featured_or_not" id="featured_or_not">
                                  <option value="">Make Featured or not</option>
                                  <?php
                                  if ($row_edit_about['ap_is_featured'] == "yes") {
                                  ?>
                                    <option value="yes" selected>Yes</option>
                                    <option value="no">No</option>
                                  <?php
                                  } else {
                                  ?>
                                    <option value="yes">Yes</option>
                                    <option value="no" selected>No</option>
                                  <?php
                                  }
                                  ?>
                                </select>
                              </div>
                            </div>
                          </td>
                        </tr>



                        <tr>
                          <td width="14%">Plans <font color="#ff0000">*</font>
                          </td>
                          <td width="2%">&nbsp;</td>
                          <td width="84%">
                            <table width="100%" id="ap_plans_table">
                              <?php
                              $all_ap_plans = json_decode($row_edit_about['ap_plans']);
                              foreach ($all_ap_plans as $one_ap_plan_key => $one_ap_plan) {
                              ?>
                                <tr>
                                  <td width="100%">
                                    <div class="col-lg-6">
                                      <div class="form-group">
                                        <input type="text" value="<?php echo $one_ap_plan; ?>" class="form-control" id="ap_plans" name="ap_plans[]" placeholder="Enter Plans (eg. 25:25:50)" autocomplete="off">
                                      </div>
                                    </div>
                                    <div class="col-lg-2">
                                      <?php
                                      if ($one_ap_plan_key == 0) {
                                        echo '<span class="btn btn-success btn-xs" id="add_new_ap_plans">New Plan</span>';
                                      } else {
                                        echo '<span class="btn btn-danger btn-xs delete_new_ap_plans">Delete Plans</span>';
                                      }
                                      ?>
                                    </div>
                                  </td>
                                </tr>
                              <?php
                              }
                              ?>
                            </table>
                          </td>
                        </tr>

                        <tr>
                          <td width="14%">Buildings & floors <font color="#ff0000">*</font>
                          </td>
                          <td width="2%">&nbsp;</td>
                          <td width="84%">
                            <table width="100%" id="ap_buildings_table">
                              <?php
                              $all_ap_building_floors = json_decode($row_edit_about['building_floors'], true);
                              foreach ($all_ap_building_floors as $building_floors_key => $one_ap_building_floors) {
                              ?>
                                <tr>
                                  <td width="100%">
                                    <div class="col-lg-3">
                                      <div class="form-group">
                                        <input type="text" value="<?php echo $one_ap_building_floors["building"]; ?>" class="form-control" id="ap_buildings" name="ap_buildings[]" placeholder="Enter Building (eg. Building-1 )" autocomplete="off">
                                      </div>
                                    </div>
                                    <div class="col-lg-3">
                                      <div class="form-group">
                                        <input type="text" value="<?php echo $one_ap_building_floors["floor"]; ?>" class="form-control" id="ap_floors" name="ap_floors[]" placeholder="Enter Last Floor (eg. 25 )" autocomplete="off">
                                      </div>
                                    </div>
                                    <div class="col-lg-2">
                                      <?php
                                      if ($building_floors_key == 0) {
                                        echo '<span class="btn btn-success btn-xs" id="add_new_ap_buildings">New Building</span>';
                                      } else {
                                        echo '<span class="btn btn-danger btn-xs delete_new_ap_buildings">Delete Building</span>';
                                      }
                                      ?>
                                    </div>
                                  </td>
                                </tr>
                              <?php
                              }
                              ?>
                            </table>

                          </td>
                        </tr>



                        <tr>
                          <td width="14%">Price <font color="#ff0000">*</font>
                          </td>
                          <td width="2%">&nbsp;</td>
                          <td width="84%">
                            <div class="col-lg-3">
                              <div class="form-group">
                                <input type="text" value="<?php echo $row_edit_about['ap_price']; ?>" class="form-control" id="ap_price" name="ap_price" placeholder="Enter Price" autocomplete="off">
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
                                <input type="date" class="form-control" id="main_date" name="main_date" autocomplete="off" value="<?php echo explode(' ', $row_edit_about['date_time'])[0]; ?>">
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
                            <a href="manage_appartment.php" class="btn btn-default">Cancel</a>
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

  $upload_dir = '../../uploads/appartment/';
  $all_ap_images = [];
  $numberOfImages = sizeof(array_filter($_FILES['image_name']['name']));
  echo "Images=" . $numberOfImages . "<br><pre>";
  $isImageUploadedErr = 0;
  if ($numberOfImages > 0) {
    foreach (array_filter($_FILES['image_name']['name']) as $key => $value) {
      $all_ap_images[$key] = time() . rand(00000, 99999) . "_" . str_replace(" ", "_", $_FILES['image_name']['name'][$key]);
      $tmp_name = $_FILES['image_name']['tmp_name'][$key];
      if (!move_uploaded_file($tmp_name, $upload_dir . $all_ap_images[$key])) {
        $isImageUploadedErr++;
      }
    }
  }

  if ($isImageUploadedErr <= 0) {
    $building_floor = [];
    for ($i = 0; $i < sizeof($_REQUEST['ap_buildings']); $i++) {
      if (!empty($_REQUEST['ap_buildings'][$i]) && !empty($_REQUEST['ap_floors'][$i])) {
        $building_floor[] = ["building" => ucfirst($_REQUEST['ap_buildings'][$i]), "floor" =>  $_REQUEST['ap_floors'][$i]];
      }
    }

    if ($numberOfImages > 0) {
      $sql_inset_post = "UPDATE " . DB_APPARTMENT . " 
      SET 
      ap_name = '" . ConvertRealString(ucfirst($_REQUEST['main_title'])) . "',
      ap_city_id='" . ConvertRealString($_REQUEST['city_id']) . "',
      ap_price = '" . ConvertRealString($_REQUEST['ap_price']) . "',
      ap_bullet_points = '" . json_encode($_REQUEST['bullet_points']) . "',
      ap_images = '" . json_encode($all_ap_images) . "',
      date_time = '" . ConvertRealString($_REQUEST['main_date']) . "',
      ap_type_id = '" . ConvertRealString($_REQUEST['appartment_type_id']) . "',
      ap_is_featured = '" . ConvertRealString($_REQUEST['featured_or_not']) . "',
      ap_plans = '" . json_encode($_REQUEST['ap_plans']) . "',
      building_floors = '" . json_encode($building_floor) . "'
      WHERE id='" . $_REQUEST['edit_id'] . "'";
    } else {
      $sql_inset_post = "UPDATE " . DB_APPARTMENT . " 
      SET 
      ap_name = '" . ConvertRealString(ucfirst($_REQUEST['main_title'])) . "',
      ap_city_id='" . ConvertRealString($_REQUEST['city_id']) . "',
      ap_price = '" . ConvertRealString($_REQUEST['ap_price']) . "',
      ap_bullet_points = '" . json_encode($_REQUEST['bullet_points']) . "',
      date_time = '" . ConvertRealString($_REQUEST['main_date']) . "',
      ap_type_id = '" . ConvertRealString($_REQUEST['appartment_type_id']) . "',
      ap_is_featured = '" . ConvertRealString($_REQUEST['featured_or_not']) . "',
      ap_plans = '" . json_encode($_REQUEST['ap_plans']) . "',
      building_floors = '" . json_encode($building_floor) . "'
      WHERE id='" . $_REQUEST['edit_id'] . "'";
    }
    $qry_inset_post  = mysqli_query($link, $sql_inset_post);
    if ($qry_inset_post) {
      $_SESSION['MSG_ALERT'] = "Latest Information update successfully";
      $_SESSION['IMG_PATH'] = "fa-check";
      $_SESSION['DIV_CLASS'] = "alert-success";
    } else {
      $_SESSION['MSG_ALERT'] = "Latest Information not updated!!!";
      $_SESSION['IMG_PATH'] = "fa-exclamation-triangle";
      $_SESSION['DIV_CLASS'] = "alert-warning";
    }
  } else {
    $_SESSION['MSG_ALERT'] = "Image update fail!!!";
    $_SESSION['IMG_PATH'] = "fa-exclamation-triangle";
    $_SESSION['DIV_CLASS'] = "alert-warning";
  }

  redirect_mp('manage_appartment');
  exit();
}
?>
<script type="text/javascript">
  $(document).ready(function() {
    $(document).on("keyup", "#main_title", function() {
      var string_for_slug = $("#main_title").val();
      var slug_tbl = "<?php echo DB_APPARTMENT; ?>";
      $.ajax({
        url: `<?= BASE_URL?>webmanager/mp-admin/ajax_make_slug.php?db_table=${slug_tbl}&string_text=${string_for_slug}`,
        success: function(result) {
          $("#main_title_slug").val(result);
        }
      });

    });

    //---------------------------------dynamic field add/delete ----------------------------
    var var_add_new_bullet_point = 1;
    $("#add_new_bullet_point").click(function() {
      var_add_new_bullet_point++;
      var bullet_point_html = `<tr>
                              <td width="100%">
                                <div class="col-lg-6">
                                  <div class="form-group">
                                    <input type="text" class="form-control" id="bullet_points" name="bullet_points[]" placeholder="${var_add_new_bullet_point}.Enter Bullet Point" autocomplete="off">
                                  </div>
                                </div>
                                <div class="col-lg-2">
                                  <span class="btn btn-danger btn-xs delete_new_bullet_point">Delete Points</span>
                                </div>
                              </td>
                            </tr>`;
      $("#bullet_point_table").append(bullet_point_html);
    });

    $(document).on("click", ".delete_new_bullet_point", function() {
      var_add_new_bullet_point--;
      $(this).closest("tr").remove();
    });

    var var_add_new_ap_image = 1;
    $("#add_new_ap_image").click(function() {
      var_add_new_ap_image++;
      var ap_image_html = `<tr>
                          <td width="100%">
                                      <div class="col-lg-6">
                                        <div class="form-group">
                                          <input type="file" class="form-control" accept=".png, .jpg, .jpeg" id="image_name" name="image_name[]" onchange="validateimg_s(this.value)">
                                        </div>
                                        <p id="image_name_alert" style="color:#F00;"></p>
                                      </div>
                                      <div class="col-lg-2">
                                      <span class="btn btn-danger btn-xs delete_new_ap_image">Delete Image</span>
                                      </div>
                                    </td>
                                  </tr>`;
      $("#ap_image_table").append(ap_image_html);
    });

    $(document).on("click", ".delete_new_ap_image", function() {
      var_add_new_ap_image--;
      $(this).closest("tr").remove();
    });


    var var_add_ap_plan = 1;
    $("#add_new_ap_plans").click(function() {
      var_add_ap_plan++;
      var ap_plan_html = `<tr>
                              <td width="100%">
                                <div class="col-lg-6">
                                  <div class="form-group">
                                    <input type="text" class="form-control" id="ap_plans" name="ap_plans[]" placeholder="${var_add_ap_plan}.Enter Plan (eg. 25:25:50)" autocomplete="off">
                                  </div>
                                </div>
                                <div class="col-lg-2">
                                  <span class="btn btn-danger btn-xs delete_new_ap_plans">Delete Plans</span>
                                </div>
                              </td>
                            </tr>`;
      $("#ap_plans_table").append(ap_plan_html);
    });

    $(document).on("click", ".delete_new_ap_plans", function() {
      var_add_ap_plan--;
      $(this).closest("tr").remove();
    });

    var var_add_ap_buildings = 1;
    $("#add_new_ap_buildings").click(function() {
      var_add_ap_buildings++;
      var ap_building_html = `<tr>
                              <td width="100%">
                                <div class="col-lg-3">
                                  <div class="form-group">
                                    <input type="text" class="form-control" id="ap_buildings" name="ap_buildings[]" placeholder="Enter Building (eg. Building-1 )" autocomplete="off">
                                  </div>
                                </div>
                                <div class="col-lg-3">
                                  <div class="form-group">
                                    <input type="text" class="form-control" id="ap_floors" name="ap_floors[]" placeholder="Enter Last Floor (eg. 25 )" autocomplete="off">
                                  </div>
                                </div>
                                <div class="col-lg-2">
                                  <span class="btn btn-danger btn-xs delete_new_ap_buildings">Delete Building</span>
                                </div>
                              </td>
                            </tr>`;
      $("#ap_buildings_table").append(ap_building_html);
    });

    $(document).on("click", ".delete_new_ap_buildings", function() {
      var_add_ap_buildings--;
      $(this).closest("tr").remove();
    });



    //--------------------------------- Insert validation   ---------------------------------

    $('#add_frm').validate({
      rules: {
         main_title: 'required',
        'image_name[]': 'required',
        main_date: 'required',
        ap_price: 'required',
        country_id: 'required',
        city_id: 'required',
        'bullet_points[]': 'required',
        appartment_type_id: 'required',
        featured_or_not: 'required',
        'ap_plans[]': 'required',
        'ap_buildings[]': 'required',
        'ap_floors[]': 'required'

      },
      messages: {
       main_title: "Please enter title...!",
        'image_name[]': "Please upload image...!",
        main_date: "Please Select Date...!",
        ap_price: "Please Enter Price...!",
        country_id: 'Please Select Country...!',
        city_id: 'Please Select City...!',
        'bullet_points[]': 'Please Enter Points...!',
        appartment_type_id: 'Please Select Ap Type...!',
        featured_or_not: 'Please Select Yes or No...!',
        'ap_plans[]': 'Please Enter Plans...!',
        'ap_buildings[]': 'Please Enter Building...!',
        'ap_floors[]': 'Please Enter Floor...!'
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
        main_title: 'required',
        main_date: 'required',
        ap_price: 'required',
        country_id: 'required',
        city_id: 'required',
        'bullet_points[]': 'required',
        appartment_type_id: 'required',
        featured_or_not: 'required'

      },
      messages: {
        main_title: "Please enter title...!",
        'image_name[]': "Please upload image...!",
        main_date: "Please Select Date...!",
        ap_price: "Please Enter Price...!",
        country_id: 'Please Select Country...!',
        city_id: 'Please Select City...!',
        'bullet_points[]': 'Please Enter Points...!',
        appartment_type_id: 'Please Select Ap Type...!',
        featured_or_not: 'Please Select Yes or No...!'
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