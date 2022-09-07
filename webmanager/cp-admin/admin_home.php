<?php
ob_start();
require("../template.php");
if($_SESSION['admin_user_id']=='')					redirect('index');
require_once("../authonication.php");
disphtml("main();");

ob_end_flush();

function main(){?>
<style>
.table>thead:first-child>tr:first-child>th{background:#337ab7 !important;color:#FFF;}
</style>
<div id="page-wrapper">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12 breadcrumb-header"><div id="breadcrumb" class="tooltip-demo"> <a href="<?=URL?>" title="Go to Home" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-home fa-fw"></i> Home</a></div>
      </div>
    </div>
    <?php if($_SESSION['type_id']== 1){?>
    <div class="row">
      <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-3"> <i class="fa fa-user fa-5x"></i> </div>
              <div class="col-xs-9 text-right">
                <div class="huge">6</div>
                <div>Register User</div>
              </div>
            </div>
          </div>
          <a href="<?php echo MP_URL.'manage_register.php' ?>">
          <div class="panel-footer"> <span class="pull-left">View Details</span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
            <div class="clearfix"></div>
          </div>
          </a> </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-3"> <i class="fa fa-home fa-5x"></i> </div>
              <div class="col-xs-9 text-right">
                <div class="huge">5</div>
                <div>Appartments</div>
              </div>
            </div>
          </div>
          <a href="<?php echo MP_URL.'manage_appartment.php' ?>">
          <div class="panel-footer"> <span class="pull-left">View Details</span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
            <div class="clearfix"></div>
          </div>
          </a> </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-3"> <i class="fa fa-shopping-cart fa-5x"></i> </div>
              <div class="col-xs-9 text-right">
                <div class="huge">7</div>
                <div>Total Booking</div>
              </div>
            </div>
          </div>
          <a href="<?php echo MP_URL.'manage_bookings.php' ?>">
          <div class="panel-footer"> <span class="pull-left">View Details</span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
            <div class="clearfix"></div>
          </div>
          </a> </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-3"> <i class="fa fa-support fa-5x"></i> </div>
              <div class="col-xs-9 text-right">
                <div class="huge">3</div>
                <div>This Month Booking</div>
              </div>
            </div>
          </div>
          <a href="<?php echo MP_URL.'manage_bookings.php' ?>">
          <div class="panel-footer"> <span class="pull-left">View Details</span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
            <div class="clearfix"></div>
          </div>
          </a> </div>
      </div>
      <?php //echo $currDir = (dirname(__FILE__));?>
    </div>
    
    <div class="row">
      <div class="col-lg-12">
        <div class="panel tabbed-panel panel-success">
          <div class="panel-heading clearfix">
            <div class="panel-title pull-left"><a data-toggle="collapse" href="#collapseOne" aria-expanded="false"><strong>Icon Reference</strong></a></div>
          </div>
          <div class="panel-body" id="collapseOne" aria-expanded="true">
            <div class="panel-body">
              <div class="table-responsive">
                <table class="table table-striped">
                  <tbody>
                    <tr>
                      <td><div class="tooltip-demo"><i class="fa fa-ellipsis-v fa-fw"></i> &nbsp; <a title="Edit" data-toggle="tooltip" data-placement="top" class="btn btn-info btn-circle"><i class="fa fa-edit fa-fw"></i></a> &nbsp; This icon stands for "edit." By clicking on this icon a record can be edited.</div></td>
                    </tr>
                    <tr>
                      <td><div class="tooltip-demo"><i class="fa fa-ellipsis-v fa-fw"></i> &nbsp; <a title="Delete" data-toggle="tooltip" data-placement="top" class="btn btn-danger btn-circle"><i class="fa fa-trash fa-fw"></i></a> &nbsp; This icon stands for "delete." By clicking on this icon a record can be deleted.</div></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="row" id="list_donation">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Login History</h3>
              </div>
              <div class="card-body table-responsive p-0">
                <table id="dataTables-example" class="table table-striped table-bordered" style="border: 1px solid #337ab7 !important;">
                  <thead>
                    <tr>
                      <th style="display:none;">SL</th>
                      <th>TYPE</th>
                      <th>LOGIN TIME</th>
                      <th>LOGIN IP</th>
                      <th>LOGOUT TIME</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
				  global $link;
               	  $sql_list_about = "SELECT * FROM ".ADMIN_LOGIN_DETAILS." ORDER BY id DESC";	
				  $qry_list_about = mysqli_query($link,$sql_list_about);
				  $num_list_about = mysqli_num_rows($qry_list_about);
				  if($num_list_about>0){
					  $i=1;
					 while($row_list_about=mysqli_fetch_array($qry_list_about)){
				  ?>
                    <tr>
                      <td style="display:none;"><?php echo $i;?></td>
                      <td><?php echo ucwords($row_list_about['userType']);?></td>
                      <td><?php echo !empty($row_list_about['login_time'])?formatDateTime($row_list_about['login_time']):' - - ';?></td>
                      <td><?php echo $row_list_about['login_ip'];?></td>
                      <td><?php echo !empty($row_list_about['logout_time'])?formatDateTime($row_list_about['logout_time']):' - - ';?></td>
                    </tr>
                    <?php $i++;}}?>
                    
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>    
    <?php }else{?>
    <div class="row">
      <div class="col-lg-12">
        <div class="panel tabbed-panel panel-success">
          <div class="panel-heading clearfix">
            <div class="panel-title pull-left"><a data-toggle="collapse" href="#collapseOne" aria-expanded="false"><strong>Icon Reference</strong></a></div>
          </div>
          <div class="panel-body" id="collapseOne" aria-expanded="true">
            <div class="panel-body">
              <div class="table-responsive">
                <table class="table table-striped">
                  <tbody>
                    <tr>
                      <td><div class="tooltip-demo"><i class="fa fa-ellipsis-v fa-fw"></i> &nbsp; <a title="Edit" data-toggle="tooltip" data-placement="top" class="btn btn-info btn-circle"><i class="fa fa-edit fa-fw"></i></a> &nbsp; This icon stands for "edit." By clicking on this icon a record can be edited.</div></td>
                    </tr>
                    <tr>
                      <td><div class="tooltip-demo"><i class="fa fa-ellipsis-v fa-fw"></i> &nbsp; <a title="Delete" data-toggle="tooltip" data-placement="top" class="btn btn-danger btn-circle"><i class="fa fa-trash fa-fw"></i></a> &nbsp; This icon stands for "delete." By clicking on this icon a record can be deleted.</div></td>
                    </tr>
                     <?php /* if($_SESSION['type_id']==3){?>
                    <tr>
                      <td><div class="tooltip-demo"><i class="fa fa-ellipsis-v fa-fw"></i> &nbsp; My URL &nbsp; <?php echo BASE_URL.$_SESSION['user_id'];?></div></td>
                    </tr>
                    <?php }*/?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row" id="list_donation">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Login History</h3>
              </div>
              <div class="card-body table-responsive p-0">
                <table id="dataTables-example" class="table table-striped table-bordered" style="border: 1px solid #337ab7 !important;">
                  <thead>
                    <tr> 
                      <th style="display:none;">SL</th>
                      <th>LOGIN TIME</th>
                      <th>LOGIN IP</th>
                      <th>LOGOUT TIME</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
				  global $link;
               	  $sql_list_about = "SELECT * FROM ".ADMIN_LOGIN_DETAILS." WHERE a_id=".$_SESSION['admin_user_id']." ORDER BY id DESC";	
				  $qry_list_about = mysqli_query($link,$sql_list_about);
				  $num_list_about = mysqli_num_rows($qry_list_about);
				  if($num_list_about>0){
					 $i=1;
					 while($row_list_about=mysqli_fetch_array($qry_list_about)){
				  ?>
                    <tr>
                      <td style="display:none;"><?php echo $i;?></td>
                      <td><?php echo !empty($row_list_about['login_time'])?formatDateTime($row_list_about['login_time']):' - - ';?></td>
                      <td><?php echo $row_list_about['login_ip'];?></td>
                      <td><?php echo !empty($row_list_about['logout_time'])?formatDateTime($row_list_about['logout_time']):' - - ';?></td>
                    </tr>
                    <?php }}?>
                    
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
    <?php  }?>
    <!-- /.row --> 
  </div>
  <!-- /.container-fluid --> 
</div>
<!-- /#page-wrapper -->
<?php  }?>
