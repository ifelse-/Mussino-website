<?php 
include("../config/functions.inc.php");
include("session.inc.php");
$list_page ='notebook-msg.php';

if(isset($_REQUEST['submit']))
{ 

    @extract($_POST);
    $Notebook_Msg_Details = addslashes($Notebook_Msg_Details);
    
 	$sql = "UPDATE notebook_msg_master SET Notebook_Msg_Details  = '$Notebook_Msg_Details' 	WHERE Notebook_Msg_Id  = '1'";
	$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
	$_SESSION['sess_mess'] = "Notebook msg updated successfully.";
	header("location: ". $list_page);
	exit;
	
}



$sql = "SELECT * FROM notebook_msg_master WHERE Notebook_Msg_Id   ='1'";
$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
$dataColles = mysql_fetch_array($result);

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
       <form name="placeadd" id="placeadd" action="<?=$PHP_SELF?>" method="POST" >
       <div class="box-1">
       <h2> Notebook MSG Edit </h2>
       <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-1">
          <?
          if($_SESSION['sess_mess']!='') {
          ?>
          <tr>
            <td align="left" valign="middle" colspan="2" style="padding: 5px 0 5px 210px; font-weight:bolder; color:#666666; font-size:14px;">
             <?=$_SESSION['sess_mess']?><? $_SESSION['sess_mess']="";?>         
            </td>
            </tr>
        <? } ?>
                    
          
           <tr>
            <td width="200" align="left" valign="middle">Description</td>
            <td align="left" valign="top" class="input-1">
			<?php
            include("../FCKeditor/fckeditor.php") ;
            $sBasePath = $_SERVER['PHP_SELF'] ;
            $sBasePath="../FCKeditor/";
            $oFCKeditor = new FCKeditor('Notebook_Msg_Details') ;
            $oFCKeditor->BasePath	= $sBasePath ;
            $oFCKeditor->Height	= 250 ;
            $oFCKeditor->Value		= $dataColles['Notebook_Msg_Details'];
            $oFCKeditor->Create() ;
            ?>     
            
            </td>
          </tr>
          
          
          <tr>
            <td align="left" valign="middle">&nbsp;</td>
            <td align="left" valign="top" class="input-2"><input type="submit" name="submit" value="Update"  class="buttons" /></td>
          </tr>
        </table>
       </div>
       
        </form>
      </div>
    </div>
    <div class="cl"></div>
  </div>
  <? include"footer.inc.php"?>
</div>

</body>
</html>