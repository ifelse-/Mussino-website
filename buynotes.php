<?php 
require_once "config/functions.inc.php";
$start=0;
if(isset($_GET['start'])) $start=$_GET['start'];
if($_SESSION['PAGESIZE']!='')
{
$pagesize=$_SESSION['PAGESIZE'];
}
else
{
$pagesize=20;
}

if($_GET['order_by']=='') { $order_by="Package_Id"; } else { $order_by=$_REQUEST['order_by'];}

if($_GET['order_by2']=='') { $order_by2="DESC"; } else { $order_by2=$_REQUEST['order_by2'];}

$column="select * ";

$sql=" FROM package_master where  Status=1  ";



$sql1="select count(*) as total ".$sql;

$sql=$column.$sql;

$sql.=" order by $order_by $order_by2 ";

$sql.=" limit $start, $pagesize";

$result=executequery($sql);

$reccnt=getSingleResult($sql1);
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
<script language="javascript">
function checkall(objForm)
{
	len = objForm.elements.length;
	var i=0;
	for( i=0 ; i<len ; i++) 
	{
		if (objForm.elements[i].type=='checkbox') 
		{
			objForm.elements[i].checked=objForm.check_all.checked;
		}
	}
}

function buy_prompt(id)
{

    window.location.href = "buy-notes-to-cart.php?id="+id;
}

</script>
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
              <div class="blue-btn-1"> <span><span>BuyNotes</span></span> </div>
            </div>
          </div>
        </div>
        <div class="pro-content notes-nw">
          <h2>Stack up your notes <span>Notes are use as cash value on Mussino.com</span></h2>
          <p class="small-txt">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
          <div class="notes-wrapper fl">
          
          	<?php
			$ct=0;
			while($line=mysql_fetch_array($result))
			{
			$bgcolor = ($ct%2==0? '#E8F3FE': '#eeeeee');
			?>
            <div class="notes-info">
              <h3><?=stripslashes($line['Package_Name']);?> <?=$line['No_Of_Package'];?> note <span class="add-btn">$<?=$line['Package_Amount'];?> <span><a href="javascript:void(0);" onclick="buy_prompt('<?=$line['Package_Id']?>');">Add</a></span></span></h3>
              <p><?=stripslashes($line['Package_Desc']);?></p>
            </div>
           <?php
			$ct++;
			}
			?>
          </div>
          <div class="blue-block fr">
            <div class="cor_4set-1"></div>
            <h4>Welcome to stack up, Marvin.</h4>
            <div class="blue-block-wrap-1">
              <div class="user-img fl"><img src="images/user.jpg" alt="" /></div>
              <div class="user-info">
                <ul>
                  <li>
                    <span class="head">Current note: </span>
                    <span class="head-info">0</span>
                  </li>
                  <li>
                    <span class="head">Current bank: </span>
                    <span class="head-info">$25.00</span>
                  </li>
                  <li>
                    <div class="blue-btn-3"><a href="#">Invite Friends</a></div>
                  </li>
                </ul>
              </div>
              <div class="cl"></div>
            </div>
            <div class="blue-block-wrap-2">
              <h5><span>Low on notes?</span> Search collabration to request notes.</h5>
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen </p>
            </div>
            <div class="blue-block-wrap-3">
              <div class="top">
                <div class="bottom">
                  <div class="search-box">
                    <div class="search-box_wrap1">
                      <div class="fl"><input name="search-cap" type="text" /></div>
                      <div class="search-btn2 fr"><input name="search" type="submit" value="Search" /></div>
                      <div class="cl"></div>
                    </div>
                  </div>
                  <ul class="frnd-list">
                    <li>
                      <div class="frnd-img fl"><img src="images/user5.jpg" alt="" /></div>
                      <div class="frnd-row fl">
                        <h3>Jazz1 kumar1</h3>
                        <div class="info-1 fl"> Ask for <input name="" type="text" /></div>
                        <div class="info-2 fl"> Give back <input name="" type="text" /><select name=""><option>Reason</option></select></div>
                        <div class="info-3 fl"><a href="#">Request</a></div>
                        <div class="cl"></div>
                      </div>
                      <div class="cl"></div>
                    </li>
                    <li>
                      <div class="frnd-img fl"><img src="images/user5.jpg" alt="" /></div>
                      <div class="frnd-row fl">
                        <h3>Jazz1 kumar1</h3>
                        <div class="info-1 fl"> Ask for <input name="" type="text" /></div>
                        <div class="info-2 fl"> Give back <input name="" type="text" /><select name=""><option>Reason</option></select></div>
                        <div class="info-3 fl"><a href="#">Request</a></div>
                        <div class="cl"></div>
                      </div>
                      <div class="cl"></div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="cor_4set-2"></div>
          </div>
          <div class="cl"></div>
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
