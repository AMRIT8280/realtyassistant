<?php //Function to display Alphabet
function DisplayAlphabet()
{
	$str = "A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z";
	$str = explode(",", $str);
	for ($i = 0; $i < sizeof($str); $i++) {
		echo "<a href=\"#\" class='link' onClick=\"javascript:search_alpha('" . $str[$i] . "')\">$str[$i]</a>&nbsp;&nbsp;&nbsp;";
	}
}
function fileread_curl($url)
{
	$filename = $url;
	$ch = curl_init();
	// set the url to fetch
	curl_setopt($ch, CURLOPT_URL, $filename);
	// don't give me the headers just the content
	curl_setopt($ch, CURLOPT_HEADER, 0);
	// return the value instead of printing the response to browser
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	// use a user agent to mimic a browser
	// curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.5) Gecko/20041107 Firefox/1.0'); 
	$content = curl_exec($ch);
	// remember to always close the session and free all resources 
	curl_close($ch);
	return $content;
}
function getValueById($table, $field, $id_name, $id)
{
	global $link;
	$return = '';
	$sql_temp = "SELECT " . $field . " from " . $table . " where " . $id_name . "='" . $id . "'";
	$rs_temp  = mysqli_query($link, $sql_temp);
	$cnt_temp = mysqli_num_rows($rs_temp);
	if ($cnt_temp != 0) {
		$row_temp = mysqli_fetch_row($rs_temp);
		$return = $row_temp[0];
	}
	return $return;
}
//Function to make thumnail of the image
function thumbnail($imagepath, $Img_Upload_Path)
{
	$save = $Img_Upload_Path . "thm_" . $imagepath; //This is the new file you saving
	$file = $Img_Upload_Path . $imagepath; //This is the original file
	list($width, $height, $type) = getimagesize($file);
	$modwidth = 150;
	$diff = $width / $modwidth;
	$modheight = $height / $diff;
	$tn = imagecreatetruecolor($modwidth, $modheight);
	switch ($type) {
		case 1:
			$image = imagecreatefromgif($file);
			break;
		case 2:
			$image = imagecreatefromjpeg($file);
			break;
		case 3:
			$image = imagecreatefrompng($file);
			break;
		default:
			return false;
	}
	@imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height);
	@imagejpeg($tn, $save, 100);
	@chmod($Img_Upload_Path . $imagepath, 0777);
	@chmod($Img_Upload_Path . 'thm_' . $imagepath, 0777);
	return   $Img_Upload_Path . 'thm_' . $imagepath;
}

function fn_create_thumbnail_image($name, $folder_name)
{
	$save = $folder_name . "/thumb_" . $name; //This is the new file you saving
	$file = $folder_name . "/" . $name; //This is the original file
	list($width, $height, $type) = getimagesize($file);
	if ($width >= $height) {
		$modwidth = 120;
		$diff = $width / $modwidth;
		$modheight = $height / $diff;
	} else {
		$modheight = 90;
		$diff = $height / $modheight;
		$modwidth = $width / $diff;
	}
	$tn = imagecreatetruecolor($modwidth, $modheight);
	switch ($type) {
		case 1:
			$image = imagecreatefromgif($file);
			break;
		case 2:
			$image = imagecreatefromjpeg($file);
			break;
		case 3:
			$image = imagecreatefrompng($file);
			break;
		default:
			return false;
	}
	@imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height);
	@imagejpeg($tn, $save, 100);
	return "thumb_" . $name;
}

/**********************************Admin Pannel****************************************/

function ConvertRealString($string)
{
	return addslashes(htmlspecialchars(strip_tags(trim($string))));
}

function redirect($file_name)
{
	header('location:' . URL . $file_name . '.php');
}

function redirect_cp($file_name)
{
	header('location:' . CP_URL . $file_name . '.php');
}

function redirect_mp($file_name)
{
	header('location:' . MP_URL . $file_name . '.php');
}


function redirect_mp_with_param($file_name)
{
	header('location:' . MP_URL . $file_name);
}


function br2nl($text)
{
	return  preg_replace('/<br\\s*?\/??>/i', '', $text);
}

function WordLimiter($text, $limit)
{
	$explode = explode(' ', $text);
	$string  = '';

	$dots = '...';
	if (count($explode) <= $limit) {
		$dots = '';
		for ($i = 0; $i < count($explode); $i++) {
			$string .= $explode[$i] . " ";
		}
	} else {
		for ($i = 0; $i < $limit; $i++) {
			$string .= $explode[$i] . " ";
		}
	}
	return $string . $dots;
}

function deleteRecord($tableName, $condition)
{
	global $link;
	$sql = "DELETE FROM `" . $tableName . "` WHERE " . $condition;
	if ($sql == true) {
		return $sql_query = mysqli_query($link, $sql);
	}
}

function getRecordFlied($tableName, $condition, $flied)
{
	//getRecordFlied(DB_TABLENAME,'id='.$row_list_about['id'],'main_title');
	// getRecordFlied(DB_TABLENAME,"main_title='up_footer'","descript");
	global $link;
	$sql = "SELECT * FROM `" . $tableName . "` WHERE " . $condition;
	if ($sql == true) {
		$sql_query = mysqli_query($link, $sql);
		$sql_row =  mysqli_fetch_array($sql_query);
		return $sql_row[$flied];
	}
}

function get_membertype($id)
{
	global $link;
	$sql_select = "SELECT * FROM " . MEMBER_TYPE . " where type_id=" . $id;
	$sql_query = mysqli_query($link, $sql_select);
	$sql_row =  mysqli_fetch_array($sql_query);
	return $sql_row['member_type'];
}
function privliges_check($type, $menu)
{
	global $link;
	$sql_select = "SELECT * FROM " . PRIVILEGES . " Where type_id=" . $type . " AND submenu_id=" . $menu . " AND status!='D' ";
	$sql_query = mysqli_query($link, $sql_select);
	$sql_row = mysqli_fetch_array($sql_query);
	$sql_num = mysqli_num_rows($sql_query);
	if ($sql_num > 0) {
		return false;
	} else {
		return true;
	}
}

function admin_menulist($type)
{
	global $link;
	$menuList = array();
	$sql_select = "SELECT * FROM " . PRIVILEGES . " Where type_id=" . $type . " AND status='A' ";
	$sql_query = mysqli_query($link, $sql_select);
	$sql_num = mysqli_num_rows($sql_query);
	if ($sql_num > 0) {
		$i = 0;
		while ($row_edit = mysqli_fetch_array($sql_query)) {
			$menuList[$i] = $row_edit['submenu_id'];
			$i++;
		}
	}
	return $menuList;
}

function _saveSettings($data = array())
{
	global $link;
	foreach ($data as $k => $v) {
		$sql_select = "SELECT * FROM " . CONFIG . " WHERE _key ='" . $k . "'";
		$sql_query = mysqli_query($link, $sql_select);
		$sql_num = mysqli_num_rows($sql_query);

		if ($sql_num > 0) {
			$sql = "UPDATE " . CONFIG . "
			SET
			
			value = '" . $v . "'
			WHERE
			_key = '" . $k . "'";
			$qry_update = mysqli_query($link, $sql) or die(mysqli_error($link));
		} else {
			$sql_inset_post = "INSERT INTO " . CONFIG . " 
			SET 
			
			_key = '" . $k . "',			
			value = '" . $v . "'";
			$qry_inset	= mysqli_query($link, $sql_inset_post) or die(mysqli_error($link));
		}
	}
}

function get_siteconfig($key)
{
	global $link;
	$img_src = false;

	$sql_select = "SELECT * FROM " . CONFIG . " Where _key='" . $key . "'";
	$sql_query = mysqli_query($link, $sql_select);
	$sql_row = mysqli_fetch_array($sql_query);

	/*if ($key == 'logo') {
		$logo = $sql_row['value'] =='logo';
		if ($logo != '') {
			$img_src = URL.'uploads/admin/' . $logo;
		}
		return $img_src;
	}
	if ($key == 'favicon') {
		$logo = get_siteconfig('favicon');
		if ($logo != '') {
			$img_src = URL.'assets/img/' . $logo;
		}
		return $img_src;
	}*/
	return $sql_row['value'];
}


function time_am_pm($aid)
{
	$data = date('h:i a', strtotime($aid));
	return $data;
}


function webformatDateTime($datetime)
{
	global $cfg, $mycms;
	if ($datetime != '') {
		return date('d-m-Y h:i A', strtotime($datetime));
	} else {
		return '';
	}
}
function webformatDate($datetime)
{
	global $cfg, $mycms;
	if ($datetime != '') {
		return date('d-m-Y', strtotime($datetime));
	} else {
		return '';
	}
}

function day_id($aid)
{
	if ($aid == 'Sunday') {
		$data = 0;
	} else if ($aid == 'Monday') {
		$data = 1;
	} else if ($aid == 'Tuesday') {
		$data = 2;
	} else if ($aid == 'Wednesday') {
		$data = 3;
	} else if ($aid == 'Thursday') {
		$data = 4;
	} else if ($aid == 'Friday') {
		$data = 5;
	} else if ($aid == 'Saturday') {
		$data = 6;
	}

	return $data;
}

function day_id_get_name($aid)
{
	if ($aid == '0') {
		$data = 'Sunday';
	} else if ($aid == '1') {
		$data = 'Monday';
	} else if ($aid == '2') {
		$data = 'Tuesday';
	} else if ($aid == '3') {
		$data = 'Wednesday';
	} else if ($aid == '4') {
		$data = 'Thursday';
	} else if ($aid == '5') {
		$data = 'Friday';
	} else if ($aid == '6') {
		$data = 'Saturday';
	}

	return $data;
}


function formatDate($date)
{
	global $link;
	if ($date != '') {
		return date('M j, Y', strtotime($date));
	} else {
		return '';
	}
}

function formatTime($time)
{
	global $link;
	return date('h:i A', strtotime($time));
}

function formatDateTime($datetime)
{
	global $link;
	if ($datetime != '') {
		return date('M j, Y h:i A', strtotime($datetime));
	} else {
		return '';
	}
}


function send_mail_commons($to_name, $to_email, $from_name, $from_email, $subject, $message)
{
	global $link;
	$mailContent	=   base64_encode($message);
	$headers = "From: $from_name <$from_email>\r\n" .
		"MIME-Version: 1.0" . "\r\n" .
		"Content-type: text/html; charset=UTF-8" . "\r\n";
	if (mail($to_email, $subject, $message, $headers)) {
		echo 'ok';
		$status	=	'sucess';
		//return true;
	} else {
		echo 'not ok';
		$status	=	'failed';
		//return false;
	}


	/*$sqlInsert				=	array();
		$sqlInsert['QUERY']		=	"INSERT INTO ".DB_EMAIL_HISTORY."
									SET
										`to_name`       	= ?,
										`to_email` 			= ?,
										`from_email` 		= ?,
										`subject` 			= ?,
										`message` 			= ?,
										`status`		 	= ?,
										`date`				= ?,
										`ipaddress`			= ?,
										`session`			= ?";

		$sqlInsert['PARAM'][]	=	array('FILD' => 'to_name',			'DATA' => $to_name,					'TYP' => 's');
		$sqlInsert['PARAM'][]	=	array('FILD' => 'to_email',			'DATA' => $to_email, 				'TYP' => 's');
		$sqlInsert['PARAM'][]	=	array('FILD' => 'from_email',		'DATA' => $from_email,				'TYP' => 's');
		$sqlInsert['PARAM'][]	=	array('FILD' => 'subject',			'DATA' => $subject, 				'TYP' => 's');
		$sqlInsert['PARAM'][]	=	array('FILD' => 'message',	    	'DATA' => addslashes($mailContent),	'TYP' => 's');
		$sqlInsert['PARAM'][]	=	array('FILD' => 'status',			'DATA' => $status,	 			'TYP' => 's');

		$sqlInsert['PARAM'][]	=	array('FILD' => 'date', 			'DATA' => date('Y-m-d H:i:s'), 		'TYP' => 's');
		$sqlInsert['PARAM'][]	=	array('FILD' => 'ipaddress', 		'DATA' => $_SERVER['REMOTE_ADDR'],	'TYP' => 's');
		$sqlInsert['PARAM'][]	=	array('FILD' => 'session',			'DATA'=> session_id(),				'TYP' => 's');

		$resInsert				=	$mycms->sql_insert($sqlInsert);*/
}


/***********************************End Pannel***************************************/
/***********************************Forndend***********************************/

function get_country_name($id)
{
	global $link;
	$sql_select = "SELECT * FROM " . DB_COUNTRY . " Where id='" . $id . "'";
	$sql_query = mysqli_query($link, $sql_select);
	$sql_row = mysqli_fetch_array($sql_query);
	return $sql_row['main_title'];
}
function get_city_name($id)
{
	global $link;
	$sql_select = "SELECT * FROM " . DB_CITY . " Where id='" . $id . "'";
	$sql_query = mysqli_query($link, $sql_select);
	$sql_row = mysqli_fetch_array($sql_query);
	return $sql_row['main_title'];
}

function get_user_name($id)
{
	global $link;
	$sql_select = "SELECT * FROM " . DB_REGISTER . " Where id='" . $id . "'";
	$sql_query = mysqli_query($link, $sql_select);
	$sql_row = mysqli_fetch_array($sql_query);
	return $sql_row['main_title'];
}

function get_user_mail($id)
{
	global $link;
	$sql_select = "SELECT * FROM " . DB_REGISTER . " Where id='" . $id . "'";
	$sql_query = mysqli_query($link, $sql_select);
	$sql_row = mysqli_fetch_array($sql_query);
	return $sql_row['contact_mail'];
}
function get_board_basis($id)
{
	global $link;
	$sql_select = "SELECT * FROM " . DB_BOARD_BASIS . " Where id='" . $id . "'";
	$sql_query = mysqli_query($link, $sql_select);
	$sql_row = mysqli_fetch_array($sql_query);
	return $sql_row['main_title'];
}
function get_tour_name($id)
{
	global $link;
	$sql_select = "SELECT * FROM " . DB_TOUR_PLAN . " Where id='" . $id . "'";
	$sql_query = mysqli_query($link, $sql_select);
	$sql_row = mysqli_fetch_array($sql_query);
	return $sql_row['main_title'];
}
function return_date($value)
{
	$end_time = date('Y-m-d', strtotime($value . "+15 day"));
	return $end_time;
}
function get_directories_cat_name($id)
{
	global $link;
	$sql_select = "SELECT main_title FROM " . DB_DIRECTORIES_CATEGORY . " Where id='" . $id . "'";
	$sql_query = mysqli_query($link, $sql_select);
	$sql_row = mysqli_fetch_array($sql_query);
	return $sql_row['main_title'];
}

/***********************************End Library***********************************/



/*********************START*********************/

function get_city_and_country_by_city_id($id)
{
	global $link;
	$sql_select_city_country = "SELECT " . DB_CITY . ".`main_title` AS 'city_name'," . DB_CITY . ".`id` AS 'city_id'," . DB_CITY . ".`image_name` AS 'city_image'," . DB_COUNTRY . ".`main_title` AS 'country_name'," . DB_COUNTRY . ".`id` AS 'country_id'," . DB_COUNTRY . ".`image_name` AS 'country_image' FROM " . DB_CITY . "," . DB_COUNTRY . " WHERE " . DB_CITY . ".`country_id`=" . DB_COUNTRY . ".`id` AND " . DB_CITY . ".`id`=" . $id . " AND " . DB_CITY . ".`status`='A'";
	$sql_query_city_country = mysqli_query($link, $sql_select_city_country);
	$all_city_country = mysqli_fetch_all($sql_query_city_country, MYSQLI_ASSOC)[0];
	return $all_city_country;
}

function get_city($by = "")
{
	global $link;
	$sql_select_city = "SELECT * FROM " . DB_CITY . " WHERE " . $by . " AND `status`='A' ORDER BY main_title ASC";
	if ($by == "") {
		$sql_select_city = "SELECT * FROM " . DB_CITY . " WHERE `status`='A' ORDER BY main_title ASC";
	}
	$sql_query_city = mysqli_query($link, $sql_select_city);
	$all_city = mysqli_fetch_all($sql_query_city, MYSQLI_ASSOC);
	return $all_city;
}

function get_country($by = "")
{
	global $link;
	$sql_select_country = "SELECT * FROM " . DB_COUNTRY . " WHERE " . $by . " AND `status`='A'";
	if ($by == "") {
		$sql_select_country = "SELECT * FROM " . DB_COUNTRY . " WHERE `status`='A'";
	}
	$sql_query_country = mysqli_query($link, $sql_select_country);
	$all_country = mysqli_fetch_all($sql_query_country, MYSQLI_ASSOC);
	return $all_country;
}

function get_ap_type($by = "")
{
	global $link;
	$sql_select_ap_type = "SELECT * FROM " . DB_AP_TYPE . " WHERE " . $by . " AND `status`='A' ORDER BY `main_title` ASC";
	if ($by == "") {
		$sql_select_ap_type = "SELECT * FROM " . DB_AP_TYPE . " WHERE `status`='A' ORDER BY `main_title` ASC";
	}
	$sql_query_ap_type = mysqli_query($link, $sql_select_ap_type);
	$all_ap_type = mysqli_fetch_all($sql_query_ap_type, MYSQLI_ASSOC);
	return $all_ap_type;
}

function get_appartment($by = "")
{
	global $link;
	$sql_select_ap = "SELECT * FROM " . DB_APPARTMENT . " WHERE " . $by . " AND `status`='A' ORDER BY `id` DESC";
	if ($by == "") {
		$sql_select_ap = "SELECT * FROM " . DB_APPARTMENT . " WHERE `status`='A' ORDER BY `id` DESC";
	}
	$sql_query_ap = mysqli_query($link, $sql_select_ap);
	$all_ap = mysqli_fetch_all($sql_query_ap, MYSQLI_ASSOC);
	return $all_ap;
}

function get_building_name($room_id = "")
{
	$room_deatils = get_room("id=" . $room_id);
	if (!empty($room_deatils)) {
		$app_deatils = get_appartment("id=" . $room_deatils[0]["ap_id"]);
		if (!empty($app_deatils)) {
			$final_data = json_decode($app_deatils[0]["building_floors"], true);
			$ressult = $final_data[$room_deatils[0]["building_id"]];
			$ressult["key"] = $room_deatils[0]["building_id"];
			return $ressult;
		}
	}
	return 0;
}

function get_room($by = "")
{
	global $link;
	$sql_select = "SELECT * FROM " . DB_AP_ROOM . " WHERE " . $by . " AND `status`='A' ORDER BY `id` DESC";
	if ($by == "") {
		$sql_select = "SELECT * FROM " . DB_AP_ROOM . " WHERE `status`='A' ORDER BY `id` DESC";
	}
	$sql_query_ap = mysqli_query($link, $sql_select);
	$all_ap = mysqli_fetch_all($sql_query_ap, MYSQLI_ASSOC);
	return $all_ap;
}

function get_bookings($by = "")
{
	global $link;
	$sql_select = "SELECT * FROM " . DB_BOOKING . " WHERE " . $by . " ORDER BY `id` DESC";
	if ($by == "") {
		$sql_select = "SELECT * FROM " . DB_BOOKING . " ORDER BY `id` DESC";
	}
	$sql_query_ap = mysqli_query($link, $sql_select);
	$all_ap = mysqli_fetch_all($sql_query_ap, MYSQLI_ASSOC);
	return $all_ap;
}

function get_user($by = "")
{
	global $link;
	$sql_select = "SELECT * FROM " . DB_REGISTER . " WHERE " . $by . " AND `status`='A' ORDER BY `id` DESC";
	if ($by == "") {
		$sql_select = "SELECT * FROM " . DB_REGISTER . " WHERE `status`='A' ORDER BY `id` DESC";
	}
	$sql_query_ap = mysqli_query($link, $sql_select);
	$all_user = mysqli_fetch_all($sql_query_ap, MYSQLI_ASSOC);
	return $all_user;
}





// Create a function for converting the amount to decimal
function convertCurrency($amount)
{
	$Arraycheck = array("4" => "K", "5" => "K", "6" => "L", "7" => "L", "8" => "Cr", "9" => "Cr");
	// define decimal values
	$numberLength = strlen($amount); //count the length of numbers
	if ($numberLength > 3) {
		foreach ($Arraycheck as $Lengthnum => $unitval) {
			if ($numberLength == $Lengthnum) {
				if ($Lengthnum % 2 == 0) {
					$RanNumber = substr($amount, 1, 2);
					$NmckGtZer = ($RanNumber[0] + $RanNumber[1]);
					if ($NmckGtZer < 1) {
						$RanNumber = "0";
					} else {
						if ($RanNumber[1] == 0) {
							$RanNumber[1] = "0";
						}
					}
					$amount = substr($amount, 0, $numberLength - $Lengthnum + 1) . "." . $RanNumber . " $unitval ";
				} else {
					$RanNumber = substr($amount, 2, 2);
					$NmckGtZer = ($RanNumber[0] + $RanNumber[1]);
					if ($NmckGtZer < 1) {
						$RanNumber  = 0;
					} else {
						if ($RanNumber[1] == 0) {
							$RanNumber[1] = "0";
						}
					}
					$amount = substr($amount, 0, $numberLength - $Lengthnum + 2) . "." . $RanNumber . " $unitval";
				}
			}
		}
	} else {
		$amount . "Rs";
	}
	return $amount;
}

function AmountInWords(float $amount)
{
	$amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
	// Check if there is any number after decimal
	$amt_hundred = null;
	$count_length = strlen($num);
	$x = 0;
	$string = array();
	$change_words = array(
		0 => '', 1 => 'One', 2 => 'Two',
		3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
		7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
		10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
		13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
		16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
		19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
		40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
		70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
	);
	$here_digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
	while ($x < $count_length) {
		$get_divider = ($x == 2) ? 10 : 100;
		$amount = floor($num % $get_divider);
		$num = floor($num / $get_divider);
		$x += $get_divider == 10 ? 1 : 2;
		if ($amount) {
			$add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
			$amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
			$string[] = ($amount < 21) ? $change_words[$amount] . ' ' . $here_digits[$counter] . $add_plural . ' 
       ' . $amt_hundred : $change_words[floor($amount / 10) * 10] . ' ' . $change_words[$amount % 10] . ' 
       ' . $here_digits[$counter] . $add_plural . ' ' . $amt_hundred;
		} else $string[] = null;
	}
	$implode_to_Rupees = implode('', array_reverse($string));
	$get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
   " . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';
	return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees ' : '') . $get_paise;
}


function send_mail_common($to_name, $to_email, $from_name, $from_email, $subject, $messege)
{
	$headers = "From: $from_name <$from_email>\r\n" .
		"MIME-Version: 1.0" . "\r\n" .
		"Content-type: text/html; charset=UTF-8" . "\r\n";
	if (mail($to_email, $subject, $messege, $headers)) {
		//return 'sucess';
		//$status	=	'sucess';
		return true;
	} else {
		//return 'failed';
		//$status	=	'failed';
		return false;
	}
}

function get_apartment_room_booking_status($ap_id)
{
	global $link;
	$ressult = [];
	$ressult["available"] = 0;
	$ressult["booked"] = 0;
	if (!empty($ap_id)) {
		$all_rooms = get_room("ap_id=" . $ap_id);
		if (!empty($all_rooms)) {
			foreach ($all_rooms as $count_room) {
				if ($count_room["booking_status"] == "available") {
					$ressult["available"] += 1;
				}
				if ($count_room["booking_status"] == "booked") {
					$ressult["booked"] += 1;
				}
			}
		}
	}
	return $ressult;
}


function generate_new_user_id()
{
	global $link;
	$id = rand(100, 999) . rand(100, 999);
	$sql = "SELECT `user_id` FROM " . LOGIN_MASTER . " WHERE `user_id`='" . $id . "'";
	$query_result = mysqli_query($link, $sql);
	if ($query_result) {
		if (mysqli_num_rows($query_result) > 0) {
			return generate_new_user_id();
		} else {
			return $id;
		}
	}
}


function get_all_featured_apartments()
{
	global $link;
	$ressult = [];
	$ressult["status"] = "error";
	$ressult["message"] = "Something went wrong.";

	$sql = "SELECT " . DB_APPARTMENT . ".*," . DB_CITY . ".`main_title` AS 'city'," . DB_CITY . ".`image_name` AS 'city_image', " . DB_COUNTRY . ".`main_title` AS 'country', " . DB_COUNTRY . ".`image_name` AS 'country_image' FROM " . DB_APPARTMENT . ", " . DB_CITY . "," . DB_COUNTRY . " WHERE " . DB_APPARTMENT . ".`ap_city_id`=" . DB_CITY . ".`id` AND " . DB_CITY . ".`country_id`=" . DB_COUNTRY . ".`id` AND " . DB_APPARTMENT . ".`ap_is_featured`='yes' AND " . DB_APPARTMENT . ".`status`='A' ORDER BY " . DB_APPARTMENT . ".`id` DESC LIMIT 10";

	$qry = mysqli_query($link, $sql);
	$numOfRecords = mysqli_num_rows($qry);

	if ($numOfRecords > 0) {
		$allRecords = mysqli_fetch_all($qry, MYSQLI_ASSOC);
		$ressult["status"] = "success";
		$ressult["message"] = "Total record = " . $numOfRecords;
		$ressult["data"] = $allRecords;
	} else {
		$ressult["status"] = "warning";
		$ressult["message"] = "Date not found.";
	}
	return $ressult;
}

function get_apartment($slug)
{
	global $link;
	$ressult = [];

	$sql = "SELECT " . DB_APPARTMENT . ".*," . DB_CITY . ".`main_title` AS 'city'," . DB_CITY . ".`image_name` AS 'city_image', " . DB_COUNTRY . ".`main_title` AS 'country', " . DB_COUNTRY . ".`image_name` AS 'country_image' FROM " . DB_APPARTMENT . ", " . DB_CITY . "," . DB_COUNTRY . " WHERE " . DB_APPARTMENT . ".`ap_city_id`=" . DB_CITY . ".`id` AND " . DB_CITY . ".`country_id`=" . DB_COUNTRY . ".`id` AND " . DB_APPARTMENT . ".`slug`='" . $slug . "' AND " . DB_APPARTMENT . ".`status`='A'";

	$qry = mysqli_query($link, $sql);
	$numOfRecords = mysqli_num_rows($qry);

	if ($numOfRecords > 0) {
		$allRecords = mysqli_fetch_all($qry, MYSQLI_ASSOC);
		$ressult["status"] = "success";
		$ressult["total"] = $numOfRecords;
		$ressult["data"] = $allRecords[0];
	} else {
		$ressult["status"] = "warning";
		$ressult["message"] = "Date not found.";
	}
	return $ressult;
}

function get_apartment_structure($ap_slug = "")
{
	global $link;
	$ressult = [];
	$ap_deatils = get_apartment($ap_slug);
	if ($ap_deatils["status"] == "success") {
		$sql = "SELECT * , CONCAT(`size_bhk`,'_',`size_sqft`) AS 'size_bhk_size_sqft' FROM " . DB_AP_ROOM . " WHERE `ap_id`='" . $ap_deatils["data"]["id"] . "' AND `status`='A'";

		$qry = mysqli_query($link, $sql);

		$numOfRecords = mysqli_num_rows($qry);

		if ($numOfRecords > 0) {

			$allRecords = mysqli_fetch_all($qry, MYSQLI_ASSOC);
			$ressult["status"] = "success";
			$ressult["ap_details"]["name"] = $ap_deatils["data"]["ap_name"];
			$ressult["ap_details"]["city"] = $ap_deatils["data"]["city"];
			$ressult["ap_details"]["country"] = $ap_deatils["data"]["country"];
			$ressult["all_buildings"] = json_decode($ap_deatils["data"]["building_floors"], true);
			$ressult["all_sizes"] = array_count_values(array_column($allRecords, 'size_bhk_size_sqft'));

			$ressult["available_status"] = array_count_values(array_column($allRecords, 'booking_status'));

			if (!isset($ressult["available_status"]["booked"])) {
				$ressult["available_status"]["booked"] = 0;
			}
			if (!isset($ressult["available_status"]["available"])) {
				$ressult["available_status"]["available"] = 0;
			}
		} else {
			$ressult["status"] = "warning";
			$ressult["message"] = "Date not found.";
		}
	} else {
		$ressult["status"] = "warning";
		$ressult["message"] = "Invalid Slug.";
	}

	return $ressult;
}

function get_apartment_room_structure($ap_slug = "", $building_ids = "", $room_sizes = "")
{
	global $link;
	$ressult = [];
	$ap_deatils = get_apartment($ap_slug);
	if ($ap_deatils["status"] == "success") {

		$building_details = json_decode($ap_deatils["data"]["building_floors"], true);
		$all_buildings_ids = [];
		if ($building_ids != "") {
			$all_buildings_ids = explode(",", $building_ids);
		} else {
			$all_buildings_ids = array_keys($building_details);
		}

		$data = [];
		foreach ($all_buildings_ids as $oneBuildingId) {

			for ($i = $building_details[$oneBuildingId]["floor"]; $i >= 0; $i--) {

				$sql_where_txt = " AND `floor_number`='" . $i . "' AND `building_id`='" . $oneBuildingId . "'";
				if ($room_sizes != "") {
					$sql_where_txt .= " AND CONCAT(`size_bhk`,'_',`size_sqft`) IN ('" . str_replace(",", "','", $room_sizes) . "')";
				}

				$sql = "SELECT * , CONCAT(`size_bhk`,'_',`size_sqft`) AS 'size_bhk_size_sqft' FROM " . DB_AP_ROOM . " WHERE `ap_id`='" . $ap_deatils["data"]["id"] . "' AND `status`='A' " . $sql_where_txt;

				$qry = mysqli_query($link, $sql);

				$numOfRecords = mysqli_num_rows($qry);

				if ($numOfRecords > 0) {
					$allRecords["status"] = "success";
					$allRecords["data"] = mysqli_fetch_all($qry, MYSQLI_ASSOC);
				} else {
					$allRecords["status"] = "warning";
					$allRecords["data"] = "Not found.";
				}

				$data[$oneBuildingId][$i] = $allRecords;

				//echo "<br>".$sql;
			}
		}
		$ressult["status"] = "success";
		$ressult["data"] = $data;
	} else {
		$ressult["status"] = "warning";
		$ressult["message"] = "Invalid Slug.";
	}
	$ressult["data"] = $data;
	return $ressult;
}



function sendUserQuery($inputs)
{

	global $link;
	$sql = "INSERT INTO " . DB_USER_QUERY . "
	SET 
	`name`='" . $inputs["name"] . "',
	`email`='" . $inputs["email"] . "',
	`phone`='" . $inputs["phone"] . "',
	`remarks`='" . $inputs["remarks"] . "'";

	mysqli_query($link, $sql);
	/*
	if(mysqli_query($link, $sql)){
		$result["status"]="success";
		$result["message"]="Thanks for contacting us. We will get back you soon.";
	}else{
		$result["status"]="warning";
		$result["message"]="Something went wrong.";
	}
	*/
	$result["sql"] = $sql;
	return $result;
}



function autoUserRegistration($inputs)
{
	global $link;
	$result = [];
	$password = "Pass@0099";

	if (!empty($inputs['billing_name']) && !empty($inputs['billing_email']) && !empty($inputs['billing_tel']) && !empty($inputs['billing_zip']) && !empty($inputs['billing_pan'])) {
		$sql_chk_email = "select * from " . DB_REGISTER . " where contact_mail='" . $_REQUEST['billing_email'] . "'";
		$qry_chk_email = mysqli_query($link, $sql_chk_email) or die(mysqli_error($link));
		$num_chk_email = mysqli_num_rows($qry_chk_email);
		if ($num_chk_email <= 0) {
			$sql_inset_post = "INSERT INTO " . DB_REGISTER . " 
					SET 	
					 main_title='" . ucwords($inputs['billing_name']) . "',
					 contact_mail='" . ($inputs['billing_email']) . "',
					 mobile_no='" . ($inputs['billing_tel']) . "',
                     pan='" . strtoupper($inputs['billing_pan']) . "',
					 address='" . ucwords($inputs['billing_address']) . "',
                     pin='" . ucwords($inputs['billing_zip']) . "',
                     city='" . ucwords($inputs['billing_city']) . "',
                     state='" . ucwords($inputs['billing_state']) . "',
					 passw='" . (md5($password)) . "'";

			$qry_inset_post	= mysqli_query($link, $sql_inset_post) or die(mysqli_error($link));

			if ($qry_inset_post) {
				$user_id = mysqli_insert_id($link);
				$_SESSION['user_mail'] = $inputs['email_address'];
				$_SESSION['user_name_id'] = $user_id;
				$_SESSION['user_name'] = ucwords($inputs['full_name']);

				$result["status"] = "success";
				$result["message"] = "New user reg success.";

				$result["data"]["new_user_name"] = $inputs['full_name'].">>".$user_id;
				$result["data"]["new_user_phone"] = $inputs['phone_number'];
				$result["data"]["new_user_email"] = $inputs['email_address'];
				$result["data"]["new_user_pass"] = $password;

				/*---------- Send Email User ---------- */
				/*
				$to_name 			=	'User';
                $to_email 			=	$inputs['email_address'];
                $from_name 			= 	get_siteconfig('website_name');
                $from_email 		= 	get_siteconfig('email');
                $subject		=	"Thank You For register Yourself With Us.";		
                $message = "<html>
							<body>
								<table style='width: 70%;background-color: #f5f5f5;padding:18px' align='center'>
									<tr>
										<th style='text-align: center; padding:10px 0px'> <img src='".BASE_URL."uploads/admin/".get_siteconfig('logo')."'/></th>
									</tr>
									<tr>
										<td>
											<p>Your login credentials are<br>
												</b>User Name: </b>".$inputs['email_address']."<br>
												<b>Password: </b>".$password."
											</p>
										</td>
									</tr>
									<tr>
										<td>
											Visit at <b>".get_siteconfig('website_name').",</b> By 
										</td>
									</tr>
									<tr>
										<td style='text-align: center;'>
											<br/>
											<a href='".BASE_URL."' style='border: 0;background-color: #337ab7;border-radius: 50px;padding: 10px 20px;color:#fff;font-size: 14px;
											    outline: none;text-decoration: none;' >
											Click here 
											</a>
										</td>
									</tr>
									<tr>
										<td>
											 Thank You, <br/>
											 <b>Team ".get_siteconfig('website_name')." </b>
										</td>
									</tr>
								</table>
							</body>
						</html>";

			    //send_mail_common($to_name, $to_email, $from_name, $from_email, $subject, $message, $bcc='');		
			    $mail_status=send_mail_common($to_name,$to_email,$from_name,$from_email,$subject,$message,$useSendGrid='no',$type='');
				*/
			} else {
				$result["status"] = "error";
				$result["message"] = "New user reg failed, Try again...!!!";
			}
		} else {
			$result["status"] = "warning";
			$result["message"] = "Email already exist please try to login first.";
		}
	} else {
		$result["status"] = "warning";
		$result["message"] = "Please provide all required inputs.";
	}
	return $result;
}





function generate_new_transaction_id()
{
	global $link;
	$id = "TNX" . rand(1000000, 9999999);
	$sql = "SELECT `tnx_id` FROM " . DB_BOOKING . " WHERE `tnx_id`='" . $id . "'";
	$query_result = mysqli_query($link, $sql);
	if ($query_result) {
		if (mysqli_num_rows($query_result) > 0) {
			return generate_new_transaction_id();
		} else {
			return $id;
		}
	}
}

function generate_new_order_id()
{
	global $link;
	$id = "ORD" . rand(1000000, 9999999);
	$sql = "SELECT `order_id` FROM " . DB_BOOKING . " WHERE `order_id`='" . $id . "'";
	$query_result = mysqli_query($link, $sql);
	if ($query_result) {
		if (mysqli_num_rows($query_result) > 0) {
			return generate_new_order_id();
		} else {
			return $id;
		}
	}
}




function procceed_to_payment($inputs)
{
	global $link;

	$result = [];

	$user_id = null;
	$amount = null;
	$booking_blocking_txt = "booking";
	$tnxId = generate_new_transaction_id();
	$orderId = generate_new_order_id();

	$room_details = get_room("id='" . $_POST["room_id"] . "' AND booking_status='available'");
	if (!empty($room_details)) {
		//print_r($room_details[0]);
		$amount = $room_details[0]["booking_amount"];
		if ($_REQUEST["booking_blocking"] == "blocking") {
			$amount = $room_details[0]["blocking_amount"];
			$booking_blocking_txt = "blocking";
		}

		if (!empty($_SESSION['user_name_id'])) {
			$user_id = $_SESSION['user_name_id'];
			$result["status"] = "success";
			$result["message"] = "User already loged in.";
		} else {
			$autoUserReg = autoUserRegistration($_POST);
			if ($autoUserReg["status"] == "success") {
				$user_id = $_SESSION['user_name_id'];
				$result["status"] = "success";
				$result["message"] = "New user reg success";
			} else {
				$result = $autoUserReg;
			}
		}
	} else {
		$result["status"] = "warning";
		$result["message"] = "Unit not found.";
	}


	//print_r($result);
	//echo "<br>==============<br>";

	if ($result["status"] == "success") {
		if (!empty($orderId) && !empty($tnxId) && !empty($user_id) && !empty($amount)) {

			if (!empty($inputs["billing_name"]) && !empty($inputs["billing_email"]) && !empty($inputs["billing_tel"]) && !empty($inputs["billing_zip"]) && !empty($inputs["billing_pan"])) {

				$sql_inset_qry = "INSERT INTO " . DB_BOOKING . " 
				SET 
				room_id = '" . ConvertRealString($inputs['room_id']) . "',
				plan = '" . ConvertRealString($inputs['room_plan']) . "',
				user_id = '" . $user_id . "',
				full_name = '" . ConvertRealString($inputs['billing_name']) . "',
				phone = '" . ConvertRealString($inputs['billing_tel']) . "',
				email = '" . ConvertRealString($inputs['billing_email']) . "',
				address = '" . ConvertRealString($inputs['billing_address']) . "',
				city = '" . ConvertRealString($inputs['billing_city']) . "',
				state = '" . ConvertRealString($inputs['billing_state']) . "',
				pin = '" . ConvertRealString($inputs['billing_zip']) . "',
				pan = '" . ConvertRealString($inputs['billing_pan']) . "',
				agent_code = '" . ConvertRealString($inputs['agent_code']) . "',
				booking_blocking = '" . $booking_blocking_txt . "',
				amount = '" . $amount . "',
				order_id = '" . $orderId . "',
				tnx_id = '" . $tnxId . "'";

				$sql_inset	= mysqli_query($link, $sql_inset_qry);
				if ($sql_inset) {
					$result["status"] = "success";
					$result["message"] = "Ready to Payment";
					$result["data"]["order_id"] = $orderId;
					$result["data"]["tnx_id"] = $tnxId;
					$result["data"]["amount"] = $amount;
				} else {
					$result["status"] = "warning";
					$result["message"] = "Booking details not inserted into database.";
				}

			} else {
				$result["status"] = "warning";
				$result["message"] = "Please provide all billing details.";
			}
		} else {
			$result["status"] = "warning";
			$result["message"] = "Order id, Tnx id and User id not found.";
		}
	}

	//print_r($result);

	//echo "<br>oid>>".$orderId;
	//echo "<br>tnx>>".$tnxId;
	//echo "<br>uid>>".$user_id;
	//echo "<br>amount>>".$amount;
	return $result;
}
