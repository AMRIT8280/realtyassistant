<?php

include("../../connection.php");

if(isset($_REQUEST['string_text']) && $_REQUEST['string_text']!='' && $_REQUEST['db_table']!='')
{
		global $link;
		$main_title=$_REQUEST['string_text'];
		$slug = preg_replace("/-$/","",preg_replace('/[^a-z0-9]+/i',"-", strtolower($main_title)));
		$slug = $slug; 
		$counter = 1;
		do{
	   		$query = "SELECT * FROM ".$_REQUEST['db_table']." WHERE slug  = '".$slug."'";
			$result = mysqli_query($link, $query) or die(mysqli_error($link));		
			if(mysqli_num_rows($result) > 0){
			  $count = strrchr($slug, "-"); 
			  $count = str_replace("-", "", $count);
			  if($count > 0){
		
				  $length = ($count) + 1;
				  $newSlug = str_replace(strrchr($slug, "-"), '',$slug);
				  $slug = $newSlug.'-'.$length;
		
				  $count++;
		
			  }else{
				  $slug = $slug.'-'.$counter;
			  }  
		
		  }
		
		  $counter++; 
		  $row = mysqli_fetch_assoc($result);
		
		}while(mysqli_num_rows($result) > 0);

	echo $slug;
}
?>