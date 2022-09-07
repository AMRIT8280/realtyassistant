<?php 
ob_start();
include("../../connection.php"); 

$sql_img="Delete  FROM ".DB_TOUR_IMAGE." WHERE id=".$_REQUEST['id'] ;
$qry_img=mysqli_query($link,$sql_img)  or die(mysqli_error($link));



$sql_img="Select *  FROM ".DB_TOUR_IMAGE." WHERE tour_id=".$_REQUEST['tourid'] ;
$qry_img=mysqli_query($link,$sql_img)  or die(mysqli_error($link));
$num_img=mysqli_num_rows($qry_img);
	if($num_img>0)
	{
		while($row_img=mysqli_fetch_array($qry_img))
		{
		?>
        <img src="../../uploads/tour/<?php echo $row_img['image_name']?>" alt="" width="100" />&nbsp;<a style="cursor:pointer; color:#FF0000;" onclick="delete_img(<?php echo $row_img['id']?>,<?php echo $row_img['tour_id']?>)"><i class="fa fa-remove fa-fw"></i></a>
                                            
		<?php }  
	}
	
	

?>


