<?php 
require_once "config/functions.inc.php";
?>
<div class="lightbox-msg"> 
<script type="text/javascript">
function createObject(){
if(window.XMLHttpRequest){
var obj	= new XMLHttpRequest();
}else{
var obj	= new ActiveXObject('Microsoft.XMLHTTP');
}
return obj;
}

var httpobj	= createObject();


function SentSellSession_Msg(lpi){ 

document.getElementById('sell_session_msg_id').innerHTML ='<img src="<?=SITE_WS_PATH?>/images/loading.gif" alt="" />';

var Message = document.getElementById('Message').value; 
var Action = document.getElementById('Action').value;    

httpobj.open('get',"<?=SITE_WS_PATH?>/ajax-session-sell-msg.php?lpi="+lpi+"&Message="+Message+"&Action="+Action);
httpobj.onreadystatechange	= handleSellSessionMSGResponse;
httpobj.send("");

}
function handleSellSessionMSGResponse(){

if(httpobj.readyState==4)
{
	var text = httpobj.responseText;
	if(text=="<span style='color:#000'>Message sent successfully</span>")
	{
	   document.getElementById('sell_session_msg_id').innerHTML = text;
	   var timeoutLoader1 = window.setTimeout(function(){ parent.parent.GB_hide(); }, 2000);
	   parent.opener.location.reload();
	   
	}
	else
	{
		document.getElementById('sell_session_msg_id').innerHTML = text;
	}

}
}


</script>
<form id="frmSellSession" name="frmSellSession" method="post" action="">
<ul style="list-style-type:none;">
<li>
<div class="date">
<div style=" color:#60A2F6; font-weight:bold; font-size:22px; text-align:justify;">Sent Message</div>
</div>

<div class="cl"></div>
</li>
<li  id="sell_session_msg_id" style="padding: 10px 0 0 114px; font-size:14px; font-weight:bold;"></li>


<li>
<ul class="login" style="list-style-type:none;">
<li style="font-weight:bold; float:left;width:65px;">Message</li>
<li style=" padding-left:10px; float:left;"><textarea name="Message" id="Message" cols="38" rows="8"></textarea></li>
</ul>
</li>
<div style="clear:both;"></div>

<li>
<ul class="login" style="list-style-type:none;">
<li style="font-weight:bold; float:left; width:65px;">Action</li>
<li style=" padding-left:10px; float:left;">
<select name="Action" id="Action">
<option value="">Select</option>
<option value="1">Accept</option>
<option value="2">Decline</option>
</select>
</li>
</ul>
</li>
<div style="clear:both;"></div>


<li style="padding:10px 0 0 114px;">
<input class="button" name="buttonSubmit" type="button" value="Sent Message" onclick="return SentSellSession_Msg('<?=$_REQUEST['id']?>');" onkeypress="if(event.keyCode==13) {return SentSellSession_Msg('<?=$_REQUEST['id']?>'); }">
</li>
</ul>
</form>
</div>