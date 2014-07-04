<?php 
require_once "config/functions.inc.php";
if($_POST['Action']=='Confirm')
{
				
				$amount = Get_Single_Field("advertise_plan_master","Ad_Plan_Amount","Advertise_Plan_Id","$_POST[Ad_Plan]");
				
				 
				
				
				$sql_insert = "INSERT INTO temp_ad_order SET
							   Ad_Name = '".addslashes(trim($_POST['Ad_Name']))."',
							   Ad_Image_Alt_Text = '".addslashes(trim($_POST['Ad_Image_Alt_Text']))."',
							   Ad_Target_Url = '".addslashes(trim($_POST['Ad_Target_Url']))."',
							   Ad_Plan = '".trim($_POST['Ad_Plan'])."',
							   Price ='".$amount."',
							   Sess_Id= '".$sess_id."' ";
				mysql_query($sql_insert);
				
                $lastId = mysql_insert_id();
				if(!empty($_FILES['Ad_Image']['name']))
				{
					list($getname,$getext) = explode(".",$_FILES['Ad_Image']['name']);
					$create_name = "Advertise_Image_".$lastId;
					$new_filename = $create_name.".".$getext;
					$upload_path = "products/advertise_image/".$new_filename;
					move_uploaded_file($_FILES['Ad_Image']['tmp_name'],$upload_path);
					$sql_update = mysql_query("UPDATE temp_ad_order SET Ad_Image='".$new_filename."' WHERE Temp_Ad_Id='".$lastId."'");
	     	    }
			header("location: add-confirm.php");
			exit;

}

$sql = "SELECT * FROM temp_ad_order WHERE Sess_Id= '".$sess_id."' ";
$result = mysql_query($sql);
$colles = mysql_fetch_array($result);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Home page</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="description" content="Default Description">
<meta name="keywords" content="">
<meta name="robots" content="">
<?php include "common.inc.php"; ?>
</head>

<body>
<div id="wrapper">
<!-- HEADER -->
<?php include "header.middle.inc.php"; ?>
<div class="content-container">

<?php include "header.top.inc.php"; ?>
<!-- TOP SPOTLIGHT 1 -->
<div class="content-box-2">
      <div class="cor_1set-5"></div>
      <div class="cor_1set-6"></div>
      <div class="pro-wrapper full">
        <div class="title">
          <div class="title_wrap-1">
            <div class="title_wrap-2">
              <div class="blue-btn-1"> <span><span>Confirm Details</span></span> </div>
            </div>
          </div>
        </div>
        <div class="pro-content">
          <div class="form-container">
            <form id="frmLogin" name="frmLogin" method="post" action="">
              <ul class="list-1">
                <li>
                </li>
                <li>
                  <div class="caption-2">AD-Name</div>
                  <div class="input-2"><?=stripslashes($colles['Ad_Name']);?></div>
                  <div class="cl"></div>
                </li>
                <li>
                  <div class="caption-2">Image</div>
                  <div class="input-2">
                 <?php if(file_exists("products/advertise_image/$colles[Ad_Image]") && $colles['Ad_Image']!='') { ?>
                                    <img src="products/advertise_image/<?php echo $colles['Ad_Image']; ?>" border="0" width="400" height="100" />
									<?php } ?>
                  </div>
                  <div class="cl"></div>
                </li>
                <li>
                  <div class="caption-2">Image Alt Text</div>
                  <div class="input-2">
                 <?=stripslashes($colles['Ad_Image_Alt_Text'])?>
                  </div>
                  <div class="cl"></div>
                </li>
                <li>
                  <div class="caption-2">Target URL</div>
                  <div class="input-2">
                 <?=stripslashes($colles['Ad_Target_Url'])?>
                  </div>
                  <div class="cl"></div>
                </li>
                <li>
                  <div class="caption-2">Package</div>
                  <div class="input-2">
                 <?=Get_Single_Field("advertise_plan_master","Ad_Plan_Name","Advertise_Plan_Id","$colles[Ad_Plan]").' '.Get_Single_Field("advertise_plan_master","Ad_Plan_Duration","Advertise_Plan_Id","$colles[Ad_Plan]").' - $'.Get_Single_Field("advertise_plan_master","Ad_Plan_Amount","Advertise_Plan_Id","$colles[Ad_Plan]")?>
                  </div>
                  <div class="cl"></div>
                </li>
                <li>
                  <div class="caption-2">Cost</div>
                  <div class="input-2">
                 $<?=$colles['Price']?>
                  </div>
                  <div class="cl"></div>
                </li>
                <li>
                  
                  <div class="input-2">
                
                <div class="paypal-logo"> <a href="add-paypall-payment.php" ><img src="images/bnr_nowAccepting_150x60.gif" alt="Additional Options"></a> </div>
                  </div>
                  <div class="cl"></div>
                </li>
              </ul>
            </form>
          </div>
        </div>
      </div>
      <div class="cor_1set-3"></div>
      <div class="cor_1set-4"></div>
    </div>


<!-- BOTTOM SPOTLIGHT 2 -->
<?php //include "bottom.footer.inc.php"; ?>
<!-- //BOTTOM SPOTLIGHT 2--> 
</div>
</div>
<!-- FOOTER -->
<?php include "footer.inc.php"; ?>
<!-- //FOOTER -->

</body>
</html>