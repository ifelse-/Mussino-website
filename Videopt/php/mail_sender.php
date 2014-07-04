<?
if(!empty($_POST['sender_mail'])
    || !empty($_POST['sender_message'])
	|| !empty($_POST['sender_footer'])
    || !empty($_POST['sender_subject'])
    || !empty($_POST['sender_name'])
	|| !empty($_POST['receiver_mail']))
{
    $to = $_POST['receiver_mail'];
    $s_name = $_POST['sender_name'];
    $s_mail = $_POST['sender_mail'];
    $subject = stripslashes($_POST['sender_subject']);
	$footer = stripslashes($_POST['sender_footer']);
    $body .= stripslashes($_POST['sender_message']);
    $body .= "\n\n---------------------------\n";
    $body .= "$footer\n";
    $header = "From: $s_name <$s_mail>\n";
    $header .= "Reply-To: $s_name <$s_mail>\n";
    $header .= "X-Mailer: PHP/" . phpversion() . "\n";
    $header .= "X-Priority: 1";
    if(mail($to, $subject, $body, $header))
    {
        echo "<response><message>sent</message></response>";
    } else {
        echo "<response><message>error</message></response>";
    }
} else {
    echo "<response><message>error</message></response>";
}
?>      
