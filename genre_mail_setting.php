<?php 
require_once "config/functions.inc.php"; 
require_once "session.inc.php"; 
if($email_notification_settings != "yes")
	require_once "action.php"; 
	
$pageName = basename($_SERVER['PHP_SELF']);

if(isset($_POST['save_gen_set']) && $_POST['save_gen_set'] == 'yes')
{
	mysql_query("delete from email_genre_settings WHERE user_id='".$_SESSION['SESS_ID']."'");
	if($_POST['genre'] != array())
	{
		foreach($_POST['genre'] as $key=>$val)
		{
			mysql_query("insert into email_genre_settings set user_id='".$_SESSION['SESS_ID']."', cat_id='$key'");
		}
	}
	echo '<script language="javascript">window.location="genre_mail_setting.php?saved=yes";</script>';
	die;
}

$sql = "SELECT * FROM email_genre_settings WHERE user_id='".$_SESSION['SESS_ID']."'";
$result = mysql_query($sql);
$selected_gen = array();
while($colles = mysql_fetch_array($result))
{
	$selected_gen[] = $colles['cat_id'];
}

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
<?php include "header.middle.inc.php"; ?>
<div id="wrapper">
    <!-- HEADER -->
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
                            <div class="blue-btn-1"> <span><span><a href="<?=SITE_WS_PATH?>/<?=trim($_SESSION['SESS_ID'])?>/<?=$_SESSION['SESS_FIRST_NAME']?>" >My Profile</a></span></span> </div>
                            &raquo; Genre email notification settings </div>
                    </div>
                </div>
                <div class="pro-content">
                    <form id="frmEmailSettings_id" name="frmEmailSettings"  method="post" action="">
                        <div class="pro-left fl">
                            <div class="user-img"> <a href="<?=SITE_WS_PATH?>/<?=trim($_SESSION['SESS_ID'])?>/<?=$_SESSION['SESS_FIRST_NAME']?>" >
                                <?php if(file_exists("products/user_image/$colles[Photo]") && $colles['Photo']!='') { ?>
                                <img src="products/user_image/<?php echo $colles['Photo']; ?>" border="0" width="100" height="150" />
                                <?php } else { ?>
                                <img src="images/user_big.png" border="0" width="100" height="150" />
                                <?php } ?>
                                </a>
                                <p>
                                    <?=$colles['Account_Type']?>
                                </p>
                            </div>
                            <div class="pro-btn_row">
                                <?php include "left-profile.inc.php"; ?>
                            </div>
                        </div>
                        <div class="pro-right">
                            <div class="form-container">
                                
                                <div class="succes" style="color:#000000;padding-left:0px;">
                                    Sellect one or more genre to receive email notification when new session is created inside your selected genre.
                                </div>
                                
                                <ul>
                                    <li></li>
                                    <li>
                                        <div class="caption-2">Select genre</div>
                                        <div class="input-2" style="width:100%;">                                            
											<ul>
											<li></li>
											<?php
											$sql_cat = "SELECT Category_Id, Category_Name FROM category_master WHERE Status=1 ORDER BY Category_Name";
											$result_cat = mysql_query($sql_cat) or die('<br>'.$sql_cat.'<br>'.mysql_error());
						
											while($colles_cat = mysql_fetch_array($result_cat))
											{											
												?>
												<li>
												<input <?php echo (in_array($colles_cat['Category_Id'],$selected_gen))? ' checked="checked" ' : ""; ?> type="checkbox" id="genre_id_<?php echo $colles_cat['Category_Id']; ?>" name="genre[<?php echo $colles_cat['Category_Id']; ?>]" value="1" style="width:15px;" /><label for="genre_id_<?php echo $colles_cat['Category_Id']; ?>">&nbsp;<?php echo stripslashes($colles_cat['Category_Name']);?></label>
												</li>
												<?php
											}
											?>
											</ul>
                                        </div>
                                        <div class="cl"></div>
                                    </li>
                                    
                                    <li>
                                        <div class="input-2">
                                            <input name="buttonSubmit" type="submit" value="Save settings" class="button" >
                                        </div>
                                        <div class="cl"></div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="cl"></div>
						<input type="hidden" name="save_gen_set" value="yes" />
                    </form>
                </div>
            </div>
            <div class="cor_1set-3"></div>
            <div class="cor_1set-4"></div>
        </div>
        <?php if($_SESSION['SESS_ID']!='') { ?>
        <?php include"footer-div.inc.php"; ?>
        <?php } ?>
    </div>
</div>
</div>
<!-- FOOTER -->
<?php include "footer.inc.php"; ?>
<!-- //FOOTER -->
</body>
</html>
