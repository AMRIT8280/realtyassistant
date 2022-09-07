<?php 
include_once("../../connection.php");
global $link;
$sql_delete_about= "UPDATE ".ADMIN_LOGIN_DETAILS." 
	SET 
	logout_time= '".date('Y-m-d h:i:s')."'
	where a_id=".$_SESSION['admin_user_id']." AND id=".$_SESSION['last_admin_id'] ;   
$qry_delete_about=mysqli_query($link,$sql_delete_about) or die(mysqli_error());
session_destroy();
?>
<script language="javascript">
	window.location="../index.php";
</script>
