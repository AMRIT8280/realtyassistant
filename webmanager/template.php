<?php
include_once("../../connection.php");
header('Cache-Control: private');
$GLOBALS['show']=10;	

function disphtml($what){

if(isset($_REQUEST['pageNo'])==""){
$GLOBALS['start'] = 0;

	$_REQUEST['pageNo'] = 1;

	}
	else{
		$GLOBALS['start']=($_REQUEST['pageNo']-1) * $GLOBALS['show'];
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include_once('cp-admin/admin_header.php');?>
</head>
<body>
<div id="wrapper">
	 <!-- Navbar -->
  <?php include_once('cp-admin/admin_left.php');?>


  <?php  echo eval($what);?>

  
</div>
<?php include("cp-admin/admin_footer.php");?>
</body>
</html>
<?php  } ?>