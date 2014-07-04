<?php
 $DB["dbName"] =  'mussinodb';   
	$DB["host"] = 'mussinodb.db.3754115.hostedresource.com'; 
	$DB["user"] = 'mussinodb';
	$DB["pass"] = 'Musicsite2011'; 
	$local_mode = false;
	mysql_connect($DB["host"], $DB["user"], $DB["pass"]) or die("<span style='FONT-SIZE:11px; FONT-COLOR: #000000; font-family=tahoma;'><center>An Internal Error has Occured. Please report following error to the webmaster.<br><br>".mysql_error()."'</center>");
mysql_select_db($DB["dbName"]);
//$conn=mysql_connect('localhost', 'root', '') or die(mysql_error());
//mysql_select_db('sound_cash') or die(mysql_error());
if(!$_POST['poll'] || !$_POST['pollid']){
	$query=mysql_query("SELECT id, ques FROM questions where Status='1' ");
	while($row=mysql_fetch_assoc($query)){
		//display question
		echo "<p class=\"pollques\" >".$row['ques']."</p>";
		$poll_id=$row['id'];
	}
	if($_GET["result"]==1 || $_COOKIE["voted".$poll_id]=='yes'){
		//if already voted or asked for result
		showresults($poll_id);
		exit;
	}
	else{
	//display options with radio buttons
		$query=mysql_query("SELECT id, `value` FROM options WHERE ques_id=$poll_id");
		if(mysql_num_rows($query)){
			echo '<div id="formcontainer" ><form method="post" id="pollform" action="'.$_SERVER['PHP_SELF'].'" >';
			echo '<input type="hidden" name="pollid" value="'.$poll_id.'" />';
			while($row=mysql_fetch_assoc($query)){
				echo '<p><input type="radio" name="poll" value="'.$row['id'].'" id="option-'.$row['id'].'" /> 
				<label for="option-'.$row['id'].'" >'.$row['value'].'</label></p>';
			}
			echo '<p><input type="submit"  value="Submit" /></p></form>';
			echo '<p><a href="'.$_SERVER['PHP_SELF'].'?result=1" id="viewresult">View result</a></p></div>';
		}
	}
}
else{
	if($_COOKIE["voted".$_POST['pollid']]!='yes'){
		
		//Check if selected option value is there in database?
		$query=mysql_query("SELECT * FROM options WHERE id='".intval($_POST["poll"])."'");
		if(mysql_num_rows($query)){
			$query="INSERT INTO votes(option_id, voted_on, ip) VALUES('".$_POST["poll"]."', '".date('Y-m-d H:i:s')."', '".$_SERVER['REMOTE_ADDR']."')";
			if(mysql_query($query))
			{
				//Vote added to database
				setcookie("voted".$_POST['pollid'], 'yes', time()+86400*300);				
			}
			else
				echo "There was some error processing the query: ".mysql_error();
		}
	}
	showresults(intval($_POST['pollid']));
}
function showresults($poll_id){
	global $conn;
	$query=mysql_query("SELECT COUNT(*) as totalvotes FROM votes WHERE option_id IN(SELECT id FROM options WHERE ques_id='$poll_id')");
	while($row=mysql_fetch_assoc($query))
		$total=$row['totalvotes'];
	$query=mysql_query("SELECT options.id, options.value, COUNT(*) as votes FROM votes, options WHERE votes.option_id=options.id AND votes.option_id IN(SELECT id FROM options WHERE ques_id='$poll_id') GROUP BY votes.option_id");
	while($row=mysql_fetch_assoc($query)){
		$percent=round(($row['votes']*100)/$total);
		echo '<div class="option" ><p>'.$row['value'].' (<em>'.$percent.'%, '.$row['votes'].' votes</em>)</p>';
		echo '<div class="bar ';
		if($_POST['poll']==$row['id']) echo ' yourvote';
		echo '" style="width: '.$percent.'%; " ></div></div>';
	}
	echo '<p>Total Votes: '.$total.'</p>';
}