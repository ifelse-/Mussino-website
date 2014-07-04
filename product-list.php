<?php 
require_once "config/functions.inc.php";
require_once "session.inc.php"; 
$pageName = basename($_SERVER['PHP_SELF']); 
$sql = "SELECT * FROM member_account_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."'";
$result = mysql_query($sql);
$colles = mysql_fetch_array($result);

$start=0;
if(isset($_GET['start'])) $start=$_GET['start'];
if($_SESSION['PAGESIZE']!='')
{
$pagesize=$_SESSION['PAGESIZE'];
}
else
{
$pagesize=5;
}
if($_GET['order_by']=='') { $order_by="Product_Id"; } else { $order_by=$_REQUEST['order_by'];}
if($_GET['order_by2']=='') { $order_by2="DESC"; } else { $order_by2=$_REQUEST['order_by2'];}
# DATE_FORMAT(Session_Start_Date,'%h:%i %p') as start_time, DATE_FORMAT(Session_End_Date,'%h:%i %p') as end_time,
$column="select *,  DATE_FORMAT(Session_Start_Date,'%a, %b %e, %Y at %l:%i %p') as start_data, DATE_FORMAT(Session_End_Date,'%a, %b %e, %Y at %l:%i %p') as end_data";
$sql=" FROM product_master where  Status=1 AND Member_Account_Id ='".$_SESSION['SESS_ID']."' AND Type!=3 ";

$sql1="select count(*) as total ".$sql;
$sql=$column.$sql;

$sql.=" order by $order_by $order_by2 ";
$sql.=" limit $start, $pagesize";

//echo $sql;

$result=executequery($sql);

$reccnt=getSingleResult($sql1);
function get_time_difference( $start, $end )
{
    $uts['start']      =    strtotime( $start );
    $uts['end']        =    strtotime( $end );
    if( $uts['start']!==-1 && $uts['end']!==-1 )
    {
        if( $uts['end'] >= $uts['start'] )
        {
            $diff    =    $uts['end'] - $uts['start'];
            if( $days=intval((floor($diff/86400))) )
                $diff = $diff % 86400;
            if( $hours=intval((floor($diff/3600))) )
                $diff = $diff % 3600;
            if( $minutes=intval((floor($diff/60))) )
                $diff = $diff % 60;
            $diff    =    intval( $diff );            
            return( array('days'=>$days, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$diff) );
        }
        else
        {
            @trigger_error( "Ending date/time is earlier than the start date/time", E_USER_WARNING );
        }
    }
    else
    {
        @trigger_error( "Invalid date/time data detected", E_USER_WARNING );
    }
    return( false );
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>My Session History</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="description" content="Default Description">
<meta name="keywords" content="">
<meta name="robots" content="">
<?php include "common.inc.php"; ?>
<script>
function checkall(form1)
{
len = form1.elements.length;
var i=0;
for( i=0 ; i<len ; i++)
{
if (form1.elements[i].type=='checkbox') form1.elements[i].checked=form1.check_all.checked;
}
}
</script>
</head>

<body>

<!-- HEADER -->
<?php include "header.middle.inc.php"; ?>
<div id="wrapper">
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
              &raquo; My Session History
            </div>
          </div>
        </div>
        <div class="pro-content">
        <form name="wish_form" method="post" action="wish-list-del.php">
          <div class="pro-left fl">
            <div class="user-img">
            <a href="<?=SITE_WS_PATH?>/<?=trim($_SESSION['SESS_ID'])?>/<?=$_SESSION['SESS_FIRST_NAME']?>" >
			<?php if(file_exists("products/user_image/$colles[Photo]") && $colles['Photo']!='') { ?>
              <img src="products/user_image/<?php echo $colles['Photo']; ?>" border="0" width="100" height="150" />
               <?php } else { ?>
              <img src="images/user_big.png" border="0" width="100" height="150" />
            <?php } ?>
            </a>
            <p><?=$colles['Account_Type']?></p>
            </div>
            <div class="pro-btn_row">
               <?php include "left-profile.inc.php"; ?>  
            </div>
          </div>
          <div class="pro-right">
            <table width="100%" border="0" cellpadding="1" cellspacing="1">
		<?php if($reccnt==0) { ?>
        <tr>
            <td class="add_heading">
            <?php echo "Sorry: no result found."; ?>						
            </td>
        </tr>
        <?php } else { ?>
          <tr>
            <td>
            <form name="wish_form" method="post" >
            <table width="100%" border="0" cellpadding="1" cellspacing="1">
            <?php if($_SESSION['sess_messs']!='') { ?>
            <tr height="32">
            	<td colspan="3" align="center" style="color:#000000;"><?=$_SESSION['sess_messs'];?> <?php $_SESSION['sess_messs']=''; ?></td>            
            </tr>
            <?php } ?>
            <tr bgcolor="#CCCCCC" height="30">
            <td align="center" width="25%"><strong>Product</strong></td>
            <td align="center" width="25%"><strong>Type</strong></td>
            <td align="center" width="40%"><strong>Session Start/End Date Time</strong></td>
            <td align="center" width="10%"><strong>Status</strong></td>
            </tr>
            <?php
			$ct=0;
            while($line=mysql_fetch_array($result))
            {
			$bgcolor = ($ct%2==0? '#E8F3FE': '#eeeeee');
			$current_time = date("Y-m-d h:i:s");
			$session_end_time = $line['Session_End_Date'];
            $diff_time = get_time_difference( $current_time, $session_end_time);
            ?>
            <tr bgcolor="<?=$bgcolor?>">				
            <td align="center" width="25%" title="<?=stripslashes($line['Title']);?>">
            <?php
            if(file_exists("products/product_image/$line[Image_Name]") && $line['Image_Name'])
            {
            ?>
            <img src="products/product_image/<?=$line['Image_Name']?>" class="img_border"  width="100" height="100" border="0" alt="<?=stripslashes($line['Title']);?>">
            <?
            }
            else
            {
            ?>
            <img src="images/no-image.gif" width="100" class="img_border"  height="100" border="0" alt="<?=stripslashes($line['Title']);?>">
            <?php
            }
            ?>
           	 <br />
             <?=stripslashes($line['Title']);?>
             <br /> 
            </td>
            <td width="25%" align="center" valign="middle"><?=stripslashes(Get_Single_Field("type_master","Type_Name","Type_Id","$line[Type]"));?></td>
            <td  width="40%" align="center" valign="middle">
			<table width="100%" border="0" align="center">
              <!--<tr>
                <td width="50"><strong>Session</strong></td>
                <td width="50"><strong>Date</strong></td>
                <td width="50"><strong>Time</strong></td>
              </tr>-->
              <tr>
                <td width="5"><strong>Start</strong></td>
                <td width="130" align="left"><?=$line['start_data']?></td>
                <!--<td width="50"><?=$line['start_time']?></td>-->
              </tr>
              <tr>
                <td width="5"><strong>End</strong></td>
                <td width="130"><?=$line['end_data']?></td>
                <!--<td width="50"><?=$line['end_time']?></td>-->
              </tr>
            </table>
            </td>
           
            <td  width="10%" align="center" valign="middle"><?=($diff_time['days']>0 && $diff_time['hours']>0 && $diff_time['minutes']>0 &&$diff_time['seconds']>0)? 'Active':'Close';?></td>
            </tr> 
            
            <?php
			$ct++;
            }
            ?>
            <tr>
            
            </tr>
            </table>	 
            </form>
            </td>
              </tr>
             
               <tr>
                <td class="add_heading">
                <?php
                require_once("paging.inc.php");
                ?>						</td>
              </tr>
              <?php
              }
              ?>
            </table>
          </div>
          <div class="cl"></div>
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