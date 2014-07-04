<?php 
$urls = $pageName.'?id='.$_REQUEST['id'];
?>
<link href="<?=SITE_WS_PATH?>/css/layout.css" rel="stylesheet" type="text/css" />
<link href="<?=SITE_WS_PATH?>/css/additional.css" rel="stylesheet" type="text/css" />
<!--[if IE 7]>
    <link rel="stylesheet" type="text/css" href="css/ie-7.css" />
<![endif]-->

<script src="//cdn.jquerytools.org/1.2.7/full/jquery.tools.min.js"></script>

<script type="text/javascript" src="<?=SITE_WS_PATH?>/script/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?=SITE_WS_PATH?>/script/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?=SITE_WS_PATH?>/script/config-add.js"></script>
<script type="text/javascript">
var GB_ROOT_DIR = "<?=SITE_WS_PATH?>/greybox/";
</script>
<script type="text/javascript" src="<?=SITE_WS_PATH?>/greybox/AJS.js"></script>
<script type="text/javascript" src="<?=SITE_WS_PATH?>/greybox/AJS_fx.js"></script>
<script type="text/javascript" src="<?=SITE_WS_PATH?>/greybox/gb_scripts.js"></script>
<link href="<?=SITE_WS_PATH?>/css/jquery-ui-1.10.4.custom.css" rel="stylesheet">
<script src="<?=SITE_WS_PATH?>/script/jquery-1.10.2.js"></script>


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

	function ajaxNewsLetter(){
	
	    document.getElementById('view_newsletter').innerHTML ='<img src="<?=SITE_WS_PATH?>/images/loading.gif" alt="" />';
		
		var Email = document.frmNewsletter.Email.value;    
	    var Name = document.frmNewsletter.Name.value;
		
		httpobj.open('get',"<?=SITE_WS_PATH?>/ajax_newsletter.php?Email="+Email+"&Name="+Name);
		httpobj.onreadystatechange	= handleNewsLetterResponse;
		httpobj.send("");
	
	}
	
	function handleNewsLetterResponse(){
	
		 if(httpobj.readyState==4){
			 var text = httpobj.responseText;
			 document.getElementById('view_newsletter').innerHTML = text;
		 }
	}
	
	
	
</script>
<script language="javascript">

function registration_request_result(){ 
	
    document.getElementById('view_registration_result').innerHTML ='<img src="<?=SITE_WS_PATH?>/images/loading.gif" alt="" />';
	
	
	var Email = document.frmRegistration.Email.value;    
	var Password = document.frmRegistration.Password.value;
	var First_Name = document.frmRegistration.First_Name.value;
	for (var i=0; i < document.frmRegistration.Account_Type.length; i++)
		{
			if(document.frmRegistration.Account_Type[i].checked)
			{
			var Account_Type = document.frmRegistration.Account_Type[i].value;
			}
			
		}
		
	if(document.frmRegistration.terms.checked==false)
	{
	var terms = 0;
	}
	else
	{
	var terms = document.frmRegistration.terms.value;
	}
		
	var security_code = document.frmRegistration.security_code.value;
	
	httpobj.open('get',"<?=SITE_WS_PATH?>/ajax-registration-request.php?Email="+Email+"&Password="+Password+"&First_Name="+First_Name+"&Account_Type="+Account_Type+"&security_code="+security_code+"&terms="+terms);
	httpobj.onreadystatechange	= handleRegistrationRequestResponse;
	httpobj.send("");

}
function handleRegistrationRequestResponse(){

	 if(httpobj.readyState==4)
	 {
		 var text = httpobj.responseText;
		 
		 if(text=='Go Welcome')
		 {
		 location.replace('<?=SITE_WS_PATH?>/action.php');
		 }
		 else
		 {
		 document.getElementById('view_registration_result').innerHTML = text;
		 }
	 }
}


function registration_musician_request_result(Account_Type){ 
	
    document.getElementById('view_musician_registration_result').innerHTML ='<img src="<?=SITE_WS_PATH?>/images/loading.gif" alt="" />';
	
	
	var Email = document.frmMusicianRegistration.Email.value;    
	var Password = document.frmMusicianRegistration.Password.value;
	var ConfirmPassword = document.frmMusicianRegistration.ConfirmPassword.value;
	var First_Name = document.frmMusicianRegistration.First_Name.value;
	var security_code = document.frmMusicianRegistration.security_code.value;
	
	if(document.frmMusicianRegistration.terms.checked==false)
	{
	var terms = 0;
	}
	else
	{
	var terms = document.frmMusicianRegistration.terms.value;
	}
	
	httpobj.open('get',"<?=SITE_WS_PATH?>/ajax-musician-registration-request.php?Email="+Email+"&Password="+Password+"&ConfirmPassword="+ConfirmPassword+"&First_Name="+First_Name+"&Account_Type="+Account_Type+"&security_code="+security_code+"&terms="+terms);
	httpobj.onreadystatechange	= handleMusicianRegistrationRequestResponse;
	httpobj.send("");

}
function handleMusicianRegistrationRequestResponse(){

	 if(httpobj.readyState==4)
	 {
		 var text = httpobj.responseText;
		
		 if(text=='Go Welcome')
		 {
		 location.replace('<?=SITE_WS_PATH?>/action.php');
		 }
		 else
		 {
		 document.getElementById('view_musician_registration_result').innerHTML = text;
		 }
	 }
}

function registration_songwriter_request_result(Account_Type){ 
	
    document.getElementById('view_songwriter_registration_result').innerHTML ='<img src="<?=SITE_WS_PATH?>/images/loading.gif" alt="" />';
	
	
	var Email = document.frmSongwriterRegistration.Email.value;    
	var Password = document.frmSongwriterRegistration.Password.value;
	var ConfirmPassword = document.frmSongwriterRegistration.ConfirmPassword.value;
	var First_Name = document.frmSongwriterRegistration.First_Name.value;
	var security_code = document.frmSongwriterRegistration.security_code.value;
	if(document.frmSongwriterRegistration.terms.checked==false)
	{
	var terms = 0;
	}
	else
	{
	var terms = document.frmSongwriterRegistration.terms.value;
	}
	
	httpobj.open('get',"<?=SITE_WS_PATH?>/ajax-songwriter-registration-request.php?Email="+Email+"&Password="+Password+"&ConfirmPassword="+ConfirmPassword+"&First_Name="+First_Name+"&Account_Type="+Account_Type+"&security_code="+security_code+"&terms="+terms);
	httpobj.onreadystatechange	= handlesongwriterRegistrationRequestResponse;
	httpobj.send("");

}
function handlesongwriterRegistrationRequestResponse(){

	 if(httpobj.readyState==4)
	 {
		 var text = httpobj.responseText;
		 if(text=='Go Welcome')
		 {
		 location.replace('<?=SITE_WS_PATH?>/action.php');
		 }
		 else
		 {
		 document.getElementById('view_songwriter_registration_result').innerHTML = text;
		 }
	 }
}

function registration_judge_request_result(Account_Type){ 
	
    document.getElementById('view_judge_registration_result').innerHTML ='<img src="<?=SITE_WS_PATH?>/images/loading.gif" alt="" />';
	
	
	var Email = document.frmJudgeRegistration.Email.value;    
	var Password = document.frmJudgeRegistration.Password.value;
	var ConfirmPassword = document.frmJudgeRegistration.ConfirmPassword.value;
	var First_Name = document.frmJudgeRegistration.First_Name.value;
	var security_code = document.frmJudgeRegistration.security_code.value;
	if(document.frmJudgeRegistration.terms.checked==false)
	{
	var terms = 0;
	}
	else
	{
	var terms = document.frmJudgeRegistration.terms.value;
	}
	
	httpobj.open('get',"<?=SITE_WS_PATH?>/ajax-judge-registration-request.php?Email="+Email+"&Password="+Password+"&ConfirmPassword="+ConfirmPassword+"&First_Name="+First_Name+"&Account_Type="+Account_Type+"&security_code="+security_code+"&terms="+terms);
	httpobj.onreadystatechange	= handleJudgeRegistrationResponse;
	httpobj.send("");

}
function handleJudgeRegistrationResponse(){

	 if(httpobj.readyState==4)
	 {
		 var text = httpobj.responseText;
		 if(text=='Go Welcome')
		 {
		 location.replace('<?=SITE_WS_PATH?>/action.php');
		 }
		 else
		 {
		 document.getElementById('view_judge_registration_result').innerHTML = text;
		 }
	 }
}

function login_artist_request_result(type){ 
	
    document.getElementById('view_login_artist_result').innerHTML ='<img src="<?=SITE_WS_PATH?>/images/loading.gif" alt="" />';

	var Email = document.frmArtistLogin.Email.value;    
	var Password = document.frmArtistLogin.Password.value;
	
	httpobj.open('get',"<?=SITE_WS_PATH?>/ajax-artist-login.php?Email="+Email+"&Password="+Password+"&type="+type);
	httpobj.onreadystatechange	= handleLoginArtistRequestResponse;
	httpobj.send("");

}
function handleLoginArtistRequestResponse(){

	 if(httpobj.readyState==4)
	 {
		 var text = httpobj.responseText;
		 if(text=='Go Welcome')
		 {
		 location.replace('<?=SITE_WS_PATH?>/action.php');
		 }
		 else if(text=='Go Cart')
		 {
		 location.replace('<?=SITE_WS_PATH?>/my-cart.php');
		 }
		 else
		 {
		 document.getElementById('view_login_artist_result').innerHTML = text;
		 }
	 }
}




function SellSession(lpi){ 
	
    document.getElementById('sell_session_id').innerHTML ='<img src="<?=SITE_WS_PATH?>/images/loading.gif" alt="" />';

	var Price = document.getElementById('Price').value;    
	var Percent = document.getElementById('Percent').value;
	var Total = document.getElementById('song_total').value;
	alert("<?=SITE_WS_PATH?>/ajax-session-sell.php?lpi="+lpi+"&Price="+Price+"&Percent="+Percent+"&Total="+Total);
	httpobj.open('get',"<?=SITE_WS_PATH?>/ajax-session-sell.php?lpi="+lpi+"&Price="+Price+"&Percent="+Percent+"&Total="+Total);
	httpobj.onreadystatechange	= handleSellSessionResponse;
	httpobj.send("");

}
function handleSellSessionResponse(){

	 if(httpobj.readyState==4)
	 {
		 var text = httpobj.responseText;
		 if(text=='Go Welcome')
		 {
		 location.replace('<?=SITE_WS_PATH?>/my-history.php');
		 }
		 else
		 {
		 document.getElementById('sell_session_id').innerHTML = text;
		 }
		 
	 }
}



function login_musician_request_result(type){ 
	
    document.getElementById('view_login_musician_result').innerHTML ='<img src="<?=SITE_WS_PATH?>/images/loading.gif" alt="" />';

	var Email = document.frmMusicianLogin.Email.value;    
	var Password = document.frmMusicianLogin.Password.value;
	
	httpobj.open('get',"<?=SITE_WS_PATH?>/ajax-musician-login.php?Email="+Email+"&Password="+Password+"&type="+type);
	httpobj.onreadystatechange	= handleLoginMusicianRequestResponse;
	httpobj.send("");

}
function handleLoginMusicianRequestResponse(){

	 if(httpobj.readyState==4)
	 {
		 var text = httpobj.responseText;
		 if(text=='Go Welcome')
		 {
		 location.replace('<?=SITE_WS_PATH?>/action.php');
		 }
		 else if(text=='Go Cart')
		 {
		 location.replace('<?=SITE_WS_PATH?>/my-cart.php');
		 }
		 else
		 {
		 document.getElementById('view_login_musician_result').innerHTML = text;
		 }
	 }
}

function login_judge_request_result(type){ 
	
    document.getElementById('view_login_judge_result').innerHTML ='<img src="<?=SITE_WS_PATH?>/images/loading.gif" alt="" />';

	var Email = document.frmJudgeLogin.Email.value;    
	var Password = document.frmJudgeLogin.Password.value;
	
	httpobj.open('get',"<?=SITE_WS_PATH?>/ajax-judge-login.php?Email="+Email+"&Password="+Password+"&type="+type);
	httpobj.onreadystatechange	= handleLoginJudgeRequestResponse;
	httpobj.send("");

}
function handleLoginJudgeRequestResponse(){

	 if(httpobj.readyState==4)
	 {
		 var text = httpobj.responseText;
		 if(text=='Go Welcome')
		 {
		 location.replace('<?=SITE_WS_PATH?>/action.php');
		 }
		 else if(text=='Go Cart')
		 {
		 location.replace('<?=SITE_WS_PATH?>/my-cart.php');
		 }
		 else
		 {
		 document.getElementById('view_login_judge_result').innerHTML = text;
		 }
	 }
}

function post_lyrics(type,pid,mid){ 
	
    document.getElementById('view_post_lyrics_result').innerHTML ='<img src="<?=SITE_WS_PATH?>/images/loading.gif" alt="" />';

	var Lyrics = document.chFrm.Lyrics.value;    
	httpobj.open('get',"<?=SITE_WS_PATH?>/ajax-post-lyrics.php?Lyrics="+Lyrics+"&type="+type+"&pid="+pid+"&mid="+mid);
	httpobj.onreadystatechange	= handlePostLyricsRequestResponse;
	httpobj.send("");

}
function handlePostLyricsRequestResponse(){

	 if(httpobj.readyState==4)
	 {
		 var text = httpobj.responseText;
		  var sharedLoader = document.getElementById('confirm_id'); //div auto hide made by vishwas just chill
          var timeoutLoader = window.setTimeout(function(){sharedLoader.style.display = 'none'; location.replace('action.php');}, 4000);
		 
	 }
}


function post_lyrics2(type,pid,mid){ 
	
    document.getElementById('view_post_lyrics_result').innerHTML ='<img src="<?=SITE_WS_PATH?>/images/loading.gif" alt="" />';

	var Lyrics = document.chFrm2.Lyrics.value;    
	httpobj.open('get',"<?=SITE_WS_PATH?>/ajax-post-lyrics.php?Lyrics="+Lyrics+"&type="+type+"&pid="+pid+"&mid="+mid);
	httpobj.onreadystatechange	= handlePostLyricsRequest2Response;
	httpobj.send("");

}
function handlePostLyricsRequest2Response(){

	 if(httpobj.readyState==4)
	 {
		 var text = httpobj.responseText;
		  document.getElementById('confirm_id').style.display='block';
		  document.getElementById('view_post_lyrics_result').innerHTML = text;
		  var sharedLoader = document.getElementById('confirm_id'); //div auto hide made by vishwas just chill
          var timeoutLoader = window.setTimeout(function(){sharedLoader.style.display = 'none'; location.replace('<?=$urls?>');}, 3000);
		  
		 
	 }
}


function post_judge_comment(pid,mid){ 
	
    document.getElementById('view_post_judge_comment_result').innerHTML ='<img src="<?=SITE_WS_PATH?>/images/loading.gif" alt="" />';

	var Lyrics_Comment = document.getElementById('Lyrics_Comment').value;    
	//alert("ajax-post-judge-comment.php?Lyrics_Comment="+Lyrics_Comment+"&pid="+pid+"&mid="+mid);
	document.getElementById('view_post_judge_comment_result').style.display = 'block';
	httpobj.open('get',"<?=SITE_WS_PATH?>/ajax-post-judge-comment.php?Lyrics_Comment="+Lyrics_Comment+"&pid="+pid+"&mid="+mid);
	httpobj.onreadystatechange	= handlePostJudgeCommentRequestResponse;
	httpobj.send("");

}
function handlePostJudgeCommentRequestResponse(){

	 if(httpobj.readyState==4)
	 {
		 var text = httpobj.responseText;
		  
		  document.getElementById('view_post_judge_comment_result').innerHTML = text;
		  var sharedLoader = document.getElementById('view_post_judge_comment_result'); //div auto hide made by vishwas just chill
          var timeoutLoader = window.setTimeout(function(){sharedLoader.style.display = 'none'; location.replace('<?=$urls?>');}, 3000);
		  
		 
	 }
}

function post_judge_comment2(pid,mid){ 
	
    document.getElementById('view_post_judge_comment_result').innerHTML ='<img src="<?=SITE_WS_PATH?>/images/loading.gif" alt="" />';

	var Lyrics_Comment = document.chFrm.Lyrics_Comment.value;    
	document.getElementById('view_post_judge_comment_result').style.display = 'block';
	httpobj.open('get',"<?=SITE_WS_PATH?>/ajax-post-judge-comment.php?Lyrics_Comment="+Lyrics_Comment+"&pid="+pid+"&mid="+mid);
	httpobj.onreadystatechange	= handlePostJudgeComment2RequestResponse;
	httpobj.send("");

}
function handlePostJudgeComment2RequestResponse(){

	 if(httpobj.readyState==4)
	 {
		 var text = httpobj.responseText;
		  
		  document.getElementById('view_post_judge_comment_result').innerHTML = text;
		  var sharedLoader = document.getElementById('view_post_judge_comment_result'); //div auto hide made by vishwas just chill
          var timeoutLoader = window.setTimeout(function(){sharedLoader.style.display = 'none'; location.replace('<?=$urls?>');}, 3000);
		  
		 
	 }
}
function showStuff(id) {
		document.getElementById(id).style.display = 'block';
	}
	function hideStuff(id) {
		document.getElementById(id).style.display = 'none';
	}
	
function showStuff1(id) {
		document.getElementById(id).style.visibility = 'visible';
	}
	function hideStuff1(id) {
		document.getElementById(id).style.visibility = 'hidden';
	}

function affilate_result(){ 
	
    document.getElementById('view_affilate_result').innerHTML ='<img src="<?=SITE_WS_PATH?>/images/loading.gif" alt="" />';
	
	
	var Agentname = document.frmAffilate.Agentname.value;    
	
	
	httpobj.open('get',"<?=SITE_WS_PATH?>/ajax-affilate-request.php?Agentname="+Agentname);
	httpobj.onreadystatechange	= handleAffilateResponse;
	httpobj.send("");

}


function handleAffilateResponse(){

	 if(httpobj.readyState==4)
	 {
		 var text = httpobj.responseText;
		 
		 if(text=='Agent name is not found our database')
		 {
		 document.getElementById('view_affilate_result').innerHTML = text;
		 }
		 else
		 {
		 document.getElementById('view_affilate_result').innerHTML = text;
		 document.getElementById('view_affilate_result_hide123').style.display = 'none';
		 }
		 
	 }
}

function affilate_result_insert(){ 
	
    document.getElementById('view_affilate_insert_result').innerHTML ='<img src="<?=SITE_WS_PATH?>/images/loading.gif" alt="" />';
	
	
	var OrderId = document.frmAffilateInsert.OrderId.value;    
	var OrderAmount = document.frmAffilateInsert.OrderAmount.value;
	var AgentId = document.frmAffilateInsert.AgentId.value;
	
	httpobj.open('get',"<?=SITE_WS_PATH?>/ajax-affilate-insert-request.php?OrderId="+OrderId+"&OrderAmount="+OrderAmount+"&AgentId="+AgentId);
	httpobj.onreadystatechange	= handleAffilateInsertResponse;
	httpobj.send("");

}
function handleAffilateInsertResponse(){

	 if(httpobj.readyState==4)
	 {
		 var text = httpobj.responseText;
		 document.getElementById('view_affilate_insert_result').innerHTML = text;
		 
	 }
}

function affilate_add_result(){ 
	
    document.getElementById('view_affilate_add_result').innerHTML ='<img src="<?=SITE_WS_PATH?>/images/loading.gif" alt="" />';
	
	
	var Agentname = document.frmAddAffilate.Agentname.value;    
	var URL = document.frmAddAffilate.URL.value;
	var Address = document.frmAddAffilate.Address.value;
	var EmailId = document.frmAddAffilate.EmailId.value;    
	var Company = document.frmAddAffilate.Company.value;
	var Country = document.frmAddAffilate.Country.value;
	var State = document.frmAddAffilate.State.value;    
	var Commision = document.frmAddAffilate.Commision.value;
	var Phoneno = document.frmAddAffilate.Phoneno.value;
	
	httpobj.open('get',"<?=SITE_WS_PATH?>/ajax-affilate-add-request.php?Agentname="+Agentname+"&URL="+URL+"&Address="+Address+"&EmailId="+EmailId+"&Company="+Company+"&Country="+Country+"&State="+State+"&Commision="+Commision+"&Phoneno="+Phoneno);
	httpobj.onreadystatechange	= handleAffilateAddResponse;
	httpobj.send("");

}
function handleAffilateAddResponse(){

	 if(httpobj.readyState==4)
	 {
		 var text = httpobj.responseText;
		 document.getElementById('view_affilate_add_result').innerHTML = text;
		 
	 }
}






function InviteFriendRequest(){ 
	
    document.getElementById('invite_friend_id').innerHTML ='<img src="<?=SITE_WS_PATH?>/images/loading.gif" alt="" />';
	
	
	var Email = document.frmInviteFriend.Email.value; 
	var Name =  document.frmInviteFriend.Name.value;  
	var Message = document.frmInviteFriend.Message.value;
	var security_code = document.frmInviteFriend.security_code.value;
	
	
	httpobj.open('get',"<?=SITE_WS_PATH?>/ajax-invite-friend.php?Email="+Email+"&Message="+Message+"&security_code="+security_code+"&Name="+Name);
	httpobj.onreadystatechange	= handleInviteFriendResponse;
	httpobj.send("");

}
function handleInviteFriendResponse(){

	 if(httpobj.readyState==4)
	 {
		 var text = httpobj.responseText;
		 
		 document.getElementById('invite_friend_id').innerHTML = text;
		 
	 }
}


function CollaborateFriendMsg(pro_id)
{ 
	
    document.getElementById('collaborate_friend_msg_id').innerHTML ='<img src="<?=SITE_WS_PATH?>/images/loading.gif" alt="" />';
	var Subject = document.frmCollaborateMsg.Subject.value;	
	var Message = document.frmCollaborateMsg.Message.value;	
	
	httpobj.open('get',"<?=SITE_WS_PATH?>/ajax-collaborate-friend-msg.php?pro_id="+pro_id+"&Subject="+Subject+"&Message="+Message);
	httpobj.onreadystatechange	= handleColFrndMsgResponse;
	httpobj.send("");

}
function handleColFrndMsgResponse()
{

	 if(httpobj.readyState==4)
	 {
		 var text = httpobj.responseText;
		 document.getElementById('collaborate_friend_msg_id').innerHTML = text;
		 var timeoutLoader = window.setTimeout(function(){location.replace('<?=$urls?>');}, 2000);
	 }
}



function CollaborateFriendRequest(pro_id){ 
	
    document.getElementById('collaborate_friend_id').innerHTML ='<img src="<?=SITE_WS_PATH?>/images/loading.gif" alt="" />';
		
	httpobj.open('get',"<?=SITE_WS_PATH?>/ajax-collaborate-friend.php?pro_id="+pro_id);
	httpobj.onreadystatechange	= handleCollaborateResponse;
	httpobj.send("");

}
function handleCollaborateResponse(){

	 if(httpobj.readyState==4)
	 {
		 var text = httpobj.responseText;
		 
		 document.getElementById('collaborate_friend_id').innerHTML = text;
		 
	 }
}

function membership_upgrade(u_id){ 
	
    document.getElementById('membership_upgrade_id').innerHTML ='<img src="<?=SITE_WS_PATH?>/images/loading.gif" alt="" />';
	
	
	var Amount = document.frmMembershipUpgrade.Amount.value; 
	
	
	httpobj.open('get',"<?=SITE_WS_PATH?>/ajax-membership-upgrade.php?Amount="+Amount+"&u_id="+u_id);
	httpobj.onreadystatechange	= handleMembershipUpgradeResponse;
	httpobj.send("");

}
function handleMembershipUpgradeResponse(){

	 if(httpobj.readyState==4)
	 {
		 var text = httpobj.responseText;
		 if(text=='Done')
		 {
		 location.replace('<?=SITE_WS_PATH?>/paypal-member-upgrade.php');
		 }
		 else
		 {
		 document.getElementById('membership_upgrade_id').innerHTML = text;
		 }
		 
	 }
}

function tellaFriendRequest(){ 
	
    document.getElementById('tell_a_friend_id').innerHTML ='<img src="<?=SITE_WS_PATH?>/images/loading.gif" alt="" />';
	
	
	var Email = document.frmTellaFriend.Email.value; 
	var Message = document.frmTellaFriend.Message.value;
	
	
	httpobj.open('get',"<?=SITE_WS_PATH?>/ajax-tell-a-friend.php?Email="+Email+"&Message="+Message);
	httpobj.onreadystatechange	= handleTellaFriendResponse;
	httpobj.send("");

}
function handleTellaFriendResponse(){

	 if(httpobj.readyState==4)
	 {
		 var text = httpobj.responseText;
		 
		 document.getElementById('tell_a_friend_id').innerHTML = text;
		 
	 }
}

function NotebookRequest(type,pid,mid){ 
	
    document.getElementById('notebook_id').innerHTML ='<img src="<?=SITE_WS_PATH?>/images/loading.gif" alt="" />';

	var Lyrics = document.frmNotebook.Lyrics.value;    
		//alert("ajax-post-lyrics.php?Lyrics="+Lyrics+"&type="+type+"&pid="+pid+"&mid="+mid);
	httpobj.open('get',"<?=SITE_WS_PATH?>/ajax-post-notebook.php?Lyrics="+Lyrics);
	httpobj.onreadystatechange	= handleNotebookResponse;
	httpobj.send("");

}
function handleNotebookResponse(){

	 if(httpobj.readyState==4)
	 {
		 var text = httpobj.responseText;
		  
		  if(text=="<span style='color:#990000;'>PLEASE ENTER THE LYRICS</span>")
		  {
		  document.getElementById('notebook_id').innerHTML = text;
		  }
		  else
		  {
		  document.getElementById('notebook_id1').style.display='none';
		  document.getElementById('notebook_id2').style.display='none';
		  document.getElementById('notebook_id').innerHTML = text;
		 
          var timeoutLoader = window.setTimeout(function(){location.replace('<?=$urls?>');}, 3000);
		  } 
		 
	 }
}
</script>


	<!-- Add HTML5 support for older IE browsers -->
	<!--[if lt IE 9]> 
		<script src="light_theme/js/html5.min.js"></script>
		<script src="light_theme/js/selectivizr-and-extra-selectors.min.js"></script>
	<![endif]-->
	<script src="light_theme/js/modernizr.custom.js"></script>
	<!-- sound manager -->
	<script src="light_theme/js/soundmanager/soundmanager2-nodebug-jsmin.js"></script>
	<script src="light_theme/js/soundmanager/jquery.playable.js"></script>
	<script src="light_theme/js/soundmanager/jquery.playable.ui.simple.js"></script>
	
	<!-- /sound manager -->
	<script src="light_theme/js/respond.min.js"></script>
	<script src="light_theme/js/jquery.fitvids.js"></script>
	<!-- Sliders -->
	<!-- jQuery Nivo slider -->
	<script src="light_theme/js/jquery.nivo.slider.pack.js"></script>
	 <!-- jQuery Revolution Slider  -->	
	<script type="text/javascript" src="light_theme/js/rs-plugin/jquery.themepunch.plugins.min.js"></script>			
    <script type="text/javascript" src="light_theme/js/rs-plugin/jquery.themepunch.revolution.min.js"></script>
	<!-- /Sliders -->
	<script src="light_theme/js/jquery.countdown.js"></script>
	<script src="light_theme/js/jquery.easing-1.3.min.js"></script>
<!--	<script src="light_theme/js/jquery.isotope.min.js"></script>
-->	<script src="light_theme/js/jquery.touchSwipe-1.2.5.min.js"></script>
	<script src="light_theme/js/jquery.sharrre-1.3.2.min.js"></script>
	<script src="//maps.google.com/maps/api/js?sensor=false&amp;libraries=places"></script>
	<script src="light_theme/js/jquery.gmap.min.js"></script>
	
	<!-- /Fancybox -->
	<!-- custom scripts -->
	<script src="light_theme/js/custom.js"></script>
    
