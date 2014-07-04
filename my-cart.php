<?php 
require_once "config/functions.inc.php";
$sql = "SELECT * FROM temp_order WHERE Sess_Id ='".$sess_id."'";
$result = mysql_query($sql);
/*if($_SESSION['SESS_ID']=="")
{
$_SESSION['go']="cart.php";
}*/
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
<script type="text/javascript" src="fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript">
  $(document).ready(function(){
				
		
$("#variousRegister").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic'
			});


});
</script>
<script>

function checkall(notesFrm)

{

len = notesFrm.elements.length;

var i=0;

for( i=0 ; i<len ; i++)

{

if (notesFrm.elements[i].type=='checkbox') notesFrm.elements[i].checked=notesFrm.check_all.checked;

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
              <div class="blue-btn-1"> <span><span>
                <?=($_GET['cat_id']!='')?Get_Single_Field("category_master","Category_Name","Category_Id","$_REQUEST[cat_id]"):MyCart;?>
                </span></span> </div>
            </div>
          </div>
        </div>
        <div class="pro-content">
          <div class="notes">
                         
           <table cellspacing="1" cellpadding="1" border="0" width="100%" style="border: 1px solid #BDBCB8;">
                
                <tr height="26" bgcolor="#DDE5E7">
                <th width="100" align="center"><b>Remove</b></th>
                <th width="150" align="center"><b>Image</b></th>
                <th width="400" align="center"><b>Name</b></th>
                <th width="100" align="center"><b>Credits/Quantity </b></th>
                <th width="100" align="center"><b>Amount</b></th>
               
                </tr>
                <?php
                $k=0;
				$Total =0;
				$totalBuy=0;
				$buy_heading=0;
				$note_heading=0;
                if(mysql_num_rows($result)>0)
                {
                while($line=mysql_fetch_array($result))
                {
				$imageName = Get_Single_Field("product_master","Image_Name","Product_Id","$line[Id]");
                
                    if($line['Mode']==0)
                    {
                    $NAME = stripslashes(Get_Single_Field("package_master","Package_Name","Package_Id","$line[Id]"));
                    $NOTES = Get_Single_Field("package_master","No_Of_Package","Package_Id","$line[Id]");
                    $PRICE = Get_Single_Field("package_master","Package_Amount","Package_Id","$line[Id]");
                    }
                    elseif($line['Mode']==1)
                    {
                    $NAME =  stripslashes(Get_Single_Field("product_master","Title","Product_Id","$line[Id]"));
                    $NOTES = 1;
                    $PRICE = Get_Single_Field("product_master","Price","Product_Id","$line[Id]");
                    }
                    elseif($line['Mode']==2)
                    {
                    $NAME =  stripslashes(Get_Single_Field("membership_upgrade_master","Membership_Package_Name","Membership_Upgrade_Id","$line[Id]"));
                    $NOTES = 1;
                    $PRICE = Get_Single_Field("membership_upgrade_master","Membership_Package_Amount","Membership_Upgrade_Id","$line[Id]");
                    }
                    elseif($line['Mode']==3)
                    {
                    $NAME =  stripslashes(Get_Single_Field("membership_artist_upgrade_master","Membership_Package_Name","Membership_Upgrade_Id","$line[Id]"));
                    $NOTES = 1;
                    $PRICE = Get_Single_Field("membership_artist_upgrade_master","Membership_Package_Amount","Membership_Upgrade_Id","$line[Id]");
                    }
                    elseif($line['Mode']==4)
                    {
                    $NAME =  stripslashes(Get_Single_Field("product_master","Title","Product_Id","$line[Id]"));
                    $NOTES = 1;
                    $PRICE = Get_Single_Field("product_master","Price","Product_Id","$line[Id]");
                    }
					elseif($line['Mode']==5)
                    {
                    $lp_id =  Get_Single_Field("sell_session","Lyrics_Post_Id","S_S_Id","$line[Id]");
					$NAME =  stripslashes(substr(Get_Single_Field("lyrics_post_master","Lyrics","Lyrics_Post_Id","$lp_id"),0,50));
                    $NOTES = 1;
                    $PRICE = Get_Single_Field("sell_session","Price","S_S_Id","$line[Id]");
                    }
                    ?>
                <tr height="30" bgcolor="#F3F3F3">
                <td width="100" align="center" class="linksmall-txt-line"><a href="add-to-cart.php?id=<?=$line['T_Id']?>&Action=modify-cart" onclick="return window.confirm('Are you sure to delete the record');"><img src="images/trash.png"  align="absmiddle"/></a></td>
                <td width="150" align="center" class="linksmall-txt-line"><?php if(file_exists("products/product_image/$imageName") && $imageName!='') { ?>
                        <img src="products/product_image/<?php echo $imageName; ?>" border="0" width="100px;" align="absmiddle" />
                       <?php } else { ?>
                       <img src="images/post-img.png" border="0" width="100px;" align="absmiddle"/>
                       <?php } ?> </td>
                <td width="400" align="center" class="linksmall-txt-line"><?=$NAME?></td>
                <td width="100" align="center" class="linksmall-txt-line"><?=$NOTES?></td>
                <td width="100" align="center" class="linksmall-txt-line">$<?=$PRICE?></td>
                </tr>
                <?php
                $Total += $PRICE;
                $k++;
                }
                }
                else
                { 
                echo "<td colspan='5' height='150' class='linksmall-txt-line' align='center'>Cart is empty</td>";
                }
                ?>
                <tr height="30" bgcolor="#DDE5E7"><td colspan="5"></td></tr>
                <?php if(mysql_num_rows($result)>0) { ?>
                
                <?php $_SESSION['Grand_Full_Amount'] = $Total; ?>
                
               
                <?php } ?>
                </table>
                       
          </div>
          <?php if(mysql_num_rows($result)>0) {?>
          <div style="padding-top:30px;">
          <div class="g-total fr">
           <div class="value-total"><strong>Grand Total : </strong> <span>$<? printf('%1.2f',$Total);?> </span></div>
           <div class="orange-btn2">
             <a href="http://mussino.com/checkout.php"><span>Proceed to Checkout</span></a>
           </div>
          </div>
          </div>
          <?php } ?>
          <div class="cl"></div>
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
<!-- FOOTER -->
<?php include "footer.inc.php"; ?>
<!-- //FOOTER -->
</body>
</html>
