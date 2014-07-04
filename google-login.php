<?php
require 'openid.php';
try {
	$openid = new LightOpenID;
	if(!$openid->mode) {
		if(isset($_GET['login'])) {
			$openid->identity = 'https://www.google.com/accounts/o8/id';
			$openid->required = array('namePerson/first', 'namePerson/last', 'contact/email');
			header('Location: ' . $openid->authUrl());
		}
?>
<script language="javascript">
window.location.href="<?php echo $_SERVER['PHP_SELF'] . "?login"?>
</script>
<?php } elseif($openid->mode == 'cancel') {
							echo 'User has canceled authentication!';
						} else {
							if($openid->validate())
							{			
								#echo 'User <b>' . $openid->identity . '</b> has logged in.<br>';
								
								#echo "<h3>User information</h3>";
								
								$identity = $openid->identity;
								$attributes = $openid->getAttributes();
								$email = $attributes['contact/email'];
								$first_name = $attributes['namePerson/first'];
								$last_name = $attributes['namePerson/last'];
								
								#echo "mode: " . $openid->mode . "<br>";
								#echo "identity: " . $identity . "<br>";
								#echo "email: " . $email . "<br>";
								#echo "first_name: " . $first_name . "<br>";
								#echo "last_name: " . $last_name . "<br>";
								
								$sql = "SELECT * FROM member_account_master WHERE  Email='".$email."'";
								$result = executeQuery($sql);
						
								if(mysql_num_rows($result )>0)
								{
								$line=mysql_fetch_array($result);
											
								$_SESSION['SESS_ID'] = $line['Member_Account_Id'];
								$_SESSION['SESS_EMAIL'] = $line['Email'];
								$_SESSION['SESS_FIRST_NAME']= ucfirst($line['First_Name']);
								$_SESSION['SESS_LAST_NAME']= ucfirst($line['Last_Name']);
								$_SESSION['SESS_ACCOUNT_TYPE'] = $line['Account_Type'];
								
								mysql_query("UPDATE member_account_master SET Last_Visited=now() WHERE Member_Account_Id='".$_SESSION['SESS_ID']."'");
								
									if($_SESSION['go']!='')
									{
									header("location: my-cart.php");
									exit(0);
									}
									else
									{
									header("location: my-profile.php");
									exit(0);
									}
								}
								else
								{
									$sql_insert = "INSERT INTO member_account_master SET
									               First_Name='".$first_name."',
												   Last_Name='".$last_name."',
												   Email='".$email."',
												   Account_Type ='Friend',
												   Date = now(),
												   status='1'";
									mysql_query($sql_insert);
									
									$sql = "SELECT * FROM member_account_master WHERE  Email='".$email."'";
								    $result = executeQuery($sql);
									
									$line=mysql_fetch_array($result);
											
								    $_SESSION['SESS_ID'] = $line['Member_Account_Id'];
								    $_SESSION['SESS_EMAIL'] = $line['Email'];
								    $_SESSION['SESS_FIRST_NAME']= ucfirst($line['First_Name']);
								    $_SESSION['SESS_LAST_NAME']= ucfirst($line['Last_Name']);
								    $_SESSION['SESS_ACCOUNT_TYPE'] = $line['Account_Type'];
								
								    mysql_query("UPDATE member_account_master SET Last_Visited=now() WHERE Member_Account_Id='".$_SESSION['SESS_ID']."'");
									
									if($_SESSION['go']!='')
									{
									header("location: my-cart.php");
									exit(0);
									}
									else
									{
									header("location: my-profile.php");
									exit(0);
									}
								}
								
								
							}
							else
							{
								echo 'User ' . $openid->identity . 'has not logged in.';
							}
						}
					} catch(ErrorException $e) {
						echo $e->getMessage();
					}
?>