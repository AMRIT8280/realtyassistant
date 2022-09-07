<?php 
session_start();
$_SESSION['session_id']=session_id();
date_default_timezone_set('Asia/Kolkata');
include("includes/table_name.php");
include("includes/a.php");
include("includes/b.php");
include("includes/function.php");
include("includes/pagination.php");

?>