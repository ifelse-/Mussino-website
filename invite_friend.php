<?php 

require_once "config/functions.inc.php";

if($_REQUEST['buttonSubmit']=='Submit')

{

@extract();
$subject = "Checkout ";		
$message= 'Dear friend, </br></br>';		
$message.= $Message;
$message.= 'Thanks';
$header = "From: ".$Email." \r\n";
$header .= "Content-type: text/html\r\n"; 

$mail = @mail($Email, $subject, $message, $header);

if($mail)

{

$_SESSION['sess_mess'] = 'An email has been sent to your friend(s).';

header("location: invite_friend.php");

exit;

}

else

{

$_SESSION['sess_mess'] = 'server error.';

header("location: invite_friend.php");

exit;

}

}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>

<title>Invite Your Friends</title>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<meta name="description" content="Default Description">

<meta name="keywords" content="">

<meta name="robots" content="">

<?php include "common.inc.php"; ?>

<script type="text/javascript">

function validateFormOnSubmit(theForm) {

var reason = "";



	reason += validateEmail(theForm.Email);

	reason += validateMSG(theForm.Message);

	

  if (reason != "") {

    alert("You must fill out the following fields :\n\n" + reason);

    return false;

  } else

	{ return true; }

}



function validateMSG(fld) {

    var error = "";

 

    if (fld.value.length == 0) {

        fld.style.background = 'Yellow'; 

        error = "Message is Required. \n\n"

    } else {

        fld.style.background = 'White';

    }

    return error;  

}



function trim(s)

{

  return s.replace(/^\s+|\s+$/, '');

}

function validateEmail(fld) {

    var error="";

    var tfld = trim(fld.value);                        // value of field with whitespace trimmed off

    var emailFilter = /^[^@]+@[^@.]+\.[^@]*\w\w$/ ;

    var illegalChars= /[\(\)\<\>\ \,\;\:\\\"\[\]]/ ;

   

    if (fld.value == "") {

        fld.style.background = 'Yellow';

        error = "Email is Required. \n\n";

    } else if (!emailFilter.test(tfld)) {              //test email for illegal characters

        fld.style.background = 'Yellow';

        error = "Invalid Email. \n\n";

    } else if (fld.value.match(illegalChars)) {

		fld.style.background = 'Yellow';

        error = "Email contains illegal characters. \n\n";

    } else {

        fld.style.background = 'White';

    }

    return error;

}



</script>

</head>



<body id="bd" class=" cms-index-index cms-home fs3">



<!-- HEADER -->

<?php include "header.top.inc.php"; ?>



<?php include "header.middle.inc.php"; ?>

<!-- TOP SPOTLIGHT 1 -->

<div id="ja-topsl" class="wrap">

    <div class="main">

        <div class="inner">

			<div class="jm-product-list latest clearfix">

				<div class="headInner">

					<h4><span class="first-word"><span>Invite Your Friends</span></span></h4>

				</div>

				<div class="form-container notes">

					<form id="frmInviteFriend" name="frmInviteFriend" method="post" action="" onsubmit="return validateFormOnSubmit(this)">

						<ul>

							<?php if($_SESSION["sess_mess"]!='') { ?>

							<li>

								<ul class="login">

									<li>&nbsp;</li>

									<li class="error"><?=$_SESSION["sess_mess"]?> <? $_SESSION["sess_mess"]='';?></li>

								</ul>

							</li>

							<?php } ?>

							<li>

								<ul class="login">

									<li>Email Addresses <br /><span style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#25A6D5">(separated by commas)</span></li>

									<li><input type="text" name="Email" id="Email" class="input-text" size="60" ></li>

								</ul>

							</li>

							<li>

								<ul class="login">

									<li>Email Message </li>

									<li><textarea name="Message" cols="57" rows="8" ></textarea></li>

								</ul>

							</li>

							<li>

								<ul class="login">

									<li>&nbsp;</li>

									<li><input class="button" name="buttonSubmit" type="submit" value="Submit" onclick="return login_request_result();" onkeypress="if(event.keyCode==13) {return login_request_result();}"></li>

								</ul>

							</li>

						</ul>  

					</form>

				</div>

            </div>

        </div>

    </div>

</div>



<!-- BOTTOM SPOTLIGHT 2 -->

<?php include "bottom.footer.inc.php"; ?>

<!-- //BOTTOM SPOTLIGHT 2--> 



<!-- FOOTER -->

<?php include "footer.inc.php"; ?>

<!-- //FOOTER -->



</body>

</html>