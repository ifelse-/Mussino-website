<?php
require_once("config/functions.inc.php");
$message='<style type="text/css">
<!--
  .fl{float:left;}
  .fr{float:right;}
  .cl{clear:both; margin:0; padding:0}
  .logo-img { width:250px; height:85px; background:url(images/mail-logo.jpg) left no-repeat; margin:0 0 0px 0;}
 .mailDetail {position: relative; border-color: #000000; border-style: solid; border-width: 4px 1px; padding:10px; margin:0px 0 0 0; width:918px; -moz-border-radius: 12px; -webkit-border-radius: 12px; border-radius: 12px; font-family:Tahoma, Arial, sans-serif;}
 
 .mailDetail-cor1, .mailDetail-cor2, .mailDetail-cor3, .mailDetail-cor4 { position:absolute; width:12px; height:15px;    background-image:url(images/corner_black.png); background-repeat:no-repeat}
 .mailDetail-cor1 {left:-1px; top:-4px; background-position: 0 0; }
 .mailDetail-cor2 { right:-1px; top:-4px; background-position:0 -15px;}
 .mailDetail-cor3 {left:-1px; bottom:-4px; background-position:0 -30px ;}
 .mailDetail-cor4 { right:-1px; bottom:-4px; background-position:0 -45px;}
 
 .mail-block-1 {width:432px; position:relative; background:#F1F1F1;  border: 1px solid #DEDCDC; padding:0 10px 10px 10px; height:170px; margin:0 10px 0 0; -moz-border-radius: 10px; -webkit-border-radius: 10px; border-radius: 10px;}
 .mail-block-1 h3 {background: url(images/gray_bdr.gif) repeat-x left bottom; color: #146898; font-size: 20px; font-weight: normal; margin:6px 0 6px 0;   padding: 0 0 6px; font-family:MyriadProCondensed;}
 .mail-block-1 ul.mail-list-1 { list-style:none; margin:0;}
 .mail-block-1 ul.mail-list-1 li { font-size:12px; background: url(images/arrow-3.gif) left 5px no-repeat; padding:0 0 0 10px; margin:0 0 10px 0}
 .mail-block-1 ul.mail-list-2 { list-style:none; margin:0;}
 .mail-block-1 ul.mail-list-2 li { font-size:12px; background: none; padding:0 0 0 0px; margin:0 0 10px 0}
 .mail-block-1.last { margin:0;}
 .mail-block-1.full-mail { margin:10px 0 0 0; width:auto; height:auto;}
 
 .mail-block-cor1, .mail-block-cor2, .mail-block-cor3, .mail-block-cor4 { position:absolute; width:11px; height:11px;    background-image:url(images/div_corner.png); background-repeat:no-repeat}
 .mail-block-cor1 {left:-1px; top:-1px; background-position:0 0;}
 .mail-block-cor2 {right:-1px; top:-1px; background-position:right -11px;}
 .mail-block-cor3 {left:-1px; bottom:-1px; background-position:0 -22px;  }
 .mail-block-cor4 {right:-1px; bottom:-1px; background-position:right -33px;}
 
 table.detail-table3 tr.cart-head { background:none;}
 table.detail-table3 tr.cart-head th { line-height:30px;}
 table.detail-table3 tr { background:#FFF;}
 table.detail-table3 tr td { padding:5px; border:#D8D8D8;}
-->
</style>


<div class="mailDetail">';
            if($_SESSION['SESS_ID']!='')
			{
			$sql_contact = "SELECT * FROM member_account_master WHERE Status='1' AND Member_Account_Id='".$_SESSION['SESS_ID']."' AND Account_Type!='ADMIN'";
			$result_contact = mysql_query($sql_contact);
			$colles_contact = mysql_fetch_array($result_contact);
			}  
			if($colles_contact['City_Id']=='999999') { $city = $colles_contact['Other_City']; } else { $city = Get_Single_Field("city_master","City_Name","City_Id","$colles_contact[City_Id]");}      
			$message.='
  <div class="logo-img"></div>
  <div class="mail-block-1 full-mail">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail-table2">
          <tr>
                <td class="info-2t">
				<ul class="mail-list-2"><li>'.ucfirst($colles_contact[First_Name]).'  '.ucfirst($colles_contact[Last_Name]).'</li>
                  <li>'.$colles_contact[Address].'</li>
                  <li>'.stripslashes($city).' '.stripslashes(Get_Single_Field("state_master","State_Name","State_Id","$colles_contact[State_Id]")).' '.$colles_contact['Zip'].' '.stripslashes(Get_Single_Field("country_master","Country_Name","Country_Id","$colles_contact[Country_Id]")).'</li>
				  <li>'.$colles_contact[Email].'</li>
                  </ul>
				  </td>
              </tr>
        </table>
		
  </div>
  
  <div class="mail-block-1 full-mail">
  <div class="order-wrapper">
    <div class="order-detail">';
                
			$sql5 = "SELECT * FROM temp_order WHERE Sess_Id ='".$sess_id."'";
			$result5 = mysql_query($sql5);  
			$message.='
			  <h3>Order Details </h3>
              <table width="100%" border="0" cellspacing="1" cellpadding="1" class="detail-table3">
			  <tr class="cart-head">
				<th width="200"  style="color:#8AC640;">Name</th>
                <th width="300" style="color:#8AC640;" valign="top">Notes/Quantity</th>
                <th width="200"><span style="color:#8AC640;">Amount</th>
               
            </tr>';
			
			
			$Total =0;
			while($line5=mysql_fetch_array($result5))
			{
			
			if($line5['Mode']==0)
			{
			$NAME = stripslashes(Get_Single_Field("package_master","Package_Name","Package_Id","$line5[Id]"));
			$NOTES = Get_Single_Field("package_master","No_Of_Package","Package_Id","$line5[Id]");
			$PRICE = Get_Single_Field("package_master","Package_Amount","Package_Id","$line5[Id]");
			}
			elseif($line5['Mode']==1)
			{
			$NAME =  stripslashes(Get_Single_Field("product_master","Title","Product_Id","$line5[Id]"));
			$NOTES = 1;
			$PRICE = Get_Single_Field("product_master","Price","Product_Id","$line5[Id]");
			}
			elseif($line5['Mode']==2)
			{
			$NAME =  stripslashes(Get_Single_Field("membership_upgrade_master","Membership_Package_Name","Membership_Upgrade_Id","$line5[Id]"));
			$NOTES = 1;
			$PRICE = Get_Single_Field("membership_upgrade_master","Membership_Package_Amount","Membership_Upgrade_Id","$line5[Id]");
			}
			elseif($line5['Mode']==3)
			{
			$NAME =  stripslashes(Get_Single_Field("membership_artist_upgrade_master","Membership_Package_Name","Membership_Upgrade_Id","$line5[Id]"));
			$NOTES = 1;
			$PRICE = Get_Single_Field("membership_artist_upgrade_master","Membership_Package_Amount","Membership_Upgrade_Id","$line5[Id]");
			}
			elseif($line5['Mode']==4)
			{
			$NAME =  stripslashes(Get_Single_Field("product_master","Title","Product_Id","$line5[Id]"));
			$NOTES = 1;
			$PRICE = Get_Single_Field("product_master","Price","Product_Id","$line5[Id]");
			}
			elseif($line['Mode']==5)
			{
			$lp_id =  Get_Single_Field("sell_session","Lyrics_Post_Id","S_S_Id","$line[Id]");
			$NAME =  stripslashes(substr(Get_Single_Field("lyrics_post_master","Lyrics","Lyrics_Post_Id","$lp_id"),0,50));
			$NOTES = 1;
			$PRICE = Get_Single_Field("sell_session","Price","S_S_Id","$line[Id]");
			}
			 $message.='			 
			 <tr>
            <td align="left" valign="top" align="center" class="market-value" height="100%">'.$NAME.'</td>
            <td align="center" valign="top" height="100%" class="market-value">'.$NOTES.'</td>
            <td align="center" valign="top" height="100%" class="total-value">$'.$PRICE.'</td>
          </tr>';
		  
        }
		
	   
	  
	  
	   $message.='<tr>
	   <td widht="200" align="right"><strong></strong></td>
	   <td widht="300">Total :</td>
	   <td widht="200" align="left">$'.number_format($_SESSION['Grand_Full_Amount'], 2, '.', ' ').'</td>
	   </tr>
       
	   </table></td> </tr>';
	   
     $message.='</table></div>
  </div>
 
  </div>
 <br>';  
	 $message .= '<strong>Regards</strong>, <br>';
	 $message .= '<strong>The Mussino Team</strong> <br>';
	 
?>
