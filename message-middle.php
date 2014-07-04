<?php
if($_REQUEST['id']!='')
{
$_SESSION['sess_col'] ='';
$sql_msg = "SELECT * FROM lyrics_post_master WHERE md5(Lyrics_Post_Id) LIKE '%".$_REQUEST['id']."%'";
$result_msg = mysql_query($sql_msg);
$colles_msg = mysql_fetch_array($result_msg);
$musician_email = Get_Single_Field("product_master","Member_Account_Id","Product_Id","$colles_msg[Product_Id]");
$msgEmail = Get_Single_Field("member_account_master","Email","Member_Account_Id","$musician_email");
}
elseif($_REQUEST['uid']!='')
{
$sql_user_list = "SELECT Email, First_Name, Last_Name FROM member_account_master WHERE Status=1 AND  Personal_Msg=0 AND md5(Collaborate_Id) LIKE '%".$_REQUEST['uid']."%'";
$result_user_list = mysql_query($sql_user_list);
}
elseif($_SESSION['SESS_ACCOUNT_TYPE']=='Artist' && $_REQUEST['id']=='' && $_REQUEST['uid']=='') 
{
$sql_user_list1 = "SELECT  distinct m.Email, m.First_Name, m.Last_Name FROM member_account_master m LEFT JOIN my_favorite_tab f ON(f.MY_Favorite_Id = m.Member_Account_Id) WHERE m.Status=1  AND m.Member_Account_Id!='".$_SESSION['SESS_ID']."' AND m.Personal_Msg=0 AND (m.Collaborate_Id='".$_SESSION['SESS_ID']."' || f.My_Id='".$_SESSION['SESS_ID']."') ORDER BY m.First_Name, m.Last_Name";
$result_user_list1 = mysql_query($sql_user_list1);	
} 
elseif($_SESSION['SESS_ACCOUNT_TYPE']=='Musician' && $_REQUEST['id']=='' && $_REQUEST['uid']=='') 
{
$sql_user_list2 = "SELECT  distinct m.Email, m.First_Name, m.Last_Name FROM member_account_master m LEFT JOIN my_favorite_tab f ON(f.MY_Favorite_Id = m.Member_Account_Id) WHERE m.Status=1  AND m.Member_Account_Id!='".$_SESSION['SESS_ID']."' AND m.Personal_Msg=0 AND (m.Collaborate_Id='".$_SESSION['SESS_ID']."' || f.My_Id='".$_SESSION['SESS_ID']."') ORDER BY m.First_Name, m.Last_Name";
$result_user_list2 = mysql_query($sql_user_list2);	 
}
if($_POST['buttonSubmit']!='')
{
	if($_REQUEST['To']=='')
	{
	$_SESSION['sess_msg'] = "<span style='color:#ff0000'>Empty To Email Address</span>";
	}
	elseif(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$",$_REQUEST['To']))
	{
	$_SESSION['sess_msg'] = "<span style='color:#ff0000'>Invalid Email ID</span>";
	}
	elseif($_REQUEST['Subject']=='')
	{
	$_SESSION['sess_msg'] = "<span style='color:#ff0000'>Please Enter Subject</span>";	
	}
	elseif($_REQUEST['Message']=='')
	{
	$_SESSION['sess_msg'] = "<span style='color:#ff0000'>Please Enter Message</span>";	
	}
	elseif( $_REQUEST['security_code']=='')
	{
	$_SESSION['sess_msg'] = "<span style='color:#ff0000'>Please Enter Image Code</span>";
	}
	elseif( $_SESSION['security_code'] != $_REQUEST['security_code'] && !empty($_SESSION['security_code']))
	{
	$_SESSION['sess_msg'] = "<span style='color:#ff0000'>The code entered is incorrect. </span>";
	}
	else
	{
		
		 
		$sql = "SELECT Member_Account_Id FROM member_account_master WHERE Email LIKE '%".$_REQUEST['To']."%' AND Status=1 AND Account_Type!='ADMIN' AND Account_Type!='ADMINISTRATOR USER'";
		$result = mysql_query($sql);
		$colles = mysql_fetch_array($result);
		if(mysql_num_rows($result)>0)
		{
		$insert_Query = "INSERT INTO message_master SET
						 To_Id = '".trim($colles['Member_Account_Id'])."',
						 From_Id = '".trim($_SESSION['SESS_ID'])."',
						 Subject = '".trim(addslashes($_REQUEST['Subject']))."',
						 Message = '".trim(nl2br(addslashes($_REQUEST['Message'])))."',
						 Date = now(),
						 Sent=1";
		mysql_query($insert_Query);
		$lastId = mysql_insert_id();

		if(!empty($_FILES['Attachment_File']['name']))
		{
		list($getname,$getext) = explode(".",$_FILES['Attachment_File']['name']);
		$create_filename = "Attach_File_".$lastId;
		$create_new_filename = $create_filename.".".$getext;
		$upload_path = "products/attachment_file/".$create_new_filename;
		move_uploaded_file($_FILES['Attachment_File']['tmp_name'],$upload_path);
		$sql_update = mysql_query("UPDATE product_master SET Attachment_File='".$create_new_filename."' WHERE Inbox_Id='".$lastId."'");
		}
		$_SESSION['sess_msg'] = "<span style='color:#1FB221'>A message has been sent successfully.</span>";
		
		$go_here = $pageName.'?'.$_SERVER['QUERY_STRING'];
		
		header('location:'.$go_here);
		exit(0);
		}
		else
		{
		$_SESSION['sess_msg'] = "<span style='color:#ff0000'>404 ERROR</span>";
		header('location:'.$go_here);
		exit(0);
		}
		
	}
}
?>
<script type="text/javascript" src="javascript/jquery-1.2.1.pack.js"></script>
<script type="text/javascript">

	
function getblank(this1)  {
	if (this1.value = "Your e-mail ID") {
		this1.value = "";
	}
    return true;
}

	
	function lookupCity(To) {
		if(To.length == 0) {
			// Hide the suggestion box.
			$('#suggestionscity').hide();
		} else {
			$.post("rpc.php", {queryString: ""+To+""}, function(data){
				if(data.length >0) {
					$('#suggestionscity').show();
					$('#autoSuggestionsListcity').html(data);
				}
			});
		}
	} // lookup
	
	function fillCity(thisValue) {
		
		$('#To').val(thisValue);
		setTimeout( "$( '#suggestionscity' ).hide();", 200 );
	}
</script>
<style type="text/css">
	
	h3 {
		margin: 0px;
		padding: 0px;	
	}

	.suggestionsBoxcity {
		position: absolute;
		margin: 10px 0px 0px 0px;
		width: 200px;
		background-color:#EFEFEF;
		-moz-border-radius: 7px;
		-webkit-border-radius: 7px;
		border: 2px solid #EEE;	
		color:#666666;	
	}
	
	.suggestionListcity {
		margin: 0px;
		padding: 0px;
	}
	
	.suggestionListcity li {
		margin: 0px 0px 1px 17px;
		padding: 1px;
		cursor: pointer;
	}
	
	.suggestionListcity li:hover {
		background-color:#EFEFEF;
	}
</style>
<script type="text/javascript">
  function reloadCaptcha(imageName)
  {
    var randomnumber=Math.floor(Math.random()*1001); // generate a random number to add to image url to prevent caching
    document.images[imageName].src = document.images[imageName].src + '&amp;rand=' + randomnumber; // change image src to the same url but with the random number on the end
  }
  </script>

<div id="page-wrapper">
  <div class="layoutArea">
    <div class="contentArea">
      <div class="content-box-2">
        <div class="cor_1set-5"></div>
        <div class="cor_1set-6"></div>
        <?php include "message-left.inc.php"; ?>
            
        <div class="rgtPannel2 fr">
          <div class="rgtPannel-col first">
            <img src="images/icon/message.png" width="30" height="30"  align="absmiddle"  /><span style=" font-size:16px; font-weight:bold; padding-left:7px; top:5px; position:relative;">Compose a message </span>
            <p>When you collaborate with another member on Mussino you can send them invites to created sessions. You can locate the collaborate button on users profile page. Once you accept or get accepted, users will be added to your collaborate List below</p>
            <div style="padding:10px 0 0 0;">
            <form id="frmMessage" name="frmMessage"  method="post" action="" enctype="multipart/form-data">
              <?php if($_SESSION['sess_msg']!='') { ?>
              <div style="padding-left:2px;"><?=$_SESSION['sess_msg']?> <?php $_SESSION['sess_msg'] =''; ?></div>
              <?php } ?>
              <ul class="list-2" id="message_id1">
              
                <li style="padding:10px 0 0 0;">
                  <div class="caption-2" style="padding-bottom:5px;">Collaborate List <span> *</span></div>
                  <div class="input-2">
                  <?php if($_REQUEST['id']!='') { ?>
                  <input name="To" id="To" type="text" value="<?=$_POST['To']!=''?$_POST['To']:$msgEmail;?>" readonly="readonly"  style="border:1px solid #999; height:18px; color:#000000; text-align:left; width:250px; text-transform:none; font-weight:normal; font-size:12px;" >
                  <?php } elseif($_REQUEST['ubid']!='') { ?>
                  <input name="To" id="To" type="text" value="<?=$_POST['To']!=''?$_POST['To']:$msgEmail;?>"  style="border:1px solid #999; height:18px; color:#000000; text-align:left; width:250px; text-transform:none; font-weight:normal; font-size:12px;" >
                  <?php } elseif($_REQUEST['uid']!='') { ?>
                  <select name="To" id="To" style="border:1px solid #999; border-radius: 5px 5px 5px 5px; height:26px; color:#000000; text-align:left; width:270px; text-transform:none; font-weight:normal; font-size:12px;">
                    <option value="">Select</option>
                    <?php
					while($colles_user_list = mysql_fetch_array($result_user_list))
					{
					?>
                    <option value="<?=$colles_user_list['Email']?>" <?php if($colles_user_list['Email']==$_POST['To']) { echo'selected'; }?>><?=stripslashes($colles_user_list['First_Name'].' '.$colles_user_list['Last_Name'])?></option>
                    <?php
					}
					?>
                  </select>
                  
                  <?php } elseif($_SESSION['SESS_ACCOUNT_TYPE']=='Artist' && $_REQUEST['id']=='' && $_REQUEST['uid']=='') { ?>
                  <select name="To" id="To" style="border:1px solid #999; border-radius: 5px 5px 5px 5px; height:26px; color:#000000; text-align:left; width:270px; text-transform:none; font-weight:normal; font-size:12px;">
                  <option value="">Select</option>
                    <?php
					while($colles_user_list1 = mysql_fetch_array($result_user_list1))
					{
					?>
                    <option value="<?=$colles_user_list1['Email']?>" <?php if($colles_user_list1['Email']==$_POST['To']) { echo'selected'; }?>><?=stripslashes($colles_user_list1['First_Name'].' '.$colles_user_list1['Last_Name'])?></option>
                    <?php
					}
					?>
                  </select>
                  
                  <?php } elseif($_SESSION['SESS_ACCOUNT_TYPE']=='Musician' && $_REQUEST['id']=='' && $_REQUEST['uid']=='') {?>
                  <select name="To" id="To" style="border:1px solid #999; border-radius: 5px 5px 5px 5px; height:26px; color:#000000; text-align:left; width:270px; text-transform:none; font-weight:normal; font-size:12px;">
                  <option value="">Select</option>
                    <?php
					while($colles_user_list2 = mysql_fetch_array($result_user_list2))
					{
					?>
                    <option value="<?=$colles_user_list2['Email']?>" <?php if($colles_user_list2['Email']==$_POST['To']) { echo'selected'; }?>><?=stripslashes($colles_user_list2['First_Name'].' '.$colles_user_list2['Last_Name'])?></option>
                    <?php
					}
					?>
                  </select>
                  <?php } ?>
                 
                  
                  </div>
                  <div class="cl"></div>
                </li>
                
                
                <li style="padding:10px 0 0 0;">
                  <div class="caption-2" style="padding-bottom:5px;">Subject<span> *</span></div>
                  <div class="input-2">
                  <input type="text" name="Subject" id="Subject" value="<?=$_POST['Subject']!=''?$_POST['Subject']:'';?>" style="border:1px solid #999; height:18px;color:#000000; text-align:left; width:250px;text-transform:none;font-weight:normal; font-size:12px;"  />
                  </div>
                  <div class="cl"></div>
                </li>
                
                <li style="padding:10px 0 0 0;">
                  <div class="caption-2" style="padding-bottom:5px;">Attach file<span> *</span></div>
                  <div class="input-2">
                  <input type="file" name="Attachment_File" id="Attachment_File"  style="border:1px solid #999; height:22px;color:#000000; text-align:left; width:250px;text-transform:none;font-weight:normal; font-size:12px; border-radius: 5px 5px 5px 5px;"  />
                  </div>
                  <div class="cl"></div>
                </li>
                
                
                <li style="padding:10px 0 0 0;">
                  <div class="caption-2" style="padding-bottom:5px;">Message <span>*</span></div>
                  <div class="input-2">
                  <textarea name="Message" cols="50" style="border-radius: 10px 10px 10px 10px; padding-left:5px;" rows="4"><?php if($_REQUEST['id']!='') { echo stripslashes($colles_msg['Lyrics']); } elseif($_POST['Message']!='') { echo stripslashes($_POST['Message']); } ?></textarea>
                  </div>
                  <div class="cl"></div>
                </li>
                
                <li style="padding:10px 0 0 0;">
                  <div class="caption-2">Type the code shown <span>*</span></div>
                  <div class="input-2">
                  <div class="captcha" style="padding:0 0 5px 0;">
                  <img src="<?=SITE_WS_PATH?>/php_captcha.php?hash=<?php echo $hash; ?>&width=150&height=40&characters=8" alt="captcha" name="captchaImage" />
                  </div>
                  <div class="gray-btn-1" style="padding-bottom:10px;">
                    <span>
                      <span><a href="#" onclick="reloadCaptcha('captchaImage'); return false;">Refresh</a></span>
                    </span>
                  </div>
                   <div class="cl"></div>
                   <input type="text" name="security_code" id="security_code" value="<?=$_POST['security_code']!=''?$_POST['security_code']:'';?>" style="border:1px solid #999; height:18px; color:#000000; text-align:left; width:250px;text-transform:none;font-weight:normal; font-size:12px;" >
                  </div>
                  <div class="cl"></div>
               </li>     
                
                <li style="padding:10px 0 0 0;">
                  <div class="input-field2">
                  
                  <div class="submit-btn fl">
                      <span>
                        <span>
                         <input style="background-color:#438EEB;  color:#fff;" name="buttonSubmit" type="submit" value="Submit" onClick="return do_message();" onKeyPress="if(event.keyCode==13) {return do_message();}"> 
                        </span>
                      </span> 
                    </div>
                  
                  </div>
                  <div class="cl"></div>
                </li>
                               
              </ul>
             
              </form>        
            </div>
          </div>
          
        </div>
        <div class="cl"></div>
        <div class="cor_1set-3"></div>
        <div class="cor_1set-4"></div>
      </div>
      <?php if($_SESSION['SESS_ID']!='') { ?>
      <?php include"footer-div.inc.php"; ?>
      <?php } ?>
    </div>
  </div>
</div>
