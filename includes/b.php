<?php
global $link;

$link = mysqli_connect(SERVER,USER,PASSWORD,DATABASE) or die("Not connected<br>" . mysqli_error($link));

if(!$link){
	echo "<br><h1>Database not connected.</h1><br>";
}

function get_siteconfig_define($key)
{
	global $link;
	$img_src = false;

	$sql_select = "SELECT * FROM " . CONFIG . " Where _key='" . $key . "'";
	$sql_query = mysqli_query($link, $sql_select);
	$sql_row = mysqli_fetch_array($sql_query);
	return $sql_row['value'];
}

//################################  Redirect URl ######################################//
//local


define("BASE_URL", "http://" . $_SERVER['HTTP_HOST'] . "/realtyassistant/");

define("URL", BASE_URL . "webmanager/");
define("CP_URL", BASE_URL . "webmanager/cp-admin/");
define("MP_URL", BASE_URL . "webmanager/mp-admin/");



define("ADMIN_EMAIL", get_siteconfig_define('email'));
define("ADMIN_CONTACT", get_siteconfig_define('phone'));
define("ADMIN_ADDRESS", get_siteconfig_define('city_address'));
define("ADMIN_ADDRESS_HEAD", get_siteconfig_define('website_address'));
define("NAME", '');
define("TIME_ZONE", get_siteconfig_define('time_zone'));
define("TITLE", get_siteconfig_define('website_name'));
define("LOGO", BASE_URL . 'uploads/admin/' . get_siteconfig_define('logo'));
define("FAB_ICO", BASE_URL . 'uploads/admin/' . get_siteconfig_define('favicon'));
