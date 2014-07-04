<?php 
include("../config/functions.inc.php");
include("session.inc.php");
$list_page ='question-list.php';
$head_page ='question.php';
if(isset($_POST['submit']))
{ 

  @extract($_POST);
  
  $ques = addslashes($ques);
    
  if(empty($_POST['id']))
	 {
    /****************************Quesry to insert into  Question to a set Set Table*************************************/
	$Sql_Insert_Question = "INSERT INTO questions SET
   						    ques = '$ques',
						    created_on = now(),
						    Status = '$Status'";
	mysql_query($Sql_Insert_Question);
	
	$qid=mysql_insert_id();
	
	if($Status==1)
	{
	$sql = "UPDATE questions  SET Status='1' WHERE id = '".$qid."'";
	executeQuery($sql);
	$sql2 = "UPDATE questions  SET Status='0' WHERE id != '".$qid."'";
	executeQuery($sql2);
	}
	if($Status==0)
	{
	$sql = "UPDATE questions  SET Status='0' WHERE id = '".$qid."'";
	executeQuery($sql);
	$sql2 = "UPDATE questions  SET Status='0' WHERE id != '".$qid."'";
	executeQuery($sql2);
	}
	
	if(count($QOPTION)>0)
	{
	$array1 = $qopt;
	$array2 = $QOPTION;
	$array3 = array_merge($array1,$array2);
	}
	else
	{
	$array3 = $qopt;
	}
	
	
	foreach($array3 as $key=>$Optionvalue)
		{
			$Sql_Question_Options="INSERT INTO options SET 
								   ques_id = '".$qid."',
								   `value` = '".$Optionvalue."'";
		    mysql_query($Sql_Question_Options);
		}
	/**********************End****************************************/
	 }else{
	 //////////////**************Update Start****************************/
	 $sqlinsertQuestion="UPDATE questions SET
   						 ques = '$ques',
						 created_on = now(),
						 Status = '$Status'
						 WHERE id='".$id."'";
	mysql_query($sqlinsertQuestion);
	
	if($Status==1)
	{
	$sql = "UPDATE questions  SET Status='1' WHERE id = '".$id."'";
	executeQuery($sql);
	$sql2 = "UPDATE questions  SET Status='0' WHERE id != '".$id."'";
	executeQuery($sql2);
	}
	if($Status==0)
	{
	$sql = "UPDATE questions  SET Status='0' WHERE id = '".$id."'";
	executeQuery($sql);
	$sql2 = "UPDATE questions  SET Status='0' WHERE id != '".$id."'";
	executeQuery($sql2);
	}
	
	//echo'<pre>'; print_r($_POST);
	//die(A);
	if(count($QOPTION)>0)
	{
	$arr1 = $qopt;
	$arr2 = $QOPTION;
	$arr3 = array_merge($arr1,$arr2);
	}
	else
	{
	$arr3 = $qopt;
	}
	
	$sql ="DELETE FROM options WHERE ques_id='".$id."'";
	$result = mysql_query($sql);
	
	
	foreach($arr3 as $key=>$Optionvalue)
		{
		
		$sqlQuestionsetOption = "INSERT INTO options SET  
									 ques_id = '".$id."',
									`value`='".$Optionvalue."'";
        mysql_query($sqlQuestionsetOption);
		  
		}
		
		
	 //////////////////////////* Update End******************************/
	 }
	$_SESSION['sess_mess'] = "Question updated successfully.";
	header("location: ". $list_page);
	exit;
	
}


if($_GET['id']!='')
{
$sql = "SELECT * FROM questions WHERE id ='".$_GET['id']."'";
$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
$dataColles = mysql_fetch_array($result);
     $sqlOption="select * from options where ques_id='".$dataColles['id']."'";
	 $resQuestionOption=mysql_query($sqlOption);
	 while($Qoption=mysql_fetch_array($resQuestionOption))
	 	{
		 $qopt[$Qoption[id]]=$Qoption[value];
		 //$qoptmarks[$Qoption->qoptid]=$Qoption->qoptmarks;
		}
		$OptionArray=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Administrator</title>
<link href="css/layout-admin.css" rel="stylesheet" type="text/css" />
<link href="css/css.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="javascript/jscript/jquery-1.2.6.min.js"></script>
<script type="text/javascript" src="javascript/jscript/ajax.js"></script>
<script>
function validate_submitsite_form(placeadd) 
{
	if (placeadd.ques.value == "") 
	{
		alert("\nPlease enter question.")
		placeadd.ques.focus();
		return false;
	}
	else if(document.getElementById("qopt").value=="")
	{
	alert("\nPlease enter option.")
	placeadd.qopt.focus();
	return false;
	}
	
	
} 
</script>
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
       <form name="placeadd" id="placeadd" action="<?=$PHP_SELF?>" method="POST"  onSubmit="return validate_submitsite_form(placeadd)">
       <div class="box-1">
       <h2> Poll Question <?=$_GET['id']!='' ? 'Edit' : 'Add';?></h2>
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
            <td width="200" align="left" valign="middle">Question </td>
            <td align="left" valign="top" class="input-1"><input type="text" name="ques" value="<?=stripslashes(trim($dataColles['ques']));?>"  size="50" class="textbox"></td>
          </tr>
          </table>
          
          
          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-1">
          
           <tr>
            <td width="200" align="left" valign="middle"><div onclick="createOption('addOption',OptionCounter)" style="cursor:pointer; padding-right:40px; width:102px;"><strong>Add New Option</strong></div></td>
            <td align="left" valign="top" class="input-1"> <div onclick="removeOption('addOption',OptionCounter)" style="cursor:pointer; padding-left:40px; width:130px;"><strong>Remove Last Option</strong></div></td>
           </tr>
           
           </table>
           
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-1" id="addOption">
                <tr>
                <td width="200" align="left" valign="middle">Option Label</td>
                <td align="left" valign="top" class="input-1">Option Value</td>
                </tr>
                <? 
                if(empty($_GET['id']))
                { ?>
                <tr>
                <td width="200" align="left" valign="middle">Option A</td>
                <td align="left" valign="top" class="input-1"><input type="text" name="qopt[]" id="qopt" value=""/></td>
                </tr>
                <?  } 
                else{ 
                $i=0;
				foreach($qopt as $key=>$option)
                {
                ?>
                <tr>
                <td width="200" align="left" valign="middle">Option <?=$OptionArray[$i] ?></td>
                <td align="left" valign="top" class="input-1"><input type="text" name="qopt[<?=$key?>]" value="<?=$qopt[$key] ?>"/></td>
                </tr>
                <? $i++;}
                $i--;
                echo "<script>OptionCounter=$i</script>" ;
                } ?>
                </table>
 
 			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-1">
          
          <tr>
            <td width="200" align="left" valign="middle">Status</td>
            <td align="left" valign="top" class="input-1">
              <select name="Status" size="1" class="textbox">
                  <option value="1" <? if($dataColles['Status']=='1') { echo "SELECTED";}?>>Active</option>
                  <option value="0" <? if($dataColles['Status']=='0') { echo "SELECTED";}?>>Inactive</option>
                </select>
            </td>
          </tr>
          <tr>
            <td align="left" valign="middle"><input type="hidden" name="id" value="<?=$dataColles['id'];?>" /></td>
            <td align="left" valign="top" class="input-2"><input type="submit" name="submit" value="<?php if($_REQUEST['id']!='') { echo 'Update'; } else { echo'Insert Record'; }?>"  class="buttons" /></td>
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
