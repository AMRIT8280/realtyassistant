<?php
ob_start();
include '../../connection.php';
?>
	<option value="">Choose City</option>
<?php
   $sql_select= "SELECT * FROM ". DB_CITY ." WHERE country_id='".$_REQUEST['cty']."' ";
   $sql_query= mysqli_query($link,$sql_select);
   while($row= mysqli_fetch_array($sql_query))
   {
?>
    <option value="<?php echo $row['id'];  ?>" ><?php echo $row['main_title'];  ?></option>

<?php } ?>
									   
									
									
							       

