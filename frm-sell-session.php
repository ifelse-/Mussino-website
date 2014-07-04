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


function SellSession(lpi){ 

document.getElementById('sell_session_id').innerHTML ='<img src="<?=SITE_WS_PATH?>/images/loading.gif" alt="" />';

var Price = document.getElementById('Price_id').value;    
var Percent = document.getElementById('Percent_id').value;

//alert("<?=SITE_WS_PATH?>/ajax-session-sell.php?lpi="+lpi+"&Price="+Price+"&Percent="+Percent);
httpobj.open('get',"<?=SITE_WS_PATH?>/ajax-session-sell.php?lpi="+lpi+"&Price="+Price+"&Percent="+Percent);
httpobj.onreadystatechange	= handleSellSessionResponse;
httpobj.send("");

}
function handleSellSessionResponse(){

if(httpobj.readyState==4)
{
	var text = httpobj.responseText;
	if(text=="<span style='color:#000'>Record added successfully</span>")
	{
	   document.getElementById('sell_session_id').innerHTML = text;
	   var timeoutLoader1 = window.setTimeout(function(){ parent.parent.GB_hide(); }, 2000);
	   
	}
	else
	{
		document.getElementById('sell_session_id').innerHTML = text;
	}

}
}

function cal_value(pri,pcnt)
{
	var  Orig_Price = pri;
	var  Orig_Percent = pcnt;
	var  SongwriterTotal = (Orig_Price*Orig_Percent)/100;
	document.getElementById('song_total_id').innerHTML = '$'+(SongwriterTotal.toFixed(2));
} 
</script>
<form id="frmSellSession" name="frmSellSession" method="post" action="">
<ul style="list-style-type:none; margin:0px; padding:20px;">
<li>
<div class="date" style="font-family:Arial, Helvetica, sans-serif">
<div style=" color:#60A2F6; font-weight:bold; font-size:22px; text-align:justify;">Sell This Session</div>
<div style=" color:#EC732A; font-weight:bold; font-size:18px; text-align:justify;">Offer Musician a chance to earn a percentage of sales</div>
<div style=" color:#696969; font-size:14px; text-align:justify;">Once this session ends you have a chance to offer the Musician a percentage of sales. If musician approved offer the audio session will be place in your account profile page. You must have a Silver or Platinum membership account. <a style="color:#09F; font-weight:bold;"  href="http://mussino.com/artist-membership-upgrade.php">Update grade now</a>.</div>
</div>

<div class="cl"></div>
</li>
<li  id="sell_session_id" style="padding: 10px 0 0 188px; font-size:14px; font-weight:bold;"></li>


<li>
<ul class="login" style="list-style-type:none;">
<li style="font-weight:bold; float:left;width:138px;">Price</li>
<li style=" padding-left:10px; float:left;"><input type="text" name="Price" id="Price_id" onkeypress="if(event.keyCode==13) {return SellSession('<?=$_REQUEST['id']?>'); }" ></li>
</ul>
</li>
<div style="clear:both;"></div>

<li>
<ul class="login" style="list-style-type:none;">
<li style="font-weight:bold; float:left; width:138px;">Offer Percentage</li>
<li style=" padding-left:10px; float:left;"><input type="text" name="Percent" id="Percent_id" onkeypress="if(event.keyCode==13) {return SellSession('<?=$_REQUEST['id']?>'); }" ></li>
</ul>
</li>
<div style="clear:both;"></div>

<li>
<ul class="login" style="list-style-type:none;">
<li style="font-weight:bold; float:left; width:138px;">Songwriter Total</li>
<li id="song_total_id" style="font-weight:bold; font-size:16px; color:#60A2F6; padding-left:10px; float:left;"></li>
</ul>
</li>
<div style="clear:both;"></div>



<li style="padding:10px 0 0 188px;">
<input class="button" name="buttonSubmit" type="button" id="trt" value="Calculate" onclick="return cal_value(document.getElementById('Price_id').value,document.getElementById('Percent_id').value);" >
<input class="button" name="buttonSubmit" type="button" value="Submit" onclick="return SellSession('<?=$_REQUEST['id']?>');" onkeypress="if(event.keyCode==13) {return SellSession('<?=$_REQUEST['id']?>'); }">
</li>
</ul>
</form>
</div>