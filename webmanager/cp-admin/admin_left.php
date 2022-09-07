<?php 
include_once("../../connection.php");
if($_SESSION['admin_user_id']=='')					redirect('index');

global $link;
?>
<!-- Navigation -->

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="navbar-header"><div class="tooltip-demo"> <a class="navbar-brand text-center"  target="_blank" href="<?=BASE_URL?>" style="line-height: 45px;color:#fff; background-color:#4f3b3b;height: 51px; padding: 6px 25px;" title="View the Site" data-toggle="tooltip" data-placement="bottom" >
    <img src="<?php echo BASE_URL.'uploads/admin/'.get_siteconfig('logo'); ?>" width="200" style="height: auto;" alt="<?=SITETITLE?>" />
    </a> </div></div>
  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
  <ul class="nav navbar-right navbar-top-links">
    <!--<li class="dropdown navbar-inverse"> <a class="dropdown-toggle" data-toggle="dropdown" href="#"> <i class="fa fa-bell fa-fw"></i> <b class="caret"></b> </a>
      <ul class="dropdown-menu dropdown-alerts">
        <li> <a href="#">
          <div> <i class="fa fa-comment fa-fw"></i> New Comment <span class="pull-right text-muted small">4 minutes ago</span> </div>
          </a> </li>
        <li> <a href="#">
          <div> <i class="fa fa-twitter fa-fw"></i> 3 New Followers <span class="pull-right text-muted small">12 minutes ago</span> </div>
          </a> </li>
        <li> <a href="#">
          <div> <i class="fa fa-envelope fa-fw"></i> Message Sent <span class="pull-right text-muted small">4 minutes ago</span> </div>
          </a> </li>
        <li> <a href="#">
          <div> <i class="fa fa-tasks fa-fw"></i> New Task <span class="pull-right text-muted small">4 minutes ago</span> </div>
          </a> </li>
        <li> <a href="#">
          <div> <i class="fa fa-upload fa-fw"></i> Server Rebooted <span class="pull-right text-muted small">4 minutes ago</span> </div>
          </a> </li>
        <li class="divider"></li>
        <li> <a class="text-center" href="#"> <strong>See All Alerts</strong> <i class="fa fa-angle-right"></i> </a> </li>
      </ul>
    </li>-->
    <li class="dropdown"> <a class="dropdown-toggle" data-toggle="dropdown" href="#">
      Welcome, <?=$_SESSION['first_name']?>
      <b class="caret"></b> </a>
      <ul class="dropdown-menu dropdown-user">
        <li><a href="<?=CP_URL?>admin_profile.php"><i class="fa fa-user fa-fw"></i> My Profile</a> </li>
        <?php //if($_SESSION['type_id']== 1){?>
        <li class="divider"></li>
        <li><a href="<?=CP_URL?>admin_changepwd.php"><i class="fa fa-lock fa-fw"></i> Change Password</a> </li>
        <?php // }?>
        <li class="divider"></li>
        <li><a href="#" data-toggle="modal" data-target="#myModal"><i class="fa fa-sign-out fa-fw"></i> Logout</a> </li>
      </ul>
    </li>
  </ul>
  <!-- /.navbar-top-links -->
  
  <div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
      <ul class="nav" id="side-menu">
        <!--<li class="sidebar-search">
          <div class="input-group custom-search-form">
            <input type="text" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
            <button class="btn btn-primary" type="button"> <i class="fa fa-search"></i> </button>
            </span> </div>-->
          <!-- /input-group
        </li> --> 
        <li> <a href="<?=URL?>" class="active" style="color:#939da8;text-shadow: 0 -1px 0 rgba(0,0,0,0.25);"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a> </li>
        <?php 
		if($_SESSION['type_id']==1){
			 $sql_select= "SELECT * FROM ".MENU_MASTER."  where menu_id ='0' AND status!='D' AND status!='I' ORDER BY order_by asc";
			 $sql_query= mysqli_query($link,$sql_select);
			 while($row= mysqli_fetch_array($sql_query)){
		?>
        <li> <a href="#" style="color:#939da8;"><i class="<?php if(!empty($row['icons'])){echo $row['icons'];}else{?>fa fa-th-list fa-fw<?php }?>"></i>
          <?php  echo $row['menuLabel']; ?>
          <span class="fa arrow"></span></a>
          <ul class="nav nav-second-level">
            <?php 
            $sql_selectS= "SELECT * FROM ".MENU_MASTER."  where menu_id ='".$row['submenu_id']."'  AND status!='D' ORDER BY order_by asc";
			 $sql_queryS= mysqli_query($link,$sql_selectS);
			 while($row_sub= mysqli_fetch_array($sql_queryS)){
            ?>
            <li> <a href="<?php if($row_sub['menu_id']==1){?><?=CP_URL?><?php }else{?><?=MP_URL?><?php }?><?php  echo $row_sub['file_name']; ?>"><i class="<?php if(!empty($row_sub['icons'])){echo $row_sub['icons'];}else{?>fa fa-dot-circle-o fa-fw<?php }?>"></i>
              <?php  echo $row_sub['menuLabel']; ?>
              </a> </li>
            <?php }?>
          </ul>
          <!-- /.nav-second-level --> 
        </li>
        <?php }}else{
			  
			  $menuListFinal = implode(",", admin_menulist($_SESSION['type_id']));
			  
			
			$sql= "SELECT * FROM ".MENU_MASTER." WHERE submenu_id IN (".$menuListFinal.") AND status='A' GROUP BY menu_id ORDER BY menu_id asc";
			 $sql_q= mysqli_query($link,$sql);
			while($rowq= mysqli_fetch_array($sql_q)){
				
			$sql_select= "SELECT * FROM ".MENU_MASTER." WHERE submenu_id=".$rowq['menu_id']." AND status='A' ORDER BY order_by asc";
			
			 $sql_query= mysqli_query($link,$sql_select);
			 while($row= mysqli_fetch_array($sql_query)){
			?>
        <li> <a href="#" style="color:#939da8;"><i class="<?php if(!empty($row['icons'])){echo $row['icons'];}else{?>fa fa-th-list fa-fw<?php }?>"></i>
          <?php  echo $row['menuLabel']; ?>
          <span class="fa arrow"></span></a>
          <ul class="nav nav-second-level">
            <?php 
            $sql_selectS= "SELECT * FROM ".MENU_MASTER."  WHERE submenu_id IN (".$menuListFinal.") AND menu_id ='".$row['submenu_id']."'  AND status='A' ORDER BY order_by asc";
			 $sql_queryS= mysqli_query($link,$sql_selectS);
			 while($row_sub= mysqli_fetch_array($sql_queryS)){
            ?>
            <li> <a href="<?php if($row_sub['menu_id']==1){?><?=CP_URL?><?php }else{?><?=MP_URL?><?php }?><?php  echo $row_sub['file_name']; ?>"><i class="<?php if(!empty($row_sub['icons'])){echo $row_sub['icons'];}else{?>fa fa-dot-circle-o fa-fw<?php }?>"></i>
              <?php  echo $row_sub['menuLabel']; ?>
              </a> </li>
            <?php }?>
          </ul>
          <!-- /.nav-second-level --> 
        </li>
        <?php }}}?>
      </ul>
    </div>
  </div>
</nav>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="myModalLabel">Ready to Leave?</h4>
      </div>
      <div class="modal-body"> Select "Sign out" below if you are ready to end your current session </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <a href="<?=CP_URL?>logout.php" class="btn btn-primary">Sign out</a> </div>
    </div>
    <!-- /.modal-content --> 
  </div>
  <!-- /.modal-dialog --> 
</div>
