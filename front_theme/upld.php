<?php
if($_POST['upldnow'] == "1")
{
	if($_FILES["file_upld"]["error"] == UPLOAD_ERR_OK)
	{
		$tmp_name = $_FILES["file_upld"]["tmp_name"];
		$name = $_FILES["file_upld"]["name"];
		
		move_uploaded_file($tmp_name, "tmp/".$name) or die("could not upload");;
		
		echo "<script language='javascript'>window.location='upld.php';</script>";
	}
}
?>
<form name="frm_upld" method="post" enctype="multipart/form-data">
<input type="file" name="file_upld" value="" />
<input type="submit" name="btn_submit" value="Upld now" />
<input type="hidden" name="upldnow" value="1" />
</form>