<?php
require_once "config/functions.inc.php";
	
	
  	if($_REQUEST['dd']!='')
	{
		
		
	$sql_bank ="INSERT INTO review_master SET
				Product_Id ='".trim($_REQUEST['pid'])."',
				Review_Desc  ='".trim(addslashes($_REQUEST['dd']))."'";
	mysql_query($sql_bank);
	
	
	$sql_review = "SELECT count(*) as totalReview FROM review_master WHERE Product_Id='".$_REQUEST['pid']."' ";
	$result_review = mysql_query($sql_review);
	$colles_review = mysql_fetch_array($result_review);		
	?>
    <?=$colles_review['totalReview'];?> Review(s)
    <?php				
	
	}
	else
	{
	echo "Please Enter Review";
	}
	
?>