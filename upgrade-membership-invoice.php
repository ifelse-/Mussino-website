<?php
require_once("config/functions.inc.php");

$req = 'cmd=_notify-validate';
//print '<pre>';print_r($_REQUEST);print '</pre>'; echo"jj". $txn_id; exit();
foreach ($_REQUEST as $key => $value)
{
   
    $log .= '' . $key . '=' . $value . ' ';
    $value = urlencode (stripslashes ($value));
    $req .= '' . '&' . $key . '=' . $value;
}
$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);
if($_GET['sessid'] !=session_id())
{
    $_SESSION['SESS_MSG'] = 'Sorry may some error with session.';
    header("location: error.php");
    exit;
}
@extract($_POST);
if(!$fp)
{
    $_SESSION['SESS_MSG'] = 'HTTP ERROR..';
    header("location: error.php");
    exit;
}
else
{
    fputs ($fp, $header . $req);
    while (!feof($fp))
    {
        $res = fgets ($fp, 1024);
       
        if(strtolower($payer_status) == "verified")
        {
            if (strtolower($payment_status) == 'completed' )
            {
                $sql = "SELECT * FROM membership_paypall_history WHERE Member_Account_Id = '".$_SESSION['SESS_ID']."'";
				$result = mysql_query($sql);
				if(mysql_num_rows($result)==0) 
				{
				$sqlInsert= " INSERT INTO membership_paypall_history SET
							  Member_Account_Id = '".$_SESSION['SESS_ID']."',
							  Amount = '".trim($_SESSION['up_amount'])."',
							  Date = now(),
							  Status = '1'";
				mysql_query($sqlInsert);
				}
				else
				{
				$sqlUpdate= " UPDATE membership_paypall_history SET
							  Member_Account_Id = '".$_SESSION['SESS_ID']."',
							  Amount = '".trim($_SESSION['up_amount'])."',
							  Date = now(),
							  Status = '1'";
				mysql_query($sqlUpdate);
				
				}	
				 
				$_SESSION['SESS_MSG'] = 'Your membership upgrade successfully';
				header("location: success.php");
                    

                }

            }

            elseif ($payment_status == 'Pending')

            {

                $_SESSION['SESS_MSG'] = 'SALES ENTRY NOT MADE';

                header("location: error.php");

                exit;

            }

            elseif ($payment_status == 'Refunded')

            {

                $_SESSION['SESS_MSG'] = 'Refunded status has been checked successfully.';

                header("location: error.php");

                exit;

            }

        }

        elseif(strcmp($res,"INVALID")==0)

        {

            if ($payment_status == 'Pending')

            {

                $_SESSION['SESS_MSG'] = 'Sales entry not made.';

                header("location: error.php");

                exit;

            }

            elseif ($payment_status == 'Refunded')

            {

                $_SESSION['SESS_MSG'] = 'Refunded status has been checked successfully.';

                header("location: error.php");

                exit;

            }

        }

    }

    fclose ($fp);

}


?>