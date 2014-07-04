<?php 
include("../config/functions.inc.php");
include("session.inc.php");


$sql="SELECT * FROM addagent  WHERE  Id='".$_REQUEST['id']."' ";
$result=mysql_query($sql);
$colles = mysql_fetch_array($result);
$sqlAnother = "SELECT * FROM useragents WHERE AgentId='".$_REQUEST['id']."' ORDER BY Id DESC";
$resultAnother = mysql_query($sqlAnother);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Administrator</title>
<link href="css/layout-admin.css" rel="stylesheet" type="text/css" />
<link href="css/css.css" rel="stylesheet" type="text/css">

</head>

<body>
<div id="wrapper">
  <div class="header-container">
   <? include"header.inc.php"?> 
  </div>
  <div class="content-container">
    <div class="left-navigation fl">
      <div class="left-navigation_inner">
        <? require_once "left.inc.php"; ?>
      </div>
    </div>
    <div class="detail-col fr">
      <div class="detail-col_inner">
        <div class="box-1">
          <h2>Commision Report of <?=$colles['Agentname']?></h2>
          
          <form  name="form1" id="form1" method="post" action="">
          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-1">
            
            
         <tr align="right">
          <?
			  if($_SESSION['sess_mess'])
			  {
			  ?>
                      <td height="29" colspan="5" align="center" class="h12" ><?=$_SESSION['sess_mess'];?>
                          <? session_unregister(sess_mess);	?></td>
                      <?
				}
				?>
				</tr>
        
            
            
           
          </table>
          
          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-1">
            <tr>
              <th width="100" align="center" valign="top">Date</th>
              <th width="250" align="center" valign="top">OrderID</th>
               <th width="200" align="center" valign="top">Order Amount($)</th>
              <th width="100" align="center" valign="top">Commision($)</th>
              
            </tr>
            <?
			if(mysql_num_rows($resultAnother)>0)
			{
			while($row=mysql_fetch_array($resultAnother))
			{
		
			?>
            <tr>
              <td width="100" align="center" valign="top"><?=get_date_format($row['Date']);?></td>
              <td width="250" align="center" valign="top"><?=trim($row['OrderId']);?></td>
              <td width="200" align="center" valign="top"><?=number_format($row['OrderAmount'],2)?></td>
              <td width="100" align="center" valign="top" ><?=number_format($row['Commision'],2)?></td>
             
            </tr>
			<?
            $totOAmt+=$row['OrderAmount'];
            $totCommission+=$row['Commision'];
            }
            }
            else
            {
            echo "<tr><td align='center' colspan='4'>sorry no record(s)</td></tr>";
            }
            ?>
            <?php
			if(mysql_num_rows($resultAnother)>0)
			{
			?>
             <tr>
              <td align="right" valign="top" colspan="2"><strong>Total</strong></td>
              <td width="200" align="center" valign="top"><?=number_format($totOAmt,2)?></td>
              <td width="100" align="center" valign="top" ><?=number_format($totCommission,2)?></td>
              </tr>
              <?php
			  }
			  ?>
          </table>
          
          </form>
          
      </div>
        
              </form></td>
          </tr>
        </table></td>
      </tr>
      </table>
      </div>
    </div>
    <div class="cl"></div>
  </div>
  <? include"footer.inc.php"?>
</div>

</body>
</html>
